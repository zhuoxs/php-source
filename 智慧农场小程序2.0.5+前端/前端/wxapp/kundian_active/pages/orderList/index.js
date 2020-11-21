var a = new getApp(), t = a.siteInfo.uniacid, e = "kundian_farm_plugin_active";

Page({
    data: {
        currentIndex: "1",
        orderList: [],
        page: 1,
        farmSetData: wx.getStorageSync("kundian_farm_setData")
    },
    onLoad: function(e) {
        this.getOrderData(1, 1, 0), a.util.setNavColor(t);
    },
    getOrderData: function(n, r, i) {
        var d = this, c = a.util.url("entry/wxapp/class") + "m=" + e, s = wx.getStorageSync("kundian_farm_uid");
        wx.request({
            url: c,
            data: {
                action: "order",
                op: "getOrderList",
                uniacid: t,
                uid: s,
                page: r,
                current: n
            },
            success: function(a) {
                if (a.data.orderList) {
                    var t = d.data.orderList, e = a.data.orderList;
                    1 == i ? e.map(function(a) {
                        t.push(a);
                    }) : (t = e, r = 1), d.setData({
                        orderList: t,
                        page: r
                    });
                }
            }
        });
    },
    changeIndex: function(a) {
        var t = a.currentTarget.dataset.index;
        this.getOrderData(t, 1, 0), this.setData({
            currentIndex: a.currentTarget.dataset.index
        });
    },
    onReachBottom: function(a) {
        var t = this.data.changeIndex, e = parseInt(this.data.page) + 1;
        this.getOrderData(t, e, 1);
    },
    onPullDownRefresh: function(a) {
        var t = this.data.changeIndex;
        this.getOrderData(t, 1, 1);
    },
    cancelOrder: function(n) {
        var r = this, i = this.data.changeIndex, d = wx.getStorageSync("kundian_farm_uid"), c = n.currentTarget.dataset.orderid, s = a.util.url("entry/wxapp/class") + "m=" + e;
        wx.showModal({
            title: "提示",
            content: "确认取消订单吗？",
            success: function(a) {
                a.confirm && wx.request({
                    url: s,
                    data: {
                        action: "order",
                        op: "cancelOrder",
                        uniacid: t,
                        order_id: c,
                        uid: d
                    },
                    success: function(a) {
                        1 == a.data.code ? wx.showModal({
                            title: "提示",
                            content: a.data.msg,
                            showCancel: !1,
                            success: function(a) {
                                r.getOrderData(i, 1, 0);
                            }
                        }) : wx.showModal({
                            title: "提示",
                            content: a.data.msg,
                            showCancel: !1
                        });
                    }
                });
            }
        });
    },
    nowPay: function(n) {
        var r = n.currentTarget.dataset.orderid;
        a.util.request({
            url: "entry/wxapp/activePay",
            data: {
                orderid: r,
                uniacid: t
            },
            cachetime: "0",
            success: function(n) {
                if (n.data && n.data.data && !n.data.errno) {
                    var i = n.data.data.package;
                    wx.requestPayment({
                        timeStamp: n.data.data.timeStamp,
                        nonceStr: n.data.data.nonceStr,
                        package: n.data.data.package,
                        signType: "MD5",
                        paySign: n.data.data.paySign,
                        success: function(n) {
                            var d = a.util.url("entry/wxapp/active") + "m=" + e;
                            wx.request({
                                url: d,
                                data: {
                                    op: "notify",
                                    uniacid: t,
                                    uid: uid,
                                    orderid: r,
                                    prepay_id: i
                                },
                                success: function(a) {
                                    wx.hideLoading(), wx.showToast({
                                        title: "支付成功",
                                        success: function(a) {
                                            wx.redirectTo({
                                                url: "../payforResult/index?status=true&order_id=" + r
                                            });
                                        }
                                    });
                                }
                            });
                        },
                        fail: function(a) {
                            wx.showModal({
                                title: "提示",
                                content: "您取消了支付",
                                showCancel: !1
                            });
                        }
                    });
                }
                "JSAPI支付必须传openid" == n.data.message && wx.navigateTo({
                    url: "../../login/index"
                });
            },
            fail: function(a) {
                wx.showModal({
                    title: "系统提示",
                    content: a.data.message ? a.data.message : "错误",
                    showCancel: !1,
                    success: function(a) {
                        a.confirm;
                    }
                });
            }
        });
    },
    seeTicket: function(a) {
        var t = a.currentTarget.dataset.orderid;
        wx.navigateTo({
            url: "../ticket/index?order_id=" + t
        });
    }
});