var common = require("../../common/common.js"), app = getApp();

Page({
    data: {
        navHref: "../../fen_admin/index/index",
        page: 1,
        pagesize: 20,
        isbottom: !1
    },
    fen_del: function(a) {
        var t = this, e = a.currentTarget.dataset.index, n = t.data.xc;
        app.util.request({
            url: "entry/wxapp/manage",
            method: "POST",
            data: {
                op: "fen_service",
                id: n.list[e].id,
                status: -1
            },
            success: function(a) {
                "" != a.data.data && (n.list.splice(e, 1), t.setData({
                    xc: n
                }));
            }
        });
    },
    onLoad: function(a) {
        var e = this;
        common.config(e, "admin3"), app.util.request({
            url: "entry/wxapp/manage",
            method: "POST",
            data: {
                op: "fen_index",
                page: e.data.page,
                pagesize: e.data.pagesize
            },
            success: function(a) {
                var t = a.data;
                "" != t.data && (e.setData({
                    xc: t.data
                }), "" != t.data.list && null != t.data.list ? e.setData({
                    page: e.data.page + 1
                }) : e.setData({
                    isbottom: !0
                }));
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
        }), app.util.request({
            url: "entry/wxapp/manage",
            method: "POST",
            data: {
                op: "fen_index",
                page: e.data.page,
                pagesize: e.data.pagesize
            },
            success: function(a) {
                var t = a.data;
                wx.stopPullDownRefresh(), "" != t.data && (e.setData({
                    xc: t.data
                }), "" != t.data.list && null != t.data.list ? e.setData({
                    page: e.data.page + 1
                }) : e.setData({
                    isbottom: !0
                }));
            }
        });
    },
    onReachBottom: function() {
        var n = this;
        n.data.isbottom || app.util.request({
            url: "entry/wxapp/manage",
            method: "POST",
            data: {
                op: "fen_index",
                page: n.data.page,
                pagesize: n.data.pagesize
            },
            success: function(a) {
                var t = a.data;
                if ("" != t.data) if ("" != t.data.list && null != t.data.list) {
                    var e = n.data.xc;
                    e.list = e.list.concat(t.data.list), n.setData({
                        xc: e,
                        page: n.data.page + 1
                    });
                } else n.setData({
                    isbottom: !0
                });
            }
        });
    }
});