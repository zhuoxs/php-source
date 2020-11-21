!function(n) {
    n && n.__esModule;
}(require("../../util/request.js"));

var n = getApp();

Page({
    data: {},
    onLoad: function(n) {
        var o = this, t = n.weburl;
        o.setData({
            weburl: t
        });
    },
    onReady: function() {
        n.util.footer(this);
    },
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {}
});