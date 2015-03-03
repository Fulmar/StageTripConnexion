<?php
/**
 * Tpcxsocial Module Entry Point
 * 
 * @package    Joomla.Tutorials
 * @subpackage Modules
 * @link http://dev.joomla.org/component/option,com_jd-wiki/Itemid,31/id,tutorials:modules/
 * @license        GNU/GPL, see LICENSE.php
 * mod_helloworld is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 */
 
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
 
// Include the syndicate functions only once
require_once( dirname(__FILE__) . DS . 'helper.php' );
require_once JPATH_SITE . '/components/com_tpcxsocial/helpers/route.php';
require_once JPATH_SITE . '/components/com_tpcxsocial/helpers/tpcxsocial.php';
require_once JPATH_SITE . '/components/com_tpcxsocial/helpers/user.php';
require_once JPATH_SITE.'/components/com_tpcxsocial/fb-sdk/facebook.php';

// Get the document object.
$document   = JFactory::getDocument();
$document->addStyleSheet(JURI::base(true) . '/components/com_tpcxsocial/template/css/social.css');
$document->addScript(JURI::base(true) . '/components/com_tpcxsocial/template/js/social.js');

$option     = JRequest::getCmd('option');
$view       = JRequest::getCmd('view');

if($option == 'com_tpcxsocial') {
    switch($view) {
        case 'posts': $view = 'topic'; break;
        default: $view = 'band'; break;
    }
}

if($params->get('layout', 'band')) {
    $view = $params->get('layout', 'band');
}

$params = JComponentHelper::getParams('com_tpcxsocial');
$app_id = $params->get('fb_app_id');

$user = TpcxsocialHelperUser::getUser();

$isLogged = TpcxsocialHelperUser::isLogged();

require JModuleHelper::getLayoutPath( 'mod_tpcxsocial', $view );
?>