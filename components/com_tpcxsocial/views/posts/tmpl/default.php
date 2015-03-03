<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

$pathImg = JURI::base() . 'components/com_tpcxsocial/template/images/';
?>

<div class="topic">
    
    <h1 class="title"><?php echo $this->topic->subject; ?></h1>
    
    <div class="clearfix">
        <div class="avatar avatar-<?php echo $this->topic->id; ?>">
            <div class="bg"></div>
            <img src="" width="97" height="97" />
        </div>
        <script>
            $(document).ready(function() {
                data = {
                    user_id: '<?php echo $this->topic->created_by; ?>',
                    avatarWidth: 97,
                    avatarHeight: 97
                };
                $.ajax({
                    url : baseUrl + 'index.php?option=com_tpcxsocial&task=user.getInfo',
                    dataType: 'json',
                    method: 'post',
                    data: data,
                    success: function(data) {
                        $('.avatar-<?php echo $this->topic->id; ?> .bg').addClass('group-' + data.group);
                        $('.avatar-<?php echo $this->topic->id; ?> img').attr('src', data.avatar);
                    }
                }); 
            });
        </script>
        <?php echo TpcxsocialHelperTpcxsocial::getBreadcrumbs($this->topic->category_id); ?>
    </div>
    
    <p class="user-infos">Discussion entamée par <span class="mark"><?php echo $this->topic->created_by_name; ?></span> &bull; <span class="mark"><?php echo $this->topic->userType; ?></span></p>
    
    <div class="discussion">
        <div class="like-topic like-topic-<?php echo $this->topic->id; ?>">
            <?php $userLiked = TpcxsocialHelperUser::getLikedTopic($this->user->id, $this->topic->id); ?>
            <?php if(TpcxsocialHelperUser::isLogged()): ?>
                <?php if(!$userLiked): ?>
                <a href="javascript:void(0)" onclick="like_topic(<?php echo $this->topic->id; ?>, <?php echo $this->user->id; ?>)">
                <?php endif; ?>
                    <img src="<?php echo $pathImg; ?>picto-like.png" alt="" />
                <?php if(!$userLiked): ?>
                </a>
                <?php endif; ?>
            <?php endif; ?>
            
            <span>
                <span class="number"><?php echo $this->topic->rating; ?></span>
                Trip
            </span>
            <hr />
            <img src="<?php echo $pathImg; ?>picto-share.png" alt="" />
            <span>
                Partage
            </span>
        </div>
        
        <?php if(TpcxsocialHelperUser::isLogged()): ?>
        <div class="reply">
            <div class="bg"></div>
            <a href="javascript:void(0)">
                <span>Répondre</span>
            </a>
        </div>
        <?php endif; ?>
        
        <h2><?php echo $this->topic->subject; ?></h2>
        <div class="text"><?php echo $this->topic->description; ?></div>
    </div>

    <a name="bloc-reply"></a>
    <div class="bloc-reply">
        <div class="title">
            <span>Votre réponse</span>
        </div>
        <div class="form">
            <div class="message-error"></div>
            <form name="reply" action="" method="post">
                <div class="box-input box-input-tag">
                    <textarea name="jform[message]" id="jform_message" rows="10" cols="80" class="input-text required"></textarea>
                    <script>
                        // Replace the <textarea id="editor1"> with a CKEditor
                        // instance, using default configuration.
                        CKEDITOR.replace( 'jform_message', {
                            uiColor: '#04a4a3',
                            language: 'fr',
                            customConfig: '/components/com_tpcxsocial/template/js/ckeditor_topic_config.js'
                        } );
                    </script>
                </div>
                <div class="buttons">
                    <button type="submit" name="submit" class="button">Envoyer votre réponse >></button>
                    <input type="hidden" name="jform[topic_id]" value="<?php echo $this->topic->id; ?>" />
                    <?php echo JHtml::_('form.token');?>
                </div>
            </form>
            <script>
                $(document).ready(function() {
                    // validate
                    $('form[name=reply]').submit(function(){
                        CKEDITOR.instances.jform_message.updateElement();
                    }).validate({
                        ignore: "",
                        errorPlacement: function(error, element) {
                            error.appendTo( element.parent() );
                        },
                        rules: {
                            "jform[reply]": {
                                required: true
                            }
                        },
                        submitHandler: function (form) {
                            $.ajax({
                                url : baseUrl + 'index.php?option=com_tpcxsocial&task=post.save',
                                method: 'post',
                                data: $(form).serialize(),
                                success: function(response) {
                                    if(!response.error) {
                                        data = {
                                            filter_order: 'p.created',
                                            id: '<?php echo $this->topic->id; ?>'
                                        };
                                        // load posts
                                        load_posts(data);
                                        $('.reply').show();
                                        $('.bloc-reply').hide();
                                    } else {
                                        $('.message-error').html(response.errorMsg).show();
                                    }
                                }
                            });
                        }
                    });
                });
            </script>
        </div>
    </div>
    
    <div class="content-items">
        
    </div>
    
</div>
<script>
    $(document).ready(function() {
        
        $('.reply a').click(function() {
            $(this).parent().hide();
            $('.bloc-reply').show();
            $('body').animate({
                scrollTop: $('.bloc-reply').offset().top - 103
            });
        });
        
        data = {
            filter_order: $('input[name=filter_order]').val(),
            id: '<?php echo $this->topic->id; ?>'
        };
        // load posts
        load_posts(data);
        
    });
</script>