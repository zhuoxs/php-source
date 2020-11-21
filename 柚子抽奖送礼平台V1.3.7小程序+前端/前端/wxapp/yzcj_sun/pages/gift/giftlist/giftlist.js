var app = getApp(), Page = require("../../../../zhy/sdk/qitui/oddpush.js").oddPush(Page).Page;

Page({
    data: {
        imgUrls: [],
        listIndex: 0,
        listAll: []
    },
    onLoad: function(t) {
        var a = wx.getStorageSync("user_info");
        this.setData({
            userInfo: a
        });
    },
    onReady: function() {},
    onShow: function() {
        var a = this;
        app.util.request({
            url: "entry/wxapp/AllGifts",
            data: {},
            success: function(t) {
                console.log(t.data), a.setData({
                    imgUrls: t.data.giftsbanner,
                    list: t.data.type,
                    daily: t.data.daily
                }), a.getUrl();
            }
        });
    },
    getUrl: function() {
        var a = this;
        app.util.request({
            url: "entry/wxapp/url",
            cachetime: "0",
            success: function(t) {
                wx.setStorageSync("url", t.data), a.setData({
                    url: t.data
                });
            }
        });
    },
    goXcx: function(t) {
        var a = t.currentTarget.dataset.appid;
        if (null != t.currentTarget.dataset.url) var e = t.currentTarget.dataset.url; else e = "";
        console.log(e), wx.navigateToMiniProgram({
            appId: a,
            path: e,
            extraData: {
                foo: "bar"
            },
            envVersion: "develop",
            success: function(t) {
                console.log(t);
            }
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    changeIndex: function(t) {
        var a = t.currentTarget.dataset.index;
        this.setData({
            listIndex: a
        });
    },
    goGiftlistdetail: function(t) {
        var a = t.currentTarget.dataset.id;
        0 != a && wx.navigateTo({
            url: "../giftlistdetail/giftlistdetail?id=" + a
        });
    }
});