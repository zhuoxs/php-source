var a = getApp(), t = require("../common/common.js");

Page({
    data: {
        pagePath: "../active/list",
        page: 1,
        pagesize: 20,
        isbottom: !1
    },
    to_detail: function(a) {
        var t = this, e = a.currentTarget.dataset.index, i = t.data.list;
        "" != i[e].link && null != i[e].link ? wx.navigateTo({
            url: "../about/link?&url=" + escape(i[e].link)
        }) : wx.navigateTo({
            url: "active?&id=" + i[e].id
        });
    },
    onLoad: function(e) {
        var i = this;
        t.config(i), t.theme(i), a.util.request({
            url: "entry/wxapp/user",
            data: {
                op: "active",
                page: i.data.page,
                pagesize: i.data.pagesize
            },
            success: function(a) {
                var t = a.data;
                "" != t.data ? i.setData({
                    list: t.data,
                    page: i.data.page + 1
                }) : i.setData({
                    isbottom: !0
                });
            }
        });
    },
    onReady: function() {},
    onShow: function() {
        t.audio_end(this);
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {
        var t = this;
        t.setData({
            page: 1,
            isbottom: !1,
            list: []
        }), a.util.request({
            url: "entry/wxapp/user",
            data: {
                op: "active",
                page: t.data.page,
                pagesize: t.data.pagesize
            },
            success: function(a) {
                wx.stopPullDownRefresh();
                var e = a.data;
                "" != e.data ? t.setData({
                    list: e.data,
                    page: t.data.page + 1
                }) : t.setData({
                    isbottom: !0
                });
            }
        });
    },
    onReachBottom: function() {
        var t = this;
        t.data.isbottom || a.util.request({
            url: "entry/wxapp/user",
            data: {
                op: "active",
                page: t.data.page,
                pagesize: t.data.pagesize
            },
            success: function(a) {
                var e = a.data;
                "" != e.data ? t.setData({
                    list: t.datalist.concat(e.data),
                    page: t.data.page + 1
                }) : t.setData({
                    isbottom: !0
                });
            }
        });
    }
});