var _extends = Object.assign || function(t) {
    for (var e = 1; e < arguments.length; e++) {
        var a = arguments[e];
        for (var o in a) Object.prototype.hasOwnProperty.call(a, o) && (t[o] = a[o]);
    }
    return t;
};

function _defineProperty(t, e, a) {
    return e in t ? Object.defineProperty(t, e, {
        value: a,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : t[e] = a, t;
}

var TOAST_CONFIG_KEY = "zanui.__zanToastPageConfig", timeoutData = {
    timeoutId: 0,
    toastCtx: null
}, globalToastUserConfig = {};

function getPageCtx(t) {
    var e = t;
    if (!e) {
        var a = getCurrentPages();
        e = a[a.length - 1];
    }
    return e;
}

function getPageToastConfig(t) {
    return (t.data.zanui || {}).__zanToastPageConfig || {};
}

function Toast(t, e) {
    var a = t || {};
    "string" == typeof t && (a = {
        message: t
    });
    var o = getPageCtx(e), n = getPageToastConfig(o), i = _extends({}, globalToastUserConfig, n, a), r = o.selectComponent(i.selector);
    if (r) {
        timeoutData.timeoutId && Toast.clear(), r.show(_extends({}, i, {
            show: !0
        }));
        var s = setTimeout(function() {
            r.clear();
        }, i.timeout || 3e3);
        timeoutData = {
            timeoutId: s,
            toastCtx: r
        };
    } else console.error("无法找到对应的toast组件，请于页面中注册并在 wxml 中声明 toast 自定义组件");
}

Toast.setDefaultOptions = function() {
    var t = 0 < arguments.length && void 0 !== arguments[0] ? arguments[0] : {}, e = 1 < arguments.length && void 0 !== arguments[1] ? arguments[1] : "page", a = {
        selector: t.selector || "",
        type: t.type || "",
        icon: t.icon || "",
        image: t.image || "",
        timeout: t.timeout || 3e3
    };
    if ("global" === e) globalToastUserConfig = _extends({}, a); else if ("page" === e) {
        getPageCtx().setData(_defineProperty({}, "" + TOAST_CONFIG_KEY, a));
    }
}, Toast.resetDefaultOptions = function() {
    "global" === (0 < arguments.length && void 0 !== arguments[0] ? arguments[0] : "page") ? globalToastUserConfig = {} : getPageCtx().setData(_defineProperty({}, "" + TOAST_CONFIG_KEY, {}));
}, Toast.clear = function() {
    clearTimeout(timeoutData.timeoutId);
    try {
        timeoutData.toastCtx && timeoutData.toastCtx.clear();
    } catch (t) {}
    timeoutData = {
        timeoutId: 0,
        toastCtx: null
    };
}, Toast.loading = function() {
    var t = 0 < arguments.length && void 0 !== arguments[0] ? arguments[0] : {};
    Toast(_extends({}, t, {
        type: "loading"
    }));
}, module.exports = Toast;