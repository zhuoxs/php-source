var app = getApp();

Page({
    data: {},
    onsubmit: function(n) {
        var o = n.detail.value.z_tw_money, t = (wx.getStorageSync("openid"), this.data.id);
        app.util.request({
            url: "entry/wxapp/Questiommm",
            data: {
                id: t,
                z_tw_money: o
            },
            success: function(n) {
                wx.showToast({
                    title: "设置成功",
                    icon: "success",
                    duration: 800
                });
            },
            fail: function(n) {
                console.log(n);
            }
        });
    },
    onLoad: function(n) {
        var o = n.id;
        this.setData({
            id: o
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