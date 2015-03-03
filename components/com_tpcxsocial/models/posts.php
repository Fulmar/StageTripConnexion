<?php
/**
 * @package		Joomla.Site
 * @subpackage	com_users
 * @copyright	Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

jimport('joomla.application.component.modellist');
jimport('joomla.event.dispatcher');
JTable::addIncludePath(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_tpcxsocial'.DS.'tables');

/**
 * Registration model class for Users.
 *
 * @package		Joomla.Site
 * @subpackage	com_users
 * @since		1.6
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
                'created', 'p.created',
                'rating', 'p.rating',
            );
        }

        parent::__construct($config);
    }

    /**
     * Method to cache the last query constructed.
     *
     * This method ensures that the query is constructed only once for a given state of the model.
     *
     * @return  JDatabaseQuery  A JDatabaseQuery object
     *
     * @since   11.1
     */
    protected function _getListQuery()
    {
        // Create a new query object.
        $db = JFactory::getDBO();

        $query = $db->getQuery(true);

        $query->select('p.id, p.parent_id, p.topic_id, p.message, p.rating, p.created, p.created_by, p.created_by_name');

        // From the hello table
        $query->from('#__tpcxsocial_forum_posts AS p');
        
        // Join over the asset groups.
        $query->select('ag.title AS access_level');
        $query->join('LEFT', '#__viewlevels AS ag ON ag.id = p.access');

        // Filter by topic.
        if ($topic_id = $this->getState('filter.topic_id')) {
            $query->where('p.topic_id = ' . (int) $topic_id);
        }
        
        $query->order($this->getState('list.ordering', 'p.created').' '.$this->getState('list.direction', 'DESC'));
        
        //echo nl2br(str_replace('#__','joomla_',$query));
        return $query;
    }

    /**
     * Method to auto-populate the model state.
     *
     * This method should only be called once per instantiation and is designed
     * to be called on the first call to the getState() method unless the model
     * configuration flag to ignore the request is set.
     *
     * Note. Calling getState in this method will result in recursion.
     *
     * @param   string  $ordering   An optional ordering field.
     * @param   string  $direction  An optional direction (asc|desc).
     *
     * @return  void
     *
     * @since   11.1
     */
    protected function populateState($ordering = null, $direction = null)
    {
        $app = JFactory::getApplication();

        $topic_id = JRequest::getInt('id');
        $this->setState('filter.topic_id', $topic_id);
        
        $orderCol   = JRequest::getCmd('filter_order', 'p.created');
        
        if (!in_array($orderCol, $this->filter_fields)) {
            $orderCol = 'p.created';
        }
        
        $this->setState('list.ordering', $orderCol);
        
        parent::populateState('p.created', 'DESC');
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
        
        foreach($items as $item) {
            $user = TpcxsocialHelperUser::getUserTpcx($item->created_by);
            $item->group_id = TpcxsocialHelperUser::getGroup($user);
            $item->group_name = TpcxsocialHelperUser::getGroupName($item->group_id);
            $item->avatar = TpcxsocialHelperUser::getAvatar($item->created_by, 40, 40);
        }
        
        return $items;
    }
    
    /**
     * Method to get the current topic
     *
     * @return  Object  An object of topic
     *
     * @since   11.1
     */
    public function getTopic()
    {
        // Create a new query object.
        $db = JFactory::getDBO();

        $query = $db->getQuery(true);

        $query->select('t.id, t.subject, t.description, t.published, t.alias, t.ordering, t.rating, t.created_by_name, t.created_by');

        // From the hello table
        $query->from('#__tpcxsocial_forum_topics AS t');

        // Filter by topic.
        if ($topic_id = $this->getState('filter.topic_id')) {
            $query->where('t.id = ' . (int) $topic_id);
        }
        $db->setQuery($query);

        $item = $db->loadObject();
        
        $groupsUser = JUserHelper::getUserGroups($item->created_by);
        
        $groupName = '';
        foreach ($groupsUser as $groupId => $value){
            $db = JFactory::getDbo();
            $db->setQuery(
                'SELECT `title`' .
                ' FROM `#__usergroups`' .
                ' WHERE `id` = '. (int) $groupId
            );
            $groupNames = $db->loadResult();
            break;
        }
        
        $item->userType = $groupNames;
        
        //echo nl2br(str_replace('#__','joomla_',$query));
        return $item;
    }
    
}
