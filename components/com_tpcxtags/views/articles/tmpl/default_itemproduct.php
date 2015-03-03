<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

$baseurl = JURI::base();
$images = json_decode($this->item->images);
$link = JRoute::_(ContentHelperRoute::getArticleRoute($this->item->slug, $this->item->catid));

?>

<li>
    <div class="push">
                     
        <div class="container-box">
            
            <div class="visuel">
                <a href="<?php echo $link; ?>">
                    <div class="tearing"></div>
                    <div class="btn">
                        <span></span>
                    </div>
                    
                    <img class="opacity" src="<?php echo $baseurl . '/' . $images->image_intro; ?>" alt="" />
                </a>
            </div>
                                
            <div class="text">
            
                <h4>
                    <a class="mod-articles-category-title " href="<?php echo $link; ?>">
                        <?php echo $this->escape($this->item->title); ?>
                    </a>
                </h4>
        
                <p class="mod-articles-category-introtext">
                    <?php
                    //echo $this->item->introtext;
                    /*$article =& JTable::getInstance('content');
                    $article->load($this->item->id);
                    $introtext = $article->get('introtext');*/
                    
                    // First get the plain text string. This is the rendered text we want to end up with.
                    $ptString = JHtml::_('string.truncate', $this->item->introtext, 280, $noSplit = true, $allowHtml = true);
                    
                    echo $ptString;
                    ?>
                </p>  
                
                <p class="readmore">
                    <a href="<?php echo $link; ?>">
                        En savoir + ->
                    </a>
                </p>          
                                        
            </div>
            
        </div>
    </div>
</li>