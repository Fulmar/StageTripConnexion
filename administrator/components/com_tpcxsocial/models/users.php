<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import the Joomla modellist library
jimport('joomla.application.component.modellist');

/**
 * TopicsList Model
 */
class TpcxsocialModelUsers extends JModelList
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
                'id', 'u.id',
                'email', 'u.email',
                'registerDate', 'u.registerDate',
                'lastvisitDate', 'u.lastvisitDate',
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

        $query->select('u.*');

        $query->from('#__users AS u');
        
        // Join over the users for the linked user.
        $query->select('tu.*');
        $query->join('INNER', '#__tpcxsocial_users AS tu ON u.id=tu.user_id');
        
        // If the model is set to check the activated state, add to the query.
        $active = $this->getState('filter.active');

        if (is_numeric($active))
        {
            if ($active == '0')
            {
                $query->where('a.activation = '.$db->quote(''));
            }
            elseif ($active == '1')
            {
                $query->where($query->length('a.activation').' = 32');
            }
        }
        
        // Filter the items over the group id if set.
        $groupId = $this->getState('filter.group_id');

        if ($groupId)
        {
            $query->join('LEFT', '#__user_usergroup_map AS map2 ON map2.user_id = u.id');
            $query->group('u.id,u.name,u.username,u.password,u.usertype,u.block,u.sendEmail,u.registerDate,u.lastvisitDate,u.activation,u.params,u.email');

            if ($groupId)
            {
                $query->where('map2.group_id = '.(int) $groupId);
            }
        }
        
        // Filter by search in name.
        $search = $this->getState('filter.search');
        if (!empty($search)) {
            if (stripos($search, 'id:') === 0) {
                $query->where('u.id = '.(int) substr($search, 3));
            }
            else {
                $search = $db->Quote('%'.$db->escape($search, true).'%');

                // Compile the different search clauses.
                $searches   = array();
                $searches[] = 'u.name LIKE '.$search;
                $searches[] = 'tu.firstname LIKE '.$search;
                $searches[] = 'u.email LIKE '.$search;
    
                // Add the clauses to the query.
                $query->where('('.implode(' OR ', $searches).')');
            }
        }
        
        $query->order($db->escape($this->getState('list.ordering', 'u.name')) . ' ' . 
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
        
        $groupId = $this->getUserStateFromRequest($this->context.'.filter.group', 'filter_group_id', null, 'int');
        $this->setState('filter.group_id', $groupId);
        
        $published = $this->getUserStateFromRequest($this->context.'.filter.published', 'filter_published', null, 'int');
        $this->setState('filter.published', $published);
        
        $access = $this->getUserStateFromRequest($this->context.'.filter.access', 'filter_access', null, 'int');
        $this->setState('filter.access', $access);
        
        // List state information.
        parent::populateState('u.name', 'asc');
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
        // Get a storage key.
        $store = $this->getStoreId();
        
        // Try to load the data from internal storage.
        if (empty($this->cache[$store])) {
                
            $groupId = $this->getState('filter.group_id');
            
            $items = parent::getItems();

            // Bail out on an error or empty list.
            if (empty($items))
            {
                $this->cache[$store] = $items;

                return $items;
            }

            // Joining the groups with the main query is a performance hog.
            // Find the information only on the result set.

            // First pass: get list of the user id's and reset the counts.
            $userIds = array();
            foreach ($items as $item)
            {
                $userIds[] = (int) $item->id;
                $item->group_count = 0;
                $item->group_names = '';
                $item->note_count = 0;
            }

            // Get the counts from the database only for the users in the list.
            $db = $this->getDbo();
            $query = $db->getQuery(true);

            // Join over the group mapping table.
            $query->select('map.user_id, COUNT(map.group_id) AS group_count')
                ->from('#__user_usergroup_map AS map')
                ->where('map.user_id IN ('.implode(',', $userIds).')')
                ->group('map.user_id')
                // Join over the user groups table.
                ->join('LEFT', '#__usergroups AS g2 ON g2.id = map.group_id');

            $db->setQuery($query);

            // Load the counts into an array indexed on the user id field.
            $userGroups = $db->loadObjectList('user_id');

            $error = $db->getErrorMsg();
            if ($error)
            {
                $this->setError($error);

                return false;
            }

            $query->clear()
                ->select('n.user_id, COUNT(n.id) As note_count')
                ->from('#__user_notes AS n')
                ->where('n.user_id IN ('.implode(',', $userIds).')')
                ->where('n.state >= 0')
                ->group('n.user_id');

            $db->setQuery((string) $query);

            // Load the counts into an array indexed on the aro.value field (the user id).
            $userNotes = $db->loadObjectList('user_id');

            $error = $db->getErrorMsg();
            if ($error)
            {
                $this->setError($error);

                return false;
            }

            // Second pass: collect the group counts into the master items array.
            foreach ($items as &$item)
            {
                if (isset($userGroups[$item->id]))
                {
                    $item->group_count = $userGroups[$item->id]->group_count;
                    //Group_concat in other databases is not supported
                    $item->group_names = $this->_getUserDisplayedGroups($item->id);
                }

                if (isset($userNotes[$item->id]))
                {
                    $item->note_count = $userNotes[$item->id]->note_count;
                }
            }

            // Add the items to the internal cache.
            $this->cache[$store] = $items;
        }
        
        return $this->cache[$store];
    }
    //sqlsrv change
    function _getUserDisplayedGroups($user_id)
    {
        $db = JFactory::getDbo();
        $sql = "SELECT title FROM ".$db->quoteName('#__usergroups')." ug left join ".
                $db->quoteName('#__user_usergroup_map')." map on (ug.id = map.group_id)".
                " WHERE map.user_id=".$user_id;

        $db->setQuery($sql);
        $result = $db->loadColumn();
        return implode("\n", $result);
    }

}
