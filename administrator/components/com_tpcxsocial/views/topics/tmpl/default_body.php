<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');

$n = count($this->items);
$saveOrder  = $this->sortColumn == 't.ordering';
$listOrder  = $this->sortColumn;
?>
<?php foreach($this->items as $i => $item):
$ordering   = $listOrder == 't.ordering';
?>
<tr class="row<?php echo $i % 2; ?>">
    <td align="center"><?php echo JHtml::_('grid.id', $i, $item->id); ?></td>
    <td>
        <a href="<?php echo JRoute::_('index.php?option=com_tpcxsocial&task=topic.edit&id='.(int) $item->id); ?>">
        <?php echo $item->subject; ?>
        </a>
    </td>
    <td align="center">
        <a href="<?php echo JRoute::_('index.php?option=com_tpcxsocial&task=post.edit&topic_id='.(int) $item->id); ?>">
        <?php echo JText::_('COM_TPCXSOCIAL_CATEGORIES_ACTION_ADD_POST'); ?>
        </a>
    </td>
    <td align="center">
        <?php echo JHtml::_('jgrid.published', $item->published, $i, 'topics.', true, 'cb', null, null); ?>
    </td>
    <td class="center">
        <?php echo JHtml::_('topic.locked', $item->locked, $i); ?>
    </td>
    <td align="center">
        <?php echo $item->category_title; ?>
    </td>
    <td class="order">
        <?php if ($saveOrder) :?>
            <?php if ($this->sortDirection == 'asc') : ?>
                <span><?php echo $this->pagination->orderUpIcon($i, ($item->parent_id == @$this->items[$i-1]->parent_id), 'topics.orderup', 'JLIB_HTML_MOVE_UP', $ordering); ?></span>
                <span><?php echo $this->pagination->orderDownIcon($i, $n, ($item->parent_id == @$this->items[$i+1]->parent_id), 'topics.orderdown', 'JLIB_HTML_MOVE_DOWN', $ordering); ?></span>
            <?php elseif ($this->sortDirection == 'desc') : ?>
                <span><?php echo $this->pagination->orderUpIcon($i, ($item->parent_id == @$this->items[$i-1]->parent_id), 'topics.orderdown', 'JLIB_HTML_MOVE_UP', $ordering); ?></span>
                <span><?php echo $this->pagination->orderDownIcon($i, $n, ($item->parent_id == @$this->items[$i+1]->parent_id), 'topics.orderup', 'JLIB_HTML_MOVE_DOWN', $ordering); ?></span>
            <?php endif; ?>
        <?php endif; ?>
        <?php $disabled = $saveOrder ?  '' : 'disabled="disabled"'; ?>
        <input type="text" name="order[]" size="5" value="<?php echo $item->ordering;?>" <?php echo $disabled ?> class="text-area-order" />
    </td>
    <td align="center">
        <?php echo $item->access_level; ?>
    </td>
    <td align="center">
        <?php echo $item->id; ?>
    </td>
</tr>
<?php endforeach; ?>