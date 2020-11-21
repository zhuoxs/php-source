var common = require("../common/common.js"), app = getApp();

Page({
    data: {
        navHref: "../partner/partner",
        tagCurr1: -1,
        page: 1,
        pagesize: 20,
        isbottom: !1
    },
    tagChange1: function(a) {
        var e = this, t = a.currentTarget.id;
        if (e.data.tagCurr1 != t) {
            e.setData({
                tagCurr1: t,
                page: 1,
                isbottom: !1
            });
            var r = {
                op: "partner",
                page: e.data.page,
                pagesize: e.data.pagesize
            };
            -1 != e.data.tagCurr1 && (r.service = e.data.partner_class[e.data.tagCurr1].id), 
            app.util.request({
                url: "entry/wxapp/index",
                method: "POST",
                data: r,
                success: function(a) {
                    var t = a.data;
                    "" != t.data ? e.setData({
                        xc: t.data,
                        page: e.data.page + 1
                    }) : e.setData({
                        isbottom: !0,
                        xc: []
                    });
                }
            });
        }
    },
    onLoad: function(a) {
        var e = this;
        common.config(e), app.util.request({
            url: "entry/wxapp/index",
            method: "POST",
            data: {
                op: "partner_class"
            },
            success: function(a) {
                var t = a.data;
                "" != t.data && e.setData({
                    partner_class: t.data
                });
            }
        });
        var t = {
            op: "partner",
            page: e.data.page,
            pagesize: e.data.pagesize
        };
        -1 != e.data.tagCurr1 && (t.service = e.data.partner_class[e.data.tagCurr1].id), 
        app.util.request({
            url: "entry/wxapp/index",
            method: "POST",
            data: t,
            success: function(a) {
                var t = a.data;
                "" != t.data ? e.setData({
                    xc: t.data,
                    page: e.data.page + 1
                }) : e.setData({
                    isbottom: !0
                });
            }
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {
        var e = this;
        e.setData({
            page: 1,
            isbottom: !1
        });
        var a = {
            op: "partner",
            page: e.data.page,
            pagesize: e.data.pagesize
        };
        -1 != e.data.tagCurr1 && (a.service = e.data.partner_class[e.data.tagCurr1].id), 
        app.util.request({
            url: "entry/wxapp/index",
            method: "POST",
            data: a,
            success: function(a) {
                var t = a.data;
                wx.stopPullDownRefresh(), "" != t.data ? e.setData({
                    xc: t.data,
                    page: e.data.page + 1
                }) : e.setData({
                    isbottom: !0,
                    xc: []
                });
            }
        });
    },
    onReachBottom: function() {
        var e = this;
        if (!e.data.isbottom) {
            var a = {
                op: "partner",
                page: e.data.page,
                pagesize: e.data.pagesize
            };
            -1 != e.data.tagCurr1 && (a.service = e.data.partner_class[e.data.tagCurr1].id), 
            app.util.request({
                url: "entry/wxapp/index",
                method: "POST",
                data: a,
                success: function(a) {
                    var t = a.data;
                    "" != t.data ? e.setData({
                        xc: e.data.xc.concat(t.data),
                        page: e.data.page + 1
                    }) : e.setData({
                        isbottom: !0
                    });
                }
            });
        }
    }
});