var common = require("../common/common.js"), app = getApp();

Page({
    data: {},
    onLoad: function(a) {
        var e = this;
        common.config(e), app.util.request({
            url: "entry/wxapp/order",
            method: "POST",
            data: {
                op: "cf_order_detail",
                id: a.id
            },
            success: function(a) {
                var t = a.data;
                "" != t.data && e.setData({
                    list: t.data
                });
            }
        });
    },
    onPullDownRefresh: function() {
        var e = this;
        app.util.request({
            url: "entry/wxapp/order",
            method: "POST",
            data: {
                op: "cf_order_detail",
                id: e.data.list.id
            },
            success: function(a) {
                wx.stopPullDownRefresh();
                var t = a.data;
                "" != t.data && e.setData({
                    list: t.data
                });
            }
        });
    }
});