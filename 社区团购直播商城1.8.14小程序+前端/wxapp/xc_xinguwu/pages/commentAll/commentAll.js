var app = getApp();

Page({
    data: {
        navIndex: 0,
        grade: [ 1, 2, 3, 4, 5 ]
    },
    changeNav: function(a) {
        console.log(a);
        var o = this, t = a.currentTarget.dataset.index;
        o.setData({
            navIndex: t,
            list: []
        }), this.options.page = 1, this.options.loadend = !1, app.util.request({
            url: "entry/wxapp/my",
            showLoading: !0,
            method: "POST",
            data: {
                op: "commentAll",
                page: 1,
                pagesize: o.options.pagesize,
                id: o.options.id,
                navIndex: t
            },
            success: function(a) {
                var t = a.data;
                t.data.list && o.setData({
                    list: t.data.list
                });
            },
            fail: function(a) {
                app.look.alert(a.data.message), o.options.loadend = !0;
            }
        });
    },
    onLoad: function(a) {
        a.page = 1, a.pagesize = 10, a.loadend = !1, this.options = a;
        var o = this;
        app.util.request({
            url: "entry/wxapp/my",
            showLoading: !1,
            method: "POST",
            data: {
                op: "commentAllNav",
                id: o.options.id
            },
            success: function(a) {
                var t = a.data;
                t.data.list && o.setData({
                    nav: t.data.list
                });
            }
        }), app.util.request({
            url: "entry/wxapp/my",
            showLoading: !1,
            method: "POST",
            data: {
                op: "commentAll",
                page: 1,
                pagesize: o.options.pagesize,
                id: o.options.id,
                navIndex: o.data.navIndex
            },
            success: function(a) {
                var t = a.data;
                t.data.list && o.setData({
                    list: t.data.list
                });
            },
            fail: function(a) {
                app.look.alert(a.data.message), o.options.loadend = !0;
            }
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {
        if (!this.options.loadend) {
            var o = this;
            app.util.request({
                url: "entry/wxapp/my",
                showLoading: !1,
                method: "POST",
                data: {
                    op: "commentAll",
                    page: o.options.page + 1,
                    pagesize: o.options.pagesize,
                    id: o.options.id,
                    navIndex: o.data.navIndex
                },
                success: function(a) {
                    var t = a.data;
                    t.data.list && (o.setData({
                        list: o.data.list.concat(t.data.list)
                    }), o.options.page = o.options.page + 1);
                },
                fail: function(a) {
                    app.look.alert(a.data.message), o.options.loadend = !0;
                }
            });
        }
    },
    onShareAppMessage: function() {}
});