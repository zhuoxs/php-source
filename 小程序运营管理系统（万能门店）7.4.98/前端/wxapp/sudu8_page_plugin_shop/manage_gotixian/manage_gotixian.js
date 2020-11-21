var app = getApp();

Page({
    data: {
        id: wx.getStorageSync("mlogin"),
        allMoney: null,
        miniNum: null,
        flag: !1,
        btndis: !1,
        setmoney: ""
    },
    onPullDownRefresh: function() {
        this.gettixian(), wx.stopPullDownRefresh();
    },
    onLoad: function(t) {
        var a = this, e = 0;
        t.fxsid && (e = t.fxsid, a.setData({
            fxsid: t.fxsid
        }));
        var n = app.util.url("entry/wxapp/BaseMin", {
            m: "sudu8_page"
        });
        wx.request({
            url: n,
            data: {
                vs1: 1
            },
            cachetime: "30",
            success: function(t) {
                t.data.data;
                a.setData({
                    baseinfo: t.data.data
                }), wx.setNavigationBarColor({
                    frontColor: a.data.baseinfo.base_tcolor,
                    backgroundColor: a.data.baseinfo.base_color
                });
            }
        }), app.util.getUserInfo(a.getinfos, e), a.gettixian();
    },
    formSubmit: function(t) {
        var a = this, e = t.detail.value, n = t.detail.formId;
        return /^(([1-9]\d*)|\d)(\.\d{1,2})?$/.test(e.money) ? 0 == e.money ? (wx.showModal({
            title: "提示",
            content: "提现金额需大于0",
            showCancel: !1
        }), !1) : "" == e.money ? (wx.showModal({
            title: "提示",
            content: "请输入提现金额！",
            showCancel: !1
        }), !1) : Number(e.money) > a.data.allMoney ? (wx.showModal({
            title: "提示",
            content: "提现金额超过可提金额！",
            showCancel: !1
        }), !1) : e.money < a.data.miniNum - .01 ? (wx.showModal({
            title: "提示",
            content: "提现金额低于最低限度！",
            showCancel: !1
        }), !1) : "" == e.buy_type ? (wx.showModal({
            title: "提示",
            content: "请选择提现到账方式！",
            showCancel: !1
        }), !1) : "" == e.account ? (wx.showModal({
            title: "提示",
            content: "请输入账户！",
            showCancel: !1
        }), !1) : a.data.flag && "" == e.card ? (wx.showModal({
            title: "提示",
            content: "请输入开户行！",
            showCancel: !1
        }), !1) : (e.card && (e.account = e.card + ":" + e.account), a.setData({
            btndis: !0
        }), void app.util.request({
            url: "entry/wxapp/goTixian",
            data: {
                beizhu: e.beizhu,
                buy_type: e.buy_type,
                account: e.account,
                sid: wx.getStorageSync("mlogin"),
                money: e.money,
                formID: n
            },
            success: function(t) {
                wx.showModal({
                    title: "提示",
                    content: "提现申请已提交，请等待打款！",
                    showCancel: !1,
                    confirmText: "确认",
                    success: function(t) {
                        wx.navigateBack();
                    }
                });
            }
        })) : (wx.showModal({
            title: "提示",
            content: "请输入正确提现金额",
            showCancel: !1
        }), !1);
    },
    getall: function() {
        var t = this.data.allMoney;
        this.setData({
            setmoney: t
        });
    },
    gettixian: function() {
        var i = this;
        app.util.request({
            url: "entry/wxapp/getMoney",
            data: {
                id: wx.getStorageSync("mlogin")
            },
            success: function(t) {
                for (var a = t.data.data.allMoney, e = t.data.data.miniNum, n = t.data.data.tixiantype.split(","), o = 0; o < n.length; o++) 1 == n[o] && i.setData({
                    weixin: !0
                }), 2 == n[o] && i.setData({
                    zhifubao: !0
                }), 3 == n[o] && i.setData({
                    yinhangka: !0
                });
                i.setData({
                    allMoney: a,
                    miniNum: e,
                    tixianType: n
                });
            }
        });
    },
    radioChange: function(t) {
        var a = this;
        3 == t.detail.value ? a.data.flag = !0 : a.data.flag = !1, a.setData({
            flag: a.data.flag
        });
    }
});