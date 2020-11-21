var n = getApp();

n.requirejs("core"), n.requirejs("jquery"), n.requirejs("foxui");

Page({
    data: {
        show: !1
    },
    onPullDownRefresh: function() {
        wx.startPullDownRefresh();
    },
    onReady: function() {},
    onLoad: function() {
        var n = this;
        setTimeout(function() {
            n.onPullDownRefresh();
        }, 300), wx.reLaunch({
            url: "/bargain/index/index"
        });
    },
    onShow: function() {},
    onHide: function() {
        wx.showTabBar({});
    },
    onUnload: function() {
        wx.showTabBar({});
    },
    onReachBottom: function() {},
    onShareAppMessage: function() {}
});