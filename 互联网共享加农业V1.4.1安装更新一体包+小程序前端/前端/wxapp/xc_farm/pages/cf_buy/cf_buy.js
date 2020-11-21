var common = require("../common/common.js"), app = getApp();

function getNowFormatDate() {
    var a = new Date(), t = a.getFullYear(), e = a.getMonth() + 1, n = a.getDate();
    return 1 <= e && e <= 9 && (e = "0" + e), 0 <= n && n <= 9 && (n = "0" + n), t + "-" + e + "-" + n;
}

function wxpay(a, t) {
    a.appId;
    var e = a.timeStamp.toString(), n = a.package, u = a.nonceStr, o = a.paySign.toUpperCase();
    wx.requestPayment({
        timeStamp: e,
        nonceStr: u,
        package: n,
        signType: "MD5",
        paySign: o,
        success: function(a) {
            wx.showToast({
                title: "支付成功",
                icon: "success",
                duration: 2e3
            }), setTimeout(function() {
                wx.reLaunch({
                    url: "../farm/farm"
                });
            }, 2e3);
        }
    });
}

Page({
    data: {
        numbervalue: 1
    },
    numMinus: function() {
        var a = this.data.numbervalue;
        1 == a || (a--, this.setData({
            numbervalue: a
        }));
    },
    numPlus: function() {
        var a = this.data.numbervalue;
        a++, this.setData({
            numbervalue: a
        });
    },
    valChange: function(a) {
        var t = a.detail.value;
        1 <= t || (t = 1), this.setData({
            numbervalue: t
        });
    },
    input: function(a) {
        this.setData({
            content: a.detail.value
        });
    },
    submit: function(a) {
        var e = this, t = {
            id: e.data.xc.detail.id,
            curr: e.data.curr,
            member: e.data.numbervalue,
            form_id: a.detail.formId
        };
        "" != e.data.content && null != e.data.content && (t.content = e.data.content), 
        "" != e.data.xc.userinfo.name && null != e.data.xc.userinfo.name && (t.name = e.data.xc.userinfo.name), 
        "" != e.data.xc.userinfo.mobile && null != e.data.xc.userinfo.mobile && (t.mobile = e.data.xc.userinfo.mobile), 
        app.util.request({
            url: "entry/wxapp/cforder",
            method: "POST",
            data: t,
            success: function(a) {
                var t = a.data;
                "" != t.data && (1 == t.data.status ? "" != t.data.errno && null != t.data.errno ? wx.showModal({
                    title: "错误",
                    content: t.data.message,
                    showCancel: !1
                }) : wxpay(t.data, e) : 2 == t.data.status && (wx.showToast({
                    title: "支付成功",
                    icon: "success",
                    duration: 2e3
                }), setTimeout(function() {
                    wx.reLaunch({
                        url: "../farm/farm"
                    });
                }, 2e3)));
            }
        });
    },
    onLoad: function(a) {
        common.config(this), this.setData({
            curr: a.curr,
            today: getNowFormatDate(),
            id: a.id
        });
    },
    onShow: function() {
        var e = this;
        app.util.request({
            url: "entry/wxapp/service",
            method: "POST",
            data: {
                op: "cf_detail",
                id: e.data.id
            },
            success: function(a) {
                var t = a.data;
                "" != t.data && e.setData({
                    xc: t.data
                });
            }
        });
    },
    onReady: function() {}
});