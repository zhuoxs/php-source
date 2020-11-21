var app = getApp(), Page = require("../../../../zhy/sdk/qitui/oddpush.js").oddPush(Page).Page;

Page({
    data: {
        title: "花迷你满天星勿忘我花束永生花ins礼盒限量100份"
    },
    onLoad: function(t) {
        var a = this;
        wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("fontcolor"),
            backgroundColor: wx.getStorageSync("color"),
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        }), a.url(), app.util.request({
            url: "entry/wxapp/integral",
            cachetime: "0",
            success: function(t) {
                a.setData({
                    integral: t.data
                });
            }
        }), app.util.request({
            url: "entry/wxapp/system",
            cachetime: "0",
            success: function(t) {
                a.setData({
                    integral_img: t.data.integral_img
                });
            }
        });
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
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    goGiftdetail: function(t) {
        wx.navigateTo({
            url: "../giftdetail/giftdetail?id=" + t.currentTarget.dataset.id
        });
    }
});