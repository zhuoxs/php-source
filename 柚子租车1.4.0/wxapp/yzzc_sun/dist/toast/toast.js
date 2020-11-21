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
    var o = getPageCtx(e), s = getPageToastConfig(o), i = Object.assign({}, globalToastUserConfig, s, a), n = o.selectComponent(i.selector);
    if (n) {
        timeoutData.timeoutId && Toast.clear(), n.show(Object.assign({}, i, {
            show: !0
        }));
        var g = setTimeout(function() {
            n.clear();
        }, i.timeout || 3e3);
        timeoutData = {
            timeoutId: g,
            toastCtx: n
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
    if ("global" === e) globalToastUserConfig = Object.assign({}, a); else if ("page" === e) {
        var o;
        getPageCtx().setData(((o = {})["" + TOAST_CONFIG_KEY] = a, o));
    }
}, Toast.resetDefaultOptions = function() {
    var t;
    "global" === (0 < arguments.length && void 0 !== arguments[0] ? arguments[0] : "page") ? globalToastUserConfig = {} : getPageCtx().setData(((t = {})["" + TOAST_CONFIG_KEY] = {}, 
    t));
}, Toast.clear = function() {
    clearTimeout(timeoutData.timeoutId);
    try {
        timeoutData.toastCtx && timeoutData.toastCtx.clear();
    } catch (t) {
        console.log(t);
    }
    timeoutData = {
        timeoutId: 0,
        toastCtx: null
    };
}, Toast.loading = function() {
    var t = 0 < arguments.length && void 0 !== arguments[0] ? arguments[0] : {};
    Toast(Object.assign({}, t, {
        type: "loading"
    }));
}, module.exports = Toast;