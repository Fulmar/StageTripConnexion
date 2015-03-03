<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');

$n = count($this->items);
$listOrder  = $this->sortColumn;
$listDirn   = $this->sortDirection;
$saveOrder  = ($listOrder == 'c.lft' && $listDirn == 'asc');
$listOrder  = $this->sortColumn;
?>
<?php foreach($this->items as $i => $item):
$orderkey   = array_search($item->id, $this->ordering[$item->parent_id]);
$ordering   = ($listOrder == 'c.lft');
?>
<tr class="row<?php echo $i % 2; ?>">
    <td align="center"><?php echo JHtml::_('grid.id', $i, $item->id); ?></td>
    <td>
        <?php
        if($item->level > 0)
            echo str_repeat('<span class="gi">|&mdash;</span>', $item->level-1);
        ?>
        <a href="<?php echo JRoute::_('index.php?option=com_tpcxsocial&task=category.edit&id='.(int) $item->id); ?>">
        <?php echo $item->title; ?>
        </a>
    </td>
    <td align="center">
        <?php echo JHtml::_('jgrid.published', $item->published, $i, 'categories.', true, 'cb', null, null); ?>
    </td>
    <td class="order">
        <?php if ($saveOrder) : ?>
            <span><?php echo $this->pagination->orderUpIcon($i, isset($this->ordering[$item->parent_id][$orderkey - 1]), 'categories.orderup', 'JLIB_HTML_MOVE_UP', $ordering); ?></span>
            <span><?php echo $this->pagination->orderDownIcon($i, $this->pagination->total, isset($this->ordering[$item->parent_id][$orderkey + 1]), 'categories.orderdown', 'JLIB_HTML_MOVE_DOWN', $ordering); ?></span>
        <?php endif; ?>
        <?php $disabled = $saveOrder ?  '' : 'disabled="disabled"'; ?>
        <input type="text" name="order[]" size="5" value="<?php echo $orderkey + 1;?>" <?php echo $disabled ?> class="text-area-order" />
        <?php $originalOrders[] = $orderkey + 1; ?>
    </td>
    <td align="center">
        <?php echo $item->access_level; ?>
    </td>
    <td align="center">
        <?php echo $item->id; ?>
    </td>
</tr>
<?php endforeach; ?>