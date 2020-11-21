var app = getApp();

Page({
    data: {},
    onLoad: function(n) {},
    onReady: function() {
        this.getBase();
    },
    getBase: function() {
        var o = this;
        console.log(app), app.util.request({
            url: "entry/wxapp/Base",
            cachetime: "30",
            success: function(n) {
                o.setData({
                    baseinfo: n.data.data
                }), wx.setNavigationBarTitle({
                    title: o.data.baseinfo.show_title
                });
            },
            fail: function(n) {
                console.log(n);
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