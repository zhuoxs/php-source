var t = getApp();

Page({
    data: {
        info: []
    },
    onLoad: function(n) {
        var a = this;
        try {
            var o = wx.getStorageSync("session");
            o && (console.log("logintag:", o), a.setData({
                logintag: o
            }));
        } catch (t) {}
        var e = a.data.logintag;
        wx.request({
            url: t.data.url + "car_owner_bidding_list",
            data: {
                logintag: e
            },
            header: {
                "content-type": "application/x-www-form-urlencoded"
            },
            success: function(t) {
                console.log(t), "0000" == t.data.retCode ? a.setData({
                    info: t.data.info
                }) : (wx.showToast({
                    title: t.data.retDesc,
                    icon: "none",
                    duration: 1e3
                }), "没有数据" == t.data.retDesc && a.setData({
                    info: []
                }));
            }
        });
    },
    bindtap: function(t) {
        wx.navigateTo({
            url: "/pages/index/bidding/list/list"
        });
    },
    partt: function(t) {
        var n = t.currentTarget.dataset.id;
        wx.navigateTo({
            url: "/pages/index/bidding/partt/partt?id=" + n
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