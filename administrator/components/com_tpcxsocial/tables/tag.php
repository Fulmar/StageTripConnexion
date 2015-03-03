<?php
// No direct access
defined('_JEXEC') or die('Restricted access');

// import Joomla table library
jimport('joomla.database.table');

/**
 * Hello Table class
 */
class TpcxsocialTableTag extends JTable {
    /**
     * Constructor
     *
     * @param object Database connector object
     */
    function __construct(&$db) {
        parent::__construct('#__tpcxsocial_forum_tags', 'id', $db);
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
            // Existing item
            $this->modified     = $date->toSql();
            $this->modified_by  = $user->get('id');
        } else {
            // New category. A category created and created_by field can be set by the user,
            // so we don't touch either of these if they are set.
            if (!intval($this->created)) {
                $this->created = $date->toSql();
            }
            if (empty($this->created_by)) {
                $this->created_by = $user->get('id');
            }
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
        if (trim($this->title) == '') {
            $this->setError(JText::_('COM_TPCXSOCIAL_WARNING_PROVIDE_VALID_TITLE'));
            return false;
        }
        
        return true;
    }

}
