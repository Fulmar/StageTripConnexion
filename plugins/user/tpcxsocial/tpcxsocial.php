<?php
/**
 * @copyright	Copyright (C) 2005 - 2009 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

/**
 * Joomla User plugin
 *
 * @package		Joomla.Plugin
 * @subpackage	User.joomla
 * @since		1.5
 */
class plgUserTpcxsocial extends JPlugin
{
	/**
	 * Remove user from joomla_tpcxsocial_users
	 *
	 * Method is called after user data is deleted from the database
	 *
	 * @param	array		$user	Holds the user data
	 * @param	boolean		$succes	True if user was succesfully stored in the database
	 * @param	string		$msg	Message
	 *
	 * @return	boolean
	 * @since	1.6
	 */
	public function onUserAfterDelete($user, $succes, $msg)
	{
		if (!$succes) {
			return false;
		}

		$db = JFactory::getDbo();
		$db->setQuery(
			'DELETE FROM '.$db->quoteName('#__tpcxsocial_users') .
			' WHERE '.$db->quoteName('user_id').' = '.(int) $user['id']
		);
		$db->query();

		return true;
	}

    /**
     * @param   string  $context    The context for the data
     * @param   int     $data       The user id
     * @param   object
     *
     * @return  boolean
     * @since   1.6
     */
    function onContentPrepareData($context, $data)
    {
        // Check we are manipulating a valid form.
        if (!in_array($context, array('com_users.profile', 'com_users.user', 'com_users.registration', 'com_admin.profile')))
        {
            return true;
        }

        if (is_object($data))
        {
            $userId = isset($data->id) ? $data->id : 0;

            if ($userId > 0)
            {
                // Load the user_id tpcx data from the database.
                $db = JFactory::getDbo();
                $db->setQuery(
                    'SELECT * FROM #__tpcxsocial_users' .
                    ' WHERE user_id = '.(int) $userId
                );
                $results = $db->loadObject();
                if(count($results) > 0) {
                    foreach ($results as $key => $value) {
                        $data->def($key, $value);
                    }
                }
            }
        }

        return true;
    }
}
