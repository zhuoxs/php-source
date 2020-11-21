//script
$(document).ready(function(){
	
	
	$(".video").click(function(){
		$(".popup-video").addClass("active");
	})
	
	$(".popup .close").click(function(){
		$(".popup video").trigger("pause");
		$(".main-body,.popup").removeClass("active");
	})
	
	$(".daicon ol li:first-child").addClass("active").find(".olcon").slideDown();
	$(".daicon ol li").click(function(){
		$(this).addClass("active").find(".olcon").slideDown().parents("li").siblings().removeClass("active").find(".olcon").slideUp();
	})

	
	$(".app .demo").hover(function(){
		$(this).next(".ma").stop(true,true).delay(300).show(0);
	},function(){
		$(this).next(".ma").stop(true,true).delay(600).hide(0);
	})
	
	$(".scenes li").hover(function(){
		$(this).find("p").stop(true,true).slideDown();
	},function(){
		$(this).find("p").stop(true,true).slideUp();
	})
	//tab
	vtab = function(vtit,vbox,vevent){
		$(vtit).find("li:first-child").addClass("active");
		$(vbox).find(".vcon:first-child").show().siblings(".vcon").hide();
		$(vtit).find("li").bind(vevent,function(){
			$(this).addClass("active").siblings("li").removeClass("active");
			var ai = $(vtit).find("li").index(this);
			$(vbox).children().eq(ai).show().siblings().hide();
			return false;
		})
	}
	vtab(".vt",".vb","click");
	
	//兼容性
	
	$(".app li:nth-child(4n)").css("margin-right","0");
	$(".app li:nth-child(n+5)").css("margin-top","3.5%");
	$(".scenes .li-2:nth-child(n+4)").css("margin-top","1%");
	$(".caselist li:nth-child(6n)").css("margin-right","0");
	$(".daili-list li:last-child").css("margin-right","0");
	$(".youshi .con li:nth-child(2n)").css("margin-left","4%");
	

})

document.addEventListener('touchstart', function () {}, false);