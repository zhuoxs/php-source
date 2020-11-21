var n = getApp();

Page({
    data: {
        logintag: "",
        info: ""
    },
    onLoad: function(o) {
        var t = this;
        try {
            var a = wx.getStorageSync("session");
            a && (console.log("logintag:", a), t.setData({
                logintag: a
            }));
        } catch (n) {}
        var e = t.data.logintag;
        wx.request({
            url: n.data.url + "get_fzsm_content",
            data: {
                logintag: e
            },
            header: {
                "content-type": "application/x-www-form-urlencoded"
            },
            success: function(n) {
                if (console.log(n), "0000" == n.data.retCode) {
                    var o = n.data.info;
                    t.setData({
                        info: o
                    });
                } else wx.showToast({
                    title: n.data.retDesc,
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