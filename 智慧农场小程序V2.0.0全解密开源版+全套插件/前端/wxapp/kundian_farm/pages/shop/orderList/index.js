var t = new getApp(), a = t.siteInfo.uniacid;

Page({
    data: {
        currentIndex: "4",
        orderData: [],
        status: "",
        page: 1,
        farmSetData: [],
        isContent: !0,
        show_verify: !0,
        verify_qrcode: ""
    },
    onLoad: function(e) {
        var r = this;
        if (e.status) n = e.status; else var n = 4;
        wx.getStorageSync("kundian_farm_uid");
        r.setData({
            farmSetData: wx.getStorageSync("kundian_farm_setData"),
            currentIndex: n
        }), this.getOrderData(), t.util.setNavColor(a);
    },
    onShow: function(t) {
        this.getOrderData();
    },
    getOrderData: function() {
        var e = this, r = e.data.currentIndex, n = wx.getStorageSync("kundian_farm_uid");
        wx.showLoading({
            title: "玩命加载中..."
        }), t.util.request({
            url: "entry/wxapp/class",
            data: {
                control: "order",
                op: "orderList",
                uniacid: a,
                uid: n,
                status: r
            },
            success: function(t) {
                var a = t.data.orderData;
                a.length > 0 ? e.setData({
                    orderData: a,
                    page: 1,
                    isContent: !0
                }) : e.setData({
                    isContent: !1
                }), wx.hideLoading();
            }
        });
    },
    changeIndex: function(t) {
        this.setData({
            currentIndex: t.currentTarget.dataset.index
        }), this.getOrderData();
    },
    sendRequest: function(a, e, r) {
        var n = this;
        wx.showModal({
            title: "提示",
            content: a,
            success: function(a) {
                a.confirm && t.util.request({
                    url: "entry/wxapp/class",
                    data: e,
                    success: function(t) {
                        1 == t.data.code ? wx.showModal({
                            title: "提示",
                            content: t.data.msg,
                            showCancel: !1,
                            success: function() {
                                n.getOrderData();
                            }
                        }) : wx.showToast({
                            title: "取消失败"
                        });
                    }
                });
            }
        });
    },
    cancelOrder: function(t) {
        var e = wx.getStorageSync("kundian_farm_uid"), r = t.currentTarget.dataset.orderid, n = {
            control: "order",
            op: "cancelOrder",
            uid: e,
            uniacid: a,
            order_id: r
        };
        this.sendRequest("确认取消订单吗？", n, 1);
    },
    payOrder: function(e) {
        wx.getStorageSync("kundian_farm_uid");
        var r = e.currentTarget.dataset.orderid;
        t.util.request({
            url: "entry/wxapp/pay",
            data: {
                op: "getShopPayOrder",
                orderid: r,
                uniacid: a,
                file: "shop"
            },
            cachetime: "0",
            success: function(e) {
                if (e.data && e.data.data && !e.data.errno) {
                    var n = e.data.data.package;
                    wx.requestPayment({
                        timeStamp: e.data.data.timeStamp,
                        nonceStr: e.data.data.nonceStr,
                        package: e.data.data.package,
                        signType: "MD5",
                        paySign: e.data.data.paySign,
                        success: function(e) {
                            wx.showLoading({
                                title: "加载中"
                            }), t.util.request({
                                url: "entry/wxapp/class",
                                data: {
                                    control: "shop",
                                    order_id: r,
                                    op: "sendMsg",
                                    uniacid: a,
                                    prepay_id: n
                                },
                                success: function() {
                                    wx.showModal({
                                        title: "提示",
                                        content: "支付成功",
                                        showCancel: !1,
                                        success: function() {
                                            wx.redirectTo({
                                                url: "../orderList/index"
                                            });
                                        }
                                    }), wx.hideLoading();
                                }
                            });
                        },
                        fail: function(t) {
                            wx.showModal({
                                title: "系统提示",
                                content: "您取消了支付!",
                                showCancel: !1,
                                success: function(t) {}
                            }), wx.hideLoading();
                        }
                    });
                } else console.log("fail1");
            },
            fail: function(t) {
                "JSAPI支付必须传openid" == t.data.message ? wx.navigateTo({
                    url: "/kundian_farm/pages/login/index"
                }) : wx.showModal({
                    title: "系统提示",
                    content: t.data.message ? t.data.message : "错误",
                    showCancel: !1,
                    success: function(t) {
                        t.confirm;
                    }
                });
            }
        });
    },
    applyRefund: function(t) {
        var e = wx.getStorageSync("kundian_farm_uid"), r = t.currentTarget.dataset.orderid, n = {
            control: "order",
            op: "applyRefund",
            uid: e,
            uniacid: a,
            order_id: r
        };
        this.sendRequest("确认申请退款吗？", n, 2);
    },
    sureGoods: function(t) {
        var e = wx.getStorageSync("kundian_farm_uid"), r = t.currentTarget.dataset.orderid, n = {
            control: "order",
            op: "sureGoods",
            uid: e,
            uniacid: a,
            order_id: r
        };
        this.sendRequest("确认已经收到货了吗?", n, 3);
    },
    intoOrderDetail: function(t) {
        var a = t.currentTarget.dataset.orderid;
        wx.navigateTo({
            url: "../Group/orderDetails/index?order_id=" + a
        });
    },
    onReachBottom: function(a) {
        var e = this, r = t.siteInfo.uniacid, n = wx.getStorageSync("kundian_farm_uid"), d = e.data, i = d.currentIndex, o = d.page, s = d.orderData;
        t.util.request({
            url: "entry/wxapp/class",
            data: {
                control: "order",
                op: "orderList",
                uniacid: r,
                uid: n,
                status: i,
                page: o
            },
            success: function(t) {
                if (t.data.orderData) {
                    for (var a = t.data.orderData, r = 0; r < a.length; r++) s.push(a[r]);
                    e.setData({
                        orderData: s,
                        page: parseInt(o) + 1
                    });
                }
            }
        });
    },
    deleteOrder: function(t) {
        var e = wx.getStorageSync("kundian_farm_uid"), r = t.currentTarget.dataset.orderid, n = {
            control: "order",
            op: "deleteOrder",
            uniacid: a,
            orderid: r,
            uid: e
        };
        this.sendRequest("确认删除订单吗?", n, 4);
    },
    commentOrder: function(t) {
        wx.navigateTo({
            url: "/kundian_farm/pages/shop/comment/index?order_id=" + t.currentTarget.dataset.orderid
        });
    },
    showVerifyQrocde: function(t) {
        var a = t.currentTarget.dataset.orderid, e = "";
        this.data.orderData.map(function(t) {
            t.id == a && (e = t.offline_qrocde);
        }), this.setData({
            verify_qrcode: e,
            show_verify: !1
        });
    },
    hideVerify: function(t) {
        this.setData({
            show_verify: !0
        });
    }
});