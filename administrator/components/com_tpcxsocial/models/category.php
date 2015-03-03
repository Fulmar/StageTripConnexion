<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla modelform library
jimport('joomla.application.component.modeladmin');

/**
 * HelloWorld Model
 */
class TpcxsocialModelCategory extends JModelAdmin
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
    public function getTable($type = 'Category', $prefix = 'TpcxsocialTable', $config = array())
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
        $form = $this->loadForm('com_tpcxsocial.category', 'category', array('control' => 'jform', 'load_data' => $loadData));
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
        $data = JFactory::getApplication()->getUserState('com_tpcxsocial.edit.category.data', array());
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

        $table->title        = htmlspecialchars_decode($table->title, ENT_QUOTES);
        $table->alias       = JApplication::stringURLSafe($table->alias);

        if (empty($table->alias)) {
            $table->alias = JApplication::stringURLSafe($table->title);
        }

        if (empty($table->id)) {
            // Set the values
            //$table->created   = $date->toSql();

        }
        else {
            // Set the values
            //$table->modified  = $date->toSql();
            //$table->modified_by   = $user->get('id');
        }
        
        // level of category
        if (trim($table->parent_id) != '') {
            
            // get the level of category parent
            $query = 'SELECT c.id, c.level' . 
                     ' FROM #__tpcxsocial_forum_categories AS C' .
                     ' WHERE c.id = "' . $table->parent_id . '"';
            $db = JFactory::getDbo();
            $db->setQuery($query);
            $category = $db->loadObject();
            
            $newLevel = $category->level + 1;
            
            if(empty($table->id) || $table->level != $newLevel) {
                $table->level = $newLevel;
            }
        } else {
            $table->level = 1;
        }
    }

    /**
     * Method to save the form data.
     *
     * @param   array  $data  The form data.
     *
     * @return  boolean  True on success.
     *
     * @since   1.6
     */
    public function save($data)
    {
        // Initialise variables;
        $dispatcher = JDispatcher::getInstance();
        $table = $this->getTable();
        $key = $table->getKeyName();
        $pk = (!empty($data[$key])) ? $data[$key] : (int) $this->getState($this->getName() . '.id');
        $isNew = true;

        // Include the content plugins for the on save events.
        JPluginHelper::importPlugin('content');

        // Allow an exception to be thrown.
        try
        {
            // Load the row if saving an existing record.
            if ($pk > 0)
            {
                $table->load($pk);
                $isNew = false;
            }
            
            // Set the new parent id if parent id not matched OR while New/Save as Copy .
            if ($table->parent_id != $data['parent_id'] || $data['id'] == 0)
            {
                $table->setLocation($data['parent_id'], 'last-child');
            }

            // Load optional fields so they get bound when present
            $result = $dispatcher->trigger('onContentPrepareData', array($this->option . '.' . $this->name, &$table));
            if (in_array(false, $result, true)) {
                $this->setError($dispatcher->getError());
                return false;
            }

            // Bind the data.
            if (!$table->bind($data))
            {
                $this->setError($table->getError());
                return false;
            }

            // Prepare the row for saving
            $this->prepareTable($table);

            // Check the data.
            if (!$table->check())
            {
                $this->setError($table->getError());
                return false;
            }

            // Trigger the onContentBeforeSave event.
            $result = $dispatcher->trigger($this->event_before_save, array($this->option . '.' . $this->name, &$table, $isNew));
            if (in_array(false, $result, true))
            {
                $this->setError($table->getError());
                return false;
            }

            // Store the data.
            if (!$table->store())
            {
                $this->setError($table->getError());
                return false;
            }

            // Clean the cache.
            $this->cleanCache();

            // Trigger the onContentAfterSave event.
            $dispatcher->trigger($this->event_after_save, array($this->option . '.' . $this->name, &$table, $isNew));
        }
        catch (Exception $e)
        {
            $this->setError($e->getMessage());

            return false;
        }

        $pkName = $table->getKeyName();

        if (isset($table->$pkName))
        {
            $this->setState($this->getName() . '.id', $table->$pkName);
        }
        $this->setState($this->getName() . '.new', $isNew);

        return true;
    }

    /**
     * Method to save the reordered nested set tree.
     * First we save the new order values in the lft values of the changed ids.
     * Then we invoke the table rebuild to implement the new ordering.
     *
     * @param   array    $idArray    An array of primary key ids.
     * @param   integer  $lft_array  The lft value
     *
     * @return  boolean  False on failure or error, True otherwise
     *
     * @since   1.6
    */
    public function saveorder($idArray = null, $lft_array = null)
    {
        // Get an instance of the table object.
        $table = $this->getTable();

        if (!$table->saveorder($idArray, $lft_array))
        {
            $this->setError($table->getError());
            return false;
        }

        // Clear the cache
        $this->cleanCache();

        return true;
    }

	/**
	 * Method override to check-in a record or an array of record
	 *
	 * @param   mixed  $pks  The ID of the primary key or an array of IDs
	 *
	 * @return  mixed  Boolean false if there is an error, otherwise the count of records checked in.
	 *
	 * @since   11.1
	 */
	public function checkin($pks = array())
	{
		// Initialise variables.
		$pks = (array) $pks;
		$table = $this->getTable();
		$count = 0;

		if (empty($pks))
		{
			$pks = array((int) $this->getState($this->getName() . '.id'));
		}

		// Check in all items.
		foreach ($pks as $pk)
		{
			if ($table->load($pk))
			{
				// calculate post number of the category
				$db = $this->getDbo();

	            $db->setQuery(
	                'SELECT count(*) as total' .
                    ' FROM joomla_tpcxsocial_forum_posts as p' .
                    ' LEFT JOIN joomla_tpcxsocial_forum_topics as t ON t.id = p.topic_id' .
                    ' LEFT JOIN joomla_tpcxsocial_forum_topics_categories as c ON c.topic_id = p.topic_id' .
                    ' WHERE c.category_id = ' . $pk
	            );
	            $db->query();
				$result = $db->loadObject();
				$posts = $result->total;
				
				// calculate topic number of the category
	            $db->setQuery(
	                'SELECT count(*) as total' .
                    ' FROM joomla_tpcxsocial_forum_topics as t' .
                    ' LEFT JOIN joomla_tpcxsocial_forum_topics_categories as c ON c.topic_id = t.id' .
                    ' WHERE c.category_id = ' . $pk
	            );
	            $db->query();
				$result = $db->loadObject();
				$topic_number = $result->total;
				
				$data = array();
				$data['post_number'] = $posts;
				$data['topic_number'] = $topic_number;
				$table->save($data);
				
				$count++;
			}
			else
			{
				$this->setError($table->getError());

				return false;
			}
		}

		// set root at 0
		$db = $this->getDbo();
		
		$db->setQuery(
            'UPDATE #__tpcxsocial_forum_categories' .
            ' SET topic_number = 0,' .
            ' post_number = 0' .
            ' WHERE id = 1'
        );
        $db->query();

		return $count;
	}

}
