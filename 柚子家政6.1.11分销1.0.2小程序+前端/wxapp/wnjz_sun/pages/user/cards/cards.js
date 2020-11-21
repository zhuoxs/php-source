var app = getApp();

Page({
    data: {
        cards: [],
        order: [ "未使用", "已使用" ],
        curIdenx: 0
    },
    onLoad: function(n) {
        wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("fontcolor"),
            backgroundColor: wx.getStorageSync("color"),
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        });
    },
    navTab: function(n) {
        var o = n.currentTarget.dataset.index;
        this.setData({
            curIdenx: o
        });
    },
    onReady: function() {},
    onShow: function() {
        var n = wx.getStorageSync("openid"), o = wx.getStorageSync("build_id"), t = this;
        app.util.request({
            url: "entry/wxapp/UserCounpPay",
            method: "GET",
            data: {
                userid: n,
                build_id: o
            },
            success: function(n) {
                console.log(n.data), t.setData({
                    nouser: n.data.Nouser,
                    user: n.data.user
                });
            }
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    toOrder: function(n) {
        wx.navigateTo({
            url: "/wnjz_sun/pages/index/classify/classify"
        });
    }
});