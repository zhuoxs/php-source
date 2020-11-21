define(['jquery', '../diypage/jquery.slimscroll.js', '../diypage/jquery.nestable.js'], function($) {
	var custom = {
		data: {
			helpBtn: $('.help-server'),
			helpDom: $('.help-server-box'),
			scrollData: {
				width: 'auto', //可滚动区域宽度
				height: '100%', //可滚动区域高度
				size: '5px', //组件宽度
				color: 'rgb(118, 131, 143)', //滚动条颜色
				position: 'right', //组件位置：left/right
				distance: '5px', //组件与侧边之间的距离
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
//			_this.nestableInit();
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
		},
		nestableInit: function() {
			$('.dd').nestable({
				maxDepth: 5, //最大层级
			});
		}
	}
	return custom;
});