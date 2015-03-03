<?php
/**
 * @package		TpCx
 * @subpackage	mod_tpcx_slideshow
 * @author      Fabien Vautour
 */

// no direct access
defined('_JEXEC') or die;

class modTpcxTravelprojectHelper
{
	public static function getListTags(&$params, $tag)
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
    
    public function getUrlRedirection(&$params)
    {
        $application = JFactory::getApplication();
        $menu = $application->getMenu();
        $item = $menu->getItem($params->get("url_redirection"));
        
        return $item->alias;
    }
    
    public function getUrlAction(&$params)
    {
        $uri = JURI::base() . 'index.php?option=com_tpcxtags';
        
        $url = JURI::getInstance($uri);
        
        $url->setVar('task', 'sendFormTravel');
        
        return $url;
    }
}
