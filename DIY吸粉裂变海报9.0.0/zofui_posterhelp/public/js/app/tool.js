	var tool = {
		size : {
			width : $(window).width(),
			height : $(window).height()
		},
		url : function(doo,opp){
			return window.sysinfo.siteroot+'app/index.php?i='+window.sysinfo.uniacid+'&c=entry&do='+doo+'&op='+opp+'&actid='+settings.actid+'&m=zofui_posterhelp';
		},
		ajax : function(url,type,datatype,data,succall,notModel,comcall){
			$.ajax({
				url : url,
				type : type,
				datatype : datatype,
				data : data,
				success : function(data){
					if(succall && datatype == 'json') succall($.parseJSON(data));
				},
				beforeSend : function(){
					if(!notModel) tool.showModal(true);
				},
				complete : function(){
					if(!notModel) tool.showModal(false);
					if(!notModel) if(comcall) comcall();
				}
			})
		},
		showModal : function(bool){
			if(bool){
				if($('#modal').length > 0){
					$('#modal').show();
				}else{
					var div = '<div id="modal" style="position:fixed;z-index:11112;top:0;left:0;width:100%;height:100%;background:rgba(255,255,255,0)">\
						<img style="position:absolute;top:40%;left:50%;width:1.5rem;margin-left:-1rem;background: #000;padding: 0.5rem;border-radius: 10px;" \
						src="./../addons/zofui_posterhelp/public/images/loading.gif"></div>';
					$('body').append(div);
				}
			}else{
				$('#modal').hide();
			}
		},
		alert : function(str,callfun){
			if($('#alert').length > 0){
				$('#alert #alertstr').text(str);
				$('#comfire').off('touchstart');
				$('#comfire').on('touchstart',function(e){
					$('#alert').hide();
					if( callfun ) callfun();
					e.preventDefault();
				});
				$('#alert').show();
			}else{
			var div = '<div id="alert" style="position:fixed;top:0;left:0;width:100%;height:100%;background: rgba(0,0,0,0.5);z-index:11111;font-size: 14px;">\
					<ul class="animatealert" style="box-shadow:0 2px 16px #000, 0 0 1px #ddd, 0 0 1px #ddd;width:80%;height:auto;background:#fff;border-radius:10px;position:absolute;top: 50%;left:10%;margin-top: -110px;">\
						<li style="height: auto;padding:20px;text-align: center;" id="alertstr">'+str+'</li>\
						<li style="height:40px;text-align:center;border-top:1px solid #C5C5C5;line-height:40px;padding-bottom:10px;color: #0894ec;font-size: 20px;" id="comfire">确定</li>\
					</ul>\
				</div>';
				$('body').append(div);
			}
			$('#comfire').off('touchstart');
			$('#comfire').on('touchstart',function(e){
				$('#alert').hide();
				if( callfun ) callfun();
				e.preventDefault();
			});
		},
		confirm : function(str,callfun){
			if($('#confirm').length > 0){
				$('#confirm #alertstr').text(str);
				$('#confirm').show();
				$('#confirm_comfire').off('touchstart');
				$('#confirm_comfire').on('touchstart',function(e){
					$('#confirm').hide();
					if( callfun ) callfun();
					e.preventDefault();
				});
				$('#confirm_cancel').off('touchstart');
				$('#confirm_cancel').on('touchstart',function(e){
					$('#confirm').hide();
					e.preventDefault();
				});	
			}else{
			var div = '<div id="confirm" style="position:fixed;top:0;left:0;width:100%;height:100%;background: rgba(0,0,0,0.5);z-index:11111;font-size: 14px;">\
					<ul class="animatealert" style="box-shadow:0 2px 16px #000, 0 0 1px #ddd, 0 0 1px #ddd;width:80%;height:auto;background:#fff;border-radius:10px;position:absolute;top: 50%;left:10%;margin-top: -110px;">\
						<li style="height: auto;padding:20px;text-align: center;" id="alertstr">'+str+'</li>\
						<li style="height:30px;text-align:center;padding-top: 5px;border-top:1px solid #C5C5C5;line-height:34px;padding-bottom:10px;color: #0894ec;font-size: 16px;">\
						<span id="confirm_cancel" style="display: inline-block;width: 50%;border-right: 1px solid #C5C5C5;">取消</span><span id="confirm_comfire" style="display: inline-block;width: 49%;">确定</span>\
						</li>\
					</ul>\
				</div>';
				$('body').append(div);
			}
			$('#confirm_comfire').off('touchstart');
			$('#confirm_comfire').on('touchstart',function(e){
				$('#confirm').hide();
				if( callfun ) callfun();
				e.preventDefault();
			});
			$('#confirm_cancel').off('touchstart');
			$('#confirm_cancel').on('touchstart',function(e){
				$('#confirm').hide();
				e.preventDefault();
			});			
		},
		updateTime : function () {
			var date = new Date();
			var time = date.getTime();  //当前时间距1970年1月1日之间的毫秒数 
			$(".lasttime").each(function(i){
				var endTime = $(this).attr('data-time') + '000'; //结束时间字符串
				var lag = (endTime*1 - time); //当前时间和结束时间之间的秒数	
				if(lag > 0){
					var second = Math.floor(lag/1000%60);     
					var minite = Math.floor(lag/1000/60%60);
					var hour = Math.floor(lag/1000/60/60%24);
					var day = Math.floor(lag/1000/60/60/24);
					second = second.toString().length == 2 ? second : '0'+second;
					minite = minite.toString().length == 2 ? minite : '0'+minite;
					hour = hour.toString().length == 2 ? hour : hour;
					day = day.toString().length == 2 ? day : day;
				}else{
					//location.href = tool.url('index','index');
				}
				$(this).find('.day').text(day);
				$(this).find('.hour').text(hour);
				$(this).find('.minite').text(minite);
				$(this).find('.second').text(second);				
			});
			setTimeout(function(){tool.updateTime()},1000);
		},
		toTop : function(){
			var html = '<a id="backTop" href="javascript:;" data-title="返回顶部" \
						style="border: 1px solid #fff;border-radius: 50%;display:none;cursor:pointer;position:fixed;text-decoration:none;\
						right:2rem;bottom:2rem;width:4.2rem;height:4.2rem;background: url(./../addons/zofui_posterhelp/public/images/top.png) no-repeat 1px 0;background-size:cover;background-color: #fff;"></a>';
			if( $('#backTop').length <= 0 ) $('body').append(html);
				
			$(window).scroll(function(){
				var viewheight = $(window).height();
				var top = $(window).scrollTop();
				if(top >= viewheight*1.5){
					$('#backTop').show();
				}else{
					$('#backTop').hide();
				}
			})

			$('body').off('touchstart','#backTop').on('touchstart','#backTop',function(e){
				$(window).scrollTop(0);
				e.preventDefault();
			})
		},
		regex : {
			tel : /^1[34578]\d{9}/
		},
		random : function(min,max){
			return min + Math.round(Math.random()*max);
		}
	};
