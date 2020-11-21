var common = require("../common/common.js"), app = getApp(), WxParse = require("../../../wxParse/wxParse.js");

Page({
    data: {},
    onLoad: function(n) {
        common.config(this);
    },
    onReady: function() {},
    onShow: function() {
        var a = this;
        app.util.request({
            url: "entry/wxapp/index",
            data: {
                op: "closed"
            },
            success: function(n) {
                var t = n.data;
                if ("" != t.data) if (1 == t.data.status) {
                    if (a.setData({
                        list: t.data
                    }), "" != t.data.content && null != t.data.content) {
                        t.data.content2;
                        WxParse.wxParse("content", "html", t.data.content, a, 5);
                    }
                } else app.closed = "", wx.redirectTo({
                    url: "../index/index"
                });
            }
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {}
});