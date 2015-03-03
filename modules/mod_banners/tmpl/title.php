<?php
/**
 * @package     TpCx
 * @subpackage  mod_tpcx_slideshow
 * @author      Florent Fulmar
 */

// no direct access
defined('_JEXEC') or die ;

$app = JFactory::getApplication();
$baseurl = JURI::base();

$template = $app -> getTemplate();
?>
<div class="mag-nouvelle-recherche">
</div>
<div>
	<div class="recherche-magazine">
		<a class="magazine-link"href="javascript:;"/></a>
		<span>
			<a id="recherche-mag" href="javascript:;"><i class="fa fa-search"></i></a>
			<a id="close-btn" href="javascript:;"><i class="closeflyout"></i></a>
		</span>
	</div>
	<input "type="text" class="input-magazine-home" name="magazine" placeholder="Indiquez ici une destination ou une thématique..." />
	<script>
	$(document).ready(function(){
		$('.magazine-link').click(function(event) {
			event.preventDefault();
			var myloc = window.location.href;
			var locarray = myloc.split("/");
			if(locarray[(locarray.length-2)]=="pays" || locarray[(locarray.length-2)]=="continent" || locarray[(locarray.length-2)]=="thematiques"){
				delete locarray[(locarray.length-1)];
				delete locarray[(locarray.length-2)];
				window.location=locarray.join("/")+"magazine";
			}else
			{
				locarray.join("/");
				window.location.href= "magazine";
			}
		});
		$('#recherche-mag').click(function(event) {
			event.preventDefault();
			$('.magazine p.title-header,.magazine p.home-page').hide();
			//$('.input-magazine-home').show();
			$('.input-magazine-home').addClass( 'js-flyout-active' );
			$('.input-magazine-home').addClass( 'focus-input' );
			$('#content .banner-title .wrapper').css( 'background-color','#7f7d28' );
			$('#recherche-mag').hide();
			$('#close-btn').show();
			$('.focus-input').focus();
			$('.recherche-magazine .magazine-link').css({ 'width':'55px','right': '948px'});
		});
		$('#close-btn').click(function(event) {
			event.preventDefault();
			$('#close-btn').hide();
			$('.input-magazine-home').removeClass( 'js-flyout-active' );
			$('#content .banner-title .wrapper').css( 'background-color','#999933' );
			$('.magazine p.title-header,.magazine p.home-page').show(); 
			$('#recherche-mag').show();
			$('.recherche-magazine .magazine-link').css({ 'width':'613px','right': '390px'});
		});
		currentWidth = Response.viewportW();
		if(currentWidth > 1020) {
			$('.rightcolumn #content .content-bottom .wrapper-big').css('padding-top','50px');
		}
		else
		{
			$('.rightcolumn #content .content-bottom .wrapper-big').css('padding-top','30px');
		}
		var destination = [

			<?php foreach($listPays as $item): ?>
			{
				id: "<?php echo $item->path; ?>",
				value: "<?php echo $item->title; ?>",
				label: "<?php echo $item->title; ?>",
			},
			<?php endforeach; ?>
			<?php foreach($listThematique as $item): ?>
			{
				id: "<?php echo $item->path; ?>",
				value: "<?php echo $item->title; ?>",
				label: "<?php echo $item->title; ?>",
			},
			<?php endforeach; ?>
			<?php foreach($listContinent as $item): ?>
			{
				id: "<?php echo $item->path; ?>",
				value: "<?php echo $item->title; ?>",
				label: "<?php echo $item->title; ?>",
			},
			<?php endforeach; ?>
		];
        
        var normalize = function( term ) {
            var ret = "";
            for ( var i = 0; i < term.length; i++ ) {
                ret += accentMap[ term.charAt(i) ] || term.charAt(i);
            }
            return ret;
        };
		$('.input-magazine-home').autocomplete({
			minLenght: 0,
			autoFocus: true,
			source: function( request, response ) {  
				var matcher = new RegExp( $.ui.autocomplete.escapeRegex( extractLast(request.term) ), "i" );
				response( $.grep( destination, function( value ) {
					value = value.truc || value.value || value;
					return matcher.test( value ) || matcher.test( normalize( value ) );
				}) );
			},
			
			select: function(event, ui) {
				value = ui.item.id;
				$.ajax({
					dataType: "json",
					url: baseUrl + 'index.php?option=com_tpcxtags&task=checkproduct&continent_id=&pays_id='
								  + value + '&thematique_id=',
					success: function(data) {
						var myloc = window.location.href;
						var locarray = myloc.split("/");
						if(locarray[(locarray.length-2)]=="pays" || locarray[(locarray.length-2)]=="continent" || locarray[(locarray.length-2)]=="thematiques"){
							delete locarray[(locarray.length-1)];
							delete locarray[(locarray.length-2)];
							window.location=locarray.join("/")+value;
						}else
						{
							locarray.join("/");
							window.location.href= value;
						}
					}
				});
			}
		});
	});
	</script>
</div>