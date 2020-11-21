var common = require("../../common/common.js"), app = getApp();

Page({
    data: {
        curr: 3
    },
    submit: function() {
        var a = this, o = a.data.list;
        1 == o.status && 1 == o.order_status && (2 != o.type2 || 2 == o.type2 && 1 == o.group_status) && wx.showModal({
            title: "提示",
            content: "确定发货吗？",
            success: function(t) {
                t.confirm ? app.util.request({
                    url: "entry/wxapp/manage",
                    method: "POST",
                    data: {
                        op: "order_status",
                        id: o.id
                    },
                    success: function(t) {
                        "" != t.data.data && (wx.showToast({
                            title: "发货成功",
                            icon: "success",
                            duration: 2e3
                        }), o.order_status = 2, a.setData({
                            list: o
                        }));
                    }
                }) : t.cancel && console.log("用户点击取消");
            }
        });
    },
    pay: function() {
        var a = this, o = a.data.list;
        (2 == o.type2 && 2 == o.group_status || 5 == o.order_status) && wx.showModal({
            title: "提示",
            content: "确定退款吗？",
            success: function(t) {
                t.confirm ? app.util.request({
                    url: "entry/wxapp/manage",
                    method: "POST",
                    data: {
                        op: "order_tui",
                        id: o.id
                    },
                    success: function(t) {
                        "" != t.data.data && (wx.showToast({
                            title: "退款成功",
                            icon: "success",
                            duration: 2e3
                        }), 5 == o.order_status ? o.order_status = 6 : o.group_status = 3, a.setData({
                            list: o
                        }));
                    }
                }) : t.cancel && console.log("用户点击取消");
            }
        });
    },
    onLoad: function(t) {
        var o = this;
        common.config(o, "admin"), app.util.request({
            url: "entry/wxapp/manage",
            method: "POST",
            data: {
                op: "order_detail",
                id: t.id
            },
            success: function(t) {
                var a = t.data;
                "" != a.data && o.setData({
                    list: a.data
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
                op: "order_detail",
                id: o.data.list.id
            },
            success: function(t) {
                var a = t.data;
                wx.stopPullDownRefresh(), "" != a.data && o.setData({
                    list: a.data
                });
            }
        });
    },
    onReachBottom: function() {}
});