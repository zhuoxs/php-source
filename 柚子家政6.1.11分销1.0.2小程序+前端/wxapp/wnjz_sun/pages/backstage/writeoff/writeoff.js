var app = getApp();

Page({
    data: {
        navTile: "订单详情",
        is_hx: 0,
        order: {
            pic: "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152531295627.png",
            num: 1,
            unit_price: "20.00",
            gname: "标题啊啊啊啊啊啊啊啊啊啊"
        },
        isIpx: app.globalData.isIpx
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