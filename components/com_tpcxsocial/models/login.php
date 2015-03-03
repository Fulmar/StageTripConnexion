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
class TpcxsocialModelLogin extends JModelForm
{
    
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
        $form = $this->loadForm('com_tpcxsocial.login', 'login', array('load_data' => $loadData));
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
        // Check the session for previously entered login form data.
        $app    = JFactory::getApplication();
        $data   = $app->getUserState('users.login.form.data', array());

        // check for return URL from the request first
        if ($return = JRequest::getVar('return', '', 'method', 'base64')) {
            $data['return'] = base64_decode($return);
            if (!JURI::isInternal($data['return'])) {
                $data['return'] = '';
            }
        }

        // Set the return URL if empty.
        if (!isset($data['return']) || empty($data['return'])) {
            $data['return'] = JRoute::_('index.php?option=com_tpcxsocial&view=profile');
        }
        $app->setUserState('users.login.form.data', $data);

        return $data;
    }
}
