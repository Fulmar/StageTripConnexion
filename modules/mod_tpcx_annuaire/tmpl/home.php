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

JHTML::_('behavior.modal');

?>

<div class="annuaire-home">
    
    <div class="wrapper-big">
        <div class="wrapper">
            
            <div class="annuaire">
                
                <h2>Trouvez votre contact sur place : <span>guide, agence de voyage, centre d'activités...</span></h2>
                
                <div class="container-box">
                
                    <div class="box-left box-mappemonde">
                        <p class="subtitle">Sur la mappemonde interactive</p>
                        <a class="modal" href="<?php echo JURI::base() . 'index.php?option=com_tpcxtags&task=mappemonde&view=mappemonde'; ?>" rel="{handler: 'iframe', size: {x: 680, y: 600}, iframeOptions: {scrolling: 'no'}}">
                            <img src="<?php echo $baseurl . 'templates/' . $template . '/images/mappemonde.png'; ?>" alt="" />
                        </a>
                    </div>
                    
                    <div class="box-right">
                        
                        <div class="clearfix">
                            
                            <form name="annuaireDestination" action="<?php echo $urlAnnuaire; ?>" method="get">
                            
                                <div class="box-left">
                                    <p class="subtitle">Par destination</p>
                                    <label>Continent</label>
                                    <select name="c" class="customSelectAnnuaire" onchange="getListPays(this.value)">
                                        <option value="">--- Choisissez ---</option>
                                        <?php foreach($listContinent as $item): ?>
                                        <option value="<?php echo $item->id; ?>">
                                            <?php echo $item->tag; ?>
                                        </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <label class="label-pays">Pays</label>
                                    <!--<select name="p" class="customSelectAnnuaire" onchange="getListThematique(this.value)">
                                        <option value="">--- Choisissez ---</option>
                                        <?php foreach($listPays as $item): ?>
                                        <option value="<?php echo $item->id; ?>">
                                            <?php echo $item->tag; ?>
                                        </option>
                                        <?php endforeach; ?>
                                    </select>-->
                                    <div class="clearfix" style="position: relative;">
                                        <input type="text" name="p-text" class="input-destination-annuaire-home" placeholder="Tapez votre destination..." />
                                        <button type="submit" name="search" class="btn-destination-search"><span><i class="fa fa-search"></i></span></button>
                                        <ul id="list-destination" class="list-destination">
                                            <?php foreach($listPays as $item): ?>
                                                <li><a data-value="<?php echo $item->id; ?>" href="javascript:;"><?php echo $item->tag; ?></a></li>
                                            <?php endforeach; ?>
                                        </ul>
                                        <input type="hidden" name="p" value="" />
                                    </div>
                                    <button type="submit" class="submit">Rechercher <span>par destination</span></button>
                                </div>
                                
                                <div class="box-right box-thematique">
                                    <p class="subtitle subtitleThematique">Par thématiques</p>
                                    <select name="t" class="customSelectAnnuaire">
                                        <option value="">--- Choisissez ---</option>
                                        <?php foreach($listThematique as $item): ?>
                                        <option value="<?php echo $item->id; ?>">
                                            <?php echo $item->tag; ?>
                                        </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <button type="submit" class="submit">Rechercher <span>par thématique</span></button>
                                </div>
                                
                            </form>
                            
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
                                    
                                    $('.input-destination-annuaire-home').autocomplete({
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
                                            $('input[name=p]').val(value);
                                        }
                                    });
                                });
                            </script>
                            
                        </div>
                        
                    </div>
                
                </div>
                
            </div>
            
        </div>
    </div>
    
</div>
