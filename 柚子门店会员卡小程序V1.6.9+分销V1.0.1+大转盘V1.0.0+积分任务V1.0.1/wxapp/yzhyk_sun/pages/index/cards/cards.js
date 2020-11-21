var app = getApp();

Page({
    data: {
        navTile: "优惠券",
        cards: []
    },
    onLoad: function(n) {
        wx.setNavigationBarTitle({
            title: this.data.navTile
        });
    },
    onReady: function() {},
    onShow: function() {
        var o = this;
        app.get_user_coupons().then(function(n) {
            o.setData({
                cards: n
            });
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    toGoods: function() {
        wx.reLaunch({
            url: "../../goods/goods"
        });
    }
});