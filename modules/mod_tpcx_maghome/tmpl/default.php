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

<div class="push">
    <div class="corner-top-left"></div>
    <div class="corner-bottom-right"></div>
    
    <div class="container-box">
        
        <?php
        $images = json_decode($article->images);
        if($images->image_intro):
        ?>
        <div class="visuel">
            <a href="<?php echo JRoute::_(ContentHelperRoute::getArticleRoute($article->id, $article->catid)); ?>">
                <div class="tearing"></div>
                <div class="btn">
                    <span></span>
                </div>
                
                <img class="opacity" src="<?php echo $baseurl . '/' . $images->image_intro; ?>" alt="">
            </a>
        </div>
        <?php endif; ?>
                            
        <div class="text">
            
            <h4>
                <a class="mod-articles-category-title" href="<?php echo JRoute::_(ContentHelperRoute::getArticleRoute($article->id, $article->catid)); ?>">
                    <?php
                    $tab = explode("|", $article->title);
                    if(count($tab) > 1) {
                        list($titleStrong, $title) = $tab;
                        echo '<span>' . $titleStrong . '</span>';
                        echo $title;
                    } else {
                      echo $article->title;
                    }
                    ?>
                </a>
            </h4>
    
            <p class="mod-articles-category-introtext">
                <?php echo $article->introtext; ?>                         
            </p>
                            
            <p class="mod-articles-category-readmore">
                <a class="mod-articles-category-title " href="<?php echo JRoute::_(ContentHelperRoute::getArticleRoute($article->id, $article->catid)); ?>">
                    Lire la suite -&gt;
                </a>
            </p>
                                    
        </div>
    
    </div>
</div>
