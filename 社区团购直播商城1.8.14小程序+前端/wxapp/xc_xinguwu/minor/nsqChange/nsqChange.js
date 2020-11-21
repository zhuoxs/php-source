var app = getApp();

Page({
    data: {
        page: 1,
        pagesize: 6,
        loadend: !1
    },
    choThis: function(t) {
        var a = t.currentTarget.dataset.index;
        app.club = this.data.list[a], wx.navigateBack({
            delta: 1
        });
    },
    onLoad: function(t) {},
    loadata: function() {
        var e = this;
        this.setData({
            club: app.club
        }), console.log("ddd"), wx.getLocation({
            success: function(t) {
                e.setData({
                    longitude: t.longitude,
                    latitude: t.latitude
                }), app.util.request({
                    url: "entry/wxapp/community",
                    showLoading: !1,
                    method: "POST",
                    data: {
                        op: "clubList",
                        page: 1,
                        longitude: t.longitude,
                        latitude: t.latitude,
                        pagesize: e.data.pagesize
                    },
                    success: function(t) {
                        var a = t.data;
                        if (a.data.clubList) {
                            for (var i = 0; i < a.data.clubList.length; i++) 1e3 < a.data.clubList[i].juli ? a.data.clubList[i].julishow = (a.data.clubList[i].juli / 1e3).toFixed(1) + "km" : a.data.clubList[i].julishow = a.data.clubList[i].juli + "m";
                            e.setData({
                                list: a.data.clubList
                            });
                        }
                    },
                    fail: function(t) {
                        app.look.alert(t.data.message), e.setData({
                            loadend: !0
                        });
                    }
                });
            },
            fail: function(t) {
                wx.showModal({
                    title: "需求授权使用地理位置",
                    content: "需求授权使用地理位置",
                    success: function(t) {
                        t.confirm ? wx.openSetting() : t.cancel;
                    }
                });
            }
        });
    },
    onReady: function() {
        var t = {};
        t.sq_bg = app.module_url + "resource/wxapp/community/sq-bg.png", this.setData({
            images: t
        });
    },
    onShow: function() {
        this.loadata();
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {
        var e = this;
        wx.getLocation({
            success: function(t) {
                e.setData({
                    longitude: t.longitude,
                    latitude: t.latitude
                }), app.util.request({
                    url: "entry/wxapp/community",
                    showLoading: !1,
                    method: "POST",
                    data: {
                        op: "clubList",
                        page: 1,
                        longitude: t.longitude,
                        latitude: t.latitude,
                        pagesize: e.data.pagesize
                    },
                    success: function(t) {
                        wx.stopPullDownRefresh();
                        var a = t.data;
                        if (a.data.clubList) {
                            for (var i = 0; i < a.data.clubList.length; i++) 1e3 < a.data.clubList[i].juli ? a.data.clubList[i].julishow = (a.data.clubList[i].juli / 1e3).toFixed(1) + "km" : a.data.clubList[i].julishow = a.data.clubList[i].juli + "m";
                            e.setData({
                                list: a.data.clubList,
                                page: 1,
                                loadend: !1
                            });
                        }
                    },
                    fail: function(t) {
                        app.look.alert(t.data.message), e.setData({
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
                    pagesize: e.data.pagesize
                },
                success: function(t) {
                    var a = t.data;
                    if (a.data.clubList) {
                        for (var i = 0; i < a.data.clubList.length; i++) 1e3 < a.data.clubList[i].juli ? a.data.clubList[i].julishow = (a.data.clubList[i].juli / 1e3).toFixed(1) + "km" : a.data.clubList[i].julishow = a.data.clubList[i].juli + "m";
                        e.setData({
                            list: e.data.list.concat(a.data.clubList),
                            page: e.data.page + 1
                        });
                    }
                },
                fail: function(t) {
                    app.look.alert(t.data.message), e.setData({
                        loadend: !0
                    });
                }
            });
        }
    }
});