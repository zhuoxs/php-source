$(document).ready(function(){
	base.initlogin();
	base.ready=function(){
		base.inittabs();
		var id=parseInt(base.query.get('id'));
		if(!id){
			base.gohome();
		}
		base.loading('正在加载');
		base.request('api.weixin.info.detail',{id:id,others:1},function(data){
			if(data.error){
				base.toast(data.error,function(){
					base.gohome();
				});
				return false;
			}
			base.closeloading();
			base.share.title=data.info.title;
			base.share.desc=data.info.content;
			base.share.url=base.url+'details.html?id='+id;
			base.initshare();
			$('.data-title').text(data.info.title);
			$('.data-ctime').text(data.info.ctime);
			$('.data-content').text(data.info.content);
			$('.data-num').text(data.info.num);
			$('.data-contact_name').text(data.info.contact_name);
			if(data.info.contact_tel.indexOf('*')==-1){
				$('.data-contact_tel').html('<a href="tel:'+data.info.contact_tel+'">'+data.info.contact_tel+'</a>');
			}
			else{
				$('.data-contact_tel').text(data.info.contact_tel);
			}
			$('.data-address').text(data.info.address);
			$('.data-has').text(data.info.total-data.info.remain);
			$('.data-total').text(data.info.total);
			$('.data-remain').text(data.info.remain);
			$('.data-price').text(data.info.price+'元/条');
			$('.account-money').text(data.account_money);
			$('.data-area').text(data.info.area_province+'/'+data.info.area_city);
			$('.detail-progress .js_progress').css('width',(data.info.total-data.info.remain)/data.info.total*100+'%')
			if(data.info.status==1 && data.info.finish==0 && data.info.remain>0){
				$('.disabled-status').hide();
			}
			else{
				$('.normal-status').hide();
			}
			if(data.info.buy&&data.info.file){	
				$('#file').append('<a style="color:#5950cb;" href="'+data.info.file+'" target="_blank">查看</a>').show();
			}
			if(data.info.finish==1){
				$('.disabled-status a').text('用户反馈已经完成');
			}
			if(data.record){
				$('.data-norecord').hide();
				var html=[];
				for(var i=0;i<data.record.length;i++){
					html.push('<li><div>'+data.record[i].account_name+'</div><div>'+data.record[i].ctime+'</div><div>'+data.record[i].num+'</div></li>');
				}
				$('.record ul').append(html.join(''));
			}
			else{
				$('.record').hide();
			}
			if(data.others){
				var html=[];
				for(var i=0;i<data.others.length;i++){
					html.push('<li><div class="xunpan-top"><div class="xunpan-top-title"><a  class="px13" href="'+base.url+'details.html?id='+data.others[i].id+'">'+data.others[i].title+'</a></div><div class="xunpan-top-time px12">'+data.others[i].ctime+'</div></div><div class="weui-progress"><div class="weui-progress__bar"><div class="weui-progress__inner-bar js_progress" style="width: '+((data.others[i].total-data.others[i].remain)/data.others[i].total)*100+'%;"></div></div><i class="weui-icon-cancel">('+(data.others[i].total-data.others[i].remain+'/'+data.others[i].total)+')</i></li>');
				}
				$('.data-others .xunpan ul').html(html.join(''));
			}
			else{
				$('.data-others').hide();
			}
			//添加接单事件
			$('#shurmoney').on('input',function(){
				if(parseInt(this.value)){

					$('.chongzhi .colorred').text(parseInt(parseInt(this.value)/100)*10+parseInt(this.value));
				}
				//alert(parseInt(parseInt(this.value)/100)*100+parseInt(this.value));
			});
			$('.normal-status a').click(function(){
				if($(this).hasClass('detbtn')){
					buy(true);
				}
				else{
					buy();
				}
			});
			/*
			if(!data.info.buy){
				$('#progress').hide();
				$('#desc').html('<p style="color:#000;">充值后可见</p>');
				$('#remainnum').hide();
				$('.record').hide();
				$('.disabled-status').hide();
				$('.normal-status').show();
			}*/
			var amount=0;
			var buynum=1;
			$('#dobuy').click(function(){
				var money=parseInt($('#shurmoney').val());
				if(money>0){
					pay(money);
				}
			});
			function refresh(){
				base.loading('正在加载');
				base.request('api.weixin.info.detail',{id:id},function(data){
					if(data.error){
						base.toast(data.error,function(){
							base.gohome();
						});
						return false;
					}
					base.closeloading();
					$('.data-title').text(data.info.title);
					$('.data-ctime').text(data.info.ctime);
					$('.data-content').text(data.info.content);
					$('.data-num').text(data.info.num);
					$('.data-contact_name').text(data.info.contact_name);
					if(data.info.contact_tel.indexOf('*')==-1){
						$('.data-contact_tel').html('<a href="tel:'+data.info.contact_tel+'">'+data.info.contact_tel+'</a>');
					}
					else{
						$('.data-contact_tel').text(data.info.contact_tel);
					}
					$('.data-address').text(data.info.address);
					$('.data-has').text(data.info.total-data.info.remain);
					$('.data-total').text(data.info.total);
					$('.data-remain').text(data.info.remain);
					$('.data-price').text(data.info.price+'元/条');
					$('.account-money').text(data.account_money);
					$('.data-area').text(data.info.area_province+'/'+data.info.area_city);
					$('.detail-progress .js_progress').css('width',(data.info.total-data.info.remain)/data.info.total*100+'%')
					if(data.info.status==1 && data.info.finish==0 && data.info.remain>0){
						$('.disabled-status').hide();
						$('.normal-status').show();
					}
					else{
						$('.normal-status').hide();
						$('.disabled-status').show();
					}
					if(data.info.finish==1){
						$('.disabled-status a').text('用户反馈已经完成');
					}
					if(data.record){
						$('.data-norecord').hide();
						var html=[];
						for(var i=0;i<data.record.length;i++){
							html.push('<li><div>'+data.record[i].account_name+'</div><div>'+data.record[i].ctime+'</div><div>'+data.record[i].num+'</div></li>');
						}
						$('.record .falst-div').siblings().remove().end().after(html.join(''));
						$('.record').show();
					}
					if(data.info.buy&&data.info.file){
						
						$('#file').append('<a  style="color:#5950cb;" href="'+data.info.file+'" target="_blank">查看</a>').show();
					}
					/*
					if(!data.info.buy){
						$('#progress').hide();
						$('#desc').html('<p style="color:#000;">充值后可见</p>');
						$('#remainnum').hide();
						$('.record').hide();
						$('.disabled-status').hide();
						$('.normal-status').show();
					}*/
					
				});
			}
			function pay(money){
				if(base.lock){
					return false;
				}
				base.lock=true;
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
		                	//alert(JSON.stringify(res));
		                	//if((res['err_msg']&&res['err_msg'].indexOf('ok')>0) || (res['errMsg']&&res['errMsg'].indexOf('ok')>0)){
		                		if($('#payandbuy').prop('checked')){
		                			gobuy(data.info.id,buynum);
		                		}
		                		else{
									base.toast('充值成功',function(){
										document.location.reload();
									});
								}
		                    //} 
		                    //else{
		                      //  $.alert(res['err_msg'] || res['errMsg']);
		                    //} 
		                    base.lock=false;   
		                };
		                param.cancel=function(res){
		                	$.alert('取消支付');
		                	base.lock=false;
		                };
		                wx.chooseWXPay(param);
		            }
		            else{
		            	base.lock=false;
		            	$.alert('接口异常');
		            }
		    	});
			}
			function gobuy(id,num){
				if(base.lock){
					return false;
				}
				$.closePopup();
				base.lock=true;
				base.request('api.weixin.info.buy',{id:id,num:num},function(data){
					//alert(JSON.stringify(data));
					base.lock=false;
					if(data.error){
						base.toast(data.error,function(){
							refresh();
						});
						return false;
					}
					base.toast('购买商机成功',function(){
						refresh();
						//base.redirect(base.url+'mybuy.html');
					});
				});
			}
			function buy(all){
				if(all){
					buynum=data.info.remain;
					amount=data.info.remain*data.info.price;
					$('.info-amount').text(data.info.remain*data.info.price);
				}
				else{
					amount=data.info.price;
					buynum=1;
					$('.info-amount').text(data.info.price);
				}
				if(parseFloat(parseFloat(amount).toFixed(2))<=parseFloat(parseFloat(data.account_money).toFixed(2))){
					$.confirm({
						title: '提示',
						text: '确认购买该商机？',
						onOK: function () {
							gobuy(data.info.id,buynum);
						}
					});
					
				}
				else{
					$('#button').popup();
				}
			}
		});
		$('.close-popup').click(function(){
			$.closePopup();
		});
	}
});