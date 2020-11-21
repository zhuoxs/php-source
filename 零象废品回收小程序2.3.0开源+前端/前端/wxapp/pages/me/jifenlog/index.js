var a = getApp();

Page({
    data: {
        list: [],
        page: 1,
        is_last: !1,
        timoney: ""
    },
    onLoad: function(t) {
        var e = this;
        a.util.request({
            url: "entry/wxapp/Api",
            data: {
                m: "ox_reclaim",
                r: "me.jifenlog",
                uid: wx.getStorageSync("uid"),
                page: e.data.page
            },
            success: function(a) {
                e.setData({
                    list: a.data.data.list
                });
            }
        });
    },
    onPullDownRefresh: function() {
        this.jiazai2();
    },
    onReachBottom: function() {
        var t = this;
        t.data.is_last || a.util.request({
            url: "entry/wxapp/Api",
            data: {
                m: "ox_reclaim",
                r: "me.jifenlog",
                uid: wx.getStorageSync("uid"),
                page: t.data.page + 1
            },
            success: function(a) {
                a.data.data.list.length < 1 && t.setData({
                    is_last: !0
                });
                for (var e = t.data.list, i = 0; i < a.data.data.list.length; i++) e.push(a.data.data.list[i]);
                t.setData({
                    list: e,
                    page: t.data.page + 1
                });
            }
        });
    },
    jiazai2: function() {
        var t = this;
        a.util.request({
            url: "entry/wxapp/Api",
            data: {
                m: "ox_reclaim",
                r: "me.jifenlog",
                uid: wx.getStorageSync("uid"),
                page: 1
            },
            success: function(a) {
                t.setData({
                    list: a.data.data.list,
                    page: 1,
                    is_last: !1
                });
            }
        });
    }
});