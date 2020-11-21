var common = require("../common/common.js"), app = getApp();

function wxpay(t, a) {
    t.appId;
    var e = t.timeStamp.toString(), o = t.package, n = t.nonceStr, r = t.paySign.toUpperCase(), s = t.out_trade_no;
    wx.requestPayment({
        timeStamp: e,
        nonceStr: n,
        package: o,
        signType: "MD5",
        paySign: r,
        success: function(t) {
            var e = setInterval(function() {
                app.util.request({
                    url: "entry/wxapp/check",
                    showLoading: !1,
                    data: {
                        out_trade_no: s
                    },
                    success: function(t) {
                        var a = t.data;
                        "" != a.data && 1 == a.data.status && (clearInterval(e), wx.showToast({
                            title: "支付成功",
                            icon: "success",
                            duration: 2e3
                        }), setTimeout(function() {
                            wx.reLaunch({
                                url: "../plant_order/order"
                            });
                        }, 2e3));
                    }
                });
            }, 1e3);
        }
    });
}

Page({
    data: {
        o_amount: 0,
        ticketCurr: 0,
        showTicket: !1
    },
    input: function(t) {
        this.setData({
            content: t.detail.value
        });
    },
    showTicket: function() {
        this.setData({
            showTicket: !0
        });
    },
    tchoice: function(t) {
        var a = t.currentTarget.id;
        this.setData({
            ticketCurr: a,
            showTicket: !1
        }), this.get_sum();
    },
    submit: function(t) {
        var e = this, a = {
            land: e.data.land,
            seed: e.data.seed,
            member: e.data.member,
            form_id: t.detail.formId
        };
        "" != e.data.content && null != e.data.content && (a.content = e.data.content), 
        "" != e.data.group && null != e.data.group && (a.group = e.data.group), 0 < e.data.ticketCurr && (a.coupon = xc.coupon[e.data.ticketCurr - 1].id), 
        app.util.request({
            url: "entry/wxapp/orderPlant",
            method: "POST",
            data: a,
            success: function(t) {
                var a = t.data;
                "" != a.data && (1 == a.data.status ? "" != a.data.errno && null != a.data.errno ? wx.showModal({
                    title: "错误",
                    content: a.data.message,
                    showCancel: !1
                }) : wxpay(a.data, e) : 2 == a.data.status && (wx.showToast({
                    title: "支付成功",
                    icon: "success",
                    duration: 2e3
                }), setTimeout(function() {
                    wx.reLaunch({
                        url: "../plant_order/order"
                    });
                }, 2e3)));
            }
        });
    },
    onLoad: function(t) {
        var e = this;
        common.config(e), e.setData({
            land: t.land,
            seed: t.seed,
            member: t.member
        }), "" != t.group && null != t.group && e.setData({
            group: t.group
        }), app.util.request({
            url: "entry/wxapp/order",
            showLoading: !1,
            method: "POST",
            data: {
                op: "order_plant",
                land: e.data.land,
                seed: e.data.seed,
                member: e.data.member
            },
            success: function(t) {
                var a = t.data;
                "" != a.data && (e.setData({
                    xc: a.data
                }), e.get_sum());
            }
        });
    },
    onReady: function() {},
    onShow: function() {
        var e = this;
        app.util.request({
            url: "entry/wxapp/order",
            method: "POST",
            data: {
                op: "order_address"
            },
            success: function(t) {
                var a = t.data;
                "" != a.data && e.setData({
                    address: a.data
                });
            }
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {
        wx.stopPullDownRefresh();
    },
    onReachBottom: function() {},
    get_sum: function() {
        var t = this, a = 0, e = t.data.xc.amount;
        a = 0 < t.data.ticketCurr ? (parseFloat(e) - parseFloat(t.data.xc.coupon[t.data.ticketCurr - 1].price)).toFixed(2) : e, 
        t.setData({
            o_amount: a
        });
    }
});