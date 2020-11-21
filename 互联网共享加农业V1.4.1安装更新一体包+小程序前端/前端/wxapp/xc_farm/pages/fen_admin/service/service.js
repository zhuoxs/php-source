var common = require("../../common/common.js"), app = getApp();

Page({
    data: {
        navHref: "../../fen_admin/service/service",
        tagCurr1: 0,
        tagCurr2: -1,
        tagList1: [ "全部", "拼团", "砍价", "秒杀" ],
        page: 1,
        pagesize: 20,
        isbottom: !1
    },
    tagChange1: function(a) {
        var e = this;
        if (a.currentTarget.id != e.data.tagCurr1) {
            e.setData({
                page: 1,
                isbottom: !1,
                tagCurr1: a.currentTarget.id
            });
            var t = {
                op: "service",
                page: e.data.page,
                pagesize: e.data.pagesize,
                type: e.data.tagCurr1,
                fen: 1
            };
            -1 != e.data.tagCurr2 && (t.cid = e.data.xc.class[e.data.tagCurr2].id), app.util.request({
                url: "entry/wxapp/service",
                method: "POST",
                data: t,
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
        }
    },
    tagChange2: function(a) {
        var e = this, t = a.currentTarget.id;
        if (e.data.tagCurr2 != t) {
            e.setData({
                page: 1,
                isbottom: !1,
                tagCurr2: t
            });
            var s = {
                op: "service",
                page: e.data.page,
                pagesize: e.data.pagesize,
                type: e.data.tagCurr1,
                fen: 1
            };
            -1 != t && (s.cid = e.data.xc.class[t].id), app.util.request({
                url: "entry/wxapp/service",
                method: "POST",
                data: s,
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
        }
    },
    fen: function(a) {
        var t = this, e = a.currentTarget.dataset.index, s = t.data.xc;
        -1 == s.list[e].service_fen_status && app.util.request({
            url: "entry/wxapp/manage",
            method: "POST",
            data: {
                op: "fen_service",
                id: s.list[e].id,
                status: 1
            },
            success: function(a) {
                "" != a.data.data && (s.list[e].service_fen_status = 1, t.setData({
                    xc: s
                }));
            }
        });
    },
    onLoad: function(a) {
        var e = this;
        common.config(e, "admin3"), "" != a.tagCurr1 && null != a.tagCurr1 && e.setData({
            tagCurr1: a.tagCurr1
        }), app.util.request({
            url: "entry/wxapp/service",
            method: "POST",
            data: {
                op: "service",
                page: e.data.page,
                pagesize: e.data.pagesize,
                type: e.data.tagCurr1,
                fen: 1
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
            isbototm: !1
        });
        var a = {
            op: "service",
            page: e.data.page,
            pagesize: e.data.pagesize,
            type: e.data.tagCurr1,
            fen: 1
        };
        -1 != e.data.tagCurr2 && (a.cid = e.data.xc.class[e.data.tagCurr2].id), app.util.request({
            url: "entry/wxapp/service",
            method: "POST",
            data: a,
            success: function(a) {
                wx.stopPullDownRefresh();
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
    onReachBottom: function() {
        var s = this;
        if (!s.data.isbottom) {
            var a = {
                op: "service",
                page: s.data.page,
                pagesize: s.data.pagesize,
                type: s.data.tagCurr1,
                fen: 1
            };
            -1 != s.data.tagCurr2 && (a.cid = s.data.xc.class[s.data.tagCurr2].id), app.util.request({
                url: "entry/wxapp/service",
                method: "POST",
                data: a,
                success: function(a) {
                    var t = a.data;
                    if ("" != t.data) if ("" != t.data.list && null != t.data.list) {
                        var e = s.data.xc;
                        e.list = e.list.concat(t.data.list), s.setData({
                            page: s.data.page + 1,
                            xc: e
                        });
                    } else wx.showToast({
                        title: "全部加载",
                        icon: "success",
                        duration: 2e3
                    }), s.setData({
                        isbottom: !0
                    });
                }
            });
        }
    }
});