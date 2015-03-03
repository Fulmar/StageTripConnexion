<?php // no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

$term = JRequest::getVar('term', '');
?>
<div class="header">
    <div class="bg-top"></div>
    <div class="bg-bottom"></div>
    
    <h2>Le forum de voyage</h2>
        
        <div class="wrapper clearfix">
            
            <div class="search form">
                <form name="search" action="<?php echo JRoute::_(TpcxsocialHelperRoute::getRootForum()); ?>" method="get">
                    <p>Trouver une réponse dans les conversations</p>
                    <input type="text" class="input-text" name="term" value="<?php echo $term; ?>" placeholder="Tapez ici une destination ; une activité ..." />
                    <button type="submit" class="btn">
                        <span><i class="fa fa-search"></i></span>
                    </button>
                </form>
            </div>
            
            <div class="topic-new">
                <a href="<?php echo JRoute::_(TpcxsocialHelperRoute::getAddTopicRoute()); ?>">
                    Lancer une conversation en posant<br /> 
                    une nouvelle question >>
                </a>
            </div>
            
        </div>
    
</div>
