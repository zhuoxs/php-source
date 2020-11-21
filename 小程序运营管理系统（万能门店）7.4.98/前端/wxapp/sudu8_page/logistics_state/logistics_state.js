var app = getApp();

Page({
    data: {
        baseurl: app.globalData.baseurl,
        uniacid: app.globalData.uniacid,
        kuaidi: "",
        kuaidihao: "",
        kd: 0
    },
    onLoad: function(a) {
        var t = this;
        a.kuaidi && t.setData({
            kuaidi: a.kuaidi
        }), a.kuaidihao && t.setData({
            kuaidihao: a.kuaidihao
        }), t.getBase(), t.KdSearch(), wx.stopPullDownRefresh();
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
    KdSearch: function() {
        var t = this;
        app.util.request({
            url: "entry/wxapp/KdSearch",
            data: {
                kuaidi: t.data.kuaidi,
                kuaidihao: t.data.kuaidihao
            },
            success: function(a) {
                -1 == a.data.data ? wx.showModal({
                    title: "提示",
                    content: "物流接口设置错误，请修改后重试！",
                    showCancel: !1
                }) : 0 < a.data.data.length ? t.setData({
                    kd: 1,
                    kdinfo: a.data.data
                }) : t.setData({
                    kd: 0
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