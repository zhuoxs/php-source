var bstartnextplay = false;
function PlayerAdsStart() {
    if (document.documentElement.clientHeight > 0) {
        $('#buffer').height ( MacPlayer.Height - 62 );
        $('#buffer').show();
    }
}
function PlayerStatus() {
    if (Player.Full == 0) {
        if (Player.PlayState == 3) {
            MacPlayer.AdsEnd()
        } else {
            PlayerAdsStart()
        }
    }
}
function PlayerNextDown() {
    if (Player.get_CurTaskProcess() > 900 && !bstartnextplay) {
        Player.StartNextDown( ConvertUrl(MacPlayer.PlayUrlNext) );
        bstartnextplay = true
    }
}
function ConvertUrl(url){
	if(url==null || url==undefined) return "";
	url = url.split("|");
	return url[0]+"|"+url[1]+"|["+document.domain+"]"+url[2]+"|";
}

MacPlayer.Html='<object id="Player" classid="clsid:88CAD623-BC08-7321-C3D7-3A9B739BCA88" width="100%" height="100%" onError="MacPlayer.Install();"><param name="URL" value="'+ ConvertUrl(MacPlayer.PlayUrl) +'"><param name="NextWebPage" value="'+ MacPlayer.PlayLinkNext +'"><param name="fvodAdUrl" VALUE="'+MacPlayer.Buffer +'"><param name="NextCacheUrl" value="'+ ConvertUrl(MacPlayer.PlayUrlNext) +'"><param name="Autoplay" value="1"></object>';

var rMsie = /(msie\s|trident.*rv:)([\w.]+)/;
var match = rMsie.exec(navigator.userAgent.toLowerCase());
if(match == null){
	if (navigator.plugins){
		var ll = false;
		for (var i=0;i<navigator.plugins.length;i++) {
			if(navigator.plugins[i].name == 'FvodPlugin'){
				ll = true;
				break;
			}
		}
	}
	if(ll){
	MacPlayer.Html = '<object id="Player" name="Player" showcontrol="1" type="application/fvod-plugin" width="100%" height="100%" URL="'+MacPlayer.PlayUrl+'" NextWebPage="'+MacPlayer.PlayLinkNext+'" Autoplay="1"></object>'
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
			setInterval("PlayerNextDown()", 9333);
		}
	}
},
MacPlayer.Second * 1000 + 1000);