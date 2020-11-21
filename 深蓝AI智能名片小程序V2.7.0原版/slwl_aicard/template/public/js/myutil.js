! function(window) {
	function getQuery(e) {
		i = "";
		if (-1 != e.indexOf("?")) var i = e.split("?")[1];
		return i
	}
	var myutil = {};
	myutil.myShowLink = function(e) {
		var i = myutil.dialog("选择器", ["./index.php?c=site&a=entry&do=system/dialoglink&m=slwl_aicard"], "");
		i.modal({
			keyboard: !1
		}), i.find(".modal-body").css({
			"height": "600px",
			"overflow-y": "auto",
			"padding": "0 15px",
		}), i.modal("show"), window.myShowLinkComplete = function(t, o, p) {
			$.isFunction(e) && (e(t, o, p), i.modal("hide"))
		}
	}, myutil.myShowUserSelect = function(e) {
		var i = myutil.dialog("用户选择器", ["./index.php?c=site&a=entry&do=system/dialoguser&m=slwl_aicard"], "");
		i.modal({
			keyboard: !1
		}), i.find(".modal-body").css({
			"height": "600px",
			"overflow-y": "auto",
			"padding": "0 15px",
		}), i.modal("show"), window.myShowUserSelectComplete = function(t, o, p) {
			$.isFunction(e) && (e(t, o, p), i.modal("hide"))
		}
	}, myutil.myShowGoodSelect = function(e) {
		var i = myutil.dialog("添加商品", ["./index.php?c=site&a=entry&do=system/dialoggood&m=slwl_aicard"], "");
		i.modal({
			keyboard: !1
		}), i.find(".modal-body").css({
			"height": "600px",
			"overflow-y": "auto",
			"padding": "0 15px",
		}), i.modal("show"), window.myShowGoodComplete = function(t, o, p) {
			$.isFunction(e) && (e(t, o, p), i.modal("hide"))
		}
	}, myutil.myShowCardSelect = function(e) {
		var i = myutil.dialog("名片选择器", ["./index.php?c=site&a=entry&do=system/dialogcard&m=slwl_aicard"], "");
		i.modal({
			keyboard: !1
		}), i.find(".modal-body").css({
			"height": "600px",
			"overflow-y": "auto",
			"padding": "0 15px",
		}), i.modal("show"), window.myShowCardSelectComplete = function(t, o, p) {
			$.isFunction(e) && (e(t, o, p), i.modal("hide"))
		}
	}, myutil.dialog = function(e, i, t, o) {
		o || (o = {}), o.containerName || (o.containerName = "modal-message");
		var n = $("#" + o.containerName);
		if (0 == n.length && ($(document.body).append('<div id="' + o.containerName + '" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true"></div>'), n = $("#" + o.containerName)), html = '<div class="modal-dialog we7-modal-dialog">\t<div class="modal-content">', e && (html += '<div class="modal-header">\t<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>\t<h3>' + e + "</h3></div>"), i && ($.isArray(i) ? html += '<div class="modal-body">正在加载中</div>' : html += '<div class="modal-body">' + i + "</div>"), t && (html += '<div class="modal-footer">' + t + "</div>"), html += "\t</div></div>", n.html(html), i && $.isArray(i)) {
			var a = function(e) {
				n.find(".modal-body").html(e)
			};
			2 == i.length ? $.post(i[0], i[1]).success(a) : $.get(i[0]).success(a)
		}
		return n
	}, "function" == typeof define && define.amd ? define(function() {
		return myutil
	}) : window.myutil = myutil
}(window);
