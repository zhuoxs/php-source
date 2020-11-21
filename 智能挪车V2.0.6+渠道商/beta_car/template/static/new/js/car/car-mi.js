// JavaScript Document
$(document).ready(function(){
	/*显示数量的面板*/
	$(".cpmc_slBtn").click(function(){
		$('.panelMask').css('display','block');
		$('.panelMask').height($(window).height());
		$('.slPanel').css('display','block');
		$(".slPanel").animate({bottom:'50'});
		$(".slPanel_close").css('display','block');
		$(".slPanel_close").animate({bottom:'43.5%'});
	});
	/*关闭数量面板*/
	$(".slPanel_close").click(function(){
		$(".slPanel").animate({bottom:'0'});
		$('.slPanel').css('display','none');
		$('.panelMask').css('display','none');
	});
	/*数量的加减*/
	$(".slPanel_plus").click(function(){
		var temp = $('.slPanel_value').text();
		temp = parseInt($('.slPanel_value').text()) + 1;
		$('.slPanel_value').text(temp);
	});
	$(".slPanel_minus").click(function(){
		if(parseInt($('.slPanel_value').text()) > 1)
		{
			var temp = $('.slPanel_value').text();
			temp = parseInt($('.slPanel_value').text()) - 1;
			$('.slPanel_value').text(temp);
		}
	});
	/*显示数量的面板*/
	
	/*申请成功显示的面板*/
	$(".zzsqz_sqBtn").click(function(){
		$('.panelMaskAll').css('display','block');
		$('.panelMaskAll').height($(window).height());
		$('.sqIsSuccessPanel').css('display','block');
	});
	$(".sqIsSuccessPanel_cannel").click(function(){
		$('.sqIsSuccessPanel').css('display','none');
		$('.panelMaskAll').css('display','none');
	});
	$(".sqIsSuccessPanel_ok").click(function(){
		$('.sqIsSuccessPanel').css('display','none');
		$('.panelMaskAll').css('display','none');
	});
	/*申请成功显示的面板*/
	
	/*我的团队*/
	
	/*我的团队*/
});

$(window).scroll(function () {
	var pos = $(this).scrollTop();
	//alert($('.cpmc_info').height() + "-------------" + pos);
	//alert(pos + "----------------"+ $(window).height());
	//alert($('.Menubox').css('marginTop'));
	
	if(pos >= $('.cpmc_info').height())
	{
		$('.Menubox').css('top' , 0);
		$('.Menubox').css('position' , 'fixed');
		$('.cpmc_pjUL').css('marginTop' , '25%');
		$('.cpmc_twxq').css('marginTop' , '20%');
		$('.cpmc_spsx').css('marginTop' , '25%');
	}
	if(pos < $('.cpmc_info').height())
	{
		$('.Menubox').css('top' , '');
		$('.Menubox').css('position' , '');
		$('.cpmc_pjUL').css('marginTop' , '');
		$('.cpmc_twxq').css('marginTop' , '');
		$('.cpmc_spsx').css('marginTop' , '');
	}
});

/*产品名称的tab*/
function setTab(name,cursel,n)
{
	for(i=1;i<=n;i++)
	{
		var menu=document.getElementById(name+i);
		var con=document.getElementById("con_"+name+"_"+i);
		menu.className=i==cursel?"hover":"";
		con.style.display=i==cursel?"block":"none";
		
		if(cursel== 1)
		{
			$('.cpmc_twxq').css('marginTop' , '0');
			$('.cpmc_twxq').css('top' , '0');
		}
		else if(cursel == 2)
		{
			$('.cpmc_spsx').css('marginTop' , '0');
			$('.cpmc_spsx').css('top' , '0');
		}
		else if(cursel == 3)
		{
			$('.cpmc_pjUL').css('marginTop' , '0');
			$('.cpmc_pjUL').css('top' , '0');
		}
		
	}
	$(".Contentbox").height($(".Contentbox").height() + 100);
	$('.Menubox').css('top' , 0);
	$('.Menubox').css('position' , 'fixed');
}