var app = getApp(), Toast = require("../../libs/zanui/toast/toast"), Toptips = require("../../libs/zanui/toptips/index");

Page({
    data: {},
    onLoad: function(t) {
        var a = this;
        app.viewCount(), t.id && a.setData({
            item_id: t.id
        }), t.log && (a.setData({
            log: !0
        }), wx.setNavigationBarTitle({
            title: "置顶记录"
        }), a.getStickLog()), t.post && a.getStickConfig(), a.setData({
            credit_title: app.globalData.credit_title,
            payType: [ app.globalData.credit_title + "支付", "微信支付" ]
        });
    },
    getStickConfig: function() {
        var o = this;
        app.util.request({
            url: "entry/wxapp/pay_item",
            cachetime: "0",
            data: {
                act: "apply",
                m: "superman_hand2"
            },
            success: function(t) {
                if (t.data.errno) o.showIconToast(t.data.errmsg); else {
                    for (var a = t.data.data.list, e = 0; e < a.length; e++) {
                        a[e].checked = !1;
                        for (var i = 0; i < a[e].fields.length; i++) a[e].fields[i].checked = !1;
                    }
                    o.setData({
                        list: a,
                        rule: t.data.data.rule,
                        completed: !0
                    });
                }
            },
            fail: function(t) {
                o.setData({
                    completed: !0
                }), o.showIconToast(t.data.errmsg);
            }
        });
    },
    districtChange: function(t) {
        for (var a = this.data.list, e = t.detail.value, i = 0; i < a.length; i++) {
            a[i].checked = !1;
            for (var o = 0; o < e.length; o++) if (a[i].district == e[o]) {
                a[i].checked = !0;
                break;
            }
        }
        this.setData({
            list: a
        });
    },
    positionChange: function(t) {
        for (var a = this.data.list, e = a[t.currentTarget.dataset.index].fields, i = t.detail.value, o = 0; o < e.length; o++) {
            e[o].checked = !1;
            for (var s = 0; s < i.length; s++) if (e[o].position == i[s]) {
                e[o].checked = !0;
                break;
            }
        }
        this.setData({
            list: a
        });
    },
    getStickLog: function() {
        var a = this;
        app.util.request({
            url: "entry/wxapp/pay_item",
            cachetime: "0",
            data: {
                act: "log",
                itemid: a.data.item_id,
                m: "superman_hand2"
            },
            success: function(t) {
                a.setData({
                    completed: !0
                }), console.log(t.data.data), t.data.errno ? a.showIconToast(t.data.errmsg) : a.setData({
                    payLog: t.data.data
                });
            },
            fail: function(t) {
                a.setData({
                    completed: !0
                }), a.showIconToast(t.data.errmsg);
            }
        });
    },
    showPopup: function() {
        this.setData({
            showBottomPopup: !0
        });
    },
    toggleBottomPopup: function() {
        this.setData({
            showBottomPopup: !this.data.showBottomPopup
        });
    },
    changePayType: function(t) {
        var a = this, e = a.data.list, i = t.detail.value, o = e.filter(function(t) {
            return t.checked;
        }), s = o.filter(function(t) {
            return 1 == t.paytype;
        }), n = o.filter(function(t) {
            return 2 == t.paytype;
        });
        0 < s.length && 1 == i ? a.showIconToast("有置顶地区不支持微信支付，请选择其他支付方式") : 0 < n.length && 0 == i ? a.showIconToast("有置顶地区不支持" + a.data.credit_title + "支付，请选择其他支付方式") : a.setData({
            payTypeIndex: i
        });
    },
    calMoney: function(t) {
        var a = this, e = t.detail.value, i = a.data.money, o = a.data.credit, s = Math.floor(parseFloat(e) * parseFloat(i) * 100) / 100, n = Math.floor(parseFloat(e) * parseFloat(o) * 100) / 100;
        a.setData({
            money: s,
            credit: n
        });
    },
    confirmPay: function(t) {
        for (var i = this, a = i.data.item_id, e = i.data.list, o = i.data.payTypeIndex, s = t.detail.value.total, n = [], r = 0, c = 0, p = 0; p < e.length; p++) if (e[p].checked) {
            for (var d = {
                district: encodeURIComponent(e[p].district)
            }, l = [], u = 0; u < e[p].fields.length; u++) e[p].fields[u].checked && (l.push(e[p].fields[u].position), 
            r += parseFloat(e[p].fields[u].price), c += parseFloat(e[p].fields[u].credit));
            2 == l.length ? d.position = 3 : 1 == l.length && (d.position = parseInt(l[0])), 
            0 < l.length && n.push(d);
        }
        if (0 != n.length) if (s) if (null != o) {
            r = Math.floor(parseFloat(s) * parseFloat(r) * 100) / 100, c = Math.floor(parseFloat(s) * parseFloat(c) * 100) / 100;
            var h = r + "元";
            0 == o && (h = c + i.data.credit_title), wx.showModal({
                title: "系统提示",
                content: "购买本次置顶需支付" + h,
                success: function(t) {
                    t.confirm && app.util.request({
                        url: "entry/wxapp/pay_item",
                        cachetime: "0",
                        data: {
                            act: "pay",
                            itemid: a,
                            fields: app.util.base64Encode(JSON.stringify(n)),
                            total: s,
                            paytype: parseInt(o) + 1,
                            money: r,
                            credit: c,
                            m: "superman_hand2"
                        },
                        success: function(t) {
                            if (t.data.errno) i.showIconToast(t.data.errmsg); else if (0 == o) {
                                var a = "";
                                a = 1 == t.data.data.top_audit ? "支付成功，请等待管理员审核" : "支付成功，物品已置顶", i.showIconToast(a, "success"), 
                                setTimeout(function() {
                                    wx.redirectTo({
                                        url: "/pages/home/index"
                                    });
                                }, 1500);
                            } else {
                                var e = {
                                    timeStamp: t.data.data.timeStamp,
                                    nonceStr: t.data.data.nonceStr,
                                    package: t.data.data.package,
                                    signType: t.data.data.signType,
                                    paySign: t.data.data.paySign,
                                    top_audit: t.data.data.top_audit
                                };
                                i.payment(e);
                            }
                        },
                        fail: function(t) {
                            i.showIconToast(t.data.errmsg);
                        }
                    });
                }
            });
        } else Toptips("请选择支付方式"); else Toptips("请填写购买数量"); else Toptips("请选择置顶地区");
    },
    payment: function(a) {
        var e = this;
        wx.requestPayment({
            timeStamp: a.timeStamp,
            nonceStr: a.nonceStr,
            package: a.package,
            signType: a.signType,
            paySign: a.paySign,
            success: function() {
                var t = "";
                t = 1 == a.top_audit ? "支付成功，请等待管理员审核" : "支付成功，物品已置顶", e.showIconToast(t, "success"), 
                setTimeout(function() {
                    wx.redirectTo({
                        url: "/pages/home/index"
                    });
                }, 1500);
            },
            fail: function(t) {
                console.log(t);
            }
        });
    },
    cancelPay: function() {
        wx.redirectTo({
            url: "../home/index"
        });
    },
    showIconToast: function(t) {
        var a = 1 < arguments.length && void 0 !== arguments[1] ? arguments[1] : "fail";
        Toast({
            type: a,
            message: t,
            selector: "#zan-toast"
        });
    }
});