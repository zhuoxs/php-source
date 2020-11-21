var WxParse = require("../wxParse/wxParse.js"), app = getApp();

Page({
    data: {},
    onLoad: function(a) {
        var r = wx.getStorageSync("color");
        wx.setNavigationBarColor({
            frontColor: "#ffffff",
            backgroundColor: r
        });
        var t = this, e = a.id, o = app.siteInfo.uniacid;
        app.util.request({
            url: "entry/wxapp/Informage",
            data: {
                id: e,
                uniacid: o
            },
            success: function(a) {
                console.log(a), t.setData({
                    informage: a.data.data
                }), WxParse.wxParse("articles", "html", a.data.data.thumbarr, t, 5);
            }
        });
    }
});