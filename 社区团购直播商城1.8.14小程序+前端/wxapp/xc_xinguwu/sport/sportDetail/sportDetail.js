function _defineProperty(t, a, e) {
    return a in t ? Object.defineProperty(t, a, {
        value: e,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : t[a] = e, t;
}

var app = getApp(), that = void 0;

Page({
    data: {},
    sureDelivery: function() {
        var o = this;
        app.util.request({
            url: "entry/wxapp/sport",
            showLoading: !0,
            method: "POST",
            data: {
                op: "sureDelivery",
                id: o.data.list.id
            },
            success: function(t) {
                app.look.ok(t.data.message), o.setData(_defineProperty({}, "list.status", 3));
                var e = getCurrentPages();
                e[e.length - 2].data.list.forEach(function(t, a) {
                    t.id == o.data.list.id && e[e.length - 2].setData(_defineProperty({}, "list[" + a + "].status", 2));
                });
            },
            fail: function(t) {
                app.look.no(t.data.message);
            }
        });
    },
    onLoad: function(t) {
        var e = this;
        this.setData({
            options: t
        }), app.util.request({
            url: "entry/wxapp/sport",
            showLoading: !1,
            method: "POST",
            data: {
                op: "getOrderDetail",
                id: t.id
            },
            success: function(t) {
                var a = t.data;
                a.data.list && e.setData({
                    list: a.data.list
                });
            }
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {
        var e = this;
        app.util.request({
            url: "entry/wxapp/sport",
            showLoading: !0,
            method: "POST",
            data: {
                op: "getOrderDetail",
                id: e.data.options.id
            },
            success: function(t) {
                wx.stopPullDownRefresh();
                var a = t.data;
                a.data.list && e.setData({
                    list: a.data.list
                });
            }
        });
    },
    onReachBottom: function() {}
});