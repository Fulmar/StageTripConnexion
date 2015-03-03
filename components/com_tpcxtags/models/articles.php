<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla modlelist library
jimport('joomla.application.component.modellist');

JModelLegacy::addIncludePath(JPATH_SITE . '/components/com_content/models', 'ContentModel');

/**
 * HelloWorld Model
 */
class TpcxtagsModelArticles extends JModelList
{
    
    /**
     * Category items data
     *
     * @var array
     */

    protected $_articles = null;
    
    protected $_items = null;
    
    /**
     * Method to auto-populate the model state.
     *
     * Note. Calling getState in this method will result in recursion.
     *
     * return   void
     * @since   1.6
     */
    protected function populateState($ordering = null, $direction = null)
    {
        // Initiliase variables.
        $app    = JFactory::getApplication('site');
        $pk     = JRequest::getInt('id');

        // Load the parameters. Merge Global and Menu Item params into new object
        $params = $app->getParams();
        $menuParams = new JRegistry;

        if ($menu = $app->getMenu()->getActive()) {
            $menuParams->loadString($menu->params);
        }
        
        $mergedParams = clone $menuParams;
        $mergedParams->merge($params);

        $this->setState('params', $mergedParams);
        $user       = JFactory::getUser();
                // Create a new query object.
        $db     = $this->getDbo();
        $query  = $db->getQuery(true);
        
        $this->setState('filter.published', 1);
        
        if($params->get('category'))
            $this->setState('filter.category_id', $params->get('category'));
        
        // filter tags on menu
        // thematique
        if($params->get('is_thematique') == 1) {
            $this->setState('filter.thematique', $params->get('listthematiques'));
        }
        // continent
        if($params->get('is_continent') == 1) {
            $this->setState('filter.continent', $params->get('listcontinents'));
        }
        // pays
        if($params->get('is_pays') == 1) {
            $this->setState('filter.pays', $params->get('listpays'));
        }
        
        // filter tags on request
        // thematique
        if(JRequest::getVar('t')) {
            $this->setState('filter.thematique', JRequest::getVar('t'));
        }
        // continent
        if(JRequest::getVar('c')) {
            $this->setState('filter.continent', JRequest::getVar('c'));
        }
        // pays
        if(JRequest::getVar('p')) {
            $this->setState('filter.pays', JRequest::getVar('p'));
        }
        // Partenaire
        if(JRequest::getVar('part')) {
            $this->setState('filter.partenaire', JRequest::getVar('part'));
        }
        
        // filter article
        if($params->get('excluded_article')) {
            $this->setState('filter.articles_id', $params->get('excluded_article'));
        }
        
        // filter.order
        $itemid = JRequest::getInt('id', 0) . ':' . JRequest::getInt('Itemid', 0);
        $orderCol = $app->getUserStateFromRequest('com_content.category.list.' . $itemid . '.filter_order', 'filter_order', '', 'string');
        if (!in_array($orderCol, $this->filter_fields)) {
            $orderCol = 'a.ordering';
        }
        $this->setState('list.ordering', $orderCol);

        $listOrder = $app->getUserStateFromRequest('com_content.category.list.' . $itemid . '.filter_order_Dir',
            'filter_order_Dir', '', 'cmd');
        if (!in_array(strtoupper($listOrder), array('ASC', 'DESC', ''))) {
            $listOrder = 'ASC';
        }
        $this->setState('list.direction', $listOrder);

        $this->setState('list.start', JRequest::getUInt('limitstart', 0));

        $this->setState('list.limit', $params->get('limit'));



        $this->setState('layout', JRequest::getCmd('layout'));

    }

    /**
     * Get the master query for retrieving a list of articles subject to the model state.
     *
     * @return  JDatabaseQuery
     * @since   1.6
     */
    function getListQuery()
    {
        // Create a new query object.
        $db = $this->getDbo();
        $query = $db->getQuery(true);

        // Select the required fields from the table.
        $query->select(
            $this->getState(
                'list.select',
                'a.id, a.title, a.alias, a.title_alias, a.introtext, ' .
                'a.checked_out, a.checked_out_time, ' .
                'a.catid, a.created, a.created_by, a.created_by_alias, ' .
                'a.publish_down, a.images, a.urls, a.attribs, a.metadata, a.metakey, a.metadesc, a.access, ' .
                'a.hits, a.xreference, a.featured,'.' '.$query->length('a.fulltext').' AS readmore'
            )
        );

        $query->from('#__content AS a');
        
        $query->where('a.state = ' . $this->getState('filter.published'));
        
        // Join over the categories.
        $query->select('c.title AS category_title, c.path AS category_route, c.access AS category_access, c.alias AS category_alias');
        $query->join('LEFT', '#__categories AS c ON c.id = a.catid');
        
        // Join over the categories to get parent category titles
        $query->select('parent.title as parent_title, parent.id as parent_id, parent.path as parent_route, parent.alias as parent_alias');
        $query->join('LEFT', '#__categories as parent ON parent.id = c.parent_id');
        
        // filter category
        if($this->getState('filter.category_id')) {
            $query->where('a.catid = ' . $this->getState('filter.category_id'));
        }
        
        // filter tags
        if($this->getState('filter.thematique') || $this->getState('filter.continent') || $this->getState('filter.pays')) {
            $query->select(' up.user_id, up.profile_key, up.profile_value');
            $query->join('INNER', '#__user_profiles as up ON a.id = up.user_id');
        }
        
        // filter thematique
        if($this->getState('filter.thematique')) {
            $subQuery = $db->getQuery(true);
            $subQuery->select('user_id');
            $subQuery->from('#__user_profiles');
            $subQuery->where('profile_key = "tpcxtagarticle.listthematiques"');
            $subQuery->where('profile_value LIKE \'%"' . $this->getState('filter.thematique') . '"%\'');
            
            $query->where('a.id IN (' . $subQuery . ')');
            
        }
        
        // filter continent
        if($this->getState('filter.continent')) {
            $subQuery = $db->getQuery(true);
            $subQuery->select('user_id');
            $subQuery->from('#__user_profiles');
            $subQuery->where('profile_key = "tpcxtagarticle.listcontinents"');
            $subQuery->where('profile_value LIKE \'%"' . $this->getState('filter.continent') . '"%\'');
            
            $query->where('a.id IN (' . $subQuery . ')');
            
        }
        
        // filter pays
        if($this->getState('filter.pays')) {
            $subQuery = $db->getQuery(true);
            $subQuery->select('user_id');
            $subQuery->from('#__user_profiles');
            $subQuery->where('profile_key = "tpcxtagarticle.listpays"');
            $subQuery->where('profile_value LIKE \'%"' . $this->getState('filter.pays') . '"%\'');
            
            $query->where('a.id IN (' . $subQuery . ')');
            
        }
        
        // filter partenaire
        if($this->getState('filter.partenaire')) {
            $subQuery = $db->getQuery(true);
            $subQuery->select('user_id');
            $subQuery->from('#__user_profiles');
            $subQuery->where('profile_key = "tpcxtagarticle.listpartenaires"');
            $subQuery->where('profile_value LIKE \'%"' . $this->getState('filter.partenaire') . '"%\'');
            
            $query->where('a.id IN (' . $subQuery . ')');
            
        }
        
        // filter article
        $excluded_articles = $this->getState('filter.articles_id');

        if ($excluded_articles) {
            $excluded_articles = explode(";", $excluded_articles);
            $articleId = implode(',', $excluded_articles);
            $query->where('a.id NOT IN (' . $articleId . ')');
        }
        
        // Add the list ordering clause.
        $query->order($this->getState('list.ordering', 'a.ordering').' '.$this->getState('list.direction', 'ASC'));
        $query->group('a.id, a.title, a.alias, a.title_alias, a.introtext');
        
        //echo nl2br(str_replace('#__','joomla_',$query));
        return $query;
    }
    
    /**
     * Get the articles in the category
     *
     * @return  mixed   An array of articles or false if an error occurs.
     * @since   1.5
     */
    function getItems()
    {
        $items  = parent::getItems();
        
        // Convert the parameter fields into objects.
        foreach ($items as &$item)
        {
            $articleParams = new JRegistry;
            $articleParams->loadString($item->attribs);

            $item->params = clone $this->getState('params');
        }
        
        return $items;
    }
    
    /**
     * Get the articles in the category
     *
     * @return  mixed   An array of articles or false if an error occurs.
     * @since   1.5
     */
    function getItem($id, $return = null)
    {
        // Create a new query object.
        $db = $this->getDbo();
        $query = $db->getQuery(true);
        
        $query->select('id, tag, category');
        $query->from('#__tpcxtags');
        $query->where('id = "' . $id . '"');
        
        $db->setQuery($query);

        $item = $db->loadObject();
        
        if($return != null) {
            if($return == 'tag')
                return $item->tag;
        }
        
        return $item;
    }
    
    /**
     * Get the term of search menu
     *
     * @return  string  The name of the tag
     * @since   1.5
     */
    public function getTermSearch()
    {
        // Create a new query object.
        $db = $this->getDbo();
        $query = $db->getQuery(true);
		
        // thematique
        if(JRequest::getVar('t')) {
            $termId = JRequest::getVar('t');
        }
        // continent
        if(JRequest::getVar('c')) {
            $termId = JRequest::getVar('c');
        }
        // pays
        if(JRequest::getVar('p')) {
            $termId = JRequest::getVar('p');
        }
        // partenaire
        if(JRequest::getVar('part')) {
            $termId = JRequest::getVar('part');

			//SELECT id AS value, title as listpartenaires FROM #__content WHERE catid = '9' ORDER BY title ASC
			
			$query->select('id AS value, title as partenaire');
	        $query->from('#__content');
			$query->where('catid = "9"');
	        $query->where('id = "' . $termId . '"');
			
			$db->setQuery($query);

        	$item = $db->loadObject();
			
			return $item->partenaire;
        }
        
        if(!isset($termId))
            return;
        
        // Create a new query object.
        $db = $this->getDbo();
        $query = $db->getQuery(true);
        
        $query->select('id, tag, category');
        $query->from('#__tpcxtags');
        $query->where('id = "' . $termId . '"');
        
        $db->setQuery($query);

        $item = $db->loadObject();
        
        return $item->tag;
    }
    
    /**
     * Get the term of search menu
     *
     * @return  string  The name of the tag
     * @since   1.5
     */
    public function getSecondTermSearch()
    {
    	// continent - pays
        if(!JRequest::getVar('c') && !JRequest::getVar('p')) {
            return;
        }
			
        // thematique
        if(JRequest::getVar('t')) {
            $termId = JRequest::getVar('t');
        }
        
        if(!isset($termId))
            return;
        
        // Create a new query object.
        $db = $this->getDbo();
        $query = $db->getQuery(true);
        
        $query->select('id, tag, category');
        $query->from('#__tpcxtags');
        $query->where('id = "' . $termId . '"');
        
        $db->setQuery($query);

        $item = $db->loadObject();
        
        return $item->tag;
    }
    
    /**
     * Method to get the filters array
     *
     * @return  array   array of filters
     */
    public function getFilters()
    {
        $db = $this->getDbo();
        
        $filters = array();
        $query = $db->getQuery(true);
        
        $query->select('id, tag, category');
        $query->from('#__tpcxtags');
        $query->where('category = "thematique"');
        $query->order('tag ASC');
        
        $db->setQuery($query);

        $availables_filters = $db->loadObjectList();
        
        $thematique   = JRequest::getCmd('t');
        
        $i = 0;
        foreach($availables_filters as $filter) {
            $filters[$i]['name'] = $filter->tag;
            $filters[$i]['value'] = $filter->id;
            if($thematique == $filter->id) {
                $filters[$i]['selected'] = true;
            }
            
            $i++;
        }
        
        return $filters;
    }
     
}