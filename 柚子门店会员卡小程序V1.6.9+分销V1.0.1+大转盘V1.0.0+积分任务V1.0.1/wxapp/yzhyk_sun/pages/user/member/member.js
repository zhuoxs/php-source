var _slicedToArray = function(t, e) {
    if (Array.isArray(t)) return t;
    if (Symbol.iterator in Object(t)) return function(t, e) {
        var n = [], a = !0, o = !1, i = void 0;
        try {
            for (var u, s = t[Symbol.iterator](); !(a = (u = s.next()).done) && (n.push(u.value), 
            !e || n.length !== e); a = !0) ;
        } catch (t) {
            o = !0, i = t;
        } finally {
            try {
                !a && s.return && s.return();
            } finally {
                if (o) throw i;
            }
        }
        return n;
    }(t, e);
    throw new TypeError("Invalid attempt to destructure non-iterable instance");
}, app = getApp();

Page({
    data: {
        navTile: "会员",
        bgLogo: "../../../../style/images/icon6.png",
        bgCards: "../../../../style/images/bgCards.png"
    },
    onLoad: function(t) {
        wx.setNavigationBarTitle({
            title: this.data.navTile
        });
    },
    onReady: function() {},
    onShow: function() {
        var i = this;
        app.full_setting(), Promise.all([ app.api.get_user_info(), app.get_card_info(), app.get_card_price() ]).then(function(t) {
            var e = _slicedToArray(t, 3), n = e[0], a = e[1], o = e[2];
            console.log(t), i.setData({
                user: n,
                card: a,
                leave: o,
                leftamount: a.next_amount - n.amount,
                left: n.amount / a.next_amount * 100
            });
        });
    },
    buyleave: function(t) {
        var a = this, o = t.currentTarget.dataset.id, i = t.currentTarget.dataset.amount, e = t.currentTarget.dataset.name, u = t.currentTarget.dataset.price, n = a.data.setting.member_charge;
        wx.showModal({
            title: "提示",
            content: "是否购买会员等级：" + e,
            success: function(t) {
                t.confirm ? 1 == n ? app.get_user_info().then(function(t) {
                    var e = t.id, n = t.openid;
                    null == t.end_time ? wx.showToast({
                        title: "非会员无法购买！",
                        icon: "none",
                        duration: 2e3,
                        success: function() {}
                    }) : 0 < u ? app.util.request({
                        url: "entry/wxapp/Orderarr",
                        data: {
                            openid: n,
                            price: u
                        },
                        success: function(t) {
                            wx.requestPayment({
                                timeStamp: t.data.timeStamp,
                                nonceStr: t.data.nonceStr,
                                package: t.data.package,
                                signType: "MD5",
                                paySign: t.data.paySign,
                                success: function(t) {
                                    app.util.request({
                                        url: "entry/wxapp/buyleave",
                                        data: {
                                            user_id: e,
                                            level_id: o,
                                            amount: i
                                        },
                                        success: function(t) {
                                            1 == t.data && wx.showToast({
                                                title: "购买成功！",
                                                icon: "success",
                                                duration: 2e3,
                                                success: function() {
                                                    setTimeout(function() {
                                                        a.onShow();
                                                    }, 1e3);
                                                }
                                            });
                                        }
                                    });
                                },
                                fail: function(t) {
                                    wx.showToast({
                                        title: "支付失败",
                                        icon: "none",
                                        duration: 2e3
                                    });
                                }
                            });
                        }
                    }) : app.util.request({
                        url: "entry/wxapp/buyleave",
                        data: {
                            user_id: e,
                            level_id: o,
                            amount: i
                        },
                        success: function(t) {
                            1 == t.data && wx.showToast({
                                title: "购买成功！",
                                icon: "success",
                                duration: 2e3,
                                success: function() {
                                    setTimeout(function() {
                                        a.onShow();
                                    }, 1e3);
                                }
                            });
                        }
                    });
                }) : 0 < u ? app.get_user_info().then(function(t) {
                    var e = t.id, n = t.openid;
                    app.util.request({
                        url: "entry/wxapp/Orderarr",
                        data: {
                            openid: n,
                            price: u
                        },
                        success: function(t) {
                            wx.requestPayment({
                                timeStamp: t.data.timeStamp,
                                nonceStr: t.data.nonceStr,
                                package: t.data.package,
                                signType: "MD5",
                                paySign: t.data.paySign,
                                success: function(t) {
                                    app.util.request({
                                        url: "entry/wxapp/buyleave",
                                        data: {
                                            user_id: e,
                                            level_id: o,
                                            amount: i
                                        },
                                        success: function(t) {
                                            1 == t.data && wx.showToast({
                                                title: "购买成功！",
                                                icon: "success",
                                                duration: 2e3,
                                                success: function() {
                                                    setTimeout(function() {
                                                        a.onShow();
                                                    }, 1e3);
                                                }
                                            });
                                        }
                                    });
                                },
                                fail: function(t) {
                                    wx.showToast({
                                        title: "支付失败",
                                        icon: "none",
                                        duration: 2e3
                                    });
                                }
                            });
                        }
                    });
                }) : app.get_user_info().then(function(t) {
                    var e = t.id;
                    app.util.request({
                        url: "entry/wxapp/buyleave",
                        data: {
                            user_id: e,
                            level_id: o,
                            amount: i
                        },
                        success: function(t) {
                            1 == t.data && wx.showToast({
                                title: "购买成功！",
                                icon: "success",
                                duration: 2e3,
                                success: function() {
                                    setTimeout(function() {
                                        a.onShow();
                                    }, 1e3);
                                }
                            });
                        }
                    });
                }) : t.cancel && console.log("用户点击取消");
            }
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    toMybill: function(t) {
        wx.navigateTo({
            url: "../mybill/mybill"
        });
    }
});