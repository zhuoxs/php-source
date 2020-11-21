var app = getApp();

Page({
    data: {
        totalprice: 0,
        discountType: "",
        curprice: 0,
        cardprice: 0,
        couponid: 0,
        money: 0,
        cards: 0,
        orders: [],
        choose: [ {
            name: "1",
            value: "微信支付",
            icon: "../../../../style/images/wx.png"
        }, {
            name: "2",
            value: "余额支付",
            icon: "../../../../style/images/local.png"
        } ],
        ispay: !0,
        showModalStatus: !1,
        showStatus: !1,
        curorder: [ {
            status: "1",
            style: "洗剪吹",
            stylist: "托尼",
            works: "首席发型师",
            curtime: "周二 01月23号 10：30"
        }, {
            status: "1",
            style: "洗剪吹",
            stylist: "墨纸",
            works: "首席发型师",
            curtime: "周二 01月23号 10：30"
        } ],
        rstatus: ""
    },
    onLoad: function(t) {
        var a = this;
        wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("fontcolor"),
            backgroundColor: wx.getStorageSync("color"),
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        });
        var e = wx.getStorageSync("build_id");
        wx.getStorage({
            key: "openid",
            success: function(t) {
                app.util.request({
                    url: "entry/wxapp/Paycoupon",
                    cachetime: "0",
                    data: {
                        uid: t.data,
                        build_id: e
                    },
                    success: function(t) {
                        console.log(t.data), a.setData({
                            cards: t.data.data
                        });
                    }
                }), app.util.request({
                    url: "entry/wxapp/SeleOrder",
                    cachetime: "0",
                    data: {
                        uid: t.data,
                        build_id: e
                    },
                    success: function(t) {
                        console.log(t.data.data), a.setData({
                            curorder: t.data.data
                        });
                    }
                }), app.util.request({
                    url: "entry/wxapp/vipDiscounts",
                    cachetime: "0",
                    data: {
                        openid: t.data
                    },
                    success: function(t) {
                        console.log(t.data), a.setData({
                            discount: t.data.dis,
                            discounted: t.data.discount
                        });
                    }
                });
            }
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    totalprice: function(t) {
        var a = this, e = t.detail.value;
        a.data.curprice, a.data.cardprice, a.data.couponid, a.data.money, a.data.orders;
        if (0 < e) var i = e; else i = 0;
        a.setData({
            curprice: i,
            totalprice: e,
            cardprice: 0,
            couponid: 0,
            money: 0,
            orders: []
        });
    },
    coupon: function(t) {
        var a = this, e = parseFloat(t.currentTarget.dataset.bprice), i = parseFloat(t.currentTarget.dataset.cprice), o = parseFloat(a.data.totalprice), s = parseFloat(a.data.money), n = t.currentTarget.dataset.id, c = (a.data.couponid, 
        a.data.curprice);
        if (e <= o) {
            var r = o - i - s;
            a.setData({
                curprice: r,
                cardprice: i,
                couponid: n
            });
        } else c < e && (wx.showModal({
            title: "提示",
            content: "不满足使用条件",
            showCancel: !1
        }), a.setData({
            curprice: c
        }));
        a.util("close");
    },
    Choiceorder: function(t) {
        var i = this, a = t.currentTarget.dataset.id, o = i.data.totalprice, s = (i.data.curprice, 
        i.data.cardprice);
        i.data.couponid, i.data.money, i.data.orders;
        wx.getStorage({
            key: "openid",
            success: function(t) {
                app.util.request({
                    url: "entry/wxapp/OrderId",
                    cachetime: "0",
                    data: {
                        uid: t.data,
                        id: a
                    },
                    success: function(t) {
                        var a = i.data.curprice, e = parseFloat(t.data.data.money);
                        if (e <= o) {
                            a = o - e - s;
                            i.setData({
                                money: e,
                                curprice: a,
                                orders: t.data.data
                            });
                        } else wx.showModal({
                            title: "提示",
                            content: "不需要补差价",
                            showCancel: !1
                        }), i.setData({
                            curprice: a,
                            cardprice: 0,
                            couponid: 0,
                            money: 0,
                            orders: []
                        });
                        i.utils("close");
                    }
                });
            }
        });
    },
    powerDrawer: function(t) {
        var a = t.currentTarget.dataset.statu;
        this.util(a);
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
    showDrawer: function(t) {
        var a = t.currentTarget.dataset.statu;
        this.utils(a);
    },
    utils: function(t) {
        var a = wx.createAnimation({
            duration: 200,
            timingFunction: "linear",
            delay: 0
        });
        (this.animation = a).opacity(0).height(0).step(), this.setData({
            animationshowData: a.export()
        }), setTimeout(function() {
            a.opacity(1).height(300).step(), this.setData({
                animationshowData: a
            }), "close" == t && this.setData({
                showStatus: !1
            });
        }.bind(this), 200), "open" == t && this.setData({
            showStatus: !0
        });
    },
    radioChange: function(t) {
        console.log(t);
        this.data.discountType;
        this.setData({
            discountType: t.detail.value
        });
    },
    radioChange1: function(t) {
        var a = t.detail.value, e = this.data.money;
        if (console.log(a), 2 == a) var i = this.data.totalprice * this.data.discount / 10 - e;
        this.setData({
            curprice: i,
            rstatus: a
        });
    },
    formSubmit: function(t) {
        console.log(t);
        var e = this, a = e.data.discountType;
        if (2 == e.data.rstatus) var i = 0; else if (t.detail.target.dataset.coupon_id) i = t.detail.target.dataset.coupon_id; else i = 0;
        var o = wx.getStorageSync("build_id"), s = t.detail.value.paymoney, n = "", c = !0;
        if (e.data.orders) var r = e.data.orders.id; else r = "";
        s <= 0 ? n = "输入金额需大于0" : "" == a ? n = "请选择支付方式" : c = "false", 1 == c && wx.showModal({
            title: "提示",
            content: n,
            showCancel: !1
        });
        var d = e.data.curprice;
        if (console.log(d), 1 == a && 0 < s) {
            var u = t.detail.target.dataset.id;
            u = u && s >= e.data.cardb ? u : "", wx.getStorage({
                key: "openid",
                success: function(t) {
                    var a = t.data;
                    app.util.request({
                        url: "entry/wxapp/Orderarr",
                        cachetime: "30",
                        data: {
                            openid: a,
                            price: d
                        },
                        success: function(t) {
                            console.log(t), wx.requestPayment({
                                timeStamp: t.data.timeStamp,
                                nonceStr: t.data.nonceStr,
                                package: t.data.package,
                                signType: "MD5",
                                paySign: t.data.paySign,
                                success: function(t) {
                                    app.util.request({
                                        url: "entry/wxapp/RemoveOrder",
                                        cachetime: "0",
                                        data: {
                                            uid: a,
                                            oid: r,
                                            user_cid: i,
                                            price: d,
                                            build_id: o
                                        },
                                        success: function(t) {
                                            t && (wx.showModal({
                                                title: "提示",
                                                content: "支付成功",
                                                showCancel: !1,
                                                success: function(t) {
                                                    t.confirm && wx.reLaunch({
                                                        url: "../index"
                                                    });
                                                }
                                            }), e.setData({
                                                ispay: !0
                                            }));
                                        }
                                    });
                                },
                                fail: function(t) {
                                    e.setData({
                                        ispay: !0
                                    });
                                }
                            });
                        }
                    });
                }
            });
        }
        2 == a && 0 < s && wx.getStorage({
            key: "openid",
            success: function(t) {
                app.util.request({
                    url: "entry/wxapp/Balance",
                    cachetime: "0",
                    data: {
                        openid: t.data,
                        price: d,
                        oid: r,
                        user_cid: i,
                        build_id: o
                    },
                    success: function(t) {
                        console.log(t.data), e.setData({
                            ispay: !0
                        }), 1 == t.data.data ? wx.showModal({
                            title: "提示",
                            content: "支付成功",
                            showCancel: !1,
                            success: function(t) {
                                t.confirm && wx.reLaunch({
                                    url: "../index"
                                });
                            }
                        }) : wx.showModal({
                            title: "提示",
                            content: "余额不足",
                            showCancel: !1
                        });
                    }
                });
            }
        });
    }
});