var app = getApp(), WxParse = require("../../../wxParse/wxParse.js");

Page({
    data: {},
    onLoad: function(n) {
        var a = this;
        app.util.request({
            url: "entry/wxapp/index",
            showLoading: !0,
            data: {
                op: "closed"
            },
            success: function(n) {
                console.log(n), WxParse.wxParse("article", "html", n.data.data.contents, a, 0), 
                a.setData({
                    img: n.data.data.img
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