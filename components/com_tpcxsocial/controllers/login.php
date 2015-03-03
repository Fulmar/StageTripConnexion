<?php
/**
 * @package		Joomla.Site
 * @subpackage	com_users
 * @copyright	Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

require_once JPATH_COMPONENT.'/controller.php';

jimport( 'joomla.application.module.helper' );

/**
 * Registration controller class for Users.
 *
 * @package		Joomla.Site
 * @subpackage	com_users
 * @since		1.6
 */
class TpcxsocialControllerLogin extends TpcxsocialController
{
    
    /**
     * Method to display registration in modal
     *
     * @since   1.6
     */
    public function displayAjax($tpl = null)
    {
        $app    = JFactory::getApplication('site');
        
        // Display the view
        parent::display($tpl);
        
        $app->close();
    }

    /**
     * Method to log out a user.
     *
     * @since   1.6
     */
    public function logout()
    {
        $app = JFactory::getApplication();

        // Perform the log in.
        $error = $app->logout();

        // Check if the log out succeeded.
        if (!($error instanceof Exception)) {
            // Get the return url from the request and validate that it is internal.
            $return = JRequest::getVar('return', '', 'method', 'base64');
            $return = base64_decode($return);
            if (!JURI::isInternal($return)) {
                $return = '';
            }

            // Redirect the user.
            $app->redirect(JRoute::_($return, false));
        } else {
            $app->redirect(JRoute::_(TpcxsocialHelperRoute::getRootForum()));
        }
    }
    
    /*
     * Save an user when he is register
     */
    public function saveUserFb()
    {   
        $app    = JFactory::getApplication('site');
        
        $data = $_POST;
        
        $userEmail = TpcxsocialHelperUser::getUserId($data['email']);
        if((int)$userEmail > 0) {
            $app->close();
        }
        
        $return = TpcxsocialHelperUser::saveUser($data, 'fb');
        
        $app->close();
    }
    
    /*
     * Reload the content of the header login when the user is connected with facebook
     * Not automatically load with PHP, make with JS
     */
    public function loginFb()
    {
        $app    = JFactory::getApplication('site');
        
        // Register the needed session variables
        $session = JFactory::getSession();
        
        $usertpcx = TpcxsocialHelperUser::getUser();
        
        $instance = new JUser($usertpcx->id);
        $session->set('user', $instance);
        
        $module = JModuleHelper::getModule('mod_tpcxsocial');
        echo JModuleHelper::renderModule($module);
        
        $app->close();
    }
    
    /*
     * Reload the content of the header login when the user is connected
     * 
     */
    public function login()
    {
        $app    = JFactory::getApplication('site');
        
        $params = JComponentHelper::getParams('com_tpcxsocial');
        $group_default = $params->get('group_default');
        
        $user = new JUser(JRequest::getVar('user_id'));
        
        // Import the user plugin group.
        JPluginHelper::importPlugin('user');
        
        $options = array();
        // Set the access control action to check.
        $options['action'] = 'core.login.site';
        
        // OK, get login in session
        $dispatcher = JDispatcher::getInstance();
        $results = $dispatcher->trigger('onUserLogin', array((array) $user, $options));
        
        $module = JModuleHelper::getModule('mod_tpcxsocial');
        echo JModuleHelper::renderModule($module);
        
        $app->close();
    }
}
