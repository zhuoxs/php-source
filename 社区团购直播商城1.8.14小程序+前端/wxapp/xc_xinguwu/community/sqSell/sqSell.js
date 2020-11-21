var app = getApp();

Page({
    data: {
        curIndex: 2,
        page: 1,
        pagesize: 15,
        loadend: !1
    },
    change: function(a) {
        var t = a.currentTarget.dataset.index;
        this.setData({
            curIndex: t,
            list: []
        });
        var e = this;
        app.util.request({
            url: "entry/wxapp/community",
            showLoading: !0,
            method: "POST",
            data: {
                op: "getSell",
                club_id: e.data.options.club_id,
                curIndex: e.data.curIndex
            },
            success: function(a) {
                var t = a.data;
                console.log(t), e.setData({
                    brokerage: t.data.brokerage,
                    number: t.data.number,
                    num: t.data.num
                });
            }
        }), app.util.request({
            url: "entry/wxapp/community",
            showLoading: !1,
            method: "POST",
            data: {
                op: "loadSell",
                club_id: e.data.options.club_id,
                curIndex: e.data.curIndex,
                page: 1,
                pagesize: e.data.pagesize
            },
            success: function(a) {
                var t = a.data;
                t.data.list && e.setData({
                    list: t.data.list,
                    page: 1,
                    loadend: !1
                });
            },
            fail: function(a) {
                app.look.alert(a.data.message), e.setData({
                    loadned: !0
                });
            }
        });
    },
    onLoad: function(a) {
        var e = this;
        e.setData({
            options: a
        }), app.util.request({
            url: "entry/wxapp/community",
            showLoading: !1,
            method: "POST",
            data: {
                op: "getSell",
                club_id: e.data.options.club_id,
                curIndex: e.data.curIndex
            },
            success: function(a) {
                var t = a.data;
                console.log(t), e.setData({
                    brokerage: t.data.brokerage,
                    number: t.data.number,
                    num: t.data.num
                });
            }
        }), app.util.request({
            url: "entry/wxapp/community",
            showLoading: !1,
            method: "POST",
            data: {
                op: "loadSell",
                club_id: e.data.options.club_id,
                curIndex: e.data.curIndex,
                page: 1,
                pagesize: e.data.pagesize
            },
            success: function(a) {
                var t = a.data;
                t.data.list && e.setData({
                    list: t.data.list
                });
            },
            fail: function(a) {
                app.look.alert(a.data.message), e.setData({
                    loadend: !0
                });
            }
        });
    },
    onReady: function() {
        var a = {};
        a.sq_sell_bg = app.module_url + "resource/wxapp/community/sq-sell-bg.png", this.setData({
            images: a
        });
    },
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
                op: "loadSell",
                club_id: e.data.options.club_id,
                curIndex: e.data.curIndex,
                page: 1,
                pagesize: e.data.pagesize
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
                url: "entry/wxapp/community",
                showLoading: !0,
                method: "POST",
                data: {
                    op: "loadSell",
                    club_id: e.data.options.club_id,
                    curIndex: e.data.curIndex,
                    page: e.data.page + 1,
                    pagesize: e.data.pagesize
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