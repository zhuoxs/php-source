var app = getApp();

Page({
    data: {
        page: 1,
        pagesize: 20,
        loadend: !1
    },
    toDelete: function(a) {
        var e = this, s = a.currentTarget.dataset.index;
        wx.showActionSheet({
            itemList: [ "取消关注" ],
            success: function(a) {
                switch (a.tapIndex) {
                  case 0:
                    app.util.request({
                        url: "entry/wxapp/live",
                        method: "POST",
                        showLoading: !0,
                        data: {
                            op: "live_focus_change",
                            id: e.data.list[s].id,
                            status: -1
                        },
                        success: function(a) {
                            app.look.ok(a.data.message);
                            var t = e.data.list;
                            console.log(s), t.splice(s, 1), e.setData({
                                list: t
                            });
                        },
                        fail: function(a) {
                            app.look.no(a.data.message);
                        }
                    });
                }
            }
        });
    },
    onLoad: function(a) {
        var e = this;
        e.setData({
            options: a
        }), app.util.request({
            url: "entry/wxapp/live",
            method: "POST",
            showLoading: !1,
            data: {
                op: "myhome",
                id: e.data.options.id,
                page: e.data.page,
                pagesize: e.data.pagesize,
                style: e.data.options.style
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
    onReady: function() {
        1 == this.data.options.style ? wx.setNavigationBarTitle({
            title: "我的关注"
        }) : wx.setNavigationBarTitle({
            title: "我的粉丝"
        });
        var a = {};
        a.living = app.module_url + "resource/wxapp/live/living.png", this.setData({
            images: a
        });
    },
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {
        var e = this;
        app.util.request({
            url: "entry/wxapp/live",
            method: "POST",
            showLoading: !0,
            data: {
                op: "myhome",
                id: e.data.options.id,
                page: 1,
                pagesize: e.data.pagesize,
                style: e.data.options.style
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
                    loadend: !0
                });
            }
        });
    },
    onReachBottom: function() {
        if (!this.data.loadend) {
            var e = this;
            app.util.request({
                url: "entry/wxapp/live",
                method: "POST",
                showLoading: !0,
                data: {
                    op: "myhome",
                    id: e.data.options.id,
                    page: e.data.page + 1,
                    pagesize: e.data.pagesize,
                    style: e.data.options.style
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
    }
});