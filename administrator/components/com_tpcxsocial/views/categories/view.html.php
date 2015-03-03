<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla view library
jimport('joomla.application.component.view');

/**
 * Tpcxsocial View
 */
class TpcxsocialViewCategories extends JView
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
        
        // Preprocess the list of items to find ordering divisions.
        foreach ($this->items as &$item) {
            $this->ordering[$item->parent_id][] = $item->id;
        }
        
        // Levels filter.
        $options    = array();
        $options[]  = JHtml::_('select.option', '1', JText::_('J1'));
        $options[]  = JHtml::_('select.option', '2', JText::_('J2'));
        $options[]  = JHtml::_('select.option', '3', JText::_('J3'));
        $options[]  = JHtml::_('select.option', '4', JText::_('J4'));
        $options[]  = JHtml::_('select.option', '5', JText::_('J5'));
        $options[]  = JHtml::_('select.option', '6', JText::_('J6'));
        $options[]  = JHtml::_('select.option', '7', JText::_('J7'));
        $options[]  = JHtml::_('select.option', '8', JText::_('J8'));
        $options[]  = JHtml::_('select.option', '9', JText::_('J9'));
        $options[]  = JHtml::_('select.option', '10', JText::_('J10'));

        $this->f_levels = $options;
        
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
        JToolBarHelper::title(JText::_('COM_TPCXSOCIAL_MANAGER_CATEGORIES'));
        JToolBarHelper::addNew('category.add');
        JToolBarHelper::editList('category.edit');
        JToolBarHelper::deleteList('', 'categories.delete');
        JToolBarHelper::divider();
        JToolBarHelper::checkin('categories.checkin');
        JToolBarHelper::trash('categories.trash');
        JToolBarHelper::divider();
        JToolBarHelper::publishList('categories.publish');
        JToolBarHelper::unpublishList('categories.unpublish');
        JToolBarHelper::divider();
        JToolBarHelper::preferences('com_tpcxsocial');
    }

}
