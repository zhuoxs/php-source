function _defineProperty(e, t, a) {
    return t in e ? Object.defineProperty(e, t, {
        value: a,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : e[t] = a, e;
}

var tool = require("../../../../style/utils/tools.js"), app = getApp();

Page({
    data: {
        order: [],
        url: [],
        hasAddress: !1,
        address: [],
        curprice: "0",
        cardprice: "0",
        totalPrice: "",
        showStatus: !1,
        choose: [ {
            name: "weixin",
            value: "微信支付",
            icon: "../../../../style/images/wx.png"
        }, {
            name: "local",
            value: "余额支付",
            icon: "../../../../style/images/local.png"
        } ],
        connect: [ {
            uname: "陈少勇",
            phoneNum: "13000000000",
            address: "福建省厦门市集美区杏林街道"
        } ],
        rstatus: "",
        multiArray: [],
        multiIndex: [ 0, 0 ],
        orderid: "",
        isIpx: app.globalData.isIpx
    },
    onLoad: function(t) {
        var a = this;
        console.log(t), wx.setNavigationBarTitle({
            title: a.data.navTile
        });
        var e = tool.formatTime(new Date());
        a.setData({
            multiArray: e
        });
        a = this, wx.getStorageSync("openid");
        wx.setStorageSync("kjid", t.id), wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("fontcolor"),
            backgroundColor: wx.getStorageSync("color"),
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        }), app.util.request({
            url: "entry/wxapp/bargainInfo",
            cachetime: "30",
            data: {
                id: t.id
            },
            success: function(e) {
                console.log(e), a.setData({
                    bargainInfo: e.data,
                    price: t.price
                });
            }
        });
    },
    onReady: function() {},
    onShow: function() {
        var e = wx.getStorageSync("openid"), t = wx.getStorageSync("kjid"), a = this;
        app.util.request({
            url: "entry/wxapp/isBuyKjgoods",
            cachetime: "0",
            data: {
                openid: e,
                id: t
            },
            success: function(e) {
                a.setData({
                    isBuy: e.data
                });
            }
        }), a.getUrl();
    },
    getUrl: function() {
        var t = this;
        app.util.request({
            url: "entry/wxapp/url",
            cachetime: "0",
            success: function(e) {
                wx.setStorageSync("url", e.data), t.setData({
                    url: e.data
                });
            }
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    bindMultiPickerColumnChange: function(e) {
        var t = {
            multiArray: this.data.multiArray,
            multiIndex: this.data.multiIndex
        };
        t.multiIndex[e.detail.column] = e.detail.value, this.setData(t);
    },
    showDrawer: function(e) {
        var t = e.currentTarget.dataset.statu;
        this.utils(t);
    },
    utils: function(t) {
        var a = this, n = wx.createAnimation({
            duration: 200,
            timingFunction: "linear",
            delay: 0
        });
        (this.animation = n).opacity(0).height(0).step(), this.setData({
            animationshowData: n.export()
        }), setTimeout(function() {
            var e = a.data.isIpx ? "568rpx" : "500rpx";
            n.opacity(1).height(e).step(), this.setData({
                animationshowData: n
            }), "close" == t && this.setData({
                showStatus: !1
            });
        }.bind(this), 200), "open" == t && this.setData({
            showStatus: !0
        });
    },
    radioChange: function(e) {
        var t = e.detail.value;
        this.setData({
            rstatus: t
        });
    },
    message: function(e) {
        this.setData({
            message: e.detail.value
        });
    },
    formSubmit: function(e) {
        var t = this, a = "", n = (t.data.connect, t.data.rstatus, t.data.isBuy);
        console.log(n);
        var i, o = wx.getStorageSync("build_id"), s = t.data.rstatus, r = wx.getStorageSync("openid"), c = e.detail.value.price, l = e.detail.value.text, u = e.detail.value.id, d = e.detail.value.time, p = e.detail.value.name, g = e.detail.value.tel, f = e.detail.value.count, w = e.detail.value.city, h = e.detail.value.detai, m = e.detail.value.province;
        (console.log(s), 1 != n) ? p ? app.util.request({
            url: "entry/wxapp/Addkanjiaorder",
            data: (i = {
                price: c,
                id: u,
                text: l,
                time: d,
                cityName: w,
                detailInfo: h,
                telNumber: g,
                countyName: f,
                name: p
            }, _defineProperty(i, "text", l), _defineProperty(i, "pays", s), _defineProperty(i, "openid", r), 
            _defineProperty(i, "provinceName", m), _defineProperty(i, "buy_type", 2), _defineProperty(i, "build_id", o), 
            i),
            success: function(e) {
                console.log(e.data), a = e.data, console.log(a), "weixin" == s ? app.util.request({
                    url: "entry/wxapp/Orderarr",
                    data: {
                        price: c,
                        openid: r,
                        order_id: a,
                        type: 2
                    },
                    success: function(e) {
                        console.log(e), console.log(a);
                        e.data.package;
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
                                    url: "entry/wxapp/PaykjOrder",
                                    cachetime: "0",
                                    data: {
                                        order_id: a,
                                        paytype: 1
                                    },
                                    success: function(e) {
                                        wx.showModal({
                                            title: "提示",
                                            content: "订单已支付成功",
                                            cancelText: "去首页",
                                            confirmText: "查看订单",
                                            confirmColor: "#41c2fc",
                                            success: function(e) {
                                                e.cancel ? wx.reLaunch({
                                                    url: "/wnjz_sun/pages/index/index"
                                                }) : e.confirm && wx.navigateTo({
                                                    url: "/wnjz_sun/pages/user/bgorder/bgorder"
                                                });
                                            }
                                        });
                                    }
                                });
                            },
                            fail: function(e) {
                                t.onShow();
                            }
                        });
                    }
                }) : app.util.request({
                    url: "entry/wxapp/kjlocal",
                    data: {
                        price: c,
                        openid: r
                    },
                    success: function(e) {
                        console.log(e), 2 == e.data.status ? wx.showToast({
                            title: "余额不足，请充值或选择微信支付！",
                            icon: "none"
                        }) : (console.log(u), app.util.request({
                            url: "entry/wxapp/PaykjOrder",
                            cachetime: "0",
                            data: {
                                order_id: a,
                                paytype: 2
                            },
                            success: function(e) {
                                wx.showModal({
                                    title: "提示",
                                    content: "订单已支付成功",
                                    cancelText: "去首页",
                                    confirmText: "查看订单",
                                    confirmColor: "#41c2fc",
                                    success: function(e) {
                                        e.cancel ? wx.reLaunch({
                                            url: "/wnjz_sun/pages/index/index"
                                        }) : e.confirm && wx.navigateTo({
                                            url: "/wnjz_sun/pages/user/bgorder/bgorder"
                                        });
                                    }
                                });
                            }
                        }));
                    }
                });
            },
            fail: function(e) {
                wx.showModal({
                    title: "提示",
                    content: e.data.message,
                    showCancel: !1
                });
            }
        }) : wx.showToast({
            title: "请选择服务地址！",
            icon: "none"
        }) : wx.showToast({
            title: "已购买过该砍价商品！",
            icon: "none"
        });
    },
    toAddress: function() {
        var t = this;
        wx.chooseAddress({
            success: function(e) {
                console.log(e), console.log("获取地址成功"), t.setData({
                    address: e,
                    hasAddress: !0
                });
            },
            fail: function(e) {
                console.log("获取地址失败");
            }
        });
    },
    bindMultiPickerChange: function(e) {
        this.setData({
            multiIndex: e.detail.value
        });
    }
});