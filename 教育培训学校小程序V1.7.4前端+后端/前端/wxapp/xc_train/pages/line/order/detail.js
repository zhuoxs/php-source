var t = getApp(), a = require("../../common/common.js");

Page({
    data: {},
    onLoad: function(t) {
        var n = this;
        a.config(n), a.theme(n), n.setData({
            id: t.id
        }), n.getData();
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {
        this.getData();
    },
    onReachBottom: function() {},
    getData: function() {
        var a = this;
        t.util.request({
            url: "entry/wxapp/order",
            data: {
                op: "line_order_detail",
                id: a.data.id
            },
            success: function(t) {
                var n = t.data;
                wx.stopPullDownRefresh(), "" != n.data && a.setData({
                    list: n.data
                });
            }
        });
    }
});