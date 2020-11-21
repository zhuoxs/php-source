$(function(){

	common();

	
	// 拖拽
	$( ".multi-img-details" ).sortable();
	$( ".multi-img-details" ).disableSelection();	

	$('.validform').Validform({
		tiptype : function(str){
			webAlert(str);
		}
	});

	$('.upuser').click(function(){
		var postdata = {
			aid : $(this).attr('aid'),
		};
		Http('post','json','upuser',postdata,function(data){
			webAlert(data.res);
			if(data.status == 200){
				setTimeout(function(){
					location.href = "";
				},500);
			}
		},true);
	});

	// 测试发海报
	$('.confirm_testpost').click(function(){
		var postdata = {
			id : $(this).attr('id'),
			nick : $(this).parents('.dropdown_menu').find('input').val(),
		};
		Http('post','json','testpost',postdata,function(data){
			alert(data.res);
		},true);

	});

	// 测试发链接
	$('.confirm_testlink').click(function(){
		var postdata = {
			linkmess : $('textarea[name="linkmess"]').val(),
			linklink : $('input[name="linklink"]').val(),
			nick : $(this).parents('.dropdown_menu').find('input').val(),
		};
		Http('post','json','testlink',postdata,function(data){
			alert(data.res);
		},true);

	});

	//添加奖品
	$('#createPrize').click(function(){
		
		var postdata = {
			name : $('input[name="name"]').val(),
			desc : $('input[name="desc"]').val(),
			type : $('input[name="type"]:checked').val()*1,
			min : $('input[name="min"]').val()*1,
			max : $('input[name="max"]').val()*1,
			cardtype : $('input[name="cardtype"]:checked').val()*1,
			cardvalue : $('input[name="cardvalue"]').val()*1,
			carduse : $('input[name="carduse"]').val()*1,			
			num : $('input[name="num"]').val(),
			start : $('input[name="time[start]"]').val(),
			end : $('input[name="time[end]"]').val(),
			id : $(this).attr('actid'),
			prizeid : $(this).attr('prizeid')*1,
			pic : $('input[name="pic"]').val(),
			qrtype : $('input[name="qrtype"]:checked').val()*1,
			pertimes : $('input[name="pertimes"]').val(),
		};
		
		if( postdata.name == '' || postdata.desc == '' ){
			webAlert('请填写奖品名称和描述');
			return false;
		}
		if( postdata.type == 0 || postdata.type == 1 || postdata.type == 2 ){
			if( postdata.min == '' || isNaN( postdata.min ) || postdata.min < 1 ){
				webAlert('奖励数值必须大于等于1');
				return false;
			}
			if( postdata.max == '' || isNaN( postdata.max ) || postdata.max < postdata.min ){
				webAlert('奖励数值最大数值必须大于最小金额');
				return false;
			}
		}else if( postdata.type == 3 ){
			if( postdata.cardvalue == '' || isNaN( postdata.cardvalue ) ){
				webAlert('请填写卡券面值');
				return false;
			}
			if( postdata.carduse == '' || isNaN( postdata.carduse ) ){
				webAlert('请填写卡券使用的消费条件');
				return false;
			}		
			if( typeof postdata.cardtype == 'undefined' || isNaN( postdata.cardtype ) ){
				webAlert('请选择卡券类型');
				return false;
			}
		}

		if( (postdata.num == '' || isNaN( postdata.num )) && postdata.prizeid == 0 ){
			webAlert('请填写生成个数');
			return false;
		}
		if( postdata.num > 500 && postdata.qrtype == 1 ){
			webAlert('奖品生成个数不能大于500个，若大于500个请多次生成。');
			return false;
		}
		if( postdata.start == postdata.end ){
			webAlert('请选择有效时间');
			return false;
		}

		if(confirm('确定要提交操作吗？')){
			Http('post','json','addprize',postdata,function(data){
				webAlert(data.res);
				if(data.status == 200){
					setTimeout(function(){
						location.href = "";
					},500);
				}
			},true);
		}
	});


	$('.keyclass').change(function(){
		var key = $(this).val();
		Http('post','json','checkkey',{key:key},function(data){
			if(data.status == 201){
				webAlert(data.res);
			}
		},true);
	})

	// 增减积分
	$('.confirm_copyrule').click(function(){
		var $this = $(this);
		var parent = $this.parents('.jsDropdownsList')
		var data = {
			money : parent.find('input[name=credit]').val(),
			uid : $(this).attr('id')
		};
		
		if(data.money == '' || data.money == 0 ||  !/\d/.test(data.money) ){
			webAlert('请填写正确的数值');
			return false;
		}
		if(confirm('确定要操作吗？')){
			Http('post','json','editmoney',data,function(data){
				if(data.status == 200){
					webAlert('操作成功');
					setTimeout(function(){
						location.href = "";
					},500);
				}else{
					webAlert(data.res);
				}
			},true);
		}

	})
	// 编辑奖品
	$('.show_edit').click(function(){
		$('.edit_prize_box').show();
	});


	// 删除属性
	$('body').on('click','.delete_params',function(){
		$(this).parents('.edit_right_item').remove();
	});


	// 导入数据 改变显示文字
	$('input[name=inputfile]').change(function(){
		var v = $(this).val();
		$(this).prev().text(v);
	});

	// 修改收货地址
	$('#edit-address').click(function(){
		var data = {
			name : $('input[name=addressname]').val(),
			tel : $('input[name=addresstel]').val(),
			address : $('input[name=addressstreet]').val(),
			mark : $('input[name=addressmark]').val(),
			logid : $(this).attr('logid')
		};
		if(data.name == '' || data.tel == '' || data.address == ''){
			alert('请填写完整信息'); return false;
		}
		if(confirm('确定修改收货地址吗？')){
			Http('post','html','editaddress',data,function(data){
				if(data == 1){
					alert('已修改');
					location.href = "";
				}else{
					alert('修改失败');
				}
			},true);
		}
	});

	// 发货 修改快递
	$('#edit-express').click(function(){
		var data = {
			name : $('input[name=expressname]').val(),
			number : $('input[name=expressnumber]').val(),
			logid : $(this).attr('logid')
		};
		if(data.name == '' || data.number == ''){
			alert('请填写完整信息'); return false;
		}
		if(confirm('确定执行操作吗？')){
			Http('post','html','editexpress',data,function(data){
				if(data == 1){
					alert('操作完成');
					location.href = "";
				}else{
					alert('操作失败');
				}
			},true);
		}
	});


	// 选择区域
	$('body').on('click','#js_selectarea_opt a',function(){
		var  obj = new areaSelect($(this).next());
		obj.init();
		$('.ui-draggable').show();
	});

	// 管理员
	$('#add_admin').click(function(){
		var html = '<div class="edit_right_item admin_item">'
						+'管理员昵称<span class="frm_input_box frm_input_box_150">'
							+'<input type="text" class="frm_input"  name="adminnick[]" value="">'
							+'<input type="hidden" class="frm_input"  name="adminhead[]" value="">'
							+'<input type="hidden" class="frm_input"  name="adminopenid[]" value="">'
						+'</span>'
						+'<a href="javascript:;" class="search_admin"> 搜索</a> 管理员头像 '
						+'<span class="frm_input_box_150" style="display: inline-block;">'
							+' <img src="" width="40px" height="40px">'
						+'</span>'
						+'<a href="javascript:;" class="delete_params"> 删除</a>'
					+'</div>';
		$('.group_admin_box').append(html);
	});

	$('body').on('click','.search_admin',function(){
		var _this = $(this);
		var postdata = {
			nick : _this.parents('.admin_item').find('input[name="adminnick[]"]').val()
		};
		Http('post','json','findadmin',postdata,function(data){
			if(data.status == 200){
				_this.prev().find('input[name="adminnick[]"]').val(data.obj.nick).next().val(data.obj.headimgurl).next().val(data.obj.openid);
				_this.next().find('img').attr('src',data.obj.headimgurl);
				webAlert('已搜索到，保存后才生效');
			}else{
				webAlert(data.res);
			}
		},true);
	});



	// 修改密码
	$('.confirm_editpass').click(function(){
		var $this = $(this);
		var postdata = {
			id : $this.attr('id'),
			pass1 : $('input[name="nowpass1"]').val(),
			pass2 : $('input[name="nowpass2"]').val()
		};
		if( postdata.pass1 !== postdata.pass2 ) {
			webAlert('重复密码必须一样');
			return false;
		}
		if(confirm('确定要修改密码吗？')){
			Http('post','json','editpassword1',postdata,function(data){
				webAlert(data.res);
				if(data.status == 200){
					$this.parents('.jsDropdownsList').hide();
				}
			},true);
		}
	});

	// 修改地址
	$('#js_editAddress').click(function(){
		var $this = $(this);
		var data = {
			id : $this.attr('oid'),
			name : $this.parents('.msg').find('input[name="name"]').val(),
			tel : $this.parents('.msg').find('input[name="tel"]').val(),
			address : $this.parents('.msg').find('input[name="address"]').val(),
		};
		
		if(confirm('确定要修改吗？')){
			Http('post','json','editaddress',data,function(data){
				if(data.status == 200){
					webAlert(data.res);
					setTimeout(function(){
						location.href = "";
					},500);
				}else{
					webAlert(data.res);
				}
			},true);
		}		
	});

	// 修改提货地址
	$('#js_editshopinfo').click(function(){
		var $this = $(this);
		var data = {
			id : $this.attr('oid'),
			name : $this.parents('.msg').find('input[name="shopname"]').val(),
			tel : $this.parents('.msg').find('input[name="shoptel"]').val(),
			address : $this.parents('.msg').find('input[name="shopaddress"]').val(),
		};
		
		if(confirm('确定要修改吗？')){
			Http('post','json','editshopinfo',data,function(data){
				if(data.status == 200){
					webAlert(data.res);
					setTimeout(function(){
						location.href = "";
					},500);
				}else{
					webAlert(data.res);
				}
			},true);
		}		

	});



	// 复制链接
	require(['jquery.zclip'], function(){
		$('.copy_url').zclip({
			path: './resource/components/zclip/ZeroClipboard.swf',
			copy: function(){
				return $(this).attr('data-href');
			},
			afterCopy: function(){
				webAlert('复制成功');
			}
		});
	});
	
	// 清理缓存
	$('.deletecache').click(function(){
		var type = $(this).attr('type');
		if(confirm('确定删除吗？')){
			Http('post','html','deletecache',{type:type},function(data){
				if(data == 1){
					webAlert('已删除');
				}else{
					webAlert('删除失败');
				}
			},true);
		}
	});


	// 导入数据 改变显示文字
	$('input[name=inputfile]').change(function(){
		var v = $(this).val();
		$(this).prev().text(v);
	});


	// 编辑排序
	var nowvalue;
	$('.edit_number_input').focus(function(){
		$(this).addClass('edit_number_input_act');
		nowvalue = $(this).val();
	});
	$('.edit_number_input').blur(function(){
		$(this).removeClass('edit_number_input_act');
		if(nowvalue == $(this).val()) return false;
		var data = {
			type : $(this).attr('inputtype'),
			value : $(this).val(),
			name : $(this).attr('inputname'),
			id : $(this).attr('id')
		};
		Http('post','html','editvalue',data,function(data){},true);
	});


	// 搜索
	$('.js_search').click(function(){
		$(this).parents('form').submit();
	});

	// 拉黑和恢复
	$('.edit_user').click(function(){
		var data = {
			type : $(this).attr('type'),
			id : $(this).attr('id')
		};
		if(confirm('确定执行操作吗？')){
			Http('post','html','edituser',data,function(data){
				if(data == 1){
					alert('操作完成');
					location.href = "";
				}else{
					alert('操作失败');
				}
			},true);
		}
	});


	



})

	function common(){




		$('body').on('click','.hide_item',function(){
			var elem = $(this).attr('hideitem');
			if( elem ){
				var arr = elem.split(",");
				for (var i = 0; i < arr.length; i++) {
					$(arr[i]).hide();
				}
			}
		});
		$('body').on('click','.show_item',function(){
			var elem = $(this).attr('showitem');
			if( elem ){
				var arr = elem.split(",");
				for (var i = 0; i < arr.length; i++) {
					$(arr[i]).show();
				}
			}
		});
		//
		$('.model_close').click(function(){
			$(this).parents('.my_model').hide();
		});

		//下拉选择
		$('body').on('click','.radio_list_item',function(){
			var txt = $(this).text();
			$(this).find('input').prop('checked',true);
			$(this).parents('.dropdown_menu').find('.jsBtLabel').text(txt).end().addClass('open');

		});
		$('.radio_list_input:checked').each(function(){
			var txt = $(this).parent().text();
			$(this).parents('.dropdown_menu').find('.jsBtLabel').text(txt);
		});

		//点击相应位置隐藏筛选/下拉
		$('body').on('click',function(e) {
			if($(e.target).parents('.dropdown_topbar').length <= 0){
				$('.dropdown_menu').each(function(){
					var $this = $(this);
					if($this.hasClass('open')) $this.removeClass('open');
				})
			}
		});	

		// 切换参数设置
		$('.js_top').click(function(){
			$('.js_top').removeClass('selected');
			var thisclass = $(this).attr('showme');
			$(this).addClass('selected');
			$('.settings_group').each(function(){
				if($(this).hasClass(thisclass)){
					$(this).show();
				}else{
					$(this).hide();
				}
			})
		});

		// table内编辑框
		$('.drop_down_editbtn').click(function(){
			$('.jsDropdownsList').hide();
			$(this).next().find('.jsDropdownsList').toggle();
		})
		$('body').on('click','.dropdown_edit_cancel',function(){
			$(this).parents('.jsDropdownsList').hide();
		});

		// 自动选择单选框
		$('.frm_radio').each(function(){
			var $this = $(this);
			if($this.attr('checked')){
				$this.parents('.frm_radio_label').addClass('selected');
			}
		});
		$('.frm_checkbox').each(function(){
			var $this = $(this);
			if($this.attr('checked')){
				$this.parents('.frm_checkbox_label').addClass('selected');
			}
		});		

		// checkbox
		$('body').on('click','.frm_radio_label',function(e){
			e.preventDefault();
			if( $(this).hasClass('disabled') ) return false;
			var $this = $(this);
			var name = $this.find('input[type=radio]').prop('name');
			
			$('input[name='+name+']').each(function(){
				$(this).prop('checked',false);
				$(this).parents('.frm_radio_label').removeClass('selected');
			})
			$this.addClass('selected').find('input').prop('checked',true);
		});


		// 复选框 包括全选
		$('body').on('click','.frm_checkbox_label',function(e){
			var checkbox = $(this).find('input[type=checkbox]');
			if( $(this).hasClass('disabled') ) return false;
			
			var isall = $(this).prop('for') == 'selectAll';
			if( checkbox.prop("checked") ){
				checkbox.prop("checked",false);
				$(this).removeClass('selected');
				if(isall){
					$('tbody input[type=checkbox]').each(function(){
						$(this).parents('.frm_checkbox_label').removeClass('selected');
						$(this).prop("checked",false);
					})
				}
			}else{
				checkbox.prop("checked",true);
				$(this).addClass('selected');
				if(isall){
					$('tbody input[type=checkbox]').each(function(){					
						$(this).parents('.frm_checkbox_label').addClass('selected');
						$(this).prop("checked",true);
					})
				}
			}
			e.preventDefault();
		});


		// 下拉
		$('body').on('click','.dropdown_menu',function(e){
			var $this = nowdropdown = $(this);
			if($this.hasClass('open')){
				$this.removeClass('open');
			}else{
				$this.addClass('open');
				$('.dropdown_menu').not(this).each(function(){
					if( $(this).hasClass('open') ) $(this).removeClass('open');
				})
			}
		});

		// 切换
		$('body').on('click','.change_item .frm_radio_label',function(){
			var item = $(this).parents('.change_item').attr('item');
			$('.'+item).hide();
			var show = $(this).attr('show');
			$('.'+show).show();		
		});
		
		// select
		$('.select_item').click(function(){
			var id = $(this).attr('id');
			var text = $(this).text();
			var parent = $(this).parents('.dropdown_menu');
			parent.find('input').val(id);
			parent.find('.jsBtLabel').text(text);
		})

	};


	function webAlert(str){
		if($('#webalert').length > 0){
			$('#webalert .alertcontent').text(str);
			alertShow();
		}else{
			var div = '<div id="webalert" style="position:fixed;z-index:99999;top:20px;left:50%;width:500px;height:35px;margin-left:-250px;background:red;">\
					<div class="alertcontent" style="font-size: 16px;color:#fff;text-align:center;line-height: 35px;">'+str+'</div></div>';
			$('body').append(div);
			alertShow();
		}
	};

	function alertShow() {
		$('#webalert').show('fast',function(){
			setTimeout(function(){$('#webalert').hide();},3000);
		})
	};

	//http请求
	 function Http(type,datatype,op,data,successCall,isloading,beforeCall,comCall){
		$.ajax({
			type: type,
			url: op.indexOf('://') >= 0 ? op : ajaxUrl(op),
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
		return window.sysinfo.siteroot + 'web/index.php?c=site&a=entry&op='+op+'&do=ajax&m=zofui_posterhelp';
	};
	
	function loading(){
		var html = 
			'<div id="loading" class="loading">'+
			'<div class="load_mask"></div>'+
			'<div class="modal-loading">'+
			'	<div class="modal-loading-in">'+
			'		<img style="width:48px; height:48px;display:inline-block" src="../attachment/images/global/loading.gif"><p>处理中，勿关闭本页</p>'+
			'	</div>'+
			'</div>'+
			'</div>';
		$(document.body).append(html);
	};
	
	function loaded(){
		$('.loading').remove();
	};


	/***地区选择***/
	function areaSelect (element) {
		//if(typeof areaSelect.areaobj === 'object') return areaSelect.areaobj;
		this.elem = element;
		//areaSelect.areaobj = this;
		this.bindEvent();
	};

	areaSelect.prototype.init = function(){
		var self = this;
		if ($('.delivery_privince .js_dd_list').html() == ''){		
			var province = '';
			for(var i=0;i<citydata.length;i++){
				province += '<dd>'
								+'<a href="javascript:;" class="jsLevel father_menu jsLevel1" data-name="'+citydata[i].text+'">'
									+'<span class="item_name">'+citydata[i].text+'</span>'
								+'</a>'
							+'</dd>';
			}
			$('.delivery_privince .js_dd_list').html(province);
		}
		
		var provincevalue = self.elem.find('.area_province_input').val();

		if(provincevalue != ''){
			var cityvalue = self.elem.find('.area_city_input').val();
			var countyvalue = self.elem.find('.area_county_input').val();
			
			$('.jsLevel1').each(function(){	
				if($(this).attr('data-name') == provincevalue) $(this).addClass('selected');
			});
			
			self.appendCityStr(provincevalue,cityvalue); //城市

			countyvalue = countyvalue.replace(/,$/,'');
			countyarray = countyvalue.split(","); //数组
			
			self.appendCountyStr(provincevalue,cityvalue,countyarray); //区县
		}else{
			$('.delivery_city .js_dd_list').empty();
			$('.delivery_county .js_dd_list').empty();
		}

	};

	areaSelect.prototype.bindEvent = function(){
		var self = this;
		//点击一级展开二级
		$('body').off('click','.delivery_box .jsLevel1').on('click','.delivery_box .jsLevel1',function(){
			var province = $(this).attr('data-name');
			$('.delivery_privince .selected').removeClass('selected');
			$(this).addClass('selected');
			self.appendCityStr(province,'');
		});		
		//点击二级展开三级
		$('body').off('click','.delivery_box .jsLevel2').on('click','.delivery_box .jsLevel2',function(){
			var province = $(this).attr('data-province'),
				city = $(this).attr('data-name');
			$('.delivery_city .selected').removeClass('selected');
			$(this).addClass('selected');
			self.appendCountyStr(province,city,[]);
		});	

		//选择区县
		$('body').off('click','.delivery_box .jsLevel3').on('click','.delivery_box .jsLevel3',function(){

			if($(this).hasClass('disabled')) return false;
			/*var province = $(this).attr('data-province'),
				city = $(this).attr('data-city'),
				county = $(this).attr('data-name');*/

			if($(this).hasClass('selected')){
				$(this).removeClass('selected');
			}else{
				$(this).addClass('selected');
			}
		});	
	
		//确定选择
		$('#confirm_indelivery').off('click').on('click',function(){

			var province = '',
				city = '',
				county = '';
			$('.delivery_county .selected').each(function(){
				province = $(this).attr('data-province');
				city = $(this).attr('data-city');
				county += $(this).attr('data-name') + ',';
			});
		
			self.elem.find('.area_province_input').val(province).next().val(city).next().val(county);
			self.elem.find('.delivery_item_province').text(province).next().text(city).next().text(county);
			self.hideDeliveryTable();
		});
		
		
		//关闭操作框
		$('.delivery_close').off('click').on('click',function(){
			self.hideDeliveryTable();
		});			
		
	};
	
	//插入城市数据
	areaSelect.prototype.appendCityStr = function (province,city){
		
		for(var i=0;i<citydata.length;i++){
			if(citydata[i].text == province){
				var citystr = '';
				for(var j=0;j<citydata[i].children.length;j++){
					var selectstr = '';
					if(city == citydata[i].children[j].text) selectstr = 'selected';
					citystr += '<dd>'
									+'<a href="javascript:;" class="jsLevel father_menu jsLevel2 '+selectstr+'" data-province="'+province+'" data-name="'+citydata[i].children[j].text+'">'
										+'<span class="item_name">'+citydata[i].children[j].text+'</span>'
									+'</a>'
								+'</dd>';
					
				}
				$('.delivery_city .js_dd_list').html(citystr);
				$('.delivery_county .js_dd_list').empty();
				return false;
			}
		}		
		
	};
	
	areaSelect.prototype.appendCountyStr = function (province,city,countyarray){
		//已经选择了的地区，
		var selectedcountystr = '';
		$('.area_county_input').each(function(){
			selectedcountystr += $(this).val() + ',';
		});
		selectedcountystr = selectedcountystr.replace(/,$/,'');
		selectedcountystr = selectedcountystr.split(","); //数组
		
		for(var i=0;i<citydata.length;i++){
			if(citydata[i].text == province){
				for(var j=0;j<citydata[i].children.length;j++){			
					if(citydata[i].children[j].text == city){
						var county = '';
						for(var k=0;k<citydata[i].children[j].children.length;k++){
							if($.inArray(citydata[i].children[j].children[k], countyarray) >= 0  || $.inArray(citydata[i].children[j].children[k], selectedcountystr) < 0 ){
								var selectedstr = '';
								if( $.inArray(citydata[i].children[j].children[k], countyarray) >= 0 ) selectedstr = 'selected';
								
								county += '<dd>'
												+'<a href="javascript:;" class="jsLevel father_menu jsLevel3 '+selectedstr+'" data-province="'+province+'" data-city="'+city+'" data-name="'+citydata[i].children[j].children[k]+'">'
													+'<span class="item_name">'+citydata[i].children[j].children[k]+'</span>'
												+'</a>'
											+'</dd>';								
							}
						}
						
						$('.delivery_county .js_dd_list').html(county);
						return false;						
					}
				}
			}
		}
	};
	
	areaSelect.prototype.hideDeliveryTable = function (){
		$('.delivery_box .selected').removeClass('selected');
		$('.ui-draggable').hide();
		self = null;
	};
