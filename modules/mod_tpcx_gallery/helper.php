<?php
/**
 * @package		TpCx
 * @subpackage	mod_tpcx_slideshow
 * @author      Fabien Vautour
 */

// no direct access
defined('_JEXEC') or die;

class modTpcxGalleryHelper
{
	public function getGalery($params)
    {
        
        if($params->get('mediafolder') == '')
            return array();
        
        $result = array();
        
        $i = 0;
        if ($handle = opendir(JPATH_BASE . '/images/' . $params->get('mediafolder'))) {
            while (false !== ($entry = readdir($handle))) {
                if ($entry != "." && $entry != ".." && $entry != "index.html" && $entry != "vignettes") {
                    $result[$i]['visuel'] = JURI::base() . 'images/' . $params->get('mediafolder') . $entry;
                    
                    // vignette
                    $folderVignette = JURI::base() . 'images/' . $params->get('mediafolder');
                    if(is_dir(JPATH_BASE . '/images/' . $params->get('mediafolder') . 'vignettes/')
                        && file_exists(JPATH_BASE . '/images/' . $params->get('mediafolder') . 'vignettes/' . $entry) ) {
                        $folderVignette = JURI::base() . 'images/' . $params->get('mediafolder') . 'vignettes/';
                        $result[$i]['vignette'] = JURI::base() . 'images/' . $params->get('mediafolder') . 'vignettes/' . $entry;
                    }
                    $result[$i]['vignette'] = $folderVignette . $entry;
                    
                    $i++;
                }
            }
            closedir($handle);
        }

        return $result;
        
    }
}
