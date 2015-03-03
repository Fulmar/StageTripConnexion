<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla controllerform library
jimport('joomla.application.component.controllerform');

/**
 * Tpcxsocial Controller
 */
class TpcxsocialControllerPost extends JControllerForm
{
    
    /**
     * Method to edit an existing record.
     *
     * @param   string  $key     The name of the primary key of the URL variable.
     * @param   string  $urlVar  The name of the URL variable if different from the primary key
     * (sometimes required to avoid router collisions).
     *
     * @return  boolean  True if access level check and checkout passes, false otherwise.
     *
     * @since   11.1
     */
    public function edit($key = null, $urlVar = null)
    {
        parent::edit($key, $urlVar);
        
        $app = JFactory::getApplication();
        $topic_id   = JRequest::getVar('topic_id');
        $parent_id   = JRequest::getVar('parent_id');
        $context = "$this->option.edit.$this->context";
        
        if(!is_null($topic_id) || !is_null($parent_id)) {
            $app->setUserState($context . '.data.topic_id', $topic_id);
            $app->setUserState($context . '.data.parent_id', $parent_id);
        }
        
        return true;
    }
}
