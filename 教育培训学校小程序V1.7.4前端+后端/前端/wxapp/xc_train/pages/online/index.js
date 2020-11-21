var a = require("../common/common.js"), t = getApp();

Page({
    data: {
        page: 1,
        pagesize: 20,
        isbottom: !1
    },
    search: function(a) {
        var e = this, s = a.detail.value;
        e.setData({
            page: 1,
            isbottom: !1
        });
        var n = {
            op: "online",
            page: e.data.page,
            pagesize: e.data.pagesize
        };
        "" != s && null != s && (n.search = s), t.util.request({
            url: "entry/wxapp/user",
            method: "POST",
            data: n,
            success: function(a) {
                var t = a.data;
                "" != t.data && (1 == t.data.admin ? (e.setData({
                    xc: t.data
                }), "" != t.data.list && null != t.data.list ? e.setData({
                    page: e.data.page + 1
                }) : e.setData({
                    isbottom: !0
                })) : wx.showModal({
                    title: "错误",
                    content: "没有权限",
                    showCancel: !1,
                    success: function(a) {
                        a.confirm ? wx.reLaunch({
                            url: "../base/base"
                        }) : a.cancel && console.log("用户点击取消");
                    }
                }));
            }
        });
    },
    onLoad: function(e) {
        var s = this;
        a.config(s), a.theme(s);
        var n = setInterval(function() {
            t.util.request({
                url: "entry/wxapp/user",
                method: "POST",
                data: {
                    op: "online",
                    page: s.data.page,
                    pagesize: s.data.pagesize
                },
                success: function(a) {
                    var t = a.data;
                    "" != t.data && (clearInterval(n), 1 == t.data.admin ? (s.setData({
                        xc: t.data
                    }), "" != t.data.list && null != t.data.list ? s.setData({
                        page: s.data.page + 1
                    }) : s.setData({
                        isbottom: !0
                    })) : wx.showModal({
                        title: "错误",
                        content: "没有权限",
                        showCancel: !1,
                        success: function(a) {
                            a.confirm ? wx.reLaunch({
                                url: "../index/index"
                            }) : a.cancel && console.log("用户点击取消");
                        }
                    }));
                }
            });
        }, 1e3);
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {
        var a = this;
        a.setData({
            page: 1,
            isbottom: !1
        }), t.util.request({
            url: "entry/wxapp/user",
            method: "POST",
            data: {
                op: "online",
                page: a.data.page,
                pagesize: a.data.pagesize
            },
            success: function(t) {
                var e = t.data;
                wx.stopPullDownRefresh(), "" != e.data && (1 == e.data.admin ? (a.setData({
                    xc: e.data
                }), "" != e.data.list && null != e.data.list ? a.setData({
                    page: a.data.page + 1
                }) : a.setData({
                    isbottom: !0
                })) : wx.showModal({
                    title: "错误",
                    content: "没有权限",
                    showCancel: !1,
                    success: function(a) {
                        a.confirm ? wx.reLaunch({
                            url: "../index/index"
                        }) : a.cancel && console.log("用户点击取消");
                    }
                }));
            }
        });
    },
    onReachBottom: function() {
        var a = this;
        a.data.isbottom || t.util.request({
            url: "entry/wxapp/user",
            method: "POST",
            data: {
                op: "online",
                page: a.data.page,
                pagesize: a.data.pagesize
            },
            success: function(t) {
                var e = t.data;
                if ("" != e.data) {
                    var s = a.data.xc;
                    "" != e.data.list && null != e.data.list ? (s.list = s.list.concat(e.data.list), 
                    a.setData({
                        xc: s,
                        page: a.data.page + 1
                    })) : a.setData({
                        isbottom: !0
                    });
                }
            }
        });
    }
});