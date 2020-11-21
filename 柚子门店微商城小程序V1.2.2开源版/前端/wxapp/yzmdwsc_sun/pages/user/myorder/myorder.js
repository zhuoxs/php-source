var app = getApp();

Page({
    data: {
        navTile: "我的订单",
        curIndex: 0,
        nav: [ "全部", "待付款", "待发货", "待收货", "待评价" ],
        all: [ {
            ordernum: "2018032015479354825174",
            status: "1",
            img: "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152360015252.png",
            title: "可口可乐可口可乐可口可乐可口可乐可口可乐可口可乐",
            price: "2.50",
            num: "1"
        }, {
            ordernum: "2018032015479354825176",
            status: "0",
            img: "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152360015252.png",
            title: "可口可乐",
            price: "2.50",
            num: "1"
        }, {
            ordernum: "2018032015479354825176",
            status: "2",
            img: "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152360015252.png",
            title: "可口可乐",
            price: "2.50",
            num: "1"
        } ],
        choose: [ {
            name: "微信",
            value: "微信支付",
            pay_type: 1,
            icon: "../../../../style/images/wx.png"
        }, {
            name: "余额",
            value: "余额支付",
            pay_type: 2,
            icon: "../../../../style/images/local.png"
        } ],
        dfk: [],
        dsh: [],
        sh: [],
        isOpenPay: !1
    },
    onLoad: function(e) {
        var t = this;
        wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("fontcolor"),
            backgroundColor: wx.getStorageSync("color"),
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        }), wx.setNavigationBarTitle({
            title: t.data.navTile
        });
        var a = wx.getStorageSync("url"), r = e.index;
        this.setData({
            curIndex: parseInt(r),
            url: a
        });
        var n = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/getMyorder",
            cachetime: "0",
            data: {
                uid: n,
                index: r
            },
            success: function(e) {
                t.setData({
                    order: e.data
                });
            }
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    bargainTap: function(e) {
        var t = this, a = parseInt(e.currentTarget.dataset.index);
        this.setData({
            curIndex: a
        });
        var r = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/getMyorder",
            cachetime: "0",
            data: {
                uid: r,
                index: a
            },
            success: function(e) {
                t.setData({
                    order: e.data
                });
            }
        });
    },
    toCancel: function(e) {
        var t = this, a = wx.getStorageSync("openid"), r = e.currentTarget.dataset.order_id, n = t.data.order, o = e.currentTarget.dataset.index;
        wx.showModal({
            title: "提示",
            content: "确定取消该订单吗？",
            success: function(e) {
                e.confirm ? app.util.request({
                    url: "entry/wxapp/cancelOrder",
                    cachetime: "0",
                    data: {
                        uid: a,
                        order_id: r
                    },
                    success: function(e) {
                        n[o].order_status = 7, t.setData({
                            order: n
                        });
                    }
                }) : e.cancel && console.log("用户点击取消");
            }
        });
    },
    toComment: function(e) {
        wx.navigateTo({
            url: "../comment/comment"
        });
    },
    toDel: function(e) {
        var t = this, a = wx.getStorageSync("openid"), r = e.currentTarget.dataset.order_id, n = t.data.order, o = e.currentTarget.dataset.index;
        wx.showModal({
            title: "提示",
            content: "订单删除后将不再显示",
            success: function(e) {
                e.confirm ? app.util.request({
                    url: "entry/wxapp/delOrder",
                    cachetime: "0",
                    data: {
                        uid: a,
                        order_id: r
                    },
                    success: function(e) {
                        n.splice(o, 1), t.setData({
                            order: n
                        });
                    }
                }) : e.cancel && console.log("用户点击删除");
            }
        });
    },
    ljzf: function(e) {
        var t = e.currentTarget.dataset.order_id, a = e.currentTarget.dataset.order_amount;
        this.setData({
            isOpenPay: !this.data.isOpenPay,
            formId: e.detail.formId,
            order_id: t,
            order_amount: a
        });
    },
    formSubmit: function(e) {
        var t = this.data.order_id, a = wx.getStorageSync("openid"), r = e.detail.formId, n = this.data.payType;
        null != n ? 1 == n ? app.util.request({
            url: "entry/wxapp/getPayParam",
            cachetime: "0",
            data: {
                order_id: t
            },
            success: function(e) {
                wx.requestPayment({
                    timeStamp: e.data.timeStamp,
                    nonceStr: e.data.nonceStr,
                    package: e.data.package,
                    signType: "MD5",
                    paySign: e.data.paySign,
                    success: function(e) {
                        wx.showToast({
                            title: "支付成功",
                            icon: "success",
                            duration: 2e3,
                            success: function() {},
                            complete: function() {
                                wx.redirectTo({
                                    url: "../../user/myorder/myorder"
                                });
                            }
                        });
                    },
                    fail: function(e) {}
                });
            }
        }) : 2 == n && app.util.request({
            url: "entry/wxapp/setAmountPay",
            cachetime: "0",
            data: {
                order_id: t,
                formId: r,
                uid: a,
                pay_type: n
            },
            success: function(e) {
                wx.showToast({
                    title: "支付成功",
                    icon: "success",
                    duration: 2e3,
                    success: function() {},
                    complete: function() {
                        wx.redirectTo({
                            url: "../../user/myorder/myorder"
                        });
                    }
                });
            }
        }) : wx.showModal({
            title: "温馨提示",
            content: "请选择支付方式",
            showCancel: !1
        });
    },
    topay: function(a) {
        wx.showModal({
            title: "提示",
            content: "确定支付",
            success: function(e) {
                if (e.confirm) {
                    wx.getStorageSync("openid");
                    var t = a.currentTarget.dataset.order_id;
                    console.log(t), app.util.request({
                        url: "entry/wxapp/getPayParam",
                        cachetime: "0",
                        data: {
                            order_id: t
                        },
                        success: function(e) {
                            wx.requestPayment({
                                timeStamp: e.data.timeStamp,
                                nonceStr: e.data.nonceStr,
                                package: e.data.package,
                                signType: "MD5",
                                paySign: e.data.paySign,
                                success: function(e) {
                                    app.util.request({
                                        url: "entry/wxapp/PayOrder",
                                        cachetime: "0",
                                        data: {
                                            order_id: t,
                                            mch_id: 0
                                        },
                                        success: function(e) {
                                            wx.showToast({
                                                title: "支付成功",
                                                icon: "success",
                                                duration: 2e3,
                                                success: function() {},
                                                complete: function() {
                                                    wx.navigateTo({
                                                        url: "../../user/myorder/myorder"
                                                    });
                                                }
                                            });
                                        }
                                    });
                                },
                                fail: function(e) {
                                    wx.navigateTo({
                                        url: "../../user/myorder/myorder"
                                    });
                                }
                            });
                        }
                    });
                } else e.cancel && console.log("用户点击取消");
            }
        });
    },
    toqueren: function(e) {
        var t = this, a = wx.getStorageSync("openid"), r = e.currentTarget.dataset.order_id, n = t.data.order, o = e.currentTarget.dataset.index;
        wx.showModal({
            title: "提示",
            content: "确定收货",
            success: function(e) {
                e.confirm ? app.util.request({
                    url: "entry/wxapp/querenOrder",
                    cachetime: "0",
                    data: {
                        uid: a,
                        order_id: r
                    },
                    success: function(e) {
                        n[o].order_status = 3, t.setData({
                            order: n
                        });
                    }
                }) : e.cancel && console.log("用户点击取消");
            }
        });
    },
    topingjia: function(e) {
        var t = e.currentTarget.dataset.order_id, a = e.currentTarget.dataset.order_detail_id;
        wx.navigateTo({
            url: "../comment/comment?order_id=" + t + "&order_detail_id=" + a
        });
    },
    toOrderdet: function(e) {
        var t = e.currentTarget.dataset.id;
        wx.navigateTo({
            url: "../orderdet/orderdet?id=" + t
        });
    },
    toIndex: function(e) {
        wx.redirectTo({
            url: "/yzmdwsc_sun/pages/index/index"
        });
    },
    toSubmit: function(e) {
        this.setData({
            isOpenPay: !this.data.isOpenPay
        });
    },
    radioChange: function(e) {
        var t = e.detail.value;
        console.log(t), this.setData({
            payType: t
        });
    }
});