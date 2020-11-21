$(document).ready(function(){
	base.initlogin(true);
	base.ready=function(){
		base.inittabs();
		window.setInterval(function(){
			$('.weui-textarea-counter span').text($('#brand_content').val().length);
		},1000);
		$('.address input[type="checkbox"]').click(function(){
			if(parseInt(this.value)==1){
				$('.address input[type="checkbox"]').prop('checked',this.checked);
			}
			else{
				if(this.checked){
					if(isall()){
						$('#s12').prop('checked',true);
					}
				}
				else{
					$('#s12').prop('checked',false);
				}
			}
		});
		function isall(){
			var all=true;
			$('.address input[type="checkbox"]').each(function(){
				//console.log(isall);
				if(parseInt(this.value)!=1&&!this.checked){
					all=false;
					return false;
				}
			});
			return all;
		}
		var remaintime=0;
		var voice=0;
		$('.voice').click(function(){
			voice=1;
			$('#sendsms').text('语音验证码');
		});
		$('#sendsms').click(function(){
			if(remaintime>0){
				return false;
			}
			var mobile=$('#mobile').val();
			if(!base.validate.ismobile(mobile)){
				base.toast('请输入手机号');
				return false;
			}
			if(base.lock){
				return false;
			}
			base.lock=true;
			base.request('api.public.sms',{type:'register',mobile:mobile,voice:voice},function(data){
				base.lock=false;
				if(data.error){
					base.toast('发送失败');
					
				}
				else{
					remaintime=120;
					setremain();
				}
			});
			base.toast('已发送');
		});
		function setremain(){
			if(remaintime>0){
				$('#sendsms').text('剩余'+remaintime+'秒').addClass('disabled');
				remaintime--;
				window.setTimeout(function(){
					setremain();
				},1000);
			}
			else{
				remaintime=0;
				$('#sendsms').text('发送验证码').removeClass('disabled');
			}
		}
		$('#submit').click(function(){
			var real_name=$('#real_name').val();
			var mobile=$('#mobile').val();
			var code=$('#code').val();
			var brand=$('#brand').val();
			var brand_content=$('#brand_content').val();
			if(real_name.length<2){
				$.toast('请填写真实姓名','forbidden');
				return false;
			}
			if(code.length<4){
				$.toast('请填写验证码','forbidden');
				return false;
			}
			if(!base.validate.ismobile(mobile)){
				$.toast('请填写手机号','forbidden');
				return false;
			}
			var area=[];
			$('.address input[type="checkbox"]').each(function(){
				if(this.checked){
					area.push(this.value);
				}
			});
			if(area.length==0){
				$.toast('请选择地区','forbidden');
				return false;
			}
			base.request('api.weixin.profile',{real_name:real_name,mobile:mobile,code:code,brand:brand,brand_content:brand_content,area:area.join(','),openid:base.storage.get('openid')},function(data){
				if(data.error){
					$.alert(data.error);
					return false;
				}
				if(data.account_id){
					base.storage.set('account_id',data.account_id);
					base.storage.set('profile',1);
					if(base.storage.get('referer')){
						//base.redirect();
						window.location.href=base.storage.get('referer');
					}
					else{
						base.gohome();
					}
				}
			});
		});
	}
});
