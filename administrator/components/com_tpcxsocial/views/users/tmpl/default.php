<?php // No direct access to this file
defined('_JEXEC') or die('Restricted Access');

// load tooltip behavior
JHtml::_('behavior.tooltip');
?>
<form action="<?php echo JRoute::_('index.php?option=com_tpcxsocial&view=users'); ?>" method="post" name="adminForm">
    
    <fieldset id="filter-bar">
        <div class="filter-search fltlft">
            <label class="filter-search-lbl" for="filter_search"><?php echo JText::_('JSEARCH_FILTER_LABEL'); ?></label>
            <input type="text" name="filter_search" id="filter_search" value="<?php echo $this->escape($this->state->get('filter.search')); ?>" title="<?php echo JText::_('COM_TPCXSOCIAL_USER_SEARCH_IN_NAME'); ?>" />
            <button type="submit"><?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?></button>
            <button type="button" onclick="document.id('filter_search').value='';this.form.submit();"><?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?></button>
        </div>
        <div class="filter-select fltrt">
            
            <select name="filter_state" class="inputbox" onchange="this.form.submit()">
                <option value="*"><?php echo JText::_('COM_TPCXSOCIAL_FILTER_STATE');?></option>
                <?php echo JHtml::_('select.options', TpcxsocialHelper::getStateOptions(), 'value', 'text', $this->state->get('filter.state'));?>
            </select>

            <select name="filter_active" class="inputbox" onchange="this.form.submit()">
                <option value="*"><?php echo JText::_('COM_TPCXSOCIAL_FILTER_ACTIVE');?></option>
                <?php echo JHtml::_('select.options', TpcxsocialHelper::getActiveOptions(), 'value', 'text', $this->state->get('filter.active'));?>
            </select>

            <select name="filter_group_id" class="inputbox" onchange="this.form.submit()">
                <option value=""><?php echo JText::_('COM_TPCXSOCIAL_FILTER_USERGROUP');?></option>
                <?php echo JHtml::_('select.options', TpcxsocialHelper::getGroups(), 'value', 'text', $this->state->get('filter.group_id'));?>
            </select>

            <select name="filter_range" id="filter_range" class="inputbox" onchange="this.form.submit()">
                <option value=""><?php echo JText::_('COM_TPCXSOCIAL_OPTION_FILTER_DATE');?></option>
                <?php echo JHtml::_('select.options', TpcxsocialHelper::getRangeOptions(), 'value', 'text', $this->state->get('filter.range'));?>
            </select>
        </div>
    </fieldset>
    <div class="clr"> </div>
    
    <table class="adminlist">
        <thead><?php echo $this->loadTemplate('head'); ?></thead>
        <tfoot><?php echo $this->loadTemplate('foot'); ?></tfoot>
        <tbody><?php echo $this->loadTemplate('body'); ?></tbody>
    </table>
    <div>
        <input type="hidden" name="task" value="" />
        <input type="hidden" name="boxchecked" value="0" />
        <input type="hidden" name="filter_order" value="<?php echo $this->sortColumn; ?>" />
        <input type="hidden" name="filter_order_Dir" value="<?php echo $this->sortDirection; ?>" />
        <?php echo JHtml::_('form.token'); ?>
    </div>
</form>