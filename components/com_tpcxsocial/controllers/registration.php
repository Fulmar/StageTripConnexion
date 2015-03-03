<?php
/**
 * @package		Joomla.Site
 * @subpackage	com_users
 * @copyright	Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

require_once JPATH_COMPONENT.'/controller.php';

/**
 * Registration controller class for Users.
 *
 * @package		Joomla.Site
 * @subpackage	com_users
 * @since		1.6
 */
class TpcxsocialControllerRegistration extends TpcxsocialController
{
    
    /**
     * Method to activate a user.
     *
     * @return  boolean     True on success, false on failure.
     * @since   1.6
     */
    public function activate()
    {
        $user       = JFactory::getUser();
        $uParams    = JComponentHelper::getParams('com_users');

        // If the user is logged in, return them back to the homepage.
        if ($user->get('id')) {
            $this->setRedirect('index.php');
            return true;
        }

        // If user registration or account activation is disabled, throw a 403.
        if ($uParams->get('useractivation') == 0 || $uParams->get('allowUserRegistration') == 0) {
            JError::raiseError(403, JText::_('JLIB_APPLICATION_ERROR_ACCESS_FORBIDDEN'));
            return false;
        }
        
        JModel::addIncludePath(JPATH_ROOT . '/components/com_users/models/');
        $model = $this->getModel($name = 'Registration', $prefix = 'UsersModel');
        
        $token = JRequest::getVar('token', null, 'request', 'alnum');

        // Check that the token is in a valid format.
        if ($token === null || strlen($token) !== 32) {
            JError::raiseError(403, JText::_('JINVALID_TOKEN'));
            return false;
        }

        // Attempt to activate the user.
        $return = $model->activate($token);

        // Check for errors.
        if ($return === false) {
            // Redirect back to the homepage.
            $this->setMessage(JText::sprintf('COM_TPCXSOCIAL_REGISTRATION_SAVE_FAILED', $model->getError()), 'warning');
            $this->setRedirect('index.php');
            return false;
        }

        $useractivation = $uParams->get('useractivation');

        // Redirect to the login screen.
        if ($useractivation == 0)
        {
            $this->setMessage(JText::_('COM_TPCXSOCIAL_REGISTRATION_SAVE_SUCCESS'));
            $this->setRedirect(JRoute::_('index.php?option=com_tpcxsocial&view=login', false));
        }
        elseif ($useractivation == 1)
        {
            $this->setMessage(JText::_('COM_TPCXSOCIAL_REGISTRATION_ACTIVATE_SUCCESS'));
            $this->setRedirect(JRoute::_('index.php?option=com_tpcxsocial&view=login', false));
        }
        elseif ($return->getParam('activate'))
        {
            $this->setMessage(JText::_('COM_TPCXSOCIAL_REGISTRATION_VERIFY_SUCCESS'));
            $this->setRedirect(JRoute::_('index.php?option=com_tpcxsocial&view=registration&layout=complete', false));
        }
        else
        {
            $this->setMessage(JText::_('COM_TPCXSOCIAL_REGISTRATION_ADMINACTIVATE_SUCCESS'));
            $this->setRedirect(JRoute::_('index.php?option=com_tpcxsocial&view=registration&layout=complete', false));
        }
        return true;
    }
    
    /**
     * Method to register a user.
     *
     * @return  boolean     True on success, false on failure.
     * @since   1.6
     */
    public function register()
    {
        // Check for request forgeries.
        JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

        // Initialise variables.
        $app    = JFactory::getApplication();
        $model  = $this->getModel('Registration', 'TpcxsocialModel');
        
        $response = array();
        $response['error'] = false;

        // Get the user data.
        $requestData = JRequest::getVar('jform', array(), 'post', 'array');

        // Validate the posted data.
        $form   = $model->getForm();
        if (!$form) {
            JError::raiseError(500, $model->getError());
            return false;
        }
        $data   = $model->validate($form, $requestData);
    
        // Check for validation errors.
        if ($data === false) {
            // Get the validation messages.
            $errors = $model->getErrors();
            
            $errorArr = array();
            // Push up to three validation messages out to the user.
            for ($i = 0, $n = count($errors); $i < $n && $i < 3; $i++) {
                if ($errors[$i] instanceof Exception) {
                    $errorArr[] = $errors[$i]->getMessage();
                } else {
                    $errorArr[] = $errors[$i];
                }
            }
            
            $errorArr = implode("<br />", $errorArr);
            
            // Save the data in the session.
            $app->setUserState('com_tpcxsocial.registration.data', $requestData);

            // show messages
            $response['error'] = true;
            $response['errorMsg'] = $errorArr;
            
            header('Content-type: application/json');
            echo json_encode($response);
        
            $app->close();
            return false;
        }

        // Attempt to save the data.
        $return = $model->register($data);

        // Check for errors.
        if ($return === false) {
            // Save the data in the session.
            $app->setUserState('com_tpcxsocial.registration.data', $data);

            // show messages
            $response['error'] = true;
            $response['errorMsg'] = $model->getError();
            
            header('Content-type: application/json');
            echo json_encode($response);
        
            $app->close();
            return false;
        }

        // Flush the data from the session.
        $app->setUserState('com_tpcxsocial.registration.data', null);
        
        if($return > 0) {
            $response['user_id'] = $return;
        } else {
            $response['error'] = !$return;
        }
        
        header('Content-type: application/json');
        echo json_encode($response);
        
        $app->close();

        return true;
    }
}