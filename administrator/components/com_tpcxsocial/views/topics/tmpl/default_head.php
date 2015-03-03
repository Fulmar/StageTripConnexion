<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');

$listOrder  = $this->sortColumn;
$listDirn   = $this->sortDirection;
$saveOrder  = $this->sortColumn == 't.ordering';
?>
<tr>
    <th width="1%">
        <input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($this->items); ?>);" />
    </th>
    <th>
        <?php echo JHtml::_('grid.sort', 'COM_TPCXSOCIAL_CATEGORIES_HEADING_SUBJECT', 't.subject', $listDirn, $listOrder); ?>
    </th>
    <th width="10%">
        <?php echo JText::_('COM_TPCXSOCIAL_CATEGORIES_HEADING_ACTION'); ?>
    </th>
    <th width="5%">
        <?php echo JHtml::_('grid.sort', 'JSTATUS', 't.published', $listDirn, $listOrder); ?>
    </th>
    <th width="5%">
        <?php echo JHtml::_('grid.sort', 'COM_TPCXSOCIAL_FIELD_TOPIC_LOCKED_LABEL', 't.locked', $listDirn, $listOrder); ?>
    </th>
    <th width="10%">
        <?php echo JHtml::_('grid.sort', 'JCATEGORY', 'category_title', $listDirn, $listOrder); ?>
    </th>
    <th>
        <?php echo JHtml::_('grid.sort', 'JGRID_HEADING_ORDERING', 't.ordering', $listDirn, $listOrder); ?>
        <?php if ($saveOrder): ?>
            <?php echo JHtml::_('grid.order',  $this->items, 'filesave.png', 'topics.saveorder'); ?>
        <?php endif; ?>
    </th>
    <th width="10%">
        <?php echo JHtml::_('grid.sort', 'JGRID_HEADING_ACCESS', 't.access', $listDirn, $listOrder); ?>
    </th>
    <th width="1%">
        <?php echo JHtml::_('grid.sort', 'JGRID_HEADING_ID', 't.id', $listDirn, $listOrder); ?>
    </th>
</tr>