<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');

$listOrder  = $this->sortColumn;
$listDirn   = $this->sortDirection;
$saveOrder  = $this->sortColumn == 'u.name';
?>
<tr>
    <th width="1%">
        <input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($this->items); ?>);" />
    </th>
    <th>
        <?php echo JHtml::_('grid.sort', 'COM_TPCXSOCIAL_USER_HEADING_NAME', 'u.name', $listDirn, $listOrder); ?>
    </th>
    <th width="5%">
        <?php echo JHtml::_('grid.sort', 'COM_TPCXSOCIAL_USER_HEADING_EMAIl', 'u.email', $listDirn, $listOrder); ?>
    </th>
    <th class="nowrap" width="5%">
        <?php echo JHtml::_('grid.sort', 'COM_TPCXSOCIAL_HEADING_ENABLED', 'u.block', $listDirn, $listOrder); ?>
    </th>
    <th class="nowrap" width="5%">
        <?php echo JHtml::_('grid.sort', 'COM_TPCXSOCIAL_HEADING_ACTIVATED', 'u.activation', $listDirn, $listOrder); ?>
    </th>
    <th width="10%">
        <?php echo JText::_('COM_TPCXSOCIAL_USER_HEADING_GROUPS'); ?>
    </th>
    <th class="nowrap" width="10%">
        <?php echo JHtml::_('grid.sort', 'COM_TPCXSOCIAL_USER_HEADING_LAST_VISIT_DATE', 'u.lastvisitDate', $listDirn, $listOrder); ?>
    </th>
    <th class="nowrap" width="10%">
        <?php echo JHtml::_('grid.sort', 'COM_TPCXSOCIAL_USER_HEADING_REGISTRATION_DATE', 'u.registerDate', $listDirn, $listOrder); ?>
    </th>
    <th width="1%">
        <?php echo JHtml::_('grid.sort', 'JGRID_HEADING_ID', 'p.id', $listDirn, $listOrder); ?>
    </th>
</tr>