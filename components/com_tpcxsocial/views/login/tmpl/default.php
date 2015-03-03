<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

$urlParam = array(
                'task' => 'login.displayAjax'
            );
$urlRegister = TpcxsocialHelperRoute::getRegistrationRoute($urlParam);
?>

<div class="registration">
    
    <h1 class="title">Connexion</h1>
    
    <div class="border"></div>
    
    <div class="buttons">
        <a class="btn-facebook" href="javascript:void(0)" onclick="fb_login()">
            <i class="fa fa-facebook"></i>
            <span>Connexion avec Facebook</span>
        </a>
    </div>
    
    <div class="separator">
        <p>ou</p>
    </div>
    
    <div class="form">
        <form name="login" action="#" method="post">
            <div class="box-input">
                <input type="text" name="email" id="jform_register_email"
                    value="<?php echo $this->form->getValue('email'); ?>" placeholder="<?php echo JText::_('COM_TPCXSOCIAL_USER_FIELD_EMAIL_LABEL'); ?>" class="input-text required" />
            </div>
            <div class="box-input">
                <input type="password" name="password" id="jform_register_password"
                    value="<?php echo $this->form->getValue('password'); ?>" placeholder="<?php echo JText::_('COM_TPCXSOCIAL_USER_FIELD_PASSWORD_LABEL'); ?>" class="input-text required" />
            </div>
            <div class="buttons">
                <button type="submit" name="submit" class="button">Connexion</button>
                <input type="hidden" name="option" value="com_tpcxsocial" />
                <input type="hidden" name="task" value="user.login" />
                <?php echo JHtml::_('form.token');?>
            </div>
            <div class="message-error"></div>
        </form>
    </div>
    
    <div class="border"></div>
    
    <p class="text-bottom">Vous pas de compte Trip Connexion ? <a class="link-connect various fancybox.ajax" href="<?php echo JRoute::_($urlRegister); ?>">Inscrivez-vous ici !</a></p>
    
</div>
<script>
    $(document).ready(function() {
        // validate
        $('form[name=login]').validate({
            errorPlacement: function(error, element) {
                error.appendTo( element.parent() );
            },
            rules: {
                "jform[email]": {
                    email: true
                }
            },
            messages: {
                "jform[email]": 'Veuillez saisir une adresse mail valide.'
            },
            submitHandler: function (form) {
                $.ajax({
                    url : baseUrl + 'index.php?option=com_tpcxsocial&task=user.login',
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