Object.defineProperty(exports, "__esModule", {
    value: !0
});

var _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function(o) {
    return typeof o;
} : function(o) {
    return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o;
};

function isDef(o) {
    return null != o;
}

function isObj(o) {
    var t = void 0 === o ? "undefined" : _typeof(o);
    return null !== o && ("object" === t || "function" === t);
}

exports.isObj = isObj, exports.isDef = isDef;