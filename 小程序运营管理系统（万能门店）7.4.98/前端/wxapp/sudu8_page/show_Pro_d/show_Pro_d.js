var app = getApp();

Page({
    data: {
        order: "",
        comment: "",
        true_price: "",
        my_money: "",
        true_money: 0,
        dikou_jf: 0,
        dikou_jf_val: 0
    },
    onPullDownRefresh: function() {
        this.getinfos(), wx.stopPullDownRefresh();
    },
    onLoad: function(a) {
        var t = this;
        t.setData({
            isIphoneX: app.globalData.isIphoneX
        }), wx.setNavigationBarTitle({
            title: "支付订单"
        });
        var e = a.order;
        t.setData({
            order: e
        });
        var o = 0;
        a.fxsid && (o = a.fxsid, t.setData({
            fxsid: a.fxsid
        })), t.showbase(), app.util.getUserInfo(t.getinfos, o);
    },
    getinfos: function() {
        var t = this;
        wx.getStorage({
            key: "openid",
            success: function(a) {
                t.setData({
                    openid: a.data
                }), t.getOrder();
            }
        });
    },
    redirectto: function(a) {
        var t = a.currentTarget.dataset.link, e = a.currentTarget.dataset.linktype;
        app.util.redirectto(t, e);
    },
    showbase: function() {
        var t = this;
        app.util.request({
            url: "entry/wxapp/BaseMin",
            cachetime: "30",
            data: {
                vs1: 1
            },
            success: function(a) {
                a.data.data;
                t.setData({
                    baseinfo: a.data.data
                }), wx.setNavigationBarColor({
                    frontColor: t.data.baseinfo.base_tcolor,
                    backgroundColor: t.data.baseinfo.base_color
                });
            }
        });
    },
    getOrder: function() {
        var o = this, a = o.data.order, d = o.data.my_money, r = o.data.true_money;
        app.util.request({
            url: "entry/wxapp/Orderinfo",
            data: {
                order: a
            },
            header: {
                "content-type": "application/json"
            },
            success: function(a) {
                a.data.data.jf_money;
                var t = a.data.data.dikou_jf;
                if (1 == a.data.data.is_score) var e = 1e3 * a.data.data.true_price - 1e3 * t; else e = 1e3 * a.data.data.true_price;
                d = 1e3 * a.data.data.my_money, r = e <= d ? 0 : e - d, o.setData({
                    showPay: 1,
                    comment: a.data.data,
                    true_price: e / 1e3,
                    my_money: d / 1e3,
                    true_money: r / 1e3,
                    dikou_jf: a.data.data.dikou_jf,
                    dikou_jf_val: a.data.data.dikou_jf,
                    cid: a.data.data.pid,
                    orderid: a.data.data.id,
                    is_more: a.data.data.is_more
                });
            }
        });
    },
    goback: function() {
        wx.navigateBack();
    },
    sendMail_form: function() {
        app.util.request({
            url: "entry/wxapp/sendMail_form2",
            data: {
                orderid: this.data.orderid,
                cid: this.data.cid
            },
            success: function(a) {},
            fail: function(a) {}
        });
    },
    sendMail_order: function(a) {
        app.util.request({
            url: "entry/wxapp/sendMail_order",
            data: {
                order_id: a
            },
            success: function(a) {},
            fail: function(a) {}
        });
    },
    pay0: function(a) {
        var t = this;
        t.setData({
            formId: a.detail.formId
        });
        var e = t.data.comment.order_id;
        app.util.request({
            url: "entry/wxapp/checktable",
            data: {
                order_id: e
            },
            success: function(a) {
                a.data.data ? (t.sendMail_order(e), "0" != t.data.is_more && t.sendMail_form(), 
                t.payover_do(e)) : wx.showModal({
                    title: "抱歉",
                    content: "您选择的商品已售出，请重新选购",
                    showCancel: !1,
                    success: function(a) {
                        wx.navigateBack({
                            delta: 2
                        });
                    }
                });
            }
        });
    },
    pay1: function(a) {
        var t = this;
        t.setData({
            formId: a.detail.formId
        });
        var e = t.data.comment.order_id;
        wx.showModal({
            title: "提示",
            content: "您将使用余额支付" + t.data.true_price + "元",
            success: function(a) {
                a.confirm && app.util.request({
                    url: "entry/wxapp/checktable",
                    data: {
                        order_id: e
                    },
                    success: function(a) {
                        a.data.data ? (t.sendMail_order(e), "0" != t.data.is_more && t.sendMail_form(), 
                        t.payover_do(e)) : wx.showModal({
                            title: "抱歉",
                            content: "您选择的商品已售出，请重新选购",
                            showCancel: !1,
                            success: function(a) {
                                wx.navigateBack({
                                    delta: 2
                                });
                            }
                        });
                    }
                });
            }
        });
    },
    pay: function(a) {
        var t = this;
        t.setData({
            formId: a.detail.formId
        });
        var e = wx.getStorageSync("openid"), o = t.data.comment.true_price;
        t.data.true_money && (o = t.data.true_money);
        var d = t.data.comment.order_id;
        wx.showModal({
            title: "提示",
            content: "您将使用微信支付" + t.data.true_money + "元",
            success: function(a) {
                a.confirm && app.util.request({
                    url: "entry/wxapp/checktable",
                    data: {
                        order_id: d
                    },
                    success: function(a) {
                        a.data.data ? app.util.request({
                            url: "entry/wxapp/weixinpay",
                            data: {
                                openid: e,
                                price: o,
                                order_id: d
                            },
                            header: {
                                "content-type": "application/json"
                            },
                            success: function(a) {
                                1 == a.data.data.errs && wx.showModal({
                                    title: "支付失败",
                                    content: a.data.data.return_msg,
                                    showCancel: !1
                                }), "success" == a.data.message && wx.requestPayment({
                                    timeStamp: a.data.data.timeStamp,
                                    nonceStr: a.data.data.nonceStr,
                                    package: a.data.data.package,
                                    signType: "MD5",
                                    paySign: a.data.data.paySign,
                                    success: function(a) {
                                        t.sendMail_order(d), "0" != t.data.is_more && t.sendMail_form(), t.payover_do(d);
                                    },
                                    fail: function(a) {},
                                    complete: function(a) {}
                                }), "error" == a.data.message && wx.showModal({
                                    title: "提醒",
                                    content: a.data.data.message,
                                    showCancel: !1
                                });
                            }
                        }) : wx.showModal({
                            title: "抱歉",
                            content: "您选择的商品已售出，请重新选购",
                            showCancel: !1,
                            success: function(a) {
                                wx.navigateBack({
                                    delta: 2
                                });
                            }
                        });
                    }
                });
            }
        });
    },
    payover_do: function(a) {
        var t = this, e = t.data.comment, o = t.data.true_price, d = t.data.my_money, r = t.data.true_money, n = t.data.dikou_jf;
        n = 1 == e.is_score ? n : 0;
        var i = 0;
        i = 0 == r ? o : d, app.util.request({
            url: "entry/wxapp/orderpayover",
            data: {
                order_id: a,
                my_pay_money: i,
                true_money: r,
                jf_score: n,
                openid: wx.getStorageSync("openid"),
                formId: t.data.formId
            },
            success: function(a) {
                1 == a.data.data && wx.showToast({
                    title: "购买成功",
                    icon: "success",
                    success: function() {
                        setTimeout(function() {
                            wx.reLaunch({
                                url: "/sudu8_page/order/order?type=9"
                            });
                        }, 1500);
                    }
                });
            },
            fail: function(a) {},
            complete: function(a) {}
        });
    },
    switch1Change: function(a) {
        var t = this, e = (t.data.dikou_jf, t.data.dikou_jf_val), o = 0, d = 0;
        d = 0 == (o = a.detail.value ? e : 0) ? -e : e;
        var r = t.data.true_money, n = t.data.true_price;
        0 == r ? n = (1e3 * n - 1e3 * d) / 1e3 : r = (1e3 * r - 1e3 * d) / 1e3, t.setData({
            dikou_jf: o,
            true_money: r,
            true_price: n
        });
    }
});