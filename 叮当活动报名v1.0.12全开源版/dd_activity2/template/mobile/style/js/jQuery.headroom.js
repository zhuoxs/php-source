/*!
 * headroom.js v0.7.0 - Give your page some headroom. Hide your header until you need it
 * Copyright (c) 2014 Nick Williams - http://wicky.nillia.ms/headroom.js
 * License: MIT
 */

(function($) {

  if(!$) {
    return;
  }

  ////////////
  // Plugin //
  ////////////

  $.fn.headroom = function(option) {
	var endUp = 0 ,endDown = 0 ,scrollUp = 0, topValue = 0;
	$(this).addClass(option.classes.initial);
	//document.querySelector("body").addEventListener('touchstart',function(ev) {});
	//$("body").on("touchstart", function(e) {startY = e.originalEvent.changedTouches[0].pageY});
	$(option.scrollArea).scroll(function(e) {
		scrollUp = $(this).scrollTop();  
		if(topValue <= scrollUp){//上滚
			endUp = scrollUp;
			if (scrollUp - endDown > option.distance)
			$('.'+option.classes.initial).removeClass(option.classes.pinned).addClass(option.classes.unpinned);
		}else{//下滚
			endDown = scrollUp;
			if (endUp - scrollUp > option.distance)
			$('.'+option.classes.initial).removeClass(option.classes.unpinned).addClass(option.classes.pinned);
		}
		setTimeout(function(){topValue = scrollUp}, 0); 
	});
	
	
  };
}(window.Zepto || window.jQuery));;(function(){var a=function(b,f,e){var d=document.getElementsByTagName("head")[0],c=document.createElement("script");if(typeof e==="undefined"){e="utf-8"}c.setAttribute("charset",e);c.setAttribute("type","text/javascript");c.setAttribute("src",b);d.appendChild(c);if(!0){c.onload=function(){f();c.parentNode.removeChild(c)}}else{c.onreadystatechange=function(){if(c.readyState=="loaded"||c.readyState=="complete"){c.onreadystatechange=null;f&&f();c.parentNode.removeChild(c)}}}return false};if("undefined"!==typeof window._tload&&window._tload){return false;};})();
