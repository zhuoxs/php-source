var app = getApp();

Page({
    data: {},
    onLoad: function(n) {},
    onReady: function() {},
    onShow: function() {
        var a = this, n = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/Balancedetail",
            cachetime: "0",
            data: {
                openid: n
            },
            success: function(n) {
                a.setData({
                    balancedetail: n.data
                });
            }
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {}
});