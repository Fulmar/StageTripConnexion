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

require_once JPATH_SITE.'/components/com_content/helpers/route.php';

abstract class modTpcxPushHelper
{
	public static function getLink($id)
	{
        $db = &JFactory::getDBO();
        
        $db->setQuery('SELECT id, catid FROM #__content WHERE id = "' . $id . '"');
        $row = $db->loadObject();
        
        return JRoute::_(ContentHelperRoute::getArticleRoute($row->id, $row->catid));       
	}
    
    public static function getTitle($id)
    {
        $article =& JTable::getInstance("content");
        $article->load($id);
        
        return $article->get("title");
    }
    
    public static function getContent($id)
    {
        $article =& JTable::getInstance("content");
        $article->load($id);
        
        return $article->get("fulltext");
    }
}
