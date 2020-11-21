var app = getApp();

Page({
    data: {},
    onLoad: function(t) {
        console.log(t);
        var e = wx.getStorageSync("openid"), o = wx.getStorageSync("url"), n = this;
        app.util.request({
            url: "entry/wxapp/GetGiftOrderDetails",
            cachetime: "0",
            data: {
                id: t.id,
                openid: e
            },
            success: function(t) {
                console.log(t), n.setData({
                    url: o,
                    orderDetails: t.data.data
                });
            }
        });
    },
    confirm: function(t) {
        console.log(t);
        app.util.request({
            url: "entry/wxapp/CheckGiftOrder",
            cachetime: "30",
            data: {
                id: t.currentTarget.dataset.oid,
                openid: wx.getStorageSync("openid")
            },
            success: function(t) {
                console.log(t), 1 == t.data.data && (wx.showToast({
                    title: "确认成功！"
                }), wx.navigateBack({}));
            }
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