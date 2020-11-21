var app = getApp(), WxParse = require("../../wxParse/wxParse.js");

Page({
    data: {},
    onLoad: function(t) {
        var n = this, a = t.uid;
        console.log(t), app.util.request({
            url: "entry/wxapp/VipShow",
            data: {
                uid: a
            },
            success: function(t) {
                if (n.setData({
                    list: t.data
                }), t.data.banner.text) {
                    var a = t.data.banner.text;
                    WxParse.wxParse("content", "html", a, n, 15);
                }
            }
        }), n.getUrl();
    },
    getUrl: function() {
        var a = this;
        app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "30",
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
    onReachBottom: function() {}
});