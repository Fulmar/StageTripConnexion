<?php
/**
 * @package     TpCx
 * @subpackage  mod_tpcx_slideshow
 * @author      Fabien Vautour
 */

// no direct access
defined('_JEXEC') or die ;

$app = JFactory::getApplication();
$baseurl = JURI::base();

?>

<div class="custompushblanc">
    <p class="titre-push"><?php echo $params->get('title'); ?></p>
    
    <?php if($galery): ?>
        
        <div class="container-box">
        <?php foreach($galery as $image): ?>
            <div class="box-left">
                <a class="fancybox" rel="gallery1" href="<?php echo $image['visuel']; ?>">
                    <img src="<?php echo $baseurl . 'timthumb.php?src=' . $image['vignette'] . '&w=113&h=75'; ?>" width="113" height="75" alt="" />
                </a>
            </div>
        <?php endforeach; ?>
        </div>
        
    <?php endif; ?>
    
    <?php if($params->get('content')): ?>
        <p><?php echo $params->get('content'); ?></p>
    <?php endif; ?>
    
    <?php if($params->get('link')): ?>
        <p><a href="<?php echo $params->get('link'); ?>">Lire la suite -></a></p>
    <?php endif; ?>
    
</div>
