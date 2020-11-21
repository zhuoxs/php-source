var common = require("../common/common.js"), app = getApp();

Page({
    data: {
        navHref: "../pin/index",
        tagCurr1: -1,
        page: 1,
        pagesize: 20,
        isbottom: !1
    },
    tagChange1: function(a) {
        var s = this, t = a.currentTarget.id;
        if (t != s.data.tagCurr1) {
            s.setData({
                tagCurr1: t,
                page: 1,
                isbottom: !1
            });
            var e = {
                op: "pin_index",
                page: s.data.page,
                pagesize: s.data.pagesize
            };
            -1 != s.data.tagCurr1 && (e.cid = s.data.xc.class[s.data.tagCurr1].id), app.util.request({
                url: "entry/wxapp/service",
                method: "POST",
                data: e,
                success: function(a) {
                    var t = a.data;
                    if ("" != t.data) {
                        var e = s.data.xc;
                        "" != t.data.list && null != t.data.list ? (e.list = t.data.list, s.setData({
                            xc: e,
                            page: s.data.page + 1
                        })) : (e.list = [], s.setData({
                            xc: e,
                            isbottom: !0
                        }));
                    }
                }
            });
        }
    },
    onLoad: function(a) {
        var e = this;
        common.config(e), app.util.request({
            url: "entry/wxapp/service",
            method: "POST",
            data: {
                op: "pin_index",
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
        });
        var a = {
            op: "pin_index",
            page: e.data.page,
            pagesize: e.data.pagesize
        };
        -1 != e.data.tagCurr1 && (a.cid = e.data.xc.class[e.data.tagCurr1].id), app.util.request({
            url: "entry/wxapp/service",
            method: "POST",
            data: a,
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
        var s = this;
        if (!s.data.isbottom) {
            var a = {
                op: "pin_index",
                page: s.data.page,
                pagesize: s.data.pagesize
            };
            -1 != s.data.tagCurr1 && (a.cid = s.data.xc.class[s.data.tagCurr1].id), app.util.request({
                url: "entry/wxapp/service",
                method: "POST",
                data: a,
                success: function(a) {
                    var t = a.data;
                    if (wx.stopPullDownRefresh(), "" != t.data) {
                        var e = s.data.xc;
                        "" != t.data.list && null != t.data.list ? (e.list = e.list.concat(t.data.list), 
                        s.setData({
                            xc: e,
                            page: s.data.page + 1
                        })) : s.setData({
                            isbottom: !0
                        });
                    }
                }
            });
        }
    }
});