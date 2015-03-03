<?php
/**
 * @package		Joomla.Site
 * @subpackage	mod_banners
 * @copyright	Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

// Include the syndicate functions only once
require_once dirname(__FILE__).'/helper.php';

$headerText	= trim($params->get('header_text'));
$footerText	= trim($params->get('footer_text'));

require_once JPATH_ADMINISTRATOR . '/components/com_banners/helpers/banners.php';
BannersHelper::updateReset();
//$list = &modBannersHelper::getList($params);

$option = JRequest::getVar('option');
$view = JRequest::getVar('view');
$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));
$listThematique = modBannersHelper::getList($params, 107);
$listContinent = modBannersHelper::getList($params, 173);
$listPays = modBannersHelper::getList($params, 180);
$urlBanners = modBannersHelper::getUrlBanners($params);


$varThematique  = JRequest::getVar('t', null);
$varContinent   = JRequest::getVar('c', null);
$varPays        = JRequest::getVar('p', null);

// if article page, not show the form
if($option == 'com_content' && $view == 'article' && $params->get('layout') == '_:recherche')
    return;
// $list	= modMenuHelper::getList($params);
// $app	= JFactory::getApplication();
// $menu	= $app->getMenu();
// $active	= $menu->getActive();
// $active_id = isset($active) ? $active->id : $menu->getDefault()->id;
// $path	= isset($active) ? $active->tree : array();
// $showAll	= $params->get('showAllChildren');
// $class_sfx	= htmlspecialchars($params->get('class_sfx'));

// if(count($list)) {
	// require JModuleHelper::getLayoutPath('mod_menu', $params->get('layout', 'default'));
// }
require JModuleHelper::getLayoutPath('mod_banners', $params->get('layout', 'default'));
