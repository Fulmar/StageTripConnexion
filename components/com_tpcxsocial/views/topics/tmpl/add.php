<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
?>

<div class="topics">
    
    <?php echo TpcxsocialHelperTpcxsocial::getBreadcrumbs($this->topic->category_id); ?>
    
    <div class="topic-new">
        
        <div class="form">
            <form name="add_topic" action="<?php echo JRoute::_('index.php?option=com_tpcxsocial&task=topic.save'); ?>" method="post">
                <div class="box-input">
                    <label class="text"><?php echo JText::_('COM_TPCXSOCIAL_SUBJECT_LABEL'); ?><small class="info">limité à 90 caractères</small></label>
                    <input type="text" name="jform[subject]" id="jform_subject"
                        value="<?php echo $this->form->getValue('subject'); ?>" placeholder="<?php echo JText::_('COM_TPCXSOCIAL_SUBJECT_LABEL'); ?>" class="input-text required" />
                </div>
                <div class="box-input">
                    <label class="text"><?php echo $this->form->getLabel('description'); ?> * :</label>
                    <textarea name="jform[description]" id="jform_description" rows="10" cols="80" class="input-text required"><?php
                    echo $this->form->getValue('description');
                    ?></textarea>
                    <script>
                        // Replace the <textarea id="editor1"> with a CKEditor
                        // instance, using default configuration.
                        CKEDITOR.replace( 'jform_description', {
                            uiColor: '#04a4a3',
                            language: 'fr',
                            customConfig: '/components/com_tpcxsocial/template/js/ckeditor_topic_config.js'
                        } );
                    </script>
                </div>
                <div class="box-input box-input-tag">
                    <label class="text"><?php echo JText::_('COM_TPCXSOCIAL_TAGS_LABEL'); ?></label>
                    <div class="input-tag">
                        <input type="hidden" name="jform[tags_value]" id="jform_tags_value" />
                        <input type="text" name="jform[tags]" id="jform_tags"
                            value="<?php echo $this->form->getValue('tags'); ?>"
                            placeholder="<?php echo JText::_('COM_TPCXSOCIAL_TAGS_LABEL2'); ?>" class="input-text input-tag" />
                        <button type"button" class="button-add-tag"><span>+ ajouter la catégorie</span></button>
                    </div>
                    <small>Vous pouvez ajouter jusqu'à 6 catégories maximum.</small>
                    <div class="tags-selected clearfix">
                        <ul></ul>
                    </div>
                </div>
                
                <?php if(TpcxsocialHelperUser::isLogged()): ?>
                <div class="buttons">
                    <button type="submit" name="submit" class="button">Soumettre la nouvelle discussion >></button>
                    <input type="hidden" name="option" value="com_tpcxsocial" />
                    <input type="hidden" name="task" value="topic.save" />
                    <?php echo JHtml::_('form.token');?>
                </div>
                <?php else: ?>
                    Vous devez être inscrit si vous voulez poster une discussion
                <?php endif; ?>
            </form>
        </div>
    </div>
    
</div>
<script>
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
    
    $(document).ready(function() {
        
        <?php if(!TpcxsocialHelperUser::isLogged()): ?>
        $("a.link-login").trigger('click');
        <?php endif; ?>
        
        // validate
        $('form[name=add_topic]').submit(function(){
            CKEDITOR.instances.jform_description.updateElement();
        }).validate({
            ignore: "",
            errorPlacement: function(error, element) {
                error.appendTo( element.parent() );
            },
            rules: {
                "jform[description]": {
                    required: true
                }
            }
        });
        
         
        
        // autocomplete
        $('#jform_tags').autocomplete({
            source: function( request, response ) {
                //term = request.term.split(/,\s*/).pop();
                term = request.term;
                $.ajax({
                    url: baseUrl + 'index.php?option=com_tpcxsocial&task=getTags',
                    dataType: "json",
                    data: {
                        style: "full",
                        term: term
                    },
                    success: function( data ) {
                        response( $.map( data, function( item ) {
                            return {
                                label: item.title,
                                value: item.id_generic
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
</script>