Page({
    data: {},
    onLoad: function(n) {
        console.log(n), this.setData({
            webUrl: n.webUrl
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