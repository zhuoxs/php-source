var app = getApp();

Page({
    data: {
        navTile: "动态",
        banner: "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152531842309.png",
        dynamicList: [],
        inputShowed: !1,
        comment: "",
        isLogin: !1,
        isIpx: app.globalData.isIpx
    },
    onLoad: function(t) {
        console.log("重新加载"), app.editTabBar();
        var e = this;
        e.reload(), wx.setNavigationBarTitle({
            title: e.data.navTile
        });
        var a = getCurrentPages(), n = a[a.length - 1].route;
        console.log("当前路径为:" + n), e.setData({
            current_url: n
        }), app.util.request({
            url: "entry/wxapp/tab",
            cachetime: "20",
            success: function(t) {
                e.setData({
                    tab1: t.data.data
                });
            }
        });
    },
    reload: function(t) {
        var e = this, a = wx.getStorageSync("url");
        "" == a ? app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "0",
            success: function(t) {
                wx.setStorageSync("url", t.data), e.setData({
                    url: t.data
                });
            }
        }) : e.setData({
            url: a
        });
        var n = wx.getStorageSync("settings");
        "" == n ? app.util.request({
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
                }), e.setData({
                    settings: t.data
                });
            }
        }) : (e.setData({
            settings: n
        }), wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("fontcolor"),
            backgroundColor: wx.getStorageSync("color"),
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        }));
        var o = wx.getStorageSync("tab");
        "" == o ? app.util.request({
            url: "entry/wxapp/getCustomize",
            cachetime: "0",
            success: function(t) {
                wx.setStorageSync("tab", t.data.tab), e.setData({
                    tab: t.data.tab
                });
            }
        }) : e.setData({
            tab: o
        }), wx.login({
            success: function(t) {
                var e = t.code;
                app.util.request({
                    url: "entry/wxapp/openid",
                    cachetime: "0",
                    data: {
                        code: e
                    },
                    success: function(t) {
                        wx.setStorageSync("openid", t.data.openid);
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
        });
    },
    goTap: function(t) {
        console.log(t);
        var e = this;
        e.setData({
            current: t.currentTarget.dataset.index
        }), 0 == e.data.current && wx.redirectTo({
            url: "../index/index?currentIndex=0"
        }), 1 == e.data.current && wx.redirectTo({
            url: "../shop/shop?currentIndex=1"
        }), 2 == e.data.current && wx.redirectTo({
            url: "../active/active?currentIndex=2"
        }), 3 == e.data.current && wx.redirectTo({
            url: "../carts/carts?currentIndex=3"
        }), 4 == e.data.current && wx.redirectTo({
            url: "../user/user?currentIndex=4"
        });
    },
    onReady: function() {},
    onShow: function() {
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
        var t = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/getDynamic",
            cachetime: "0",
            data: {
                openid: t
            },
            success: function(t) {
                e.setData({
                    dynamic: t.data
                });
            }
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    clickGood: function(t) {
        var e = this, a = e.data.dynamic, n = t.currentTarget.dataset.statu, o = t.currentTarget.dataset.index, r = t.currentTarget.dataset.id, i = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/setDynamicCollection",
            cachetime: "0",
            data: {
                openid: i,
                dynamic_id: r,
                is_status: n
            },
            success: function(t) {
                app.util.request({
                    url: "entry/wxapp/getDynamicCollectionHeadimg",
                    cachetime: "0",
                    data: {
                        dynamic_id: r
                    },
                    success: function(t) {
                        console.log("返回信息"), console.log(t.data);
                        t.data.length;
                        a[o].is_collection = 1 == n ? 1 : 0, a[o].headimg = t.data, e.setData({
                            dynamic: a
                        });
                    }
                });
            }
        });
    },
    toMsg: function(t) {
        this.data.dynamicList;
        var e = t.currentTarget.dataset.index, a = t.currentTarget.dataset.id;
        this.setData({
            comment_id: a,
            inputShowed: !0,
            commIndex: e
        });
    },
    loseFocus: function(t) {
        var e = this, a = wx.getStorageSync("openid"), n = e.data.comment_id, o = e.data.comment, r = e.data.dynamic, i = e.data.commIndex;
        "" != o ? app.util.request({
            url: "entry/wxapp/setDynamicComment",
            cachetime: "0",
            data: {
                openid: a,
                comment: o,
                comment_id: n
            },
            success: function(t) {
                app.util.request({
                    url: "entry/wxapp/getDynamicComment",
                    cachetime: "0",
                    data: {
                        comment_id: n
                    },
                    success: function(t) {
                        r[i].comment = t.data, e.setData({
                            dynamic: r,
                            inputShowed: !1,
                            comment: ""
                        });
                    }
                });
            }
        }) : e.setData({
            inputShowed: !1
        });
    },
    comment: function(t) {
        this.setData({
            comment: t.detail.value
        });
    },
    previewImg: function(t) {
        for (var e = this.data.dynamic, a = this.data.url, n = t.currentTarget.dataset.index, o = t.currentTarget.dataset.idx, r = a + "" + e[n].imgs[o], i = e[n].imgs, c = 0; c < i.length; c++) i[c] = a + "" + i[c];
        wx.previewImage({
            current: r,
            urls: i
        });
    },
    toGoodsdet: function(t) {
        var a = t.currentTarget.dataset.gid, e = t.currentTarget.dataset.related_gid;
        0 < e && (a = e), app.util.request({
            url: "entry/wxapp/GoodsDetails",
            cachetime: "0",
            data: {
                id: a
            },
            success: function(t) {
                var e = t.data.data.lid;
                1 == e || 2 == e || 3 == e ? wx.navigateTo({
                    url: "../index/goodsDet/goodsDet?gid=" + a
                }) : 4 == e ? wx.navigateTo({
                    url: "../index/groupDet/groupDet?gid=" + a
                }) : 5 == e ? wx.navigateTo({
                    url: "../index/bardet/bardet?gid=" + a
                }) : 6 == e ? wx.navigateTo({
                    url: "../index/limitDet/limitDet?gid=" + a
                }) : 7 == e && wx.navigateTo({
                    url: "../index/shareDet/shareDet?gid=" + a
                });
            }
        });
    },
    toTab: function(t) {
        var e = t.currentTarget.dataset.url;
        e = "/" + e, wx.redirectTo({
            url: e
        });
    },
    bindGetUserInfo: function(t) {
        null == t.detail.userInfo ? console.log("没有授权") : (wx.setStorageSync("is_login", 1), 
        this.setData({
            isLogin: !1
        }), this.reload(), this.onLoad());
    }
});