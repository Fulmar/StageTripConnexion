<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');

$n = count($this->items);
$listOrder  = $this->sortColumn;
?>
<?php foreach($this->items as $i => $item):
$ordering   = $listOrder == 'p.ordering';
?>
<tr class="row<?php echo $i % 2; ?>">
    <td align="center"><?php echo JHtml::_('grid.id', $i, $item->id); ?></td>
    <td>
        <a href="<?php echo JRoute::_('index.php?option=com_tpcxsocial&task=post.edit&id='.(int) $item->id); ?>">
        <?php echo JHTML::_('string.truncate', $item->message, 150, false, false); ?>
        </a>
    </td>
    <td>
        <a href="<?php echo JRoute::_('index.php?option=com_tpcxsocial&task=topic.edit&id='.(int) $item->topic_id); ?>">
        <?php echo $item->topic_title; ?>
        </a>
    </td>
    <td align="center">
        <a href="<?php echo JRoute::_('index.php?option=com_tpcxsocial&task=post.edit&topic_id=' . (int) $item->topic_id . '&parent_id='.(int) $item->id); ?>">
        <?php echo JText::_('COM_TPCXSOCIAL_CATEGORIES_ACTION_ADD_POST_PARENT'); ?>
        </a>
    </td>
    <td align="center">
        <?php echo JHtml::_('jgrid.published', $item->published, $i, 'posts.', true, 'cb', null, null); ?>
    </td>
    <td align="center">
        <?php echo $item->access_level; ?>
    </td>
    <td align="center">
        <?php echo $item->id; ?>
    </td>
</tr>
<?php endforeach; ?>