<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla view library
jimport('joomla.application.component.view');
 
/**
 * HTML View class for the HelloWorld Component
 */
class TpcxsocialViewRegistration extends JView
{
    // Overwriting JView display method
    function display($tpl = null) 
    {
        // Assign data to the view
        $app                  = JFactory::getApplication();
        $this->params         = $app->getParams('com_tpcxsocial');
        $this->groups_id      = $this->get('Groups');
        
        $this->data     = $this->get('Data');
        $this->form     = $this->get('Form');
        
        // Display the view
        parent::display($tpl);
    }
}