var app = getApp();

Page({
    data: {
        problem: []
    },
    onLoad: function(n) {},
    onReady: function() {},
    onShow: function() {
        var o = this;
        app.util.request({
            url: "entry/wxapp/Help",
            success: function(n) {
                console.log(n), o.setData({
                    problem: n.data
                });
            }
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {}
});