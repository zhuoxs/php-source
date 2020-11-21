var app = getApp();

Page({
    data: {
        fight: [],
        is_modal_Hidden: !0,
        isLogin: !0
    },
    onLoad: function(e) {
        var o = this, t = e.id, n = e.cid;
        console.log(e), o.wxauthSetting(), app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "30",
            success: function(e) {
                wx.setStorageSync("url", e.data), o.setData({
                    url: e.data
                });
            }
        }), app.util.request({
            url: "entry/wxapp/CourseInfo",
            data: {
                id: t,
                cid: n
            },
            cachetime: 0,
            success: function(e) {
                console.log(e), o.setData({
                    fight: e.data
                });
            }
        }), app.util.request({
            url: "entry/wxapp/GetYymoney",
            cachetime: 0,
            success: function(e) {
                o.setData({
                    money: e.data
                });
            }
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onShareAppMessage: function(e) {
        var o = wx.getStorageSync("users").name;
        return "button" === e.from && console.log(e.target), {
            title: "用户 " + o + " 邀你参加课程 [" + this.data.fight.course_name + "]",
            path: "/byjs_sun/pages/product/courseGoInfo/courseGoInfo?id=" + this.data.fight.id,
            success: function(e) {},
            fail: function(e) {}
        };
    },
    onReachBottom: function() {},
    goCourseInfo: function(e) {
        var o = this, t = e.currentTarget.dataset.id, n = e.currentTarget.dataset.cid, s = o.data.fight.course_price, a = o.data.fight.course_img, c = o.data.money.yy_money;
        wx.navigateTo({
            url: "/byjs_sun/pages/product/courseInfo/courseInfo?id=" + t + "&money=" + c + "&price=" + s + "&img=" + a + "&cid=" + n
        });
    },
    toIndex: function(e) {
        wx.redirectTo({
            url: "/byjs_sun/pages/product/index/index"
        });
    },
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
                var o = e.code;
                wx.setStorageSync("code", o), wx.getSetting({
                    success: function(e) {
                        console.log("进入wx.getSetting"), console.log(e), e.authSetting["scope.userInfo"] ? (console.log("scope.userInfo已授权"), 
                        wx.getUserInfo({
                            success: function(e) {
                                a.setData({
                                    is_modal_Hidden: !0,
                                    thumb: e.userInfo.avatarUrl,
                                    nickname: e.userInfo.nickName
                                }), console.log("进入wx-getUserInfo"), console.log(e.userInfo), wx.setStorageSync("user_info", e.userInfo);
                                var t = e.userInfo.nickName, n = e.userInfo.avatarUrl, s = e.userInfo.gender;
                                app.util.request({
                                    url: "entry/wxapp/openid",
                                    cachetime: "0",
                                    data: {
                                        code: o
                                    },
                                    success: function(e) {
                                        console.log("进入获取openid"), console.log(e.data), wx.setStorageSync("key", e.data.session_key);
                                        var o = e.data.openid;
                                        wx.setStorageSync("userid", e.data.openid), wx.setStorage({
                                            key: "openid",
                                            data: o
                                        }), app.util.request({
                                            url: "entry/wxapp/Login",
                                            cachetime: "0",
                                            data: {
                                                openid: o,
                                                img: n,
                                                name: t,
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