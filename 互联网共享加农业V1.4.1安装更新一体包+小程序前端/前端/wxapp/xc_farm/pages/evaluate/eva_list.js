var common = require("../common/common.js"), app = getApp();

Page({
    data: {
        page: 1,
        pagesize: 20,
        isbtoom: !1
    },
    backbtn: function() {
        wx.navigateBack({
            delta: 1
        });
    },
    onLoad: function(a) {
        var e = this;
        e.setData({
            id: a.id,
            count: a.count
        }), app.util.request({
            url: "entry/wxapp/service",
            method: "POST",
            data: {
                op: "discuss",
                type: 1,
                page: e.data.page,
                pagesize: e.data.pagesize,
                pid: a.id
            },
            success: function(a) {
                var t = a.data;
                "" != t.data ? e.setData({
                    list: t.data,
                    page: t.data.page + 1
                }) : e.setData({
                    isbottom: !0,
                    list: []
                });
            }
        });
    },
    onReachBottom: function() {
        var e = this;
        e.data.isbottom || app.util.request({
            url: "entry/wxapp/service",
            method: "POST",
            data: {
                op: "discuss",
                type: 1,
                page: e.data.page,
                pagesize: e.data.pagesize,
                pid: e.data.id
            },
            success: function(a) {
                var t = a.data;
                "" != t.data ? e.setData({
                    list: e.data.list.concat(t.data),
                    page: t.data.page + 1
                }) : e.setData({
                    isbottom: !0
                });
            }
        });
    },
    onPullDownRefresh: function() {
        var e = this;
        e.setData({
            page: 1,
            isbottom: !1
        }), app.util.request({
            url: "entry/wxapp/service",
            method: "POST",
            data: {
                op: "discuss",
                type: 1,
                page: e.data.page,
                pagesize: e.data.pagesize,
                pid: e.data.id
            },
            success: function(a) {
                var t = a.data;
                wx.stopPullDownRefresh(), "" != t.data ? e.setData({
                    list: t.data,
                    page: t.data.page + 1
                }) : e.setData({
                    isbottom: !0
                });
            }
        });
    }
});