var t = getApp(), n = require("../common/common.js"), a = require("../../../wxParse/wxParse.js");

Page({
    data: {},
    onLoad: function(t) {
        var a = this;
        n.config(a), n.theme(a);
    },
    onReady: function() {},
    onShow: function() {
        var n = this;
        t.util.request({
            url: "entry/wxapp/index",
            data: {
                op: "closed"
            },
            success: function(t) {
                var e = t.data;
                if ("" != e.data) if (1 == e.data.status) {
                    if (n.setData({
                        list: e.data
                    }), "" != e.data.content && null != e.data.content) {
                        e.data.content2;
                        a.wxParse("content", "html", e.data.content, n, 5);
                    }
                } else wx.redirectTo({
                    url: "../base/base"
                });
            }
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {}
});