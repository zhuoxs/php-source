var bstartnextplay = false;
function PlayerAdsStart() {
    if (document.documentElement.clientHeight > 0) {
        $('#buffer').height ( MacPlayer.Height - 62 );
        $('#buffer').show();
    }
}
function PlayerStatus() {
	try{
	    if (Player.IsPlaying()) {
	        MacPlayer.AdsEnd()
	    } else {
	        PlayerAdsStart()
	    }
	}
	catch(e){
		PlayerAdsStart()
	}
}
function ConvertUrl(url){
	if(url==null || url==undefined) return "";
	url = url.split("|");
	return url[0]+"|"+url[1]+"|["+document.domain+"]"+url[2]+"|";
}

MacPlayer.Html='<object id="Player" classid="clsid:D154C77B-73C3-4096-ABC4-4AFAE87AB206" width="100%" height="100%" onError="MacPlayer.Install();"><param name="URL" value="'+ ConvertUrl(MacPlayer.PlayUrl) +'"><param name="NextWebPage" value="'+ MacPlayer.PlayLinkNext +'"><param name="NextCacheUrl" value="'+ ConvertUrl(MacPlayer.PlayUrlNext) +'"><param name="Autoplay" value="1"></object>';

var rMsie = /(msie\s|trident.*rv:)([\w.]+)/;
var match = rMsie.exec(navigator.userAgent.toLowerCase());
if(match == null){
	if (navigator.plugins){
		var ll = false;
		for (var i=0;i<navigator.plugins.length;i++) {
			if(navigator.plugins[i].name == 'npFFPlayer'){
				ll = true;
				break;
			}
		}
	}
	if(ll){
	MacPlayer.Html = '<object id="Player" name="Player" showcontrol="1" type="application/npFFPlayer" width="100%" height="100%" URL="'+MacPlayer.PlayUrl+'" NextWebPage="'+MacPlayer.PlayLinkNext+'" Autoplay="1"></object>'
	}
	else{
		MacPlayer.Install();
	}
}
MacPlayer.Show();
setTimeout(function(){
	if (MacPlayer.Status == true && MacPlayer.Flag==1){
		setInterval("PlayerStatus()", 1000);
		if (MacPlayer.PlayLinkNext) {
		
		}
	}
},
MacPlayer.Second * 1000 + 1000);