var app = getApp();

Page({
    data: {
        putForward: "",
        paymoney: "0",
        navTile: "线下买单",
        index: 0,
        viptype: 0,
        choose: [ {
            name: "微信支付",
            value: "1",
            icon: "/style/images/wx.png",
            checked: "checked"
        } ],
        paytype: "1",
        mode: [ {
            name: "八折",
            coupon: "8",
            mode: "1"
        } ],
        check: !0,
        rules: "<p>这是规则</p><p>这是规则</p><p>这是规则</p><p>这是规则</p>",
        isShow: !0,
        is_modal_Hidden: !0,
        storeinfo: []
    },
    onLoad: function(e) {
        var t = this;
        wx.setNavigationBarTitle({
            title: t.data.navTile
        });
        var o = app.getSiteUrl();
        t.setData({
            url: o,
            options: e
        }), wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("System").fontcolor,
            backgroundColor: wx.getStorageSync("System").color,
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        }), app.wxauthSetting();
        var a = e.bid;
        console.log("商家信息bid"), console.log(a), a ? app.util.request({
            url: "entry/wxapp/GetStoreInfo",
            cachetime: "30",
            data: {
                bid: a
            },
            success: function(e) {
                console.log("获取店铺数据"), console.log(e.data), t.setData({
                    storeinfo: e.data
                }), t.GetVip();
            }
        }) : wx.redirectTo({
            url: "/mzhk_sun/pages/backstage/backstage"
        }), app.util.request({
            url: "entry/wxapp/System",
            cachetime: "30",
            showLoading: !1,
            success: function(e) {
                console.log(e.data);
                var o = t.data.choose;
                if (1 == e.data.isopen_recharge) {
                    o = o.concat([ {
                        name: "余额支付",
                        value: "2",
                        icon: "/style/images/yuelogo.png",
                        checked: ""
                    } ]);
                }
                console.log(o), t.setData({
                    choose: o
                });
            }
        });
    },
    GetVip: function() {
        var o = this, e = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/ISVIP",
            data: {
                openid: e
            },
            success: function(e) {
                console.log("获取vip数据"), console.log(e), o.setData({
                    viptype: e.data.viptype
                });
            }
        });
    },
    onReady: function() {},
    onShow: function() {
        app.func.islogin(app, this), this.GetVip();
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    toggleRule: function(e) {
        this.setData({
            isShow: !this.data.isShow
        });
    },
    enterMmoney: function(e) {
        var o, t = this, a = t.data.storeinfo, n = e.detail.value;
        o = 0 <= n ? 0 < a.memdiscount ? (n * a.memdiscount / 10).toFixed(2) : (100 * n / 100).toFixed(2) : "0.00", 
        t.data.viptype <= 0 && (o = (100 * n / 100).toFixed(2)), console.log("扫码金额等"), console.log(n), 
        console.log(a.memdiscount), console.log(o), t.setData({
            paymoney: o,
            putForward: n
        });
    },
    toMember: function(e) {
        wx.navigateTo({
            url: "../../member/member"
        });
    },
    formSubmit: function(e) {
        var i = this;
        app.util.request({
            url: "entry/wxapp/Payment",
            cachetime: "0",
            showLoading: !1,
            data: {
                bid: i.options.bid
            },
            success: function(e) {
                if (console.log(e.data), 2 == e.data) return wx.showModal({
                    title: "提示",
                    content: "商家未开启线下付",
                    showCancel: !1
                }), wx.redirectTo({
                    url: "/mzhk_sun/pages/user/user"
                }), !1;
                var o = i.data.putForward, t = i.data.paymoney, a = i.data.paytype;
                i.data.check;
                if (o <= 0) return wx.showModal({
                    title: "提示",
                    content: "请输入正确的金额",
                    showCancel: !1
                }), !1;
                if ("" == a) return wx.showModal({
                    title: "提示",
                    content: "请选择支付方式",
                    showCancel: !1
                }), !1;
                if (t < 1) return wx.showModal({
                    title: "提示",
                    content: "实际支付金额必须大于1元",
                    showCancel: !1
                }), !1;
                var n = wx.getStorageSync("openid");
                1 == a ? app.util.request({
                    url: "entry/wxapp/Orderarr",
                    data: {
                        openid: n,
                        price: t,
                        paytype: 2,
                        bid: i.options.bid
                    },
                    success: function(e) {
                        console.log(9999), console.log(e.data), wx.requestPayment({
                            timeStamp: e.data.timeStamp,
                            nonceStr: e.data.nonceStr,
                            package: e.data.package,
                            signType: e.data.signType,
                            paySign: e.data.paySign,
                            success: function(e) {
                                console.log("支付成功"), app.util.request({
                                    url: "entry/wxapp/PayOffline",
                                    cachetime: "0",
                                    data: {
                                        bid: i.options.bid,
                                        price: t
                                    },
                                    success: function(e) {
                                        console.log("成功"), wx.showModal({
                                            title: "提示",
                                            content: "支付成功",
                                            showCancel: !1,
                                            success: function(e) {
                                                wx.redirectTo({
                                                    url: "/mzhk_sun/pages/user/user"
                                                });
                                            }
                                        });
                                    },
                                    fail: function(e) {
                                        console.log("shibai"), console.log(r);
                                    }
                                });
                            },
                            fail: function(e) {
                                wx.showToast({
                                    title: "支付失败",
                                    icon: "none",
                                    duration: 2e3
                                });
                            }
                        });
                    }
                }) : 2 == a && app.util.request({
                    url: "entry/wxapp/OrderarrYue",
                    data: {
                        openid: n,
                        price: t,
                        paytypes: 2,
                        bid: i.options.bid
                    },
                    success: function(e) {
                        console.log("成功"), wx.showModal({
                            title: "提示",
                            content: "支付成功",
                            showCancel: !1,
                            success: function(e) {
                                wx.redirectTo({
                                    url: "/mzhk_sun/pages/user/user"
                                });
                            }
                        });
                    },
                    fail: function(e) {
                        wx.showToast({
                            title: "支付失败",
                            icon: "none",
                            duration: 2e3
                        });
                    }
                });
            }
        });
    },
    updateUserInfo: function(e) {
        console.log("授权操作更新");
        app.wxauthSetting();
    },
    radioChange: function(e) {
        var o = e.detail.value;
        console.log(o), this.setData({
            paytype: o
        });
    }
});