	
	function game(){
		this.address = null;
		this.actbtn = null;
		this.getedid = 0;
		this.formed = false;
		this.ing = false;
	}
	game.prototype.init = function() {
		this.bind();
		if( settings.islimit == 1 ){
			this.limit();
		}
	};
	game.prototype.bind = function() {
		var _self = this;
		
		$('.close_btn').click(function(){
			$(this).parents('.close_me').hide();
		});
		
		$('.rule-btn').on('touchstart',function(e){
			$(this).addClass('rule-activity').siblings().removeClass('rule-activity');
			var type = $(this).attr('type');
			$('.'+type).show().siblings().hide();
			e.preventDefault();
		});

		/*prize*/
		$('.btn_changeprize').click(function(){
			var $this = $(this);
			var isminus = $this.attr('ism');
			var need = $this.attr('need');
			var pid = $this.attr('pid');
			var type = $this.attr('type');

			if( _self.address == null && type == 3 && settings.sendtype == 0 ){
				$('#address_box').show();
				_self.actbtn = $this;
				return false;
			}

			if( isminus == '1' ){
				var alertstr = '兑换此奖品将扣除您'+need+settings.cname;
			}else{
				var alertstr = '确定要兑换此奖品吗？';
			}
			tool.confirm(alertstr,function(){
				tool.ajax(tool.url('ajaxdeal','changeprize'),'post','json',{pid:pid,address:_self.address},function(data){
					tool.alert(data.res);
					if( data.status == '200' ){
						var num = $this.parents('.prize_item_r').find('.last_num').text()*1;
						$this.parents('.prize_item_r').find('.last_num').text(num-1);
					}
				},false);
			});
		});

		$('.btn_setaddress').click(function(){
			var data = {
				name : $('input[name="name"]').val(),
				tel : $('input[name="tel"]').val(),
				address : $('textarea[name="address"]').val(),
			}
			if( data.name == '' ){
				tool.alert('请填写姓名');
				return false;
			}
			if( data.tel == '' || !tool.regex.tel.test( data.tel ) ){
				tool.alert('请填写正确的手机号');
				return false;
			}
			if( data.address == '' ){
				tool.alert('请填写收货地址');
				return false;
			}			
			tool.confirm('填写后不能修改，确定吗？',function(){
				_self.address = data;
				$('#address_box').hide();
				_self.actbtn.triggerHandler('click');
			});

		});

		$('.geted_info').click(function(){
			var $this = $(this);
			var gid = $this.attr('getid');
			if( gid == _self.getedid ){
				$('#info_box').show();
			}else{
				tool.ajax(tool.url('ajaxdeal','addressinfo'),'post','json',{gid:gid},function(data){
					if( data.status == '200' ){
						$('.address_box_name').text( data.obj.getname );
						$('.address_box_tel').text( data.obj.gettel );
						$('.address_box_add').text( data.obj.address );
						if( data.obj.expressname == null ){
							$('.address_box_exn').parents('.form_group').hide();
						}else{
							$('.address_box_exn').parents('.form_group').show();
							$('.address_box_exn').text(data.obj.expressname);
						}
						if( data.obj.expressnumber == null ){
							$('.address_box_exm').parents('.form_group').hide();
						}else{
							$('.address_box_exm').parents('.form_group').show();
							$('.address_box_exm').text(data.obj.expressnumber);
						}
						
						$('#info_box').show();
						_self.getedid = gid;
					}else{
						tool.alert(data.res);
					}
				},false);
			}
		});

		$('.to_getprize').click(function(){
			var url = $(this).attr('url');
			$('.qrcode').text(url);
			$('#shop_box').show();
		});	

		$('#get_poster').click(function(){
			if( !_self.formed && settings.isform == 1 ){
				$('#form_box').show();
				return false;
			}
			if( _self.ing ) return false;
			_self.ing = true;
			tool.ajax(tool.url('ajaxdeal','getposter'),'post','json',{},function(data){
				tool.alert(data.res,function(){
					_self.ing = false;
					if( data.status == '200' ){
						wx.closeWindow();
					}
				});
			});
		});
		$('.btn_setform').click(function(){
			var pdata = {
				name : $('input[name="fname"]').val(),
				tel : $('input[name="ftel"]').val(),
			}
			if( pdata.name == '' ){
				tool.alert('请填写姓名');
				return false;
			}
			if( pdata.tel == '' || !tool.regex.tel.test( pdata.tel ) ){
				tool.alert('请填写正确的手机号');
				return false;
			}		
			tool.confirm('填写后不能修改，确定吗？',function(){
				tool.ajax(tool.url('ajaxdeal','setform'),'post','json',pdata,function(data){
					if( data.status == '200' ){
						_self.formed = true;
						$('#form_box').hide();
						//$('#get_poster').triggerHandler('click');

						tool.ajax(tool.url('ajaxdeal','getposter'),'post','json',{},function(data){
							tool.alert(data.res,function(){
								_self.ing = false;
								if( data.status == '200' ){
									wx.closeWindow();
								}
							});
						});
						
					}else{
						tool.alert(data.res);
					}
				});
			});

		});

	};

	game.prototype.limit = function(){
		var _self = this;
		tool.showModal(true);
		wx.ready(function (){
			wx.getLocation({
				success: function (res) {
					tool.ajax(tool.url('ajaxdeal','location'),'post','json',{latitude:res.latitude,longitude:res.longitude},function(data){
						if(data.status != '200'){
							tool.alert(data.res,function(){
								wx.closeWindow();
							});
						}
						tool.showModal(false);
					},true);
				},
				cancel: function (res) {
					var str = '请允许定位,否则无法参与活动';
					tool.showModal(false);
					tool.alert(str,function(){
						_self.limit();
					});
				},
				fail: function (res) {
					var str = JSON.stringify(res);
					tool.alert(str,function(){
						wx.closeWindow();
					});
				}
			});
		});

	}



	var wxJs = {};	

	wxJs.share = function(shareData){
		wx.ready(function (){
			//分享朋友
			wx.onMenuShareAppMessage({
				title: shareData.sharetitle,
				desc: shareData.sharedesc,
				link: shareData.sharelink,
				imgUrl:shareData.shareimg,
				trigger: function (res) {
				},
				success: function (res) {
					
				},
				cancel: function (res) {
				},
				fail: function (res) {
					//alert(JSON.stringify(res));
					//alert(shareData.title)
				}
			});
			//朋友圈
			wx.onMenuShareTimeline({
				title: shareData.sharetitle,
				link: shareData.sharelink,
				imgUrl:shareData.shareimg,
				trigger: function (res) {
				},
				success: function (res) {
					wxJs.shareSuccess();
				},
				cancel: function (res) {
				},
				fail: function (res) {
					//alert(JSON.stringify(res));
				}
			});
		});
	};



$(function(){

	var hideArr = [
		'menuItem:share:qq',
		'menuItem:share:weiboApp',
		'menuItem:share:QZone',
		'menuItem:copyUrl',
		'menuItem:openWithQQBrowser',
		'menuItem:openWithSafari',
		'menuItem:favorite',
		'menuItem:share:facebook',
		'menuItem:share:email',
		
	];
	hideArr.push('menuItem:share:appMessage');
	hideArr.push('menuItem:share:timeline');
	
	wx.ready(function (){
		wx.hideMenuItems({
		    menuList: hideArr
		});
		wxJs.share(settings);	
	});
	
	var play = new game();
	play.init();
	/*tool.ajax(tool.url('ajaxdeal','queue'),'post','json',{},function(data){},true);*/
});

	

	
