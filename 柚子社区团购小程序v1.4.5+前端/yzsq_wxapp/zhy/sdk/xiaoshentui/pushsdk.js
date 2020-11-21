var _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function(t) {
    return typeof t;
} : function(t) {
    return t && "function" == typeof Symbol && t.constructor === Symbol && t !== Symbol.prototype ? "symbol" : typeof t;
}, Version = "3.0.0", url = "plog", path = "default", conf = require("./push-stat-conf.js"), aldpush_event_data = {}, aldpush_event_type = "", is_yyy = !1, num = 0, onlineTier = !1, onlineData = {}, weaOnlineThis = null, onlineURL = "https://openapi.xiaoshentui.com", filterEventList = [], filteEtypeList = [ "developer_function" ], eventData = {
    num: 0,
    max: 10,
    name: null
}, InitData = {
    uu: "",
    ak: "",
    pm: "",
    wvv: "",
    wsdk: "",
    sv: "",
    wv: "",
    nt: "",
    ww: "",
    wh: "",
    pr: "",
    pp: "",
    lat: "",
    lng: "",
    ev: "",
    st: "",
    et: "",
    ppx: "",
    ppy: "",
    v: "",
    data: "",
    fid: "",
    lang: "",
    wsr: "",
    ifo: "",
    jscode: "",
    etype: ""
};

function inspectversion() {
    wx.request({
        url: "https://" + url + ".xiaoshentui.com/config/app.json",
        header: {
            AldStat: "MiniApp-Stat"
        },
        method: "GET",
        success: function(t) {
            200 === t.statusCode && (t.data.push_v != Version && console.warn("小神推sdk已更新,为不影响正常使用,请去官网(http://www.xiaoshentui.com/)下载最新版本"), 
            t.data.filter_event && (filterEventList = t.data.filter_event), t.data.filter_etype && (filteEtypeList = t.data.filter_etype));
        }
    });
}

function HookIt1(t, n, e) {
    if (t[n]) {
        var a = t[n];
        t[n] = function(t) {
            return e.call(this, t, n), a.call.apply(a, [ this ].concat(Array.prototype.slice.call(arguments)));
        };
    } else t[n] = function(t) {
        e.call(this, t, n);
    };
}

function get_uuid() {
    var t = wx.getStorageSync("t_uuid");
    return t ? InitData.ifo = !1 : (t = "" + Date.now() + Math.floor(1e7 * Math.random()), 
    wx.setStorageSync("t_uuid", t), wx.setStorageSync("ifo", 1), InitData.ifo = !0), 
    t;
}

var login_func = function(t, n) {
    if (!conf.is_getUserinfo) return !1;
    wx.login({
        success: function(t) {
            t.code ? (InitData.jscode = t.code, wx.getUserInfo({
                success: function(t) {
                    n(t);
                },
                fail: function(t) {}
            })) : InitData.jscode = 0;
        }
    });
}, wx_request = function(n, e, a) {
    if (void 0 === e && (e = "GET"), void 0 === a && (a = "d.html"), !(4e3 <= JSON.stringify(n).length)) {
        var o = 0;
        !function t() {
            wx.request({
                url: "https://" + url + ".xiaoshentui.com/" + a,
                data: n,
                header: {},
                method: e,
                success: function() {},
                fail: function() {
                    o < 2 && (o++, n.retryTimes = o, t());
                }
            });
        }();
    }
};

function push_log(t, n, e) {
    if ("user_info_close" != n) {
        var a = get_uuid(), o = 0;
        if ("app" == n && "hide" == e) {
            var i = Date.now();
            o = wx.getStorageSync("ifo"), wx.setStorageSync("ifo", 0);
        }
        var s = "";
        "user_info" == n ? s = t.aldpush_login_data : "user_info_close" == n || (s = "event" == n ? aldpush_event_data : "yyy" == n ? aldpush_event_data : 0);
        var p = "fpage" == n || "fhpage" == n ? InitData.fid : 0, u = "user_info" !== n ? 0 : InitData.jscode, r = {
            v: Version,
            uu: a,
            ev: n,
            life: e,
            ak: conf.app_key.replace(/(^\s*)|(\s*$)/g, ""),
            pm: InitData.pm ? InitData.pm : 0,
            wvv: InitData.wvv ? InitData.wvv : 0,
            wsdk: InitData.wsdk ? InitData.wsdk : 0,
            sv: InitData.sv ? InitData.sv : 0,
            wv: InitData.wv ? InitData.wv : 0,
            nt: InitData.nt ? InitData.nt : 0,
            ww: InitData.ww ? InitData.ww : 0,
            wh: InitData.wh ? InitData.wh : 0,
            pr: InitData.pr ? InitData.pr : 0,
            pp: InitData.pp ? InitData.pp : 0,
            lat: InitData.lat ? InitData.lat : 0,
            lng: InitData.lng ? InitData.lng : 0,
            st: InitData.st || 0,
            et: i || 0,
            ppx: InitData.ppx ? InitData.ppx : 0,
            ppy: InitData.ppy ? InitData.ppy : 0,
            data: s || 0,
            fid: p,
            lang: InitData.lang ? InitData.lang : 0,
            wsr: "app" == n ? t.aldpush_showOptions : {},
            ifo: o,
            jscode: u || 0,
            ust: Date.now()
        };
        "setopenid" === n && t.aldpush_openid && (r.openid = t.aldpush_openid, r.user_info = t.aldpush_login_data), 
        "" === aldpush_event_type || "event" !== n && "yyy" !== n || (r.etype = aldpush_event_type), 
        "yyy" === n && "postevent" === e ? wx.request({
            url: "https://openapi.xiaoshentui.com/Main/action/Event/Event_upload/mobile_info",
            method: "POST",
            header: {
                "content-type": "application/json"
            },
            data: r,
            success: function(t) {}
        }) : "yyy" === n && is_yyy ? wx.request({
            url: "https://openapi.xiaoshentui.com/Main/action/Event/Event_upload/event_report",
            method: "POST",
            header: {
                "content-type": "application/json"
            },
            data: r,
            success: function(t) {}
        }) : wx_request(r, "GET", "d.html");
    }
}

function pushFormSubmit(t) {
    var n = this;
    InitData.ppx = t.detail.target.offsetLeft, InitData.ppy = t.detail.target.offsetTop, 
    InitData.fid = t.detail.formId, push_log(n, "fpage", "clickform");
}

function hidepushFormSubmit(t) {
    InitData.ppx = t.detail.target.offsetLeft, InitData.ppy = t.detail.target.offsetTop, 
    InitData.fid = t.detail.formId, this.setData({
        is_showHideBtn: !0
    }), push_log(this, "fhpage", "hideclickform");
}

function handlerInterceptor(t) {
    return !(0 <= filterEventList.indexOf(t)) && (eventData.name == t ? (eventData.num++, 
    !(eventData.num >= eventData.max)) : (0 != eventData.num && (eventData.num = 0, 
    eventData.name = null), !0));
}

function otherPageFunction(t, n) {
    if (conf.is_sendEventFunc) {
        var e = handlerInterceptor(n);
        eventData.name = n;
        var a = "", o = arguments;
        if (t || (t = o), t) {
            if (aldpush_event_type = void 0 === t.type ? void 0 === t.from ? 0 <= [ "onLoad", "onReady", "onShow", "onHide", "onUnload", "onPullDownRefresh", "onReachBottom", "onShareAppMessage", "onPageScroll" ].indexOf(n) ? "wechat_function" : "developer_function" : t.from : t.type, 
            a = void 0 !== o[0] ? o[0] : {}, aldpush_event_data = a, !(0 <= filteEtypeList.indexOf(aldpush_event_type))) return;
            0 <= conf.filterFunc.indexOf(n) || e && push_log(this, "event", n), is_yyy && push_log(this, "yyy", n);
        }
    }
}

function startEventFunc(n) {
    wx.onAccelerometerChange(function(t) {
        n.isShow && 1 < t.x && 1 < t.y && 3 <= (num += 1) && (is_yyy = !0, push_log(n, "yyy", "postevent"));
    });
}

function pushGetApp(t) {
    this.app = t;
}

function weaOnlinePushLayer() {
    var t = wx.getSystemInfoSync(), n = {
        app_key: conf.app_key,
        uuid: wx.getStorageSync("t_uuid"),
        os: t.platform,
        device: t.model
    };
    wx.request({
        url: onlineURL + "/inapp_push",
        method: "GET",
        header: {
            "content-type": "application/json"
        },
        data: n,
        success: function(t) {
            200 == t.data.code && (onlineTier = !0, (onlineData = t.data.data).isShow = !0);
        }
    });
}

function atDetails(t) {
    var n = this, e = t.currentTarget.dataset, a = onlineData, o = wx.getSystemInfoSync(), i = {
        app_key: conf.app_key,
        uuid: wx.getStorageSync("t_uuid"),
        os: o.platform,
        device: o.model,
        msg_key: e.msgkey ? e.msgkey : ""
    };
    e.msgkey && wx.request({
        url: onlineURL + "/inapp_click_count",
        method: "GET",
        header: {
            "content-type": "application/json"
        },
        data: i,
        success: function(t) {}
    }), 1 == e.type ? wx.navigateTo({
        url: "/" + e.acdetail,
        success: function() {
            a.isShow = !1, n.setData({
                onlineData: a
            });
        },
        fail: function(t) {
            wx.switchTab({
                url: "/" + e.acdetail,
                success: function() {
                    a.isShow = !1, n.setData({
                        onlineData: a
                    });
                }
            });
        }
    }) : 3 == e.type ? wx.navigateToMiniProgram({
        appId: e.apd,
        path: "/" + e.acdetail,
        success: function(t) {
            a.isShow = !1, n.setData({
                onlineData: a
            });
        }
    }) : 4 == e.type && (a.isShow = !1, n.setData({
        onlineData: a
    }));
}

function colseOneBox() {
    var t = onlineData;
    t.isShow = !1, this.setData({
        onlineData: t
    });
}

Array.prototype.indexOf || (Array.prototype.indexOf = function(t) {
    if (null == this) throw new TypeError();
    var n = Object(this), e = n.length >>> 0;
    if (0 === e) return -1;
    var a = 0;
    if (1 < arguments.length && ((a = Number(arguments[1])) != a ? a = 0 : 0 != a && a != 1 / 0 && a != -1 / 0 && (a = (0 < a || -1) * Math.floor(Math.abs(a)))), 
    e <= a) return -1;
    for (var o = 0 <= a ? a : Math.max(e - Math.abs(a), 0); o < e; o++) if (o in n && n[o] === t) return o;
    return -1;
}), pushGetApp.prototype.pushuserinfo = function(t, n) {
    if ("object" === (void 0 === t ? "undefined" : _typeof(t))) {
        var e = [ "encryptedData", "errMsg", "iv", "rawData", "signature", "userInfo" ];
        for (var a in t) if (e.indexOf(a) < 0) return;
        this.app.aldpush_login_data = t, "string" == typeof n && (InitData.jscode = n), 
        push_log(this.app, "user_info", "userinfo");
    }
}, pushGetApp.prototype.setopenid = function(t, n) {
    if ("string" == typeof t && (this.app.aldpush_openid = t, "object" === (void 0 === n ? "undefined" : _typeof(n)))) {
        var e = [ "avatarUrl", "country", "city", "gender", "language", "nickName", "province", "unionId" ];
        for (var a in n) if (-1 == e.indexOf(a)) return;
        this.app.aldpush_login_data = n, push_log(this.app, "setopenid", "setopenid");
    }
};

try {
    var res = wx.getSystemInfoSync();
    InitData.pm = res.model, InitData.pr = res.pixelRatio, InitData.ww = res.screenWidth, 
    InitData.wh = res.screenHeight, InitData.lang = res.language, InitData.wv = res.version, 
    InitData.wvv = res.platform, InitData.wsdk = void 0 === res.SDKVersion ? "1.0.0" : res.SDKVersion, 
    InitData.sv = res.system;
} catch (t) {}

wx.getNetworkType({
    success: function(t) {
        InitData.nt = t.networkType;
    }
});

var getsetting = function(n, e) {
    wx.getSetting({
        success: function(t) {
            t.authSetting["scope.userLocation"] && "location" == n && wx.getLocation({
                type: "wgs84",
                success: function(t) {
                    InitData.lat = t.latitude, InitData.lng = t.longitude, push_log(InitData, "location", "location");
                }
            }), t.authSetting["scope.userInfo"] && "userInfo" == e && login_func(InitData, function(t) {
                InitData.aldpush_login_data = t, push_log(InitData, "user_info", "userinfo");
            });
        }
    });
};

inspectversion();

var pushSdk = function(t, n) {
    try {
        var e, a;
        "App" === n ? e = t : a = t;
    } catch (t) {}
    function o(t) {
        get_uuid();
        this.aldpush = new pushGetApp(this), void 0 !== t ? (this.aldpush_showOptions = t, 
        path = t.path, InitData.pp = t.path) : this.aldpush_showOptions = {}, conf.app_key && (wx.getStorageSync("t_appkey") || wx.setStorageSync("t_appkey", conf.app_key));
    }
    function i(t) {
        this.isShow = !0, conf.is_sendEvent && startEventFunc(this), this.aldpush_showOptions = void 0 !== t ? t : {}, 
        conf.is_encePush && weaOnlinePushLayer();
    }
    function s() {
        this.isShow = !1, num = 0, getsetting("location"), push_log(this, "app", "hide");
    }
    function p(t) {
        var n = weaOnlineThis = this;
        InitData.st = Date.now(), InitData.pp = this.__route__, "default" != path && path != n.__route__ && login_func(n, function(t) {
            n.aldpush_login_data = t;
        }), setTimeout(function() {
            conf.is_encePush && onlineData.isShow && onlineTier && (n.setData({
                onlineTier: onlineTier,
                onlineData: onlineData
            }), n.colseOneBox || (HookIt1(n, "atDetails", atDetails), HookIt1(n, "colseOneBox", colseOneBox)));
        }, 2e3);
    }
    function u(t) {
        void 0 !== t && (this.options = t), InitData.pp = path = this.__route__, getsetting("locationfalse", "userInfo"), 
        push_log(getApp(), "page", "hide"), conf.is_encePush && onlineData.isShow && onlineTier && (onlineTier = !1, 
        onlineData = {}, this.setData({
            onlineTier: onlineTier,
            onlineData: onlineData
        }));
    }
    function r(t) {
        for (var n = InitData.ww, e = InitData.wh, a = {
            length: [],
            is_showHideBtn: !1
        }, o = 0; o <= 50; o++) {
            var i = '-webkit-transform: scale(0.5);transform:scale(1);content:"";height:88px;width:88px;border:1px solid transparent;background-color:transparent;position:fixed;z-index: 999;left:' + Math.ceil(Math.random() * n) + "px;top:" + Math.ceil(Math.random() * e) + "px;";
            a.length.push(i);
        }
        var s = wx.getStorageSync("isShowClick");
        this.setData({
            hideBtnData: a,
            isShowClick: Boolean(s)
        });
    }
    var c, l;
    return conf.is_plugins ? {
        App: function(t) {
            HookIt1(t, "onLaunch", o), HookIt1(t, "onShow", i), HookIt1(t, "onHide", s), e ? e(t) : App(t);
        },
        Page: function(t) {
            for (var n in t) if ("function" == typeof t[n]) {
                if ("onLoad" == n) {
                    HookIt1(t, "onLoad", r);
                    continue;
                }
                HookIt1(t, n, otherPageFunction);
            }
            HookIt1(t, "onShow", p), HookIt1(t, "onHide", u), HookIt1(t, "hidepushFormSubmit", hidepushFormSubmit), 
            HookIt1(t, "pushFormSubmit", pushFormSubmit), a ? a(t) : Page(t);
        }
    } : (c = App, l = Page, App = function(t) {
        HookIt1(t, "onLaunch", o), HookIt1(t, "onShow", i), HookIt1(t, "onHide", s), c(t);
    }, void (Page = function(t) {
        for (var n in t) if ("function" == typeof t[n]) {
            if ("onLoad" == n) {
                HookIt1(t, "onLoad", r);
                continue;
            }
            HookIt1(t, n, otherPageFunction);
        }
        HookIt1(t, "onShow", p), HookIt1(t, "onHide", u), HookIt1(t, "hidepushFormSubmit", hidepushFormSubmit), 
        HookIt1(t, "pushFormSubmit", pushFormSubmit), l(t);
    }));
};

exports.pushSdk = pushSdk;