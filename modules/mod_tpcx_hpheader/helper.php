<?php
/**
 * @version		$Id: helper.php 21995 2011-08-22 05:21:50Z infograf768 $
 * @package		Joomla.Site
 * @subpackage	mod_articles_news
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.model');

abstract class modTpcxHpheaderHelper
{
	public static function getList(&$params, $tag)
    {
        // Get the dbo
        $db = JFactory::getDbo();
        
        $query = $db->getQuery(true);
        
        $query->select('id, tag, category');
        $query->from('#__tpcxtags');
        $query->where('category = "' . $tag . '"');
        $query->where('published = 1');
        $query->order('tag ASC');
        
        $db->setQuery($query);

        $items = $db->loadObjectList();
        
        return $items; 
    }
}
