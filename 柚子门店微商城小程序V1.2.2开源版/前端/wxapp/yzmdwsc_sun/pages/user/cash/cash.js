var app = getApp();

Page({
    data: {
        cash: "0.00",
        navTile: "我的分享金",
        account: "0.00"
    },
    onLoad: function(n) {
        wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("fontcolor"),
            backgroundColor: wx.getStorageSync("color"),
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        }), wx.setNavigationBarTitle({
            title: this.data.navTile
        });
    },
    onReady: function() {},
    onShow: function() {
        var o = this, n = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/getUser",
            cachetime: "0",
            data: {
                openid: n
            },
            success: function(n) {
                o.setData({
                    user: n.data
                });
            }
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {}
});