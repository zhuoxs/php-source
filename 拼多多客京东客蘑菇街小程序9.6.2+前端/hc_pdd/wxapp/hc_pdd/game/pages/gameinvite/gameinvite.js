var app = getApp();

Page({
    data: {
        Mask: !1,
        shouquan: 0,
        pageNum: 1,
        loding: !0
    },
    jaizai: function(a) {
        var n = this, o = n.data.goodsist;
        app.util.request({
            url: "entry/wxapp/Goodslist",
            method: "POST",
            data: {
                pageNum: a,
                user_id: app.globalData.user_id
            },
            success: function(a) {
                for (var t = a.data.data.list, e = 0; e < t.length; e++) o.push(t[e]);
                n.setData({
                    goodsist: o,
                    loding: !0
                });
            }
        });
    },
    index: function() {
        wx.reLaunch({
            url: "../../../pages/index/index"
        });
    },
    mark: function() {
        wx.navigateTo({
            url: "../mark/mark"
        });
    },
    shangpin: function() {
        var n = this;
        app.util.request({
            url: "entry/wxapp/Goodslist",
            method: "POST",
            data: {
                user_id: app.globalData.user_id
            },
            success: function(a) {
                var t = a.data.data.list, e = a.data.data.goodtoplist;
                n.setData({
                    goodsist: t,
                    goodtoplist: e
                });
            },
            fail: function(a) {
                console.log("失败" + a);
            }
        });
    },
    details: function(a) {
        var t = a.currentTarget.dataset.id, e = (a.currentTarget.dataset.jump, a.currentTarget.dataset.hui);
        a.currentTarget.dataset.itemurl, a.currentTarget.dataset.skuid;
        wx.navigateTo({
            url: "../../../pages/details/details?goods_id=" + t + "&hui=" + e + "&parameter=0"
        });
    },
    onLoad: function(a) {
        var t = a.user_id;
        console.log(t, "获取携带参数");
        var e = wx.getSystemInfoSync().statusBarHeight, n = wx.getMenuButtonBoundingClientRect().top;
        this.setData({
            topone: e,
            top: n,
            invite_id: t
        }), this.shangpin();
    },
    fan: function() {
        wx.reLaunch({
            url: "../../../pages/index/index"
        });
    },
    overdue: function() {
        var t = this;
        wx.getSetting({
            success: function(a) {
                if (a.authSetting["scope.userInfo"]) wx.checkSession({
                    success: function(a) {
                        t.register(function(a) {});
                    },
                    fail: function(a) {
                        t.data.shouquan;
                        t.setData({
                            shouquan: 1
                        });
                    }
                }); else {
                    t.data.shouquan;
                    t.setData({
                        shouquan: 1
                    });
                }
            }
        });
    },
    login: function(e) {
        wx.showToast({
            title: "加载中...",
            mask: !0,
            icon: "loading"
        });
        var n = this;
        app.globalData.userInfo ? ("function" == typeof cb && cb(app.globalData.userInfo), 
        n.register(function(a) {})) : wx.login({
            success: function(a) {
                var t = e.detail;
                app.globalData.userInfo = t.userInfo, t.act = "autologin", t.code = a.code, app.util.request({
                    url: "entry/wxapp/getopenid",
                    method: "post",
                    dataType: "json",
                    data: t,
                    success: function(a) {
                        wx.hideLoading(), 0 == a.data.errno && (t.openid = a.data.data.openid, t.session_key = a.data.data.session_key, 
                        app.globalData.userInfo = t, app.globalData.session_key = a.data.data.session_key, 
                        wx.setStorageSync("user", e), "function" == typeof cb && cb(app.globalData.userInfo), 
                        n.register(function(a) {}), n.setData({
                            session_key: a.data.data.session_key
                        }));
                    }
                });
            },
            fail: function(a) {
                console.log(a, "获取失败");
            }
        });
    },
    register: function(r) {
        app.globalData.invite;
        var d = this;
        wx.getStorage({
            key: "user",
            success: function(a) {
                var t = a.data.detail, e = a.data.detail.openid, n = (t = t.userInfo).country, o = t.province, s = t.city, i = t.gender, u = t.nickName, c = t.avatarUrl;
                app.util.request({
                    url: "entry/wxapp/Gamezhuce",
                    method: "post",
                    dataType: "json",
                    data: {
                        openid: e,
                        nickname: u,
                        gender: i,
                        country: n,
                        province: o,
                        city: s,
                        avatar: c,
                        invite_id: d.data.invite_id
                    },
                    success: function(a) {
                        console.log(a.data.data, "成功"), app.globalData.user_id = a.data.data;
                        var t = a.data.data;
                        d.setData({
                            user_id: t,
                            shouquan: 0
                        }), "function" == typeof r && r(a.data.data);
                    },
                    fail: function(a) {
                        console.log(a, "未过期失败");
                        d.data.shouquan;
                        d.setData({
                            shouquan: 1
                        });
                    }
                });
            },
            fail: function(a) {
                d.data.shouquan;
                d.setData({
                    shouquan: 1
                });
            }
        });
    },
    getUserInfo: function(t) {
        var e = this;
        wx.getSetting({
            success: function(a) {
                console.log(a), a.authSetting["scope.userInfo"] ? e.login(t) : wx.showModal({
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
    onReady: function() {},
    onShow: function() {
        this.overdue();
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {
        var a = this.data.pageNum;
        a++, this.jaizai(a), this.setData({
            loding: !1,
            pageNum: a
        });
    },
    onShareAppMessage: function() {}
});