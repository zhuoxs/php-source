var common = require("../common/common.js"), app = getApp();

Page({
    data: {
        navHref: "../cf/cf",
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
                op: "cf",
                page: e.data.page,
                pagesize: e.data.pagesize
            },
            success: function(a) {
                var t = a.data;
                "" != t.data ? e.setData({
                    xc: t.data,
                    page: e.data.page + 1
                }) : e.setData({
                    isbottom: !1
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
                op: "cf",
                page: e.data.page,
                pagesize: e.data.pagesize
            },
            success: function(a) {
                var t = a.data;
                "" != t.data ? e.setData({
                    xc: e.data.xc.concat(t.data),
                    page: e.data.page + 1
                }) : (wx.showToast({
                    title: "全部加载",
                    icon: "success",
                    duration: 2e3
                }), e.setData({
                    isbottom: !1
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
                op: "cf",
                page: e.data.page,
                pagesize: e.data.pagesize
            },
            success: function(a) {
                wx.stopPullDownRefresh();
                var t = a.data;
                "" != t.data ? e.setData({
                    xc: t.data,
                    page: e.data.page + 1
                }) : e.setData({
                    isbottom: !1,
                    xc: []
                });
            }
        });
    },
    onShareAppMessage: function() {
        return {
            title: app.config.webname,
            path: "/xc_farm/pages/cf/cf",
            success: function(a) {
                console.log(a);
            },
            fail: function(a) {
                console.log(a);
            }
        };
    }
});