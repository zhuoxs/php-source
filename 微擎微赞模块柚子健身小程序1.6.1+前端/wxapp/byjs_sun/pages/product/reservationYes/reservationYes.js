Page({
    data: {},
    onLoad: function(n) {},
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    goIndex: function() {
        wx.reLaunch({
            url: "/byjs_sun/pages/product/index/index"
        });
    }
});