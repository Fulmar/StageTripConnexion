<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla view library
jimport('joomla.application.component.view');

/**
 * Tpcxsocial View
 */
class TpcxsocialViewTagcategories extends JView
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
       
        JToolBarHelper::title(JText::_('COM_TPCXSOCIAL_MANAGER_TAG_CATEGORIES'));
        JToolBarHelper::addNew('tagcategory.add');
        JToolBarHelper::editList('tagcategory.edit');
        JToolBarHelper::deleteList('', 'tagcategories.delete');
        JToolBarHelper::divider();
        JToolBarHelper::checkin('tagcategories.checkin');
        JToolBarHelper::trash('tagcategories.trash');
        JToolBarHelper::divider();
        JToolBarHelper::publishList('tagcategories.publish');
        JToolBarHelper::unpublishList('tagcategories.unpublish');
        JToolBarHelper::divider();
        JToolBarHelper::preferences('com_tpcxsocial');
    }

}
