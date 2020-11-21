var app = getApp();

Page({
    data: {},
    onLoad: function(a) {
        var o = this;
        app.util.request({
            url: "entry/wxapp/System",
            data: {
                m: app.globalData.Plugin_scoretask
            },
            success: function(a) {
                console.log("关于我们的"), console.log(a.data), o.setData({
                    aboutUs: a.data
                });
            }
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {}
});