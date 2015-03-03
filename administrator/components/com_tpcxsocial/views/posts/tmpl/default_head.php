<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');

$listOrder  = $this->sortColumn;
$listDirn   = $this->sortDirection;
$saveOrder  = $this->sortColumn == 'p.ordering';
?>
<tr>
    <th width="1%">
        <input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($this->items); ?>);" />
    </th>
    <th>
        <?php echo JHtml::_('grid.sort', 'COM_TPCXSOCIAL_POSTS_HEADING_MESSAGE', 'p.message', $listDirn, $listOrder); ?>
    </th>
    <th>
        <?php echo JHtml::_('grid.sort', 'COM_TPCXSOCIAL_POSTS_HEADING_TOPIC', 'topic_title', $listDirn, $listOrder); ?>
    </th>
    <th width="10%">
        <?php echo JText::_('COM_TPCXSOCIAL_CATEGORIES_HEADING_ACTION'); ?>
    </th>
    <th width="5%">
        <?php echo JHtml::_('grid.sort', 'JSTATUS', 'p.published', $listDirn, $listOrder); ?>
    </th>
    <th width="10%">
        <?php echo JHtml::_('grid.sort', 'JGRID_HEADING_ACCESS', 'p.access', $listDirn, $listOrder); ?>
    </th>
    <th width="1%">
        <?php echo JHtml::_('grid.sort', 'JGRID_HEADING_ID', 'p.id', $listDirn, $listOrder); ?>
    </th>
</tr>