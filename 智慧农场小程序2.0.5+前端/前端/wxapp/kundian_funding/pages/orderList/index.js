var t = new getApp(), a = t.siteInfo.uniacid, e = t.util.url("entry/wxapp/funding") + "m=kundian_farm_plugin_funding";

Page({
    data: {
        currentIndex: 1,
        confirm: !1,
        orderData: [],
        farmSetData: wx.getStorageSync("kundian_farm_setData"),
        current_cover: "",
        current_orderid: ""
    },
    onLoad: function(a) {
        this.getOrderData(1, 1, 0), t.util.setNavColor();
    },
    getOrderData: function(t, a, r) {
        var n = this, d = wx.getStorageSync("kundian_farm_uid");
        wx.request({
            url: e,
            data: {
                op: "getOrderData",
                control: "order",
                uid: d,
                currentIndex: t,
                page: a
            },
            success: function(t) {
                if (t.data.orderData) {
                    var e = [];
                    1 == r ? (e = n.data.orderData, t.data.orderData.map(function(t) {
                        e.push(t);
                    })) : (e = t.data.orderData, a = 1), n.setData({
                        orderData: e,
                        page: a
                    });
                }
            }
        });
    },
    onReachBottom: function(t) {
        var a = parseInt(this.data.page) + 1;
        this.getOrderData(this.data.currentIndex, a, 1);
    },
    changeIndex: function(t) {
        var a = t.currentTarget.dataset.index;
        this.getOrderData(a, 1, 0), this.setData({
            currentIndex: a
        });
    },
    payOrder: function(r) {
        var n = r.currentTarget.dataset.orderid, d = wx.getStorageSync("kundian_farm_uid");
        t.util.request({
            url: "entry/wxapp/fundingPay",
            data: {
                orderid: n,
                uniacid: a
            },
            cachetime: "0",
            success: function(t) {
                if (t.data && t.data.data && !t.data.errno) {
                    var a = t.data.data.package;
                    wx.requestPayment({
                        timeStamp: t.data.data.timeStamp,
                        nonceStr: t.data.data.nonceStr,
                        package: t.data.data.package,
                        signType: "MD5",
                        paySign: t.data.data.paySign,
                        success: function(t) {
                            wx.request({
                                url: e,
                                data: {
                                    op: "notify",
                                    control: "project",
                                    uid: d,
                                    orderid: n,
                                    prepay_id: a
                                },
                                success: function(t) {
                                    wx.showToast({
                                        title: "支付成功",
                                        success: function(t) {
                                            wx.redirectTo({
                                                url: "../orderList/index"
                                            });
                                        }
                                    });
                                }
                            });
                        },
                        fail: function(t) {
                            backApp();
                        }
                    });
                }
                "JSAPI支付必须传openid" == t.data.message && wx.navigateTo({
                    url: "../../login/index"
                });
            },
            fail: function(t) {
                wx.showModal({
                    title: "系统提示",
                    content: t.data.message ? t.data.message : "错误",
                    showCancel: !1,
                    success: function(t) {
                        t.confirm && backApp();
                    }
                });
            }
        });
    },
    cancelOrder: function(t) {
        var a = this, r = a.data.currentIndex, n = t.currentTarget.dataset.orderid;
        wx.showModal({
            title: "提示",
            content: "是否确认取消该订单？",
            success: function(t) {
                t.confirm && wx.request({
                    url: e,
                    data: {
                        op: "cancelOrder",
                        orderid: n,
                        control: "order"
                    },
                    success: function(t) {
                        wx.showModal({
                            title: "提示",
                            content: t.data.msg,
                            showCancel: !1,
                            success: function() {
                                a.getOrderData(r, 1, 0);
                            }
                        });
                    }
                });
            }
        });
    },
    preventTouchMove: function() {},
    comfirmOrder: function(t) {
        var a = this, e = t.currentTarget.dataset.orderid, r = "";
        a.data.orderData.map(function(t) {
            t.id == e && (r = t.project.cover);
        }), this.setData({
            confirm: !0,
            current_cover: r,
            current_orderid: e
        });
    },
    cancel: function() {
        this.setData({
            confirm: !1
        });
    },
    confirmGoods: function(t) {
        var a = this, r = t.currentTarget.dataset.orderid, n = a.data.currentIndex;
        wx.request({
            url: e,
            data: {
                op: "confirmOrder",
                control: "order",
                orderid: r
            },
            success: function(t) {
                wx.showModal({
                    title: "提示",
                    content: t.data.msg,
                    showCancel: !1,
                    success: function(t) {
                        a.setData({
                            confirm: !1
                        }), a.getOrderData(n, 1, 0);
                    }
                });
            }
        });
    },
    orderDetail: function(t) {
        var a = t.currentTarget.dataset.orderid;
        wx.navigateTo({
            url: "../orderdetail/index?orderid=" + a
        });
    }
});