<?php
/**
 * @package		Joomla.Site
 * @subpackage	com_users
 * @copyright	Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

JTable::addIncludePath(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_tpcxsocial'.DS.'tables');

/**
 * Function to build a Users URL route.
 *
 * @param	array	The array of query string values for which to build a route.
 * @return	array	The URL route with segments represented as an array.
 * @since	1.5
 */
function TpcxsocialBuildRoute(&$query)
{
    static $items;
    static $register;
    static $login;
    static $profile;
    
    $segments = array();
    
    // Get the relevant menu items if not loaded.
    if (empty($items)) {
        // Get all relevant menu items.
        $app    = JFactory::getApplication();
        $menu   = $app->getMenu();
        $items  = $menu->getItems('component', 'com_tpcxsocial');
        
        // Build an array of serialized query strings to menu item id mappings.
        for ($i = 0, $n = count($items); $i < $n; $i++) {
            // Check to see if we have found the login menu item.
            if (empty($login) && !empty($items[$i]->query['view']) && ($items[$i]->query['view'] == 'login')) {
                $login = $items[$i]->id;
            }

            // Check to see if we have found the registration menu item.
            if (empty($register) && !empty($items[$i]->query['view']) && ($items[$i]->query['view'] == 'registration')) {
                $register = $items[$i]->id;
            }

            // Check to see if we have found the profile menu item.
            if (empty($profile) && !empty($items[$i]->query['view']) && ($items[$i]->query['view'] == 'profile')) {
                $profile = $items[$i]->id;
            }
        }
    }

    if (!empty($query['view'])) {
        switch ($query['view']) {
            case 'login':
                if ($query['Itemid'] = $login) {
                    unset ($query['view']);
                }
                break;

            case 'registration':
                if ($query['Itemid'] = $register) {
                    unset ($query['view']);
                }
                break;

            case 'profile':
                if ($query['Itemid'] = $profile) {
                    unset ($query['view']);
                }
                break;  
            case 'categories':
                if(!is_null($query['id'])) {
                    $segments[] = 'f' . $query['id'] . '.html';
                }
                unset($query['view']);
                unset($query['id']);
                
                break;  

            case 'topics':
                
                unset($query['view']);
                
                break;   

            case 'posts':
                $db = JFactory::getDbo();
                
                $db = JFactory::getDbo();
                $aquery = $db->setQuery($db->getQuery(true)
                    ->select('alias')
                    ->from('#__tpcxsocial_forum_topics')
                    ->where('id='.(int)$query['id'])
                );
                $alias = $db->loadResult();
                $query['id'] = $query['id'].':'.$alias;
                
                $segments[] = 'posts';
                $segments[] = $query['id'];
                
                unset($query['id']);
                unset($query['view']);
                
                break;            

            default:
                if (!empty($query['view'])) {
                    $segments[] = $query['view'];
                }
                unset ($query['view']);
                
                if(isset($query['id'])) {
                    $segments[] = $query['id'];
                };
                unset( $query['id'] );
                
                break;
        }
    }
    
    return $segments;
}

/**
 * Function to parse a Users URL route.
 *
 * @param	array	The URL route with segments represented as an array.
 * @return	array	The array of variables to set in the request.
 * @since	1.5
 */
function TpcxsocialParseRoute($segments)
{
    $vars = array();
    
    if(count($segments) > 1) {
        $vars['view'] = 'posts';
        $id = explode( ':', $segments[1] );
        $vars['id'] = (int) $id[0];
    }
    
    return $vars;
}