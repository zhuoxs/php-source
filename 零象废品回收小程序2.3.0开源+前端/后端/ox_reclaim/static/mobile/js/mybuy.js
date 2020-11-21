$(document).ready(function(){
	base.initlogin();
	base.ready=function(){
		base.inittabs('mybuy');
		var page_no=1;
		var page_size=8;
		var end=false;
		var status=-1;
		var keyword='';
		$('#searchInput').val(keyword);
		if(base.query.get('keyword')){
			keyword=base.query.get('keyword');
		}
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
			status=-1;
			keyword='';
			getlist(false);
			$('.loading').show();
		});
		getlist(false);
		$('.chance-xuanxiang').click(function(){
			$.actions({
				title:'筛选状态',
  				actions: [{
  					text:'全部',
  					onClick: function() {
    					status=-1;
    					page_no=1;
    					end=false;
    					keyword='';
    					getlist(false);
    				}
  				},{
    				text: "未处理",
    				onClick: function() {
    					status=0;
    					page_no=1;
    					end=false;
    					keyword='';
    					getlist(false);
    				}
  				},{
				    text: "联系中",
				    onClick: function() {
				    	status=1;
				    	page_no=1;
    					end=false;
    					keyword='';
    					getlist(false);
					}
				},{
					text: "已完成",
				    onClick: function() {
				    	status=2;
				    	page_no=1;
    					end=false;
    					keyword='';
    					getlist(false);
					}
				}]
			});
		});
		$('.bodys').on('click','.reply',function(){
			var id=$(this).attr('data-id');
			$.prompt("请输入您想反馈的内容",function(text) {
				base.request('api.weixin.mybuy.reply',{id:id,content:text},function(data){
					if(data.error){
						base.toast(data.error);
						return false;
					}
					base.toast('操作成功');
				});
			});
		});
		$('.bodys').on('click','.edit-status',function(){
			var id=$(this).attr('data-id');
			var status=parseInt($(this).attr('data-status'));
			$.actions({
				title:'备注状态',
  				actions: [{
    				text: "未处理",
    				className: (status==0?"color-danger":''),
    				onClick: function() {
    					if(status==0){
    						return false;
    					}
    					editstatus(id,0);
    				}
  				},{
				    text: "联系中",
				    className: (status==1?"color-danger":''),
				    onClick: function() {
				    	if(status==1){
    						return false;
    					}
    					editstatus(id,1);
					}
				},{
					text: "已完成",
					className: (status==2?"color-danger":''),
				    onClick: function() {
				    	if(status==2){
    						return false;
    					}
    					editstatus(id,2);
					}
				}]
			});
		});
		function editstatus(id,status){
			base.request('api.weixin.mybuy.status',{id:id,status:status},function(data){
				if(data.error){
					base.toast(data.error);
					return false;
				}
				$('#item-'+id).find('.wancheng').text(getstatus(status)).end().find('.edit-status').attr('data-status',status);

				base.toast('操作成功');
			});
		}
		function getstatus(status){
			if(status==0){
				return '未处理'
			}
			if(status==1){
				return '联系中'
			}
			if(status==2){
				return '已完成';
			}
		}
		function getlist(append){
			if(base.lock){
				return false;
			}
			if(end){
				return false;
			}
			base.lock=true;
			//alert(status);
			base.request('api.weixin.mybuy',{page_no:page_no,page_size:page_size,status:status,keyword:keyword},function(data){
				//alert(JSON.stringify(data));
				if(data.list){
					$('.no-data').hide();
					$('.bodys').show();
					var html=[];
					for(var i=0;i<data.list.length;i++){
						html.push('<li id="item-'+data.list[i].id+'"><div class="qiugou"><div class="qiugou"><a href="'+base.url+'details.html?id='+data.list[i].info.id+'">'+data.list[i].info.title+'</a></div><div class="wancheng chred">'+getstatus(data.list[i].status)+'</div></div><div><div class="ch-left">描述：</div><div>'+data.list[i].info.content+'</div></div><div ><div class="ch-left">地址：</div><div>'+data.list[i].info.area_province+' '+data.list[i].info.area_city+'</div></div><div><div class="ch-left">联系人：</div><div>'+data.list[i].info.contact_name+'</div></div><div><div class="ch-left">联系电话：</div><div><a  class="tel" href="tel:'+data.list[i].info.contact_tel+'">'+data.list[i].info.contact_tel+'</a></div></div><div><div class="ch-left">购买时间：</div><div>'+data.list[i].ctime+'</div></div><div><div class="ch-left">购买次数：</div><div>'+data.list[i].num+'次</div></div><div><div class="ch-left">商机价格：</div><div>'+(data.list[i].info.price)+'/次<b data-id="'+data.list[i].id+'" class="reply">反馈投诉</b></div></div></li>');
						//<img src="img/bianxie.png" data-status="'+data.list[i].status+'" data-id="'+data.list[i].id+'" class="edit-status" />
					}
					if(append){
						$('.bodys ul').append(html.join(''));
					}
					else{
						$('.bodys ul').html(html.join(''));
					}
					$(document.body).pullToRefreshDone();
					page_no++;
				}
				else{
					if(page_no==1){
						if(!append){
							$('.bodys ul').html('');
						}
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