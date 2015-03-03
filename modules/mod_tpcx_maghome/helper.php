<?php
/**
 * @package		TpCx
 * @subpackage	mod_tpcx_slideshow
 * @author      Fabien Vautour
 */

// no direct access
defined('_JEXEC') or die;

class modTpcxMaghomeHelper
{
	public static function getArticle(&$params)
    {
        $articlehighlight = $params->get('articlehighlight');
        
        // Get an instance of the generic articles model
        $model = JModelLegacy::getInstance('Article', 'ContentModel', array('ignore_request' => true));

        // Set application parameters in model
        $app = JFactory::getApplication();
        $appParams = $app->getParams();
        $model->setState('params', $appParams);
        
        $article = $model->getItem($articlehighlight);
        
        return $article;
        
    }
}
