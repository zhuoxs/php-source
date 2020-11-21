var WxParse = require("../wxParse/wxParse.js"), app = getApp();

Page({
    data: {},
    onLoad: function(a) {
        var r = wx.getStorageSync("color");
        wx.setNavigationBarColor({
            frontColor: "#ffffff",
            backgroundColor: r
        });
        var t = this, e = a.id;
        app.util.request({
            url: "entry/wxapp/Informyjy",
            data: {
                id: e
            },
            success: function(a) {
                console.log(a), t.setData({
                    informage: a.data.data
                }), WxParse.wxParse("articles", "html", a.data.data.thumbarr, t, 5);
            }
        });
    }
});