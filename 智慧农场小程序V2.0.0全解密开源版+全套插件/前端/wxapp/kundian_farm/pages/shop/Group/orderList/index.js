var a = new getApp(), t = a.siteInfo.uniacid;

Page({
    data: {
        currentIndex: "1",
        proJect: [],
        orderData: [],
        page: 1,
        farmSetData: []
    },
    onLoad: function(e) {
        var r = this, n = wx.getStorageSync("kundian_farm_uid");
        a.util.request({
            url: "entry/wxapp/class",
            data: {
                control: "group",
                op: "getGroupList",
                uid: n,
                uniacid: t
            },
            success: function(a) {
                r.setData({
                    orderData: a.data.orderData
                });
            }
        }), a.util.setNavColor(t), r.setData({
            farmSetData: wx.getStorageSync("kundian_farm_setData")
        });
    },
    getOrderData: function() {
        var e = this, r = wx.getStorageSync("kundian_farm_uid");
        a.util.request({
            url: "entry/wxapp/class",
            data: {
                control: "group",
                op: "getGroupList",
                uid: r,
                uniacid: t
            },
            success: function(a) {
                e.setData({
                    orderData: a.data.orderData
                });
            }
        });
    },
    changeIndex: function(e) {
        var r = e.currentTarget.dataset.index, n = this;
        this.setData({
            currentIndex: r
        });
        var n = this, o = wx.getStorageSync("kundian_farm_uid");
        a.util.request({
            url: "entry/wxapp/class",
            data: {
                control: "group",
                op: "getGroupList",
                uid: o,
                uniacid: t,
                status: r
            },
            success: function(a) {
                n.setData({
                    orderData: a.data.orderData
                });
            }
        });
    },
    payGroupOrder: function(e) {
        wx.getStorageSync("kundian_farm_uid");
        var r = e.currentTarget.dataset.orderid;
        a.util.request({
            url: "entry/wxapp/pay",
            data: {
                op: "getGroupPayOrder",
                orderid: r,
                uniacid: t,
                file: "group"
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
                                title: "玩命加载中"
                            }), a.util.request({
                                url: "entry/wxapp/class",
                                data: {
                                    control: "group",
                                    order_id: r,
                                    op: "sendMsg",
                                    uniacid: t,
                                    prepay_id: n
                                },
                                success: function() {
                                    wx.hideLoading(), wx.showModal({
                                        title: "提示",
                                        content: "支付成功",
                                        showCancel: !1,
                                        success: function() {
                                            wx.redirectTo({
                                                url: "../orderList/index"
                                            });
                                        }
                                    });
                                }
                            });
                        },
                        fail: function(a) {
                            wx.showModal({
                                title: "系统提示",
                                content: "您取消了支付!",
                                showCancel: !1,
                                success: function(a) {
                                    a.confirm && is_jump && wx.redirectTo({
                                        url: "../orderList/index"
                                    });
                                }
                            });
                        }
                    });
                } else console.log("fail1");
            },
            fail: function(a) {
                "JSAPI支付必须传openid" == a.data.message ? wx.navigateTo({
                    url: "/kundian_farm/pages/login/index"
                }) : wx.showModal({
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
    applyRefund: function(e) {
        var r = this, n = wx.getStorageSync("kundian_farm_uid"), o = e.currentTarget.dataset.orderid;
        a.util.request({
            url: "entry/wxapp/class",
            data: {
                control: "group",
                op: "applyGroupRefund",
                uid: n,
                uniacid: t,
                order_id: o
            },
            success: function(a) {
                1 == a.data.code ? (wx.showToast({
                    title: "申请已提交"
                }), r.getOrderData()) : wx.showToast({
                    title: "申请失败"
                });
            }
        });
    },
    sureGoods: function(e) {
        var r = this, n = wx.getStorageSync("kundian_farm_uid"), o = e.currentTarget.dataset.orderid;
        a.util.request({
            url: "entry/wxapp/class",
            data: {
                control: "group",
                op: "sureGoods",
                uid: n,
                uniacid: t,
                order_id: o
            },
            success: function(a) {
                1 == a.data.code ? (wx.showToast({
                    title: "收货成功"
                }), r.getOrderData()) : wx.showToast({
                    title: "收货失败"
                });
            }
        });
    },
    cancelOrder: function(e) {
        var r = this, n = wx.getStorageSync("kundian_farm_uid"), o = e.currentTarget.dataset.orderid;
        a.util.request({
            url: "entry/wxapp/class",
            data: {
                control: "group",
                op: "cancelOrder",
                uid: n,
                uniacid: t,
                order_id: o
            },
            success: function(a) {
                1 == a.data.code ? (wx.showToast({
                    title: "取消成功"
                }), r.getOrderData()) : wx.showToast({
                    title: "取消失败"
                });
            }
        });
    },
    onReachBottom: function(e) {
        var r = this, n = wx.getStorageSync("kundian_farm_uid"), o = r.data, d = o.orderData, i = o.page, s = o.currentIndex;
        a.util.request({
            url: "entry/wxapp/class",
            data: {
                control: "group",
                op: "getGroupList",
                uid: n,
                uniacid: t,
                status: s,
                page: i
            },
            success: function(a) {
                if (a.data.orderData) {
                    for (var t = a.data.orderData, e = 0; e < t.length; e++) d.push(t[e]);
                    r.setData({
                        orderData: d,
                        page: parseInt(i) + 1
                    });
                }
            }
        });
    },
    deleteOrder: function(t) {
        var e = this;
        wx.showModal({
            title: "提示",
            content: "确认删除订单吗？删除后将不可找回",
            success: function(r) {
                if (r.confirm) {
                    var n = t.currentTarget.dataset.orderid, o = wx.getStorageSync("kundian_farm_uid"), d = a.siteInfo.uniacid;
                    a.util.request({
                        url: "entry/wxapp/class",
                        data: {
                            control: "group",
                            op: "deleteOrder",
                            uniacid: d,
                            uid: o,
                            orderid: n
                        },
                        success: function(a) {
                            console.log(a), 1 == a.data.code ? (wx.showToast({
                                title: a.data.msg
                            }), e.getOrderData()) : wx.showToast({
                                title: a.data.msg
                            });
                        }
                    });
                }
            }
        });
    }
});