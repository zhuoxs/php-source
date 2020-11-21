var app = getApp();

Page({
    data: {
        is_modal_Hidden: !0,
        notice: "充值后，账户余额仅支持平台消费，不予以退还",
        balance: "0.00",
        rechargecard: [],
        isclick: !1,
        isany_money_recharge: 0
    },
    onLoad: function(a) {
        var t = this;
        app.wxauthSetting(), app.util.request({
            url: "entry/wxapp/System",
            cachetime: "30",
            showLoading: !1,
            success: function(a) {
                console.log(a), t.setData({
                    isany_money_recharge: a.data.isany_money_recharge ? a.data.isany_money_recharge : 0
                });
            }
        }), wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("System").fontcolor ? wx.getStorageSync("System").fontcolor : "",
            backgroundColor: wx.getStorageSync("System").color ? wx.getStorageSync("System").color : "",
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        }), app.util.request({
            url: "entry/wxapp/GetRechargeCard",
            cachetime: "30",
            success: function(a) {
                console.log(a), t.setData({
                    rechargecard: a.data
                });
            }
        });
    },
    onShow: function() {
        var t = this;
        app.func.islogin(app, t);
        var a = wx.getStorageSync("openid");
        a && app.util.request({
            url: "entry/wxapp/VIP",
            showLoading: !1,
            data: {
                openid: a
            },
            success: function(a) {
                console.log(a), t.setData({
                    balance: a.data.money
                });
            }
        });
    },
    updateUserInfo: function(a) {
        console.log("授权操作更新");
        app.wxauthSetting();
    },
    money: function(a) {
        var t = a.detail.value;
        this.setData({
            money: t
        });
    },
    quick_pay: function(a) {
        var t = wx.getStorageSync("openid"), e = this, n = a.currentTarget.dataset.id;
        if (e.data.isclick) return console.log("重复点击"), !1;
        e.setData({
            isclick: !0
        }), app.util.request({
            url: "entry/wxapp/Orderarr",
            data: {
                id: n,
                openid: t,
                paytype: 1
            },
            success: function(a) {
                console.log("进入支付"), console.log(a.data), wx.requestPayment({
                    timeStamp: a.data.timeStamp,
                    nonceStr: a.data.nonceStr,
                    package: a.data.package,
                    signType: "MD5",
                    paySign: a.data.paySign,
                    success: function(a) {
                        app.util.request({
                            url: "entry/wxapp/BuyRechargeCard",
                            data: {
                                openid: t,
                                id: n
                            },
                            success: function(a) {
                                console.log(a.data), e.setData({
                                    isclick: !1
                                });
                                var t = (100 * e.data.balance / 100 + a.data).toFixed(2);
                                e.setData({
                                    balance: t
                                });
                            },
                            fail: function(a) {
                                wx.showModal({
                                    title: "提示信息",
                                    content: a.data.message,
                                    showCancel: !1,
                                    success: function(a) {}
                                }), e.setData({
                                    isclick: !1
                                });
                            }
                        });
                    },
                    fail: function(a) {
                        e.setData({
                            isclick: !1
                        });
                    }
                });
            },
            fail: function(a) {
                wx.showModal({
                    title: "提示信息",
                    content: a.data.message,
                    showCancel: !1,
                    success: function(a) {}
                }), e.setData({
                    isclick: !1
                });
            }
        });
    },
    submit: function(a) {
        var e = this, t = wx.getStorageSync("openid"), n = e.data.money;
        return e.data.isclick ? (console.log("重复点击"), !1) : n <= 0 || !n || "undefined" == n ? (wx.showToast({
            title: "请输入正确的充值金额",
            icon: "none",
            duration: 2e3
        }), !1) : (e.setData({
            isclick: !0
        }), void app.util.request({
            url: "entry/wxapp/Orderarr",
            data: {
                openid: t,
                price: n
            },
            success: function(a) {
                console.log("进入支付"), console.log(a.data), wx.requestPayment({
                    timeStamp: a.data.timeStamp,
                    nonceStr: a.data.nonceStr,
                    package: a.data.package,
                    signType: "MD5",
                    paySign: a.data.paySign,
                    success: function(a) {
                        app.util.request({
                            url: "entry/wxapp/BuyRechargeCard",
                            data: {
                                openid: t,
                                price: n
                            },
                            success: function(a) {
                                console.log(a.data), e.setData({
                                    isclick: !1
                                });
                                var t = (100 * e.data.balance / 100 + 100 * a.data / 100).toFixed(2);
                                e.setData({
                                    balance: t
                                });
                            },
                            fail: function(a) {
                                wx.showModal({
                                    title: "提示信息",
                                    content: a.data.message,
                                    showCancel: !1,
                                    success: function(a) {}
                                }), e.setData({
                                    isclick: !1
                                });
                            }
                        });
                    },
                    fail: function(a) {
                        e.setData({
                            isclick: !1
                        });
                    }
                });
            },
            fail: function(a) {
                wx.showModal({
                    title: "提示信息",
                    content: a.data.message,
                    showCancel: !1,
                    success: function(a) {}
                }), e.setData({
                    isclick: !1
                });
            }
        }));
    },
    gobalance: function(a) {
        wx.navigateTo({
            url: "/mzhk_sun/pages/user/balancedetail/balancedetail"
        });
    }
});