<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
$app = JFactory::getApplication();

$com_path = JPATH_SITE . '/components/com_content/';
require_once $com_path.'helpers/route.php';

$session = JFactory::getSession();
$session->set('termSearch', $this->termSearch);
$session->set('secondTermSearch', $this->secondTermSearch);
$session->set('countItems', $this->countItems);

?>

<div class="items items-<?php echo $this->params->get('type'); ?>">
	<?php if($this->params->get('type') == 'magazine'): ?>
        <?php $s = $this->countItems > 1 ? 's' : ''; ?>
        <p class="results-text">
            Il y'a <?php echo $this->countItems; ?>
            article<?php echo $s; ?> concernant votre recherche "<span id="term" class="term"></span>"
        </p>
    <?php endif; ?>
    <?php if($this->params->get('category') == '9' && isset($this->termSearch)): ?>
        <?php $s = $this->countItems > 1 ? 's' : ''; ?>
        <p class="results-text">
            Voici nos partenaires qui correspondent à votre recherche <span class="term">"<?php echo $this->termSearch; ?>"</span>
            <?php if($this->secondTermSearch): ?>
            	& <span class="term">"<?php echo $this->secondTermSearch; ?>"</span>
        	<?php endif; ?>
            (<?php echo $this->countItems; ?> réponse<?php echo $s; ?>)
            <div class="choices-partner clearfix">
                <p>Trier les résultats par : </p>
                <ul class="list">
                    <li class="selected">
                        <a href="javascript:void(0)" data-value="<?php echo $this->filter_selected['value']; ?>">
                            <?php echo $this->filter_selected['name']; ?> <span><i class="fa fa-chevron-down"></i></span>
                        </a>
                        <div class="children">
                            <ul>
                                <?php foreach($this->filters as $filter): ?>
                                    <li>
                                        <a href="javascript:void(0)" data-value="<?php echo $filter['value']; ?>">
                                            <?php echo $filter['name']; ?>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </li>
                </ul>
                <?php if(!empty($this->filter_selected['value'])): ?>
                <p class="remove">
                    <a href="<?php echo JURI::base() . 'annuaire?c=&p=' . JRequest::getVar('p') . '&t='; ?>">Supprimer le filtre</a>
                </p>
                <?php endif; ?>
            </div>
        </p>
    <?php endif; ?>
    

    <?php if($this->params->get('category') == '10' && !is_null($this->params->get('page_heading'))): ?>
        <h2 class="title"><?php echo $this->params->get('page_heading'); ?></h2>
    <?php endif; ?>
    
    <?php if($this->params->get('category') == '10' && isset($this->termSearch)): ?>
        <?php $s = $this->countItems > 1 ? 's' : ''; ?>
        <p class="results-text">
            Voici les voyages qui correspondent à votre recherche <span class="term">"<?php echo $this->termSearch; ?>"</span>
            <?php if($this->secondTermSearch): ?>
                & <span class="term">"<?php echo $this->secondTermSearch; ?>"</span>
            <?php endif; ?>
            (<?php echo $this->countItems; ?> réponse<?php echo $s; ?>)
        </p>
    <?php endif; ?>
    
    <?php if($this->params->get('type') == 'produit'): ?>
        <ul class="list-items">
    <?php endif; ?>
    
    <?php foreach($this->items as $item): ?>
        <?php
            $this->item = &$item;
            if($this->params->get('type') == 'produit')
                echo $this->loadTemplate('itemproduct');
            else    
                echo $this->loadTemplate('item');
        ?>
    <?php endforeach; ?>
    
    <?php // push suggestion
    if($this->params->get('type') == 'produit'): ?>
        <?php if($this->pagination->get('pages.current') == $this->pagination->get('pages.total')): ?>
            <li>
                <div class="push-suggest">
                    <a href="<?php echo JRoute::_('index.php?option=com_chronoforms&Itemid=266'); ?>">
                        <img src="<?php echo JURI::base() . '/templates/' . $app->getTemplate() . '/images/suggestion-voyage-en-direct.jpg'; ?>" alt="Suggestions de voyages" />
                    </a>
                </div>
            </li>
        <?php endif; ?>
    <?php endif; ?>   
    
    <?php if($this->params->get('type') == 'produit'): ?>
        </ul>
    <?php endif; ?>

    <div class="pagination">
        <?php echo $this->pagination->getPagesLinks(); ?>
    </div>

</div>
<script>
    $(document).ready(function() {
        $('.choices-partner .list .selected').click(function() {
            $('.choices-partner .list .children').slideToggle({
                duration: 400
            });
            return false;
        });
        $('.choices-partner .list .children a').each(function(index, element){
            $(this).click(function(){
                $(location).attr('href', '<?php echo JURI::base() . 'annuaire?c=&p=' . JRequest::getVar('p') . '&t='; ?>' + $(this).attr('data-value'));
            });
        });
        
        $(document).click(function(){
            $(".choices-partner .list .children").slideUp(150);
        });
	});
	var myloc = window.location.href;
	var locarray = myloc.split("/");

	var text = locarray[(locarray.length-1)];
	var replace = "text.replace('?limitstart=0' , ' ')";
	<?php for ($i =0; $i <= $this->countItems; $i++){ ?>
		
		replace += ".replace('?start=<?php echo $i++; ?>','')";
	<?php }; ?>
		res = eval(replace);
		document.getElementById("term").innerHTML = res ;
	
</script>