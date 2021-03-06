/*
 * 	Easy Slider 1.7 - jQuery plugin
 *	written by Alen Grakalic	
 *	http://cssglobe.com/post/4004/easy-slider-15-the-easiest-jquery-plugin-for-sliding
 *
 *	Copyright (c) 2009 Alen Grakalic (http://cssglobe.com)
 *	Dual licensed under the MIT (MIT-LICENSE.txt)
 *	and GPL (GPL-LICENSE.txt) licenses.
 *
 *	Built for jQuery library
 *	http://jquery.com
 *
 */
 
/*
 *	markup example for $("#slider").easySlider();
 *	
 * 	<div id="slider">
 *		<ul>
 *			<li><img src="images/01.jpg" alt="" /></li>
 *			<li><img src="images/02.jpg" alt="" /></li>
 *			<li><img src="images/03.jpg" alt="" /></li>
 *			<li><img src="images/04.jpg" alt="" /></li>
 *			<li><img src="images/05.jpg" alt="" /></li>
 *		</ul>
 *	</div>
 *
 */

(function(b){b.fn.easySlider=function(a){a=b.extend({prevId:"prevBtn",prevText:"Previous",nextId:"nextBtn",nextText:"Next",controlsShow:!0,controlsBefore:"",controlsAfter:"",controlsFade:!0,firstId:"firstBtn",firstText:"First",firstShow:!1,lastId:"lastBtn",lastText:"Last",lastShow:!1,vertical:!1,speed:800,auto:!1,pause:2E3,continuous:!1,numeric:!1,numericId:"controls"},a);this.each(function(){function l(c){c=parseInt(c)+1;b("li","#"+a.numericId).removeClass("current");b("li#"+a.numericId+c).addClass("current")} function t(){c>h&&(c=0);0>c&&(c=h);a.vertical?b("ul",e).css("margin-left",c*n*-1):b("ul",e).css("margin-left",c*k*-1);q=!0;a.numeric&&l(c)}function f(d,g){if(q){q=!1;var m=c;switch(d){case "next":c=m>=h?a.continuous?c+1:h:c+1;break;case "prev":c=0>=c?a.continuous?c-1:0:c-1;break;case "first":c=0;break;case "last":c=h;break;default:c=d}var m=Math.abs(m-c),l=m*a.speed;a.vertical?(p=c*n*-1,b("ul",e).animate({marginTop:p},{queue:!1,duration:l,complete:t})):(p=c*k*-1,b("ul",e).animate({marginLeft:p},{queue:!1, duration:l,complete:t}));!a.continuous&&a.controlsFade&&(c==h?(b("a","#"+a.nextId).hide(),b("a","#"+a.lastId).hide()):(b("a","#"+a.nextId).show(),b("a","#"+a.lastId).show()),0==c?(b("a","#"+a.prevId).hide(),b("a","#"+a.firstId).hide()):(b("a","#"+a.prevId).show(),b("a","#"+a.firstId).show()));g&&clearTimeout(r);a.auto&&"next"==d&&!g&&(r=setTimeout(function(){f("next",!1)},m*a.speed+a.pause))}}var e=b(this),g=b("li",e).length,k=b("li",e).width(),n=b("li",e).height(),q=!0;e.width(k);e.height(n);e.css("overflow", "hidden");var h=g-1,c=0;b("ul",e).css("width",g*k);a.continuous&&(b("ul",e).prepend(b("ul li:last-child",e).clone().css("margin-left","-"+k+"px")),b("ul",e).append(b("ul li:nth-child(2)",e).clone()),b("ul",e).css("width",(g+1)*k));a.vertical||b("li",e).css("float","left");if(a.controlsShow){var d=a.controlsBefore;a.numeric?d+='<ol id="'+a.numericId+'"></ol>':(a.firstShow&&(d+='<span id="'+a.firstId+'"><a href="javascript:void(0);">'+a.firstText+"</a></span>"),d+=' <span id="'+a.prevId+'"><a href="javascript:void(0);">'+ a.prevText+"</a></span>",d+=' <span id="'+a.nextId+'"><a href="javascript:void(0);">'+a.nextText+"</a></span>",a.lastShow&&(d+=' <span id="'+a.lastId+'"><a href="javascript:void(0);">'+a.lastText+"</a></span>"));d+=a.controlsAfter;b(e).after(d)}if(a.numeric)for(d=0;d<g;d++)b(document.createElement("li")).attr("id",a.numericId+(d+1)).html("<a rel="+d+' href="javascript:void(0);">'+(d+1)+"</a>").appendTo(b("#"+a.numericId)).click(function(){f(b("a",b(this)).attr("rel"),!0)});else b("a","#"+a.nextId).click(function(){f("next", !0)}),b("a","#"+a.prevId).click(function(){f("prev",!0)}),b("a","#"+a.firstId).click(function(){f("first",!0)}),b("a","#"+a.lastId).click(function(){f("last",!0)});var r;a.auto&&(r=setTimeout(function(){f("next",!1)},a.pause));a.numeric&&l(0);!a.continuous&&a.controlsFade&&(b("a","#"+a.prevId).hide(),b("a","#"+a.firstId).hide())})}})(jQuery);



