<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla modelform library
jimport('joomla.application.component.modeladmin');

/**
 * HelloWorld Model
 */
class TpcxsocialModelPost extends JModelAdmin
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
    public function getTable($type = 'Post', $prefix = 'TpcxsocialTable', $config = array())
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
        $form = $this->loadForm('com_tpcxsocial.post', 'post', array('control' => 'jform', 'load_data' => $loadData));
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
        $data = JFactory::getApplication()->getUserState('com_tpcxsocial.edit.post.data', array());
        if (empty($data)) {
            $data = $this->getItem();
        }
        return $data;
    }

    /**
     * Prepare and sanitise the table prior to saving.
     *
     * @param   JTable  $table
     *
     * @return  void
     * @since   1.6
     */
    protected function prepareTable(&$table)
    {
        $date = JFactory::getDate();
        $user = JFactory::getUser();

        if (empty($table->id)) {
            // Set the values
            //$table->created   = $date->toSql();

        }
        else {
            // Set the values
            //$table->modified  = $date->toSql();
            //$table->modified_by   = $user->get('id');
        }
        
        // get the category id
        $db     = JFactory::getDbo();
        $query  = $db->getQuery(true);
 
        $query->select('t.category_id');
        $query->from('#__tpcxsocial_forum_topics AS t');
        $query->where('id = "' . $table->topic_id . '"');
 
        // Get the options.
        $db->setQuery($query);
 
        $topic = $db->loadObject();
        
        $table->category_id = $topic->category_id;
        
    }

    /**
     * A protected method to get a set of ordering conditions.
     *
     * @param   JTable  $table  A record object.
     *
     * @return  array   An array of conditions to add to add to ordering queries.
     * @since   1.6
     */
    protected function getReorderConditions($table)
    {
        $condition = array();
        $condition[] = 'thread = '.(int) $table->thread;

        return $condition;
    }

}
