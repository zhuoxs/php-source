var t = new getApp(), e = t.siteInfo.uniacid, a = t.util.getNewUrl("entry/wxapp/pt", "kundian_farm_plugin_pt");

Page({
    data: {
        types: [ {
            id: 1,
            title: "全部",
            read: 0,
            clicked: !1
        }, {
            id: 2,
            title: "待付款",
            read: 0,
            clicked: !1
        }, {
            id: 3,
            title: "待收货",
            read: 0,
            clicked: !1
        }, {
            id: 4,
            title: "已收货",
            read: 0,
            clicked: !1
        } ],
        currentId: 1,
        orderList: [],
        page: 1,
        isContent: !0,
        farmSetData: []
    },
    onLoad: function() {
        this.getOrderList(1, 1);
        var t = wx.getStorageSync("kundian_farm_setData");
        this.setData({
            farmSetData: t
        });
    },
    getOrderList: function(t, n) {
        wx.showLoading({
            title: "玩命加载中..."
        });
        var i = this, d = wx.getStorageSync("kundian_farm_uid"), r = i.data.orderList;
        wx.request({
            url: a,
            data: {
                action: "index",
                op: "getOrderList",
                uniacid: e,
                uid: d,
                page: t,
                currentId: n
            },
            success: function(e) {
                if (t > 1) {
                    var a = e.data.list;
                    void 0 != a && a.map(function(t) {
                        r.push(t);
                    }), i.setData({
                        orderList: r,
                        page: t
                    });
                } else {
                    var n = !0, d = e.data.orderList;
                    void 0 != d && 0 != d.length || (n = !1), i.setData({
                        orderList: d,
                        isContent: n
                    });
                }
                wx.hideLoading();
            }
        });
    },
    selected: function(t) {
        var e = t.currentTarget.dataset.id, a = this.data, n = a.types;
        a.currentId != e && (n.find(function(t) {
            return t.id == e;
        }).clicked = !0, this.setData({
            currentId: e,
            types: n
        }), this.getOrderList(1, a.currentId));
    },
    onReachBottom: function() {
        this.getOrderList(parseInt(this.data.page) + 1, this.data.currentId);
    },
    deleteItem: function(t) {
        var n = this, i = t.currentTarget.dataset.orderid, d = this.data.orderList, r = wx.getStorageSync("kundian_farm_uid");
        wx.showModal({
            title: "提示",
            content: "确认删除该订单吗？",
            success: function(t) {
                t.confirm && wx.request({
                    url: a,
                    data: {
                        op: "deletePtOrder",
                        action: "index",
                        order_id: i,
                        uniacid: e,
                        uid: r
                    },
                    success: function(t) {
                        wx.showToast({
                            title: t.data.msg,
                            icon: "none"
                        }), d.map(function(t, e) {
                            t.id == i && d.splice(e, 1);
                        }), n.setData({
                            orderList: d
                        });
                    }
                });
            }
        });
    },
    cancelOrder: function(t) {
        var n = this, i = t.currentTarget.dataset.orderid, d = wx.getStorageSync("kundian_farm_uid");
        wx.showModal({
            title: "提示",
            content: "确认取消该订单吗？",
            success: function(t) {
                t.confirm && wx.request({
                    url: a,
                    data: {
                        op: "cancelPtOrder",
                        action: "index",
                        order_id: i,
                        uniacid: e,
                        uid: d
                    },
                    success: function(t) {
                        wx.showToast({
                            title: t.data.msg,
                            icon: "none"
                        }), 0 == t.data.code && n.getOrderList(1, n.data.currentId);
                    }
                });
            }
        });
    },
    nowPay: function(n) {
        var i = n.currentTarget.dataset.orderid, d = t.util.getNewUrl("entry/wxapp/pay", "kundian_farm_plugin_pt");
        wx.request({
            url: d,
            data: {
                orderid: i,
                uniacid: e
            },
            cachetime: "0",
            success: function(t) {
                if (t.data && t.data.data && !t.data.errno) {
                    var n = t.data.data.package;
                    wx.requestPayment({
                        timeStamp: t.data.data.timeStamp,
                        nonceStr: t.data.data.nonceStr,
                        package: t.data.data.package,
                        signType: "MD5",
                        paySign: t.data.data.paySign,
                        success: function(t) {
                            wx.showLoading({
                                title: "加载中"
                            }), wx.request({
                                url: a,
                                data: {
                                    action: "index",
                                    op: "sendMsg",
                                    order_id: i,
                                    uniacid: e,
                                    prepay_id: n
                                },
                                success: function() {
                                    wx.showModal({
                                        title: "提示",
                                        content: "支付成功",
                                        showCancel: !1,
                                        success: function() {
                                            wx.redirectTo({
                                                url: "../orderLists/index"
                                            });
                                        }
                                    }), wx.hideLoading();
                                }
                            });
                        },
                        fail: function(t) {
                            wx.showModal({
                                title: "提示",
                                content: t.data.message,
                                showCancel: !1
                            });
                        }
                    });
                } else wx.showModal({
                    title: "提示",
                    content: t.data.message,
                    showCancel: !1
                });
            },
            fail: function(t) {
                wx.showModal({
                    title: "系统提示",
                    content: t.data.message ? t.data.message : "错误",
                    showCancel: !1,
                    success: function(t) {}
                });
            }
        });
    },
    applyRefund: function(t) {
        var n = this, i = t.currentTarget.dataset.orderid, d = wx.getStorageSync("kundian_farm_uid");
        wx.showModal({
            title: "提示",
            content: "确认对该订单进行退款处理吗?",
            success: function(t) {
                t.confirm && wx.request({
                    url: a,
                    data: {
                        op: "applyRefundOrder",
                        action: "index",
                        order_id: i,
                        uniacid: e,
                        uid: d
                    },
                    success: function(t) {
                        wx.showToast({
                            title: t.data.msg,
                            icon: "none"
                        }), 0 == t.data.code && n.getOrderList(1, n.data.currentId);
                    }
                });
            }
        });
    },
    confirmGoods: function(t) {
        var n = this, i = wx.getStorageSync("kundian_farm_uid"), d = t.currentTarget.dataset.orderid;
        wx.showModal({
            title: "提示",
            content: "确认您已经收到货了吗？",
            success: function(t) {
                t.confirm && wx.request({
                    url: a,
                    data: {
                        op: "confirmGoods",
                        action: "index",
                        order_id: d,
                        uniacid: e,
                        uid: i
                    },
                    success: function(t) {
                        wx.showToast({
                            title: t.data.msg
                        }), 0 == t.data.code && n.getOrderList(1, n.data.currentId);
                    }
                });
            }
        });
    },
    orderDetail: function(t) {
        var e = t.currentTarget.dataset.orderid;
        wx.navigateTo({
            url: "../orderDetail/index?order_id=" + e
        });
    },
    toComment: function(t) {
        var e = t.currentTarget.dataset.orderid;
        wx.navigateTo({
            url: "/kundian_farm/pages/shop/comment/index?order_id=" + e + "&module_name=kundian_farm_plugin_pt"
        });
    }
});