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

var _default = function() {
    function e() {
        _classCallCheck(this, e);
    }
    return _createClass(e, null, [ {
        key: "getComponentRect",
        value: function(e, n) {
            var r = wx.createSelectorQuery().in(e);
            return new Promise(function(t, e) {
                r.select(n).boundingClientRect(function(e) {
                    t(e);
                }).exec();
            });
        }
    }, {
        key: "getScrollViewRect",
        value: function(e, n) {
            var r = wx.createSelectorQuery().in(e);
            return new Promise(function(t, e) {
                r.select(n).scrollOffset(function(e) {
                    t(e);
                }).exec();
            });
        }
    }, {
        key: "getParentRelation",
        value: function(e) {
            var t = {};
            return t[e] = {
                type: "parent"
            }, t;
        }
    }, {
        key: "getChildRelation",
        value: function(e) {
            var t = {};
            return t[e] = {
                type: "child"
            }, t;
        }
    } ]), e;
}();

exports.default = _default;