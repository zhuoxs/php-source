var common = require("../common/common.js"), app = getApp();

Page({
    data: {
        tab: [ "全部", "拼种中", "已完成", "退款" ],
        tabCurr: 0,
        page: 1,
        pagesize: 20,
        isbottom: !1,
        canload: !0
    },
    tabChange: function(a) {
        var e = this, t = a.currentTarget.dataset.index;
        t != e.data.tabCurr && (e.setData({
            tabCurr: t,
            page: 1,
            isbottom: !1
        }), app.util.request({
            url: "entry/wxapp/order",
            method: "POST",
            data: {
                op: "plant_order",
                page: e.data.page,
                pagesize: e.data.pagesize,
                curr: e.data.tabCurr
            },
            success: function(a) {
                var t = a.data;
                "" != t.data ? e.setData({
                    xc: t.data,
                    page: e.data.page + 1
                }) : e.setData({
                    xc: [],
                    isbottom: !0
                });
            }
        }));
    },
    loadingFunc: function() {
        var e = this;
        !e.data.isbottom && e.data.canload && (e.setData({
            canload: !1
        }), app.util.request({
            url: "entry/wxapp/order",
            method: "POST",
            data: {
                op: "plant_order",
                page: e.data.page,
                pagesize: e.data.pagesize,
                curr: e.data.tabCurr
            },
            success: function(a) {
                var t = a.data;
                "" != t.data ? e.setData({
                    xc: e.data.xc.concat(t.data),
                    page: e.data.page + 1,
                    canload: !0
                }) : e.setData({
                    isbottom: !0,
                    canload: !0
                });
            }
        }));
    },
    onLoad: function(a) {
        var e = this;
        common.config(e), app.util.request({
            url: "entry/wxapp/order",
            method: "POST",
            data: {
                op: "plant_order",
                page: e.data.page,
                pagesize: e.data.pagesize,
                curr: e.data.tabCurr
            },
            success: function(a) {
                var t = a.data;
                "" != t.data ? e.setData({
                    xc: t.data,
                    page: e.data.page + 1
                }) : e.setData({
                    isbottom: !0
                });
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
            isbottom: !1
        }), app.util.request({
            url: "entry/wxapp/order",
            method: "POST",
            data: {
                op: "plant_order",
                page: e.data.page,
                pagesize: e.data.pagesize,
                curr: e.data.tabCurr
            },
            success: function(a) {
                var t = a.data;
                wx.stopPullDownRefresh(), "" != t.data ? e.setData({
                    xc: t.data,
                    page: e.data.page + 1
                }) : e.setData({
                    isbottom: !0
                });
            }
        });
    },
    onReachBottom: function() {},
    onShareAppMessage: function(a) {
        var t = app.config.webname, e = "", o = "/xc_farm/pages/index/index";
        if ("button" === a.from) {
            var n = this.data.xc, r = a.target.dataset.index;
            t = n[r].pin_name, o = "/xc_farm/pages/plant_pin/index?&id=" + n[r].group, e = n[r].pin_simg;
        }
        return {
            title: t,
            imageUrl: e,
            path: o,
            success: function(a) {
                console.log(a);
            },
            fail: function(a) {
                console.log(a);
            }
        };
    }
});