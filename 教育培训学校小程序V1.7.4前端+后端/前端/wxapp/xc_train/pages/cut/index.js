function a(a) {
    t = setInterval(function() {
        for (var t = a.data.list, e = 0; e < t.length; e++) t[e].fail > 0 && (t[e].fail = t[e].fail - 1, 
        t[e].hour = parseInt(t[e].fail / 3600), t[e].min = parseInt(t[e].fail % 3600 / 60), 
        t[e].second = t[e].fail % 60);
        a.setData({
            list: t
        });
    }, 1e3);
}

var t, e = getApp(), s = require("../common/common.js");

Page({
    data: {
        page: 1,
        pagesize: 20,
        isbottom: !1
    },
    onLoad: function(i) {
        var o = this;
        s.config(o), s.theme(o), clearInterval(t), e.util.request({
            url: "entry/wxapp/service",
            data: {
                op: "cut_user",
                page: o.data.page,
                pagesize: o.data.pagesize
            },
            success: function(t) {
                var e = t.data;
                "" != e.data ? (o.setData({
                    list: e.data,
                    page: o.data.page
                }), a(o)) : o.setData({
                    isbottom: !0
                });
            }
        });
    },
    onReady: function() {},
    onShow: function() {
        s.audio_end(this);
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {
        var s = this;
        clearInterval(t), s.setData({
            page: 1,
            isbottom: !1
        }), e.util.request({
            url: "entry/wxapp/service",
            data: {
                op: "cut_user",
                page: s.data.page,
                pagesize: s.data.pagesize
            },
            success: function(t) {
                var e = t.data;
                wx.stopPullDownRefresh(), "" != e.data ? (s.setData({
                    list: e.data,
                    page: s.data.page
                }), a(s)) : s.setData({
                    isbottom: !0,
                    list: []
                });
            }
        });
    },
    onReachBottom: function() {
        var a = this;
        a.data.isbottom || e.util.request({
            url: "entry/wxapp/service",
            data: {
                op: "cut_user",
                page: a.data.page,
                pagesize: a.data.pagesize
            },
            success: function(t) {
                var e = t.data;
                "" != e.data ? a.setData({
                    list: a.data.list.concat(e.data),
                    page: a.data.page
                }) : a.setData({
                    isbottom: !0
                });
            }
        });
    }
});