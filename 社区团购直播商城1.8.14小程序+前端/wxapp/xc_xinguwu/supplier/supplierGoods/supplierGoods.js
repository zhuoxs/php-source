var app = getApp();

Page({
    data: {},
    onLoad: function(a) {
        a.id = 1, this.options = a, this.page = 1, this.pagesize = 20, this.loadend = !1;
        var o = this;
        app.util.request({
            url: "entry/wxapp/supplier",
            showLoading: !1,
            method: "post",
            data: {
                op: "loadSupplierGoods",
                page: 1,
                pagesize: o.pagesize,
                id: o.options.id
            },
            success: function(a) {
                var t = a.data;
                t.data.list && o.setData({
                    list: t.data.list
                });
            },
            fail: function(a) {
                app.look.alert(a.data.message), o.loadend = !0;
            }
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {
        var o = this;
        app.util.request({
            url: "entry/wxapp/supplier",
            showLoading: !0,
            method: "post",
            data: {
                op: "loadSupplierGoods",
                page: 1,
                pagesize: o.pagesize,
                id: o.options.id
            },
            success: function(a) {
                wx.stopPullDownRefresh();
                var t = a.data;
                t.data.list && (o.setData({
                    list: t.data.list
                }), o.page = 1, o.loadend = !1);
            },
            fail: function(a) {
                app.look.alert(a.data.message), o.loadend = !0, o.setData({
                    list: []
                });
            }
        });
    },
    onReachBottom: function() {
        if (!this.loadend) {
            var o = this;
            app.util.request({
                url: "entry/wxapp/supplier",
                showLoading: !0,
                method: "post",
                data: {
                    op: "loadSupplierGoods",
                    page: o.page + 1,
                    pagesize: o.pagesize,
                    id: o.options.id
                },
                success: function(a) {
                    var t = a.data;
                    t.data.list && (o.setData({
                        list: o.data.list.concat(t.data.list)
                    }), o.page += 1);
                },
                fail: function(a) {
                    app.look.alert(a.data.message), o.loadend = !0;
                }
            });
        }
    }
});