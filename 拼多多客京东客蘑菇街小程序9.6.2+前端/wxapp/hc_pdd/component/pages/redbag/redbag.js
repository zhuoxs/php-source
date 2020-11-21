var app = getApp();

Page({
    data: {},
    onLoad: function(a) {
        var t = a.outuser_id, o = a.hb_id;
        console.log(a), this.setData({
            outuser_id: t,
            hb_id: o
        }), this.Opentree(), this.Headcolor();
    },
    Headcolor: function() {
        var o = this;
        app.util.request({
            url: "entry/wxapp/Headcolor",
            method: "POST",
            success: function(a) {
                var t = a.data.data.config;
                console.log(t.treeadultid), o.setData({
                    config: t
                });
            },
            fail: function(a) {
                console.log("失败" + a);
            }
        });
    },
    Opentree: function() {
        var e = this;
        app.util.request({
            url: "entry/wxapp/Opentree",
            method: "POST",
            data: {
                user_id: e.data.outuser_id
            },
            success: function(a) {
                var t = a.data.data.user.head_pic, o = a.data.data.user.nick_name;
                e.setData({
                    avatarUrl: t,
                    nickName: o
                });
            },
            fail: function(a) {
                console.log("失败" + a);
            }
        });
    },
    onReady: function() {},
    getUserInfo: function(t) {
        var o = this;
        wx.getSetting({
            success: function(a) {
                console.log(a), a.authSetting["scope.userInfo"] ? o.login(t) : wx.showModal({
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
            },
            fail: function(a) {
                console.log(a);
            }
        });
    },
    login: function(o) {
        wx.showToast({
            title: "加载中...",
            mask: !0,
            icon: "loading"
        });
        var e = this;
        app.globalData.userInfo ? ("function" == typeof cb && cb(app.globalData.userInfo), 
        e.register(function(a) {})) : wx.login({
            success: function(a) {
                var t = o.detail;
                app.globalData.userInfo = t.userInfo, t.act = "autologin", t.code = a.code, app.util.request({
                    url: "entry/wxapp/getopenid",
                    method: "post",
                    dataType: "json",
                    data: t,
                    success: function(a) {
                        console.log(a, "wx.login"), 0 == a.data.errno && (t.openid = a.data.data.openid, 
                        t.session_key = a.data.data.session_key, app.globalData.userInfo = t, app.globalData.session_key = a.data.data.session_key, 
                        wx.setStorageSync("user", o), "function" == typeof cb && cb(app.globalData.userInfo), 
                        e.register(function(a) {}), e.setData({
                            session_key: a.data.data.session_key
                        }));
                    }
                });
            },
            fail: function(a) {
                console.log("获取失败");
            }
        });
    },
    register: function(u) {
        wx.showToast({
            title: "授权中...",
            mask: !0,
            icon: "loading"
        });
        var r = this;
        wx.getStorage({
            key: "user",
            success: function(a) {
                var t = a.data.detail.userInfo;
                app.globalData.openId = a.data.detail.openid, app.globalData.userInfo = a.data.detail.userInfo;
                var o = a.data.detail.openid;
                app.globalData.openId = a.data.detail.openid;
                var e = a.data.detail.session_key;
                app.globalData.session_key = a.data.detail.session_key;
                var n = (t = a.data.detail.userInfo).country, s = t.province, i = t.city, d = t.gender, c = t.nickName, l = t.avatarUrl;
                app.util.request({
                    url: "entry/wxapp/Treezhuce",
                    method: "post",
                    dataType: "json",
                    data: {
                        openid: o,
                        session_key: e,
                        nickname: c,
                        gender: d,
                        country: n,
                        province: s,
                        city: i,
                        avatar: l,
                        outuser_id: r.data.outuser_id,
                        hb_id: r.data.hb_id
                    },
                    success: function(a) {
                        console.log(a, "uid"), app.globalData.user_id = a.data.data.data, console.log(a.data.data.data, "获取uid"), 
                        console.log(a.data.data.data, "uid测试");
                        var t = a.data.data.hbmoney;
                        console.log(a.data, a.data.hbmoney, "邀请红包", a.data.data.hbmoney), wx.navigateTo({
                            url: "../redenvelopes/redenvelopes?hbmoney=" + t + "&nickName=" + r.data.nickName + "&avatarUrl=" + r.data.avatarUrl
                        }), "function" == typeof u && u(a.data.data);
                    },
                    fail: function(a) {
                        console.log(a, "shibai");
                    }
                });
            },
            fail: function(a) {
                console.log(a, "shibai");
            }
        });
    },
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {}
});