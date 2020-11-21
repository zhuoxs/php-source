var app = getApp();

Page({
    data: {},
    onLoad: function(e) {
        wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("fontcolor"),
            backgroundColor: wx.getStorageSync("color"),
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        }), console.log(e);
        var t = this;
        app.util.request({
            url: "entry/wxapp/Url2",
            cachetime: "0",
            success: function(e) {
                wx.setStorageSync("url2", e.data), t.setData({
                    url2: e.data
                });
            }
        }), app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "0",
            success: function(e) {
                wx.setStorageSync("url", e.data), t.setData({
                    url: e.data
                });
            }
        });
        var a = e.id;
        wx.getStorage({
            key: "openid",
            success: function(e) {
                app.util.request({
                    url: "entry/wxapp/OrderDetails",
                    cahcetime: "0",
                    data: {
                        id: a,
                        openid: e.data
                    },
                    success: function(e) {
                        console.log(e), t.setData({
                            orderDetails: e.data.data[0]
                        });
                    }
                });
            }
        });
    },
    confirm: function(e) {
        console.log(e);
        var t = e.currentTarget.dataset.oid;
        app.util.request({
            url: "entry/wxapp/CompleteOrder",
            cachetime: "0",
            data: {
                order_id: t
            },
            success: function(e) {
                console.log(e), wx.showToast({
                    title: "确认收货成功！",
                    icon: "success",
                    duration: 2e3
                });
            }
        }), this.onShow(), wx.navigateTo({
            url: "../myOrder-list/index",
            success: function(e) {},
            fail: function(e) {},
            complete: function(e) {}
        });
    },
    payNow: function(e) {
        console.log(e);
        var t = e.currentTarget.dataset.price, o = e.currentTarget.dataset.oid;
        wx.getStorage({
            key: "openid",
            success: function(e) {
                var a = e.data;
                console.log(t), app.util.request({
                    url: "entry/wxapp/Orderarr",
                    cachetime: "0",
                    data: {
                        openid: a,
                        price: t
                    },
                    success: function(e) {
                        console.log(e);
                        var t = e.data.package;
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
                                    duration: 2e3
                                }), app.util.request({
                                    url: "entry/wxapp/PayOrder",
                                    cachetime: "0",
                                    data: {
                                        order_id: o
                                    },
                                    success: function(e) {
                                        console.log(e), app.util.request({
                                            url: "entry/wxapp/BuyMessage",
                                            cachetime: "0",
                                            data: {
                                                order_id: o,
                                                new_package: t,
                                                openid: a
                                            },
                                            success: function(e) {
                                                console.log("-------------模板消息发送----------------"), console.log(e);
                                            }
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
    onReady: function() {},
    onShow: function() {},
    goToGroups: function(t) {
        console.log(t);
        var e = wx.getStorageSync("openid");
        console.log(e);
        console.log("开始请求数据"), app.util.request({
            url: "entry/wxapp/FindTuan",
            cachetime: "30",
            data: {
                id: t.currentTarget.dataset.id,
                openid: e
            },
            success: function(e) {
                console.log("请求成功，返回参数"), console.log(e), wx.navigateTo({
                    url: "../pintuan-list/goCantuan?id=" + t.currentTarget.dataset.id + "&openid=" + e.data.data + "&gotype=22"
                });
            },
            fail: function() {
                console.log("vvvvvvvvvv");
            }
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {}
});