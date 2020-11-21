Page({
    data: {},
    onLoad: function(n) {
        this.setData({
            not: !0
        });
    },
    priceBtn: function() {
        this.setData({
            cur: !this.data.cur,
            not: !1
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