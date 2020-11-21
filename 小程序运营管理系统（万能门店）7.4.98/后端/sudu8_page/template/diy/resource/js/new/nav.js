$(function() {
	var nav = {
		data: {
			helpBtn: $('.help-server'),
			helpDom: $('.help-server-box'),
			navDom: $("left-menu app-sidebar"),
			scrollData: {
				width: 'auto', //可滚动区域宽度
				height: '100%', //可滚动区域高度
				size: '5px', //组件宽度
				color: 'rgb(118, 131, 143)', //滚动条颜色
				position: 'right', //组件位置：left/right
				distance: '3px', //组件与侧边之间的距离
				start: 'top', //默认滚动位置：top/bottom
				opacity: .5, //滚动条透明度
				alwaysVisible: false, //是否 始终显示组件
				disableFadeOut: false, //是否 鼠标经过可滚动区域时显示组件，离开时隐藏组件
				railVisible: true, //是否 显示轨道
				railColor: '#333', //轨道颜色
				railOpacity: .2, //轨道透明度
				railDraggable: true, //是否 滚动条可拖动
				railClass: 'slimScrollRail', //轨道div类名 
				barClass: 'slimScrollBar', //滚动条div类名
				wrapperClass: 'slimScrollDiv8', //外包div类名
				allowPageScroll: false, //是否 使用滚轮到达顶端/底端时，滚动窗口
				wheelStep: 20, //滚轮滚动量
				touchScrollStep: 200, //滚动量当用户使用手势
				borderRadius: '7px', //滚动条圆角
				railBorderRadius: '7px' //轨道圆角
			}
		},
		init: function() {
			var _this = this;
			// _this.getNotice();
			_this.data.helpBtn.on('click', _this.changeHelp);
			_this.navCurrent();
			_this.boxHeight();
			_this.slimScrollInit();
		},
		changeHelp: function(e) {
			var _this = this,
				isClose = $(_this).hasClass('help-close');
			nav.changeState(isClose);
		},
		changeState: function(isShow) {
			$.each([nav.data.helpBtn, nav.data.helpDom], function(index, value) {
				isShow ? value.removeClass('help-close') : value.addClass('help-close');
			});
			isShow ? $(".site-page .page-container .page").removeClass("show-margin") : $(".site-page .page-container .page").addClass("show-margin");
		},
		boxHeight: function() {
			var pageHeight = $(".page").height(),
				winHeight = $(window).height(),
				winWidth = $(window).width(),
				boxHeight = 0;
			boxHeight = winWidth >= 1350 ? pageHeight : pageHeight > winHeight ? winHeight - 50 : pageHeight;
			$(".help-server-body-box").height(boxHeight);
		},
		slimScrollInit: function() {
			var _this = this;
			$(".slimScroll-box").each(function() {
				var _that = $(this),
					data = {};
				$.each(_this.data.scrollData, function(key, value) {
					data[key] = _that.attr('data-scroll-' + key) || _this.data.scrollData[key];
				});
				_that.slimScroll(data);
			});
			$(window).on('load',function(){
				$(".slimScroll-box").trigger('mouseover');
			});
		},
		navCurrent: function() {
			var _this = this;
			var foldnav = _this.getCookie("foldnav");
			foldnav == 1 && $(".skin-black").addClass("skin-black-fold");
		},
		getCookie: function(name) {
			var cookies = document.cookie;
			if(cookies.length > 0) {
				var cooliesList = {};
				cookies.split(";").map(function(value, index) {
					cooliesList[value.split("=")[0].trim()] = value.split("=")[1];
				});
				if(cooliesList[name]) {
					return cooliesList[name];
				} else {
					return null;
				}
			} else {
				return null;
			}
		},
		delCookie: function(name) {
			var exp = new Date();
			exp.setTime(exp.getTime() - 1);
			var cval = this.getCookie(name);
			if(cval != null) {
				document.cookie = name + "=" + cval + ";expires=" + exp.toGMTString();
			}
		},
		// getNotice: function() {
		// 	$.post('./index.php?c=direct&a=notice-show&do=post',{},function(data){
		// 		$("#admui-messageContent").html(data);
		// 	},'html');
		// }
	}
	nav.init();

	$(".site-menu-sub>li").click(function() {
		var $this = $(this);
		$(".site-menu .site-menu-sub>li").removeClass("active");
		$this.addClass("active");
	});

	$("#admui-toggleMenubar").click(function() {
		$("body").hasClass("site-menubar-unfold") ? $("body").removeClass("site-menubar-unfold").addClass("site-menubar-fold") : $("body").removeClass("site-menubar-fold").addClass("site-menubar-unfold");
	});

	$(".list-fold").click(function() {
		var skinBlack = $(".skin-black");
		var isFold = skinBlack.hasClass("skin-black-fold");
		isFold ? skinBlack.removeClass("skin-black-fold") : skinBlack.addClass("skin-black-fold");
		var foldnav = nav.getCookie("foldnav");
		nav.delCookie("foldnav");
		if(isFold) {
			document.cookie = "foldnav=0";
		} else {
			document.cookie = "foldnav=1";
		}
	});
	
	$(".change-skin").click(function() {
		var leftMenu = $(".skin-black > .left-menu.app-sidebar");
		var colour = $(this).data("skin");
		nav.delCookie("skin");
		document.cookie = "skin="+colour;
		if(colour == "black"){
			leftMenu.removeClass("colour-white");
		}else{
			!leftMenu.hasClass("colour-white")&&leftMenu.addClass("colour-white");
		}
		console.log(document.cookie);
	});
	
	var timeout = null;
	$(window).resize(function() {
		clearTimeout(timeout);
		timeout = setTimeout(function() {
			nav.boxHeight();
			nav.slimScrollInit();
		}, 500);
	});
});