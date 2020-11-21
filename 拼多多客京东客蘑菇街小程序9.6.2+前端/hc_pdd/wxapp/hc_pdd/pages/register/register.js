var app = getApp();

Page({
    data: {},
    onLoad: function(a) {
        var t = a.user_id;
        this.setData({
            activation: t
        }), console.log(t), console.log("接收user_id");
    },
    getUserInfo: function(t) {
        var o = this;
        wx.getSetting({
            success: function(a) {
                a.authSetting["scope.userInfo"] ? (o.login(t), wx.showLoading({
                    title: "登录中..."
                })) : wx.showModal({
                    title: "提示",
                    content: "获取用户信息失败,需要授权才能继续使用！",
                    showCancel: !1,
                    confirmText: "授权",
                    success: function(a) {
                        a.confirm && wx.openSetting({
                            success: function(a) {
                                a.authSetting["scope.userInfo"] ? wx.showToast({
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
    onShow: function() {
        this.Headcolor();
    },
    register: function(d) {
        var l = this;
        wx.getStorage({
            key: "user",
            success: function(a) {
                var t, o = (t = a.data.detail).openid, e = t.session_key, n = (t = t.userInfo).country, i = t.province, s = t.city, c = t.gender, r = t.nickName, u = t.avatarUrl;
                app.util.request({
                    url: "entry/wxapp/zhuce",
                    method: "post",
                    dataType: "json",
                    data: {
                        openid: o,
                        session_key: e,
                        nickname: r,
                        gender: c,
                        country: n,
                        province: i,
                        city: s,
                        avatar: u,
                        activation: l.data.activation
                    },
                    success: function(a) {
                        app.globalData.user_id = a.data.data, "function" == typeof d && d(a.data.data), 
                        wx.reLaunch({
                            url: "../index/index"
                        });
                    }
                });
            },
            fail: function(a) {
                l.setData({});
            }
        });
    },
    xiangqig: function(a) {
        var t = a.currentTarget.dataset.id;
        wx.navigateTo({
            url: "../education/education?id=" + t
        });
    },
    login: function(o) {
        var e = this;
        app.globalData.userInfo ? "function" == typeof cb && cb(app.globalData.userInfo) : wx.login({
            success: function(a) {
                var t = o.detail;
                app.globalData.userInfo = t.userInfo, t.act = "autologin", t.code = a.code, app.util.request({
                    url: "entry/wxapp/getopenid",
                    method: "post",
                    dataType: "json",
                    data: t,
                    success: function(a) {
                        0 == a.data.errno && (t.session_key = a.data.data.session_key, t.openid = a.data.data.openid, 
                        app.globalData.userInfo = t, wx.setStorageSync("user", o), "function" == typeof cb && cb(app.globalData.userInfo), 
                        e.register(function(a) {
                            wx.reLaunch({
                                url: "../index/index"
                            });
                        }));
                    }
                });
            },
            fail: function(a) {
                console.log("获取失败");
            }
        });
    },
    Headcolor: function() {
        var s = this;
        app.util.request({
            url: "entry/wxapp/Headcolor",
            method: "POST",
            success: function(a) {
                var t = a.data.data.config.search_color, o = a.data.data.config.share_icon;
                a.data.data.config.head_color;
                app.globalData.Headcolor = a.data.data.config.head_color;
                var e = a.data.data.config.title, n = a.data.data.yesno, i = a.data.data.config.loginbg;
                s.setData({
                    search_color: t,
                    share_icon: o,
                    yesno: n,
                    loginbg: i
                }), wx.setNavigationBarTitle({
                    title: e
                });
            },
            fail: function(a) {
                console.log("失败" + a), console.log(a);
            }
        });
    }
});