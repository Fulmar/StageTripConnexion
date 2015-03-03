<?php
/**
 * @package		Joomla.Site
 * @subpackage	com_users
 * @copyright	Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

JTable::addIncludePath(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_tpcxsocial'.DS.'tables');
require_once JPATH_SITE.'/components/com_tpcxsocial/fb-sdk/facebook.php';

/**
 * Users Route Helper
 *
 * @package		Joomla.Site
 * @subpackage	com_users
 * @since		1.6
 */
class TpcxsocialHelperUser
{
	
    /*
     * Return a user id by email
     * 
     * @param   string  $email
     */
    public static function getUserId($facebook_id)
    {
        $db     = JFactory::getDbo();
        $query = "SELECT user_id FROM #__tpcxsocial_users WHERE facebook_id='" . $facebook_id . "';";
        $db->setQuery($query);
        $user_id = $db->loadResult();
        
        return $user_id;
    }
    
    /*
     * Return a user based on Joomla and Social data
     * 
     * @param   string  $email
     */
    public static function getUser()
    {
        // get user facebook
        $facebook = self::getFacebookInstance();
        $userFB = $facebook->getUser();
        
        if($userFB) {
          try {
            // Proceed knowing you have a logged in user who's authenticated.
            $user_profile = $facebook->api('/me');
            $userId = self::getUserId($userFB);
            
          } catch (FacebookApiException $e) {
            error_log($e);
            $userFB = null;
          }
        }
        
        if(!$userId) {
            // user logged in joomla
            // return user in session
            $user = JFactory::getUser();
            
            // Get the dispatcher and load the users plugins.
            $dispatcher = JDispatcher::getInstance();
            JPluginHelper::importPlugin('user');
    
            // Trigger the data preparation event.
            $results = $dispatcher->trigger('onContentPrepareData', array('com_users.profile', $user));
            
            return $user;
        }
        
        $user = self::getUserTpcx($userId);
        
        return $user;
    }
    
    /*
     * Retrieve the group of the user
     * 
     * @return  int     $group_id 
     */
    public static function getGroup($user)
    {
        if(!is_object($user)) {
            $user = self::getUserTpcx($user);
        }
        
        foreach($user->groups as $key => $value) {
            $group = $value;
        }
        
        return $group;
    }

    /*
     * Check if an user is logged with FB, G+ or Joomla
     * 
     * @return  boolean     TRUE if succcess. FALSE otherwise 
     */
    public static function isLogged()
    {
        $isLogged = true;
        
        $user = self::getUser();
        
        if($user->guest == 1) {
            $isLogged = false;
        }
        
        return $isLogged;
    }
    
    /*
     * Retrieve the avatar of the user
     * 
     * @return  string  $avatar 
     */
    public static function getAvatar($userId, $width = 100, $height = 100)
    {
        $avatar = '';
        
        $user = self::getUserTpcx($userId);
        
        if($user->login_facebook == 1) {
            $avatar = "https://graph.facebook.com/" . $user->facebook_id . "/picture?type=square&width=" . $width . "&height=" . $height;
        }
        
        if(!empty($user->avatar)) {
            $avatar = $user->avatar;
        }
        
        if(empty($avatar)) {
            $avatar = JURI::base() . 'components/com_tpcxsocial/template/images/avatar-generic.jpg';
        }
        
        return $avatar;
    }
    
    /*
     * Retrieve the link logout if the user is logged in facebook, joomla, ...
     * 
     * @return  array  $linkLogout 
     */
    public function getLogoutLink($userId)
    {
        $linkLogout = array();
        
        $user = self::getUser();
        
        $linkLogout['href'] = 'index.php?option=com_tpcxsocial&task=login.logout&return=' . base64_encode(JRoute::_(TpcxsocialHelperRoute::getRootForum()));
        $linkLogout['onclick'] = ''; 
        
        if($user->login_facebook == 1) {
            $linkLogout['href'] = 'javascript:void(0)';
            $linkLogout['onclick'] = 'fb_logout()';
        }
        
        return $linkLogout;
    }
    
    /*
     * Return a user tpcx
     * 
     * @param   string  $email
     */
    public static function getUserTpcx($id = null)
    {
        $userTpcx = JTable::getInstance('Usertpcx', 'TpcxsocialTable');
        $userTpcx->load($id);
        $user = $userTpcx->getProperties();
        
        return (object)$user;
    }
    
    /*
     * Get User Facebook
     */
    public static function getFacebookInstance()
    {
        $params = JComponentHelper::getParams('com_tpcxsocial');
        $app_id = $params->get('fb_app_id');
        $secret_key = $params->get('fb_secret_key');
        $config = array(
            'appId' => $app_id,
            'secret' => $secret_key,
            'fileUpload' => false, // optional
            'allowSignedRequest' => false, // optional, but should be set to false for non-canvas apps
        );
        
        $facebook = new Facebook($config);
        
        return $facebook;
    }
    
    /*
     * Save an user if he is not register with facebook
     */
    public static function saveUser($data_entry, $type = null)
    {
        JModel::addIncludePath(JPATH_SITE . '/components/com_tpcxsocial/models/');
        $model = JModel::getInstance('Registration', 'TpcxsocialModel'); 
        
        $params = JComponentHelper::getParams('com_tpcxsocial');
        $group_default = $params->get('group_default');
        
        $data = $data_entry;
        
        if($type == 'fb') {
            $data = array();
            $data['name']               = $data_entry['last_name'];
            $data['username']           = $data_entry['username'];
            $data['firstname']          = $data_entry['first_name'];
            $data['email']              = $data_entry['email'];
            if(empty($data['email'] )) {
                $data['email'] = $data['username'] . '@facebook.com';
            }
            
            $data['login_facebook']     = 1;
            $data['facebook_id']        = $data_entry['id'];
            
            $data['groups'][] = $group_default;
        
        }
        
        $return = $model->register($data);

        return $return;
    }
    
    /*
     * Get group name
     */
    public static function getGroupName($group_id)
    {
        $db = JFactory::getDbo();
        $db->setQuery(
            'SELECT `title`' .
            ' FROM `#__usergroups`' .
            ' WHERE `id` = '. (int) $group_id
        );
        $groupName = $db->loadResult();
        
        return $groupName;
    }
    
    /*
     * Get if user liked the topic
     */
    public static function getLikedTopic($user_id, $topic_id)
    {
        $db = JFactory::getDbo();
        $db->setQuery(
            'SELECT count(*) as total' .
            ' FROM `#__tpcxsocial_users_liked`' .
            ' WHERE `user_id` = '. (int) $user_id .
            ' AND `topic_id` = '. (int) $topic_id
        );
        
        $result = $db->loadObject();
        
        if($result->total > 0) {
            return true;
        }
        
        return false;
    }
    
    /*
     * Get if user liked the topic
     */
    public static function getRatingPost($user_id, $post_id)
    {
        $db = JFactory::getDbo();
        $db->setQuery(
            'SELECT rating' .
            ' FROM `#__tpcxsocial_users_rating`' .
            ' WHERE `user_id` = '. (int) $user_id .
            ' AND `post_id` = '. (int) $post_id
        );
        
        $result = $db->loadObject();
        
        if($result->rating > 0) {
            return $result->rating;
        }
        
        return false;
    }
}
