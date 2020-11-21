var app = getApp();

Page({
    data: {},
    del: function(n) {
        var o = n.currentTarget.dataset.index, a = this.data.info, t = n.currentTarget.dataset.id;
        console.log(t);
        var e = app.siteInfo.uniacid;
        a.splice(o, 1), app.util.request({
            url: "entry/wxapp/Deljijian",
            data: {
                id: t,
                uniacid: e
            },
            success: function(n) {
                console.log(n);
            },
            fail: function(n) {
                console.log(n);
            }
        }), this.setData({
            info: a
        });
    },
    info: function(n) {
        var o = n.currentTarget.dataset.id;
        wx.navigateTo({
            url: "../infojyxiang/infojyxiang?id=" + o
        });
    },
    onLoad: function(n) {
        var o = wx.getStorageSync("color");
        wx.setNavigationBarColor({
            frontColor: "#ffffff",
            backgroundColor: o
        });
        var a = this, t = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/Selecjianybaogao",
            data: {
                openid: t
            },
            success: function(n) {
                console.log(n.data.data), a.setData({
                    info: n.data.data
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