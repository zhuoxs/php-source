function e(e, a, t) {
    return a in e ? Object.defineProperty(e, a, {
        value: t,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : e[a] = t, e;
}

function a(e, a) {
    var t = new RegExp("(^|&)" + a + "=([^&]*)(&|$)"), i = e.split("?")[1].match(t);
    return null != i ? unescape(i[2]) : null;
}

function t(e, t, r) {
    var n = require("../../../we7/js/underscore.js"), o = require("../../../we7/js/md5.js"), s = "", c = a(e, "sign");
    if (c || t && t.sign) return !1;
    if (e && (s = i(e)), t) {
        var d = [];
        for (var u in t) u && t[u] && (d = d.concat({
            name: u,
            value: t[u]
        }));
        s = s.concat(d);
    }
    s = n.sortBy(s, "name"), s = n.uniq(s, !0, "name");
    for (var f = "", l = 0; l < s.length; l++) s[l] && s[l].name && s[l].value && (f += s[l].name + "=" + s[l].value, 
    l < s.length - 1 && (f += "&"));
    return r = r || getApp().siteInfo.token, c = o(f + r);
}

function i(e) {
    var a = [];
    if (-1 != e.indexOf("?")) for (var t = e.split("?")[1].split("&"), i = 0; i < t.length; i++) t[i].split("=")[0] && unescape(t[i].split("=")[1]) && (a[i] = {
        name: t[i].split("=")[0],
        value: unescape(t[i].split("=")[1])
    });
    return a;
}

var r = require("../../../we7/js/util.js");

r.request = function(i) {
    require("../../../we7/js/underscore.js");
    var n, o = require("../../../we7/js/md5.js"), s = getApp();
    (i = i || {}).cachetime = i.cachetime ? i.cachetime : 0, i.showLoading = void 0 === i.showLoading || i.showLoading, 
    i.fromcache = void 0 == i.fromcache || i.fromcache;
    for (var c in i.data) void 0 === i.data[c] && delete i.data[c];
    var d = wx.getStorageSync("userInfo").sessionid, u = i.url;
    if (-1 == u.indexOf("http://") && -1 == u.indexOf("https://") && (u = r.url(u)), 
    a(u, "state") || i.data && i.data.state || !d || (u = u + "&state=we7sid-" + d), 
    !i.data || !i.data.m) {
        var f = getCurrentPages();
        f && (f = f[getCurrentPages().length - 1]).__route__ && (u = u + "&m=" + f.__route__.split("/")[0]);
    }
    var l = t(u, i.data);
    if (l && (u = u + "&sign=" + l), !u) return !1;
    wx.showNavigationBarLoading(), i.showLoading && r.showLoading();
    var g = o(u);
    if (i.fromcache && i.cachetime) {
        var p = wx.getStorageSync(g), m = Date.parse(new Date());
        if (p && p.data) {
            if (p.expire > m) return i.complete && "function" == typeof i.complete && i.complete(p), 
            i.success && "function" == typeof i.success && i.success(p), wx.hideLoading(), wx.hideNavigationBarLoading(), 
            !0;
            wx.removeStorageSync(g);
        }
    }
    if ("post" == i.method) for (var h in i.data) "string" != typeof i.data[h] && (i.data[h] = JSON.stringify(i.data[h]));
    wx.request((n = {
        url: u,
        data: i.data ? i.data : {},
        header: i.header ? i.header : {},
        method: i.method ? i.method : "POST"
    }, e(n, "header", {
        "content-type": "application/x-www-form-urlencoded"
    }), e(n, "success", function(e) {
        if (wx.hideNavigationBarLoading(), wx.hideLoading(), e.data && e.data.errno) {
            if ("41009" == e.data.errno) return wx.setStorageSync("userInfo", ""), void r.getUserInfo(function() {
                r.request(i);
            });
            if (i.fail && "function" == typeof i.fail) i.fail(e); else if (e.data.message) {
                if (null != e.data.data && e.data.data.redirect) a = e.data.data.redirect; else var a = "";
                s.util.message(e.data.message, a, "error");
            }
        } else if (i.success && "function" == typeof i.success && i.success(e), i.cachetime) {
            var t = {
                data: e.data,
                expire: m + 1e3 * i.cachetime
            };
            wx.setStorageSync(g, t);
        }
    }), e(n, "fail", function(e) {
        wx.hideNavigationBarLoading(), wx.hideLoading();
        var a = require("../../../we7/js/md5.js")(u), t = wx.getStorageSync(a);
        if (t && t.data) return i.success && "function" == typeof i.success && i.success(t), 
        console.log("failreadcache:" + u), !0;
        i.fail && "function" == typeof i.fail && i.fail(e);
    }), e(n, "complete", function(e) {
        i.complete && "function" == typeof i.complete && i.complete(e);
    }), n));
}, module.exports = r;