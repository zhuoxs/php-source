Page({
    data: {},
    onLoad: function(n) {},
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    goCourseInfo: function() {
        wx.navigateTo({
            url: "/byjs_sun/pages/product/courseInfo/courseInfo?type=2"
        });
    }
});