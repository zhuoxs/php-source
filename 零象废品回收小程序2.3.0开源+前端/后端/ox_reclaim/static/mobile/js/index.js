$(document).ready(function(){
	base.initlogin();
	base.ready=function(){
		base.inittabs('home');
		var loading = false;
		var page_no=1;
		var page_size=8;
		var keyword='';
		var area_code=0;
		var info_type=-1;
		if(base.query.get('keyword')){
			keyword=base.query.get('keyword');
		}
		if(base.query.get('area_code')){
			area_code=base.query.get('area_code');
		}
		if(base.query.get('info_type')){
			info_type=base.query.get('info_type');
		}
		var end=false;
		try{
			$(document.body).infinite(80).on('infinite',function(){
				if(!end){
					getlist(true);
				}
				else{
					$('.loading').hide();
				}
			});
		}
		catch(e){
			console.log(e);
		}
		$('.totop').click(function(){
			$(window).scrollTop(0);
		});
		$(window).scroll(function(){
			sessionStorage.scrolltop=($(window).scrollTop());
			if(sessionStorage.scrolltop>0){
				$('.totop').show();
			}
			else{
				$('.totop').hide();
			}
		});
		try{
			$(document.body).pullToRefresh();
		}
		catch(e){
			console.log(e);
		}
		$(document.body).on("pull-to-refresh", function() {
			page_no=1;
			end=false;
			code=0;
			keyword='';
			info_type=-1;
			getlist(false);
			$('.loading').show();
		});
		if(sessionStorage.scrolltop>0 && sessionStorage.page_no>0){
			getlist(false,sessionStorage.page_no);
		}
		else{
			getlist(false);
		}
		function getlist(append,last_page_no){
			if(loading){
				return;
			}
			if(end){
				return false;
			}
			loading = true;
			sessionStorage.page_no=page_no;
			var query={page_no:page_no,page_size:page_size,keyword:keyword,area_code:area_code,info_type:info_type};
			if(last_page_no>0){
				sessionStorage.page_no=last_page_no;
				page_no=last_page_no;
				query.page_no=1;
				query.page_size=last_page_no*page_size;
			}
			base.request('api.weixin.info.list',query,function(data){
				if(data.list){
					var html=[];
					for(var i=0;i<data.list.length;i++){
						html.push('<li id="list-item-'+data.list[i].info_id+'"><a href="http://weixin.xbdbld.com/details.html?id='+data.list[i].info_id+'"><i>商机</i><div class="in-lift"><h2 class="h2">'+data.list[i].title+'</h2><div class="in-liftp"><div><span>'+data.list[i].content+'</span></div></div><div class="intime"><div>'+data.list[i].area_province+data.list[i].area_city+'</div><div>'+data.list[i].ctime+'</div></div></div><div class="in-right"><div class="circle" data-percent="'+(data.list[i].total-data.list[i].remain)/data.list[i].total*100+'"></div><div class="in-surplus">剩余<span>'+data.list[i].remain+'</span>次机会 </div></div></a></li>');
						//html.push('<li id="list-item-'+data.list[i].info_id+'"><a href="http://weixin.xbdbld.com/details.html?id='+data.list[i].info_id+'"><i>商机</i><div class="in-lift"><h2 class="h2">'+data.list[i].title+'</h2><div class="intime"><div>'+data.list[i].area_province+data.list[i].area_city+'</div><div>'+data.list[i].ctime+'</div></div></div></a></li>');
					}
					if(append){
						$('.inquiry-ul').append(html.join(''));
					}
					else{
						$('.inquiry-ul').html(html.join(''));
					}
					initcircle();
					try{
						$(document.body).pullToRefreshDone();
					}
					catch(e){
						console.log(e);
					}
					page_no++;
					if(data.total<page_size){
						$('.loading').hide();
					}
					$('.no-data').hide();
					if(last_page_no>0){
						$(window).scrollTop(sessionStorage.scrolltop);
					}
				}
				else{
					end=true;
					$('.loading').hide();
					if(page_no==1){
						$('.inquiry-ul').html('');
						$('.no-data').show();
					}
				}
				loading=false;
			});
		}
		function initcircle(){
			$('.circle').each(function(){
				var value=parseInt($(this).attr('data-percent'));
				var ready=$(this).attr('data-ready');
				if(!ready){
					try{
						$(this).circleChart({
							value: value,
							startAngle: 180,
							animate: false,
							text: 0 + '%',
							color:'#09bb07',
							onDraw: function(el, circle){
								$(".circleChart_text", el).html(Math.round(circle.value) + '%');
							}
						});
						$(this).attr('data-ready',1);
					}
					catch(e){
						console.log(e);
					}
				}
			});
		}
		base.request('api.public.config',{type:'infotype'},function(data){
			if(data.config){
				var config=JSON.parse(data.config);
				var html=[];
				html.push('<label class="weui-cell weui-check__label" for="info_type_-1"><div class="weui-cell__hd"><input type="radio" class="weui-check" name="info_type" value="-1" id="info_type_-1" checked="checked"><i class="weui-icon-checked"></i></div><div class="weui-cell__bd"><p>全部商机</p></div></label>');
				for(var i=0;i<config.length;i++){
					html.push('<label class="weui-cell weui-check__label" for="info_type_'+i+'"><div class="weui-cell__hd"><input type="radio" class="weui-check" name="info_type" value="'+(i+1)+'" id="info_type_'+i+'"><i class="weui-icon-checked"></i></div><div class="weui-cell__bd"><p>'+config[i]+'</p></div></label>');
				}
				$('#info_type').html(html.join(''));
			}
		});
		$('.advance').click(function(){
			base.redirect('search.html');
		});
		
		
	}

});