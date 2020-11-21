function tusi(txt,fun){
	$('.tusi').remove();
	var div = $('<div style="background-image: url('+commonjspath+'/tusi.png);max-width: 85%;min-height: 77px;min-width: 270px;position: absolute;left: -1000px;top: -1000px;text-align: center;border-radius:10px;"><span style="color: #ffffff;line-height: 77px;font-size: 23px;">'+txt+'</span></div>');
	$('body').append(div);
	div.css('zIndex',9999999);
	div.css('left',parseInt(($(window).width()-div.width())/2));
	var top = parseInt($(window).scrollTop()+($(window).height()-div.height())/2);
	div.css('top',top);
	setTimeout(function(){
		div.remove();
    	if(fun){
    		fun();
    	}
	},2000);
}
function tusi_h(txt,fun){
	$('.tusi').remove();
	var div = $('<div style="background-image: url('+commonjspath+'/tusi_h.png);max-width: 85%;min-height: 40px;min-width: 270px;position: absolute;left: -1000px;top: -1000px;text-align: center;border-radius:10px;"><span style="color: #ffffff;line-height: 40px;font-size: 23px;">'+txt+'</span></div>');
	$('body').append(div);
	div.css('zIndex',9999999);
	div.css('left',parseInt(($(window).width()-div.width())/2));
	var top = parseInt($(window).scrollTop()+($(window).height()-div.height())/2);
	div.css('top',top);
	setTimeout(function(){
		div.remove();
    	if(fun){
    		fun();
    	}
	},3000);
}
function loading(txt){
	if(txt === false){
		$('.qp_lodediv').remove();
	}else{
		$('.qp_lodediv').remove();
		var div = $('<div class="qp_lodediv" style="background: url('+commonjspath+'/loadb.png);width: 269px;height: 107px;position: absolute;left: -1000px;top: -1000px;text-align: center;"><span style="color: #ffffff;line-height: 107px;font-size: 23px; white-space: nowrap;">&nbsp;&nbsp;&nbsp;<img src="'+commonjspath+'/load.gif" style="vertical-align: middle;"/>&nbsp;&nbsp;'+txt+'</span></div>');
		$('body').append(div);
		div.css('zIndex',9999999);
		div.css('left',parseInt(($(window).width()-div.width())/2));
		var top = parseInt($(window).scrollTop()+($(window).height()-div.height())/2);
		div.css('top',top);
	}	
}