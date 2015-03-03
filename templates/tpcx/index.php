<?php

/**
 * Template Trip Connexion  
 *
 * @author fvautour 
 */

// restricted access
defined( '_JEXEC' ) or die;

// init
include_once(JPATH_ROOT . '/templates/' . $this->template . '/php/function.php');
include_once(JPATH_ROOT . '/templates/' . $this->template . '/php/init.php');

// detection source
$page_en_cours = strtolower($_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
$utm_source_url = 'utm_source';
$find = strpos($page_en_cours,$utm_source_url);
if($find == TRUE)   {
    if(isset($_SESSION['utm_source']))  {
        $findURI = strpos($_SESSION['utm_source'],$_SERVER['REQUEST_URI']);
        if($findURI == FALSE)   {
            if(!empty($_SERVER['REQUEST_URI'])) {
                $_SESSION['utm_source'] = $_SESSION['utm_source'].'<br >'.$_SERVER['REQUEST_URI'];
            }
        }
    }else{
        if(!empty($_SERVER['REQUEST_URI'])) {
            $_SESSION['utm_source'] = '<br /><br />TRACKING SOURCES : <br />'.$_SERVER['REQUEST_URI'];
        }
    }
}

?><!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        
        <meta   name="description"  content="<?php echo $this->getDescription(); ?>" />      
        <meta   name="keywords"     content="<?php echo $this->getMetaData('keywords'); ?>" />
        
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <meta name="p:domain_verify" content="15853fcf1be7b7ce76dfbd244c8ca3e2"/>
        
        <link rel="icon" type="image/png" href="<?php echo $this->baseurl . '/templates/' . $this->template . '/favicon.png'; ?>" />
        
        <!-- fonts -->
        <link href='<?php echo $this->baseurl . '/templates/' . $this->template . '/css/fonts/fonts.css'; ?>' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="<?php echo $this->baseurl . '/templates/' . $this->template . '/css/font-awesome/font-awesome.min.css'; ?>">
        
        <link href="https://plus.google.com/102202152641551309796" rel="publisher" />
        
        <!-- css -->    
        <link rel="stylesheet" href="<?php echo $this->baseurl . '/templates/' . $this->template . '/css/normalize.css'; ?>">
        <link rel="stylesheet" href="<?php echo $this->baseurl . '/templates/' . $this->template . '/css/jquery.fancybox.css'; ?>">
        <link rel="stylesheet" href="<?php echo $this->baseurl . '/templates/' . $this->template . '/css/jquery-ui-1.10.2.custom.css'; ?>">
        <link rel="stylesheet" href="<?php echo $this->baseurl . '/templates/' . $this->template . '/css/layout.css'; ?>">
        <link rel="stylesheet" href="<?php echo $this->baseurl . '/templates/' . $this->template . '/css/general.css'; ?>">
        <link rel="stylesheet" href="<?php echo $this->baseurl . '/templates/' . $this->template . '/css/menu.css'; ?>">
        <link rel="stylesheet" href="<?php echo $this->baseurl . '/templates/' . $this->template . '/css/content.css'; ?>">
        <link rel="stylesheet" href="<?php echo $this->baseurl . '/templates/' . $this->template . '/css/module.css'; ?>">
        <link rel="stylesheet" media="screen and (max-width: 1020px)" href="<?php echo $this->baseurl . '/templates/' . $this->template . '/css/styles_max_1020.css'; ?>" type="text/css" />
        <link rel="stylesheet" media="screen and (max-width: 740px)" href="<?php echo $this->baseurl . '/templates/' . $this->template . '/css/styles_max_740.css'; ?>" type="text/css" />
        
        <script async src="<?php echo $this->baseurl . '/templates/' . $this->template . '/js/modernizr-2.6.2-respond-1.1.0.min.js'; ?>"></script>
        
        <!-- js -->
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="<?php echo $this->baseurl . '/templates/' . $this->template . '/js/jquery-1.9.1.min.js'; ?>"><\/script>')</script>
        <script src="<?php echo $this->baseurl . '/templates/' . $this->template . '/js/jquery-ui-1.10.4.custom.min.js'; ?>"></script>
        <!-- <script src="<?php /*echo $this->baseurl . '/templates/' . $this->template . '/js/jquery.ui.datepicker-fr.js'; */?>"></script>-->
		<script type="text/javascript">
				/* French initialisation for the jQuery UI date picker plugin. */
			/* Written by Keith Wood (kbwood{at}iinet.com.au),
					  StÃ©phane Nahmani (sholby@sholby.net),
				  StÃ©phane Raimbault <stephane.raimbault@gmail.com> */
			jQuery(function(a){a.datepicker.regional.fr={closeText:"Fermer",prevText:"Pr\u00e9c\u00e9dent",nextText:"Suivant",currentText:"Aujourd'hui",monthNames:"Janvier F\u00e9vrier Mars Avril Mai Juin Juillet Ao\u00fbt Septembre Octobre Novembre D\u00e9cembre".split(" "),monthNamesShort:"Janv. F\u00e9vr. Mars Avril Mai Juin Juil. Ao\u00fbt Sept. Oct. Nov. D\u00e9c.".split(" "),dayNames:"Dimanche Lundi Mardi Mercredi Jeudi Vendredi Samedi".split(" "),dayNamesShort:"Dim. Lun. Mar. Mer. Jeu. Ven. Sam.".split(" "), dayNamesMin:"DLMMJVS".split(""),weekHeader:"Sem.",dateFormat:"dd/mm/yy",firstDay:1,isRTL:!1,showMonthAfterYear:!1,yearSuffix:""};a.datepicker.setDefaults(a.datepicker.regional.fr)});
		</script>
        <script async src="<?php echo $this->baseurl . '/templates/' . $this->template . '/js/jquery.innerfade.js'; ?>"></script>
        <script src="<?php echo $this->baseurl . '/templates/' . $this->template . '/js/jquery.customSelect.min.js'; ?>"></script>
        <script async src="<?php echo $this->baseurl . '/templates/' . $this->template . '/js/jquery.fancybox.pack.js'; ?>"></script>
        <script async src="<?php echo $this->baseurl . '/templates/' . $this->template . '/js/jquery.validate.js'; ?>"></script>
        <script async src="<?php echo $this->baseurl . '/templates/' . $this->template . '/js/functions.js'; ?>"></script>
        <script async src="<?php echo $this->baseurl . '/templates/' . $this->template . '/js/response.min.js'; ?>"></script>
        <script src="<?php echo $this->baseurl . '/templates/' . $this->template . '/js/jquery.jcarousel.min.js'; ?>"></script>
        
        <jdoc:include type="head" />
        
        <?php if(JURI::getInstance()->getHost() == 'www.tripconnexion.com'): ?>
        <script type="text/javascript">

          var _gaq = _gaq || [];
          _gaq.push(['_setAccount', 'UA-39995668-1']);
          _gaq.push(['_trackPageview']);
          _gaq.push(['_setDomainName', 'tripconnexion.com']);
        
          (function() {
            var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
            ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
            var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
          })();
        
        </script>
		<?php endif; ?>
		<?php if(JURI::getInstance()->getHost() == 'www.tripconnexion.com'): ?>
		<script>(function() {
			  var _fbq = window._fbq || (window._fbq = []);
			  if (!_fbq.loaded) {
				var fbds = document.createElement('script');
				fbds.async = true;
				fbds.src = '//connect.facebook.net/en_US/fbds.js';
				var s = document.getElementsByTagName('script')[0];
				s.parentNode.insertBefore(fbds, s);
				_fbq.loaded = true;
			  }
			  _fbq.push(['addPixelId', '1581988462031653']);
			})();
			window._fbq = window._fbq || [];
			window._fbq.push(['track', 'PixelInitialized', {}]);
		</script>
		<noscript><img height="1" width="1" alt="" style="display:none" src="https://www.facebook.com/tr?id=1581988462031653&amp;ev=PixelInitialized" /></noscript>
        <?php endif; ?>
        
        <?php if(JURI::getInstance()->getHost() == '127.0.0.1'): ?>
        <script type="text/javascript">

          var _gaq = _gaq || [];
          _gaq.push(['_setAccount', 'UA-40870460-1']);
          _gaq.push(['_trackPageview']);
          _gaq.push(['_setDomainName', 'tripconnexion.com']);
        
          (function() {
            var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
            ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
            var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
          })();
        
        </script>
        <?php endif; ?>
        
    </head>
    <body class="<?php echo implode(' ', $class); ?> ">

        <?php if($this->countModules('absolute')) : ?>
        <!-- absolute -->
        <div id="absolute">                 
            <jdoc:include type="modules" name="absolute" />
        </div>      
        <!--! absolute -->            
        <?php endif; ?>
        
        <!-- sticky-footer -->
        <div id="sticky-footer">
            
            <?php
            jimport( 'joomla.application.module.helper' ); 
            jimport( 'joomla.html.parameter' ); 
            $module = &JModuleHelper::getModule('mod_tpcx_slideshow'); 
            $moduleParams = new JParameter($module->params);
            require_once JPATH_SITE . '/modules/mod_tpcx_slideshow/helper.php';
            $listPays = modTpcxSlideshowHelper::getList($moduleParams, 'pays');
            ?>
            
            <div class="mobile-header">
                <div class="bg-bottom-header"></div>
                <div class="logo">
					<div class="logo-mobile">
						<a href="<?php echo JURI::base(); ?>">
							<img src="<?php echo $this->baseurl . '/templates/' . $this->template . '/images/logo-mobile.png'; ?>" alt="" />
						</a>
					</div>
					<div class="logo-tablette">
						<a href="<?php echo JURI::base(); ?>">
							<img src="<?php echo $this->baseurl . '/templates/' . $this->template . '/images/logo.png'; ?>" alt="" />
						</a>
					</div>
                </div>
				<div class="buttonHeader">
					<input type="text" class="input-destination-home" name="pays-slideshow" placeholder="Où souhaitez-vous allez ?" />
					<button type="submit" name="search" class="btn-destination-search"><span><i class="fa fa-search"></i></span></button>
					<ul id="list-destination" class="list-destination">
						<?php foreach($listPays as $item): ?>
							<li><a data-value="<?php echo $item->id; ?>" href="javascript:;"><?php echo $item->tag; ?></a></li>
						<?php endforeach; ?>
					</ul>
				</div>
            </div>

            <?php if($hp): ?>
				<div class="concept-mobile">
					<div class="bg-top"></div>
					<div class="img-mobile">
						<img src="<?php echo $this->baseurl . '/templates/' . $this->template . '/images/concept-mobile.jpg'; ?>" alt="" style="width:100%;"/>
					</div>
					<div class="flech-mobile">
						<img src="<?php echo $this->baseurl . '/templates/' . $this->template . '/images/flech-mobile.png'; ?>" alt="" />
					</div>
				</div>    
                <?php if($this->countModules('hp-header')) : ?>
                <!-- hp-header -->
                <jdoc:include type="modules" name="hp-header" />
                <!--! hp-header -->            
                <?php endif; ?>
                
            <?php else: ?>
                
                <!-- header -->
                <div class="header-container <?php echo $hp ? 'header-container-home' : ''; ?> <?php echo $hp ? 'slideshow-show' : ''; ?>">
                    <div class="bg-bottom-header"></div>
                    
                    <header id="header" class="clearfix">
                        
                        <div class="btn">
                            <a href="javascript:void(0);" <?php echo $hp ? 'class="on"' : ''; ?>></a>
                        </div>
                        <div class="logo">
                            <a href="<?php echo JURI::base(); ?>">
                                <?php if($hp): ?>
                                    <img src="<?php echo $this->baseurl . '/templates/' . $this->template . '/images/logo-home.png'; ?>" alt="" />
                                <?php else: ?>
                                    <img src="<?php echo $this->baseurl . '/templates/' . $this->template . '/images/logo.png'; ?>" alt="" />
                                <?php endif; ?>
                            </a>
                        </div>
                        <?php if($hp): ?>
                        <div class="intro" style="float: left; margin-left: 90px;">
                            <p class="text-intro">Voyagez sans intermédiaire</p>
                            <p>avec le réseau de <img src="<?php echo $this->baseurl . '/templates/' . $this->template . '/images/logo-intro.png'; ?>" alt="" /> !</p>
                        </div>
                        <?php endif; ?>
                        
                        <?php if(!$hp): ?>
                            
                            <div class="top-header-search" style="float: left; margin-left: 80px; margin-top: 18px;">
                                <div class="clearfix" style="position: relative;">
                                    <input type="text" class="input-destination-header" name="pays-slideshow" placeholder="Voyagez sans intermédiaire! Où souhaitez-vous aller ?..." />
                                    <button type="submit" name="search" class="btn-destination-search"><span><i class="fa fa-search"></i></span></button>
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
                                        <div><a href="javascript:void(0);" id="btn-soumettre-projet"><img src="<?php echo $this->baseurl . '/templates/' . $this->template . '/images/btn-presenter-projet.png'; ?>" alt="" /></a></div>
                                        <div><a href="javascript:void(0);" id="btn-voir-partenaire"><img src="<?php echo $this->baseurl . '/templates/' . $this->template . '/images/btn-partenaire.png'; ?>" alt="" /></a></div>
                                        <div><a href="javascript:void(0);" id="btn-voir-voyages"><img src="<?php echo $this->baseurl . '/templates/' . $this->template . '/images/btn-voyages.png'; ?>" alt="" /></a></div>
                                    </div>
                                </div>
                            </div>
    
                            <script type="text/javascript">
                            $(window).load(function(){
                                
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
                                
                                $('.input-destination-header').autocomplete({
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
                                    $('.input-destination-header').trigger('focus');
                                });
                                
                                /*
                                $("html").click(function() {
                                    $("#list-destination").hide();
                                });*/
                                
                            });
                            
                            </script>
                        <?php endif; ?>
                        
                        <div class="intro" style="margin-top: 0; margin-right: 0;">
                            <a class="link-popup-button" href="#">
                                <img src="<?php echo $this->baseurl . '/templates/' . $this->template . '/images/bon-plan-voyage-en-direct.png'; ?>" alt="" />
                            </a>
                            <script>
                                $(document).ready(function() {
                                    $('a.link-popup-button').click(function() {
                                        event.preventDefault();
                                        $.fancybox.open([
                                        {
                                            href : '#popup-email'
                                        }  
                                        ], {
                                            wrapCSS: 'fancybox-popup',
                                            scrolling: 'no',
                                            minWidth: 938,
                                            afterShow: function() {
                                                $('.fancybox-inner').css('overflow', 'visible');
                                            }
                                        });
                                    });
                                });
                            </script>
                        </div>
                        
                    </header>
                    
                    <!--<div class="stamp">
                        <a class="modal" href="index.php?option=com_chronoforms&amp;chronoform=nous-contacter&amp;tmpl=component" rel="{handler: 'iframe', size: {x: 600, y: 600}}">
                            <img src="<?php echo $this->baseurl . '/templates/' . $this->template . '/images/stamp.png'; ?>" alt="" />
                        </a>
                    </div>-->
                    
                </div>
                <!--! header -->
                
            <?php endif; ?>
			<?php if($this->countModules('products-enlarge-top-content')) : ?>
			<!-- products-enlarge-top-content -->
			<div id="products-enlarge-top-content">
				<jdoc:include type="modules" name="products-enlarge-top-content" />
			</div>
			<!--! products-enlarge-top-content -->
			<?php endif; ?>
            
            
            <?php if($this->countModules('slideshow')) : ?>
            <!-- slideshow -->
            <div id="slideshow-container">
                <jdoc:include type="modules" name="slideshow" /> 
            </div>
            <!--! slideshow -->
            <?php endif; ?>
            
            <!-- middle -->
            <?php
            $class = array();
            if($hp) {
                $class[] = 'slideshow-show';
                $class[] = 'middle-home';
            }
            $class = implode(" ", $class);
            ?>
            <div id="middle" class="<?php echo $class; ?>">
                
                <div class="bg-top-middle"></div>
                
                <?php if($this->countModules('top')) : ?>
                <!-- top -->
                <div id="top" class="clearfix">
                    <div class="wrapper-big">
                        <div class="wrapper">
                            <jdoc:include type="modules" name="top" style="wrap" /> 
                        </div>
                    </div>
                </div>
                <!--! top -->
                <?php endif; ?>
                
                <?php if($this->countModules('products-before-content')) : ?>
                <!-- products-before-content -->
                <div id="products-before-content">
					<?php if($this->countModules('banner-title-top')) : ?>
                    <div class="banner-title">
						<!-- wrapper-big -->
						<div class="wrapper-big">
							<!-- wrapper -->
							<div class="wrapper">
								<jdoc:include type="modules" name="banner-title-top" style="wrap"/>
							<!-- wrapper -->
							</div>
						<!-- wrapper-big -->
						</div>
					</div>
					<?php endif; ?>
					<div class="content-bottom">
						<!-- wrapper-big -->
						<div class="wrapper-big">
							
							<!-- wrapper -->
							<div class="wrapper">
							
								<jdoc:include type="modules" name="products-before-content" style="wrap" />
							
							</div>
							<!--! wrapper -->
							
						</div>
						<!--! wrapper-big -->
                    </div>
                </div>
                <!--! products-before-content -->
                <?php endif; ?>
                
                <!-- content -->
                <div id="content">
					<?php if($this->countModules('banner-title')) : ?>
                    <div class="banner-title">
						<!-- wrapper-big -->
						<div class="wrapper-big">
							<!-- wrapper -->
							<div class="wrapper">
								<jdoc:include type="modules" name="banner-title" style="wrap"/>
							<!-- wrapper -->
							</div>
						<!-- wrapper-big -->
						</div>
					</div>
					<?php endif; ?>
					<div class="content-bottom">
						<!-- wrapper-big -->
						<div class="wrapper-big">
							
							<!-- wrapper -->
							<div class="wrapper">
							
								<?php if($this->countModules('content-top')) : ?>
								<!-- content-top -->
								<div id="content-top">
									<jdoc:include type="modules" name="content-top" style="wrap" /> 
								</div>
								<!--! content-top -->
								<?php endif; ?>
								
								<div id="content-middle" class="clearfix">
									
									<div id="main">
										
										<!-- component -->                          
										<jdoc:include type="message" />
										<jdoc:include type="component" />
										<!--! component -->
										
									</div>
									
									<?php if($this->countModules('right')) : ?>
									<!-- right -->
									<aside id="right">
										<jdoc:include type="modules" name="right" style="wrap" /> 
									</aside>
									<!--! right -->
									<?php endif; ?>
									
								</div>
								
								<?php if($this->countModules('content-bottom')) : ?>
								<!-- content-bottom -->
								<div id="content-bottom">
									<jdoc:include type="modules" name="content-bottom" style="wrap" /> 
								</div>
								<!--! content-bottom -->
								<?php endif; ?>
						
							</div>
							<!--! wrapper -->
								
						</div>
						<!--! wrapper-big -->
                    </div>
                </div>
                <!--! content -->
                
                <?php if($this->countModules('products-after-content')) : ?>
                <!-- products-after-content -->
                <div id="products-after-content">
					<?php if($this->countModules('banner-title-top')) : ?>
                    <div class="banner-title">
						<!-- wrapper-big -->
						<div class="wrapper-big">
							<!-- wrapper -->
							<div class="wrapper">
								<jdoc:include type="modules" name="banner-title-top" style="wrap"/>
							<!-- wrapper -->
							</div>
						<!-- wrapper-big -->
						</div>
					</div>
					<?php endif; ?>
					<div class="content-bottom">
						<!-- wrapper-big -->
						<div class="wrapper-big">
							
							<!-- wrapper -->
							<div class="wrapper">
							
								<jdoc:include type="modules" name="products-after-content" style="wrap" />
							
							</div>
							<!--! wrapper -->
							
						</div>
                    <!--! wrapper-big -->
					</div>
                    
                </div>
				<!-- products-after-content -->
				<?php endif; ?>
				<?php if($this->countModules('products-enlarge-bottom-content')) : ?>
				<!-- products-enlarge-bottom-content -->
                <div id="products-enlarge-bottom-content">
					<jdoc:include type="modules" name="products-enlarge-bottom-content" />
                </div>
                <!--! products-enlarge-bottom-content -->
                <?php endif; ?>
                
                <?php if($this->countModules('bottom')) : ?>
                <!-- bottom -->
                <div id="bottom">
                    <jdoc:include type="modules" name="bottom" /> 
                </div>
                <!--! bottom-->
                <?php endif; ?>
                
            </div>
            <!--! middle -->
            
        </div>
        <!--! sticky-footer -->
        
        <!-- footer -->  
        <div class="footer-container">  
                     
            <footer id="footer">
                <div class="wrapper" style="overflow: hidden; text-align: center;">
                    <jdoc:include type="modules" name="footer"/>
                </div>
            </footer>
            
        </div>
        <!--! footer -->  
        
        <!-- js -->
        <script>
            var baseUrl = '<?php echo JURI::base(); ?>';
            var templateUrl = '<?php echo $this->baseurl . '/templates/' . $this->template; ?>';
        </script>
        <script async src="<?php echo $this->baseurl . '/templates/' . $this->template . '/js/init.js'; ?>"></script>
        
        <!-- debug -->
        <jdoc:include type="modules" name="debug" />
        
        <a id="inlinedata" href="#data"></a>

        <div style="display:none">
            <div id="data" class="popup-search">
                <h3>Affinez votre recherche</h3>
                <p class="selection-recherche">Pour votre recherche <span id="term" class="term"></span>, vous souhaitez voir la liste :</p>
                <div style="margin-top: 20px;">
                    <div class="btn"><a href="" id="btn-choix-partenaire"><img src="<?php echo $this->baseurl . '/templates/' . $this->template . '/images/btn-choix-partenaire.png'; ?>" alt="" /></a></div>
                    <div class="or"><span>ou</span></div>
                    <div class="btn"><a href="" id="btn-choix-produit"><img src="<?php echo $this->baseurl . '/templates/' . $this->template . '/images/btn-choix-produit.png'; ?>" alt="" /></a></div>
                </div>
            </div>
        </div>
        
    </body>
</html>
