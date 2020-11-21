var _globalData;

function _defineProperty(e, t, n) {
    return t in e ? Object.defineProperty(e, t, {
        value: n,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : e[t] = n, e;
}

App({
    siteInfo: require("siteinfo.js"),
    util: require("/we7/js/util.js"),
    func: require("func.js"),
    distribution: require("/zhy/distribution/distribution.js"),
    onLaunch: function() {
        var t = this, e = wx.getStorageSync("logs") || [];
        e.unshift(Date.now()), wx.setStorageSync("logs", e), wx.login({
            success: function(e) {}
        }), wx.getSetting({
            success: function(e) {
                e.authSetting["scope.userInfo"] && wx.getUserInfo({
                    success: function(e) {
                        t.globalData.userInfo = e.userInfo, t.userInfoReadyCallback && t.userInfoReadyCallback(e);
                    }
                });
            }
        });
    },
    onShow: function() {
        var t = this;
        wx.getSystemInfo({
            success: function(e) {
                console.log("适配"), console.log(e.model), -1 == e.model.search("iPhone X") && -1 == e.model.search("iPhone11") || (t.globalData.isIpx = !0);
            }
        });
    },
    globalData: (_globalData = {
        userInfo: null
    }, _defineProperty(_globalData, "userInfo", {}), _defineProperty(_globalData, "cardsBg", ""), 
    _defineProperty(_globalData, "isIpx", !1), _defineProperty(_globalData, "Plugin_distribution", "yzcyk_sun_plugin_distribution"), 
    _defineProperty(_globalData, "tabBar", {
        color: "#9E9E9E",
        selectedColor: "#f00",
        backgroundColor: "#fff",
        borderStyle: "#ccc",
        list: [ {
            pagePath: "/yzcyk_sun/pages/index/index",
            text: "首页",
            iconPath: "/style/images/index.png",
            selectedIconPath: "/style/images/indexSele.png",
            selectedColor: "#ff5e5e",
            active: !0
        }, {
            pagePath: "/yzcyk_sun/pages/punch/punch",
            text: "打卡",
            iconPath: "/style/images/punch.png",
            selectedIconPath: "/style/images/punchSele.png",
            selectedColor: "#ff5e5e",
            active: !1
        }, {
            pagePath: "/yzcyk_sun/pages/member/member",
            text: "亲子卡",
            iconPath: "/style/images/qzk.png",
            selectedIconPath: "/style/images/qzk.png",
            selectedColor: "#ff5e5e",
            active: !1
        }, {
            pagePath: "/yzcyk_sun/pages/shop/shop",
            text: "好店",
            iconPath: "/style/images/shop.png",
            selectedIconPath: "/style/images/shopSele.png",
            selectedColor: "#ff5e5e",
            active: !1
        }, {
            pagePath: "/yzcyk_sun/pages/user/user",
            text: "我的",
            iconPath: "/style/images/user.png",
            selectedIconPath: "/style/images/userSele.png",
            selectedColor: "#ff5e5e",
            active: !1
        } ],
        position: "bottom"
    }), _globalData),
    get_imgroot: function() {
        var a = 0 < arguments.length && void 0 !== arguments[0] && arguments[0], o = this;
        return new Promise(function(t, e) {
            var n = wx.getStorageSync("imgroot") || o.globalData.imgroot;
            n && !a ? t(n) : o.util.request({
                url: "entry/wxapp/Url1",
                success: function(e) {
                    wx.setStorageSync("imgroot", e.data), o.globalData.imgroot = e.data, t(e.data);
                }
            });
        });
    },
    get_wxuser_info: function() {
        var a = this;
        return new Promise(function(t, e) {
            var n = a.globalData.wxuser_info;
            n ? t(n) : wx.getSetting({
                success: function(e) {
                    e.authSetting["scope.userInfo"] ? wx.getUserInfo({
                        success: function(e) {
                            a.globalData.wxuser_info = e.userInfo, t(e.userInfo);
                        }
                    }) : wx.authorize({
                        scope: "scope.userInfo",
                        success: function(e) {
                            wx.getUserInfo({
                                success: function(e) {
                                    a.globalData.wxuser_info = e.userInfo, t(e.userInfo);
                                }
                            });
                        }
                    });
                }
            });
        });
    },
    get_wxuser_location: function() {
        var a = this;
        return new Promise(function(t, n) {
            var e = a.globalData.wxuser_location;
            e ? t(e) : wx.getSetting({
                success: function(e) {
                    e.authSetting["scope.userLocation"] ? wx.getLocation({
                        success: function(e) {
                            a.globalData.wxuser_location = e, t(e);
                        }
                    }) : wx.authorize({
                        scope: "scope.userLocation",
                        success: function(e) {
                            wx.getLocation({
                                success: function(e) {
                                    a.globalData.wxuser_location = e, t(e);
                                }
                            });
                        },
                        fail: function(e) {
                            n();
                        }
                    });
                }
            });
        });
    },
    get_openid: function() {
        var a = this;
        return new Promise(function(t, e) {
            var n = a.globalData.openid;
            n ? (wx.setStorageSync("openid", n), t(n)) : wx.login({
                success: function(e) {
                    e.code;
                    a.util.request({
                        url: "entry/wxapp/openid",
                        data: {
                            code: e.code
                        },
                        success: function(e) {
                            a.globalData.openid = e.data.openid, wx.setStorageSync("openid", e.data.openid), 
                            a.globalData.key = e.data.session_key, t(e.data.openid);
                        }
                    });
                }
            });
        });
    },
    get_user_info: function() {
        var a = 0 < arguments.length && void 0 !== arguments[0] && arguments[0], o = this;
        return new Promise(function(t, e) {
            var n = o.globalData.user_info;
            n && !a ? t(n) : o.get_openid().then(function(e) {
                o.util.request({
                    url: "entry/wxapp/getUser",
                    data: {
                        openid: e
                    },
                    success: function(e) {
                        o.globalData.user_info = e.data, o.globalData.uniacid = e.data.uniacid, t(e.data);
                    }
                });
            });
        });
    },
    get_setting: function() {
        var a = 0 < arguments.length && void 0 !== arguments[0] && arguments[0], o = this;
        return new Promise(function(t, e) {
            var n = o.globalData.setting;
            n && !a ? t(n) : o.util.request({
                url: "entry/wxapp/system",
                success: function(e) {
                    o.globalData.setting = e.data, t(e.data);
                }
            });
        });
    },
    get_user_vip: function() {
        0 < arguments.length && void 0 !== arguments[0] && arguments[0];
        var n = this;
        return new Promise(function(t, e) {
            n.get_openid().then(function(e) {
                n.util.request({
                    url: "entry/wxapp/checkVip",
                    data: {
                        openid: e
                    },
                    success: function(e) {
                        t(e.data);
                    }
                });
            });
        });
    },
    get_qz_cards: function() {
        var a = 0 < arguments.length && void 0 !== arguments[0] && arguments[0], o = this;
        return new Promise(function(t, e) {
            var n = o.globalData.qz;
            n && !a ? t(n) : o.util.request({
                url: "entry/wxapp/settings",
                success: function(e) {
                    o.globalData.qz = e.data, t(e.data);
                }
            });
        });
    },
    get_diy_msg: function() {
        var a = 0 < arguments.length && void 0 !== arguments[0] && arguments[0], o = this;
        return new Promise(function(t, e) {
            var n = o.globalData.diyMsg;
            n && !a ? t(n) : o.util.request({
                url: "entry/wxapp/getCustomize",
                cachetime: "5000",
                success: function(e) {
                    o.globalData.diyMsg = e.data, t(e.data);
                }
            });
        });
    },
    get_album: function(a) {
        var o = 1 < arguments.length && void 0 !== arguments[1] && arguments[1], s = this;
        return new Promise(function(t, e) {
            var n = s.globalData.album;
            n && !o ? t(n) : s.util.request({
                url: "entry/wxapp/getStoryAlbum",
                cachetime: "0",
                data: {
                    id: a
                },
                success: function(e) {
                    s.globalData.album = e.data, t(e.data);
                }
            });
        });
    }
});