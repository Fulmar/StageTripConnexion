<?php

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
 
// Include the syndicate functions only once
require_once( dirname(__FILE__).DS.'helper.php' );

$link_article = $params->get('link_article');
$link = $params->get('link_article');
if($params->get('externe_link')) {
    $link = $params->get('externe_link');    
} else {
    $link = modTpcxPushHelper::getLink($link);
}
$target_link = $params->get('target_link');
$type_link = $params->get('type_link');
$show_link = $params->get('show_link');
$image = $params->get('image');

if( (!empty($link) && !empty($image)) ) {
    require JModuleHelper::getLayoutPath( 'mod_tpcx_push' );
}
?>