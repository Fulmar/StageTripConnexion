<?php
/**
* @package		Mightysites
* @copyright	Copyright (C) 2009-2013 AlterBrains.com. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
*/
defined('_JEXEC') or die('Restricted access');

// todo - remove once 2.5 is dead
jimport('joomla.plugin.plugin');

// Base class
class plgSystemMightysitesBase extends JPlugin
{
	/*
	public function onContentAfterSave($context, $table, $isNew)
	{
		//JFactory::getApplication()->enqueueMessage('onContentAfterSave :: ' . $context);
		$this->synchronizeContent(__FUNCTION__, $context, $table, $isNew);
	}

	public function onContentChangeState($context, $pks, $value)
	{
		$this->synchronizeContent(__FUNCTION__, $context, $pks, $value);
	}
		
	public function onContentAfterDelete($context, $table)
	{
		$this->synchronizeContent(__FUNCTION__, $context, $table, $isNew);
	}
	
	// Isn't it beauty?
	protected function synchronizeContent()
	{
		$app = JFactory::getApplication();
		
		if ($app->getCfg('mighty_sync')) {
			$args 		= func_get_args();
			$event 		= array_shift($args);
			$context 	= $args[0];
			
			$this->loadLanguage();
			
			require_once(__DIR__.'/synchronizations/synchronization.php');
			
			$handler = MightySynchronization::getInstance($context);
			
			if ($handler && method_exists($handler, $event)) {
				// Prepare context
				$args[0] = str_replace('.', '_', $args[0]);
				
				// Run
				call_user_func_array(array(&$handler, $event), $args);
			}
		}
	}
	*/
}

$app = JFactory::getApplication();

// Frontend options
if ($app->isSite()) {
	class plgSystemMightysites extends plgSystemMightysitesBase
	{
		// Start single login?
		public function onUserLogin($user, $options = array())
		{
			$app = JFactory::getApplication();
			
			if ($app->getCfg('mighty_slogin') && $app->getCfg('mighty_sdomains')) {
				$_SESSION['mightylogin'] = $user;
			}
		}

		// Start single logout?
		public function onUserLogout($user, $options = array())
		{
			$app = JFactory::getApplication();
			
			if ($app->getCfg('mighty_slogout') && $app->getCfg('mighty_sdomains')) {
				setcookie('mightylogout', 1, time()+3600, '/');
			}
		}

		// Start single login/logout to other sites!
		public function onBeforeCompileHead()
		{
			$document = JFactory::getDocument();
			
			// Login there
			if (isset($_SESSION['mightylogin'])) {
				$user = $_SESSION['mightylogin'];
				unset($_SESSION['mightylogin']);

				jimport('joomla.utilities.simplecrypt');
				jimport('joomla.utilities.utility');
				
				$domains 	= JFactory::getApplication()->getCfg('mighty_sdomains');
				
				foreach($domains as $domain => $secret) {
					$key 	= md5($secret . @$_SERVER['HTTP_USER_AGENT']);
					$crypt 	= new JSimpleCrypt($key);
					$hash 	= base64_encode($crypt->encrypt(serialize($user)));
					// possible 'suhosin.get.max_value_length' issue, let's use array
					$hash = implode('&mighty_login[]=', str_split($hash, 250));
					
					$document->addScript('http://'.$domain.'/index.php?'.md5($_SERVER['REQUEST_TIME']).'=1&amp;mighty_login[]='.$hash, 'text/javascript', true);
				}
			}

			// Logout there
			if (isset($_COOKIE['mightylogout'])) {
				setcookie('mightylogout', '', time()-360, '/');

				$domains = JFactory::getApplication()->getCfg('mighty_sdomains');
				
				foreach($domains as $domain => $secret) {
					$document->addScript('http://'.$domain.'/index.php?mighty_logout=1&amp;'.md5($_SERVER['REQUEST_TIME']).'=1', 'text/javascript', true);
				}
			}
			
			// Custom CSS files
			$config = JFactory::getConfig();
			if ($config->get('mighty_css')) {
				foreach($config->get('mighty_css') as $css_file) {
					$document->addStylesheet($css_file);
				}
			}
		}
		
		// Lost database handler?
		public function onAfterDispatch()
		{
			if (JFactory::getConfig()->get('config.mighty_enable') && get_class(JFactory::$database) != 'JDatabaseMightysites') {
				JDatabaseMightysites::changeHandler();
			}
		}
	}

	$config = JFactory::getConfig();

	// Implicitely setup language, getLanguage() only next!
	if ($config->get('mighty_language')) {
		$config->set('language', $config->get('mighty_language'));
	}

	$lang 	= JFactory::getLanguage();
	
	// Implicitely setup template
	if ($config->get('mighty_template')) {
		$app->input->set('templateStyle', $config->get('mighty_template'));
	}
	
	// Implicitely setup home menu item
	if ($config->get('mighty_home'))
	{
		$menu = $app->getMenu();
		if ($menu->getDefault()) {
			$menu->getDefault()->home = 0;
		}
		if ($menu->getDefault($lang->getTag())) {
			$menu->getDefault($lang->getTag())->home = 0;
		}
		$menu->setDefault($config->get('mighty_home'), $lang->getTag());
		$menu->setDefault($config->get('mighty_home'), '*');
		$menu->getDefault()->home = 1;
	}
	
	// Remove menu items
	$mighty_menuitems = $config->get('mighty_menuitems');
	if ($mighty_menuitems && is_array($mighty_menuitems) && $mighty_menuitems != array(''))
	{
		$mighty_menuitems = array_flip($mighty_menuitems);
		$menu = $app->getMenu();
		
		// I hate Joomla sometimes... smbd is crazy on privates which are useless
		$rProperty = new ReflectionProperty($menu, '_items');
		$rProperty->setAccessible(true);
		$items = $rProperty->getValue($menu);
		
		foreach($items as $key => &$item) {
			if (isset($mighty_menuitems[$item->id]) || isset($mighty_menuitems[$item->id])) {
				$mighty_menuitems[$item->id] = true;
				unset($items[$key]);
			}
		}
		
		$rProperty->setValue($menu, $items);
	}
	
	// Load language overrides, 
	if ($config->get('mighty_langoverride'))
	{
		$domain = $_SERVER['HTTP_HOST'] ? $_SERVER['HTTP_HOST'] : $_SERVER['SERVER_NAME'];
		$domain = (substr($domain, 0, 4) == 'www.') ? substr($domain, 4) : $domain;
		$domain = preg_replace('#([^A-Z0-9])#i', '_', $domain);
		
		$override_file = JPATH_SITE.'/language/overrides/'.$domain.'.'.$lang->getTag().'.override.ini';
		if (file_exists($override_file)) {
			$rProperty = new ReflectionProperty($lang, 'override');
			$rProperty->setAccessible(true);
			$override = $rProperty->getValue($lang);
			
			$rMethod = new ReflectionMethod($lang, 'parse');
			$rMethod->setAccessible(true);
			$contents = $rMethod->invoke($lang, $override_file);
			
			if (is_array($contents)) {
				$override = array_merge($override, $contents);
			}
			
			$lang->set('override', $override);
		}
	}

}

// Backend options
if (JFactory::getApplication()->isAdmin()) {
	class plgSystemMightysites extends plgSystemMightysitesBase
	{
		public function onAfterRoute()
		{
			$app = JFactory::getApplication();
			
			if (isset($_REQUEST['mighty_token']) && strlen($_REQUEST['mighty_token'])) {
				$token 	= $app->input->getString('mighty_token');
				$folder = $app->getCfg('tmp_path');
				
				jimport('joomla.filesystem.folder');
				jimport('joomla.filesystem.file');
				
				$files	= JFolder::files($folder, '\.mighty$');

				if (sizeof($files)) {
					$data = false;
					foreach($files as $file) {
						if ($file == md5($token.$app->getCfg('secret')).'.mighty') {
							jimport('joomla.filesystem.file');
							$data = JFile::read($folder.'/'.$file);
						}
						JFile::delete($folder.'/'.$file);
					}
					
					if ($data) {
						$data = unserialize($data);
						
						if (!JFactory::getUser()->id) {
							$user = new JUser();
							$user->load($data['user_id']);
							
							// try load by username next
							if (!$user->id) {
								// remove "JUser: :_load: Unable to load user with id: 42" message
								$session = JFactory::getSession(); 
								$session->set('application.queue', null); 
								
								// load other admin by username
								$db = JFactory::getDBO();
								$db->setQuery('SELECT id FROM #__users WHERE `username`='.$db->quote($data['username']));
								$user->load($db->loadResult());
							}
							
							if ($user->id) {
								// Mark the user as logged in
								$user->set('guest', 0);
						
								// Register the needed session variables
								$session = JFactory::getSession();
								$session->set('user', $user);
						
								$db = JFactory::getDBO();
						
								// Check to see the the session already exists.
								$app = JFactory::getApplication();
								$app->checkSession();
						
								// Update the user related fields for the Joomla sessions table.
								$db->setQuery(
									'UPDATE `#__session`' .
									' SET `guest` = '.$db->quote($user->get('guest')).',' .
									'	`username` = '.$db->quote($user->get('username')).',' .
									'	`userid` = '.(int) $user->get('id') .
									' WHERE `session_id` = '.$db->quote($session->getId())
								);
								$db->query();
						
								// Hit the user last visit field
								$user->setLastVisit();
							}
						}
						
						if (strpos($data['return'], 'index.php') === 0) {
							$data['return'] = JUri::base() . '/' . $data['return'];
						}
						
						$app->redirect($data['return']);
					}
				}
			}
		}
		
		public function onAfterDispatch()
		{
			$app = JFactory::getApplication();

			// our message from saving modal config
			if ($app->input->get('option') == 'com_mightysites') {
				if ($app->input->get('mighty_saved')) {
					$app->enqueueMessage(JText::sprintf('COM_MIGHTYSITES_CONFIG_UPDATED', $app->input->get('mighty_saved')));
				}
			}
			
			// let's rock
			else if ($app->input->get('option') == 'com_config') {
			 	if ($app->input->get('controller') != 'component' && $app->input->get('view') != 'component' && $app->input->get('tmpl') == 'component') {
					require_once(JPATH_ADMINISTRATOR.'/components/com_mightysites/helpers/helper.php');

					$document = JFactory::getDocument();

					$version = new JVersion;
					if ($version->RELEASE == '2.5') {
						JToolBarHelper::title(JText::_('COM_CONFIG') . ' :: ' . MightysitesHelper::getHost(), 'config.png');
						
						$html = '
			<div id="toolbar-box">
				<div class="m">';
						
						$toolbar = $document->getBuffer('modules', 'toolbar', array('name'=>'toolbar'));
						$toolbar = strtr($toolbar, array(
							'Joomla.submitbutton(\'application.cancel\')' 	=> 'try {window.parent.SqueezeBox.close()} catch(e){self.top.location=\''.base64_decode($app->input->getString('mighty')).'\';}; return false;',
						));
						$html .= $toolbar;
						
						
						$html .= $document->getBuffer('modules', 'title', array('name'=>'title'));
						$html .= '</div>
			</div>';
						$html .= $document->getBuffer('modules', 'submenu', array('name'=>'submenu',  'style'=>'rounded', 'id'=>'submenu-box'));
						$html .= '<div id="element-box">
				<div class="m">';
						
						$contents = $document->getBuffer('component');
						$contents = strtr($contents, array(
							'index.php?option=com_config" ' 	=> 'index.php?option=com_config&amp;tmpl=component&amp;mighty='.$app->input->getString('mighty').'" '
						));
						
						$html .= $contents;
						
						$html .= '<div class="clr"></div>
				</div>
			</div>
		';
					}
					else {
						$html = 
						'<a class="btn btn-subhead" data-toggle="collapse" data-target=".subhead-collapse">'.JText::_('TPL_ISIS_TOOLBAR').'<i class="icon-wrench"></i></a>
						<div class="subhead-collapse">
							<div class="subhead">
								<div class="container-fluid">
									<div id="container-collapse" class="container-collapse"></div>
									<div class="row-fluid">
										<div class="span12">
											'.JToolBar::getInstance('toolbar')->render('toolbar').'
										</div>
									</div>
								</div>
							</div>
						</div>
						
						<div class="container-fluid container-main">
							<section id="content">
								<h1 class="content-title">'.JText::_('COM_CONFIG') . ' : ' . MightysitesHelper::getHost().'</h1>
								<div class="row-fluid">
									<div class="span12">' . 
										$document->getBuffer('component') . 
									'</div>
								</div>
							</section>
						</div>';
						
						$html = strtr($html, array(
							'Joomla.submitbutton(\'application.cancel\')' 	=> 'try {window.parent.SqueezeBox.close()} catch(e){self.top.location=\''.base64_decode($app->input->getString('mighty')).'\';}; return false;',
							JRoute::_('index.php?option=com_config') 		=> JRoute::_('index.php?option=com_config&tmpl=component&mighty='.$app->input->getString('mighty')),
						));

						// Prettify
						$document->addStyleDeclaration('html, body {padding:0; margin:0; height:auto;} #sidebar.span2 {display:none;} div.container-fluid.container-main {padding:0;}');
					}
					
					$document->setBuffer($html, 'component');
				}
			}
		}
	}

	$version = new JVersion;
	if ($version->RELEASE == '2.5') {
		require_once(dirname(__FILE__).'/format_25.php');
	} else {
		require_once(dirname(__FILE__).'/format.php');
	}
	
}