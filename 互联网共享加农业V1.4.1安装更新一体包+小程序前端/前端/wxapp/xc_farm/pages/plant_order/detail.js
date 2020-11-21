var common = require("../common/common.js"), app = getApp();

Page({
    data: {},
    onLoad: function(a) {
        var o = this;
        common.config(o), o.setData({
            id: a.id
        }), app.util.request({
            url: "entry/wxapp/order",
            method: "POST",
            data: {
                op: "plant_order_detail",
                id: o.data.id
            },
            success: function(a) {
                var t = a.data;
                "" != t.data && o.setData({
                    xc: t.data
                });
            }
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {
        app.util.request({
            url: "entry/wxapp/order",
            method: "POST",
            data: {
                op: "plant_order_detail",
                id: self.data.id
            },
            success: function(a) {
                var t = a.data;
                wx.stopPullDownRefresh(), "" != t.data && self.setData({
                    xc: t.data
                });
            }
        });
    },
    onReachBottom: function() {}
});