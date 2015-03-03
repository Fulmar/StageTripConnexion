<?php
/**
 * @package     TpCx
 * @subpackage  mod_tpcx_slideshow
 * @author      Fabien Vautour
 */

// no direct access
defined('_JEXEC') or die ;

$app = JFactory::getApplication();
$baseurl = JURI::base();

$template = $app -> getTemplate();
?>

<div id="travel-project-container">
    
    <a name="atravelproject"></a>
    
    <div class="wrapper-big">
        <div class="wrapper">
            
            <div class="travel-project">
                <p class="title">Présentez votre projet de voyage</p>
                <p class="subtitle">Ne perdez plus de temps à trouver les partenaires de voyage sérieux, nous les contactons directement pour vous !</p>
                
                <form name="travelForm" id="travelForm" action="<?php echo $urlAction; ?>" method="post">
                    <input type="hidden" name="sendform" value="1" />
                    <input type="hidden" name="url_redirection" value="<?php echo JURI::base() . $urlRedirection; ?>" />
                    <input type="hidden" name="email_send" value="<?php echo $params->get('email_send'); ?>" />
                    <input type="hidden" name="provenance" value="FORMULAIRE_PROJET_VOYAGE" />
                
                    <div class="container-form">
                        
                        <div class="box-form-inline box-form-pays-1">
                            <label class="text">Quel pays souhaitez vous visiter ? *</label>
                            <select name="choix-pays-1" class="customSelectTravel required" onchange="$('.label-choix-pays-1').html(this.options[this.selectedIndex].innerHTML);">
                                <option value="">--- Choisissez ---</option>
                                <?php foreach($listPays as $pays): ?>
                                <option value="<?php echo $pays->id; ?>"><?php echo $pays->tag; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <div class="box-form-inline box-form-pays-2">
                            <label class="text">Souhaitez-vous visiter un autre pays au cours du même voyage ?</label>
                            <select name="choix-pays-2" class="customSelectTravel" onchange="if(this.value != '') $('.box-pays-2').show(); else $('.box-pays-2').hide(); $('.label-choix-pays-2').html(this.options[this.selectedIndex].innerHTML);">
                                <option value="">Non</option>
                                <?php foreach($listPays as $pays): ?>
                                <option value="<?php echo $pays->id; ?>"><?php echo $pays->tag; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <div class="box-form-inline box-form-pays-3">
                            <label class="text">Souhaitez-vous visiter un autre pays au cours du même voyage ?</label>
                            <select name="choix-pays-3" class="customSelectTravel" onchange="if(this.value != '') $('.box-pays-3').show(); else $('.box-pays-3').hide(); $('.label-choix-pays-3').html(this.options[this.selectedIndex].innerHTML);">
                                <option value="">Non</option>
                                <?php foreach($listPays as $pays): ?>
                                <option value="<?php echo $pays->id; ?>"><?php echo $pays->tag; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <div class="container-box">
                        
                            <div class="box-form">
                                <label>Départ souhaité le *</label>
                                <input type="text" id="date-depart" name="date-depart" class="input-travel-text input-datepicker required" />
                            </div>
                            
                            <div class="box-form">
                                <label>Durée prévue * :</label>
                                <select name="duree-prevue" class="customSelectTravel required">
                                    <option value="">--- Choisissez ---</option>
                                    <?php for($i = 1; $i <= 45; $i++): ?>
                                    <option value="<?php echo $i; ?>">
                                        <?php echo $i; ?> jour<?php echo ($i == 1 ? '' : 's'); ?>
                                        <?php echo ($i == 45 ? ' et plus' : ''); ?>
                                    </option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                            
                            <div class="box-form">
                                <label>A plus ou moins :</label>
                                <select name="plus-ou-moins" class="customSelectTravel">
                                    <option value="">--- Choisissez ---</option>
                                    <?php for($i = 1; $i <= 5; $i++): ?>
                                    <option value="<?php echo $i; ?>">
                                        <?php echo $i; ?> jour<?php echo ($i == 1 ? '' : 's'); ?>
                                        <?php echo ($i == 5 ? ' et plus' : ''); ?>
                                    </option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                        
                        </div>
                        
                        <div class="container-box">
                        
                            <div class="box-form">
                                <label>Nombre d'adultes * :</label>
                                <select name="nombre-adultes" class="customSelectTravel required">
                                    <option value="">--- Choisissez ---</option>
                                    <?php for($i = 1; $i <= 25; $i++): ?>
                                    <option value="<?php echo $i; ?>">
                                        <?php echo $i; ?>
                                        <?php echo ($i == 25 ? ' et plus' : ''); ?>
                                    </option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                            
                            <div class="box-form">
                                <label>Nombre d'enfants de 2 à 12 ans :</label>
                                <select name="nombre-enfants-2-12" class="customSelectTravel">
                                    <option value="">--- Choisissez ---</option>
                                    <?php for($i = 0; $i <= 25; $i++): ?>
                                    <option value="<?php echo $i; ?>">
                                        <?php echo $i; ?>
                                        <?php echo ($i == 25 ? ' et plus' : ''); ?>
                                    </option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                            
                            <div class="box-form">
                                <label>Nombre d'enfants de moins de 2 ans :</label>
                                <select name="nombre-enfants-moins-12" class="customSelectTravel">
                                    <option value="">--- Choisissez ---</option>
                                    <?php for($i = 0; $i <= 25; $i++): ?>
                                    <option value="<?php echo $i; ?>">
                                        <?php echo $i; ?>
                                        <?php echo ($i == 25 ? ' et plus' : ''); ?>
                                    </option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                        
                        </div>
                        
                        <div class="button">
                            <button type="submit" class="submit travel-next-step">
                                <span>Valider</span>
                            </button>
                        </div>
                        
                        <div class="container-subform container-subform-1">
                            
                            <div class="border-top"></div>
                            
                            <h3>&bull;&nbsp;Vos envies</h3>
                            
                            <div class="box-form-textarea">
                                <label>
                                    Décrivez votre projet et de quelle façon vous souhaitez voyager * : <br />
                                </label>
                                <textarea name="envies" class="textarea-travel required" placeholder="Nous vous conseillons vivement d’expliquer ci dessous votre vision du voyage et vos envies, Plus vous serez précis, mieux les partenaires pourront répondre à vos attentes..."></textarea>
                            </div>
                        
                            <div class="box-form-inline">
                                <p class="text-radio">Avez vous déjà visité ce(s) pays :</p>
                                <div class="container-box">
                                    <p class="radio-box box-pays box-pays-1">
                                        <span class="label-choix-pays-1">Pays 1</span> : <input type="radio" name="visite-pays1" id="visite-pays1-1" value="1" /><label for="visite-pays1-1">Oui</label>
                                        <input type="radio" name="visite-pays1" id="visite-pays1-0" value="0" /><label for="visite-pays1-0">Non</label>
                                    </p>
                                    <p class="radio-box box-pays box-pays-2" style="display: none;">
                                        <span class="label-choix-pays-2">Pays 2</span> : <input type="radio" name="visite-pays2" id="visite-pays2-1" value="1" />
                                        <label for="visite-pays2-1">Oui</label>
                                        <input type="radio" name="visite-pays2" id="visite-pays2-0" value="0" />
                                        <label for="visite-pays2-0">Non</label>
                                    </p>
                                    <p class="radio-box box-pays box-pays-3" style="display: none;">
                                        <span class="label-choix-pays-3">Pays 3</span> : <input type="radio" name="visite-pays3" id="visite-pays3-1" value="1" />
                                        <label for="visite-pays3-1">Oui</label>
                                        <input type="radio" name="visite-pays3" id="visite-pays3-0" value="0" />
                                        <label for="visite-pays3-0">Non</label>
                                    </p>
                                </div>
                            </div>
                            
                            <div class="box-form-inline">
                                <p class="text-radio text-radio-left">De quelle façon<br /> souhaitez‐vous voyager :</p>
                                <p class="radio-box">
                                    <input type="radio" name="facon-voyager" id="facon-voyager-famille" value="famille" /><label for="facon-voyager-famille">Avec ma famille</label>
                                    <input type="radio" name="facon-voyager" id="facon-voyager-amis" value="amis" /><label for="facon-voyager-amis">Avec mes amis</label>
                                    <input type="radio" name="facon-voyager" id="facon-voyager-amoureux" value="amoureux" /><label for="facon-voyager-amoureux">En amoureux</label>
                                    <input type="radio" name="facon-voyager" id="facon-voyager-petit-groupe" value="petit-groupe" /><label for="facon-voyager-petit-groupe">Au sein d'un petit groupe organisé</label>
                                    <input type="radio" name="facon-voyager" id="facon-voyager-seul" value="seul" /><label for="facon-voyager-seul">Seul</label>
                                </p>
                            </div>
                            
                            <div class="box-form-inline">
                                <p class="text-radio text-radio-left">Souhaitez‐vous être accompagné d’un guide durant votre voyage ?</p>
                                <p class="radio-box">
                                    <input type="radio" name="guide" id="guide-jamais" value="jamais" />
                                    <label for="guide-jamais">Jamais</label>
                                    <input type="radio" name="guide" id="guide-necessaire" value="necessaire" />
                                    <label for="guide-necessaire">De temps en temps</label>
                                    <input type="radio" name="guide" id="guide-toujours" value="toujours" />
                                    <label for="guide-toujours">Toujours</label>
                                </p>
                            </div>
                            
                            <div class="box-form-inline">
                                <p class="text-radio">Quelles sont les thématiques que vous souhaiteriez donner à votre voyage ?</p>
                                <div class="container-box selection-radio">
                                    <div class="box-hebergement">
                                        <label>
                                            <span>Histoire et<br />
                                            culture</span>
                                            <img src="<?php echo $baseurl . 'templates/' . $template . '/images/form/travel/voyage-histoire-culture.png'; ?>" alt="" />
                                        </label>
                                        <input type="checkbox" name="thematique[]" id="thematique-histoire" value="histoire" />
                                    </div>
                                    <div class="box-hebergement">
                                        <label>
                                            <span>Les beaux paysages</span>
                                            <img src="<?php echo $baseurl . 'templates/' . $template . '/images/form/travel/voyage-paysages.png'; ?>" alt="" />
                                        </label>
                                        <input type="checkbox" name="thematique[]" id="thematique-paysages" value="paysages" />
                                    </div>
                                    <div class="box-hebergement">
                                        <label>
                                            <span>La vie quotidienne<br />
                                            des gens</span>
                                            <img src="<?php echo $baseurl . 'templates/' . $template . '/images/form/travel/voyage-vie-quotidienne.png'; ?>" alt="" />
                                        </label>
                                        <input type="checkbox" name="thematique[]" id="thematique-quotidien" value="quotidien" />
                                    </div>
                                    <div class="box-hebergement">
                                        <label>
                                            <span>Le confort</span>
                                            <img src="<?php echo $baseurl . 'templates/' . $template . '/images/form/travel/voyage-bien-etre.png'; ?>" alt="" />
                                        </label>
                                        <input type="checkbox" name="thematique[]" id="thematique-confort" value="confort" />
                                    </div>
                                </div>
                                <div class="container-box selection-radio">
                                    <div class="box-hebergement">
                                        <label>
                                            <span>La gastronomie</span>
                                            <img src="<?php echo $baseurl . 'templates/' . $template . '/images/form/travel/voyage-gastronomie.png'; ?>" alt="" />
                                        </label>
                                        <input type="checkbox" name="thematique[]" id="thematique-gastronomie" value="gastronomie" />
                                    </div>
                                    <div class="box-hebergement">
                                        <label>
                                            <span>La plongée</span>
                                            <img src="<?php echo $baseurl . 'templates/' . $template . '/images/form/travel/voyage-plongee.png'; ?>" alt="" />
                                        </label>
                                        <input type="checkbox" name="thematique[]" id="thematique-plongee" value="plongee" />
                                    </div>
                                    <div class="box-hebergement">
                                        <label>
                                            <span>Trek & randonnées</span>
                                            <img src="<?php echo $baseurl . 'templates/' . $template . '/images/form/travel/voyage-trek.png'; ?>" alt="" />
                                        </label>
                                        <input type="checkbox" name="thematique[]" id="thematique-trek" value="trek" />
                                    </div>
                                    <div class="box-hebergement">
                                        <label>
                                            <span style="text-align: left;">Autre(s)</span>
                                        </label>
                                        <input type="text" style="margin-left: 0;" name="thematique-autres-text" class="input-travel-text input-autre" />
                                    </div>
                                </div>
                            </div>
                            
                            <div class="box-form-inline">
                                <p class="text-radio">Quel type d'hébergement préférez‐vous ?</p>
                                <div class="container-box selection-radio2">
                                    <div class="box-hebergement">
                                        <label>
                                            <span>Hôtel standard<br />
                                            moins de 40 €</span>
                                            <img src="<?php echo $baseurl . 'templates/' . $template . '/images/form/travel/hotel-standard.png'; ?>" alt="" />
                                        </label>
                                        <input type="checkbox" name="hebergement[]" id="hebergement-standard" value="standard" />
                                    </div>
                                    <div class="box-hebergement">
                                        <label>
                                            <span>Hôtel supérieur<br />
                                            de 40 € à 100 €</span>
                                            <img src="<?php echo $baseurl . 'templates/' . $template . '/images/form/travel/hotel-superieur.png'; ?>" alt="" />
                                        </label>
                                        <input type="checkbox" name="hebergement[]" id="hebergement-superieur" value="superieur" />
                                    </div>
                                    <div class="box-hebergement">
                                        <label>
                                            <span>Hôtel de luxe<br />
                                            plus de 100 €</span>
                                            <img src="<?php echo $baseurl . 'templates/' . $template . '/images/form/travel/hotel-luxe.png'; ?>" alt="" />
                                        </label>
                                        <input type="checkbox" name="hebergement[]" id="hebergement-luxe" value="luxe" />
                                    </div>
                                    <div class="box-hebergement">
                                        <label>
                                            <span>Hébergement<br />
                                            d'exception</span>
                                            <img src="<?php echo $baseurl . 'templates/' . $template . '/images/form/travel/hebergement-exception.png'; ?>" alt="" />
                                        </label>
                                        <input type="checkbox" name="hebergement[]" id="hebergement-exception" value="exception" />
                                    </div>
                                    <div class="box-hebergement">
                                        <label>
                                            <span>Hébergement<br />
                                            insolite</span>
                                            <img src="<?php echo $baseurl . 'templates/' . $template . '/images/form/travel/hebergement-insolite.png'; ?>" alt="" />
                                        </label>
                                        <input type="checkbox" name="hebergement[]" id="hebergement-insolite" value="insolite" />
                                    </div>
                                    <div class="box-hebergement">
                                        <label>
                                            <span class="single">Chez l'habitant</span>
                                            <img src="<?php echo $baseurl . 'templates/' . $template . '/images/form/travel/chez-l-habitant.png'; ?>" alt="" />
                                        </label>
                                        <input type="checkbox" name="hebergement[]" id="hebergement-habitant" value="habitant" />
                                    </div>
                                </div>
                            </div>
                            
                            <div class="box-form-inline">
                                <p class="text-radio text-radio-left">Pour les repas souhaitez‐vous :</p>
                                <p class="radio-box">
                                    <input type="radio" name="repas" id="repas-petit-dejeuner" value="petit-dejeuner" />
                                    <label for="repas-petit-dejeuner">Simplement le petit déjeuner</label>
                                    <input type="radio" name="repas" id="repas-pension-complete" value="pension-complete" />
                                    <label for="repas-pension-complete">Une pension complète</label>
                                    <input type="radio" name="repas" id="repas-demi-pension" value="demi-pension" />
                                    <label for="repas-demi-pension">Une demi‐pension</label>
                                </p>
                            </div>
                            
                            <div class="box-form-inline">
                                <p class="text-radio text-radio-left">Avez-vous déjà réservé vos billets d’avion ?</p>
                                <p class="radio-box">
                                    <input type="radio" name="billet-avion" id="billet-avion-1" value="1" />
                                    <label for="billet-avion-1">Oui</label>
                                    <input type="radio" name="billet-avion" id="billet-avion-0" value="0" />
                                    <label for="billet-avion-0">Non</label>
                                </p>
                            </div>
                            
                            <div class="box-form-inline">
                                <p class="text-radio text-radio-left">Budget par personne et par jour * :</p>
                                <p class="radio-box">
                                    <input type="radio" name="budget" id="budget-60-100" value="60-a-100" />
                                    <label for="budget-60-100">De 60 à 100 €<br />
                                        --------------------<br />
                                        Des services de qualité<br />
                                        mais avant tout bon marché
                                    </label>
                                    <input type="radio" name="budget" id="budget-100-140" value="100-a-140" />
                                    <label for="budget-100-140">de 100 € - 140 €<br />
                                        --------------------<br />
                                        Des services où le confort<br />
                                        et l'originalité priment avant tout</label>
                                    <input type="radio" name="budget" id="budget-sup-140" value="140-sup" />
                                    <label for="budget-sup-140">+ de 140 €<br /> 
                                        --------------------<br />
                                        Pas de limite,<br />
                                        je veux le meilleur avant tout</label>
                                </p>
                                <p class="small">En donnant une idée budgétaire réaliste vous permettez au partenaire de vous répondre mieux et plus vite !</p>
                            </div>
                            
                            <div class="button">
                                <button type="submit" class="submit travel-next-step2">
                                    <span>Valider</span>
                                </button>
                            </div>
                            
                            <div class="container-subform container-subform-2">
                            
                                <div class="border-top"></div>
                                
                                <h3>&bull;&nbsp;Vous</h3>
                                
                                <div class="box-form-inline">
                                    <div class="container-box">
                                        <div class="box-33">
                                            <label class="text">Civilité :</label>
                                            <select name="civilite" class="customSelectTravel" style="height: 16px;">
                                                <option value="">--- Choisissez ---</option>
                                                <option value="Mlle">Mlle</option>
                                                <option value="Mme">Mme</option>
                                                <option value="M">M</option>
                                            </select>
                                        </div>
                                        <div class="box-33">
                                            <label class="text">Nom * :</label><input type="text" name="nom" class="input-travel-text required" />
                                        </div>
                                        <div class="box-33">
                                            <label class="text">Prénom * :</label><input type="text" name="prenom" class="input-travel-text required" />
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="box-form-inline">
                                    <div class="container-box">
                                        <div class="box-33">
                                            <label class="text">Email * :</label><input type="text" id="email_travel_project" name="email" class="input-travel-text required" />
                                        </div>
                                        <div class="box-33" style="width: 66%;">
                                            <label class="text">Confirmation d'email * :</label><input type="text" name="email_confirmation" class="input-travel-text required" equalTo="#email" />
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="box-form-inline">
                                    <div class="container-box">
                                        <div class="box-33">
                                            <label class="text">Téléphone * :</label><input type="text" name="telephone" class="input-travel-text required" />
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="box-form-inline">
                                    <p>Pour être certain de recevoir les bons plans et les infos utiles pour vos prochains voyages, souhaitez-vous abonner :</p>
                                    <p class="radio-box no-margin">
                                        A la newsletter de TripConnexion ? <input type="radio" name="newsletter" id="newsletter-1" value="1" />
                                        <label for="newsletter-1">Oui</label>
                                        <input type="radio" name="newsletter" id="newsletter-0" value="0" />
                                        <label for="newsletter-0">Non</label>
                                    </p>
                                    <p class="radio-box">
                                        A celles de nos partenaires ? <input type="radio" name="newsletter-partenaire" id="newsletter-partenaire-1" value="1" />
                                        <label for="newsletter-partenaire-1">Oui</label>
                                        <input type="radio" name="newsletter-partenaire" id="newsletter-partenaire-0" value="0" />
                                        <label for="newsletter-partenaire-0">Non</label>
                                    </p>
                                </div>
                                
                                <div class="box-form-textarea">
                                    <label>Avez-vous d’autres remarques à partager pour mieux comprendre votre projet de voyage ?</label>
                                    <textarea name="remarques" class="textarea-travel"></textarea>
                                </div>
                                
                                <div class="box-form-inline empty-input">
                                    <div class="container-box">
                                        <label class="text">Vous ne devez pas remplir ce champ</label>
                                        <input type="text" name="empty-input" class="" value="" />
                                    </div>
                                </div>
                                <script>
                                    $(document).ready(function() {
                                        $('<input type="checkbox" name="nobot" required="true"> Je confirme ne pas être un robot').prependTo($('.box-form-inline.empty-input'));
                                        $('.box-form-inline.empty-input input[name=nobot]').prop( "checked", true );
                                    });
                                </script>
                            
                                <div class="button">
                                    <button type="submit" class="submit submit2">
                                        <span>Valider</span> votre proposition
                                    </button>
                                </div>
                                
                            </div>
                            
                        </div>
                        
                    </div>
                
                </form>
                
            </div>
            
        </div>
    </div>
    
</div>
