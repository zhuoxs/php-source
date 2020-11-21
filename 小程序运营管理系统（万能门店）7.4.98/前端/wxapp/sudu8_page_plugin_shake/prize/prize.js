var app = getApp();

Page({
    data: {},
    onPullDownRefresh: function() {
        wx.stopPullDownRefresh();
    },
    onLoad: function(o) {
        var n = this;
        o.id && (n.data.id = o.id), wx.setNavigationBarTitle({
            title: "奖品列表"
        }), wx.setNavigationBarColor({
            frontColor: "#ffffff",
            backgroundColor: o.nav_color ? o.nav_color : "#FEA049"
        }), app.util.request({
            url: "entry/wxapp/getPrizeList",
            data: {
                id: o.id
            },
            success: function(o) {
                n.setData({
                    prizes: o.data.data
                });
            }
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {}
});