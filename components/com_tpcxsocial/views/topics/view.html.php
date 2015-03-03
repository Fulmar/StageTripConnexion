<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla view library
jimport('joomla.application.component.view');
 
/**
 * HTML View class for the HelloWorld Component
 */
class TpcxsocialViewTopics extends JView
{
    // Overwriting JView display method
    function display($tpl = null) 
    {
        // Assign data to the view
        $app                  = JFactory::getApplication();
        
        $this->user           = JFactory::getUser();
        $this->items          = $this->get('Items');
        $this->category_id    = JRequest::getInt('id');
        $this->categories     = $this->get('Categories');
        $this->filters        = TpcxsocialHelperTpcxsocial::getFilters();
        
        $this->form       = $this->get('Form');
        
        // add ckeditor
        $layout = JRequest::getVar('layout');
        if($layout == 'add') {
            $document   = JFactory::getDocument();
            $document->addScript(JURI::base(true) . '/components/com_tpcxsocial/template/js/ckeditor/ckeditor.js');
        }
        
        // prepare filter
        foreach($this->filters as $key => $filter) {
            if($filter['selected']) {
                $this->filter_selected = $this->filters[$key];
                unset($this->filters[$key]);
                break;
            }
        }
        
        $this->_prepareDocument();
        
        // Display the view
        parent::display($tpl);
    }

    /**
     * Prepares the document
     */
    protected function _prepareDocument()
    {
        $app        = JFactory::getApplication();
        $menus      = $app->getMenu();
        $pathway    = $app->getPathway();
        $title      = null;
        
        // set active menu for the suffixe class
        $Itemid = TpcxsocialHelperRoute::getItemIdSocial();
        
        JSite::getMenu()->setActive($Itemid);
        
    }
}