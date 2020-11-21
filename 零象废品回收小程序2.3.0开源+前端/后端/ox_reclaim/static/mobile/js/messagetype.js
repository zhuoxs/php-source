$(document).ready(function(){
	base.initlogin();
	base.ready=function(){
		base.inittabs("messagetype");
		base.request('api.public.config',{type:'itemtype'},function(data){
			if(data.config){
				var config=JSON.parse(data.config);
				var html=[];
				for(var i=0;i<config.length;i++){
					html.push('<label class="weui-cell weui-check__label" for="s'+(11+i)+'"><div class="weui-cell__hd"><input type="checkbox" class="weui-check" value="'+(i+1)+'" name="item_type" id="s'+(11+i)+'" /><i class="weui-icon-checked"></i></div><div class="weui-cell__bd"><p>'+config[i]+'</p></div></label>');
				}
				$('#info_type').html(html.join(''));
				
				base.request('api.weixin.message.setting',{},function(res){
					if(res.setting && res.setting.item_type){
						var types=res.setting.item_type.split(',');
						for(var j=0;j<types.length;j++){
							$('input[name="item_type"][value="'+types[j]+'"]').prop('checked',true);
						}
					}
					console.log(res);
				});
			}
		});
		$('#submit').click(function(){
			var ids=[];
			$('input[name="item_type"]:checked').each(function(){
				ids.push(this.value);
			});
			if(ids.length==0){
				base.toast('至少选择一项');
				return false;
			}
			base.request('api.weixin.messagetype',{item_type:ids.join(',')},function(data){
				base.toast('保存成功');
			});
		});
	}
});