<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

$baseurl = JURI::base();
$images = json_decode($this->item->images);
$link = JRoute::_(ContentHelperRoute::getArticleRoute($this->item->slug, $this->item->catid));

?>

<div class="item">
    
    <?php //if($this->params->get('type') == 'magazine'): ?>
        <div class="corner-top-left"></div>
        <div class="corner-bottom-right"></div>
    <?php //endif; ?>
    
    <?php if($this->params->get('type') == 'partenaire'): ?>
        <h2>
            <a href="<?php echo $link; ?>">
                <?php echo $this->escape($this->item->title); ?>
            </a>
        </h2>
    <?php endif; ?>
    
    <?php  if (isset($images->image_intro) and !empty($images->image_intro)) : ?>
    <div class="visuel">
        <a href="<?php echo $link; ?>">
                <div class="tearing"></div>
            <?php if($this->params->get('type') == 'magazine'): ?>
                <div class="btn-<?php echo $this->params->get('type'); ?>">
                    <span></span>
                </div>
            <?php endif; ?>
            
            <img class="opacity" src="<?php echo $baseurl . htmlspecialchars($images->image_intro); ?>" alt="<?php echo htmlspecialchars($images->image_intro_alt); ?>" />
        </a>
    </div>
    <?php endif; ?>
    
    <?php if($this->params->get('type') == 'magazine'): ?>
    <h2>
        <a href="<?php echo $link; ?>">
            <?php echo str_replace("|", "", $this->escape($this->item->title)); ?>
        </a>
    </h2>
    <?php endif; ?>
    
    <?php echo $this->item->introtext; ?>

    <p class="readmore">
        <a href="<?php echo $link; ?>">
            <?php if($this->params->get('type') == 'magazine'): ?>
            Lire la suite ->
            <?php elseif($this->params->get('type') == 'partenaire'): ?>
            Voir la fiche du partenaire ->
            <?php endif; ?>
        </a>
    </p>
    
</div>