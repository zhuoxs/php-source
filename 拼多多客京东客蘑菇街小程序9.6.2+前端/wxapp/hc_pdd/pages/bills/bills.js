var app = getApp();

Page({
    data: {},
    onLoad: function(o) {
        var n = app.globalData.Headcolor;
        this.setData({
            backgroundColor: n
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