var t = getApp(), a = require("../common/common.js");

Page({
    data: {},
    onLoad: function(o) {
        var n = this;
        a.config(n), a.theme(n), t.util.request({
            url: "entry/wxapp/order",
            data: {
                op: "mall_order_detail",
                id: o.id
            },
            success: function(t) {
                var a = t.data;
                "" != a.data && n.setData({
                    list: a.data
                });
            }
        });
    },
    onReady: function() {},
    onShow: function() {
        a.audio_end(this);
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {
        var a = this;
        t.util.request({
            url: "entry/wxapp/order",
            data: {
                op: "mall_order_detail",
                id: a.data.list.id
            },
            success: function(t) {
                var o = t.data;
                wx.stopPullDownRefresh(), "" != o.data && a.setData({
                    list: o.data
                });
            }
        });
    },
    onReachBottom: function() {}
});