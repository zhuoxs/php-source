var app = getApp();

Page({
    data: {},
    onLoad: function(o) {
        var n = wx.getStorageSync("color");
        wx.setNavigationBarColor({
            frontColor: "#ffffff",
            backgroundColor: n
        });
    },
    onReady: function() {
        this.getBase();
    },
    getBase: function() {
        var n = this;
        console.log(app), app.util.request({
            url: "entry/wxapp/Base",
            cachetime: "30",
            success: function(o) {
                n.setData({
                    baseinfo: o.data.data
                }), wx.setNavigationBarTitle({
                    title: n.data.baseinfo.show_title
                });
            },
            fail: function(o) {
                console.log(o);
            }
        });
    },
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {
        wx.showNavigationBarLoading(), setTimeout(function() {
            wx.hideNavigationBarLoading(), wx.stopPullDownRefresh();
        }, 1e3);
    },
    onReachBottom: function() {},
    onShareAppMessage: function() {}
});