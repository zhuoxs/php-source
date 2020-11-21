var common = require("../common/common.js"), app = getApp();

Page({
    data: {
        navHref: "",
        page: 1,
        pagesize: 20,
        isbottom: !1
    },
    onLoad: function(a) {
        var e = this;
        common.config(e), "" != a.type && null != a.type && e.setData({
            type: a.type
        });
        var t = {
            op: "cf_order",
            page: e.data.page,
            pagesize: e.data.pagesize
        };
        "" != e.data.type && null != e.data.type && (t.type = e.data.type), app.util.request({
            url: "entry/wxapp/order",
            method: "POST",
            data: t,
            success: function(a) {
                var t = a.data;
                "" != t.data ? e.setData({
                    list: t.data,
                    page: e.data.page + 1
                }) : e.setData({
                    isbototm: !0
                });
            }
        });
    },
    onReachBottom: function() {
        var e = this;
        if (!e.data.isbottom) {
            var a = {
                op: "cf_order",
                page: e.data.page,
                pagesize: e.data.pagesize
            };
            app.util.request({
                url: "entry/wxapp/order",
                method: "POST",
                data: a,
                success: function(a) {
                    var t = a.data;
                    "" != t.data ? e.setData({
                        list: e.data.list.concat(t.data),
                        page: e.data.page + 1
                    }) : e.setData({
                        isbototm: !0
                    });
                }
            });
        }
    },
    onPullDownRefresh: function() {
        var e = this;
        e.setData({
            page: 1,
            isbottom: !1
        });
        var a = {
            op: "cf_order",
            page: e.data.page,
            pagesize: e.data.pagesize
        };
        "" != e.data.type && null != e.data.type && (a.type = e.data.type), app.util.request({
            url: "entry/wxapp/order",
            method: "POST",
            data: a,
            success: function(a) {
                var t = a.data;
                wx.stopPullDownRefresh(), "" != t.data ? e.setData({
                    list: t.data,
                    page: e.data.page + 1
                }) : e.setData({
                    isbototm: !0
                });
            }
        });
    }
});