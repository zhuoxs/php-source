var app = getApp();

Page({
    data: {
        navTile: "订单详情",
        is_hx: 0
    },
    onLoad: function(n) {},
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    toConfirm: function(n) {
        n.currentTarget.dataset.order_id;
    },
    toOrderlist: function(n) {
        wx.navigateBack({});
    }
});