<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla modelform library
jimport('joomla.application.component.modeladmin');

/**
 * HelloWorld Model
 */
class TpcxsocialModelUser extends JModelAdmin
{
    /**
     * Returns a reference to the a Table object, always creating it.
     *
     * @param       type    The table type to instantiate
     * @param       string  A prefix for the table class name. Optional.
     * @param       array   Configuration array for model. Optional.
     * @return      JTable  A database object
     * @since       2.5
     */
    public function getTable($type = 'Usertpcx', $prefix = 'TpcxsocialTable', $config = array())
    {
        return JTable::getInstance($type, $prefix, $config);
    }

    /**
     * Method to get the record form.
     *
     * @param       array   $data           Data for the form.
     * @param       boolean $loadData       True if the form is to load its own data (default case), false if not.
     * @return      mixed   A JForm object on success, false on failure
     * @since       2.5
     */
    public function getForm($data = array(), $loadData = true)
    {
        // Get the form.
        $form = $this->loadForm('com_tpcxsocial.user', 'user', array('control' => 'jform', 'load_data' => $loadData));
        if (empty($form)) {
            return false;
        }
        return $form;
    }

    /**
     * Method to get the data that should be injected in the form.
     *
     * @return      mixed   The data for the form.
     * @since       2.5
     */
    protected function loadFormData()
    {
        // Check the session for previously entered form data.
        $data = JFactory::getApplication()->getUserState('com_tpcxsocial.edit.user.data', array());
        if (empty($data)) {
            $data = $this->getItem();
        }
        return $data;
    }

    /**
     * Method to get a single record.
     *
     * @param   integer  $pk  The id of the primary key.
     *
     * @return  mixed    Object on success, false on failure.
     *
     * @since   11.1
     */
    public function getItem($pk = null)
    {
        $pk = (!empty($pk)) ? $pk : (int) $this->getState($this->getName() . '.id');
        
        $item = parent::getItem($pk);
        
        // load user
        $user = JUser::getInstance($pk);
        
        $item->setProperties($user->getProperties());
        
        return $item;
    }

    /**
     * Gets the groups this object is assigned to
     *
     * @param   integer  $userId  The user ID to retrieve the groups for
     *
     * @return  array  An array of assigned groups
     *
     * @since   1.6
     */
    public function getAssignedGroups($userId = null)
    {
        // Initialise variables.
        $userId = (!empty($userId)) ? $userId : (int) $this->getState('user.id');

        if (empty($userId))
        {
            $result = array();

            $groupsIDs = $this->getForm()->getValue('groups');

            if (!empty($groupsIDs))
            {
                $result = $groupsIDs;
            }
            else
            {
                $config = JComponentHelper::getParams('com_tpcxsocial');

                if ($groupId = $config->get('group_default'))
                {
                    $result[] = $groupId;
                }
            }
        }
        else
        {
            $result = JUserHelper::getUserGroups($userId);
        }

        return $result;
    }

    /**
     * Method to delete one or more records.
     *
     * @param   array  &$pks  An array of record primary keys.
     *
     * @return  boolean  True if successful, false if an error occurs.
     *
     * @since   11.1
     */
    public function delete(&$pks)
    {
        
        // Iterate the items to delete each one.
        foreach ($pks as $i => $pk)
        {
            $user = new JUser($pk);
            $user->delete();
        }
        
    }

}
