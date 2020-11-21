var app = getApp();

Page({
    data: {
        imgUrls: [],
        is_modal_Hidden: !0,
        isLogin: !0,
        coachList: []
    },
    onLoad: function(e) {
        var t = this;
        t.wxauthSetting(), app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "30",
            success: function(e) {
                wx.setStorageSync("url", e.data), t.setData({
                    url: e.data
                });
            }
        }), app.util.request({
            url: "entry/wxapp/GetCoach",
            data: {
                id: e.id
            },
            cachetime: "0",
            success: function(e) {
                t.setData({
                    list: e.data
                });
            }
        }), app.util.request({
            url: "entry/wxapp/GetCoachCourse",
            data: {
                id: e.id
            },
            cachetime: "0",
            success: function(e) {
                t.setData({
                    coachList: e.data
                });
            }
        });
    },
    goCourseGoInfo: function(e) {
        var t = e.currentTarget.dataset.id, o = e.currentTarget.dataset.cid;
        console.log(t), wx.navigateTo({
            url: "../../product/courseGoInfo/courseGoInfo?id=" + t + "&cid=" + o
        });
    },
    goCoachbooking: function(e) {
        var t = e.currentTarget.dataset.id, o = e.currentTarget.dataset.img;
        wx.navigateTo({
            url: "../coachbooking/coachbooking?id=" + t + "&money=" + e.currentTarget.dataset.money + "&coach=" + e.currentTarget.dataset.coach + "&logo=" + o
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function(e) {
        var t = wx.getStorageSync("users").name;
        return "button" === e.from && console.log(e.target), {
            title: "用户 " + t + " 邀请你参与教练 [" + this.data.list.coach_name + "] 的健身课程",
            path: "/byjs_sun/pages/update/coachdetail/coachdetail?id=" + this.data.list.id,
            success: function(e) {},
            fail: function(e) {}
        };
    },
    toIndex: function(e) {
        wx.reLaunch({
            url: "/byjs_sun/pages/product/index/index"
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
                                                img: n,
                                                name: o,
                                                gender: a
                                            },
                                            success: function(e) {
                                                console.log("进入地址login"), console.log(e.data), wx.setStorageSync("users", e.data), 
                                                wx.setStorageSync("uniacid", e.data.uniacid), s.setData({
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
    }
});