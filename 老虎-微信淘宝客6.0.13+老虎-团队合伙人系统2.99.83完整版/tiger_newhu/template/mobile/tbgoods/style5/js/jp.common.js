	var _html="<div class='alert_fullbg' style='display:block;'></div>"
	var _height=$(window).height();
	var executeFlg = true;
	var timer;
	$(document).ready(function(){
	    var w_h=$("#head").width();
		//$("#index .search-area").css('width',w_h-100);
		if( $(".next-nav ul li a.active").offset() != null ){
            $(".next-nav .box").scrollLeft($(".next-nav ul li a.active").offset().left);
        }
		//alert(0);
	})
	//分类动画
	$(".classify .btn-type").on('click',function(){
		$("body").css("paddingBottom","0");
		//$(".back-top").css("display","none");
		$(".main").css({"height":_height,"overflow":"hidden"})
		$(".app").append(_html);
		$(".alert_fullbg").css('z-index','201');
		$(".app-other").css({'left':'0','visibility':'visible'});
		$(".app-other").css('height',_height)
		$(".alert_fullbg").on('click',function(){
			$("body").css("paddingBottom","45px");
			//$(".back-top").css("display","block");
			$(".app-other").css({'left':'-70%','visibility':'hidden'});
			$(this).remove();
			clearTimeout(timer);
			timer=setTimeout(function(){
			    $(".app-other").css('height',"auto")
			    $(".main").css({"height":"auto","overflow":"visible"})
			},400);
		});
	})
	
	//筛选
	$(".choice,.pack_up").on('click',function(){
	  var _all_h=0;
	  var dd_size=$(".screen-box dd").size();
	  _all_h=$(".screen-box dt").height()+$(".screen-box dd").height()*dd_size-18;
	  if($(".screen-box").hasClass("show")){
	    executeFlg=true;
	  	$(".alert_fullbg").remove();
		$(".choice em").addClass("cur");
	  	$(".screen-box").css("height","0px");
	  	$(".screen-box").removeClass("show");
	  }
	  else{
	    executeFlg=false;	  	
		$(".choice em").removeClass("cur");
	  	$(".screen-box").css("height",_all_h);
	    $(".screen-box").addClass("show");
		$(".alert_fullbg").on('click',function(){
			$(".alert_fullbg").remove();
			$(".choice em").removeClass("cur");
			$(".screen-box").css("height","0px");
			$(".screen-box").removeClass("show");
			executeFlg=true;
		})
	  }
	})
	//滚动一级导航浮动
	var nav_f_show=function(){
		$(window).on('scroll',function(){
		if($(window).scrollTop()>$("#nav").offset().top&&executeFlg==true){
			$("#nav ul").addClass("fixed");
		}
		else{
			$("#nav ul").removeClass("fixed");
		}
	})
	}
	//二级导航浮动以及适配
	var nav_t_show=function(){
	    var box=$(".next-nav").width();
	    var _box_h=0;
		$(".next-nav ul li").each(function(i){
		    _box_h+=$(this).width();
		})
		$(".next-nav ul").css("width",_box_h);
		$(window).on('scroll',function(){
		if($(window).scrollTop()>$(".next-nav").offset().top&&executeFlg==true){
			$(".next-nav .box").addClass("fixed");
		}
		else{
			$(".next-nav .box").removeClass("fixed");
		}
	})
	}
	if($(".next-nav ul li").size()>0){
		nav_t_show();
	}
	if($("#nav").size()>0){
		nav_f_show();
	}
	
	
		//搜索导航浮动
	var nav_search_show=function(){
		$(window).on('scroll',function(){
		if($(window).scrollTop()>$("#head").offset().top&&executeFlg==true){
			$(".search_warp").show();
			$(".search_warp").addClass("fixed");
			
			
		}
		else{
			$(".search_warp").removeClass("fixed");
			$(".search_warp").hide();
		}
	})
	}
	if($(".next-nav ul li").size()>0){
		nav_t_show();
	}
	if($("#nav").size()>0){
		nav_f_show();
	}
	if($("#head").size()>0){
		nav_search_show();
		
	}
	if($("#bady-tab").size()>0){
		bady_tab_show();
	}
	

	/**
     * 首页幻灯片 mumian
     * @param {}
     * @time 2015-02-10
     */
    var carousel_index = function(){
	    //var area_h=$(".banner li a").height();
		//$(".area").css("height",area_h);
        if($(".banner li").size() <= 1) return;
        $(".banner li").each(function(){
            $(".adType").append('<a></a>');
        });
		$('.area').swipeSlide({
		continuousScroll:true,
		speed : 3000,
		transitionType : 'cubic-bezier(0.22, 0.69, 0.72, 0.88)'
		},function(i){
		$('.adType').children().eq(i).addClass('current').siblings().removeClass('current');
		});
    }
    carousel_index();
	//搜索
	//alert($("#search_keyword").val());
	searchFun=function(){
		$("#search_keyword").on('focus',function(){
		$(this).next().css("display","block");
		})
		var $search_txt = $(".box-search #keyword");
		$search_txt.on('keyup', function () {
                if ($(this).val() == "") {
                    $(this).next().css("display","none");
                } else {
                    $(this).next().css("display","block");
                }
            });
		$(".box-search .del").on('click',function(){
						$(this).css("display","none");
						$search_txt.val("");
		})
	}
	searchFun();
	$(".closed").on("click",function(){
    	$(".go-app").hide();
    	return false;
    })
	//关于筛选勾勾
	$(".screen-box dd a").on("click",function(){
		$(".screen-box dd a").find("img").css("display","none");
		$(this).find("img").css("display","block");
	});




   
