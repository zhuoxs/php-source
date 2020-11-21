var app = getApp();

Page({
    data: {
        navTile: "提交订单",
        shopPic: "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152351792032.png",
        cart: {},
        goods: [],
        times: "24小时内",
        address: "厦门市集美区杏林湾路",
        contact: "13000000",
        totalprice: "0",
        cardprice: "0",
        curprice: "0",
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
        choose: [ {
            name: "微信",
            value: "微信支付",
            icon: "../../../../style/images/wx.png"
        }, {
            name: "余额",
            value: "余额支付",
            icon: "../../../../style/images/local.png"
        } ],
        payStatus: 0,
        payType: "",
        coupon_id: 0,
        discount: 10,
        isPay: 0,
        isIpx: app.globalData.isIpx
    },
    onLoad: function(t) {
        var a = this;
        wx.setNavigationBarTitle({
            title: a.data.navTile
        }), app.get_imgroot().then(function(t) {
            a.setData({
                imgroot: t
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
    onShow: function() {
        var i = this, o = app.offline_cart_get();
        app.get_user_coupons().then(function(t) {
            var a = t, e = [];
            for (var n in a) parseFloat(a[n].use_amount) <= parseFloat(o.amount) && e.push(a[n]);
            app.get_store_info().then(function(t) {
                i.setData({
                    cart: o,
                    store: t,
                    cards: e
                }), i.totalPrice();
            });
        }), app.get_user_info().then(function(t) {
            i.setData({
                user: t
            });
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    powerDrawer: function(t) {
        var a = t.currentTarget.dataset.statu;
        1 == this.data.discountType && this.util(a);
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
            a.opacity(1).height("550rpx").step(), this.setData({
                animationData: a
            }), "close" == t && this.setData({
                showModalStatus: !1
            });
        }.bind(this), 200), "open" == t && this.setData({
            showModalStatus: !0
        });
    },
    coupon: function(t) {
        var a = this, e = t.currentTarget.dataset.price, n = t.currentTarget.dataset.index;
        a.data.curprice;
        a.setData({
            cardprice: e,
            coupon_id: a.data.cards[n].id
        }), a.totalPrice(), a.util("close");
    },
    showPay: function(t) {
        var a = t.currentTarget.dataset.statu;
        this.setData({
            payStatus: a
        });
    },
    payChange: function(t) {
        var a = t.detail.value;
        console.log(a), this.setData({
            payType: a
        });
    },
    radioChange: function(t) {
        var a = t.detail.value;
        this.setData({
            discountType: a,
            cardprice: 0
        }), this.totalPrice();
    },
    formSubmit: function(t) {
        var a = !0, e = "", n = this, i = n.data.payType;
        "" == i ? e = "请选择支付方式" : a = "false", 1 != a ? (n.setData({
            isPay: ++n.data.isPay
        }), 1 == n.data.isPay ? app.pay(n.data.curprice, i).then(function() {
            n.paysuccess({
                amount: n.data.cart.amount,
                pay_amount: n.data.curprice,
                pay_type: i
            }), wx.showModal({
                title: "提示",
                content: "支付成功",
                cancelText: "回首页",
                confirmText: "查看订单",
                confirmColor: "#ff640f",
                success: function(t) {
                    t.confirm ? wx.redirectTo({
                        url: "/yzhyk_sun/pages/user/scanorder/scanorder"
                    }) : wx.reLaunch({
                        url: "/yzhyk_sun/pages/index/index"
                    });
                }
            });
        }) : wx.showToast({
            title: "正在支付中...",
            icon: "none"
        })) : wx.showModal({
            title: "提示",
            content: e,
            showCancel: !1
        });
    },
    totalPrice: function(t) {
        var a = this, e = a.data.cardprice, n = a.data.cart.amount, i = a.data.discount, o = a.data.discountType || 0, s = parseFloat(n);
        1 == o ? s = n - e : 2 == o && (s = n * parseFloat(i) / 10), s <= 0 && (s = 0), 
        e = (n - (s = s.toFixed(2))).toFixed(2), a.setData({
            curprice: s,
            cardprice: e
        });
    },
    paysuccess: function(t) {
        app.util.request({
            url: "entry/wxapp/AddOrderScan",
            cachetime: "0",
            method: "post",
            data: {
                user_id: this.data.user.id,
                store_id: this.data.store.id,
                amount: t.amount,
                pay_amount: t.pay_amount,
                pay_type: t.pay_type,
                goodses: this.data.cart.goodses,
                coupon_id: this.data.coupon_id
            },
            success: function(t) {
                app.offline_cart_clear(), app.get_user_info(!1), app.get_user_coupons(!1);
            }
        });
    },
    toMember: function(t) {
        wx.redirectTo({
            url: "/yzhyk_sun/pages/index/member/member"
        });
    }
});