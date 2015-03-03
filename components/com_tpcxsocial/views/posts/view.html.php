<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla view library
jimport('joomla.application.component.view');
 
/**
 * HTML View class for the HelloWorld Component
 */
class TpcxsocialViewPosts extends JView
{
    // Overwriting JView display method
    function display($tpl = null) 
    {
        // Assign data to the view
        $app                  = JFactory::getApplication();
        
        $this->user           = JFactory::getUser();
        $this->items          = $this->get('Items');
        $this->topic          = $this->get('Topic');
        $this->filters        = TpcxsocialHelperTpcxsocial::getFiltersPosts();
        $this->userIsLogged   = TpcxsocialHelperUser::isLogged();
                
        // prepare filter
        foreach($this->filters as $key => $filter) {
            if($filter['selected']) {
                $this->filter_selected = $this->filters[$key];
                unset($this->filters[$key]);
                break;
            }
        }
        
        $this->category_image = JURI::base() . 'components/com_tpcxsocial/template/images/header.jpg';
        if(!is_null($this->topic->category_id)) {
            $this->category_image = $this->get('CategoryImage');    
        }
        
        $document   = JFactory::getDocument();
        $document->addScript(JURI::base(true) . '/components/com_tpcxsocial/template/js/ckeditor/ckeditor.js');
        $document->addScript(JURI::base(true) . '/components/com_tpcxsocial/template/js/jRating.jquery.min.js');
        
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
        $Itemid = TpcxsocialHelperRoute::getItemIdSocialTopic();
        
        JSite::getMenu()->setActive($Itemid);
        
    }
}