var app = getApp(), WxParse = require("../wxParse/wxParse.js");

Page({
    data: {},
    onLoad: function(t) {
        var a = wx.getStorageSync("color");
        wx.setNavigationBarColor({
            frontColor: "#ffffff",
            backgroundColor: a
        });
        var e = t.title;
        wx.setNavigationBarTitle({
            title: e
        });
        var o = this;
        app.util.request({
            url: "entry/wxapp/Base",
            success: function(t) {
                console.log(t), o.setData({
                    tell: t.data.data.yy_telphone,
                    yy_title: t.data.data.yy_title,
                    yy_address: t.data.data.yy_address,
                    latitude: t.data.data.latitude,
                    longitude: t.data.data.longitude,
                    baseinfo: t.data.data,
                    show_title: t.data.data.show_title,
                    yy_thumb: t.data.data.yy_thumb
                }), wx.setStorage({
                    key: "title",
                    data: t.data.data.show_title
                }), WxParse.wxParse("article", "html", t.data.data.yy_content, o, 5);
            },
            fail: function(t) {
                console.log(t);
            }
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {}
});