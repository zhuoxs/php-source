Object.defineProperty(exports, "__esModule", {
    value: !0
});

var _createClass = function() {
    function r(e, t) {
        for (var n = 0; n < t.length; n++) {
            var r = t[n];
            r.enumerable = r.enumerable || !1, r.configurable = !0, "value" in r && (r.writable = !0), 
            Object.defineProperty(e, r.key, r);
        }
    }
    return function(e, t, n) {
        return t && r(e.prototype, t), n && r(e, n), e;
    };
}();

function _classCallCheck(e, t) {
    if (!(e instanceof t)) throw new TypeError("Cannot call a class as a function");
}

var SystemHelper = function() {
    function e() {
        _classCallCheck(this, e);
    }
    return _createClass(e, null, [ {
        key: "isIos",
        value: function() {
            var e = wx.getSystemInfoSync();
            return /ios/i.test(e.system);
        }
    }, {
        key: "isAndroid",
        value: function() {
            var e = wx.getSystemInfoSync();
            return /android/i.test(e.system);
        }
    } ]), e;
}();

exports.default = SystemHelper;