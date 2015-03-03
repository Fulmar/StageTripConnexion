<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

$pathImg = JURI::base() . 'components/com_tpcxsocial/template/images/';
?>

<div class="clearfix">
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
</div>

<div class="items">
    <?php foreach($this->items as $item): ?>
        <div class="item clearfix">
            <div class="border-thread"></div>
            <div class="note clearfix">
                <div class="rating" data-average="<?php echo $item->rating; ?>" data-id="<?php echo $item->id; ?>"></div>
            </div>
            <div class="avatar">
                <div class="bg group-<?php echo $item->group_id; ?>"></div>
                <img src="<?php echo $item->avatar; ?>" width="40" height="40" />
            </div>
            <div class="user">
                <span class="name"><?php echo $item->created_by_name; ?></span> &bull; <?php echo $item->group_name; ?>
            </div>
            <div class="message">
                <?php echo $item->message; ?>
            </div>
            <div class="actions">
                <?php if($this->userIsLogged): ?>
                <ul>
                    <li class="evaluate">
                        <?php
                        $rating = TpcxsocialHelperUser::getRatingPost($this->user->id, $item->id);
                        if(!$rating) {
                            $rating = 0;
                        }
                        ?>
                        <label>Evaluer</label>
                        <div class="stars">
                            <div class="rating" data-average="<?php echo $rating; ?>" data-id="<?php echo $item->id; ?>"></div>
                        </div>
                    </li>
                    <li>
                        <a href="javascript:void(0)" class="btn-reply">Répondre</a>
                    </li>
                    <li>
                        <a href="">Partager</a>
                    </li>
                </ul>
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<script>
$(document).ready(function() {
    
    // rating
    $(".item .actions .rating").jRating({
        bigStarsPath: baseUrl + 'components/com_tpcxsocial/template/images/stars.png',
        type: 'big',
        length: 5,
        rateMax: 5,
        step: true,
        phpPath: baseUrl + 'index.php?option=com_tpcxsocial&task=user.rate',
    });
    $(".item .note .rating").jRating({
        isDisabled: true,
        bigStarsPath: baseUrl + 'components/com_tpcxsocial/template/images/stars.png',
        type: 'big',
        length: 5,
        rateMax: 5,
        step: true,
        phpPath: baseUrl + 'index.php?option=com_tpcxsocial&task=user.rate',
    });
    
    $('a.btn-reply').click(function() {
        $('.discussion .reply').hide();
        $('.bloc-reply').show();
        $('body').animate({
            scrollTop: $('.bloc-reply').offset().top - 103
        });
    });
});
</script>