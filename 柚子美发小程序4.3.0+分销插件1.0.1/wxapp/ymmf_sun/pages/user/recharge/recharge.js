var app = getApp();

Page({
    data: {
        notice: "充值后，账户余额仅支持平台消费，不予以退还"
    },
    onLoad: function(a) {
        var t = this;
        wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("fontcolor"),
            backgroundColor: wx.getStorageSync("color"),
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        }), wx.getStorage({
            key: "openid",
            success: function(a) {
                app.util.request({
                    url: "entry/wxapp/MoneyData",
                    cachetime: "0",
                    data: {
                        uid: a.data
                    },
                    success: function(a) {
                        t.setData({
                            money: a.data.data.money
                        });
                    }
                });
            }
        });
    },
    onReady: function() {},
    onShow: function() {
        var t = this;
        app.util.request({
            url: "entry/wxapp/youhuimoney",
            cachetime: "0",
            success: function(a) {
                t.setData({
                    youhui: a.data
                });
            }
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    formSubmit: function(a) {
        for (var e = a.detail.value.money, t = this.data.youhui, n = 0, o = (Array(), 0); o < t.length; o++) ;
        for (o = 0; o < t.length; o++) (parseInt(e) > parseInt(t[o].recharge) || parseInt(e) == parseInt(t[o].recharge)) && (n = t[o].youhui);
        console.log(n);
        var c = parseInt(e) + parseInt(n);
        console.log(c), e <= 0 ? wx.showModal({
            title: "提示",
            content: "充值金额不得小于0",
            showCancel: "false",
            success: function(a) {
                return !1;
            }
        }) : wx.getStorage({
            key: "openid",
            success: function(a) {
                var t = a.data;
                app.util.request({
                    url: "entry/wxapp/Orderarr",
                    cachetime: "30",
                    data: {
                        openid: a.data,
                        price: e
                    },
                    success: function(a) {
                        console.log(a), wx.requestPayment({
                            timeStamp: a.data.timeStamp,
                            nonceStr: a.data.nonceStr,
                            package: a.data.package,
                            signType: "MD5",
                            paySign: a.data.paySign,
                            success: function(a) {
                                wx.showToast({
                                    title: "充值成功",
                                    icon: "success",
                                    duration: 2e3
                                }), app.util.request({
                                    url: "entry/wxapp/chongqian",
                                    cachetime: "0",
                                    data: {
                                        uid: t,
                                        price: e,
                                        actual: c
                                    },
                                    success: function(a) {
                                        wx.navigateBack({});
                                    }
                                });
                            },
                            fail: function(a) {}
                        });
                    }
                });
            }
        });
    },
    clickPay: function(a) {
        var t = a.currentTarget.dataset.index, e = this.data.youhui, n = e[t].recharge, o = parseInt(e[t].recharge) + parseInt(e[t].youhui);
        wx.getStorage({
            key: "openid",
            success: function(a) {
                var t = a.data;
                app.util.request({
                    url: "entry/wxapp/Orderarr",
                    cachetime: "30",
                    data: {
                        openid: a.data,
                        price: n
                    },
                    success: function(a) {
                        console.log(a), wx.requestPayment({
                            timeStamp: a.data.timeStamp,
                            nonceStr: a.data.nonceStr,
                            package: a.data.package,
                            signType: "MD5",
                            paySign: a.data.paySign,
                            success: function(a) {
                                wx.showToast({
                                    title: "充值成功",
                                    icon: "success",
                                    duration: 2e3
                                }), app.util.request({
                                    url: "entry/wxapp/chongqian",
                                    cachetime: "0",
                                    data: {
                                        uid: t,
                                        price: n,
                                        actual: o
                                    },
                                    success: function(a) {
                                        wx.navigateBack({});
                                    }
                                });
                            },
                            fail: function(a) {}
                        });
                    }
                });
            }
        });
    },
    goToBa: function(a) {
        wx.navigateTo({
            url: "/ymmf_sun/pages/user/balancedetail/balancedetail"
        });
    }
});