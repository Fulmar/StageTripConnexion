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

<div class="annuaire-hpHeader">
	<div class="wrapper-big">
		<div class="wrapper">
			<h2>Trouvez et contactez directement les experts locaux qui vous plaisent en fonction de votre destination:</h2>
			<div class="recherche">
				<input type="text" class="input-destination-annuaire-hpheader" name="pays-slideshow" placeholder="Où souhaitez-vous allez ?" />
				<button type="submit" name="search" class="btn-destination-search"><span><i class="fa fa-search"></i></span></button>
				<ul id="list-destination" class="list-destination">
					<?php foreach($listPays as $item): ?>
						<li><a data-value="<?php echo $item->id; ?>" href="javascript:;"><?php echo $item->tag; ?></a></li>
					<?php endforeach; ?>
				</ul>
			</div>
		</div>
	</div>
</div>
<script>
            
            
$(document).ready(function(){
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
	$('.input-destination-annuaire-hpheader').autocomplete({
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
					
					if(data.travels == 0 && data.partners == 0) {
						$("html, body").animate({
							scrollTop: $("#travel-project-container").offset().top - 0
						}, {
							duration: 400,
							complete: function() {
								
							}
						});
						return;
					}
					
					// products empty
					if(data == 0) {
						$('#btn-voir-voyages').parent().hide();
					} else {
						$('#btn-voir-voyages').parent().show();
					}
					
					// partners empty
					// if(data.partners == 0) {
						// $('#btn-voir-partenaire').parent().hide();
					// } else {
						// $('#btn-voir-partenaire').parent().show();
					// }
					
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
							scrollTop: $("#travel-project-container").offset().top - 0
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
});


        </script>