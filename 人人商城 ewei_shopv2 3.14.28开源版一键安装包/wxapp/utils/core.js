var t = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function(t) {
    return typeof t;
} : function(t) {
    return t && "function" == typeof Symbol && t.constructor === Symbol && t !== Symbol.prototype ? "symbol" : typeof t;
}, e = require("jquery");

module.exports = {
    toQueryPair: function(t, e) {
        return void 0 === e ? t : t + "=" + encodeURIComponent(null === e ? "" : String(e));
    },
    getUrl: function(n, o, i) {
        n = n.replace(/\//gi, ".");
        var a = getApp().getConfig().api + "&r=" + n;
        return o && ("object" == (void 0 === o ? "undefined" : t(o)) ? a += "&" + e.param(o) : "string" == typeof o && (a += "&" + o)), 
        a;
    },
    json: function(t, n, o, i, a, r) {
        var s = getApp(), c = s.getCache("userinfo_openid"), u = s.getCache("usermid"), f = s.getCache("authkey");
        (n = n || {}).comefrom = "wxapp", n.openid = "sns_wa_" + c, u && (n.mid = u.mid, 
        n.merchid = n.merchid || u.merchid);
        var d = this;
        i && d.loading(), n && (n.authkey = f || "");
        var l = {
            url: (a ? this.getUrl(t) : this.getUrl(t, n)) + "&timestamp=" + +new Date(),
            method: a ? "POST" : "GET",
            header: {
                "Content-type": a ? "application/x-www-form-urlencoded" : "application/json",
                Cookie: "PHPSESSID=" + c
            }
        };
        r || delete l.header.Cookie, a && (l.data = e.param(n)), o && (l.success = function(t) {
            if (i && d.hideLoading(), "request:ok" == t.errMsg && "function" == typeof o) {
                if (s.setCache("authkey", t.data.authkey || ""), void 0 !== t.data.sysset) {
                    if (1 == t.data.sysset.isclose) return void wx.redirectTo({
                        url: "/pages/message/auth/index?close=1&text=" + t.data.sysset.closetext
                    });
                    s.setCache("sysset", t.data.sysset);
                }
                o(t.data);
            }
        }), l.fail = function(t) {
            i && d.hideLoading(), d.alert(t.errMsg);
        }, wx.request(l);
    },
    post: function(t, e, n, o, i) {
        this.json(t, e, n, o, !0, i);
    },
    get: function(t, e, n, o, i) {
        this.json(t, e, n, o, !1, i);
    },
    getDistanceByLnglat: function(t, e, n, o) {
        function i(t) {
            return t * Math.PI / 180;
        }
        var a = i(e), r = i(o), s = a - r, c = i(t) - i(n), u = 2 * Math.asin(Math.sqrt(Math.pow(Math.sin(s / 2), 2) + Math.cos(a) * Math.cos(r) * Math.pow(Math.sin(c / 2), 2)));
        return u *= 6378137, u = Math.round(1e4 * u) / 1e7;
    },
    alert: function(e, n) {
        "object" === (void 0 === e ? "undefined" : t(e)) && (e = JSON.stringify(e)), wx.showModal({
            title: "提示",
            content: e,
            showCancel: !1,
            success: function(t) {
                t.confirm && "function" == typeof confirm && n();
            }
        });
    },
    confirm: function(e, n, o) {
        "object" === (void 0 === e ? "undefined" : t(e)) && (e = JSON.stringify(e)), wx.showModal({
            title: "提示",
            content: e,
            showCancel: !0,
            success: function(t) {
                t.confirm ? "function" == typeof n && n() : "function" == typeof o && o();
            }
        });
    },
    loading: function(t) {
        void 0 !== t && "" != t || (t = "加载中"), wx.showToast({
            title: t,
            icon: "loading",
            duration: 5e6
        });
    },
    hideLoading: function() {
        wx.hideToast();
    },
    toast: function(t, e) {
        e || (e = "success"), wx.showToast({
            title: t,
            icon: e,
            duration: 1e3
        });
    },
    success: function(t) {
        wx.showToast({
            title: t,
            icon: "success",
            duration: 1e3
        });
    },
    upload: function(t) {
        var e = this;
        wx.chooseImage({
            success: function(n) {
                e.loading("正在上传...");
                var o = e.getUrl("util/uploader/upload", {
                    file: "file"
                }), i = n.tempFilePaths;
                wx.uploadFile({
                    url: o,
                    filePath: i[0],
                    name: "file",
                    success: function(n) {
                        e.hideLoading();
                        var o = JSON.parse(n.data);
                        if (0 != o.error) e.alert("上传失败"); else if ("function" == typeof t) {
                            var i = o.files[0];
                            t(i);
                        }
                    }
                });
            }
        });
    },
    pdata: function(t) {
        return t.currentTarget.dataset;
    },
    data: function(t) {
        return t.target.dataset;
    },
    phone: function(t) {
        var e = this.pdata(t).phone;
        wx.makePhoneCall({
            phoneNumber: e
        });
    },
    pay: function(e, n, o) {
        return "object" == (void 0 === e ? "undefined" : t(e)) && ("function" == typeof n && (e.success = n, 
        "function" == typeof o && (e.fail = o), void wx.requestPayment(e)));
    },
    cartcount: function(t) {
        this.get("member/cart/count", {}, function(e) {
            t.setData({
                cartcount: e.cartcount
            });
        });
    },
    onShareAppMessage: function(t, e) {
        var n = getApp(), o = n.getCache("sysset"), i = o.share || {}, a = n.getCache("userinfo_id"), r = o.shopname || "", s = o.description || "";
        return i.title && (r = i.title), e && (r = e), i.desc && (s = i.desc), t = t || "/pages/index/index", 
        t = -1 != t.indexOf("?") ? t + "&" : t + "?", {
            title: r,
            desc: s,
            path: t + "mid=" + a
        };
    },
    str2Obj: function(t) {
        if ("string" != typeof t) return t;
        if (t.indexOf("&") < 0 && t.indexOf("=") < 0) return {};
        var n = t.split("&"), o = {};
        return e.each(n, function(t, e) {
            if (e.indexOf("=") > -1) {
                var n = e.split("=");
                o[n[0]] = n[1];
            }
        }), o;
    },
    countDown: function(t, e) {
        var n = parseInt(Date.now() / 1e3), o = 0;
        if (t && (o = t > n ? t - n : n - t, o = parseInt(o)), e && (o = parseInt(e)), 0 == o) return !1;
        var i = Math.floor(o / 86400), a = Math.floor((o - 24 * i * 60 * 60) / 3600), r = Math.floor((o - 24 * i * 60 * 60 - 3600 * a) / 60), s = Math.floor(o - 24 * i * 60 * 60 - 3600 * a - 60 * r);
        return [ i, a < 10 ? "0" + a : a, r < 10 ? "0" + r : r, s < 10 ? "0" + s : s ];
    }
};