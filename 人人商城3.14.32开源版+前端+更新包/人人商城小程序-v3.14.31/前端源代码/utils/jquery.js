function n(t, r, o, i) {
    var u;
    if (p.isArray(r)) p.each(r, function(r, u) {
        o || y.test(t) ? i(t, u) : n(t + "[" + ("object" === (void 0 === u ? "undefined" : e(u)) ? r : "") + "]", u, o, i);
    }); else if (o || "object" !== p.type(r)) i(t, r); else for (u in r) n(t + "[" + u + "]", r[u], o, i);
}

function t(n) {
    var t = n.length, r = p.type(n);
    return !p.isWindow(n) && (!(1 !== n.nodeType || !t) || "array" === r || "function" !== r && (0 === t || "number" == typeof t && t > 0 && t - 1 in n));
}

var r = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function(n) {
    return typeof n;
} : function(n) {
    return n && "function" == typeof Symbol && n.constructor === Symbol && n !== Symbol.prototype ? "symbol" : typeof n;
}, e = "function" == typeof Symbol && "symbol" == r(Symbol.iterator) ? function(n) {
    return void 0 === n ? "undefined" : r(n);
} : function(n) {
    return n && "function" == typeof Symbol && n.constructor === Symbol && n !== Symbol.prototype ? "symbol" : void 0 === n ? "undefined" : r(n);
}, o = {}, i = [], u = i.push, f = i.indexOf, c = o.toString, a = o.hasOwnProperty, l = "1.10.2".trim, s = /%20/g, y = /\[\]$/, p = {
    isFunction: function(n) {
        return "function" === p.type(n);
    },
    isArray: Array.isArray || function(n) {
        return "array" === p.type(n);
    },
    isWindow: function(n) {
        return null != n && n == n.window;
    },
    isNumeric: function(n) {
        return !isNaN(parseFloat(n)) && isFinite(n);
    },
    type: function(n) {
        return null == n ? String(n) : "object" === (void 0 === n ? "undefined" : e(n)) || "function" == typeof n ? o[c.call(n)] || "object" : void 0 === n ? "undefined" : e(n);
    },
    isPlainObject: function(n) {
        var t;
        if (!n || "object" !== p.type(n) || n.nodeType || p.isWindow(n)) return !1;
        try {
            if (n.constructor && !a.call(n, "constructor") && !a.call(n.constructor.prototype, "isPrototypeOf")) return !1;
        } catch (n) {
            return !1;
        }
        if (p.support.ownLast) for (t in n) return a.call(n, t);
        for (t in n) ;
        return void 0 === t || a.call(n, t);
    },
    isEmptyObject: function(n) {
        var t;
        for (t in n) return !1;
        return !0;
    },
    each: function(n, r, e) {
        var o = 0, i = n.length, u = t(n);
        if (e) {
            if (u) for (;o < i && !1 !== r.apply(n[o], e); o++) ; else for (o in n) if (!1 === r.apply(n[o], e)) break;
        } else if (u) for (;o < i && !1 !== r.call(n[o], o, n[o]); o++) ; else for (o in n) if (!1 === r.call(n[o], o, n[o])) break;
        return n;
    },
    trim: l && !l.call("\ufeff ") ? function(n) {
        return null == n ? "" : l.call(n);
    } : function(n) {
        return null == n ? "" : (n + "").replace(rtrim, "");
    },
    makeArray: function(n, r) {
        var e = r || [];
        return null != n && (t(Object(n)) ? p.merge(e, "string" == typeof n ? [ n ] : n) : u.call(e, n)), 
        e;
    },
    inArray: function(n, t, r) {
        var e;
        if (t) {
            if (f) return f.call(t, n, r);
            for (e = t.length, r = r ? r < 0 ? Math.max(0, e + r) : r : 0; r < e; r++) if (r in t && t[r] === n) return r;
        }
        return -1;
    },
    merge: function(n, t) {
        var r = t.length, e = n.length, o = 0;
        if ("number" == typeof r) for (;o < r; o++) n[e++] = t[o]; else for (;void 0 !== t[o]; ) n[e++] = t[o++];
        return n.length = e, n;
    },
    isMobile: function(n) {
        return "" !== p.trim(n) && /^1[3|4|5|6|7|8|9][0-9]\d{8}$/.test(p.trim(n));
    },
    toFixed: function(n, t) {
        var r = parseInt(t) || 0;
        if (r < -20 || r > 100) throw new RangeError("Precision of " + r + " fractional digits is out of range");
        var e = Number(n);
        if (isNaN(e)) return "NaN";
        var o = "";
        if (e <= 0 && (o = "-", e = -e), e >= Math.pow(10, 21)) return o + e.toString();
        var i;
        if (t = Math.round(e * Math.pow(10, r)), i = 0 == t ? "0" : t.toString(), 0 == r) return o + i;
        var u = i.length;
        return u <= r && (i = Math.pow(10, r + 1 - u).toString().substring(1) + i, u = r + 1), 
        r > 0 && (i = i.substring(0, u - r) + "." + i.substring(u - r)), o + i;
    }
};

p.extend = function() {
    var n, t, r, o, i, u, f = arguments[0] || {}, c = 1, a = arguments.length, l = !1;
    for ("boolean" == typeof f && (l = f, f = arguments[1] || {}, c = 2), "object" === (void 0 === f ? "undefined" : e(f)) || p.isFunction(f) || (f = {}), 
    a === c && (f = this, --c); c < a; c++) if (null != (n = arguments[c])) for (t in n) r = f[t], 
    f !== (o = n[t]) && (l && o && (p.isPlainObject(o) || (i = p.isArray(o))) ? (i ? (i = !1, 
    u = r && p.isArray(r) ? r : []) : u = r && p.isPlainObject(r) ? r : {}, f[t] = p.extend(l, u, o)) : void 0 !== o && (f[t] = o));
    return f;
}, p.param = function(t, r) {
    var e, o = [], i = function(n, t) {
        t = p.isFunction(t) ? t() : null == t ? "" : t, o[o.length] = encodeURIComponent(n) + "=" + encodeURIComponent(t);
    };
    if (void 0 === r && (r = !1), p.isArray(t) || t.jquery && !p.isPlainObject(t)) p.each(t, function() {
        i(this.name, this.value);
    }); else for (e in t) n(e, t[e], r, i);
    return o.join("&").replace(s, "+");
}, module.exports = p;