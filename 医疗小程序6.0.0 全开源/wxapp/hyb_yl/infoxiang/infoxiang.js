var WxParse = require("../wxParse/wxParse.js"), app = getApp();

Page({
    data: {},
    onLoad: function(a) {
        var t = this, e = a.id, r = app.siteInfo.uniacid;
        app.util.request({
            url: "entry/wxapp/Informage",
            data: {
                id: e,
                uniacid: r
            },
            success: function(a) {
                console.log(a), t.setData({
                    informage: a.data.data
                }), WxParse.wxParse("articles", "html", a.data.data.thumbarr, t, 5);
            }
        });
    }
});