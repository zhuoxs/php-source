function _interopRequireDefault(e) {
    return e && e.__esModule ? e : {
        default: e
    };
}

function _defineProperty(e, t, n) {
    return t in e ? Object.defineProperty(e, t, {
        value: n,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : e[t] = n, e;
}

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
    var a = require("underscore.js"), r = require("md5.js"), i = "", o = getUrlParam(e, "sign");
    if (o || t && t.sign) return !1;
    if (e && (i = getQuery(e)), t) {
        var s = [];
        for (var u in t) u && t[u] && (s = s.concat({
            name: u,
            value: t[u]
        }));
        i = i.concat(s);
    }
    i = a.sortBy(i, "name"), i = a.uniq(i, !0, "name");
    for (var c = "", f = 0; f < i.length; f++) i[f] && i[f].name && i[f].value && (c += i[f].name + "=" + i[f].value, 
    f < i.length - 1 && (c += "&"));
    return n = n || getApp().siteInfo.token, o = r(c + n);
}

var _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function(e) {
    return typeof e;
} : function(e) {
    return e && "function" == typeof Symbol && e.constructor === Symbol && e !== Symbol.prototype ? "symbol" : typeof e;
}, _base = require("base64"), _md = require("md5"), _md2 = _interopRequireDefault(_md), util = {};

util.base64Encode = function(e) {
    return (0, _base.base64_encode)(e);
}, util.base64Decode = function(e) {
    return (0, _base.base64_decode)(e);
}, util.md5 = function(e) {
    return (0, _md2.default)(e);
}, util.url = function(e, t) {
    var n = getApp(), a = n.siteInfo.siteroot + "?i=" + n.siteInfo.uniacid + "&t=" + n.siteInfo.multiid + "&v=" + n.siteInfo.version + "&from=wxapp&";
    if (e && ((e = e.split("/"))[0] && (a += "c=" + e[0] + "&"), e[1] && (a += "a=" + e[1] + "&"), 
    e[2] && (a += "do=" + e[2] + "&")), t && "object" === (void 0 === t ? "undefined" : _typeof(t))) for (var r in t) r && t.hasOwnProperty(r) && t[r] && (a += r + "=" + t[r] + "&");
    return a;
}, util.getSign = function(e, t, n) {
    return getSign(e, t, n);
}, util.request = function(e) {
    require("underscore.js");
    var t, n = require("md5.js"), a = getApp();
    (e = e || {}).cachetime = e.cachetime ? e.cachetime : 0, e.showLoading = void 0 === e.showLoading || e.showLoading;
    var r = wx.getStorageSync("userInfo").sessionid, i = e.url;
    if (-1 == i.indexOf("http://") && -1 == i.indexOf("https://") && (i = util.url(i)), 
    getUrlParam(i, "state") || e.data && e.data.state || !r || (i = i + "&state=we7sid-" + r), 
    !e.data || !e.data.m) {
        var o = getCurrentPages();
        o.length && (o = o[getCurrentPages().length - 1]) && o.__route__ && (i = i + "&m=" + o.__route__.split("/")[0]);
    }
    var s = getSign(i, e.data);
    if (s && (i = i + "&sign=" + s), !i) return !1;
    if (wx.showNavigationBarLoading(), e.showLoading && util.showLoading(), e.cachetime) {
        var u = n(i), c = wx.getStorageSync(u), f = Date.parse(new Date());
        if (c && c.data) {
            if (c.expire > f) return e.complete && "function" == typeof e.complete && e.complete(c), 
            e.success && "function" == typeof e.success && e.success(c), console.log("cache:" + i), 
            wx.hideLoading(), wx.hideNavigationBarLoading(), !0;
            wx.removeStorageSync(u);
        }
    }
    wx.request((t = {
        url: i,
        data: e.data ? e.data : {},
        header: e.header ? e.header : {},
        method: e.method ? e.method : "GET"
    }, _defineProperty(t, "header", {
        "content-type": "application/x-www-form-urlencoded"
    }), _defineProperty(t, "success", function(t) {
        if (wx.hideNavigationBarLoading(), wx.hideLoading(), t.data.errno) {
            if ("41009" == t.data.errno) return wx.setStorageSync("userInfo", ""), void util.getUserInfo(function() {
                util.request(e);
            });
            if (e.fail && "function" == typeof e.fail) e.fail(t); else if (t.data.message) {
                if (null != t.data.data && t.data.data.redirect) n = t.data.data.redirect; else var n = "";
                a.util.message(t.data.message, n, "error");
            }
        } else if (e.success && "function" == typeof e.success && e.success(t), e.cachetime) {
            var r = {
                data: t.data,
                expire: f + 1e3 * e.cachetime
            };
            wx.setStorageSync(u, r);
        }
    }), _defineProperty(t, "fail", function(t) {
        wx.hideNavigationBarLoading(), wx.hideLoading();
        var n = require("md5.js")(i), a = wx.getStorageSync(n);
        if (a && a.data) return e.success && "function" == typeof e.success && e.success(a), 
        console.log("failreadcache:" + i), !0;
        e.fail && "function" == typeof e.fail && e.fail(t);
    }), _defineProperty(t, "complete", function(t) {
        e.complete && "function" == typeof e.complete && e.complete(t);
    }), t));
}, util.getWe7User = function(e, t) {
    var n = wx.getStorageSync("userInfo") || {};
    util.request({
        url: "auth/session/openid",
        data: {
            code: t || ""
        },
        cachetime: 0,
        showLoading: !1,
        success: function(t) {
            t.data.errno || (n.sessionid = t.data.data.sessionid, n.memberInfo = t.data.data.userinfo, 
            wx.setStorageSync("userInfo", n)), "function" == typeof e && e(n);
        }
    });
}, util.upadteUser = function(e, t) {
    var n = wx.getStorageSync("userInfo");
    if (!e) return "function" == typeof t && t(n);
    n.wxInfo = e.userInfo, util.request({
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
}, util.checkSession = function(e) {
    util.request({
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
}, util.getUserInfo = function(e, t) {
    var n = function() {
        console.log("start login");
        wx.login({
            success: function(n) {
                util.getWe7User(function(n) {
                    t ? util.upadteUser(t, function(t) {
                        "function" == typeof e && e(t);
                    }) : wx.canIUse("getUserInfo") ? wx.getUserInfo({
                        withCredentials: !0,
                        success: function(t) {
                            util.upadteUser(t, function(t) {
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
                        e.confirm && util.getUserInfo();
                    }
                });
            }
        });
    }, a = wx.getStorageSync("userInfo") || {};
    a.sessionid ? util.checkSession({
        success: function() {
            t ? util.upadteUser(t, function(t) {
                "function" == typeof e && e(t);
            }) : "function" == typeof e && e(a);
        },
        fail: function() {
            a.sessionid = "", console.log("relogin"), wx.removeStorageSync("userInfo"), n();
        }
    }) : n();
}, util.navigateBack = function(e) {
    var t = e.delta ? e.delta : 1;
    if (e.data) {
        var n = getCurrentPages(), a = n[n.length - (t + 1)];
        a.pageForResult ? a.pageForResult(e.data) : a.setData(e.data);
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
        var a = t.substring(0, 9), r = "", i = "";
        "navigate:" == a ? (i = "navigateTo", r = t.substring(9)) : "redirect:" == a ? (i = "redirectTo", 
        r = t.substring(9)) : (r = t, i = "redirectTo");
    }
    console.log(r), n || (n = "success"), "success" == n ? wx.showToast({
        title: e,
        icon: "success",
        duration: 2e3,
        mask: !!r,
        complete: function() {
            r && setTimeout(function() {
                wx[i]({
                    url: r
                });
            }, 1800);
        }
    }) : "error" == n && wx.showModal({
        title: "系统信息",
        content: e,
        showCancel: !1,
        complete: function() {
            r && wx[i]({
                url: r
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
}, util.showImage = function(e) {
    var t = e ? e.currentTarget.dataset.preview : "";
    if (!t) return !1;
    wx.previewImage({
        urls: [ t ]
    });
}, util.parseContent = function(e) {
    if (!e) return e;
    var t = [ "\ud83c[\udf00-\udfff]", "\ud83d[\udc00-\ude4f]", "\ud83d[\ude80-\udeff]" ], n = e.match(new RegExp(t.join("|"), "g"));
    if (n) for (var a in n) e = e.replace(n[a], "[U+" + n[a].codePointAt(0).toString(16).toUpperCase() + "]");
    return e;
}, util.date = function() {
    this.isLeapYear = function(e) {
        return 0 == e.getYear() % 4 && (e.getYear() % 100 != 0 || e.getYear() % 400 == 0);
    }, this.dateToStr = function(e, t) {
        e = arguments[0] || "yyyy-MM-dd HH:mm:ss", t = arguments[1] || new Date();
        var n = e, a = [ "日", "一", "二", "三", "四", "五", "六" ];
        return n = n.replace(/yyyy|YYYY/, t.getFullYear()), n = n.replace(/yy|YY/, t.getYear() % 100 > 9 ? (t.getYear() % 100).toString() : "0" + t.getYear() % 100), 
        n = n.replace(/MM/, t.getMonth() > 9 ? t.getMonth() + 1 : "0" + (t.getMonth() + 1)), 
        n = n.replace(/M/g, t.getMonth()), n = n.replace(/w|W/g, a[t.getDay()]), n = n.replace(/dd|DD/, t.getDate() > 9 ? t.getDate().toString() : "0" + t.getDate()), 
        n = n.replace(/d|D/g, t.getDate()), n = n.replace(/hh|HH/, t.getHours() > 9 ? t.getHours().toString() : "0" + t.getHours()), 
        n = n.replace(/h|H/g, t.getHours()), n = n.replace(/mm/, t.getMinutes() > 9 ? t.getMinutes().toString() : "0" + t.getMinutes()), 
        n = n.replace(/m/g, t.getMinutes()), n = n.replace(/ss|SS/, t.getSeconds() > 9 ? t.getSeconds().toString() : "0" + t.getSeconds()), 
        n = n.replace(/s|S/g, t.getSeconds());
    }, this.dateAdd = function(e, t, n) {
        switch (n = arguments[2] || new Date(), e) {
          case "s":
            return new Date(n.getTime() + 1e3 * t);

          case "n":
            return new Date(n.getTime() + 6e4 * t);

          case "h":
            return new Date(n.getTime() + 36e5 * t);

          case "d":
            return new Date(n.getTime() + 864e5 * t);

          case "w":
            return new Date(n.getTime() + 6048e5 * t);

          case "m":
            return new Date(n.getFullYear(), n.getMonth() + t, n.getDate(), n.getHours(), n.getMinutes(), n.getSeconds());

          case "y":
            return new Date(n.getFullYear() + t, n.getMonth(), n.getDate(), n.getHours(), n.getMinutes(), n.getSeconds());
        }
    }, this.dateDiff = function(e, t, n) {
        switch (e) {
          case "s":
            return parseInt((n - t) / 1e3);

          case "n":
            return parseInt((n - t) / 6e4);

          case "h":
            return parseInt((n - t) / 36e5);

          case "d":
            return parseInt((n - t) / 864e5);

          case "w":
            return parseInt((n - t) / 6048e5);

          case "m":
            return n.getMonth() + 1 + 12 * (n.getFullYear() - t.getFullYear()) - (t.getMonth() + 1);

          case "y":
            return n.getFullYear() - t.getFullYear();
        }
    }, this.strToDate = function(dateStr) {
        var data = dateStr, reCat = /(\d{1,4})/gm, t = data.match(reCat);
        return t[1] = t[1] - 1, eval("var d = new Date(" + t.join(",") + ");"), d;
    }, this.strFormatToDate = function(e, t) {
        var n = 0, a = -1, r = t.length;
        (a = e.indexOf("yyyy")) > -1 && a < r && (n = t.substr(a, 4));
        var i = 0;
        (a = e.indexOf("MM")) > -1 && a < r && (i = parseInt(t.substr(a, 2)) - 1);
        var o = 0;
        (a = e.indexOf("dd")) > -1 && a < r && (o = parseInt(t.substr(a, 2)));
        var s = 0;
        ((a = e.indexOf("HH")) > -1 || (a = e.indexOf("hh")) > 1) && a < r && (s = parseInt(t.substr(a, 2)));
        var u = 0;
        (a = e.indexOf("mm")) > -1 && a < r && (u = t.substr(a, 2));
        var c = 0;
        return (a = e.indexOf("ss")) > -1 && a < r && (c = t.substr(a, 2)), new Date(n, i, o, s, u, c);
    }, this.dateToLong = function(e) {
        return e.getTime();
    }, this.longToDate = function(e) {
        return new Date(e);
    }, this.isDate = function(e, t) {
        null == t && (t = "yyyyMMdd");
        var n = t.indexOf("yyyy");
        if (-1 == n) return !1;
        var a = e.substring(n, n + 4), r = t.indexOf("MM");
        if (-1 == r) return !1;
        var i = e.substring(r, r + 2), o = t.indexOf("dd");
        if (-1 == o) return !1;
        var s = e.substring(o, o + 2);
        return !(!isNumber(a) || a > "2100" || a < "1900") && (!(!isNumber(i) || i > "12" || i < "01") && !(s > getMaxDay(a, i) || s < "01"));
    }, this.getMaxDay = function(e, t) {
        return 4 == t || 6 == t || 9 == t || 11 == t ? "30" : 2 == t ? e % 4 == 0 && e % 100 != 0 || e % 400 == 0 ? "29" : "28" : "31";
    }, this.isNumber = function(e) {
        return /^\d+$/g.test(e);
    }, this.toArray = function(e) {
        e = arguments[0] || new Date();
        var t = Array();
        return t[0] = e.getFullYear(), t[1] = e.getMonth(), t[2] = e.getDate(), t[3] = e.getHours(), 
        t[4] = e.getMinutes(), t[5] = e.getSeconds(), t;
    }, this.datePart = function(e, t) {
        t = arguments[1] || new Date();
        var n = "", a = [ "日", "一", "二", "三", "四", "五", "六" ];
        switch (e) {
          case "y":
            n = t.getFullYear();
            break;

          case "M":
            n = t.getMonth() + 1;
            break;

          case "d":
            n = t.getDate();
            break;

          case "w":
            n = a[t.getDay()];
            break;

          case "ww":
            n = t.WeekNumOfYear();
            break;

          case "h":
            n = t.getHours();
            break;

          case "m":
            n = t.getMinutes();
            break;

          case "s":
            n = t.getSeconds();
        }
        return n;
    }, this.maxDayOfDate = function(e) {
        (e = arguments[0] || new Date()).setDate(1), e.setMonth(e.getMonth() + 1);
        var t = e.getTime() - 864e5;
        return new Date(t).getDate();
    };
}, module.exports = util;