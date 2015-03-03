<?php
/**
 * @package     TpCx
 * @subpackage  mod_tpcx_slideshow
 * @author      Fabien Vautour
 */

// no direct access
defined('_JEXEC') or die;

require_once dirname(__FILE__) . '/helper.php';

$option = JRequest::getVar('option');
$view = JRequest::getVar('view');

$listThematique = modTpcxAnnuaireHelper::getList($params, 'thematique');
$listContinent = modTpcxAnnuaireHelper::getList($params, 'continent');
$listPays = modTpcxAnnuaireHelper::getList($params, 'pays');

$urlAnnuaire = modTpcxAnnuaireHelper::getUrlAnnuaire($params);

$varThematique  = JRequest::getVar('t', null);
$varContinent   = JRequest::getVar('c', null);
$varPays        = JRequest::getVar('p', null);

// if article page, not show the form
if($option == 'com_content' && $view == 'article' && $params->get('layout') == '_:recherche')
    return;

require JModuleHelper::getLayoutPath('mod_tpcx_annuaire', $params->get('layout', 'recherche'));