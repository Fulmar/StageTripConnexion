<?php
/**
 * @package		Joomla.Site
 * @subpackage	com_content
 * @copyright	Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.helper');
jimport('joomla.application.categories');

JTable::addIncludePath(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_tpcxsocial'.DS.'tables');

/**
 * Content Component Route Helper
 *
 * @static
 * @package		Joomla.Site
 * @subpackage	com_content
 * @since 1.5
 */
abstract class TpcxsocialHelperRoute
{
    protected static $lookup;
    
	/**
     * Method to get the item ID of a link of Forum for get the suffixe class "social-page wide" 
     *
     * @param   array     $group_id
     * @return  mixed       Integer menu id on success, null on failure.
     * @since   1.6
     */
    public static function getItemIdSocial()
    {
        $link = 'index.php?option=com_tpcxsocial&view=topics';           
        $menu = JSite::getMenu();
        $menuItem = $menu->getItems( 'link', $link, true );
        $Itemid = $menuItem->id;
        
        return $Itemid;
    }
    
    /**
     * Method to get the item ID of a link of Forum for get the suffixe class "social-page" 
     *
     * @param   array     $group_id
     * @return  mixed       Integer menu id on success, null on failure.
     * @since   1.6
     */
    public static function getItemIdSocialTopic()
    {
        $link = 'index.php?option=com_tpcxsocial&view=posts';           
        $menu = JSite::getMenu();
        $menuItem = $menu->getItems( 'link', $link, true );
        $Itemid = $menuItem->id;
        
        return $Itemid;
    }
    
    /**
     * Get the forum home
     */
    public static function getRootForum()
    {
        $link = 'index.php?option=com_tpcxsocial&view=topics';
        
        $link .= '&Itemid=' . self::getItemIdSocial();
        
        return $link;
    }

    /*
     * Get the account URL
     */
    public function getAccountUrl()
    {
        $link = 'index.php?option=com_tpcxsocial&view=profile';     
        
        $link .= '&Itemid=' . self::getItemIdSocial();      
        
        return $link;
    }
    
    /**
     * @param   int The route of the category
     */
    public static function getCategoryRoute($catid = 0)
    {
        $app        = JFactory::getApplication();
        $menus      = $app->getMenu('site');
        
        $id = (int) $catid;
        
        $category = JTable::getInstance('Category', 'TpcxsocialTable');
        $category->load($id);
        
        if($id < 1)
        {
            $link = 'index.php?option=com_tpcxsocial&view=topics';
            
            $active = $menus->getActive();
            if ($active && $active->component == 'com_tpcxsocial') {
                $itemId = $active->id;
            }
            
            $link .= '&Itemid=' . $itemId;
        }
        else
        {

            $link = 'index.php?option=com_tpcxsocial&view=topics&id=' . $id;
            
            $itemId = self::getItemIdSocial();
            
            if($category)
            {
                $link .= '&Itemid=' . $itemId;
            }
        }

        return $link;
    }
    
    /**
     * @param   int The route of the topic
     */
    public static function getTopicRoute($topicid)
    {
        $app        = JFactory::getApplication();
        $menus      = $app->getMenu('site');
        
        $id = (int) $topicid;
        $topic = JTable::getInstance('Topic', 'TpcxsocialTable');
        $topic->load($id);
        
        if($id < 1)
        {
            $link = '';
        }
        else
        {

            //Create the link
            $link = 'index.php?option=com_tpcxsocial&view=posts&id=' . $id;
            
            $itemId = self::getItemIdSocialTopic();
            
            if($topic)
            {
                $link .= '&Itemid=' . $itemId;
            }
        }

        return $link;
    }
    
    /**
     * @param   int The route of the category
     */
    public static function getAddTopicRoute()
    {
        $app        = JFactory::getApplication();
        $menus      = $app->getMenu('site');

        //Create the link
        $link = 'index.php?option=com_tpcxsocial&view=topics&layout=add';
        
        $active = $menus->getActive();
        if ($active && $active->component == 'com_tpcxsocial') {
            $itemId = $active->id;
        }
        
        $link .= '&Itemid=' . $itemId;

        return $link;
    }
    
    /**
     * 
     */
    public static function getRegistrationRoute($params = null)
    {
        $app        = JFactory::getApplication();
        $menus      = $app->getMenu('site');

        //Create the link
        $link = 'index.php?option=com_tpcxsocial&view=registration';
        
        $active = $menus->getActive();
        if ($active && $active->component == 'com_tpcxsocial') {
            $itemId = $active->id;
        }
        
        $link .= '&Itemid=' . $itemId;
        
        if(!is_null($params) && is_array($params)) {
            foreach($params as $key => $value) {
                $link .= '&' . $key . '=' . $value;
            }
        }
        
        return $link;
    }
    
    /**
     * 
     */
    public static function getLoginRoute($params = null)
    {
        $app        = JFactory::getApplication();
        $menus      = $app->getMenu('site');

        //Create the link
        $link = 'index.php?option=com_tpcxsocial&view=login';
        
        $active = $menus->getActive();
        if ($active && $active->component == 'com_tpcxsocial') {
            $itemId = $active->id;
        }
        
        $link .= '&Itemid=' . $itemId;
        
        if(!is_null($params) && is_array($params)) {
            foreach($params as $key => $value) {
                $link .= '&' . $key . '=' . $value;
            }
        }
        
        return $link;
    }
}
