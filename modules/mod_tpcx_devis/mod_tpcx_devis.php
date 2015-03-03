<?php
/**
 * @package     TpCx
 * @subpackage  mod_tpcx_devis
 * @author      Fulmar Florent
 */

// no direct access
defined('_JEXEC') or die;

require_once dirname(__FILE__) . '/helper.php';

$option = JRequest::getVar('option');
$view = JRequest::getVar('view');

$listThematique = modTpcxDevisHelper::getList($params, 'thematique');
$listContinent = modTpcxDevisHelper::getList($params, 'continent');
$listPays = modTpcxDevisHelper::getList($params, 'pays');

$urlConcept = modTpcxDevisHelper::getUrlDevis($params);

$varThematique  = JRequest::getVar('t', null);
$varContinent   = JRequest::getVar('c', null);
$varPays        = JRequest::getVar('p', null);

// if article page, not show the form
if($option == 'com_content' && $view == 'article' && $params->get('layout') == '_:recherche')
    return;

require JModuleHelper::getLayoutPath('mod_tpcx_devis', $params->get('layout', 'recherche'));