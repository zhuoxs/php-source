var app = getApp();

Page({
    data: {},
    onLoad: function(t) {
        var o = this;
        app.util.request({
            url: "entry/wxapp/distribution",
            showLoading: !1,
            data: {
                op: "deposit"
            },
            success: function(t) {
                var a = t.data;
                console.log(a.data.list), a.data.list && o.setData({
                    list: a.data.list
                });
            }
        });
    },
    onReady: function() {
        app.look.navbar(this);
    },
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {
        var o = this;
        app.util.request({
            url: "entry/wxapp/distribution",
            showLoading: !1,
            data: {
                op: "deposit"
            },
            success: function(t) {
                wx.stopPullDownRefresh();
                var a = t.data;
                a.data.list && o.setData({
                    list: a.data.list
                });
            }
        });
    },
    onReachBottom: function() {}
});