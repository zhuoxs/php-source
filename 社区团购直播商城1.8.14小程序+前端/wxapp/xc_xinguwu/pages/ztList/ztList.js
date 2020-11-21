var app = getApp();

Page({
    data: {
        kindName: "全部",
        menuHidden: !1,
        curIndex: 0,
        page: 1,
        pagesize: 20,
        loadend: !1,
        style: 0
    },
    menuList: function() {
        0 == this.data.menuHidden ? this.setData({
            menuHidden: !0
        }) : this.setData({
            menuHidden: !1
        });
    },
    bindTap: function(a) {
        var t = a.currentTarget.dataset.index;
        -1 == t ? this.setData({
            curIndex: 0,
            menuHidden: !1,
            kindName: "全部",
            list: []
        }) : this.setData({
            curIndex: this.data.specialclass[t].id,
            menuHidden: !1,
            kindName: this.data.specialclass[t].name,
            list: []
        }), this.onPullDownRefresh();
    },
    onLoad: function(a) {
        var e = this;
        this.setData({
            style: app.globalData.webset.special_list_type,
            "goHome.blackhomeimg": app.globalData.blackhomeimg,
            curIndex: a.curIndex ? a.curIndex : "0"
        }), app.util.request({
            url: "entry/wxapp/special",
            showLoading: !1,
            method: "POST",
            data: {
                op: "special_class"
            },
            success: function(a) {
                var t = a.data;
                t.data.list && e.setData({
                    specialclass: t.data.list
                });
            }
        }), app.util.request({
            url: "entry/wxapp/special",
            showLoading: !1,
            method: "POST",
            data: {
                op: "special_list",
                page: 1,
                pagesize: e.data.pagesize,
                curIndex: e.data.curIndex
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
    onReady: function() {
        "" != app.globalData.webset.special_title && wx.setNavigationBarTitle({
            title: app.globalData.webset.special_title
        });
    },
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {
        var e = this;
        app.util.request({
            url: "entry/wxapp/special",
            showLoading: !0,
            method: "POST",
            data: {
                op: "special_list",
                page: 1,
                pagesize: e.data.pagesize,
                curIndex: e.data.curIndex
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
                url: "entry/wxapp/special",
                showLoading: !0,
                method: "POST",
                data: {
                    op: "special_list",
                    page: e.data.page + 1,
                    pagesize: e.data.pagesize,
                    curIndex: e.data.curIndex
                },
                success: function(a) {
                    wx.stopPullDownRefresh();
                    var t = a.data;
                    t.data.list && e.setData({
                        list: e.data.list.concat(t.data.list),
                        page: e.data.page + 1
                    });
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