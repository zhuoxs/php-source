function _defineProperty(t, a, e) {
    return a in t ? Object.defineProperty(t, a, {
        value: e,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : t[a] = e, t;
}

var app = getApp();

Page({
    data: {
        navTile: "活动报名",
        goods: {},
        baby: {},
        totalPrice: 0,
        cardPrice: 0,
        showModalStatus: !1,
        cards: [],
        goodsNum: 1,
        price: 0,
        cardmprice: 0,
        cardId: "",
        isRequest: 0,
        isIpx: app.globalData.isIpx
    },
    onLoad: function(t) {
        var o = this;
        wx.setNavigationBarTitle({
            title: o.data.navTile
        }), o.setData({
            activity_id: t.id
        });
        var a = wx.getStorageSync("setting");
        a ? wx.setNavigationBarColor({
            frontColor: a.fontcolor,
            backgroundColor: a.color
        }) : app.get_setting(!0).then(function(t) {
            wx.setNavigationBarColor({
                frontColor: t.fontcolor,
                backgroundColor: t.color
            });
        }), app.get_imgroot().then(function(t) {
            o.setData({
                imgroot: t
            });
        }), app.util.request({
            url: "entry/wxapp/getActivityDetail",
            cachetime: "0",
            data: {
                id: t.id
            },
            success: function(a) {
                var e = 0;
                app.get_user_vip().then(function(t) {
                    e = 1 == t ? a.data.qzk_price : a.data.common_price, o.setData({
                        goods: a.data,
                        price: e
                    }), o.totalPrice();
                });
            }
        });
    },
    onReady: function() {},
    onShow: function() {
        var t = wx.getStorageSync("baby") || {};
        this.setData({
            baby: t
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    formSubmit: function(t) {
        var e = this, o = t.detail.formId, i = t.detail.value.uname, n = t.detail.value.phone, a = "", c = !0, r = e.data.goods, s = e.data.baby;
        if (null == s.id) a = "请选择宝宝"; else if ("" == i) a = "请输入您的姓名"; else if (/^1(3|4|5|7|8)\d{9}$/.test(n)) {
            if (c = "false", e.setData({
                isRequest: ++e.data.isRequest
            }), 1 != e.data.isRequest) return void wx.showToast({
                title: "正在请求中...",
                icon: "none"
            });
            1 == r.qzk_status ? app.get_openid().then(function(t) {
                var a;
                app.util.request({
                    url: "entry/wxapp/setOrder",
                    cachetime: "0",
                    data: (a = {
                        openid: t,
                        activity_id: r.id,
                        baby_id: s.id,
                        name: i,
                        phone: n
                    }, _defineProperty(a, "baby_id", s.id), _defineProperty(a, "formId", o), a),
                    success: function(t) {
                        console.log(t.data), wx.showModal({
                            title: "",
                            content: "领取成功",
                            showCancel: !1,
                            confirmText: "去活动页",
                            success: function(t) {
                                wx.navigateBack({});
                            }
                        });
                    },
                    fail: function(t) {
                        wx.showModal({
                            title: "提示",
                            content: t.data.message,
                            showCancel: !1,
                            success: function(t) {
                                wx.navigateBack({});
                            }
                        });
                    },
                    complete: function() {
                        e.setData({
                            isRequest: 0
                        });
                    }
                });
            }) : (console.log(e.data.goodsNum), app.get_openid().then(function(t) {
                var a;
                app.util.request({
                    url: "entry/wxapp/setOrder",
                    cachetime: "0",
                    data: (a = {
                        openid: t,
                        activity_id: r.id,
                        baby_id: s.id,
                        name: i,
                        phone: n
                    }, _defineProperty(a, "baby_id", s.id), _defineProperty(a, "num", e.data.goodsNum), 
                    _defineProperty(a, "coupon_id", e.data.cardId), _defineProperty(a, "formId", o), 
                    a),
                    success: function(t) {
                        console.log(t.data), app.util.request({
                            url: "entry/wxapp/getPayParam",
                            cachetime: "0",
                            data: {
                                order_id: t.data
                            },
                            success: function(t) {
                                wx.requestPayment({
                                    timeStamp: t.data.timeStamp,
                                    nonceStr: t.data.nonceStr,
                                    package: t.data.package,
                                    signType: "MD5",
                                    paySign: t.data.paySign,
                                    success: function(t) {
                                        wx.showModal({
                                            title: "提示",
                                            content: "支付成功",
                                            cancelText: "去首页",
                                            confirmText: "去订单页",
                                            confirmColor: "#ff5e5e",
                                            success: function(t) {
                                                t.confirm ? wx.redirectTo({
                                                    url: "/yzqzk_sun/pages/user/myorder/myorder"
                                                }) : wx.reLaunch({
                                                    url: "/yzqzk_sun/pages/index/index"
                                                });
                                            }
                                        });
                                    },
                                    fail: function(t) {
                                        wx.showModal({
                                            title: "提示",
                                            content: "支付失败",
                                            confirmText: "去首页",
                                            confirmColor: "#ff5e5e",
                                            success: function(t) {
                                                t.confirm && wx.reLaunch({
                                                    url: "/yzqzk_sun/pages/index/index"
                                                });
                                            }
                                        });
                                    }
                                });
                            }
                        });
                    },
                    fail: function(t) {
                        wx.showModal({
                            title: "提示",
                            content: t.data.message,
                            showCancel: !1,
                            success: function(t) {
                                wx.navigateBack({});
                            }
                        });
                    },
                    complete: function() {
                        e.setData({
                            isRequest: 0
                        });
                    }
                });
            }));
        } else a = "请正确输入手机号码";
        1 == c && wx.showModal({
            title: "提示",
            content: a,
            showCancel: !1
        });
    },
    reduce: function(t) {
        var a = this.data.goodsNum;
        a <= 1 ? a = 1 : a--, this.setData({
            goodsNum: a
        }), this.totalPrice();
    },
    add: function(t) {
        var a = this.data.goodsNum;
        a++, this.setData({
            goodsNum: a
        }), this.totalPrice();
    },
    coupon: function(t) {
        var a = t.currentTarget.dataset.price, e = t.currentTarget.dataset.id, o = t.currentTarget.dataset.mprice;
        this.setData({
            cardPrice: a,
            cardId: e,
            cardmprice: o
        }), this.totalPrice(), this.util("close");
    },
    totalPrice: function() {
        var t = this, a = t.data.price, e = t.data.cardPrice, o = t.data.goodsNum, i = o * a, n = 0;
        t.data.cardmprice <= i ? n = o * a - e : (t.setData({
            cardId: 0,
            cardPrice: 0
        }), n = i), n <= 0 && (n = 0), t.setData({
            totalPrice: n.toFixed(2),
            totalPricegood: i.toFixed(2)
        });
    },
    get_coupon: function() {
        var a = this;
        app.get_openid().then(function(t) {
            app.util.request({
                url: "entry/wxapp/getUserCoupon",
                cachetime: "0",
                data: {
                    openid: t,
                    m_price: a.data.totalPricegood,
                    store_id: a.data.goods.store.id
                },
                success: function(t) {
                    a.setData({
                        cards: t.data.data
                    });
                }
            });
        });
    },
    powerDrawer: function(t) {
        var a = t.currentTarget.dataset.statu;
        "open" == a && this.get_coupon(), this.util(a);
    },
    util: function(t) {
        var a = wx.createAnimation({
            duration: 200,
            timingFunction: "linear",
            delay: 0
        });
        (this.animation = a).opacity(0).height(0).step(), this.setData({
            animationData: a.export()
        }), setTimeout(function() {
            a.opacity(1).height(300).step(), this.setData({
                animationData: a
            }), "close" == t && this.setData({
                showModalStatus: !1
            });
        }.bind(this), 200), "open" == t && this.setData({
            showModalStatus: !0
        });
    },
    toBaby: function(t) {
        wx.navigateTo({
            url: "../../user/baby/baby?isback=1"
        });
    }
});