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

<div id="newsletter">
    
    <a name="topnewsletter"></a>
    
    <div class="wrapper">
        <p class="title"><?php echo $params->get('title'); ?></p>
        
        <div class="container-box">
            <div class="box-left">
                <p class="subtitle"><?php echo $params->get('subtitle'); ?></p>
                <p id="txt-newsletter-confirm" class="confirm"></p>
                <form name="newseltter" method="post" action="#" onsubmit="insertNewsletter(); return false;">
                    <input type="hidden" name="provenance" id="provenance-newsletter" value="ABONNEMENT_NEWSLETTER" />
                    <p>
                        <label for="email-newsletter"><?php echo $params->get('labelnews'); ?></label>
                        <input type="text" name="email-newsletter" id="email-newsletter" value="" placeholder="Votre email" />
                        <button type="submit" class="submit"><span>ok</span></button>
                    </p>
                </form>
            </div>
            <?php if($params->get('link-twitter') || $params->get('link-facebook') || $params->get('link-pinterest') || $params->get('link-googleplus')): ?>
            <div class="box-right">
                <div class="social">
                    <p class="title">Suivez-nous sur les réseaux sociaux :</p>
                    <div class="container-box">
                        <?php if($params->get('link-twitter')): ?>
                        <a href="<?php echo $params->get('link-twitter'); ?>" target="_blank">
                            <img class="picto" src="<?php echo $baseurl . 'templates/' . $template . '/images/picto-twitter.gif'; ?>" alt="" />
                        </a>
                        <?php endif; ?>
                        <?php if($params->get('link-facebook')): ?>
                        <a href="<?php echo $params->get('link-facebook'); ?>" target="_blank">
                            <img class="picto" src="<?php echo $baseurl . 'templates/' . $template . '/images/picto-facebook.gif'; ?>" alt="" />
                        </a>
                        <?php endif; ?>
                        <?php if($params->get('link-pinterest')): ?>
                        <a href="<?php echo $params->get('link-pinterest'); ?>" target="_blank">
                            <img class="picto" src="<?php echo $baseurl . 'templates/' . $template . '/images/picto-pinterest.gif'; ?>" alt="" />
                        </a>
                        <?php endif; ?>
                        <?php if($params->get('link-googleplus')): ?>
                        <a href="<?php echo $params->get('link-googleplus'); ?>" target="_blank">
                            <img class="picto" src="<?php echo $baseurl . 'templates/' . $template . '/images/picto-googleplus.gif'; ?>" alt="" />
                        </a>
                        <?php endif; ?>
						<?php if($params->get('link-instagram')): ?>
                        <a href="<?php echo $params->get('link-instagram'); ?>" target="_blank">
                            <img class="picto" src="<?php echo $baseurl . 'templates/' . $template . '/images/picto-instagram.gif'; ?>" alt="" />
                        </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
        
    </div>
    
</div>
