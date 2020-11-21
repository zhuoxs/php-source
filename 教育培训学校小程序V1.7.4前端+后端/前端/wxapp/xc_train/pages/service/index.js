var a = getApp(), t = require("../common/common.js");

Page({
    data: {
        pagePath: "../service/index",
        curr: -1,
        page: 1,
        pagesize: 20,
        isbottom: !1
    },
    tab: function(t) {
        var e = this, s = t.currentTarget.dataset.index;
        if (s != e.data.curr) {
            e.setData({
                curr: s,
                page: 1,
                isbottom: !1,
                list: []
            });
            var i = {
                op: "service",
                page: e.data.page,
                pagesize: e.data.pagesize
            };
            -1 != e.data.curr && (i.cid = e.data.pclass[e.data.curr].id), a.util.request({
                url: "entry/wxapp/service",
                data: i,
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
        }
    },
    onLoad: function(e) {
        var s = this;
        t.config(s), t.theme(s), "" != e.curr && null != e.curr && s.setData({
            cid: e.cid
        }), a.util.request({
            url: "entry/wxapp/service",
            data: {
                op: "service_class",
                type: 1
            },
            showLoading: !1,
            success: function(a) {
                var t = a.data;
                if ("" != t.data && (s.setData({
                    pclass: t.data
                }), "" != e.cid && null != e.cid)) for (var i = 0; i < t.data.length; i++) t.data[i].id == e.cid && s.setData({
                    curr: i
                });
            },
            complete: function() {
                var t = {
                    op: "service",
                    page: s.data.page,
                    pagesize: s.data.pagesize
                };
                -1 != s.data.curr && (t.cid = s.data.pclass[s.data.curr].id), a.util.request({
                    url: "entry/wxapp/service",
                    data: t,
                    success: function(a) {
                        var t = a.data;
                        "" != t.data ? s.setData({
                            list: t.data,
                            page: s.data.page + 1
                        }) : s.setData({
                            isbottom: !0
                        });
                    }
                });
            }
        });
    },
    onReady: function() {},
    onShow: function() {
        t.audio_end(this);
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {
        var t = this;
        t.setData({
            page: 1,
            isbottom: !1
        });
        var e = {
            op: "service",
            page: t.data.page,
            pagesize: t.data.pagesize
        };
        -1 != t.data.curr && (e.cid = t.data.pclass[t.data.curr].id), a.util.request({
            url: "entry/wxapp/service",
            data: e,
            success: function(a) {
                wx.stopPullDownRefresh();
                var e = a.data;
                "" != e.data ? t.setData({
                    list: e.data,
                    page: t.data.page + 1
                }) : t.setData({
                    isbottom: !0
                });
            }
        });
    },
    onReachBottom: function() {
        var t = this;
        if (!t.data.isbottom) {
            var e = {
                op: "service",
                page: t.data.page,
                pagesize: t.data.pagesize
            };
            -1 != t.data.curr && (e.cid = t.data.pclass[t.data.curr].id), a.util.request({
                url: "entry/wxapp/service",
                data: e,
                success: function(a) {
                    var e = a.data;
                    "" != e.data ? t.setData({
                        list: t.data.list.concat(e.data),
                        page: t.data.page + 1
                    }) : t.setData({
                        isbottom: !0
                    });
                }
            });
        }
    },
    onShareAppMessage: function() {
        var a = this, t = "/xc_train/pages/service/index?&cid=" + a.data.pclass[a.data.curr].id;
        return t = escape(t), {
            title: a.data.config.title + "-" + a.data.pclass[a.data.curr].name,
            path: "/xc_train/pages/base/base?&share=" + t,
            success: function(a) {
                console.log(a);
            },
            fail: function(a) {
                console.log(a);
            }
        };
    }
});