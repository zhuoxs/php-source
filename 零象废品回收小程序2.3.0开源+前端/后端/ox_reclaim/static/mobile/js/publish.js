$(document).ready(function(){
		window.setInterval(function(){
			$('.weui-textarea-counter').eq(0).find('span').text($('#title').val().length);
			$('.weui-textarea-counter').eq(1).find('span').text($('#content').val().length);
		},1000);
		$("#area").cityPicker({
			title: "请选择收货地址"
		});
		request('api.public.config',{type:'infotype'},function(data){
			if(data.config){
				var config=JSON.parse(data.config);
				var html=[];
				for(var i=0;i<config.length;i++){
					html.push('<label class="weui-cell weui-check__label" for="info_type_'+i+'"><div class="weui-cell__hd"><input type="radio" class="weui-check" name="info_type" value="'+(i+1)+'" id="info_type_'+i+'" '+(i==0?'checked="checked"':'')+'><i class="weui-icon-checked"></i></div><div class="weui-cell__bd"><p>'+config[i]+'</p></div></label>');
				}
				$('#info_type').html(html.join(''));
			}
		});
		$('#submit').click(function(){
			if(base.lock){
				return false;
			}
			var info_type=$('input[name="info_type"]:checked').val();
			var title=$('#title').val();
			var contact_name=$('#contact_name').val();
			var contact_tel=$('#contact_tel').val();
			var num=$('#num').val();
			var area=$('#area').val();
			var area_code=$('#area').attr('data-codes');
			var content=$('#content').val();
			if(title.length>50 || title.length==0){
				$.toptip('标题最多50个字', 'error');
				return false;
			}
			if(contact_name.length<2 || contact_name.length>5){
				$.toptip('联系人最少2个字最多5个字', 'error');
				return false;
			}
			if(!base.validate.ismobile(contact_tel)){
				$.toptip('请输入正确的手机号码','error');
				return false;
			}
			if(num.length<2 || num.length>10){
				$.toptip('数量最少2个字最多10个字', 'error');
				return false;
			}
			if(area==''){
				$.toptip('请选择您的收货省市', 'error');
				return flase;
			}
			if(content.length>200 || content.length<20){
				$.toptip('描述最少20个字最多200字', 'error');
				return false;
			}
			request('api.weixin.info.submit',{info_type:info_type,title:title,contact_name:contact_name,contact_tel:contact_tel,num:num,area:area,area_code:area_code,content:content},function(data){
				base.lock=false;
				if(data.error){
					base.toast(data.error);
					return false;
				}
				base.toast('发布成功等待审核',function(){
					base.redirect(base.memberurl);
				});
			});
		});
});