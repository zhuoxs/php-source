Object.defineProperty(exports, "__esModule", {
    value: !0
});

var _createClass = function() {
    function r(e, n) {
        for (var t = 0; t < n.length; t++) {
            var r = n[t];
            r.enumerable = r.enumerable || !1, r.configurable = !0, "value" in r && (r.writable = !0), 
            Object.defineProperty(e, r.key, r);
        }
    }
    return function(e, n, t) {
        return n && r(e.prototype, n), t && r(e, t), e;
    };
}();

function _classCallCheck(e, n) {
    if (!(e instanceof n)) throw new TypeError("Cannot call a class as a function");
}

var StringHelper = function() {
    function e() {
        _classCallCheck(this, e);
    }
    return _createClass(e, null, [ {
        key: "isNumber",
        value: function(e) {
            return /^\d+(\.\d+)?$/.test(e);
        }
    }, {
        key: "getLength",
        value: function(e) {
            return e.toString().length;
        }
    }, {
        key: "camelCase2Dash",
        value: function(e) {
            return e.replace(/([a-zA-Z])(?=[A-Z])/g, "$1-").toLowerCase();
        }
    }, {
        key: "dash2CamelCase",
        value: function(e) {
            return e.replace(/\-([a-z])/gi, function(e, n) {
                return n.toUpperCase();
            });
        }
    } ]), e;
}();

exports.default = StringHelper;