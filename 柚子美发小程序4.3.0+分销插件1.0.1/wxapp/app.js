var App = require("zhy/sdk/qitui/oddpush.js").oddPush(App, "App").App;

App({
    siteInfo: require("siteinfo.js"),
    util: require("/we7/js/util.js"),
    func: require("func.js"),
    onLaunch: function() {
        var t = wx.getUpdateManager();
        t.onCheckForUpdate(function(e) {
            console.log(e.hasUpdate);
        }), t.onUpdateReady(function() {
            wx.showModal({
                title: "更新提示",
                content: "新版本已经准备好，是否重启应用？",
                success: function(e) {
                    e.confirm && t.applyUpdate();
                }
            });
        }), t.onUpdateFailed(function() {}), wx.removeStorageSync("showAd");
        var a = this;
        wx.getSystemInfo({
            success: function(e) {
                -1 < e.model.indexOf("iPhone X") && (console.log(e.model), a.globalData.tabBar.isIpx = !0);
            }
        }), wx.request({
            url: this.siteInfo.siteroot + "?i=" + this.siteInfo.uniacid + "&t=undefined&v=1.0.0&from=wxapp&c=entry&a=wxapp&do=GetqtappData&m=ymmf_sun",
            header: {
                "content-type": "application/json"
            },
            success: function(e) {
                console.log(e.data);
                var t = e.data;
                wx.setStorageSync("qitui", t);
            }
        });
    },
    onShow: function() {
        var t = this;
        wx.getSystemInfo({
            success: function(e) {
                console.log(e.model), -1 != e.model.search("iPhone X") && (t.globalData.isIpx = !0);
            }
        });
    },
    globalData: {
        isIpx: !1,
        userInfo: null,
        showAd: !1,
        Plugin_distribution: "ymmf_sun_plugin_distribution",
        tabBar: {
            color: "#9E9E9E",
            selectedColor: "#f00",
            backgroundColor: "#fff",
            borderStyle: "#ccc",
            isIpx: !1,
            list: [ {
                pagePath: "/ymmf_sun/pages/index/index",
                text: "",
                iconPath: "",
                selectedIconPath: "",
                selectedColor: "#f92c53",
                active: !0
            }, {
                pagePath: "/ymmf_sun/pages/category/category",
                text: "",
                iconPath: "",
                selectedIconPath: "",
                selectedColor: "#f92c53",
                active: !1
            }, {
                pagePath: "/ymmf_sun/pages/bargain/bargain",
                text: "",
                iconPath: "",
                selectedIconPath: "",
                selectedColor: "#f92c53",
                active: !1
            }, {
                pagePath: "/ymmf_sun/pages/user/user",
                text: "",
                iconPath: "",
                selectedIconPath: "",
                selectedColor: "#f92c53",
                active: !1
            } ],
            position: "bottom"
        }
    },
    Func: require("/ymmf_sun/resource/js/func.js"),
    distribution: require("/zhy/distribution/distribution.js"),
    editTabBar: function() {
        var e = getCurrentPages(), t = e[e.length - 1], a = t.__route__;
        0 != a.indexOf("/") && (a = "/" + a);
        for (var o = this.globalData.tabBar, n = 0; n < o.list.length; n++) o.list[n].active = !1, 
        o.list[n].pagePath == a && (o.list[n].active = !0);
        var s = o.list;
        this.util.request({
            url: "entry/wxapp/Url",
            cachetime: "0",
            success: function(e) {
                wx.setStorageSync("url", e.data);
            }
        });
        var i = wx.getStorageSync("url");
        this.util.request({
            url: "entry/wxapp/Tab",
            cachetime: "0",
            success: function(e) {
                console.log(e.data), s[0].text = e.data.index, s[0].iconPath = i + e.data.indeximg, 
                s[0].selectedIconPath = i + e.data.indeximgs, s[1].text = e.data.coupon, s[1].iconPath = i + e.data.couponimg, 
                s[1].selectedIconPath = i + e.data.couponimgs, s[2].text = e.data.fans, s[2].iconPath = i + e.data.fansimg, 
                s[2].selectedIconPath = i + e.data.fansimgs, s[3].text = e.data.mine, s[3].iconPath = i + e.data.mineimg, 
                s[3].selectedIconPath = i + e.data.mineimgs, o.list = s;
            }
        }), console.log(o), t.setData({
            tabBar: o
        });
    },
    getNavList: function(e) {
        var t = getCurrentPages(), a = t[t.length - 1];
        this.util.request({
            url: "entry/wxapp/getNavList",
            data: {
                p: e
            },
            cachetime: "0",
            success: function(e) {
                console.log(e.data), 2 != e.data ? (a.setData({
                    nav_list: e.data
                }), e.data.nav.length <= 0 && a.setData({
                    showdefaultnav: !0
                })) : a.setData({
                    showdefaultnav: !0
                });
            }
        });
    },
    getSiteUrl: function() {
        var t = wx.getStorageSync("url");
        if (t) return console.log("图片路径缓存"), console.log(t), t;
        wx.request({
            url: this.siteInfo.siteroot + "?i=" + this.siteInfo.uniacid + "&t=undefined&v=1.0.0&from=wxapp&c=entry&a=wxapp&do=Url&m=ymmf_sun",
            header: {
                "content-type": "application/json"
            },
            success: function(e) {
                return console.log("服务器路径"), console.log(e.data), t = e.data, wx.setStorageSync("url", t), 
                t;
            }
        });
    },
    wxauthSetting: function(e) {
        var s = this, t = getCurrentPages(), i = t[t.length - 1];
        wx.login({
            success: function(e) {
                console.log("进入wx-login");
                var t = e.code;
                wx.setStorageSync("code", t), s.util.request({
                    url: "entry/wxapp/openid",
                    showLoading: !1,
                    data: {
                        code: t
                    },
                    success: function(e) {
                        console.log("进入获取openid"), console.log(e.data), wx.setStorageSync("key", e.data.session_key), 
                        wx.setStorageSync("openid", e.data.openid);
                        var n = e.data.openid;
                        wx.getSetting({
                            success: function(e) {
                                console.log("进入wx.getSetting"), console.log(e), e.authSetting["scope.userInfo"] && (console.log("scope.userInfo已授权"), 
                                wx.getUserInfo({
                                    success: function(e) {
                                        var t = e.userInfo.nickName, a = e.userInfo.avatarUrl, o = e.userInfo.gender;
                                        i.setData({
                                            is_modal_Hidden: !0,
                                            thumb: a,
                                            nickname: t
                                        }), console.log("进入wx-getUserInfo"), console.log(e.userInfo), wx.setStorageSync("user_info", e.userInfo), 
                                        s.util.request({
                                            url: "entry/wxapp/Login",
                                            showLoading: !1,
                                            cachetime: "0",
                                            data: {
                                                openid: n,
                                                img: a,
                                                name: t,
                                                gender: o
                                            },
                                            success: function(e) {
                                                console.log("---22222222222222222222222222---"), i.onShow(), console.log("进入地址login"), 
                                                console.log(e.data), wx.setStorageSync("users", e.data), wx.setStorageSync("uniacid", e.data.uniacid), 
                                                i.setData({
                                                    usersinfo: e.data
                                                });
                                            }
                                        });
                                    }
                                }));
                            }
                        });
                    }
                });
            }
        });
    }
});