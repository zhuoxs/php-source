Page({
    data: {
        danganArr: []
    },
    onLoad: function(n) {},
    huanDetailClick: function() {
        wx.navigateTo({
            url: "/hyb_yl/huan_detail/huan_detail"
        });
    },
    addDangClick: function() {
        wx.navigateTo({
            url: "/hyb_yl/jiandang/jiandang"
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