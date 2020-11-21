var app = getApp();

Page({
    data: {
        list: []
    },
    onLoad: function(n) {
        var t = this, o = wx.getStorageSync("users").openid, e = wx.getStorageSync("users").id;
        app.util.request({
            url: "entry/wxapp/GetBalance",
            data: {
                openid: o,
                uid: e
            },
            success: function(n) {
                console.log(n), t.setData({
                    list: n.data
                });
            }
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {}
});