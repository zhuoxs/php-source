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
    goBargain: function(a) {
        var n = wx.getStorageSync("bid"), e = a.currentTarget.dataset.pic;
        app.util.request({
            url: "entry/wxapp/kjActiveStatus",
            cachetime: "0",
            data: {
                id: a.currentTarget.dataset.id
            },
            success: function(t) {
                console.log(t.data), 1 == t.data ? wx.navigateTo({
                    url: "/ymktv_sun/pages/booking/bargain/bargain?id=" + a.currentTarget.dataset.id + "&bid=" + n + "&pic=" + e
                }) : 0 == t.data ? wx.showToast({
                    title: "活动尚未开始！",
                    icon: "none",
                    duration: 2e3
                }) : wx.showToast({
                    title: "活动已结束！",
                    icon: "none",
                    duration: 2e3
                });
            }
        });
    },
    onReady: function() {},
    onShow: function() {
        var a = this, t = wx.getStorageSync("bid");
        app.util.request({
            url: "entry/wxapp/kanallData",
            cachetime: "0",
            data: {
                bid: t
            },
            success: function(t) {
                console.log(t.data), a.setData({
                    allData: t.data
                });
            }
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {}
});