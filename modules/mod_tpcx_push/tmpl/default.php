<?php

/**
 * Template Tpcx 
 *
 * @author Fabien Vautour 
 */

// no direct access
defined('_JEXEC') or die;

?>
<div class="push-bottom" style="display: none;">
    <div class="closebox">
        <a href="" class="btn-close">
            <img src="<?php echo JURI::base(); ?>media/system/images/modal/closebox.png" alt="Fermer" />
        </a>
    </div>
    
    <?php if($show_link == 'modal'): ?>
       
        <?php if($type_link == 'source'): ?>
            <a href="<?php echo $link; ?>" class="various fancybox.iframe">
        <?php else: ?>
            <div id="inline-push" style="display: none;">
                <?php
                    $titleArticle = modTpcxPushHelper::getTitle($link_article);
                    $contentArticle = modTpcxPushHelper::getContent($link_article);
                ?>
                <h1 class="title-annuaire"><?php echo $titleArticle; ?></h1>
                <div class="item-page">
                    <?php echo $contentArticle; ?>
                </div>
            </div>
            <a href="#inline-push" class="various">
        <?php endif; ?>    
    <?php else: ?>
        <a href="<?php echo $link; ?>" target="<?php echo $target_link; ?>">    
    <?php endif; ?>
        <img src="<?php echo $image; ?>" />
    </a>
</div>
<script>
    showPush = false;
    $(document).ready(function() {
        $('.push-bottom .btn-close').click(function() {
            event.preventDefault();
            $('.push-bottom').hide();
        });
    });
    $(window).load(function(){
		currentWidth = Response.viewportW();
		if(currentWidth > 1020) {
			topShowPush = Number($('#bottom').offset().top) - 500;

			$(window).on("resize scroll", function() {
				var y = $(window).scrollTop();
				if(y > topShowPush && !showPush) {
					$('.push-bottom').show();
					showPush = true;
				}
			});
		}
    });
</script>