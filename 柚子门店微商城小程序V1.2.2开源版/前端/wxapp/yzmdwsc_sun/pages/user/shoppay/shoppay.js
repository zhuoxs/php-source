var app = getApp();

Page({
    data: {
        navTile: "到店支付",
        uthumb: "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152550116768.jpg",
        shopname: "柚子鲜花坊",
        price: ""
    },
    onLoad: function(t) {
        wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("fontcolor"),
            backgroundColor: wx.getStorageSync("color"),
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        }), wx.setNavigationBarTitle({
            title: this.data.navTile
        });
        var e = wx.getStorageSync("url"), a = wx.getStorageSync("settings");
        this.setData({
            url: e,
            settings: a
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    bindPrice: function(t) {
        this.setData({
            price: t.detail.value
        });
    },
    toPayByBalance: function(t) {
        var e = this.data.price || 0, a = wx.getStorageSync("openid"), n = t.detail.formId;
        e <= 0 ? wx.showToast({
            title: "金额不得小于0"
        }) : wx.showModal({
            title: "提示",
            content: "确定使用余额支付",
            success: function(t) {
                t.confirm ? app.util.request({
                    url: "entry/wxapp/setShopOrderByBalance",
                    cachetime: "0",
                    data: {
                        openid: a,
                        price: e,
                        formId: n
                    },
                    success: function(t) {
                        0 == t.data.errno && wx.showToast({
                            title: "支付成功",
                            icon: "success",
                            duration: 3e3,
                            success: function() {},
                            complete: function() {
                                wx.redirectTo({
                                    url: "../../user/user"
                                });
                            }
                        });
                    }
                }) : t.cancel && console.log("用户点击取消");
            }
        });
    },
    toPay: function(t) {
        var e = this.data.price || 0, a = wx.getStorageSync("openid");
        e <= 0 ? wx.showToast({
            title: "金额不得小于0"
        }) : app.util.request({
            url: "entry/wxapp/setShopOrder",
            cachetime: "0",
            data: {
                openid: a,
                price: e
            },
            success: function(t) {
                if (0 == t.data.errno) {
                    var e = t.data.data;
                    app.util.request({
                        url: "entry/wxapp/getPayParam",
                        cachetime: "0",
                        data: {
                            order_id: e
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
                                    });
                                },
                                fail: function(t) {}
                            });
                        }
                    });
                }
            }
        });
    }
});