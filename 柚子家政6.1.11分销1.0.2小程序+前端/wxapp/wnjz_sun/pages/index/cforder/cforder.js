function _defineProperty(t, e, a) {
    return e in t ? Object.defineProperty(t, e, {
        value: a,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : t[e] = a, t;
}

var tool = require("../../../../style/utils/tools.js"), app = getApp();

Page({
    data: {
        navTile: "确认订单",
        order: [],
        price: "48.80",
        oldprice: "600",
        num: "3",
        curprice: "0",
        cardprice: "0",
        totalPrice: "",
        showStatus: !1,
        choose: [ {
            name: "微信",
            value: "微信支付",
            icon: "../../../../style/images/wx.png"
        }, {
            name: "余额",
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
        multiIndex: [ 0, 0 ]
    },
    onLoad: function(t) {
        var e = this;
        wx.setNavigationBarTitle({
            title: e.data.navTile
        });
        var a = e.data.price;
        console.log(a);
        var i = (a * e.data.num).toFixed(2);
        e.setData({
            id: t.id,
            price: t.price,
            totalPrice: i
        });
        var n = tool.formatTime(new Date());
        e.setData({
            multiArray: n
        });
        e = this;
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
        wx.getStorageSync("openid");
        var t = this.data.id;
        console.log(t);
        var e = this;
        app.util.request({
            url: "entry/wxapp/confiim",
            data: {
                id: t
            },
            success: function(t) {
                console.log(t), e.setData({
                    order: t.data
                });
            }
        }), app.util.request({
            url: "entry/wxapp/url",
            cachetime: "0",
            success: function(t) {
                wx.setStorageSync("url", t.data), e.setData({
                    url: t.data
                });
            }
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    bindMultiPickerColumnChange: function(t) {
        var e = {
            multiArray: this.data.multiArray,
            multiIndex: this.data.multiIndex
        };
        console.log(t), e.multiIndex[t.detail.column] = t.detail.value, this.setData(e);
    },
    showDrawer: function(t) {
        var e = t.currentTarget.dataset.statu;
        this.utils(e);
    },
    utils: function(t) {
        var e = wx.createAnimation({
            duration: 200,
            timingFunction: "linear",
            delay: 0
        });
        (this.animation = e).opacity(0).height(0).step(), this.setData({
            animationshowData: e.export()
        }), setTimeout(function() {
            e.opacity(1).height("500rpx").step(), this.setData({
                animationshowData: e
            }), "close" == t && this.setData({
                showStatus: !1
            });
        }.bind(this), 200), "open" == t && this.setData({
            showStatus: !0
        });
    },
    radioChange: function(t) {
        console.log(t);
        var e = t.detail.value;
        this.setData({
            rstatus: e
        });
    },
    messageinput: function(t) {
        console.log(t.detail.value), this.setData({
            message: t.detail.value
        });
    },
    formSubmit: function(t) {
        var e = this, i = (e.data.connect, e.data.rstatus, e.data.rstatus), n = wx.getStorageSync("openid"), o = t.detail.value.price, s = t.detail.value.text, r = t.detail.value.id, l = t.detail.value.time, c = t.detail.value.name, u = t.detail.value.tel, d = t.detail.value.count, p = t.detail.value.city, m = t.detail.value.detai, g = t.detail.value.province, a = e.data.rstatus;
        console.log(r), console.log(l), c ? a ? "微信" == i ? app.util.request({
            url: "entry/wxapp/Orderarr",
            data: {
                price: o,
                openid: n
            },
            success: function(a) {
                console.log(a), app.util.request({
                    url: "entry/wxapp/Addkanjiaorder",
                    data: {
                        price: o,
                        id: r,
                        text: s,
                        time: l,
                        cityName: p,
                        detailInfo: m,
                        telNumber: u,
                        countyName: d,
                        name: c,
                        pays: i,
                        openid: n,
                        provinceName: g,
                        buy_type: 1
                    },
                    success: function(t) {
                        console.log(t);
                        var e = t.data;
                        wx.requestPayment({
                            timeStamp: a.data.timeStamp,
                            nonceStr: a.data.nonceStr,
                            package: a.data.package,
                            signType: "MD5",
                            paySign: a.data.paySign,
                            success: function(t) {
                                wx.showToast({
                                    title: "支付成功",
                                    icon: "success",
                                    duration: 2e3
                                }), app.util.request({
                                    url: "entry/wxapp/PaykjOrder",
                                    cachetime: "0",
                                    data: {
                                        order_id: e
                                    },
                                    success: function(t) {
                                        wx.switchTab({
                                            url: "../index"
                                        });
                                    }
                                });
                            },
                            fail: function(t) {}
                        });
                    }
                });
            }
        }) : (console.log("------------------余额付款---------------------"), app.util.request({
            url: "entry/wxapp/kjlocal",
            data: {
                price: o,
                openid: n
            },
            success: function(t) {
                var e;
                (console.log(t), 2 == t.data.status) ? wx.showToast({
                    title: "余额不足，请充值！",
                    icon: "none"
                }) : app.util.request({
                    url: "entry/wxapp/Addkanjiaorder",
                    data: (e = {
                        price: o,
                        id: r,
                        text: s,
                        time: l,
                        cityName: p,
                        detailInfo: m,
                        telNumber: u,
                        countyName: d,
                        name: c
                    }, _defineProperty(e, "text", s), _defineProperty(e, "pays", i), _defineProperty(e, "openid", n), 
                    _defineProperty(e, "provinceName", g), _defineProperty(e, "buy_type", 1), e),
                    success: function(t) {
                        console.log(t.data);
                        var e = t.data;
                        wx.showToast({
                            title: "支付成功！",
                            icon: "success"
                        }), app.util.request({
                            url: "entry/wxapp/PaykjOrder",
                            cachetime: "0",
                            data: {
                                order_id: e
                            },
                            success: function(t) {
                                wx.switchTab({
                                    url: "../index"
                                });
                            }
                        });
                    }
                });
            }
        })) : (console.log("请选择付款方式"), wx.showToast({
            title: "请选择付款方式",
            icon: "none"
        })) : wx.showToast({
            title: "请选择服务地址！",
            icon: "none"
        });
    },
    toAddress: function() {
        var e = this;
        wx.chooseAddress({
            success: function(t) {
                console.log(t), e.setData({
                    address: t,
                    hasAddress: !0
                });
            },
            fail: function(t) {
                console.log("获取地址失败");
            }
        });
    },
    bindMultiPickerChange: function(t) {
        this.setData({
            multiIndex: t.detail.value
        });
    }
});