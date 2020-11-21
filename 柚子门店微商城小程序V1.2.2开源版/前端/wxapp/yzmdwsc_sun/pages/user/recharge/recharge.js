var app = getApp();

Page({
    data: {
        notice: "充值后，账户余额仅支持平台消费，不予以退还",
        youhui: [ {
            recharge: 20,
            youhui: 5
        }, {
            recharge: 20,
            youhui: 5
        }, {
            recharge: 20,
            youhui: 5
        } ],
        is_pay: !0
    },
    onLoad: function(e) {
        var a = this;
        wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("fontcolor"),
            backgroundColor: wx.getStorageSync("color"),
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        }), app.util.request({
            url: "entry/wxapp/getRecharge",
            cachetime: "0",
            success: function(e) {
                a.setData({
                    recharge: e.data
                });
            }
        });
    },
    onReady: function() {},
    onShow: function() {
        var a = this;
        app.util.request({
            url: "entry/wxapp/getUser",
            cachetime: "0",
            data: {
                openid: wx.getStorageSync("openid")
            },
            success: function(e) {
                a.setData({
                    user: e.data
                });
            }
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    money: function(e) {
        var a = e.detail.value;
        this.setData({
            money: a
        });
    },
    quick_pay: function(e) {
        var t = this, a = wx.getStorageSync("openid"), n = e.currentTarget.dataset.recharge_id;
        t.data.is_pay, t.setData({
            is_pay: !1
        }), app.util.request({
            url: "entry/wxapp/setRecharge",
            cachetime: "0",
            data: {
                openid: a,
                recharge_id: n
            },
            success: function(e) {
                t.setData({
                    is_pay: !0
                });
                var a = e.data;
                app.util.request({
                    url: "entry/wxapp/getPayParam",
                    cachetime: "0",
                    data: {
                        order_id: a
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
                                            url: "/yzmdwsc_sun/pages/user/recharge/recharge"
                                        });
                                    }
                                });
                            },
                            fail: function(e) {}
                        });
                    }
                });
            }
        });
    },
    submit: function(e) {
        var t = this, a = wx.getStorageSync("openid"), n = e.currentTarget.dataset.money;
        n <= 0 || null == n ? wx.showToast({
            title: "请输入正确充值金额",
            icon: "none"
        }) : (t.data.is_pay, t.setData({
            is_pay: !1
        }), app.util.request({
            url: "entry/wxapp/setRecharge",
            cachetime: "0",
            data: {
                openid: a,
                money: n
            },
            success: function(e) {
                t.setData({
                    is_pay: !0
                });
                var a = e.data;
                app.util.request({
                    url: "entry/wxapp/getPayParam",
                    cachetime: "0",
                    data: {
                        order_id: a
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
                                            url: "/yzmdwsc_sun/pages/user/recharge/recharge"
                                        });
                                    }
                                });
                            },
                            fail: function(e) {}
                        });
                    }
                });
            }
        }));
    }
});