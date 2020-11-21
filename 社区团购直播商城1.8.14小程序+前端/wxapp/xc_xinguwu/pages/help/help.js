var app = getApp(), WxParse = require("../../../wxParse/wxParse.js");

Page({
    data: {},
    onLoad: function(a) {
        var o = this;
        this.setData({
            "goHome.blackhomeimg": app.globalData.blackhomeimg
        }), app.util.request({
            url: "entry/wxapp/my",
            showLoading: !1,
            method: "POST",
            data: {
                op: "help"
            },
            success: function(a) {
                var t = a.data;
                t.data.list && (WxParse.wxParse("article", "html", t.data.list.contents, o, 10), 
                t.data.list);
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