<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

$pathImg = JURI::base() . 'components/com_tpcxsocial/template/images/';
?>

<div class="profile clearfix">
    
    <h1 class="title">Mon compte</h1>
    
    <div class="clearfix">
        <div class="avatar">
            <div class="bg group-<?php echo $this->group; ?>"></div>
            <img src="<?php echo $this->avatar ?>" width="97" height="97" />
        </div>
    </div>
    
    <div class="content">
        
        <h2>Mes infos</h2>
        
        <div class="items clearfix">
            
            <div class="item profil">
                <div class="picto">
                    <img src="<?php echo $pathImg; ?>picto-config.png" />
                </div>
                <div class="link">
                    <a href="<?php echo JRoute::_('index.php?option=com_tpcxsocial&task=profile.edit&user_id='.(int) $this->data->id); ?>">Modifier</a>
                </div>
                <h3>Mon profil</h3>
                <div class="text">
                    <p>Pseudo : <?php echo $this->user->username; ?></p>
                    <p>Nom : <?php echo $this->user->name; ?></p>
                    <p>Prénom : <?php echo $this->user->firstname; ?></p>
                    <p>Email : <?php echo $this->user->email; ?></p>
                    <p>Je suis un <?php echo $this->groupName; ?></p>
                </div>
            </div>
            
            <div class="item notifications">
                <div class="picto">
                    <img src="<?php echo $pathImg; ?>picto-notifications.png" />
                </div>
                <h3>7 notifications !</h3>
                <div class="text">
                    <ul>
                        <li><span>1</span> nouveau message</li>
                        <li><span>1</span> nouvelle invitation d’ami</li>
                        <li><span>2</span> réponses d’annonce</li>
                        <li><span>3</span> réponses dans le forum</li>
                    </ul>
                </div>
            </div>
            
            <div class="item friends no-margin">
                <div class="picto">
                    <img src="<?php echo $pathImg; ?>picto-friends.png" />
                </div>
                <h3>Inviter mes amis</h3>
                <div class="text">
                    <img class="image-wide" src="<?php echo $pathImg; ?>friends-image.jpg" />
                </div>
            </div>
            
            <div class="item wanted-travel">
                <div class="picto">
                    <img src="<?php echo $pathImg; ?>picto-wanted-travel.png" />
                </div>
                <div class="link">
                    <a href="">Voir mes envies</a>
                </div>
                <h3>Mes envies de voyages</h3>
                <div class="text">
                    
                </div>
            </div>
            
        </div>
        
    </div>
    
</div>