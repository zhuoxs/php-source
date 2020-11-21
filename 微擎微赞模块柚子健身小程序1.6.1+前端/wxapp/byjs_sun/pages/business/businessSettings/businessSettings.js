Page({
    data: {
        switchShow: !0
    },
    shangeSwich: function() {
        var n = this.data.switchShow;
        n = !n, this.setData({
            switchShow: n
        });
    },
    onLoad: function(n) {},
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    goIndex: function() {
        wx.navigateTo({
            url: "/byjs_sun/pages/business/businessIndex2/businessIndex"
        });
    },
    goOrder: function() {
        wx.navigateTo({
            url: "/byjs_sun/pages/business/businessOrder/businessOrder"
        });
    }
});