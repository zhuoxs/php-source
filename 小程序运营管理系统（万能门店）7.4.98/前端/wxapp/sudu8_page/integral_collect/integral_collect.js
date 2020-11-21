var app = getApp();

Page({
    data: {},
    onLoad: function(a) {
        var t = this;
        wx.setNavigationBarTitle({
            title: "获取积分"
        }), t.getBase(), app.util.request({
            url: "entry/wxapp/scoreget",
            success: function(a) {
                t.setData({
                    guiz: a.data.data.guiz
                });
            }
        });
    },
    getBase: function() {
        var t = this;
        app.util.request({
            url: "entry/wxapp/BaseMin",
            cachetime: "30",
            data: {
                vs1: 1
            },
            success: function(a) {
                t.setData({
                    baseinfo: a.data.data
                }), wx.setNavigationBarColor({
                    frontColor: t.data.baseinfo.base_tcolor,
                    backgroundColor: t.data.baseinfo.base_color
                });
            },
            fail: function(a) {}
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {
        wx.stopPullDownRefresh();
    },
    onReachBottom: function() {},
    onShareAppMessage: function() {}
});