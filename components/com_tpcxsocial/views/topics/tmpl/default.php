<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

$app = JFactory::getApplication();

$pathImg = TpcxsocialHelperTpcxsocial::getPathImage();
?>

<div class="topics clearfix">
    
    <div class="categories">
        <?php echo $this->loadTemplate('categories'); ?>
    </div>
    
    <div class="items">
        
        <?php if(JRequest::getVar('term')): ?>
        <p class="result-search">Les disussions en lien avec votre recherche : <span>"<?php echo JRequest::getVar('term'); ?>"</span></p>
        <?php else: ?>
        <div class="filter clearfix">
            <form name="filter" action="" method="get">
                <input type="hidden" name="filter_order" value="" />
                <label>Trier les discussions :</label>
                <ul class="choices">
                    <li class="selected">
                        <a href="javascript:void(0)" data-value="<?php echo $this->filter_selected['value']; ?>">
                            <?php echo $this->filter_selected['name']; ?> <span><i class="fa fa-chevron-down"></i></span>
                        </a>
                        <ul class="children">
                            <?php foreach($this->filters as $filter): ?>
                                <li>
                                    <a href="javascript:void(0)" data-value="<?php echo $filter['value']; ?>">
                                        <?php echo $filter['name']; ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </li>
                </ul>
            </form>
        </div>
        <?php endif; ?>
        
        <?php foreach($this->items as $item): ?>
            <div class="item">
                <div class="clearfix">
                    <div class="avatar avatar-<?php echo $item->id; ?>">
                        <div class="bg"></div>
                        <img src="" width="40" height="40" />
                    </div>
                    <script>
                        $(document).ready(function() {
                            data = {
                                user_id: '<?php echo $item->created_by; ?>',
                                avatarWidth: 40,
                                avatarHeight: 40
                            };
                            $.ajax({
                                url : baseUrl + 'index.php?option=com_tpcxsocial&task=user.getInfo',
                                dataType: 'json',
                                method: 'post',
                                data: data,
                                beforeSend: function() {
                                    $('<img>')
                                        .attr('class', 'loader')
                                        .attr('src', '<?php echo JURI::base(); ?>templates/tpcx/images/ajax-loader.gif')
                                        .appendTo('.avatar-<?php echo $item->id; ?>');
                                },
                                success: function(data) {
                                    $('.avatar-<?php echo $item->id; ?> img.loader').remove();
                                    $('.avatar-<?php echo $item->id; ?> .bg').addClass('group-' + data.group);
                                    $('.avatar-<?php echo $item->id; ?> img').attr('src', data.avatar);
                                }
                            }); 
                        });
                    </script>
                    <div class="like-topic like-topic-<?php echo $item->id; ?>">
                        <?php $userLiked = TpcxsocialHelperUser::getLikedTopic($this->user->id, $item->id); ?>
                        <?php if(!$userLiked): ?>
                        <a href="javascript:void(0)" onclick="like_topic(<?php echo $item->id; ?>, <?php echo $this->user->id; ?>)">
                        <?php endif; ?>
                            <img src="<?php echo $pathImg; ?>picto-like.png" alt="" />
                        <?php if(!$userLiked): ?>
                        </a>
                        <?php endif; ?>
                        <span>
                            <span class="number"><?php echo $item->rating; ?></span>
                            Trip
                        </span>
                    </div>
                    <h2>
                        <a href="<?php echo JRoute::_(TpcxsocialHelperRoute::getTopicRoute($item->id)); ?>"><?php echo $item->subject; ?></a>
                    </h2>
                    <div class="intro">
                        <?php echo $item->description_intro; ?>
                    </div>
                </div>
                <div class="informations">
                    <div class="show-discussion">
                        <a href="<?php echo JRoute::_(TpcxsocialHelperRoute::getTopicRoute($item->id)); ?>">
                            <span>voir la discussion</span>
                        </a>
                    </div>
                    <p class="user">
                        <span class="name">
                            <?php echo $item->created_by_name; ?>
                        </span> a posé cette question le <?php echo JHTML::_('date', $item->created, 'd/m/Y'); ?>
                        &bull; Il y'a <?php echo $item->posts; ?> réponse<?php echo ($item->posts > 1 ? 's' : ''); ?>
                    </p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    
</div>
<script>
    $(document).ready(function() {
        $('.filter .choices .selected').click(function() {
            $('.filter .children').slideToggle({
                duration: 400
            });
            return false;
        });
        $('.filter .children a').each(function(index, element){
            $(this).click(function(){
                $('input[name=filter_order]').val($(this).attr('data-value'));
                $('form[name=filter]').submit();
            });
        });
        
        $(document).click(function(){
            $(".filter .children").slideUp(150);
        });
    });
</script>