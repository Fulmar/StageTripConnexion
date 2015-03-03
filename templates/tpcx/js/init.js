$(function() {
    
    // Hover btn header
    if($('#slideshow').length > 0) {
        
        $('#header .btn a, .intro p.text-intro').click(function() {
            
            version = false;
            if (/MSIE\s([\d.]+)/.test(navigator.userAgent)) {
                //Get the IE version.  This will be 6 for IE6, 7 for IE7, etc...
                version = new Number(RegExp.$1);
            }
            
            element = 'body';
            if(version) {
                element = 'html';
            }
            
            $(element).animate({
                scrollTop: $("body").offset().top - 103
            }, {
                duration: 400,
                easing: 'swing',
                complete: function() {
                    
                    // show Toggle
                    $('#slideshow').slideToggle({
                        duration: "slow",
                        complete: function() {
                            if($(this).css('display') == 'block') {
                                $('#header .btn a').addClass('on');
                                $('#middle').addClass('slideshow-show');
                                $('.header-container').addClass('slideshow-show');
                            } else {
                                $('#header .btn a').removeClass('on');
                                $('#middle').removeClass('slideshow-show');
                                $('.header-container').removeClass('slideshow-show');
                            }
                       }
                   });
           
                }
            });
            
        });
    } else {
        $('#header .btn').hide();
    }
    
    // Opacity
    $('img.opacity').each(function(i) {
        $(this).parent().hover(
            function() {
                $(this).stop().animate({ opacity: 0.7 }, 400);
            },
            function() {
                $(this).stop().animate({ opacity: 1.0 }, 400);
            }
        );
    });
    
    // Add top and bottom push green
    $('div.pushvert').each(function(i) {
        $('<div class="toppushvert"></div>').insertBefore($(this).children('div.custompushvert'));
        $('<div class="bottompushvert"></div>').insertAfter($(this).children('div.custompushvert'));
    });
    
    // Add top and bottom push blue
    $('div.pushbleu').each(function(i) {
        $('<div class="toppushbleu"></div>').insertBefore($(this).children('div.custompushbleu'));
        $('<div class="bottompushbleu"></div>').insertAfter($(this).children('div.custompushbleu'));
    });
    
    // Add top and bottom push white
    $('div.pushblanc').each(function(i) {
        $('<div class="toppushblanc"></div>').insertBefore($(this).children('div.custompushblanc'));
        $('<div class="bottompushblanc"></div>').insertAfter($(this).children('div.custompushblanc'));
    });
    
    // Add top and bottom push orange
    $('div.pushorange').each(function(i) {
        $('<div class="toppushorange"></div>').insertBefore($(this).children('div.custompushorange'));
        $('<div class="bottompushorange"></div>').insertAfter($(this).children('div.custompushorange'));
    });
    
    // Add top and bottom push violet
    $('div.pushviolet').each(function(i) {
        $('<div class="toppushviolet"></div>').insertBefore($(this).children('div.custompushviolet'));
        $('<div class="bottompushviolet"></div>').insertAfter($(this).children('div.custompushviolet'));
    });
    
    // Add top and bottom submenu
    $('div.submenu').each(function(i) {
        $('<div class="cornertop"></div>').insertBefore($(this));
        $('<div class="topsubmenu"></div>').insertBefore($(this));
        $('<div class="bottomsubmenu"></div>').insertAfter($(this));
    });
    
    // custom select
    $(document).ready(function() {
        
        // annuaire
        $('.customSelectAnnuaire').each(function(i) {
            $(this).customSelect({
                customClass: 'customSelectAnnuaire'
            });
        });
        
        // travel
        $('.customSelectTravel').each(function(i) {
            $(this).customSelect({
                customClass: 'customSelectTravel'
            });
        });

		//concept
        $('.customSelectConcept').each(function(i) {
            $(this).customSelect({
                customClass: 'customSelectConcept'
            });
			len=$(".concept-home .customSelectInner").text().length;
			if(len>25)
			{
			  $(".concept-home .customSelectInner").text($(".concept-home .customSelectInner").text().substr(0,25)+'...');
			}
        });
        
        // menu
        $('.customSelectMenu').each(function(i) {
            $(this).customSelect({
                customClass: 'customSelectMenu'
            });
        });
        
    });
    
    // fancybox
    $(document).ready(function() {
        $(".fancybox").fancybox({
            openEffect  : 'none',
            closeEffect : 'none',
            helpers : {
                overlay : {
                    locked : false
                }
            }
        });
    });

    // Contact partenaire
    $(document).ready(function() {
        $(".various").fancybox({
            maxWidth    : 800
        });
        
    });

    // Travel
    $(document).ready(function() {
        
        if($('.box-form-pays-2').length > 0)
            $('.box-form-pays-2').hide();
        if($('.box-form-pays-2').length > 0)
            $('.box-form-pays-3').hide();
        
        if($('select[name=choix-pays-1]').length > 0) {
            $('select[name=choix-pays-1]').bind('change', function(){
                $('.box-form-pays-2').show();
            });
        }
        
        if($('select[name=choix-pays-2]').length > 0) {
            $('select[name=choix-pays-2]').bind('change', function(){
                $('.box-form-pays-3').show();
            });
        }
        
        // date picker
        var today = new Date();
        var tomorrow = new Date(new Date().getTime() + 24 * 60 * 60 * 1000);
        $("#date-depart").datepicker({
            showOn: "both",
            buttonImage: templateUrl + "/images/datepicker.png",
            buttonImageOnly: true,
            dateFormat: "dd/mm/yy",
            minDate: tomorrow
        }); 
        
        $( ".radio-box" ).buttonset();
        
        // validate
        $('#travelForm').validate({
            invalidHandler: function(event, validator) {
                // 'this' refers to the form
                var errors = validator.numberOfInvalids();
                //console.log(validator.element($('select[name=choix-pays-1]')));
                //console.log(event);
            },
            success: function(label) {
                label.parent().children("span.customSelect").removeClass('error');
            },
            errorPlacement: function(error, element) {
                if(element.hasClass('hasCustomSelect')) {
                    element.parent().children("span.customSelect").addClass('error');
                }
                error.appendTo( element.parent() );
            },
            submitHandler: function(form) {
                
                if($('.container-subform-1').is(":visible") && $('.container-subform-2').is(":visible")) {
                    // container-form-1 and container-form-2 is visible : form submit
                    form.submit();
                    
                } else {
                    
                    if(!$('.container-subform-1').is(":visible")) {
                        element = '.container-subform-1';
                        button = '.travel-next-step';
                        delta = 100;
                    } else {
                        element = '.container-subform-2';
                        button = '.travel-next-step2';
                        delta = -1100;
                    }
                    
                    // container-form-1 is not visible : first step
                    $(element).slideDown(400, function() {
                        
                        $(button).hide();
                        
                        element = 'body';
                        if(isIe()) {
                            element = 'html';
                        }

                        $(element).animate({
                            scrollTop: $('.container-subform').offset().top - delta
                        }, {
                            duration: 400,
                            complete: function() {
                                
                            }
                        });
                        
                    });
                }
                
            },
            rules: {
                email: {
                    required: true,
                    email: true
                },
                email_confirmation: {
                    required: true,
                    email: true,
                    equalTo: "#email_travel_project"
                },
                budget: {
                    required: true
                }
            },
            messages: {
                email: 'Veuillez saisir une adresse mail valide.',
                email_confirmation: 'Veuillez saisir une adresse mail valide et identique au champ email.'
            }
        });
        
        // box hebergement
        $(".box-hebergement").each(function(i){

            $(this).children("label").children("img").bind('click', function(){
                checked = $(this).parent().parent().children("input").is(':checked');
                if(checked) {
                    $(this).parent().parent().children("input").prop('checked', false);
                }
                else {
                    $(this).parent().parent().children("input").prop('checked', true);
                }
            });
        });
        
    });
    
    // scroll to travel project
    if($('a.scrollprojetvoyage').length > 0) {
        
        $('a.scrollprojetvoyage').bind('click', function() {
            element = 'body';
            if(isIe()) {
                element = 'html';
            }
        
            $(element).animate({
                scrollTop: $("#travel-project-container").offset().top - 101
            }, {
                duration: 800,
                complete: function() {
                    
                }
            });
        });
        
    }
    
    // select pays slideshow
    $(document).ready(function(){
        /*$('select[name=pays-slideshow]').change(function(){
            
            value = this.value;
            text = this.options[this.selectedIndex].text;
            
            $('select[name=choix-pays-1]').val(value);
            $('select[name=choix-pays-1]').next().children(".customSelectInner").html(text);
            $('.box-form-pays-2').show();
            
            element = 'body';
            if(isIe()) {
                element = 'html';
            }
    
            /*$("html, body").animate({
                scrollTop: $("#travel-project-container").offset().top - 101
            }, {
                duration: 400,
                complete: function() {
                    
                }
            });*/
           
           /*$("a#inlinedataproject").fancybox({
                openEffect  : 'none',
                closeEffect : 'none',
                hideOnContentClick: true,
                helpers : {
                    overlay : {
                        locked : false
                    }
                }
            });
            
            $('.selection-recherche #term-project').empty();
            $('.selection-recherche #term-project').append($("#slideshow select[name=pays-slideshow] option:selected").text());
            
            $("a#inlinedataproject").trigger('click');
            
            $("a#btn-soumettre-projet").bind('click', function(e){
                e.preventDefault();
                $.fancybox.close();
                $("html, body").animate({
                    scrollTop: $("#travel-project-container").offset().top - 101
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
            
        });*/
        
        $("a#inlinedataproject").fancybox({
            openEffect  : 'none',
            closeEffect : 'none',
            hideOnContentClick: true,
            helpers : {
                overlay : {
                    locked : false
                }
            }
        });            
        
        $('#hp-header input.input-destination-home ,.buttonHeader input.input-destination-home ').bind('focus', function() {
            if($(this).val() == '') {
                $('#hp-header .list-destination,.buttonHeader .list-destination').show();
                $('#hp-header .list-destination li a, .buttonHeader .list-destination li a').each(function() {
                   
                   $(this).bind('mousedown', function() {
						
						value = $(this).attr('data-value');
						text = $(this).text();
						
						$('input.input-destination-home').val(text);
						
                        $.ajax({
                            dataType: "json",
                            url: baseUrl + 'index.php?option=com_tpcxtags&task=checkproduct&continent_id=&pays_id='
                                          + value + '&thematique_id=',
                            success: function(data) {
                                
                                // products empty
                                if(data  == 0) {
                                    $('#btn-voir-voyages').parent().hide();
                                } else {
                                    $('#btn-voir-voyages').parent().show();
                                }
                                
                                $('select[name=choix-pays-1]').val(value);
                                $('select[name=choix-pays-1]').next().children(".customSelectInner").html(text);
                                $('.box-form-pays-2').show();
                                
                                $('.selection-recherche #term-project').empty();
                                $('.selection-recherche #term-project').append(text);
                                
                                $("a#inlinedataproject").trigger('click');
                                $('#hp-header .list-destination, .buttonHeader .list-destination').hide();
                                
                                $("a#btn-soumettre-projet").bind('click', function(e){
                                    e.preventDefault();
                                    $.fancybox.close();
                                    $("html, body").animate({
                                        scrollTop: $("#travel-project-container").offset().top - 101
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
                       
                        
                   }); 
                });
            }
        });
        
        $('#hp-header input.input-destination-home ,.buttonHeader input.input-destination-home ').bind('keyup', function() {
            if($(this).val().length > 0) {
                $('#hp-header .list-destination, ,.buttonHeader .list-destination').hide();
            } 
        });
        $(document).bind('click', function(e) {
            var container = $('input.input-destination-home').parent().find('.list-destination');
            var container2 = $('input.input-destination-home');

            if (!container.is(e.target) // if the target of the click isn't the container...
                && container.has(e.target).length === 0) { // ... nor a descendant of the container
                    
                    if (!container2.is(e.target) // if the target of the click isn't the container...
                        && container2.has(e.target).length === 0) { // ... nor a descendant of the container
                            container.hide();
                        }
            } 
        });
        
        $('input.input-destination-header').bind('focus', function() {
            if($(this).val() == '') {
                $(this).parent().find('.list-destination').show();
                $(this).parent().find('.list-destination li a').each(function() {
                   $(this).bind('mousedown', function() {
                       
                        value = $(this).attr('data-value');
						if(data  == 0) {
							$('#btn-voir-voyages').parent().hide();
						} else {
							$('#btn-voir-voyages').parent().show();
						}
                        $('select[name=choix-pays-1]').val(value);
                        $('select[name=choix-pays-1]').next().children(".customSelectInner").html($(this).text());
                        $('.box-form-pays-2').show();
                        
                        $('.selection-recherche #term-project').empty();
                        $('.selection-recherche #term-project').append($(this).text());
						$("a#inlinedataproject").trigger('click');
						$('.list-destination').hide();

                        $("a#btn-soumettre-projet").bind('click', function(e){
                            e.preventDefault();
                            $.fancybox.close();
                            $("html, body").animate({
                                scrollTop: $("#travel-project-container").offset().top - 101
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
                   }); 
                });
            }
        });
        
        $('input.input-destination-header').bind('blur', function() {
            $(this).parent().find('.list-destination').hide();
        });
        
        $('input.input-destination-header').bind('keyup', function() {
           if($(this).val().length > 0) {
               $('.list-destination').hide();
           } 
        });
        
        $('.list-destination').click(function(event) {
            $('html').one('click',function() {
                // Hide the menus
                $('.list-destination').hide();
            });
        
            event.stopPropagation();
        });
    });
    
    // breakpoint
    $(document).ready(function(){  
        function processModal(width) {
            if(currentWidth < 740) {
                $("a.modal").each(function(i){
                    this.removeClass('modal');
                    this.href = this.href + '&responsive740=1';
                });
            }
        }
        
        currentWidth = Response.viewportW();
        processModal(currentWidth);
        
        if(currentWidth < 1020) {
            $('.item-page .article-content p img').each(function() {
                if(!$(this).hasClass('original-size')) {
                    //if($(this).width() > 50) {
                       $(this).css('width', '100%');
                    //}
                }
            });
        }

    });
	

	
	///////////ANNUAIRE///////////
    $(document).ready(function(){
        $('input.input-destination-annuaire-home').bind('focus', function() {
            if($(this).val() == '') {
                $(this).parent().find('.list-destination').show();
                $(this).parent().find('.list-destination li a').each(function() {
                   
                   $(this).bind('mousedown', function() {
                        value = $(this).attr('data-value');
                        $(this).parent().parent().parent().find('.list-destination').hide();
                        $(this).parent().parent().parent().find('.input-destination-annuaire-home').val($(this).text());
                        $(this).parent().parent().parent().find('input[name=p]').val(value);
                   }); 
                });
            }
        });
        
        $('input.input-destination-annuaire-home').bind('keyup', function() {
           if($(this).val().length > 0) {
               $(this).parent().find('.list-destination').hide();
           } 
        });
		$('input.input-destination-annuaire-home').bind('blur', function() {
            $(this).parent().find('.list-destination').hide();
        });
        $('input.input-destination-annuaire-push').bind('focus', function() {
            if($(this).val() == '') {
                $(this).parent().find('.list-destination').show();
                $(this).parent().find('.list-destination li a').each(function() {
                   
                   $(this).bind('mousedown', function() {
                        value = $(this).attr('data-value');
                        $(this).parent().parent().parent().find('.list-destination').hide();
                        $(this).parent().parent().parent().find('.input-destination-annuaire-push').val($(this).text());
                        $(this).parent().parent().parent().find('input[name=p]').val(value);
                   }); 
                });
            }
        });
        
        $('input.input-destination-annuaire-push').bind('keyup', function() {
           if($(this).val().length > 0) {
               $(this).parent().find('.list-destination').hide();
           } 
        });
        
        $('input.input-destination-annuaire-push').bind('blur', function() {
            $(this).parent().find('.list-destination').hide();
        });
        
        $('input.input-destination-annuaire-recherche').bind('focus', function() {
            if($(this).val() == '') {
                $(this).parent().find('.list-destination').show();
                $(this).parent().find('.list-destination li a').each(function() {
                   
                   $(this).bind('mousedown', function() {
                        value = $(this).attr('data-value');
                        $(this).parent().parent().parent().find('.list-destination').hide();
                        $(this).parent().parent().parent().find('.input-destination-annuaire-recherche').val($(this).text());
                        $(this).parent().parent().parent().find('input[name=p]').val(value);
                   }); 
                });
            }
        });
        
        $('input.input-destination-annuaire-recherche').bind('keyup', function() {
           if($(this).val().length > 0) {
               $(this).parent().find('.list-destination').hide();
           } 
        });
        
        $('input.input-destination-annuaire-recherche').bind('blur', function() {
            $(this).parent().find('.list-destination').hide();
        });
    });
		///////////CONCEPT//////////
	$(document).ready(function(){
		$('.concept-home input.input-destination-concept-recherche').bind('focus', function() {
            if($(this).val() == '') {
                $(this).parent().find('.list-destination').show();
                $(this).parent().find('.list-destination li a').each(function() {
                   $(this).bind('click', function() {
						value = $(this).attr('data-value');
						text = $(this).text();
						$('input.input-destination-concept-recherche').val(text);
                        $.ajax({
                            dataType: "json",
                            url: baseUrl + 'index.php?option=com_tpcxtags&task=checkproduct&continent_id=&pays_id='
                                          + value + '&thematique_id=',
                            success: function(data) {							
                                // products empty
								if(data == 0) {
									$('.btn-voir-voyages').hide();
								} else {
									$('.btn-voir-voyages').show();
								}
								
                                $('select[name=choix-pays-1]').val(value);
                                $('select[name=choix-pays-1]').next().children(".customSelectInner").html(text);
                                $('.box-form-pays-2').show();
                                
                                $('.selection-recherche #term-project').empty();
                                $('.selection-recherche #term-project').append(text);
                                
                                
                                $('.list-destination').hide();
								$(".btn-destination-search-hp-header").click( function(e){
									if(document.getElementById("customSelectConcept").value == 1){
										e.preventDefault();
										$.fancybox.close();
										$("html, body").animate({
											scrollTop: $("#travel-project-container").offset().top - 0
										}, {
											duration: 400,
											complete: function() {
												
											}
										});
									}


									if(document.getElementById("customSelectConcept").value == 2){
										e.preventDefault();
										$.fancybox.close();
										$(location).attr('href', baseUrl + 'annuaire?c=&p=' + value + '&t=');
									}
												
									if(document.getElementById("customSelectConcept").value == 3){
										e.preventDefault();
										$.fancybox.close();
										$(location).attr('href', baseUrl + 'voyages?c=&p=' + value + '&t=');
									}
						
								});
							}
						});
					});	
                });
            }
        });
       
        
        $('.concept-home input.input-destination-concept-recherche').bind('focus', function() {
            if($(this).val() == '') {
                $(this).parent().find('.list-destination').show();	
                $(this).parent().find('.list-destination li a').each(function() {
                  $(this).bind('mousedown', function() {
						value = $(this).attr('data-value');
						text = $(this).text();
						$('input.input-destination-concept-recherche').val(text);
						
                        $.ajax({
                            dataType: "json",
                            url: baseUrl + 'index.php?option=com_tpcxtags&task=checkproduct&continent_id=&pays_id='
                                          + value + '&thematique_id=',
                            success: function(data) {

								if(data == 0) {
									$('.btn-voir-voyages').hide();
								} else {
									$('.btn-voir-voyages').show();
								}
                                
                                $('select[name=choix-pays-1]').val(value);
                                $('select[name=choix-pays-1]').next().children(".customSelectInner").html(text);
                                $('.box-form-pays-2').show();
                                
                                $('.selection-recherche #term-project').empty();
                                $('.selection-recherche #term-project').append(text);
                                
                                
                                $('.list-destination').hide();
								$(".btn-destination-search-hp-header").click( function(e){
									if(document.getElementById("customSelectConcept").value == 1){
										e.preventDefault();
										$.fancybox.close();
										$("html, body").animate({
											scrollTop: $("#travel-project-container").offset().top - 0
										}, {
											duration: 400,
											complete: function() {
												
											}
										});
									}


									if(document.getElementById("customSelectConcept").value == 2){
										e.preventDefault();
										$.fancybox.close();
										$(location).attr('href', baseUrl + 'annuaire?c=&p=' + value + '&t=');
									}
												
									if(document.getElementById("customSelectConcept").value == 3){
										e.preventDefault();
										$.fancybox.close();
										$(location).attr('href', baseUrl + 'voyages?c=&p=' + value + '&t=');
									}
									
								});
							}
						});
                   }); 
                });
            }
        });
		$('.concept-home input.input-destination-concept-recherche').bind('blur', function() {
            $(this).parent().find('.list-destination').hide();
        });
        $('.concept-home input.input-destination-concept-recherche').bind('keyup', function() {
           if($(this).val().length > 0) {
               $(this).parent().find('.list-destination').hide();  
           } 
        });
	});
	//////ANNUAIRE HPHEADER////////
	$(document).ready(function(){
		$('input.input-destination-annuaire-hpheader').bind('focus', function() {
            if($(this).val() == '') {
                $(this).parent().find('.list-destination').show();
                $(this).parent().find('.list-destination li a').each(function() {
                   $(this).bind('click', function() {
						value = $(this).attr('data-value');
						text = $(this).text();
						$('input.input-destination-annuaire-hpheader').val(text);
                       $.ajax({
                            dataType: "json",
                            url: baseUrl + 'index.php?option=com_tpcxtags&task=checkproduct&continent_id=&pays_id='
                                          + value + '&thematique_id=',
                            success: function(data) {
                                
                                // products empty
                                if(data  == 0) {
                                    $('#btn-voir-voyages').parent().hide();
                                } else {
                                    $('#btn-voir-voyages').parent().show();
                                }
                                
                                $('select[name=choix-pays-1]').val(value);
                                $('select[name=choix-pays-1]').next().children(".customSelectInner").html(text);
                                $('.box-form-pays-2').show();
                                
                                $('.selection-recherche #term-project').empty();
                                $('.selection-recherche #term-project').append(text);
                                
                                $("a#inlinedataproject").trigger('click');
                                $('.list-destination').hide();
                                
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
					});	
                });
            }
        });
       
        
        $('input.input-destination-annuaire-hpheader').bind('focus', function() {
            if($(this).val() == '') {
                $(this).parent().find('.list-destination').show();	
                $(this).parent().find('.list-destination li a').each(function() {
                  $(this).bind('mousedown', function() {
						value = $(this).attr('data-value');
						text = $(this).text();
						$('input.input-destination-annuaire-hpheader').val(text);
						
                        $.ajax({
                            dataType: "json",
                            url: baseUrl + 'index.php?option=com_tpcxtags&task=checkproduct&continent_id=&pays_id='
                                          + value + '&thematique_id=',
                            success: function(data) {
                                
                                // products empty
                                if(data  == 0) {
                                    $('#btn-voir-voyages').parent().hide();
                                } else {
                                    $('#btn-voir-voyages').parent().show();
                                }
                                
                                $('select[name=choix-pays-1]').val(value);
                                $('select[name=choix-pays-1]').next().children(".customSelectInner").html(text);
                                $('.box-form-pays-2').show();
                                
                                $('.selection-recherche #term-project').empty();
                                $('.selection-recherche #term-project').append(text);
                                
                                $("a#inlinedataproject").trigger('click');
                                $('.list-destination').hide();
                                
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
                   }); 
                });
            }
        });
		$('input.input-destination-annuaire-hpheader').bind('blur', function() {
            $(this).parent().find('.list-destination').hide();
        });
        $('input.input-destination-annuaire-hpheader').bind('keyup', function() {
           if($(this).val().length > 0) {
               $(this).parent().find('.list-destination').hide();  
           } 
        });
	});	

        
    
    // Right Push scroll/follow
    $(window).load(function(){
    	if($('aside#right .module:last-child()').length > 0) {
    	    var top = $('aside#right .module:last-child()').offset().top - parseFloat($('aside#right .module:last-child()').css('marginTop').replace(/auto/, 0));

            if($('#products-after-content').length > 0) {
                limitTop = Number($('#products-after-content').offset().top) - Number($('aside#right .module:last-child()').height()) - 160;
            } else {
				if($('#products-enlarge-bottom-content').length > 0){
					limitTop = Number($('#products-enlarge-bottom-content').offset().top) - Number($('aside#right .module:last-child()').height()) - 160;
				} else {
					limitTop = Number($('#bottom').offset().top) - Number($('aside#right .module:last-child()').height()) - 160;
				}
			}
            $(window).on("resize scroll", function() {
                var left = $('aside#right').offset().left;
                currentWidth = Response.viewportW();
                var widthModule = $('aside#right .module:last-child()').width();
            	// what the y position of the scroll is
				var y = $(window).scrollTop();
				// whether that's below the form
				//if (y >= top && y <= limitTop) {
			    if (y >= top && currentWidth > 1020) {
					if(y <= limitTop) {
						// if so, ad the fixed class
						$('aside#right .module:last-child()').css('position', 'fixed');
			           	$('aside#right .module:last-child()').css('top', '140px');
			           	$('aside#right .module:last-child()').css('left', left + 'px');
                        $('aside#right .module:last-child()').css('width', widthModule + 'px');
					} else {
						// otherwise negative top
						newTop = (limitTop - y + 50);
						$('aside#right .module:last-child()').css('position', 'fixed');
			          	$('aside#right .module:last-child()').css('top', newTop);
                        $('aside#right .module:last-child()').css('left', left + 'px');
                        $('aside#right .module:last-child()').css('width', widthModule + 'px');
					}
				} else {
					// otherwise remove it
					$('aside#right .module:last-child()').css('position', 'relative');
		           	$('aside#right .module:last-child()').css('top', '0');
                    $('aside#right .module:last-child()').css('left', '0');
				}
            });   
		}
    });
    
    /*
    $(document).ready(function() {
       $(window).scroll(function(event) {
           var y = $(window).scrollTop();
           
           if(y > 50) {
               // height header
               $('.header-container').css('height', '50px');
               $('.header-container').css('backgroundPosition', '0% 85%');
               $('.header-container .logo').css('marginTop', '0');
               $('.header-container .logo img').css('height', '30px');
               $('#middle').css('paddingTop', '140px');
               $('.stamp').hide();
               $('.header-container .btn').hide();
               $('.header-container .intro').hide();
               $('.header-container .call-to-action').show();
           } else {
               // default value
               $('.header-container').css('height', '108px');
               $('.header-container.slideshow-show').css('height', '95px');
               $('.header-container').css('backgroundPosition', 'top left');
               $('.header-container .logo').css('marginTop', '10px');
               $('.header-container .logo img').css('height', '72px');
               $('#middle').css('paddingTop', '108px');
               $('#middle.slideshow-show').css('paddingTop', '96px');
               $('.stamp').show();
               $('.header-container .btn').show();
               $('.header-container .intro').show();
               $('.header-container .call-to-action').hide();
           }
       });
    });
    */
    
    // popup product / partenaires
    $('form[name=annuaireDestination]').submit(function(e){
        //if($("#current_page").val() != 'recherche') {

            e.preventDefault();
            
            form = this;
            
            // check if product exist
            $.ajax({
                dataType: "json",
                url: baseUrl + 'index.php?option=com_tpcxtags&task=checkproduct&continent_id='
                              + $(form).find("select[name=c] option:selected").val() + '&pays_id='
                              + $(form).find("input[name=p]").val() + '&thematique_id='
                              + $(form).find("select[name=t] option:selected").val(),
                success: function(data) {
                    
                    // products empty
                    if(data == 0) {
                        form.submit();
                        return;
                    }
                    
                    termContinent = $(form).find("select[name=c] option:selected").text();
                    termPays = $(form).find("input[name=p-text]").val();
                    termThematique = $(form).find("select[name=t] option:selected").text();
                    
                    textTerm = '';
                    if($(form).find("select[name=c] option:selected").val() != '')
                        textTerm = '"' + $.trim(termContinent) + '"';
                    if($(form).find("input[name=p-text]").val() != '') {
                        if($(form).find("select[name=c] option:selected").val() != '')
                            textTerm += ' & ';
                        textTerm += '"' + $.trim(termPays) + '"';
                    }   
                    if($(form).find("select[name=t] option:selected").val() != '')
                        textTerm = '"' + $.trim(termThematique) + '"';
                    
                    $('.selection-recherche #term').empty();
                    $('.selection-recherche #term').append(textTerm);
                    
                    if(textTerm == '') {
                        form.submit();
                        return;
                    }
                    
                    if(textTerm == '')
                        $('.selection-recherche').hide();
                    else
                        $('.selection-recherche').show();
                    
                    $("a#inlinedata").trigger('click');
                    
                    $("a#btn-choix-partenaire").bind('click', function(e){
                        e.preventDefault();
                        $('form[name=annuaireDestination]').attr('action', baseUrl + 'annuaire');
                        form.submit();
                    });
                    
                    // if products -> change URL
                    $("a#btn-choix-produit").bind('click', function(e){
                        e.preventDefault();
                        $('form[name=annuaireDestination]').attr('action', baseUrl + 'voyages');
                        form.submit();
                    });

                }
            });
                
                
            
        //}
    });
    
    $("a#inlinedata").fancybox({
        openEffect  : 'none',
        closeEffect : 'none',
        hideOnContentClick: true,
        helpers : {
            overlay : {
                locked : false
            }
        }
    });
    
    // center pagination in product page
    if($('div.items-produit .pagination').length > 0) {
        
        paginationWidth = $('div.items-produit .pagination ul').width();
        
        $('div.items-produit .pagination ul').css('position', 'relative');
        $('div.items-produit .pagination ul').css('left', '50%');
        $('div.items-produit .pagination ul').css('margin-left', '-' + (paginationWidth / 2) + 'px' );
        
    }
    
    // title H2 HOME PAGE
    $(window).load(function() {
        
        function resizeTitle() {
            $('.module h2.home-page').each(function(e, i) {
                
                $(this).children('.bgLeft').remove();
                $(this).children('.bgRight').remove();
                
                widthLeft = $(this).offset().left;
                widthRight = $("body").width() - widthLeft - $(this).width();
                
                var bgLeft = $('<div class="bgLeft" />').css('position', 'absolute')
                            .css('width', widthLeft).css('height', $(this).innerHeight())
                            .css('background', $(this).css('background-color'))
                            .css('top', '0').css('left', -widthLeft);
                $(this).append( bgLeft );
                
                var bgRight = $('<div class="bgRight" />').css('position', 'absolute')
                            .css('width', widthRight).css('height', $(this).innerHeight())
                            .css('background', $(this).css('background-color'))
                            .css('top', '0').css('left', $(this).width());
                $(this).append( bgRight );
            }); 
        }
        
        resizeTitle();
        
        $(window).on("resize", function() {
            resizeTitle();
        });
    });
   
});