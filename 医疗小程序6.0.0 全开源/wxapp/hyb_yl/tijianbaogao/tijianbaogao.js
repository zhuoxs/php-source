var app = getApp();

Page({
    data: {},
    del: function(n) {
        var a = n.currentTarget.dataset.index, t = this.data.info, o = n.currentTarget.dataset.id;
        console.log(o);
        var e = app.siteInfo.uniacid;
        t.splice(a, 1), app.util.request({
            url: "entry/wxapp/Deltijian",
            data: {
                id: o,
                uniacid: e
            },
            success: function(n) {
                console.log(n);
            },
            fail: function(n) {
                console.log(n);
            }
        }), this.setData({
            info: t
        });
    },
    onLoad: function(n) {
        var a = this, t = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/Selectijianbaogao",
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