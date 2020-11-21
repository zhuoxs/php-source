require(['jquery','common','weixinJs'],function($,common,wxJs){
	
	var familyshop = {
		isGetPageed : false,
		getpageurl : common.createUrl('pagelist',initParams.op),
		pageparams : {
			'sortid' : '',
			'goodorder' : 'order',
			'updown' : 'desc',
			'isfirstcut' : '',
			'iscredit' : '',
			'isfreeexpress' : '',
			'iscard' : '',
			'search' : '',
			'page' : 1
		},
		init: {
			indexinit : function(){
				if($.inArray(initParams.op,['familygood','sysgood','intro','sort','fshop','fmember','flog','order']) >= 0 && !familyshop.isGetPageed) { //加载内容
					familyshop.isGetPageed = true;
					familyshop.getFirstPage();
					common.goToTop(); //回到顶部
				};
				if($.inArray(initParams.op,['sort']) >= 0) { //搜索商品
					$('form').submit(function(){  //监控提交表单，返回false阻止提交
						familyshop.pageparams.search = $('input[name=for]').val();
						familyshop.fn.resetPage();
						$("#search_bar").hide().prev().show();
						$('.out_search').show();
						return false;
					});
					$('body').on('click','#out_search',function(){ //退出搜索
						familyshop.pageparams.search = '';
						$('.out_search').hide();
						$("#search_bar").hide().prev().show();
						familyshop.fn.resetPage();
					});
					
				}
				
				if($.inArray(initParams.op,['fshop','sort','sysgood','flog']) >= 0) { //筛选
					$('.select .select_item_btn').click(function(){
					
						var thisclass = $(this);
						if(thisclass.find('span').hasClass('ti-angle-down')){
							$('.select .select_item_in').hide().prev().find('span').removeClass('ti-angle-up').addClass('ti-angle-down');
							thisclass.find('span').removeClass('ti-angle-down').addClass('ti-angle-up').parent().next().show();
						}else{
							familyshop.fn.hideSelect();
						}
					});
					$('body').click(function(e) { //点击相应位置隐藏筛选
						if(e.target.className != 'select_item_btn' && e.target.className != 'ti-angle-down' && e.target.className != 'ti-angle-up')
							if ( $('.select .select_item_in').is(':visible') ) familyshop.fn.hideSelect();
					});
				};
				if($.inArray(initParams.op,['herothis','herolast','herohis']) >= 0) { //顶部右上角下拉筛选
					$('#select_type').click(function(){
						$('.select_type_item').toggle();
					});
					$('body').click(function(e) { //点击相应位置隐藏筛选
						if(e.target.id != 'select_type')
							if ( $('.select_type_item').is(':visible') ) $('.select_type_item').hide();
					});
				};
			}
		},
		getFirstPage : function(){ //异步加载初始化页面
			common.Http('POST','json',familyshop.getpageurl,familyshop.pageparams,function(data){
				$(initParams.insertelem).append(data.data);
				common.squareImage('.nead_square_images img'); //处理图片
				common.lazyLoadImages(); //懒加载
				familyshop.pageparams.page ++ ;
				familyshop.fn.getPage();	//第一页加载完后再初始化加载方法			
			},function(){
				$('.page_item').append('<li id="page_before_show"><img src="../addons/recouse/images/loading.gif"></li>');
			},true,function(){
				$('#page_before_show').remove();
				
			});
		},		
		events:{
			'.sort_top a' : { //切换分类
				click : function(){
					$('.sort_top').find('.activity_bottom').removeClass('activity_bottom');
					$(this).find('li').addClass('activity_bottom');
					familyshop.pageparams.sortid = $(this).attr('data-id');
					familyshop.fn.resetPage();
				}
			},
			'.activity_select .select_body_item' : { //筛选活动
				click : function(){
					var type = $(this).attr('data-type');
					if(type == 'all'){
						familyshop.pageparams.isfirstcut = '';
						familyshop.pageparams.iscredit = '';						
						familyshop.pageparams.isfreeexpress = '';						
						familyshop.pageparams.iscard = '';
						$('.activity_select .font_ff5f27').not(':first').hide();
						$('.activity_select .font_ff5f27:first').show();
					}else{
						$('.activity_select .font_ff5f27:first').hide();
						if(familyshop.pageparams[type] == ''){
							familyshop.pageparams[type] = 1;
							$(this).find('.font_ff5f27').show();
						}else{
							familyshop.pageparams[type] = '';
							
							$(this).find('.font_ff5f27').hide();
						}						
					}			
					familyshop.fn.resetPage();
				}
			},
			'.order_btn' : {
				click : function(){
					var type = $(this).attr('data-type');
					var thisspan = $(this).find('span');
					if(thisspan.hasClass('ti-stats-down')){
						$(this).find('span').removeClass('ti-stats-down').addClass('ti-stats-up');
						familyshop.pageparams.updown = 'asc';
					}else{
						$(this).find('span').removeClass('ti-stats-up').addClass('ti-stats-down');
						familyshop.pageparams.updown = 'desc';
					}
					$('.order_btn').removeClass('font_ff5f27');
					$(this).addClass('font_ff5f27');
					familyshop.pageparams.order = type;
					familyshop.fn.resetPage();
				}
			},
			'#search_clear' : { //清除搜索内容
				click : function(){
					$('#search_input').focus().val('');
				}
			},
			'#showSearch' : { //显示搜索
				click : function(){
					$('#search_bar').show();
				}
			},
			'#search_cancel , #search_bar .weui_mask' : { //隐藏搜索
				click : function(){
					$('#search_bar').hide();
				}
			}			
		},
		fn : {
			hideSelect : function(){ //隐藏筛选
				$('.select .ti-angle-up').removeClass('ti-angle-up').addClass('ti-angle-down');
				$('.select .select_item_in').hide();
			},
			resetPage : function(){ //重置页面
				familyshop.pageparams.page = 1;			
				$(initParams.insertelem).empty();
				familyshop.getFirstPage();	
				
			},
			getPage : function(){ //加载页面
				common.getMoreData(initParams.insertelem,familyshop.pageparams.page,familyshop.getpageurl,familyshop.pageparams,function(){
					common.squareImage('.nead_square_images img'); //处理图片
					common.lazyLoadImages(); //懒加载
					familyshop.pageparams.page ++ ;
				});
			}
		}
	};
	
	
	common.init(familyshop);
});