function t(t) {
    a = setInterval(function() {
        var e = t.data.fail;
        if (e > 0) {
            e -= 1;
            var n = parseInt(e / 3600), i = parseInt(e % 3600 / 60), c = e % 60;
            t.setData({
                fail: e,
                hour: n,
                min: i,
                second: c
            });
        } else clearInterval(a);
    }, 1e3);
}

var a, e = getApp(), n = require("../common/common.js"), i = require("../../../wxParse/wxParse.js");

Page({
    data: {
        curr: 1,
        fail: 0,
        hour: 0,
        min: 0,
        second: 0
    },
    cut: function() {
        var t = this;
        e.util.request({
            url: "entry/wxapp/service",
            data: {
                op: "cut_price",
                id: t.data.list.id
            },
            success: function(a) {
                var n = a.data;
                "" != n.data && (t.setData({
                    menu1: !0,
                    cut_price: n.data.cut_price
                }), e.util.request({
                    url: "entry/wxapp/service",
                    data: {
                        op: "cut_detail",
                        id: t.data.list.id
                    },
                    success: function(a) {
                        var e = a.data;
                        "" != e.data && t.setData({
                            list: e.data
                        });
                    }
                }));
            }
        });
    },
    menu_close: function() {
        this.setData({
            menu1: !1,
            menu2: !1
        });
    },
    tab: function(t) {
        var a = this, e = t.currentTarget.dataset.index;
        a.data.curr != e && a.setData({
            curr: e
        });
    },
    onLoad: function(c) {
        var s = this;
        n.config(s), n.theme(s), clearInterval(a), e.util.request({
            url: "entry/wxapp/service",
            data: {
                op: "cut_detail",
                id: c.id
            },
            success: function(a) {
                var e = a.data;
                if ("" != e.data && (-1 == e.data.end && e.data.fail > 0 && (s.setData({
                    fail: e.data.fail
                }), t(s)), s.setData({
                    list: e.data
                }), 2 == e.data.content_type)) {
                    var n = e.data.content2;
                    i.wxParse("content2", "html", n, s, 5);
                }
            }
        }), e.util.request({
            url: "entry/wxapp/service",
            data: {
                op: "cut_log",
                id: c.id
            },
            success: function(t) {
                var a = t.data;
                "" != a.data && s.setData({
                    order: a.data
                });
            }
        }), "" != c.cut_openid && null != c.cut_openid && (s.setData({
            cut_openid: c.cut_openid
        }), e.util.request({
            url: "entry/wxapp/service",
            data: {
                op: "cut_price2",
                id: c.id,
                openid: s.data.cut_openid
            },
            success: function(t) {
                var a = t.data;
                "" != a.data && s.setData({
                    menu2: !0,
                    cut_price: a.data.cut_price,
                    cut_user: a.data.cut_user
                });
            }
        }));
    },
    onReady: function() {},
    onShow: function() {
        n.audio_end(this);
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {
        var n = this;
        clearInterval(a), e.util.request({
            url: "entry/wxapp/service",
            data: {
                op: "cut_detail",
                id: n.data.list.id
            },
            success: function(a) {
                var e = a.data;
                if (wx.stopPullDownRefresh(), "" != e.data && (-1 == e.data.end && e.data.fail > 0 && (n.setData({
                    fail: e.data.fail
                }), t(n)), n.setData({
                    list: e.data
                }), 2 == e.data.content_type)) {
                    var c = e.data.content2;
                    i.wxParse("content2", "html", c, n, 5);
                }
            }
        });
    },
    onReachBottom: function() {},
    onShareAppMessage: function() {
        var t = this, a = "/xc_train/pages/cut/detail?&id=" + t.data.list.id + "&cut_openid=" + t.data.list.userinfo.openid;
        a = escape(a);
        var e = t.data.config.title + "-" + t.data.list.name;
        return "" != t.data.config.cut_share && null != t.data.config.cut_share && (e = t.data.config.cut_share), 
        {
            title: e,
            path: "/xc_train/pages/base/base?&share=" + a,
            success: function(t) {
                console.log(t);
            },
            fail: function(t) {
                console.log(t);
            }
        };
    }
});