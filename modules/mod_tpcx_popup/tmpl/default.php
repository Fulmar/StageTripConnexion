<?php

/**
 * Template Tpcx 
 *
 * @author Fabien Vautour 
 */

// no direct access
defined('_JEXEC') or die;

if($_COOKIE["popup-email"] == 1) {
    $showPopup = false;
} else {
    $showPopup = true;
    setcookie("popup-email", 1, time() + $params->get('cookie_expire'));
    if(!isset($_COOKIE["popup-email-count"])) {
        $count = 0;
    } else {
        $count = $_COOKIE["popup-email-count"] + 1;
    }
    setcookie("popup-email-count", $count);
    
    if($count == $params->get('count_show')) {
        $showPopup = false;
        setcookie("popup-email-count", 0);
        setcookie("popup-email", 1, time() + $params->get('reshow_popup'));   
    }
}

$db = JFactory::getDbo();
$db->setQuery(
    'SELECT * FROM joomla_tpcx_account_users WHERE address_ip = "' . $_SERVER['REMOTE_ADDR'] . '"'
);
$db->query();
if($db->getNumRows() > 0) {
    $showPopup = false;
}

?>
<div id="popup-email" class="popup">
    <div class="form">
        <div class="content1" style="display: none;">
            <div class="img-1">
                <h2 class="titre-popup" style="font-size: 20px;">En créant un compte vous pourrez :</h2>
                <br />
                
                <img src="<?php echo JURI::base() ?>templates/tpcx/images/popup-bg-1.png" />
            </div>
            <div class="img-2">
                <h2 class="titre-popup" style="text-align: center;">Inscription</h2>
                <div class="border"></div>
                <a class="link-register-email" href="#">
                    <span>S'inscrire avec votre email &gt;&gt;</span>
                </a>
                <div class="border"></div>
            </div>
        </div>
        <div class="content2">
            <div class="img-3">
                <img src="<?php echo JURI::base() ?>templates/tpcx/images/popup-bg-2.png" />
            </div>
            <p class="intro-popup">Nos partenaires ont souvent des avantages ou des promotions ! En créant une alerte vous serez sûrs d'être tenus <br> informés des offres et bons plans qui pourraient vous
				intéresser ! Merci de nous indiquer quels sont les voyages que<br> vous aimeriez réaliser prochainement :</p>
                
            <div class="box-input box-input-tag" id="eventInputTag">
                <div class="input-tag">
                    <input type="hidden" name="jform[tags_value]" id="jform_tags_value" />
                    <input type="text" name="jform[tags]" id="jform_tags"
                        value=""
                        placeholder="<?php echo JText::_('Tapez ici une destination (continent, pays, région...) ou bien une thématique'); ?>" class="input-text input-tag" />
                    <button type"button" class="button-add-tag"><span>+ ajouter une alerte de voyage</span></button>
                </div>
                <div class="tags-selected clearfix">
                    <ul></ul>
                </div>
                <div class="img-4">
                    <img src="<?php echo JURI::base() ?>templates/tpcx/images/popup-bg-3.png" />
                </div>
                <div class="form_popup">
                    <div class="clearfix box-form" style="margin-bottom: 15px;">
                        <div class="input-box">
                            <label>Civilité :</label>
                            <select class="input required" name="civilite">
                                <option value="">--- Choisissez ---</option>
                                <option value="Mlle">Mlle</option>
                                <option value="Mme">Mme</option>
                                <option value="M">M</option>
                            </select>
                        </div>
                        <div class="input-box">
                            <label>Votre nom :</label>
                            <input type="text" class="input required width-200" name="nom" value="" />
                        </div>
                        <div class="input-box">
                            <label>Votre prénom :</label>
                            <input type="text" class="input required width-200" name="prenom" value="" />
                        </div>
                    </div>
                    <div class="clearfix box-form" style="margin-bottom: 15px;">
                        <div class="input-box">
                            <label>Votre email :</label>
                            <input type="text" class="input required width-200" name="email" value="" />
                        </div>
                    </div>
                    <div class="box-form">
                        <p>Souhaitez-vous recevoir les informations sur les bons plans de voyage de<br />
                        TripConnexion et de ses partenaires ?</p>
                    </div>
                    <div class="clearfix box-form box-radio" style="margin-bottom: 15px;">
                        <div class="input-box">
                            <label for="newsletter_oui">Oui :</label>
                            <input type="radio" id="newsletter_oui" name="newsletter" value="1" />
                        </div>
                        <div class="input-box">
                            <label for="newsletter_non">Non :</label>
                            <input type="radio" id="newsletter_non" name="newsletter" value="0" />
                        </div>
                    </div>
                    <div class="buttons clearfix">
                        <div class="button-account">
                            <a class="link-create-account" href="#">
                                <span>Confirmer ses alertes voyage &gt;&gt;</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="response" style="display: none;">
            </div>
        </div>
    </div>
</div>
<script>
function IsEmail(email) {
  var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  return regex.test(email);
}

$(document).ready(function() {
    <?php if($showPopup): ?>
    if( !/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
        var fancy = setTimeout(function () {
            $.fancybox.open([
            {
                href : '#popup-email'
            }  
            ], {
                wrapCSS: 'fancybox-popup',
                scrolling: 'no',
                minWidth: 938,
                afterShow: function() {
                    $('.fancybox-inner').css('overflow', 'visible');
                }
            });
        }, <?php echo $params->get('show_popup'); ?>);
    }
    <?php endif; ?>
    
    $('a.link-register-email').click(function(){
        event.preventDefault();
        $('.content1').hide();
        $('.content2').show();
    });
    
    $('a.link-create-account').click(function(){
        event.preventDefault();
        
        inputCivilite = $('.form .form_popup select[name=civilite]');
        inputNom = $('.form .form_popup input[name=nom]');
        inputPrenom = $('.form .form_popup input[name=prenom]');
        inputNewsletter = $('.form .form_popup input:radio[name=newsletter]:checked');
        
        inputCivilite.removeClass('error');
        inputNom.removeClass('error');
        inputPrenom.removeClass('error');
        
        error = false;
        
        if(inputCivilite.val() == "") {
            inputCivilite.addClass('error');
            error = true;
        }
        
        if(inputNom.val() == "") {
            inputNom.addClass('error');
            error = true;
        }
        
        if(inputPrenom.val() == "") {
            inputPrenom.addClass('error');
            error = true;
        }
        
        $('.form .form_popup label.msg-error').remove();
        inputEmail = $('.form .form_popup input[name=email]');
        inputEmail.removeClass('error');
        
        if(!IsEmail(inputEmail .val())) {
            inputEmail.addClass('error');
            inputEmail.parent().append("<label class='msg-error'>L'email n'est pas correct</label>");
            error = true;
        }
        
        // radio
        if(inputNewsletter.val() == undefined) {
            $(".form .form_popup .box-radio").append("<label class='msg-error'>Veuillez indiquer si vous souhaitez recevoir notre newsletter</label>");
            error = true;
        }
        
        if(error) {
            return false;
        }
        
        $.ajax({
            url: baseUrl + 'index.php?option=com_tpcxtags&task=accountcreate',
            dataType: "json",
            data: {
                selection: $('#jform_tags_value').val(),
                civilite: inputCivilite.val(),
                nom: inputNom.val(),
                prenom: inputPrenom.val(),
                email: inputEmail.val(),
                newsletter: inputNewsletter.val()
            },
            success: function( data ) {
                $('.form #eventInputTag').hide();
                if(data.error) {
                    $('.form .response').append('<p class="response-error">' + data.errorMsg + '</p>');
                    $('.form .response').show();
                } else {
                    $('.form .response').append('<p class="response-success">Votre inscritpion a bien été prise en compte. Vous serez prochainement averti par email de l\'ouverture de votre espace personnel.</p>');
                    $('.form .response').append('<p class="response-success">Merci de votre confiance.</p>');
                    $('.form .response').show();
                }
            }
        });
    });
    
    // autocomplete
    $('#jform_tags').autocomplete({
        appendTo: "#eventInputTag",
        source: function( request, response ) {
            //term = request.term.split(/,\s*/).pop();
            term = request.term;
            $.ajax({
                url: baseUrl + 'index.php?option=com_tpcxtags&task=listtags',
                dataType: "json",
                data: {
                    term: term
                },
                success: function( data ) {
                    response( $.map( data, function( item ) {
                        return {
                            label: item.tag,
                            value: item.id
                        }
                    }));
                }
            });
        },
        focus: function( event, ui ) {
            return false;
        },
        select: function(event, ui) {
            // input hidden
            var values = $('#jform_tags_value').val();
            values = values.split(/,/).filter(Boolean);
            if(values.length > 5) {
                alert('Vous ne pouvez mettre plus de 6 thématiques');
                return false;
            }
            values.push(ui.item.value);
            values = values.join();
            $('#jform_tags_value').val(values);
            
            // list
            $( "<li>" )
                .attr('data-value', ui.item.value)
                .text(ui.item.label)
                .append( $('<a>').text('X')
                        .attr('onclick', 'delete_tag(this)')
                        .attr('class', 'delete')
                        .attr('href', 'javascript:void(0)')
                )
                .appendTo( $('.tags-selected ul') );
            
            this.value = '';
            return false;
        }
    }).data("ui-autocomplete")._renderItem = function( ul, item ) {
        ul.addClass('autocomplete-tags');
        return $( "<li>" )
            .attr( "data-value", item.value )
            .append( $( "<a>" ).text( item.label ) )
            .appendTo( ul );
    };
    
    

});
function delete_tag(element)
{
    var value = $(element).parent().attr('data-value');
    
    var values = $('#jform_tags_value').val();
    values = values.split(/,/).filter(Boolean);
    for(var i = 0; i <= values.length - 1; i++){
        if (values[i] == value)
            values.splice(i, 1);
    }
    values = values.join();
    $('#jform_tags_value').val(values);
                
    $(element).parent().remove();
}
</script>
