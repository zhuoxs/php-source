$(document).ready(function(){

		base.request('api.weixin.member',{},function(data){
			//console.log(data);
			$('.member-info .real_name').text(data.account.real_name);
			$('.member-info .money').text(data.account.money);
			$('.member-info .header_img img').attr('src',data.account.header_img);
			base.inittabs('member');
			$('#charge').click(function(){
				$('#chargecontainer').popup();
			});
			var topay=base.query.get('pay');
			if(topay==1){
				$('#charge').click();
			}
			$('#freecharge').click(function(){
				pay($('#money').val());
			});
			$('#staticcharge a').click(function(){
				pay($(this).attr('data-money'));
			});
			$('#money').on('input',function(){
				if(parseInt(this.value)){
					//alert((parseInt(parseInt(this.value)/100)*30));
					$('.addmoney').text('送'+(parseInt(parseInt(this.value)/100)*10));
				}
				//alert(parseInt(parseInt(this.value)/100)*100+parseInt(this.value));
			});
			$('.qrcode').click(function(){
				base.request('api.weixin.qrcode',{},function(data){
					if(data.url){
						//$.alert('<img  style="width:100px;height:100px;" src="'+data.url+'" />');
						wx.previewImage({

	    					current: data.url,

	    					urls: [data.url]

						});
					}
					
				});
			});
			
		});
		function pay(money){
				base.request('api.weixin.pay',{'openid':base.storage.get('openid'),money:money},function(data){
					if(data.json){
		                var param={};
		                param.appId=data.json.appId;
		                param.timestamp=data.json.timeStamp;
		                param.nonceStr=data.json.nonceStr;
		                param.package=data.json.package;
		                param.signType='MD5';
		                param.paySign=data.json.paySign;
		                param.success=function(res){
		                	$.alert('充值成功');
		                };
		                param.cancel=function(res){
		                	$.alert('取消支付');
		                };
		                wx.chooseWXPay(param);
		            }
		            else{
		            	$.alert('接口异常');
		            }
		    	});
			}

});