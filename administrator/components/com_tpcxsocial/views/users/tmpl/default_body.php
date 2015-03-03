<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');

$n = count($this->items);
$saveOrder  = $this->sortColumn == 'p.ordering';
$listOrder  = $this->sortColumn;
$loggeduser = JFactory::getUser();
?>
<?php foreach($this->items as $i => $item):
$ordering   = $listOrder == 'p.ordering';
$canChange  = $loggeduser->authorise('core.edit.state', 'com_users');
?>
<tr class="row<?php echo $i % 2; ?>">
    <td align="center"><?php echo JHtml::_('grid.id', $i, $item->id); ?></td>
    <td>
        <a href="<?php echo JRoute::_('index.php?option=com_tpcxsocial&task=user.edit&user_id='.(int) $item->id); ?>">
        <?php echo $item->name . ' ' . $item->firstname; ?>
        </a>
    </td>
    <td align="center">
        <?php echo $item->email; ?>
    </td>
    <td class="center">
        <?php if ($canChange) : ?>
            <?php if ($loggeduser->id != $item->id) : ?>
                <?php echo JHtml::_('grid.boolean', $i, !$item->block, 'users.unblock', 'users.block'); ?>
            <?php else : ?>
                <?php echo JHtml::_('grid.boolean', $i, !$item->block, 'users.block', null); ?>
            <?php endif; ?>
        <?php else : ?>
            <?php echo JText::_($item->block ? 'JNO' : 'JYES'); ?>
        <?php endif; ?>
    </td>
    <td class="center">
        <?php echo JHtml::_('grid.boolean', $i, !$item->activation, 'users.activate', null); ?>
    </td>
    <td align="center">
        <?php if (substr_count($item->group_names, "\n") > 1) : ?>
            <span class="hasTip" title="<?php echo JText::_('COM_TPCXSOCIAL_USER_HEADING_GROUPS').'::'.nl2br($item->group_names); ?>"><?php echo JText::_('COM_TPCXSOCIAL_USERS_MULTIPLE_GROUPS'); ?></span>
        <?php else : ?>
            <?php echo nl2br($item->group_names); ?>
        <?php endif; ?>
    </td>
    <td class="center">
        <?php if ($item->lastvisitDate!='0000-00-00 00:00:00'):?>
            <?php echo JHtml::_('date', $item->lastvisitDate, 'Y-m-d H:i:s'); ?>
        <?php else:?>
            <?php echo JText::_('JNEVER'); ?>
        <?php endif;?>
    </td>
    <td class="center">
        <?php echo JHtml::_('date', $item->registerDate, 'Y-m-d H:i:s'); ?>
    </td>
    <td align="center">
        <?php echo $item->id; ?>
    </td>
</tr>
<?php endforeach; ?>