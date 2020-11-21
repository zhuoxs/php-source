function _defineProperty(t, a, e) {
    return a in t ? Object.defineProperty(t, a, {
        value: e,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : t[a] = e, t;
}

var app = getApp();

function qrcode(t) {
    var a = require("../../../utils/wxqrcode.js").createQrCodeImg(t, {
        size: 300
    });
    return console.log(a), a;
}

Page({
    data: {
        logistics: null,
        qrcode: !1
    },
    hideQrcode: function() {
        this.setData({
            qrcode: !1
        });
    },
    copy_order: function(t) {
        var a = t.currentTarget.dataset.value;
        wx.setClipboardData({
            data: a,
            success: function() {
                app.look.ok("复制成功");
            }
        });
    },
    check_express: function() {
        var a = this;
        null == a.data.logistics ? app.util.request({
            url: "entry/wxapp/my",
            showLoading: !1,
            data: {
                op: "check_express",
                id: a.data.list.id,
                type: 1
            },
            success: function(t) {
                console.log(t), a.setData({
                    mylogistics: !0,
                    logistics: t.data.data.Traces.reverse()
                });
            }
        }) : a.setData({
            mylogistics: !0
        });
    },
    cancel: function() {
        this.setData({
            mylogistics: !1
        });
    },
    makePhoneCall: function(t) {
        wx.makePhoneCall({
            phoneNumber: t.currentTarget.dataset.value
        });
    },
    onLoad: function(t) {
        var e = this;
        this.setData({
            "goHome.blackhomeimg": app.globalData.blackhomeimg
        }), app.util.request({
            url: "entry/wxapp/my",
            cachetime: "30",
            method: "POST",
            data: {
                op: "get_order_detail",
                id: t.id
            },
            success: function(t) {
                var a = t.data;
                a.data.list && e.setData({
                    list: a.data.list
                });
            }
        });
    },
    onReady: function() {
        app.look.navbar(this);
        var t = {};
        t.nor_pos = app.module_url + "resource/wxapp/community/nor-pos.png", t.sq_call = app.module_url + "resource/wxapp/community/sq-call.png", 
        this.setData({
            images: t
        });
    },
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    cancelOrder: function(t) {
        var a = this, e = a.data.list, i = e.id;
        wx.showModal({
            title: "提示",
            content: "确定取消订单",
            success: function(t) {
                t.confirm ? (wx.showLoading({
                    title: "操作中"
                }), app.util.request({
                    url: "entry/wxapp/my",
                    data: {
                        op: "off_order",
                        id: i
                    },
                    success: function(t) {
                        e.status = -1, a.setData({
                            list: e
                        });
                    }
                })) : t.cancel && console.log("用户点击取消");
            }
        });
    },
    pay: function(t) {
        var e = this, i = e.data.list, a = i.id;
        wx.showLoading({
            title: "加载中"
        }), app.util.request({
            url: "entry/wxapp/my",
            data: {
                op: "pay_order",
                id: a
            },
            success: function(t) {
                wx.hideLoading(), t.data && t.data.data && !t.data.errno && wx.requestPayment({
                    timeStamp: t.data.data.timeStamp,
                    nonceStr: t.data.data.nonceStr,
                    package: t.data.data.package,
                    signType: "MD5",
                    paySign: t.data.data.paySign,
                    success: function(t) {
                        var a = i.order;
                        setTimeout(function() {
                            !function t(a) {
                                app.util.request({
                                    url: "entry/wxapp/payquery",
                                    showLoading: !1,
                                    data: {
                                        tid: a
                                    },
                                    success: function(t) {
                                        i.status = 2, e.setData({
                                            list: i
                                        });
                                    },
                                    fail: function() {
                                        setTimeout(function() {
                                            t(a);
                                        }, 1e3);
                                    }
                                });
                            }(a);
                        }, 500);
                    },
                    fail: function(t) {
                        t.errMsg;
                    }
                });
            }
        });
    },
    toRefund: function(t) {
        var a = this.data.list.id;
        wx.navigateTo({
            url: "../refund/refund?id=" + a
        });
    },
    toDelivery: function(t) {
        var a = this.data.list.id;
        wx.showLoading({
            title: "提交中"
        }), app.util.request({
            url: "entry/wxapp/my",
            data: {
                op: "remind_order",
                id: a
            },
            success: function(t) {
                wx.hideLoading();
            }
        });
    },
    confirmReceipt: function(t) {
        var a = this, e = this.data.list, i = e.id;
        wx.showModal({
            title: "提示",
            content: "确认收货?",
            success: function(t) {
                t.confirm && (wx.showLoading({
                    title: "加载中"
                }), app.util.request({
                    url: "entry/wxapp/my",
                    data: {
                        op: "sure_order",
                        id: i
                    },
                    success: function(t) {
                        app.util.message({
                            title: t.data.message
                        }), e.status = 5, a.setData({
                            list: e
                        });
                    }
                }));
            }
        });
    },
    pickCode: function(t) {
        var e = this;
        "" != this.data.list.hex ? this.setData({
            hex: qrcode(this.data.list.hex + "#" + e.data.list.order),
            qrcode: !0
        }) : app.util.request({
            url: "entry/wxapp/community",
            showLoading: !0,
            method: "POST",
            data: {
                op: "pickCode",
                id: e.data.list.id
            },
            success: function(t) {
                var a;
                e.setData((_defineProperty(a = {
                    hex: qrcode(t.data.data + "#" + e.data.list.order)
                }, "list.hex", t.data.data), _defineProperty(a, "qrcode", !0), a));
            },
            fail: function(t) {
                app.look.no(t.data.message);
            }
        });
    }
});