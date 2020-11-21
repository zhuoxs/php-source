var t = getApp();

Page({
    data: {
        isShow: !1,
        TabCur: 1,
        scrollLeft: 0,
        list: [],
        page: 1,
        status: 0,
        is_last: !1
    },
    onLoad: function(a) {
        var e = this;
        t.util.getUserInfo(function(a) {
            a.memberInfo ? (t.util.request({
                url: "entry/wxapp/Api",
                data: {
                    m: "ox_reclaim",
                    r: "shop.orderList",
                    uid: a.memberInfo.uid,
                    status: e.data.status,
                    page: e.data.page
                },
                success: function(t) {
                    e.setData({
                        list: t.data.data
                    });
                }
            }), wx.setStorageSync("uid", a.memberInfo.uid)) : e.hideDialog();
        });
    },
    hideDialog: function() {
        this.setData({
            isShow: !this.data.isShow
        });
    },
    updateUserInfo: function(a) {
        var e = this;
        e.hideDialog(), a.detail.userInfo && t.util.getUserInfo(function(a) {
            t.util.request({
                url: "entry/wxapp/Api",
                data: {
                    m: "ox_reclaim",
                    r: "shop.orderList",
                    uid: a.memberInfo.uid,
                    status: e.data.status,
                    page: e.data.page
                },
                success: function(t) {
                    e.setData({
                        list: t.data.data
                    });
                }
            }), wx.setStorageSync("uid", a.memberInfo.uid);
        }, a.detail);
    },
    tabSelect: function(a) {
        var e = this;
        this.setData({
            page: 1,
            is_last: !1,
            TabCur: a.currentTarget.dataset.id,
            scrollLeft: 60 * (a.currentTarget.dataset.id - 1)
        }), t.util.request({
            url: "entry/wxapp/Api",
            data: {
                m: "ox_reclaim",
                r: "shop.orderList",
                uid: wx.getStorageSync("uid"),
                status: a.currentTarget.dataset.id,
                page: 1
            },
            success: function(t) {
                e.setData({
                    list: t.data.data,
                    TabCur: a.currentTarget.dataset.id,
                    scrollLeft: 60 * (a.currentTarget.dataset.id - 1),
                    status: a.currentTarget.dataset.id
                });
            }
        });
    },
    onPullDownRefresh: function() {
        var a = this;
        t.util.request({
            url: "entry/wxapp/Api",
            data: {
                m: "ox_reclaim",
                r: "shop.orderList",
                uid: wx.getStorageSync("uid"),
                status: a.data.status,
                page: 1
            },
            success: function(t) {
                a.setData({
                    list: t.data.data,
                    page: 1,
                    is_last: !1
                }), wx.stopPullDownRefresh();
            }
        });
    },
    getlist: function() {
        var a = this;
        t.util.request({
            url: "entry/wxapp/Api",
            data: {
                m: "ox_reclaim",
                r: "shop.orderList",
                uid: wx.getStorageSync("uid"),
                status: a.data.status,
                page: 1
            },
            success: function(t) {
                a.setData({
                    list: t.data.data,
                    page: 1,
                    is_last: !1
                }), wx.stopPullDownRefresh();
            }
        });
    },
    onReachBottom: function() {
        var a = this;
        a.data.is_last || t.util.request({
            url: "entry/wxapp/Api",
            data: {
                m: "ox_reclaim",
                r: "shop.orderList",
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
                for (var e = a.data.list, s = 0; s < t.data.data.length; s++) e.push(t.data.data[s]);
                a.setData({
                    list: e,
                    page: a.data.page + 1
                });
            }
        });
    },
    confirm: function(a) {
        var e = this;
        t.util.request({
            url: "entry/wxapp/Api",
            data: {
                m: "ox_reclaim",
                r: "shop.cancel",
                uid: wx.getStorageSync("uid"),
                id: a.target.dataset.id
            },
            success: function(a) {
                e.getlist(), t.util.message({
                    title: "确认收货成功"
                });
            }
        });
    },
    showModal: function(t) {
        this.setData({
            modalName: t.currentTarget.dataset.target,
            orderid: t.currentTarget.dataset.orderid
        });
    },
    hideModal: function(t) {
        this.setData({
            modalName: null,
            refundval: ""
        });
    }
});