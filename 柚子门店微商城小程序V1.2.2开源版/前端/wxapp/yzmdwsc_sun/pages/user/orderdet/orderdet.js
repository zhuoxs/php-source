var app = getApp();

Page({
    data: {
        navTile: "订单详情",
        addr: [ "墨纸", "1300000000", "厦门市集美区杏林湾运营中心" ],
        shopname: "柚子鲜花店",
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
        distribution: "0.00",
        totalprice: "2.50",
        discount: "30.00",
        orderNnum: "1234567897",
        time: "2018-05-01 10:10:10",
        status: 1
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
        var n = e.id, o = wx.getStorageSync("openid"), a = wx.getStorageSync("url"), r = wx.getStorageSync("settings");
        t.setData({
            url: a,
            settings: r,
            order_id: n
        }), app.util.request({
            url: "entry/wxapp/getOrderDetail",
            cachetime: "0",
            data: {
                id: n,
                uid: o
            },
            success: function(e) {
                console.log(e.data.data), t.setData({
                    order: e.data.data
                });
            }
        });
    },
    topay: function(n) {
        wx.showModal({
            title: "提示",
            content: "确定支付",
            success: function(e) {
                if (e.confirm) {
                    wx.getStorageSync("openid");
                    var t = n.currentTarget.dataset.order_id;
                    app.util.request({
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
    toCancel: function(e) {
        var t = wx.getStorageSync("openid"), n = e.currentTarget.dataset.order_id;
        wx.showModal({
            title: "提示",
            content: "确定取消该订单吗？",
            success: function(e) {
                e.confirm ? app.util.request({
                    url: "entry/wxapp/cancelOrder",
                    cachetime: "0",
                    data: {
                        uid: t,
                        order_id: n
                    },
                    success: function(e) {
                        wx.navigateTo({
                            url: "../../user/myorder/myorder"
                        });
                    }
                }) : e.cancel && console.log("用户点击取消");
            }
        });
    },
    toqueren: function(e) {
        var t = wx.getStorageSync("openid"), n = e.currentTarget.dataset.order_id;
        wx.showModal({
            title: "提示",
            content: "确定收货",
            success: function(e) {
                e.confirm ? app.util.request({
                    url: "entry/wxapp/querenOrder",
                    cachetime: "0",
                    data: {
                        uid: t,
                        order_id: n
                    },
                    success: function(e) {
                        wx.navigateTo({
                            url: "../../user/myorder/myorder"
                        });
                    }
                }) : e.cancel && console.log("用户点击确认");
            }
        });
    },
    toDel: function(e) {
        var t = wx.getStorageSync("openid"), n = e.currentTarget.dataset.order_id;
        wx.showModal({
            title: "提示",
            content: "订单删除后将不再显示",
            success: function(e) {
                e.confirm ? app.util.request({
                    url: "entry/wxapp/delOrder",
                    cachetime: "0",
                    data: {
                        uid: t,
                        order_id: n
                    },
                    success: function(e) {
                        wx.navigateTo({
                            url: "../../user/myorder/myorder"
                        });
                    }
                }) : e.cancel && console.log("用户点击删除");
            }
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    deletes: function(e) {
        wx.showModal({
            title: "提示",
            content: "订单删除后不再显示!",
            success: function(e) {
                if (e.confirm) console.log("确定"); else if (e.cancel) return;
            }
        });
    },
    cancel: function(e) {
        wx.showModal({
            title: "提示",
            content: "确定取消订单",
            success: function(e) {
                if (e.confirm) console.log("确定"); else if (e.cancel) return;
            }
        });
    },
    subPay: function(e) {},
    toMap: function(e) {
        var t = parseFloat(e.currentTarget.dataset.latitude), n = parseFloat(e.currentTarget.dataset.longitude);
        wx.openLocation({
            latitude: t,
            longitude: n,
            scale: 28
        });
    }
});