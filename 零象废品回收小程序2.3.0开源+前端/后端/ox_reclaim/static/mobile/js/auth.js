window.onerror=function(){
	alert(JSON.stringify(arguments));
}
$(document).ready(function(){
	base.initlogin();
	base.ready=function(){
		base.inittabs();
		var pics=[];
		base.request('api.public.config',{type:'authtype'},function(data){
			if(data.config){
				var config=JSON.parse(data.config);
				var html=[];
				for(var i=0;i<config.length;i++){
					html.push('<label class="weui-cell weui-check__label" for="auth_type_'+i+'"><div class="weui-cell__hd"><input type="radio" class="weui-check" name="type" value="'+(i+1)+'" id="auth_type_'+i+'"><i class="weui-icon-checked"></i></div><div class="weui-cell__bd"><p>'+config[i]+'</p></div></label>');
				}
				$('#auth_type').html(html.join(''));
			}
			base.request('api.weixin.auth.get',{},function(data){
				if(!data.auth || data.auth.status==2){
					$('#file').change(function(){
						base.upload({id:'#file'},function(data){
							if(data.url){
								pics.push(data.url);
								$('#uploaderFiles').append('<li class="weui-uploader__file" style="background-image:url('+data.url+')"></li>');
								$('#pics').val(pics.join(','));
							}
							else{
								$.alert(data.error);
							}
						});
					});
					$('#submit').click(function(){
						if(base.lock){
							return false;
						}
						var type=$('input[name="type"]:checked').val();
						var card_name=$('#card_name').val();
						var card_no=$('#card_no').val();
						var pics=$('#pics').val();
						if(card_name.length==0){
							$.toptip('姓名或者公司名称不能为空','error');
							return false;
						}
						if(card_no.length==0){
							$.toptip('身份证号或者信用代码号不能为空','error');
							return false;
						}
						if(pics.split(',').length>5 || pics.split(',').length==0){
							$.toptip('最多五张最少一张图片','error');
							return false;
						}
						base.lock=true;
						base.request('api.weixin.auth',{type:type,card_name:card_name,card_no:card_no,pics:pics},function(data){
							base.lock=false;
							if(data.error){
								base.toast(base.error);
								return false;
							}
							base.toast('上传成功等待审核',function(data){
								base.redirect(base.memberurl);
							});
						});
					});
				}
				else{
					if(data.auth.status==0){
						$('#submit').text('正在审核中').addClass('weui-btn_disabled');
					}
					else{
						$('#submit').text('认证审核已通过').addClass('weui-btn_disabled');
					}
					$('.weui-uploader__input-box').hide();
					$('input[name="type"]').prop('disabled',true);
					$('input[name="type"][value="'+data.auth.type+'"]').prop('checked',true);
					$('#card_no').val(data.auth.card_no).prop('disabled',true);
					$('#card_name').val(data.auth.card_name).prop('disabled',true);
					pics=data.auth.pics.split(',');
					for(var i=0;i<pics.length;i++){
						$('#uploaderFiles').append('<li class="weui-uploader__file" style="background-image:url('+pics[i]+')"></li>');
					}
				}
			});
			
			
			$('#uploaderFiles').on('click','li',function(){
				$.photoBrowser({items:pics,initIndex:$(this).index()}).open();
			});
		});
		
		
	}
	
})


 