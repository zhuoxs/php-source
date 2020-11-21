Object.defineProperty(exports, "__esModule", {
    value: !0
});

require("../../utils/util");

var e = new getApp(), t = e.siteInfo.uniacid, a = e.util.getNewUrl("entry/wxapp/pt", "kundian_farm_plugin_pt");

Page({
    data: {
        orderStatus: 0,
        orderDetail: [],
        maxLimit: 4,
        order_id: 0,
        relation: [],
        relationOrder: [],
        differ: [],
        about: [],
        farmSetData: [],
        is_update: !1
    },
    onLoad: function(e) {
        var r = this, d = e.order_id, n = wx.getStorageSync("kundian_farm_setData");
        wx.request({
            url: a,
            data: {
                op: "getPtOrderDetail",
                action: "index",
                uniacid: t,
                order_id: d
            },
            success: function(e) {
                var t = e.data, a = t.orderDetail, i = t.relation, o = t.relationOrder, s = t.differ, c = t.about;
                r.setData({
                    order_id: d,
                    orderDetail: a,
                    relation: i,
                    relationOrder: o,
                    differ: s,
                    maxLimit: parseInt(i.ptnumber),
                    about: c,
                    farmSetData: n
                });
            }
        });
    },
    onHide: function() {
        clearInterval(void 0);
    },
    preventTouchMove: function() {},
    onShareAppMessage: function(e) {
        var t = wx.getStorageSync("kundian_farm_wxInfo"), a = this.data.orderDetail;
        return "button" === e.from && console.log(e.target), {
            title: t.nickName + "邀请你拼" + a.goods_name,
            path: "/kundian_pt/pages/details/index?goodsid=" + a.goods_id + "&relation_id=" + a.relation_id,
            imageUrl: a.cover
        };
    },
    chooseAddress: function(e) {
        wx.navigateTo({
            url: "/kundian_farm/pages/user/address/index?is_select=true"
        }), this.setData({
            is_update: !0
        });
    },
    onShow: function(e) {
        var r = this, d = wx.getStorageSync("kundian_farm_uid"), n = wx.getStorageSync("selectAdd_" + d), i = r.data, o = i.order_id, s = i.orderDetail, c = i.is_update;
        if (n && c) {
            var u = n.region + " " + n.address, l = n.name, f = n.phone;
            wx.request({
                url: a,
                data: {
                    op: "ptUpdateAddress",
                    action: "index",
                    uniacid: t,
                    order_id: o,
                    address: u,
                    phone: f,
                    name: l
                },
                success: function(e) {
                    s.name = l, s.address = u, s.phone = f, r.setData({
                        orderDetail: s,
                        is_update: !1
                    });
                }
            }), wx.removeStorageSync("selectAdd_" + d);
        }
    },
    callNumber: function(e) {
        var t = this.data.about;
        wx.makePhoneCall({
            phoneNumber: t.phone
        });
    },
    cancelPtOrder: function(e) {
        var r = this, d = e.currentTarget.dataset.orderid, n = wx.getStorageSync("kundian_farm_uid"), i = r.data.orderDetail;
        wx.showModal({
            title: "提示",
            content: "确认取消该订单吗？",
            success: function(e) {
                e.confirm && wx.request({
                    url: a,
                    data: {
                        op: "cancelPtOrder",
                        action: "index",
                        order_id: d,
                        uniacid: t,
                        uid: n
                    },
                    success: function(e) {
                        wx.showToast({
                            title: e.data.msg
                        }), 0 == e.data.code && (i.status_code = 5, r.setData({
                            orderDetail: i
                        }));
                    }
                });
            }
        });
    },
    nowPay: function(r) {
        var d = this, n = r.currentTarget.dataset.orderid, i = e.util.getNewUrl("entry/wxapp/pay", "kundian_farm_plugin_pt"), o = d.data.orderDetail;
        wx.request({
            url: i,
            data: {
                orderid: n,
                uniacid: t
            },
            cachetime: "0",
            success: function(e) {
                if (e.data && e.data.data && !e.data.errno) {
                    var r = e.data.data.package;
                    wx.requestPayment({
                        timeStamp: e.data.data.timeStamp,
                        nonceStr: e.data.data.nonceStr,
                        package: e.data.data.package,
                        signType: "MD5",
                        paySign: e.data.data.paySign,
                        success: function(e) {
                            wx.showLoading({
                                title: "加载中"
                            }), wx.request({
                                url: a,
                                data: {
                                    action: "index",
                                    op: "sendMsg",
                                    order_id: n,
                                    uniacid: t,
                                    prepay_id: r
                                },
                                success: function(e) {
                                    console.log(pa), wx.showModal({
                                        title: "提示",
                                        content: "支付成功",
                                        showCancel: !1,
                                        success: function() {
                                            o.status_code = 1, d.setData({
                                                orderDetail: o
                                            });
                                        }
                                    }), wx.hideLoading();
                                }
                            });
                        },
                        fail: function(e) {
                            console.log(e), wx.showModal({
                                title: "提示",
                                content: e.data.message,
                                showCancel: !1
                            });
                        }
                    });
                } else wx.showModal({
                    title: "提示",
                    content: e.data.message,
                    showCancel: !1
                });
            },
            fail: function(e) {
                wx.showModal({
                    title: "系统提示",
                    content: e.data.message ? e.data.message : "错误",
                    showCancel: !1,
                    success: function(e) {}
                });
            }
        });
    },
    applyRefundOrder: function(e) {
        var r = this, d = e.currentTarget.dataset.orderid, n = wx.getStorageSync("kundian_farm_uid"), i = r.data.orderDetail;
        wx.showModal({
            title: "提示",
            content: "确认对该订单进行退款处理吗?",
            success: function(e) {
                e.confirm && wx.request({
                    url: a,
                    data: {
                        op: "applyRefundOrder",
                        action: "index",
                        order_id: d,
                        uniacid: t,
                        uid: n
                    },
                    success: function(e) {
                        wx.showToast({
                            title: e.data.msg
                        }), 0 == e.data.code && (i.status_code = 4, r.setData({
                            orderDetail: i
                        }));
                    }
                });
            }
        });
    },
    confirmGoods: function(e) {
        var r = this, d = wx.getStorageSync("kundian_farm_uid"), n = e.currentTarget.dataset.orderid, i = r.data.orderDetail;
        wx.showModal({
            title: "提示",
            content: "确认您已经收到货了吗？",
            success: function(e) {
                e.confirm && wx.request({
                    url: a,
                    data: {
                        op: "confirmGoods",
                        action: "index",
                        order_id: n,
                        uniacid: t,
                        uid: d
                    },
                    success: function(e) {
                        wx.showToast({
                            title: e.data.msg
                        }), 0 == e.data.code && (i.status_code = 3, r.setData({
                            orderDetail: i
                        }));
                    }
                });
            }
        });
    },
    deletePtOrder: function(e) {
        var r = e.currentTarget.dataset.orderid, d = wx.getStorageSync("kundian_farm_uid");
        wx.showModal({
            title: "提示",
            content: "确认删除该订单吗？",
            success: function(e) {
                e.confirm && wx.request({
                    url: a,
                    data: {
                        op: "deletePtOrder",
                        action: "index",
                        order_id: r,
                        uniacid: t,
                        uid: d
                    },
                    success: function(e) {
                        wx.showToast({
                            title: e.data.msg,
                            success: function() {
                                wx.redirectTo({
                                    url: "../orderLists/index"
                                });
                            }
                        });
                    }
                });
            }
        });
    },
    buyAgain: function(e) {
        var t = e.currentTarget.dataset.goodsid;
        wx.redirectTo({
            url: "../details/index?goodsid=" + t
        });
    },
    toComment: function(e) {
        var t = e.currentTarget.dataset.orderid.orderid;
        wx.navigateTo({
            url: "/kundian_farm/pages/shop/comment/index?order_id=" + t + "&module_name=kundian_farm_plugin_pt"
        });
    }
});