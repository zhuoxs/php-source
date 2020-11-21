function t() {
    return (t = Object.assign || function(t) {
        for (var n = 1; n < arguments.length; n++) {
            var e = arguments[n];
            for (var o in e) Object.prototype.hasOwnProperty.call(e, o) && (t[o] = e[o]);
        }
        return t;
    }).apply(this, arguments);
}

function n() {
    var t = getCurrentPages();
    return t[t.length - 1];
}

Object.defineProperty(exports, "__esModule", {
    value: !0
});

var e = [], o = function o(r) {
    return r = t({}, o.currentOptions, r), new Promise(function(o, s) {
        var c = (r.context || n()).selectComponent(r.selector);
        delete r.selector, c ? (c.set(t({
            onCancel: s,
            onConfirm: o
        }, r)), e.push(c)) : console.warn("未找到 van-dialog 节点，请确认 selector 及 context 是否正确");
    });
};

o.defaultOptions = {
    show: !0,
    title: "",
    message: "",
    zIndex: 100,
    overlay: !0,
    asyncClose: !1,
    messageAlign: "",
    transition: "scale",
    selector: "#van-dialog",
    confirmButtonText: "确认",
    cancelButtonText: "取消",
    showConfirmButton: !0,
    showCancelButton: !1,
    closeOnClickOverlay: !1,
    confirmButtonOpenType: ""
}, o.alert = o, o.confirm = function(n) {
    return o(t({
        showCancelButton: !0
    }, n));
}, o.close = function() {
    e.forEach(function(t) {
        t.close();
    }), e = [];
}, o.stopLoading = function() {
    e.forEach(function(t) {
        t.stopLoading();
    });
}, o.setDefaultOptions = function(t) {
    Object.assign(o.currentOptions, t);
}, o.resetDefaultOptions = function() {
    o.currentOptions = t({}, o.defaultOptions);
}, o.resetDefaultOptions(), exports.default = o;