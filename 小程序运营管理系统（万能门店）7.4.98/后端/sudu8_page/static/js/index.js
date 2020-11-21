$(document).ready(function(){
	var windowheight = $(window).height();
	$('.aside').css('height',windowheight);
	var windowwidth = $(window).width();
	$('.contentbox').css('width',windowwidth-200);
	$('.aside_user').mouseover(function(){
		$('.aside_user_content').show()
	})
	$('.aside_user').mouseout(function(){
		$('.aside_user_content').hide()
	})
	$('.aside_user_content').mouseover(function(){
		$('.aside_user_content').show()
	})
	$('.aside_user_content').mouseout(function(){
		$('.aside_user_content').hide()
	})
	var jdt_w = $('.jdt').outerWidth();
	var jdt_left_w = jdt_w/2-10;
	$('.jdt_left').css('width',jdt_left_w);
	$('.jdt_right').css('width',jdt_left_w);
	$('.order_details_alert').css('width',windowwidth)
	$('.order_details_alert').css('height',windowheight)
	var ckwlacl = (windowwidth-720)/2;
	var ckwlact = (windowheight-210)/2
	$('.ckwlac').css('left',ckwlacl);
	$('.ckwlac').css('top',ckwlact);
	$('.ckwl').click(function(){
		$('.ckwla').show()
	})
	$('.ckwl_close').click(function(){
		$('.ckwla').hide()
	})
	$('.tjbzac').css('left',ckwlacl);
	$('.tjbz').click(function(){
		$('.tjbza').show()
	})
	$('.tjbz_close').click(function(){
		$('.tjbza').hide()
	})
	$('.xgshxxac').css('left',ckwlacl);
	$('.xgshxx').click(function(){
		$('.xgshxxa').show()
	})
	$('.xgshxx_close').click(function(){
		$('.xgshxxa').hide()
	})
	$('#changead_check1').click(function(){
		$('.change_address').hide()
	})
	$('#changead_check2').click(function(){
		$('.change_address').show()
	})
	var xgyjacl = (windowwidth-800)/2;
	var xgyjact = (windowheight-598)/2
	$('.xgyjac').css('left',xgyjacl);
	$('.xgyjac').css('top',xgyjact)
	$('.xgyj').click(function(){
		$('.xgyja').show()
	})
	$('.xgyj_close').click(function(){
		$('.xgyja').hide()
	})
	var tjbzact = (windowheight-333)/2
	$('.tjbzac').css('left',ckwlacl);
	$('.tjbzac').css('top',tjbzact);
	$('.dd_head_right').click(function(){
		$('.tjbza').show()
	})
	$('.tjbz_close').click(function(){
		$('.tjbza').hide()
	})
	var hyczat = (windowheight-649)/2
	$('.hyczc').css('left',ckwlacl);
	$('.hyczc').css('top',hyczat);
	$('.hycz').click(function(){
		$('.hycza').show()
	})
	$('.hycz_close').click(function(){
		$('.hycza').hide()
	})
	
	$('.czjf').click(function(){
		$('.czjf').addClass('active')
		$('.czjfa').show();
		$('.czyea').hide();
		$('.czye').removeClass('active');
		$('#submit_czjf').show()
		$('#submit_czye').hide()
	})
	$('.czye').click(function(){
		$('.czjf').removeClass('active')
		$('.czjfa').hide();
		$('.czyea').show();
		$('.czye').addClass('active')
		$('#submit_czjf').hide()
		$('#submit_czye').show()
	})
	var delete_fxsact =(windowheight-134)/2
	$('.delete_fxsac').css('margin-top',delete_fxsact);
	$('.delete_fxs').click(function(){
		$('.delete_fxsa').show()
	})
	$('.delete_fxsac_close').click(function(){
		$('.delete_fxsa').hide()
	})
	$('.deltrs').click(function(){
		var q = 0
		var tbody = $('.tbody')
			var chks = $('.tbody').find('input')
			for (var i = chks.length - 1; i >= 0; i--) {
				if (chks[i].type == "checkbox" && chks[i].checked == true) {
					q++;
				}
			}
			if(q!=0){$('.delete_fxsa1').show()}
		
	})
	$('.delete_fxsac_close').click(function(){
		$('.delete_fxsa1').hide()
	})
	$('.xiajia').click(function(){
		var q = 0
		var tbody = $('.tbody')
			var chks = $('.tbody').find('input')
			for (var i = chks.length - 1; i >= 0; i--) {
				if (chks[i].type == "checkbox" && chks[i].checked == true) {
					q++;
				}
			}
			if(q!=0){$('.delete_fxsa2').show()}
	})
	$('.delete_fxsac_close').click(function(){
		$('.delete_fxsa2').hide()
	})
	$('#member_details_zdy').click(function(){
		$('.jfsx_input').show()
	})
	$('#member_details_read').click(function(){
		$('.jfsx_input').hide()
	})
	$('.jbxx').click(function(){
		$('.jbxx').addClass('active');
		$('.jyxx').removeClass('active');
		$('.fxsxx').removeClass('active');
		$('.member_details_jbxx').show();
		$('.member_details_jyxx').hide();
		$('.member_details_fxsxx').hide();
	})
	$('.jyxx').click(function(){
		$('.jbxx').removeClass('active');
		$('.jyxx').addClass('active');
		$('.fxsxx').removeClass('active');
		$('.member_details_jbxx').hide();
		$('.member_details_jyxx').show();
		$('.member_details_fxsxx').hide();
	})
	$('.fxsxx').click(function(){
		$('.jbxx').removeClass('active');
		$('.jyxx').removeClass('active');
		$('.fxsxx').addClass('active');
		$('.member_details_jbxx').hide();
		$('.member_details_jyxx').hide();
		$('.member_details_fxsxx').show();
	})
	$(".selectAll").click(function(){
		if($(this).is(':checked')){
			$('.selectOne').prop('checked',true)
		}else{
			$('.selectOne').prop('checked',false);
		}
	})
	$(".selectOne").click(function(){
		var allSel = false
		$(".selectOne").each(function(){
			if(!$(this).is(':checked')){
				allSel = true
			}
		})
		if(allSel){
			$(".selectAll").prop('checked',false)
		}else{
			$(".selectAll").prop('checked',true)
		}
	
	})
	var list_liw = $('.list_li').outerWidth();
	var list_lih = $('.list_li').outerHeight();
	var ul_linew = list_liw*3-40;

})
$(window).resize(function(){
	var windowheight = $(window).height();
	$('.aside').css('height',windowheight);
	var windowwidth = $(window).width();
	$('.contentbox').css('width',windowwidth-200);
	$('.aside_user').mouseover(function(){
		$('.aside_user_content').show()
	})
	$('.aside_user').mouseout(function(){
		$('.aside_user_content').hide()
	})
	$('.aside_user_content').mouseover(function(){
		$('.aside_user_content').show()
	})
	$('.aside_user_content').mouseout(function(){
		$('.aside_user_content').hide()
	})
	var jdt_w = $('.jdt').outerWidth();
	var jdt_left_w = jdt_w/2-10;
	$('.jdt_left').css('width',jdt_left_w);
	$('.jdt_right').css('width',jdt_left_w);
	$('.order_details_alert').css('width',windowwidth)
	$('.order_details_alert').css('height',windowheight)
	var ckwlacl = (windowwidth-720)/2;
	var ckwlact = (windowheight-210)/2
	$('.ckwlac').css('left',ckwlacl);
	$('.ckwlac').css('top',ckwlact);
	$('.ckwl').click(function(){
		$('.ckwla').show()
	})
	$('.ckwl_close').click(function(){
		$('.ckwla').hide()
	})
	var tjbzact = (windowheight-333)/2
	$('.tjbzac').css('left',ckwlacl);
	$('.tjbzac').css('top',tjbzact);
	$('.tjbz').click(function(){
		$('.tjbza').show()
	})
	$('.tjbz_close').click(function(){
		$('.tjbza').hide()
	})
	$('.xgshxxac').css('left',ckwlacl);
	$('.xgshxx').click(function(){
		$('.xgshxxa').show()
	})
	$('.xgshxx_close').click(function(){
		$('.xgshxxa').hide()
	})
	var xgyjacl = (windowwidth-800)/2;
	var xgyjact = (windowheight-598)/2
	$('.xgyjac').css('left',xgyjacl);
	$('.xgyjac').css('top',xgyjact)
	$('.xgyj').click(function(){
		$('.xgyja').show()
	})
	$('.xgyj_close').click(function(){
		$('.xgyja').hide()
	})
	$('.tjbzac').css('left',ckwlacl);
	$('.dd_head_right').click(function(){
		$('.tjbza').show()
	})
	$('.tjbz_close').click(function(){
		$('.tjbza').hide()
	})
	var hyczat = (windowheight-649)/2
	$('.hyczc').css('left',ckwlacl);
	$('.hyczc').css('top',hyczat);
	$('.hycz').click(function(){
		$('.hycza').show()
	})
	$('.hycz_close').click(function(){
		$('.hycza').hide()
	})
	var delete_fxsact =(windowheight-134)/2
	$('.delete_fxsac').css('margin-top',delete_fxsact);
	$('.delete_fxs').click(function(){
		$('.delete_fxsa').show()
	})
	$('delete_fxsac_close').click(function(){
		$('.delete_fxsa').hide()
	})
})
var changeText = function (me){
	var val = me.innerText;
	me.parentNode.parinnerHTML = me.innerHTML = '<input class="changeText" onblur="setValue(this)" type="text" value="' + val + '"/>';
}
var setValue = function(me){
	var td = me.parentNode;
	val = me.value;
	td.innerHTML = val;
}
var changeText2 = function (me){
	var val = me.innerText;
	me.innerHTML = me.innerHTML = '<input class="changeText2" onblur="setValue(this)" type="text" value="' + val + '"/>';
}
function delTrs(){
			var tbody = $('.tbody')
			var chks = $('.tbody').find('input')
			for (var i = chks.length - 1; i >= 0; i--) {
				if (chks[i].type == "checkbox" && chks[i].checked == true) {
					chks[i].parentNode.parentNode.remove();
				}
			}
			$('.delete_fxsa1').hide()
}
