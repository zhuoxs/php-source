var wxbarcode = require("../../../../style/utils/index.js"), app = getApp();

Page({
    data: {
        order: {},
        navTile: "订单详情",
        shopname: "柚子商店",
        goods: [],
        totalprice: "2.50",
        discount: "30.00",
        orderNnum: "1234567897",
        time: "2018-05-01 10:10:10",
        status: 1,
        paytype: "余额支付",
        choose: [ {
            name: "微信",
            value: "微信支付",
            icon: "../../../../style/images/wx.png"
        }, {
            name: "余额",
            value: "余额支付",
            icon: "../../../../style/images/local.png"
        } ],
        payStatus: !1,
        isPay: 0
    },
    onLoad: function(a) {
        var t = this;
        wx.setNavigationBarTitle({
            title: t.data.navTile
        }), app.get_imgroot().then(function(a) {
            t.setData({
                imgroot: a
            });
        }), app.util.request({
            url: "entry/wxapp/GetOrderInfo",
            data: {
                id: a.id
            },
            success: function(a) {
                a.data.discount = (parseFloat(a.data.amount) - parseFloat(a.data.pay_amount) + parseFloat(a.data.distribution_fee)).toFixed(2), 
                t.setData({
                    order: a.data
                }), wxbarcode.qrcode("qrcode", a.data.order_number, 420, 420);
            }
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    deletes: function(a) {
        var t = this;
        wx.showModal({
            title: "提示",
            content: "订单删除后不再显示!",
            success: function(a) {
                if (a.confirm) app.util.request({
                    url: "entry/wxapp/DeleteOrder",
                    cachetime: "0",
                    data: {
                        id: t.data.order.id
                    },
                    success: function(a) {
                        wx.navigateBack({});
                    }
                }); else if (a.cancel) return;
            }
        });
    },
    cancel: function(a) {
        var t = this.data.order.id, e = this;
        wx.showModal({
            title: "提示",
            content: "确定取消该订单吗？",
            success: function(a) {
                a.confirm ? app.util.request({
                    url: "entry/wxapp/CancelOrder",
                    data: {
                        id: t
                    },
                    success: function(a) {
                        app.util.request({
                            url: "entry/wxapp/GetOrderInfo",
                            data: {
                                id: t
                            },
                            success: function(a) {
                                a.data.discount = parseFloat(a.data.amount) - parseFloat(a.data.pay_amount) + parseFloat(a.data.distribution_fee), 
                                e.setData({
                                    order: a.data
                                }), wxbarcode.qrcode("qrcode", a.data.order_number, 420, 420);
                            }
                        });
                    }
                }) : a.cancel && console.log("用户点击取消");
            }
        });
    },
    dialog: function(a) {
        wx.makePhoneCall({
            phoneNumber: this.data.order.tel
        });
    },
    powerDrawer: function(a) {
        this.setData({
            payStatus: !this.data.payStatus
        });
    },
    radioChange: function(a) {
        var t = a.detail.value;
        console.log(t), this.setData({
            payType: t
        });
    },
    formSubmit: function(a) {
        var o = this, i = o.data.payType;
        null != i ? (o.setData({
            isPay: ++o.data.isPay
        }), 1 == o.data.isPay ? app.get_user_info().then(function(a) {
            var t = o.data.order, e = t.id, n = t.pay_amount;
            app.get_user_info().then(function(a) {
                app.util.request({
                    url: "entry/wxapp/PayOrder",
                    cachetime: "0",
                    data: {
                        user_id: a.id,
                        id: e,
                        pay_type: i,
                        pay_amount: n
                    },
                    success: function(a) {
                        app.wx_requestPayment(a.data.paydata).then(function(a) {
                            wx.redirectTo({
                                url: "../../index/paysuc/paysuc"
                            });
                        }), o.setData({
                            isPay: --o.data.isPay
                        });
                    }
                });
            });
        }) : wx.showToast({
            title: "正在支付中...",
            icon: "none"
        })) : wx.showToast({
            title: "请选择支付方式",
            icon: "none"
        });
    }
});