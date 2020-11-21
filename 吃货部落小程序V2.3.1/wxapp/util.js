function _defineProperty(e, t, a) {
    return t in e ? Object.defineProperty(e, t, {
        value: a,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : e[t] = a, e;
}

var util = require("/we7/js/util.js");

function getUrlParam(e, t) {
    var a = new RegExp("(^|&)" + t + "=([^&]*)(&|$)"), r = e.split("?")[1].match(a);
    return null != r ? unescape(r[2]) : null;
}

function getSign(e, t, a) {
    var r = require("/we7/js/underscore.js"), i = require("/we7/js/md5.js"), n = "", o = getUrlParam(e, "sign");
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
    require("/we7/js/underscore.js");
    var e, t = require("/we7/js/md5.js"), i = getApp();
    (r = r || {}).cachetime = r.cachetime ? r.cachetime : 0, r.showLoading = void 0 === r.showLoading || r.showLoading, 
    r.fromcache = null == r.fromcache || r.fromcache;
    var a = wx.getStorageSync("userInfo").sessionid, n = r.url;
    if (-1 == n.indexOf("http://") && -1 == n.indexOf("https://") && (n = util.url(n)), 
    getUrlParam(n, "state") || r.data && r.data.state || !a || (n = n + "&state=we7sid-" + a), 
    !r.data || !r.data.m) {
        var o = getCurrentPages();
        o && (o = o[getCurrentPages().length - 1]).__route__ && (n = n + "&m=" + o.__route__.split("/")[0]);
    }
    var s = getSign(n, r.data);
    if (s && (n = n + "&sign=" + s), !n) return !1;
    wx.showNavigationBarLoading(), r.showLoading && util.showLoading();
    var c = t(n);
    if (r.fromcache && r.cachetime) {
        var u = wx.getStorageSync(c), d = Date.parse(new Date());
        if (u && u.data) {
            if (u.expire > d) return r.complete && "function" == typeof r.complete && r.complete(u), 
            r.success && "function" == typeof r.success && r.success(u), wx.hideLoading(), wx.hideNavigationBarLoading(), 
            !0;
            wx.removeStorageSync(c);
        }
    }
    console.log("----接口地址数据----"), console.log(n), console.log(r.data), console.log("----接口地址数据end----"), 
    wx.request((_defineProperty(e = {
        url: n,
        data: r.data ? r.data : {},
        header: r.header ? r.header : {},
        method: r.method ? r.method : "GET"
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
                expire: d + 1e3 * r.cachetime
            };
            wx.setStorageSync(c, a);
        }
    }), _defineProperty(e, "fail", function(e) {
        wx.hideNavigationBarLoading(), wx.hideLoading();
        var t = require("/we7/js/md5.js")(n), a = wx.getStorageSync(t);
        if (a && a.data) return r.success && "function" == typeof r.success && r.success(a), 
        console.log("failreadcache:" + n), !0;
        r.fail && "function" == typeof r.fail && r.fail(e);
    }), _defineProperty(e, "complete", function(e) {
        r.complete && "function" == typeof r.complete && r.complete(e);
    }), e));
}, module.exports = util;