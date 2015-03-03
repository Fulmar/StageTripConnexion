<?php

/**
 * Template Tpcx 
 *
 * @author Fabien Vautour 
 */

// no direct access
defined('_JEXEC') or die;
$app = JFactory::getApplication();

$id = JRequest::getString('id');

if(!empty($id)):

$modelArticle = JModel::getInstance( 'Article', 'ContentModel' );

$article = $modelArticle->getItem(JRequest::getString('id'));
if(!empty($article->fields['image_header'])):
    $size = getimagesize(JPATH_BASE . DIRECTORY_SEPARATOR . $article->fields['image_header']);
    $ratio = $size[1] / $size[0];
?>
<div class="header-article" style="background-image: url('<?php echo JURI::base() . $article->fields['image_header']; ?>');">
    <div class="bg-bottom"></div>
</div>
<script>
    $(document).ready(function(){
        
        // $('#slideshow-container').css('marginTop', '72px');
        $('#slideshow-container').css('marginBottom', '6px');
        $('#middle').css('marginTop', '0');
        
        currentWidth = Response.viewportW();
        
        if(currentWidth < 1020) {
            $('#slideshow-container').css('marginTop', '0');
            // $('#slideshow-container').hide();
        }
        
        ratio = '<?php echo $ratio; ?>';
        
        // resize header-article based on body width
        $(window).resize(function() {
            documentWidth = $(document).width();
            newHeight = documentWidth * ratio;
            $('.header-article').css('height', parseInt(newHeight) + 'px');
        }).resize();
    });
</script>
<?php endif; ?>

<?php endif; ?>