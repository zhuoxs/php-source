var app = getApp();

Page({
    data: {},
    onLoad: function(o) {
        var a = o.user_id;
        this.setData({
            activation: a
        }), this.Headcolor();
    },
    onReady: function() {},
    getUserInfo: function(a) {
        var n = this;
        console.log(111), wx.getSetting({
            success: function(o) {
                o.authSetting["scope.userInfo"] ? (n.login(a), wx.showLoading({
                    title: "登录中..."
                })) : wx.showModal({
                    title: "提示",
                    content: "获取用户信息失败,需要授权才能继续使用！",
                    showCancel: !1,
                    confirmText: "授权",
                    success: function(o) {
                        o.confirm && wx.openSetting({
                            success: function(o) {
                                o.authSetting["scope.userInfo"] ? wx.showToast({
                                    title: "授权成功"
                                }) : wx.showToast({
                                    title: "未授权..."
                                });
                            }
                        });
                    }
                });
            }
        });
    },
    register: function(r) {
        var d = this;
        wx.getStorage({
            key: "user",
            success: function(o) {
                var a, n = (a = o.data.detail).openid, t = a.session_key, e = (a = a.userInfo).country, i = a.province, c = a.city, s = a.gender, l = a.nickName, u = a.avatarUrl;
                app.util.request({
                    url: "entry/wxapp/Yaoqingzhuce",
                    method: "post",
                    dataType: "json",
                    data: {
                        openid: n,
                        session_key: t,
                        nickname: l,
                        gender: s,
                        country: e,
                        province: i,
                        city: c,
                        avatar: u,
                        activation: d.data.activation
                    },
                    success: function(o) {
                        app.globalData.user_id = o.data.data, "function" == typeof r && r(o.data.data), 
                        wx.reLaunch({
                            url: "../index/index"
                        });
                    }
                });
            },
            fail: function(o) {
                console.log("失败"), console.log(o), d.setData({});
            }
        });
    },
    login: function(n) {
        console.log("走接口了么");
        var t = this;
        console.log("login"), app.globalData.userInfo ? (wx.reLaunch({
            url: "../index/index"
        }), "function" == typeof cb && cb(app.globalData.userInfo)) : wx.login({
            success: function(o) {
                var a = n.detail;
                app.globalData.userInfo = a.userInfo, a.act = "autologin", a.code = o.code, app.util.request({
                    url: "entry/wxapp/getopenid",
                    method: "post",
                    dataType: "json",
                    data: a,
                    success: function(o) {
                        console.log("走登录接口"), 0 == o.data.errno && (a.session_key = o.data.data.session_key, 
                        a.openid = o.data.data.openid, console.log(o.data.data.openid), app.globalData.userInfo = a, 
                        wx.setStorageSync("user", n), "function" == typeof cb && cb(app.globalData.userInfo), 
                        t.register(function(o) {
                            console.log("跳转"), wx.reLaunch({
                                url: "../index/index"
                            });
                        }));
                    },
                    fail: function(o) {
                        console.log("挑战失败"), console.log(o);
                    }
                });
            },
            fail: function(o) {
                console.log("失败"), console.log(o), console.log("获取失败");
            }
        });
    },
    fanhu: function() {
        console.log(111), wx.reLaunch({
            url: "../index/index"
        });
    },
    Headcolor: function() {
        var c = this;
        app.util.request({
            url: "entry/wxapp/Headcolor",
            method: "POST",
            success: function(o) {
                var a = o.data.data.config.search_color, n = o.data.data.config.share_icon;
                o.data.data.config.head_color;
                app.globalData.Headcolor = o.data.data.config.head_color;
                o.data.data.config.title;
                var t = o.data.data.yesno, e = o.data.data.config.loginbg, i = o.data.data.info.invite_bg;
                c.setData({
                    search_color: a,
                    share_icon: n,
                    yesno: t,
                    loginbg: e,
                    invite_bg: i
                });
            },
            fail: function(o) {
                console.log("失败" + o), console.log(o);
            }
        });
    },
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {}
});