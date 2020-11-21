var app = getApp();

Page({
    data: {
        check: !1,
        page: 1,
        pagesize: 20,
        loadend: !1
    },
    selechedAll: function() {
        this.setData({
            check: !this.data.check
        });
    },
    search: function(a) {
        console.log(a);
        var t = a.detail.value;
        "" == t && app.look.alert("订单号为空"), app.util.request({
            url: "entry/wxapp/community",
            showLoading: !0,
            method: "POST",
            data: {
                op: "loadClubFastGet",
                page: 1,
                pagesize: that.data.pagesize,
                club_id: that.data.options.club_id,
                order: t
            },
            success: function(a) {
                that.setData({
                    list: a.data.data.list,
                    loadend: !0
                });
            },
            fail: function(a) {
                app.look.alert("没有查询到该订单"), that.setData({
                    loadend: !0
                });
            }
        });
    },
    myform: function(a) {
        console.log(a);
        var i = this, l = a.detail.value.order_ids;
        0 != l.length ? app.util.request({
            url: "entry/wxapp/community",
            showLoading: !1,
            method: "POST",
            data: {
                op: "fastGet",
                ids: l
            },
            success: function(a) {
                app.look.ok(a.data.message);
                for (var t = i.data.list, e = 0; e < t.length; e++) {
                    console.log(e), console.log(t);
                    for (var o = 0, s = l.length; o < s; o++) if (t[e].id == l[o]) {
                        t.splice(e, 1), e--;
                        break;
                    }
                }
                console.log(t), i.setData({
                    list: t,
                    check: !1
                });
            },
            fail: function(a) {
                app.look.no(a.data.message);
            }
        }) : app.look.alert("请先选择内容");
    },
    onLoad: function(a) {
        this.setData({
            options: a
        });
        var e = this;
        app.util.request({
            url: "entry/wxapp/community",
            showLoading: !1,
            method: "POST",
            data: {
                op: "loadClubFastGet",
                page: 1,
                pagesize: e.data.pagesize,
                club_id: e.data.options.club_id
            },
            success: function(a) {
                var t = a.data;
                t.data.list && (console.log(t.data.list), e.setData({
                    list: t.data.list
                }));
            },
            fail: function(a) {
                app.look.alert(a.data.message), e.setData({
                    loadend: !0
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
            url: "entry/wxapp/community",
            showLoading: !0,
            method: "POST",
            data: {
                op: "loadClubFastGet",
                page: 1,
                pagesize: e.data.pagesize,
                club_id: e.data.options.club_id
            },
            success: function(a) {
                wx.stopPullDownRefresh();
                var t = a.data;
                t.data.list && e.setData({
                    list: t.data.list,
                    page: 1,
                    loadend: !1
                });
            },
            fail: function(a) {
                app.look.alert(a.data.message), e.setData({
                    loadend: !0,
                    list: []
                });
            }
        });
    },
    onReachBottom: function() {
        if (!this.data.loadend) {
            var e = this;
            app.util.request({
                url: "entry/wxapp/community",
                showLoading: !0,
                method: "POST",
                data: {
                    op: "loadClubFastGet",
                    page: e.data.page + 1,
                    pagesize: e.data.pagesize,
                    club_id: e.data.options.club_id
                },
                success: function(a) {
                    var t = a.data;
                    t.data.list && e.setData({
                        list: e.data.list.concat(t.data.list),
                        page: e.data.page + 1
                    });
                },
                fail: function(a) {
                    app.look.alert(a.data.message), e.setData({
                        loadend: !0
                    });
                }
            });
        }
    },
    onShareAppMessage: function() {}
});