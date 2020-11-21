var app = getApp();

Page({
    data: {},
    scan: function() {
        wx.scanCode({
            success: function(a) {
                var t = a.result;
                app.util.request({
                    url: "entry/wxapp/manage",
                    showLoading: !0,
                    data: {
                        op: "query_order",
                        text: t
                    },
                    success: function(a) {
                        var t = a.data.data;
                        wx.navigateTo({
                            url: "../mSend/mSend?id=" + t
                        });
                    }
                });
            }
        });
    },
    myOrder: function() {
        wx.navigateTo({
            url: "../mList/mList"
        });
    },
    onLoad: function(a) {
        var n = this;
        app.util.request({
            url: "entry/wxapp/manage",
            showLoading: !1,
            data: {
                op: "management"
            },
            success: function(a) {
                var t = a.data;
                t.data.list && n.setData({
                    list: t.data.list
                });
            }
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {
        var n = this;
        app.util.request({
            url: "entry/wxapp/manage",
            showLoading: !0,
            data: {
                op: "management"
            },
            success: function(a) {
                wx.stopPullDownRefresh();
                var t = a.data;
                t.data.list && n.setData({
                    list: t.data.list
                });
            }
        });
    },
    onReachBottom: function() {},
    onShareAppMessage: function() {}
});