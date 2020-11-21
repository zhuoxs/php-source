var t = getApp();

Page({
    data: {
        TabCur: 1,
        scrollLeft: 0,
        list: [],
        page: 1,
        status: 1,
        is_last: !1
    },
    onLoad: function(a) {
        var s = this;
        a.status && s.setData({
            status: a.status,
            TabCur: a.status
        }), t.util.request({
            url: "entry/wxapp/Api",
            data: {
                m: "ox_master",
                r: "store.orderList2",
                uid: wx.getStorageSync("uid"),
                status: s.data.status,
                page: s.data.page
            },
            success: function(t) {
                s.setData({
                    list: t.data.data
                });
            }
        });
    },
    tabSelect: function(a) {
        var s = this;
        t.util.request({
            url: "entry/wxapp/Api",
            data: {
                m: "ox_master",
                r: "store.orderList2",
                uid: wx.getStorageSync("uid"),
                status: a.currentTarget.dataset.id,
                page: 1
            },
            success: function(t) {
                s.setData({
                    list: t.data.data,
                    TabCur: a.currentTarget.dataset.id,
                    scrollLeft: 60 * (a.currentTarget.dataset.id - 1),
                    status: a.currentTarget.dataset.id,
                    page: 1,
                    is_last: !1
                });
            }
        });
    },
    onPullDownRefresh: function() {
        var a = this;
        t.util.request({
            url: "entry/wxapp/Api",
            data: {
                m: "ox_master",
                r: "store.orderList2",
                uid: wx.getStorageSync("uid"),
                status: a.data.status,
                page: 1
            },
            success: function(t) {
                a.setData({
                    list: t.data.data,
                    page: 1,
                    is_last: !1
                });
            }
        });
    },
    onReachBottom: function() {
        var a = this;
        a.data.is_last || t.util.request({
            url: "entry/wxapp/Api",
            data: {
                m: "ox_master",
                r: "store.orderList2",
                uid: wx.getStorageSync("uid"),
                page: a.data.page + 1,
                status: a.data.status
            },
            success: function(t) {
                t.data.data.length < 1 && (a.setData({
                    is_last: !0
                }), wx.showToast({
                    title: "没有更多数据了",
                    icon: "success",
                    duration: 2e3
                }));
                for (var s = a.data.list, e = 0; e < t.data.data.length; e++) s.push(t.data.data[e]);
                a.setData({
                    list: s,
                    page: a.data.page + 1
                });
            }
        });
    }
});