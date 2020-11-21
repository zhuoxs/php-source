var common = require("../../common/common.js"), app = getApp();

Page({
    data: {},
    onLoad: function(a) {
        var t = this;
        common.config(t, "admin3"), app.util.request({
            url: "entry/wxapp/manage",
            method: "POST",
            data: {
                op: "fen_center"
            },
            success: function(a) {
                var n = a.data;
                "" != n.data && t.setData({
                    xc: n.data
                });
            }
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {
        var t = this;
        app.util.request({
            url: "entry/wxapp/manage",
            method: "POST",
            data: {
                op: "fen_center"
            },
            success: function(a) {
                var n = a.data;
                wx.stopPullDownRefresh(), "" != n.data && t.setData({
                    xc: n.data
                });
            }
        });
    },
    onReachBottom: function() {}
});