function e(e, t, n) {
    return t in e ? Object.defineProperty(e, t, {
        value: n,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : e[t] = n, e;
}

function t(e) {
    var t = [];
    if (-1 != e.indexOf("?")) for (var n = e.split("?")[1].split("&"), o = 0; o < n.length; o++) n[o].split("=")[0] && unescape(n[o].split("=")[1]) && (t[o] = {
        name: n[o].split("=")[0],
        value: unescape(n[o].split("=")[1])
    });
    return t;
}

function n(e, t) {
    var n = new RegExp("(^|&)" + t + "=([^&]*)(&|$)"), o = e.split("?")[1].match(n);
    return null != o ? unescape(o[2]) : null;
}

function o(e, o, a) {
    var i = require("underscore.js"), r = require("md5.js"), s = "", c = n(e, "sign");
    if (c || o && o.sign) return !1;
    if (e && (s = t(e)), o) {
        var u = [];
        for (var f in o) f && o[f] && (u = u.concat({
            name: f,
            value: o[f]
        }));
        s = s.concat(u);
    }
    s = i.sortBy(s, "name"), s = i.uniq(s, !0, "name");
    for (var d = "", l = 0; l < s.length; l++) s[l] && s[l].name && s[l].value && (d += s[l].name + "=" + s[l].value, 
    l < s.length - 1 && (d += "&"));
    return a = a || getApp().siteInfo.token, c = r(d + a);
}

var a = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function(e) {
    return typeof e;
} : function(e) {
    return e && "function" == typeof Symbol && e.constructor === Symbol && e !== Symbol.prototype ? "symbol" : typeof e;
}, i = require("base64"), r = function(e) {
    return e && e.__esModule ? e : {
        default: e
    };
}(require("md5")), s = {};

s.base64Encode = function(e) {
    return (0, i.base64_encode)(e);
}, s.base64Decode = function(e) {
    return (0, i.base64_decode)(e);
}, s.md5 = function(e) {
    return (0, r.default)(e);
}, s.url = function(e, t) {
    var n = getApp(), o = n.siteInfo.siteroot + "?i=" + n.siteInfo.uniacid + "&t=" + n.siteInfo.multiid + "&v=" + n.siteInfo.version + "&from=wxapp&";
    if (e && ((e = e.split("/"))[0] && (o += "c=" + e[0] + "&"), e[1] && (o += "a=" + e[1] + "&"), 
    e[2] && (o += "do=" + e[2] + "&")), t && "object" === (void 0 === t ? "undefined" : a(t))) for (var i in t) i && t.hasOwnProperty(i) && t[i] && (o += i + "=" + t[i] + "&");
    return o;
}, s.getSign = function(e, t, n) {
    return o(e, t, n);
}, s.getNewUrl = function(e, t) {
    var a = e, i = wx.getStorageSync("userInfo").sessionid;
    if (-1 == a.indexOf("http://") && -1 == a.indexOf("https://") && (a = s.url(a)), 
    n(a, "state") || e.data && e.data.state || !i || (a = a + "&state=we7sid-" + i), 
    !e.data || !e.data.m) {
        getCurrentPages();
        a = a + "&m=" + t;
    }
    var r = o(a, e.data);
    return r && (a = a + "&sign=" + r), a;
}, s.request = function(t) {
    require("underscore.js");
    var a, i = require("md5.js"), r = getApp();
    (t = t || {}).cachetime = t.cachetime ? t.cachetime : 0, t.showLoading = void 0 === t.showLoading || t.showLoading;
    var c = wx.getStorageSync("userInfo").sessionid, u = t.url;
    if (-1 == u.indexOf("http://") && -1 == u.indexOf("https://") && (u = s.url(u)), 
    n(u, "state") || t.data && t.data.state || !c || (u = u + "&state=we7sid-" + c), 
    !t.data || !t.data.m) {
        var f = getCurrentPages();
        f.length && (f = f[getCurrentPages().length - 1]) && f.__route__ && (u += "&m=kundian_farm");
    }
    var d = o(u, t.data);
    if (d && (u = u + "&sign=" + d), !u) return !1;
    if (t.cachetime) {
        var l = i(u), g = wx.getStorageSync(l), p = Date.parse(new Date());
        if (g && g.data) {
            if (g.expire > p) return t.complete && "function" == typeof t.complete && t.complete(g), 
            t.success && "function" == typeof t.success && t.success(g), console.log("cache:" + u), 
            wx.hideLoading(), wx.hideNavigationBarLoading(), !0;
            wx.removeStorageSync(l);
        }
    }
    wx.request((a = {
        url: u,
        data: t.data ? t.data : {},
        header: t.header ? t.header : {},
        method: t.method ? t.method : "GET"
    }, e(a, "header", {
        "content-type": "application/x-www-form-urlencoded"
    }), e(a, "success", function(e) {
        if (wx.hideNavigationBarLoading(), wx.hideLoading(), e.data.errno) {
            if ("41009" == e.data.errno) return wx.setStorageSync("userInfo", ""), void s.getUserInfo(function() {
                s.request(t);
            });
            if (t.fail && "function" == typeof t.fail) t.fail(e); else if (e.data.message) {
                if (null != e.data.data && e.data.data.redirect) n = e.data.data.redirect; else var n = "";
                r.util.message(e.data.message, n, "error");
            }
        } else if (t.success && "function" == typeof t.success && t.success(e), t.cachetime) {
            var o = {
                data: e.data,
                expire: p + 1e3 * t.cachetime
            };
            wx.setStorageSync(l, o);
        }
    }), e(a, "fail", function(e) {
        wx.hideNavigationBarLoading(), wx.hideLoading();
        var n = require("md5.js")(u), o = wx.getStorageSync(n);
        if (o && o.data) return t.success && "function" == typeof t.success && t.success(o), 
        console.log("failreadcache:" + u), !0;
        t.fail && "function" == typeof t.fail && t.fail(e);
    }), e(a, "complete", function(e) {
        t.complete && "function" == typeof t.complete && t.complete(e);
    }), a));
}, s.getWe7User = function(e, t) {
    wx.showLoading({
        title: "玩命加载中....",
        mask: !0
    });
    var n = wx.getStorageSync("userInfo") || {};
    s.request({
        url: "auth/session/openid",
        data: {
            code: t || ""
        },
        cachetime: 0,
        showLoading: !1,
        success: function(t) {
            wx.hideLoading(), t.data.errno || (n.sessionid = t.data.data.sessionid, n.memberInfo = t.data.data.userinfo, 
            wx.setStorageSync("userInfo", n)), "function" == typeof e && e(n);
        }
    });
}, s.upadteUser = function(e, t) {
    var n = wx.getStorageSync("userInfo");
    if (!e) return "function" == typeof t && t(n);
    n.wxInfo = e.userInfo, s.request({
        url: "auth/session/userinfo",
        data: {
            signature: e.signature,
            rawData: e.rawData,
            iv: e.iv,
            encryptedData: e.encryptedData
        },
        method: "POST",
        header: {
            "content-type": "application/x-www-form-urlencoded"
        },
        cachetime: 0,
        success: function(e) {
            e.data.errno || (n.memberInfo = e.data.data, wx.setStorageSync("userInfo", n)), 
            "function" == typeof t && t(n);
        }
    });
}, s.checkSession = function(e) {
    s.request({
        url: "auth/session/check",
        method: "POST",
        cachetime: 0,
        showLoading: !1,
        success: function(t) {
            t.data.errno ? "function" == typeof e.fail && e.fail() : "function" == typeof e.success && e.success();
        },
        fail: function() {
            "function" == typeof e.fail && e.fail();
        }
    });
}, s.getUserInfo = function(e, t) {
    var n = function() {
        wx.login({
            success: function(n) {
                s.getWe7User(function(n) {
                    t ? s.upadteUser(t, function(t) {
                        "function" == typeof e && e(t);
                    }) : wx.canIUse("getUserInfo") ? wx.getUserInfo({
                        withCredentials: !0,
                        success: function(t) {
                            s.upadteUser(t, function(t) {
                                "function" == typeof e && e(t);
                            });
                        },
                        fail: function() {
                            "function" == typeof e && e(n);
                        }
                    }) : "function" == typeof e && e(n);
                }, n.code);
            },
            fail: function() {
                wx.showModal({
                    title: "获取信息失败",
                    content: "请允许授权以便为您提供给服务",
                    success: function(e) {
                        e.confirm && s.getUserInfo();
                    }
                });
            }
        });
    }, o = wx.getStorageSync("userInfo") || {};
    o.sessionid ? s.checkSession({
        success: function() {
            t ? s.upadteUser(t, function(t) {
                "function" == typeof e && e(t);
            }) : "function" == typeof e && e(o);
        },
        fail: function() {
            o.sessionid = "", console.log("relogin"), wx.removeStorageSync("userInfo"), n();
        }
    }) : n();
}, s.navigateBack = function(e) {
    var t = e.delta ? e.delta : 1;
    if (e.data) {
        var n = getCurrentPages(), o = n[n.length - (t + 1)];
        o.pageForResult ? o.pageForResult(e.data) : o.setData(e.data);
    }
    wx.navigateBack({
        delta: t,
        success: function(t) {
            "function" == typeof e.success && e.success(t);
        },
        fail: function(t) {
            "function" == typeof e.fail && e.fail(t);
        },
        complete: function() {
            "function" == typeof e.complete && e.complete();
        }
    });
}, s.message = function(e, t, n) {
    if (!e) return !0;
    if ("object" == (void 0 === e ? "undefined" : a(e)) && (t = e.redirect, n = e.type, 
    e = e.title), t) {
        var o = t.substring(0, 9), i = "", r = "";
        "navigate:" == o ? (r = "navigateTo", i = t.substring(9)) : "redirect:" == o ? (r = "redirectTo", 
        i = t.substring(9)) : (i = t, r = "redirectTo");
    }
    n || (n = "success"), "success" == n ? wx.showToast({
        title: e,
        icon: "success",
        duration: 2e3,
        mask: !!i,
        complete: function() {
            i && setTimeout(function() {
                wx[r]({
                    url: i
                });
            }, 1800);
        }
    }) : "error" == n && wx.showModal({
        title: "系统信息",
        content: e,
        showCancel: !1,
        complete: function() {
            i && wx[r]({
                url: i
            });
        }
    });
}, s.user = s.getUserInfo, s.saveFormId = function(e, t) {
    var n = wx.getStorageSync("kundian_farm_uid");
    s.request({
        url: "entry/wxapp/class",
        data: {
            op: "saveFormId",
            action: "index",
            control: "home",
            form_id: e,
            uniacid: t,
            uid: n
        },
        success: function(e) {
            console.log(e);
        }
    });
}, s.setNavColor = function() {
    var e = wx.getStorageSync("kundian_farm_setData");
    wx.setNavigationBarColor({
        frontColor: e.front_color,
        backgroundColor: e.nav_top_color
    });
}, module.exports = s;