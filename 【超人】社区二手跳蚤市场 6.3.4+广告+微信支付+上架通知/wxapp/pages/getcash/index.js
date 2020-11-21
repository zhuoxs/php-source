var app = getApp(), Toptips = require("../../libs/zanui/toptips/index"), Toast = require("../../libs/zanui/toast/toast");

Page({
    data: {
        charge: 0,
        idx: 0
    },
    onLoad: function() {
        var o = this, a = wx.getStorageSync("loading_img");
        a ? o.setData({
            loadingImg: a
        }) : o.setData({
            loadingImg: "../../libs/images/loading.gif"
        }), app.util.request({
            url: "entry/wxapp/finance",
            data: {
                m: "superman_hand2",
                act: "getcash"
            },
            fail: function(a) {
                console.log(a), wx.showModal({
                    title: "系统提示",
                    content: a.data.errmsg + "(" + a.data.errno + ")"
                });
            },
            success: function(a) {
                if (console.log(a), o.setData({
                    completed: !0
                }), 0 == a.data.errno) {
                    var e = a.data.data;
                    if (e.getcash && e.getcash.getcash_type) {
                        for (var t = Object.keys(e.getcash.getcash_type), n = 0; n < t.length; n++) 1 == t[n] ? t[n] = "微信" : 2 == t[n] ? t[n] = "支付宝" : t[n] = "银行卡";
                        o.setData({
                            account: t,
                            balance: e.member_info.balance,
                            rate: e.getcash.fee_rate ? e.getcash.fee_rate : "",
                            fee_max: e.getcash.fee_max ? e.getcash.fee_max : 0,
                            fee_min: e.getcash.fee_min ? e.getcash.fee_min : 0
                        });
                    } else wx.showModal({
                        title: "系统提示",
                        content: "提现参数未设置，请联系管理员设置",
                        showCancel: !1,
                        success: function(a) {
                            a.confirm && wx.redirectTo({
                                url: "../my/index"
                            });
                        }
                    });
                }
            }
        });
    },
    showAccount: function(a) {
        this.setData({
            idx: a.detail.value
        });
    },
    calCharge: function(a) {
        var e = this, t = "" == a.detail.value ? 0 : a.detail.value, n = parseFloat(e.data.rate), o = (parseFloat(t) * n / 100).toFixed(2), s = e.data.fee_max, i = e.data.fee_min;
        0 == i && 0 == s && e.setData({
            charge: o
        }), 0 == i && 0 < s && (s < o ? e.setData({
            charge: s
        }) : e.setData({
            charge: o
        })), 0 < i && 0 == s && (o < i ? e.setData({
            charge: i
        }) : e.setData({
            charge: o
        })), 0 < i && 0 < s && (o < i ? e.setData({
            charge: i
        }) : s < o ? e.setData({
            charge: s
        }) : e.setData({
            charge: o
        }));
    },
    getCash: function(a) {
        console.log(a.detail.value);
        var e = this, t = a.detail.value;
        if (1 == e.data.idx) {
            if ("" == t.alipay_account) return void Toptips("请填写支付宝账号");
            if ("" == t.alipay_username) return void Toptips("请填写支付宝昵称");
        }
        if (2 == e.data.idx) {
            if ("" == t.bank_name) return void Toptips("请填写银行名称");
            if ("" == t.bank_account) return void Toptips("请填写开户行名称");
            if ("" == t.bank_cardno) return void Toptips("请填写银行卡号");
            if ("" == t.bank_username) return void Toptips("请填写开卡人姓名");
        }
        "" != t.money ? parseFloat(t.money) > parseFloat(e.data.balance) ? Toptips("提现金额大于账户余额，请重新填写") : app.util.request({
            url: "entry/wxapp/finance",
            data: {
                m: "superman_hand2",
                act: "getcash",
                account_type: t.account_type,
                alipay_account: t.alipay_account ? t.alipay_account : "",
                alipay_username: t.alipay_username ? t.alipay_username : "",
                bank_name: t.bank_name ? t.bank_name : "",
                bank_account: t.bank_account ? t.bank_account : "",
                bank_cardno: t.bank_cardno ? t.bank_cardno : "",
                bank_username: t.bank_username ? t.bank_username : "",
                money: t.money,
                apply_remark: t.apply_remark,
                submit: "yes"
            },
            fail: function(a) {
                console.log(a), wx.showModal({
                    title: "系统提示",
                    content: a.data.errmsg + "(" + a.data.errno + ")"
                });
            },
            success: function(a) {
                console.log(a), 0 == a.data.errno ? (e.showIconToast("提现成功，请等待管理员审核", "success"), 
                setTimeout(function() {
                    wx.redirectTo({
                        url: "../my/index"
                    });
                }, 1e3)) : wx.showModal({
                    title: "系统提示",
                    content: a.data.errmsg + "(" + a.data.errno + ")"
                });
            }
        }) : Toptips("请填写提现金额");
    },
    showIconToast: function(a) {
        var e = 1 < arguments.length && void 0 !== arguments[1] ? arguments[1] : "fail";
        Toast({
            type: e,
            message: a,
            selector: "#zan-toast"
        });
    }
});