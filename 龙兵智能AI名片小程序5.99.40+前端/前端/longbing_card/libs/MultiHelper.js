Object.defineProperty(exports, "__esModule", {
    value: !0
});

var _createClass = function() {
    function n(e, a) {
        for (var t = 0; t < a.length; t++) {
            var n = a[t];
            n.enumerable = n.enumerable || !1, n.configurable = !0, "value" in n && (n.writable = !0), 
            Object.defineProperty(e, n.key, n);
        }
    }
    return function(e, a, t) {
        return a && n(e.prototype, a), t && n(e, t), e;
    };
}();

function _classCallCheck(e, a) {
    if (!(e instanceof a)) throw new TypeError("Cannot call a class as a function");
}

var MultiHelper = function() {
    function e() {
        _classCallCheck(this, e);
    }
    return _createClass(e, null, [ {
        key: "getChildIndex",
        value: function(e, a) {
            return e.data.children.indexOf(a);
        }
    }, {
        key: "callParent",
        value: function(e, a) {
            for (var t = arguments.length, n = Array(2 < t ? t - 2 : 0), r = 2; r < t; r++) n[r - 2] = arguments[r];
            e.data.parent[a].apply(e.data.parent, n);
        }
    }, {
        key: "updateChildActive",
        value: function(e, t) {
            e.data.children.forEach(function(e, a) {
                t === a ? e.setData({
                    active: !0
                }) : e.data.active && e.setData({
                    active: !1
                });
            });
        }
    } ]), e;
}();

exports.default = MultiHelper;