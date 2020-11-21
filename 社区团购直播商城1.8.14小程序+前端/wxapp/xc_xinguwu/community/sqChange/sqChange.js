var app = getApp();

Page({
    data: {
        paeg: 1,
        pagesize: 20,
        loadend: !1
    },
    choThis: function(a) {
        var t = a.currentTarget.dataset.index;
        app.club = this.data.list[t], wx.navigateBack({
            delta: 1
        });
    },
    search: function(a) {
        var e = a.detail.value;
        if ("" != e) {
            var i = this;
            app.util.request({
                url: "entry/wxapp/community",
                showLoading: !0,
                method: "POST",
                data: {
                    op: "clubList",
                    page: 1,
                    longitude: i.data.longitude,
                    latitude: i.data.latitude,
                    pagesize: i.data.pagesize,
                    search: e
                },
                success: function(a) {
                    var t = a.data;
                    t.data.clubList && i.setData({
                        list: t.data.clubList,
                        page: 1,
                        loadend: !1,
                        searchValue: e
                    });
                },
                fail: function(a) {
                    app.look.alert(a.data.message), i.setData({
                        loadend: !0,
                        list: []
                    });
                }
            });
        }
    },
    onLoad: function(a) {
        var e = this;
        this.setData({
            club: app.club
        }), wx.getLocation({
            success: function(a) {
                e.setData({
                    longitude: a.longitude,
                    latitude: a.latitude
                }), app.util.request({
                    url: "entry/wxapp/community",
                    showLoading: !1,
                    method: "POST",
                    data: {
                        op: "clubList",
                        page: 1,
                        longitude: a.longitude,
                        latitude: a.latitude,
                        pagesize: e.data.pagesize
                    },
                    success: function(a) {
                        var t = a.data;
                        t.data.clubList && (console.log(t.data.clubList), e.setData({
                            list: t.data.clubList
                        }));
                    },
                    fail: function(a) {
                        app.look.alert(a.data.message), e.setData({
                            loadend: !0
                        });
                    }
                });
            }
        });
    },
    onReady: function() {
        var a = {};
        a.sq_bg = app.module_url + "resource/wxapp/community/sq-bg.png", a.sqSuccess = app.module_url + "resource/wxapp/community/sqSuccess.png", 
        this.setData({
            images: a
        });
    },
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {
        var e = this;
        e.setData({
            searchValue: ""
        }), wx.getLocation({
            success: function(a) {
                e.setData({
                    longitude: a.longitude,
                    latitude: a.latitude
                }), app.util.request({
                    url: "entry/wxapp/community",
                    showLoading: !0,
                    method: "POST",
                    data: {
                        op: "clubList",
                        page: 1,
                        longitude: a.longitude,
                        latitude: a.latitude,
                        pagesize: e.data.pagesize
                    },
                    success: function(a) {
                        wx.stopPullDownRefresh();
                        var t = a.data;
                        t.data.clubList && e.setData({
                            list: t.data.clubList,
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
                    op: "clubList",
                    page: e.data.page + 1,
                    longitude: e.data.longitude,
                    latitude: e.data.latitude,
                    pagesize: e.data.pagesize,
                    search: e.data.searchValue
                },
                success: function(a) {
                    var t = a.data;
                    t.data.clubList && e.setData({
                        list: e.data.list.concat(t.data.clubList),
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