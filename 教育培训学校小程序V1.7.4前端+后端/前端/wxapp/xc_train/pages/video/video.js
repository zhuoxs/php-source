var a = getApp(), t = require("../common/common.js");

Page({
    data: {
        curr: -1,
        pagePath: "../video/video",
        page: 1,
        pagesize: 20,
        isbottom: !1
    },
    tab: function(t) {
        var e = this, s = t.currentTarget.dataset.index;
        if (s != e.data.curr) {
            e.setData({
                curr: s,
                list: [],
                page: 1,
                isbottom: !1
            });
            var o = {
                op: "video",
                page: e.data.page,
                pagesize: e.data.pagesize
            };
            -1 != e.data.curr && (o.cid = e.data.pclass[e.data.curr].id), a.util.request({
                url: "entry/wxapp/service",
                data: o,
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
    to_shop: function() {
        var t = this;
        a.util.request({
            url: "entry/wxapp/manage",
            showLoading: !1,
            data: {
                op: "bind"
            },
            success: function(a) {
                "" != a.data.data ? wx.navigateTo({
                    url: "../manage/index"
                }) : t.setData({
                    shadow: !0,
                    manage: !0
                });
            }
        });
    },
    password: function(a) {
        this.setData({
            password: a.detail.value
        });
    },
    shop_close: function() {
        this.setData({
            shadow: !1,
            manage: !1
        });
    },
    shop_login: function(t) {
        var e = this, s = t.currentTarget.dataset.status;
        "" == e.data.password || null == e.data.password ? wx.showModal({
            title: "错误",
            content: "请输入密码",
            success: function(a) {
                a.confirm ? console.log("用户点击确定") : a.cancel && console.log("用户点击取消");
            }
        }) : a.util.request({
            url: "entry/wxapp/manage",
            showLoading: !1,
            data: {
                op: "login",
                status: s,
                password: e.data.password
            },
            success: function(a) {
                "" != a.data.data ? wx.navigateTo({
                    url: "../manage/index"
                }) : e.setData({
                    password: ""
                });
            }
        });
    },
    onLoad: function(e) {
        var s = this;
        t.config(s), t.theme(s), a.util.request({
            url: "entry/wxapp/service",
            data: {
                op: "video_class"
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
                op: "video",
                page: s.data.page,
                pagesize: s.data.pagesize
            },
            success: function(a) {
                var t = a.data;
                "" != t.data ? s.setData({
                    list: t.data,
                    page: s.data.page + 1
                }) : s.setData({
                    isbottom: !0
                });
            }
        }), s.setData({
            userinfo: a.userinfo
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
            op: "video",
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
                op: "video",
                page: t.data.page,
                pagesize: t.data.pagesize
            };
            -1 != t.data.curr && (e.cid = t.data.pclass[t.data.curr].id), a.util.request({
                url: "entry/wxapp/service",
                data: e,
                success: function(a) {
                    var e = a.data;
                    "" != e.data ? t.setData({
                        list: e.data,
                        page: t.data.page + 1
                    }) : t.setData({
                        isbottom: !0
                    });
                }
            });
        }
    }
});