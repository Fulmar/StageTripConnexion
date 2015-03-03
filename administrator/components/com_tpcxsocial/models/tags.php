<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import the Joomla modellist library
jimport('joomla.application.component.modellist');

/**
 * TopicsList Model
 */
class TpcxsocialModelTags extends JModelList
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
                'title', 't.title',
                'published', 't.published'
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

        $query->select('t.id, t.title, t.published');

        // From the hello table
        $query->from('#__tpcxsocial_forum_tags AS t');
        
        // Join over the categories.
        $query->select('cat.title AS category_title');
        $query->join('LEFT', '#__tpcxsocial_forum_tags_categories AS cat ON cat.id = t.category_id');
        
        // Filter by category.
        if ($category_id = $this->getState('filter.category_id')) {
            $query->where('t.category_id = ' . (int) $category_id);
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
                $query->where('(t.title LIKE '.$search.')');
            }
        }
        
        $query->order($db->escape($this->getState('list.ordering', 't.title')) . ' ' . 
        $db->escape($this->getState('list.direction', 'ASC')));
        
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
        
        $published = $this->getUserStateFromRequest($this->context.'.filter.published', 'filter_published', '');
        $this->setState('filter.published', $published);
        
        $category_id = $this->getUserStateFromRequest($this->context.'.filter.category_id', 'filter_category_id', '');
        $this->setState('filter.category_id', $category_id);
        
        // List state information.
        parent::populateState('t.title', 'asc');
    }

}
