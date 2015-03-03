<?php
// No direct access
defined('_JEXEC') or die('Restricted access');

// import Joomla table library
jimport('joomla.database.tablenested');

/**
 * Hello Table class
 */
class TpcxsocialTableCategory extends JTableNested {
    /**
     * Constructor
     *
     * @param object Database connector object
     */
    function __construct(&$db) {
        parent::__construct('#__tpcxsocial_forum_categories', 'id', $db);
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
        // Verify that the alias is unique
        $table = JTable::getInstance('Category', 'TpcxsocialTable');
        if ($table->load(array('alias'=>$this->alias)) && ($table->id != $this->id || $this->id==0)) {
            $this->setError(JText::_('COM_TPCXSOCIAL_ERROR_UNIQUE_ALIAS'));
            return false;
        }

        // Attempt to store the data.
        return parent::store($updateNulls);
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
        /** check for valid name */
        if (trim($this->title) == '') {
            $this->setError(JText::_('COM_TPCXSOCIAL_WARNING_PROVIDE_VALID_NAME'));
            return false;
        }

        if (empty($this->alias)) {
            $this->alias = $this->title;
        }
        $this->alias = JApplication::stringURLSafe($this->alias);
        if (trim(str_replace('-', '', $this->alias)) == '') {
            $this->alias = JFactory::getDate()->format("Y-m-d-H-i-s");
        }
        
        return true;
    }

}
