<?php
/**
 * @package     TpCx
 * @subpackage  mod_tpcx_concept
 * @author      Fulmar Florent
 */

// no direct access
defined('_JEXEC') or die;

require_once dirname(__FILE__) . '/helper.php';

$option = JRequest::getVar('option');
$view = JRequest::getVar('view');

$listThematique = modTpcxConceptHelper::getList($params, 'thematique');
$listContinent = modTpcxConceptHelper::getList($params, 'continent');
$listPays = modTpcxConceptHelper::getList($params, 'pays');

$urlConcept = modTpcxConceptHelper::getUrlConcept($params);

$varThematique  = JRequest::getVar('t', null);
$varContinent   = JRequest::getVar('c', null);
$varPays        = JRequest::getVar('p', null);

// if article page, not show the form
if($option == 'com_content' && $view == 'article' && $params->get('layout') == '_:recherche')
    return;

require JModuleHelper::getLayoutPath('mod_tpcx_concept', $params->get('layout', 'recherche'));