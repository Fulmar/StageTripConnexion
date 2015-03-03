<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');

$listOrder  = $this->sortColumn;
$listDirn   = $this->sortDirection;

$saveOrder  = ($listOrder == 'c.lft' && $listDirn == 'asc');
?>
<tr>
    <th width="1%">
        <input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($this->items); ?>);" />
    </th>
    <th>
        <?php echo JHtml::_('grid.sort', 'COM_TPCXSOCIAL_CATEGORIES_HEADING_NAME', 'c.title', $listDirn, $listOrder); ?>
    </th>
    <th width="5%">
        <?php echo JHtml::_('grid.sort', 'JSTATUS', 'c.published', $listDirn, $listOrder); ?>
    </th>
    <th width="10%">
        <?php echo JHtml::_('grid.sort', 'JGRID_HEADING_ORDERING', 'c.lft', $listDirn, $listOrder); ?>
        <?php if ($saveOrder) :?>
            <?php echo JHtml::_('grid.order',  $this->items, 'filesave.png', 'categories.saveorder'); ?>
        <?php endif; ?>
    </th>
    <th width="10%">
        <?php echo JHtml::_('grid.sort', 'JGRID_HEADING_ACCESS', 'c.access', $listDirn, $listOrder); ?>
    </th>
    <th width="1%">
        <?php echo JHtml::_('grid.sort', 'JGRID_HEADING_ID', 'c.id', $listDirn, $listOrder); ?>
    </th>
</tr>