$(document).ready(function(){
	base.initlogin();
	base.ready=function(){
		base.inittabs();
		var page_no=1;
		var page_size=8;
		var end=false;
		$(document.body).infinite(80).on('infinite',function(){
			if(!end){
				getlist(true);
			}
			else{
				$('.loading').hide();
			}
		});
		$(document.body).pullToRefresh();
		$(document.body).on("pull-to-refresh", function() {
			page_no=1;
			end=false;
			getlist(false);
			$('.loading').show();
		});
		getlist(false);
		function getlist(append){
			if(base.lock){
				return false;
			}
			if(end){
				return false;
			}
			base.lock=true;
			base.request('api.account.money',{page_no:page_no,page_size:page_size},function(data){
				if(data.list){
					$('.no-data').hide();
					var html=[];
					for(var i=0;i<data.list.length;i++){
						html.push('<li class="detali"><div><div>时间</div><div>'+data.list[i].ctime+'</div></div><div class="pp"><div class="deta-time">变动金额:<span>'+(data.list[i].type==2?'-':'')+data.list[i].money+'</span> </div><div class="deta-yue">余额: <span>'+data.list[i].remain_money+'</span></div></div><div class="beizhu"><div>备注</div><div>'+data.list[i].memo+'</div></div></li>');
					}
					if(append){
						$('.bodys ul').append(html.join(''));
					}
					else{
						$('.bodys ul').html(html.join(''));
					}
					$(document.body).pullToRefreshDone();
					page_no++;
					if(data.total<page_size){
						$('.loading').hide();
					}
				}
				else{
					if(page_no==1){
						//base.redirect(base.memberurl);
						$('.no-data').show();
						$('.bodys').hide();
					}
					end=true;
					$('.loading').hide();
					
				}
				base.lock=false;
			});
		}
	}
});