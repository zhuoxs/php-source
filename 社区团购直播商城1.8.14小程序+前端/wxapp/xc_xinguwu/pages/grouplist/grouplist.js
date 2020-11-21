var i = 0, app = getApp();

Page({
    data: {
        curIndex: 0,
        page: 1,
        pagesize: 20,
        loadend: !1,
        loading: !1,
        staus: 1
    },
    changeStyle: function() {
        this.data.staus;
        1 == this.data.staus ? this.setData({
            staus: 2
        }) : this.setData({
            staus: 1
        });
    },
    showInput: function() {
        this.setData({
            inputShowed: !0
        });
    },
    hideInput: function() {
        this.setData({
            inputVal: "",
            inputShowed: !1
        });
    },
    clearInput: function() {
        this.setData({
            inputVal: ""
        });
    },
    inputTyping: function(a) {
        this.setData({
            inputVal: a.detail.value
        });
    },
    searchList: function(a) {
        var e = this;
        app.util.request({
            url: "entry/wxapp/goods",
            showLoading: !0,
            data: {
                op: "get_group_list",
                page: 1,
                pagesize: e.data.pagesize,
                search: a.detail.value
            },
            success: function(a) {
                console.log(a);
                var t = a.data;
                t.data.list && e.setData({
                    list: t.data.list,
                    page: 1
                });
            },
            complete: function() {
                e.setData({
                    curIndex: 0,
                    loadend: !0
                });
            }
        });
    },
    changeCategory: function(a) {
        var e = this, t = parseInt(a.currentTarget.dataset.index);
        this.setData({
            curIndex: t
        }), app.util.request({
            url: "entry/wxapp/goods",
            showLoading: !0,
            data: {
                op: "get_group_list",
                page: 1,
                pagesize: e.data.pagesize,
                cid: t
            },
            success: function(a) {
                var t = a.data;
                t.data.list && e.setData({
                    list: t.data.list,
                    page: 1,
                    loadend: !1
                });
            },
            fail: function() {
                e.setData({
                    loadend: !0,
                    list: []
                });
            }
        });
    },
    onLoad: function(a) {
        var e = this;
        app.util.request({
            url: "entry/wxapp/goods",
            showLoading: !1,
            data: {
                op: "grouplist"
            },
            success: function(a) {
                var t = a.data;
                t.data.goodclass && (e.setData({
                    goodclass: t.data.goodclass
                }), app.util.request({
                    url: "entry/wxapp/goods",
                    showLoading: !1,
                    data: {
                        op: "get_group_list",
                        page: e.data.page,
                        pagesize: e.data.pagesize,
                        cid: e.data.curIndex
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
                }));
            }
        });
    },
    onReady: function() {
        app.look.group_footer(this), app.look.navbar(this);
    },
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {
        var e = this;
        app.util.request({
            url: "entry/wxapp/goods",
            showLoading: !0,
            data: {
                op: "get_group_list",
                page: 1,
                pagesize: e.data.pagesize,
                cid: e.data.curIndex
            },
            success: function(a) {
                wx.stopPullDownRefresh();
                var t = a.data;
                t.data.list && e.setData({
                    list: t.data.list,
                    page: 1
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
        var e = this;
        e.data.loadend || (e.setData({
            loading: !0
        }), app.util.request({
            url: "entry/wxapp/goods",
            showLoading: !1,
            data: {
                op: "get_group_list",
                page: e.data.page + 1,
                pagesize: e.data.pagesize,
                cid: e.data.curIndex
            },
            success: function(a) {
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
            },
            complete: function() {
                e.setData({
                    loading: !1
                });
            }
        }));
    },
    todetail: function(a) {
        wx.navigateTo({
            url: "../groupdetail/groupdetail?id=" + this.data.list[a.currentTarget.dataset.index].id
        });
    }
});