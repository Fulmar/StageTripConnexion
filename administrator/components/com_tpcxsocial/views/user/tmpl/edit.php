<?php
// No direct access
defined('_JEXEC') or die('Restricted access');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
?>
<form action="<?php echo JRoute::_('index.php?option=com_tpcxsocial&layout=edit&user_id=' . (int)$this->item->user_id); ?>" method="post" name="adminForm" id="adminForm" class="form-validate">
    <div class="width-60 fltlft">
        <fieldset class="adminform">
            <legend><?php echo JText::_('COM_TPCXSOCIAL_USER_DETAILS'); ?></legend>
            <ul class="adminformlist">
                <li><?php echo $this->form->getLabel('user_id'); ?>
                <?php echo $this->form->getInput('user_id'); ?></li>
                
                <li><?php echo $this->form->getLabel('username'); ?>
                <?php echo $this->form->getInput('username'); ?></li>
                
                <li><?php echo $this->form->getLabel('name'); ?>
                <?php echo $this->form->getInput('name'); ?></li>
                
                <li><?php echo $this->form->getLabel('firstname'); ?>
                <?php echo $this->form->getInput('firstname'); ?></li>
                
                <li><?php echo $this->form->getLabel('email'); ?>
                <?php echo $this->form->getInput('email'); ?></li>
                
                <li><?php echo $this->form->getLabel('password'); ?>
                <?php echo $this->form->getInput('password'); ?></li>
                
                <li><?php echo $this->form->getLabel('password2'); ?>
                <?php echo $this->form->getInput('password2'); ?></li>
                
                <li><?php echo $this->form->getLabel('country'); ?>
                <?php echo $this->form->getInput('country'); ?></li>
                
                <li><?php echo $this->form->getLabel('city'); ?>
                <?php echo $this->form->getInput('city'); ?></li>
                
                <li><?php echo $this->form->getLabel('birthday'); ?>
                <?php echo $this->form->getInput('birthday'); ?></li>
                
                <li><?php echo $this->form->getLabel('avatar'); ?>
                <?php echo $this->form->getInput('avatar'); ?></li>
                
                <li><?php echo $this->form->getLabel('country_visited'); ?>
                <?php echo $this->form->getInput('country_visited'); ?></li>
                
                <li><?php echo $this->form->getLabel('country_last'); ?>
                <?php echo $this->form->getInput('country_last'); ?></li>
                
                <li><?php echo $this->form->getLabel('quote'); ?>
                <?php echo $this->form->getInput('quote'); ?></li>
                
                <li><?php echo $this->form->getLabel('hobbies'); ?>
                <?php echo $this->form->getInput('hobbies'); ?></li>
                    
                <li><?php echo $this->form->getLabel('registerDate'); ?>
                <?php echo $this->form->getInput('registerDate'); ?></li>
                
                <li><?php echo $this->form->getLabel('lastvisitDate'); ?>
                <?php echo $this->form->getInput('lastvisitDate'); ?></li>
                
                <li><?php echo $this->form->getLabel('block'); ?>
                <?php echo $this->form->getInput('block'); ?></li>
            </ul>
        </fieldset>
        
        <fieldset id="user-groups" class="adminform">
            <legend><?php echo JText::_('COM_TPCXSOCIAL_ASSIGNED_GROUPS'); ?></legend>
            <?php echo $this->loadTemplate('groups');?>
        </fieldset>
    </div>
    
    <div class="width-40 fltrt">
        <?php echo  JHtml::_('sliders.start', 'contact-slider'); ?>
            <?php echo JHtml::_('sliders.panel', JText::_('COM_TPCXSOCIAL_USER_FIELDSET_DETAILS'), 'user-details'); ?>
            
            <fieldset class="panelform">
                <ul class="adminformlist">
                    
                    <li><?php echo $this->form->getLabel('created_by'); ?>
                    <?php echo $this->form->getInput('created_by'); ?></li>

                </ul>
            </fieldset>
            
        <?php echo JHtml::_('sliders.end'); ?>
    </div>
    
    <div>
        <input type="hidden" name="task" value="user.edit" />
        <?php echo JHtml::_('form.token'); ?>
    </div>
</form>