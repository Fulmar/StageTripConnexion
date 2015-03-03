<?php
/**
 * @package		TpCx
 * @subpackage	mod_tpcx_slideshow
 * @author      Fabien Vautour
 */

// no direct access
defined('_JEXEC') or die;

class modTpcxSlideshowHelper
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
