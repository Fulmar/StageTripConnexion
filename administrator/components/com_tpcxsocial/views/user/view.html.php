<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla view library
jimport('joomla.application.component.view');

/**
 * Tpcxsocial View
 */
class TpcxsocialViewUser extends JView
{
    /**
     * display method of category view
     * @return void
     */
    public function display($tpl = null)
    {
        // get the Data
        $form = $this->get('Form');
        $item = $this->get('Item');
        $this->groups       = $this->get('AssignedGroups');

        // Check for errors.
        if (count($errors = $this->get('Errors'))) {
            JError::raiseError(500, implode('<br />', $errors));
            return false;
        }
        // Assign the Data
        $this->form = $form;
        $this->item = $item;

        // Set the toolbar
        $this->addToolBar();
        
        $this->form->setValue('password',       null);
        $this->form->setValue('password2',  null);

        // Display the template
        parent::display($tpl);
        
        // Set the document
        $this->setDocument();
    }

    /**
     * Setting the toolbar
     */
    protected function addToolBar()
    {
        $input = JFactory::getApplication()->input;
        $input->set('hidemainmenu', true);
        $isNew = ($this->item->user_id == 0);
        JToolBarHelper::title($isNew ? JText::_('COM_TPCXSOCIAL_MANAGER_USERS_NEW') : JText::_('COM_TPCXSOCIAL_MANAGER_USERS_EDIT'));
        JToolBarHelper::save('user.save');
        JToolBarHelper::cancel('user.cancel', $isNew ? 'JTOOLBAR_CANCEL' : 'JTOOLBAR_CLOSE');
    }
    
    /**
     * Method to set up the document properties
     *
     * @return void
     */
    protected function setDocument() 
    {
            $isNew = ($this->item->user_id < 1);
            $document = JFactory::getDocument();
            $document->setTitle($isNew ? JText::_('COM_TPCXSOCIAL_USER_CREATING')
                                       : JText::_('COM_TPCXSOCIAL_USER_EDITING'));
            $document->addScript(JURI::root() . "/administrator/components/com_tpcxsocial"
                                              . "/views/user/submitbutton.js");
            JText::script('COM_TPCXSOCIAL_USER_ERROR_UNACCEPTABLE');
    }

}
