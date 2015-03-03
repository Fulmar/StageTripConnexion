<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla controller library
jimport('joomla.application.component.controller');

/**
 * General Controller of Tpcxsocial component
 */
class TpcxsocialController extends JController
{
    
    /**
     * display task
     *
     * @return void
     */
    function display($cachable = false, $urlparams = false)
    {
        require_once JPATH_COMPONENT . '/helpers/tpcxsocial.php';
        
        // Set the submenu
        TpcxsocialHelper::addSubmenu(JRequest::getCmd('view', 'users'));
        
        // set default view if not set
        $input = JFactory::getApplication()->input;
        $input->set('view', $input->getCmd('view', 'users'));
        
        // call parent behavior
        parent::display($cachable);
    }

}
