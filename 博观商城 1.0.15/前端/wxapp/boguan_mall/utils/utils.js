function e(e, t) {
    if (!(e instanceof t)) throw new TypeError("Cannot call a class as a function");
}

Object.defineProperty(exports, "__esModule", {
    value: !0
}), exports.Utils = void 0;

var t = function() {
    function e(e, t) {
        for (var n = 0; n < t.length; n++) {
            var r = t[n];
            r.enumerable = r.enumerable || !1, r.configurable = !0, "value" in r && (r.writable = !0), 
            Object.defineProperty(e, r.key, r);
        }
    }
    return function(t, n, r) {
        return n && e(t.prototype, n), r && e(t, r), t;
    };
}(), n = (require("token.js"), require("base.js")), r = (getApp(), require("../../siteinfo.js"), 
new n.Base()), i = function() {
    function n() {
        e(this, n);
    }
    return t(n, [ {
        key: "userData",
        value: function(e, t) {
            r.getData(e, function(e) {
                t && t(e);
            });
        }
    } ]), n;
}();

exports.Utils = i;