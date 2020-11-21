var _typeof2 = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function(e) {
    return typeof e;
} : function(e) {
    return e && "function" == typeof Symbol && e.constructor === Symbol && e !== Symbol.prototype ? "symbol" : typeof e;
};

Object.defineProperty(exports, "__esModule", {
    value: !0
}), exports.default = void 0;

var _createClass = function() {
    function n(e, t) {
        for (var r = 0; r < t.length; r++) {
            var n = t[r];
            n.enumerable = n.enumerable || !1, n.configurable = !0, "value" in n && (n.writable = !0), 
            Object.defineProperty(e, n.key, n);
        }
    }
    return function(e, t, r) {
        return t && n(e.prototype, t), r && n(e, r), e;
    };
}(), _typeof = "function" == typeof Symbol && "symbol" === _typeof2(Symbol.iterator) ? function(e) {
    return void 0 === e ? "undefined" : _typeof2(e);
} : function(e) {
    return e && "function" == typeof Symbol && e.constructor === Symbol && e !== Symbol.prototype ? "symbol" : void 0 === e ? "undefined" : _typeof2(e);
}, _StringHelper = require("./StringHelper.js"), _StringHelper2 = _interopRequireDefault(_StringHelper), _index = require("./lodash.merge/index.js"), _index2 = _interopRequireDefault(_index), _index3 = require("./lodash.trim/index.js"), _index4 = _interopRequireDefault(_index3);

function _interopRequireDefault(e) {
    return e && e.__esModule ? e : {
        default: e
    };
}

function _toConsumableArray(e) {
    if (Array.isArray(e)) {
        for (var t = 0, r = Array(e.length); t < e.length; t++) r[t] = e[t];
        return r;
    }
    return Array.from(e);
}

function _classCallCheck(e, t) {
    if (!(e instanceof t)) throw new TypeError("Cannot call a class as a function");
}

var SizeAttrs = [ "height", "width", "paddingTop", "paddingRight", "paddingBottom", "paddingLeft", "marginTop", "marginRight", "marginBottom", "marginLeft", "top", "right", "bottom", "left", "lineHeight", "fontSize" ], DashedSizeAttrs = SizeAttrs.map(function(e) {
    return _StringHelper2.default.camelCase2Dash(e);
});

function getUnitizedValue(e) {
    return /^\d+(\.\d+)?$/.test(e) ? e + "px" : e;
}

function getObjectStyle(e) {
    if ("object" === (void 0 === e ? "undefined" : _typeof(e))) return e;
    var t = e.split(";"), i = {};
    return t.forEach(function(e) {
        var t = e.split(":");
        if (2 === t.length) {
            var r = (0, _index4.default)(t[0]), n = (0, _index4.default)(t[1]);
            r && n && (i[r] = n);
        }
    }), i;
}

var StyleHelper = function() {
    function n() {
        _classCallCheck(this, n);
    }
    return _createClass(n, null, [ {
        key: "getPlainStyle",
        value: function(t) {
            if (!t) return "";
            var r = "", e = void 0 === t ? "undefined" : _typeof(t);
            if ("string" === e) r = t; else if ("object" === e) {
                var n = "";
                Object.keys(t).forEach(function(e) {
                    n = _StringHelper2.default.camelCase2Dash(e), t[e] && (-1 < DashedSizeAttrs.indexOf(n) || -1 < SizeAttrs.indexOf(e) ? r += n + ": " + getUnitizedValue(t[e]) + ";" : r += n + ": " + t[e] + ";");
                });
            }
            return r;
        }
    }, {
        key: "getMergedPlainStyles",
        value: function(e) {
            var t = e.map(function(e) {
                return getObjectStyle(e);
            }), r = _index2.default.apply(void 0, [ {} ].concat(_toConsumableArray(t)));
            return n.getPlainStyle(r);
        }
    } ]), n;
}();

exports.default = StyleHelper;