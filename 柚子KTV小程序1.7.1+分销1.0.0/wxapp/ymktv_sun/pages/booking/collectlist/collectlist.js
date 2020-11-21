var app = getApp(), Page = require("../../../../zhy/sdk/qitui/oddpush.js").oddPush(Page).Page;

Page({
    data: {},
    onLoad: function(t) {
        wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("fontcolor"),
            backgroundColor: wx.getStorageSync("color"),
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        }), this.url();
    },
    url: function(t) {
        var a = this;
        app.util.request({
            url: "entry/wxapp/Url2",
            cachetime: "0",
            success: function(t) {
                wx.setStorageSync("url2", t.data);
            }
        }), app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "0",
            success: function(t) {
                wx.setStorageSync("url", t.data), a.setData({
                    url: t.data
                });
            }
        });
    },
    goCard: function(a) {
        var e = wx.getStorageSync("bid"), n = a.currentTarget.dataset.pic;
        app.util.request({
            url: "entry/wxapp/jkActiveing",
            cachetime: "0",
            data: {
                id: a.currentTarget.dataset.id,
                bid: e
            },
            success: function(t) {
                console.log(t.data), 1 == t.data ? wx.showToast({
                    title: "活动已结束！",
                    icon: "none",
                    duration: 2e3
                }) : 2 == t.data ? wx.showToast({
                    title: "活动尚未开启！",
                    icon: "none",
                    duration: 2e3
                }) : wx.navigateTo({
                    url: "/ymktv_sun/pages/booking/card/card?id=" + a.currentTarget.dataset.id + "&bid=" + e + "&pic=" + n
                });
            }
        });
    },
    onReady: function() {},
    onShow: function() {
        var a = this, t = wx.getStorageSync("bid");
        app.util.request({
            url: "entry/wxapp/Cardcollecting",
            cachetime: "0",
            data: {
                bid: t
            },
            success: function(t) {
                console.log(t.data), a.setData({
                    Card: t.data
                });
            }
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {}
});