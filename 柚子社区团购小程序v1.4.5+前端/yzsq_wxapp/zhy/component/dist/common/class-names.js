Object.defineProperty(exports, "__esModule", {
    value: !0
});

var _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function(e) {
    return typeof e;
} : function(e) {
    return e && "function" == typeof Symbol && e.constructor === Symbol && e !== Symbol.prototype ? "symbol" : typeof e;
};

exports.classNames = classNames;

var hasOwn = {}.hasOwnProperty;

function classNames() {
    for (var e = [], o = 0; o < arguments.length; o++) {
        var r = arguments[o];
        if (r) {
            var t = void 0 === r ? "undefined" : _typeof(r);
            if ("string" === t || "number" === t) e.push(r); else if (Array.isArray(r) && r.length) {
                var s = classNames.apply(null, r);
                s && e.push(s);
            } else if ("object" === t) for (var n in r) hasOwn.call(r, n) && r[n] && e.push(n);
        }
    }
    return e.join(" ");
}