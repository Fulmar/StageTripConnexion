<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import the Joomla modellist library
jimport('joomla.application.component.modellist');

/**
 * CaegoriesLIst Model
 */
class TpcxsocialModelCategories extends JModelList
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
                'id', 'c.id',
                'title', 'c.title',
                'published', 'c.published',
                'access', 'c.access',
                'lft', 'c.lft',
                'rgt', 'c.rgt',
                'level', 'c.level',
                'path', 'c.path',
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

        $query->select('c.id, c.title, c.published, c.parent_id, c.access, c.level, c.lft, c.rgt');

        // From the hello table
        $query->from('#__tpcxsocial_forum_categories AS c');
        
        // Join over the asset groups.
        $query->select('ag.title AS access_level');
        $query->join('LEFT', '#__viewlevels AS ag ON ag.id = c.access');

        // Join over the categories.
        $query->select('cat.title AS category_title');
        $query->join('LEFT', '#__tpcxsocial_forum_categories AS cat ON cat.id = c.parent_id');
        
        $query->where('c.id > 1');
        
        // Filter on the level.
        if ($level = $this->getState('filter.level')) {
            $query->where('c.level <= '.(int) $level);
        }
        
        // Filter by access level.
        if ($access = $this->getState('filter.access')) {
            $query->where('c.access = ' . (int) $access);
        }
        
        // Filter by published state
        $published = $this->getState('filter.published');
        if (is_numeric($published)) {
            $query->where('c.published = ' . (int) $published);
        }
        elseif ($published === '') {
            $query->where('(c.published = 0 OR c.published = 1)');
        }
        
        // Filter by search in name.
        $search = $this->getState('filter.search');
        if (!empty($search)) {
            if (stripos($search, 'id:') === 0) {
                $query->where('c.id = '.(int) substr($search, 3));
            }
            else {
                $search = $db->Quote('%'.$db->escape($search, true).'%');
                $query->where('(c.title LIKE '.$search.' OR c.alias LIKE '.$search.')');
            }
        }
        
        $query->order($db->escape($this->getState('list.ordering', 'c.lft')) . ' ' . 
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
        
        $level = $this->getUserStateFromRequest($this->context.'.filter.level', 'filter_level', 0, 'int');
        $this->setState('filter.level', $level);
        
        // List state information.
        parent::populateState('c.lft', 'asc');
    }

}
