var qitui = wx.getStorageSync("qitui");

if (qitui) var config = {
    appkey: qitui.qt_appkey,
    is_reportingEvent: !1,
    is_openPlugins: 1 == qitui.qt_isopen
}; else config = {
    appkey: "",
    is_reportingEvent: !1,
    is_openPlugins: !1
};

var Version = "1.0.0", onlineURL = "https://www.7tui.net", apiURL = "https://www.7tui.net/api", Gdata = {
    v: Version,
    data: "",
    uinfo: "",
    u_code: "",
    lat: "",
    lng: ""
};

function gocheckversion() {
    wx.request({
        url: onlineURL + "/qtapp.json",
        method: "GET",
        success: function(t) {
            200 === t.statusCode && t.data.v != Version && console.warn("奇推sdk已更新,请去官网(https://www.7tui.net/)下载最新版本");
        }
    });
}

function oddPushFormSubmit(t) {
    console.log("奇推22");
    oddpush_data(this, "frompage", "pushfrom", {
        x: t.detail.target.offsetLeft,
        y: t.detail.target.offsetTop,
        fid: t.detail.formId
    });
}

function HookTo(t, e, o) {
    if (t[e]) {
        var n = t[e];
        t[e] = function(t) {
            return o.call(this, t, e), n.call.apply(n, [ this ].concat(Array.prototype.slice.call(arguments)));
        };
    } else t[e] = function(t) {
        o.call(this, t, e);
    };
}

var goto_login = function(t, e) {
    wx.login({
        success: function(t) {
            t.code ? (Gdata.u_code = t.code, wx.getUserInfo({
                success: function(t) {
                    e(t);
                }
            })) : Gdata.u_code = 0;
        }
    });
}, goto_openid = function(t, e) {
    var o = wx.getStorageSync("u_openid"), n = wx.getStorageSync("u_openid_start_time");
    if (n && o) {
        var i = new Date().getTime();
        if (n && o && n + 439200 < i) return !1;
    }
    wx.login({
        success: function(t) {
            t.code ? (Gdata.u_code = t.code, oddpush_data(Gdata, "getopenid", "getopenid")) : Gdata.u_code = 0;
        }
    });
};

function getauthSetting(e) {
    if (null == e) return !1;
    wx.getSetting({
        success: function(t) {
            t.authSetting["scope.userInfo"] && "userInfo" == e.u && goto_login(Gdata, function(t) {
                Gdata.oddpush_user_data = t.rawData, oddpush_data(Gdata, "userinfo", "userinfo");
            }), t.authSetting["scope.userLocation"] && "location" == e.l && wx.getLocation({
                type: "wgs84",
                success: function(t) {
                    Gdata.lat = t.latitude, Gdata.lng = t.longitude;
                }
            });
        }
    });
}

function oddpush_data(t, e, o, n) {
    if (!config.appkey) {
        var i = wx.getStorageSync("qitui");
        if (!i) return !1;
        config.appkey = i.qt_appkey, config.is_openPlugins = 1 == i.qt_isopen;
    }
    if (!config.is_openPlugins) return !1;
    null == n && (n = {});
    var a = wx.getStorageSync("u_openid");
    console.log(a);
    var u = {
        d: n,
        u_code: Gdata.u_code,
        akey: config.appkey.replace(/(^\s*)|(\s*$)/g, ""),
        u_openid: a
    };
    if ("userinfo" == e) {
        u.ud = Gdata.oddpush_user_data;
        var s = new Date().getTime(), d = wx.getStorageSync("u_openid_time");
        if (console.log(d), d && a && d + 600 < s) return !1;
    }
    wx.request({
        url: apiURL + "/" + o,
        method: "POST",
        header: {
            "content-type": "application/json"
        },
        data: u,
        success: function(t) {
            if (console.log(t), "userinfo" == o && null != t.data.openid) {
                wx.setStorageSync("u_openid", t.data.openid);
                var e = new Date().getTime();
                wx.setStorageSync("u_openid_time", e);
            }
            if ("getopenid" == o && null != t.data.openid) {
                wx.setStorageSync("u_openid", t.data.openid);
                e = new Date().getTime();
                wx.setStorageSync("u_openid_start_time", e);
            }
        }
    });
}

var oddpush = function(t, e) {
    try {
        var o, n;
        "App" === e ? o = t : n = t;
    } catch (t) {}
    var i = function(t) {
        goto_openid();
    };
    function a(t) {
        getauthSetting({
            u: "userInfo"
        });
    }
    return {
        App: function(t) {
            HookTo(t, "onShow", i), o ? o(t) : App(t);
        },
        Page: function(t) {
            HookTo(t, "onShow", a), HookTo(t, "oddPushFormSubmit", oddPushFormSubmit), n ? n(t) : Page(t);
        }
    };
};

gocheckversion(), exports.oddPush = oddpush;