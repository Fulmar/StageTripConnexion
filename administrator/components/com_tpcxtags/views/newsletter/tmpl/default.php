<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
// load tooltip behavior
JHtml::_('behavior.tooltip');
?>
<form action="<?php echo JRoute::_('index.php?option=com_tpcxtags&view=newsletter'); ?>" method="post" name="adminForm" id="adminForm">
    
    <fieldset id="filter-bar">
        <div class="filter-search fltlft">
            <label class="filter-search-lbl" for="filter_search"><?php echo JText::_('Rechercher : '); ?></label>
            <input type="text" name="filter_search" id="filter_search" value="<?php echo $this->escape($this->state->get('filter.search')); ?>" title="<?php echo JText::_('COM_PROF_FILTER_SEARCH_IN_COMPETENCE'); ?>" />
            <button type="submit"><?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?></button>
            <button type="button" onclick="document.id('filter_search').value='';this.form.submit();"><?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?></button>
        </div>
        <div class="filter-select fltrt">
            <select name="filter_provenance" class="inputbox" onchange="this.form.submit()">
                <option value=""><?php echo JText::_('--- Provenance ---');?></option>
                <?php
                $db = JFactory::getDBO();
                $query = $db->getQuery(true);
                $query->select('provenance');
                $query->from('tpcx_newsletter');
                $query->group('provenance');
                $db->setQuery($query);
                $results = $db->loadObjectList();
                foreach($results as $result):
                    echo '<option value="' . $result->provenance . '"
                        ' . ($this->state->get('filter.provenance') == $result->provenance ? 'selected="selected"' : '') . '>' . $result->provenance . '</option>';
                endforeach;
                ?>
            </select>
        </div>
    </fieldset>
    <div class="clr"> </div>
    
    <table class="adminlist">
        <thead><?php echo $this->loadTemplate('head');?></thead>
        <tfoot><?php echo $this->loadTemplate('foot');?></tfoot>
        <tbody><?php echo $this->loadTemplate('body');?></tbody>
    </table>
    <div>
        <input type="hidden" name="task" value="" />
        <input type="hidden" name="boxchecked" value="0" />
        <?php echo JHtml::_('form.token'); ?>
    </div>
</form>