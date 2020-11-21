var WxParse = require("../../../wxParse/wxParse.js"), app = getApp();

Page({
    data: {
        logs: []
    },
    onLoad: function() {
        var a = app.globalData.Headcolor;
        this.Notice(), this.setData({
            backgroundColor: a
        });
    },
    Notice: function() {
        var e = this;
        app.util.request({
            url: "entry/wxapp/Notice",
            method: "POST",
            success: function(a) {
                var t = a.data.data;
                e.setData({
                    Notice: t
                });
            }
        });
    }
});