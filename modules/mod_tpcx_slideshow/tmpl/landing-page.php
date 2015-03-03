<?php
/**
 * @package     TpCx
 * @subpackage  mod_tpcx_slideshow
 * @author      Fabien Vautour
 */

// no direct access
defined('_JEXEC') or die ;

$app = JFactory::getApplication();
$menu 		= 	$app->getMenu();
$active 	=	$menu->getActive();

$baseurl = JURI::base();

$template = $app -> getTemplate();
?>

<div id="slideshow" <?php echo ($active == $menu->getDefault() ? '' : 'style="display: none;"'); ?>>

    <div class="arguments landing-page">
        <div class="form">
            <p><?php echo $params->get('textbtn'); ?></p>
            <div class="clearfix" style="position: relative;">
                <input type="text" class="input-destination-home" name="pays-slideshow" placeholder="Tapez votre destination..." />
                <button type="submit" name="search" class="btn-destination-search"><span><i class="fa fa-search"></i></span></button>
                <ul id="list-destination" class="list-destination">
                    <?php foreach($listPays as $item): ?>
                        <li><a data-value="<?php echo $item->id; ?>" href="javascript:;"><?php echo $item->tag; ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
    
    <div id="slides">
        <div class="loader"></div>
        <ul style="display: none;">
            <?php for($i = 1; $i <= 5; $i++): ?>
                <?php if($params->get('image' . $i)): ?>
                <li>
                    <div class="slide">
                        <?php if($params->get('link' . $i)): ?>
                        <a href="<?php echo $params->get('link' . $i); ?>">
                        <?php endif; ?>
                            <img width="<?php echo $params->get('slideshowWidth'); ?>" height="<?php echo $params->get('slideshowHeight'); ?>" style="margin-left: -<?php echo round($params->get('slideshowWidth') / 2); ?>px;" class="image" src="<?php echo $baseurl . '/' . $params->get('image' . $i); ?>" alt="" />
                        <?php if($params->get('link' . $i)): ?>
                        </a>
                        <?php endif; ?>
                        
                        <div class="wrapper">
                            <p><?php echo $params->get('text' . $i); ?></p>
                        </div>
                    </div>
                </li>
                <?php endif; ?>
            <?php endfor; ?>
        </ul>
    </div>
    
    <a href="javascript:void(0)" class="prev-link"></a>
    <a href="javascript:void(0)" class="next-link"></a>

</div>
                
<div class="select-pays-responsive">
    <div class="form">
        <p><?php echo $params->get('textbtn'); ?></p>
        <div class="clearfix" style="position: relative;">
            <input type="text" class="input-destination-home" name="pays-slideshow" placeholder="Tapez votre destination..." />
            <button type="submit" name="search" class="btn-destination-search"><span><i class="fa fa-search"></i></span></button>
            <ul id="list-destination" class="list-destination">
                <?php foreach($listPays as $item): ?>
                    <li><a data-value="<?php echo $item->id; ?>" href="javascript:;"><?php echo $item->tag; ?></a></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</div>

<a id="inlinedataproject" href="#dataproject"></a>

<div style="display:none">
    <div id="dataproject" class="popup-search">
        <h3>Affinez votre recherche</h3>
        <p class="selection-recherche">Pour votre recherche <span id="term-project" class="term"></span>, vous souhaitez :</p>
        <div style="margin-top: 20px; margin-left: 20px;">
            <div><a href="javascript:void(0);" id="btn-soumettre-projet"><img src="<?php echo $baseurl . 'templates/' . $template . '/images/btn-presenter-projet.png'; ?>" alt="" /></a></div>
            <div><a href="javascript:void(0);" id="btn-voir-partenaire"><img src="<?php echo $baseurl . 'templates/' . $template . '/images/btn-partenaire.png'; ?>" alt="" /></a></div>
            <div><a href="javascript:void(0);" id="btn-voir-voyages"><img src="<?php echo $baseurl . 'templates/' . $template . '/images/btn-voyages.png'; ?>" alt="" /></a></div>
        </div>
    </div>
</div>

<script type="text/javascript">
$(window).load(function(){
    
    function resizeSlideshow()
    {
        var  heightMax = 0;
        $('#slideshow #slides ul li .slide .image').each(function( index ) {
            if($(this).height() > heightMax)
                heightMax = $(this).height();
        });
        
        $('#slideshow').height(heightMax);
        $('.arguments').height(heightMax);
        $('.arguments .form').show();
    }
    
    /*resizeSlideshow();
    $(window).resize(function(){
        resizeSlideshow();
    });*/
    
    $('#slides ul').show();
    $('#slides .loader').hide();
    
    $('#slides ul').innerFade({
        speed: 1000,
        timeout: 4000,
        loop: true,
        containerHeight: '556px',
        prevLink: '.prev-link',
        nextLink: '.next-link'
    });
    
    // autocomplete
    var destination = [
        <?php foreach($listPays as $item): ?>
        {
            id: "<?php echo $item->id; ?>",
            value: "<?php echo $item->tag; ?>",
            label: "<?php echo $item->tag; ?>"
        },
        <?php endforeach; ?>
    ];
    
    var accentMap = {
		"é": "e",
		"É": "e",
		"ö": "o",
		"à": "a"
    };
    
    var normalize = function( term ) {
		var ret = "";
		for ( var i = 0; i < term.length; i++ ) {
			ret += accentMap[ term.charAt(i) ] || term.charAt(i);
		}
		return ret;
    };
    
    $('.input-destination-home').autocomplete({
        minLenght: 0,
        autoFocus: true,
        source: function( request, response ) {
        	var matcher = new RegExp( $.ui.autocomplete.escapeRegex( extractLast(request.term) ), "i" );
            response( $.grep( destination, function( value ) {
                value = value.label || value.value || value;
                return matcher.test( value ) || matcher.test( normalize( value ) );
            }) );
        },
       // source: destination,
        change: function(event, ui) {
            
        },
        select: function(event, ui) {
            value = ui.item.id;
            
            $.ajax({
                dataType: "json",
                url: baseUrl + 'index.php?option=com_tpcxtags&task=checkproduct&continent_id=&pays_id='
                              + value + '&thematique_id=',
                success: function(data) {
                    
                    // products empty
                    if(data == 0) {
                        $('#btn-voir-voyages').parent().hide();
                    } else {
                        $('#btn-voir-voyages').parent().show();
                    }
                    
                    $('select[name=choix-pays-1]').val(value);
                    $('select[name=choix-pays-1]').next().children(".customSelectInner").html(ui.item.label);
                    $('.box-form-pays-2').show();
                    
                    $('.selection-recherche #term-project').empty();
                    $('.selection-recherche #term-project').append(ui.item.label);
                    
                    $("a#inlinedataproject").trigger('click');
                    
                    $("a#btn-soumettre-projet").bind('click', function(e){
                        e.preventDefault();
                        $.fancybox.close();
                        $("html, body").animate({
                            scrollTop: $("#travel-project-container").offset().top - 101
                        }, {
                            duration: 400,
                            complete: function() {
                                
                            }
                        });
                    });
                    
                    $("a#btn-voir-partenaire").bind('click', function(e){
                        e.preventDefault();
                        $.fancybox.close();
                        $(location).attr('href', baseUrl + 'annuaire?c=&p=' + value + '&t=');
                    });
                                
                    $("a#btn-voir-voyages").bind('click', function(e){
                        e.preventDefault();
                        $.fancybox.close();
                        $(location).attr('href', baseUrl + 'voyages?c=&p=' + value + '&t=');
                    });
                    
                }
            });
            
        }
    });
    
    $( ".btn-destination-search" ).click(function() {
    	$('.input-destination-home').trigger('focus');
    });
    
});

</script>
