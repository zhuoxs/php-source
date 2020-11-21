var app = getApp();

Page({
    data: {
        vip: !1,
        is_modal_Hidden: !0
    },
    onLoad: function(e) {},
    onShow: function() {
        var o = this, e = wx.getStorageSync("openid"), n = wx.getStorageSync("userInfo");
        app.util.request({
            url: "entry/wxapp/vipRecharge",
            cachetime: "0",
            data: {
                openid: e
            },
            success: function(e) {
                console.log(e.data), o.setData({
                    list: e.data.recharge,
                    isopen: e.data.isopen,
                    details: e.data.details,
                    userInfo: n,
                    iscun: e.data.iscun
                });
            }
        });
    },
    goViptwo: function() {
        wx.getStorageSync("openid") ? wx.navigateTo({
            url: "../viptwo/viptwo"
        }) : this.wxauthSetting();
    },
    goVipthree: function(e) {
        var o = this, n = o.data.userInfo, t = wx.getStorageSync("openid");
        if (0 == o.data.iscun) var a = 0; else {
            var s = e.currentTarget.dataset.index;
            a = o.data.list[s].recharge;
        }
        t ? 1 == o.data.isopen ? wx.navigateTo({
            url: "../vipthree/vipthree?total=" + a + "&name=" + n.nickName
        }) : wx.showModal({
            title: "提示",
            content: "您不是会员，是否前往普通充值！",
            success: function(e) {
                e.confirm && wx.redirectTo({
                    url: "/ymktv_sun/pages/my/mybalance/mybalance"
                });
            }
        }) : o.wxauthSetting();
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
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
                var o = e.code;
                wx.setStorageSync("code", o), wx.getSetting({
                    success: function(e) {
                        console.log("进入wx.getSetting"), console.log(e), e.authSetting["scope.userInfo"] ? (console.log("scope.userInfo已授权"), 
                        wx.getUserInfo({
                            success: function(e) {
                                s.setData({
                                    is_modal_Hidden: !0,
                                    thumb: e.userInfo.avatarUrl,
                                    nickname: e.userInfo.nickName
                                }), console.log("进入wx-getUserInfo"), console.log(e.userInfo), wx.setStorageSync("user_info", e.userInfo), 
                                wx.setStorageSync("userInfo", e.userInfo);
                                var n = e.userInfo.nickName, t = e.userInfo.avatarUrl, a = e.userInfo.gender;
                                app.util.request({
                                    url: "entry/wxapp/openid",
                                    cachetime: "0",
                                    data: {
                                        code: o
                                    },
                                    success: function(e) {
                                        console.log("进入获取openid"), console.log(e.data), wx.setStorageSync("key", e.data.session_key), 
                                        wx.setStorageSync("openid", e.data.openid);
                                        var o = e.data.openid;
                                        console.log(o), wx.setStorageSync("userid", e.data.openid), wx.setStorage({
                                            key: "openid",
                                            data: o
                                        }), console.log(n), app.util.request({
                                            url: "entry/wxapp/Login",
                                            cachetime: "0",
                                            data: {
                                                openid: o,
                                                img: t,
                                                name: n,
                                                gender: a
                                            },
                                            success: function(e) {
                                                console.log("进入地址login"), console.log(e.data), wx.setStorageSync("users", e.data), 
                                                wx.setStorageSync("uniacid", e.data.uniacid), s.setData({
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
    }
});