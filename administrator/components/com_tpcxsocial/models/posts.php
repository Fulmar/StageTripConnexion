<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import the Joomla modellist library
jimport('joomla.application.component.modellist');

/**
 * TopicsList Model
 */
class TpcxsocialModelPosts extends JModelList
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
                'id', 'p.id',
                'subject', 'p.subject',
                'published', 'p.published'
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

        $query->select('p.id, p.published, p.access, p.topic_id, p.message');

        // From the hello table
        $query->from('#__tpcxsocial_forum_posts AS p');
        
        // Join over the asset groups.
        $query->select('ag.title AS access_level');
        $query->join('LEFT', '#__viewlevels AS ag ON ag.id = p.access');
        
        // Join over the topic.
        $query->select('t.subject AS topic_title');
        $query->join('LEFT', '#__tpcxsocial_forum_topics AS t ON t.id = p.topic_id');
        
        // Filter by access level.
        if ($access = $this->getState('filter.access')) {
            $query->where('p.access = ' . (int) $access);
        }
                
        // Filter by topic id.
        if ($topic_id = $this->getState('filter.topic_id')) {
            $query->where('p.topic_id = ' . (int) $topic_id);
        }
        
        // Filter by published state
        $published = $this->getState('filter.published');
        if (is_numeric($published)) {
            $query->where('p.published = ' . (int) $published);
        }
        elseif ($published === '') {
            $query->where('(p.published = 0 OR p.published = 1)');
        }
        
        // Filter by search in name.
        $search = $this->getState('filter.search');
        if (!empty($search)) {
            if (stripos($search, 'id:') === 0) {
                $query->where('p.id = '.(int) substr($search, 3));
            }
            else {
                $search = $db->Quote('%'.$db->escape($search, true).'%');
                $query->where('(p.message LIKE '.$search.')');
            }
        }
        
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
        
        $topic_id = $this->getUserStateFromRequest($this->context.'.filter.topic_id', 'filter_topic_id', '');
        $this->setState('filter.topic_id', $topic_id);
        
        // List state information.
        parent::populateState('p.created', 'desc');
    }

}
