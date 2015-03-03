<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla view library
jimport('joomla.application.component.view');
 
/**
 * HTML View class for the HelloWorld Component
 */
class TpcxtagsViewArticles extends JView
{
    protected $pagination;
    
    // Overwriting JView display method
    function display($tpl = null) 
    {
        // Assign data to the view
        $state            = $this->get('State');
        $params           = $state->params;
        $items            = $this->get('Items');
        $pagination       = $this->get('Pagination');
        $countItems       = $this->get('Total');
        $termSearch       = $this->get('TermSearch');
        $secondTermSearch       = $this->get('SecondTermSearch');
        
        $this->filters        = $this->get('Filters');

        // prepare filter
        // get tag from articles
        $articlesId = array();
        foreach($items as $key => $value) {
            $articlesId[] = $value->id;
        }
        
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        
        $query->select('profile_value');
        $query->from('#__user_profiles');
        $query->where('profile_key = "tpcxtagarticle.listthematiques"');
        $query->where('user_id IN (' . implode(", ", $articlesId) . ')');
        
        $db->setQuery($query);

        $result = $db->loadObjectList();
        
        $thematiqueInArticles = array();
        foreach ($result as $key => $value) {
            $string = str_replace('["', '', $value->profile_value);
            $string = str_replace('"]', '', $string);
            $string = str_replace('"', '', $string);
            $arr = explode(",", $string);
            $thematiqueInArticles = array_merge($thematiqueInArticles, $arr);
        }
        
        $thematiqueInArticles = array_unique($thematiqueInArticles);
        
        foreach($this->filters as $key => $filter) {
            if(!in_array($filter['value'], $thematiqueInArticles)) {
                unset($this->filters[$key]);
            }
        }
        
        foreach($this->filters as $key => $filter) {
            if($filter['selected']) {
                $this->filter_selected = $this->filters[$key];
                unset($this->filters[$key]);
                break;
            } else {
                $this->filter_selected = array(
                    'value' => '',
                    'name'  => 'thématiques'
                );
            }
        }
        
        // Check for errors.
        if (count($errors = $this->get('Errors'))) 
        {
            JLog::add(implode('<br />', $errors), JLog::WARNING, 'jerror');
            return false;
        }
        
        // Compute the article slugs and prepare introtext (runs content plugins).
        for ($i = 0, $n = count($items); $i < $n; $i++)
        {
            $item = &$items[$i];
            $item->slug = $item->alias ? ($item->id . ':' . $item->alias) : $item->id;

            // No link for ROOT category
            if ($item->parent_alias == 'root') {
                $item->parent_slug = null;
            }

            $item->event = new stdClass();

            $dispatcher = JDispatcher::getInstance();

            $item->introtext = JHtml::_('content.prepare', $item->introtext, '', 'com_content.category');

            $results = $dispatcher->trigger('onContentAfterTitle', array('com_content.article', &$item, &$item->params, 0));
            $item->event->afterDisplayTitle = trim(implode("\n", $results));

            $results = $dispatcher->trigger('onContentBeforeDisplay', array('com_content.article', &$item, &$item->params, 0));
            $item->event->beforeDisplayContent = trim(implode("\n", $results));

            $results = $dispatcher->trigger('onContentAfterDisplay', array('com_content.article', &$item, &$item->params, 0));
            $item->event->afterDisplayContent = trim(implode("\n", $results));
        }
        
        $this->assignRef('state', $state);
        $this->assignRef('items', $items);
        $this->assignRef('countItems', $countItems);
        $this->assignRef('params', $params);
        $this->assignRef('pagination', $pagination);
        $this->assignRef('termSearch', $termSearch);
        $this->assignRef('secondTermSearch', $secondTermSearch);
        
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
        
        $title = $this->params->get('page_title', '');

        if (empty($title)) {
            $title = $app->getCfg('sitename');
        }
        elseif ($app->getCfg('sitename_pagetitles', 0) == 1) {
            $title = JText::sprintf('JPAGETITLE', $app->getCfg('sitename'), $title);
        }
        elseif ($app->getCfg('sitename_pagetitles', 0) == 2) {
            $title = JText::sprintf('JPAGETITLE', $title, $app->getCfg('sitename'));
        }
        
        if ($this->item->metadesc)
        {
            $this->document->setDescription($this->item->metadesc);
        }
        elseif (!$this->item->metadesc && $this->params->get('menu-meta_description'))
        {
            $this->document->setDescription($this->params->get('menu-meta_description'));
        }

        if ($this->item->metakey)
        {
            $this->document->setMetadata('keywords', $this->item->metakey);
        }
        elseif (!$this->item->metakey && $this->params->get('menu-meta_keywords'))
        {
            $this->document->setMetadata('keywords', $this->params->get('menu-meta_keywords'));
        }
        
        if ($this->params->get('robots'))
        {
            $this->document->setMetadata('robots', $this->params->get('robots'));
        }

        $this->document->setTitle($title);
    }
}