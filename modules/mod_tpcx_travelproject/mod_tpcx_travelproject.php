<?php
/**
 * @package     TpCx
 * @subpackage  mod_tpcx_slideshow
 * @author      Fabien Vautour
 */

// no direct access
defined('_JEXEC') or die;

require_once dirname(__FILE__) . '/helper.php';

$listPays = modTpcxTravelprojectHelper::getListTags($params, 'pays');
$urlRedirection = modTpcxTravelprojectHelper::getUrlRedirection($params);
$urlAction = modTpcxTravelprojectHelper::getUrlAction($params);

require JModuleHelper::getLayoutPath('mod_tpcx_travelproject', $params->get('layout', 'default'));