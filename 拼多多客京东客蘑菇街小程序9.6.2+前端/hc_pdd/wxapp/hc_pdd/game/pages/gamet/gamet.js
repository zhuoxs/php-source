var app = getApp();

Page({
    data: {},
    onLoad: function(n) {
        var o = wx.getMenuButtonBoundingClientRect().top, t = app.globalData.url;
        this.setData({
            top: o,
            url: t
        });
    },
    fan: function() {},
    Kouhonglist: function() {},
    onReady: function() {},
    onShow: function() {
        this.Kouhonglist();
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {}
});