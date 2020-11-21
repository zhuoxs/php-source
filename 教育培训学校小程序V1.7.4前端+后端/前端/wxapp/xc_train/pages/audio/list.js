var a = getApp(), t = require("../common/common.js");

Page({
    data: {
        curr: -1,
        pagePath: "../audio/list",
        page: 1,
        pagesize: 20,
        isbottom: !1
    },
    tab: function(t) {
        var e = this, s = t.currentTarget.dataset.index;
        if (s != e.data.curr) {
            e.setData({
                curr: s,
                page: e.data.page,
                isbottom: !1
            });
            var i = {
                op: "audio",
                page: e.data.list,
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
                        isbottom: !0,
                        list: []
                    });
                }
            });
        }
    },
    onLoad: function(e) {
        var s = this;
        t.config(s), t.theme(s), a.util.request({
            url: "entry/wxapp/service",
            data: {
                op: "audio_class"
            },
            showLoading: !1,
            success: function(a) {
                var t = a.data;
                "" != t.data && s.setData({
                    pclass: t.data
                });
            }
        }), a.util.request({
            url: "entry/wxapp/service",
            data: {
                op: "audio",
                page: s.data.list,
                pagesize: s.data.pagesize
            },
            showLoading: !1,
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
            op: "audio",
            page: t.data.list,
            pagesize: t.data.pagesize
        };
        -1 != t.data.curr && (e.cid = t.data.pclass[t.data.curr].id), a.util.request({
            url: "entry/wxapp/service",
            data: e,
            success: function(a) {
                var e = a.data;
                wx.stopPullDownRefresh(), "" != e.data ? t.setData({
                    list: e.data,
                    page: t.data.page + 1
                }) : t.setData({
                    isbottom: !0,
                    list: []
                });
            }
        });
    },
    onReachBottom: function() {
        var t = this, e = {
            op: "audio",
            page: t.data.list,
            pagesize: t.data.pagesize
        };
        -1 != t.data.curr && (e.cid = t.data.pclass[t.data.curr].id), a.util.request({
            url: "entry/wxapp/service",
            data: e,
            success: function(a) {
                var e = a.data;
                "" != e.data ? t.setData({
                    list: t.data.concat(e.data),
                    page: t.data.page + 1
                }) : t.setData({
                    isbottom: !0
                });
            }
        });
    }
});