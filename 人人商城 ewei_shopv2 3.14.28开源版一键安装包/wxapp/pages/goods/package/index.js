var n = getApp(), o = n.requirejs("core");

n.requirejs("icons"), n.requirejs("jquery");

Page({
    data: {
        show: !0
    },
    onLoad: function(n) {
        var e = this;
        o.get("package.get_list", {
            goodsid: n.id
        }, function(n) {
            e.setData({
                list: n.list
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