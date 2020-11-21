var app = getApp();

Page({
    data: {
        navTile: "商品详情",
        indicatorDots: !1,
        autoplay: !1,
        interval: 3e3,
        duration: 800,
        goods: [ {
            imgUrls: [ "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152540565197.png", "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152540565217.png", "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152229433564.png" ],
            title: "发财树绿萝栀子花海棠花卉盆栽",
            shareprice: "0.15",
            detail: [ "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152541264562.png", "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152541264579.png", "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/15254126459.png", "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152541264601.png" ],
            visitnum: 6
        } ],
        isLogin: !1,
        isIpx: app.globalData.isIpx
    },
    onLoad: function(t) {
        this.reload(t), wx.setNavigationBarTitle({
            title: this.data.navTile
        });
    },
    dealwith: function(t) {
        var e = this, a = t.gid;
        e.setData({
            gid: a
        });
        var n = wx.getStorageSync("openid");
        if (n) {
            var o = t.openid;
            o && app.util.request({
                url: "entry/wxapp/setShareRecord",
                cachetime: "0",
                data: {
                    gid: a,
                    openid: n,
                    share_openid: o
                },
                success: function(t) {}
            }), app.util.request({
                url: "entry/wxapp/GoodsDetails",
                cachetime: "0",
                data: {
                    id: a
                },
                success: function(t) {
                    e.setData({
                        goodinfo: t.data.data
                    });
                }
            }), app.util.request({
                url: "entry/wxapp/setShareAccessRecord",
                cachetime: "0",
                data: {
                    openid: n,
                    gid: a
                },
                success: function(t) {
                    app.util.request({
                        url: "entry/wxapp/getShareAccessRecord",
                        cachetime: "0",
                        data: {
                            gid: a
                        },
                        success: function(t) {
                            e.setData({
                                record: t.data,
                                record_length: t.data.length
                            });
                        }
                    });
                }
            });
        }
    },
    bindGetUserInfo: function(t) {
        null == t.detail.userInfo ? console.log("没有授权") : (wx.setStorageSync("is_login", 1), 
        this.setData({
            isLogin: !1
        }), this.reload(), this.onLoad());
    },
    reload: function(a) {
        var o = this, t = wx.getStorageSync("url");
        "" == t ? app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "0",
            success: function(t) {
                wx.setStorageSync("url", t.data), o.setData({
                    url: t.data
                });
            }
        }) : o.setData({
            url: t
        });
        var e = wx.getStorageSync("settings");
        "" == e ? app.util.request({
            url: "entry/wxapp/Settings",
            cachetime: "0",
            success: function(t) {
                wx.setStorageSync("settings", t.data), wx.setStorageSync("color", t.data.color), 
                wx.setStorageSync("fontcolor", t.data.fontcolor), wx.setNavigationBarColor({
                    frontColor: wx.getStorageSync("fontcolor"),
                    backgroundColor: wx.getStorageSync("color"),
                    animation: {
                        duration: 0,
                        timingFunc: "easeIn"
                    }
                }), o.setData({
                    settings: t.data
                });
            }
        }) : (o.setData({
            settings: e
        }), wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("fontcolor"),
            backgroundColor: wx.getStorageSync("color"),
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        }));
        var n = wx.getStorageSync("openid");
        "" == n ? wx.login({
            success: function(t) {
                var e = t.code;
                app.util.request({
                    url: "entry/wxapp/openid",
                    cachetime: "0",
                    data: {
                        code: e
                    },
                    success: function(t) {
                        wx.setStorageSync("openid", t.data.openid), o.dealwith(a);
                        var n = t.data.openid;
                        wx.getSetting({
                            success: function(t) {
                                t.authSetting["scope.userInfo"] && wx.getUserInfo({
                                    success: function(t) {
                                        wx.setStorageSync("user_info", t.userInfo);
                                        var e = t.userInfo.nickName, a = t.userInfo.avatarUrl;
                                        app.util.request({
                                            url: "entry/wxapp/Login",
                                            cachetime: "0",
                                            data: {
                                                openid: n,
                                                img: a,
                                                name: e
                                            },
                                            success: function(t) {
                                                wx.setStorageSync("users", t.data), wx.setStorageSync("uniacid", t.data.uniacid);
                                            }
                                        });
                                    }
                                });
                            }
                        });
                    }
                });
            }
        }) : (o.dealwith(a), wx.getSetting({
            success: function(t) {
                t.authSetting["scope.userInfo"] && wx.getUserInfo({
                    success: function(t) {
                        wx.setStorageSync("user_info", t.userInfo);
                        var e = t.userInfo.nickName, a = t.userInfo.avatarUrl;
                        app.util.request({
                            url: "entry/wxapp/Login",
                            cachetime: "0",
                            data: {
                                openid: n,
                                img: a,
                                name: e
                            },
                            success: function(t) {
                                wx.setStorageSync("users", t.data), wx.setStorageSync("uniacid", t.data.uniacid);
                            }
                        });
                    }
                });
            }
        }));
    },
    onReady: function() {},
    onShow: function() {
        (e = this).data.gid;
        var e = this;
        wx.getStorageSync("is_login") || wx.getSetting({
            success: function(t) {
                t.authSetting["scope.userInfo"] ? (wx.setStorageSync("is_login", 1), e.setData({
                    isLogin: !1
                })) : e.setData({
                    isLogin: !0
                });
            }
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function(t) {
        var e = wx.getStorageSync("openid");
        return "button" === t.from && console.log(t.target), {
            title: this.data.goodinfo.goods_name,
            path: "yzmdwsc_sun/pages/index/shareDet/shareDet?gid=" + this.data.gid + "&openid=" + e,
            success: function(t) {},
            fail: function(t) {}
        };
    },
    tobuy: function(t) {
        var a = t.currentTarget.dataset.gid;
        app.util.request({
            url: "entry/wxapp/GoodsDetails",
            cachetime: "0",
            data: {
                id: a
            },
            success: function(t) {
                var e = t.data.data.lid;
                1 == e || 2 == e || 3 == e ? wx.navigateTo({
                    url: "../goodsDet/goodsDet?gid=" + a
                }) : 4 == e ? wx.navigateTo({
                    url: "../groupDet/groupDet?gid=" + a
                }) : 5 == e ? wx.navigateTo({
                    url: "../bardet/bardet?gid=" + a
                }) : 6 == e ? wx.navigateTo({
                    url: "../limitDet/limitDet?gid=" + a
                }) : 7 == e && wx.navigateTo({
                    url: "../shareDet/shareDet?gid=" + a
                });
            }
        });
    }
});