var WxParse = require("../../../wxParse/wxParse.js"), app = getApp();

Page({
    data: {},
    onLoad: function(n) {
        var a = n.id, e = this;
        app.util.request({
            url: "entry/wxapp/Shenheset",
            method: "POST",
            data: {
                id: a
            },
            success: function(n) {
                var a = n.data.data.content, t = n.data.data.name;
                wx.setNavigationBarTitle({
                    title: t
                }), WxParse.wxParse("article", "html", a, e, 5);
            },
            fail: function(n) {
                console.log("失败");
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