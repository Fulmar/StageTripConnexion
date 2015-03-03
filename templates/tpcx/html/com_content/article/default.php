<?php
/**
 * @package		Joomla.Site
 * @subpackage	com_content
 * @copyright	Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers');

// Create shortcuts to some parameters.
$params		= $this->item->params;
$images = json_decode($this->item->images);
$urls = json_decode($this->item->urls);
$canEdit	= $this->item->params->get('access-edit');
$user		= JFactory::getUser();

$backUrl = '';
$db = JFactory::getDbo();
        
$query = $db->getQuery(true);
        
$query->select('*');
$query->from('#__menu');
$query->where('type = "component"');
$query->where('params LIKE "%\"category\":\"' . $this->item->catid . '\"%"');

$db->setQuery($query);

$items = $db->loadObjectList();
if(count($items) > 0) {
    foreach($items as $item) {
        $backUrl = $item->alias;
        break;
    }
}

if(isset($_SERVER['HTTP_REFERER']))
    $backUrl = $_SERVER['HTTP_REFERER'];

$app    = JFactory::getApplication();
$menu   = $app->getMenu();
$menutype = $menu->getActive()->menutype;

jimport('joomla.log.log');
JLog::add(JText::_('test'), JLog::WARNING, 'jerror');

if($this->pageclass_sfx == 'partenaire' || $this->pageclass_sfx == 'produit'):

    $session = JFactory::getSession();
    $termSearch = $session->get('termSearch');
    $secondTermSearch = $session->get('secondTermSearch');
    $countItems = $session->get('countItems');
    
    $search  = 'annuaire';
    
    if($this->pageclass_sfx == 'produit')
        $search  = 'voyages';    
    
    $result = strstr($_SERVER['HTTP_REFERER'], $search);
    
    if(!empty($result))
        $backUrl = $_SERVER['HTTP_REFERER'];
    
    if(empty($backUrl))
        $backUrl = $search;
    
endif;

?>

<?php
$class = '';
if($menutype == 'menuarticlespartenaire') {
    $class = 'title-annuaire';
}
if($menutype == 'menuarticlesproduit') {
    $class = 'title-produit';
}
if($menutype == 'menuautre' || $menutype == 'menufooter' || $this->pageclass_sfx == 'wide confirmation'):
    $class = 'title-autre';
endif;
?>

<?php if($menutype != 'menuarticlesmagazine'): ?>
<h1 class="<?php echo $class; ?>">
    <?php echo $this->escape($this->item->title); ?>
</h1>
<?php endif; ?>

<?php if($this->pageclass_sfx != 'confirmation' && $this->pageclass_sfx != 'wide' && $this->pageclass_sfx != 'interieur'  && $this->pageclass_sfx != 'wide confirmation'): ?>
    <div class="breadcrumbs <?php echo $this->pageclass_sfx; ?>">
        <?php if($this->pageclass_sfx == 'partenaire'): ?>
            <a href="<?php echo $backUrl; ?>"><- Retour à la liste des partenaires<?php
            if(!empty($termSearch) && !empty($_SERVER['HTTP_REFERER']) && !empty($result)) {
                echo  ' qui correspond à votre recherche "' . $termSearch . '"';
               
                if(!empty($secondTermSearch))
                    echo  ' & ' . $secondTermSearch;
                
                if(!empty($countItems)) {
                    $s = $countItems > 1 ? 's' : '';
                    echo  ' (' . $countItems . ' réponse' . $s . ')';
                }
            }
            ?></a>
        <?php elseif($this->pageclass_sfx == 'produit'): ?>
            <a href="<?php echo $backUrl; ?>"><- Retour à la liste des voyages et expériences<?php
            if(!empty($termSearch) && !empty($_SERVER['HTTP_REFERER']) && !empty($result)) {
                echo  ' qui correspond à votre recherche "' . $termSearch . '"';
               
                if(!empty($secondTermSearch))
                    echo  ' & ' . $secondTermSearch;
                
                if(!empty($countItems)) {
                    $s = $countItems > 1 ? 's' : '';
                    echo  ' (' . $countItems . ' réponse' . $s . ')';
                }
            }
            ?></a>
        <?php else: ?>
            <a href="<?php echo $backUrl; ?>"><- Retour à la liste des articles</a>
        <?php endif; ?>
    </div>
<?php endif; ?>

<article class="item-page <?php echo $this->pageclass_sfx; ?>">
    
    <div class="article-content">
        
        <div class="social-buttons">
            <div class="social fb">
                <a href="" class="btn-share-fb">
                    <img src="<?php echo JURI::base() . "templates/" . $app->getTemplate(); ?>/images/social-fb.png" />
                </a>
                <script>
                $(document).ready(function() {
                    $('a.btn-share-fb').click(function() {
                        event.preventDefault();
                        window.open('http://www.facebook.com/sharer/sharer.php?u=<?php echo JURI::current(); ?>&t=<?php echo $this->escape($this->item->title); ?>',
                                    'facebook_share',
                                    'height=320, width=640, toolbar=no, menubar=no, scrollbars=no, resizable=no, location=no, directories=no, status=no');
                       
                    }); 
                }); 
                </script>
            </div>
            <div class="social twitter">
                <script type="text/javascript" src="//platform.twitter.com/widgets.js"></script>
                <a href="https://twitter.com/intent/tweet?url=<?php echo JURI::current(); ?>">
                    <img src="<?php echo JURI::base() . "templates/" . $app->getTemplate(); ?>/images/social-twitter.png" />
                </a>
            </div>
            <div class="social gplus">
                <a href="https://plus.google.com/share?url=<?php echo JURI::current(); ?>" onclick="javascript:window.open(this.href,
  '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;">
                    <img src="<?php echo JURI::base() . "templates/" . $app->getTemplate(); ?>/images/social-gplus.png" />
                </a>
            </div>
        </div>
        <script>
            $(window).load(function(){
                
                var $sidebar   = $(".social-buttons"),
                    $container = $(".article-content");
                
                limitTop = $container.height() + parseInt($container.css('padding-top')) + parseInt($container.css('padding-bottom')) - 100;
                
                $sidebar.css('left', Number($container.offset().left - 52) + 'px');
                $sidebar.css('top', Number($container.offset().top + 26) + 'px');
                
                var $window    = $(window);
                
                $window.on("resize scroll", function() {
                    if($window.scrollTop() > limitTop) {
                        $sidebar.css('position', 'absolute');
                        $sidebar.css('top', limitTop + 'px');
                        $sidebar.css('left', '-52px');
                    } else {
                        $sidebar.css('position', 'fixed');
                        $sidebar.css('left', Number($container.offset().left - 52) + 'px');
                        $sidebar.css('top', Number($container.offset().top + 26) + 'px');
                    }
                });
                
            });
        </script>
        
        <?php //if($this->pageclass_sfx != 'partenaire'): ?>
        <div class="corner-top-left"></div>
        <div class="corner-bottom-right"></div>
        <?php //endif; ?>
        
        <?php if ($this->params->get('show_page_heading')) : ?>
        	<h1>
        	<?php echo $this->escape($this->params->get('page_heading')); ?>
        	</h1>
        <?php endif; ?>
    <?php
    if (!empty($this->item->pagination) AND $this->item->pagination && !$this->item->paginationposition && $this->item->paginationrelative)
    {
     echo $this->item->pagination;
    }
     ?>
    
    <?php if ($canEdit ||  $params->get('show_print_icon') || $params->get('show_email_icon')) : ?>
    	<ul class="actions">
    	<?php if (!$this->print) : ?>
    		<?php if ($params->get('show_print_icon')) : ?>
    			<li class="print-icon">
    			<?php echo JHtml::_('icon.print_popup',  $this->item, $params); ?>
    			</li>
    		<?php endif; ?>
    
    		<?php if ($params->get('show_email_icon')) : ?>
    			<li class="email-icon">
    			<?php echo JHtml::_('icon.email',  $this->item, $params); ?>
    			</li>
    		<?php endif; ?>
    
    		<?php if ($canEdit) : ?>
    			<li class="edit-icon">
    			<?php echo JHtml::_('icon.edit', $this->item, $params); ?>
    			</li>
    		<?php endif; ?>
    
    	<?php else : ?>
    		<li>
    		<?php echo JHtml::_('icon.print_screen',  $this->item, $params); ?>
    		</li>
    	<?php endif; ?>
    
    	</ul>
    <?php endif; ?>
    
    <?php  if (!$params->get('show_intro')) :
    	echo $this->item->event->afterDisplayTitle;
    endif; ?>
    
    <?php echo $this->item->event->beforeDisplayContent; ?>
    
    <?php $useDefList = (($params->get('show_author')) or ($params->get('show_category')) or ($params->get('show_parent_category'))
    	or ($params->get('show_create_date')) or ($params->get('show_modify_date')) or ($params->get('show_publish_date'))
    	or ($params->get('show_hits'))); ?>
    
    <?php if ($useDefList) : ?>
    	<dl class="article-info">
    	<dt class="article-info-term"><?php  echo JText::_('COM_CONTENT_ARTICLE_INFO'); ?></dt>
    <?php endif; ?>
    <?php if ($params->get('show_parent_category') && $this->item->parent_slug != '1:root') : ?>
    	<dd class="parent-category-name">
    	<?php	$title = $this->escape($this->item->parent_title);
    	$url = '<a href="'.JRoute::_(ContentHelperRoute::getCategoryRoute($this->item->parent_slug)).'">'.$title.'</a>';?>
    	<?php if ($params->get('link_parent_category') and $this->item->parent_slug) : ?>
    		<?php echo JText::sprintf('COM_CONTENT_PARENT', $url); ?>
    	<?php else : ?>
    		<?php echo JText::sprintf('COM_CONTENT_PARENT', $title); ?>
    	<?php endif; ?>
    	</dd>
    <?php endif; ?>
    <?php if ($params->get('show_category')) : ?>
    	<dd class="category-name">
    	<?php 	$title = $this->escape($this->item->category_title);
    	$url = '<a href="'.JRoute::_(ContentHelperRoute::getCategoryRoute($this->item->catslug)).'">'.$title.'</a>';?>
    	<?php if ($params->get('link_category') and $this->item->catslug) : ?>
    		<?php echo JText::sprintf('COM_CONTENT_CATEGORY', $url); ?>
    	<?php else : ?>
    		<?php echo JText::sprintf('COM_CONTENT_CATEGORY', $title); ?>
    	<?php endif; ?>
    	</dd>
    <?php endif; ?>
    <?php if ($params->get('show_create_date')) : ?>
    	<dd class="create">
    	<?php echo JText::sprintf('COM_CONTENT_CREATED_DATE_ON', JHtml::_('date', $this->item->created, JText::_('DATE_FORMAT_LC2'))); ?>
    	</dd>
    <?php endif; ?>
    <?php if ($params->get('show_modify_date')) : ?>
    	<dd class="modified">
    	<?php echo JText::sprintf('COM_CONTENT_LAST_UPDATED', JHtml::_('date', $this->item->modified, JText::_('DATE_FORMAT_LC2'))); ?>
    	</dd>
    <?php endif; ?>
    <?php if ($params->get('show_publish_date')) : ?>
    	<dd class="published">
    	<?php echo JText::sprintf('COM_CONTENT_PUBLISHED_DATE_ON', JHtml::_('date', $this->item->publish_up, JText::_('DATE_FORMAT_LC2'))); ?>
    	</dd>
    <?php endif; ?>
    <?php if ($params->get('show_author') && !empty($this->item->author )) : ?>
    	<dd class="createdby">
    	<?php $author = $this->item->created_by_alias ? $this->item->created_by_alias : $this->item->author; ?>
    	<?php if (!empty($this->item->contactid) && $params->get('link_author') == true): ?>
    	<?php
    		$needle = 'index.php?option=com_contact&view=contact&id=' . $this->item->contactid;
    		$menu = JFactory::getApplication()->getMenu();
    		$item = $menu->getItems('link', $needle, true);
    		$cntlink = !empty($item) ? $needle . '&Itemid=' . $item->id : $needle;
    	?>
    		<?php echo JText::sprintf('COM_CONTENT_WRITTEN_BY', JHtml::_('link', JRoute::_($cntlink), $author)); ?>
    	<?php else: ?>
    		<?php echo JText::sprintf('COM_CONTENT_WRITTEN_BY', $author); ?>
    	<?php endif; ?>
    	</dd>
    <?php endif; ?>
    <?php if ($params->get('show_hits')) : ?>
    	<dd class="hits">
    	<?php echo JText::sprintf('COM_CONTENT_ARTICLE_HITS', $this->item->hits); ?>
    	</dd>
    <?php endif; ?>
    <?php if ($useDefList) : ?>
    	</dl>
    <?php endif; ?>
    
    <?php if (isset ($this->item->toc)) : ?>
    	<?php echo $this->item->toc; ?>
    <?php endif; ?>
    
    <?php if (isset($urls) AND ((!empty($urls->urls_position) AND ($urls->urls_position=='0')) OR  ($params->get('urls_position')=='0' AND empty($urls->urls_position) ))
    		OR (empty($urls->urls_position) AND (!$params->get('urls_position')))): ?>
    <?php echo $this->loadTemplate('links'); ?>
    <?php endif; ?>
    
    <?php if ($params->get('access-view')):?>
    
    <?php if($this->pageclass_sfx == 'partenaire' && ($menutype != 'menuautre' &&  $menutype != 'menufooter')): ?>
        <?php if ($params->get('show_title') && $this->item->catid == 8) : ?>
            <h1>
                <?php echo $this->escape($this->item->title); ?>
            </h1>
        <?php endif; ?>
    <?php endif; ?>
    
    <?php  if (isset($images->image_fulltext) and !empty($images->image_fulltext)) : ?>
        
        <div class="visuel">
            <div class="tearing"></div>
            
            <img
                class="opacity"
                <?php if ($images->image_fulltext_caption):
                    echo 'class="caption"'.' title="' .htmlspecialchars($images->image_fulltext_caption) .'"';
                endif; ?>
                src="<?php echo htmlspecialchars($images->image_fulltext); ?>" alt="<?php echo htmlspecialchars($images->image_fulltext_alt); ?>"/>
        </div>
        
    <?php endif; ?>
    
    <?php if($this->pageclass_sfx != 'partenaire' && ($menutype != 'menuautre' &&  $menutype != 'menufooter')): ?>
        <?php if ($params->get('show_title') && $this->item->catid == 8) : ?>
            <h1>
                <?php echo str_replace("|", "", $this->escape($this->item->title)); ?>
            </h1>
        <?php endif; ?>
    <?php endif; ?>
    
    <?php
    if (!empty($this->item->pagination) AND $this->item->pagination AND !$this->item->paginationposition AND !$this->item->paginationrelative):
    	echo $this->item->pagination;
     endif;
    ?>
    <?php echo $this->item->text; ?>
    <?php
    if (!empty($this->item->pagination) AND $this->item->pagination AND $this->item->paginationposition AND!$this->item->paginationrelative):
    	 echo $this->item->pagination;?>
    <?php endif; ?>
    
    <?php if (isset($urls) AND ((!empty($urls->urls_position)  AND ($urls->urls_position=='1')) OR ( $params->get('urls_position')=='1') )): ?>
    <?php echo $this->loadTemplate('links'); ?>
    <?php endif; ?>
    	<?php //optional teaser intro text for guests ?>
    <?php elseif ($params->get('show_noauth') == true and  $user->get('guest') ) : ?>
    	<?php echo $this->item->introtext; ?>
    	<?php //Optional link to let them register to see the whole article. ?>
    	<?php if ($params->get('show_readmore') && $this->item->fulltext != null) :
    		$link1 = JRoute::_('index.php?option=com_users&view=login');
    		$link = new JURI($link1);?>
    		<p class="readmore">
    		<a href="<?php echo $link; ?>">
    		<?php $attribs = json_decode($this->item->attribs);  ?>
    		<?php
    		if ($attribs->alternative_readmore == null) :
    			echo JText::_('COM_CONTENT_REGISTER_TO_READ_MORE');
    		elseif ($readmore = $this->item->alternative_readmore) :
    			echo $readmore;
    			if ($params->get('show_readmore_title', 0) != 0) :
    			    echo JHtml::_('string.truncate', ($this->item->title), $params->get('readmore_limit'));
    			endif;
    		elseif ($params->get('show_readmore_title', 0) == 0) :
    			echo JText::sprintf('COM_CONTENT_READ_MORE_TITLE');
    		else :
    			echo JText::_('COM_CONTENT_READ_MORE');
    			echo JHtml::_('string.truncate', ($this->item->title), $params->get('readmore_limit'));
    		endif; ?></a>
    		</p>
    	<?php endif; ?>
    <?php endif; ?>
    <?php
    if (!empty($this->item->pagination) AND $this->item->pagination AND $this->item->paginationposition AND $this->item->paginationrelative):
    	 echo $this->item->pagination;?>
    <?php endif; ?>
    
</div>

<?php if($this->pageclass_sfx == 'partenaire'): ?>
    <input type="hidden" name="partenaire_tracking" value="<?php echo $this->item->id; ?> - <?php echo $this->item->title; ?>" />
<?php endif; ?>

<?php if(count($this->item->tpcxtagarticle) > 0): ?>
    
<?php
JModelLegacy::addIncludePath(JPATH_SITE.'/components/com_tpcxtags/models', 'TpcxtagsModel');
$model = JModelLegacy::getInstance('Articles', 'TpcxtagsModel', array('ignore_request' => true));

$thematiques = array();
$pays = array();
$partenaires = array();
?>
<div class="tpcxtags">
    <?php
    if($this->pageclass_sfx == 'partenaire'):
        $textePartenaires = '';
        $query = $db->getQuery(true);
        
        $query->select('user_id');
        $query->from('#__user_profiles');
        $query->where('profile_key = "tpcxtagarticle.listpartenaires"');
        $query->where('profile_value LIKE \'%"' . $this->item->id . '"%\'');
        
        $db->setQuery($query);
        $db->query();
        $count = $db->getNumRows();
        
        if($count > 0) {
            $texteVoyages = '<p><a href="' . JURI::base() . 'voyages?c=&p=&t=&part=' . $this->item->id . '">Découvrir les voyages et expériences</a> que propose ' . $this->escape($this->item->title) . '</p>';
        }
        $texteDestinations = 'Ce partenaire travaille sur ces destinations : ';
        $texteThematiques = 'Il propose ces thématiques de voyages : ';
        $link = 'annuaire';
    elseif($this->pageclass_sfx == 'produit'):
        $textePartenaires = 'Voir les autres voyages de : ';
        $texteDestinations = 'Voir les autres voyages sur ces destinations : ';
        $texteThematiques = 'Voir les autres voyages sur ces thèmes : ';
        $link = 'voyages';
    else:
        $textePartenaires = '';
        $texteDestinations = 'Voir d\'autres articles sur ces destinations : ';
        $texteThematiques = 'Voir les autres articles sur ces thèmes : ';
    endif;
    
    $app    = JFactory::getApplication();
    $menu   = $app->getMenu();
    $itemsMagazine  = $menu->getItems('menutype', 'menumagazine');
    ?>
    
    <?php foreach($this->item->tpcxtagarticle as $key => $tags): ?>
        <?php
        if($key == 'listthematiques') {
            foreach($tags as $tag):
                if($this->pageclass_sfx == 'partenaire' || $this->pageclass_sfx == 'produit')
                    $thematiques[] = '<a href="' . $link . '?c=&p=&t=' . $tag . '">' . $model->getItem($tag, 'tag') . '</a>';
                else {
                    foreach($itemsMagazine as $item) {
                        if($item->params->get('listthematiques') == $tag) {
                            $link = JURI::base() . $item->route;
                            break;
                        }
                    }
                    $thematiques[] = '<a href="' . $link . '">' . $model->getItem($tag, 'tag') . '</a>';
                }
            endforeach;
        } elseif($key == 'listpays') {
            foreach($tags as $tag):
                if($this->pageclass_sfx == 'partenaire' || $this->pageclass_sfx == 'produit')
                    $pays[] = '<a href="' . $link . '?c=&p=' . $tag . '&t=">' . $model->getItem($tag, 'tag') . '</a>';
                else {
                    foreach($itemsMagazine as $item) {
                        if($item->params->get('listpays') == $tag) {
                            $link = JURI::base() . $item->route;
                            break;
                        }
                    }
                    $pays[] = '<a href="' . $link . '">' . $model->getItem($tag, 'tag') . '</a>';
                }
            endforeach;
        } elseif($key == 'listpartenaires') {
            foreach($tags as $tag):
                if($this->pageclass_sfx == 'produit') {
                    $query = $db->getQuery(true);
        
                    $query->select('title');
                    $query->from('#__content');
                    $query->where('catid = 9');
                    $query->where('id = ' . $tag);
                    
                    $db->setQuery($query);
                    
                    $tagTitle = $db->loadObject();
                    
                    $partenaires[] = '<a href="' . $link . '?c=&p=&t=&part=' . $tag . '">' . $tagTitle->title . '</a>';
                }
            endforeach;
        }
        ?>
    <?php endforeach; ?>
    
    <?php
    if($this->pageclass_sfx == 'partenaire'):
        echo $texteVoyages;
    endif;
    if(count($partenaires) > 0):
        echo '<p class="title">';
        echo $textePartenaires;
        echo implode(" / ", $partenaires);
        echo '</p>';
    endif;
    ?>
    
    <?php
    if(count($pays) > 0):
        echo '<p class="title">';
        echo $texteDestinations;
        echo implode(" / ", $pays);
        echo '</p>';
    endif;
    ?>
    
    <?php
    if(count($thematiques) > 0):
        echo '<p class="title">';
        echo $texteThematiques;
        echo implode(" / ", $thematiques);
        echo '</p>';
    endif;
    ?>
    
</div>
<?php endif; ?>

<?php if($this->pageclass_sfx != 'confirmation'): ?>
    <?php echo $this->item->event->afterDisplayContent; ?>
<?php endif; ?>

</article>
