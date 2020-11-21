function e() {
    return (e = Object.assign || function(e) {
        for (var t = 1; t < arguments.length; t++) {
            var n = arguments[t];
            for (var r in n) Object.prototype.hasOwnProperty.call(n, r) && (e[r] = n[r]);
        }
        return e;
    }).apply(this, arguments);
}

function t(e) {
    return (0, r.isObj)(e) ? e : {
        message: e
    };
}

function n() {
    var e = getCurrentPages();
    return e[e.length - 1];
}

Object.defineProperty(exports, "__esModule", {
    value: !0
});

var r = require("../common/utils"), o = {
    type: "text",
    mask: !1,
    message: "",
    show: !0,
    zIndex: 1e3,
    duration: 3e3,
    position: "middle",
    forbidClick: !1,
    loadingType: "circular",
    selector: "#van-toast"
}, i = [], c = e({}, o), s = function(r) {
    void 0 === r && (r = {});
    var o = ((r = e({}, c, t(r))).context || n()).selectComponent(r.selector);
    if (o) return delete r.context, delete r.selector, i.push(o), o.set(r), clearTimeout(o.timer), 
    r.duration > 0 && (o.timer = setTimeout(function() {
        o.clear(), i = i.filter(function(e) {
            return e !== o;
        });
    }, r.duration)), o;
    console.warn("未找到 van-toast 节点，请确认 selector 及 context 是否正确");
}, u = function(n) {
    return function(r) {
        return s(e({
            type: n
        }, t(r)));
    };
};

[ "loading", "success", "fail" ].forEach(function(e) {
    s[e] = u(e);
}), s.clear = function() {
    i.forEach(function(e) {
        e.clear();
    }), i = [];
}, s.setDefaultOptions = function(e) {
    Object.assign(c, e);
}, s.resetDefaultOptions = function() {
    c = e({}, o);
}, exports.default = s;