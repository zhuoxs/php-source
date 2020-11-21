if (!(/msie [6|7|8|9]/i.test(navigator.userAgent))){
	new WOW().init();
};

$(function(){
		//$('#test1').html('<span>111</span>');
		var glide = $('.abc').glide({

			//autoplay:true,//是否自动播放 默认值 true如果不需要就设置此值

			animationTime:500, //动画过度效果，只有当浏览器支持CSS3的时候生效

			arrows:true, //是否显示左右导航器
			//arrowsWrapperClass: "arrowsWrapper",//滑块箭头导航器外部DIV类名
			//arrowMainClass: "slider-arrow",//滑块箭头公共类名
			//arrowRightClass:"slider-arrow--right",//滑块右箭头类名
			//arrowLeftClass:"slider-arrow--left",//滑块左箭头类名
			arrowRightText:"",//定义左右导航器文字或者符号也可以是类
			arrowLeftText:"",

			nav:true, //主导航器也就是本例中显示的小方块
			navCenter:true, //主导航器位置是否居中
			navClass:"slider-nav",//主导航器外部div类名
			navItemClass:"slider-nav__item", //本例中小方块的样式
			navCurrentItemClass:"slider-nav__item--current" //被选中后的样式
			
			//
		});
	})