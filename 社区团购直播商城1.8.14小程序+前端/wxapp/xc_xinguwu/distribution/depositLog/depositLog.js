var app = getApp();

Page({
    data: {
        page: 1,
        pagesize: 20,
        loadend: !1,
        date: ""
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
    onLoad: function(a) {
        var e = this;
        app.util.request({
            url: "entry/wxapp/distribution",
            showLoading: !1,
            data: {
                op: "get_deposit_log",
                page: e.data.page,
                pagesize: e.data.pagesize
            },
            success: function(a) {
                var t = a.data;
                t.data.list && e.setData({
                    list: e.data_realign(t.data.list)
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
                op: "get_deposit_log",
                page: 1,
                pagesize: e.data.pagesize
            },
            success: function(a) {
                wx.stopPullDownRefresh();
                var t = a.data;
                t.data.list && e.setData({
                    list: e.data_realign(t.data.list),
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
                    op: "get_deposit_log",
                    page: e.data.page + 1,
                    pagesize: e.data.pagesize
                },
                success: function(a) {
                    var t = a.data;
                    t.data.list && e.setData({
                        list: e.data.list.concat(e.data_realign(t.data.list)),
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
    },
    data_realign: function(a) {
        for (var t = new app.util.date(), e = 0, i = a.length; e < i; e++) {
            var n = new Date(a[e].createtime);
            a[e].month_day = t.dateToStr("MM-DD", n), a[e].week = "周" + t.dateToStr("W", n), 
            a[e].year_month = t.dateToStr("YYYY-MM", n);
        }
        var s = {};
        for (e = 0, i = a.length; e < i; e++) {
            var o, d = 0, l = 0;
            if (0 == e) (o = {}).date = a[e].year_month, o.sub = {}, o.sub[l] = a[e], s[d] = o; else if (o.date == a[e].year_month) l++, 
            o.sub[e] = a[e], s[l] = o; else l = 0, d++, (o = {}).date = a[e].year_month, o.sub = {}, 
            o.sub[l] = a[e], s[d] = o;
        }
        return s;
    },
    bindDateChange: function(a) {
        console.log(a), this.setData({
            date: a.detail.value
        });
    },
    search: function() {
        var e = this, a = e.data.date;
        console.log(a), "" != a && app.util.request({
            url: "entry/wxapp/distribution",
            showLoading: !1,
            data: {
                op: "search_deposit_log",
                search: a
            },
            success: function(a) {
                var t = a.data;
                t.data.list && e.setData({
                    list: e.data_realign(t.data.list)
                });
            }
        });
    }
});