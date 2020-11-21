var app = getApp();

Page({
    data: {},
    onLoad: function(a) {
        var o = this;
        if (a.id) {
            var t = a.id;
            o.setData({
                id: t
            }), app.util.request({
                url: "entry/wxapp/my",
                data: {
                    op: "refund_detail",
                    id: t
                },
                success: function(a) {
                    var t = a.data;
                    console.log(t.data.order), t.data && t.data.order && o.setData({
                        order: t.data.order
                    });
                }
            });
        }
    },
    onReady: function() {
        app.look.navbar(this);
    },
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {
        var o = this, a = this.data.id;
        "" != a ? app.util.request({
            url: "entry/wxapp/my",
            data: {
                op: "refund_detail",
                id: a
            },
            success: function(a) {
                wx.stopPullDownRefresh();
                var t = a.data;
                console.log(t.data.order), t.data && t.data.order && o.setData({
                    order: t.data.order
                });
            }
        }) : wx.stopPullDownRefresh();
    },
    onReachBottom: function() {}
});