<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

$urlParam = array(
                'task' => 'login.displayAjax'
            );
$urlLogin = TpcxsocialHelperRoute::getLoginRoute($urlParam);
?>

<div class="registration">
    
    <h1 class="title">Inscription</h1>
    
    <div class="border"></div>
    
    <div class="form">
        <form name="register" action="#" method="post">
            <div class="box-input">
                <input type="text" name="jform[username]" id="jform_register_username"
                    value="<?php echo $this->form->getValue('username'); ?>" placeholder="<?php echo JText::_('COM_TPCXSOCIAL_USER_FIELD_USERNAME_LABEL'); ?>" class="input-text required" />
            </div>
            <div class="box-input">
                <input type="text" name="jform[name]" id="jform_register_name"
                    value="<?php echo $this->form->getValue('name'); ?>" placeholder="<?php echo JText::_('COM_TPCXSOCIAL_FIELD_NAME_LABEL'); ?>" class="input-text required" />
            </div>
            <div class="box-input">
                <input type="text" name="jform[firstname]" id="jform_register_firstname"
                    value="<?php echo $this->form->getValue('firstname'); ?>" placeholder="<?php echo JText::_('COM_TPCXSOCIAL_FIELD_FIRSTNAME_LABEL'); ?>" class="input-text required" />
            </div>
            <div class="box-input">
                <input type="text" name="jform[email]" id="jform_register_email"
                    value="<?php echo $this->form->getValue('email'); ?>" placeholder="<?php echo JText::_('COM_TPCXSOCIAL_USER_FIELD_EMAIL_LABEL'); ?>" class="input-text required" />
            </div>
            <div class="box-input">
                <input type="password" name="jform[password1]" id="jform_register_password1"
                    value="<?php echo $this->form->getValue('password1'); ?>" placeholder="<?php echo JText::_('COM_TPCXSOCIAL_USER_FIELD_PASSWORD_LABEL'); ?>" class="input-text required" />
            </div>
            <div class="box-input">
                <input type="password" name="jform[password2]" id="jform_register_password2"
                    value="<?php echo $this->form->getValue('password2'); ?>" placeholder="<?php echo JText::_('COM_TPCXSOCIAL_USER_FIELD_PASSWORD2_DESC'); ?>" class="input-text required" />
            </div>
            <div class="buttons">
                <button type="submit" name="submit" class="button">S'inscrire</button>
                <input type="hidden" name="option" value="com_tpcxsocial" />
                <input type="hidden" name="task" value="registration.register" />
                <?php echo JHtml::_('form.token');?>
            </div>
            <div class="message-error"></div>
        </form>
    </div>
    
    <div class="border"></div>
    
    <p class="text-bottom">Déjà membre de TripConnexion ? <a class="link-connect various fancybox.ajax" href="<?php echo JRoute::_($urlLogin); ?>">Connectez-vous ici !</a></p>
    
</div>
<script>
    $(document).ready(function() {
        // validate
        $('form[name=register]').validate({
            errorPlacement: function(error, element) {
                error.appendTo( element.parent() );
            },
            rules: {
                "jform[email]": {
                    email: true
                },
                "jform[password2]": {
                    equalTo: "#jform_register_password1"
                }
            },
            messages: {
                "jform[email]": 'Veuillez saisir une adresse mail valide.',
                "jform[password2]": 'Veuillez saisir un mot de passe identique au champ mot de passe.'
            },
            submitHandler: function (form) {
                $.ajax({
                    url : baseUrl + 'index.php?option=com_tpcxsocial&task=registration.register',
                    method: 'post',
                    data: $(form).serialize(),
                    success: function(response) {
                        if(!response.error) {
                            $.fancybox.close();
                            $.ajax({
                                url : baseUrl + 'index.php?option=com_tpcxsocial&task=login.login&user_id=' + response.user_id,
                                dataType: 'html',
                                success: function(response) {
                                    $('.top-header-login').html(response);
                                }
                            }); 
                        } else {
                            $('.message-error').html(response.errorMsg).show();
                        }
                    }
                });
            }
        }); 
    });
</script>