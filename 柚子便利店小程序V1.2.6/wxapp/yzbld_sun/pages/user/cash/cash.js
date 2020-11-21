var _request = require("../../../util/request.js"), _request2 = _interopRequireDefault(_request);

function _interopRequireDefault(t) {
    return t && t.__esModule ? t : {
        default: t
    };
}

var WxParse = require("../../wxParse/wxParse.js"), app = getApp();

Page({
    data: {
        ratesMoney: "0.00",
        putForward: "",
        minPut: "0",
        mode: [],
        list: [],
        check: !1,
        commissionMoney: "0.00",
        isShow: !0,
        is_modal_Hidden: !0,
        defaulttype: 0,
        index: 0,
        cangetMoney: "0.00",
        totalamount: "0.00",
        ptcc_rate: 0,
        rule: ""
    },
    onLoad: function(t) {
        var o = this;
        _request2.default.get("getWithdrawSetting").then(function(t) {
            console.log(t);
            var e = {
                cms_rates: t.commission,
                wd_wxrates: t.poundage
            };
            o.setData({
                minPut: t.min_amount,
                rule: t.rule,
                totalamount: t.user_amount,
                withdraw: e
            });
            var a = o.data.rule;
            WxParse.wxParse("rule", "html", a, o, 0);
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
        var e = this;
        e.calcom(e.data.totalamount), e.setData({
            putForward: e.data.totalamount
        });
    },
    enterMmoney: function(t) {
        var e = this.data.totalamount, a = t.detail.value;
        console.log("totalamount:" + e), console.log("money:" + a), parseFloat(a) > parseFloat(e) ? wx.showToast({
            title: "提现金额不得超过￥" + e,
            icon: "none"
        }) : this.calcom(a);
    },
    calcom: function(t) {
        var e = this, a = e.data.withdraw, o = "0.00", n = "0.00", i = "0.00", s = e.data.ptcc_rate;
        t && (i = 0 < s ? (s / 100 * t).toFixed(2) : (a.cms_rates / 100 * t).toFixed(2), 
        n = (t - (o = (a.wd_wxrates / 100 * t).toFixed(2)) - i).toFixed(2)), e.setData({
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
        var e = this, a = parseFloat(e.data.putForward), o = e.data.totalamount, n = e.data.check, i = !1, s = "", r = t.detail.value.wx_uname, u = t.detail.value.wx_phone;
        if (a < 2 || a > parseFloat(o) ? s = "金额不得大于" + o + "元或小于2元" : "" == r || null == r ? s = "请输入您的姓名" : /^1(3|4|5|7|8)\d{9}$/.test(u) ? n ? i = !0 : s = "请阅读提现须知" : s = "请输入正确的手机号码", 
        i) {
            var l = {};
            l.amount = this.data.putForward, l.poundage = this.data.ratesMoney, l.commission = this.data.commissionMoney, 
            l.true_amount = this.data.cangetMoney, l.name = r, l.phone = u, console.log(l), 
            _request2.default.post("postWithdraw", l).then(function(t) {
                console.log(t), wx.redirectTo({
                    url: "../dorder/dorder?index=2"
                });
            });
        } else wx.showToast({
            title: s,
            icon: "none"
        });
    }
});