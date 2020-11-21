Page({
    data: {},
    onLoad: function(n) {},
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {
        wx.showNavigationBarLoading(), setTimeout(function() {
            wx.hideNavigationBarLoading(), wx.stopPullDownRefresh();
        }, 1e3);
    },
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    tjxzClick: function() {
        wx.navigateTo({
            url: "../tjxuzhi/tjxuzhi"
        });
    },
    quyuyue: function() {
        wx.navigateTo({
            url: "../yyjilu/yyjilu"
        });
    }
});