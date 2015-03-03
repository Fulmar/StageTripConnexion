<?php
/**
 * @package		Joomla.Site
 * @subpackage	com_users
 * @copyright	Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

jimport('joomla.application.component.modelform');
jimport('joomla.event.dispatcher');

/**
 * Registration model class for Users.
 *
 * @package		Joomla.Site
 * @subpackage	com_users
 * @since		1.6
 */
class TpcxsocialModelRegistration extends JModelForm
{
    /**
     * Get a list of the user groups for filtering.
     *
     * @return  array  An array of JHtmlOption elements.
     *
     * @since   1.6
     */
    static function getGroups()
    {
        // Get the parameters
        $params = JComponentHelper::getParams('com_tpcxsocial');
        
        $db = JFactory::getDbo();
        $db->setQuery(
            'SELECT a.id AS value, a.title AS text, COUNT(DISTINCT b.id) AS level' .
            ' FROM #__usergroups AS a' .
            ' LEFT JOIN '.$db->quoteName('#__usergroups').' AS b ON a.lft > b.lft AND a.rgt < b.rgt' .
            ' WHERE a.id IN (' . implode(',', $params->get('groups_id')) . ')' .
            ' GROUP BY a.id, a.title, a.lft, a.rgt' .
            ' ORDER BY a.lft ASC'
        );
        $options = $db->loadObjectList();

        // Check for a database error.
        if ($db->getErrorNum())
        {
            JError::raiseNotice(500, $db->getErrorMsg());
            return null;
        }

        return $options;
    }

    /**
     * Method to get the registration form data.
     *
     * The base form data is loaded and then an event is fired
     * for users plugins to extend the data.
     *
     * @return  mixed       Data object on success, false on failure.
     * @since   1.6
     */
    public function getData()
    {
        if ($this->data === null) {

            $this->data = new stdClass();
            $app    = JFactory::getApplication();

            // Override the base user data with any data in the session.
            $temp = (array)$app->getUserState('com_tpcxsocial.registration.data', array());
            foreach ($temp as $k => $v) {
                $this->data->$k = $v;
            }

            // Unset the passwords.
            unset($this->data->password1);
            unset($this->data->password2);
        }

        return $this->data;
    }

    /**
     * Method to get the registration form.
     *
     * The base form is loaded from XML and then an event is fired
     * for users plugins to extend the form with extra fields.
     *
     * @param   array   $data       An optional array of data for the form to interogate.
     * @param   boolean $loadData   True if the form is to load its own data (default case), false if not.
     * @return  JForm   A JForm object on success, false on failure
     * @since   1.6
     */
    public function getForm($data = array(), $loadData = true)
    {
        // Get the form.
        $form = $this->loadForm('com_tpcxsocial.registration', 'registration', array('control' => 'jform', 'load_data' => $loadData));
        if (empty($form)) {
            return false;
        }

        return $form;
    }

    /**
     * Method to get the data that should be injected in the form.
     *
     * @return  mixed   The data for the form.
     * @since   1.6
     */
    protected function loadFormData()
    {
        return $this->getData();
    }

    /**
     * Method to save the form data.
     *
     * @param   array       The form data.
     * @return  mixed       The user id on success, false on failure.
     * @since   1.6
     */
    public function register($temp)
    {
        $config = JFactory::getConfig();
        $db     = $this->getDbo();
        $params = JComponentHelper::getParams('com_users');

        // Initialise the table with JUser.
        $user = new JUser;
        $data = (array)$this->getData();

        // Merge in the registration data.
        foreach ($temp as $k => $v) {
            $data[$k] = $v;
        }
        
        $params = JComponentHelper::getParams('com_tpcxsocial');
        $group_default = $params->get('group_default');
        
        $data['groups'][] = $group_default;
        
        // Prepare the data for the user object.
        $data['email']      = $data['email'];
        $data['password']   = $data['password1'];
        $useractivation = $params->get('useractivation');
        $sendpassword = $params->get('sendpassword', 1);

        // Check if the user needs to activate their account.
        if (($useractivation == 1) || ($useractivation == 2)) {
            $data['activation'] = JApplication::getHash(JUserHelper::genRandomPassword());
            $data['block'] = 1;
        }

        // Bind the data.
        if (!$user->bind($data)) {
            $this->setError(JText::sprintf('COM_USERS_REGISTRATION_BIND_FAILED', $user->getError()));
            return false;
        }

        // Load the users plugin group.
        JPluginHelper::importPlugin('user');

        // Store the data.
        if (!$user->save()) {
            $this->setError(JText::sprintf('COM_TPCXSOCIAL_REGISTRATION_SAVE_FAILED', $user->getError()));
            return false;
        }
        
        // TpCx add user in tpcx table
        $table = $this->getTable('Usertpcx', 'TpcxsocialTable');
        
        $data['user_id'] = $user->id;
        
        $table->bind($data);
        
        // Store the data.
        $stored = $table->getDbo()->insertObject($table->getTableName(), $table, $table->getKeyName());
        if (!$stored) {
            $this->setError(JText::sprintf('COM_TPCXSOCIAL_REGISTRATION_SAVE_FAILED', $table->getDbo()->getErrorMsg()));
            return false;
        }
        
        return $user->id;
    }
}
