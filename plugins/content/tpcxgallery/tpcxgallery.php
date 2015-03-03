<?php
/**
 * @package     Joomla.Site
 * @subpackage  plg_content_tpcxtag
 * @copyright   Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('JPATH_BASE') or die;

jimport('joomla.utilities.date');

/**
 * An example custom profile plugin.
 *
 * @package     Joomla.Plugin
 * @subpackage  User.profile
 * @version     1.6
 */
class plgContentTpcxgallery extends JPlugin
{
    /**
     * Constructor
     *
     * @access      protected
     * @param       object  $subject The object to observe
     * @param       array   $config  An array that holds the plugin configuration
     * @since       2.5
     */
    public function __construct(& $subject, $config)
    {
        parent::__construct($subject, $config);
        $this->loadLanguage();
    }

    /**
     * @param   string  $context    The context for the data
     * @param   int     $data       The user id
     * @param   object
     *
     * @return  boolean
     * @since   2.5
     */
    function onContentPrepareData($context, $data)
    {
        // checking
        $document = JFactory::getDocument();   
        
        $app = JFactory::getApplication();
        if ($app->isAdmin())
            return;
        
        if($document->getType() != 'html') {
            return;
        }
        
        if ( !isset($data->fulltext) || !preg_match("#{gallery}(.*?){/gallery}#s", $data->fulltext) ) {
            return;
        }
        
        if( preg_match_all("#{gallery}(.*?){/gallery}#s", $data->fulltext, $matches, PREG_PATTERN_ORDER) > 0) {
            
            $result = array();
            
            $folder = $matches[1][0];
            
            $i = 0;
            if ($handle = opendir(JPATH_BASE . '/images/' . $folder)) {
                while (false !== ($entry = readdir($handle))) {
                    if ($entry != "." && $entry != ".." && $entry != "index.html" && $entry != "vignettes") {
                        $result[$i]['visuel'] = JURI::base() . 'images/' . $folder . '/' . $entry;
                        
                        // vignette
                        $folderVignette = JURI::base() . 'images/' . $folder;
                        if(is_dir(JPATH_BASE . '/images/' . $folder . '/vignettes/')
                            && file_exists(JPATH_BASE . '/images/' . $folder . '/vignettes/' . $entry) ) {
                            $folderVignette = JURI::base() . 'images/' . $folder . '/vignettes/';
                            $result[$i]['vignette'] = JURI::base() . 'images/' . $folder . '/vignettes/' . $entry;
                        }
                        $result[$i]['vignette'] = $folderVignette . '/' . $entry;
                        
                        $i++;
                    }
                }
                closedir($handle);
            }

            $gallery = '<div class="gallery-article">';
            $gallery .= '<div class="container-box">';
            foreach($result as $image):
                $gallery .= '<div class="box-left">';
                $gallery .= '<a class="fancybox" rel="gallery1" href="' . $image['visuel'] . '">';
                //$gallery .= '<img src="' . $image['vignette'] . '" width="120" height="" alt="" />';
				$gallery .= '<img src="' . JURI::base() . 'timthumb.php?src=' . $image['vignette'] . '&w=120&h=80" width="120" height="80" alt="" />';
                $gallery .= '</a>';
                $gallery .= '</div>';
            endforeach;
            $gallery .= '</div>';
            $gallery .= '</div>';

            $data->fulltext = preg_replace("#{gallery}" . $folder . "{/gallery}#s", $gallery, $data->fulltext);
            
        }
        
        return true;
    }
    
}
