function _defineProperty(e, t, a) {
    return t in e ? Object.defineProperty(e, t, {
        value: a,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : e[t] = a, e;
}

var util = require("../../../we7/js/util.js");

function getUrlParam(e, t) {
    var a = new RegExp("(^|&)" + t + "=([^&]*)(&|$)"), r = e.split("?")[1].match(a);
    return null != r ? unescape(r[2]) : null;
}

function getSign(e, t, a) {
    var r = require("../../../we7/js/underscore.js"), i = require("../../../we7/js/md5.js"), n = "", o = getUrlParam(e, "sign");
    if (o || t && t.sign) return !1;
    if (e && (n = getQuery(e)), t) {
        var s = [];
        for (var c in t) c && t[c] && (s = s.concat({
            name: c,
            value: t[c]
        }));
        n = n.concat(s);
    }
    n = r.sortBy(n, "name"), n = r.uniq(n, !0, "name");
    for (var u = "", d = 0; d < n.length; d++) n[d] && n[d].name && n[d].value && (u += n[d].name + "=" + n[d].value, 
    d < n.length - 1 && (u += "&"));
    return o = i(u + (a = a || getApp().siteInfo.token));
}

function getQuery(e) {
    var t = [];
    if (-1 != e.indexOf("?")) for (var a = e.split("?")[1].split("&"), r = 0; r < a.length; r++) a[r].split("=")[0] && unescape(a[r].split("=")[1]) && (t[r] = {
        name: a[r].split("=")[0],
        value: unescape(a[r].split("=")[1])
    });
    return t;
}

util.request = function(r) {
    require("../../../we7/js/underscore.js");
    var e, t = require("../../../we7/js/md5.js"), i = getApp();
    r = r || {};
    for (var a in r.cachetime = r.cachetime ? r.cachetime : 0, r.showLoading = void 0 === r.showLoading || r.showLoading, 
    r.fromcache = null == r.fromcache || r.fromcache, r.data) void 0 === r.data[a] && delete r.data[a];
    var n = wx.getStorageSync("userInfo").sessionid, o = r.url;
    if (-1 == o.indexOf("http://") && -1 == o.indexOf("https://") && (o = util.url(o)), 
    getUrlParam(o, "state") || r.data && r.data.state || !n || (o = o + "&state=we7sid-" + n), 
    !r.data || !r.data.m) {
        var s = getCurrentPages();
        s && (s = s[getCurrentPages().length - 1]).__route__ && (o = o + "&m=" + s.__route__.split("/")[0]);
    }
    var c = getSign(o, r.data);
    if (c && (o = o + "&sign=" + c), !o) return !1;
    wx.showNavigationBarLoading(), r.showLoading && util.showLoading();
    var u = t(o);
    if (r.fromcache && r.cachetime) {
        var d = wx.getStorageSync(u), f = Date.parse(new Date());
        if (d && d.data) {
            if (d.expire > f) return r.complete && "function" == typeof r.complete && r.complete(d), 
            r.success && "function" == typeof r.success && r.success(d), wx.hideLoading(), wx.hideNavigationBarLoading(), 
            !0;
            wx.removeStorageSync(u);
        }
    }
    if ("post" == r.method) for (var l in r.data) "string" != typeof r.data[l] && (r.data[l] = JSON.stringify(r.data[l]));
    wx.request((_defineProperty(e = {
        url: o,
        data: r.data ? r.data : {},
        header: r.header ? r.header : {},
        method: r.method ? r.method : "POST"
    }, "header", {
        "content-type": "application/x-www-form-urlencoded"
    }), _defineProperty(e, "success", function(e) {
        if (wx.hideNavigationBarLoading(), wx.hideLoading(), e.data && e.data.errno) {
            if ("41009" == e.data.errno) return wx.setStorageSync("userInfo", ""), void util.getUserInfo(function() {
                util.request(r);
            });
            if (r.fail && "function" == typeof r.fail) r.fail(e); else if (e.data.message) {
                if (null != e.data.data && e.data.data.redirect) var t = e.data.data.redirect; else t = "";
                i.util.message(e.data.message, t, "error");
            }
        } else if (r.success && "function" == typeof r.success && r.success(e), r.cachetime) {
            var a = {
                data: e.data,
                expire: f + 1e3 * r.cachetime
            };
            wx.setStorageSync(u, a);
        }
    }), _defineProperty(e, "fail", function(e) {
        wx.hideNavigationBarLoading(), wx.hideLoading();
        var t = require("../../../we7/js/md5.js")(o), a = wx.getStorageSync(t);
        if (a && a.data) return r.success && "function" == typeof r.success && r.success(a), 
        console.log("failreadcache:" + o), !0;
        r.fail && "function" == typeof r.fail && r.fail(e);
    }), _defineProperty(e, "complete", function(e) {
        r.complete && "function" == typeof r.complete && r.complete(e);
    }), e));
}, module.exports = util;