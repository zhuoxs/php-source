var app = getApp();

Page({
    data: {},
    tonadf: function(a) {
        var t = a.currentTarget.dataset.id;
        wx.redirectTo({
            url: "../manageOrderDetail/manageOrderDetail?id=" + t
        });
    },
    onLoad: function(a) {
        var n = this;
        n.setData({
            options: a
        }), app.util.request({
            url: "entry/wxapp/manage",
            showLoading: !1,
            data: {
                op: "msendsucess",
                id: a.id
            },
            success: function(a) {
                var t = a.data;
                console.log(t), t.data.top && n.setData({
                    top: t.data.top
                }), t.data.down && n.setData({
                    down: t.data.down
                });
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