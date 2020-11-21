var app = getApp();

Page({
    data: {
        bingli: []
    },
    del: function(n) {
        var o = n.currentTarget.dataset.index, t = n.currentTarget.dataset.id;
        console.log(n);
        var a = this.data.bingli, i = (wx.getStorageSync("openid"), app.siteInfo.uniacid);
        a.splice(o, 1), app.util.request({
            url: "entry/wxapp/Delbinli",
            data: {
                id: t,
                uniacid: i
            },
            success: function(n) {
                console.log(n);
            },
            fail: function(n) {
                console.log(n);
            }
        }), this.setData({
            bingli: a
        });
    },
    onLoad: function(n) {
        var o = wx.getStorageSync("color");
        wx.setNavigationBarColor({
            frontColor: "#ffffff",
            backgroundColor: o
        });
        var t = this, a = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/Allbinli",
            data: {
                openid: a
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