var app = getApp(), Toptips = require("../../libs/zanui/toptips/index");

Page({
    data: {
        receiver: null,
        hasReceiver: !1,
        remarkOrder: {
            placeholder: "选填",
            inputCount: 0,
            maxlength: 100,
            inputValue: ""
        },
        itemCount: {
            quantity: 1,
            min: 1,
            max: 10
        },
        showOpenSetting: !1
    },
    onLoad: function(t) {
        var e = this, a = wx.getStorageSync("loading_img");
        a ? e.setData({
            loadingImg: a
        }) : e.setData({
            loadingImg: "../../libs/images/loading.gif"
        });
        var i = t.id, n = t.type;
        n && "wechat" == n && e.setData({
            wechatPay: !0
        }), app.util.request({
            url: "entry/wxapp/item",
            cachetime: "0",
            data: {
                act: "detail",
                id: i,
                m: "superman_hand2"
            },
            success: function(t) {
                t.data.errno ? e.showIconToast(t.data.errmsg) : e.setData({
                    itemDetail: t.data.data.item,
                    credit_title: app.globalData.credit_title,
                    completed: !0
                });
            },
            fail: function(t) {
                e.setData({
                    completed: !0
                }), e.showIconToast(t.data.errmsg);
            }
        });
    },
    setAddress: function() {
        var e = this;
        wx.chooseAddress({
            success: function(t) {
                e.setData({
                    receiver: t,
                    hasReceiver: !0
                });
            },
            fail: function(t) {
                console.log(t), e.data.showOpenSetting || e.setData({
                    showOpenSetting: !0
                });
            }
        });
    },
    hideOpenSetting: function() {
        this.data.showOpenSetting && this.setData({
            showOpenSetting: !1
        });
    },
    confirmOpenSetting: function() {
        this.data.showOpenSetting && this.setData({
            showOpenSetting: !1
        });
    },
    handleZanStepperChange: function(t) {
        var e = t.detail;
        this.setData({
            "itemCount.quantity": e,
            fee: Math.floor(parseFloat(this.data.itemDetail.price) * e * 100) / 100
        });
    },
    submitOrder: function(t) {
        var a = this;
        if (a.data.hasReceiver || 2 == a.data.itemDetail.trade_type) {
            var e = "";
            2 != a.data.itemDetail.trade_type && (e = a.data.receiver.provinceName + a.data.receiver.cityName + a.data.receiver.countyName + a.data.receiver.detailInfo);
            var i = t.detail.formId;
            app.util.request({
                url: "entry/wxapp/notice",
                cachetime: "0",
                data: {
                    act: "formid",
                    formid: i,
                    m: "superman_hand2"
                },
                success: function(t) {
                    0 == t.data.errno ? console.log("formid已添加") : console.log(t.data.errmsg);
                },
                fail: function(t) {
                    console.log(t.data.errmsg);
                }
            }), app.util.request({
                url: "entry/wxapp/item",
                data: {
                    m: "superman_hand2",
                    act: "submit",
                    itemid: a.data.itemDetail.id,
                    mobile: a.data.receiver ? a.data.receiver.telNumber : "",
                    address: e,
                    name: a.data.receiver ? a.data.receiver.userName : "",
                    formId: i,
                    count: a.data.itemCount.quantity,
                    payType: a.data.wechatPay ? "wechat" : "credit",
                    reply: a.data.remarkOrder.inputValue ? a.data.remarkOrder.inputValue : ""
                },
                fail: function(t) {
                    20 == t.data.errno ? wx.showModal({
                        title: "系统提示",
                        content: t.data.errmsg + "(" + t.data.errno + ")",
                        confirmText: "去赚" + a.data.credit_title,
                        success: function(t) {
                            t.confirm && wx.redirectTo({
                                url: "../get_credit/index"
                            });
                        }
                    }) : wx.showModal({
                        title: "系统提示",
                        content: t.data.errmsg + "(" + t.data.errno + ")"
                    });
                },
                success: function(t) {
                    if (a.data.wechatPay) {
                        var e = {
                            timeStamp: t.data.data.timeStamp,
                            nonceStr: t.data.data.nonceStr,
                            package: t.data.data.package,
                            signType: t.data.data.signType,
                            paySign: t.data.data.paySign
                        };
                        a.payment(e);
                    } else wx.showToast({
                        title: "兑换成功"
                    }), setTimeout(function() {
                        wx.redirectTo({
                            url: "../my_order/index?type=buy"
                        });
                    }, 2e3);
                }
            });
        } else Toptips("未设置收货地址");
    },
    payment: function(t) {
        wx.requestPayment({
            timeStamp: t.timeStamp,
            nonceStr: t.nonceStr,
            package: t.package,
            signType: t.signType,
            paySign: t.paySign,
            success: function(t) {
                wx.showToast({
                    title: "支付成功"
                }), setTimeout(function() {
                    wx.redirectTo({
                        url: "../my_order/index?type=buy"
                    });
                }, 1e3);
            },
            fail: function(t) {
                console.log(t);
            }
        });
    },
    bindChangeRemarkOrder: function(t) {
        var e = t.detail.detail.value, a = e.length;
        this.setData({
            "remarkOrder.inputValue": e,
            "remarkOrder.inputCount": a
        });
    }
});