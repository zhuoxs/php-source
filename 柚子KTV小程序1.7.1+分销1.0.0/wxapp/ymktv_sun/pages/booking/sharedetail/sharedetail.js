var md5 = require("../../../../we7/js/utils/md5.js"), base64 = require("../../../../we7/js/utils/base64.js"), app = getApp(), Page = require("../../../../zhy/sdk/qitui/oddpush.js").oddPush(Page).Page;

Page({
    data: {
        showplay: 0,
        kanjia: 0,
        flag: "true",
        iskan: 0,
        is_modal_Hidden: !0
    },
    onLoad: function(e) {
        var a = this;
        wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("fontcolor"),
            backgroundColor: wx.getStorageSync("color"),
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        }), a.url(), a.wxauthSetting();
        var t = e.uid, n = e.id;
        wx.setStorageSync("gid", n), wx.setStorageSync("user_id", t), app.util.request({
            url: "entry/wxapp/Nowkangood",
            cachetime: "0",
            data: {
                id: n,
                userid: t
            },
            success: function(e) {
                console.log(e.data), a.setData({
                    nowgood: e.data[0],
                    id: n,
                    userid: t
                });
            }
        }), app.util.request({
            url: "entry/wxapp/kanmaster",
            cachetime: "0",
            data: {
                id: n,
                userid: t
            },
            success: function(e) {
                console.log(e.data), a.setData({
                    kanmaster: e.data
                });
            }
        });
    },
    onShow: function() {
        var a = this, t = wx.getStorageSync("gid"), n = wx.getStorageSync("user_id");
        app.util.request({
            url: "entry/wxapp/friendData",
            cachetime: "0",
            data: {
                gid: t,
                userid: n
            },
            success: function(e) {
                console.log(e.data), a.setData({
                    friends: e.data
                });
            }
        }), wx.getStorage({
            key: "openid",
            success: function(e) {
                console.log(e.data), app.util.request({
                    url: "entry/wxapp/iskan",
                    cachetime: "0",
                    data: {
                        gid: t,
                        openid: e.data,
                        userid: n
                    },
                    success: function(e) {
                        console.log(e.data), a.setData({
                            iskan: e.data.iskan
                        });
                    }
                });
            }
        });
    },
    wxauthSetting: function(e) {
        var s = this;
        wx.getStorageSync("openid") ? wx.getSetting({
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
        }) : wx.login({
            success: function(e) {
                console.log("进入wx-login");
                var a = e.code;
                wx.setStorageSync("code", a), wx.getSetting({
                    success: function(e) {
                        console.log("进入wx.getSetting"), console.log(e), e.authSetting["scope.userInfo"] ? (console.log("scope.userInfo已授权"), 
                        wx.getUserInfo({
                            success: function(e) {
                                s.setData({
                                    is_modal_Hidden: !0,
                                    thumb: e.userInfo.avatarUrl,
                                    nickname: e.userInfo.nickName
                                }), console.log("进入wx-getUserInfo"), console.log(e.userInfo), wx.setStorageSync("user_info", e.userInfo);
                                var t = e.userInfo.nickName, n = e.userInfo.avatarUrl, o = e.userInfo.gender;
                                app.util.request({
                                    url: "entry/wxapp/openid",
                                    cachetime: "0",
                                    data: {
                                        code: a
                                    },
                                    success: function(e) {
                                        console.log("进入获取openid"), console.log(e.data), wx.setStorageSync("key", e.data.session_key), 
                                        wx.setStorageSync("openid", e.data.openid);
                                        var a = e.data.openid;
                                        console.log(a), wx.setStorageSync("userid", a), wx.setStorage({
                                            key: "openid",
                                            data: a
                                        }), app.util.request({
                                            url: "entry/wxapp/Login",
                                            cachetime: "0",
                                            data: {
                                                openid: a,
                                                img: n,
                                                name: t,
                                                gender: o
                                            },
                                            success: function(e) {
                                                console.log("进入地址login"), console.log(e.data), wx.setStorageSync("users", e.data), 
                                                s.setData({
                                                    usersinfo: e.data
                                                }), s.onShow();
                                            }
                                        });
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
    url: function(e) {
        var a = this;
        app.util.request({
            url: "entry/wxapp/Url2",
            cachetime: "0",
            success: function(e) {
                wx.setStorageSync("url2", e.data);
            }
        }), app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "0",
            success: function(e) {
                wx.setStorageSync("url", e.data), a.setData({
                    url: e.data
                });
            }
        });
    },
    showplay: function(o) {
        var s = this;
        s.data.showplay;
        console.log(o);
        var e = s.data.flag;
        s.data.kanjia;
        "true" == e ? (s.setData({
            flag: "false"
        }), wx.getStorage({
            key: "openid",
            success: function(e) {
                var n = e.data;
                app.util.request({
                    url: "entry/wxapp/EndActive",
                    cachetime: "0",
                    data: {
                        gid: o.currentTarget.dataset.gid
                    },
                    success: function(e) {
                        if (console.log(e.data), 0 == e.data) wx.showModal({
                            title: "提示",
                            content: "该活动已结束！",
                            showCancel: !1
                        }); else {
                            if (s.data.userid == n) return void wx.showModal({
                                title: "提示",
                                content: "您是砍主哦，不能再继续砍价啦",
                                showCancel: !1
                            });
                            app.util.request({
                                url: "entry/wxapp/isfriend",
                                cachetime: "0",
                                data: {
                                    userid: o.currentTarget.dataset.userid,
                                    gid: o.currentTarget.dataset.gid,
                                    openid: n
                                },
                                success: function(e) {
                                    if (console.log(e.data), "" != e.data || e.data) s.setData({
                                        kanjia: 1
                                    }); else {
                                        var a = new Date().valueOf(), t = base64.base64_encode(a + "???alsjdlqkwjlke123654!@#!@81903890");
                                        app.util.request({
                                            url: "entry/wxapp/friendkan",
                                            cachetime: "0",
                                            data: {
                                                userid: o.currentTarget.dataset.userid,
                                                gid: o.currentTarget.dataset.gid,
                                                openid: n,
                                                t: t,
                                                timestamp: a
                                            },
                                            success: function(e) {
                                                console.log(e.data), s.setData({
                                                    kanjias: e.data,
                                                    kanjia: 1
                                                }), s.onShow();
                                            }
                                        });
                                    }
                                }
                            });
                        }
                    }
                });
            }
        })) : wx.showToast({
            title: "请勿重复请求！",
            icon: "none",
            duration: 2e3
        }), s.setData({
            showplay: 1
        });
    },
    closeplay: function() {
        this.data.showplay;
        this.setData({
            showplay: 0
        });
    },
    goBargaindetail: function(e) {
        var a = this, t = wx.getStorageSync("userid");
        app.util.request({
            url: "entry/wxapp/iskanzhu",
            cachetime: "0",
            data: {
                id: a.data.id,
                uid: t
            },
            success: function(e) {
                1 == e.data ? wx.navigateTo({
                    url: "../bargaindetail/bargaindetail?id=" + a.data.id
                }) : wx.navigateTo({
                    url: "../bargain/bargain?id=" + a.data.id
                });
            }
        });
    },
    onReady: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    goHome: function() {
        wx.reLaunch({
            url: "../index/index"
        });
    }
});