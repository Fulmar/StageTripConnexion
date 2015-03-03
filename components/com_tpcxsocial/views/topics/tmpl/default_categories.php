<h2><a href="<?php echo JRoute::_(TpcxsocialHelperRoute::getRootForum()); ?>">Parcourir toutes les destinations</a></h2>
<ul class="level1">
    <?php foreach($this->categories as $category): ?>
        <li>
            <a href="javascript:void(0);" class="link-title"><?php echo $category->title; ?> <span>>></span></a>
        
            <?php if(count($category->children) > 0): ?>
                <?php
                $class = array();
                $class[] = 'level2';
                if(!$category->selected)
                    $class[] = 'hide';    
                $class = implode(' ', $class);
                ?>
                <ul class="<?php echo $class; ?>">
                    <?php foreach($category->children as $subCategory): ?>
                        <li class="<?php echo ($subCategory->selected ? 'selected' : ''); ?>">
                            <a href="<?php echo JRoute::_(TpcxsocialHelperRoute::getCategoryRoute($subCategory->id)); ?>"><?php echo $subCategory->title; ?></a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </li>
    <?php endforeach; ?>
</ul>
<script>
    $(document).ready(function() {
        $('.link-title').each(function(index, element) {
            $(element).click(function() {
                $(this).parent().find('.level2').slideToggle({
                    duration: 400,
                    complete: function() {
                        if($(this).is(':visible')) {
                            $(this).parent().find('.link-title span').html('<i class="fa fa-chevron-down"></i>');
                        } else {
                            $(this).parent().find('.link-title span').html('>>');
                        }
                    }
                });
            });
        });
    });
</script>