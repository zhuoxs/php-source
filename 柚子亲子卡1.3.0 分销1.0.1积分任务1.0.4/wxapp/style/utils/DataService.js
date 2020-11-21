var _createClass = function() {
    function a(t, e) {
        for (var n = 0; n < e.length; n++) {
            var a = e[n];
            a.enumerable = a.enumerable || !1, a.configurable = !0, "value" in a && (a.writable = !0), 
            Object.defineProperty(t, a.key, a);
        }
    }
    return function(t, e, n) {
        return e && a(t.prototype, e), n && a(t, n), t;
    };
}(), _DataRepository = require("DataRepository"), _DataRepository2 = _interopRequireDefault(_DataRepository), _util = require("../utils/util");

function _interopRequireDefault(t) {
    return t && t.__esModule ? t : {
        default: t
    };
}

function _classCallCheck(t, e) {
    if (!(t instanceof e)) throw new TypeError("Cannot call a class as a function");
}

var DataSerivce = function() {
    function e(t) {
        _classCallCheck(this, e), t = t || {}, this.id = t._id || 0, this.content = t.content || "", 
        this.date = t.date || "", this.month = t.month || "", this.year = t.year || "", 
        this.level = t.level || "", this.title = t.title || "";
    }
    return _createClass(e, [ {
        key: "save",
        value: function() {
            if (this._checkProps()) return _DataRepository2.default.addData({
                title: this.title,
                content: this.content,
                year: this.year,
                month: this.month,
                date: this.date,
                level: this.level,
                addDate: new Date().getTime()
            });
        }
    }, {
        key: "delete",
        value: function() {
            return _DataRepository2.default.removeData(this.id);
        }
    }, {
        key: "_checkProps",
        value: function() {
            return this.title && this.level && this.date && this.year && this.month;
        }
    } ], [ {
        key: "findAll",
        value: function() {
            return _DataRepository2.default.findAllData().then(function(t) {
                return t.data ? t.data : [];
            });
        }
    }, {
        key: "findById",
        value: function(e) {
            return _DataRepository2.default.findBy(function(t) {
                return t._id == e;
            }).then(function(t) {
                return t && 0 < t.length ? t[0] : null;
            });
        }
    }, {
        key: "deleteRange",
        value: function(t) {
            return _DataRepository2.default.removeRange(t);
        }
    }, {
        key: "findByDate",
        value: function(e) {
            return e ? _DataRepository2.default.findBy(function(t) {
                return t && t.date == e.getDate() && t.month == e.getMonth() && t.year == e.getFullYear();
            }).then(function(t) {
                return t;
            }) : [];
        }
    } ]), e;
}();

module.exports = DataSerivce;