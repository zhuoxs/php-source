var common = require("../../common/common.js"), app = getApp();

Page({
    data: {
        navHref: "../../admin/store/store",
        page: 1,
        pagesize: 20,
        isbottom: !1
    },
    onLoad: function(a) {},
    onReady: function() {},
    onShow: function() {
        var e = this;
        common.config(e, "admin2"), e.setData({
            page: 1,
            isbottom: !1
        }), app.util.request({
            url: "entry/wxapp/manage",
            method: "POST",
            data: {
                op: "store",
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
                op: "store",
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
        var o = this;
        o.data.isbottom || app.util.request({
            url: "entry/wxapp/manage",
            method: "POST",
            data: {
                op: "store",
                page: o.data.page,
                pagesize: o.data.pagesize
            },
            success: function(a) {
                var t = a.data;
                if ("" != t.data) if ("" != t.data.list && null != t.data.list) {
                    var e = o.data.xc;
                    e.list = e.list.concat(t.data.list), o.setData({
                        xc: e,
                        page: o.data.page + 1
                    });
                } else o.setData({
                    isbottom: !0
                });
            }
        });
    }
});