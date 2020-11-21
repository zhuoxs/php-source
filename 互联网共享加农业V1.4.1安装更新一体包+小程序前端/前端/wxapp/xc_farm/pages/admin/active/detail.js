var common = require("../../common/common.js"), app = getApp(), WxParse = require("../../../../wxParse/wxParse.js");

Page({
    data: {
        curr: 2,
        page: 1,
        pagesize: 20,
        isbottom: !1
    },
    tab: function(a) {
        var t = a.currentTarget.dataset.index;
        t != this.data.curr && this.setData({
            curr: t
        });
    },
    submit: function(a) {
        var t = this, e = a.currentTarget.dataset.index, o = t.data.order;
        parseInt(o[e].is_member) < parseInt(o[e].member) && wx.showModal({
            title: "提示",
            content: "确定核销吗？",
            success: function(a) {
                a.confirm ? app.util.request({
                    url: "entry/wxapp/manage",
                    method: "POST",
                    data: {
                        op: "active_status",
                        id: o[e].id
                    },
                    success: function(a) {
                        "" != a.data.data && (wx.showToast({
                            title: "核销成功",
                            icon: "success",
                            duration: 2e3
                        }), o[e].is_member = parseInt(o[e].is_member) + 1, t.setData({
                            order: o
                        }));
                    }
                }) : a.cancel && console.log("用户点击取消");
            }
        });
    },
    code: function(a) {
        wx.scanCode({
            success: function(a) {
                console.log(a), wx.redirectTo({
                    url: a.result
                });
            }
        });
    },
    onLoad: function(a) {
        var e = this;
        common.config(e, "admin"), app.util.request({
            url: "entry/wxapp/manage",
            method: "POST",
            data: {
                op: "active_detail",
                id: a.id
            },
            success: function(a) {
                var t = a.data;
                if ("" != t.data && (e.setData({
                    xc: t.data
                }), "" != t.data.content && null != t.data.content)) WxParse.wxParse("article", "html", t.data.content, e, 0);
            }
        });
        var t = {
            op: "active_order",
            id: a.id,
            page: e.data.page,
            pagesize: e.data.pagesize
        };
        "" != a.order && null != a.order && (t.order = a.order), app.util.request({
            url: "entry/wxapp/manage",
            showLoading: !1,
            method: "POST",
            data: t,
            success: function(a) {
                var t = a.data;
                "" != t.data ? e.setData({
                    order: t.data,
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
            url: "entry/wxapp/manage",
            method: "POST",
            data: {
                op: "active_detail",
                id: e.data.xc.id
            },
            success: function(a) {
                var t = a.data;
                if (wx.stopPullDownRefresh(), "" != t.data && (e.setData({
                    xc: t.data
                }), "" != t.data.content && null != t.data.content)) WxParse.wxParse("article", "html", t.data.content, e, 0);
            }
        }), app.util.request({
            url: "entry/wxapp/manage",
            showLoading: !1,
            method: "POST",
            data: {
                op: "active_order",
                id: e.data.xc.id,
                page: e.data.page,
                pagesize: e.data.pagesize
            },
            success: function(a) {
                var t = a.data;
                "" != t.data ? e.setData({
                    order: t.data,
                    page: e.data.page + 1
                }) : e.setData({
                    isbottom: !0,
                    order: []
                });
            }
        });
    },
    onReachBottom: function() {
        var e = this;
        e.data.isbottom || 2 != e.data.curr || app.util.request({
            url: "entry/wxapp/manage",
            method: "POST",
            data: {
                op: "active_order",
                id: e.data.xc.id,
                page: e.data.page,
                pagesize: e.data.pagesize
            },
            success: function(a) {
                var t = a.data;
                "" != t.data ? e.setData({
                    order: e.data.order.concat(t.data),
                    page: e.data.page + 1
                }) : e.setData({
                    isbottom: !0
                });
            }
        });
    }
});