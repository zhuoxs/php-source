var t = getApp(), a = require("../../common/common.js");

Page({
    data: {
        curr: 1,
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
    onLoad: function(e) {
        var n = this;
        a.config(n), a.theme(n), t.util.request({
            url: "entry/wxapp/index",
            data: {
                op: "share_config"
            },
            success: function(t) {
                var a = t.data;
                "" != a.data && n.setData({
                    share: a.data
                });
            }
        }), n.getData(!0);
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
                op: "share_team",
                curr: e.data.curr
            },
            success: function(t) {
                wx.stopPullDownRefresh();
                var a = t.data;
                "" != a.data ? e.setData({
                    list: e.data.list.concat(a.data),
                    page: e.data.page
                }) : e.setData({
                    isbottom: !0
                });
            }
        });
    }
});