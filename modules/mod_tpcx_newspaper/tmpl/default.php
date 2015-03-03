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
$currentUrl = JURI::current();

$template = $app->getTemplate();

?>

<div id="newspaper">
    
    <div class="newspaper-bg-bottom"></div>
    
    <a name="topnewspaper"></a>
    
    <div class="wrapper" style="padding: 15px 0; border-left: 2px dashed #ffffff; border-right: 2px dashed #ffffff;">
        
        <div class="box-title clearfix">
            <div class="picto left"><img src="<?php echo $baseurl . 'templates/' . $template . '/images/newspaper-left-title.png'; ?>" alt="" /></div>
            <p class="text">
                <?php echo $params->get('title'); ?>
            </p>
            <div class="picto right"><img src="<?php echo $baseurl . 'templates/' . $template . '/images/newspaper-right-title.png'; ?>" alt="" /></div>
        </div>
        
        <div class="logo-newspaper clearfix">
            <div class="logo">
                <a href="<?php echo $params->get('link'); ?>">
                    <img src="<?php echo $baseurl . 'templates/' . $template . '/images/logo-virgin.png'; ?>" alt="" />
                </a>
            </div>
            <div class="logo">
                <a href="<?php echo $params->get('link'); ?>">
                    <img src="<?php echo $baseurl . 'templates/' . $template . '/images/logo-fr2.png'; ?>" alt="" />
                </a>
            </div>
            <div class="logo">
                <a href="<?php echo $params->get('link'); ?>">
                    <img src="<?php echo $baseurl . 'templates/' . $template . '/images/logo-grands-reportages.png'; ?>" alt="" />
                </a>
            </div>
            <div class="logo">
                <a href="<?php echo $params->get('link'); ?>">
                    <img src="<?php echo $baseurl . 'templates/' . $template . '/images/logo-m6.png'; ?>" alt="" />
                </a>
            </div>
            <div class="logo">
                <a href="<?php echo $params->get('link'); ?>">
                    <img src="<?php echo $baseurl . 'templates/' . $template . '/images/logo-france-info.png'; ?>" alt="" />
                </a>
            </div>
            <div class="logo">
                <a href="<?php echo $params->get('link'); ?>">
                    <img src="<?php echo $baseurl . 'templates/' . $template . '/images/logo-challenges.png'; ?>" alt="" />
                </a>
            </div>
            <div class="logo">
                <a href="<?php echo $params->get('link'); ?>">
                    <img src="<?php echo $baseurl . 'templates/' . $template . '/images/logo-20minutes.png'; ?>" alt="" />
                </a>
            </div>
            <div class="logo">
                <a href="<?php echo $params->get('link'); ?>">
                    <img src="<?php echo $baseurl . 'templates/' . $template . '/images/logo-direct-matin.png'; ?>" alt="" />
                </a>
            </div>
            <div class="logo">
                <a href="<?php echo $params->get('link'); ?>">
                    <img src="<?php echo $baseurl . 'templates/' . $template . '/images/logo-nrj.png'; ?>" alt="" />
                </a>
            </div>
            <div class="logo">
                <a href="<?php echo $params->get('link'); ?>">
                    <img src="<?php echo $baseurl . 'templates/' . $template . '/images/logo-metronews.png'; ?>" alt="" />
                </a>
            </div>
        </div>
        
    </div>
    
</div>
