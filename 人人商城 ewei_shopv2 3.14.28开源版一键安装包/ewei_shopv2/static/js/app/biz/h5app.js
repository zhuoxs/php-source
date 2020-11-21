define(["core", "ydb"], function(core) {
	var modal = {};
	modal.init = function(params) {
		modal.share = params.share ? params.share : null;
		modal.backurl = params.backurl;
		modal.payinfo = params.payinfo;
		modal.statusbar = params.statusbar;
		modal.initYDB();
		modal.initSet();
		modal.initHN();
		modal.initHM();
		modal.initSNS();
		modal.initOther()
	};
	modal.initYDB = function() {
		window.YDB = modal.YDB = new YDBOBJ()
	};
	modal.initSet = function() {
		var isIOS = modal.isIOS();
		if (isIOS) {
			modal.YDB.SetStatusBarStyle(modal.statusbar)
		}
	};
	modal.initHN = function() {
		if ($(".fui-header .fui-header-right").length < 1) {
			return
		}
		var nomenu = $(".fui-header .fui-header-right").data("nomenu");
		if (nomenu) {
			return
		}
		var html = "";
		$('.head-nav').remove();
		if ($('.head-nav').length <= 0) {
			if ($(".fui-header .fui-header-right a").length > 0) {
				html += $(".fui-header .fui-header-right").html()
			}
			html += '<a href="javascript:;" class="head-nav" style="display: inline-block"><i class="icon icon-category"></i></a>';
			$(".fui-header .fui-header-right").empty();
			$(".fui-header .fui-header-right").html(html)
		}
	};
	modal.initHM = function() {
		$(".head-nav, .head-menu-mask").unbind("click").click(function() {
			if ($(".fui-mask").length > 0) {
				return
			}
			$(".head-menu-mask").fadeToggle(100);
			$(".head-menu").fadeToggle(100)
		});
		$(".head-menu").find("nav").unbind("click").click(function() {
			var type = $(this).data("type");
			if (!type) {
				return
			}
			$(".head-menu-mask").fadeOut(100);
			$(".head-menu").fadeOut(100);
			if (type == "share") {
				modal.initShare()
			}
			if (type == "reload") {
				setTimeout(function() {
					location.reload(true)
				}, 200)
			}
			if (type == "exitapp") {
				FoxUI.confirm("确定退出吗？", function() {
					modal.YDB.ExitApp()
				})
			}
			if (type == "browser") {}
			if (type == "eraser") {
				modal.YDB.ClearCache()
			}
		})
	};
	modal.initShare = function() {
		if (!modal.share) {
			FoxUI.alert("分享参数错误");
			return
		}
		modal.YDB.Share(modal.share.title, modal.share.desc, modal.share.imgUrl, modal.share.link)
	};
	modal.initSNS = function() {
		$(document).on('click', ".btn-sns", function() {
			var sns = $(this).data("sns");
			if (sns == "wx") {
				FoxUI.toast.show("正在呼起微信");
				modal.YDB.WXLogin(0, core.getUrl("account/sns", {
					sns: "wx",
					backurl: modal.backurl
				}, true))
			} else {
				if (sns == "qq") {
					FoxUI.toast.show("正在呼起手机QQ");
					modal.YDB.QQLogin(core.getUrl("account/sns", {
						sns: "qq",
						backurl: modal.backurl
					}, true))
				} else {
					return
				}
			}
		})
	};
	modal.initOther = function() {
		$("#btn-share").unbind("click").click(function() {
			modal.initShare()
		})
	};
	window.appPay = modal.appPay = function(app, ordersn, money, status, callback) {
		ordersn = ordersn ? ordersn : modal.payinfo.ordersn;
		money = money ? money : modal.payinfo.money;
		if (!modal.payinfo) {
			FoxUI.toast.show("参数错误(0)");
			return
		}
		if (!ordersn || money <= 0) {
			FoxUI.toast.show("参数错误(1)");
			return
		}
		if (app == 'wechat') {
			if (!modal.payinfo.mcname) {
				FoxUI.toast.show("参数错误(2)");
				return
			}
			FoxUI.toast.show("正在呼起微信");
			modal.YDB.SetWxpayInfo(modal.payinfo.mcname, "订单支付" + ordersn, money, ordersn, modal.payinfo.attach)
		}
		if (app == 'alipay') {
			if (!modal.payinfo.aliname) {
				FoxUI.toast.show("参数错误(2)");
				return
			}
			FoxUI.toast.show("正在呼起支付宝");
			modal.YDB.SetAlipayInfo(modal.payinfo.aliname, modal.payinfo.attach + ":APP", money, ordersn);
			modal.YDB.SetRSA2AlipayInfo(modal.payinfo.aliname, modal.payinfo.attach + ":APP", money, ordersn)
		}
		$('.btn-pay').removeAttr('submit');
		$('.pay-btn').removeAttr('stop');
		FoxUI.loader.hide();
		if (status) {
			modal.getStatus(ordersn)
		}
		if (callback) {
			callback()
		}
	};
	modal.getStatus = function(ordersn) {
		var paytype = modal.payinfo.type;
		if (paytype == 0) {
			var url = core.getUrl('order/pay/orderstatus');
			var data = {
				id: modal.payinfo.orderid
			};
			var url_return = core.getUrl('order/pay/success', {
				id: modal.payinfo.orderid
			})
		} else if (paytype == 1) {
			var url = core.getUrl('member/recharge/getstatus');
			var data = {
				logno: ordersn
			};
			var url_return = core.getUrl('member')
		} else if (paytype == 6) {
			var url = core.getUrl('threen/register/lottery');
			var data = {
				id: ordersn
			};
			var url_return = core.getUrl('threen')
		}
		var settime = setInterval(function() {
			$.getJSON(url, data, function(ret) {
				if (ret.status >= 1) {
					clearInterval(settime);
					location.href = url_return
				} else {}
			})
		}, 1000)
	};
	window.h5app = modal;
	modal.initWX = function() {
		modal.initWXinstall(1);
		var isIOS = modal.isIOS();
		if (isIOS) {
			modal.YDB.isWXAppInstalled("modal.initWXinstall")
		}
	};
	modal.initWXinstall = function(status) {
		if (status) {
			$("#threeWX").show()
		}
	};
	modal.isIOS = function() {
		var ua = navigator.userAgent;
		var ipad = ua.match(/(iPad).*OS\s([\d_]+)/);
		var ipod = ua.match(/(iPod)(.*OS\s([\d_]+))?/);
		var iphone = !ipad && ua.match(/(iPhone\sOS)\s([\d_]+)/);
		if (ipad || iphone || ipod) {
			return true
		}
		return false
	};
	return modal
});