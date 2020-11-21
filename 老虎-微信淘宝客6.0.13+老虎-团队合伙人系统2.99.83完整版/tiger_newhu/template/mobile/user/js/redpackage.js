$(function(){
	var width = $(window).width();
	$("html,body").css('font-size',(width/18.75)+'px');
	$(window).resize(function(){
	var width = $(window).width();
		$("html,body").css('font-size',(width/18.75)+'px');
	})

	var send_phone = null;
	$(".getred").click(function(){
		$(".step1").hide();
		$(".step2").show();
	})
	$(".next").click(function(){
		var phone = $(".tel").val();
		//var code = $(".code").val();
		if(phone==''||phone.length!=11){
			layer.msg('请输入正确的手机号');
		}else{
			//$.post($("#verifycode").val(),{vercode:code},function(ret){
				//if(ret.isError==false){
					send_phone = phone;
					$('.phone').text(phone);
					$(".setpwd").show();
					$(".reg").hide();
				//}else{
				//	layer.msg(ret.errorMessage);
				//}
			//})
		}
		
	})
	$(".success").click(function(){
		var pwd = $(".pwd").val();
		var patt = / /ig;
		if(patt.test(pwd)){
			layer.msg('不能包含空格');
			$(".pwd").val('');
		}else{
			if(pwd.length<6||pwd.length>24){
				layer.msg('请输入6-24位密码');
			}else{
				$.post($("#reg").val(),{phone:send_phone,password:pwd},function(ret){
					ret=JSON.parse(ret);
					//console.log(ret);
					//alert(ret);
					if(ret.error){
						//alert(1);
						$(".final").show();
						$(".red-package").hide();
					}else{						
						//alert(2);
						layer.msg(ret.data);
					}
				})
			}
		}
		
	})
	
	function oldUser(phone){
		$(".reg").hide();
		$(".red-package").hide();
		$('.phone').text(phone);
		$(".final").show();
	}
	$(".getcode").click(function(){
		var phone = $(".tel").val();
		var self =$(this);
		if(!$(this).hasClass('disabled')){
			if(phone==''||phone.length!=11){
				layer.msg('请输入正确的手机号');
			}else{
					$.post($("#getcode").val(),{phone:phone},function(ret){
						if(ret.isError==false){
							layer.msg('验证码发送成功');
							timer();
							self.addClass('disabled');
						}else{
							layer.msg(ret.errorMessage);
							if(ret.errorCode=="10005"){
								oldUser(phone);
							}
						}
					})
			}
		}
		
	})

	function timer(){
		var t = 60;
		var handle = setInterval(function(){
			if(t>0){
				t--;
				$(".getcode").text(t+'s');
			}else{
				$(".getcode").text('验证码').removeClass('disabled');
				clearInterval(handle);
			}
		},1000)
	}
	$(".download").click(function(){
			$(".download-notice").click(function(){
				$(this).removeClass('active');
			})
			if(type==1){
				location.href = wlink;
			}else{
				if (mobileUtil.isWeiBo) {
					if (mobileUtil.isAndroid) {
						$(".download-notice").addClass('active android');
					}else{
						$(".download-notice").addClass('active ios');
					}
				}else if(mobileUtil.isWeixin){
					if (mobileUtil.isAndroid) {
						$(".download-notice").addClass('active android');
					}else{
						location.href = ioslink;
					}

				}else{
					if (mobileUtil.isAndroid) {
						location.href = andlink;
					}else{
						location.href = ioslink;
					}
				}
			}
	})
})