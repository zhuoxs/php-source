var app = getApp();

Page({
    data: {},
    onLoad: function(o) {},
    onReady: function() {
        var o = {};
        o.sport_submit_success = app.module_url + "resource/wxapp/sport/sport-submit-success.png", 
        this.setData({
            images: o
        });
    },
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {}
});