//ios
if (/(iPhone|iPad|iPod|iOS)/i.test(navigator.userAgent)) {
   //alert(navigator.userAgent); 
   
   //add a new meta node of viewport in head node
	head = document.getElementsByTagName('head');
	viewport = document.createElement('meta');
	viewport.name = 'viewport';
	viewport.content = 'target-densitydpi=device-dpi, width=' + 640 + 'px, user-scalable=no';
	head.length > 0 && head[head.length - 1].appendChild(viewport);    
   
}
//android
//if (/(iPhone|iPad|iPod|iOS)/i.test(navigator.userAgent)) {
//  //alert(navigator.userAgent);  
//  window.location.href ="iPhone.html";
//} else if (/(Android)/i.test(navigator.userAgent)) {
//  //alert(navigator.userAgent); 
//  window.location.href ="Android.html";
//} else {
//  window.location.href ="pc.html";
//};

$(function(){
	
	
	//页面不足一屏，铺满一屏
	$('.layout').css('min-height',$(window).height());
	
	var glide = $('.glide').glide({

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
	});

	
	$(window).scroll(function() {
		//如果滚轮向下滚了
		if($("#toTop").size() > 0){
			if($(document).scrollTop() > 0){
				$("#toTop").css("display","block");
				$("#toTop").click(function() {
					$('body').stop().animate({
						scrollTop: 0
					}, 500);
				});
			}else{
				$("#toTop").css("display","none");
			}
		}
	});
});

//浮动菜单
$(function() {
	$(window).scroll(function() {
		if($("#s_menu").size() > 0){
			//如果滚轮向下滚了
			if($(document).scrollTop() > 0){
				$("#s_menu").css("display","block");
			}else{
				$("#s_menu").css("display","none");
			}
		}
	});
	
	//点击浮动菜单弹出相应的
	if($("#all_kind").size() > 0){
		//所有种类
		$("#all_kind .title_a").click(function(){
			if($(this).parent().find("dl").is(":hidden")){
				$(this).parent().find("dl").fadeIn();
				$("#pro_sort dl").fadeOut();
				$("#filter .f_div").fadeOut();
				$("#all_kind").addClass("selected");
				$("#pro_sort").removeClass("selected");
				$("#filter").removeClass("selected");
				$("#mask").fadeIn();
			}else{
				$(this).parent().find("dl").fadeOut();
				$("#all_kind").removeClass("selected");
				$("#mask").fadeOut();
			}
		});
		
	}
	if($("#pro_sort").size() > 0){
		//所有种类
		$("#pro_sort .title_a").click(function(){
			if($(this).parent().find("dl").is(":hidden")){
				$(this).parent().find("dl").fadeIn();
				$("#all_kind dl").fadeOut();
				$("#filter .f_div").fadeOut();
				$("#pro_sort").addClass("selected");
				$("#all_kind").removeClass("selected");
				$("#filter").removeClass("selected");
				$("#mask").fadeIn();
			}else{
				$(this).parent().find("dl").fadeOut();
				
				$("#pro_sort").removeClass("selected");
				
				$("#mask").fadeOut();
			}
		});
	}
	//筛选
	if($("#filter").size() > 0){
		$("#filter .title_a").click(function(){
			if($(this).parent().find(".f_div").is(":hidden")){
				$(this).parent().find(".f_div").fadeIn();
				$("#all_kind dl").fadeOut();
				$("#pro_sort dl").fadeOut();
				$("#filter").addClass("selected");
				$("#all_kind").removeClass("selected");
				$("#pro_sort").removeClass("selected");
				$("#mask").fadeIn();
			}else{
				$(this).parent().find(".f_div").fadeOut();
				
				$("#filter").removeClass("selected");
				$("#mask").fadeOut();
			}
		});
	}
	
	if($("#mask").size() > 0){
		$("#mask").click(function(){
			$("#all_kind dl").fadeOut();
			$("#pro_sort dl").fadeOut();
			$("#filter .f_div").fadeOut();
			$("#all_kind").removeClass("selected");
			$("#pro_sort").removeClass("selected");
			$("#filter").removeClass("selected");
		});
	}
});

//浮动菜单二维码
$(function(){
	if($("#title_qr").size() > 0){
		$("#title_qr").click(function(){
			$("#mask").fadeIn();
			$("#qr_img").fadeIn();
		});
		
		$("#mask").click(function(){
			$("#mask").fadeOut();
			$("#qr_img").fadeOut();
		});
	}
});

//首页轮播
$(function(){
	if ($('#h_slider').size() > 0) {
        $('#h_slider').glide({
            //autoplay:true,//是否自动播放 默认值 true如果不需要就设置此值
            animationTime: 500, //动画过度效果，只有当浏览器支持CSS3的时候生效
            arrows: false, //是否显示左右导航器
            //arrowsWrapperClass: "arrowsWrapper",//滑块箭头导航器外部DIV类名
            //arrowMainClass: "slider-arrow",//滑块箭头公共类名
            //arrowRightClass:"slider-arrow--right",//滑块右箭头类名
            //arrowLeftClass:"slider-arrow--left",//滑块左箭头类名
            arrowRightText: "", //定义左右导航器文字或者符号也可以是类
            arrowLeftText: "",
            nav: false, //主导航器也就是本例中显示的小方块
            navCenter: true, //主导航器位置是否居中
            navClass: "slider-nav", //主导航器外部div类名
            navItemClass: "slider-nav__item", //本例中小方块的样式
            navCurrentItemClass: "slider-nav__item--current" //被选中后的样式
                //
        });
   	}
})

//底部菜单自适应
$(function(){
	if($(".footer").size() > 0){
		var li = $(".footer ul li");
		li.css("width",(100/li.length)+"%");
	}
});



//$(document).delegate("a", "click", function (e) {
//
//      var url = $(this).attr("href");
//      if($("#goods_box").length == 0) return;
//      //e.preventDefault();
//      //$(this).attr("target", "_blank");
//
//      //isLoadingOrIsLoaded("", true, false);
//	
//      window.localStorage.setItem("top", document.body.scrollTop);
//      window.localStorage.setItem("html", $("#goods_box").parent().html());
//      window.localStorage.setItem("url", window.location.href);
//			 
//		
//  });
//	
//
//  if(window.localStorage.getItem("url") == window.location.href && window.localStorage.getItem("top") != "null") {
//		
//      $("#goods_box").parent().html(window.localStorage.getItem("html"));
//      document.body.scrollTop = window.localStorage.getItem("top");
//      window.localStorage.setItem("top", "null");
//      window.localStorage.setItem("html", "null");
//      window.localStorage.setItem("url", "null");		
//		 	//alert(limit);
//		var le=$("#goods_box li").length;
//		limit=1+Math.ceil(le/10);
//			//alert(limit);
//		//alert( $("#list_box li").length);
//  }	
