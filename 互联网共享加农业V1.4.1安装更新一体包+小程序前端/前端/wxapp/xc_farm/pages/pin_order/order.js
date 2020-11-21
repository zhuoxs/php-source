var common = require("../common/common.js"), app = getApp();

Page({
    data: {
        status: 1
    },
    tab: function() {
        this.setData({
            status: -this.data.status
        });
    },
    onLoad: function(t) {
        var n = this;
        common.config(n), n.setData({
            id: t.id
        }), app.util.request({
            url: "entry/wxapp/order",
            method: "POST",
            data: {
                op: "pin_index",
                id: n.data.id
            },
            success: function(t) {
                var a = t.data;
                "" != a.data && n.setData({
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
        var n = this;
        app.util.request({
            url: "entry/wxapp/order",
            method: "POST",
            data: {
                op: "pin_index",
                id: n.data.id
            },
            success: function(t) {
                var a = t.data;
                wx.stopPullDownRefresh(), "" != a.data && n.setData({
                    xc: a.data
                });
            }
        });
    },
    onReachBottom: function() {},
    onShareAppMessage: function() {
        var t = this.data.xc;
        return {
            title: t.name,
            imageUrl: t.simg,
            path: "/xc_farm/pages/pin/detail?&id=" + this.data.id,
            success: function(t) {
                console.log(t);
            },
            fail: function(t) {
                console.log(t);
            }
        };
    }
});