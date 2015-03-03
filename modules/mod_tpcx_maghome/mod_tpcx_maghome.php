<?php
/**
 * @package     TpCx
 * @subpackage  mod_tpcx_slideshow
 * @author      Fabien Vautour
 */

// no direct access
defined('_JEXEC') or die;

// Include the helper functions only once
require_once dirname(__FILE__) . '/helper.php';

$article = modTpcxMaghomeHelper::getArticle($params);

require JModuleHelper::getLayoutPath('mod_tpcx_maghome', $params->get('layout', 'default'));