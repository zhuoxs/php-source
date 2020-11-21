var app = getApp();

Page({
    data: {
        navTile: "打卡",
        mission: []
    },
    onLoad: function(o) {
        wx.setNavigationBarTitle({
            title: this.data.navTile
        });
        var t = wx.getStorageSync("setting");
        t ? wx.setNavigationBarColor({
            frontColor: t.fontcolor,
            backgroundColor: t.color
        }) : app.get_setting(!0).then(function(o) {
            wx.setNavigationBarColor({
                frontColor: o.fontcolor,
                backgroundColor: o.color
            });
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    toSettarget: function(o) {
        wx.navigateTo({
            url: "../settarget/settarget"
        });
    }
});