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
                'created', 't.created',
                'published', 't.published',
                'ordering', 't.ordering',
                'access', 't.access',
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

        $query->select('t.id, t.subject, t.description, t.published, t.alias, t.rating, t.ordering, t.posts, t.created, t.created_by, t.created_by_name');

        // From the hello table
        $query->from('#__tpcxsocial_forum_topics AS t');
        
        // Join over the posts
        //$query->select('p.message AS post_message');
        //$query->join('LEFT', '#__tpcxsocial_forum_posts AS p ON p.topic_id = t.id');
        
        // Join over the asset groups.
        $query->select('ag.title AS access_level');
        $query->join('LEFT', '#__viewlevels AS ag ON ag.id = t.access');
        
        // join over the categories
        $query->join('LEFT', '#__tpcxsocial_forum_topics_categories AS tc ON tc.topic_id = t.id');
        
        $query->select('c.title as category_title');
        $query->join('LEFT', '#__tpcxsocial_forum_categories AS c ON c.id = tc.category_id');
        
        // join over the tags
        $query->join('LEFT', '#__tpcxsocial_forum_topics_tags AS ttag ON ttag.topic_id = t.id');
        
        $query->join('LEFT', '#__tpcxsocial_forum_tags AS tag ON tag.id = ttag.tag_id');
        
        // Filter by category.
        if ($category_id = $this->getState('filter.category_id')) {
            $query->where('tc.category_id = ' . (int) $category_id);
        }
        
        // Filter by search term.
        if ($term = $this->getState('filter.term')) {
            $searches = array();
            $searches[] = 't.subject LIKE "%' . $term . '%"';
            $searches[] = 't.description LIKE "%' . $term . '%"';
            $searches[] = 'c.title LIKE "%' . $term . '%"';
            $searches[] = 'tag.title LIKE "%' . $term . '%"';
            
            $searches = '(' . implode(" OR ", $searches) . ')';
            
            $query->where($searches);
        }
        
        // Filter by published state
        $published = $this->getState('filter.published');

        if (is_numeric($published)) {
            // Use article state if badcats.id is null, otherwise, force 0 for unpublished
            $query->where('t.published = ' . (int) $published);
        }
        
        $query->group('t.id');
        
        $query->order($this->getState('list.ordering', 't.created').' '.$this->getState('list.direction', 'DESC'));
        
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

        $category_id = JRequest::getInt('id');
        $this->setState('filter.category_id', $category_id);
        
        $term = JRequest::getVar('term');
        $this->setState('filter.term', $term);
        
        $this->setState('filter.published', 1);
        
        $orderCol   = JRequest::getCmd('filter_order', 't.created');
        
        if (!in_array($orderCol, $this->filter_fields)) {
            $orderCol = 't.created';
        }
        
        $this->setState('list.ordering', $orderCol);
        
        if($orderCol == 't.subject') {
            $this->setState('list.direction', 'ASC');
        }
        
        //parent::populateState('t.subject', 'asc');
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
        
        // if term exist
        if ($term = $this->getState('filter.term')) {
            $pattern = '/(' . $term . ')/i';
            $replacement = '<span class="search-term">$1</span>';
            foreach($items as $item) {
                $item->subject = preg_replace($pattern, $replacement, $item->subject);

                $description_intro = JHtml::_('string.truncate', $item->description, 150, $noSplit = true, $allowHtml = false);
                $item->description_intro = preg_replace($pattern, $replacement, $description_intro);
            }    
            
        }
        
        return $items;
    }

    /**
     * Method to get an array of data categories items
     *
     * @return  object  An array of data items
     *
     * @since   11.1
     */
    public function getCategories()
    {
        $app = JFactory::getApplication();
        $params = $app->getParams();
        
        $items = $this->getChildren($params->get('category_destination'));
        
        $category = JTable::getInstance('Category', 'TpcxsocialTable');
        
        $path = array();
        if ($category_id = $this->getState('filter.category_id')) {
            $path = $category->getPath($category_id);
        }
        
        $categories_selected = array();
        foreach($path as $p) {
            $categories_selected[] = $p->id;
        }
        
        foreach($items as $item) {
            if(!$category->isLeaf($item->id)) {
                
                if(in_array($item->id, $categories_selected)) {
                    
                    $item->selected = true;
                }
                
                $item->children = $this->getChildren($item->id);
                
                // get the children of level 2
                foreach($item->children as $subItem) {
                    
                    if(in_array($subItem->id, $categories_selected)) {
                        $subItem->selected = true;
                    }
                    
                    if(!$category->isLeaf($subItem->id)) {
                        $subItem->children = $this->getChildren($subItem->id);
                    }
                }
            }   
        }
        
        return $items;
    }

    /**
     * Method to get an array of data children categories items
     *
     * @return  mixed  An array of data items on success, false on failure.
     *
     * @since   11.1
     */
    public function getChildren($parentId = 1)
    {
        // Create a new query object.
        $db = JFactory::getDBO();

        $query = $db->getQuery(true);

        $query->select('c.id, c.title, c.description, c.published, c.alias, c.parent_id, c.access, c.level');

        // From the hello table
        $query->from('#__tpcxsocial_forum_categories AS c');
        
        // Join over the asset groups.
        $query->select('ag.title AS access_level');
        $query->join('LEFT', '#__viewlevels AS ag ON ag.id = c.access');
        
        // no category root
        $query->where('c.parent_id > 0');
        
        // no category root
        $query->where('c.visible = 1');
        
        // Filter by parent id.
        if ($parentId) {
            $query->where('c.parent_id = ' . (int) $parentId);
        }
        
        $query->order('c.lft ASC');
        
        $items = $this->_getList($query);

        return $items;
    }
    
}
