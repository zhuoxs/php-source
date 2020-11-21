function _defineProperty(a, t, e) {
    return t in a ? Object.defineProperty(a, t, {
        value: e,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : a[t] = e, a;
}

var app = getApp();

function countNum(a) {
    for (var t = 0, e = a.length; t < e; t++) for (var s = 0, i = a[t].list.length; s < i; s++) {
        var n = 0;
        for (var o in a[t].list[s].attrs) n += parseInt(a[t].list[s].attrs[o]);
        a[t].list[s].num = n;
    }
    return a;
}

Page({
    data: {
        navIndex: 0,
        list: []
    },
    search: function(a) {
        console.log(a);
        var t = a.detail.value;
        if ("" != t) {
            var e = this;
            e.setData({
                navIndex: 0
            }), e.loadend = !0, app.util.request({
                url: "entry/wxapp/supplier",
                showLoading: !0,
                method: "POST",
                data: {
                    op: "loadSupplierOrder",
                    page: 0,
                    pagesize: e.pagesize,
                    search: t
                },
                success: function(a) {
                    var t = a.data;
                    t.data.list && e.setData({
                        list: t.data.list
                    });
                },
                fail: function(a) {
                    app.look.alert("没有查到你要的结果"), e.setData({
                        list: []
                    });
                }
            });
        }
    },
    changeNav: function(a) {
        var t = a.currentTarget.dataset.index;
        this.setData({
            navIndex: t
        });
        var e = this;
        app.util.request({
            url: "entry/wxapp/supplier",
            showLoading: !0,
            method: "POST",
            data: {
                op: "loadSupplierOrder",
                page: 0,
                pagesize: e.pagesize,
                curIndex: t
            },
            success: function(a) {
                var t = a.data;
                t.data.list && (e.setData({
                    list: countNum(t.data.list)
                }), e.loadend = !1);
            },
            fail: function(a) {
                app.look.alert(a.data.message), e.loadend = !0, e.setData({
                    list: []
                });
            }
        });
    },
    confirmDelivery: function(a) {
        var s = a.currentTarget.dataset.index, t = this.data.list[s].id, i = this;
        app.util.request({
            url: "entry/wxapp/supplier",
            showLoading: !0,
            data: {
                op: "confirmDelivery",
                id: t
            },
            success: function(a) {
                if (app.look.ok(a.data.message), 0 == i.data.navIndex) {
                    var t;
                    i.setData((_defineProperty(t = {}, "list[" + s + "].status", 2), _defineProperty(t, "list[" + s + "].deliver_time", a.data.data), 
                    t));
                } else {
                    var e = i.data.list;
                    e.splice(s, 1), i.setData({
                        list: e
                    });
                }
            }
        });
    },
    onLoad: function(a) {
        this.pagesize = 20, this.loadend = !1;
        var e = this;
        app.util.request({
            url: "entry/wxapp/supplier",
            showLoading: !1,
            method: "POST",
            data: {
                op: "loadSupplierOrder",
                page: 0,
                pagesize: e.pagesize,
                curIndex: e.data.navIndex
            },
            success: function(a) {
                var t = a.data;
                console.log(t.data.list), t.data.list && e.setData({
                    list: countNum(t.data.list)
                });
            },
            fail: function(a) {
                app.look.alert(a.data.message), e.loadend = !0;
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
            url: "entry/wxapp/supplier",
            showLoading: !0,
            method: "POST",
            data: {
                op: "loadSupplierOrder",
                page: 0,
                pagesize: e.pagesize,
                curIndex: e.data.navIndex
            },
            success: function(a) {
                wx.stopPullDownRefresh();
                var t = a.data;
                t.data.list && (e.setData({
                    list: countNum(t.data.list)
                }), e.loadend = !1);
            },
            fail: function(a) {
                app.look.alert(a.data.message), e.loadend = !0, e.setData({
                    list: []
                });
            }
        });
    },
    onReachBottom: function() {
        if (!this.loadend) {
            var e = this;
            app.util.request({
                url: "entry/wxapp/supplier",
                showLoading: !0,
                method: "POST",
                data: {
                    op: "loadSupplierOrder",
                    page: e.data.list.length,
                    pagesize: e.pagesize,
                    curIndex: e.data.navIndex
                },
                success: function(a) {
                    wx.stopPullDownRefresh();
                    var t = a.data;
                    t.data.list && e.setData({
                        list: e.data.list.concat(countNum(t.data.list))
                    });
                },
                fail: function(a) {
                    app.look.alert(a.data.message), e.loadend = !0;
                }
            });
        }
    }
});