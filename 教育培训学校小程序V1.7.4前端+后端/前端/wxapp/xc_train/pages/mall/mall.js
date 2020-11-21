var a = getApp(), t = require("../common/common.js");

Page({
    data: {
        pagePath: "../mall/mall",
        curr: -1,
        page: 1,
        pagesize: 20,
        isbottom: !1,
        tagList1: [ "全部", "拼团", "限时抢购" ],
        tagCurr1: 0
    },
    tagChange1: function(t) {
        var e = this, s = t.currentTarget.dataset.index;
        if (s != e.data.tagCurr1) {
            e.setData({
                tagCurr1: s,
                page: 1,
                isbottom: !1
            });
            var r = {
                op: "mall",
                page: e.data.page,
                pagesize: e.data.pagesize
            };
            -1 != e.data.curr && (r.cid = e.data.pclass[e.data.curr].id), 0 != e.data.tagCurr1 && (r.type = e.data.tagCurr1 + 1), 
            a.util.request({
                url: "entry/wxapp/service",
                data: r,
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
    tab: function(t) {
        var e = this, s = t.currentTarget.dataset.index;
        if (s != e.data.curr) {
            e.setData({
                curr: s,
                page: 1,
                isbottom: !1
            });
            var r = {
                op: "mall",
                page: e.data.page,
                pagesize: e.data.pagesize
            };
            -1 != e.data.curr && (r.cid = e.data.pclass[e.data.curr].id), 0 != e.data.tagCurr1 && (r.type = e.data.tagCurr1 + 1), 
            a.util.request({
                url: "entry/wxapp/service",
                data: r,
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
        t.config(s), t.theme(s), "" != e.type && null != e.type && s.setData({
            tagCurr1: e.type
        }), a.util.request({
            url: "entry/wxapp/service",
            data: {
                op: "service_class",
                type: 3
            },
            showLoading: !1,
            success: function(a) {
                var t = a.data;
                "" != t.data && s.setData({
                    pclass: t.data
                });
            }
        });
        var r = {
            op: "mall",
            page: s.data.page,
            pagesize: s.data.pagesize
        };
        -1 != s.data.curr && (r.cid = s.data.pclass[s.data.curr].id), 0 != s.data.tagCurr1 && (r.type = parseInt(s.data.tagCurr1) + 1), 
        a.util.request({
            url: "entry/wxapp/service",
            data: r,
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
            op: "mall",
            page: t.data.page,
            pagesize: t.data.pagesize
        };
        -1 != t.data.curr && (e.cid = t.data.pclass[t.data.curr].id), 0 != t.data.tagCurr1 && (e.type = t.data.tagCurr1 + 1), 
        a.util.request({
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
        var t = this;
        if (!t.data.isbottom) {
            var e = {
                op: "mall",
                page: t.data.page,
                pagesize: t.data.pagesize
            };
            -1 != t.data.curr && (e.cid = t.data.pclass[t.data.curr].id), 0 != t.data.tagCurr1 && (e.type = t.data.tagCurr1 + 1), 
            a.util.request({
                url: "entry/wxapp/service",
                data: e,
                success: function(a) {
                    var e = a.data;
                    wx.stopPullDownRefresh(), "" != e.data ? t.setData({
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
        var a = this, t = "/xc_train/pages/mall/mall";
        return t = escape(t), {
            title: a.data.config.title,
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