function t(t, a) {
    t.appId;
    var e = t.timeStamp.toString(), o = t.package, r = t.nonceStr, d = t.paySign.toUpperCase();
    t.out_trade_no;
    wx.requestPayment({
        timeStamp: e,
        nonceStr: r,
        package: o,
        signType: "MD5",
        paySign: d,
        success: function(a) {
            wx.showToast({
                title: "支付成功",
                icon: "success",
                duration: 2e3
            }), setTimeout(function() {
                "" != t.group_id && null != t.group_id ? wx.reLaunch({
                    url: "../order_detail/order_detail?&id=" + t.group_id
                }) : wx.redirectTo({
                    url: "../order/order"
                });
            }, 2e3);
        }
    });
}

var a = getApp(), e = require("../common/common.js");

Page({
    data: {
        amount: 0,
        o_amount: 0,
        ticketCurr: 0,
        showTicket: !1,
        pei_type: 1
    },
    pei_change: function(t) {
        var a = this, e = t.currentTarget.dataset.index;
        e != a.data.pei_type && (a.setData({
            pei_type: e
        }), a.get_sum());
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
        var a = this, e = t.currentTarget.id;
        a.setData({
            ticketCurr: e,
            showTicket: !1
        }), a.get_sum();
    },
    submit: function(e) {
        var o = this;
        if ("" != o.data.address && null != o.data.address) if ("" != o.data.store_id && null != o.data.store_id) {
            var r = {
                address: JSON.stringify(o.data.address),
                form_id: e.detail.formId,
                store: o.data.store_id
            };
            "" != o.data.content && null != o.data.content && (r.content = o.data.content), 
            o.data.ticketCurr > 0 && (r.coupon = o.data.list.coupon[o.data.ticketCurr - 1].id), 
            "" != o.data.group && null != o.data.group && (r.group = o.data.group), "" != o.data.group_id && null != o.data.group_id && (r.group_id = o.data.group_id), 
            r.id = o.data.id, r.format = o.data.format, r.member = o.data.member, r.pei_type = o.data.pei_type, 
            a.util.request({
                url: "entry/wxapp/mallorder",
                data: r,
                success: function(a) {
                    var e = a.data;
                    "" != e.data && (1 == e.data.status ? "" != e.data.errno && null != e.data.errno ? wx.showModal({
                        title: "错误",
                        content: e.data.message,
                        showCancel: !1
                    }) : t(e.data) : 2 == e.data.status && (wx.showToast({
                        title: "支付成功",
                        icon: "success",
                        duration: 2e3
                    }), setTimeout(function() {
                        "" != e.data.group_id && null != e.data.group_id ? wx.reLaunch({
                            url: "../order_detail/order_detail?&id=" + e.data.group_id
                        }) : wx.redirectTo({
                            url: "../order/order"
                        });
                    }, 2e3)));
                }
            });
        } else wx.showModal({
            title: "错误",
            content: "请选择提货校区"
        }); else wx.showModal({
            title: "错误",
            content: "请完善用户信息"
        });
    },
    store_on: function() {
        this.setData({
            store_page: !0
        });
    },
    store_close: function() {
        this.setData({
            store_page: !1
        });
    },
    store_choose: function(t) {
        var a = this, e = t.currentTarget.dataset.index, o = a.data.list.store;
        a.setData({
            store_page: !1,
            store_id: o[e].id,
            store_name: o[e].name
        });
    },
    onLoad: function(t) {
        var o = this;
        e.config(o), e.theme(o), o.setData({
            id: t.id,
            format: t.format,
            member: t.member
        });
        var r = {
            op: "mall_detail",
            id: t.id,
            format: t.format,
            member: t.member
        };
        "" != t.group && null != t.group && (r.group = t.group, o.setData({
            group: t.group
        })), "" != t.group_id && null != t.group_id && o.setData({
            group_id: t.group_id
        }), wx.getLocation({
            type: "wgs84",
            success: function(t) {
                var a = t.latitude, e = t.longitude;
                t.speed, t.accuracy;
                o.setData({
                    latitude: a,
                    longitude: e
                });
            },
            complete: function() {
                null != o.data.latitude && "" != o.data.latitude && (r.latitude = o.data.latitude), 
                null != o.data.longitude && "" != o.data.longitude && (r.longitude = o.data.longitude), 
                a.util.request({
                    url: "entry/wxapp/service",
                    data: r,
                    success: function(t) {
                        var a = t.data;
                        "" != a.data && (o.setData({
                            list: a.data
                        }), "" != a.data.store && null != a.data.store && o.setData({
                            store_id: a.data.store[0].id,
                            store_name: a.data.store[0].name
                        }), o.get_sum());
                    }
                });
            }
        });
    },
    onReady: function() {},
    onShow: function() {
        var t = this;
        e.audio_end(this), a.util.request({
            url: "entry/wxapp/service",
            data: {
                op: "address"
            },
            success: function(a) {
                var e = a.data;
                "" != e.data && t.setData({
                    address: e.data
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
        var t = this, a = 0, e = 0;
        -1 == t.data.format ? e = (parseInt(t.data.member) * parseFloat(t.data.list.price)).toFixed(2) : 1 == t.data.list.type || 2 == t.data.list.type ? e = "" != t.data.group && null != t.data.group && 2 == t.data.list.type ? (parseInt(t.data.member) * parseFloat(t.data.list.format[t.data.format].group_price)).toFixed(2) : (parseInt(t.data.member) * parseFloat(t.data.list.format[t.data.format].price)).toFixed(2) : 3 == t.data.list.type && (e = (parseInt(t.data.member) * parseFloat(t.data.list.format[t.data.format].limit_price)).toFixed(2)), 
        a = t.data.ticketCurr > 0 ? (parseFloat(e) - parseFloat(t.data.list.coupon[t.data.ticketCurr - 1].name)).toFixed(2) : e, 
        1 == t.data.pei_type && "" != t.data.list.fee && null != t.data.list.fee && (a = (parseFloat(a) + parseFloat(t.data.list.fee)).toFixed(2)), 
        t.setData({
            o_amount: a,
            amount: e
        });
    }
});