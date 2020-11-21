var common = require("../../common/common.js"), app = getApp();

Page({
    data: {
        curr: 1,
        page: 1,
        pagesize: 20,
        isbottom: !1
    },
    tab: function(a) {
        var e = this, t = a.currentTarget.dataset.index;
        e.data.curr != t && (e.setData({
            curr: t,
            page: 1,
            isbottom: !1,
            list: []
        }), app.util.request({
            url: "entry/wxapp/manage",
            method: "POST",
            data: {
                op: "store_order",
                curr: e.data.curr,
                page: e.data.page,
                pagesize: e.data.pagesize,
                admin: e.data.admin
            },
            success: function(a) {
                var t = a.data;
                "" != t.data ? e.setData({
                    list: t.data,
                    page: e.data.page + 1
                }) : e.setData({
                    isbottom: !0,
                    list: []
                });
            }
        }));
    },
    onLoad: function(a) {
        var e = this;
        e.setData({
            admin: a.admin
        }), 1 == e.data.admin ? common.config(e, "admin2") : 2 == e.data.admin && (e.setData({
            navHref: "../../admin/account/account?&admin=2"
        }), common.config(e, "admin3")), app.util.request({
            url: "entry/wxapp/manage",
            method: "POST",
            data: {
                op: "store_order",
                curr: e.data.curr,
                page: e.data.page,
                pagesize: e.data.pagesize,
                admin: e.data.admin
            },
            success: function(a) {
                var t = a.data;
                "" != t.data ? e.setData({
                    list: t.data,
                    page: e.data.page + 1
                }) : e.setData({
                    isbottom: !0
                });
            }
        });
    },
    onReady: function() {},
    onShow: function() {
        var e = this;
        app.util.request({
            url: "entry/wxapp/manage",
            showLoading: !1,
            method: "POST",
            data: {
                op: "store"
            },
            success: function(a) {
                var t = a.data;
                "" != t.data && e.setData({
                    xc: t.data
                });
            }
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {
        var e = this;
        e.setData({
            page: 1,
            isbottom: !1
        }), app.util.request({
            url: "entry/wxapp/manage",
            showLoading: !1,
            method: "POST",
            data: {
                op: "store"
            },
            success: function(a) {
                var t = a.data;
                "" != t.data && e.setData({
                    xc: t.data
                });
            }
        }), app.util.request({
            url: "entry/wxapp/manage",
            method: "POST",
            data: {
                op: "store_order",
                curr: e.data.curr,
                page: e.data.page,
                pagesize: e.data.pagesize,
                admin: e.data.admin
            },
            success: function(a) {
                var t = a.data;
                wx.stopPullDownRefresh(), "" != t.data ? e.setData({
                    list: t.data,
                    page: e.data.page + 1
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
            url: "entry/wxapp/manage",
            method: "POST",
            data: {
                op: "store_order",
                curr: e.data.curr,
                page: e.data.page,
                pagesize: e.data.pagesize,
                admin: e.data.admin
            },
            success: function(a) {
                var t = a.data;
                "" != t.data ? e.setData({
                    list: e.data.list.concat(t.data),
                    page: e.data.page + 1
                }) : e.setData({
                    isbottom: !0
                });
            }
        });
    }
});