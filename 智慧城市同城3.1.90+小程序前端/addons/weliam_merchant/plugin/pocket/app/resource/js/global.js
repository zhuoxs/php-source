


var maskIsHide = true;
var pushState = null;

 // 获取手机型号
var ignorePhoneModel = ['sm-g9200', 'sm-g9208'];
function getPhoneModel() {
	var UA = navigator.userAgent;
	var model = '';
	try {
		var _model = UA.match(/;\s?([^;]+)\s?Build/i);
		if(_model) {
			_model = _model[1];
			model = _model.trim();
		}
	} catch (e) {
	}
	return model.toLowerCase();
}
function pushStateEvent(e) {
	if ( ignorePhoneModel.indexOf(getPhoneModel()) == -1) {
		pushState = {backevent: e};
		history.pushState(pushState, document.title, "?backevent=" + pushState.backevent.replace(/#/g, ""));
	}
}
//confirm
function wptConfirm(msg, sureObj) {
	maskIsHide = false;
	$('.wptConfirm .tip .msg').html(msg);

	if(typeof sureObj != "undefined") {
		//确定按钮上的文字
		sureObj.text && $('.wptConfirm .btns .sure').text(sureObj.text);
		//确定按钮的class
		sureObj.class && $('.wptConfirm .btns .sure').addClass(sureObj.class);
		//描述文本class
		sureObj.msgClass && $('.wptConfirm .tip .msg').addClass(sureObj.msgClass);
	}

	$(".wptConfirm").show();
	$(".wptConfirm .wptMask").animate({opacity: "0.4"}, 100);
	$(".wptConfirm .dialog").animate({bottom: "0px"}, 100);

	$(document).off("wptConfirm_view:hide").one("wptConfirm_view:hide", function (e) {
		maskIsHide = true;
		$(".wptConfirm .wptMask").animate({opacity: "0"}, 100);
		var height = '-' + $(".wptConfirm .dialog").height() + 'px';
		$(".wptConfirm .dialog").animate({bottom: height}, 100, function () {
			$(".wptConfirm").hide();
		});
	});

	$('.wptConfirm .wptMask, .wptConfirm .btn-cancel, .wptConfirm .btn-confirm').off('touchend').one('touchend', function (e) {
 		e.preventDefault();
		if ($(e.target).hasClass('sure')) {
			$(document.body).trigger('wptConfirm_view:sure');
		}
		$(document.body).trigger("wptConfirm_view:hide");
	});
}


//multiConfirm
function wptMultiConfirm(msg, sureObj, cancelObj) {
	maskIsHide = false;
	$('.wptMultiConfirm .tip .msg').html(msg);

	if(typeof cancelObj != "undefined" && typeof cancelObj.text != "undefined") {
		$(".wptMultiConfirm .btns .btn-cancel").html(cancelObj.text);
	}

	if(typeof sureObj != "undefined") {
		$(".wptMultiConfirm .btns .btn-cancel").before(sureObj);
	}

	$(".wptMultiConfirm").show();
	$(".wptMultiConfirm .wptMask").animate({opacity: "0.4"}, 100);
	$(".wptMultiConfirm .dialog").animate({bottom: "0px"}, 100);

	$(document).off("wptMultiConfirm_view:hide").one("wptMultiConfirm_view:hide", function (e) {
		maskIsHide = true;
		$(".wptMultiConfirm .wptMask").animate({opacity: "0"}, 100);
		var height = '-' + $(".wptMultiConfirm .dialog").height() + 'px';
		$(".wptMultiConfirm .dialog").animate({bottom: height}, 100, function () {
			$(".wptMultiConfirm").hide();
			$(".wptMultiConfirm").find(sureObj).remove();
		});
	});

	$('.wptMultiConfirm').off('touchend').one('touchend', '.wptMask, .btn-cancel, .btn-confirm', function (e) {
		e.preventDefault();
		if($(e.target).hasClass('btn-cancel')) {
			if (typeof cancelObj != "undefined" && typeof cancelObj.cb == "function") {
				cancelObj.cb();
			}
		}
		$(document.body).trigger("wptMultiConfirm_view:hide");
	});
}
//loading
function wptLoading(msg, callback, time) {
	time = typeof time == "undefined" ? 1000 : time;
	maskIsHide = false;
	if(msg!="")
		$(".wptLoading .weui_toast_content").html(msg);

	$(".wptLoading .wptMask").animate({opacity: "0.4"}, 100);
	$(".wptLoading").show();
	$(".wptLoading .loading").animate({opacity: 1}, time, function(){
		if (typeof(callback) == 'function') callback();
	});

	$(document).off("wptLoading_view:hide").one("wptLoading_view:hide", function (e) {
		maskIsHide = true;
		$(".wptLoading .loading").css({opacity: 0});
		$(".wptLoading").hide();
	});

	$(document).off("wptLoading_view:msg").on("wptLoading_view:msg", function (e, msg) {
		$(".wptLoading .loading").html(msg);
	});
}
function wpthideLoading() {
	$(".wptLoading").hide();
}


//跳转
function wptRedirect(url, time){
	time = typeof time == 'undefined' ?  200  : time;
	if (time > 0) {
		setTimeout(function(){
			location.href = url;
		}, time);
	}else{
		location.href = url;
	}
}
//alert
function wptAlert(msg, callback, onlyBtnClose) {
	maskIsHide = false;

	$(".wptAlert .tip .msg").html(msg);

	$(".wptAlert").show();
	$(".wptMask").animate({opacity: "0.4"}, 100);
	$(".wptAlert .dialog").animate({bottom: "0px"}, 100);

	$(document).off("wptAlert_view:hide").one("wptAlert_view:hide", function (e) {
		maskIsHide = true;
		$(".wptAlert .wptMask").animate({opacity: "0"}, 100);
		var height = '-' + $(".wptAlert .dialog").height() + 'px';
		$(".wptAlert .dialog").animate({bottom: height}, 100, function () {
			$(".wptAlert").hide();
		});
		if (typeof(callback) == 'function') setTimeout(callback, 0);
	});

	var closeObj = $('.wptAlert .wptMask, .wptAlert .btn-confirm');
	if(typeof onlyBtnClose != "undefined" && onlyBtnClose == true) {
		closeObj = $('.wptAlert .btn-confirm');
	}
	closeObj.off('touchend').one('touchend', function (e) {
		e.preventDefault();
		$(document.body).trigger("wptAlert_view:hide");
	});
}


function webToast() {
    //默认设置
    var dcfg = {
        msg: "提示信息",
        postion: "top",
        //展示位置，可能值：bottom,top,middle,默认top：是因为在mobile web环境下，输入法在底部会遮挡toast提示框
        time: 3000,
        //展示时间
    };
    //*********************以下为参数处理******************
    var len = arguments.length;
    var arg0 = arguments[0];
    if (arguments.length > 0) {
        dcfg.msg = arguments[0];
        dcfg.msg = arg0;

        var arg1 = arguments[1];
        var regx = /(bottom|top|middle)/i;
        var numRegx = /[1-9]\d*/;
        if (regx.test(arg1)) {
            dcfg.postion = arg1;
        } else if (numRegx.test(arg1)) {
            dcfg.time = arg1;
        }

        var arg2 = arguments[2];
        var numRegx = /[1-9]\d*/;
        if (numRegx.test(arg2)) {
            dcfg.time = arg2;
        }
    }
    //*********************以上为参数处理******************
    var ret = "<div class='web_toast'><div class='cx_mask_transparent'></div>" + dcfg.msg + "</div>";
    if ($(".web_toast").length <= 0) {
        $("body").append(ret);
    } else { //如果页面有web_toast 先清除之前的样式
        $(".web_toast").css("left", "");

        ret = "<div class='cx_mask_transparent'></div>" + dcfg.msg;
        $(".web_toast").html(ret);
    }
    $(".web_toast").fadeIn();
    var w = $(".web_toast").width(),
    ww = $(window).width();
    $(".web_toast").css("left", (ww - w) / 2 );
    if ("bottom" == dcfg.postion) {
        $(".web_toast").css("bottom", 50);
        $(".web_toast").css("top", ""); //这里为什么要置空，自己琢磨，我就不告诉
    } else if ("top" == dcfg.postion) {
        $(".web_toast").css("bottom", "");
        $(".web_toast").css("top", 50);
    } else if ("middle" == dcfg.postion) {
        $(".web_toast").css("bottom", "");
        $(".web_toast").css("top", "");
        var h = $(".web_toast").height(),
        hh = $(window).height();
        $(".web_toast").css("bottom", (hh - h) / 2 - 20);
    }
    setTimeout(function() {
        $(".web_toast").fadeOut();
    },
    dcfg.time);
}
