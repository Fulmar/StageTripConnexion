<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla modelform library
jimport('joomla.application.component.modeladmin');

/**
 * HelloWorld Model
 */
class TpcxsocialModelTopic extends JModelAdmin
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
    public function getTable($type = 'Topic', $prefix = 'TpcxsocialTable', $config = array())
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
        $form = $this->loadForm('com_tpcxsocial.topic', 'topic', array('control' => 'jform', 'load_data' => $loadData));
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
        $data = JFactory::getApplication()->getUserState('com_tpcxsocial.edit.topic.data', array());
        if (empty($data)) {
            $data = $this->getItem();
        }
        return $data;
    }

    /**
     * Method to get a single record.
     *
     * @param   integer $pk The id of the primary key.
     *
     * @return  mixed   Object on success, false on failure.
     * @since   1.6
     */
    public function getItem($pk = null)
    {
        if ($item = parent::getItem($pk)) {
            
            // Convert the params field to an array.
            $registry = new JRegistry;
            $registry->loadObject($item->category_id);
            $item->category_id = $registry->toArray();
            
            // Convert the params field to an array.
            $registry = new JRegistry;
            $registry->loadObject($item->tag_id);
            $item->tag_id = $registry->toArray();
        }

        return $item;
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

        $table->subject        = htmlspecialchars_decode($table->subject, ENT_QUOTES);
        $table->alias       = JApplication::stringURLSafe($table->alias);

        if (empty($table->alias)) {
            $table->alias = JApplication::stringURLSafe($table->subject);
        }

        if (empty($table->id)) {
            // Set the values
            //$table->created   = $date->toSql();

            // Set ordering to the last item if not set
            if (empty($table->ordering)) {
                $db = JFactory::getDbo();
                $db->setQuery('SELECT MAX(ordering) FROM #__tpcxsocial_forum_topics');
                $max = $db->loadResult();

                $table->ordering = $max+1;
            }
        }
        else {
            // Set the values
            //$table->modified  = $date->toSql();
            //$table->modified_by   = $user->get('id');
        }
    }

    /**
     * Method to save the form data.
     *
     * @param   array  $data  The form data.
     *
     * @return  boolean  True on success, False on error.
     *
     * @since   11.1
     */
    public function save($data)
    {
        if(parent::save($data)) {
            $topic_id = $this->getState($this->getName().'.id');
            
            $db = JFactory::getDbo();
            
            // categories topic
            // delete old relation categories
            $db = JFactory::getDbo(true);
            $db->setQuery(
                "DELETE FROM #__tpcxsocial_forum_topics_categories WHERE topic_id = '" . $topic_id . "'"
            );
            $db->query();
            
            $category_id = $data['category_id'];
            
            // add new relation categories
            $values = array();
            foreach($category_id as $id) {
                $values[] = "('" . $topic_id . "', '" . $id . "')";
            }
            
            $values = implode(", ", $values);
            
            $db->setQuery(
                "INSERT INTO #__tpcxsocial_forum_topics_categories VALUES " . $values
            );
            $db->query();
            
            // tags
            // delete old relation tag
            $db = JFactory::getDbo(true);
            $db->setQuery(
                "DELETE FROM #__tpcxsocial_forum_topics_tags WHERE topic_id = '" . $topic_id . "'"
            );
            $db->query();
            
            $tag_id = $data['tag_id'];
            
            // add new relation tag
            $values = array();
            foreach($tag_id as $id) {
                $values[] = "('" . $topic_id . "', '" . $id . "')";
            }
            
            $values = implode(", ", $values);
            
            $db->setQuery(
                "INSERT INTO #__tpcxsocial_forum_topics_tags VALUES " . $values
            );
            $db->query();
            
            
            return true;
        }
        
        return false;
        
    }

    /**
     * Method to toggle the locked setting of topics.
     *
     * @param   array   $pks    The ids of the items to toggle.
     * @param   int     $value  The value to toggle to.
     *
     * @return  boolean True on success.
     * @since   1.6
     */
    public function locked($pks, $value = 0)
    {
        // Sanitize the ids.
        $pks = (array) $pks;
        JArrayHelper::toInteger($pks);

        if (empty($pks)) {
            $this->setError(JText::_('COM_TPCXSOCIAL_NO_ITEM_SELECTED'));
            return false;
        }

        $table = $this->getTable();

        try
        {
            $db = $this->getDbo();

            $db->setQuery(
                'UPDATE #__tpcxsocial_forum_topics' .
                ' SET locked = '.(int) $value.
                ' WHERE id IN ('.implode(',', $pks).')'
            );
            if (!$db->query()) {
                throw new Exception($db->getErrorMsg());
            }

        }
        catch (Exception $e)
        {
            $this->setError($e->getMessage());
            return false;
        }

        $table->reorder();

        // Clean component's cache
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
				// calculate post number of the topic
				$db = $this->getDbo();

	            $db->setQuery(
	                'SELECT COUNT(*) AS total' .
	                ' FROM #__tpcxsocial_forum_posts' .
	                ' WHERE topic_id = ' . $pk
	            );
	            $db->query();
				$result = $db->loadObject();
				$posts = $result->total;
				
				// select last post
	            $db->setQuery(
	                'SELECT *' .
	                ' FROM #__tpcxsocial_forum_posts' .
	                ' WHERE topic_id = ' . $pk .
	                ' ORDER BY created DESC' .
	                ' LIMIT 0, 1'
	            );
	            $db->query();
				$result = $db->loadObject();
				
				$db = $this->getDbo();
                $db->setQuery(
                    "UPDATE #__tpcxsocial_forum_topics SET " .
                    "posts = " . $posts . ", " .
                    "last_post_id = " . $result->id . ", " .
                    "last_post_time = " . $result->created . ", " .
                    "last_post_user_id = " . $result->created_by . ", " .
                    "last_post_message = " . $db->quote($result->message) . ", " .
                    "last_post_guest_name = " . $result->created_by_name .
                    "WHERE id = " . $pk
                );
                $db->query();
				
				$count++;
			}
			else
			{
				$this->setError($table->getError());

				return false;
			}
		}

		return $count;
	}

}
