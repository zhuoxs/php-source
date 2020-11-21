var n = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function(n) {
    return typeof n;
} : function(n) {
    return n && "function" == typeof Symbol && n.constructor === Symbol && n !== Symbol.prototype ? "symbol" : typeof n;
};

(function() {
    function t(n) {
        function t(t, r, e, u, i, o) {
            for (;i >= 0 && i < o; i += n) {
                var a = u ? u[i] : i;
                e = r(e, t[a], a, t);
            }
            return e;
        }
        return function(r, e, u, i) {
            e = g(e, i, 4);
            var o = !_(r) && d.keys(r), a = (o || r).length, c = n > 0 ? 0 : a - 1;
            return arguments.length < 3 && (u = r[o ? o[c] : c], c += n), t(r, e, u, o, c, a);
        };
    }
    function r(n) {
        return function(t, r, e) {
            r = m(r, e);
            for (var u = null != t && t.length, i = n > 0 ? 0 : u - 1; i >= 0 && i < u; i += n) if (r(t[i], i, t)) return i;
            return -1;
        };
    }
    function e(n, t) {
        var r = S.length, e = n.constructor, u = d.isFunction(e) && e.prototype || i, o = "constructor";
        for (d.has(n, o) && !d.contains(t, o) && t.push(o); r--; ) (o = S[r]) in n && n[o] !== u[o] && !d.contains(t, o) && t.push(o);
    }
    var u = Array.prototype, i = Object.prototype, o = Function.prototype, a = u.push, c = u.slice, l = i.toString, f = i.hasOwnProperty, s = Array.isArray, p = Object.keys, h = o.bind, v = Object.create, y = function() {}, d = function n(t) {
        return t instanceof n ? t : this instanceof n ? void (this._wrapped = t) : new n(t);
    };
    module.exports = d, d.VERSION = "1.8.2";
    var g = function(n, t, r) {
        if (void 0 === t) return n;
        switch (null == r ? 3 : r) {
          case 1:
            return function(r) {
                return n.call(t, r);
            };

          case 2:
            return function(r, e) {
                return n.call(t, r, e);
            };

          case 3:
            return function(r, e, u) {
                return n.call(t, r, e, u);
            };

          case 4:
            return function(r, e, u, i) {
                return n.call(t, r, e, u, i);
            };
        }
        return function() {
            return n.apply(t, arguments);
        };
    }, m = function(n, t, r) {
        return null == n ? d.identity : d.isFunction(n) ? g(n, t, r) : d.isObject(n) ? d.matcher(n) : d.property(n);
    };
    d.iteratee = function(n, t) {
        return m(n, t, 1 / 0);
    };
    var b = function(n, t) {
        return function(r) {
            var e = arguments.length;
            if (e < 2 || null == r) return r;
            for (var u = 1; u < e; u++) for (var i = arguments[u], o = n(i), a = o.length, c = 0; c < a; c++) {
                var l = o[c];
                t && void 0 !== r[l] || (r[l] = i[l]);
            }
            return r;
        };
    }, j = function(n) {
        if (!d.isObject(n)) return {};
        if (v) return v(n);
        y.prototype = n;
        var t = new y();
        return y.prototype = null, t;
    }, x = Math.pow(2, 53) - 1, _ = function(n) {
        var t = null != n && n.length;
        return "number" == typeof t && t >= 0 && t <= x;
    };
    d.each = d.forEach = function(n, t, r) {
        t = g(t, r);
        var e, u;
        if (_(n)) for (e = 0, u = n.length; e < u; e++) t(n[e], e, n); else {
            var i = d.keys(n);
            for (e = 0, u = i.length; e < u; e++) t(n[i[e]], i[e], n);
        }
        return n;
    }, d.map = d.collect = function(n, t, r) {
        t = m(t, r);
        for (var e = !_(n) && d.keys(n), u = (e || n).length, i = Array(u), o = 0; o < u; o++) {
            var a = e ? e[o] : o;
            i[o] = t(n[a], a, n);
        }
        return i;
    }, d.reduce = d.foldl = d.inject = t(1), d.reduceRight = d.foldr = t(-1), d.find = d.detect = function(n, t, r) {
        var e;
        if (void 0 !== (e = _(n) ? d.findIndex(n, t, r) : d.findKey(n, t, r)) && -1 !== e) return n[e];
    }, d.filter = d.select = function(n, t, r) {
        var e = [];
        return t = m(t, r), d.each(n, function(n, r, u) {
            t(n, r, u) && e.push(n);
        }), e;
    }, d.reject = function(n, t, r) {
        return d.filter(n, d.negate(m(t)), r);
    }, d.every = d.all = function(n, t, r) {
        t = m(t, r);
        for (var e = !_(n) && d.keys(n), u = (e || n).length, i = 0; i < u; i++) {
            var o = e ? e[i] : i;
            if (!t(n[o], o, n)) return !1;
        }
        return !0;
    }, d.some = d.any = function(n, t, r) {
        t = m(t, r);
        for (var e = !_(n) && d.keys(n), u = (e || n).length, i = 0; i < u; i++) {
            var o = e ? e[i] : i;
            if (t(n[o], o, n)) return !0;
        }
        return !1;
    }, d.contains = d.includes = d.include = function(n, t, r) {
        return _(n) || (n = d.values(n)), d.indexOf(n, t, "number" == typeof r && r) >= 0;
    }, d.invoke = function(n, t) {
        var r = c.call(arguments, 2), e = d.isFunction(t);
        return d.map(n, function(n) {
            var u = e ? t : n[t];
            return null == u ? u : u.apply(n, r);
        });
    }, d.pluck = function(n, t) {
        return d.map(n, d.property(t));
    }, d.where = function(n, t) {
        return d.filter(n, d.matcher(t));
    }, d.findWhere = function(n, t) {
        return d.find(n, d.matcher(t));
    }, d.max = function(n, t, r) {
        var e, u, i = -1 / 0, o = -1 / 0;
        if (null == t && null != n) for (var a = 0, c = (n = _(n) ? n : d.values(n)).length; a < c; a++) (e = n[a]) > i && (i = e); else t = m(t, r), 
        d.each(n, function(n, r, e) {
            ((u = t(n, r, e)) > o || u === -1 / 0 && i === -1 / 0) && (i = n, o = u);
        });
        return i;
    }, d.min = function(n, t, r) {
        var e, u, i = 1 / 0, o = 1 / 0;
        if (null == t && null != n) for (var a = 0, c = (n = _(n) ? n : d.values(n)).length; a < c; a++) (e = n[a]) < i && (i = e); else t = m(t, r), 
        d.each(n, function(n, r, e) {
            ((u = t(n, r, e)) < o || u === 1 / 0 && i === 1 / 0) && (i = n, o = u);
        });
        return i;
    }, d.shuffle = function(n) {
        for (var t, r = _(n) ? n : d.values(n), e = r.length, u = Array(e), i = 0; i < e; i++) (t = d.random(0, i)) !== i && (u[i] = u[t]), 
        u[t] = r[i];
        return u;
    }, d.sample = function(n, t, r) {
        return null == t || r ? (_(n) || (n = d.values(n)), n[d.random(n.length - 1)]) : d.shuffle(n).slice(0, Math.max(0, t));
    }, d.sortBy = function(n, t, r) {
        return t = m(t, r), d.pluck(d.map(n, function(n, r, e) {
            return {
                value: n,
                index: r,
                criteria: t(n, r, e)
            };
        }).sort(function(n, t) {
            var r = n.criteria, e = t.criteria;
            if (r !== e) {
                if (r > e || void 0 === r) return 1;
                if (r < e || void 0 === e) return -1;
            }
            return n.index - t.index;
        }), "value");
    };
    var w = function(n) {
        return function(t, r, e) {
            var u = {};
            return r = m(r, e), d.each(t, function(e, i) {
                var o = r(e, i, t);
                n(u, e, o);
            }), u;
        };
    };
    d.groupBy = w(function(n, t, r) {
        d.has(n, r) ? n[r].push(t) : n[r] = [ t ];
    }), d.indexBy = w(function(n, t, r) {
        n[r] = t;
    }), d.countBy = w(function(n, t, r) {
        d.has(n, r) ? n[r]++ : n[r] = 1;
    }), d.toArray = function(n) {
        return n ? d.isArray(n) ? c.call(n) : _(n) ? d.map(n, d.identity) : d.values(n) : [];
    }, d.size = function(n) {
        return null == n ? 0 : _(n) ? n.length : d.keys(n).length;
    }, d.partition = function(n, t, r) {
        t = m(t, r);
        var e = [], u = [];
        return d.each(n, function(n, r, i) {
            (t(n, r, i) ? e : u).push(n);
        }), [ e, u ];
    }, d.first = d.head = d.take = function(n, t, r) {
        if (null != n) return null == t || r ? n[0] : d.initial(n, n.length - t);
    }, d.initial = function(n, t, r) {
        return c.call(n, 0, Math.max(0, n.length - (null == t || r ? 1 : t)));
    }, d.last = function(n, t, r) {
        if (null != n) return null == t || r ? n[n.length - 1] : d.rest(n, Math.max(0, n.length - t));
    }, d.rest = d.tail = d.drop = function(n, t, r) {
        return c.call(n, null == t || r ? 1 : t);
    }, d.compact = function(n) {
        return d.filter(n, d.identity);
    };
    var A = function n(t, r, e, u) {
        for (var i = [], o = 0, a = u || 0, c = t && t.length; a < c; a++) {
            var l = t[a];
            if (_(l) && (d.isArray(l) || d.isArguments(l))) {
                r || (l = n(l, r, e));
                var f = 0, s = l.length;
                for (i.length += s; f < s; ) i[o++] = l[f++];
            } else e || (i[o++] = l);
        }
        return i;
    };
    d.flatten = function(n, t) {
        return A(n, t, !1);
    }, d.without = function(n) {
        return d.difference(n, c.call(arguments, 1));
    }, d.uniq = d.unique = function(n, t, r, e) {
        if (null == n) return [];
        d.isBoolean(t) || (e = r, r = t, t = !1), null != r && (r = m(r, e));
        for (var u = [], i = [], o = 0, a = n.length; o < a; o++) {
            var c = n[o], l = r ? r(c, o, n) : c;
            t ? (o && i === l || u.push(c), i = l) : r ? d.contains(i, l) || (i.push(l), u.push(c)) : d.contains(u, c) || u.push(c);
        }
        return u;
    }, d.union = function() {
        return d.uniq(A(arguments, !0, !0));
    }, d.intersection = function(n) {
        if (null == n) return [];
        for (var t = [], r = arguments.length, e = 0, u = n.length; e < u; e++) {
            var i = n[e];
            if (!d.contains(t, i)) {
                for (var o = 1; o < r && d.contains(arguments[o], i); o++) ;
                o === r && t.push(i);
            }
        }
        return t;
    }, d.difference = function(n) {
        var t = A(arguments, !0, !0, 1);
        return d.filter(n, function(n) {
            return !d.contains(t, n);
        });
    }, d.zip = function() {
        return d.unzip(arguments);
    }, d.unzip = function(n) {
        for (var t = n && d.max(n, "length").length || 0, r = Array(t), e = 0; e < t; e++) r[e] = d.pluck(n, e);
        return r;
    }, d.object = function(n, t) {
        for (var r = {}, e = 0, u = n && n.length; e < u; e++) t ? r[n[e]] = t[e] : r[n[e][0]] = n[e][1];
        return r;
    }, d.indexOf = function(n, t, r) {
        var e = 0, u = n && n.length;
        if ("number" == typeof r) e = r < 0 ? Math.max(0, u + r) : r; else if (r && u) return e = d.sortedIndex(n, t), 
        n[e] === t ? e : -1;
        if (t !== t) return d.findIndex(c.call(n, e), d.isNaN);
        for (;e < u; e++) if (n[e] === t) return e;
        return -1;
    }, d.lastIndexOf = function(n, t, r) {
        var e = n ? n.length : 0;
        if ("number" == typeof r && (e = r < 0 ? e + r + 1 : Math.min(e, r + 1)), t !== t) return d.findLastIndex(c.call(n, 0, e), d.isNaN);
        for (;--e >= 0; ) if (n[e] === t) return e;
        return -1;
    }, d.findIndex = r(1), d.findLastIndex = r(-1), d.sortedIndex = function(n, t, r, e) {
        for (var u = (r = m(r, e, 1))(t), i = 0, o = n.length; i < o; ) {
            var a = Math.floor((i + o) / 2);
            r(n[a]) < u ? i = a + 1 : o = a;
        }
        return i;
    }, d.range = function(n, t, r) {
        arguments.length <= 1 && (t = n || 0, n = 0), r = r || 1;
        for (var e = Math.max(Math.ceil((t - n) / r), 0), u = Array(e), i = 0; i < e; i++, 
        n += r) u[i] = n;
        return u;
    };
    var O = function(n, t, r, e, u) {
        if (!(e instanceof t)) return n.apply(r, u);
        var i = j(n.prototype), o = n.apply(i, u);
        return d.isObject(o) ? o : i;
    };
    d.bind = function(n, t) {
        if (h && n.bind === h) return h.apply(n, c.call(arguments, 1));
        if (!d.isFunction(n)) throw new TypeError("Bind must be called on a function");
        var r = c.call(arguments, 2);
        return function e() {
            return O(n, e, t, this, r.concat(c.call(arguments)));
        };
    }, d.partial = function(n) {
        var t = c.call(arguments, 1);
        return function r() {
            for (var e = 0, u = t.length, i = Array(u), o = 0; o < u; o++) i[o] = t[o] === d ? arguments[e++] : t[o];
            for (;e < arguments.length; ) i.push(arguments[e++]);
            return O(n, r, this, this, i);
        };
    }, d.bindAll = function(n) {
        var t, r, e = arguments.length;
        if (e <= 1) throw new Error("bindAll must be passed function names");
        for (t = 1; t < e; t++) n[r = arguments[t]] = d.bind(n[r], n);
        return n;
    }, d.memoize = function(n, t) {
        var r = function r(e) {
            var u = r.cache, i = "" + (t ? t.apply(this, arguments) : e);
            return d.has(u, i) || (u[i] = n.apply(this, arguments)), u[i];
        };
        return r.cache = {}, r;
    }, d.delay = function(n, t) {
        var r = c.call(arguments, 2);
        return setTimeout(function() {
            return n.apply(null, r);
        }, t);
    }, d.defer = d.partial(d.delay, d, 1), d.throttle = function(n, t, r) {
        var e, u, i, o = null, a = 0;
        r || (r = {});
        var c = function() {
            a = !1 === r.leading ? 0 : d.now(), o = null, i = n.apply(e, u), o || (e = u = null);
        };
        return function() {
            var l = d.now();
            a || !1 !== r.leading || (a = l);
            var f = t - (l - a);
            return e = this, u = arguments, f <= 0 || f > t ? (o && (clearTimeout(o), o = null), 
            a = l, i = n.apply(e, u), o || (e = u = null)) : o || !1 === r.trailing || (o = setTimeout(c, f)), 
            i;
        };
    }, d.debounce = function(n, t, r) {
        var e, u, i, o, a, c = function c() {
            var l = d.now() - o;
            l < t && l >= 0 ? e = setTimeout(c, t - l) : (e = null, r || (a = n.apply(i, u), 
            e || (i = u = null)));
        };
        return function() {
            i = this, u = arguments, o = d.now();
            var l = r && !e;
            return e || (e = setTimeout(c, t)), l && (a = n.apply(i, u), i = u = null), a;
        };
    }, d.wrap = function(n, t) {
        return d.partial(t, n);
    }, d.negate = function(n) {
        return function() {
            return !n.apply(this, arguments);
        };
    }, d.compose = function() {
        var n = arguments, t = n.length - 1;
        return function() {
            for (var r = t, e = n[t].apply(this, arguments); r--; ) e = n[r].call(this, e);
            return e;
        };
    }, d.after = function(n, t) {
        return function() {
            if (--n < 1) return t.apply(this, arguments);
        };
    }, d.before = function(n, t) {
        var r;
        return function() {
            return --n > 0 && (r = t.apply(this, arguments)), n <= 1 && (t = null), r;
        };
    }, d.once = d.partial(d.before, 2);
    var k = !{
        toString: null
    }.propertyIsEnumerable("toString"), S = [ "valueOf", "isPrototypeOf", "toString", "propertyIsEnumerable", "hasOwnProperty", "toLocaleString" ];
    d.keys = function(n) {
        if (!d.isObject(n)) return [];
        if (p) return p(n);
        var t = [];
        for (var r in n) d.has(n, r) && t.push(r);
        return k && e(n, t), t;
    }, d.allKeys = function(n) {
        if (!d.isObject(n)) return [];
        var t = [];
        for (var r in n) t.push(r);
        return k && e(n, t), t;
    }, d.values = function(n) {
        for (var t = d.keys(n), r = t.length, e = Array(r), u = 0; u < r; u++) e[u] = n[t[u]];
        return e;
    }, d.mapObject = function(n, t, r) {
        t = m(t, r);
        for (var e, u = d.keys(n), i = u.length, o = {}, a = 0; a < i; a++) o[e = u[a]] = t(n[e], e, n);
        return o;
    }, d.pairs = function(n) {
        for (var t = d.keys(n), r = t.length, e = Array(r), u = 0; u < r; u++) e[u] = [ t[u], n[t[u]] ];
        return e;
    }, d.invert = function(n) {
        for (var t = {}, r = d.keys(n), e = 0, u = r.length; e < u; e++) t[n[r[e]]] = r[e];
        return t;
    }, d.functions = d.methods = function(n) {
        var t = [];
        for (var r in n) d.isFunction(n[r]) && t.push(r);
        return t.sort();
    }, d.extend = b(d.allKeys), d.extendOwn = d.assign = b(d.keys), d.findKey = function(n, t, r) {
        t = m(t, r);
        for (var e, u = d.keys(n), i = 0, o = u.length; i < o; i++) if (e = u[i], t(n[e], e, n)) return e;
    }, d.pick = function(n, t, r) {
        var e, u, i = {}, o = n;
        if (null == o) return i;
        d.isFunction(t) ? (u = d.allKeys(o), e = g(t, r)) : (u = A(arguments, !1, !1, 1), 
        e = function(n, t, r) {
            return t in r;
        }, o = Object(o));
        for (var a = 0, c = u.length; a < c; a++) {
            var l = u[a], f = o[l];
            e(f, l, o) && (i[l] = f);
        }
        return i;
    }, d.omit = function(n, t, r) {
        if (d.isFunction(t)) t = d.negate(t); else {
            var e = d.map(A(arguments, !1, !1, 1), String);
            t = function(n, t) {
                return !d.contains(e, t);
            };
        }
        return d.pick(n, t, r);
    }, d.defaults = b(d.allKeys, !0), d.create = function(n, t) {
        var r = j(n);
        return t && d.extendOwn(r, t), r;
    }, d.clone = function(n) {
        return d.isObject(n) ? d.isArray(n) ? n.slice() : d.extend({}, n) : n;
    }, d.tap = function(n, t) {
        return t(n), n;
    }, d.isMatch = function(n, t) {
        var r = d.keys(t), e = r.length;
        if (null == n) return !e;
        for (var u = Object(n), i = 0; i < e; i++) {
            var o = r[i];
            if (t[o] !== u[o] || !(o in u)) return !1;
        }
        return !0;
    };
    var F = function t(r, e, u, i) {
        if (r === e) return 0 !== r || 1 / r == 1 / e;
        if (null == r || null == e) return r === e;
        r instanceof d && (r = r._wrapped), e instanceof d && (e = e._wrapped);
        var o = l.call(r);
        if (o !== l.call(e)) return !1;
        switch (o) {
          case "[object RegExp]":
          case "[object String]":
            return "" + r == "" + e;

          case "[object Number]":
            return +r != +r ? +e != +e : 0 == +r ? 1 / +r == 1 / e : +r == +e;

          case "[object Date]":
          case "[object Boolean]":
            return +r == +e;
        }
        var a = "[object Array]" === o;
        if (!a) {
            if ("object" != (void 0 === r ? "undefined" : n(r)) || "object" != (void 0 === e ? "undefined" : n(e))) return !1;
            var c = r.constructor, f = e.constructor;
            if (c !== f && !(d.isFunction(c) && c instanceof c && d.isFunction(f) && f instanceof f) && "constructor" in r && "constructor" in e) return !1;
        }
        u = u || [], i = i || [];
        for (var s = u.length; s--; ) if (u[s] === r) return i[s] === e;
        if (u.push(r), i.push(e), a) {
            if ((s = r.length) !== e.length) return !1;
            for (;s--; ) if (!t(r[s], e[s], u, i)) return !1;
        } else {
            var p, h = d.keys(r);
            if (s = h.length, d.keys(e).length !== s) return !1;
            for (;s--; ) if (p = h[s], !d.has(e, p) || !t(r[p], e[p], u, i)) return !1;
        }
        return u.pop(), i.pop(), !0;
    };
    d.isEqual = function(n, t) {
        return F(n, t);
    }, d.isEmpty = function(n) {
        return null == n || (_(n) && (d.isArray(n) || d.isString(n) || d.isArguments(n)) ? 0 === n.length : 0 === d.keys(n).length);
    }, d.isElement = function(n) {
        return !(!n || 1 !== n.nodeType);
    }, d.isArray = s || function(n) {
        return "[object Array]" === l.call(n);
    }, d.isObject = function(t) {
        var r = void 0 === t ? "undefined" : n(t);
        return "function" === r || "object" === r && !!t;
    }, d.each([ "Arguments", "Function", "String", "Number", "Date", "RegExp", "Error" ], function(n) {
        d["is" + n] = function(t) {
            return l.call(t) === "[object " + n + "]";
        };
    }), d.isArguments(arguments) || (d.isArguments = function(n) {
        return d.has(n, "callee");
    }), "function" != typeof /./ && "object" != ("undefined" == typeof Int8Array ? "undefined" : n(Int8Array)) && (d.isFunction = function(n) {
        return "function" == typeof n || !1;
    }), d.isFinite = function(n) {
        return isFinite(n) && !isNaN(parseFloat(n));
    }, d.isNaN = function(n) {
        return d.isNumber(n) && n !== +n;
    }, d.isBoolean = function(n) {
        return !0 === n || !1 === n || "[object Boolean]" === l.call(n);
    }, d.isNull = function(n) {
        return null === n;
    }, d.isUndefined = function(n) {
        return void 0 === n;
    }, d.has = function(n, t) {
        return null != n && f.call(n, t);
    }, d.noConflict = function() {
        return root._ = previousUnderscore, this;
    }, d.identity = function(n) {
        return n;
    }, d.constant = function(n) {
        return function() {
            return n;
        };
    }, d.noop = function() {}, d.property = function(n) {
        return function(t) {
            return null == t ? void 0 : t[n];
        };
    }, d.propertyOf = function(n) {
        return null == n ? function() {} : function(t) {
            return n[t];
        };
    }, d.matcher = d.matches = function(n) {
        return n = d.extendOwn({}, n), function(t) {
            return d.isMatch(t, n);
        };
    }, d.times = function(n, t, r) {
        var e = Array(Math.max(0, n));
        t = g(t, r, 1);
        for (var u = 0; u < n; u++) e[u] = t(u);
        return e;
    }, d.random = function(n, t) {
        return null == t && (t = n, n = 0), n + Math.floor(Math.random() * (t - n + 1));
    }, d.now = Date.now || function() {
        return new Date().getTime();
    };
    var E = {
        "&": "&amp;",
        "<": "&lt;",
        ">": "&gt;",
        '"': "&quot;",
        "'": "&#x27;",
        "`": "&#x60;"
    }, I = d.invert(E), M = function(n) {
        var t = function(t) {
            return n[t];
        }, r = "(?:" + d.keys(n).join("|") + ")", e = RegExp(r), u = RegExp(r, "g");
        return function(n) {
            return n = null == n ? "" : "" + n, e.test(n) ? n.replace(u, t) : n;
        };
    };
    d.escape = M(E), d.unescape = M(I), d.result = function(n, t, r) {
        var e = null == n ? void 0 : n[t];
        return void 0 === e && (e = r), d.isFunction(e) ? e.call(n) : e;
    };
    var N = 0;
    d.uniqueId = function(n) {
        var t = ++N + "";
        return n ? n + t : t;
    }, d.templateSettings = {
        evaluate: /<%([\s\S]+?)%>/g,
        interpolate: /<%=([\s\S]+?)%>/g,
        escape: /<%-([\s\S]+?)%>/g
    };
    var B = /(.)^/, T = {
        "'": "'",
        "\\": "\\",
        "\r": "r",
        "\n": "n",
        "\u2028": "u2028",
        "\u2029": "u2029"
    }, R = /\\|'|\r|\n|\u2028|\u2029/g, q = function(n) {
        return "\\" + T[n];
    };
    d.template = function(n, t, r) {
        !t && r && (t = r), t = d.defaults({}, t, d.templateSettings);
        var e = RegExp([ (t.escape || B).source, (t.interpolate || B).source, (t.evaluate || B).source ].join("|") + "|$", "g"), u = 0, i = "__p+='";
        n.replace(e, function(t, r, e, o, a) {
            return i += n.slice(u, a).replace(R, q), u = a + t.length, r ? i += "'+\n((__t=(" + r + "))==null?'':_.escape(__t))+\n'" : e ? i += "'+\n((__t=(" + e + "))==null?'':__t)+\n'" : o && (i += "';\n" + o + "\n__p+='"), 
            t;
        }), i += "';\n", t.variable || (i = "with(obj||{}){\n" + i + "}\n"), i = "var __t,__p='',__j=Array.prototype.join,print=function(){__p+=__j.call(arguments,'');};\n" + i + "return __p;\n";
        try {
            var o = new Function(t.variable || "obj", "_", i);
        } catch (n) {
            throw n.source = i, n;
        }
        var a = function(n) {
            return o.call(this, n, d);
        }, c = t.variable || "obj";
        return a.source = "function(" + c + "){\n" + i + "}", a;
    }, d.chain = function(n) {
        var t = d(n);
        return t._chain = !0, t;
    };
    var K = function(n, t) {
        return n._chain ? d(t).chain() : t;
    };
    d.mixin = function(n) {
        d.each(d.functions(n), function(t) {
            var r = d[t] = n[t];
            d.prototype[t] = function() {
                var n = [ this._wrapped ];
                return a.apply(n, arguments), K(this, r.apply(d, n));
            };
        });
    }, d.mixin(d), d.each([ "pop", "push", "reverse", "shift", "sort", "splice", "unshift" ], function(n) {
        var t = u[n];
        d.prototype[n] = function() {
            var r = this._wrapped;
            return t.apply(r, arguments), "shift" !== n && "splice" !== n || 0 !== r.length || delete r[0], 
            K(this, r);
        };
    }), d.each([ "concat", "join", "slice" ], function(n) {
        var t = u[n];
        d.prototype[n] = function() {
            return K(this, t.apply(this._wrapped, arguments));
        };
    }), d.prototype.value = function() {
        return this._wrapped;
    }, d.prototype.valueOf = d.prototype.toJSON = d.prototype.value, d.prototype.toString = function() {
        return "" + this._wrapped;
    };
}).call(void 0);