var common = require("../../common/common.js"), app = getApp();

Page({
    data: {
        navHref: "../../admin/index2/index2"
    },
    code: function() {
        wx.scanCode({
            success: function(t) {
                wx.navigateTo({
                    url: t.result
                });
            }
        });
    },
    prev_m: function() {
        var n = this, e = n.data.month;
        1 < parseInt(e) && parseInt(e) <= parseInt(n.data.month_t) && (e = (e = parseInt(e) - 1) < 10 ? "0" + e : e, 
        app.util.request({
            url: "entry/wxapp/manage",
            method: "POST",
            data: {
                op: "index2",
                month: e
            },
            success: function(t) {
                var a = t.data;
                "" != a.data && n.setData({
                    xc: a.data,
                    month: e
                });
            }
        }));
    },
    next_m: function() {
        var n = this, e = n.data.month;
        1 <= parseInt(e) && parseInt(e) < parseInt(n.data.month_t) && (e = (e = parseInt(e) + 1) < 10 ? "0" + e : e, 
        app.util.request({
            url: "entry/wxapp/manage",
            method: "POST",
            data: {
                op: "index2",
                month: e
            },
            success: function(t) {
                var a = t.data;
                "" != a.data && n.setData({
                    xc: a.data,
                    month: e
                });
            }
        }));
    },
    onLoad: function(t) {
        var n = this;
        common.config(n, "admin2");
        var a = new Date().getMonth() + 1;
        a = a < 10 ? "0" + a : a, n.setData({
            month: a,
            month_t: a
        }), app.util.request({
            url: "entry/wxapp/manage",
            method: "POST",
            data: {
                op: "index2",
                month: n.data.month
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
            url: "entry/wxapp/manage",
            method: "POST",
            data: {
                op: "index2",
                month: n.data.month
            },
            success: function(t) {
                var a = t.data;
                wx.stopPullDownRefresh(), "" != a.data && n.setData({
                    xc: a.data
                });
            }
        });
    },
    onReachBottom: function() {}
});