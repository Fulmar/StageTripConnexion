<?php // no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

$urlParam = array('task' => 'login.displayAjax');
$urlRegister = TpcxsocialHelperRoute::getRegistrationRoute($urlParam);
$urlLogin = TpcxsocialHelperRoute::getLoginRoute($urlParam);

$avatar = TpcxsocialHelperUser::getAvatar($user->id, 26, 26);
$linkLogout = TpcxsocialHelperUser::getLogoutLink($user->id);

?>
<div class="top-header-login clearfix">
    
    <?php if(!$isLogged): ?>
        <a class="link-login various fancybox.ajax" href="<?php echo JRoute::_($urlRegister); ?>">Inscription</a>
        <a class="link-login various fancybox.ajax" href="<?php echo JRoute::_($urlLogin); ?>">Connexion</a>
    <?php else: ?>
        
        <div class="connect clearfix">
            
            <div class="top">
                <ul>
                    <li>
                        <a href=""><i class="fa fa-bell"></i></a>
                    </li>
                    <li>
                        <a href=""><i class="fa fa-envelope"></i></a>
                    </li>
                </ul>
                
                    
            </div>
            
            <div class="menu-level1">
                <ul>
                    <li>
                        <a href="<?php echo JRoute::_(TpcxsocialHelperRoute::getRootForum()); ?>">Le forum</a>
                    </li>
                    <li>
                        <a href="">Passer une annonce</a>
                    </li>
                    <li>
                        <a href="<?php echo JRoute::_(TpcxsocialHelperRoute::getAccountUrl()); ?>" class="my-account">
                            <div class="avatar">
                                <div class="bg"></div>
                                <img src="<?php echo $avatar ?>" width="26" height="26" />
                            </div>
                            <span>Mon compte <i class="fa fa-chevron-down"></i></span>
                        </a>
                        <div class="menu-level2">
                            <ul>
                                <li>
                                    <a href="<?php echo $linkLogout['href']; ?>" onclick="<?php echo $linkLogout['onclick']; ?>">Déconnexion</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                </ul>   
            </div>
             
        </div>
        
    <?php endif; ?>
    
</div>