<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

$urlParam = array(
                'layout' => 'register',
                'task' => 'login.displayAjax'
            );
$urlRegisterEmail = TpcxsocialHelperRoute::getRegistrationRoute($urlParam);

$urlParam = array(
                'task' => 'login.displayAjax'
            );
$urlLogin = TpcxsocialHelperRoute::getLoginRoute($urlParam);
?>

<div class="registration">
    
    <h1 class="title">Inscription</h1>
    
    <div class="border"></div>
    
    <div class="buttons">
        <a class="btn-facebook" href="javascript:void(0)" onclick="fb_login()">
            <i class="fa fa-facebook"></i>
            <span>Inscription avec Facebook</span>
        </a>
        
        <div class="separator">
            <p>ou</p>
        </div>
        
        <a class="link-register-email various fancybox.ajax" href="<?php echo JRoute::_($urlRegisterEmail); ?>">
            <span>S'inscrire avec votre email >></span>
        </a>
    </div>
    
    <div class="border"></div>
    
    <p class="text-bottom">Déjà membre de TripConnexion ? <a class="link-connect various fancybox.ajax" href="<?php echo JRoute::_($urlLogin); ?>">Connectez-vous ici !</a></p>
    
</div>