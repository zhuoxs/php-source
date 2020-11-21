var o = getApp(), n = o.requirejs("core");

o.requirejs("jquery"), o.requirejs("foxui");

Page({
    data: {},
    onLoad: function(o) {
        var e = this;
        n.post("groups.goods.play", {}, function(o) {
            e.setData({
                rules: o.rules
            });
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