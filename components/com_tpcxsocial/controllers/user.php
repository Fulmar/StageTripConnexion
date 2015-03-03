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
class TpcxsocialControllerUser extends TpcxsocialController
{
    
    /**
     * Method to log in a user.
     *
     * @since   1.6
     */
    public function login()
    {
        JSession::checkToken('post') or jexit(JText::_('JInvalid_Token'));
        
        $response = array();
        $response['error'] = false;
        
        $app = JFactory::getApplication();

        // Populate the data array:
        $data = array();
        $data['return'] = base64_decode(JRequest::getVar('return', '', 'POST', 'BASE64'));
        $data['email'] = JRequest::getVar('email', '', 'method', 'email');
        $data['password'] = JRequest::getString('password', '', 'post', JREQUEST_ALLOWRAW);

        // Set the return URL if empty.
        if (empty($data['return'])) {
            $data['return'] = JRoute::_('index.php?option=com_tpcxsocial&view=profile');
        }

        // Set the return URL in the user state to allow modification by plugins
        $app->setUserState('users.login.form.return', $data['return']);

        // Get the log in options.
        $options = array();
        $options['remember'] = JRequest::getBool('remember', false);
        $options['return'] = $data['return'];

        // Get the log in credentials.
        $credentials = array();
        $credentials['email'] = $data['email'];
        $credentials['password'] = $data['password'];
        
        // Perform the log in.
        if (true === $app->login($credentials, $options)) {
            $user = JFactory::getUser();
            $response['user_id'] = $user->id;
        } else {
            $response['error'] = true;
            $response['errorMsg'] = 'Une erreur est survenue lors de l\'identificaion.';
        }
        
        header('Content-type: application/json');
        echo json_encode($response);
        
        $app->close();
    }

    public function like()
    {
        $app = JFactory::getApplication();
        $db = JFactory::getDbo();
        
        $topic_id = JRequest::getVar('topic_id');
        $user_id = JRequest::getVar('user_id');
        
        $db->getQuery(true);
        $query = 'UPDATE #__tpcxsocial_forum_topics SET rating = rating + 1 WHERE id = ' . $topic_id;
        $db->setQuery($query);
        $db->query();
        
        $db->getQuery(true);
        $query = 'INSERT INTO #__tpcxsocial_users_liked VALUE ("' . $user_id . '", "' . $topic_id . '")';
        $db->setQuery($query);
        $db->query();
        
        $db->getQuery(true);
        $query = 'SELECT rating FROM #__tpcxsocial_forum_topics WHERE id = ' . $topic_id;
        $db->setQuery($query);
        $db->query();
        $result = $db->loadObject();
        
        $response = array();
        $response['rating'] = $result->rating;
        
        header('Content-type: application/json');
        echo json_encode($response);
        
        $app->close();
    } 

    public function rate()
    {
        $app    = JFactory::getApplication();
        $db     = JFactory::getDbo();
        $user   = JFactory::getUser();
        $userId = (int) $user->get('id');
        
        $post_id = JRequest::getVar('idBox');
        $rate = JRequest::getVar('rate');
        
        $db->getQuery(true);
        $query = 'INSERT INTO #__tpcxsocial_users_rating VALUE ("", "' . $userId . '", "' . $post_id . '", "' . $rate . '")';
        $db->setQuery($query);
        $db->query();
        
        $db->getQuery(true);
        $query = 'SELECT AVG(rating) as average FROM #__tpcxsocial_users_rating WHERE post_id = ' . $post_id;
        $db->setQuery($query);
        $db->query();
        $result = $db->loadObject();
        
        $db->getQuery(true);
        $query = 'UPDATE #__tpcxsocial_forum_posts SET rating = "' . $result->average . '" WHERE id = ' . $post_id;
        $db->setQuery($query);
        $db->query();
        
        $app->close();
    } 

    public function getInfo()
    {
        $app = JFactory::getApplication();
        $db = JFactory::getDbo();
        
        $user_id = JRequest::getVar('user_id');
        $avatarWidth = JRequest::getVar('avatarWidth');
        $avatarHeight = JRequest::getVar('avatarHeight');
        
        $response = array();
        
        $avatar = TpcxsocialHelperUser::getAvatar($user_id, $avatarWidth, $avatarHeight);
        $group = TpcxsocialHelperUser::getGroup($user_id);
        
        $response['avatar'] = $avatar;
        $response['group'] = $group;
                
        header('Content-type: application/json');
        echo json_encode($response);
        
        $app->close();
    } 
    
}
