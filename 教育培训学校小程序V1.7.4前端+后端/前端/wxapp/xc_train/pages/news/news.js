var a = getApp(), t = require("../common/common.js");

Page({
    data: {
        pagePath: "../news/news",
        page: 1,
        pagesize: 20,
        isbottom: !1
    },
    onLoad: function(e) {
        var s = this;
        t.config(s), t.theme(s), "" != e.cid && null != e.cid ? (s.setData({
            cid: e.cid
        }), a.util.request({
            url: "entry/wxapp/service",
            data: {
                op: "news",
                page: s.data.page,
                pagesize: s.data.pagesize,
                cid: s.data.cid
            },
            success: function(a) {
                var t = a.data;
                if ("" != t.data) {
                    for (var e = 0; e < t.data.length; e++) t.data[e].nav = "../about/link?&url=" + escape(t.data[e].link);
                    s.setData({
                        list: t.data,
                        page: s.data.page + 1
                    });
                } else s.setData({
                    isbottom: !0
                });
            }
        }), a.util.request({
            url: "entry/wxapp/service",
            data: {
                op: "news_class",
                id: s.data.cid
            },
            success: function(a) {
                var t = a.data;
                "" != t.data && s.setData({
                    new_class: t.data
                });
            }
        })) : wx.showModal({
            title: "提示",
            content: "非法访问",
            showCancel: !1,
            success: function(a) {
                a.confirm && wx.reLaunch({
                    url: "../index/index"
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
        }), a.util.request({
            url: "entry/wxapp/service",
            data: {
                op: "news",
                page: t.data.page,
                pagesize: t.data.pagesize,
                cid: t.data.cid
            },
            success: function(a) {
                wx.stopPullDownRefresh();
                var e = a.data;
                if ("" != e.data) {
                    for (var s = 0; s < e.data.length; s++) e.data[s].nav = "../about/link?&url=" + escape(e.data[s].link);
                    t.setData({
                        list: e.data,
                        page: t.data.page + 1
                    });
                } else t.setData({
                    isbottom: !0
                });
            }
        });
    },
    onReachBottom: function() {
        var t = this;
        t.data.isbottom || a.util.request({
            url: "entry/wxapp/service",
            data: {
                op: "news",
                page: t.data.page,
                pagesize: t.data.pagesize,
                cid: t.data.cid
            },
            success: function(a) {
                var e = a.data;
                if ("" != e.data) {
                    for (var s = 0; s < e.data.length; s++) e.data[s].nav = "../about/link?&url=" + escape(e.data[s].link);
                    t.setData({
                        list: t.data.list.concat(e.data),
                        page: t.data.page + 1
                    });
                } else t.setData({
                    isbottom: !0
                });
            }
        });
    }
});