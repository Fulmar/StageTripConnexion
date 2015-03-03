<?php
/**
 * @package     TpCx
 * @subpackage  mod_tpcx_devis
 * @author      Florent Fulmar
 */

// no direct access
defined('_JEXEC') or die ;

$app = JFactory::getApplication();
$baseurl = JURI::base();

$template = $app -> getTemplate();
//537
?>

<div id="devis-sur-mesure" href="#">
    
    <div class="wrapper-big">
        <div class="wrapper">
			<div class="devis-sur-mesure">
				<p class="title">Comment recevoir<br> des devis ?</p>
				<p class="subtitle">Vous nous détaillez <br>votre futur projet de voyage</p>
				<p class="subtitle">Nous faisons suivre votre<br>demande aux acteurs locaux<br>concernés</p>
				<p class="subtitle">Vous recevez leurs propositions<br>et dialoguez directement<br>avec eux !</p>
				<div class="buttonDevis">
					<button class="submit devis-next-step">
						<span>Demander un devis</span>
					</button>
				</div>
			</div>
		</div>
    </div>
</div>
<script>
    $(document).ready(function() {
        resize();
        // link scroll
        $(".buttonDevis button.submit, #devis-sur-mesure").click(function(event) {
            event.preventDefault();
            $("body, html").animate({
                scrollTop: $("#travel-project-container").offset().top
            });    
        });
    });
</script>