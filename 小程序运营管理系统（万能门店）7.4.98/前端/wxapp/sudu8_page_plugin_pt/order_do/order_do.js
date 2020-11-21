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
        var t = this;
        t.setData({
            isIphoneX: app.globalData.isIphoneX
        });
        var e = a.shareid;
        t.setData({
            shareid: e
        }), wx.setNavigationBarTitle({
            title: "支付订单"
        });
        var r = a.orderid, o = a.dkmoney, d = a.dkscore, i = a.yunfei, n = app.util.url("entry/wxapp/BaseMin", {
            m: "sudu8_page"
        });
        wx.request({
            url: n,
            data: {
                vs1: 1
            },
            success: function(a) {
                t.setData({
                    baseinfo: a.data.data
                }), wx.setNavigationBarColor({
                    frontColor: t.data.baseinfo.base_tcolor,
                    backgroundColor: t.data.baseinfo.base_color
                });
            },
            fail: function(a) {}
        }), t.setData({
            order: r,
            dkmoney: o,
            dkscore: d,
            yf: i
        }), t.getOrder();
        var s = 0;
        a.fxsid && (s = a.fxsid, t.setData({
            fxsid: a.fxsid
        })), app.util.getUserInfo(t.getinfos, s);
    },
    redirectto: function(a) {
        var t = a.currentTarget.dataset.link, e = a.currentTarget.dataset.linktype;
        app.util.redirectto(t, e);
    },
    getinfos: function() {
        var t = this;
        wx.getStorage({
            key: "openid",
            success: function(a) {
                t.setData({
                    openid: a.data
                });
            }
        });
    },
    getOrder: function() {
        var o = this, a = o.data.order, t = wx.getStorageSync("openid"), d = o.data.true_price, i = o.data.kouk, e = app.util.url("entry/wxapp/duoorderget", {
            m: "sudu8_page_plugin_pt"
        });
        wx.request({
            url: e,
            data: {
                order: a,
                openid: t
            },
            header: {
                "content-type": "application/json"
            },
            success: function(a) {
                var t = a.data.data, e = t.mymoney, r = t.price;
                1 * e < 1 * r ? (d = (r - e).toFixed(2), i = 1) : (d = r, i = 0), o.setData({
                    comment: a.data.data,
                    kouk: i,
                    true_price: d,
                    mymoney: e,
                    couponid: t.coupon
                });
            }
        });
    },
    goback: function() {
        wx.navigateBack();
    },
    pay1: function(a) {
        var t = this, e = t.data.order;
        t.setData({
            formId: a.detail.formId
        }), t.payover_do(e);
    },
    pay3: function(a) {
        var t = this, e = wx.getStorageSync("openid"), r = t.data.true_price, o = t.data.order;
        t.setData({
            formId: a.detail.formId
        }), app.util.request({
            url: "entry/wxapp/weixinpay",
            data: {
                openid: e,
                price: r,
                order_id: o
            },
            header: {
                "content-type": "application/json"
            },
            success: function(a) {
                "success" == a.data.message && wx.requestPayment({
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
                                t.payover_do(o);
                            }
                        });
                    },
                    fail: function(a) {},
                    complete: function(a) {}
                }), "error" == a.data.message && wx.showModal({
                    title: "提醒",
                    content: a.data.data.message,
                    showCancel: !1
                });
            }
        });
    },
    payover_do: function(t) {
        var e = this, a = (e.data.comment, wx.getStorageSync("openid")), r = e.data.kouk, o = e.data.mymoney, d = e.data.true_price, i = e.data.couponid, n = (e.data.order, 
        e.data.shareid), s = e.data.dkscore;
        e.data.mymoney, e.data.true_price;
        if (0 == r) var u = d;
        if (1 == r) u = o;
        app.util.request({
            url: "entry/wxapp/duoorderchange",
            data: {
                order_id: t,
                openid: a,
                true_price: u,
                dkscore: s,
                couponid: i,
                shareid: n,
                formid: e.data.formId
            },
            success: function(a) {
                e.sendMail_order(t), 0 == a.data.data ? wx.redirectTo({
                    url: "/sudu8_page_plugin_pt/orderlist/orderlist"
                }) : wx.redirectTo({
                    url: "/sudu8_page_plugin_pt/pt/pt?shareid=" + a.data.data
                });
            }
        });
    },
    sendMail_order: function(a) {
        var t = app.util.url("entry/wxapp/sendMail_order", {
            m: "sudu8_page_plugin_pt"
        });
        app.util.request({
            url: t,
            data: {
                order_id: a
            },
            success: function(a) {},
            fail: function(a) {}
        });
    },
    onShareAppMessage: function() {
        return {
            title: "支付订单"
        };
    }
});