var app = getApp();

Page({
    data: {},
    onLoad: function(t) {
        var o = this;
        console.log(t);
        var n = wx.getStorageSync("openid");
        console.log(n), app.util.request({
            url: "entry/wxapp/GetMyCoupons",
            cachetime: "0",
            data: {
                bid: t.bid,
                price: t.price - 0,
                openid: n
            },
            success: function(t) {
                console.log(t), o.setData({
                    couponsList: t.data.data
                });
            }
        }), o.diyWinColor();
    },
    goYhqDetails: function(t) {
        var o = [ t.currentTarget.dataset.id, t.currentTarget.dataset.yhqtype, t.currentTarget.dataset.price, t.currentTarget.dataset.reduce ];
        console.log(o), wx.setStorageSync("yhqDetails", o), wx.navigateBack({});
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    diyWinColor: function(t) {
        var o = wx.getStorageSync("system");
        wx.setNavigationBarColor({
            frontColor: o.color,
            backgroundColor: o.fontcolor,
            animation: {
                duration: 400,
                timingFunc: "easeIn"
            }
        }), wx.setNavigationBarTitle({
            title: "可使用优惠券"
        });
    }
});