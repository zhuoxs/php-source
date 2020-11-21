var app = getApp(), wxbarcode = require("../../../../style/utils/index.js");

Page({
    data: {
        order: {},
        navTile: "订单详情",
        shopname: "柚子商店",
        goods: [ {
            title: "发财树绿萝栀子花海棠花卉盆栽",
            goodsThumb: "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152531295627.png",
            price: "2.50",
            specConn: "s",
            num: "1"
        }, {
            title: "发财树绿萝栀子花海棠花卉盆栽",
            goodsThumb: "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152531295627.png",
            price: "2.50",
            specConn: "套餐1",
            num: "1"
        } ],
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
        }), t.setData({
            id: a.id
        }), app.util.request({
            url: "entry/wxapp/GetOrderappInfo",
            cachetime: "0",
            data: {
                id: a.id
            },
            success: function(a) {
                t.setData({
                    order: a.data
                }), wxbarcode.qrcode("qrcode", "appgoods:" + a.data.order_number, 420, 420);
            }
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
        var i = this, o = i.data.payType;
        null != o ? (i.setData({
            isPay: ++i.data.isPay
        }), 1 == i.data.isPay ? app.get_user_info().then(function(a) {
            var t = i.data.order, e = t.id, n = t.pay_amount;
            app.get_user_info().then(function(a) {
                app.util.request({
                    url: "entry/wxapp/PayOrderapp",
                    cachetime: "0",
                    data: {
                        user_id: a.id,
                        id: e,
                        pay_type: o,
                        pay_amount: n
                    },
                    success: function(a) {
                        if (null != a.data.paydata) if (1 == a.data.paydata.paytype) app.util.request({
                            url: "entry/wxapp/GetOrderappInfo",
                            cachetime: "0",
                            data: {
                                id: i.data.id
                            },
                            success: function(a) {
                                i.setData({
                                    order: a.data
                                }), wxbarcode.qrcode("qrcode", "appgoods:" + a.data.order_number, 420, 420), i.setData({
                                    payStatus: !this.data.payStatus
                                });
                            }
                        }); else {
                            var t = a.data.paydata.integralid;
                            app.wx_requestPayment(a.data.paydata).then(function(a) {
                                "requestPayment:ok" == a.errMsg && app.util.request({
                                    url: "entry/wxapp/addint",
                                    cachetime: "0",
                                    method: "post",
                                    data: {
                                        iid: t
                                    },
                                    success: function() {
                                        wx.redirectTo({
                                            url: "../../index/paysuc/paysuc"
                                        });
                                    }
                                });
                            });
                        } else wx.showModal({
                            title: "提示",
                            content: a.data.msg,
                            showCancel: !1,
                            success: function(a) {}
                        });
                        i.setData({
                            isPay: --i.data.isPay
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
                    url: "entry/wxapp/DeleteOrderapp",
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
        var t = this;
        wx.showModal({
            title: "提示",
            content: "确定取消订单",
            success: function(a) {
                if (a.confirm) app.util.request({
                    url: "entry/wxapp/cancelOrderapp",
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
    dialog: function(a) {
        wx.makePhoneCall({
            phoneNumber: this.data.order.tel
        });
    }
});