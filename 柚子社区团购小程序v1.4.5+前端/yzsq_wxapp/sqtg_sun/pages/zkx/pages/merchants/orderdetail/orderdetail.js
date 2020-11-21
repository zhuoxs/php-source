var app = getApp();

Page({
    data: {
        show: !1,
        payType: [ {
            name: "微信支付",
            pic: "../../../../../zhy/resource/images/wx.png"
        }, {
            name: "余额支付",
            pic: "../../../../../zhy/resource/images/local.png"
        } ],
        curPay: 1,
        showModalStatus: !1,
        isRequest: 0
    },
    onLoad: function(a) {
        this.setData({
            id: a.id
        });
        var t = wx.getStorageSync("userInfo");
        t ? this.setData({
            uInfo: t
        }) : wx.showModal({
            title: "提示",
            content: "您未登陆，请先登陆！",
            success: function(a) {
                if (a.confirm) {
                    var t = encodeURIComponent("/sqtg_sun/pages/public/pages/myorder/myorder?id=0");
                    app.reTo("/sqtg_sun/pages/home/login/login?id=" + t);
                } else a.cancel && app.lunchTo("/sqtg_sun/pages/home/index/index");
            }
        }), this.loadData();
    },
    loadData: function() {
        var t = this;
        app.ajax({
            url: "Corder|getOrderDetail",
            data: {
                order_id: t.data.id
            },
            success: function(a) {
                console.log(a), t.setData({
                    shop: a.data.shop,
                    goods: a.data,
                    imgroot: a.other.img_root,
                    show: !0
                });
            }
        });
    },
    cancelOrder: function(a) {
        var t = this, e = t.data.id, o = t.data.goods;
        wx.showModal({
            title: "提示",
            content: "确定取消该订单吗",
            success: function(a) {
                a.confirm && app.ajax({
                    url: "Corder|cancelOrder",
                    data: {
                        user_id: t.data.uInfo.id,
                        order_id: e
                    },
                    success: function(a) {
                        wx.showToast({
                            title: "取消成功"
                        }), o.order_status = 4, t.setData({
                            goods: o
                        });
                    }
                });
            }
        });
    },
    subOrder: function(a) {
        var t = this, e = t.data.curPay, o = (t.data.id, t.data.goods);
        console.log(e), 1 == e ? app.ajax({
            url: "Corder|getPayParam",
            data: {
                order_id: o.pay_order_id
            },
            success: function(a) {
                wx.requestPayment({
                    timeStamp: a.data.timeStamp,
                    nonceStr: a.data.nonceStr,
                    package: a.data.package,
                    signType: "MD5",
                    paySign: a.data.paySign,
                    success: function(a) {
                        console.log(a), wx.showModal({
                            title: "恭喜你",
                            content: "支付成功",
                            showCancel: !1,
                            success: function(a) {
                                o.pay_type = 1, o.order_status = 1, t.setData({
                                    goods: o
                                }), t.toSgjoin();
                            }
                        });
                    },
                    fail: function(a) {
                        wx.showModal({
                            title: "提示",
                            content: "支付失败",
                            confirmText: "回订单页",
                            confirmColor: "#f87d6d",
                            success: function(a) {
                                a.confirm && app.reTo("/sqtg_sun/pages/public/pages/myorder/myorder?id=1");
                            }
                        });
                    }
                });
            }
        }) : app.ajax({
            url: "Corder|setBalancePay",
            data: {
                user_id: t.data.uInfo.id,
                pay_order_id: o.pay_order_id,
                formId: a.detail.formId
            },
            success: function(a) {
                0 == a.code && (wx.showToast({
                    title: a.data.msg
                }), o.pay_type = 2, o.order_status = 1, t.setData({
                    goods: o
                }), t.toSgjoin());
            }
        });
    },
    confirmOrder: function(a) {
        var t = this, e = (a.currentTarget.dataset.id, t.data.goods);
        app.ajax({
            url: "Corder|confirmOrder",
            data: {
                order_id: t.data.id
            },
            success: function(a) {
                e.order_status = 3, wx.showToast({
                    title: "收货成功"
                }), t.setData({
                    goods: e
                });
            }
        });
    },
    deleteOrder: function(a) {
        var t = this;
        t.data.goods;
        wx.showModal({
            title: "提示",
            content: "订单删除后不再显示",
            success: function(a) {
                a.confirm && app.ajax({
                    url: "Corder|delOrder",
                    data: {
                        user_id: t.data.uInfo.id,
                        order_id: t.data.id
                    },
                    success: function(a) {
                        0 == a.code && wx.showModal({
                            content: "删除成功",
                            showCancel: !1,
                            success: function(a) {
                                app.reTo("/sqtg_sun/pages/public/pages/myorder/myorder?id=6");
                            }
                        });
                    }
                });
            }
        });
    },
    refundOrder: function(a) {
        var t = this, e = t.data.goods;
        wx.showModal({
            title: "提示",
            content: "确定退款吗",
            success: function(a) {
                a.confirm && app.ajax({
                    url: "Corder|setOrderRefund",
                    data: {
                        user_id: t.data.uInfo.id,
                        order_id: t.data.id
                    },
                    success: function(a) {
                        e.order_status = 5, e.refund = {}, e.refund.review_status = 0, e.refund.refund_status = 0, 
                        wx.showToast({
                            title: "申请退款成功"
                        }), t.setData({
                            goods: e
                        });
                    }
                });
            }
        });
    },
    toSgjoin: function(a) {
        this.setData({
            showModalStatus: !this.data.showModalStatus
        });
    },
    changePayType: function(a) {
        this.setData({
            curPay: a.currentTarget.dataset.index
        });
    },
    toClassifyDetail: function(a) {
        var t = a.currentTarget.dataset.id;
        app.navTo("/sqtg_sun/pages/hqs/pages/classifydetail/classifydetail?id=" + t);
    },
    callme: function() {
        wx.makePhoneCall({
            phoneNumber: this.data.goods.phone
        });
    }
});