var app = getApp();

Page({
    data: {},
    onLoad: function(n) {
        console.log(n);
        var o = new app.util.date();
        n.time = o.dateToStr("yyyy-MM-dd HH:mm:ss"), this.setData({
            options: n
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {}
});