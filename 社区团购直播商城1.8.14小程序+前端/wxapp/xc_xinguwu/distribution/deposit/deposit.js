var app = getApp();

Page({
    data: {
        inputvalue: "",
        modal_show: !1,
        wechat: !0
    },
    radioChange: function(a) {
        this.setData({
            wechat: 1 == a.detail.value
        });
    },
    changePrice: function(a) {
        var t = this, o = a.detail.value, e = e = /^(\.*)(\d+)(\.?)(\d{0,2}).*$/g;
        o = e.test(o) ? o.replace(e, "$2$3$4") : "", parseFloat(o) > parseFloat(t.data.list.brokerage) && (app.look.alert("佣金余额不足"), 
        o = t.data.inputvalue), parseFloat(2e4 < o) && (app.look.alert("最高2w额度"), o = t.data.inputvalue), 
        t.setData({
            inputvalue: o
        });
    },
    depositDetail: function() {
        wx.navigateTo({
            url: "../depositLog/depositLog"
        });
    },
    myform: function(a) {
        var t = this, o = a.detail.value;
        "" != o.wechat || "" != o.alipay ? "" != o.name ? "" != o.peice ? parseFloat(o.price) < parseFloat(app.globalData.webset.minimum_amount) ? app.look.alert(app.globalData.webset.minimum_amount + "元起提") : app.util.request({
            url: "entry/wxapp/distribution",
            showLoading: !1,
            data: {
                op: "withdraw_deposit",
                value: o
            },
            success: function(a) {
                t.setData({
                    modal_show: !0
                });
            }
        }) : app.look.alert("请输入金额") : app.look.alert("请输入您的姓名") : app.look.alert("请输入提现帐号");
    },
    close: function() {
        this.setData({
            modal_show: !1
        });
    },
    todepositlog: function() {
        wx.navigateTo({
            url: "../depositLog/depositLog"
        });
    },
    onLoad: function(a) {
        this.setData({
            minimum_amount: app.globalData.webset.minimum_amount
        });
        var o = this;
        app.util.request({
            url: "entry/wxapp/distribution",
            showLoading: !1,
            data: {
                op: "deposit"
            },
            success: function(a) {
                var t = a.data;
                t.data.list && o.setData({
                    list: t.data.list,
                    nickname: app.globalData.userInfo.nickname
                });
            }
        });
    },
    onReady: function() {
        app.look.navbar(this);
    },
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {}
});