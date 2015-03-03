<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla view library
jimport('joomla.application.component.view');
 
/**
 * HTML View class for the HelloWorld Component
 */
class TpcxsocialViewProfile extends JView
{
    // Overwriting JView display method
    function display($tpl = null) 
    {
        // Assign data to the view
        $app                  = JFactory::getApplication();
        
        $this->data           = $this->get('Data');
        $this->form           = $this->get('Form');
        $this->user           = JFactory::getUser();
        
        // Get the dispatcher and load the users plugins.
        $dispatcher = JDispatcher::getInstance();
        JPluginHelper::importPlugin('user');

        // Trigger the data preparation event.
        $results = $dispatcher->trigger('onContentPrepareData', array('com_users.profile', $this->user));
        
        // set variables
        $this->avatar         = TpcxsocialHelperUser::getAvatar($user->id, 97, 97);
        $this->group          = TpcxsocialHelperUser::getGroup($this->user);
        $this->groupName      = TpcxsocialHelperUser::getGroupName($this->group);
        
        $model = JModel::getInstance('Registration', 'TpcxsocialModel');
        $this->groups_id      = $model->getGroups();
        
        $this->groupUser = $this->data->groups;
        
        // Display the view
        parent::display($tpl);
    }
}