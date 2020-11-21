var app = getApp();

Page({
    data: {
        bingli: []
    },
    del: function(n) {
        var t = n.currentTarget.dataset.index, o = n.currentTarget.dataset.id;
        console.log(n);
        var i = this.data.bingli, a = (wx.getStorageSync("openid"), app.siteInfo.uniacid);
        i.splice(t, 1), app.util.request({
            url: "entry/wxapp/Delbinli",
            data: {
                id: o,
                uniacid: a
            },
            success: function(n) {
                console.log(n);
            },
            fail: function(n) {
                console.log(n);
            }
        }), this.setData({
            bingli: i
        });
    },
    onLoad: function(n) {
        var t = this, o = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/Allbinli",
            data: {
                openid: o
            },
            success: function(n) {
                console.log(n), t.setData({
                    bingli: n.data.data
                });
            },
            fail: function(n) {
                console.log(n);
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