var app = getApp();

Page({
    data: {
        page: 1,
        pagesize: 20,
        curIndex: 0,
        loadend: !1
    },
    show: function() {
        this.setData({
            show: !0
        });
    },
    hidden: function() {
        this.setData({
            show: !1
        });
    },
    bindTap: function(a) {
        var n = this, s = parseInt(a.currentTarget.dataset.index);
        app.util.request({
            url: "entry/wxapp/goods",
            showLoading: !1,
            data: {
                op: "my_bargain_list",
                page: 1,
                pagesize: n.data.pagesize,
                status: s
            },
            success: function(a) {
                var t = a.data;
                t.data.list && n.setData({
                    list: t.data.list,
                    curIndex: s
                });
            }
        });
    },
    onLoad: function(a) {
        var n = this;
        app.util.request({
            url: "entry/wxapp/goods",
            showLoading: !1,
            data: {
                op: "my_bargain_list",
                page: n.data.page,
                pagesize: n.data.pagesize
            },
            success: function(a) {
                var t = a.data;
                console.log(t.data.list), t.data.list && n.setData({
                    list: t.data.list
                });
            }
        });
    },
    onReady: function() {
        app.util.footer(this), app.look.navbar(this);
    },
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {}
});