var App = require("zhy/sdk/qitui/oddpush.js").oddPush(App, "App").App;

App({
    siteInfo: require("siteinfo.js"),
    util: require("/we7/js/utils/util.js"),
    onLaunch: function() {
        var t = wx.getStorageSync("logs") || [];
        t.unshift(Date.now()), wx.setStorageSync("logs", t), wx.request({
            url: this.siteInfo.siteroot + "?i=" + this.siteInfo.uniacid + "&t=undefined&v=1.0.0&from=wxapp&c=entry&a=wxapp&do=GetqtappData&m=ymktv_sun",
            header: {
                "content-type": "application/json"
            },
            success: function(t) {
                console.log(t.data);
                var e = t.data;
                wx.setStorageSync("qitui", e);
            }
        });
    },
    globalData: {
        userInfo: null,
        adBtn: !1,
        Plugin_distribution: "ymktv_sun_plugin_distribution",
        tabBarList: {}
    },
    func: require("func.js"),
    distribution: require("/zhy/distribution/distribution.js"),
    Func: require("/ymktv_sun/resource/js/func.js"),
    editTabBar: function() {
        var t = getCurrentPages(), e = t[t.length - 1], a = e.__route__;
        0 != a.indexOf("/") && (a = "/" + a);
        for (var n = this.globalData.tabBar, o = 0; o < n.list.length; o++) n.list[o].active = !1, 
        n.list[o].pagePath == a && (n.list[o].active = !0);
        var s = n.list;
        this.util.request({
            url: "entry/wxapp/Url",
            cachetime: "0",
            success: function(t) {
                wx.setStorageSync("url", t.data);
            }
        });
        var i = wx.getStorageSync("url");
        this.util.request({
            url: "entry/wxapp/Tab",
            cachetime: "0",
            success: function(t) {
                console.log(t.data), s[0].text = t.data.index, s[0].iconPath = i + t.data.indeximg, 
                s[0].selectedIconPath = i + t.data.indeximgs, s[1].text = t.data.coupon, s[1].iconPath = i + t.data.couponimg, 
                s[1].selectedIconPath = i + t.data.couponimgs, s[2].text = t.data.fans, s[2].iconPath = i + t.data.fansimg, 
                s[2].selectedIconPath = i + t.data.fansimgs, s[3].text = t.data.mine, s[3].iconPath = i + t.data.mineimg, 
                s[3].selectedIconPath = i + t.data.mineimgs, n.list = s;
            }
        }), console.log(n), e.setData({
            tabBar: n
        });
    },
    getNavList: function(t) {
        var e = getCurrentPages(), a = e[e.length - 1];
        this.util.request({
            url: "entry/wxapp/getNavList",
            data: {
                p: t
            },
            cachetime: "0",
            success: function(t) {
                console.log(t.data), 2 != t.data ? (a.setData({
                    nav_list: t.data
                }), t.data.nav.length <= 0 && a.setData({
                    showdefaultnav: !0
                })) : a.setData({
                    showdefaultnav: !0
                });
            }
        });
    },
    getSiteUrl: function() {
        var e = wx.getStorageSync("url");
        if (e) return console.log("图片路径缓存"), console.log(e), e;
        wx.request({
            url: this.siteInfo.siteroot + "?i=" + this.siteInfo.uniacid + "&t=undefined&v=1.0.0&from=wxapp&c=entry&a=wxapp&do=Url&m=ymktv_sun",
            header: {
                "content-type": "application/json"
            },
            success: function(t) {
                return console.log("服务器路径"), console.log(t.data), e = t.data, wx.setStorageSync("url", e), 
                e;
            }
        });
    },
    wxauthSetting: function(t) {
        var s = this, e = getCurrentPages(), i = e[e.length - 1];
        wx.login({
            success: function(t) {
                console.log("进入wx-login");
                var e = t.code;
                wx.setStorageSync("code", e), s.util.request({
                    url: "entry/wxapp/openid",
                    showLoading: !1,
                    data: {
                        code: e
                    },
                    success: function(t) {
                        console.log("进入获取openid"), console.log(t.data), wx.setStorageSync("key", t.data.session_key), 
                        wx.setStorageSync("openid", t.data.openid);
                        var o = t.data.openid;
                        wx.getSetting({
                            success: function(t) {
                                console.log("进入wx.getSetting"), console.log(t), t.authSetting["scope.userInfo"] && (console.log("scope.userInfo已授权"), 
                                wx.getUserInfo({
                                    success: function(t) {
                                        var e = t.userInfo.nickName, a = t.userInfo.avatarUrl, n = t.userInfo.gender;
                                        i.setData({
                                            is_modal_Hidden: !0,
                                            thumb: a,
                                            nickname: e
                                        }), console.log("进入wx-getUserInfo"), console.log(t.userInfo), wx.setStorageSync("user_info", t.userInfo), 
                                        s.util.request({
                                            url: "entry/wxapp/Login",
                                            showLoading: !1,
                                            cachetime: "0",
                                            data: {
                                                openid: o,
                                                img: a,
                                                name: e,
                                                gender: n
                                            },
                                            success: function(t) {
                                                i.onShow(), console.log("进入地址login"), console.log(t.data), wx.setStorageSync("users", t.data), 
                                                wx.setStorageSync("uniacid", t.data.uniacid), i.setData({
                                                    usersinfo: t.data
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
    },
    url: function() {
        this.util.request({
            url: "entry/wxapp/Url",
            cachetime: "0",
            success: function(t) {
                wx.setStorageSync("url", t.data);
            }
        });
    }
});