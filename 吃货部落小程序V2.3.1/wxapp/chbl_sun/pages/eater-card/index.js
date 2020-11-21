var app = getApp();

Page({
    data: {
        price: "",
        msgLis: [ "恭喜王总喜提玛莎拉达一辆", "恭喜赵总喜提奥由R8一辆", "恭喜陈总喜提奔也G65一辆" ]
    },
    onLoad: function(t) {
        wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("fontcolor"),
            backgroundColor: wx.getStorageSync("color"),
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        });
        var a = this;
        app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "0",
            success: function(t) {
                wx.setStorageSync("url", t.data);
                var e = wx.getStorageSync("tab");
                a.setData({
                    url: t.data,
                    tab: e
                });
            }
        }), a.setData({
            current: t.currentIndex
        }), app.util.request({
            url: "entry/wxapp/GetVipcard",
            cachetime: "0",
            success: function(t) {
                if (console.log(t), a.setData({
                    vipcard: t.data.data
                }), t.data.data) var e = t.data.data.name; else e = "会员卡";
                wx.setNavigationBarTitle({
                    title: e
                });
            }
        });
    },
    buyMonth: function(t) {
        console.log(t);
        var a = this, n = wx.getStorageSync("openid"), o = t.currentTarget.dataset.cid;
        wx.showModal({
            title: "提示",
            content: "该卡有效期为" + t.currentTarget.dataset.day + "天，是否确认购买？",
            success: function(t) {
                t.confirm ? (app.util.request({
                    url: "entry/wxapp/IsBuyVipCard",
                    cachetime: "0",
                    data: {
                        openid: n
                    },
                    success: function(t) {
                        console.log(t), 1 == t.data ? wx.showToast({
                            title: "您已购买过会员卡！",
                            icon: "none"
                        }) : app.util.request({
                            url: "entry/wxapp/getVipType",
                            cachetime: "0",
                            data: {
                                id: o
                            },
                            success: function(t) {
                                console.log(t);
                                var e = t.data.price;
                                app.util.request({
                                    url: "entry/wxapp/orderarr",
                                    cachetime: "0",
                                    data: {
                                        openid: n,
                                        price: e
                                    },
                                    success: function(t) {
                                        console.log(t), wx.requestPayment({
                                            timeStamp: t.data.timeStamp,
                                            nonceStr: t.data.nonceStr,
                                            package: t.data.package,
                                            signType: "MD5",
                                            paySign: t.data.paySign,
                                            success: function(t) {
                                                console.log(t), wx.showToast({
                                                    title: "支付成功",
                                                    icon: "success",
                                                    duration: 2e3
                                                }), app.util.request({
                                                    url: "entry/wxapp/BuyOK",
                                                    cachetime: "0",
                                                    data: {
                                                        id: o,
                                                        openid: n
                                                    },
                                                    success: function(t) {
                                                        console.log(t), wx.showToast({
                                                            title: "购买成功！"
                                                        });
                                                    }
                                                }), a.onShow();
                                            }
                                        });
                                    },
                                    fail: function(t) {}
                                });
                            }
                        });
                    }
                }), a.onShow()) : t.cancel && wx.showToast({
                    title: "取消购买！",
                    icon: "none"
                });
            }
        });
    },
    goTap: function(t) {
        console.log(t);
        var e = this;
        e.setData({
            current: t.currentTarget.dataset.index
        }), 0 == e.data.current && wx.redirectTo({
            url: "../first/index"
        }), 1 == e.data.current && wx.redirectTo({
            url: "../cheap/index?currentIndex=1"
        }), 3 == e.data.current && wx.redirectTo({
            url: "../mine/index?currentIndex=3"
        });
    },
    goActive: function() {
        wx.navigateTo({
            url: "../active-Card/index"
        });
    },
    buyButton: function(t) {
        console.log(t);
        var a = t.currentTarget.dataset.price, n = t.currentTarget.dataset.id;
        wx.getStorage({
            key: "openid",
            success: function(t) {
                var e = t.data;
                app.util.request({
                    url: "entry/wxapp/Orderarr",
                    cachetime: "0",
                    data: {
                        openid: e,
                        price: a
                    },
                    success: function(t) {
                        console.log(t), wx.requestPayment({
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
                                    url: "entry/wxapp/BuyOK",
                                    cachetime: "0",
                                    data: {
                                        openid: e,
                                        id: n
                                    },
                                    success: function(t) {
                                        console.log(t);
                                    }
                                });
                            },
                            fail: function(t) {}
                        });
                    }
                });
            }
        });
    },
    onReady: function() {},
    onShow: function() {
        var a = this;
        app.util.request({
            url: "entry/wxapp/SystemVip",
            cachetime: "0",
            success: function(t) {
                console.log(t), a.setData({
                    is_vipcardopen: t.data.data.price
                });
            }
        }), app.util.request({
            url: "entry/wxapp/VipList",
            cachetime: "30",
            success: function(t) {
                console.log(t), a.setData({
                    viplist: t.data
                });
            }
        }), wx.getStorage({
            key: "openid",
            success: function(t) {
                console.log(t);
                var e = t.data;
                app.util.request({
                    url: "entry/wxapp/VipcardNum",
                    cachetime: "0",
                    data: {
                        openid: e
                    },
                    success: function(t) {
                        console.log(t), a.setData({
                            card_number: t.data.data
                        });
                    }
                });
            }
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {}
});