var _createClass = function() {
    function a(e, t) {
        for (var n = 0; n < t.length; n++) {
            var a = t[n];
            a.enumerable = a.enumerable || !1, a.configurable = !0, "value" in a && (a.writable = !0), 
            Object.defineProperty(e, a.key, a);
        }
    }
    return function(e, t, n) {
        return t && a(e.prototype, t), n && a(e, n), e;
    };
}(), _Config = require("Config"), _Config2 = _interopRequireDefault(_Config), _util = require("../utils/util");

function _interopRequireDefault(e) {
    return e && e.__esModule ? e : {
        default: e
    };
}

function _classCallCheck(e, t) {
    if (!(e instanceof t)) throw new TypeError("Cannot call a class as a function");
}

var DataRepository = function() {
    function e() {
        _classCallCheck(this, e);
    }
    return _createClass(e, null, [ {
        key: "addData",
        value: function(t) {
            return !!t && (t._id = (0, _util.guid)(), e.findAllData().then(function(e) {
                (e = e || []).unshift(t), wx.setStorage({
                    key: _Config2.default.ITEMS_SAVE_KEY,
                    data: e
                });
            }));
        }
    }, {
        key: "removeData",
        value: function(a) {
            return e.findAllData().then(function(e) {
                if (e) {
                    for (var t = 0, n = e.length; t < n; t++) if (e[t] && e[t]._id == a) {
                        e.splice(t, 1);
                        break;
                    }
                    wx.setStorage({
                        key: _Config2.default.ITEMS_SAVE_KEY,
                        data: e
                    });
                }
            });
        }
    }, {
        key: "removeRange",
        value: function(f) {
            if (f) return e.findAllData().then(function(t) {
                if (t) {
                    for (var e = [], n = 0, a = f.length; n < a; n++) for (var i = 0, r = t.length; i < r; i++) if (t[i] && t[i]._id == f[n]) {
                        e.push(i);
                        break;
                    }
                    var u = 0;
                    e.forEach(function(e) {
                        t.splice(e - u, 1), u++;
                    }), wx.setStorage({
                        key: _Config2.default.ITEMS_SAVE_KEY,
                        data: t
                    });
                }
            });
        }
    }, {
        key: "saveData",
        value: function(a) {
            return !(!a || !a._id) && e.findAllData().then(function(e) {
                if (!e) return !1;
                for (var t = 0, n = e.length; i < n; t++) if (e[t] && e[t]._id == a._id) {
                    e[t] = a;
                    break;
                }
                wx.setStorage({
                    key: _Config2.default.ITEMS_SAVE_KEY,
                    data: a
                });
            });
        }
    }, {
        key: "findAllData",
        value: function() {
            return (0, _util.promiseHandle)(wx.getStorage, {
                key: _Config2.default.ITEMS_SAVE_KEY
            }).then(function(e) {
                return e.data ? e.data : [];
            }).catch(function(e) {
                (0, _util.log)(e);
            });
        }
    }, {
        key: "findBy",
        value: function(t) {
            return e.findAllData().then(function(e) {
                return e && (e = e.filter(function(e) {
                    return t(e);
                })), e;
            });
        }
    } ]), e;
}();

module.exports = DataRepository;