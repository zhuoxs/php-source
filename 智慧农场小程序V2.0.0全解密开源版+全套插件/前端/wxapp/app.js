App({
    onLaunch: function() {
        var a = this, n = this;
        wx.getSystemInfo({
            success: function(n) {
                a.globalData.sysData = n, n.model.indexOf("iPhone X") > -1 && (a.globalData.isIphoneX = !0);
                var t = [ n.windowHeight, n.screenWidth, n.model, !1 ], i = t[0], e = t[1], o = t[2], r = t[3];
                o.indexOf("iPhone X") > -1 && (r = !0), a.globalData.screenHeight = i, a.globalData.isFullScreen = r, 
                a.globalData.Proportion = e / 750;
            }
        });
        var t = this;
        wx.getSystemInfo({
            success: function(a) {
                var n = 68;
                -1 !== a.model.indexOf("iPhone X") ? n = 88 : -1 !== a.model.indexOf("iPhone") && (n = 64), 
                t.globalData.statusBarHeight = a.statusBarHeight, t.globalData.titleBarHeight = n - a.statusBarHeight;
            },
            failure: function() {
                t.globalData.statusBarHeight = 0, t.globalData.titleBarHeight = 0;
            }
        });
        var i = n.siteInfo.siteroot + "?i=" + n.siteInfo.uniacid + "&t=" + n.siteInfo.multiid + "&v=" + n.siteInfo.version + "&from=wxapp&m=kundian_farm&c=entry&a=wxapp&do=class";
        wx.request({
            url: i,
            data: {
                op: "getCommonData",
                uniacid: n.siteInfo.uniacid,
                control: "index"
            },
            success: function(a) {
                wx.setStorageSync("kundianFarmTarbar", a.data.tarbar), wx.setStorageSync("kundian_farm_setData", a.data.farmSetData), 
                "kundian_farm/pages/HomePage/index/index" != a.data.tarbar[0].path && wx.reLaunch({
                    url: "/" + a.data.tarbar[0].path + "?is_tarbar=true"
                });
            }
        });
    },
    onShow: function() {},
    onHide: function() {},
    onError: function(a) {},
    util: require("util/resource/js/util.js"),
    loginBindParent: function(a, n) {
        var t = this;
        void 0 != n && 0 != n && void 0 != a && 0 != a && t.bindParent(a, n);
    },
    bindParent: function(a, n) {
        var t = this;
        void 0 == a && 0 == a || t.util.request({
            url: "entry/wxapp/class",
            data: {
                control: "distribution",
                op: "bindParent",
                user_uid: a,
                uniacid: t.siteInfo.uniacid,
                uid: n
            },
            success: function(a) {
                console.log(a);
            },
            error: function(a) {
                console.log(a);
            }
        });
    },
    getAuthUserInfo: function(a) {
        var n = this, t = n.siteInfo.uniacid;
        return new Promise(function(i, e) {
            n.util.getUserInfo(function(a) {
                wx.showLoading({
                    title: "登录中..."
                }), console.log(a), wx.setStorageSync("kundian_farm_uid", a.memberInfo.uid), wx.setStorageSync("kundian_farm_sessionid", a.sessionid), 
                wx.setStorageSync("kundian_farm_wxInfo", a.wxInfo);
                var e = a.wxInfo.avatarUrl, o = a.wxInfo.nickName, r = a.memberInfo, s = {
                    op: "login",
                    action: "index",
                    control: "home",
                    avatar: r.avatar,
                    uid: r.uid,
                    nickname: r.nickname,
                    uniacid: t,
                    wxNickName: o,
                    wxAvatar: e
                };
                n.util.request({
                    url: "entry/wxapp/class",
                    data: s,
                    success: function(a) {
                        if (wx.setStorageSync("kundian_farm_uid", a.data.uid), 0 == a.data.code) {
                            var t = wx.getStorageSync("farm_share_uid");
                            void 0 != t && 0 != t && (n.loginBindParent(t, r.uid), wx.removeStorageSync("farm_share_uid")), 
                            wx.showToast({
                                title: "登陆成功",
                                icon: "none",
                                success: function(a) {}
                            });
                        } else wx.showToast({
                            title: "登录失败",
                            icon: "none"
                        });
                        i(a.data.uid), wx.hideLoading();
                    }
                });
            }, a.detail);
        });
    },
    globalData: {
        userInfo: null,
        uid: "",
        sessionid: "",
        sysData: {},
        isIphoneX: !1,
        screenHeight: 0,
        Proportion: 0,
        isFullScreen: !1,
        tarbar: []
    },
    siteInfo: {
        uniacid: "17",
        acid: "17",
        multiid: "1108",
        version: "1.0.0",
        siteroot: "https://www.wazyb.com/app/index.php"
    }
});
