var common = require("../../common/common.js"), app = getApp();

Page({
    data: {
        navHref: "../../fen_admin/order/order",
        curr: 1,
        page: 1,
        pagesize: 20,
        isbottom: !1
    },
    tab: function(a) {
        var e = this, t = a.currentTarget.dataset.index;
        if (t != e.data.curr) {
            e.setData({
                curr: t,
                page: 1,
                isbottom: !1
            });
            var n = {
                op: "fen_order",
                page: e.data.page,
                pagesize: e.data.pagesize,
                curr: e.data.curr
            };
            "" != e.data.content && null != e.data.content && (n.content = e.data.content), 
            app.util.request({
                url: "entry/wxapp/manage",
                method: "POST",
                data: n,
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
            });
        }
    },
    input: function(a) {
        this.setData({
            content: a.detail.value
        });
    },
    search: function() {
        var e = this;
        if ("" != e.data.content && null != e.data.content) {
            e.setData({
                page: 1,
                isbottom: !1
            });
            var a = {
                op: "fen_order",
                page: e.data.page,
                pagesize: e.data.pagesize,
                curr: e.data.curr
            };
            "" != e.data.content && null != e.data.content && (a.content = e.data.content), 
            app.util.request({
                url: "entry/wxapp/manage",
                method: "POST",
                data: a,
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
            });
        }
    },
    code: function() {
        wx.scanCode({
            success: function(a) {
                wx.navigateTo({
                    url: a.result
                });
            }
        });
    },
    onLoad: function(a) {
        var e = this;
        common.config(e, "admin3");
        var t = {
            op: "fen_order",
            page: e.data.page,
            pagesize: e.data.pagesize,
            curr: e.data.curr
        };
        app.util.request({
            url: "entry/wxapp/manage",
            method: "POST",
            data: t,
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
            op: "fen_order",
            page: e.data.page,
            pagesize: e.data.pagesize,
            curr: e.data.curr
        };
        "" != e.data.content && null != e.data.content && (a.content = e.data.content), 
        app.util.request({
            url: "entry/wxapp/manage",
            method: "POST",
            data: a,
            success: function(a) {
                wx.stopPullDownRefresh();
                var t = a.data;
                "" != t.data ? e.setData({
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
        if (!e.data.isbottom) {
            var a = {
                op: "fen_order",
                page: e.data.page,
                pagesize: e.data.pagesize,
                curr: e.data.curr
            };
            "" != e.data.content && null != e.data.content && (a.content = e.data.content), 
            app.util.request({
                url: "entry/wxapp/manage",
                method: "POST",
                data: a,
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
    }
});