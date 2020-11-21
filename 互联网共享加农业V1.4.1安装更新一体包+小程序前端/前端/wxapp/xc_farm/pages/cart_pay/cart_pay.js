var common = require("../common/common.js"), app = getApp();

function wxpay(t, a) {
    t.appId;
    var e = t.timeStamp.toString(), r = t.package, o = t.nonceStr, d = t.paySign.toUpperCase(), n = t.out_trade_no;
    wx.requestPayment({
        timeStamp: e,
        nonceStr: o,
        package: r,
        signType: "MD5",
        paySign: d,
        success: function(t) {
            var e = setInterval(function() {
                app.util.request({
                    url: "entry/wxapp/check",
                    showLoading: !1,
                    data: {
                        out_trade_no: n
                    },
                    success: function(t) {
                        var a = t.data;
                        "" != a.data && 1 == a.data.status && (clearInterval(e), wx.showToast({
                            title: "支付成功",
                            icon: "success",
                            duration: 2e3
                        }), setTimeout(function() {
                            2 == a.order_type ? wx.reLaunch({
                                url: "../order_tgdetail/order_tgdetail?&id=" + a.order
                            }) : wx.reLaunch({
                                url: "../order/order"
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
        var r = this, a = r.data.xc;
        common.is_bind(function() {
            if ("" != a.address && null != a.address) {
                var e = {
                    address: JSON.stringify(a.address),
                    form_id: t.detail.formId,
                    order_type: r.data.order_type
                };
                "" != r.data.content && null != r.data.content && (e.content = r.data.content), 
                0 < r.data.ticketCurr && (e.coupon = a.coupon[r.data.ticketCurr - 1].id), "" != r.data.id && null != r.data.id ? (e.id = r.data.id, 
                e.format_index = r.data.format_index, e.member = r.data.member) : "" != r.data.card && null != r.data.card ? e.card = r.data.card : e.services = JSON.stringify(a.service), 
                "" != r.data.group && null != r.data.group && (e.group = r.data.group), "" != a.topic && null != a.topic && (e.topic = a.topic), 
                app.util.request({
                    url: "entry/wxapp/setorder",
                    method: "POST",
                    data: e,
                    success: function(t) {
                        var a = t.data;
                        "" != a.data && (a.data.order_type = e.order_type, 1 == a.data.status ? "" != a.data.errno && null != a.data.errno ? wx.showModal({
                            title: "错误",
                            content: a.data.message,
                            showCancel: !1
                        }) : wxpay(a.data, r) : 2 == a.data.status && (wx.showToast({
                            title: "支付成功",
                            icon: "success",
                            duration: 2e3
                        }), setTimeout(function() {
                            2 == a.data.order_type ? wx.reLaunch({
                                url: "../order_tgdetail/order_tgdetail?&id=" + a.data.order
                            }) : wx.reLaunch({
                                url: "../order/order"
                            });
                        }, 2e3)));
                    }
                });
            } else wx.showModal({
                title: "错误",
                content: "请选择地址"
            });
        });
    },
    onLoad: function(t) {
        var a = this;
        common.config(a), a.setData({
            order_type: t.order_type
        }), "" != t.id && null != t.id && a.setData({
            id: t.id,
            format_index: t.format_index,
            member: t.member
        }), "" != t.card && null != t.card && a.setData({
            card: t.card
        }), "" != t.group && null != t.group && a.setData({
            group: t.group
        }), "" != t.topic && null != t.topic && a.setData({
            topic: t.topic
        });
    },
    onShow: function() {
        var e = this, t = {
            op: "porder",
            order_type: e.data.order_type
        };
        "" != e.data.id && null != e.data.id && (t.id = e.data.id, t.format_index = e.data.format_index, 
        t.member = e.data.member), "" != e.data.card && null != e.data.card && (t.card = e.data.card), 
        "" != e.data.topic && null != e.data.topic && (t.topic = e.data.topic), app.util.request({
            url: "entry/wxapp/order",
            method: "POST",
            data: t,
            success: function(t) {
                var a = t.data;
                "" != a.data && (e.setData({
                    xc: a.data
                }), e.get_sum());
            }
        });
    },
    onPullDownRefresh: function() {
        wx.stopPullDownRefresh();
    },
    get_sum: function() {
        var t = this, a = 0, e = t.data.xc.amount;
        a = 0 < t.data.ticketCurr ? (parseFloat(e) - parseFloat(t.data.xc.coupon[t.data.ticketCurr - 1].price)).toFixed(2) : e, 
        t.setData({
            o_amount: a
        });
    }
});