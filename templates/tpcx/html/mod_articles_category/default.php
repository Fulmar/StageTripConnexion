<?php
/**
 * @package		Joomla.Site
 * @subpackage	mod_articles_category
 * @copyright	Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

$app = JFactory::getApplication();
$baseurl = JURI::base();

$template = $app -> getTemplate();

?>
<ul class="category-module <?php echo $moduleclass_sfx; ?>">
<?php if ($grouped) : ?>
	<?php foreach ($list as $group_name => $group) : ?>
	<li>
		<h<?php echo $item_heading; ?>><?php echo $group_name; ?></h<?php echo $item_heading; ?>>
		<ul>
			<?php foreach ($group as $item) : ?>
				<li>
					<h<?php echo $item_heading+1; ?>>
					   	<?php if ($params->get('link_titles') == 1) : ?>
						<a class="mod-articles-category-title <?php echo $item->active; ?>" href="<?php echo $item->link; ?>">
						<?php echo $item->title; ?>
				        <?php if ($item->displayHits) :?>
							<span class="mod-articles-category-hits">
				            (<?php echo $item->displayHits; ?>)  </span>
				        <?php endif; ?></a>
				        <?php else :?>
				        <?php echo $item->title; ?>
				        	<?php if ($item->displayHits) :?>
							<span class="mod-articles-category-hits">
				            (<?php echo $item->displayHits; ?>)  </span>
				        <?php endif; ?></a>
				            <?php endif; ?>
			        </h<?php echo $item_heading+1; ?>>


				<?php if ($params->get('show_author')) :?>
					<span class="mod-articles-category-writtenby">
					<?php echo $item->displayAuthorName; ?>
					</span>
				<?php endif;?>

				<?php if ($item->displayCategoryTitle) :?>
					<span class="mod-articles-category-category">
					(<?php echo $item->displayCategoryTitle; ?>)
					</span>
				<?php endif; ?>
				<?php if ($item->displayDate) : ?>
					<span class="mod-articles-category-date"><?php echo $item->displayDate; ?></span>
				<?php endif; ?>
				<?php if ($params->get('show_introtext')) :?>
			<p class="mod-articles-category-introtext">
			<?php echo $item->displayIntrotext; ?>
			</p>
		<?php endif; ?>

		<?php if ($params->get('show_readmore')) :?>
			<p class="mod-articles-category-readmore">
				<a class="mod-articles-category-title <?php echo $item->active; ?>" href="<?php echo $item->link; ?>">
				<?php if ($item->params->get('access-view')== FALSE) :
						echo JText::_('MOD_ARTICLES_CATEGORY_REGISTER_TO_READ_MORE');
					elseif ($readmore = $item->alternative_readmore) :
						echo $readmore;
						echo JHtml::_('string.truncate', $item->title, $params->get('readmore_limit'));
						if ($params->get('show_readmore_title', 0) != 0) :
							echo JHtml::_('string.truncate', ($this->item->title), $params->get('readmore_limit'));
						endif;
					elseif ($params->get('show_readmore_title', 0) == 0) :
						echo JText::sprintf('MOD_ARTICLES_CATEGORY_READ_MORE_TITLE');
					else :

						echo JText::_('MOD_ARTICLES_CATEGORY_READ_MORE');
						echo JHtml::_('string.truncate', ($item->title), $params->get('readmore_limit'));
					endif; ?>
	        </a>
			</p>
			<?php endif; ?>
		</li>
			<?php endforeach; ?>
		</ul>
	</li>
	<?php endforeach; ?>
<?php else : ?>
	<?php $i = 0; foreach ($list as $item) : ?>
	    <?php
	    $i++;
	    
	    $class = '';
        if($i == 1)
            $class = 'second secondfirst';
        if($i == 2)
            $class = 'second secondlast';
        if($i > 2)
            $class = 'general';
        if($i > 2 && $i%3 == 0)
            $class .= ' clear';
	    ?>
	    <li class="<?php echo $class; ?>">
	        <div class="push">
	            
	            <?php if($i == 1 || $i == 2): ?>
	                <div class="corner-top-left"></div>
	                <div class="corner-bottom-right"></div>
	            <?php endif; ?>
	            
	            <div class="container-box">
	                
	                <?php
                    $images = json_decode($item->images);
                    if($images->image_intro):
                    ?>
    	            <div class="visuel">
    	                <a href="<?php echo $item->link; ?>">
        	                <div class="tearing"></div>
        	                <div class="btn">
        	                    <span></span>
                            </div>
        	                
        	                <img class="opacity" src="<?php echo $baseurl . '/' . $images->image_intro; ?>" alt="" />
                        </a>
    	            </div>
    	            <?php endif; ?>
    	            
    	            <div class="text">
    	            
                	   	<h<?php echo $item_heading; ?>>
                	   	<?php if ($params->get('link_titles') == 1) : ?>
                            <a class="mod-articles-category-title <?php echo $item->active; ?>" href="<?php echo $item->link; ?>">
                		<?php
                		  echo $item->title;
                		?>
                        <?php if ($item->displayHits) :?>
                			<span class="mod-articles-category-hits">
                            (<?php echo $item->displayHits; ?>)  </span>
                        <?php endif; ?></a>
                        <?php else :?>
                        <?php echo $item->title; ?>
                        	<?php if ($item->displayHits) :?>
                			<span class="mod-articles-category-hits">
                            (<?php echo $item->displayHits; ?>)  </span>
                        <?php endif; ?></a>
                            <?php endif; ?>
                        </h<?php echo $item_heading; ?>>
                
                       	<?php if ($params->get('show_author')) :?>
                       		<span class="mod-articles-category-writtenby">
                			<?php echo $item->displayAuthorName; ?>
                			</span>
                		<?php endif;?>
                		<?php if ($item->displayCategoryTitle) :?>
                			<span class="mod-articles-category-category">
                			(<?php echo $item->displayCategoryTitle; ?>)
                			</span>
                		<?php endif; ?>
                        <?php if ($item->displayDate) : ?>
                			<span class="mod-articles-category-date"><?php echo $item->displayDate; ?></span>
                		<?php endif; ?>
                		<?php if ($params->get('show_introtext')) :?>
                			<p class="mod-articles-category-introtext">
                			<?php echo $item->displayIntrotext; ?>
                			</p>
                		<?php endif; ?>
                
                		<?php if($i == 1 || $i == 2): ?>
                			<p class="mod-articles-category-readmore">
                				<a class="mod-articles-category-title <?php echo $item->active; ?>" href="<?php echo $item->link; ?>">
                		          Lire la suite ->
                                </a>
                			</p>
                		<?php endif; ?>
                		
                    </div>
                    
                </div>
		</div>
	</li>
	<?php endforeach; ?>
<?php endif; ?>
</ul>
