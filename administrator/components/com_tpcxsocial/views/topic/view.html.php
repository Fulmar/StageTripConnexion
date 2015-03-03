<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla view library
jimport('joomla.application.component.view');

/**
 * Tpcxsocial View
 */
class TpcxsocialViewTopic extends JView
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
        JToolBarHelper::title($isNew ? JText::_('COM_TPCXSOCIAL_MANAGER_TOPICS_NEW') : JText::_('COM_TPCXSOCIAL_MANAGER_TOPICS_EDIT'));
        JToolBarHelper::save('topic.save');
        JToolBarHelper::cancel('topic.cancel', $isNew ? 'JTOOLBAR_CANCEL' : 'JTOOLBAR_CLOSE');
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
            $document->setTitle($isNew ? JText::_('COM_TPCXSOCIAL_TOPIC_CREATING')
                                       : JText::_('COM_TPCXSOCIAL_TOPIC_EDITING'));
            $document->addScript(JURI::root() . "/administrator/components/com_tpcxsocial"
                                              . "/views/topic/submitbutton.js");
            JText::script('COM_TPCXSOCIAL_TOPIC_ERROR_UNACCEPTABLE');
    }

}
