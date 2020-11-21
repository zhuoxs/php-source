var app = getApp();

Page({
    data: {
        miaoshu: ""
    },
    onLoad: function(n) {
        var o = this, a = n.id;
        app.util.request({
            url: "entry/wxapp/Orderguan",
            data: {
                id: a
            },
            success: function(n) {
                o.setData({
                    fenli: n.data.data
                });
            },
            fail: function(n) {
                console.log(n);
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