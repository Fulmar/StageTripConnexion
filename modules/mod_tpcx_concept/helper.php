<?php
/**
 * @package		TpCx
 * @subpackage	mod_tpcx_concept
 * @author      Florent Fulmar
 */

// no direct access
defined('_JEXEC') or die;

class modTpcxConceptHelper
{
	public static function getList(&$params, $tag)
    {
        // Get the dbo
        $db = JFactory::getDbo();
        
        $query = $db->getQuery(true);
        
        $query->select('t.id, t.tag, t.category');
        $query->from('#__tpcxtags as t');
        $query->join('INNER', '#__user_profiles as u ON u.profile_value LIKE CONCAT(\'%"\', t.id ,\'"%\')');
        $query->join('INNER', '#__content AS c ON u.user_id = c.id');
        $query->where('category = "' . $tag . '"');
        $query->where('published = 1');
        $query->where('catid = 9');
        $query->group('t.id');
        $query->order('tag ASC');

        $db->setQuery($query);

        $items = $db->loadObjectList();
        
        return $items; 
    }
    
    public function getUrlConcept(&$params)
    {
        // app
        $app    = JFactory::getApplication();
        $menu   = $app->getMenu();
        $item   = $menu->getItem($params->get('conceptlink'));
        
        return JURI::base() . $item;
    }
}
