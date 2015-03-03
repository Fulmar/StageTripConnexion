<?php
/**
 * @package     TpCx
 * @subpackage  mod_tpcx_slideshow
 * @author      Fabien Vautour
 */

// no direct access
defined('_JEXEC') or die;

require_once dirname(__FILE__).'/helper.php';

$listPays = modTpcxSlideshowHelper::getList($params, 'pays');

require JModuleHelper::getLayoutPath('mod_tpcx_slideshow', $params->get('layout', 'default'));