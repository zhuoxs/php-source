var app = getApp(), Page = require("../../../sdk/qitui/oddpush.js").oddPush(Page).Page;

Page({
    data: {
        banner: "",
        navTile: "砍价",
        curIndex: 0,
        nav: [ "进行中", "往期活动" ],
        curList: [],
        oldList: [],
        adflashimg: [],
        page: 1,
        oldpage: 1,
        is_modal_Hidden: !0
    },
    onLoad: function(t) {
        var e = this;
        app.wxauthSetting(), e.setData({
            options: t
        }), wx.setNavigationBarTitle({
            title: e.data.navTile
        });
        var a = app.getSiteUrl();
        a ? e.setData({
            url: a
        }) : app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "30",
            success: function(t) {
                wx.setStorageSync("url", t.data), a = t.data, e.setData({
                    url: a
                });
            }
        }), wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("System").fontcolor ? wx.getStorageSync("System").fontcolor : "",
            backgroundColor: wx.getStorageSync("System").color ? wx.getStorageSync("System").color : "",
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        }), app.util.request({
            url: "entry/wxapp/GetadData",
            cachetime: "30",
            data: {
                position: 3
            },
            success: function(t) {
                console.log("11111"), console.log(t.data);
                var a = t.data;
                e.setData({
                    adflashimg: a
                });
            }
        }), e.getptactive(), e.getptclose();
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
    onShow: function() {
        app.func.islogin(app, this);
        var t = this.data.options;
        t.d_user_id && app.distribution.distribution_parsent(app, t.d_user_id);
    },
    getUrl: function() {
        var a = this, e = app.getSiteUrl();
        e ? a.setData({
            url: e
        }) : app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "30",
            success: function(t) {
                wx.setStorageSync("url", t.data), e = t.data, a.setData({
                    url: e
                });
            }
        });
    },
    getptactive: function() {
        var n = this;
        wx.getLocation({
            type: "wgs84",
            success: function(t) {
                var a = t.latitude, e = t.longitude;
                app.util.request({
                    url: "entry/wxapp/KJactive",
                    data: {
                        lat: a,
                        lon: e,
                        openid: wx.getStorageSync("openid")
                    },
                    success: function(t) {
                        console.log(t.data), 2 == t.data ? n.setData({
                            curList: []
                        }) : n.setData({
                            curList: t.data
                        });
                    }
                });
            }
        });
    },
    getptclose: function() {
        var a = this;
        app.util.request({
            url: "entry/wxapp/KJClose",
            cachetime: "30",
            data: {
                openid: wx.getStorageSync("openid")
            },
            success: function(t) {
                console.log("往期数据"), console.log(t.data), 2 == t.data ? a.setData({
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
        var n = this;
        if (1 == n.data.curIndex) {
            var e = n.data.oldpage, o = n.data.oldList;
            app.util.request({
                url: "entry/wxapp/KJClose",
                cachetime: "30",
                data: {
                    page: e,
                    openid: wx.getStorageSync("openid")
                },
                success: function(t) {
                    if (console.log("往期数据"), console.log(t.data), 2 == t.data) wx.showToast({
                        title: "已经没有内容了哦！！！",
                        icon: "none"
                    }); else {
                        var a = t.data;
                        o = o.concat(a), n.setData({
                            oldList: o,
                            oldpage: e + 1
                        });
                    }
                }
            });
        } else {
            var i = n.data.page, s = n.data.curList;
            wx.getLocation({
                type: "wgs84",
                success: function(t) {
                    var a = t.latitude, e = t.longitude;
                    app.util.request({
                        url: "entry/wxapp/KJactive",
                        cachetime: "30",
                        data: {
                            lat: a,
                            lon: e,
                            page: i,
                            openid: wx.getStorageSync("openid")
                        },
                        success: function(t) {
                            if (console.log("活动数据"), console.log(t.data), 2 == t.data) wx.showToast({
                                title: "已经没有内容了哦！！！",
                                icon: "none"
                            }); else {
                                var a = t.data;
                                s = s.concat(a), n.setData({
                                    curList: s,
                                    page: i + 1
                                });
                            }
                        }
                    });
                }
            });
        }
    },
    onShareAppMessage: function() {
        return {
            path: "/mzhk_sun/pages/index/bargain/bargain?d_user_id=" + wx.getStorageSync("users").id
        };
    },
    navTap: function(t) {
        var a = parseInt(t.currentTarget.dataset.index);
        this.setData({
            curIndex: a
        });
    },
    toBardet: function(t) {
        var a = t.currentTarget.dataset.id;
        wx.navigateTo({
            url: "../bardet/bardet?id=" + a
        });
    },
    updateUserInfo: function(t) {
        console.log("授权操作更新");
        app.wxauthSetting();
    }
});