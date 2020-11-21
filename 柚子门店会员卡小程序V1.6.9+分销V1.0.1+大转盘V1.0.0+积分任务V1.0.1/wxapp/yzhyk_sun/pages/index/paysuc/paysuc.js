Page({
    data: {},
    onLoad: function(n) {},
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    toIndex: function(n) {
        wx.reLaunch({
            url: "/yzhyk_sun/pages/index/index"
        });
    }
});