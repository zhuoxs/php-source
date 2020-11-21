var app = getApp();

Page({
    data: {
        guanzhu: []
    },
    onLoad: function(n) {
        var o = wx.getStorageSync("color");
        wx.setNavigationBarColor({
            frontColor: "#ffffff",
            backgroundColor: o
        });
        var a = this, t = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/Myguan",
            data: {
                openid: t
            },
            success: function(n) {
                console.log(n), a.setData({
                    myguan: n.data.data
                });
            }
        });
    },
    onReady: function() {},
    onShow: function() {
        var o = this, n = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/Myguan",
            data: {
                openid: n
            },
            success: function(n) {
                console.log(n), o.setData({
                    myguan: n.data.data
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