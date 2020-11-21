var a = getApp();

Page({
    data: {
        TabCur: 0,
        scrollLeft: 0,
        list: [],
        page: 1,
        is_last: !1
    },
    onLoad: function(t) {
        var e = this;
        e.setData({
            TabCur: t.id
        }), a.util.request({
            url: "entry/wxapp/Api",
            data: {
                m: "ox_master",
                r: "me.refund",
                uid: wx.getStorageSync("uid"),
                page: e.data.page
            },
            success: function(a) {
                e.setData({
                    list: a.data.data
                });
            }
        });
    },
    tabSelect: function(t) {
        var e = this;
        a.util.request({
            url: "entry/wxapp/Api",
            data: {
                m: "ox_master",
                r: "me.refund",
                uid: wx.getStorageSync("uid"),
                page: 1
            },
            success: function(a) {
                e.setData({
                    list: a.data.data,
                    TabCur: t.currentTarget.dataset.id,
                    scrollLeft: 60 * (t.currentTarget.dataset.id - 1),
                    page: 1,
                    is_last: !1
                });
            }
        });
    },
    onPullDownRefresh: function() {
        var t = this;
        a.util.request({
            url: "entry/wxapp/Api",
            data: {
                m: "ox_master",
                r: "me.refund",
                uid: wx.getStorageSync("uid"),
                page: 1
            },
            success: function(a) {
                t.setData({
                    list: a.data.data,
                    page: 1,
                    is_last: !1
                });
            }
        });
    },
    onReachBottom: function() {
        var t = this;
        t.data.is_last || a.util.request({
            url: "entry/wxapp/Api",
            data: {
                m: "ox_master",
                r: "me.refund",
                uid: wx.getStorageSync("uid"),
                page: t.data.page + 1
            },
            success: function(a) {
                a.data.data.length < 1 && (t.setData({
                    is_last: !0
                }), wx.showToast({
                    title: "没有更多数据了",
                    icon: "success",
                    duration: 2e3
                }));
                for (var e = t.data.list, s = 0; s < a.data.data.length; s++) e.push(a.data.data[s]);
                t.setData({
                    list: e,
                    page: t.data.page + 1
                });
            }
        });
    },
    gome: function(t) {
        a.util.request({
            url: "entry/wxapp/Api",
            data: {
                m: "ox_master",
                r: "me.add_formid",
                uid: wx.getStorageSync("uid"),
                formid: t.detail.formId
            }
        }), wx.switchTab({
            url: "/pages/me/index"
        });
    }
});