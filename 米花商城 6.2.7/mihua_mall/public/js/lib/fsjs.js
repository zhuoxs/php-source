$(function(){
	//切换分类类型
	$('input[name=sorttype]').change(function(){
		if($(this).val() == '1'){
			$('.sort_classtwo').hide();
		}else{
			$('.sort_classtwo').show();
		}
	})
	//验证提交分类
	$('#addsort').click(function(){
		var type = $('input[name=sorttype]:checked').val(),
			sortname = $('input[name=sortname]').val(),
			sortorder = $('input[name=sortorder]').val(),
			upsort = $('input[name=upsort]:checked').val();
		if(typeof(type) == 'undefined'){
			alert('请选择分类级数');return false;		
		}
		if(sortname == '' || sortorder == ''){
			alert('分类名称和排序必填！');return false;
		}
		if(type == 2 && typeof(upsort) == 'undefined'){
			alert('请选择所属分类');return false;
		}
	});


/*运费模板*/
	var province = ['北京','天津','河北省','山西省','内蒙古自治区','辽宁省','吉林省','黑龙江省','上海','江苏省','浙江省','安徽省','福建省','江西省','山东省','河南省','湖北省','湖南省','广东省','广西壮族自治区','海南省','重庆','四川省','贵州省','云南省','西藏自治区','陕西省','甘肃省','青海省','宁夏回族自治区','新疆维吾尔自治区','台湾省','香港特别行政区','澳门特别行政区','海外'];
	
	//添加一个地区
	$('#addonearea').click(function(){ 
		var addstr = 
					'<div class="express_main_item">'
						+'<div class="item_cell_box">'
							+'<li class="item_cell_flex express_btn_out">'
								+'<a href="javascript:;" class="a_href edit_province" data-toggle="modal" data-target="#myModal">编辑地区 </a>'
								+'<input type="hidden" name="express[area][]" class="col-sm-2 area_value_input"  value="" />'
								+'<span class="btn_44b549 delete_express">删除</span>'
							+'</li>'
							+'<li class="express_btn_money">'
								+'<span class="font_13px_999"> 下单量 </span>'
								+'<span class="input_box input_box_60">'
									+'<input type="text" class="input_input" name="express[num][]" value="">'
								+'</span>'
								+'<span class="font_13px_999"> 件内，邮费 </span>'
								+'<span class="input_box input_box_60">'
									+'<input type="text" class="input_input" name="express[money][]" value="">'
								+'</span>'
								+'<span class="font_13px_999"> 元，每增加 </span>'
								+'<span class="input_box input_box_60">'
									+'<input type="text" class="input_input" name="express[numex][]" value="">'
								+'</span>'
								+'<span class="font_13px_999"> 件，加邮费 </span>'
								+'<span class="input_box input_box_60">'
									+'<input type="text" class="input_input" name="express[moneyex][]" value="">'
								+'</span>'
								+'<span class="font_13px_999"> 元 </span>'									
							+'</li>'
						+'</div>'
						+'<div class="area_item">'
							+'<span class="font_13px_999"></span>'
						+'</div>'
					+'</div>';
		$('.express_main').append(addstr);
	});
	
	//删除地区选择项
	$('body').on('click','.delete_express',function(){
		$(this).parents('.express_main_item').remove();
	})

	//编辑地区
	$('body').on('click','.edit_province',function(){
		thisclass = $(this);
		thisinput = thisclass.next();
		var areaArrayed = [];
		var selected = '';
		$('.area_value_input').not(thisinput).each(function(){
			selected += $(this).val();
		});
		selected = selected.replace(/,$/,'');
		selectedArray=selected.split(","); //其余的值,数组
	
		selfvalue = thisinput.val();
		selfvalue = selfvalue.replace(/,$/,'');
		selfArray=selfvalue.split(","); //自己的值，数组
		
		$('.express_modal .province').each(function(){
			$(this).removeClass('area_selected');
			if($.inArray($(this).find('input').val(),selectedArray) >= 0){
			
				$(this).parent().hide();
			}
			if($.inArray($(this).find('input').val(),selfArray) >= 0){
				$(this).addClass('area_selected').find('input').attr('checked',true);
				$(this).parent().show();
			}			
		});
	});

	$('body').on('click','.express_modal .province',function(){
		var ischecked = $(this).find('input').is(':checked');
		if(ischecked){
			$(this).addClass('area_selected');
		}else{
			$(this).removeClass('area_selected');
		}
		
	});	
	$('.area_confirm').click(function(){
		var str = '';
		$('.express_modal .area_selected input:checked').each(function(){
			str += $(this).val() + ',';
		});
		thisclass.next().val(str);
		thisclass.parents('.express_main_item').find('.area_item span').text(str);
		$('#myModal').modal('hide');
	});
	
	//提交
	$('input[name=addexpress').click(function(){
		var expressname = $('input[name=expressname]').val();
		if(expressname == ''){
			alert('请填写模板名称');return false;
		}
		var isempty = 0;
		$('.express_main_item input').each(function(){
			if($(this).val() == ''){
				isempty = 1;return;
			}
		});
		if(isempty == 1){
			alert('区域运费不能存在空项');return false;
		}
	});

/* 运费模板结束 */

/*添加编辑商品*/ // ///////////////////////////

	changeItem($('input[name=ruletype]'),$('.show_rule')); //切换规格类型
	
	//编辑规格
	$('body').on('click','.edit_rule_item',function(){
		var type = $(this).attr('data-type');
		var valueinput = $(this).parent().find('input');
		var value = valueinput.val();
		if(value == ''){
			alert('请在编辑框输入内容');return false;
		}
		if(type == '1'){
			$(this).parents('.input_form').find('.rule_name').text(value).next().val(value);
		}else if(type == '2'){
			var valueelemt = $(this).parents('.input_form').find('.rule_pro');
			valueelemt.append(value+',');
			var nowvalue = valueelemt.next().val();
			valueelemt.next().val(nowvalue+value+',');
		}
		valueinput.val('').focus();
	});
	
	//重置属性
	$('body').on('click','.reset_rule_pro',function(){
		if(confirm('确定要重置属性吗？')){
			$(this).parents('.input_form').find('.rule_pro').text('').next().val('');
		}
	});
	//删除
	$('body').on('click','.deletethis_rule',function(){
		if(confirm('确定要这条规格吗？')){
			$(this).parent().remove();
		}
	});	
	
	//添加一条规格
	$('.add_a_rule').click(function(){
		var type = $(this).attr('data-type');
		if(type == '1'){
			var str = 
				'<div class="item_cell_box good_rule_body">'
				+'<div class="input_title"></div>'
				+'<div class="input_form item_cell_flex">'
					+'<div>'
						+'规格名称: '
						+'<span class="rule_name"></span><input type="hidden"  name="samerulename[]">'
					+'</div>'
					+'<div class="item_cell_box">'
						+'<p>规格属性:</p>&nbsp;'
						+'<p class="rule_pro item_cell_flex"></p>'
						+'<input type="hidden" name="samerulepro[]">'
					+'</div>'
					+'<div class="add_btn_box">'
						+'<span class="input_box input_box_200">'
							+'<input type="text" class="input_input">'
						+'</span>'
						+'<span class="font_13px_999 add_btn edit_rule_item" data-type="1"> 编辑名称 </span>&nbsp;&nbsp;'
						+'<span class="font_13px_999 add_btn edit_rule_item" data-type="2">添加属性</span>&nbsp;&nbsp;'
						+'<span class="font_13px_999 add_btn reset_rule_pro" >重置属性</span>'
					+'</div>'
				+'</div>'
				+'<span class="fa fa-times deletethis_rule"></span>'
				+'</div>';
				
		}else if(type == '2'){
			var str = 
				'<div class="item_cell_box good_rule_body">'
					+'<div class="input_title"></div>'
					+'<div class="input_form item_cell_flex">'
						+'<div>'
							+' 名称: &nbsp;'
							+'<span class="input_box input_box_150">'
								+'<input type="text" class="input_input" name="diffrulename[]">'
							+'</span>	&nbsp;&nbsp;'
							+' 现价: &nbsp;'
							+'<span class="input_box input_box_100">'
								+'<input type="text" class="input_input" name="diffnowprice[]">'
							+'</span>元&nbsp;'
							+' 团购价: &nbsp;'
							+'<span class="input_box input_box_100">'
								+'<input type="text" class="input_input" name="diffgroupprice[]">'
							+'</span>元	'						
						+'</div>'
					+'</div>'
					+'<span class="fa fa-times deletethis_rule"></span>'
				+'</div>';				
		}
		$(this).parents('.show_rule').find('.rule_append_box').append(str);
	});
	
	////提交商品
	$('form[name=addgood_form]').submit(function(){
		var form = $(this).serializeArray();
		
		for(v in form){
			var t = form[v].name;
			var type = '';
			var notice = '';		
			if(t == 'title') {
				type = 'str';
				notice = '标题';
			}else if(t == 'descrip'){
				type = 'str';
				notice = '简述';
			}else if(t == 'oldprice'){
				type = 'money';
				notice = '原价';
			}else if(t == 'nowprice'){
				type = 'money';
				notice = '现价';				
			}else if(t == 'groupprice'){
				type = 'money';
				notice = '团购价';	
			}else if(t == 'groupendtime'){
				type = 'money';
				notice = '组团限制时间';
			}else if(t == 'stock'){
				type = 'int';
				notice = '库存';
			}else if(t == 'sales'){
				type = 'int';
				notice = '销量';				
			}else if(t == 'order'){
				type = 'int';
				notice = '排序';				
			}else if(t == 'groupnum'){
				type = 'int';
				notice = '满团人数';
			}
			if(type != ''){
				var bool = checkForm(t,form[v].value,type,notice);
				if(!bool) return false;
			}
		}
		var picnum = $('.good_pic .multi-item img').length;	
		if(picnum <=0 ){
			alert('还没有上传商品图片');return false;
		}
		
		var sortnum = $('input[name="sort[]"]:checked').length;
		if(sortnum <=0 ){
			alert('还没有选择分类');return false;
		}		
		
		
		// ///// 验证规格
		var ruletype = $('input[name=ruletype]:checked').val();
		var iserror = false;
		if(ruletype == 1){
			$('input[name="samerulename[]"]').each(function(){
				if($(this).val() == ''){
					alert('有规格没有填写名称'); iserror = true; return false;
				}
			});
			$('input[name="samerulepro[]"]').each(function(){
				if($(this).val() == ''){
					alert('有规格没有填写属性'); iserror = true; return false;
				}
			});			
		}
		if(ruletype == 2){
			$('input[name="diffrulename[]"]').each(function(){
				if($(this).val() == ''){
					alert('有规格没有填写名称'); iserror = true; return false;
				}
			});
			$('input[name="diffnowprice[]"]').each(function(){
				if($(this).val() == ''){
					alert('有规格没有填写现价'); iserror = true; return false;
				}
				var bool = checkForm('',$(this).val(),'money','规格现价');
				if(!bool){
					iserror = true; return false;
				}
			});	
			$('input[name="diffgroupprice[]"]').each(function(){
				if($(this).val() == ''){
					alert('有规格没有填写团购价'); iserror = true; return false;
				}
				var bool = checkForm('',$(this).val(),'money','规格团购价');
				if(!bool){
					iserror = true; return false;
				}
			});				
		}
		
		//团购人数必须在2-200之间
		var groupnum = $('input[name=groupnum]').val()*1;
		if(groupnum > 200 || groupnum < 2){
			alert('团购人数必须在2-200之间，包括2和200'); return false;
		}
		// //////验证运费
		var expresstype = $('input[name=expresstype]:checked').val();
		if(expresstype == 1){
			var bool = checkForm('',$('input[name=expressmoney]').val(),'money','商品运费');
			if(!bool) iserror = true;
		}
		if(expresstype == 2 && $('input[name=expressid]').val() == ''){
			alert('还没有选择运费模板');return false;
		}		
		
		var nowprice = $('input[name=nowprice]').val()*1;
		var groupprice = $('input[name=groupprice]').val()*1;
		
		// ////////验证活动
		var iscredit = $('input[name=iscredit]:checked').val();
		var isfreeexpress = $('input[name=isfreeexpress]:checked').val();		
		var isfirstcut = $('input[name=isfirstcut]:checked').val();		
		if(iscredit == 1){	
			var bool = checkForm('',$('input[name=maxcredit]').val(),'int','最多抵扣积分');
			if(!bool) iserror = true;
			if($('input[name=maxcredit]').val()*$('.creditratio').text() >= nowprice || $('input[name=maxcreditmoney]').val()*$('.creditratio').text() >= groupprice){
				alert('最多抵扣积分太多了，与比率乘积不能大于等于现价和团购价');return false;
			}
		}
		if(isfreeexpress == 1){
			var bool = checkForm('',$('input[name=fullmoney]').val(),'money','满额包邮');
			if(!bool) iserror = true;
			if($('input[name=fullmoney]').val()*1 < nowprice || $('input[name=fullmoney]').val()*1 <groupprice){
				alert('满额包邮的金额不能小于现价和团购价');return false;
			}
		}		
		if(isfirstcut == 1){
			var bool = checkForm('',$('input[name=firstcutmoney]').val(),'money','首单优惠金额');
			if(!bool) iserror = true;
			if($('input[name=firstcutmoney]').val()*1 >= nowprice || $('input[name=firstcutmoney]').val()*1 >= groupprice){
				alert('首单优惠金额不能大于等于商品现价和团购价');return false;
			}
		}			
		
		// /////限购验证
		var limitbuy = $('input[name=limitbuy]:checked').val();
		if(limitbuy == 1){
			var bool = checkForm('',$('input[name=limittime]').val(),'int','限购间隔天数');
			if(!bool) iserror = true;	
			var bool = checkForm('',$('input[name=limitnum]').val(),'int','限购数量');
			if(!bool) iserror = true;
		}
		
		
		if(iserror) return false;
	});
	
	
	function checkForm(name,value,type,notice){
		if(value == '' || value == undefined){
			alert('还没有填写'+notice);return false;
		}
		if(type != 'str'){
			if(type == 'int'){
				var R = /^[1-9]*[1-9][0-9]*$/;
				var noticetype ='正整数';
			}else if(type == 'intAndLetter'){
				var R = /^[A-Za-z0-9]*$/;
				var noticetype ='数字和字母组合';
			}else if(type == 'money'){ //金额,最多2个小数
				var R = /^\d+\.?\d{0,2}$/;
				var noticetype ='数字，最多2位小数';
			}else if(type == 'mobile'){ //手机
				var R = /^1[3|4|5|7|8]\d{9}$/;
				var noticetype ='正确的手机类型';
			}else if(type == 'cn'){ //中文
				var R = /^[\u2E80-\u9FFF]+$/;
				var noticetype ='中文';
			}
			
			if(!R.test(value)){
				alert(notice + '必须是'+ noticetype);return false;
			}			
		}

		return true;
	}
	
	
	// ///////////////添加标签
	$('.add_a_inco').click(function(){
		var valueinput =  $(this).prev().find('input');
		var value = valueinput.val();
		if(value == ''){
			alert('请先在输入框输入标签名称');return false;
		}
		var str = '<label><input type="checkbox" name="inco[]" value="'+value+'" checked="checked"> '+value+'</label>';
		$(this).parents('.input_form').find('.inco_append_box').append(str);
		valueinput.val('').focus();
	});
	
	
	// ///////////运费模板
	changeItem($('input[name=expresstype]'),$('.good_express_value')); //切换运费
	
	// /////////活动
	$('.activity_onoff').click(function(){
		var ison = $(this).find('input:checked').val();
		var showelem = $(this).attr('data-show');
		if(ison == '1'){
			$('.'+showelem).css({'display': '-webkit-box'});
		}else{
			$('.'+showelem).hide();
		}
	});
	
	// ////////////限购
	changeItem($('input[name=limitbuy]'),$('.good_limit_body')); //切换运费	
	
	///////参数
	$('body').on('focus','.good_params_list input',function(){
		$(this).parent().css({'background':'#fff'});
	});
	$('body').on('blur','.good_params_list input',function(){
		$(this).parent().css({'background':'#f3f4f9'});
	});	
	
	//添加一个参数
	$('.add_a_params').click(function(){
		var thisparent = $(this).parents('.good_params_item');
		var name = thisparent.find('input[name=addparamsname]').val();
		var pro = thisparent.find('input[name=addparamspro]').val();		
		if(name == '' || pro == ''){
			alert('请先在左方填好名称和属性');return false;
		}
		var str = 
				'<div class="good_params_item">'
					+'<div class="params_name_div">'
						+'<span class="input_box input_box_100">'
							+'<input type="text" class="input_input" name="paramsname[]" value="'+name+'" >'
						+'</span>'
					+'</div>'
					+'<div class="params_pro_div">'
						+'<span class="input_box input_box_300">'
							+'<input type="text" class="input_input" name="paramspro[]" value="'+pro+'" >'
						+'</span>'
						+'<a href="javascript:;" class="a_href deletethis_params"> 删除</a>'
					+'</div>'
				+'</div>';	
		$('.good_params_list').append(str);
		$('input[name=addparamspro]').val('');
		$('input[name=addparamsname]').val('').focus();
	});
	
	//删除参数
	$('body').on('click','.deletethis_params',function(){
		if(confirm('确定要这条参数吗？')){
			$(this).parents('.good_params_item').remove();
		}
	});		
	
	//阻止关闭下拉
	$('.dropdown-menu li.removefromcart').click(function(e) {
		e.stopPropagation();
	});	
	
	// 复制链接
	require(['jquery.zclip'], function(){
		var copyurl = '';
		$('.copy_url').zclip({
			path: './resource/components/zclip/ZeroClipboard.swf',
			copy: function(){
				return $(this).attr('data-href');
			},
			afterCopy: function(){
				alert('复制成功');
			}
		});
	});	

	// //// 改变分类
	$('input[name=changesinglesort]').click(function(){
		var thiselem = $(this);
		var thisid = thiselem.attr('data-id');
		var params = [];
		
		thiselem.parents('.change_sort_menu').find('input[name="singlesortvalue[]"]:checked').each(function(){
			params.push($(this).val());
		});
		Http('post','html','changesort',{params:params,id:thisid},function(data){
			if(data == 1){
				alert('成功改变分类');
			}else{
				alert('改变分类失败');
			}
		},function(){
			thiselem.unbind('click');
		})
	});
	
	/***优惠券***/
	changeItem($('input[name=cardtype]'),$('.card_notice_item'),function(type){
		if(type == 'card_notice_aa' || type == 'card_notice_cc'){
			$('#card_font_aa').text('此券面值');
			$('#card_font_bb').text('元，');
		}else{
			$('#card_font_aa').text('此券可打');
			$('#card_font_bb').text('折，');
		}
	});
	
	//提交优惠券
	$('form[name=addcard_form').submit(function(){
		var data = {
			cardtype : $('input[name=cardtype]:checked').val(),
			cardname : $('input[name=cardname]').val(),
			needcredit : $('input[name=needcredit]').val()*1,
			cardvalue : $('input[name=cardvalue]').val()*1,
			fullmoney : $('input[name=fullmoney]').val()*1,
			totalnum : $('input[name=totalnum]').val()*1,	
			limitnum : $('input[name=limitnum]').val()*1,
			expire : $('input[name=expire]').val()*1,
			starttime : $('input[name="datelimit[start]"]').val(),
			endtime : $('input[name="datelimit[end]"]').val()
		};
		
		var bool = checkForm('',data.cardtype,'str','优惠券类型');
		if(!bool) return false;
		var bool = checkForm('',data.cardname,'str','优惠券名称');
		if(!bool) return false;		
		var bool = checkForm('',data.cardvalue,'money','优惠券面值');
		if(!bool) return false;			
		var bool = checkForm('',data.fullmoney,'money','订单金额数值');
		if(!bool) return false;			
		var bool = checkForm('',data.totalnum,'int','优惠券发放总量');
		if(!bool) return false;				
		var bool = checkForm('',data.limitnum,'int','限制每人领取数量');
		if(!bool) return false;			
		var bool = checkForm('',data.expire,'int','优惠券有效时间');
		if(!bool) return false;			
			
		if((data.cardtype == 1 || data.cardtype == 3) && data.cardvalue >= data.fullmoney){
			alert('优惠券的面值不能大于等于订单金额');return false;
		}		
		if((data.cardtype == 2 || data.cardtype == 4) && data.cardvalue >= 1){
			alert('优惠券的折扣值不能大于等于1');return false;
		}			
		if(data.starttime ==  data.endtime ){
			alert('兑换时间段无效');return false;
		}
		if(data.cardvalue <=  0 ){
			alert('面值或折扣值不能小于等于0');return false;
		}
		
	});
	
	//////////////////////////增加测试数据
	var issending = false;
	$('body').on('click','.testdata_btn',function(){
		if(issending) return false;
		var op = $(this).attr('data-op');
		
		Http('post','html','test'+op,{},function(data){
			issending = false;
			if(data == 1){
				location.href = "";				
			}else if (data == 2){
				alert('增加测试数据失败');
			}else if (data == 0){
				alert('数据已经有很多了，不需要增加了');
			}else{
				alert(data);
			}
		},function(){
			issending = true;
		});
		
	});
	
	
	/*setting切换*/
	$('.setting_btn').click(function(){
		var showelem = $(this).attr('data-show');
		$('.setting_btn').removeClass('activity_bottom');
		$(this).addClass('activity_bottom');
		$('.setting_item').hide();
		$('.'+showelem).show();
	});
	
	/////清理缓存
	$('input[name=deletecache]').click(function(){
		if(confirm('确定删除缓存吗？')){
			Http('post','html','deletecache',{},function(data){
				if(data == 1){
					alert('已删除');
				}else{
					alert('删除失败');
				}
			});
		}
	});
	

	queueueue();
	// 计划任务
	function queueueue(){
		Http('post','html','queue',{},function(data){},false);
		setInterval(function(){
			Http('post','html','queue',{},function(data){},false);
		},10000);		
	}



	////////////////////////////////订单管理页面
	var orderdealtype = '';
	$('.order_deal_btn').click(function(){
		var thisclass = $(this);
		var dealbox = thisclass.parents('.opclass').find('.order_deal_box');
		orderdealtype = thisclass.attr('data-type');
		$('.order_deal_box,.order_item_body').hide();
		dealbox.show();
		if(orderdealtype == 'express' || orderdealtype == 'editexpress'){
			dealbox.find('.order_express_body').show();
		
		}else if(orderdealtype == 'refund'){
			dealbox.find('.order_refund_body').show();			
		}
		
	});
	
	$('.order_list_refuserefund').click(function(){ //拒绝退款申请
		var id = $(this).attr('data-id');
		refuserefundOrder({id:id});
	});
	
	
	//关闭操作框
	$('.closethisdealbox').click(function(){
		$(this).parents('.order_deal_box').hide();
	});
	//切换是否需要物流
	$('.expresstype').click(function(){
		var thisvalue = $(this).val();
		var showclass = $(this).parents('.order_express_body').find('.express_need');
		if(thisvalue == '0') showclass.hide();
		if(thisvalue == '1') showclass.show();
		
	});
	//确定编辑订单内容
	$('.confirm_order').click(function(){
		var dealclass = $(this).parents('.order_deal_box');
		var orderid = $(this).attr('data-id');
		if(orderdealtype == ''){
			alert('你没有选择操作方式');return false;
		}
		if(orderdealtype == 'express' || orderdealtype == 'editexpress'){ //编辑快递 
			sendGoodAndEditExpress(orderdealtype,dealclass,orderid);
		}
		if(orderdealtype == 'refund'){
			var returnmoney = dealclass.find('input[name=refundmoney]').val()*1;
			refundOrder({id:orderid,money:returnmoney});
		}
		
	});
	

	//批量填写快递
	$('input[name=alltoexpress]').click(function(){
		$('.table_allexpress').css({'display':'table-cell'}).next().hide();
		$('.goodid_check input').prop('checked',true);

		$(this).attr('type','hidden').next().attr('type','submit').next().attr('type','button');
		
	});
	//退出批量填写快递
	$('input[name=quitbatchexpress]').click(function(){
		$('.table_allexpress').css({'display':'none'}).next().show();
		$('.goodid_check input').prop('checked',false);
		$(this).attr('type','hidden').prev().attr('type','hidden').prev().attr('type','button');
	});
	
	//批量选择快递
	$('.batchexpress_select').change(function(){
		var isbatchchange = $('input[name=batchselectexpress]:checked').val();
		var nowvalue = $(this).val();
		if(isbatchchange == 1){
			$('.batchexpress_select').val(nowvalue);
		}
	});
	//提交批量物流发货
	$('input[name=submitbatchexpress]').click(function(){
		var ischecked = $('input[name="checkid[]"]:checked').val();
		if(typeof(ischecked) == 'undefined'){
			alert('先选择要发货的订单。');return false;
		}
		var isquit = false;
		$('input[name="checkid[]"]:checked').each(function(){
			if($(this).parents('tr').find('.batchexpressnumber').val() == ''){
				isquit = true; return false;
			}
		});
		if(isquit){
			alert('有选择的订单还没有填写订单编号');return false;
		}
	});
	
	//搜索,改变内容
	$('.search_write input').on('input propertychange',function(){
		var thisinput = $(this);
		thisinput.parents('.search_write').find('input.input_input').not(thisinput).val('');
	});
	
	
	var orderinfodealtype = '';
	/*订单详情页面*/
	$('.info_top_status .btn_44b549').click(function(){ //详情页面操作订单
		var type = $(this).attr('data-type');
		if($.inArray(type,['sendmessagetouser','markorder','refund']) >= 0){
			$('.order_info_deal_box').hide();
			$('.order_info_commonbox').show();			
		}
		if(type == 'sendmessagetouser' ){
			$('.order_info_noticestr').text('通知内容');
			orderinfodealtype = 'message';
			$('input[name=orderdealvalue]').val('您有一笔订单就要过期了，支付后我们会准备给您发货。');
		}
		if(type == 'markorder'){
			$('.order_info_noticestr').text('备注内容');
			orderinfodealtype = 'mark';
			$('input[name=orderdealvalue]').val($('input[name=orderdealvalue]').attr('data-mark'));
		}
		if(type == 'refund'){
			orderinfodealtype = 'refund';
			$('.order_info_noticestr').text('退款金额');
			$('input[name=orderdealvalue]').val($('input[name=orderdealvalue]').attr('data-money'));
		}
		if(type == 'refuserefund'){ //拒绝退款
			refuserefundOrder({id:$(this).attr('data-id')});
			return false;
		}
		if(type == 'cansel'){
			$('.order_info_deal_box').hide();
		}
		if(type == 'sendgood'){
			$('.order_info_sendgood').show();
		}
		if(type == 'confirmsendgood'){ //确定发货
			sendGoodAndEditExpress('express',$(this).parents('.order_info_sendgood'),$(this).attr('data-id'));
		}
		if(type == 'commonconfirm'){ //确定
			var postdata = {
				value : $('input[name=orderdealvalue]').val(),
				id : $(this).attr('data-id'),
				type : orderinfodealtype
			};
			if(orderinfodealtype == 'mark'){
				var noticestr = '确定要提交备注吗？';
				var posturl = 'markorder';
			}
			if(postdata.value == ''){
				alert('你还没有填写内容');return false;
			}
			
			if(orderinfodealtype == 'refund'){ //退款
				refundOrder({id:postdata.id,money:postdata.value});
				return false;
			}
			if(orderinfodealtype == 'message'){
				var noticestr = '确定要发送吗？';
				var posturl = 'reminduser'; 
			}
			if(confirm(noticestr)){
				Http('post','html',posturl,postdata,function(data){
					if(data == 1){
						alert('操作成功');
						location.href = "";
					}else{
						alert(data);
					}
				},true);
			}
		}
		if(type == 'delete'){ //删除订单
			var postdata = {
				id : $(this).attr('data-id')
			};
			if(confirm('确定要删除此订单吗？')){
				Http('post','html','deleteOrder',postdata,function(data){
					if(data == 1){
						alert('已删除此订单');
						location.href = window.sysinfo.siteroot + '/web/index.php?c=site&a=entry&op=list&do=order&m=mihua_mall';
					}else{
						alert(data);
					}
				},true);
			}
		}		
		
	});
	$('.cancelsendgoodinorderinfo').click(function(){
		$('.order_info_sendgood').hide();
	});

	//修改收货地址
	$('#info_edit_address').click(function(){
		$('.edit_address_btnlist').show();
		$(this).parents('.input_form').removeClass('no_bord_input').addClass('have_bord_input').find('input').attr('disabled',false);
		
	});
	//取消修改地址
	$('.cancel_edit_address').click(function(){
		$('.edit_address_btnlist').hide();
		$(this).parents('.input_form').removeClass('have_bord_input').addClass('no_bord_input').find('input').attr('disabled',true);
	});
	//确定修改地址
	$('.confirm_edit_address').click(function(){
		var postdata = {
			id : $(this).attr('data-id'),
			name : $('input[name=infoaddressname]').val(),
			tel : $('input[name=infoaddresstel]').val(),
			address : $('input[name=infoaddressaddress]').val()
		};
		if(confirm('确定要修改收件人信息吗？')){
			Http('post','html','editOrderOfAddress',postdata,function(data){
				if(data == 1){
					alert('已修改');
					location.href = "";
				}else{
					alert(data);
				}
			},true);
		}
	});
	
	//查看快递信息
	$('.info_getexpressinfo').click(function(){
		var postdata = {
			name : $(this).attr('data-name'),
			number : $(this).attr('data-number')
		};
		Http('post','json','getexpressinfo',postdata,function(data){
			if(data.status == 1){
				$('.getexpressinfobox .input_form').html(data.data);
				$('.getexpressinfobtn').hide();
				$('.getexpressinfobox').css({'display':'-webkit-box'});
			}else{
				alert(data.data);
			}
		},true);
	});
	
	
	//////////////////////团列表页面
	//全团退款
	$('.group_allrefund').click(function(){	
		var id = $(this).attr('data-id');
		Http('post','html','refundgroup',{id:id},function(data){
			if(data == 1){
				alert('已提交给计划任务处理，等待系统处理退款。');
				location.href = "";
			}else{				
				alert(data.data);
			}
		},true);
	});
	
	///////////////////////评价页面
	$('.select_commnet_good').click(function(){ // 检索商品
		var id = $('input[name=selectgood]').val();
		if(id == ''){
			alert('先填写商品id');return false;
		}
		Http('post','json','selectcommentgood',{id:id},function(data){
			if(data.status == 1){
				$('.comment_good').html(data.data);
			}else{
				alert(data.data);
			}
		},true);		
	});
	
	$('form[name=addcomment_form]').submit(function(){ //提交保存
		var gid = $('input[name=commentgoodid]').val(),
			text = $('textarea[name=text]').val(),
			nickname = $('input[name=nickname]').val(),
			headimg = $('input[name=headimg]').val();
		if(typeof(gid) == 'undefined'){
			alert('你还没有选择评价的商品');return false;
		}
		if(text == ''){
			alert('你还没有填写评价内容');return false;
		}
		if(nickname == ''){
			alert('你还没有填写评价人昵称');return false;
		}		
		if(headimg == ''){
			alert('你还没有填写评价人头像');return false;
		}		
	});
	
	//随机查询获取评价人
	$('.rand_getnickname').click(function(){
		Http('post','json','getnickname',{},function(data){
			if(data.status == 1){
				$('input[name=nickname]').val(data.data.nickname);
				$('input[name=headimg]').attr('value',data.data.avatar).parents('.input_form ').find('.input-group').show().find('img').attr('src',data.data.avatar);
			}else{
				alert(data.data);
			}
		},true);
	});
	
	//查询管理员
	$('.search_admin').click(function(){
		var nickname = $('input[name=adminnickname]').val();
		if(nickname == ''){
			alert('填写完整的昵称');return false;
		}
		Http('post','json','getadmin',{nickname:nickname},function(data){
			if(data.status == 1){
				$('input[name=adminopenid]').val(data.data.openid);
				$('input[name=adminheadimg]').val(data.data.headimgurl);
				$('#adminheadimg').attr('src',data.data.headimgurl);
			}else{
				alert(data.data);
			}
		},true);		
	});
	
	//导入excel文件
	$("body").on("change","input[name='orderfile']",function(){
		var filePath=$(this).val();
		if(filePath.indexOf("csv") != -1){
			var arr=filePath.split('\\');
			var fileName=arr[arr.length-1];
			$(".is_select_file").html(fileName);
		}else{
			alert('请选择csv格式的文件');
			return false 
		}
	});
	
	$('input[name=import]').click(function(){
		var filename = $("input[name='orderfile']").val();
		if(filename == ''){
			alert('请先选择要导入的数据文件，格式是csv格式的。此功能是批量发货功能，流程是：先将要发货的订单导出为csv格式的文件，填好快递名称和编号后使用此功能导入。');return false;
		}
		if(!confirm('导入前请先确定文件内是否已填写快递名称和编号，并且需要和平台订单编号一 一对应。否则可能导致数据出错！！！')){
			return false;
		}
	});
	
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	//拒绝退款
	function refuserefundOrder(postdata){
		if(confirm('拒绝退款后订单进入正常状态，确定要拒绝退款吗？')){
			Http('post','html','refuserefund',postdata,function(data){
				if(data == 1){
					alert('已拒绝退款');
					location.href = "";
				}else{
					alert(data);
				}
			},true);
		}
	}
	
	//单个订单退款方法
	function refundOrder(postdata){
		if(confirm('确定要给此订单退款吗？')){
			Http('post','html','refundsingle',postdata,function(data){
				if(data == 1){
					alert('已退款');
					location.href = "";
				}else{
					alert(data);
				}
			},true);				
		}
	}
	
	
	//发货和修改快递
	function sendGoodAndEditExpress(orderdealtype,outbox,orderid){
		var postdata = {
			expresstype : outbox.find('.expresstype:checked').val(),
			expressname : outbox.find('select[name=expressname]').val(),
			expressnumber : outbox.find('input[name=expressnumber]').val(),
			id : orderid,
			type : orderdealtype
		};
		if(postdata.expresstype == '1' && (postdata.expressname == '' || postdata.expressnumber == '' || postdata.expressnumber == undefined)){
			alert('快递名称和快递编号必填');return false;
		}
		if(confirm('发货后订单状态变为已发货，状态不可恢复，确定要发货吗？')){
			Http('post','html','sendgood',postdata,function(data){
				if(data == 1){
					alert('操作成功');
					location.href = "";
				}else{
					alert(data);
				}
			},true);
		}
	}
	
	
	//切换内容
	function changeItem(elemt,hideelemts,callback){
		elemt.change(function(){
			var showelemt = $(this).attr('data-show');
			hideelemts.hide();
			$('.'+showelemt).show();
			if(callback) callback(showelemt);
		});
	}
	//http请求
	 function Http(type,datatype,op,data,successCall,isloading,beforeCall,comCall){
		$.ajax({
			type: type,
			url: ajaxUrl(op),
			dataType: datatype,
			data : data,
			beforeSend:function(){
				if(beforeCall) beforeCall();
				if(isloading) loading();
			},
			success: function(data){
				if(successCall) successCall(data);
			},
			complete:function(){
				if(comCall) comCall();
				if(isloading) loaded();
			},				
			error: function(xhr, type){
				console.log(xhr);
			}
		});	
	};

	function ajaxUrl(op){
		return window.sysinfo.siteroot + '/web/index.php?c=site&a=entry&op='+op+'&do=Ajaxreq&m=mihua_mall';
	}
	
	function loading(){
		var html = 
			'<div id="loading" class="loading">'+
			'<div class="load_mask"></div>'+
			'<div class="modal-loading">'+
			'	<div class="modal-loading-in">'+
			'		<img style="width:48px; height:48px;" src="../attachment/images/global/loading.gif"><p>处理中，勿关闭本页</p>'+
			'	</div>'+
			'</div>'+
			'</div>';
		$(document.body).append(html);
	};
	
	function loaded(){
		$('.loading').remove();
	}
	
})
