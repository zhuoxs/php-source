var common = require("../../common/common.js"), app = getApp();

Page({
    data: {
        navHref: "../../admin/index/index"
    },
    code: function() {
        wx.scanCode({
            success: function(n) {
                wx.navigateTo({
                    url: n.result
                });
            }
        });
    },
    onLoad: function(n) {
        var o = this;
        common.config(o, "admin"), app.util.request({
            url: "entry/wxapp/manage",
            method: "POST",
            data: {
                op: "index"
            },
            success: function(n) {
                var a = n.data;
                "" != a.data && o.setData({
                    xc: a.data
                });
            }
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {
        var o = this;
        app.util.request({
            url: "entry/wxapp/manage",
            method: "POST",
            data: {
                op: "index"
            },
            success: function(n) {
                var a = n.data;
                wx.stopPullDownRefresh(), "" != a.data && o.setData({
                    xc: a.data
                });
            }
        });
    },
    onReachBottom: function() {}
});