var o = getApp();

Page({
    data: {
        info: []
    },
    onLoad: function(t) {
        var e = this;
        try {
            var n = wx.getStorageSync("session");
            n && (console.log("logintag:", n), e.setData({
                logintag: n
            }));
        } catch (o) {}
        var a = e.data.logintag;
        wx.request({
            url: o.data.url + "enter_my_wallet",
            data: {
                logintag: a
            },
            header: {
                "content-type": "application/x-www-form-urlencoded"
            },
            success: function(o) {
                if (console.log("enter_my_wallet => 获我的钱包数据信息"), console.log(o), "0000" == o.data.retCode) {
                    var t = o.data.info;
                    e.setData({
                        info: t
                    });
                } else wx.showToast({
                    title: o.data.retDesc,
                    icon: "none",
                    duration: 1e3
                });
            }
        });
    },
    recharge: function(o) {
        wx.navigateTo({
            url: "recharge/recharge"
        });
    },
    deposit: function(o) {
        wx.navigateTo({
            url: "deposit/deposit"
        });
    },
    Detailed: function(o) {
        wx.navigateTo({
            url: "Detailed/Detailed"
        });
    },
    onReady: function() {},
    onShow: function() {
        this.onLoad();
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {}
});