var common = require("../common/common.js"), app = getApp();

Page({
    data: {
        tab: [ "全部", "拼单中", "待发货", "待收货", "待评价" ],
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
                op: "pin_order",
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
                    isbottom: !0,
                    xc: []
                });
            }
        }));
    },
    loadingFunc: function() {
        var e = this;
        if (!e.data.isbottom && e.data.canload) {
            e.setData({
                canload: !1
            });
            var a = {
                op: "order",
                page: e.data.page,
                pagesize: e.data.pagesize,
                curr: e.data.tabCurr
            };
            app.util.request({
                url: "entry/wxapp/order",
                method: "POST",
                data: a,
                success: function(a) {
                    var t = a.data;
                    "" != t.data ? e.setData({
                        list: e.data.list.concat(t.data),
                        page: e.data.page + 1,
                        canload: !0
                    }) : e.setData({
                        isbottom: !0,
                        canload: !0
                    });
                }
            });
        }
    },
    shFunc: function(a) {
        var t = this, e = t.data.xc, o = a.currentTarget.dataset.index;
        wx.showModal({
            title: "确认收货",
            content: "是否要确认收货？",
            success: function(a) {
                a.confirm ? app.util.request({
                    url: "entry/wxapp/order",
                    method: "POST",
                    data: {
                        op: "order_status",
                        id: e[o].id,
                        status: 3
                    },
                    success: function(a) {
                        "" != a.data.data && (wx.showToast({
                            title: "收货成功",
                            icon: "success",
                            duration: 2e3
                        }), e[o].order_status = 3, t.setData({
                            xc: e
                        }));
                    }
                }) : a.cancel && console.log("用户点击取消");
            }
        });
    },
    onLoad: function(a) {
        var e = this;
        common.config(e), app.util.request({
            url: "entry/wxapp/order",
            method: "POST",
            data: {
                op: "pin_order",
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
                op: "pin_order",
                page: e.data.page,
                pagesize: e.data.pagesize,
                curr: e.data.tabCurr
            },
            success: function(a) {
                wx.stopPullDownRefresh();
                var t = a.data;
                "" != t.data ? e.setData({
                    xc: t.data,
                    page: e.data.page + 1
                }) : e.setData({
                    isbottom: !0,
                    xc: []
                });
            }
        });
    },
    onReachBottom: function() {
        this.data.isbottom;
    },
    onShareAppMessage: function(a) {
        var t = app.config.webname, e = "", o = "/xc_farm/pages/index/index";
        if ("button" === a.from) {
            var n = this.data.xc, s = a.target.dataset.index;
            t = n[s].pin_name, o = "/xc_farm/pages/pin/detail?&id=" + n[s].service, e = n[s].pin_simg;
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