var _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function(e) {
    return typeof e;
} : function(e) {
    return e && "function" == typeof Symbol && e.constructor === Symbol && e !== Symbol.prototype ? "symbol" : typeof e;
};

function _defineProperty(e, t, n) {
    return t in e ? Object.defineProperty(e, t, {
        value: n,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : e[t] = n, e;
}

var util = {}, openid = "";

function getQuery(e) {
    var t = [];
    if (-1 != e.indexOf("?")) for (var n = e.split("?")[1].split("&"), a = 0; a < n.length; a++) n[a].split("=")[0] && unescape(n[a].split("=")[1]) && (t[a] = {
        name: n[a].split("=")[0],
        value: unescape(n[a].split("=")[1])
    });
    return t;
}

function getUrlParam(e, t) {
    var n = new RegExp("(^|&)" + t + "=([^&]*)(&|$)"), a = e.split("?")[1].match(n);
    return null != a ? unescape(a[2]) : null;
}

function getSign(e, t, n) {
    var a = require("underscore.js"), i = require("md5.js"), o = "", s = getUrlParam(e, "sign");
    if (s || t && t.sign) return !1;
    if (e && (o = getQuery(e)), t) {
        var r = [];
        for (var u in t) u && t[u] && (r = r.concat({
            name: u,
            value: t[u]
        }));
        o = o.concat(r);
    }
    o = a.sortBy(o, "name"), o = a.uniq(o, !0, "name");
    for (var c = "", l = 0; l < o.length; l++) o[l] && o[l].name && o[l].value && (c += o[l].name + "=" + o[l].value, 
    l < o.length - 1 && (c += "&"));
    return s = i(c + (n = n || getApp().siteInfo.token));
}

util.url = function(e, t) {
    var n = getApp(), a = n.siteInfo.siteroot + "?i=" + n.siteInfo.uniacid + "&t=" + n.siteInfo.multiid + "&v=" + n.siteInfo.version + "&from=wxapp&";
    if (e && ((e = e.split("/"))[0] && (a += "c=" + e[0] + "&"), e[1] && (a += "a=" + e[1] + "&"), 
    e[2] && (a += "do=" + e[2] + "&")), t) for (var i in t) i && t[i] && (a += i + "=" + t[i] + "&");
    return a;
}, util.request = function(a) {
    require("underscore.js");
    var e, t = require("md5.js"), i = getApp();
    (a = a || {}).cachetime = a.cachetime ? a.cachetime : 0, a.showLoading = void 0 === a.showLoading || a.showLoading;
    var n = wx.getStorageSync("userInfo").sessionid, o = a.url;
    if (-1 == o.indexOf("http://") && -1 == o.indexOf("https://") && (o = util.url(o)), 
    getUrlParam(o, "state") || a.data && a.data.state || !n || (o = o + "&state=we7sid-" + n), 
    !a.data || !a.data.m) {
        var s = getCurrentPages();
        s && (s = s[getCurrentPages().length - 1]).__route__ && (o = o + "&m=" + s.__route__.split("/")[0]);
    }
    var r = getSign(o, a.data);
    if (r && (o = o + "&sign=" + r), !o) return !1;
    if (wx.showNavigationBarLoading(), a.showLoading && util.showLoading(), a.cachetime) {
        var u = t(o), c = wx.getStorageSync(u), l = Date.parse(new Date());
        if (c && c.data) {
            if (c.expire > l) return a.complete && "function" == typeof a.complete && a.complete(c), 
            a.success && "function" == typeof a.success && a.success(c), wx.hideLoading(), wx.hideNavigationBarLoading(), 
            !0;
            wx.removeStorageSync(u);
        }
    }
    wx.request((_defineProperty(e = {
        url: o,
        data: a.data ? a.data : {},
        header: a.header ? a.header : {},
        method: a.method ? a.method : "POST"
    }, "header", {
        "content-type": "application/x-www-form-urlencoded"
    }), _defineProperty(e, "success", function(e) {
        if (wx.hideNavigationBarLoading(), wx.hideLoading(), e.data.errno) {
            if ("41009" == e.data.errno) return wx.setStorageSync("userInfo", ""), void util.getUserInfo(function() {
                util.request(a);
            });
            if (a.fail && "function" == typeof a.fail) a.fail(e); else if (e.data.message) {
                if (null != e.data.data && e.data.data.redirect) var t = e.data.data.redirect; else t = "";
                i.util.message(e.data.message, t, "error");
            }
        } else if (a.success && "function" == typeof a.success && a.success(e), a.cachetime) {
            var n = {
                data: e.data,
                expire: l + 1e3 * a.cachetime
            };
            wx.setStorageSync(u, n);
        }
    }), _defineProperty(e, "fail", function(e) {
        wx.hideNavigationBarLoading(), wx.hideLoading();
        var t = require("md5.js")(o), n = wx.getStorageSync(t);
        if (n && n.data) return a.success && "function" == typeof a.success && a.success(n), 
        !0;
        a.fail && "function" == typeof a.fail && a.fail(e);
    }), _defineProperty(e, "complete", function(e) {
        a.complete && "function" == typeof a.complete && a.complete(e);
    }), e));
}, util.redirectto = function(t, e) {
    switch (e) {
      case "page":
        "/sudu8_page/index/index" == t || "/sudu8_page/index/index/" == t ? wx.reLaunch({
            url: t
        }) : wx.navigateTo({
            url: t
        });
        break;

      case "web":
        wx.navigateTo({
            url: "/sudu8_page/webpage/webpage?url=" + encodeURIComponent(t)
        });
        break;

      case "tel":
        t = t.slice(4), wx.showModal({
            title: "提示",
            content: "是否拨打电话:" + t,
            success: function(e) {
                1 == e.confirm && wx.makePhoneCall({
                    phoneNumber: t
                });
            }
        });
        break;

      case "map":
        t = (n = t.split("##"))[0].split(","), wx.openLocation({
            latitude: parseFloat(t[0]),
            longitude: parseFloat(t[1]),
            scale: 22,
            name: n[1],
            address: n[2]
        });
        break;

      case "mini":
        var n, a = (n = t.split(","))[0].slice(6);
        if (2 == n.length) var i = n[1].slice(9); else i = "";
        wx.navigateToMiniProgram({
            appId: a,
            path: i,
            success: function(e) {}
        });
    }
}, util.getUserInfo = function(n, a) {
    getCurrentPages();
    wx.getStorage({
        key: "openid",
        success: function(e) {
            util.fxsbindagain(a, e.data), "function" == typeof n && n();
        },
        fail: function() {
            wx.login({
                success: function(e) {
                    var t = util.url("entry/wxapp/Appbase", {
                        m: "sudu8_page"
                    });
                    wx.request({
                        url: t,
                        data: {
                            code: e.code
                        },
                        success: function(e) {
                            if (e.data.data) {
                                wx.setStorageSync("openid", e.data.data.openid);
                                var t = e.data.data.openid;
                                util.fxsbindagain(a, t), "function" == typeof n && n();
                            } else wx.showModal({
                                title: "提醒",
                                content: "获取用户信息失败，请检查appid和appsecret是否正确！",
                                showCancel: !1
                            });
                        }
                    });
                },
                fail: function() {
                    wx.showModal({
                        title: "获取信息失败",
                        content: "请允许授权以便为您提供给服务",
                        success: function(e) {
                            e.confirm && util.getUserInfo();
                        }
                    });
                }
            });
        }
    });
}, util.fxsbindagain = function(e, t) {
    0 != e && e != t ? (util.fxsbind(e, t), wx.setStorageSync("fxsid", e)) : wx.getStorage({
        key: "fxsid",
        success: function(e) {
            0 != e.data && util.fxsbind(e.data, t);
        },
        fail: function() {
            wx.setStorageSync("fxsid", 0);
        }
    });
}, util.fxsbind = function(e, t) {
    var n = util.url("entry/wxapp/bindfxs", {
        m: "sudu8_page"
    });
    wx.request({
        url: n,
        data: {
            openid: t,
            fxsid: e
        },
        success: function(e) {}
    });
}, util.selfinfoget = function(i) {
    wx.getStorage({
        key: "golobeuser",
        success: function(e) {},
        fail: function() {
            wx.getSetting({
                success: function(e) {
                    e.authSetting["scope.userInfo"], wx.showModal({
                        title: "提示",
                        content: "必须授权登录后才能操作,是否重新授权登录？",
                        showCancel: !1,
                        success: function(e) {
                            wx.openSetting({
                                success: function(e) {
                                    e.authSetting["scope.userInfo"] ? wx.getUserInfo({
                                        success: function(e) {
                                            var t = e.userInfo, n = wx.getStorageSync("openid"), a = util.url("entry/wxapp/Useupdate", {
                                                m: "sudu8_page"
                                            });
                                            wx.request({
                                                url: a,
                                                data: {
                                                    openid: n,
                                                    nickname: t.nickName,
                                                    avatarUrl: t.avatarUrl,
                                                    gender: t.gender,
                                                    province: t.province,
                                                    city: t.city,
                                                    country: t.country
                                                },
                                                header: {
                                                    "content-type": "application/json"
                                                },
                                                success: function(e) {
                                                    wx.setStorageSync("golobeuid", e.data.data.id), wx.setStorageSync("golobeuser", e.data.data), 
                                                    "function" == typeof i && i();
                                                }
                                            });
                                        }
                                    }) : util.selfinfoget();
                                }
                            });
                        }
                    });
                }
            });
        }
    });
}, util.openset = function() {
    wx.showModal({
        title: "提示",
        content: "必须授权登录后才能操作,是否重新授权登录？",
        showCancel: !1,
        success: function(e) {
            wx.openSetting({
                success: function(e) {
                    e.authSetting["scope.userInfo"] ? wx.getUserInfo({
                        success: function(e) {
                            var t = e.userInfo, n = util.url("entry/wxapp/Useupdate", {
                                m: "sudu8_page"
                            });
                            wx.request({
                                url: n,
                                data: {
                                    openid: openid,
                                    nickname: t.nickName,
                                    avatarUrl: t.avatarUrl,
                                    gender: t.gender,
                                    province: t.province,
                                    city: t.city,
                                    country: t.country
                                },
                                header: {
                                    "content-type": "application/json"
                                },
                                success: function(e) {
                                    wx.setStorageSync("golobeuid", e.data.data.id);
                                }
                            });
                        }
                    }) : util.openset();
                }
            });
        }
    });
}, util.navigateBack = function(t) {
    var e = t.delta ? t.delta : 1;
    if (t.data) {
        var n = getCurrentPages(), a = n[n.length - (e + 1)];
        a.pageForResult ? a.pageForResult(t.data) : a.setData(t.data);
    }
    wx.navigateBack({
        delta: e,
        success: function(e) {
            "function" == typeof t.success && t.success(e);
        },
        fail: function(e) {
            "function" == typeof t.fail && t.function(e);
        },
        complete: function() {
            "function" == typeof t.complete && t.complete();
        }
    });
}, util.footer = function(e) {
    var t = e, n = getApp().tabBar;
    for (var a in n.list) n.list[a].pageUrl = n.list[a].pagePath.replace(/(\?|#)[^"]*/g, "");
    t.setData({
        tabBar: n,
        "tabBar.thisurl": t.__route__
    });
}, util.message = function(e, t, n) {
    if (!e) return !0;
    if ("object" == (void 0 === e ? "undefined" : _typeof(e)) && (t = e.redirect, n = e.type, 
    e = e.title), t) {
        var a = t.substring(0, 9), i = "", o = "";
        "navigate:" == a ? (o = "navigateTo", i = t.substring(9)) : "redirect:" == a ? (o = "redirectTo", 
        i = t.substring(9)) : (i = t, o = "redirectTo");
    }
    n || (n = "success"), "success" == n ? wx.showToast({
        title: e,
        icon: "success",
        duration: 2e3,
        mask: !!i,
        complete: function() {
            i && setTimeout(function() {
                wx[o]({
                    url: i
                });
            }, 1800);
        }
    }) : "error" == n && wx.showModal({
        title: "系统信息",
        content: e,
        showCancel: !1,
        complete: function() {
            i && wx[o]({
                url: i
            });
        }
    });
}, util.user = util.getUserInfo, util.showLoading = function() {
    wx.getStorageSync("isShowLoading") && (wx.hideLoading(), wx.setStorageSync("isShowLoading", !1)), 
    wx.showLoading({
        title: "加载中",
        complete: function() {
            wx.setStorageSync("isShowLoading", !0);
        },
        fail: function() {
            wx.setStorageSync("isShowLoading", !1);
        }
    });
}, util.countDown = function(t, n) {
    var r = 2 < arguments.length && void 0 !== arguments[2] ? arguments[2] : 0;
    "object" != (void 0 === n ? "undefined" : _typeof(n)) && (n = [ n ]);
    var u = function(e) {
        return e < 10 ? "0" + e : e;
    }, c = 0;
    if ("function" == typeof t && t(function(e) {
        for (var t = [], n = 0; n < e.length; n++) if (0 < e[n]) {
            var a = Math.floor(e[n] / 1e3), i = Math.floor(a / 3600), o = {};
            o.day = Math.floor(i / 24), o.hour = u(i % 24), o.min = u(Math.floor((a - 3600 * i) / 60)), 
            o.sec = u(a % 60), o.sto_id = r, t.push(o);
        } else {
            var s = {
                day: 0,
                hour: 0,
                min: 0,
                sec: 0
            };
            s.sto_id = r, t.push(s), c++;
        }
        return 1 == e.length ? t[0] : t;
    }(n)), c != n.length) r = setTimeout(function() {
        for (var e = 0; e < n.length; e++) n[e] -= 1e3;
        util.countDown(t, n, r);
    }, 1e3);
}, module.exports = util;