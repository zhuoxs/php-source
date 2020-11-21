var app = getApp();

Page({
    data: {},
    onLoad: function(o) {
        console.log(o);
        var n = this, e = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/MyStoreCoupon",
            cachetime: "0",
            data: {
                sid: o.sid,
                openid: e,
                price: o.price
            },
            success: function(o) {
                console.log(o), n.setData({
                    myStoreCoupon: o.data
                });
            }
        });
    },
    useNow: function(o) {
        console.log(o);
        var n = o.currentTarget.dataset.cid, e = o.currentTarget.dataset.downprice;
        wx.setStorageSync("coupon_id", n), wx.setStorageSync("down_price", e), wx.navigateBack({});
    },
    onReady: function() {},
    onShow: function() {
        wx.getStorageSync("openid");
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {}
});