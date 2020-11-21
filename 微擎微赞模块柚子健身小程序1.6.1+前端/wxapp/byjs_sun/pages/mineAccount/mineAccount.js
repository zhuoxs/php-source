var app = getApp();

Page({
    data: {
        currIdx: 1
    },
    onLoad: function(t) {},
    selectTab: function(t) {
        var e = t.currentTarget.dataset.index;
        this.setData({
            currIdx: e
        });
    },
    onReady: function() {},
    onShow: function() {
        var e = this, t = wx.getStorageSync("users").id;
        app.util.request({
            url: "entry/wxapp/GetMyAccount",
            data: {
                uid: t
            },
            cachetime: 0,
            success: function(t) {
                console.log(t), e.setData({
                    user: t.data.user,
                    res: t.data.res,
                    result: t.data.result
                });
            }
        });
    },
    withdrawal: function() {
        var e = this, t = e.data.money, n = wx.getStorageSync("users").id, a = wx.getStorageSync("users").openid;
        console.log(t == e.data.res.min_money), console.log(e.data.res.min_money), null != t ? t >= e.data.res.min_money ? app.util.request({
            url: "entry/wxapp/Getwithdrawal",
            data: {
                openid: a,
                money: t,
                uid: n
            },
            cachetime: 0,
            success: function(t) {
                e.onShow();
            }
        }) : wx.showToast({
            title: "金额不足！",
            icon: "none",
            duration: 2e3
        }) : wx.showToast({
            title: "请输入提现金额",
            icon: "none",
            duration: 2e3
        });
    },
    getMoney: function(t) {
        var e = t.detail.value;
        this.setData({
            money: e
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {}
});