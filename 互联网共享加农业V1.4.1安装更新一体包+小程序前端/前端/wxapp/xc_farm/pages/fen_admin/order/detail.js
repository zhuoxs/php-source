var common = require("../../common/common.js"), app = getApp();

Page({
    data: {},
    onLoad: function(a) {
        var n = this;
        common.config(n, "admin3"), app.util.request({
            url: "entry/wxapp/manage",
            method: "POST",
            data: {
                op: "fen_order_detail",
                id: a.id
            },
            success: function(a) {
                var t = a.data;
                "" != t.data && n.setData({
                    list: t.data
                });
            }
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {
        var n = this;
        app.util.request({
            url: "entry/wxapp/manage",
            method: "POST",
            data: {
                op: "fen_order_detail",
                id: n.data.list.id
            },
            success: function(a) {
                var t = a.data;
                wx.stopPullDownRefresh(), "" != t.data && n.setData({
                    list: t.data
                });
            }
        });
    },
    onReachBottom: function() {}
});