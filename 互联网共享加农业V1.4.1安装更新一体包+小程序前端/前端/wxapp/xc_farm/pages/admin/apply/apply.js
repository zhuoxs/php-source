var common = require("../../common/common.js"), app = getApp();

Page({
    data: {
        curr: 1,
        page: 1,
        pagesize: 20,
        isbottom: !1
    },
    tab: function(a) {
        var e = this, t = a.currentTarget.dataset.index;
        if (t != e.data.curr) {
            e.setData({
                curr: t,
                page: 1,
                isbottom: !1
            });
            var o = {
                op: "apply",
                page: e.data.page,
                pagesize: e.data.pagesize,
                curr: e.data.curr
            };
            "" != e.data.mobile && null != e.data.mobile && (o.mobile = e.data.mobile), app.util.request({
                url: "entry/wxapp/manage",
                method: "POST",
                data: o,
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
    input: function(a) {
        this.setData({
            mobile: a.detail.value
        });
    },
    search: function() {
        var e = this;
        if ("" != e.data.mobile && null != e.data.mobile) {
            e.setData({
                page: 1,
                isbottom: !1
            });
            var a = {
                op: "apply",
                page: e.data.page,
                pagesize: e.data.pagesize,
                curr: e.data.curr
            };
            "" != e.data.mobile && null != e.data.mobile && (a.mobile = e.data.mobile), app.util.request({
                url: "entry/wxapp/manage",
                method: "POST",
                data: a,
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
    call: function(a) {
        var t = a.currentTarget.dataset.index;
        wx.makePhoneCall({
            phoneNumber: this.data.list[t].mobile
        });
    },
    onLoad: function(a) {
        var e = this;
        common.config(e, "admin"), app.util.request({
            url: "entry/wxapp/manage",
            method: "POST",
            data: {
                op: "apply",
                page: e.data.page,
                pagesize: e.data.pagesize,
                curr: e.data.curr
            },
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
        });
        var a = {
            op: "apply",
            page: e.data.page,
            pagesize: e.data.pagesize,
            curr: e.data.curr
        };
        "" != e.data.mobile && null != e.data.mobile && (a.mobile = e.data.mobile), app.util.request({
            url: "entry/wxapp/manage",
            method: "POST",
            data: a,
            success: function(a) {
                var t = a.data;
                wx.stopPullDownRefresh(), "" != t.data ? e.setData({
                    list: t.data,
                    page: e.data.page + 1
                }) : e.setData({
                    isbottom: !0,
                    list: []
                });
            }
        });
    },
    onReachBottom: function() {
        var e = this;
        if (!e.data.isbottom) {
            var a = {
                op: "apply",
                page: e.data.page,
                pagesize: e.data.pagesize,
                curr: e.data.curr
            };
            "" != e.data.mobile && null != e.data.mobile && (a.mobile = e.data.mobile), app.util.request({
                url: "entry/wxapp/manage",
                method: "POST",
                data: a,
                success: function(a) {
                    var t = a.data;
                    "" != t.data ? e.setData({
                        list: e.data.list.concat(t.data),
                        page: e.data.page + 1
                    }) : e.setData({
                        isbottom: !0
                    });
                }
            });
        }
    }
});