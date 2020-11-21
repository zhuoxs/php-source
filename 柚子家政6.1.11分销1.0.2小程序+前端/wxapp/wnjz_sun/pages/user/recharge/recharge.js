var app = getApp();

Page({
    data: {
        notice: "充值后，账户余额仅支持平台消费，不予以退还",
        youhui: []
    },
    onLoad: function(t) {
        var n = this;
        wx.getUserInfo({
            success: function(t) {
                n.setData({
                    nickname: t.userInfo.nickName
                });
            }
        });
        wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("fontcolor"),
            backgroundColor: wx.getStorageSync("color"),
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        });
    },
    onReady: function() {},
    onShow: function() {
        var n = this;
        app.util.request({
            url: "entry/wxapp/jine",
            success: function(t) {
                console.log(t), n.setData({
                    youhui: t.data
                });
            }
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    money: function(t) {
        var n = t.detail.value;
        this.setData({
            money: n
        });
    },
    quick_pay: function(t) {
        var n = wx.getStorageSync("openid"), a = t.currentTarget.dataset.change_price, e = t.currentTarget.dataset.change_youhui, o = parseInt(a) + parseInt(e);
        app.util.request({
            url: "entry/wxapp/Orderarr",
            data: {
                price: a,
                openid: n
            },
            success: function(t) {
                wx.requestPayment({
                    timeStamp: t.data.timeStamp,
                    nonceStr: t.data.nonceStr,
                    package: t.data.package,
                    signType: "MD5",
                    paySign: t.data.paySign,
                    success: function(t) {
                        wx.showToast({
                            title: "支付成功",
                            icon: "success",
                            duration: 2e3
                        }), app.util.request({
                            url: "entry/wxapp/Addmoney",
                            data: {
                                price: o,
                                openid: n
                            },
                            success: function(t) {}
                        });
                    },
                    fail: function(t) {}
                });
            }
        });
    },
    submit: function(t) {
        var n = wx.getStorageSync("openid"), a = t.currentTarget.dataset.money, e = this.data.youhui;
        console.log(a);
        for (var o = 0, i = 0; i < e.length; i++) parseInt(a) >= parseInt(e[i].recharge) && (o = e[i].youhui);
        var r = parseInt(a) + parseInt(o);
        app.util.request({
            url: "entry/wxapp/Orderarr",
            data: {
                price: a,
                openid: n
            },
            success: function(t) {
                wx.requestPayment({
                    timeStamp: t.data.timeStamp,
                    nonceStr: t.data.nonceStr,
                    package: t.data.package,
                    signType: "MD5",
                    paySign: t.data.paySign,
                    success: function(t) {
                        wx.showToast({
                            title: "支付成功",
                            icon: "success",
                            duration: 2e3
                        }), app.util.request({
                            url: "entry/wxapp/Addmoney",
                            data: {
                                price: r,
                                openid: n
                            },
                            success: function(t) {
                                wx.navigateTo({
                                    url: "wnjz_sun/pages/index/index"
                                });
                            }
                        });
                    },
                    fail: function(t) {}
                });
            }
        });
    }
});