var t = getApp(), a = require("../../common/common.js");

Page({
    data: {
        curr: 1,
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
        }), a.getData(!0);
    },
    onLoad: function(t) {
        var e = this;
        a.config(e), a.theme(e);
        var n = new Date(), o = n.getFullYear(), i = n.getMonth() + 1;
        parseInt(i) < 10 && (i = "0" + i), e.setData({
            date: o + "-" + i
        }), e.getData(!0);
    },
    onReady: function() {},
    onShow: function() {
        a.audio_end(this);
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {
        this.getData(!0);
    },
    onReachBottom: function() {
        this.getData(!1);
    },
    getData: function(a) {
        var e = this;
        a && e.setData({
            page: 1,
            isbottom: !1,
            list: []
        }), e.data.isbottom || t.util.request({
            url: "entry/wxapp/index",
            data: {
                op: "share_count",
                curr: e.data.curr,
                page: e.data.page,
                pagesize: e.data.pagesize,
                plan_date: e.data.date
            },
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
});