var app = getApp();

Page({
    data: {
        navTile: "联系客服",
        phone: "0592-6666666"
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
        var o = wx.getStorageSync("settings");
        this.setData({
            settings: o
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    dialog: function(n) {
        wx.makePhoneCall({
            phoneNumber: this.data.settings.tel
        });
    }
});