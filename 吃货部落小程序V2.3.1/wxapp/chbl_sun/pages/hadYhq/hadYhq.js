var app = getApp();

Page({
    data: {},
    onLoad: function(o) {
        console.log(o), wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("fontcolor"),
            backgroundColor: wx.getStorageSync("color"),
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        });
    },
    useNow: function(o) {
        wx.navigateTo({
            url: "../shops/shops?id=" + o.currentTarget.dataset.sid
        });
    },
    onReady: function() {},
    onShow: function() {
        var n = this, o = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/MyCoupon",
            cachetime: "0",
            data: {
                openid: o
            },
            success: function(o) {
                console.log(o), n.setData({
                    myCoupon: o.data
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