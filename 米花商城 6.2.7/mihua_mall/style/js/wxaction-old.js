WeixinApi.ready(function(Api) {
        Api.showOptionMenu();
	
        // 分享的回调
        var wxCallbacks = {
            // 分享被用户自动取消
            cancel : function(resp) {
                TopBox.alert("分享后获得积分,还有可能得到佣金哦!不要错过发大财的机会!");
            },
            // 分享失败了
            fail : function(resp) {
                TopBox.alert("分享失败，可能是网络问题，一会儿再试试？");
            },
            // 分享成功
            confirm : function(resp) {
             TopBox.alert("分享后成功,等着收佣金吧!");
            },
        };
        Api.shareToFriend(wxData,wxCallbacks);
        Api.shareToTimeline(wxData,wxCallbacks);
        Api.shareToWeibo(wxData,wxCallbacks);
        Api.generalShare(wxData,wxCallbacks);
    });