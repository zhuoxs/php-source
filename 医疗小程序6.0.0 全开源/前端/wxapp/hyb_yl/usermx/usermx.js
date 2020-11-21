var app = getApp();

Page({
    data: {
        wendaArr: []
    },
    onLoad: function(o) {
        var n = this, a = wx.getStorageSync("color");
        wx.setNavigationBarColor({
            frontColor: "#ffffff",
            backgroundColor: a
        });
        var t = o.openid;
        app.util.request({
            url: "entry/wxapp/Selectx",
            data: {
                user_openid: t
            },
            success: function(o) {
                console.log(o), n.setData({
                    wendaArr: o.data.data
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