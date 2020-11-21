var common = require("../common/common.js"), app = getApp();

Page({
    data: {
        navHref: ""
    },
    pay: function() {
        var e = this;
        app.util.request({
            url: "entry/wxapp/service",
            method: "POST",
            data: {
                op: "trace_status",
                id: e.data.list.id
            },
            success: function(t) {
                if ("" != t.data.data) {
                    wx.showToast({
                        title: "操作成功",
                        icon: "success",
                        duration: 2e3
                    });
                    var a = e.data.list;
                    a.status = 1, e.setData({
                        list: a
                    });
                }
            }
        });
    },
    onLoad: function(t) {
        var e = this;
        common.config(e), app.util.request({
            url: "entry/wxapp/service",
            method: "POST",
            data: {
                op: "trace",
                code: t.code
            },
            success: function(t) {
                var a = t.data;
                "" != a.data && e.setData({
                    list: a.data
                });
            }
        });
    },
    onPullDownRefresh: function() {
        var e = this;
        app.util.request({
            url: "entry/wxapp/service",
            method: "POST",
            data: {
                op: "trace",
                code: e.data.list.code
            },
            success: function(t) {
                var a = t.data;
                wx.stopPullDownRefresh(), "" != a.data && e.setData({
                    list: a.data
                });
            }
        });
    }
});