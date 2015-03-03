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

<div class="annuaire-default">
    
    <div class="container-box" style="overflow: visible;">
        
        <input type="hidden" id="current_page" name="current_page" value="recherche" />
            
        <form name="annuaireDestination" action="<?php echo $urlAnnuaire; ?>" method="get">
            
            <div class="box-left">
                <p class="title">Faire une nouvelle recherche</p>
                <p class="subtitle">Par destination</p>
                
                    <div class="container-input">
                        <p class="input">
                            <label>Continent</label>
                            <select name="c" class="customSelectAnnuaire" onchange="getListPays(this.value)">
                                <option value="">--- Choisissez ---</option>
                                <?php foreach($listContinent as $item): ?>
                                <option value="<?php echo $item->id; ?>" <?php //echo $varContinent == $item->id ? 'selected="selected"' : '' ?>>
                                    <?php echo $item->tag; ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </p>
                        <div class="input" style="position: relative;">
                            <label class="label-pays">Pays</label>
                            <!--<select name="p" class="customSelectAnnuaire" onchange="getListThematique(this.value)">
                                <option value="">--- Choisissez ---</option>
                                <?php foreach($listPays as $item): ?>
                                <option value="<?php echo $item->id; ?>" <?php //echo $varPays == $item->id ? 'selected="selected"' : '' ?>>
                                    <?php echo $item->tag; ?>
                                </option>
                                <?php endforeach; ?>
                            </select>-->
                                <input type="text" name="p-text" class="input-destination-annuaire-recherche" placeholder="Tapez votre destination..." />
                                <button type="submit" name="search" class="btn-destination-search"><span><i class="fa fa-search"></i></span></button>
                                <ul id="list-destination" class="list-destination" style="top: 53px;">
                                    <?php foreach($listPays as $item): ?>
                                        <li><a data-value="<?php echo $item->id; ?>" href="javascript:;"><?php echo $item->tag; ?></a></li>
                                    <?php endforeach; ?>
                                </ul>
                                <input type="hidden" name="p" value="" />
                        </div>
                        <p class="input">
                            <button type="submit" class="submit">Rechercher</button>
                        </p>
                    </div>
                    
            </div>
            
            <div class="box-right">
                <div class="box">
                    <p class="subtitle label-thematique">Par thématiques</p>
                        <p>
                            <select name="t" class="customSelectAnnuaire">
                                <option value="">--- Choisissez ---</option>
                                <?php foreach($listThematique as $item): ?>
                                <option value="<?php echo $item->id; ?>" <?php //echo $varThematique == $item->id ? 'selected="selected"' : '' ?>>
                                    <?php echo $item->tag; ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </p>
                        <button type="submit" class="submit">Rechercher</button>
                </div>
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
                
                $('.input-destination-annuaire-recherche').autocomplete({
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
