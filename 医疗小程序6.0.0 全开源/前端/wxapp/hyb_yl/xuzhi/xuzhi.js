var app = getApp(), WxParse = require("../wxParse/wxParse.js");

Page({
    data: {},
    onLoad: function(a) {
        var n = wx.getStorageSync("color");
        wx.setNavigationBarColor({
            frontColor: "#ffffff",
            backgroundColor: n
        });
    },
    fanhui: function() {
        wx.navigateBack({
            delta: 1
        });
    },
    onReady: function() {
        this.getBase();
    },
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    getBase: function() {
        var n = this;
        app.util.request({
            url: "entry/wxapp/Base",
            success: function(a) {
                console.log(a), n.setData({
                    base: a.data.data
                }), WxParse.wxParse("article", "html", a.data.data.txxz, n, 5);
            },
            fail: function(a) {}
        });
    }
});