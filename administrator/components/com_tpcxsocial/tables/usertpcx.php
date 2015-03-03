<?php
// No direct access
defined('_JEXEC') or die('Restricted access');

// import Joomla table library
jimport('joomla.database.table');

/**
 * Hello Table class
 */
class TpcxsocialTableUsertpcx extends JTable {
    /**
     * Constructor
     *
     * @param object Database connector object
     */
    function __construct(&$db) {
        parent::__construct('#__tpcxsocial_users', 'user_id', $db);
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
        
        $jform = $_REQUEST['jform'];
        
        $pk = 0;
        if(!empty($this->user_id)) {
            $pk = $this->user_id;
        }
        
        // create new user joomla
        $user = new JUser($pk);
        
        //Write to database
        if(!$user->bind($jform)) {
            throw new Exception("Could not bind data. Error: " . $user->getError());
        }
		
        if (!$user->save()) {
            throw new Exception("Could not save user. Error: " . $user->getError());
        }
        
        $data = $jform;
		$data['user_id'] = $user->id;
        
        $this->bind($data);
		
        // If a primary key exists update the object, otherwise insert it.
        if ($pk > 0)
        {
            $stored = $this->_db->updateObject($this->_tbl, $this, $this->_tbl_key, $updateNulls);
        }
        else
        {
            $stored = $this->_db->insertObject($this->_tbl, $this, $this->_tbl_key);
        }
		
		return true;
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
        
        if(!is_array($keys)) {
            $keys = array($this->_tbl_key => $keys);
        }
        
        foreach($keys as $field => $value) {
            $user = new JUser($value);
            
            foreach($user->getProperties() as $key => $value) {
                $this->set($key, $value);
            }
        }
        
        
    }

}
