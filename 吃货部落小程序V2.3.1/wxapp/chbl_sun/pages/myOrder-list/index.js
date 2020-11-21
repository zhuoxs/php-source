var app = getApp();

Page({
    data: {
        statusType: [ "全部订单", "待支付", "待确认", " 已完成" ],
        currentType: 0,
        tabClass: [ "", "", "", "" ],
        orderListStatus: [ "待支付", "进行中", "已完成", "已完成" ],
        flag: 1,
        orderList: !0,
        orderData: []
    },
    onLoad: function(e) {
        wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("fontcolor"),
            backgroundColor: wx.getStorageSync("color"),
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        });
        var a = this;
        app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "0",
            success: function(t) {
                wx.setStorageSync("url", t.data), a.setData({
                    url: t.data,
                    comein: e.type
                });
            }
        });
    },
    goBackHome: function(t) {
        wx.redirectTo({
            url: "../first/index"
        });
    },
    statusTap: function(t) {
        var a = this;
        console.log(t);
        var o = t.currentTarget.dataset.index;
        a.data.currentType = o, a.setData({
            currentType: o
        }), wx.getStorage({
            key: "openid",
            success: function(t) {
                var e = t.data;
                1 == o && (console.log("待支付"), app.util.request({
                    url: "entry/wxapp/OrderStatus",
                    cachetime: "0",
                    data: {
                        uid: e,
                        curType: o
                    },
                    success: function(t) {
                        console.log(t), a.setData({
                            orderStatuso: t.data.data
                        });
                    }
                })), 2 == o && (console.log("进行中"), app.util.request({
                    url: "entry/wxapp/OrderStatus",
                    cachetime: "0",
                    data: {
                        uid: e,
                        curType: o
                    },
                    success: function(t) {
                        console.log(t), a.setData({
                            orderStatust: t.data.data
                        });
                    }
                })), 3 == o && (console.log("已完成"), app.util.request({
                    url: "entry/wxapp/OrderStatus",
                    cachetime: "0",
                    data: {
                        uid: e,
                        curType: o
                    },
                    success: function(t) {
                        console.log(t), a.setData({
                            orderStatuss: t.data.data
                        });
                    }
                }));
            }
        });
    },
    goDetails: function(t) {
        wx.navigateTo({
            url: "../myOrder-list/details?id=" + t.currentTarget.dataset.id
        });
    },
    confirm: function(t) {
        console.log(t);
        var e = t.currentTarget.dataset.oid;
        app.util.request({
            url: "entry/wxapp/CompleteOrder",
            cachetime: "0",
            data: {
                order_id: e
            },
            success: function(t) {
                console.log(t), wx.showToast({
                    title: "确认收货成功！",
                    icon: "success",
                    duration: 2e3
                });
            }
        }), this.onShow(), wx.navigateTo({
            url: "../myOrder-list/index",
            success: function(t) {},
            fail: function(t) {},
            complete: function(t) {}
        });
    },
    cancel: function(t) {
        var e = this, a = t.currentTarget.dataset.oid;
        console.log(a), wx.showModal({
            title: "提示",
            content: "是否确认取消该订单？",
            success: function(t) {
                t.confirm ? (console.log("用户点击确定"), app.util.request({
                    url: "entry/wxapp/cancel",
                    cachetime: "0",
                    data: {
                        oid: a
                    },
                    success: function(t) {
                        e.onShow();
                    }
                })) : t.cancel && console.log("用户点击取消");
            }
        });
    },
    payNow: function(t) {
        console.log(t);
        var e = t.currentTarget.dataset.price, o = this, n = t.currentTarget.dataset.oid;
        console.log(n), app.util.request({
            url: "entry/wxapp/CheckOrderNum",
            cachetime: "30",
            data: {
                order_id: n
            },
            success: function(t) {
                console.log(t), wx.getStorage({
                    key: "openid",
                    success: function(t) {
                        var a = t.data;
                        app.util.request({
                            url: "entry/wxapp/Orderarr",
                            cachetime: "0",
                            data: {
                                openid: a,
                                price: e
                            },
                            success: function(t) {
                                console.log(t);
                                var e = t.data.package;
                                wx.requestPayment({
                                    timeStamp: t.data.timeStamp,
                                    nonceStr: t.data.nonceStr,
                                    package: t.data.package,
                                    signType: "MD5",
                                    paySign: t.data.paySign,
                                    success: function(t) {
                                        wx.showToast({
                                            title: "支付成功",
                                            icon: "success",
                                            duration: 2e3
                                        }), app.util.request({
                                            url: "entry/wxapp/PayOrder",
                                            cachetime: "0",
                                            data: {
                                                order_id: n
                                            },
                                            success: function(t) {
                                                console.log(t), app.util.request({
                                                    url: "entry/wxapp/BuyMessage",
                                                    cachetime: "0",
                                                    data: {
                                                        order_id: n,
                                                        new_package: e,
                                                        openid: a
                                                    },
                                                    success: function(t) {
                                                        console.log("-------------模板消息发送----------------"), console.log(t);
                                                    }
                                                });
                                            }
                                        }), o.onShow();
                                    },
                                    fail: function(t) {}
                                });
                            }
                        });
                    }
                });
            }
        });
    },
    onReady: function() {},
    onShow: function() {
        var a = this;
        wx.getStorage({
            key: "openid",
            success: function(t) {
                app.util.request({
                    url: "entry/wxapp/orderList",
                    cachetime: "0",
                    data: {
                        uid: t.data
                    },
                    success: function(t) {
                        console.log(5555), console.log(t);
                        var e = t.data.data;
                        a.setData({
                            orderList: e
                        }), console.log(e);
                    }
                });
            }
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {}
});