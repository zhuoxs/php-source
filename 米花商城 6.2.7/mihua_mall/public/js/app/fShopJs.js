$(function () {
  'use strict';
	
	var config = {
		loading : false,
		sort : {
			sortid : '',
			goodorder : 'order',
			updown : 'desc',
			isfirstcut : '',
			iscredit : '',
			isfreeexpress : '',
			iscard : '',
			search : initParams.forstr,
			page : 1,
			isinit : false,
			isend : false,
			op : 'sort'
		},
		user : {
			page : 1,
			isinit : false,
			isend : false,
			op : initParams.op,
			status : initParams.status,
			onlygroup : 0
		}
	}
	
	// ///////商品
	var good = {
		params: {
			commentpage:1,
			buytype : '',
			commentisend : false,
			commenttype : 'all',
			isallow : true,
			
		},
		init: {
			indexinit : function(){ 
				good.fn.setValue(); //初始赋值
				if(initParams.deal == 'newgroup') $('.group_buy_btn').trigger('click'); //如果是新开一团
				if(initParams.groupid) $('#joingroup').trigger('click'); //如果是参团
				common.updateTime();//处理时间
			}
		},
		events:{
			'.detail_btn' : { //显示相应详情
				click : function(){
					good.fn.changeDetailItem($(this));
				}
			},
			'.comment_item img' : { //预览图片
				click : function(){
					var current = $(this).attr('src'),
						urls = [];
					$('.comment_images img').each(function(){
						urls.push($(this).attr('src'));
					});
					wxJs.preViewsImages(current,urls);
				}
			},			
			'.more' : {
				click : function(){
					good.fn.getMoreComment();
				}
			},
			'.buy_btn' : {
				click : function(){
					var type = $(this).attr('data-type');
					good.params.buytype = type;
					$('.buy_item_img img').show();
					
					good.fn.changePrice($('input[name=rulepro]:checked').parent());
					if(good.params.goodid != $('input[name="goodid"]').val()) good.fn.setValue(); //重新赋值，解决返回列表再进入商品页面参数不改变的情况。
					common.isShowSheet(this,'#sideup_buy');
				}
			},
			'#sideup_buy #actionsheet_cancel , #sideup_buy #mask' : { //隐藏缩略图片
				click : function(){
					$('.buy_item_img img').hide();
				}
			},
			'.buy_rule .buy_rule_item label' : { //选择规格
				click : function(){
					var thisclass = $(this);
					thisclass.parent().find('.font_activity').removeClass('font_activity');
					thisclass.find('span').addClass('font_activity');
					if(good.params.goodtype == 2){ //如果是不同价格的商品，改变价格。
						good.fn.changePrice($(this));
					}
					
				}
			},
			'#buy_confirm' : {  //确定下单
				click : function(){

					if(good.params.buytype == ''){
						common.alert('请关闭后重新选择下单方式。');return false;
					}
					var data = {
						number : $('input[name=buynumber]').val()*1,
						status : good.params.goodstatus,
						groupid : initParams.groupid,
						gid : good.params.goodid,
						goodtype : good.params.goodtype,
						stock : good.params.stock,
						buytype : good.params.buytype
					};
					if(data.goodtype > 0){
						if($('.buy_rule_item').length != $('.buy_rule_item .font_activity').length){
							common.alert('您还有规格没有选择');return false;
						}
					}
					
					data.rule = {};
					$('.buy_rule_item input:checked').each(function(){ //处理规格
						if(data.goodtype == 1){
							var name = $(this).parents('.buy_rule_item').find('.rule_name').text();
							data.rule[name] = $(this).val();
						
						}else if(data.goodtype == 2){
							data.rule['name'] = $(this).val();
						}
					});
					if(data.number <= 0 || data.number > data.stock || !common.verify('number','int',data.number)){
						common.alert('选择的数量不是正确的数值');return false;
					}
					if(data.status == 1){
						common.alert('当前商品已下架，不能下单');return false;
					}
		
					common.Http('post','html',common.createUrl('ajaxdeal','buygood'),data,function(data){
						if(data == '4'){
							common.alert('已加入购物车');
							$('#sideup_buy #actionsheet_cancel').triggerHandler('click');
							$('.buy_item_img img').toggle();
						}else if(data == '5') {
							location.href = common.createUrl('confirm','confirm');
						}else{
							common.alert(data);
						}
					},'',false);
					
				}
			},
			'.select_good_num span' : { //加减
				touchstart : function(){
					common.changeNumberBtn($(this));
				}
			},
			'input[name="buynumber"]' : { //直接编辑
				change : function(){
					common.changeNumberEdit($(this));
				}
			},
			'#good_foot_back' : { //返回
				click : function(){
					$.router.back();
				}
			},
			'.comment_type span' : { //切换评价类型
				click : function(){
					if(!good.params.isallow) return false;
					good.params.isallow = false;
					$(this).siblings('.comment_type_activity').removeClass('comment_type_activity');
					$(this).addClass('comment_type_activity');
					good.params.commenttype = $(this).attr('data-type');
					good.fn.resetCommentType();
				}
			}
		},
		fn:{
			changeDetailItem : function(elemt){ //切换详情内容
				var showtype = elemt.attr('data-type');
				good.fn.getDetailContent(showtype,elemt);//初始化内容
				
				$('.detail_item').hide();
				$('.'+showtype).show();
				$('.detail_btn_list li').removeClass('activity_bottom');
				$('.'+showtype+'_bot').addClass('activity_bottom');
				
				if (!$('#sideup_gooddetail #mask').is('visible')) common.isShowSheet(this,'#sideup_gooddetail'); //是否已显示
			},
			getDetailContent : function(showtype,elemt){ //加载内容
				if(showtype == 'detail_body' && $('.detail_body').html() == ''){
					var content = common.htmlspecialchars_decode(elemt.attr('data-content'));
					$('.detail_body').html(content);
				}
				if(showtype == 'comment_body' && $('.comment_list').html() == ''){
					good.fn.getMoreComment();
				}
			},
			getMoreComment : function(){ //查询更多评论内容
				if(good.params.commentisend) return false;
				common.Http('post','json',common.createUrl('pagelist','goodcomment'),{goodid:good.params.goodid,page:good.params.commentpage,type:good.params.commenttype},function(data){
					good.params.commentpage++;
					if(data.status == 'ok'){
						$('.comment_list').append(data.data);
						$('.more').show();
					}else{
						good.params.commentisend = true;
						$('.more').html('<div class="get_more_loading">已无更多内容</div>').show();
					}
				},function(){
					$('.comment_list').append('<div id="get_more_loading" class="get_more_loading"><img src="../addons/zofui_task/public/images/loading.gif"> 正在加载</div>');
					$('.more').hide();
					good.params.isallow = true; //完了后允许点击切换
				},true,function(){
					$('#get_more_loading').remove();
				});				
			},
			changePrice : function(elemt){ //当是不同规格的价格时，切换下单方式的时候，改变价格
				//var thisclass = $('input[name=rulepro]:checked').parent();
				if(elemt.length > 0){ //如果已选择规格
					var nowprice = elemt.attr('data-now')*1,
						groupprice = elemt.attr('data-group')*1;				
				}else{ //还没选择规格
					var nowprice = good.params.goodprice,
						groupprice = good.params.goodgroupprice;		
				}
				
				if(good.params.buytype == 'single' || good.params.buytype == 'cart'){
					$('#buy_price_item span').text(nowprice+' 元');
				}else if(good.params.buytype == 'group' || good.params.buytype == 'joingroup'){
					$('#buy_price_item span').text(groupprice+' 元');
				}else{
					common.alert('出现异常，请关闭后重新选择');
				}	

			},
			setValue : function(){
				good.params.goodtype = $('input[name=goodtype]').val()*1;
				good.params.goodstatus = $('input[name=goodstatus]').val()*1;
				good.params.goodid = $('input[name="goodid"]').val();
				good.params.goodprice = $('input[name=goodprice]').val()*1;
				good.params.goodgroupprice = $('input[name=goodgroupprice]').val()*1;
				good.params.goodstock = $('input[name=goodstock]').val()*1; 
			},
			resetCommentType : function(){
				good.params.commentisend = false;
				good.params.commentpage = 1;
				$('.comment_list').empty();
				$('.more').html('<span class="look_more">查看更多</span>');
				good.fn.getMoreComment();
			}
		}
		
	};		
	
	
	//顶部搜索筛选等,在sort，fshop页面
	var topSelect = {
		init: {
			initfun : function(){
				common.goToTop('content'); //回到顶部
				
				$('body').on('click',function(e) { //点击相应位置隐藏筛选
					if(e.target.id != 'select_type')
						if ( $('.select_type_item').css('display') == 'block') $('.select_type_item').hide();
				});
				
				$('body').on('click',function(e) { //点击相应位置隐藏中间筛选
					if(e.target.className != 'select_item_btn' && e.target.className != 'ti-angle-down' && e.target.className != 'ti-angle-up'){
						$('.select .select_item_in').each(function(){
							if($(this).css('display')  != 'none') topSelect.fn.hideSelect();
						});
					}
				});				
			}
		},		
		events:{
			'#out_search' : { //退出搜索
				click : function(){
					config.sort.search = '';
					$('.out_search').hide();
					$("#search_bar").hide().prev().show();
					topSelect.fn.resetPage();
				}
			},			
			'.page' : { //监控提交表单来搜索，返回false阻止提交
				submit : function(){
					config.sort.search = $('input[name=for]').val();
					topSelect.fn.resetPage();
					$("#search_bar").hide().prev().show();
					$('.out_search').show();
					return false;
				}
			},				
			'.select .select_item_btn' : { //排序
				click : function(){
					var thisclass = $(this);
					if(thisclass.find('span').hasClass('ti-angle-down')){
						$('.select .select_item_in').hide().prev().find('span').removeClass('ti-angle-up').addClass('ti-angle-down');
						thisclass.find('span').removeClass('ti-angle-down').addClass('ti-angle-up').parent().next().show();
					}else{
						topSelect.fn.hideSelect();
					}
				}
			},				
			'#select_type' : { //顶部右上角下拉筛选
				click : function(){
					$('.select_type_item').toggle();
				}
			},			
			'.sort_top li' : { //切换分类 activity_bottom
				click : function(){
					$('.sort_top').find('.activity_bottom').removeClass('activity_bottom');
					$(this).find('span').addClass('activity_bottom');
					config.sort.sortid = $(this).attr('data-id');
					topSelect.fn.resetPage();
				}
			},
			'.activity_select .select_body_item' : { //筛选活动
				click : function(){
					var type = $(this).attr('data-type');
					if(type == 'all'){
						config.sort.isfirstcut = '';
						config.sort.iscredit = '';						
						config.sort.isfreeexpress = '';						
						config.sort.iscard = '';
						$('.activity_select .font_ff5f27').not('first').hide();
						$('.activity_select .font_ff5f27').first().show();
					}else{
						$('.activity_select .font_ff5f27').first().hide();
						if(config.sort[type] == ''){
							config.sort[type] = 1;
							$(this).find('.font_ff5f27').show();
						}else{
							config.sort[type] = '';
							
							$(this).find('.font_ff5f27').hide();
						}						
					}			
					topSelect.fn.resetPage();
					
				}
			},
			'.order_btn' : {
				click : function(){
					var type = $(this).attr('data-type');
					var thisspan = $(this).find('span');
					if(thisspan.hasClass('ti-stats-down')){
						$(this).find('span').removeClass('ti-stats-down').addClass('ti-stats-up');
						config.sort.updown = 'asc';
					}else{
						$(this).find('span').removeClass('ti-stats-up').addClass('ti-stats-down');
						config.sort.updown = 'desc';
					}
					$('.order_btn').removeClass('font_ff5f27');
					$(this).addClass('font_ff5f27');
					config.sort.order = type;
					topSelect.fn.resetPage();
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
				$('.list_container').empty();
				config.sort.isend = false;
				config.sort.page = 1;
				$.refreshScroller();
				common.getPage(config.sort,function(data){});
				common.goToTop(); //回到顶部
			}
		}
		
	}
	
	/////////////分类
	var sort = {
		init: {
			initfun : function(){
				common.goToTop(); //回到顶部
			}
		},		
		events:{		
		},
		fn : {
		}
	};	
	
	
	// //////////////购物车
	var cart = {
		params: {
			dealtype : '',
			id : '',
			data : []
		},
		init: {
			init :function (){
				cart.fn.initCartMoney();
			}
		},
		events:{
			'.cart_delete' : { //删除一个
				click : function(){
					cart.params.dealtype = 'delete';
					cart.params.id = $(this).attr('data-id')*1;;
					cart.fn.dealCart('确定要从购物车中删除此商品吗？',$(this));
				}
			},
			'.select_good_num span' : { //加减
				touchstart : function(){
					common.changeNumberBtn($(this));
					cart.fn.initCartMoney();
				}
			},
			'input[name="buynumber"]' : { //直接编辑
				change : function(){
					common.changeNumberEdit($(this));
					cart.fn.initCartMoney();
				}
			},
			'#clear_all' : { //清空
				click : function(){
					cart.params.dealtype = 'clearall';
					if($('.cart_good_box').length > 0) cart.fn.dealCart('确定要清空购物车吗？',$(this));
				}
			},
			'#to_confirm' : {
				click : function(){
					if($('.cart_good_box').length > 0){
						cart.params.data = [];
						$('.cart_good_box').each(function(index,elements){
							var data = {};
							data.gid = $(this).find('input[name=gid]').val();
							data.number = $(this).find('input[name=buynumber]').val();
							cart.params.data.push(data);
						});
						common.Http('post','html',common.createUrl('ajaxdeal','cartconfirm'),cart.params,function(data){
							if(data == 1){
								location.href = common.createUrl('confirm','confirm');
							}else{
								common.alert(data);
							}
							
						},'',false);						
					}
				}
			}
		},
		fn:{
			dealCart : function(str,elements){
				common.confirm('提示',str,function(){
					common.Http('post','html',common.createUrl('ajaxdeal','cart'),cart.params,function(data){
						if(data == 1){
							if(cart.params.dealtype == 'delete'){
								elements.parents('.cart_good_box').remove();
								common.alert('已删除');
								cart.fn.initCartMoney();
							}
							if(cart.params.dealtype == 'clearall'){
								$('.cart_good_list').remove();
								common.alert('已清空');
								cart.fn.initCartMoney();
							}
							if($('.cart_good_box').length <= 0){ //没有商品以后的提示
								$('.cart_bottom_box').hide();
								$('.cart_is_empty').show();
							}							
						}else{
							common.alert('出现异常情况');
						}
						
					},'',false);
					
				});
			},
			initCartMoney : function(){
				var flagmoney = 0;
				var flagnum = 0;
				$('.cart_good_box').each(function(){
					var thisprice = $(this).attr('data-price')*1;		
					var thisnum = $(this).find('input[name="buynumber"]').val()*1;
					flagnum += thisnum;
					flagmoney += thisprice*thisnum;
				});

				$('#total_money').text('￥'+flagmoney.toFixed(2));
				$('#total_number').text('（'+flagnum+'）');
			}			
		}
		
	};	
	
	
	var confirm = {
		init: {
			init : function(){
			}
		},
		events:{
			'.confirm_address' : { //选择微信地址
				click : function(){
					wxJs.openAddress(function(res){
						var data = {
							name : res.userName,
							tel : res.telNumber,						
							province : res.provinceName,
							city : res.cityName,
							dist : res.countryName,
							street : res.detailInfo	
						}
						var str = '<p>'+data.name+' '+data.tel+'</p>'
								  +'<p class="font_13px_999">'+data.province+' '+data.city+' '+data.dist+' '+data.street+'</p>'
								  +'<input name="address" value="'+data.province+','+data.city+','+data.dist+','+data.street+'" type="hidden"><input name="province" type="hidden" value="'+data.province+'"><input name="tel" type="hidden" value="'+data.tel+'"><input name="name" type="hidden" value="'+data.name+'">';
						$('.confirm_address_in').html(str);
						var cardid = $('input[name=checkedcard]:checked').val();
						confirm.fn.changeParamsFunc(cardid);
					});
				}
			},
			'#to_select_card' : { //去选择优惠券
				click : function(){
					common.isShowSheet(this,'#sideup_card');
				}
			},
			'.activity_checked_card' : { //选择相应的优惠券
				click : function(){
					var cardid = $(this).find('input[name=checkedcard]').val();
					confirm.fn.changeParamsFunc(cardid);
					
				}
			},
			'select[name=credit]' : {
				change : function(){
					var cardid = $('input[name=checkedcard]:checked').val();
					confirm.fn.changeParamsFunc(cardid);
				}
			},
			'#gotoback' : {
				click : function(){
					$.router.back();
				}
			},
			'input[name=paygood]' : {
				click : function(){
					var address = $('input[name=address]').val(),
						province =  $('input[name=province]').val();
					if(address == undefined || address == '' || province == undefined || province == ''){
						common.alert('您还没有选择收货地址');return false;
					}
				}
			}
		},
		fn:{
			changeParamsFunc : function(cardid){ //选择地址，卡券等重置参数
				var postdata = {
					cardid : cardid,
					credit : $('select[name=credit]').val(),
					province : $('input[name=province]').val()
				};

				common.Http('post','json',common.createUrl('ajaxdeal','selectcard'),postdata,function(data){
					if(data.status == 1){
						$('#total_fee').text(data.totalmoney[1]); //总金额
						if(data.totalcardcountmoney*1 > 0){
							$('.activity_card_notice').html('优惠<font class="font_ff5f27">'+data.totalcardcountmoney+'</font>元');
						}else if(data.iscard == 1 && $('#to_select_card').length > 0){ //以此判断是否有券可用
							$('.activity_card_notice').text('选择优惠券');
						}else{
							$('.activity_card_notice').text('不可使用');
						}
						if(data.minuscreditmoney >0){
							$('.activity_credit_notice').html('优惠<span class="font_ff5f27">'+data.minuscreditmoney+'</span>元');
						}else{
							$('.activity_credit_notice').text('不可抵扣');
						}
						$('.confirm_goods').each(function(){ //各个商品
							var thisclass = $(this);
							var id = thisclass.attr('data-id');
							
							for(var t in data.goodinfo){
								if(data.goodinfo[t].id == id){
									if(data.goodinfo[t].buyexpressmoney*1 > 0){
										thisclass.find('.good_item_express').text(data.goodinfo[t].buyexpressmoney);
									}else{
										if(data.goodinfo[t].buyfreeexpressmoney*1 > 0){
											thisclass.find('.good_item_expressa').text('包邮');
											thisclass.find('.good_item_express').text('(免'+data.goodinfo[t].buyfreeexpressmoney+'元运费)');
										}else{
											thisclass.find('.good_item_expressa').text('包邮');
										}
									}
									thisclass.find('.good_item_toal').text(data.goodinfo[t].buynumber*data.goodinfo[t].buyprice + data.goodinfo[t].buyexpressmoney*1);
								}
								
							}
						});
						
						
					}else{
						common.alert('出现异常，请返回重新选择商品');
					}
					$('#sideup_card #actionsheet_cancel').trigger('click');
				});
			}
		}
		
	};		
	
	var user = {
		params: {
			isexchange : false,
			isclick : false,
			needdeletecomment : {} //需要删除的评价按钮
		},
		init: {
			indexuser : function(){ 
				common.uploadImageByWxJs(5);
				common.deleteImagesInWxJs();
				common.updateTime();//处理时间
			}
		},
		events:{
			'#my_address' : { //获取微信地址
				click : function(){
					wxJs.openAddress(function(res){});
				}
			},
			'.card_exchange' : { //兑换优惠券
				click : function(){
					if(user.params.isexchange) return false;
					var thisclass = $(this);
					var postdata = {
						id : $(this).attr('data-id'),
						needcredit : $(this).attr('data-need')
					};					
					//common.confirm('提示','兑换此券需消耗'+postdata.needcredit+'个人积分,确定兑换吗？',function(){
						user.params.isexchange = true;
						common.Http('post','json',common.createUrl('ajaxdeal','exchangecard'),postdata,function(data){
							user.params.isexchange = false;
							if(data.str== '已达兑换上限'){
								thisclass.parent().append('<font class="exchanged">已兑换</font>');
								thisclass.remove();
							}
							common.alert(data.str);
						},'',false);							
						
					//});
					
					
				
				}
			},
			'#refresh_user' : { //更新信息
				click : function(){
					common.Http('post','html',common.createUrl('ajaxdeal','refreshuser'),{},function(data){
						common.alert(data);
						if(data == '更新成功'){
							setTimeout(function(){
								location = "";
							},800);
						}
					},'',false);					
				}
			},
			'.order_top li' : { //切换订单类型
				click : function(){
					user.fn.changeStatus($(this),function(value){
						config.user.status = value;
						user.fn.initOrderPage();					
					});
				}
			},
			'#gotoback' : { //返回
				click : function(){
					$.router.back();
				}
			},
			'.order_btn_deal' : { //处理订单
				click : function(){
					if(user.params.isclick) return false;
					var postdata = {
						type : $(this).attr('data-type'),
						orderid : $(this).parent().attr('data-id')
					};
					var deleteclass = $(this).parents('.afterdealdelete');
					if(postdata.type == 'cancel'){
						var iscard = '',iscredit = '';
						if(initParams.isreturncard == 2) iscard = '使用的卡券不退还，';
						if(initParams.isreturncredit == 2) iscredit = '使用的积分不退还，';
						var notice = iscard + iscredit +'确定要取消此订单吗？';
					} 
					if(postdata.type == 'refund') var notice = '退款后此订单所使用的优惠券等不给予退还，确定要申请退款吗？';
					if(postdata.type == 'cancelrefund') var notice = '取消退款申请后不可再申请退款，确定要取消退款申请吗？';
					if(postdata.type == 'confirm') var notice = '确定要确认收货吗？';
					common.confirm('提示',notice,function(){
						user.params.isclick = true;
						common.Http('post','html',common.createUrl('ajaxdeal','dealorder'),postdata,function(data){
							if(data == 2){
								common.alert('操作成功');
								setTimeout(function(){
									if(deleteclass.length > 0){ //来自列表页面，直接删除此dom
										deleteclass.remove();
										user.params.isclick = false; //解除锁定
									}else{
										location.href = "";
									}
								},1000);
							}else{
								common.alert(data);
								user.params.isclick = false;
							}
							
						});
					});
					
				}
			},
			'#comment_good' : { //详情页面评价商品
				click : function(){
					user.params.needdeletecomment = $(this);
					common.isShowSheet(this,'#sideup_comment');
				}
			},
			'.comment_good' : { //订单列表页面评价商品
				click : function(){
					var self = this;
					user.params.needdeletecomment = $(this).parent(); //获取需要删除的评价按钮
					var postdata = {
						id : $(this).attr('data-id')
					};
					common.Http('post','json',common.createUrl('pagelist','getcommentgoog'),postdata,function(data){
						if(data.status == 'ok'){
							$('.sideup_comment_body').empty().append(data.data);
							$('.foot_box .fixed_bottom').css({'z-index':'-1'});
							common.isShowSheet(self,'#sideup_comment');
						}else{
							common.alert('当前订单不能评价');
						}
						
					});					
					
				}
			},
			'#sideup_comment #actionsheet_cancel ,#sideup_comment #mask' : { //上一步隐藏了导航，这里显示导航
				click : function(){
					$('.foot_box .fixed_bottom').css({'z-index':'1'});
				}
			},
			'.pubcomment' : { //发布评价
				click : function(){

					var thisclass = $(this).parents('.good_comment_item');
					var postdata = {
						gid : thisclass.find('input[name=gid]').val(),
						id : thisclass.attr('data-id'),
						level : thisclass.find('input:checked').val(),
						text : thisclass.find('textarea[name=text]').val(),
						pic : []
					};
					thisclass.find('.upload_images_views input').each(function(){
						postdata.pic.push($(this).val());
					});
					if(postdata.level == '' || postdata.level == undefined){
						common.alert('请先选择评价等级');
						return false;
					}
					if(postdata.text == ''){
						common.alert('请填写评价文字');
						return false;
					}
					common.confirm('提示','评价后不能修改，确定要提交评价吗？',function(){
						common.Http('post','html',common.createUrl('ajaxdeal','commentgood'),postdata,function(data){
							if(data == 2){
								common.alert('评价成功');
								thisclass.remove();
								if($('.good_comment_item').length == 0){
									$('#sideup_comment #actionsheet_cancel').triggerHandler('click');
									$('.foot_box .fixed_bottom').css({'z-index':'1'});
									if(user.params.needdeletecomment) user.params.needdeletecomment.remove();
								} 
							}else{
								common.alert(data);
							}
						});						
					});
				}
			},
			'.select_express_btn' : { //查询快递信息
				click : function(){
					var postdata = {
						expressname : $(this).attr('data-name'),
						expressnumber : $(this).attr('data-num')
					};
					common.Http('post','json',common.createUrl('ajaxdeal','selectexpress'),postdata,function(data){
						if(data.status == 1){
							$('.express_body').html(data.data);
							$('.select_express_btn').remove();
						}else{
							common.alert(data.data);
						}
					});
				}
			},
			'.group_top a:not(:first-child)' : { //  查询团单
				click : function(){
					config.user.op = 'mygroup';
					user.fn.changeStatus($(this).find('li'),function(value){
						config.user.status = value;
						user.fn.initOrderPage();					
					});
				}
			},
			'.group_top a:first-child' : { //查询未支付的团单
				click : function(){
					config.user.op = 'order';
					config.user.onlygroup = 1;
					user.fn.changeStatus($(this).find('li'),function(value){
						config.user.status = value;
						user.fn.initOrderPage();					
					});
				}
			},			
		},
		fn:{
			initOrderPage : function(){
				config.user.page = 1;
				config.user.isend = false;
				$('.list_container').empty();
				common.getPage(config.user,function(data){
					if(data.status == 'ok'){
						config.user.isinit = true;
					}
				});
			},
			changeStatus : function(elemt,callback){ //切换订单，团状态
				$('.top_item .activity_bottom').removeClass('activity_bottom');
				elemt.addClass('activity_bottom');
				callback(elemt.attr('data-status'));
			}
			
		}
		
	};
	
	var group = {
		params : {
		
		},
		init : {
			init : function(){
				common.squareImage('.avatar-list img'); //处理头像
				common.updateTime();//处理时间
			}
		},
		events : {
			'#gotoback' : {
				click : function(){
					$.router.back();
				}
			},
			'.group_moremember' : { //查看更多成员
				click : function(){
					var thisclass = $(this).find('span');
					if(thisclass.hasClass('ti-angle-down')){
						$('.avatar-list').css({'height':'auto'});
						thisclass.removeClass('ti-angle-down').addClass('ti-angle-up');
					}else{
						$('.avatar-list').css({'height':'48px'});
						thisclass.removeClass('ti-angle-up').addClass('ti-angle-down');					
					}
					
				}
			},
			'.call_family' : { //纸飞机
				click : function(){
					var right = $(window).width()*1-50;
					var height = $(window).height();
					$('.group_plane').show().animate({
						bottom : height+'px',
						left : right+'px'
					},2000,function(){
						$('.group_plane').css({bottom:0,left:0}).hide();
					});
				}
			}
		},
		fn : {
			
		}
	};
	
	
	//sort页面
	$(document).on("pageInit", "#page_sort", function(e, id, page) {
		//初始加载页面
		if(!config.sort.isinit){
			common.getPage(config.sort,function(data){
				if(data.status == 'ok'){
					config.sort.isinit = true;
				}
			});			
		}
		
		common.init(topSelect);
		common.init(sort);

		$(page).on('infinite', function() {
			//加载页面
			common.getPage(config.sort,function(data){		
				
			});	
		});
	});
	
	//good页面
	$(document).on("pageInit", "#page_good", function(e, id, page) {
		common.init(good);
		
		//赋值分享数据
		shareData.title = $('.good_title_target').text();
		shareData.desc = $('.good_page_title .desc').text();
		shareData.imgUrl = $('.swiper-wrapper img').first().attr('src');
		wxJs.share(shareData);
		
		$(page).on('infinite', function() {
			console.log('page_good')
		});
	});	
	
	//cart页面
	$(document).on("pageInit", "#page_cart", function(e, id, page) {
		common.init(cart);
		wxJs.share(shareData);
		$(page).on('infinite', function() {
			console.log('page_cart')
		});
	});		
	
	//confirm页面
	$(document).on("pageInit", "#page_confirm", function(e, id, page) {
		common.init(confirm);
		$(page).on('infinite', function() {
			console.log('page_confirm')
		});
	});	
	
	
	//user页面
	$(document).on("pageInit", "#page_user,#page_orderinfo", function(e, id, page) {
		
		if($.inArray(initParams.op,['getcard','card','mygroup']) >= 0) { //卡券列表
			if(!config.user.isinit){
				common.getPage(config.user,function(data){
					if(data.status == 'ok'){
						config.user.isinit = true;
					}
				});
			}
		}
		if($.inArray(initParams.op,['order']) >= 0) { //订单列表
			if(!config.user.isinit){
				user.fn.initOrderPage();
			}
			if(config.user.status == 5 || config.user.status == 4){ //选择最右边的状态时，将滚动条滚动到最右边
				$('.order_top').scrollLeft(100);
			}
		}
		
		common.init(user);
		$(page).on('infinite', function() {
			common.getPage(config.user,function(data){});	 //加载页面
		});
	});		
	
	
	//index页面
	$(document).on("pageInit", "#page_index", function(e, id, page) {
		common.indexInit();
		//aaa();
		$(".swiper-container").swiper({ //幻灯片
			autoplay : 3000,
			speed : 300,
			autoplayDisableOnInteraction : false,
			onInit : function(){ //设置原点颜色
				$('.swiper-pagination').each(function(){
					var color = $(this).attr('data-color');
					$(this).find('span').css({'background-color':color});
				});
			}
		});
		
		$(page).on('infinite', function() {});
	});		
	
	//group页面
	$(document).on("pageInit", "#page_group", function(e, id, page) {
		common.init(group);
		
		//分享数据
		shareData.title = '我正在团购一款宝贝，您也来参团吧'; 
		shareData.desc = $('.goods-detail .name').text();
		shareData.imgUrl = $('.goods-detail .image img').first().attr('src');
		wxJs.share(shareData);
		
		$(page).on('infinite', function() {});
	});
	
	$.init();
	
	
});
