var app = getApp();

Page({
    data: {
        list: [],
        isManager: !1
    },
    onLoad: function(t) {
        var a = this, e = wx.getStorageSync("setting");
        e ? wx.setNavigationBarColor({
            frontColor: e.fontcolor,
            backgroundColor: e.color
        }) : app.get_setting(!0).then(function(t) {
            wx.setNavigationBarColor({
                frontColor: t.fontcolor,
                backgroundColor: t.color
            });
        }), a.setData({
            user: wx.getStorageSync("user"),
            id: t.id,
            shopname: t.shopname
        }), app.util.request({
            url: "entry/wxapp/getWithDrawSet",
            cachetime: "0",
            data: {},
            success: function(t) {
                console.log(t.data), a.setData({
                    isboss: t.data.is_open
                });
            }
        }), app.get_openid().then(function(t) {
            app.util.request({
                url: "entry/wxapp/getUseridcard",
                cachetime: "0",
                data: {
                    openid: t,
                    store_id: a.data.id
                },
                success: function(t) {
                    console.log(t), 1 == t.data && a.setData({
                        isManager: !0
                    });
                }
            });
        });
    },
    onReady: function() {},
    onShow: function() {
        var a = this;
        app.get_openid().then(function(t) {
            app.util.request({
                url: "entry/wxapp/getstoretongji",
                cachetime: "0",
                data: {
                    store_id: a.data.id,
                    openid: t
                },
                success: function(t) {
                    console.log(t.data), a.setData({
                        data: t.data.tongji
                    });
                }
            }), app.util.request({
                url: "entry/wxapp/getStoreDetail",
                cachetime: "0",
                data: {
                    id: a.data.id,
                    openid: t
                },
                success: function(t) {
                    console.log(t.data), a.setData({
                        totalamount: t.data.money
                    });
                }
            });
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    scanCode: function(t) {
        app.get_openid().then(function(e) {
            wx.scanCode({
                success: function(t) {
                    var a = t.result;
                    app.util.request({
                        url: "entry/wxapp/setCheckCoupon",
                        cachetime: "0",
                        data: {
                            openid: e,
                            result: a
                        },
                        success: function(t) {
                            if (1 == t.data.errcode) {
                                var a = "/yzcyk_sun/pages/backstage/coupon/coupon?id=" + t.data.user_coupon_id + "&uid=" + t.data.uid;
                                wx.navigateTo({
                                    url: a
                                });
                            } else if (2 == t.data.errcode) {
                                a = "/yzcyk_sun/pages/backstage/writeoff/writeoff?orderid=" + t.data.orderid + "&uid=" + t.data.uid;
                                wx.navigateTo({
                                    url: a
                                });
                            }
                        }
                    });
                }
            });
        });
    },
    orderNum: function(t) {
        this.setData({
            orderNum: t.detail.value
        });
    },
    submit: function(t) {
        null == this.data.orderNum && wx.showModal({
            content: "请输入订单号",
            showCancel: !1
        });
    },
    toCash: function(t) {
        wx.navigateTo({
            url: "../cash/cash?id=" + this.data.id
        });
    },
    toManager: function(t) {
        wx.navigateTo({
            url: "../manager/manager?id=" + this.data.id
        });
    }
});