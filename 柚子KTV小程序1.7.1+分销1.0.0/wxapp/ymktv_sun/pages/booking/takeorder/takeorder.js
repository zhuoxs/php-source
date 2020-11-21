var app = getApp(), Page = require("../../../../zhy/sdk/qitui/oddpush.js").oddPush(Page).Page;

Page({
    data: {},
    onLoad: function(a) {
        var e = this;
        wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("fontcolor"),
            backgroundColor: wx.getStorageSync("color"),
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        }), e.url(), console.log(a);
        var t = a.id, n = a.price;
        app.util.request({
            url: "entry/wxapp/kangoodid",
            cachetime: "0",
            data: {
                id: t,
                price: n
            },
            success: function(a) {
                console.log(a.data), e.setData({
                    goodsData: a.data,
                    price: n
                });
            }
        }), app.util.request({
            url: "entry/wxapp/system",
            cachetime: "0",
            success: function(a) {
                e.setData({
                    shop: a.data
                });
            }
        });
    },
    url: function(a) {
        var e = this;
        app.util.request({
            url: "entry/wxapp/Url2",
            cachetime: "0",
            success: function(a) {
                wx.setStorageSync("url2", a.data);
            }
        }), app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "0",
            success: function(a) {
                wx.setStorageSync("url", a.data), e.setData({
                    url: a.data
                });
            }
        });
    },
    bindSave: function(a) {
        var e = this, n = wx.getStorageSync("bid"), o = a.detail.value;
        if ("" != o.mobile) {
            var i = e.data.goodsData.id, c = e.data.price, r = e.data.goodsData.integral;
            wx.getStorage({
                key: "openid",
                success: function(a) {
                    var t = a.data;
                    app.util.request({
                        url: "entry/wxapp/Orderarr",
                        cachetime: "30",
                        data: {
                            openid: t,
                            price: c
                        },
                        success: function(a) {
                            wx.requestPayment({
                                timeStamp: a.data.timeStamp,
                                nonceStr: a.data.nonceStr,
                                package: a.data.package,
                                signType: "MD5",
                                paySign: a.data.paySign,
                                success: function(a) {
                                    wx.getStorage({
                                        key: "openid",
                                        success: function(e) {
                                            app.util.request({
                                                url: "entry/wxapp/kanjiaorder",
                                                cachetime: "0",
                                                data: {
                                                    id: i,
                                                    openid: t,
                                                    price: c,
                                                    remark: o.remark,
                                                    mobile: o.mobile,
                                                    integral: r,
                                                    bid: n
                                                },
                                                success: function(a) {
                                                    console.log(e.data), 1 == a.data && wx.redirectTo({
                                                        url: "../../my/myreduce/myreduce"
                                                    });
                                                }
                                            });
                                        }
                                    });
                                },
                                fail: function(a) {}
                            });
                        }
                    });
                }
            });
        } else wx.showModal({
            title: "提示",
            content: "请输入您的联系方式！",
            showCancel: !1
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {}
});