var a = getApp();

Page({
    data: {
        list: [],
        page: 1,
        is_last: !1,
        user: [],
        shop: [],
        jifendesc: !1
    },
    onLoad: function(t) {
        var e = this;
        a.util.request({
            url: "entry/wxapp/Api",
            data: {
                m: "ox_reclaim",
                r: "shop.index",
                uid: wx.getStorageSync("uid"),
                page: e.data.page
            },
            success: function(t) {
                e.setData({
                    list: t.data.data.list,
                    shop: t.data.data.shop,
                    user: t.data.data.user
                }), 0 == e.data.shop.open && (a.util.message({
                    title: "积分商城已关闭",
                    type: "error"
                }), setTimeout(function() {
                    wx.switchTab({
                        url: "/pages/me/index"
                    });
                }, 2e3));
            }
        });
    },
    onPullDownRefresh: function() {
        var t = this;
        a.util.request({
            url: "entry/wxapp/Api",
            data: {
                m: "ox_reclaim",
                r: "shop.index",
                uid: wx.getStorageSync("uid"),
                page: 1
            },
            success: function(a) {
                t.setData({
                    list: a.data.data.list,
                    shop: a.data.data.shop,
                    user: a.data.data.user,
                    page: 1,
                    is_last: !1
                }), wx.stopPullDownRefresh();
            }
        });
    },
    onReachBottom: function() {
        var t = this;
        t.data.is_last || a.util.request({
            url: "entry/wxapp/Api",
            data: {
                m: "ox_reclaim",
                r: "shop.index",
                uid: wx.getStorageSync("uid"),
                page: t.data.page + 1
            },
            success: function(a) {
                a.data.data.list.length < 1 && (t.setData({
                    is_last: !0
                }), wx.showToast({
                    title: "没有更多数据了",
                    icon: "success",
                    duration: 2e3
                }));
                for (var e = t.data.list, s = 0; s < a.data.data.list.length; s++) e.push(a.data.data.list[s]);
                t.setData({
                    list: e,
                    page: t.data.page + 1
                });
            }
        });
    },
    godetails: function(a) {
        console.log(a), wx.navigateTo({
            url: "/pages/shop/pages/details/index?id=" + a.currentTarget.dataset.id
        });
    },
    jifendesc: function() {
        this.setData({
            jifendesc: !this.data.jifendesc
        });
    },
    gohome: function() {
        wx.navigateTo({
            url: "/pages/need/pages/home/index"
        });
    },
    goorder: function() {
        wx.navigateTo({
            url: "/pages/shop/pages/order/index"
        });
    }
});