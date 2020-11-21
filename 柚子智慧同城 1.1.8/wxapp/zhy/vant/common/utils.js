Object.defineProperty(exports, "__esModule", {
    value: !0
});

var t = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function(t) {
    return typeof t;
} : function(t) {
    return t && "function" == typeof Symbol && t.constructor === Symbol && t !== Symbol.prototype ? "symbol" : typeof t;
};

exports.isObj = function(o) {
    var e = void 0 === o ? "undefined" : t(o);
    return null !== o && ("object" === e || "function" === e);
}, exports.isDef = function(t) {
    return void 0 !== t && null !== t;
}, exports.isNumber = function(t) {
    return /^\d+$/.test(t);
}, exports.range = function(t, o, e) {
    return Math.min(Math.max(t, o), e);
};