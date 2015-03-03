<?php

/**
 * Template Tpcx 
 *
 * @author Florent Fulmar
 */

// no direct access
defined('_JEXEC') or die;

?>
<div class="push-bottom-left">
	<p>En poursuivant votre navigation sur ce site, vous acceptez que des cookies soient utilisés afin d'améliorer votre expérience d'utilisateur et de vous offrir des contenus plus personnalisés.
	</p>
	<a href="utilisation-cookies">
		en savoir+>>
	</a>
	<button class="closeCnil">
		<a href="javascript:;" id="btn-Cnil">OK</a>
    </button>
</div>
<script>
	$(document).ready(function() {
		function getCookie(name) {
			var dc = document.cookie;
			var prefix = name + "=";
			var begin = dc.indexOf("; " + prefix);
			if (begin == -1) {
				begin = dc.indexOf(prefix);
				if (begin != 0) return null;
			}
			else
			{
				begin += 2;
				var end = document.cookie.indexOf(";", begin);
				if (end == -1) {
				end = dc.length;
				}
			}
			return unescape(dc.substring(begin + prefix.length, end));
		}
		$('.closeCnil, #btn-Cnil').click(function(event) {
			event.preventDefault();
			var date = new Date();
			date.setTime(date.getTime()+(365*24*60*60*1000));
			var expires = "; expires="+date.toGMTString();
			document.cookie = 'popup-cnil=1'+expires;
			$('.push-bottom-left').hide();
		});
		var popupCnil = getCookie("popup-cnil");
		if(popupCnil == null){
			$('.push-bottom-left').show();
		}
		currentWidth = Response.viewportW();
		if(currentWidth < 1020) {
			$('.hp .push-bottom-left').css('bottom','0');
		}
    });
	$(document).ready(function() {
		if($('#hp-header').size()){
			$(window).load(function(){
				currentWidth = Response.viewportW();
				if(currentWidth > 1020) {
					LimiteCnilTop = $("#hp-header .nav-header").offset().top - 250;
					$(window).on("resize scroll",function() {
						var CnilTop = $(window).scrollTop();
						if(CnilTop > LimiteCnilTop) {
							$('.push-bottom-left').css('bottom','0');					
						}
						else
						{
							$('.push-bottom-left').css('bottom','65px');
						}
					});
				};
			});
		};
    });
</script>