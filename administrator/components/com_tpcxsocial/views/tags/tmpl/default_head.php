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
        <?php echo JHtml::_('grid.sort', 'COM_TPCXSOCIAL_CATEGORIES_HEADING_SUBJECT', 't.title', $listDirn, $listOrder); ?>
    </th>
    <th width="5%">
        <?php echo JHtml::_('grid.sort', 'JSTATUS', 't.published', $listDirn, $listOrder); ?>
    </th>
    <th width="10%">
        <?php echo JHtml::_('grid.sort', 'JCATEGORY', 'category_title', $listDirn, $listOrder); ?>
    </th>
    <th width="1%">
        <?php echo JHtml::_('grid.sort', 'JGRID_HEADING_ID', 't.id', $listDirn, $listOrder); ?>
    </th>
</tr>