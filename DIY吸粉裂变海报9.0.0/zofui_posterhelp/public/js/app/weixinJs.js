	
		var wxJs = {};	
		
		wxJs.share = function(shareData){
			var data = {
				title: shareData.sharetitle,
				desc: shareData.sharedesc,
				link: shareData.sharelink,
				imgUrl:shareData.shareimg,
				trigger: function (res) {},
				success: function (res) {},
				cancel: function (res) {},
				fail: function (res) {alert(JSON.stringify(res));}
			};
			wx.onMenuShareAppMessage(data);
			//分享QQ
			wx.onMenuShareQQ(data);
			//分享QQ空间
			wx.onMenuShareQZone(data);	
			//朋友圈
			wx.onMenuShareTimeline(data);
		};

		var hideArr = [
			'menuItem:share:timeline',
			'menuItem:share:appMessage',
			'menuItem:share:qq',
			'menuItem:share:facebook',
			'menuItem:share:weiboApp',
			'menuItem:share:QZone',
			'menuItem:share:qq',
			'menuItem:copyUrl',
			'menuItem:openWithSafari',
			'menuItem:share:email',
			'menuItem:originPage',
			'menuItem:editTag',
			'menuItem:delete',
			'menuItem:readMode',
			'menuItem:openWithQQBrowser'
		];
		if( settings.hide = 1 ){
			wx.hideMenuItems({
				menuList: hideArr
			});	
		}
		
		function getLocation(call){
			if(  settings.islimit == 0 ){
				if( call ) call();
				return false;
			}
			
			common.showIndicator();

			if( sysinfo.openid.length < 10 ){
				var data = {latitude:22.729254,longitude:114.01135,country : settings.country};
				common.Http('post','json',common.createUrl('ajaxdeal','location'),data,function(res){
					if(res.status == 200){
						if( call ) call();
					}else{
						common._alert(res.res,function(){});
					}
					common.hideIndicator();
				});
			}else{
				wx.ready(function (){
				wx.getLocation({
					success: function (res) {
						var data = {latitude:res.latitude,longitude:res.longitude,dealop:settings.op,country:settings.country};
						common.Http('post','json',common.createUrl('ajaxdeal','location'),data,function(res){
							if(res.status == 200){
								if( call ) call();
							}else{
								common._alert(res.res,function(){});
							}
						})
						common.hideIndicator();
					},
					cancel: function (res) {
						common.hideIndicator();
						common._alert('请允许读取您的位置，以便为您推荐离您最近的活动信息',function(){
							//getLocation(call);
						});
					},
					fail: function (res) {
						var str = JSON.stringify(res);
						common._alert('获取位置失败,请重新进入获取您的位置。原因：'+str,function(){
							//wx.closeWindow();
						});
					}
				});
				});
			}
			
		};

$(function(){
	
	wx.ready(function (){
		wxJs.share(settings);
	});

});