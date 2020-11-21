var app = getApp(), Page = require("../../../sdk/qitui/oddpush.js").oddPush(Page).Page;

Page({
    data: {
        banner: "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/15227233856.png",
        navTile: "商品列表",
        curIndex: 0,
        nav: [ "限时抢购", "往期活动" ],
        curList: [],
        url: [],
        oldList: [],
        page: 1,
        oldpage: 1,
        adflashimg: []
    },
    onLoad: function(t) {
        var o = this;
        wx.setNavigationBarTitle({
            title: o.data.navTile
        });
        var a = app.getSiteUrl();
        a ? o.setData({
            url: a
        }) : app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "30",
            success: function(t) {
                wx.setStorageSync("url", t.data), a = t.data, o.setData({
                    url: a
                });
            }
        }), wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("System").fontcolor,
            backgroundColor: wx.getStorageSync("System").color,
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        }), wx.getLocation({
            type: "wgs84",
            success: function(t) {
                var a = t.latitude, e = t.longitude;
                app.util.request({
                    url: "entry/wxapp/QGactive",
                    data: {
                        showtype: 1,
                        lat: a,
                        lon: e,
                        openid: wx.getStorageSync("openid")
                    },
                    success: function(t) {
                        console.log(t.data), 2 == t.data ? o.setData({
                            curList: []
                        }) : o.setData({
                            curList: t.data
                        });
                    }
                });
            }
        }), o.getptclose(), app.util.request({
            url: "entry/wxapp/GetadData",
            cachetime: "30",
            data: {
                position: 5
            },
            success: function(t) {
                console.log("11111"), console.log(t.data);
                var a = t.data;
                o.setData({
                    adflashimg: a
                });
            }
        });
    },
    toIndex: function(t) {
        wx.reLaunch({
            url: "/mzhk_sun/pages/index/index"
        });
    },
    gotoadinfo: function(t) {
        var a = t.currentTarget.dataset.tid, e = t.currentTarget.dataset.id;
        app.func.gotourl(app, a, e);
    },
    onReady: function() {},
    onShow: function() {},
    getUrl: function() {
        var a = this;
        app.util.request({
            url: "entry/wxapp/url",
            cachetime: "30",
            success: function(t) {
                wx.setStorageSync("url", t.data), a.setData({
                    url: t.data
                });
            }
        });
    },
    getptclose: function() {
        var a = this;
        app.util.request({
            url: "entry/wxapp/QGClose",
            cachetime: "30",
            data: {
                openid: wx.getStorageSync("openid")
            },
            success: function(t) {
                2 == t.data ? a.setData({
                    oldList: []
                }) : a.setData({
                    oldList: t.data
                });
            }
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {
        var o = this;
        if (1 == o.data.curIndex) {
            var e = o.data.oldpage, n = o.data.oldList;
            app.util.request({
                url: "entry/wxapp/QGClose",
                cachetime: "30",
                data: {
                    page: e,
                    showtype: 1,
                    openid: wx.getStorageSync("openid")
                },
                success: function(t) {
                    if (console.log("往期数据"), console.log(t.data), 2 == t.data) wx.showToast({
                        title: "已经没有内容了哦！！！",
                        icon: "none"
                    }); else {
                        var a = t.data;
                        n = n.concat(a), o.setData({
                            oldList: n,
                            oldpage: e + 1
                        });
                    }
                }
            });
        } else {
            var s = o.data.page, i = o.data.curList;
            wx.getLocation({
                type: "wgs84",
                success: function(t) {
                    var a = t.latitude, e = t.longitude;
                    app.util.request({
                        url: "entry/wxapp/QGactive",
                        cachetime: "30",
                        data: {
                            showtype: 1,
                            lat: a,
                            lon: e,
                            page: s,
                            openid: wx.getStorageSync("openid")
                        },
                        success: function(t) {
                            if (console.log("活动数据"), console.log(t.data), 2 == t.data) wx.showToast({
                                title: "已经没有内容了哦！！！",
                                icon: "none"
                            }); else {
                                var a = t.data;
                                i = i.concat(a), o.setData({
                                    curList: i,
                                    page: s + 1
                                });
                            }
                        }
                    });
                }
            });
        }
    },
    onShareAppMessage: function() {},
    navTap: function(t) {
        var a = parseInt(t.currentTarget.dataset.index);
        this.setData({
            curIndex: a
        });
    },
    toPackage: function(t) {
        var a = t.currentTarget.dataset.id;
        console.log(a), wx.navigateTo({
            url: "../goods/goods?gid=" + a
        });
    }
});