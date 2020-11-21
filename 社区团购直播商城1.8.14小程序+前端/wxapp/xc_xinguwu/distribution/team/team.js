var app = getApp();

Page({
    data: {
        curIndex: 1,
        pagesize: 20,
        loadend: !1
    },
    bindTap: function(a) {
        var t = parseInt(a.currentTarget.dataset.index);
        this.setData({
            curIndex: t,
            list: []
        });
        var e = this;
        app.util.request({
            url: "entry/wxapp/distribution",
            showLoading: !1,
            data: {
                op: "get_team",
                status: e.data.curIndex,
                row: 0,
                pagesize: e.data.pagesize
            },
            success: function(a) {
                var t = a.data;
                t.data.list && e.setData({
                    list: t.data.list
                });
            },
            fail: function() {
                e.setData({
                    loadend: !0
                });
            }
        });
    },
    onLoad: function(a) {
        var e = this;
        e.setData({
            "goHome.blackhomeimg": app.globalData.blackhomeimg,
            retail_grade: app.globalData.webset.retail_grade
        }), app.util.request({
            url: "entry/wxapp/distribution",
            showLoading: !1,
            data: {
                op: "get_team",
                status: e.data.curIndex,
                row: 0,
                pagesize: e.data.pagesize
            },
            success: function(a) {
                var t = a.data;
                console.log(t.data.list), t.data.list && e.setData({
                    list: t.data.list
                });
            },
            fail: function() {
                e.setData({
                    loadend: !0
                });
            }
        });
    },
    onReady: function() {
        app.look.navbar(this);
    },
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {
        var e = this;
        app.util.request({
            url: "entry/wxapp/distribution",
            showLoading: !1,
            data: {
                op: "get_team",
                status: e.data.curIndex,
                row: 0,
                pagesize: e.data.pagesize
            },
            success: function(a) {
                wx.stopPullDownRefresh();
                var t = a.data;
                t.data.lsit && e.setData({
                    list: t.data.list,
                    loadend: !1
                });
            },
            fail: function() {
                e.setData({
                    loadend: !0
                });
            }
        });
    },
    onReachBottom: function() {
        if (!this.data.loadend) {
            var e = this;
            app.util.request({
                url: "entry/wxapp/distribution",
                showLoading: !1,
                data: {
                    op: "get_team",
                    status: e.data.curIndex,
                    row: e.data.list.length,
                    pagesize: e.data.pagesize
                },
                success: function(a) {
                    var t = a.data;
                    t.data.list && (console.log("ccc"), e.setData({
                        list: e.data.list.concat(t.data.list)
                    }));
                },
                fail: function() {
                    e.setData({
                        loadend: !0
                    });
                }
            });
        }
    }
});