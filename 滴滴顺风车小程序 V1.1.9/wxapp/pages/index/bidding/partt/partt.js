var o = getApp();

Page({
    data: {
        nid: ""
    },
    onLoad: function(n) {
        console.log(n);
        var t = this, a = n.id;
        t.setData({
            nid: a
        });
        try {
            var e = wx.getStorageSync("session");
            e && (console.log("logintag:", e), t.setData({
                logintag: e
            }));
        } catch (o) {}
        var i = t.data.logintag;
        wx.request({
            url: o.data.url + "car_owner_bidding_view",
            data: {
                logintag: i,
                nid: a
            },
            header: {
                "content-type": "application/x-www-form-urlencoded"
            },
            success: function(o) {
                console.log(o), "0000" == o.data.retCode ? t.setData({
                    info: o.data.info
                }) : wx.showToast({
                    title: o.data.retDesc,
                    icon: "loading",
                    duration: 1e3
                });
            }
        });
    },
    onReady: function() {},
    del: function(n) {
        var t = this, a = t.data.logintag, e = t.data.nid;
        wx.request({
            url: o.data.url + "car_owner_del_bidding",
            data: {
                logintag: a,
                nid: e
            },
            header: {
                "content-type": "application/x-www-form-urlencoded"
            },
            success: function(o) {
                console.log("删除记录"), console.log(o), "0000" == o.data.retCode ? (setTimeout(function() {
                    console.log("延迟调用 => home"), wx.navigateBack({
                        delta: 1,
                        success: function(o) {
                            var n = getCurrentPages().pop();
                            void 0 != n && null != n && n.onLoad();
                        }
                    });
                }, 1e3), wx.showToast({
                    title: o.data.retDesc,
                    icon: "none",
                    duration: 1e3
                })) : wx.showToast({
                    title: o.data.retDesc,
                    icon: "none",
                    duration: 1e3
                });
            }
        });
    },
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {}
});