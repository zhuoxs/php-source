var tool = require("../../../style/utils/countDown.js"), app = getApp(), Page = require("../../../zhy/sdk/qitui/oddpush.js").oddPush(Page).Page;

Page({
    data: {
        url: [],
        banner: [],
        bargainList: [],
        indicatorDots: !1,
        autoplay: !1,
        interval: 3e3,
        duration: 800,
        whichone: 3
    },
    onLoad: function(e) {
        var t = this;
        app.editTabBar(), wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("fontcolor"),
            backgroundColor: wx.getStorageSync("color"),
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        }), app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "0",
            success: function(e) {
                wx.setStorageSync("url", e.data), t.setData({
                    url: e.data
                });
            }
        });
        var o = wx.getStorageSync("system");
        console.log(o.is_bargainopen), t.setData({
            bargain_open: o.is_bargainopen
        });
    },
    onReady: function() {
        app.getNavList("");
    },
    onShow: function() {
        var a = this, e = wx.getStorageSync("build_id");
        console.log(e), app.util.request({
            url: "entry/wxapp/kjBanner",
            cachetime: "10",
            success: function(e) {
                console.log(e), a.setData({
                    banner: e.data.data
                });
            }
        }), app.util.request({
            url: "entry/wxapp/KJlist",
            cachetime: "0",
            data: {
                build_id: e
            },
            success: function(e) {
                console.log(e.data), a.setData({
                    bargainList: e.data
                });
                var o = e.data;
                console.log("ceshi--------------"), console.log(o), console.log("ceshi--------------");
                var n = setInterval(function() {
                    for (var e = 0; e < o.length; e++) {
                        var t = tool.countDown(a, o[e].endtime);
                        t ? o[e].clock = "离结束剩：" + t[0] + "天" + t[1] + "时" + t[3] + "分" + t[4] + "秒" : (o[e].clock = "已经截止", 
                        clearInterval(n)), a.setData({
                            bargainList: o
                        });
                    }
                }, 1e3);
                a.setData({
                    bargainList: e.data
                });
            }
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    gotodetails: function(t) {
        console.log(t);
        var o = t.currentTarget.dataset.pic;
        console.log("你的图片是多少哦"), console.log(o);
        app.util.request({
            url: "entry/wxapp/timeout",
            cachetime: "0",
            data: {
                id: t.currentTarget.dataset.id
            },
            success: function(e) {
                console.log(e), 2 == e.data || "2" == e.data ? wx.navigateTo({
                    url: "detail/detail?id=" + t.currentTarget.dataset.id + "&pic=" + o
                }) : wx.showToast({
                    title: "活动已过期，感谢参与！",
                    icon: "none"
                });
            }
        });
    },
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    wxauthSetting: function(e) {
        var s = this, t = wx.getStorageSync("openid");
        if (t) {
            var o = wx.getStorageSync("user_info"), n = o.nickName, a = o.avatarUrl, i = o.gender;
            app.util.request({
                url: "entry/wxapp/Login",
                cachetime: "0",
                data: {
                    openid: t,
                    img: a,
                    name: n,
                    gender: i
                },
                success: function(e) {
                    s.setData({
                        usersinfo: e.data
                    });
                }
            }), wx.getSetting({
                success: function(e) {
                    console.log("进入wx.getSetting 1"), console.log(e), e.authSetting["scope.userInfo"] ? (console.log("scope.userInfo已授权 1"), 
                    wx.getUserInfo({
                        success: function(e) {
                            s.setData({
                                is_modal_Hidden: !0,
                                thumb: e.userInfo.avatarUrl,
                                nickname: e.userInfo.nickName
                            });
                        }
                    })) : (console.log("scope.userInfo没有授权 1"), wx.showModal({
                        title: "获取信息失败",
                        content: "请允许授权以便为您提供给服务",
                        success: function(e) {
                            s.setData({
                                is_modal_Hidden: !1
                            });
                        }
                    }));
                },
                fail: function(e) {
                    console.log("获取权限失败 1"), s.setData({
                        is_modal_Hidden: !1
                    });
                }
            });
        } else wx.login({
            success: function(e) {
                console.log("进入wx-login");
                var t = e.code;
                wx.setStorageSync("code", t), wx.getSetting({
                    success: function(e) {
                        console.log("进入wx.getSetting"), console.log(e), e.authSetting["scope.userInfo"] ? (console.log("scope.userInfo已授权"), 
                        wx.getUserInfo({
                            success: function(e) {
                                s.setData({
                                    is_modal_Hidden: !0,
                                    thumb: e.userInfo.avatarUrl,
                                    nickname: e.userInfo.nickName
                                }), console.log("进入wx-getUserInfo"), console.log(e.userInfo), wx.setStorageSync("user_info", e.userInfo);
                                var o = e.userInfo.nickName, n = e.userInfo.avatarUrl, a = e.userInfo.gender;
                                app.util.request({
                                    url: "entry/wxapp/openid",
                                    cachetime: "0",
                                    data: {
                                        code: t
                                    },
                                    success: function(e) {
                                        wx.setStorageSync("key", e.data.session_key), wx.setStorageSync("openid", e.data.openid);
                                        var t = e.data.openid;
                                        console.log("进入获取openid"), console.log(e.data);
                                        t = e.data.openid;
                                        wx.setStorage({
                                            key: "openid",
                                            data: t
                                        }), app.util.request({
                                            url: "entry/wxapp/Login",
                                            cachetime: "0",
                                            data: {
                                                openid: t,
                                                img: n,
                                                name: o,
                                                gender: a
                                            },
                                            success: function(e) {
                                                console.log("进入地址login"), console.log(e.data), console.log("ceshi-------------------------------"), 
                                                s.onShow(), console.log("ceshi-------------------------------"), wx.setStorageSync("users", e.data), 
                                                wx.setStorageSync("uniacid", e.data.uniacid), s.setData({
                                                    usersinfo: e.data
                                                });
                                            }
                                        }), s.onShow();
                                    }
                                });
                            },
                            fail: function(e) {
                                console.log("进入 wx-getUserInfo 失败"), wx.showModal({
                                    title: "获取信息失败",
                                    content: "请允许授权以便为您提供给服务!",
                                    success: function(e) {
                                        s.setData({
                                            is_modal_Hidden: !1
                                        });
                                    }
                                });
                            }
                        })) : (console.log("scope.userInfo没有授权"), s.setData({
                            is_modal_Hidden: !1
                        }));
                    }
                });
            },
            fail: function() {
                wx.showModal({
                    title: "获取信息失败",
                    content: "请允许授权以便为您提供给服务!!!",
                    success: function(e) {
                        s.setData({
                            is_modal_Hidden: !1
                        });
                    }
                });
            }
        });
    },
    updateUserInfo: function(e) {
        console.log("授权操作更新");
        this.wxauthSetting();
    },
    Branch: function() {
        var n = this, e = wx.getStorageSync("isSwitch"), a = wx.getStorageSync("openid");
        if (1 != e) var s = 2; else s = 1;
        wx.setStorageSync("Switch", s), a && (wx.getLocation({
            type: "gcj02",
            success: function(e) {
                var t = e.latitude, o = e.longitude;
                app.util.request({
                    url: "entry/wxapp/CurrentBranch",
                    cachetime: "0",
                    data: {
                        openid: a,
                        latitude: t,
                        longitude: o,
                        Switch: s
                    },
                    success: function(e) {
                        console.log(e.data), n.setData({
                            Branch: e.data
                        });
                    }
                });
            },
            fail: function() {
                console.log("你有打印出来吗"), n.setData({
                    jurisDiction: !0
                });
            }
        }), app.util.request({
            url: "entry/wxapp/AmountSaveVip",
            cachetime: "0",
            data: {
                openid: a
            }
        }));
    },
    goHome: function() {
        wx.reLaunch({
            url: "/ymmf_sun/pages/index/index"
        });
    },
    get: function() {
        this.setData({
            jurisDiction: !1
        }), wx.openSetting({
            success: function(e) {
                console.log(e.authSetting), e.authSetting = {
                    "scope.userInfo": !0,
                    "scope.userLocation": !0
                };
            }
        });
    },
    goindex: function(e) {
        wx.reLaunch({
            url: "/ymmf_sun/pages/index/index"
        });
    }
});