<?php
// No direct access
defined('_JEXEC') or die('Restricted access');
JHtml::_('behavior.tooltip');
?>
<form action="<?php echo JRoute::_('index.php?option=com_tpcxtags&layout=edit&id='.(int) $this->item->id); ?>"
      method="post" name="adminForm" id="tpcxtags-form">
        <fieldset class="adminform">
            <legend><?php echo JText::_( 'Ttag' ); ?></legend>
            <ul class="adminformlist">
                <li><?php echo $this->form->getLabel('id'); ?>
                <?php echo $this->form->getInput('id'); ?></li>
                <li><?php echo $this->form->getLabel('tag'); ?>
                <?php echo $this->form->getInput('tag'); ?></li>
                <li><?php echo $this->form->getLabel('category'); ?>
                <?php echo $this->form->getInput('category'); ?></li>
                <li><?php echo $this->form->getLabel('subcategory'); ?>
                <?php echo $this->form->getInput('subcategory'); ?></li>
            <?php /*foreach($this->form->getFieldset() as $field): ?>
                <li><?php
                echo $field->label;
                echo $field->input;
                ?></li>
            <?php endforeach;*/ ?>
            </ul>
        </fieldset>
        <div>
            <input type="hidden" name="task" value="tpcxtag.edit" />
            <?php echo JHtml::_('form.token'); ?>
        </div>
</form>