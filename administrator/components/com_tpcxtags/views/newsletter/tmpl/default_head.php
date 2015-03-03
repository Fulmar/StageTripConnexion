<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
?>
<tr>
    <th width="5">
        <?php echo JText::_('ID'); ?>
    </th>
    <th width="20">
        <input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($this->items); ?>);" />
    </th>              
    <th>
        <?php echo JText::_('Email'); ?>
    </th>                 
    <th>
        <?php echo JText::_('Provenance'); ?>
    </th>                 
    <th>
        <?php echo JText::_('Newsletter'); ?>
    </th>                 
    <th>
        <?php echo JText::_('Partenaire'); ?>
    </th>                 
    <th>
        <?php echo JText::_('Date'); ?>
    </th>
</tr>