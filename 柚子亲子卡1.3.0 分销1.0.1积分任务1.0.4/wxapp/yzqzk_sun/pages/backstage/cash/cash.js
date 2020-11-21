var app = getApp();

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
        cangetMoney: "0.00"
    },
    onLoad: function(a) {
        var e = this;
        app.get_openid().then(function(t) {
            app.util.request({
                url: "entry/wxapp/getStoreDetail",
                cachetime: "0",
                data: {
                    id: a.id,
                    openid: t
                },
                success: function(t) {
                    console.log(t.data), e.setData({
                        totalamount: parseInt(t.data.money),
                        ptcc_rate: t.data.ptcc_rate,
                        id: a.id
                    });
                }
            });
        }), app.util.request({
            url: "entry/wxapp/getWithDrawSet",
            cachetime: "0",
            data: {},
            success: function(t) {
                console.log(t.data), e.setData({
                    withdraw: t.data
                });
            }
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
        a < e && wx.showToast({
            title: "提现金额不得超过￥" + a,
            icon: "none"
        }), this.calcom(e);
    },
    calcom: function(t) {
        var a = this, e = a.data.withdraw, o = "0.00", n = "0.00", i = "0.00", c = a.data.ptcc_rate;
        t && (i = 0 < c ? (c / 100 * t).toFixed(2) : (e.cms_rates / 100 * t).toFixed(2), 
        n = (t - (o = (e.wd_wxrates / 100 * t).toFixed(2)) - i).toFixed(2)), a.setData({
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
        var a = this, e = a.data.putForward, o = a.data.totalamount, n = a.data.check, i = !1, c = "", s = t.detail.value.wx_uname, d = t.detail.value.wx_phone;
        e < 2 || o < e ? c = "金额不得大于" + o + "元或小于2元" : "" == s || null == s ? c = "请输入您的姓名" : /^1(3|4|5|7|8)\d{9}$/.test(d) ? n ? (i = !0, 
        app.get_openid().then(function(t) {
            app.util.request({
                url: "entry/wxapp/setWithDraw",
                cachetime: "0",
                data: {
                    openid: t,
                    money: e,
                    store_id: a.data.id,
                    wd_name: s,
                    wd_phone: d
                },
                success: function(t) {
                    wx.showModal({
                        title: "提示",
                        content: t.data.errmsg,
                        showCancel: !1,
                        success: function(t) {
                            wx.navigateBack({});
                        }
                    });
                }
            });
        })) : c = "请阅读提现须知" : c = "请输入正确的手机号码", i || wx.showToast({
            title: c,
            icon: "none"
        });
    }
});