var a = getApp(), t = require("../../common/common.js");

Page({
    data: {
        curr: -1,
        page: 1,
        pagesize: 20,
        isbottom: !1,
        list: []
    },
    tab: function(a) {
        var t = this, e = a.currentTarget.dataset.index;
        e != t.data.curr && (t.setData({
            curr: e
        }), t.getData(!0));
    },
    onLoad: function(a) {
        var e = this;
        t.config(e), t.theme(e), e.getNav(), e.getData(!0);
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
    getNav: function() {
        var t = this;
        a.util.request({
            url: "entry/wxapp/index",
            data: {
                op: "line_class"
            },
            success: function(a) {
                var e = a.data;
                "" != e.data && t.setData({
                    nav: e.data
                });
            }
        });
    },
    getData: function(t) {
        var e = this;
        if (t && e.setData({
            page: 1,
            isbottom: !1,
            list: []
        }), !e.data.isbottom) {
            var n = {
                op: "line",
                page: e.data.page,
                pagesize: e.data.pagesize
            };
            -1 != e.data.curr && (n.cid = e.data.nav[e.data.curr].id), a.util.request({
                url: "entry/wxapp/index",
                data: n,
                success: function(a) {
                    wx.stopPullDownRefresh();
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