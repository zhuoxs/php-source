var app = getApp(), Page = require("../../../../zhy/sdk/qitui/oddpush.js").oddPush(Page).Page;

Page({
    data: {
        balance: 0
    },
    onLoad: function(a) {},
    onReady: function() {},
    onShow: function() {
        var t = this, a = wx.getStorageSync("users").openid;
        app.util.request({
            url: "entry/wxapp/Balance",
            data: {
                openid: a
            },
            success: function(a) {
                console.log(parseFloat(a.data.money)), console.log(parseFloat(a.data.res.tx_money)), 
                console.log(parseFloat(a.data.money) > parseFloat(a.data.res.tx_money)), console.log(parseFloat(a.data.money) > parseFloat(a.data.res.tx_money) && 1 < a.data.money), 
                parseFloat(a.data.money) > parseFloat(a.data.res.tx_money) && 1 < a.data.money ? t.setData({
                    state: 1
                }) : t.setData({
                    state: 2
                }), t.setData({
                    balance: a.data.money,
                    system: a.data.res
                });
            }
        });
    },
    goExtract: function() {
        var t = this;
        t.setData({
            state: 2
        });
        var a = wx.getStorageSync("users").openid, e = wx.getStorageSync("users").id, n = t.data.balance, o = n * (1 - t.data.system.tx_sxf / 100);
        0 < t.data.length && 0 < t.data.length1 ? app.util.request({
            url: "entry/wxapp/GoExtract",
            data: {
                openid: a,
                uid: e,
                money: n,
                sj_cost: o,
                wx: t.data.value,
                name: t.data.name,
                tx_sxf: t.data.system.tx_sxf
            },
            success: function(a) {
                wx.showToast({
                    title: "提现成功，等待消息",
                    icon: "",
                    image: "",
                    duration: 2e3,
                    mask: !0,
                    success: function(a) {},
                    fail: function(a) {},
                    complete: function(a) {}
                }), t.setData({
                    balance: a.data
                });
            }
        }) : wx.showToast({
            title: "请输入必要信息",
            icon: "none",
            image: "",
            duration: 2e3,
            mask: !0,
            success: function(a) {},
            fail: function(a) {},
            complete: function(a) {}
        });
    },
    bindKeyInput1: function(a) {
        this.setData({
            length: a.detail.value.length,
            value: a.detail.value
        });
    },
    bindKeyInput0: function(a) {
        this.setData({
            length1: a.detail.value.length,
            name: a.detail.value
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    goRecordlist: function(a) {
        wx.navigateTo({
            url: "../recordlist/recordlist"
        });
    }
});