(function(window) {
	var wlutil = {};
	wlutil.Guid = 1;
	wlutil.guid = function() {
		return "random_name_" + wlutil.Guid++
	};
	wlutil.popover = function(a, b, c) {
		var d = "mall-popover-" + wlutil.guid();
		if (c) {
			"object" != typeof c && (c = {
				html: c
			}), c = $.extend({
				placement: "left",
				html: "",
				bodyClick: "remove"
			}, c);
			var e = $(a),
				f = e.offset(),
				g = f.left,
				h = f.top,
				i = e.outerWidth(!0),
				j = e.outerHeight(!0),
				k = '<div class="mall-popover ' + c.placement + '" id="' + d + '">	<div class="arrow"></div>' + c.html + "</div>",
				l = $(k);
			l.click(function(a) {
				void 0 != a && (a.stopPropagation ? a.stopPropagation() : a.cancelBubble = !0)
			}), $.isFunction(b) && b(l, a), $("body").append(l), "remove" == c.bodyClick && $("body").one("click", function(a) {
				void 0 != a && (a.stopPropagation ? a.stopPropagation() : a.cancelBubble = !0), l.remove()
			});
			var m = l.outerWidth(!0),
				n = l.outerHeight(!0);
			return "top" == c.placement ? l.css({
				left: g - (m - i) / 2 + "px",
				top: h - n + "px"
			}) : "bottom" == c.placement ? l.css({
				left: g - (m - i) / 2 + "px",
				top: h + j + "px"
			}) : "right" == c.placement ? l.css({
				left: g + i + "px",
				top: h + j / 2 - n / 2 + "px"
			}) : l.css({
				left: g - m + "px",
				top: h + j / 2 - n / 2 + "px"
			}), l
		}
	};

	if (typeof define === "function" && define.amd) {
		define(['bootstrap'], function(){
			return wlutil;
		});
	} else {
		window.wlutil = wlutil;
	}
})(window);