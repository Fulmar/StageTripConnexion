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
 * Users Route Helper
 *
 * @package		Joomla.Site
 * @subpackage	com_users
 * @since		1.6
 */
class TpcxsocialHelperTpcxsocial
{
	
	/**
	 * Method to get the name of the group id
	 *
     * @param   array     $group_id
	 * @return	mixed		Integer menu id on success, null on failure.
	 * @since	1.6
	 */
	public static function getGroupName($group_id)
	{
	    $group = array_values($group_id);
        $group = $group[0];
	    
        $db = JFactory::getDbo();
        $db->setQuery(
            'SELECT `title`' .
            ' FROM `#__usergroups`' .
            ' WHERE `id` = '. (int) $group
        );
        $result = $db->loadObject();
        
        return $result->title;
	}
    
    /**
     * Method to get the breadcrumbs of the forum
     *
     * @return  array       list of items
     * @since   1.6
     */
    public static function getBreadcrumbs($category_id, $lastLink = false)
    {
        $category = JTable::getInstance('Category', 'TpcxsocialTable');
        $path = $category->getPath($category_id);
        
        $results = array();
        
        foreach($path as $key => $item) {
            if($item->level > 0) {
                $results[$key] = $item;
                $results[$key]->link = JRoute::_(TpcxsocialHelperRoute::getCategoryRoute($item->id));
            }
        }
        
        $html = array();
        $html[] = '<div class="breadcrumbs">' . "\n";
        $html[] = '<span class="title">' . "\n";
        $html[] = '<a href="' . JRoute::_(TpcxsocialHelperRoute::getRootForum()) . '">Forum de voyage</a>' . "\n";
        $html[] = '</span>' . "\n";
        
        $i = 1;
        foreach($results as $link) {
            $html[] = ' > ';
            if($i < count($results) || $lastLink) {
                $html[] = '<a href="' . $link->link . '">';   
            }
            
            $html[] = '<span>' . $link->title . '</span>';
            
            if($i < count($results) || $lastLink) {
                $html[] = '</a>' . "\n";
            }
            $i++;
        }
        
        $html[] = '</div>' . "\n";
        
        $html = implode('', $html);
        
        return $html;
    }
    
    /**
     * Method to get the breadcrumbs of the account
     *
     * @return  array       list of items
     * @since   1.6
     */
    public static function getBreadcrumbsAccount($lastLink = null)
    {
        $app        = JFactory::getApplication();       
        $menus      = $app->getMenu('site');
        
        $html = array();
        $html[] = '<div class="breadcrumbs">' . "\n";
        $html[] = '<span class="title">' . "\n";
        $html[] = '<a href="' . JRoute::_(TpcxsocialHelperRoute::getAccountUrl()) . '">Mon espace</a>' . "\n";
        $html[] = '</span>' . "\n";
        
        if(!is_null($lastLink)) {
            $html[] = ' > ';
            $html[] = '<span>' . $lastLink . '</span>';
        }
        
        $html[] = '</div>' . "\n";
        
        $html = implode('', $html);
        
        return $html;
    }

    /**
     * Method to get the filters array
     *
     * @return  array   array of filters
     */
    public static function getFilters()
    {
        $filters = array();
        $availables_filters = array(
            't.subject' => 'ordre alphabétique',
            't.created' => 'les plus récent',
            //'t.ordering' => 'ordre d\'affichage'
        );
        
        $orderCol   = JRequest::getCmd('filter_order', 't.created');
        
        $i = 0;
        foreach($availables_filters as $value => $name) {
            $filters[$i]['name'] = $name;
            $filters[$i]['value'] = $value;
            if($orderCol == $value) {
                $filters[$i]['selected'] = true;
            }
            
            $i++;
        }
        
        return $filters;
    }

    /**
     * Method to get the filters array
     *
     * @return  array   array of filters
     */
    public static function getFiltersPosts()
    {
        $filters = array();
        $availables_filters = array(
            'p.rating' => 'les mieux notées',
            'p.created' => 'les plus récent',
            //'t.ordering' => 'ordre d\'affichage'
        );
        
        $orderCol   = JRequest::getCmd('filter_order', 'p.created');
        
        $i = 0;
        foreach($availables_filters as $value => $name) {
            $filters[$i]['name'] = $name;
            $filters[$i]['value'] = $value;
            if($orderCol == $value) {
                $filters[$i]['selected'] = true;
            }
            
            $i++;
        }
        
        return $filters;
    }
    
    public static function getPathImage()
    {
        return JURI::base() . 'components/com_tpcxsocial/template/images/';
    }
    
    /*
     * Get tags
     */
    public static function getTags($term = null)
    {
        $db = JFactory::getDbo();
        
        $query = $db->getQuery(true);
        
        $query->select('id, title, CONCAT("t", id) as id_generic');
        $query->from('#__tpcxsocial_forum_tags');
        
        if(!is_null($term)) {
            $query->where('title LIKE "%' . $term . '%"');
        }
        
        $db->setQuery($query);
        $result = $db->loadObjectList();
        
        return $result;
    }
    
    /*
     * Get tags
     */
    public static function getCategories($term = null, $level = 3)
    {
        $db = JFactory::getDbo();
        
        $query = $db->getQuery(true);
        
        $query->select('id, title, CONCAT("c", id) as id_generic');
        $query->from('#__tpcxsocial_forum_categories');
        
        $query->where('level = ' . $level);
        
        if(!is_null($term)) {
            $query->where('title LIKE "%' . $term . '%"');
        }
        
        $db->setQuery($query);
        $result = $db->loadObjectList();
        
        return $result;
    }
}
