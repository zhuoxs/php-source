var t = getApp(), a = require("../../common/common.js");

Page({
    data: {
        curr: -1,
        type: 1,
        date: "",
        page: 1,
        pagesize: 20,
        isbottom: !1,
        list: []
    },
    tab: function(t) {
        var a = this, e = t.currentTarget.dataset.index;
        e != a.data.curr && (a.setData({
            curr: e
        }), a.getData(!0));
    },
    bindDateChange: function(t) {
        var a = this;
        a.setData({
            date: t.detail.value
        }), a.getCount(), a.getData(!0);
    },
    onLoad: function(t) {
        var e = this;
        e.setData({
            type: t.type
        }), a.config(e), a.theme(e);
        var n = new Date(), o = n.getFullYear(), s = n.getMonth() + 1;
        parseInt(s) < 10 && (s = "0" + s), e.setData({
            date: o + "-" + s
        }), e.getCount(), e.getData(!0);
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {
        this.getData(!0);
    },
    onReachBottom: function() {
        this.getData(!1);
    },
    getCount: function() {
        var a = this, e = {
            op: "share_record_count"
        };
        2 == a.data.type && (e.plan_date = a.data.date), t.util.request({
            url: "entry/wxapp/index",
            data: e,
            success: function(t) {
                var e = t.data;
                "" != e.data && a.setData({
                    amount: e.data.amount
                });
            }
        });
    },
    getData: function(a) {
        var e = this;
        if (a && e.setData({
            page: 1,
            isbottom: !1,
            list: []
        }), !e.data.isbottom) {
            var n = {
                op: "share_record",
                page: e.data.page,
                pagesize: e.data.pagesize,
                curr: e.data.curr
            };
            2 == e.data.type && (n.plan_date = e.data.date), t.util.request({
                url: "entry/wxapp/index",
                data: n,
                success: function(t) {
                    wx.stopPullDownRefresh();
                    var a = t.data;
                    "" != a.data ? e.setData({
                        list: e.data.list.concat(a.data),
                        page: e.data.page + 1
                    }) : e.setData({
                        isbottom: !0
                    });
                }
            });
        }
    }
});