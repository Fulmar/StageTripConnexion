<?php
// No direct access
defined('_JEXEC') or die('Restricted access');

// import Joomla table library
jimport('joomla.database.table');

/**
 * Hello Table class
 */
class TpcxsocialTableTopic extends JTable {
    /**
     * Constructor
     *
     * @param object Database connector object
     */
    function __construct(&$db) {
        parent::__construct('#__tpcxsocial_forum_topics', 'id', $db);
    }

    /**
     * Method to load a row from the database by primary key and bind the fields
     * to the JTable instance properties.
     *
     * @param   mixed    $keys   An optional primary key value to load the row by, or an array of fields to match.  If not
     * set the instance property value is used.
     * @param   boolean  $reset  True to reset the default values before loading the new row.
     *
     * @return  boolean  True if successful. False if row not found or on error (internal error state set in that case).
     *
     * @link    http://docs.joomla.org/JTable/load
     * @since   11.1
     */
    public function load($keys = null, $reset = true)
    {
        parent::load($keys, $reset);
        
        $category_id = $this->getCategories();
        $this->category_id = $category_id;
        
        $tag_id = $this->getTags();
        $this->tag_id = $tag_id;
        
        return true; 
    }
    
    /*
     * Get the categories of the table topic 
     */
    public function getCategories() {
        
        $db = JFactory::getDbo(true);
        $db->setQuery(
            "SELECT category_id FROM #__tpcxsocial_forum_topics_categories WHERE topic_id = '" . $this->id . "'"
        );
        $db->query();
        
        return $db->loadResultArray();
        
    }
    
    /*
     * Get the tags of the table topic 
     */
    public function getTags() {
        
        $db = JFactory::getDbo(true);
        $db->setQuery(
            "SELECT tag_id FROM #__tpcxsocial_forum_topics_tags WHERE topic_id = '" . $this->id . "'"
        );
        $db->query();
        
        return $db->loadResultArray();
        
    }

    /**
     * Stores a category
     *
     * @param   boolean True to update fields even if they are null.
     * @return  boolean True on success, false on failure.
     * @since   1.6
     */
    public function store($updateNulls = false)
    {
        $date   = JFactory::getDate();
        $user   = JFactory::getUser();
		
        if ($this->id) {
        	$edit = true;
            // Existing item
            $this->modified     = $date->toSql();
            $this->modified_by  = $user->get('id');
            
        } else {
        	$edit = false;
            // New category. A category created and created_by field can be set by the user,
            // so we don't touch either of these if they are set.
            if (!intval($this->created)) {
                $this->created = $date->toSql();
            }
            if (empty($this->created_by)) {
                $this->created_by = $user->get('id');
            }
			
			// get user name
			$userTpcx = JTable::getInstance('Usertpcx', 'TpcxsocialTable');
			$userTpcx->load($this->created_by);
		    $fullname = $userTpcx->firstname . ' ' . $userTpcx->name;
			
			$this->created_by_name = $fullname;
        }
    
        // Attempt to store the data.
        if(!parent::store($updateNulls)) {
        	return false;
        }
		
		return true;
    }

    /**
     * Overloaded check function
     *
     * @return boolean
     * @see JTable::check
     * @since 1.5
     */
    function check()
    {
        /** check for valid subject */
        if (trim($this->subject) == '') {
            $this->setError(JText::_('COM_TPCXSOCIAL_WARNING_PROVIDE_VALID_SUBJECT'));
            return false;
        }

        if (empty($this->alias)) {
            $this->alias = $this->subject;
        }
        $this->alias = JApplication::stringURLSafe($this->alias);
        if (trim(str_replace('-', '', $this->alias)) == '') {
            $this->alias = JFactory::getDate()->format("Y-m-d-H-i-s");
        }
        
        return true;
    }

}
