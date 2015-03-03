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
class TpcxsocialControllerPost extends TpcxsocialController
{
    
    /**
     * Method to save a topic data.
     *
     * @return  void
     * @since   1.6
     */
    public function save()
    {
        // Initialise variables.
        $app    = JFactory::getApplication();
        $model  = $this->getModel('Post', 'TpcxsocialModel');
        $user   = JFactory::getUser();
        $userId = (int) $user->get('id');
        
        // Get the user data.
        $data = JRequest::getVar('jform', array(), 'post', 'array');
        
        $response = array();
        $response['error'] = false;
        
        // Check for request forgeries.
        if(!JSession::checkToken()) {
            $response['error'] = true;
            $response['errorMsg'] = 'Une erreur est survenue. Veuillez recommencez.';
            
            header('Content-type: application/json');
            echo json_encode($response);
            $app->close();
        }
        
        // Attempt to save the data.
        $return = $model->save($data);
        
        // Check for errors.
        if ($return === false) {
            $response['error'] = true;
            $response['errorMsg'] = 'Une erreur est survenue. Veuillez recommencez.';
            
            header('Content-type: application/json');
            echo json_encode($response);
            $app->close();
        }
        
        header('Content-type: application/json');
        echo json_encode($response);
        
        $app->close();
    }

    /**
     * Method to load the posts of the topic
     *
     * @return  void
     * @since   1.6
     */
    public function load()
    {
        $app    = JFactory::getApplication();
        
        // Display the view
        parent::display($tpl);
        
        $app->close();
    }
    
}
