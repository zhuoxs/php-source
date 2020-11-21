var common = require("../common/common.js"), app = getApp();

Page({
    data: {
        navHref: "../event/event",
        page: 1,
        pagesize: 20,
        isbottom: !1
    },
    onLoad: function(a) {
        var e = this;
        common.config(e), app.util.request({
            url: "entry/wxapp/service",
            method: "POST",
            data: {
                op: "active",
                page: e.data.page,
                pagesize: e.data.pagesize
            },
            success: function(a) {
                var t = a.data;
                "" != t.data ? e.setData({
                    page: e.data.page + 1,
                    list: t.data
                }) : e.setData({
                    isbottom: !0
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
                op: "active",
                page: e.data.page,
                pagesize: e.data.pagesize
            },
            success: function(a) {
                var t = a.data;
                "" != t.data ? e.setData({
                    list: e.data.list.concat(t.data),
                    page: e.data.page + 1
                }) : (wx.showToast({
                    title: "全部加载",
                    icon: "success",
                    duration: 2e3
                }), e.setData({
                    isbottom: !0
                }));
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
                op: "active",
                page: e.data.page,
                pagesize: e.data.pagesize
            },
            success: function(a) {
                wx.stopPullDownRefresh();
                var t = a.data;
                "" != t.data ? e.setData({
                    page: e.data.page + 1,
                    list: t.data
                }) : e.setData({
                    isbottom: !0,
                    list: []
                });
            }
        });
    },
    onShareAppMessage: function() {
        return {
            title: app.config.webname,
            path: "/xc_farm/pages/event/event",
            success: function(a) {
                console.log(a);
            },
            fail: function(a) {
                console.log(a);
            }
        };
    }
});