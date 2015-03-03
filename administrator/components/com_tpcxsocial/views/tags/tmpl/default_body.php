<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');

$n = count($this->items);
$listOrder  = $this->sortColumn;
?>
<?php foreach($this->items as $i => $item):
?>
<tr class="row<?php echo $i % 2; ?>">
    <td align="center"><?php echo JHtml::_('grid.id', $i, $item->id); ?></td>
    <td>
        <a href="<?php echo JRoute::_('index.php?option=com_tpcxsocial&task=tag.edit&id='.(int) $item->id); ?>">
        <?php echo $item->title; ?>
        </a>
    </td>
    <td align="center">
        <?php echo JHtml::_('jgrid.published', $item->published, $i, 'tags.', true, 'cb', null, null); ?>
    </td>
    <td align="center">
        <?php echo $item->category_title; ?>
    </td>
    <td align="center">
        <?php echo $item->id; ?>
    </td>
</tr>
<?php endforeach; ?>