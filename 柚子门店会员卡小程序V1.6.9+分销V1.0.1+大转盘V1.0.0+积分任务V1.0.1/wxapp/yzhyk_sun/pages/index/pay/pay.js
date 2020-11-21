var app = getApp();

Page({
    data: {
        navTile: "线上买单",
        totalprice: "0",
        cardprice: "",
        curprice: "0",
        enterprice: "",
        choose: [ {
            name: "微信",
            value: "微信支付",
            icon: "../../../../style/images/wx.png"
        }, {
            name: "余额",
            value: "余额支付",
            icon: "../../../../style/images/local.png"
        } ],
        showModalStatus: !1,
        cards: [ {
            price: "30",
            minprice: "398",
            time: "2018.01.12-2018.02.12"
        }, {
            price: "10",
            minprice: "398",
            time: "2018.01.12-2018.02.12"
        } ],
        rstatus: "",
        currentStoreName: "门店",
        discount: 10
    },
    onLoad: function(t) {
        var a = this;
        wx.setNavigationBarTitle({
            title: a.data.navTile
        }), app.get_user_coupons().then(function(t) {
            var e = t;
            a.setData({
                cards: e
            });
        }), app.get_store_info().then(function(t) {
            a.setData({
                currentStoreID: t.id,
                currentStoreName: t.name
            });
        }), app.get_card_info().then(function(t) {
            a.setData({
                discount: t && t.discount ? t.discount : 10
            });
        }), app.get_setting().then(function(t) {
            a.setData({
                setting: t
            });
        }), app.get_user_info().then(function(t) {
            a.setData({
                user: t
            });
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    totalprice: function() {
        var t = this.data.enterprice;
        console.log(t);
        var e = this.data.cardprice || 0, a = this.data.discount, n = this.data.discountType || 0, i = parseFloat(t || 0);
        1 == n ? i = t - parseFloat(e) : 2 == n && (i = t * a / 10), i < 0 && (i = 0), this.setData({
            totalprice: t,
            curprice: i.toFixed(2)
        });
    },
    coupon: function(t) {
        var e = t.currentTarget.dataset.price, a = t.currentTarget.dataset.coupon_id;
        this.setData({
            cardprice: e,
            coupon_id: a
        }), this.util("close"), this.totalprice();
    },
    enterMoney: function(t) {
        var e = t.detail.value, a = this.data.oldvalue, n = e.split(".");
        n[1] && 2 < n[1].length && (e = a), this.setData({
            enterprice: e,
            cardprice: 0,
            oldvalue: e
        }), this.totalprice();
    },
    powerDrawer: function(t) {
        var e = t.currentTarget.dataset.statu;
        1 == this.data.discountType && this.util(e);
    },
    util: function(t) {
        var e = wx.createAnimation({
            duration: 200,
            timingFunction: "linear",
            delay: 0
        });
        (this.animation = e).opacity(0).height(0).step(), this.setData({
            animationData: e.export()
        }), setTimeout(function() {
            e.opacity(1).height(300).step(), this.setData({
                animationData: e
            }), "close" == t && this.setData({
                showModalStatus: !1
            });
        }.bind(this), 200), "open" == t && this.setData({
            showModalStatus: !0
        });
    },
    payChange: function(t) {
        var e = t.detail.value;
        this.setData({
            rstatus: e
        });
    },
    radioChange: function(t) {
        var e = t.detail.value;
        this.setData({
            discountType: e,
            cardprice: 0,
            coupon_id: null
        }), this.totalprice();
    },
    formSubmit: function(t) {
        var a = t.detail.value.paymoney, n = this, i = n.data.rstatus, o = n.data.coupon_id, e = "", s = !0, c = t.detail.formId;
        a <= 0 ? e = "输入金额需大于0" : "" == i ? e = "请选择支付方式" : s = "false", 1 != s ? ("the formId is a mock one" != c && app.getFormid(c), 
        app.get_store_info().then(function(e) {
            app.get_user_info().then(function(t) {
                app.util.request({
                    url: "entry/wxapp/AddOrderOnline",
                    cachetime: "0",
                    data: {
                        user_id: t.id,
                        store_id: e.id,
                        amount: a,
                        pay_amount: n.data.curprice,
                        pay_type: i,
                        coupon_id: o
                    },
                    success: function(t) {
                        if (console.log(0 != t.data.code), 0 != t.data.code) console.log(t.data.msg), wx.showModal({
                            title: "提示",
                            content: t.data.msg
                        }); else {
                            var e = function() {
                                wx.showModal({
                                    title: "提示",
                                    content: "支付成功",
                                    cancelText: "回首页",
                                    confirmText: "查看账单",
                                    confirmColor: "#ff640f",
                                    success: function(t) {
                                        t.confirm ? wx.redirectTo({
                                            url: "/yzhyk_sun/pages/user/mybill/mybill"
                                        }) : wx.reLaunch({
                                            url: "/yzhyk_sun/pages/index/index"
                                        });
                                    }
                                }), app.get_user_info(!1), app.get_user_coupons(!1);
                            };
                            console.log(i), "微信" == i ? app.wx_requestPayment(t.data.paydata).then(function(t) {
                                e();
                            }) : e();
                        }
                    }
                });
            });
        })) : wx.showModal({
            title: "提示",
            content: e,
            showCancel: !1
        });
    },
    toMember: function(t) {
        wx.navigateTo({
            url: "../member/member"
        });
    }
});