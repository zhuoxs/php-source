var common = require("../common/common.js"), app = getApp();

function wxpay(t, a) {
    t.appId;
    var e = t.timeStamp.toString(), o = t.package, n = t.nonceStr, r = t.paySign.toUpperCase(), i = t.out_trade_no;
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
                        out_trade_no: i
                    },
                    success: function(t) {
                        var a = t.data;
                        "" != a.data && 1 == a.data.status && (clearInterval(e), wx.showToast({
                            title: "支付成功",
                            icon: "success",
                            duration: 2e3
                        }), setTimeout(function() {
                            wx.reLaunch({
                                url: "../pin_order/index"
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
            id: e.data.id,
            group: e.data.group,
            group_detail: e.data.group_detail,
            form_id: t.detail.formId
        };
        "" != e.data.content && null != e.data.content && (a.content = e.data.content), 
        0 < e.data.ticketCurr && (a.coupon = xc.coupon[e.data.ticketCurr - 1].id), app.util.request({
            url: "entry/wxapp/orderPin",
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
                        url: "../pin_order/index"
                    });
                }, 2e3)));
            }
        });
    },
    onLoad: function(t) {
        var e = this;
        common.config(e), e.setData({
            id: t.id,
            group: t.group,
            group_detail: t.group_detail
        }), app.util.request({
            url: "entry/wxapp/order",
            showLoading: !1,
            method: "POST",
            data: {
                op: "order_pin",
                id: e.data.id,
                group: e.data.group,
                group_detail: e.data.group_detail
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