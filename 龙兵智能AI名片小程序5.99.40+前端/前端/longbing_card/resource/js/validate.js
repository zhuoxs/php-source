function _classCallCheck(t, i) {
    if (!(t instanceof i)) throw new TypeError("Cannot call a class as a function");
}

Object.defineProperty(exports, "__esModule", {
    value: !0
});

var strategies = {
    isNoEmpty: function(t, i) {
        if ("" === t || void 0 === t || !1 === t || "[]" === JSON.stringify(t) || "{}" === JSON.stringify(t)) return i;
    },
    minLength: function(t, i, n) {
        if (t.length < i) return n;
    },
    maxLength: function(t, i, n) {
        if (t.length > i) return n;
    },
    isMobile: function(t, i) {
        if (!/^([0-9]{11})$/.test(t)) return i;
    },
    isEmail: function(t, i) {
        if (!/^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/.test(t)) return i;
    },
    isMoney: function(t, i) {
        if (!/^(([1-9][0-9]*)|(([0]\.\d{1,2}|[1-9][0-9]*\.\d{1,2})))$/.test(t) || parseFloat(t) < .01) return i;
    },
    isUrl: function(t, i) {
        if (t.indexOf("http") < 0) return i;
    },
    isNumber: function(t, i) {
        if (!/^[1-9]+[0-9]*]*$/.test(t)) return i;
    }
}, Validate = function t() {
    _classCallCheck(this, t), this.cache = [];
};

Validate.prototype.add = function(e, r, s) {
    this.cache.push(function() {
        var t = void 0, i = void 0;
        if ("string" == typeof r) {
            var n = (i = r.split(":")).shift();
            t = strategies[n];
        } else i = [], t = r;
        return i.unshift(e), i.push(s), t.apply(null, i);
    });
}, Validate.prototype.start = function() {
    for (var t, i = 0; t = this.cache[i++]; ) {
        var n = t();
        if (n) return n;
    }
}, exports.default = Validate;