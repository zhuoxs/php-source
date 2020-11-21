var app = getApp(), wxParse = require("../../../../common/wxParse/wxParse.js");

Page({
    data: {
        ratesMoney: "0.00",
        putForward: "",
        minPut: "100",
        mode: [],
        list: [],
        check: !1,
        commissionMoney: "0.00",
        isShow: !0,
        is_modal_Hidden: !0,
        defaulttype: 0,
        index: 0,
        cangetMoney: "0.00",
        totalamount: "0.00"
    },
    onLoad: function(t) {
        var o = this;
        app.get_admin_store_info().then(function(t) {
            o.setData({
                totalamount: t.balance,
                store: t
            });
        }), app.api.get_setting().then(function(t) {
            console.log(t), wxParse.wxParse("detail", "html", t.withdraw_content, o, 0);
            var a = {
                wd_wxrates: t.withdraw_wechatrate,
                wd_content: t.withdraw_content,
                cms_rates: t.withdraw_platformrate
            }, e = t.withdraw_platformrate;
            o.setData({
                ptcc_rate: e,
                withdraw: a,
                setting: t
            });
        }), app.api.get_user_info().then(function(t) {
            o.setData({
                user: t
            });
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    toggleRule: function(t) {
        this.setData({
            isShow: !this.data.isShow
        });
    },
    cashAll: function(t) {
        var a = this;
        a.calcom(a.data.totalamount), a.setData({
            putForward: a.data.totalamount
        });
    },
    enterMmoney: function(t) {
        var a = this.data.totalamount, e = t.detail.value;
        a - 0 < e - 0 && wx.showToast({
            title: "提现金额不得超过￥" + a,
            icon: "none"
        }), this.calcom(e);
    },
    calcom: function(t) {
        var a = this, e = a.data.withdraw, o = "0.00", n = "0.00", i = "0.00", s = a.data.ptcc_rate;
        t && (i = 0 < s ? (s / 100 * t).toFixed(2) : (e.cms_rates / 100 * t).toFixed(2), 
        n = (t - (o = (e.wd_wxrates / 100 * t).toFixed(2)) - i).toFixed(2)), console.log(o), 
        a.setData({
            commissionMoney: i,
            ratesMoney: o,
            cangetMoney: n,
            putForward: t
        });
    },
    checkboxChange: function(t) {
        this.setData({
            check: !this.data.check
        });
    },
    formSubmit: function(t) {
        var a = this, e = a.data.setting.withdraw_min, o = a.data.putForward, n = a.data.totalamount, i = a.data.check, s = !1, c = "";
        t.detail.value.wx_uname, t.detail.value.wx_phone;
        o - 0 < e - 0 || n - 0 < o - 0 ? c = "金额不得大于" + n + "元或小于" + e + "元" : i ? s = !0 : c = "请阅读提现须知", 
        s ? app.util.request({
            url: "entry/wxapp/AddWithdraw",
            data: {
                user_id: a.data.user.id,
                store_id: a.data.store.id,
                balance: o,
                paycommission: a.data.commissionMoney,
                ratesmoney: a.data.ratesMoney
            },
            success: function(t) {
                t.data.code ? wx.showToast({
                    title: t.data.msg
                }) : wx.navigateBack({});
            }
        }) : wx.showToast({
            title: c,
            icon: "none"
        });
    }
});