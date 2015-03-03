<?php
/**
 * @package     TpCx
 * @subpackage  mod_tpcx_concept
 * @author      Florent Fulmar
 */

// no direct access
defined('_JEXEC') or die ;

$app = JFactory::getApplication();
$baseurl = JURI::base();

$template = $app -> getTemplate();
//537
?>

<div id="concept-home">
		<div class="wrapper-big">
			<div class="wrapper">
				<div class="flech-header" style="overflow:initial;">
					<img alt="" src="<?php JURI::base(); ?>templates/tpcx/images/flech-concept.png" />
				</div>
				<div class="concept-home">
					<p class="title-pig">Moins cher</p>
					<p class="subtitle" >Vous voyagez en direct avec les locaux.<br>Sans aucun intermédiaire, il y'a zéro commission !</p>
					<p class="title-chrono">Rapide</p>
					<p class="subtitle" >En 2 clics, vous trouvez, comparez et contactez des <br>agences locales et des guides partout dans le monde !</p>
					<p class="title-hand">Transparent</p>
					<p class="subtitle" >Vous dialoguez et créez votre voyage vraiment en<br> direct avec les spécialistes sur place !</p>
					<div class="mapmonde">
						<p class="subtitle-top">Dites stop aux intermédiaires et voyagez en direct avec les <br>agences locales, guides indépendants, associations...</p>
						<div class="map">
						</div>
						<p class="subtitle-bottom">TripConnexion est un outil gratuit pour trouver et <br>contacter les experts locaux du voyage !</p>
					</div>
					<div class="input" style="position: absolute;">
					<form action="#" autocomplet="off">
						<div class="box-form">
							<input type="text" name="p-text" class="input-destination-concept-recherche" placeholder="Où souhaitez-vous aller ?"  required/>
							<ul id="list-destination" class="list-destination">
								<?php foreach($listPays as $item): ?>
									<li><a data-value="<?php echo $item->id; ?>" href="javascript:;"><?php echo $item->tag; ?></a></li>
								<?php endforeach; ?>
							</ul>
						</div>
						<div class="box-form">
							<select id="customSelectConcept" name="" class="customSelectConcept" required>
								<option value="">Que recherchez-vous ?</option>
								<option class="btn-soumettre-projet" value="1" href="javascript:void(0);">Recevoir des devis sur mesure en présentant mon projet de voyage</option>
								<option class="btn-voir-voyages" value="3" href="javascript:void(0);">Parcourir des suggestions de circuits pour me donner des idées</option>
								<option class="btn-voir-partenaire" value="2" href="javascript:void(0);">Trouver et contacter directement les experts locaux qui me plaisent</option>	
							</select>
						</div>
						<div class="box-form">
							<button type="submit" name="search" class="submit btn-destination-search-hp-header"><span>Rechercher&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-search"></i></span></button>
						</div>
					</form>
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
	$('.input-destination-concept-recherche').autocomplete({
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
							scrollTop: $("#travel-project-container").offset().top - 101
						}, {
							duration: 400,
							complete: function() {
								
							}
						});
						return;
					}
					
					// products empty
					if(data == 0) {
						$('.btn-voir-voyages').hide();
					} else {
						$('.btn-voir-voyages').show();
					}
					$('select[name=choix-pays-1]').val(value);
					$('select[name=choix-pays-1]').next().children(".customSelectInner").html(ui.item.label);
					$('.box-form-pays-2').show();
					
					$('.selection-recherche #term-project').empty();
					$('.selection-recherche #term-project').append(ui.item.label);
					
					$(".btn-destination-search-hp-header").click( function(e){
						if(document.getElementById("customSelectConcept").value == 1){
							e.preventDefault();
							$.fancybox.close();
							$("html, body").animate({
								scrollTop: $("#travel-project-container").offset().top - 0
							}, {
								duration: 400,
								complete: function() {
									
								}
							});
						}


						if(document.getElementById("customSelectConcept").value == 2){
							e.preventDefault();
							$.fancybox.close();
							$(location).attr('href', baseUrl + 'annuaire?c=&p=' + value + '&t=');
						}
									
						if(document.getElementById("customSelectConcept").value == 3){
							e.preventDefault();
							$.fancybox.close();
							$(location).attr('href', baseUrl + 'voyages?c=&p=' + value + '&t=');
						}
						
					});
				}
			});
		}
	});
});


        </script>
		</div>  
</div>
