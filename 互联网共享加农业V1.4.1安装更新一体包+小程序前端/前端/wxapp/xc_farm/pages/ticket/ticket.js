var common = require("../common/common.js"), app = getApp();

Page({
    data: {
        navHref: "",
        tab: [ "兑换券", "待领取", "未使用", "已过期" ],
        tabCurr: 1
    },
    tabChange: function(a) {
        var e = this, t = a.currentTarget.id;
        if (t != e.data.tabCurr) if (e.setData({
            tabCurr: t,
            list: []
        }), 0 == t) app.util.request({
            url: "entry/wxapp/user",
            method: "POST",
            data: {
                op: "cf_card"
            },
            success: function(a) {
                var t = a.data;
                "" != t.data ? e.setData({
                    list: t.data
                }) : e.setData({
                    list: []
                });
            }
        }); else {
            var s = {
                op: "coupon",
                curr: e.data.tabCurr
            };
            app.util.request({
                url: "entry/wxapp/user",
                method: "POST",
                data: s,
                success: function(a) {
                    var t = a.data;
                    "" != t.data ? e.setData({
                        list: t.data
                    }) : e.setData({
                        list: []
                    });
                }
            });
        }
    },
    get_coupon: function(a) {
        var t = this, e = a.currentTarget.dataset.index, s = t.data.list;
        app.util.request({
            url: "entry/wxapp/user",
            method: "POST",
            data: {
                op: "get_coupon",
                id: s[e].id
            },
            success: function(a) {
                "" != a.data.data && (wx.showToast({
                    title: "领取成功",
                    icon: "success",
                    duration: 2e3
                }), s.splice(e, 1), t.setData({
                    list: s
                }));
            }
        });
    },
    onLoad: function(a) {
        var e = this;
        common.config(e);
        var t = {
            op: "coupon",
            curr: e.data.tabCurr
        };
        app.util.request({
            url: "entry/wxapp/user",
            method: "POST",
            data: t,
            success: function(a) {
                var t = a.data;
                "" != t.data && e.setData({
                    list: t.data
                });
            }
        });
    },
    onPullDownRefresh: function() {
        var e = this;
        if (0 == e.data.tabCurr) app.util.request({
            url: "entry/wxapp/user",
            method: "POST",
            data: {
                op: "cf_card"
            },
            success: function(a) {
                var t = a.data;
                wx.stopPullDownRefresh(), "" != t.data ? e.setData({
                    list: t.data
                }) : e.setData({
                    list: []
                });
            }
        }); else {
            var a = {
                op: "coupon",
                curr: e.data.tabCurr
            };
            app.util.request({
                url: "entry/wxapp/user",
                method: "POST",
                data: a,
                success: function(a) {
                    var t = a.data;
                    wx.stopPullDownRefresh(), "" != t.data ? e.setData({
                        list: t.data
                    }) : e.setData({
                        list: []
                    });
                }
            });
        }
    }
});