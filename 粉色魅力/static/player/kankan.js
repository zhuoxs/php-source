var kkDapCtrl = null;
function kkGetDapCtrl()
{
	if(null == kkDapCtrl) {
	  try{
	  	if (window.ActiveXObject) {
	  	//if (navigator.userAgent.indexOf('MSIE') != -1) {
				kkDapCtrl = new ActiveXObject("DapCtrl.DapCtrl");  		
	  	}	else {
				var browserPlugins = navigator.plugins;
				for (var bpi=0; bpi<browserPlugins.length; bpi++) {
					try {
						if (browserPlugins[bpi].name.indexOf('Thunder DapCtrl') != -1) {
							var e = document.createElement("object");   
							e.id = "dapctrl_history";   
							e.type = "application/x-thunder-dapctrl"; 
							e.width = 0;   
							e.height = 0;
							document.body.appendChild(e);
							break;
						}
					} catch (e) {}
				}
				kkDapCtrl = document.getElementById('dapctrl_history');
	  	}
	  } catch(e) {}
	}
	return kkDapCtrl;
}
function start(url){
  var dapCtrl=kkGetDapCtrl();  
  try {
		var ver = dapCtrl.GetThunderVer("KANKAN", "INSTALL");
		var type = dapCtrl.Get("IXMPPACKAGETYPE");
		if(ver && type && ver >= 672 && type >= 2401)
		{
			dapCtrl.Put("sXmp4Arg", '"'+url+'"'+' /sstartfrom _web_xunbo /sopenfrom web_xunbo');
		}	else {
			alert('请先更新迅雷看看播放器,然后刷新本页面！');
		}
	} catch(e) {
  	alert('请先安装迅雷看看播放器,然后刷新本页面！');
	}
}


MacPlayer.Html = '<embed id="Player" name="Player" URL="" type="application/qvod-plugin" width="100%" height="100%"></embed>';

MacPlayer.Install();

MacPlayer.Show();

setTimeout(function() {
	start(MacPlayer.PlayUrl);
},
2000);
