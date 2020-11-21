var o = getApp();

Page({
    data: {
        logintag: ""
    },
    onLoad: function(n) {
        var t = this;
        try {
            var a = wx.getStorageSync("session");
            a && (console.log("logintag:", a), t.setData({
                logintag: a
            }));
        } catch (o) {}
        var e = t.data.logintag;
        wx.request({
            url: o.data.url + "noticelist",
            data: {
                logintag: e
            },
            header: {
                "content-type": "application/x-www-form-urlencoded"
            },
            success: function(o) {
                console.log("显示搜索页面广告"), console.log(o), "0000" == o.data.retCode ? t.setData({
                    info: o.data.info
                }) : wx.showToast({
                    title: o.data.retDesc,
                    icon: "none",
                    duration: 1e3
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
    onShareAppMessage: function() {}
});