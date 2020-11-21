var app = getApp(), WxParse = require("../wxParse/wxParse.js");

Page({
    data: {},
    onLoad: function(a) {
        var t = this;
        app.util.request({
            url: "entry/wxapp/Base",
            success: function(a) {
                console.log(a), t.setData({
                    tell: a.data.data.yy_telphone,
                    yy_title: a.data.data.yy_title,
                    yy_address: a.data.data.yy_address,
                    latitude: a.data.data.latitude,
                    longitude: a.data.data.longitude,
                    baseinfo: a.data.data,
                    show_title: a.data.data.show_title,
                    yy_thumb: a.data.data.yy_thumb
                }), wx.setStorage({
                    key: "title",
                    data: a.data.data.show_title
                }), WxParse.wxParse("article", "html", a.data.data.yy_content, t, 5);
            },
            fail: function(a) {
                console.log(a);
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