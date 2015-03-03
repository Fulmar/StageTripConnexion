<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');

$listOrder  = $this->sortColumn;
$listDirn   = $this->sortDirection;
?>
<tr>
    <th width="1%">
        <input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($this->items); ?>);" />
    </th>
    <th>
        <?php echo JHtml::_('grid.sort', 'COM_TPCXSOCIAL_CATEGORIES_HEADING_SUBJECT', 'c.title', $listDirn, $listOrder); ?>
    </th>
    <th width="5%">
        <?php echo JHtml::_('grid.sort', 'JSTATUS', 'c.published', $listDirn, $listOrder); ?>
    </th>
    <th width="1%">
        <?php echo JHtml::_('grid.sort', 'JGRID_HEADING_ID', 'c.id', $listDirn, $listOrder); ?>
    </th>
</tr>