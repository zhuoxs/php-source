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
        wx.redirectTo({
            url: "../index/index"
        });
    },
    toSet: function(n) {
        wx.redirectTo({
            url: "../set/set"
        });
    }
});