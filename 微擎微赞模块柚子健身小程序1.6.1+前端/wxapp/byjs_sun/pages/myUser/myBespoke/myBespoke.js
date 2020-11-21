var app = getApp(), util = require("../../../resource/utils/util.js");

Page({
    data: {
        list: [],
        navIndex: 0,
        is_modal_Hidden: !0,
        isLogin: !0
    },
    onLoad: function(e) {
        var t = this;
        t.wxauthSetting();
        var n = e.navIndex;
        n && t.setData({
            navIndex: n
        }), app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "0",
            success: function(e) {
                wx.setStorageSync("url", e.data), t.setData({
                    url: e.data
                });
            }
        });
        var o = wx.getStorageSync("users").id;
        app.util.request({
            url: "entry/wxapp/SeeAppointment",
            data: {
                user_id: o
            },
            success: function(e) {
                console.log(e), t.setData({
                    list: e.data.res,
                    list1: e.data.res1,
                    list2: e.data.res2
                });
            }
        });
    },
    gotMeal: function(e) {
        var n = this, t = e.currentTarget.dataset.id;
        app.util.request({
            url: "entry/wxapp/changeStatus",
            data: {
                id: t
            },
            success: function(e) {
                var t = wx.getStorageSync("users").id;
                app.util.request({
                    url: "entry/wxapp/SeeAppointment",
                    data: {
                        user_id: t
                    },
                    success: function(e) {
                        console.log(e), n.setData({
                            list: e.data.res,
                            list1: e.data.res1,
                            list2: e.data.res2
                        });
                    }
                });
            }
        });
    },
    gohome: function() {
        wx.redirectTo({
            url: "../../product/index/index"
        });
    },
    changeIndex: function(e) {
        var t = e.currentTarget.dataset.index;
        this.setData({
            navIndex: t
        });
    },
    code: function(e) {
        1 == e.currentTarget.dataset.status && console.log("跳出二维码");
    },
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    wxauthSetting: function(e) {
        var a = this;
        wx.getStorageSync("openid") ? wx.getSetting({
            success: function(e) {
                console.log("进入wx.getSetting 1"), console.log(e), e.authSetting["scope.userInfo"] ? (console.log("scope.userInfo已授权 1"), 
                wx.getUserInfo({
                    success: function(e) {
                        a.setData({
                            is_modal_Hidden: !0,
                            thumb: e.userInfo.avatarUrl,
                            nickname: e.userInfo.nickName
                        });
                    }
                })) : (console.log("scope.userInfo没有授权 1"), wx.showModal({
                    title: "获取信息失败",
                    content: "请允许授权以便为您提供给服务",
                    success: function(e) {
                        a.setData({
                            is_modal_Hidden: !1
                        });
                    }
                }));
            },
            fail: function(e) {
                console.log("获取权限失败 1"), a.setData({
                    is_modal_Hidden: !1
                });
            }
        }) : wx.login({
            success: function(e) {
                console.log("进入wx-login");
                var t = e.code;
                wx.setStorageSync("code", t), wx.getSetting({
                    success: function(e) {
                        console.log("进入wx.getSetting"), console.log(e), e.authSetting["scope.userInfo"] ? (console.log("scope.userInfo已授权"), 
                        wx.getUserInfo({
                            success: function(e) {
                                a.setData({
                                    is_modal_Hidden: !0,
                                    thumb: e.userInfo.avatarUrl,
                                    nickname: e.userInfo.nickName
                                }), console.log("进入wx-getUserInfo"), console.log(e.userInfo), wx.setStorageSync("user_info", e.userInfo);
                                var n = e.userInfo.nickName, o = e.userInfo.avatarUrl, s = e.userInfo.gender;
                                app.util.request({
                                    url: "entry/wxapp/openid",
                                    cachetime: "0",
                                    data: {
                                        code: t
                                    },
                                    success: function(e) {
                                        console.log("进入获取openid"), console.log(e.data), wx.setStorageSync("key", e.data.session_key);
                                        var t = e.data.openid;
                                        wx.setStorageSync("userid", e.data.openid), wx.setStorage({
                                            key: "openid",
                                            data: t
                                        }), app.util.request({
                                            url: "entry/wxapp/Login",
                                            cachetime: "0",
                                            data: {
                                                openid: t,
                                                img: o,
                                                name: n,
                                                gender: s
                                            },
                                            success: function(e) {
                                                console.log("进入地址login"), console.log(e.data), wx.setStorageSync("users", e.data), 
                                                wx.setStorageSync("uniacid", e.data.uniacid), a.setData({
                                                    usersinfo: e.data
                                                });
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
                                        a.setData({
                                            is_modal_Hidden: !1
                                        });
                                    }
                                });
                            }
                        })) : (console.log("scope.userInfo没有授权"), a.setData({
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
                        a.setData({
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
    }
});