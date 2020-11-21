function t(t, a, e) {
    return a in t ? Object.defineProperty(t, a, {
        value: e,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : t[a] = e, t;
}

var a, e = getApp();

Page((a = {
    data: {
        list: [],
        page: 1,
        is_last: !1,
        price: "",
        orderid: "",
        error: !0
    },
    onLoad: function(t) {
        var a = this;
        e.util.request({
            url: "entry/wxapp/Api",
            data: {
                m: "ox_master",
                r: "store.orderList",
                uid: wx.getStorageSync("uid"),
                page: a.data.page
            },
            success: function(t) {
                a.setData({
                    list: t.data.data.list,
                    auto: t.data.data.auto,
                    detail: t.data.data.detail
                });
            }
        });
    },
    showModal1: function(t) {
        this.setData({
            modalName: t.currentTarget.dataset.target
        });
    },
    goStoreDetail: function() {
        wx.navigateTo({
            url: "/pages/store/pages/masterDetail/index?uid=" + wx.getStorageSync("uid")
        });
    },
    showModal: function(t) {
        this.setData({
            modalName: t.currentTarget.dataset.target
        });
    },
    hideModal: function(t) {
        this.setData({
            modalName: null
        });
    },
    isoff: function(t) {
        e.util.request({
            url: "entry/wxapp/Api",
            data: {
                m: "ox_master",
                r: "store.isoff",
                uid: wx.getStorageSync("uid"),
                isoff: t.detail.value
            },
            success: function(t) {
                e.util.message({
                    title: "设置成功"
                });
            }
        });
    },
    orderTakers: function(t) {
        e.util.request({
            url: "entry/wxapp/Api",
            data: {
                m: "ox_master",
                r: "store.orderTakers",
                repair_uid: wx.getStorageSync("uid"),
                order_id: t.target.dataset.orderid
            },
            success: function(t) {
                e.util.message({
                    title: "抢单成功",
                    redirect: "navigate:/pages/store/pages/order/index"
                });
            }
        });
    },
    onPullDownRefresh: function() {
        var t = this;
        e.util.request({
            url: "entry/wxapp/Api",
            data: {
                m: "ox_master",
                r: "store.orderList",
                uid: wx.getStorageSync("uid"),
                page: 1
            },
            success: function(a) {
                t.setData({
                    list: a.data.data.list,
                    page: 1,
                    is_last: !1
                }), wx.stopPullDownRefresh();
            }
        });
    },
    onReachBottom: function() {
        var t = this;
        t.data.is_last || e.util.request({
            url: "entry/wxapp/Api",
            data: {
                m: "ox_master",
                r: "store.orderList",
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
                for (var e = t.data.list, i = 0; i < a.data.data.list.length; i++) e.push(a.data.data.list[i]);
                t.setData({
                    list: e,
                    page: t.data.page + 1
                });
            }
        });
    },
    upPrice: function(t) {
        this.setData({
            price: t.detail.value
        });
    },
    bidding: function() {
        var t = this, a = this.data.price;
        console.log(a), this.checkRate(a), e.util.request({
            url: "entry/wxapp/Api",
            data: {
                m: "ox_master",
                r: "bidding.index",
                uid: wx.getStorageSync("uid"),
                price: a,
                order_id: this.data.orderid
            },
            success: function(a) {
                wx.showModal({
                    title: "系统消息",
                    content: a.data.message,
                    success: function(a) {
                        a.confirm ? t.hideModal() : a.cancel && t.hideModal();
                    }
                });
            },
            fail: function(a) {
                wx.showModal({
                    title: "系统消息",
                    content: a.data.message,
                    success: function(a) {
                        a.confirm ? t.hideModal() : a.cancel && t.hideModal();
                    }
                });
            }
        });
    },
    checkRate: function(t) {
        if (!isNaN(t)) return this.setData({
            error: !0
        }), !1;
        this.setData({
            error: !1
        });
    }
}, t(a, "showModal", function(t) {
    this.setData({
        modalName: t.currentTarget.dataset.target,
        orderid: t.currentTarget.dataset.orderid
    });
}), t(a, "hideModal", function(t) {
    this.setData({
        modalName: null
    });
}), t(a, "jumpBase", function() {
    wx.navigateTo({
        url: "/pages/store/pages/home/index"
    });
}), t(a, "jumpMoney", function() {
    wx.navigateTo({
        url: "/pages/me/money/index?id=0"
    });
}), t(a, "jumptake", function() {
    wx.navigateTo({
        url: "/pages/me/take/index"
    });
}), a));