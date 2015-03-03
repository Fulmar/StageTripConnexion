<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
?>
<?php foreach($this->items as $i => $item): ?>
<tr class="row<?php echo $i % 2; ?>">
    <td>
        <?php echo $item->id; ?>
    </td>
    <td>
        <?php echo JHtml::_('grid.id', $i, $item->id); ?>
    </td>
    <td>
        <?php echo $item->email; ?>
    </td>
    <td>
        <?php echo $item->provenance; ?>
    </td>
    <td>
        <?php echo $item->newsletter; ?>
    </td>
    <td>
        <?php echo $item->partenaire; ?>
    </td>
    <td>
        <?php echo $item->date; ?>
    </td>
</tr>
<?php endforeach; ?>