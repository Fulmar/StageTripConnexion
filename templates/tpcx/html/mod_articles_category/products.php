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
<div id="carousel-products-prev" class="prevButton jcarousel-prev jcarousel-prev-horizontal">
    <img src="<?php echo $baseurl . '/templates/' . $template . '/images/prev-carousel.png'; ?>" alt="Précédent" />
</div>
<div id="carousel-products-next" class="nextButton jcarousel-next jcarousel-next-horizontal">
    <img src="<?php echo $baseurl . '/templates/' . $template . '/images/next-carousel.png'; ?>" alt="Suivant" />
</div>
    <?php 
	$maxItem=0;
	foreach ($list as $item) :
		$maxItem++;
	endforeach;
	$minItem = $maxItem/2;
	?>
<div class="carousel-products-mobile">
	<div class="carousel-products">
		<ul class="category-module <?php echo $moduleclass_sfx; ?>">
		<?php 
		$i=0;
		foreach ($list as $item) : 
		$i++;
		?>
			<li class="<?php echo $class; ?>">
				<div class="push">
					
					<div class="container-box">
						
						<?php
						$images = json_decode($item->images);
						if($images->image_intro):
						?>
						<div class="visuel <?php echo "img-nomber-".$i;?>">
							<a href="<?php echo $item->link; ?>">
								<!--<div class="tearing"></div>-->
								<div class="btn">
									<span></span>
								</div>
								
								<img class="opacity" src="<?php echo $baseurl . '/' . $images->image_intro; ?>" alt="" />
							</a>
						</div>
						<?php endif; ?>
						
						<div class="text <?php echo "text-nomber-".$i;?>">
						
						<?php
						$article =& JTable::getInstance('content');
						$article->load($item->id);
						$introtext = $article->get('introtext');
						?>
						
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
								<div class="mod-articles-category-introtext">
								<?php
								//echo $introtext;
								// First get the plain text string. This is the rendered text we want to end up with.
								$ptString = JHtml::_('string.truncate', $introtext, 240, $noSplit = true, $allowHtml = true);
								
								//echo $ptString;
								//$ptString = str_replace('<p>', '', $ptString);
								$ptString = str_replace('...', '', $ptString);
								echo $ptString;
								?>
								</div>
							<?php endif; ?>
					
							<p class="mod-articles-category-readmore">
								<a class="mod-articles-category-title <?php echo $item->active; ?>" href="<?php echo $item->link; ?>">
								  Lire la suite ->
								</a>
							</p>
							
						</div>
						
					</div>
			</div>
		</li>
		<?php endforeach; ?>
		</ul>
	</div>
</div>
<div class="carousel-products-1020">
	<div class="carousel-top carousel-products">
		<ul class="category-module <?php echo $moduleclass_sfx; ?>">
		<?php 
		$i=0;
		foreach ($list as $item) : 
		$i++;
		if($i <= $minItem){
		?>
			<li class="<?php echo $class; ?>">
				<div class="push">
					
					<div class="container-box">
						
						<?php
						$images = json_decode($item->images);
						if($images->image_intro):
						?>
						<div class="visuel <?php echo "img-nomber-".$i;?>">
							<a href="<?php echo $item->link; ?>">
								<!--<div class="tearing"></div>-->
								<div class="btn">
									<span></span>
								</div>
								
								<img class="opacity" src="<?php echo $baseurl . '/' . $images->image_intro; ?>" alt="" />
							</a>
						</div>
						<?php endif; ?>
						
						<div class="text <?php echo "text-nomber-".$i;?>">
						
						<?php
						$article =& JTable::getInstance('content');
						$article->load($item->id);
						$introtext = $article->get('introtext');
						?>
						
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
								<div class="mod-articles-category-introtext">
								<?php
								//echo $introtext;
								// First get the plain text string. This is the rendered text we want to end up with.
								$ptString = JHtml::_('string.truncate', $introtext, 240, $noSplit = true, $allowHtml = true);
								
								//echo $ptString;
								//$ptString = str_replace('<p>', '', $ptString);
								$ptString = str_replace('...', '', $ptString);
								echo $ptString;
								?>
								</div>
							<?php endif; ?>
					
							<p class="mod-articles-category-readmore">
								<a class="mod-articles-category-title <?php echo $item->active; ?>" href="<?php echo $item->link; ?>">
								  Lire la suite ->
								</a>
							</p>
							
						</div>
						
					</div>
			</div>
		</li>
		<?php } endforeach; ?>
		</ul>
	</div>
	<div class="carousel-bottom carousel-products">
		<ul class="category-module <?php echo $moduleclass_sfx; ?>">
		<?php 
		$iItem = $minItem;
		$i = round( $minItem);
		$i=$i-1;
		echo $i;
		foreach ($list as $item) : 
		$iItem++;
		if($iItem > $maxItem){
		$i++;
		?>
			<li class="<?php echo $class; ?>">
				<div class="push">
					
					<div class="container-box">
						
						<?php
						$images = json_decode($item->images);
						if($images->image_intro):
						?>
						<div class="visuel <?php echo "img-nomber-".$i;?>">
							<a href="<?php echo $item->link; ?>">
								<!--<div class="tearing"></div>-->
								<div class="btn">
									<span></span>
								</div>
								
								<img class="opacity" src="<?php echo $baseurl . '/' . $images->image_intro; ?>" alt="" />
							</a>
						</div>
						<?php endif; ?>
						
						<div class="text <?php echo "text-nomber-".$i;?>">
						
						<?php
						$article =& JTable::getInstance('content');
						$article->load($item->id);
						$introtext = $article->get('introtext');
						?>
						
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
								<div class="mod-articles-category-introtext">
								<?php
								//echo $introtext;
								// First get the plain text string. This is the rendered text we want to end up with.
								$ptString = JHtml::_('string.truncate', $introtext, 240, $noSplit = true, $allowHtml = true);
								
								//echo $ptString;
								//$ptString = str_replace('<p>', '', $ptString);
								$ptString = str_replace('...', '', $ptString);
								echo $ptString;
								?>
								</div>
							<?php endif; ?>
					
							<p class="mod-articles-category-readmore">
								<a class="mod-articles-category-title <?php echo $item->active; ?>" href="<?php echo $item->link; ?>">
								  Lire la suite ->
								</a>
							</p>
							
						</div>
						
					</div>
			</div>
		</li>
		<?php } endforeach; ?>
		</ul>
	</div>
</div>

<script>

	
	$(document).ready(function(){
	var DebutWidth =19.5;
	var totalWidth =0;
	<?php 
		$i=0;
		foreach ($list as $item) :
		$i++;
		?>
		currentWidth = Response.viewportW();
			if(currentWidth > 1020) {
			$('.push .<?php echo "img-nomber-".$i; ?>').mouseover(function(event) {
				event.preventDefault();
				$('.push .<?php echo "text-nomber-".$i; ?>').css( 'transform','translateX(0px)' );
			});
			$('.push .<?php echo "img-nomber-".$i; ?>').mouseout(function(event) {
				event.preventDefault();
				$('.push .<?php echo "text-nomber-".$i; ?>').css( 'transform','translateX(900%)' );
			});
			$('.push .<?php echo "text-nomber-".$i; ?>').mouseover(function(event) {
				event.preventDefault();
				$('.push .<?php echo "text-nomber-".$i; ?>').css( 'transform','translateX(0px)' );
			});
			$('.push .<?php echo "text-nomber-".$i; ?>').mouseout(function(event) {
				event.preventDefault();
				$('.push .<?php echo "text-nomber-".$i; ?>').css( 'transform','translateX(900%)' );
			});
		}
		
		// totalWidth = totalWidth + DebutWidth;
		<?php endforeach; ?>
		// totalWidth = totalWidth *16;
		// currentWidth = Response.viewportW();
		// if(currentWidth > 1020) {
			// $('.carousel-products ul ').css( 'width',totalWidth );
		// }

	});
	
    $(document).ready(function(){
		<?php
			$maxRand=0;
			foreach ($list as $item) :
				$maxRand++;
			endforeach;
		?>
		currentWidth = Response.viewportW();
		if(currentWidth > 1020) {
			function affiheTextFirst(x) {
				$(x).css( 'transform','translateX(900%)' );
				var myString =".push ";
				myString +=".";
				myString += "text-nomber-";
				myString += Math.floor((Math.random() * <?php echo $maxRand; ?>) + 1);
				$(myString).css( 'transform','translateX(0px)' );
				setTimeout(function(){return affiheTextFirst(myString);}, 5000);
					
			};
		}
		if(currentWidth > 1020) {
		function affiheTextSeconde(x) {
				$(x).css( 'transform','translateX(900%)' );
				var myString =".push ";
				myString +=".";
				myString += "text-nomber-";
				myString += Math.floor((Math.random() * <?php echo $maxRand; ?>) + 1);
				$(myString).css( 'transform','translateX(0px)' );
				setTimeout(function(){return affiheTextSeconde(myString);}, 4000);
					
			};
		}
        $('.carousel-products')
            .on('jcarousel:create jcarousel:reload', function() {
                var element = $(this),
                    width = element.innerWidth();
                    //width = $("body").innerWidth();
        
                if (width > 1020) {
                    width = width / 2;
					
                } else if (width < 1020) {
                    width = width / 1;
                }
				
                element.jcarousel('items').css('width', width + 'px');
            })
			.jcarousel({
                // Your configurations options
                wrap: 'circular'
            }).jcarouselAutoscroll({
                interval: 3000,
                target: '+=1',
				autostart:true,
            });
		//stop scroll or start scroll carousel 	
		$('.carousel-products .push img,.carousel-products .push .text').mouseover(function(event) {
			event.preventDefault();	
			$('.carousel-products').jcarouselAutoscroll('stop');
		});
		$('.carousel-products .push img,.carousel-products .push .text').mouseout(function(event) {
			event.preventDefault();
			$('.carousel-products').jcarouselAutoscroll('start');
		});
		//Control carousel
        $('#carousel-products-prev')
            .on('jcarouselcontrol:active', function() {
                $(this).removeClass('inactive');
            })
            .on('jcarouselcontrol:inactive', function() {
                $(this).addClass('inactive');
            })
            .jcarouselControl({
                target: '-=1'
            });
        
        $('#carousel-products-next')
            .on('jcarouselcontrol:active', function() {
                $(this).removeClass('inactive');
            })
            .on('jcarouselcontrol:inactive', function() {
                $(this).addClass('inactive');
            })
            .jcarouselControl({
                target: '+=1'
            });
		if(currentWidth > 1020) {
			affiheTextFirst();
			affiheTextSeconde();
		}
    });
    
</script>