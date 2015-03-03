<?php
// No direct access
defined('_JEXEC') or die('Restricted access');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
?>
<form action="<?php echo JRoute::_('index.php?option=com_tpcxsocial&layout=edit&id=' . (int)$this->item->id); ?>" method="post" name="adminForm" id="adminForm" class="form-validate">
    <div class="width-60 fltlft">
        <fieldset class="adminform">
            <legend><?php echo JText::_('COM_TPCXSOCIAL_CATEGORY_DETAILS'); ?></legend>
            <ul class="adminformlist">
                <li><?php echo $this->form->getLabel('id'); ?>
                <?php echo $this->form->getInput('id'); ?></li>
                
                <li><?php echo $this->form->getLabel('title'); ?>
                <?php echo $this->form->getInput('title'); ?></li>
                
                <li><?php echo $this->form->getLabel('alias'); ?>
                <?php echo $this->form->getInput('alias'); ?></li>
                
                <li><?php echo $this->form->getLabel('published'); ?>
                <?php echo $this->form->getInput('published'); ?></li>
                
                <li><?php echo $this->form->getLabel('visible'); ?>
                <?php echo $this->form->getInput('visible'); ?></li>
                
                <li><?php echo $this->form->getLabel('access'); ?>
                <?php echo $this->form->getInput('access'); ?></li>
                
                <li><?php echo $this->form->getLabel('parent_id'); ?>
                <?php echo $this->form->getInput('parent_id'); ?></li>
                
                <li><?php echo $this->form->getLabel('description'); ?>
                <?php echo $this->form->getInput('description'); ?></li>
            </ul>
        </fieldset>
    </div>
    
    <div class="width-40 fltrt">
        <?php echo  JHtml::_('sliders.start', 'contact-slider'); ?>
            <?php echo JHtml::_('sliders.panel', JText::_('COM_TPCXSOCIAL_CATEGORY_FIELDSET_DETAILS'), 'forum-details'); ?>
            
            <fieldset class="panelform">
                <ul class="adminformlist">
                    
                    <li><?php echo $this->form->getLabel('images'); ?>
                    <?php echo $this->form->getInput('images'); ?></li>
                    
                    <li><?php echo $this->form->getLabel('created_by'); ?>
                    <?php echo $this->form->getInput('created_by'); ?></li>
                    
                    <li><?php echo $this->form->getLabel('created'); ?>
                    <?php echo $this->form->getInput('created'); ?></li>
                    
                    <li><?php echo $this->form->getLabel('topic_ordering'); ?>
                    <?php echo $this->form->getInput('topic_ordering'); ?></li>

                    <li><?php echo $this->form->getLabel('topic_number'); ?>
                    <?php echo $this->form->getInput('topic_number'); ?></li>

                    <li><?php echo $this->form->getLabel('post_number'); ?>
                    <?php echo $this->form->getInput('post_number'); ?></li>

                    <li><?php echo $this->form->getLabel('last_topic_id'); ?>
                    <?php echo $this->form->getInput('last_topic_id'); ?></li>

                    <li><?php echo $this->form->getLabel('last_topic_post_id'); ?>
                    <?php echo $this->form->getInput('last_topic_post_id'); ?></li>
                    
                    <li><?php echo $this->form->getLabel('last_post_time'); ?>
                    <?php echo $this->form->getInput('last_post_time'); ?></li>

                </ul>
            </fieldset>
            
        <?php echo JHtml::_('sliders.end'); ?>
    </div>
    
    <div>
        <input type="hidden" name="task" value="category.edit" />
        <?php echo JHtml::_('form.token'); ?>
    </div>
</form>