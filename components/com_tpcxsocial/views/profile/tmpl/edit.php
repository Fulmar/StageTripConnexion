<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
?>

<div class="profile clearfix">
    
    <h1 class="title">Mon compte</h1>
    
    <?php echo TpcxsocialHelperTpcxsocial::getBreadcrumbsAccount('Edition de mon profil'); ?>
    
    <div class="clearfix">
        <div class="avatar">
            <div class="bg group-<?php echo $this->group; ?>"></div>
            <img src="<?php echo $this->avatar ?>" width="97" height="97" />
        </div>
    </div>
    
    <div class="content">
        
        <div class="form">
            <form name="register" action="<?php echo JRoute::_('index.php?option=com_tpcxsocial&task=profile.save'); ?>" method="post">
                <div class="box-input">
                    <label class="text"><?php echo JText::_('COM_TPCXSOCIAL_PROFILE_NOCHANGE_USERNAME_DESC'); ?></label>
                    <?php echo $this->form->getInput('username'); ?>
                </div>
                <div class="box-input">
                    <label class="text"><?php echo $this->form->getLabel('name'); ?> * :</label>
                    <?php echo $this->form->getInput('name'); ?>
                </div>
                <div class="box-input">
                    <label class="text"><?php echo $this->form->getLabel('firstname'); ?> * :</label>
                    <?php echo $this->form->getInput('firstname'); ?>
                </div>
                <div class="box-input">
                    <label class="text"><?php echo $this->form->getLabel('email1'); ?> * :</label>
                    <?php echo $this->form->getInput('email1'); ?>
                </div>
                <div class="box-input">
                    <label class="text"><?php echo $this->form->getLabel('password1'); ?> * :</label>
                    <?php echo $this->form->getInput('password1'); ?>
                </div>
                <div class="box-input">
                    <label class="text"><?php echo $this->form->getLabel('password2'); ?> * :</label>
                    <?php echo $this->form->getInput('password2'); ?>
                </div>
                <div class="buttons">
                    <button type="submit" name="submit" class="button">Modifier mes informations</button>
                    <input type="hidden" name="option" value="com_tpcxsocial" />
                    <input type="hidden" name="task" value="profile.save" />
                    <?php echo JHtml::_('form.token');?>
                </div>
            </form>
        </div>
        
    </div>
    
</div>
<script>
    $(document).ready(function() {
        // validate
        $('form[name=register]').validate({
            errorPlacement: function(error, element) {
                error.appendTo( element.parent() );
            },
            rules: {
                "jform[email1]": {
                    email: true
                }
            },
            messages: {
                "jform[email1]": 'Veuillez saisir une adresse mail valide.'
            }
        }); 
    });
</script>