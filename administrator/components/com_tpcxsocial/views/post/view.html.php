<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla view library
jimport('joomla.application.component.view');

/**
 * Tpcxsocial View
 */
class TpcxsocialViewPost extends JView
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
        $isNew = ($this->item->id == 0);
        JToolBarHelper::title($isNew ? JText::_('COM_TPCXSOCIAL_MANAGER_POSTS_NEW') : JText::_('COM_TPCXSOCIAL_MANAGER_POSTS_EDIT'));
        JToolBarHelper::save('post.save');
        JToolBarHelper::cancel('post.cancel', $isNew ? 'JTOOLBAR_CANCEL' : 'JTOOLBAR_CLOSE');
    }
    
    /**
     * Method to set up the document properties
     *
     * @return void
     */
    protected function setDocument() 
    {
            $isNew = ($this->item->id < 1);
            $document = JFactory::getDocument();
            $document->setTitle($isNew ? JText::_('COM_TPCXSOCIAL_POST_CREATING')
                                       : JText::_('COM_TPCXSOCIAL_POST_EDITING'));
            $document->addScript(JURI::root() . "/administrator/components/com_tpcxsocial"
                                              . "/views/post/submitbutton.js");
            JText::script('COM_TPCXSOCIAL_POST_ERROR_UNACCEPTABLE');
    }

}
