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
        state: 0,
        currentTab: 0,
        processData: []
    },
    swichNav: function(t) {
        if (this.data.currentTab === t.currentTarget.dataset.current) return !1;
        this.setData({
            currentTab: t.currentTarget.dataset.current
        });
    },
    swiperChange: function(t) {
        this.setData({
            currentTab: t.detail.current
        });
    },
    onPullDownRefresh: function() {
        this.getvipgrade(), wx.stopPullDownRefresh();
    },
    onLoad: function(t) {
        var a = this;
        wx.setNavigationBarTitle({
            title: "会员权益"
        });
        var e = 0;
        t.fxsid && (e = t.fxsid, a.setData({
            fxsid: t.fxsid
        })), a.getBase(), app.util.getUserInfo(a.getinfos, e);
    },
    getinfos: function() {
        var a = this;
        wx.getStorage({
            key: "openid",
            success: function(t) {
                a.setData({
                    openid: t.data
                }), a.getvipgrade();
            }
        });
    },
    getvipgrade: function() {
        var r = this;
        app.util.request({
            url: "entry/wxapp/getvipgrade",
            data: {
                openid: wx.getStorageSync("openid")
            },
            success: function(t) {
                for (var a = t.data.data.vip, e = t.data.data.userinfo.grade, n = 0, o = 0; o < a.length; o++) e == a[o].grade && (n = o);
                r.setData({
                    currentTab: n,
                    processData: a,
                    grade: e,
                    vipid: t.data.data.userinfo.vipid,
                    usermoney: t.data.data.userinfo.money ? t.data.data.userinfo.money : 0
                });
            }
        });
    },
    getBase: function() {
        var a = this;
        app.util.request({
            url: "entry/wxapp/BaseMin",
            cachetime: "30",
            data: {
                vs1: 1
            },
            success: function(t) {
                a.setData({
                    baseinfo: t.data.data
                }), wx.setNavigationBarColor({
                    frontColor: a.data.baseinfo.base_tcolor,
                    backgroundColor: a.data.baseinfo.base_color
                });
            },
            fail: function(t) {}
        });
    },
    open_grade: function(t) {
        var n = this, a = t.currentTarget.dataset.grade, o = t.currentTarget.dataset.price, e = n.data.usermoney, r = 0, s = 0;
        o <= e ? r = o : s = o - (r = e);
        var i = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/viporder",
            data: _defineProperty({
                openid: i,
                ordermoeny: o,
                yuemoney: r,
                money: s,
                open_grade: a
            }, "open_grade", a),
            header: {
                "content-type": "application/json"
            },
            success: function(t) {
                var a = t.data.data;
                if (0 < a) if (0 == s) wx.showModal({
                    title: "请注意",
                    content: "您将使用余额支付" + r + "元",
                    success: function(t) {
                        t.confirm && (n.payover_do(a), wx.showLoading({
                            title: "下单中...",
                            mask: !0
                        }));
                    }
                }); else {
                    var e = wx.getStorageSync("openid");
                    app.util.request({
                        url: "entry/wxapp/beforepay",
                        data: {
                            openid: e,
                            price: o,
                            order_id: a,
                            types: "vipgrade",
                            formId: n.data.formId
                        },
                        header: {
                            "content-type": "application/json"
                        },
                        success: function(t) {
                            1 == t.data.data.errs && wx.showModal({
                                title: "支付失败",
                                content: t.data.data.return_msg,
                                showCancel: !1
                            });
                            -1 != [ 1, 2, 3, 4 ].indexOf(t.data.data.err) && wx.showModal({
                                title: "支付失败",
                                content: t.data.data.message,
                                showCancel: !1
                            }), 0 == t.data.data.err && wx.requestPayment({
                                timeStamp: t.data.data.timeStamp,
                                nonceStr: t.data.data.nonceStr,
                                package: t.data.data.package,
                                signType: "MD5",
                                paySign: t.data.data.paySign,
                                success: function(t) {
                                    wx.showToast({
                                        title: "支付成功",
                                        icon: "success",
                                        mask: !0,
                                        duration: 3e3,
                                        success: function(t) {
                                            wx.showToast({
                                                title: "购买成功！",
                                                icon: "success",
                                                success: function() {
                                                    n.getvipgrade();
                                                }
                                            });
                                        }
                                    });
                                },
                                fail: function(t) {},
                                complete: function(t) {}
                            });
                        }
                    });
                } else wx.showModal({
                    title: "提示",
                    content: "生成订单失败",
                    showCancel: !1
                });
            }
        });
    },
    payover_do: function(t, a) {
        var e = this, n = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/paynotify",
            data: {
                out_trade_no: t,
                openid: n,
                types: "vipgrade",
                open_grade: a
            },
            success: function(t) {
                "失败" == t.data.data.message ? wx.showToast({
                    title: "付款失败, 请刷新后重新付款！",
                    icon: "none",
                    mask: !0,
                    success: function() {}
                }) : wx.showToast({
                    title: "购买成功！",
                    icon: "success",
                    mask: !0,
                    success: function() {
                        e.getvipgrade();
                    }
                });
            }
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {}
});