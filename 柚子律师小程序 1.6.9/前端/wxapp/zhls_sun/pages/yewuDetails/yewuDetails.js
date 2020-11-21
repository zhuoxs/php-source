var app = getApp();

Page({
    data: {},
    onLoad: function(t) {
        var n = this;
        wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("fontcolor"),
            backgroundColor: wx.getStorageSync("color"),
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        }), n.url();
        var a = t.id;
        console.log(t), app.util.request({
            url: "entry/wxapp/businessData",
            cachetime: "0",
            data: {
                id: a
            },
            success: function(t) {
                console.log(t.data), n.setData({
                    business: t.data
                });
            }
        });
    },
    url: function(t) {
        var n = this;
        app.util.request({
            url: "entry/wxapp/Url2",
            cachetime: "0",
            success: function(t) {
                wx.setStorageSync("url2", t.data);
            }
        }), app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "0",
            success: function(t) {
                wx.setStorageSync("url", t.data), n.setData({
                    url: t.data
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