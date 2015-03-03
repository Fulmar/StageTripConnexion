<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import the Joomla modellist library
jimport('joomla.application.component.modellist');

/**
 * TopicsList Model
 */
class TpcxsocialModelTopics extends JModelList
{
    
    /**
     * Constructor.
     *
     * @param   array   An optional associative array of configuration settings.
     * @see     JController
     * @since   1.6
     */
    public function __construct($config = array())
    {
        if (empty($config['filter_fields'])) {
            $config['filter_fields'] = array(
                'id', 't.id',
                'subject', 't.subject',
                'published', 't.published',
                'ordering', 't.ordering',
                'access', 't.access',
            );
        }

        parent::__construct($config);
    }

    /**
     * Method to build an SQL query to load the list data.
     *
     * @return      string  An SQL query
     */
    protected function getListQuery()
    {
        // Create a new query object.
        $db = JFactory::getDBO();

        $query = $db->getQuery(true);

        $query->select('t.id, t.subject, t.published, t.ordering, t.access, t.locked');

        // From the hello table
        $query->from('#__tpcxsocial_forum_topics AS t');
        
        // Join over the asset groups.
        $query->select('ag.title AS access_level');
        $query->join('LEFT', '#__viewlevels AS ag ON ag.id = t.access');
        
        // Join over the categories.
        /*$query->join('LEFT', '#__tpcxsocial_forum_topics_categories AS tc ON tc.topic_id = t.id');
        
        $query->select('cat.title AS category_title');
        $query->join('LEFT', '#__tpcxsocial_forum_categories AS cat ON cat.id = tc.category_id');*/
        
        // Filter by access level.
        if ($access = $this->getState('filter.access')) {
            $query->where('t.access = ' . (int) $access);
        }
        
        // Filter by category.
        if ($category_id = $this->getState('filter.category_id')) {
            $query->join('LEFT', '#__tpcxsocial_forum_topics_categories AS tc ON tc.topic_id = t.id');
            $query->where('tc.category_id = ' . (int) $category_id);
        }
        
        // Filter by published state
        $published = $this->getState('filter.published');
        if (is_numeric($published)) {
            $query->where('t.published = ' . (int) $published);
        }
        elseif ($published === '') {
            $query->where('(t.published = 0 OR t.published = 1)');
        }
        
        // Filter by search in name.
        $search = $this->getState('filter.search');
        if (!empty($search)) {
            if (stripos($search, 'id:') === 0) {
                $query->where('t.id = '.(int) substr($search, 3));
            }
            else {
                $search = $db->Quote('%'.$db->escape($search, true).'%');
                $query->where('(t.subject LIKE '.$search.' OR t.alias LIKE '.$search.')');
            }
        }

        $query->order($db->escape($this->getState('list.ordering', 't.subject')) . ' ' . 
        $db->escape($this->getState('list.direction', 'ASC')));
        
        //echo nl2br(str_replace('#__','joomla_',$query));
        return $query;
    }

    /**
     * Method to auto-populate the model state.
     *
     * Note. Calling getState in this method will result in recursion.
     *
     * @return  void
     * @since   1.6
     */
    protected function populateState($ordering = null, $direction = null)
    {
        // Initialise variables.
        $app = JFactory::getApplication();
        
        $search = $this->getUserStateFromRequest($this->context.'.filter.search', 'filter_search');
        $this->setState('filter.search', $search);
        
        $access = $this->getUserStateFromRequest($this->context.'.filter.access', 'filter_access', 0, 'int');
        $this->setState('filter.access', $access);

        $published = $this->getUserStateFromRequest($this->context.'.filter.published', 'filter_published', '');
        $this->setState('filter.published', $published);
        
        $category_id = $this->getUserStateFromRequest($this->context.'.filter.category_id', 'filter_category_id', '');
        $this->setState('filter.category_id', $category_id);
        
        // List state information.
        parent::populateState('t.subject', 'asc');
    }

    /**
     * Method to get an array of data items.
     *
     * @return  mixed  An array of data items on success, false on failure.
     *
     * @since   11.1
     */
    public function getItems()
    {
        $items = parent::getItems();
        
        $db = $this->getDbo();
        $query = $db->getQuery(true);
        
        foreach($items as $item) {
            $query = $db->getQuery(true);
            
            // From the hello table
            $query->from('#__tpcxsocial_forum_topics_categories AS tc');
            $query->where('tc.topic_id = ' . (int) $item->id);
            
            $query->select('cat.title AS category_title');
            $query->join('LEFT', '#__tpcxsocial_forum_categories AS cat ON cat.id = tc.category_id');
            //echo nl2br(str_replace('#__','joomla_',$query));
            $db->setQuery($query);
            $result = $db->loadResultArray();
            
            if(count($result) > 0) {
                $item->category_title = implode(", ", $result);
            }
        }
        
        return $items;
    }

}
