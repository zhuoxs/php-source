var _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function(t) {
    return typeof t;
} : function(t) {
    return t && "function" == typeof Symbol && t.constructor === Symbol && t !== Symbol.prototype ? "symbol" : typeof t;
};

!function() {
    var r = "6.1.2", u = require("./ald-stat-conf.js"), o = 0, _ = 0, i = 0, l = 0;
    function d(t) {
        var a = "";
        try {
            a = wx.getStorageSync("aldstat_uuid");
        } catch (t) {
            a = "uuid-getstoragesync";
        }
        if (!a) {
            a = "" + Date.now() + Math.floor(1e7 * Math.random());
            try {
                wx.setStorageSync("aldstat_uuid", a);
            } catch (t) {
                wx.setStorageSync("aldstat_uuid", "uuid-getstoragesync");
            }
            t.aldstat_is_first_open = !0;
        }
        return a;
    }
    function a(t, a, s) {
        if (t[a]) {
            var e = t[a];
            t[a] = function(t) {
                s.call(this, t, a), e.call(this, t);
            };
        } else t[a] = function(t) {
            s.call(this, t, a);
        };
    }
    var p = function(a) {
        wx.getSetting && wx.getSetting({
            success: function(t) {
                t.authSetting["scope.userInfo"] && wx.getUserInfo({
                    withCredentials: !1,
                    success: function(t) {
                        a(t);
                    }
                });
            }
        });
    }, h = function(a, s, e) {
        void 0 === s && (s = "GET"), void 0 === e && (e = "d.html");
        var n = 0;
        !function t() {
            o += 1, a.rq_c = o, wx.request({
                url: "https://log.aldwx.com/" + e,
                data: a,
                header: {
                    AldStat: "MiniApp-Stat"
                },
                method: s,
                success: function() {},
                fail: function() {
                    n < 2 && (n++, a.retryTimes = n, t());
                }
            });
        }();
    }, g = function(t, a, s, e) {
        void 0 === t.aldstat_showoption && (t.aldstat_showoption = {});
        var n = {
            ak: u.app_key,
            wsr: t.aldstat_showoption,
            uu: d(t),
            at: t.aldstat_access_token,
            st: Date.now(),
            tp: s,
            ev: a,
            nt: t.aldstat_network_type,
            pm: t.aldstat_phone_model,
            pr: t.aldstat_pixel_ratio,
            ww: t.aldstat_window_width,
            wh: t.aldstat_window_height,
            lang: t.aldstat_language,
            wv: t.aldstat_wechat_version,
            lat: t.aldstat_lat,
            lng: t.aldstat_lng,
            spd: t.aldstat_speed,
            v: r
        };
        e && (n.ct = e), t.aldstat_location_name && (n.ln = t.aldstat_location_name), t.aldstat_src && (n.sr = t.aldstat_src), 
        t.aldstat_qr && (n.qr = t.aldstat_qr), h(n, "GET", "d.html");
    };
    function c(t) {
        this.app = t;
    }
    c.prototype.debug = function(t) {
        g(this.app, "debug", 0, t);
    }, c.prototype.warn = function(t) {
        g(this.app, "debug", 1, t);
    }, c.prototype.error = function(t) {
        var a, s, e, n, o;
        a = this.app, s = "debug", e = 2, n = t, o = {
            ak: u.app_key,
            uu: d(a),
            at: a.aldstat_access_token,
            st: Date.now(),
            tp: e,
            ev: s,
            v: r
        }, n && (o.ct = n), a.aldstat_qr && (o.qr = a.aldstat_qr), h(o, "GET", "d.html");
    }, c.prototype.sendEvent = function(t, a) {
        if (!S(t)) return !1;
        if (255 <= t.length) return !1;
        if ("object" === (void 0 === a ? "undefined" : _typeof(a))) {
            for (var s in a) {
                if (!S(s)) return !1;
                if ("object" == _typeof(a[s])) return !1;
                if (!S(a[s])) return !1;
            }
            g(this.app, "event", t, JSON.stringify(a));
        } else if ("string" == typeof a && a.length <= 255) {
            if (S(a)) {
                var e = String(a);
                new Object()[e] = a, g(this.app, "event", t, a);
            }
        } else g(this.app, "event", t, !1);
    };
    var s = function() {
        this.aldstat_duration += Date.now() - this.aldstat_showtime, w(this, "app", "unLaunch");
    }, f = function(a, t, s) {
        void 0 !== wx.getShareInfo ? wx.getShareInfo({
            shareTicket: t,
            success: function(t) {
                g(a, "event", "ald_share_" + s, JSON.stringify(t));
            },
            fail: function() {
                g(a, "event", "ald_share_" + s, "1");
            }
        }) : g(a, "event", "ald_share_" + s, "1");
    }, e = function(t) {
        wx.request({
            url: "https://log.aldwx.com/config/app.json",
            header: {
                AldStat: "MiniApp-Stat"
            },
            method: "GET",
            success: function(t) {
                if (200 === t.statusCode) for (var a in t.data) wx.setStorageSync(a, t.data[a]);
            }
        }), this.aldstat = new c(this);
        var a = "";
        try {
            a = wx.getStorageSync("aldstat_src");
        } catch (t) {
            a = "uuid-getstoragesync";
        }
        a && (this.aldstat_src = a);
        var s = d(this);
        this.aldstat_uuid = s, this.aldstat_timestamp = Date.now(), this.aldstat_showtime = Date.now(), 
        this.aldstat_duration = 0;
        var e = this;
        e.aldstat_error_count = 0, e.aldstat_page_count = 1, e.aldstat_first_page = 0, this.aldstat_showoption = void 0 !== t ? t : {};
        var n = function() {
            wx.getSystemInfo({
                success: function(t) {
                    e.aldstat_vsdk_version = void 0 === t.SDKVersion ? "1.0.0" : t.SDKVersion, e.aldstat_phone_model = t.model, 
                    e.aldstat_pixel_ratio = t.pixelRatio, e.aldstat_window_width = t.windowWidth, e.aldstat_window_height = t.windowHeight, 
                    e.aldstat_language = t.language, e.aldstat_wechat_version = t.version, e.aldstat_sv = t.system, 
                    e.aldstat_wvv = t.platform;
                },
                complete: function() {
                    u.getLocation && r(), o();
                }
            });
        }, o = function() {
            p(function(t) {
                var a = "";
                try {
                    a = wx.getStorageSync("aldstat_uuid");
                } catch (t) {
                    a = "uuid-getstoragesync";
                }
                t.userInfo.uu = a, h(t.userInfo, "GET", "u.html");
            });
        }, r = function() {
            wx.getLocation({
                type: "wgs84",
                success: function(t) {
                    e.aldstat_lat = t.latitude, e.aldstat_lng = t.longitude, e.aldstat_speed = t.speed;
                }
            });
        };
        wx.getNetworkType({
            success: function(t) {
                e.aldstat_network_type = t.networkType;
            },
            complete: n
        });
        var _ = "";
        try {
            _ = wx.getStorageSync("app_session_key_create_launch_upload");
        } catch (t) {
            _ = "";
        }
        _ ? 0 < _ && "number" == typeof _ && (e.aldstat_access_token = "" + Date.now() + Math.floor(1e7 * Math.random())) : e.aldstat_access_token = "" + Date.now() + Math.floor(1e7 * Math.random()), 
        w(e, "app", "launch");
    }, n = function(t, a) {
        void 0 === this.aldstat_error_count ? this.aldstat_error_count = 1 : this.aldstat_error_count++, 
        g(this, "event", "ald_error_message", JSON.stringify(t));
    }, w = function(t, a, s) {
        var e = "";
        try {
            e = wx.getStorageSync("app_" + s + "_upload");
        } catch (t) {
            e = "";
        }
        if ((e || "launch" === s) && !(e < 1 && "number" == typeof e)) {
            void 0 === t.aldstat_timestamp && (t.aldstat_timestamp = Date.now());
            var n = wx.getSystemInfoSync();
            t.aldstat_vsdk_version = void 0 === n.SDKVersion ? "1.0.0" : n.SDKVersion, t.aldstat_phone_model = n.model, 
            t.aldstat_pixel_ratio = n.pixelRatio, t.aldstat_window_width = n.windowWidth, t.aldstat_window_height = n.windowHeight, 
            t.aldstat_language = n.language, t.aldstat_sv = n.system, t.aldstat_wvv = n.platform;
            var o = {
                ak: u.app_key,
                waid: u.appid,
                wst: u.appsecret,
                uu: d(t),
                at: t.aldstat_access_token,
                wsr: t.aldstat_showoption,
                st: t.aldstat_timestamp,
                dr: t.aldstat_duration,
                et: Date.now(),
                pc: t.aldstat_page_count,
                fp: t.aldstat_first_page,
                lp: t.aldstat_last_page,
                life: s,
                ec: t.aldstat_error_count,
                nt: t.aldstat_network_type,
                pm: t.aldstat_phone_model,
                wsdk: t.aldstat_vsdk_version,
                pr: t.aldstat_pixel_ratio,
                ww: t.aldstat_window_width,
                wh: t.aldstat_window_height,
                lang: t.aldstat_language,
                wv: t.aldstat_wechat_version,
                lat: t.aldstat_lat,
                lng: t.aldstat_lng,
                spd: t.aldstat_speed,
                v: r,
                ev: a,
                sv: t.aldstat_sv,
                wvv: t.aldstat_wvv
            };
            "launch" === s ? _ += 1 : "show" === s ? i += 1 : l += 1, o.la_c = _, o.as_c = i, 
            o.ah_c = l, t.page_share_count && "number" == typeof t.page_share_count && (o.sc = t.page_share_count), 
            t.aldstat_is_first_open && (o.ifo = "true"), t.aldstat_location_name && (o.ln = t.aldstat_location_name), 
            t.aldstat_src && (o.sr = t.aldstat_src), t.aldstat_qr && (o.qr = t.aldstat_qr), 
            t.ald_share_src && (o.usr = t.ald_share_src), h(o, "GET", "d.html");
        }
    }, v = function(t) {
        this.aldstat_showtime = Date.now(), this.aldstat_showoption = void 0 !== t ? t : {};
        var a = "";
        try {
            a = wx.getStorageSync("app_session_key_create_show_upload");
        } catch (t) {
            a = "";
        }
        a && 0 < a && "number" == typeof a && (this.aldstat_access_token = "" + Date.now() + Math.floor(1e7 * Math.random())), 
        w(this, "app", "show"), void 0 !== t && (void 0 !== t.shareTicket ? f(this, t.shareTicket, "click") : void 0 !== t.query && void 0 !== t.query.ald_share_src && f(this, "0", "click"));
    }, y = function(t, a) {
        var s = this;
        s.aldstat_is_first_open && (s.aldstat_is_first_open = !1), s.aldstat_duration = Date.now() - s.aldstat_showtime, 
        w(s, "app", "hide");
    };
    function S(t) {
        if ("string" != typeof t) return !1;
        var a = t.replace(/\s+/g, "_");
        return !/[~`!@/#+=\$%\^()&\*]+/g.test(a);
    }
    var m = function(t, a) {
        var s = getApp();
        b(s, this, "hide");
    }, x = function(t, a) {
        var s = getApp();
        b(s, this, "unload");
    }, k = function(t, a) {
        var s = "";
        try {
            s = wx.getStorageSync("aldstat_src");
        } catch (t) {
            s = "";
        }
        var e = getApp();
        if (wx.showShareMenu, s && (e.aldstat_src = s), !function(t) {
            for (var a in t) return !1;
            return !0;
        }(t)) {
            if (void 0 !== t.aldsrc) if (s) e.aldstat_qr = t.aldsrc; else {
                try {
                    wx.setStorageSync("aldstat_src", t.aldsrc);
                } catch (t) {}
                e.aldstat_src = t.aldsrc, e.aldstat_qr = t.aldsrc;
            }
            void 0 !== t.ald_share_src && (e.ald_share_src = t.ald_share_src), this.aldstat_page_args = JSON.stringify(t);
        }
        b(e, this, "load");
    }, b = function(t, a, s) {
        var e = "";
        try {
            e = wx.getStorageSync("page_" + s + "_upload");
        } catch (t) {
            e = "";
        }
        if ((e || "show" === s) && !(e < 1 && "number" == typeof e)) {
            a.aldstat_start_time = Date.now(), a.aldstat_error_count = 0, t.aldstat_page_count ? t.aldstat_page_count++ : t.aldstat_page_count = 1, 
            t.aldstat_first_page || (t.aldstat_first_page = a.__route__, a.aldstat_is_first_page = !0), 
            t.aldstat_last_page = a.__route__;
            var n = {
                uu: d(t),
                at: t.aldstat_access_token,
                wsr: t.aldstat_showoption,
                ak: u.app_key,
                ev: "page",
                st: a.aldstat_start_time,
                dr: Date.now() - a.aldstat_start_time,
                pp: a.__route__,
                life: s,
                sc: a.page_share_count,
                ec: a.aldstat_error_count,
                nt: t.aldstat_network_type,
                pm: t.aldstat_phone_model,
                pr: t.aldstat_pixel_ratio,
                ww: t.aldstat_window_width,
                wh: t.aldstat_window_height,
                lang: t.aldstat_language,
                wv: t.aldstat_wechat_version,
                lat: t.aldstat_lat,
                lng: t.aldstat_lng,
                spd: t.aldstat_speed,
                v: r,
                wsdk: t.aldstat_vsdk_version,
                sv: t.aldstat_sv,
                wvv: t.aldstat_wvv
            };
            a.aldstat_is_first_page && (n.ifp = "true"), t.aldstat_page_last_page && (n.lp = t.aldstat_page_last_page), 
            t.aldstat_location_name && (n.ln = t.aldstat_location_name), a.aldstat_page_args && (n.ag = a.aldstat_page_args), 
            t.aldstat_src && (n.sr = t.aldstat_src), t.aldstat_qr && (n.qr = t.aldstat_qr), 
            t.ald_share_src && (n.usr = t.ald_share_src), t.aldstat_page_last_page = a.__route__, 
            h(n, "GET", "d.html");
        }
    }, q = function(t, a) {
        var s = getApp();
        b(s, this, "show");
    }, D = function(t, a) {
        var s = getApp();
        g(s, "event", "ald_pulldownrefresh", 1);
    }, T = function(t, a) {
        var s = getApp();
        g(s, "event", "ald_reachbottom", 1);
    }, A = function(t, a) {
        var s = getApp();
        if (void 0 !== t && void 0 !== t[1]) {
            var e = "";
            try {
                e = wx.getStorageSync("aldstat_uuid");
            } catch (t) {
                e = "uuid-getstoragesync";
            }
            var n = "";
            try {
                n = wx.getStorageSync(e);
            } catch (t) {
                n = "p_share_count_getst";
            }
            var o = "";
            if ("undefined" !== s.ald_share_src && s.ald_share_src) {
                for (var r = (o = s.ald_share_src).split(","), _ = !0, i = 0, l = r.length; i < l; i++) {
                    if (r[i].replace('"', "") == e) {
                        _ = !1;
                        break;
                    }
                }
                3 <= r.length && (_ && r.shift(), o = r.toString()), "" !== o && _ && (o = o + "," + e);
            } else try {
                o = wx.getStorageSync("aldstat_uuid");
            } catch (t) {
                o = "ald_share_src_getst";
            }
            if (t[1].path && "undefined" !== t[1].path || (u.defaultPath ? t[1].path = u.defaultPath : t[1].path = this.__route__), 
            -1 != t[1].path.indexOf("?") ? t[1].path += "&ald_share_src=" + o : t[1].path += "?ald_share_src=" + o, 
            g(s, "event", "ald_share_chain", {
                path: s.aldstat_last_page,
                chain: o
            }), "" === n || void 0 === n) {
                try {
                    wx.setStorageSync(e, 1);
                } catch (t) {}
                n = 1, s.page_share_count = n;
            } else {
                n = parseInt(wx.getStorageSync(e)) + 1, s.page_share_count = n;
                try {
                    wx.setStorageSync(e, n);
                } catch (t) {}
            }
            p(function(t) {
                var a = "";
                try {
                    a = wx.getStorageSync("aldstat_uuid");
                } catch (t) {
                    a = "uuid-getstoragesync";
                }
                t.userInfo.uu = a, h(t.userInfo, "GET", "u.html");
            });
            t[1];
            void 0 === t[1].success && (t[1].success = function(t) {}), void 0 === t[1].fail && (t[1].fail = function(t) {});
            var d = t[1].fail, c = t[1].success;
            return t[1].success = function(t) {
                new Array();
                if ("object" === _typeof(t.shareTickets)) for (var a = 0; a < t.shareTickets.length; a++) f(s, t.shareTickets[a], "user");
                g(s, "event", "ald_share_status", JSON.stringify(t)), c(t);
            }, t[1].fail = function(t) {
                g(s, "event", "ald_share_status", "fail"), d(t);
            }, t[1];
        }
    }, M = App;
    App = function(t) {
        a(t, "onLaunch", e), a(t, "onUnlaunch", s), a(t, "onShow", v), a(t, "onHide", y), 
        a(t, "onError", n), M(t);
    };
    var I = Page;
    Page = function(t) {
        a(t, "onLoad", k), a(t, "onUnload", x), a(t, "onShow", q), a(t, "onHide", m), a(t, "onReachBottom", T), 
        a(t, "onPullDownRefresh", D), void 0 !== t.onShareAppMessage && function(t, s, e) {
            if (t[s]) {
                var n = t[s];
                t[s] = function(t) {
                    var a = n.call(this, t);
                    return e.call(this, [ t, a ], s), a;
                };
            } else t[s] = function(t) {
                e.call(this, t, s);
            };
        }(t, "onShareAppMessage", A), I(t);
    };
}();