<?php
/**
* @package		Mightysites
* @copyright	Copyright (C) 2009-2013 AlterBrains.com. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
*/
defined('_JEXEC') or die('Restricted access');

abstract class MightySynchronization
{
	public $params;
	
	protected static $_instances = array();
	
	public function __construct()
	{
		require_once(JPATH_SITE.'/administrator/components/com_mightysites/helpers/helper.php');
		
		$this->params = MightysitesHelper::getCurrentSite()->params;
	}
	
	public static function getInstance($context)
	{
		if (!isset(static::$_instances[$context]))
		{
			static::$_instances[$context] = false;
			
			$classname = str_replace('.', '_', $context) . '_MightySynchronization';
			
			if (!class_exists($classname)) {
				if (file_exists(__DIR__.'/'.$context.'.php')) {
					require_once(__DIR__.'/'.$context.'.php');
				}
			}
			
			if (class_exists($classname)) {
				static::$_instances[$context] = new $classname();
			}
		}
		
		return static::$_instances[$context];
	}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	public function onContentAfterSave($context, $table, $isNew)
	{
		if ($this->allowsSync(__FUNCTION__, $context, $table, $isNew)) {
			$k = 0;
			foreach($this->params->get('sync_sites__'.$context) as $site_id) {
				$newTable = $this->getTableFromSite($table, $site_id, $isNew);
				if ($newTable) {
					$k++;
					if ($this->setupSiteDbo($site_id)) {
						if ($newTable->store()) {
							// update ID!
							if ($isNew) {
								// todo - update ID!!!
							}
							
							$this->message('PLG_SYSTEM_MIGHTYSITES_SYNC_'.$context.($isNew ? '_CREATED' : '_SAVED'), $site_id);
						} else {
							$this->error($newTable->getError(), $site_id);
						}
					}
				}
			}
			if ($k) {
				$this->restoreDbo();
			}
		}
	}

	public function onContentChangeState($context, $pks, $value)
	{
		static $in_progress;
		
		if ($in_progress) {
			return;
		}
		
		$in_progress = true;
		
		$model = null;
		
		switch($context) {
			case 'com_categories_category':
				$model = 'CategoriesModelCategory';
				break;
				
			case 'com_content_article':
				$model = 'ContentModelArticle';
				break;
		}
		
		if ($model && class_exists($model)) {
			$model = new $model;
			
			foreach($this->params->get('sync_sites__'.$context) as $site_id) {
				if ($this->setupSiteDbo($site_id)) {
					if ($model->publish($pks, $value)) {
						$this->message('PLG_SYSTEM_MIGHTYSITES_SYNC_'.$context.'_SAVED', $site_id);
					}
				}
			}
			$this->restoreDbo();
		}
	}
		
	public function onContentAfterDelete($context, $table)
	{
		if ($this->allowsSync(__FUNCTION__, $context, $table, $isNew)) {
			$k = 0;
			foreach($this->params->get('sync_sites__'.$context) as $site_id) {
				$newTable = $this->getTableFromSite($table, $site_id, $isNew);
				if ($newTable) {
					$k++;
					if ($this->setupSiteDbo($site_id)) {
						$pk = $table->get('_tbl_key');
						if ($newTable->delete($pk)) {
							$this->message('PLG_SYSTEM_MIGHTYSITES_SYNC_'.$context.'_DELETED', $site_id);
						} else {
							$this->error($newTable->getError(), $site_id);
						}
					}
				}
			}
			if ($k) {
				$this->restoreDbo();
			}
		}
	}
	
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		
	protected function allowsSync($event, $context, $table, $isNew = false)
	{
		if (!$this->params->get('sync__'.$context) || !$this->params->get('sync_sites__'.$context)) {
			return false;
		}
		
		// Check semafors
		switch($event) {
			case 'onContentAfterSave':
				if ($isNew && !$this->params->get('sync_create__'.$context)) {
					return false;
				}
				if (!$isNew && !$this->params->get('sync_update__'.$context)) {
					return false;
				}
				break;

			case 'onContentChangeState':
				if (!$this->params->get('sync_update__'.$context)) {
					return false;
				}
				break;

			case 'onContentAfterDelete':
				if (!$this->params->get('sync_delete__'.$context)) {
					return false;
				}
				break;
				
			default:
				return false;
				break;
		}

		// Check category
		if (isset($table->catid) && $table->catid) {
			switch($event) {
				case 'onContentAfterSave':
					if ($isNew && $this->params->get('sync_cats_create__'.$context) && !in_array($table->catid, $this->params->get('sync_cats_create__'.$context))) {
						return false;
					}
					if (!$isNew && $this->params->get('sync_cats_update__'.$context) && !in_array($table->catid, $this->params->get('sync_cats_update__'.$context))) {
						return false;
					}
					break;
	
				case 'onContentChangeState':
					if ($this->params->get('sync_cats_update__'.$context) && !in_array($table->catid, $this->params->get('sync_cats_update__'.$context))) {
						return false;
					}
					break;
	
				case 'onContentAfterDelete':
					if ($this->params->get('sync_cats_delete__'.$context) && !in_array($table->catid, $this->params->get('sync_cats_delete__'.$context))) {
						return false;
					}
					break;
					
				default:
					return false;
					break;
			}
		}
		
		return true;
	}
	
	protected function getTableFromSite(&$sampleTable, $site_id, $isNew = false)
	{
		$site = MightysitesHelper::getSite($site_id, true);
		
		if ($site) {
			$tableClass = get_class($sampleTable);
			
			$db = MightysitesHelper::getDbo($site, true);
			
			if ($db) {
				$table = new $tableClass($db);
				$table->bind($sampleTable->getProperties());
				
				// Unset ID for new
				if ($isNew) {
					$k = $table->get('_tbl_key');
					unset($table->$k);
				}
				
				return $table;
			}
		}
		
		return false;
	}
	
	protected function setupSiteDbo($site_id)
	{
		$site = MightysitesHelper::getSite($site_id, true);
		
		if ($site) {
			// Force database select, single user can use different databases
			JFactory::$database = MightysitesHelper::getDbo($site, true);
			return true;
		}
		
		return false;
	}
	
	protected function restoreDbo()
	{
		JFactory::$database = null;
		
		JFactory::getDbo();
	}
	
	protected function message($text, $site_id = null, $type = 'message')
	{
		if (JString::strpos(JText::_($text), '%s') !== false) {
			$site = MightysitesHelper::getSite($site_id);
			$text = JText::sprintf($text, $site->domain);
		} else {
			$text = JText::_($text);
		}
		
		JFactory::getApplication()->enqueueMessage($text, $type);
	}
	
	protected function error($text, $site_id = null)
	{
		$this->message($type, $site_id, 'error');
	}

}
