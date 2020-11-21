var app = getApp();

Page({
    data: {},
    onLoad: function(n) {
        var o = this, t = n.id;
        app.util.request({
            url: "entry/wxapp/Weburl",
            data: {
                id: t
            },
            success: function(n) {
                console.log(n), o.setData({
                    src: n.data.data.webviewurl
                });
            }
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {}
});