var app = getApp();

Page({
    data: {
        showModalStatus: !1,
        order: [],
        ig: [],
        img: [],
        isHelp: !1,
        flag: !0,
        isLogin: !1
    },
    onLoad: function(t) {
        var e = this;
        e.reload();
        var a = t.id, n = t.openid;
        wx.setStorageSync("kanjiaid", a), wx.setStorageSync("userid", n);
        a = wx.getStorageSync("kanjiaid");
        var i = wx.getStorageSync("userid");
        app.util.request({
            url: "entry/wxapp/helpBargain",
            cachetime: "0",
            data: {
                id: a,
                openid: n
            },
            success: function(t) {
                e.setData({
                    helpbargain: t.data.data
                });
            }
        }), app.util.request({
            url: "entry/wxapp/kanzhu",
            cahetime: "0",
            data: {
                openid: i
            },
            success: function(t) {
                e.setData({
                    userInfo: t.data.data
                });
            }
        });
    },
    login: function() {
        var i = this;
        wx.login({
            success: function(t) {
                var e = t.code;
                wx.setStorageSync("code", e), wx.getUserInfo({
                    success: function(t) {
                        wx.setStorageSync("user_info", t.userInfo);
                        var a = t.userInfo.nickName, n = t.userInfo.avatarUrl;
                        app.util.request({
                            url: "entry/wxapp/openid",
                            cachetime: "0",
                            data: {
                                code: e
                            },
                            success: function(t) {
                                wx.setStorageSync("key", t.data.session_key), wx.setStorageSync("openid", t.data.openid);
                                var e = t.data.openid;
                                app.util.request({
                                    url: "entry/wxapp/Login",
                                    cachetime: "0",
                                    data: {
                                        openid: e,
                                        img: n,
                                        name: a
                                    },
                                    success: function(t) {
                                        wx.setStorageSync("users", t.data), wx.setStorageSync("uniacid", t.data.uniacid);
                                    }
                                });
                            }
                        }), i.setData({
                            avatarUrl: n
                        });
                    },
                    fail: function(t) {
                        wx.getSetting({
                            success: function(t) {
                                0 == t.authSetting["scope.userInfo"] && wx.openSetting({
                                    success: function(t) {}
                                });
                            }
                        });
                    }
                });
            }
        });
    },
    onReady: function() {},
    onShow: function() {
        var t = wx.getStorageSync("kanjiaid"), e = wx.getStorageSync("userid"), a = wx.getStorageSync("openid"), n = this;
        wx.getStorageSync("is_login") || wx.getSetting({
            success: function(t) {
                t.authSetting["scope.userInfo"] ? (wx.setStorageSync("is_login", 1), n.setData({
                    isLogin: !1
                })) : n.setData({
                    isLogin: !0
                });
            }
        }), app.util.request({
            url: "entry/wxapp/Friends",
            cachetime: "0",
            data: {
                openid: e,
                id: t
            },
            success: function(t) {
                console.log(t), n.setData({
                    friends: t.data.data
                });
            }
        }), app.util.request({
            url: "entry/wxapp/IsHelp",
            cachetime: "0",
            data: {
                openid: a,
                userid: e,
                id: t
            },
            success: function(t) {
                if (0 == t.data.data.length) var e = 0; else {
                    n.setData({
                        helpPrice: t.data.data[0].kanjias
                    });
                    e = 1;
                }
                n.setData({
                    join: e
                });
            }
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    order: function(t) {},
    bargain: function(t) {},
    onShareAppMessage: function() {},
    powerDrawer1: function(t) {
        var e = t.currentTarget.dataset.statu;
        this.util(e);
    },
    powerDrawer: function(t) {
        var i = this, o = t.currentTarget.dataset.statu, e = t.currentTarget.dataset.id, a = wx.getStorageSync("openid"), n = wx.getStorageSync("userid");
        i.data.flag;
        app.util.request({
            url: "entry/wxapp/Expire",
            cachetime: "0",
            data: {
                id: e
            },
            success: function(t) {
                a != n ? 0 != t.data.data && "0" != t.data.data ? app.util.request({
                    url: "entry/wxapp/zuidijia",
                    cachetime: "0",
                    data: {
                        id: e,
                        openid: n
                    },
                    success: function(t) {
                        console.log(t), "222" == t.data || 222 == t.data ? (app.util.request({
                            url: "entry/wxapp/DoHelpBargain",
                            cachetime: "0",
                            data: {
                                id: e,
                                openid: a,
                                userid: n
                            },
                            success: function(t) {
                                i.util(o), i.setData({
                                    isHelp: !0
                                });
                                var e = t.data.data;
                                console.log(e), i.setData({
                                    helpPrice: e,
                                    hideShopPopup: !1
                                });
                                var a = wx.getStorageSync("kanjiaid"), n = wx.getStorageSync("userid");
                                app.util.request({
                                    url: "entry/wxapp/helpBargain",
                                    cachetime: "0",
                                    data: {
                                        id: a,
                                        openid: n
                                    },
                                    success: function(t) {
                                        i.setData({
                                            helpbargain: t.data.data
                                        });
                                        var e = wx.getStorageSync("kanjiaid"), a = wx.getStorageSync("userid");
                                        app.util.request({
                                            url: "entry/wxapp/Friends",
                                            cachetime: "0",
                                            data: {
                                                openid: a,
                                                id: e
                                            },
                                            success: function(t) {
                                                console.log(t), i.setData({
                                                    friends: t.data.data
                                                });
                                            }
                                        });
                                    }
                                });
                            }
                        }), i.onShow()) : wx.showToast({
                            title: "已经很低啦，不能再砍了！",
                            icon: "none"
                        });
                    }
                }) : wx.showToast({
                    title: "活动已到期！感谢参与！",
                    icon: "none"
                }) : wx.showToast({
                    title: "不能为自己砍价哦，快去求助好友吧！",
                    icon: "none"
                });
            }
        });
    },
    util: function(t) {
        var e = wx.createAnimation({
            duration: 200,
            timingFunction: "linear",
            delay: 0
        });
        (this.animation = e).opacity(0).height(0).step(), this.setData({
            animationData: e.export()
        }), setTimeout(function() {
            e.opacity(1).height("468rpx").step(), this.setData({
                animationData: e
            }), "close" == t && this.setData({
                showModalStatus: !1
            });
        }.bind(this), 200), "open" == t && this.setData({
            showModalStatus: !0
        });
    },
    help: function(t) {
        wx.updateShareMenu({
            withShareTicket: !0,
            success: function() {}
        });
    },
    toDetail: function(t) {
        var e = t.currentTarget.dataset.gid;
        wx.navigateTo({
            url: "../bardet/bardet?gid=" + e
        });
    },
    toIndex: function(t) {
        wx.redirectTo({
            url: "/yzmdwsc_sun/pages/index/index"
        });
    },
    bindGetUserInfo: function(t) {
        null == t.detail.userInfo ? console.log("没有授权") : (wx.setStorageSync("is_login", 1), 
        this.setData({
            isLogin: !1
        }), this.reload(), this.onLoad());
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
        var i = wx.getStorageSync("openid");
        "" == i ? wx.login({
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
        }) : wx.getSetting({
            success: function(t) {
                t.authSetting["scope.userInfo"] && wx.getUserInfo({
                    success: function(t) {
                        wx.setStorageSync("user_info", t.userInfo);
                        var e = t.userInfo.nickName, a = t.userInfo.avatarUrl;
                        app.util.request({
                            url: "entry/wxapp/Login",
                            cachetime: "0",
                            data: {
                                openid: i,
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