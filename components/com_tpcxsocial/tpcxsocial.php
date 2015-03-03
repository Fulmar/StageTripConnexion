<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import joomla controller library
jimport('joomla.application.component.controller');

require_once JPATH_COMPONENT.'/helpers/tpcxsocial.php';
require_once JPATH_COMPONENT.'/helpers/route.php';
require_once JPATH_COMPONENT.'/helpers/user.php';

// Get an instance of the controller prefixed by HelloWorld
$controller = JController::getInstance('Tpcxsocial');
 
// Perform the Request task
$input = JFactory::getApplication()->input;
$controller->execute($input->getCmd('task'));
 
// Redirect if set by the controller
$controller->redirect();