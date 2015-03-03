<?php

/**
 * Template Tpcx 
 *
 * @author Fabien Vautour 
 */

// no direct access
defined('_JEXEC') or die;
$app = JFactory::getApplication();
?>
<!---<div class="flech-header" style="overflow:initial;">
	<img alt="" src="<?php// JURI::base(); ?>templates/tpcx/images/flech-concept.png" />
</div>--->
<header id="hp-header" class="clearfix" style="background-image: url('<?php echo JURI::base() . $params->get('image_bg'); ?>');">
    
    <div id="video-hp">
        <video loop="loop" preload="auto" width="1920" height="1080">
            <source src="<?php JURI::base(); ?>templates/tpcx/videos/HEADER_tripconnexion_1080p.mp4" type="video/mp4" /></source>
            <source src="<?php JURI::base(); ?>templates/tpcx/videos/HEADER_tripconnexion_1080p.webm" type="video/webm" /></source>
        </video>
    </div>
	
    <div class="nav-header">

	</div>

    <div class="picto logo-fb">
        <a href="<?php echo $params->get('link-facebook'); ?>" target="_blank">
            <img src="<?php echo JURI::base() . 'templates/' . $app->getTemplate() . '/images/logo-hp-header-fb.png'; ?>" alt="Tripconnexion Facebook" />
        </a>
    </div>
    <div class="picto logo-gplus">
        <a href="<?php echo $params->get('link-googleplus'); ?>" target="_blank">
            <img src="<?php echo JURI::base() . 'templates/' . $app->getTemplate() . '/images/logo-hp-header-gplus.png'; ?>" alt="Tripconnexion Google Plus" />
        </a>
    </div>
    <div class="picto logo-twitter">
        <a href="<?php echo $params->get('link-twitter'); ?>" target="_blank">
            <img src="<?php echo JURI::base() . 'templates/' . $app->getTemplate() . '/images/logo-hp-header-twitter.png'; ?>" alt="Tripconnexion Twitter" />
        </a>
    </div>
    <div class="picto logo-instagram">
        <a href="<?php echo $params->get('link-instagram'); ?>" target="_blank">
            <img src="<?php echo JURI::base() . 'templates/' . $app->getTemplate() . '/images/logo-hp-header-instagram.png'; ?>" alt="Tripconnexion Instagram" />
        </a>
    </div>
    <div class="picto logo-pinterest">
        <a href="<?php echo $params->get('link-pinterest'); ?>" target="_blank">
            <img src="<?php echo JURI::base() . 'templates/' . $app->getTemplate() . '/images/logo-hp-header-pinterest.png'; ?>" alt="Tripconnexion Pinterest" />
        </a>
    </div>
	<div class="picto logo-arrow-down">
		<a href="#">
		<img alt="" src="<?php JURI::base(); ?>templates/tpcx/images/logo-hp-header-arrow-down.png">
		</a>
	</div>

    
    <div class="wrapper">
        
        <div class="logo">
            <img src="<?php echo JURI::base() . 'templates/' . $app->getTemplate() . '/images/logo-tpcx-hp-header.png'; ?>" alt="Tripconnexion" />
        </div>
        
        <h1 class="title"><?php echo $params->get('intro'); ?></h1>
        
        <div class="bg-input-hp-header">
            <div class="rope-bg"></div>
            <div class="clearfix" style="position: relative;">
                <input type="text" class="input-destination-home" name="pays-slideshow" placeholder="Où souhaitez-vous aller ?" />
                <button type="submit" name="search" class="btn-destination-search-hp-header"><span><i class="fa fa-search"></i></span></button>
                <ul id="list-destination" class="list-destination">
                    <?php foreach($listPays as $item): ?>
                        <li><a data-value="<?php echo $item->id; ?>" href="javascript:;"><?php echo $item->tag; ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
        
        <a id="inlinedataproject" href="#dataproject"></a>

        <div style="display:none">
            <div id="dataproject" class="popup-search">
                <h3>Affinez votre recherche</h3>
                <p class="selection-recherche">Pour votre recherche <span id="term-project" class="term"></span>, vous souhaitez :</p>
                <div style="margin-top: 20px; margin-left: 20px;">
                    <div><a href="javascript:void(0);" id="btn-soumettre-projet"><img src="<?php echo JURI::base() . 'templates/' . $app->getTemplate() . '/images/btn-presenter-projet.png'; ?>" alt="" /></a></div>
                    <div><a href="javascript:void(0);" id="btn-voir-partenaire"><img src="<?php echo JURI::base() . 'templates/' . $app->getTemplate() . '/images/btn-partenaire.png'; ?>" alt="" /></a></div>
                    <div><a href="javascript:void(0);" id="btn-voir-voyages"><img src="<?php echo JURI::base() . 'templates/' . $app->getTemplate() . '/images/btn-voyages.png'; ?>" alt="" /></a></div>
                </div>
            </div>
        </div>
    
    </div>
</header>
<script>
    var min_w = 300; // minimum video width allowed
    var vid_w_orig;  // original video dimensions
    var vid_h_orig;
    
    $(function() { // runs after DOM has loaded
    
        vid_w_orig = parseInt($('video').attr('width'));
        vid_h_orig = parseInt($('video').attr('height'));
    
        $(window).resize(function () { resizeToCover(); });
        $(window).trigger('resize');
    });
    
    function resizeToCover() {
    
        // set the video viewport to the window size
        $('#video-hp').width($(window).width());
        $('#video-hp').height($(window).height());
    
        // use largest scale factor of horizontal/vertical
        var scale_h = $(window).width() / vid_w_orig;
        var scale_v = $(window).height() / vid_h_orig;
        var scale = scale_h > scale_v ? scale_h : scale_v;
    
        // don't allow scaled width < minimum video width
        if (scale * vid_w_orig < min_w) {scale = min_w / vid_w_orig;};
    
        // now scale the video
        $('video').width(scale * vid_w_orig);
        $('video').height(scale * vid_h_orig);
        // and center it by scrolling the video viewport
        $('#video-hp').scrollLeft(($('video').width() - $(window).width()) / 2);
        $('#video-hp').scrollTop(($('video').height() - $(window).height()) / 2);
    
    };
   
    $(window).load(function() {
        var video = document.querySelector('#video-hp video');
        
        function checkLoad() {
            if (video.readyState === 4) {
                video.autoplay = true;
                $('#video-hp').show();
                video.play();
            } else {
                setTimeout(checkLoad, 100);
            }
        }
    
        checkLoad();
    });
    
    function resize() {
        $('#hp-header').css('height', $("body").height());
    }
    $(window).load(function() {
        $(window).on("resize", function() {
            resize();
        });
    });
    
    $(document).ready(function() {
        resize();
        // link scroll
		$(".logo-arrow-down a, .nav-header").click(function(event) {
			event.preventDefault();
			$("body, html").animate({
				scrollTop: $("#products-enlarge-top-content").offset().top + 10
				
				
			});
		});
        
        $(".nav-header a.magazine").click(function(event) {
            event.preventDefault()
            $("body, html").animate({
                scrollTop: $(".module.magazine").offset().top
            });    
        });
        
        $(".nav-header a.partenaire").click(function(event) {
            event.preventDefault();
            $("body, html").animate({
                scrollTop: $(".annuaire-home").offset().top
            });    
        });
        
        $(".nav-header a.projet").click(function(event) {
            event.preventDefault();
            $("body, html").animate({
                scrollTop: $("#travel-project-container").offset().top
            });    
        });    
    });
    
    $(window).load(function(){
    
        function resizeSlideshow()
        {
            var  heightMax = 0;
            $('#slideshow #slides ul li .slide .image').each(function( index ) {
                if($(this).height() > heightMax)
                    heightMax = $(this).height();
            });
            
            $('#slideshow').height(heightMax);
            $('.arguments').height(heightMax);
            $('.arguments .form').show();
        }
        
        /*resizeSlideshow();
        $(window).resize(function(){
            resizeSlideshow();
        });*/
        
        $('#slides ul').show();
        $('#slides .loader').hide();
        
        $('#slides ul').innerFade({
            speed: 1000,
            timeout: 4000,
            loop: true,
            containerHeight: '556px',
            prevLink: '.prev-link',
            nextLink: '.next-link'
        });
        // autocomplete
        var destination = [
            <?php foreach($listPays as $item): ?>
            {
                id: "<?php echo $item->id; ?>",
                value: "<?php echo $item->tag; ?>",
                label: "<?php echo $item->tag; ?>"
            },
            <?php endforeach; ?>
        ];
        
        var accentMap = {
            "é": "e",
            "É": "e",
            "ö": "o",
            "à": "a"
        };
        
        var normalize = function( term ) {
            var ret = "";
            for ( var i = 0; i < term.length; i++ ) {
                ret += accentMap[ term.charAt(i) ] || term.charAt(i);
            }
            return ret;
        };
        
        $('.input-destination-home').autocomplete({
            minLenght: 0,
            autoFocus: true,
            source: function( request, response ) {
                var matcher = new RegExp( $.ui.autocomplete.escapeRegex( extractLast(request.term) ), "i" );
                response( $.grep( destination, function( value ) {
                    value = value.label || value.value || value;
                    return matcher.test( value ) || matcher.test( normalize( value ) );
                }) );
            },
           // source: destination,
            change: function(event, ui) {
                
            },
            select: function(event, ui) {
                value = ui.item.id;
                
                $.ajax({
                    dataType: "json",
                    url: baseUrl + 'index.php?option=com_tpcxtags&task=checkproduct&continent_id=&pays_id='
                                  + value + '&thematique_id=',
                    success: function(data) {
                        
                        if(data.travels == 0 && data.partners == 0) {
                            $("html, body").animate({
                                scrollTop: $("#travel-project-container").offset().top - 0
                            }, {
                                duration: 400,
                                complete: function() {
                                    
                                }
                            });
                            return;
                        }
                        
                        // products empty
                        if(data == 0) {
                            $('#btn-voir-voyages').parent().hide();
                        } else {
                            $('#btn-voir-voyages').parent().show();
                        }
                        
                        // partners empty
                        // if(data.partners == 0) {
                            // $('#btn-voir-partenaire').parent().hide();
                        // } else {
                            // $('#btn-voir-partenaire').parent().show();
                        // }
                        
                        $('select[name=choix-pays-1]').val(value);
                        $('select[name=choix-pays-1]').next().children(".customSelectInner").html(ui.item.label);
                        $('.box-form-pays-2').show();
                        
                        $('.selection-recherche #term-project').empty();
                        $('.selection-recherche #term-project').append(ui.item.label);
                        
                        $("a#inlinedataproject").trigger('click');
                        
                        $("a#btn-soumettre-projet").bind('click', function(e){
                            e.preventDefault();
                            $.fancybox.close();
                            $("html, body").animate({
                                scrollTop: $("#travel-project-container").offset().top - 0
                            }, {
                                duration: 400,
                                complete: function() {
                                    
                                }
                            });
                        });
                        
                        $("a#btn-voir-partenaire").bind('click', function(e){
                            e.preventDefault();
                            $.fancybox.close();
                            $(location).attr('href', baseUrl + 'annuaire?c=&p=' + value + '&t=');
                        });
                                    
                        $("a#btn-voir-voyages").bind('click', function(e){
                            e.preventDefault();
                            $.fancybox.close();
                            $(location).attr('href', baseUrl + 'voyages?c=&p=' + value + '&t=');
                        });
                        
                    }
                });
                
            }
        });
        
        $( ".btn-destination-search" ).click(function() {
            $('.input-destination-home').trigger('focus');
        });
        
    });
    
</script>