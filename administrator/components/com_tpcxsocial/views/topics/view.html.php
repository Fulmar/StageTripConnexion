<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla view library
jimport('joomla.application.component.view');

/**
 * Tpcxsocial View
 */
class TpcxsocialViewTopics extends JView
{

    /**
     * Tpcxsocial view display method
     * @return void
     */
    function display($tpl = null)
    {
        // Get data from the model
        $items = $this->get('Items');
        $pagination = $this->get('Pagination');
        $this->state = $this->get('State');

        // Check for errors.
        if (count($errors = $this->get('Errors'))) {
            JError::raiseError(500, implode('<br />', $errors));
            return false;
        }
        // Assign data to the view
        $this->items = $items;
        $this->pagination = $pagination;
        $this->sortDirection = $this->state->get('list.direction');
        $this->sortColumn = $this->state->get('list.ordering');

        // Set the toolbar
        $this->addToolBar();
        
        // Display the template
        parent::display($tpl);
    }
 
    /**
     * Setting the toolbar
     */
    protected function addToolBar() 
    {
       
        JToolBarHelper::title(JText::_('COM_TPCXSOCIAL_MANAGER_TOPICS'));
        JToolBarHelper::addNew('topic.add');
        JToolBarHelper::editList('topic.edit');
        JToolBarHelper::deleteList('', 'topics.delete');
        JToolBarHelper::divider();
        JToolBarHelper::checkin('topics.checkin');
        JToolBarHelper::trash('topics.trash');
        JToolBarHelper::divider();
        JToolBarHelper::publishList('topics.publish');
        JToolBarHelper::unpublishList('topics.unpublish');
        JToolBarHelper::divider();
        JToolBarHelper::preferences('com_tpcxsocial');
    }

}
