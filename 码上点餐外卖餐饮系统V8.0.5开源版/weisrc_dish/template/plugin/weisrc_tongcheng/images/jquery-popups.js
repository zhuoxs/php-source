/**
* jQuery WeUI V1.2.0 
* By ÑÔ´¨
* http://lihongxun945.github.io/jquery-weui/
 */

(function($) {
  "use strict";

  $.fn.transitionEnd = function(callback) {
    var events = ['webkitTransitionEnd', 'transitionend', 'oTransitionEnd', 'MSTransitionEnd', 'msTransitionEnd'],
      i, dom = this;
      
    function fireCallBack(e) {
      /*jshint validthis:true */
      if (e.target !== this) return;
      callback.call(this, e);
      for (i = 0; i < events.length; i++) {
        dom.off(events[i], fireCallBack);
      }
    }
    if (callback) {
      for (i = 0; i < events.length; i++) {
        dom.on(events[i], fireCallBack);
      }
    }
    return this;
  };
})($);

/*======================================================
************   Popup   ************
======================================================*/
+ function($) {
  "use strict";

  $.openPopup = function(popup, className) {

    $.closePopup();

    popup = $(popup);
    popup.show();
    popup.width();
    popup.addClass("pop-ups__container--visible");
    var modal = popup.find(".pop-ups__modal");
    modal.width();
    modal.transitionEnd(function() {
      //modal.trigger("open");
    });
  }

  $.closePopup = function(container, remove) {
    container = $(container || ".pop-ups__container--visible");
    container.find('.pop-ups__modal').transitionEnd(function() {
      var $this = $(this);
      //$this.trigger("close");
      container.hide();
      remove && container.remove();
    })
    container.removeClass("pop-ups__container--visible")
  };

  $(document).on("click", ".close-popups, .pop-ups__overlay", function() {
    $.closePopup();
  })
  
  .on("click", ".open-popups", function() {
    $($(this).data("target")).popup();
  })
  
  .on("click", ".pop-ups__container", function(e) {
    if($(e.target).hasClass("pop-ups__container")) $.closePopup();
  })

  $.fn.popup = function() {
    return this.each(function() {
      $.openPopup(this);
    });
  };

}($);