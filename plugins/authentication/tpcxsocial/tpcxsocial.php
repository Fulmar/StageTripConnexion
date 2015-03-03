<?php
/**
 * @copyright	Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

/**
 * Joomla Authentication plugin
 *
 * @package		Joomla.Plugin
 * @subpackage	Authentication.joomla
 * @since 1.5
 */
class plgAuthenticationTpcxsocial extends JPlugin
{
	/**
	 * This method should handle any authentication and report back to the subject
	 *
	 * @access	public
	 * @param	array	Array holding the user credentials
	 * @param	array	Array of extra options
	 * @param	object	Authentication response object
	 * @return	boolean
	 * @since 1.5
	 */
	function onUserAuthenticate($credentials, $options, &$response)
	{
		$response->type = 'Joomla';
		// Joomla does not like blank passwords
		if (empty($credentials['password'])) {
			$response->status = JAuthentication::STATUS_FAILURE;
			$response->error_message = JText::_('JGLOBAL_AUTH_EMPTY_PASS_NOT_ALLOWED');
			return false;
		}

		// Initialise variables.
		$conditions = '';

		// Get a database object
		$db		= JFactory::getDbo();
		$query	= $db->getQuery(true);

		$query->select('id, password');
		$query->from('#__users');
		$query->where('email=' . $db->Quote($credentials['email']));

		$db->setQuery($query);
		$result = $db->loadObject();

		if ($result) {
			$parts	= explode(':', $result->password);
			$crypt	= $parts[0];
			$salt	= @$parts[1];
			$testcrypt = JUserHelper::getCryptedPassword($credentials['password'], $salt);

			if ($crypt == $testcrypt) {
				$user = JUser::getInstance($result->id); // Bring this in line with the rest of the system
				$response->email = $user->email;
                $response->username = $user->username;
				$response->fullname = $user->name;
				if (JFactory::getApplication()->isAdmin()) {
					$response->language = $user->getParam('admin_language');
				}
				else {
					$response->language = $user->getParam('language');
				}
				$response->status = JAuthentication::STATUS_SUCCESS;
				$response->error_message = '';
			} else {
				$response->status = JAuthentication::STATUS_FAILURE;
				$response->error_message = JText::_('JGLOBAL_AUTH_INVALID_PASS');
			}
		} else {
			$response->status = JAuthentication::STATUS_FAILURE;
			$response->error_message = JText::_('JGLOBAL_AUTH_NO_USER');
		}
	}
}
