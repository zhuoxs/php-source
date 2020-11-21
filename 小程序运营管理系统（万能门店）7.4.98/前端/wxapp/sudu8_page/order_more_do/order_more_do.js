var app = getApp();

Page({
    data: {
        order: "",
        comment: "",
        dikou_jf: 0,
        dikou_jf_val: 0,
        true_price: 0,
        kouk: 0
    },
    onPullDownRefresh: function() {
        this.getinfos(), wx.stopPullDownRefresh();
    },
    onLoad: function(a) {
        var o = this;
        o.setData({
            isIphoneX: app.globalData.isIphoneX
        }), wx.setNavigationBarTitle({
            title: "支付订单"
        });
        var t = a.orderid, e = a.dkmoney, r = a.dkscore, n = a.yunfei;
        this.setData({
            order: t,
            dkmoney: e,
            dkscore: r,
            yf: n,
            types: a.types ? a.types : ""
        });
        var d = 0;
        a.fxsid && (d = a.fxsid, o.setData({
            fxsid: a.fxsid
        })), app.util.request({
            url: "entry/wxapp/BaseMin",
            data: {
                vs1: 1
            },
            success: function(a) {
                if (a.data.data.video) var t = "show";
                if (a.data.data.c_b_bg) var e = "bg";
                o.setData({
                    baseinfo: a.data.data,
                    show_v: t,
                    c_b_bg1: e
                }), wx.setNavigationBarTitle({
                    title: o.data.baseinfo.name
                }), wx.setNavigationBarColor({
                    frontColor: o.data.baseinfo.base_tcolor,
                    backgroundColor: o.data.baseinfo.base_color
                }), 1 == a.data.data.form_index && o.indexForm();
            },
            fail: function(a) {}
        }), app.util.getUserInfo(o.getinfos, d);
    },
    redirectto: function(a) {
        var t = a.currentTarget.dataset.link, e = a.currentTarget.dataset.linktype;
        app.util.redirectto(t, e);
    },
    getinfos: function() {
        var e = this;
        wx.getStorage({
            key: "openid",
            success: function(a) {
                var t = a.data;
                e.setData({
                    openid: t
                }), e.getOrder();
            }
        });
    },
    getOrder: function() {
        var r = this, a = r.data.order, t = wx.getStorageSync("openid"), n = r.data.true_price, d = r.data.kouk;
        app.util.request({
            url: "entry/wxapp/duoorderget",
            data: {
                order: a,
                openid: t
            },
            header: {
                "content-type": "application/json"
            },
            success: function(a) {
                var t = a.data.data, e = t.mymoney, o = t.price;
                1 * e < 1 * o ? (n = Math.floor(100 * (o - e)) / 100, d = 1) : (n = o, d = 0), r.setData({
                    comment: a.data.data,
                    kouk: d,
                    true_price: n,
                    mymoney: e,
                    couponid: t.coupon
                });
            }
        });
    },
    goback: function() {
        wx.navigateBack();
    },
    pay1: function(e) {
        var o = this;
        wx.showModal({
            title: "请注意",
            content: "您将使用余额支付" + o.data.true_price + "元",
            success: function(a) {
                if (a.confirm) {
                    var t = o.data.order;
                    o.setData({
                        formId: e.detail.formId
                    }), o.payover_do(t);
                }
            }
        });
    },
    pay3: function(a) {
        var t = this, e = wx.getStorageSync("openid"), o = t.data.true_price, r = t.data.order;
        t.setData({
            formId: a.detail.formId
        }), app.util.request({
            url: "entry/wxapp/beforepay",
            data: {
                openid: e,
                price: o,
                order_id: r,
                types: t.data.types,
                formId: a.detail.formId
            },
            header: {
                "content-type": "application/json"
            },
            success: function(a) {
                -1 != [ 1, 2, 3, 4 ].indexOf(a.data.data.err) && wx.showModal({
                    title: "支付失败",
                    content: a.data.data.message,
                    showCancel: !1
                }), 0 == a.data.data.err && wx.requestPayment({
                    timeStamp: a.data.data.timeStamp,
                    nonceStr: a.data.data.nonceStr,
                    package: a.data.data.package,
                    signType: "MD5",
                    paySign: a.data.data.paySign,
                    success: function(a) {
                        wx.showToast({
                            title: "支付成功",
                            icon: "success",
                            duration: 3e3,
                            success: function(a) {
                                wx.navigateBack({
                                    delta: 9
                                }), wx.navigateTo({
                                    url: "/sudu8_page/order_more_list/order_more_list"
                                });
                            }
                        });
                    },
                    fail: function(a) {},
                    complete: function(a) {}
                });
            }
        });
    },
    payover_do: function(a) {
        var t = this, e = (t.data.comment, wx.getStorageSync("openid")), o = (t.data.kouk, 
        t.data.mymoney, t.data.true_price);
        t.data.couponid, t.data.order, t.data.dkscore, t.data.mymoney, t.data.true_price, 
        wx.getStorageSync("fxsid");
        app.util.request({
            url: "entry/wxapp/paynotify",
            data: {
                out_trade_no: a,
                openid: e,
                payprice: o,
                types: "duo",
                flag: 0,
                formId: t.data.formId
            },
            success: function(a) {
                wx.navigateBack({
                    delta: 9
                }), wx.navigateTo({
                    url: "/sudu8_page/order_more_list/order_more_list"
                });
            }
        });
    },
    sendMail_order: function(a) {
        app.util.request({
            url: "entry/wxapp/sendMail_order_gwc",
            data: {
                order_id: a
            },
            success: function(a) {},
            fail: function(a) {}
        });
    }
});