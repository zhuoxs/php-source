var t = getApp(), a = require("../../common/common.js");

Page({
    data: {
        curr: 0,
        page: 1,
        pagesize: 20,
        isbottom: !1,
        list: []
    },
    onLoad: function(t) {
        var e = this;
        a.config(e), a.theme(e), e.getData(!0);
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
    getData: function(a) {
        var e = this;
        a && e.setData({
            page: 1,
            isbottom: !1,
            list: []
        }), e.data.isbottom || t.util.request({
            url: "entry/wxapp/order",
            data: {
                op: "line_order",
                page: e.data.page,
                pagesize: e.data.pagesize
            },
            success: function(t) {
                var a = t.data;
                wx.stopPullDownRefresh(), "" != a.data ? e.setData({
                    list: e.data.list.concat(a.data),
                    page: e.data.page + 1
                }) : e.setData({
                    isbottim: !0
                });
            }
        });
    }
});