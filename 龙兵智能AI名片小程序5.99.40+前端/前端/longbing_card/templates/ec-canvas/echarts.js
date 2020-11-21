var _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function(t) {
    return typeof t;
} : function(t) {
    return t && "function" == typeof Symbol && t.constructor === Symbol && t !== Symbol.prototype ? "symbol" : typeof t;
};

!function(t, e) {
    "object" == ("undefined" == typeof exports ? "undefined" : _typeof(exports)) && "undefined" != typeof module ? e(exports) : "function" == typeof define && define.amd ? define([ "exports" ], e) : e(t.echarts = {});
}(void 0, function(t) {
    function e(t, e) {
        "createCanvas" === t && (Xl = null), Hl[t] = e;
    }
    function b(t) {
        if (null == t || "object" != (void 0 === t ? "undefined" : _typeof(t))) return t;
        var e = t, i = zl.call(t);
        if ("[object Array]" === i) {
            if (!w(t)) {
                e = [];
                for (var n = 0, r = t.length; n < r; n++) e[n] = b(t[n]);
            }
        } else if (El[i]) {
            if (!w(t)) {
                var a = t.constructor;
                if (t.constructor.from) e = a.from(t); else {
                    e = new a(t.length);
                    for (n = 0, r = t.length; n < r; n++) e[n] = b(t[n]);
                }
            }
        } else if (!Ol[i] && !w(t) && !s(t)) for (var o in e = {}, t) t.hasOwnProperty(o) && (e[o] = b(t[o]));
        return e;
    }
    function m(t, e, i) {
        if (!L(e) || !L(t)) return i ? b(e) : t;
        for (var n in e) if (e.hasOwnProperty(n)) {
            var r = t[n], a = e[n];
            !L(a) || !L(r) || P(a) || P(r) || s(a) || s(r) || o(a) || o(r) || w(a) || w(r) ? !i && n in t || (t[n] = b(e[n])) : m(r, a, i);
        }
        return t;
    }
    function i(t, e) {
        for (var i = t[0], n = 1, r = t.length; n < r; n++) i = m(i, t[n], e);
        return i;
    }
    function A(t, e) {
        for (var i in e) e.hasOwnProperty(i) && (t[i] = e[i]);
        return t;
    }
    function C(t, e, i) {
        for (var n in e) e.hasOwnProperty(n) && (i ? null != e[n] : null == t[n]) && (t[n] = e[n]);
        return t;
    }
    function n() {
        return Xl || (Xl = Wl().getContext("2d")), Xl;
    }
    function d(t, e) {
        if (t) {
            if (t.indexOf) return t.indexOf(e);
            for (var i = 0, n = t.length; i < n; i++) if (t[i] === e) return i;
        }
        return -1;
    }
    function a(t, e) {
        function i() {}
        var n = t.prototype;
        for (var r in i.prototype = e.prototype, t.prototype = new i(), n) t.prototype[r] = n[r];
        (t.prototype.constructor = t).superClass = e;
    }
    function r(t, e, i) {
        C(t = "prototype" in t ? t.prototype : t, e = "prototype" in e ? e.prototype : e, i);
    }
    function E(t) {
        return t ? "string" != typeof t && "number" == typeof t.length : void 0;
    }
    function R(t, e, i) {
        if (t && e) if (t.forEach && t.forEach === Rl) t.forEach(e, i); else if (t.length === +t.length) for (var n = 0, r = t.length; n < r; n++) e.call(i, t[n], n, t); else for (var a in t) t.hasOwnProperty(a) && e.call(i, t[a], a, t);
    }
    function D(t, e, i) {
        if (t && e) {
            if (t.map && t.map === Gl) return t.map(e, i);
            for (var n = [], r = 0, a = t.length; r < a; r++) n.push(e.call(i, t[r], r, t));
            return n;
        }
    }
    function S(t, e, i, n) {
        if (t && e) {
            if (t.reduce && t.reduce === Vl) return t.reduce(e, i, n);
            for (var r = 0, a = t.length; r < a; r++) i = e.call(n, i, t[r], r, t);
            return i;
        }
    }
    function u(t, e, i) {
        if (t && e) {
            if (t.filter && t.filter === Nl) return t.filter(e, i);
            for (var n = [], r = 0, a = t.length; r < a; r++) e.call(i, t[r], r, t) && n.push(t[r]);
            return n;
        }
    }
    function _(t, e) {
        var i = Fl.call(arguments, 2);
        return function() {
            return t.apply(e, i.concat(Fl.call(arguments)));
        };
    }
    function g(t) {
        var e = Fl.call(arguments, 1);
        return function() {
            return t.apply(this, e.concat(Fl.call(arguments)));
        };
    }
    function P(t) {
        return "[object Array]" === zl.call(t);
    }
    function v(t) {
        return "function" == typeof t;
    }
    function M(t) {
        return "[object String]" === zl.call(t);
    }
    function L(t) {
        var e = void 0 === t ? "undefined" : _typeof(t);
        return "function" === e || !!t && "object" == e;
    }
    function o(t) {
        return !!Ol[zl.call(t)];
    }
    function p(t) {
        return !!El[zl.call(t)];
    }
    function s(t) {
        return "object" == (void 0 === t ? "undefined" : _typeof(t)) && "number" == typeof t.nodeType && "object" == _typeof(t.ownerDocument);
    }
    function y(t) {
        return t != t;
    }
    function k() {
        for (var t = 0, e = arguments.length; t < e; t++) if (null != arguments[t]) return arguments[t];
    }
    function O(t, e) {
        return null != t ? t : e;
    }
    function z(t, e, i) {
        return null != t ? t : null != e ? e : i;
    }
    function l() {
        return Function.call.apply(Fl, arguments);
    }
    function h(t) {
        if ("number" == typeof t) return [ t, t, t, t ];
        var e = t.length;
        return 2 === e ? [ t[0], t[1], t[0], t[1] ] : 3 === e ? [ t[0], t[1], t[2], t[1] ] : t;
    }
    function c(t, e) {
        if (!t) throw new Error(e);
    }
    function f(t) {
        return null == t ? null : "function" == typeof t.trim ? t.trim() : t.replace(/^[\s\uFEFF\xA0]+|[\s\uFEFF\xA0]+$/g, "");
    }
    function x(t) {
        t[ql] = !0;
    }
    function w(t) {
        return t[ql];
    }
    function I(t) {
        function e(t, e) {
            i ? n.set(t, e) : n.set(e, t);
        }
        var i = P(t);
        this.data = {};
        var n = this;
        t instanceof I ? t.each(e) : t && R(t, e);
    }
    function T(t) {
        return new I(t);
    }
    function B() {}
    function N(t, e) {
        var i = new Ul(2);
        return null == t && (t = 0), null == e && (e = 0), i[0] = t, i[1] = e, i;
    }
    function F(t, e) {
        return t[0] = e[0], t[1] = e[1], t;
    }
    function G(t) {
        var e = new Ul(2);
        return e[0] = t[0], e[1] = t[1], e;
    }
    function V(t, e, i) {
        return t[0] = e[0] + i[0], t[1] = e[1] + i[1], t;
    }
    function H(t, e, i, n) {
        return t[0] = e[0] + i[0] * n, t[1] = e[1] + i[1] * n, t;
    }
    function W(t, e, i) {
        return t[0] = e[0] - i[0], t[1] = e[1] - i[1], t;
    }
    function X(t) {
        return Math.sqrt(q(t));
    }
    function q(t) {
        return t[0] * t[0] + t[1] * t[1];
    }
    function j(t, e, i) {
        return t[0] = e[0] * i, t[1] = e[1] * i, t;
    }
    function U(t, e) {
        var i = X(e);
        return 0 === i ? (t[0] = 0, t[1] = 0) : (t[0] = e[0] / i, t[1] = e[1] / i), t;
    }
    function Y(t, e) {
        return Math.sqrt((t[0] - e[0]) * (t[0] - e[0]) + (t[1] - e[1]) * (t[1] - e[1]));
    }
    function Z(t, e) {
        return (t[0] - e[0]) * (t[0] - e[0]) + (t[1] - e[1]) * (t[1] - e[1]);
    }
    function $(t, e, i) {
        var n = e[0], r = e[1];
        return t[0] = i[0] * n + i[2] * r + i[4], t[1] = i[1] * n + i[3] * r + i[5], t;
    }
    function K(t, e, i) {
        return t[0] = Math.min(e[0], i[0]), t[1] = Math.min(e[1], i[1]), t;
    }
    function Q(t, e, i) {
        return t[0] = Math.max(e[0], i[0]), t[1] = Math.max(e[1], i[1]), t;
    }
    function J() {
        this.on("mousedown", this._dragStart, this), this.on("mousemove", this._drag, this), 
        this.on("mouseup", this._dragEnd, this), this.on("globalout", this._dragEnd, this);
    }
    function tt(t, e) {
        return {
            target: t,
            topTarget: e && e.topTarget
        };
    }
    function et(t, e) {
        var i = t._$eventProcessor;
        return null != e && i && i.normalizeQuery && (e = i.normalizeQuery(e)), e;
    }
    function it(t, e, i, n) {
        return i = i || {}, n || !Ll.canvasSupported ? nt(t, e, i) : Ll.browser.firefox && null != e.layerX && e.layerX !== e.offsetX ? (i.zrX = e.layerX, 
        i.zrY = e.layerY) : null != e.offsetX ? (i.zrX = e.offsetX, i.zrY = e.offsetY) : nt(t, e, i), 
        i;
    }
    function nt(t, e, i) {
        var n, r = (n = t).getBoundingClientRect ? n.getBoundingClientRect() : {
            left: 0,
            top: 0
        };
        i.zrX = e.clientX - r.left, i.zrY = e.clientY - r.top;
    }
    function rt(t, e, i) {
        if (null != (e = e || window.event).zrX) return e;
        var n = e.type;
        if (n && 0 <= n.indexOf("touch")) {
            var r = "touchend" != n ? e.targetTouches[0] : e.changedTouches[0];
            r && it(t, r, e, i);
        } else it(t, e, e, i), e.zrDelta = e.wheelDelta ? e.wheelDelta / 120 : -(e.detail || 0) / 3;
        var a = e.button;
        return null == e.which && void 0 !== a && ih.test(e.type) && (e.which = 1 & a ? 1 : 2 & a ? 3 : 4 & a ? 2 : 0), 
        e;
    }
    function at() {
        nh(this.event);
    }
    function ot() {}
    function st(t, e, i) {
        if (t[t.rectHover ? "rectContain" : "contain"](e, i)) {
            for (var n, r = t; r; ) {
                if (r.clipPath && !r.clipPath.contain(e, i)) return !1;
                r.silent && (n = !0), r = r.parent;
            }
            return !n || rh;
        }
        return !1;
    }
    function lt() {
        var t = new sh(6);
        return ht(t), t;
    }
    function ht(t) {
        return t[0] = 1, t[1] = 0, t[2] = 0, t[3] = 1, t[4] = 0, t[5] = 0, t;
    }
    function ut(t, e) {
        return t[0] = e[0], t[1] = e[1], t[2] = e[2], t[3] = e[3], t[4] = e[4], t[5] = e[5], 
        t;
    }
    function ct(t, e, i) {
        var n = e[0] * i[0] + e[2] * i[1], r = e[1] * i[0] + e[3] * i[1], a = e[0] * i[2] + e[2] * i[3], o = e[1] * i[2] + e[3] * i[3], s = e[0] * i[4] + e[2] * i[5] + e[4], l = e[1] * i[4] + e[3] * i[5] + e[5];
        return t[0] = n, t[1] = r, t[2] = a, t[3] = o, t[4] = s, t[5] = l, t;
    }
    function dt(t, e, i) {
        return t[0] = e[0], t[1] = e[1], t[2] = e[2], t[3] = e[3], t[4] = e[4] + i[0], t[5] = e[5] + i[1], 
        t;
    }
    function ft(t, e, i) {
        var n = e[0], r = e[2], a = e[4], o = e[1], s = e[3], l = e[5], h = Math.sin(i), u = Math.cos(i);
        return t[0] = n * u + o * h, t[1] = -n * h + o * u, t[2] = r * u + s * h, t[3] = -r * h + u * s, 
        t[4] = u * a + h * l, t[5] = u * l - h * a, t;
    }
    function pt(t, e, i) {
        var n = i[0], r = i[1];
        return t[0] = e[0] * n, t[1] = e[1] * r, t[2] = e[2] * n, t[3] = e[3] * r, t[4] = e[4] * n, 
        t[5] = e[5] * r, t;
    }
    function gt(t, e) {
        var i = e[0], n = e[2], r = e[4], a = e[1], o = e[3], s = e[5], l = i * o - a * n;
        return l ? (l = 1 / l, t[0] = o * l, t[1] = -a * l, t[2] = -n * l, t[3] = i * l, 
        t[4] = (n * s - o * r) * l, t[5] = (a * r - i * s) * l, t) : null;
    }
    function mt(t) {
        return 5e-5 < t || t < -5e-5;
    }
    function vt(t) {
        this._target = t.target, this._life = t.life || 1e3, this._delay = t.delay || 0, 
        this._initialized = !1, this.loop = null != t.loop && t.loop, this.gap = t.gap || 0, 
        this.easing = t.easing || "Linear", this.onframe = t.onframe, this.ondestroy = t.ondestroy, 
        this.onrestart = t.onrestart, this._pausedTime = 0, this._paused = !1;
    }
    function yt(t) {
        return (t = Math.round(t)) < 0 ? 0 : 255 < t ? 255 : t;
    }
    function xt(t) {
        return t < 0 ? 0 : 1 < t ? 1 : t;
    }
    function _t(t) {
        return yt(t.length && "%" === t.charAt(t.length - 1) ? parseFloat(t) / 100 * 255 : parseInt(t, 10));
    }
    function wt(t) {
        return xt(t.length && "%" === t.charAt(t.length - 1) ? parseFloat(t) / 100 : parseFloat(t));
    }
    function bt(t, e, i) {
        return i < 0 ? i += 1 : 1 < i && (i -= 1), 6 * i < 1 ? t + (e - t) * i * 6 : 2 * i < 1 ? e : 3 * i < 2 ? t + (e - t) * (2 / 3 - i) * 6 : t;
    }
    function St(t, e, i) {
        return t + (e - t) * i;
    }
    function Mt(t, e, i, n, r) {
        return t[0] = e, t[1] = i, t[2] = n, t[3] = r, t;
    }
    function It(t, e) {
        return t[0] = e[0], t[1] = e[1], t[2] = e[2], t[3] = e[3], t;
    }
    function Tt(t, e) {
        Sh && It(Sh, e), Sh = bh.put(t, Sh || e.slice());
    }
    function Ct(t, e) {
        if (t) {
            e = e || [];
            var i = bh.get(t);
            if (i) return It(e, i);
            var n = (t += "").replace(/ /g, "").toLowerCase();
            if (n in wh) return It(e, wh[n]), Tt(t, e), e;
            if ("#" !== n.charAt(0)) {
                var r = n.indexOf("("), a = n.indexOf(")");
                if (-1 !== r && a + 1 === n.length) {
                    var o = n.substr(0, r), s = n.substr(r + 1, a - (r + 1)).split(","), l = 1;
                    switch (o) {
                      case "rgba":
                        if (4 !== s.length) return void Mt(e, 0, 0, 0, 1);
                        l = wt(s.pop());

                      case "rgb":
                        return 3 !== s.length ? void Mt(e, 0, 0, 0, 1) : (Mt(e, _t(s[0]), _t(s[1]), _t(s[2]), l), 
                        Tt(t, e), e);

                      case "hsla":
                        return 4 !== s.length ? void Mt(e, 0, 0, 0, 1) : (s[3] = wt(s[3]), Dt(s, e), Tt(t, e), 
                        e);

                      case "hsl":
                        return 3 !== s.length ? void Mt(e, 0, 0, 0, 1) : (Dt(s, e), Tt(t, e), e);

                      default:
                        return;
                    }
                }
                Mt(e, 0, 0, 0, 1);
            } else {
                var h;
                if (4 === n.length) return 0 <= (h = parseInt(n.substr(1), 16)) && h <= 4095 ? (Mt(e, (3840 & h) >> 4 | (3840 & h) >> 8, 240 & h | (240 & h) >> 4, 15 & h | (15 & h) << 4, 1), 
                Tt(t, e), e) : void Mt(e, 0, 0, 0, 1);
                if (7 === n.length) return 0 <= (h = parseInt(n.substr(1), 16)) && h <= 16777215 ? (Mt(e, (16711680 & h) >> 16, (65280 & h) >> 8, 255 & h, 1), 
                Tt(t, e), e) : void Mt(e, 0, 0, 0, 1);
            }
        }
    }
    function Dt(t, e) {
        var i = (parseFloat(t[0]) % 360 + 360) % 360 / 360, n = wt(t[1]), r = wt(t[2]), a = r <= .5 ? r * (n + 1) : r + n - r * n, o = 2 * r - a;
        return Mt(e = e || [], yt(255 * bt(o, a, i + 1 / 3)), yt(255 * bt(o, a, i)), yt(255 * bt(o, a, i - 1 / 3)), 1), 
        4 === t.length && (e[3] = t[3]), e;
    }
    function At(t, e) {
        var i = Ct(t);
        if (i) {
            for (var n = 0; n < 3; n++) i[n] = e < 0 ? i[n] * (1 - e) | 0 : (255 - i[n]) * e + i[n] | 0, 
            255 < i[n] ? i[n] = 255 : t[n] < 0 && (i[n] = 0);
            return Ot(i, 4 === i.length ? "rgba" : "rgb");
        }
    }
    function kt(t) {
        var e = Ct(t);
        return e ? ((1 << 24) + (e[0] << 16) + (e[1] << 8) + +e[2]).toString(16).slice(1) : void 0;
    }
    function Pt(t, e, i) {
        if (e && e.length && 0 <= t && t <= 1) {
            i = i || [];
            var n = t * (e.length - 1), r = Math.floor(n), a = Math.ceil(n), o = e[r], s = e[a], l = n - r;
            return i[0] = yt(St(o[0], s[0], l)), i[1] = yt(St(o[1], s[1], l)), i[2] = yt(St(o[2], s[2], l)), 
            i[3] = xt(St(o[3], s[3], l)), i;
        }
    }
    function Lt(t, e, i) {
        if (e && e.length && 0 <= t && t <= 1) {
            var n = t * (e.length - 1), r = Math.floor(n), a = Math.ceil(n), o = Ct(e[r]), s = Ct(e[a]), l = n - r, h = Ot([ yt(St(o[0], s[0], l)), yt(St(o[1], s[1], l)), yt(St(o[2], s[2], l)), xt(St(o[3], s[3], l)) ], "rgba");
            return i ? {
                color: h,
                leftIndex: r,
                rightIndex: a,
                value: n
            } : h;
        }
    }
    function Ot(t, e) {
        if (t && t.length) {
            var i = t[0] + "," + t[1] + "," + t[2];
            return ("rgba" === e || "hsva" === e || "hsla" === e) && (i += "," + t[3]), e + "(" + i + ")";
        }
    }
    function Et(t, e) {
        return t[e];
    }
    function zt(t, e, i) {
        t[e] = i;
    }
    function Bt(t, e, i) {
        return (e - t) * i + t;
    }
    function Rt(t, e, i) {
        return .5 < i ? e : t;
    }
    function Nt(t, e, i, n, r) {
        var a = t.length;
        if (1 == r) for (var o = 0; o < a; o++) n[o] = Bt(t[o], e[o], i); else {
            var s = a && t[0].length;
            for (o = 0; o < a; o++) for (var l = 0; l < s; l++) n[o][l] = Bt(t[o][l], e[o][l], i);
        }
    }
    function Ft(t, e, i) {
        var n = t.length, r = e.length;
        if (n !== r) if (r < n) t.length = r; else for (var a = n; a < r; a++) t.push(1 === i ? e[a] : Ch.call(e[a]));
        var o = t[0] && t[0].length;
        for (a = 0; a < t.length; a++) if (1 === i) isNaN(t[a]) && (t[a] = e[a]); else for (var s = 0; s < o; s++) isNaN(t[a][s]) && (t[a][s] = e[a][s]);
    }
    function Gt(t, e, i) {
        if (t === e) return !0;
        var n = t.length;
        if (n !== e.length) return !1;
        if (1 === i) {
            for (var r = 0; r < n; r++) if (t[r] !== e[r]) return !1;
        } else {
            var a = t[0].length;
            for (r = 0; r < n; r++) for (var o = 0; o < a; o++) if (t[r][o] !== e[r][o]) return !1;
        }
        return !0;
    }
    function Vt(t, e, i, n, r, a, o, s, l) {
        var h = t.length;
        if (1 == l) for (var u = 0; u < h; u++) s[u] = Ht(t[u], e[u], i[u], n[u], r, a, o); else {
            var c = t[0].length;
            for (u = 0; u < h; u++) for (var d = 0; d < c; d++) s[u][d] = Ht(t[u][d], e[u][d], i[u][d], n[u][d], r, a, o);
        }
    }
    function Ht(t, e, i, n, r, a, o) {
        var s = .5 * (i - t), l = .5 * (n - e);
        return (2 * (e - i) + s + l) * o + (-3 * (e - i) - 2 * s - l) * a + s * r + e;
    }
    function Wt(t) {
        if (E(t)) {
            var e = t.length;
            if (E(t[0])) {
                for (var i = [], n = 0; n < e; n++) i.push(Ch.call(t[n]));
                return i;
            }
            return Ch.call(t);
        }
        return t;
    }
    function Xt(t) {
        return t[0] = Math.floor(t[0]), t[1] = Math.floor(t[1]), t[2] = Math.floor(t[2]), 
        "rgba(" + t.join(",") + ")";
    }
    function qt(t, e, i, n, a, r) {
        var o, s, l = t._getter, h = t._setter, u = "spline" === e, c = n.length;
        if (c) {
            var d, f = E(n[0].value), p = !1, g = !1, m = f ? E((s = (o = n)[o.length - 1].value) && s[0]) ? 2 : 1 : 0;
            n.sort(function(t, e) {
                return t.time - e.time;
            }), d = n[c - 1].time;
            for (var v = [], y = [], x = n[0].value, _ = !0, w = 0; w < c; w++) {
                v.push(n[w].time / d);
                var b = n[w].value;
                if (f && Gt(b, x, m) || !f && b === x || (_ = !1), "string" == typeof (x = b)) {
                    var S = Ct(b);
                    S ? (b = S, p = !0) : g = !0;
                }
                y.push(b);
            }
            if (r || !_) {
                var M = y[c - 1];
                for (w = 0; w < c - 1; w++) f ? Ft(y[w], M, m) : !isNaN(y[w]) || isNaN(M) || g || p || (y[w] = M);
                f && Ft(l(t._target, a), M, m);
                var I, T, C, D, A, k = 0, P = 0;
                if (p) var L = [ 0, 0, 0, 0 ];
                var O = new vt({
                    target: t._target,
                    life: d,
                    loop: t._loop,
                    delay: t._delay,
                    onframe: function(t, e) {
                        var i;
                        if (e < 0) i = 0; else if (e < P) {
                            for (i = Math.min(k + 1, c - 1); 0 <= i && !(v[i] <= e); i--) ;
                            i = Math.min(i, c - 2);
                        } else {
                            for (i = k; i < c && !(v[i] > e); i++) ;
                            i = Math.min(i - 1, c - 2);
                        }
                        P = e;
                        var n = v[(k = i) + 1] - v[i];
                        if (0 !== n) if (I = (e - v[i]) / n, u) if (C = y[i], T = y[0 === i ? i : i - 1], 
                        D = y[c - 2 < i ? c - 1 : i + 1], A = y[c - 3 < i ? c - 1 : i + 2], f) Vt(T, C, D, A, I, I * I, I * I * I, l(t, a), m); else {
                            if (p) r = Vt(T, C, D, A, I, I * I, I * I * I, L, 1), r = Xt(L); else {
                                if (g) return Rt(C, D, I);
                                r = Ht(T, C, D, A, I, I * I, I * I * I);
                            }
                            h(t, a, r);
                        } else if (f) Nt(y[i], y[i + 1], I, l(t, a), m); else {
                            var r;
                            if (p) Nt(y[i], y[i + 1], I, L, 1), r = Xt(L); else {
                                if (g) return Rt(y[i], y[i + 1], I);
                                r = Bt(y[i], y[i + 1], I);
                            }
                            h(t, a, r);
                        }
                    },
                    ondestroy: i
                });
                return e && "spline" !== e && (O.easing = e), O;
            }
        }
    }
    function jt(t, e, i, n, r, a, o, s) {
        function l() {
            --u || a && a();
        }
        M(n) ? (a = r, r = n, n = 0) : v(r) ? (a = r, r = "linear", n = 0) : v(n) ? (a = n, 
        n = 0) : v(i) ? (a = i, i = 500) : i || (i = 500), t.stopAnimation(), function t(e, i, n, r, a, o, s) {
            var l = {}, h = 0;
            for (var u in r) r.hasOwnProperty(u) && (null != n[u] ? L(r[u]) && !E(r[u]) ? t(e, i ? i + "." + u : u, n[u], r[u], a, o, s) : (s ? (l[u] = n[u], 
            Ut(e, i, u, r[u])) : l[u] = r[u], h++) : null == r[u] || s || Ut(e, i, u, r[u]));
            0 < h && e.animate(i, !1).when(null == a ? 500 : a, l).delay(o || 0);
        }(t, "", t, e, i, n, s);
        var h = t.animators.slice(), u = h.length;
        u || a && a();
        for (var c = 0; c < h.length; c++) h[c].done(l).start(r, o);
    }
    function Ut(t, e, i, n) {
        if (e) {
            var r = {};
            r[e] = {}, r[e][i] = n, t.attr(r);
        } else t.attr(i, n);
    }
    function Yt(t, e, i, n) {
        i < 0 && (t += i, i = -i), n < 0 && (e += n, n = -n), this.x = t, this.y = e, this.width = i, 
        this.height = n;
    }
    function Zt(t, e, i, n) {
        var r = e + 1;
        if (r === i) return 1;
        if (n(t[r++], t[e]) < 0) {
            for (;r < i && n(t[r], t[r - 1]) < 0; ) r++;
            !function(t, e, i) {
                for (i--; e < i; ) {
                    var n = t[e];
                    t[e++] = t[i], t[i--] = n;
                }
            }(t, e, r);
        } else for (;r < i && 0 <= n(t[r], t[r - 1]); ) r++;
        return r - e;
    }
    function $t(t, e, i, n, r) {
        for (n === e && n++; n < i; n++) {
            for (var a, o = t[n], s = e, l = n; s < l; ) r(o, t[a = s + l >>> 1]) < 0 ? l = a : s = a + 1;
            var h = n - s;
            switch (h) {
              case 3:
                t[s + 3] = t[s + 2];

              case 2:
                t[s + 2] = t[s + 1];

              case 1:
                t[s + 1] = t[s];
                break;

              default:
                for (;0 < h; ) t[s + h] = t[s + h - 1], h--;
            }
            t[s] = o;
        }
    }
    function Kt(t, e, i, n, r, a) {
        var o = 0, s = 0, l = 1;
        if (0 < a(t, e[i + r])) {
            for (s = n - r; l < s && 0 < a(t, e[i + r + l]); ) (l = 1 + ((o = l) << 1)) <= 0 && (l = s);
            s < l && (l = s), o += r, l += r;
        } else {
            for (s = r + 1; l < s && a(t, e[i + r - l]) <= 0; ) (l = 1 + ((o = l) << 1)) <= 0 && (l = s);
            s < l && (l = s);
            var h = o;
            o = r - l, l = r - h;
        }
        for (o++; o < l; ) {
            var u = o + (l - o >>> 1);
            0 < a(t, e[i + u]) ? o = u + 1 : l = u;
        }
        return l;
    }
    function Qt(t, e, i, n, r, a) {
        var o = 0, s = 0, l = 1;
        if (a(t, e[i + r]) < 0) {
            for (s = r + 1; l < s && a(t, e[i + r - l]) < 0; ) (l = 1 + ((o = l) << 1)) <= 0 && (l = s);
            s < l && (l = s);
            var h = o;
            o = r - l, l = r - h;
        } else {
            for (s = n - r; l < s && 0 <= a(t, e[i + r + l]); ) (l = 1 + ((o = l) << 1)) <= 0 && (l = s);
            s < l && (l = s), o += r, l += r;
        }
        for (o++; o < l; ) {
            var u = o + (l - o >>> 1);
            a(t, e[i + u]) < 0 ? l = u : o = u + 1;
        }
        return l;
    }
    function Jt(p, g) {
        function e(t) {
            var e = o[t], i = s[t], n = o[t + 1], r = s[t + 1];
            s[t] = i + r, t === l - 3 && (o[t + 1] = o[t + 2], s[t + 1] = s[t + 2]), l--;
            var a = Qt(p[n], p, e, i, 0, g);
            e += a, 0 !== (i -= a) && (0 !== (r = Kt(p[e + i - 1], p, n, r, r - 1, g)) && (i <= r ? function(t, e, i, n) {
                var r = 0;
                for (r = 0; r < e; r++) v[r] = p[t + r];
                var a = 0, o = i, s = t;
                if (p[s++] = p[o++], 0 != --n) {
                    if (1 === e) {
                        for (r = 0; r < n; r++) p[s + r] = p[o + r];
                        return p[s + n] = v[a];
                    }
                    for (var l, h, u, c = m; ;) {
                        h = l = 0, u = !1;
                        do {
                            if (g(p[o], v[a]) < 0) {
                                if (p[s++] = p[o++], h++, (l = 0) == --n) {
                                    u = !0;
                                    break;
                                }
                            } else if (p[s++] = v[a++], l++, h = 0, 1 == --e) {
                                u = !0;
                                break;
                            }
                        } while ((l | h) < c);
                        if (u) break;
                        do {
                            if (0 !== (l = Qt(p[o], v, a, e, 0, g))) {
                                for (r = 0; r < l; r++) p[s + r] = v[a + r];
                                if (s += l, a += l, (e -= l) <= 1) {
                                    u = !0;
                                    break;
                                }
                            }
                            if (p[s++] = p[o++], 0 == --n) {
                                u = !0;
                                break;
                            }
                            if (0 !== (h = Kt(v[a], p, o, n, 0, g))) {
                                for (r = 0; r < h; r++) p[s + r] = p[o + r];
                                if (s += h, o += h, 0 === (n -= h)) {
                                    u = !0;
                                    break;
                                }
                            }
                            if (p[s++] = v[a++], 1 == --e) {
                                u = !0;
                                break;
                            }
                            c--;
                        } while (Xh <= l || Xh <= h);
                        if (u) break;
                        c < 0 && (c = 0), c += 2;
                    }
                    if ((m = c) < 1 && (m = 1), 1 === e) {
                        for (r = 0; r < n; r++) p[s + r] = p[o + r];
                        p[s + n] = v[a];
                    } else {
                        if (0 === e) throw new Error();
                        for (r = 0; r < e; r++) p[s + r] = v[a + r];
                    }
                } else for (r = 0; r < e; r++) p[s + r] = v[a + r];
            }(e, i, n, r) : function(t, e, i, n) {
                var r = 0;
                for (r = 0; r < n; r++) v[r] = p[i + r];
                var a = t + e - 1, o = n - 1, s = i + n - 1, l = 0, h = 0;
                if (p[s--] = p[a--], 0 != --e) {
                    if (1 === n) {
                        for (h = (s -= e) + 1, l = (a -= e) + 1, r = e - 1; 0 <= r; r--) p[h + r] = p[l + r];
                        return p[s] = v[o];
                    }
                    for (var u = m; ;) {
                        var c = 0, d = 0, f = !1;
                        do {
                            if (g(v[o], p[a]) < 0) {
                                if (p[s--] = p[a--], c++, (d = 0) == --e) {
                                    f = !0;
                                    break;
                                }
                            } else if (p[s--] = v[o--], d++, c = 0, 1 == --n) {
                                f = !0;
                                break;
                            }
                        } while ((c | d) < u);
                        if (f) break;
                        do {
                            if (0 !== (c = e - Qt(v[o], p, t, e, e - 1, g))) {
                                for (e -= c, h = (s -= c) + 1, l = (a -= c) + 1, r = c - 1; 0 <= r; r--) p[h + r] = p[l + r];
                                if (0 === e) {
                                    f = !0;
                                    break;
                                }
                            }
                            if (p[s--] = v[o--], 1 == --n) {
                                f = !0;
                                break;
                            }
                            if (0 !== (d = n - Kt(p[a], v, 0, n, n - 1, g))) {
                                for (n -= d, h = (s -= d) + 1, l = (o -= d) + 1, r = 0; r < d; r++) p[h + r] = v[l + r];
                                if (n <= 1) {
                                    f = !0;
                                    break;
                                }
                            }
                            if (p[s--] = p[a--], 0 == --e) {
                                f = !0;
                                break;
                            }
                            u--;
                        } while (Xh <= c || Xh <= d);
                        if (f) break;
                        u < 0 && (u = 0), u += 2;
                    }
                    if ((m = u) < 1 && (m = 1), 1 === n) {
                        for (h = (s -= e) + 1, l = (a -= e) + 1, r = e - 1; 0 <= r; r--) p[h + r] = p[l + r];
                        p[s] = v[o];
                    } else {
                        if (0 === n) throw new Error();
                        for (l = s - (n - 1), r = 0; r < n; r++) p[l + r] = v[r];
                    }
                } else for (l = s - (n - 1), r = 0; r < n; r++) p[l + r] = v[r];
            }(e, i, n, r)));
        }
        var o, s, m = Xh, l = 0, v = [];
        o = [], s = [], this.mergeRuns = function() {
            for (;1 < l; ) {
                var t = l - 2;
                if (1 <= t && s[t - 1] <= s[t] + s[t + 1] || 2 <= t && s[t - 2] <= s[t] + s[t - 1]) s[t - 1] < s[t + 1] && t--; else if (s[t] > s[t + 1]) break;
                e(t);
            }
        }, this.forceMergeRuns = function() {
            for (;1 < l; ) {
                var t = l - 2;
                0 < t && s[t - 1] < s[t + 1] && t--, e(t);
            }
        }, this.pushRun = function(t, e) {
            o[l] = t, s[l] = e, l += 1;
        };
    }
    function te(t, e, i, n) {
        i || (i = 0), n || (n = t.length);
        var r = n - i;
        if (!(r < 2)) {
            var a = 0;
            if (r < Wh) return void $t(t, i, n, i + (a = Zt(t, i, n, e)), e);
            var o = new Jt(t, e), s = function(t) {
                for (var e = 0; Wh <= t; ) e |= 1 & t, t >>= 1;
                return t + e;
            }(r);
            do {
                if ((a = Zt(t, i, n, e)) < s) {
                    var l = r;
                    s < l && (l = s), $t(t, i, i + l, i + a, e), a = l;
                }
                o.pushRun(i, a), o.mergeRuns(), r -= a, i += a;
            } while (0 !== r);
            o.forceMergeRuns();
        }
    }
    function ee(t, e) {
        return t.zlevel === e.zlevel ? t.z === e.z ? t.z2 - e.z2 : t.z - e.z : t.zlevel - e.zlevel;
    }
    function ie(t, e, i) {
        var n = null == e.x ? 0 : e.x, r = null == e.x2 ? 1 : e.x2, a = null == e.y ? 0 : e.y, o = null == e.y2 ? 0 : e.y2;
        return e.global || (n = n * i.width + i.x, r = r * i.width + i.x, a = a * i.height + i.y, 
        o = o * i.height + i.y), n = isNaN(n) ? 0 : n, r = isNaN(r) ? 1 : r, a = isNaN(a) ? 0 : a, 
        o = isNaN(o) ? 0 : o, t.createLinearGradient(n, a, r, o);
    }
    function ne(t, e, i) {
        var n = i.width, r = i.height, a = Math.min(n, r), o = null == e.x ? .5 : e.x, s = null == e.y ? .5 : e.y, l = null == e.r ? .5 : e.r;
        return e.global || (o = o * n + i.x, s = s * r + i.y, l *= a), t.createRadialGradient(o, s, 0, o, s, l);
    }
    function re() {
        return !1;
    }
    function ae(t, e, i) {
        var n = Wl(), r = e.getWidth(), a = e.getHeight(), o = n.style;
        return o && (o.position = "absolute", o.left = 0, o.top = 0, o.width = r + "px", 
        o.height = a + "px", n.setAttribute("data-zr-dom-id", t)), n.width = r * i, n.height = a * i, 
        n;
    }
    function oe(t) {
        if ("string" == typeof t) {
            var e = iu.get(t);
            return e && e.image;
        }
        return t;
    }
    function se(t, e, i, n, r) {
        if (t) {
            if ("string" == typeof t) {
                if (e && e.__zrImageSrc === t || !i) return e;
                var a = iu.get(t), o = {
                    hostEl: i,
                    cb: n,
                    cbPayload: r
                };
                return a ? !he(e = a.image) && a.pending.push(o) : (!e && (e = new Image()), e.onload = e.onerror = le, 
                iu.put(t, e.__cachedImgObj = {
                    image: e,
                    pending: [ o ]
                }), e.src = e.__zrImageSrc = t), e;
            }
            return t;
        }
        return e;
    }
    function le() {
        var t = this.__cachedImgObj;
        this.onload = this.onerror = this.__cachedImgObj = null;
        for (var e = 0; e < t.pending.length; e++) {
            var i = t.pending[e], n = i.cb;
            n && n(this, i.cbPayload), i.hostEl.dirty();
        }
        t.pending.length = 0;
    }
    function he(t) {
        return t && t.width && t.height;
    }
    function ue(t, e) {
        var i, n, r = t + ":" + (e = e || su);
        if (nu[r]) return nu[r];
        for (var a = (t + "").split("\n"), o = 0, s = 0, l = a.length; s < l; s++) o = Math.max((i = a[s], 
        n = e, lu.measureText(i, n)).width, o);
        return au < ru && (ru = 0, nu = {}), ru++, nu[r] = o;
    }
    function ce(t, e, i, n, r, a, o) {
        return a ? (l = n, h = _e(t, {
            rich: a,
            truncate: o,
            font: e,
            textAlign: s = i,
            textPadding: r
        }), u = h.outerWidth, c = h.outerHeight, d = de(0, u, s), f = fe(0, c, l), new Yt(d, f, u, c)) : function(t, e, i, n, r, a) {
            var o = xe(t, e, r, a), s = ue(t, e);
            r && (s += r[1] + r[3]);
            var l = o.outerHeight, h = de(0, s, i), u = fe(0, l, n), c = new Yt(h, u, s, l);
            return c.lineHeight = o.lineHeight, c;
        }(t, e, i, n, r, o);
        var s, l, h, u, c, d, f;
    }
    function de(t, e, i) {
        return "right" === i ? t -= e : "center" === i && (t -= e / 2), t;
    }
    function fe(t, e, i) {
        return "middle" === i ? t -= e / 2 : "bottom" === i && (t -= e), t;
    }
    function pe(t, e, i, n, r) {
        if (!e) return "";
        var a = (t + "").split("\n");
        r = ge(e, i, n, r);
        for (var o = 0, s = a.length; o < s; o++) a[o] = me(a[o], r);
        return a.join("\n");
    }
    function ge(t, e, i, n) {
        (n = A({}, n)).font = e;
        i = O(i, "...");
        n.maxIterations = O(n.maxIterations, 2);
        var r = n.minChar = O(n.minChar, 0);
        n.cnCharWidth = ue("国", e);
        var a = n.ascCharWidth = ue("a", e);
        n.placeholder = O(n.placeholder, "");
        for (var o = t = Math.max(0, t - 1), s = 0; s < r && a <= o; s++) o -= a;
        var l = ue(i);
        return o < l && (i = "", l = 0), o = t - l, n.ellipsis = i, n.ellipsisWidth = l, 
        n.contentWidth = o, n.containerWidth = t, n;
    }
    function me(t, e) {
        var i = e.containerWidth, n = e.font, r = e.contentWidth;
        if (!i) return "";
        var a = ue(t, n);
        if (a <= i) return t;
        for (var o = 0; ;o++) {
            if (a <= r || o >= e.maxIterations) {
                t += e.ellipsis;
                break;
            }
            var s = 0 === o ? ve(t, r, e.ascCharWidth, e.cnCharWidth) : 0 < a ? Math.floor(t.length * r / a) : 0;
            a = ue(t = t.substr(0, s), n);
        }
        return "" === t && (t = e.placeholder), t;
    }
    function ve(t, e, i, n) {
        for (var r = 0, a = 0, o = t.length; a < o && r < e; a++) {
            var s = t.charCodeAt(a);
            r += 0 <= s && s <= 127 ? i : n;
        }
        return a;
    }
    function ye(t) {
        return ue("国", t);
    }
    function xe(t, e, i, n) {
        null != t && (t += "");
        var r = ye(e), a = t ? t.split("\n") : [], o = a.length * r, s = o;
        if (i && (s += i[0] + i[2]), t && n) {
            var l = n.outerHeight, h = n.outerWidth;
            if (null != l && l < s) t = "", a = []; else if (null != h) for (var u = ge(h - (i ? i[1] + i[3] : 0), e, n.ellipsis, {
                minChar: n.minChar,
                placeholder: n.placeholder
            }), c = 0, d = a.length; c < d; c++) a[c] = me(a[c], u);
        }
        return {
            lines: a,
            height: o,
            outerHeight: s,
            lineHeight: r
        };
    }
    function _e(t, e) {
        var i = {
            lines: [],
            width: 0,
            height: 0
        };
        if (null != t && (t += ""), !t) return i;
        for (var n, r = ou.lastIndex = 0; null != (n = ou.exec(t)); ) {
            var a = n.index;
            r < a && we(i, t.substring(r, a)), we(i, n[2], n[1]), r = ou.lastIndex;
        }
        r < t.length && we(i, t.substring(r, t.length));
        var o = i.lines, s = 0, l = 0, h = [], u = e.textPadding, c = e.truncate, d = c && c.outerWidth, f = c && c.outerHeight;
        u && (null != d && (d -= u[1] + u[3]), null != f && (f -= u[0] + u[2]));
        for (var p = 0; p < o.length; p++) {
            for (var g = o[p], m = 0, v = 0, y = 0; y < g.tokens.length; y++) {
                var x = (A = g.tokens[y]).styleName && e.rich[A.styleName] || {}, _ = A.textPadding = x.textPadding, w = A.font = x.font || e.font, b = A.textHeight = O(x.textHeight, ye(w));
                if (_ && (b += _[0] + _[2]), A.height = b, A.lineHeight = z(x.textLineHeight, e.textLineHeight, b), 
                A.textAlign = x && x.textAlign || e.textAlign, A.textVerticalAlign = x && x.textVerticalAlign || "middle", 
                null != f && s + A.lineHeight > f) return {
                    lines: [],
                    width: 0,
                    height: 0
                };
                A.textWidth = ue(A.text, w);
                var S = x.textWidth, M = null == S || "auto" === S;
                if ("string" == typeof S && "%" === S.charAt(S.length - 1)) A.percentWidth = S, 
                h.push(A), S = 0; else {
                    if (M) {
                        S = A.textWidth;
                        var I = x.textBackgroundColor, T = I && I.image;
                        T && (he(T = oe(T)) && (S = Math.max(S, T.width * b / T.height)));
                    }
                    var C = _ ? _[1] + _[3] : 0;
                    S += C;
                    var D = null != d ? d - v : null;
                    null != D && D < S && (!M || D < C ? (A.text = "", A.textWidth = S = 0) : (A.text = pe(A.text, D - C, w, c.ellipsis, {
                        minChar: c.minChar
                    }), A.textWidth = ue(A.text, w), S = A.textWidth + C));
                }
                v += A.width = S, x && (m = Math.max(m, A.lineHeight));
            }
            g.width = v, s += g.lineHeight = m, l = Math.max(l, v);
        }
        i.outerWidth = i.width = O(e.textWidth, l), i.outerHeight = i.height = O(e.textHeight, s), 
        u && (i.outerWidth += u[1] + u[3], i.outerHeight += u[0] + u[2]);
        for (p = 0; p < h.length; p++) {
            var A, k = (A = h[p]).percentWidth;
            A.width = parseInt(k, 10) / 100 * l;
        }
        return i;
    }
    function we(t, e, i) {
        for (var n = "" === e, r = e.split("\n"), a = t.lines, o = 0; o < r.length; o++) {
            var s = r[o], l = {
                styleName: i,
                text: s,
                isLineHolder: !s && !n
            };
            if (o) a.push({
                tokens: [ l ]
            }); else {
                var h = (a[a.length - 1] || (a[0] = {
                    tokens: []
                })).tokens, u = h.length;
                1 === u && h[0].isLineHolder ? h[0] = l : (s || !u || n) && h.push(l);
            }
        }
    }
    function be(t, e) {
        var i, n, r, a, o, s = e.x, l = e.y, h = e.width, u = e.height, c = e.r;
        h < 0 && (s += h, h = -h), u < 0 && (l += u, u = -u), "number" == typeof c ? i = n = r = a = c : c instanceof Array ? 1 === c.length ? i = n = r = a = c[0] : 2 === c.length ? (i = r = c[0], 
        n = a = c[1]) : 3 === c.length ? (i = c[0], n = a = c[1], r = c[2]) : (i = c[0], 
        n = c[1], r = c[2], a = c[3]) : i = n = r = a = 0, h < i + n && (i *= h / (o = i + n), 
        n *= h / o), h < r + a && (r *= h / (o = r + a), a *= h / o), u < n + r && (n *= u / (o = n + r), 
        r *= u / o), u < i + a && (i *= u / (o = i + a), a *= u / o), t.moveTo(s + i, l), 
        t.lineTo(s + h - n, l), 0 !== n && t.arc(s + h - n, l + n, n, -Math.PI / 2, 0), 
        t.lineTo(s + h, l + u - r), 0 !== r && t.arc(s + h - r, l + u - r, r, 0, Math.PI / 2), 
        t.lineTo(s + a, l + u), 0 !== a && t.arc(s + a, l + u - a, a, Math.PI / 2, Math.PI), 
        t.lineTo(s, l + i), 0 !== i && t.arc(s + i, l + i, i, Math.PI, 1.5 * Math.PI);
    }
    function Se(t) {
        return Me(t), R(t.rich, Me), t;
    }
    function Me(t) {
        if (t) {
            t.font = (r = ((n = t).fontSize || n.fontFamily) && [ n.fontStyle, n.fontWeight, (n.fontSize || 12) + "px", n.fontFamily || "sans-serif" ].join(" ")) && f(r) || n.textFont || n.font;
            var e = t.textAlign;
            "middle" === e && (e = "center"), t.textAlign = null == e || hu[e] ? e : "left";
            var i = t.textVerticalAlign || t.textBaseline;
            "center" === i && (i = "middle"), t.textVerticalAlign = null == i || uu[i] ? i : "top", 
            t.textPadding && (t.textPadding = h(t.textPadding));
        }
        var n, r;
    }
    function Ie(t, e, i, n, r, a) {
        var o, s, l, h, u, c;
        n.rich ? (s = e, l = i, h = n, u = r, (!(c = (o = t).__textCotentBlock) || o.__dirtyText) && (c = o.__textCotentBlock = _e(l, h)), 
        function(t, e, i, n, r) {
            var a = i.width, o = i.outerWidth, s = i.outerHeight, l = n.textPadding, h = Pe(s, n, r), u = h.baseX, c = h.baseY, d = h.textAlign, f = h.textVerticalAlign;
            Te(e, n, r, u, c);
            var p = de(u, o, d), g = fe(c, s, f), m = p, v = g;
            l && (m += l[3], v += l[0]);
            var y = m + a;
            De(n) && Ae(t, e, n, p, g, o, s);
            for (var x = 0; x < i.lines.length; x++) {
                for (var _, w = i.lines[x], b = w.tokens, S = b.length, M = w.lineHeight, I = w.width, T = 0, C = m, D = y, A = S - 1; T < S && (!(_ = b[T]).textAlign || "left" === _.textAlign); ) Ce(t, e, _, n, M, v, C, "left"), 
                I -= _.width, C += _.width, T++;
                for (;0 <= A && "right" === (_ = b[A]).textAlign; ) Ce(t, e, _, n, M, v, D, "right"), 
                I -= _.width, D -= _.width, A--;
                for (C += (a - (C - m) - (y - D) - I) / 2; T <= A; ) _ = b[T], Ce(t, e, _, n, M, v, C + _.width / 2, "center"), 
                C += _.width, T++;
                v += M;
            }
        }(o, s, c, h, u)) : function(t, e, i, n, r, a) {
            var o = a && a.style, s = o && "text" === a.type, l = n.font || su;
            s && l === (o.font || su) || (e.font = l);
            var h = t.__computedFont;
            t.__styleFont !== l && (t.__styleFont = l, h = t.__computedFont = e.font);
            var u = n.textPadding, c = t.__textCotentBlock;
            (!c || t.__dirtyText) && (c = t.__textCotentBlock = xe(i, h, u, n.truncate));
            var d = c.outerHeight, f = c.lines, p = c.lineHeight, g = Pe(d, n, r), m = g.baseX, v = g.baseY, y = g.textAlign || "left", x = g.textVerticalAlign;
            Te(e, n, r, m, v);
            var _ = fe(v, d, x), w = m, b = _, S = De(n);
            if (S || u) {
                var M = ue(i, h), I = M;
                u && (I += u[1] + u[3]);
                var T = de(m, I, y);
                S && Ae(t, e, n, T, _, I, d), u && (w = Be(m, y, u), b += u[0]);
            }
            e.textAlign = y, e.textBaseline = "middle";
            for (var C = 0; C < cu.length; C++) {
                var D = cu[C], A = D[0], k = D[1], P = n[A];
                s && P === o[A] || (e[k] = Uh(e, k, P || D[2]));
            }
            b += p / 2;
            var L = n.textStrokeWidth, O = s ? o.textStrokeWidth : null, E = !s || L !== O, z = !s || E || n.textStroke !== o.textStroke, B = Oe(n.textStroke, L), R = Ee(n.textFill);
            if (B && (E && (e.lineWidth = L), z && (e.strokeStyle = B)), R && (!s || n.textFill !== o.textFill || o.textBackgroundColor) && (e.fillStyle = R), 
            1 === f.length) B && e.strokeText(f[0], w, b), R && e.fillText(f[0], w, b); else for (var C = 0; C < f.length; C++) B && e.strokeText(f[C], w, b), 
            R && e.fillText(f[C], w, b), b += p;
        }(t, e, i, n, r, a);
    }
    function Te(t, e, i, n, r) {
        if (i && e.textRotation) {
            var a = e.textOrigin;
            "center" === a ? (n = i.width / 2 + i.x, r = i.height / 2 + i.y) : a && (n = a[0] + i.x, 
            r = a[1] + i.y), t.translate(n, r), t.rotate(-e.textRotation), t.translate(-n, -r);
        }
    }
    function Ce(t, e, i, n, r, a, o, s) {
        var l = n.rich[i.styleName] || {};
        l.text = i.text;
        var h = i.textVerticalAlign, u = a + r / 2;
        "top" === h ? u = a + i.height / 2 : "bottom" === h && (u = a + r - i.height / 2), 
        !i.isLineHolder && De(l) && Ae(t, e, l, "right" === s ? o - i.width : "center" === s ? o - i.width / 2 : o, u - i.height / 2, i.width, i.height);
        var c = i.textPadding;
        c && (o = Be(o, s, c), u -= i.height / 2 - c[2] - i.textHeight / 2), Le(e, "shadowBlur", z(l.textShadowBlur, n.textShadowBlur, 0)), 
        Le(e, "shadowColor", l.textShadowColor || n.textShadowColor || "transparent"), Le(e, "shadowOffsetX", z(l.textShadowOffsetX, n.textShadowOffsetX, 0)), 
        Le(e, "shadowOffsetY", z(l.textShadowOffsetY, n.textShadowOffsetY, 0)), Le(e, "textAlign", s), 
        Le(e, "textBaseline", "middle"), Le(e, "font", i.font || su);
        var d = Oe(l.textStroke || n.textStroke, p), f = Ee(l.textFill || n.textFill), p = O(l.textStrokeWidth, n.textStrokeWidth);
        d && (Le(e, "lineWidth", p), Le(e, "strokeStyle", d), e.strokeText(i.text, o, u)), 
        f && (Le(e, "fillStyle", f), e.fillText(i.text, o, u));
    }
    function De(t) {
        return t.textBackgroundColor || t.textBorderWidth && t.textBorderColor;
    }
    function Ae(t, e, i, n, r, a, o) {
        var s = i.textBackgroundColor, l = i.textBorderWidth, h = i.textBorderColor, u = M(s);
        if (Le(e, "shadowBlur", i.textBoxShadowBlur || 0), Le(e, "shadowColor", i.textBoxShadowColor || "transparent"), 
        Le(e, "shadowOffsetX", i.textBoxShadowOffsetX || 0), Le(e, "shadowOffsetY", i.textBoxShadowOffsetY || 0), 
        u || l && h) {
            e.beginPath();
            var c = i.textBorderRadius;
            c ? be(e, {
                x: n,
                y: r,
                width: a,
                height: o,
                r: c
            }) : e.rect(n, r, a, o), e.closePath();
        }
        if (u) if (Le(e, "fillStyle", s), null != i.fillOpacity) {
            var d = e.globalAlpha;
            e.globalAlpha = i.fillOpacity * i.opacity, e.fill(), e.globalAlpha = d;
        } else e.fill(); else if (v(s)) Le(e, "fillStyle", s(i)), e.fill(); else if (L(s)) {
            var f = s.image;
            (f = se(f, null, t, ke, s)) && he(f) && e.drawImage(f, n, r, a, o);
        }
        if (l && h) if (Le(e, "lineWidth", l), Le(e, "strokeStyle", h), null != i.strokeOpacity) {
            d = e.globalAlpha;
            e.globalAlpha = i.strokeOpacity * i.opacity, e.stroke(), e.globalAlpha = d;
        } else e.stroke();
    }
    function ke(t, e) {
        e.image = t;
    }
    function Pe(t, e, i) {
        var n = e.x || 0, r = e.y || 0, a = e.textAlign, o = e.textVerticalAlign;
        if (i) {
            var s = e.textPosition;
            if (s instanceof Array) n = i.x + ze(s[0], i.width), r = i.y + ze(s[1], i.height); else {
                var l = function(t, e, i) {
                    var n = e.x, r = e.y, a = e.height, o = e.width, s = a / 2, l = "left", h = "top";
                    switch (t) {
                      case "left":
                        n -= i, r += s, l = "right", h = "middle";
                        break;

                      case "right":
                        n += i + o, r += s, h = "middle";
                        break;

                      case "top":
                        n += o / 2, r -= i, l = "center", h = "bottom";
                        break;

                      case "bottom":
                        n += o / 2, r += a + i, l = "center";
                        break;

                      case "inside":
                        n += o / 2, r += s, l = "center", h = "middle";
                        break;

                      case "insideLeft":
                        n += i, r += s, h = "middle";
                        break;

                      case "insideRight":
                        n += o - i, r += s, l = "right", h = "middle";
                        break;

                      case "insideTop":
                        n += o / 2, r += i, l = "center";
                        break;

                      case "insideBottom":
                        n += o / 2, r += a - i, l = "center", h = "bottom";
                        break;

                      case "insideTopLeft":
                        n += i, r += i;
                        break;

                      case "insideTopRight":
                        n += o - i, r += i, l = "right";
                        break;

                      case "insideBottomLeft":
                        n += i, r += a - i, h = "bottom";
                        break;

                      case "insideBottomRight":
                        n += o - i, r += a - i, l = "right", h = "bottom";
                    }
                    return {
                        x: n,
                        y: r,
                        textAlign: l,
                        textVerticalAlign: h
                    };
                }(s, i, e.textDistance);
                n = l.x, r = l.y, a = a || l.textAlign, o = o || l.textVerticalAlign;
            }
            var h = e.textOffset;
            h && (n += h[0], r += h[1]);
        }
        return {
            baseX: n,
            baseY: r,
            textAlign: a,
            textVerticalAlign: o
        };
    }
    function Le(t, e, i) {
        return t[e] = Uh(t, e, i), t[e];
    }
    function Oe(t, e) {
        return null == t || e <= 0 || "transparent" === t || "none" === t ? null : t.image || t.colorStops ? "#000" : t;
    }
    function Ee(t) {
        return null == t || "none" === t ? null : t.image || t.colorStops ? "#000" : t;
    }
    function ze(t, e) {
        return "string" == typeof t ? 0 <= t.lastIndexOf("%") ? parseFloat(t) / 100 * e : parseFloat(t) : t;
    }
    function Be(t, e, i) {
        return "right" === e ? t - i[1] : "center" === e ? t + i[3] / 2 - i[1] / 2 : t + i[3];
    }
    function Re(t, e) {
        return null != t && (t || e.textBackgroundColor || e.textBorderWidth && e.textBorderColor || e.textPadding);
    }
    function Ne(t) {
        for (var e in t = t || {}, Eh.call(this, t), t) t.hasOwnProperty(e) && "style" !== e && (this[e] = t[e]);
        this.style = new Zh(t.style, this), this._rect = null, this.__clipPaths = [];
    }
    function Fe(t) {
        Ne.call(this, t);
    }
    function Ge(t) {
        return parseInt(t, 10);
    }
    function Ve(t) {
        var e = t[1][0] - t[0][0], i = t[1][1] - t[0][1];
        return Math.sqrt(e * e + i * i);
    }
    function He(t) {
        return "mousewheel" === t && Ll.browser.firefox ? "DOMMouseScroll" : t;
    }
    function We(t, e, i) {
        var n = t._gestureMgr;
        "start" === i && n.clear();
        var r = n.recognize(e, t.handler.findHover(e.zrX, e.zrY, null).target, t.dom);
        if ("end" === i && n.clear(), r) {
            var a = r.type;
            e.gestureEvent = a, t.handler.dispatchToElement({
                target: r.target
            }, a, r.event);
        }
    }
    function Xe(t) {
        t._touching = !0, clearTimeout(t._touchTimer), t._touchTimer = setTimeout(function() {
            t._touching = !1;
        }, 700);
    }
    function qe(t) {
        var e = t.pointerType;
        return "pen" === e || "touch" === e;
    }
    function je(a) {
        function t(t, r) {
            R(t, function(t) {
                var e, i, n;
                e = a, i = He(t), n = r._handlers[t], eh ? e.addEventListener(i, n) : e.attachEvent("on" + i, n);
            }, r);
        }
        var n;
        th.call(this), this.dom = a, this._touching = !1, this._touchTimer, this._gestureMgr = new xu(), 
        this._handlers = {}, n = this, R(bu, function(t) {
            n._handlers[t] = _(Iu[t], n);
        }), R(Mu, function(t) {
            n._handlers[t] = _(Iu[t], n);
        }), R(wu, function(t) {
            var e, i;
            n._handlers[t] = (e = Iu[t], i = n, function() {
                return i._touching ? void 0 : e.apply(i, arguments);
            });
        }), Ll.pointerEventsSupported ? t(Mu, this) : (Ll.touchEventsSupported && t(bu, this), 
        t(wu, this));
    }
    function Ue(t, e) {
        var i = new ku(Pl(), t, e);
        return Au[i.id] = i;
    }
    function Ye(t) {
        return t instanceof Array ? t : null == t ? [] : [ t ];
    }
    function Ze(t, e, i) {
        if (t) {
            t[e] = t[e] || {}, t.emphasis = t.emphasis || {}, t.emphasis[e] = t.emphasis[e] || {};
            for (var n = 0, r = i.length; n < r; n++) {
                var a = i[n];
                !t.emphasis[e].hasOwnProperty(a) && t[e].hasOwnProperty(a) && (t.emphasis[e][a] = t[e][a]);
            }
        }
    }
    function $e(t) {
        return !Ou(t) || Eu(t) || t instanceof Date ? t : t.value;
    }
    function Ke(t, r) {
        r = (r || []).slice();
        var a = D(t || [], function(t) {
            return {
                exist: t
            };
        });
        return Lu(r, function(t, e) {
            if (Ou(t)) {
                for (var i = 0; i < a.length; i++) if (!a[i].option && null != t.id && a[i].exist.id === t.id + "") return a[i].option = t, 
                void (r[e] = null);
                for (i = 0; i < a.length; i++) {
                    var n = a[i].exist;
                    if (!(a[i].option || null != n.id && null != t.id || null == t.name || Je(t) || Je(n) || n.name !== t.name + "")) return a[i].option = t, 
                    void (r[e] = null);
                }
            }
        }), Lu(r, function(t) {
            if (Ou(t)) {
                for (var e = 0; e < a.length; e++) {
                    var i = a[e].exist;
                    if (!a[e].option && !Je(i) && null == t.id) {
                        a[e].option = t;
                        break;
                    }
                }
                e >= a.length && a.push({
                    option: t
                });
            }
        }), a;
    }
    function Qe(t) {
        var e = t.name;
        return !(!e || !e.indexOf(zu));
    }
    function Je(t) {
        return Ou(t) && t.id && 0 === (t.id + "").indexOf("\0_ec_\0");
    }
    function ti(e, t) {
        return null != t.dataIndexInside ? t.dataIndexInside : null != t.dataIndex ? P(t.dataIndex) ? D(t.dataIndex, function(t) {
            return e.indexOfRawIndex(t);
        }) : e.indexOfRawIndex(t.dataIndex) : null != t.name ? P(t.name) ? D(t.name, function(t) {
            return e.indexOfName(t);
        }) : e.indexOfName(t.name) : void 0;
    }
    function ei() {
        var e = "__\0ec_inner_" + Ru++ + "_" + Math.random().toFixed(5);
        return function(t) {
            return t[e] || (t[e] = {});
        };
    }
    function ii(s, l, h) {
        if (M(l)) {
            var t = {};
            t[l + "Index"] = 0, l = t;
        }
        var e = h && h.defaultMainType;
        !e || ni(l, e + "Index") || ni(l, e + "Id") || ni(l, e + "Name") || (l[e + "Index"] = 0);
        var u = {};
        return Lu(l, function(t, e) {
            t = l[e];
            if ("dataIndex" !== e && "dataIndexInside" !== e) {
                var i = e.match(/^(\w+)(Index|Id|Name)$/) || [], n = i[1], r = (i[2] || "").toLowerCase();
                if (!(!n || !r || null == t || "index" === r && "none" === t || h && h.includeMainTypes && d(h.includeMainTypes, n) < 0)) {
                    var a = {
                        mainType: n
                    };
                    ("index" !== r || "all" !== t) && (a[r] = t);
                    var o = s.queryComponents(a);
                    u[n + "Models"] = o, u[n + "Model"] = o[0];
                }
            } else u[e] = t;
        }), u;
    }
    function ni(t, e) {
        return t && t.hasOwnProperty(e);
    }
    function ri(t, e, i) {
        t.setAttribute ? t.setAttribute(e, i) : t[e] = i;
    }
    function ai(t) {
        return "auto" === t ? Ll.domSupported ? "html" : "richText" : t || "html";
    }
    function oi(t) {
        var e = {
            main: "",
            sub: ""
        };
        return t && (t = t.split(Nu), e.main = t[0] || "", e.sub = t[1] || ""), e;
    }
    function si(t) {
        (t.$constructor = t).extend = function(t) {
            var e = this, i = function() {
                t.$constructor ? t.$constructor.apply(this, arguments) : e.apply(this, arguments);
            };
            return A(i.prototype, t), i.extend = this.extend, i.superCall = hi, i.superApply = ui, 
            a(i, this), i.superClass = e, i;
        };
    }
    function li(t) {
        var e = [ "__\0is_clz", Gu++, Math.random().toFixed(3) ].join("_");
        t.prototype[e] = !0, t.isInstance = function(t) {
            return !(!t || !t[e]);
        };
    }
    function hi(t, e) {
        var i = l(arguments, 2);
        return this.superClass.prototype[e].apply(t, i);
    }
    function ui(t, e, i) {
        return this.superClass.prototype[e].apply(t, i);
    }
    function ci(i, t) {
        t = t || {};
        var a = {};
        if (i.registerClass = function(t, e) {
            if (e) if (c(/^[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)?$/.test(r = e), 'componentType "' + r + '" illegal'), 
            (e = oi(e)).sub) {
                if (e.sub !== Fu) ((n = a[(i = e).main]) && n[Fu] || ((n = a[i.main] = {})[Fu] = !0), 
                n)[e.sub] = t;
            } else a[e.main] = t;
            var i, n, r;
            return t;
        }, i.getClass = function(t, e, i) {
            var n = a[t];
            if (n && n[Fu] && (n = e ? n[e] : null), i && !n) throw new Error(e ? "Component " + t + "." + (e || "") + " not exists. Load it first." : t + ".type should be specified.");
            return n;
        }, i.getClassesByMainType = function(t) {
            t = oi(t);
            var i = [], e = a[t.main];
            return e && e[Fu] ? R(e, function(t, e) {
                e !== Fu && i.push(t);
            }) : i.push(e), i;
        }, i.hasClass = function(t) {
            return t = oi(t), !!a[t.main];
        }, i.getAllClassMainTypes = function() {
            var i = [];
            return R(a, function(t, e) {
                i.push(e);
            }), i;
        }, i.hasSubTypes = function(t) {
            t = oi(t);
            var e = a[t.main];
            return e && e[Fu];
        }, i.parseClassType = oi, t.registerWhenExtend) {
            var n = i.extend;
            n && (i.extend = function(t) {
                var e = n.call(this, t);
                return i.registerClass(e, t.type);
            });
        }
        return i;
    }
    function di(t) {
        return -Yu < t && t < Yu;
    }
    function fi(t) {
        return Yu < t || t < -Yu;
    }
    function pi(t, e, i, n, r) {
        var a = 1 - r;
        return a * a * (a * t + 3 * r * e) + r * r * (r * n + 3 * a * i);
    }
    function gi(t, e, i, n, r) {
        var a = 1 - r;
        return 3 * (((e - t) * a + 2 * (i - e) * r) * a + (n - i) * r * r);
    }
    function mi(t, e, i, n, r) {
        var a = 6 * i - 12 * e + 6 * t, o = 9 * e + 3 * n - 3 * t - 9 * i, s = 3 * e - 3 * t, l = 0;
        if (di(o)) {
            if (fi(a)) 0 <= (u = -s / a) && u <= 1 && (r[l++] = u);
        } else {
            var h = a * a - 4 * o * s;
            if (di(h)) r[0] = -a / (2 * o); else if (0 < h) {
                var u, c = Uu(h), d = (-a - c) / (2 * o);
                0 <= (u = (-a + c) / (2 * o)) && u <= 1 && (r[l++] = u), 0 <= d && d <= 1 && (r[l++] = d);
            }
        }
        return l;
    }
    function vi(t, e, i, n, r, a) {
        var o = (e - t) * r + t, s = (i - e) * r + e, l = (n - i) * r + i, h = (s - o) * r + o, u = (l - s) * r + s, c = (u - h) * r + h;
        a[0] = t, a[1] = o, a[2] = h, a[3] = c, a[4] = c, a[5] = u, a[6] = l, a[7] = n;
    }
    function yi(t, e, i, n) {
        var r = 1 - n;
        return r * (r * t + 2 * n * e) + n * n * i;
    }
    function xi(t, e, i, n) {
        return 2 * ((1 - n) * (e - t) + n * (i - e));
    }
    function _i(t, e, i) {
        var n = t + i - 2 * e;
        return 0 === n ? .5 : (t - e) / n;
    }
    function wi(t, e, i, n, r) {
        var a = (e - t) * n + t, o = (i - e) * n + e, s = (o - a) * n + a;
        r[0] = t, r[1] = a, r[2] = s, r[3] = s, r[4] = o, r[5] = i;
    }
    function bi(t, e, i) {
        if (0 !== t.length) {
            var n, r = t[0], a = r[0], o = r[0], s = r[1], l = r[1];
            for (n = 1; n < t.length; n++) r = t[n], a = ec(a, r[0]), o = ic(o, r[0]), s = ec(s, r[1]), 
            l = ic(l, r[1]);
            e[0] = a, e[1] = s, i[0] = o, i[1] = l;
        }
    }
    function Si(t, e, i, n, r, a) {
        r[0] = ec(t, i), r[1] = ec(e, n), a[0] = ic(t, i), a[1] = ic(e, n);
    }
    function Mi(t, e, i, n, r, a, o, s, l, h) {
        var u, c = mi, d = pi, f = c(t, i, r, o, hc);
        for (l[0] = 1 / 0, l[1] = 1 / 0, h[0] = -1 / 0, h[1] = -1 / 0, u = 0; u < f; u++) {
            var p = d(t, i, r, o, hc[u]);
            l[0] = ec(p, l[0]), h[0] = ic(p, h[0]);
        }
        for (f = c(e, n, a, s, uc), u = 0; u < f; u++) {
            var g = d(e, n, a, s, uc[u]);
            l[1] = ec(g, l[1]), h[1] = ic(g, h[1]);
        }
        l[0] = ec(t, l[0]), h[0] = ic(t, h[0]), l[0] = ec(o, l[0]), h[0] = ic(o, h[0]), 
        l[1] = ec(e, l[1]), h[1] = ic(e, h[1]), l[1] = ec(s, l[1]), h[1] = ic(s, h[1]);
    }
    function Ii(t, e, i, n, r, a, o, s, l) {
        var h = K, u = Q, c = Math.abs(r - a);
        if (c % ac < 1e-4 && 1e-4 < c) return s[0] = t - i, s[1] = e - n, l[0] = t + i, 
        void (l[1] = e + n);
        if (oc[0] = rc(r) * i + t, oc[1] = nc(r) * n + e, sc[0] = rc(a) * i + t, sc[1] = nc(a) * n + e, 
        h(s, oc, sc), u(l, oc, sc), (r %= ac) < 0 && (r += ac), (a %= ac) < 0 && (a += ac), 
        a < r && !o ? a += ac : r < a && o && (r += ac), o) {
            var d = a;
            a = r, r = d;
        }
        for (var f = 0; f < a; f += Math.PI / 2) r < f && (lc[0] = rc(f) * i + t, lc[1] = nc(f) * n + e, 
        h(s, lc, s), u(l, lc, l));
    }
    function Ti(t, e, i, n, r, a, o) {
        if (0 === r) return !1;
        var s, l = r;
        if (e + l < o && n + l < o || o < e - l && o < n - l || t + l < a && i + l < a || a < t - l && a < i - l) return !1;
        if (t === i) return Math.abs(a - t) <= l / 2;
        var h = (s = (e - n) / (t - i)) * a - o + (t * n - i * e) / (t - i);
        return h * h / (s * s + 1) <= l / 2 * l / 2;
    }
    function Ci(t, e, i, n, r, a, o, s, l, h, u) {
        if (0 === l) return !1;
        var c = l;
        return !(e + c < u && n + c < u && a + c < u && s + c < u || u < e - c && u < n - c && u < a - c && u < s - c || t + c < h && i + c < h && r + c < h && o + c < h || h < t - c && h < i - c && h < r - c && h < o - c) && function(t, e, i, n, r, a, o, s, l, h, u) {
            var c, d, f, p, g, m = .005, v = 1 / 0;
            Qu[0] = l, Qu[1] = h;
            for (var y = 0; y < 1; y += .05) Ju[0] = pi(t, i, r, o, y), Ju[1] = pi(e, n, a, s, y), 
            (p = Kl(Qu, Ju)) < v && (c = y, v = p);
            v = 1 / 0;
            for (var x = 0; x < 32 && !(m < Zu); x++) d = c - m, f = c + m, Ju[0] = pi(t, i, r, o, d), 
            Ju[1] = pi(e, n, a, s, d), p = Kl(Ju, Qu), 0 <= d && p < v ? (c = d, v = p) : (tc[0] = pi(t, i, r, o, f), 
            tc[1] = pi(e, n, a, s, f), g = Kl(tc, Qu), f <= 1 && g < v ? (c = f, v = g) : m *= .5);
            return u && (u[0] = pi(t, i, r, o, c), u[1] = pi(e, n, a, s, c)), Uu(v);
        }(t, e, i, n, r, a, o, s, h, u, null) <= c / 2;
    }
    function Di(t, e, i, n, r, a, o, s, l) {
        if (0 === o) return !1;
        var h = o;
        return !(e + h < l && n + h < l && a + h < l || l < e - h && l < n - h && l < a - h || t + h < s && i + h < s && r + h < s || s < t - h && s < i - h && s < r - h) && function(t, e, i, n, r, a, o, s, l) {
            var h, u = .005, c = 1 / 0;
            Qu[0] = o, Qu[1] = s;
            for (var d = 0; d < 1; d += .05) Ju[0] = yi(t, i, r, d), Ju[1] = yi(e, n, a, d), 
            (m = Kl(Qu, Ju)) < c && (h = d, c = m);
            c = 1 / 0;
            for (var f = 0; f < 32 && !(u < Zu); f++) {
                var p = h - u, g = h + u;
                Ju[0] = yi(t, i, r, p), Ju[1] = yi(e, n, a, p);
                var m = Kl(Ju, Qu);
                if (0 <= p && m < c) h = p, c = m; else {
                    tc[0] = yi(t, i, r, g), tc[1] = yi(e, n, a, g);
                    var v = Kl(tc, Qu);
                    g <= 1 && v < c ? (h = g, c = v) : u *= .5;
                }
            }
            return l && (l[0] = yi(t, i, r, h), l[1] = yi(e, n, a, h)), Uu(c);
        }(t, e, i, n, r, a, s, l, null) <= h / 2;
    }
    function Ai(t) {
        return (t %= Mc) < 0 && (t += Mc), t;
    }
    function ki(t, e, i, n, r, a, o, s, l) {
        if (0 === o) return !1;
        var h = o;
        s -= t, l -= e;
        var u = Math.sqrt(s * s + l * l);
        if (i < u - h || u + h < i) return !1;
        if (Math.abs(n - r) % Ic < 1e-4) return !0;
        if (a) {
            var c = n;
            n = Ai(r), r = Ai(c);
        } else n = Ai(n), r = Ai(r);
        r < n && (r += Ic);
        var d = Math.atan2(l, s);
        return d < 0 && (d += Ic), n <= d && d <= r || n <= d + Ic && d + Ic <= r;
    }
    function Pi(t, e, i, n, r, a) {
        if (e < a && n < a || a < e && a < n) return 0;
        if (n === e) return 0;
        var o = n < e ? 1 : -1, s = (a - e) / (n - e);
        (1 === s || 0 === s) && (o = n < e ? .5 : -.5);
        var l = s * (i - t) + t;
        return l === r ? 1 / 0 : r < l ? o : 0;
    }
    function Li(t, e, i, n, r, a, o, s, l, h) {
        if (e < h && n < h && a < h && s < h || h < e && h < n && h < a && h < s) return 0;
        var u, c = function(t, e, i, n, r, a) {
            var o = n + 3 * (e - i) - t, s = 3 * (i - 2 * e + t), l = 3 * (e - t), h = t - r, u = s * s - 3 * o * l, c = s * l - 9 * o * h, d = l * l - 3 * s * h, f = 0;
            if (di(u) && di(c)) di(s) ? a[0] = 0 : 0 <= (M = -l / s) && M <= 1 && (a[f++] = M); else {
                var p = c * c - 4 * u * d;
                if (di(p)) {
                    var g = c / u, m = -g / 2;
                    0 <= (M = -s / o + g) && M <= 1 && (a[f++] = M), 0 <= m && m <= 1 && (a[f++] = m);
                } else if (0 < p) {
                    var v = Uu(p), y = u * s + 1.5 * o * (-c + v), x = u * s + 1.5 * o * (-c - v);
                    0 <= (M = (-s - ((y = y < 0 ? -ju(-y, Ku) : ju(y, Ku)) + (x = x < 0 ? -ju(-x, Ku) : ju(x, Ku)))) / (3 * o)) && M <= 1 && (a[f++] = M);
                } else {
                    var _ = (2 * u * s - 3 * o * c) / (2 * Uu(u * u * u)), w = Math.acos(_) / 3, b = Uu(u), S = Math.cos(w), M = (-s - 2 * b * S) / (3 * o), I = (m = (-s + b * (S + $u * Math.sin(w))) / (3 * o), 
                    (-s + b * (S - $u * Math.sin(w))) / (3 * o));
                    0 <= M && M <= 1 && (a[f++] = M), 0 <= m && m <= 1 && (a[f++] = m), 0 <= I && I <= 1 && (a[f++] = I);
                }
            }
            return f;
        }(e, n, a, s, h, Ac);
        if (0 === c) return 0;
        for (var d, f, p = 0, g = -1, m = 0; m < c; m++) {
            var v = Ac[m], y = 0 === v || 1 === v ? .5 : 1;
            pi(t, i, r, o, v) < l || (g < 0 && (g = mi(e, n, a, s, kc), kc[1] < kc[0] && 1 < g && (void 0, 
            u = kc[0], kc[0] = kc[1], kc[1] = u), d = pi(e, n, a, s, kc[0]), 1 < g && (f = pi(e, n, a, s, kc[1]))), 
            p += 2 == g ? v < kc[0] ? d < e ? y : -y : v < kc[1] ? f < d ? y : -y : s < f ? y : -y : v < kc[0] ? d < e ? y : -y : s < d ? y : -y);
        }
        return p;
    }
    function Oi(t, e, i, n, r, a, o, s) {
        if (e < s && n < s && a < s || s < e && s < n && s < a) return 0;
        var l = function(t, e, i, n, r) {
            var a = t - 2 * e + i, o = 2 * (e - t), s = t - n, l = 0;
            if (di(a)) fi(o) && 0 <= (u = -s / o) && u <= 1 && (r[l++] = u); else {
                var h = o * o - 4 * a * s;
                if (di(h)) 0 <= (u = -o / (2 * a)) && u <= 1 && (r[l++] = u); else if (0 < h) {
                    var u, c = Uu(h), d = (-o - c) / (2 * a);
                    0 <= (u = (-o + c) / (2 * a)) && u <= 1 && (r[l++] = u), 0 <= d && d <= 1 && (r[l++] = d);
                }
            }
            return l;
        }(e, n, a, s, Ac);
        if (0 === l) return 0;
        var h = _i(e, n, a);
        if (0 <= h && h <= 1) {
            for (var u = 0, c = yi(e, n, a, h), d = 0; d < l; d++) {
                var f = 0 === Ac[d] || 1 === Ac[d] ? .5 : 1;
                yi(t, i, r, Ac[d]) < o || (u += Ac[d] < h ? c < e ? f : -f : a < c ? f : -f);
            }
            return u;
        }
        f = 0 === Ac[0] || 1 === Ac[0] ? .5 : 1;
        return yi(t, i, r, Ac[0]) < o ? 0 : a < e ? f : -f;
    }
    function Ei(t, e, i, n, r, a, o, s) {
        if (i < (s -= e) || s < -i) return 0;
        var l = Math.sqrt(i * i - s * s);
        Ac[0] = -l, Ac[1] = l;
        var h = Math.abs(n - r);
        if (h < 1e-4) return 0;
        if (h % Cc < 1e-4) {
            r = Cc;
            var u = a ? 1 : -1;
            return o >= Ac[n = 0] + t && o <= Ac[1] + t ? u : 0;
        }
        if (a) {
            l = n;
            n = Ai(r), r = Ai(l);
        } else n = Ai(n), r = Ai(r);
        r < n && (r += Cc);
        for (var c = 0, d = 0; d < 2; d++) {
            var f = Ac[d];
            if (o < f + t) {
                var p = Math.atan2(s, f);
                u = a ? 1 : -1;
                p < 0 && (p = Cc + p), (n <= p && p <= r || n <= p + Cc && p + Cc <= r) && (p > Math.PI / 2 && p < 1.5 * Math.PI && (u = -u), 
                c += u);
            }
        }
        return c;
    }
    function zi(t, e, i, n, r) {
        for (var a = 0, o = 0, s = 0, l = 0, h = 0, u = 0; u < t.length; ) {
            var c = t[u++];
            switch (c === Tc.M && 1 < u && (i || (a += Pi(o, s, l, h, n, r))), 1 == u && (l = o = t[u], 
            h = s = t[u + 1]), c) {
              case Tc.M:
                o = l = t[u++], s = h = t[u++];
                break;

              case Tc.L:
                if (i) {
                    if (Ti(o, s, t[u], t[u + 1], e, n, r)) return !0;
                } else a += Pi(o, s, t[u], t[u + 1], n, r) || 0;
                o = t[u++], s = t[u++];
                break;

              case Tc.C:
                if (i) {
                    if (Ci(o, s, t[u++], t[u++], t[u++], t[u++], t[u], t[u + 1], e, n, r)) return !0;
                } else a += Li(o, s, t[u++], t[u++], t[u++], t[u++], t[u], t[u + 1], n, r) || 0;
                o = t[u++], s = t[u++];
                break;

              case Tc.Q:
                if (i) {
                    if (Di(o, s, t[u++], t[u++], t[u], t[u + 1], e, n, r)) return !0;
                } else a += Oi(o, s, t[u++], t[u++], t[u], t[u + 1], n, r) || 0;
                o = t[u++], s = t[u++];
                break;

              case Tc.A:
                var d = t[u++], f = t[u++], p = t[u++], g = t[u++], m = t[u++], v = t[u++], y = (t[u++], 
                1 - t[u++]), x = Math.cos(m) * p + d, _ = Math.sin(m) * g + f;
                1 < u ? a += Pi(o, s, x, _, n, r) : (l = x, h = _);
                var w = (n - d) * g / p + d;
                if (i) {
                    if (ki(d, f, g, m, m + v, y, e, w, r)) return !0;
                } else a += Ei(d, f, g, m, m + v, y, w, r);
                o = Math.cos(m + v) * p + d, s = Math.sin(m + v) * g + f;
                break;

              case Tc.R:
                l = o = t[u++], h = s = t[u++];
                x = l + t[u++], _ = h + t[u++];
                if (i) {
                    if (Ti(l, h, x, h, e, n, r) || Ti(x, h, x, _, e, n, r) || Ti(x, _, l, _, e, n, r) || Ti(l, _, l, h, e, n, r)) return !0;
                } else a += Pi(x, h, x, _, n, r), a += Pi(l, _, l, h, n, r);
                break;

              case Tc.Z:
                if (i) {
                    if (Ti(o, s, l, h, e, n, r)) return !0;
                } else a += Pi(o, s, l, h, n, r);
                o = l, s = h;
            }
        }
        return i || (b = s, S = h, Math.abs(b - S) < Dc) || (a += Pi(o, s, l, h, n, r) || 0), 
        0 !== a;
        var b, S;
    }
    function Bi(t) {
        Ne.call(this, t), this.path = null;
    }
    function Ri(t, e, i, n, r, a, o, s, l, h, u) {
        var c = l * (Hc / 180), d = Vc(c) * (t - i) / 2 + Gc(c) * (e - n) / 2, f = -1 * Gc(c) * (t - i) / 2 + Vc(c) * (e - n) / 2, p = d * d / (o * o) + f * f / (s * s);
        1 < p && (o *= Fc(p), s *= Fc(p));
        var g = (r === a ? -1 : 1) * Fc((o * o * s * s - o * o * f * f - s * s * d * d) / (o * o * f * f + s * s * d * d)) || 0, m = g * o * f / s, v = g * -s * d / o, y = (t + i) / 2 + Vc(c) * m - Gc(c) * v, x = (e + n) / 2 + Gc(c) * m + Vc(c) * v, _ = qc([ 1, 0 ], [ (d - m) / o, (f - v) / s ]), w = [ (d - m) / o, (f - v) / s ], b = [ (-1 * d - m) / o, (-1 * f - v) / s ], S = qc(w, b);
        Xc(w, b) <= -1 && (S = Hc), 1 <= Xc(w, b) && (S = 0), 0 === a && 0 < S && (S -= 2 * Hc), 
        1 === a && S < 0 && (S += 2 * Hc), u.addData(h, y, x, o, s, _, S, c, a);
    }
    function Ni(t, e) {
        var i = function(t) {
            if (!t) return new Sc();
            for (var e, i = 0, n = 0, r = i, a = n, o = new Sc(), s = Sc.CMD, l = t.match(jc), h = 0; h < l.length; h++) {
                for (var u, c = l[h], d = c.charAt(0), f = c.match(Uc) || [], p = f.length, g = 0; g < p; g++) f[g] = parseFloat(f[g]);
                for (var m = 0; m < p; ) {
                    var v, y, x, _, w, b, S, M = i, I = n;
                    switch (d) {
                      case "l":
                        i += f[m++], n += f[m++], u = s.L, o.addData(u, i, n);
                        break;

                      case "L":
                        i = f[m++], n = f[m++], u = s.L, o.addData(u, i, n);
                        break;

                      case "m":
                        i += f[m++], n += f[m++], u = s.M, o.addData(u, i, n), r = i, a = n, d = "l";
                        break;

                      case "M":
                        i = f[m++], n = f[m++], u = s.M, o.addData(u, i, n), r = i, a = n, d = "L";
                        break;

                      case "h":
                        i += f[m++], u = s.L, o.addData(u, i, n);
                        break;

                      case "H":
                        i = f[m++], u = s.L, o.addData(u, i, n);
                        break;

                      case "v":
                        n += f[m++], u = s.L, o.addData(u, i, n);
                        break;

                      case "V":
                        n = f[m++], u = s.L, o.addData(u, i, n);
                        break;

                      case "C":
                        u = s.C, o.addData(u, f[m++], f[m++], f[m++], f[m++], f[m++], f[m++]), i = f[m - 2], 
                        n = f[m - 1];
                        break;

                      case "c":
                        u = s.C, o.addData(u, f[m++] + i, f[m++] + n, f[m++] + i, f[m++] + n, f[m++] + i, f[m++] + n), 
                        i += f[m - 2], n += f[m - 1];
                        break;

                      case "S":
                        v = i, y = n;
                        var T = o.len(), C = o.data;
                        e === s.C && (v += i - C[T - 4], y += n - C[T - 3]), u = s.C, M = f[m++], I = f[m++], 
                        i = f[m++], n = f[m++], o.addData(u, v, y, M, I, i, n);
                        break;

                      case "s":
                        v = i, y = n, T = o.len(), C = o.data, e === s.C && (v += i - C[T - 4], y += n - C[T - 3]), 
                        u = s.C, M = i + f[m++], I = n + f[m++], i += f[m++], n += f[m++], o.addData(u, v, y, M, I, i, n);
                        break;

                      case "Q":
                        M = f[m++], I = f[m++], i = f[m++], n = f[m++], u = s.Q, o.addData(u, M, I, i, n);
                        break;

                      case "q":
                        M = f[m++] + i, I = f[m++] + n, i += f[m++], n += f[m++], u = s.Q, o.addData(u, M, I, i, n);
                        break;

                      case "T":
                        v = i, y = n, T = o.len(), C = o.data, e === s.Q && (v += i - C[T - 4], y += n - C[T - 3]), 
                        i = f[m++], n = f[m++], u = s.Q, o.addData(u, v, y, i, n);
                        break;

                      case "t":
                        v = i, y = n, T = o.len(), C = o.data, e === s.Q && (v += i - C[T - 4], y += n - C[T - 3]), 
                        i += f[m++], n += f[m++], u = s.Q, o.addData(u, v, y, i, n);
                        break;

                      case "A":
                        x = f[m++], _ = f[m++], w = f[m++], b = f[m++], S = f[m++], Ri(M = i, I = n, i = f[m++], n = f[m++], b, S, x, _, w, u = s.A, o);
                        break;

                      case "a":
                        x = f[m++], _ = f[m++], w = f[m++], b = f[m++], S = f[m++], Ri(M = i, I = n, i += f[m++], n += f[m++], b, S, x, _, w, u = s.A, o);
                    }
                }
                ("z" === d || "Z" === d) && (u = s.Z, o.addData(u), i = r, n = a), e = u;
            }
            return o.toStatic(), o;
        }(t);
        return (e = e || {}).buildPath = function(t) {
            if (t.setData) {
                t.setData(i.data), (e = t.getContext()) && t.rebuildPath(e);
            } else {
                var e = t;
                i.rebuildPath(e);
            }
        }, e.applyTransform = function(t) {
            Nc(i, t), this.dirty(!0);
        }, e;
    }
    function Fi(t, e) {
        return new Bi(Ni(t, e));
    }
    function Gi(t, e, i, n, r, a, o) {
        var s = .5 * (i - t), l = .5 * (n - e);
        return (2 * (e - i) + s + l) * o + (-3 * (e - i) - 2 * s - l) * a + s * r + e;
    }
    function Vi(t, e, i) {
        var n = e.points, r = e.smooth;
        if (n && 2 <= n.length) {
            if (r && "spline" !== r) {
                var a = function(t, e, i, n) {
                    var r, a, o, s, l = [], h = [], u = [], c = [];
                    if (n) {
                        o = [ 1 / 0, 1 / 0 ], s = [ -1 / 0, -1 / 0 ];
                        for (var d = 0, f = t.length; d < f; d++) K(o, o, t[d]), Q(s, s, t[d]);
                        K(o, o, n[0]), Q(s, s, n[1]);
                    }
                    for (var d = 0, f = t.length; d < f; d++) {
                        var p = t[d];
                        if (i) r = t[d ? d - 1 : f - 1], a = t[(d + 1) % f]; else {
                            if (0 === d || d === f - 1) {
                                l.push(G(t[d]));
                                continue;
                            }
                            r = t[d - 1], a = t[d + 1];
                        }
                        W(h, a, r), j(h, h, e);
                        var g = Y(p, r), m = Y(p, a), v = g + m;
                        0 !== v && (g /= v, m /= v), j(u, h, -g), j(c, h, m);
                        var y = V([], p, u), x = V([], p, c);
                        n && (Q(y, y, o), K(y, y, s), Q(x, x, o), K(x, x, s)), l.push(y), l.push(x);
                    }
                    return i && l.push(l.shift()), l;
                }(n, r, i, e.smoothConstraint);
                t.moveTo(n[0][0], n[0][1]);
                for (var o = n.length, s = 0; s < (i ? o : o - 1); s++) {
                    var l = a[2 * s], h = a[2 * s + 1], u = n[(s + 1) % o];
                    t.bezierCurveTo(l[0], l[1], h[0], h[1], u[0], u[1]);
                }
            } else {
                "spline" === r && (n = function(t, e) {
                    for (var i = t.length, n = [], r = 0, a = 1; a < i; a++) r += Y(t[a - 1], t[a]);
                    var o = r / 2;
                    o = o < i ? i : o;
                    for (var a = 0; a < o; a++) {
                        var s, l, h, u = a / (o - 1) * (e ? i : i - 1), c = Math.floor(u), d = u - c, f = t[c % i];
                        e ? (s = t[(c - 1 + i) % i], l = t[(c + 1) % i], h = t[(c + 2) % i]) : (s = t[0 === c ? c : c - 1], 
                        l = t[i - 2 < c ? i - 1 : c + 1], h = t[i - 3 < c ? i - 1 : c + 2]);
                        var p = d * d, g = d * p;
                        n.push([ Gi(s[0], f[0], l[0], h[0], d, p, g), Gi(s[1], f[1], l[1], h[1], d, p, g) ]);
                    }
                    return n;
                }(n, i)), t.moveTo(n[0][0], n[0][1]);
                s = 1;
                for (var c = n.length; s < c; s++) t.lineTo(n[s][0], n[s][1]);
            }
            i && t.closePath();
        }
    }
    function Hi(t, e, i) {
        var n = t.cpx2, r = t.cpy2;
        return null === n || null === r ? [ (i ? gi : pi)(t.x1, t.cpx1, t.cpx2, t.x2, e), (i ? gi : pi)(t.y1, t.cpy1, t.cpy2, t.y2, e) ] : [ (i ? xi : yi)(t.x1, t.cpx1, t.x2, e), (i ? xi : yi)(t.y1, t.cpy1, t.y2, e) ];
    }
    function Wi(t) {
        Ne.call(this, t), this._displayables = [], this._temporaryDisplayables = [], this._cursor = 0, 
        this.notClear = !0;
    }
    function Xi(t) {
        return Bi.extend(t);
    }
    function qi(t, e, i, n) {
        var r = Fi(t, e);
        return i && ("center" === n && (i = Ui(i, r.getBoundingRect())), Yi(r, i)), r;
    }
    function ji(t, i, n) {
        var r = new Fe({
            style: {
                image: t,
                x: i.x,
                y: i.y,
                width: i.width,
                height: i.height
            },
            onload: function(t) {
                if ("center" === n) {
                    var e = {
                        width: t.width,
                        height: t.height
                    };
                    r.setStyle(Ui(i, e));
                }
            }
        });
        return r;
    }
    function Ui(t, e) {
        var i, n = e.width / e.height, r = t.height * n;
        return r <= t.width ? i = t.height : i = (r = t.width) / n, {
            x: t.x + t.width / 2 - r / 2,
            y: t.y + t.height / 2 - i / 2,
            width: r,
            height: i
        };
    }
    function Yi(t, e) {
        if (t.applyTransform) {
            var i = t.getBoundingRect().calculateTransform(e);
            t.applyTransform(i);
        }
    }
    function Zi(t) {
        var e = t.shape, i = t.style.lineWidth;
        return dd(2 * e.x1) === dd(2 * e.x2) && (e.x1 = e.x2 = Ki(e.x1, i, !0)), dd(2 * e.y1) === dd(2 * e.y2) && (e.y1 = e.y2 = Ki(e.y1, i, !0)), 
        t;
    }
    function $i(t) {
        var e = t.shape, i = t.style.lineWidth, n = e.x, r = e.y, a = e.width, o = e.height;
        return e.x = Ki(e.x, i, !0), e.y = Ki(e.y, i, !0), e.width = Math.max(Ki(n + a, i, !1) - e.x, 0 === a ? 0 : 1), 
        e.height = Math.max(Ki(r + o, i, !1) - e.y, 0 === o ? 0 : 1), t;
    }
    function Ki(t, e, i) {
        var n = dd(2 * t);
        return (n + dd(e)) % 2 == 0 ? n / 2 : (n + (i ? 1 : -1)) / 2;
    }
    function Qi(t) {
        return null != t && "none" !== t;
    }
    function Ji(t) {
        var e = t.__hoverStl;
        if (e && !t.__highlighted) {
            var i = t.useHoverLayer;
            t.__highlighted = i ? "layer" : "plain";
            var n = t.__zr;
            if (n || !i) {
                var r = t, a = t.style;
                i && (a = (r = n.addHover(t)).style), yn(a), i || function(t) {
                    if (t.__hoverStlDirty) {
                        t.__hoverStlDirty = !1;
                        var e = t.__hoverStl;
                        if (!e) return t.__normalStl = null;
                        var i = t.__normalStl = {}, n = t.style;
                        for (var r in e) null != e[r] && (i[r] = n[r]);
                        i.fill = n.fill, i.stroke = n.stroke;
                    }
                }(r), a.extendFrom(e), tn(a, e, "fill"), tn(a, e, "stroke"), vn(a), i || (t.dirty(!1), 
                t.z2 += 1);
            }
        }
    }
    function tn(t, e, i) {
        !Qi(e[i]) && Qi(t[i]) && (t[i] = function(t) {
            if ("string" != typeof t) return t;
            var e = vd.get(t);
            return e || (e = At(t, -.1), yd < 1e4 && (vd.set(t, e), yd++)), e;
        }(t[i]));
    }
    function en(t) {
        t.__highlighted && (function(t) {
            var e = t.__highlighted;
            if ("layer" === e) t.__zr && t.__zr.removeHover(t); else if (e) {
                var i = t.style, n = t.__normalStl;
                n && (yn(i), t.setStyle(n), vn(i), t.z2 -= 1);
            }
        }(t), t.__highlighted = !1);
    }
    function nn(t, e) {
        t.isGroup ? t.traverse(function(t) {
            !t.isGroup && e(t);
        }) : e(t);
    }
    function rn(t, e) {
        e = t.__hoverStl = !1 !== e && (e || {}), t.__hoverStlDirty = !0, t.__highlighted && (en(t), 
        Ji(t));
    }
    function an(t) {
        return t && t.__isEmphasisEntered;
    }
    function on(t) {
        this.__hoverSilentOnTouch && t.zrByTouch || !this.__isEmphasisEntered && nn(this, Ji);
    }
    function sn(t) {
        this.__hoverSilentOnTouch && t.zrByTouch || !this.__isEmphasisEntered && nn(this, en);
    }
    function ln() {
        this.__isEmphasisEntered = !0, nn(this, Ji);
    }
    function hn() {
        this.__isEmphasisEntered = !1, nn(this, en);
    }
    function un(t, e, i) {
        t.isGroup ? t.traverse(function(t) {
            !t.isGroup && rn(t, t.hoverStyle || e);
        }) : rn(t, t.hoverStyle || e), cn(t, i);
    }
    function cn(t, e) {
        var i = !1 === e;
        if (t.__hoverSilentOnTouch = null != e && e.hoverSilentOnTouch, !i || t.__hoverStyleTrigger) {
            var n = i ? "off" : "on";
            t[n]("mouseover", on)[n]("mouseout", sn), t[n]("emphasis", ln)[n]("normal", hn), 
            t.__hoverStyleTrigger = !i;
        }
    }
    function dn(t, e, i, n, r, a, o) {
        var s, l = (r = r || gd).labelFetcher, h = r.labelDataIndex, u = r.labelDimIndex, c = i.getShallow("show"), d = n.getShallow("show");
        (c || d) && (l && (s = l.getFormattedLabel(h, "normal", null, u)), null == s && (s = v(r.defaultText) ? r.defaultText(h, r) : r.defaultText));
        var f = c ? s : null, p = d ? O(l ? l.getFormattedLabel(h, "emphasis", null, u) : null, s) : null;
        (null != f || null != p) && (fn(t, i, a, r), fn(e, n, o, r, !0)), t.text = f, e.text = p;
    }
    function fn(t, e, i, n, r) {
        return pn(t, e, n, r), i && A(t, i), t;
    }
    function pn(t, e, i, n) {
        if ((i = i || gd).isRectText) {
            var r = e.getShallow("position") || (n ? null : "inside");
            "outside" === r && (r = "top"), t.textPosition = r, t.textOffset = e.getShallow("offset");
            var a = e.getShallow("rotate");
            null != a && (a *= Math.PI / 180), t.textRotation = a, t.textDistance = O(e.getShallow("distance"), n ? null : 5);
        }
        var o, s = e.ecModel, l = s && s.option.textStyle, h = function(t) {
            for (var e; t && t !== t.ecModel; ) {
                var i = (t.option || gd).rich;
                if (i) for (var n in e = e || {}, i) i.hasOwnProperty(n) && (e[n] = 1);
                t = t.parentModel;
            }
            return e;
        }(e);
        if (h) for (var u in o = {}, h) if (h.hasOwnProperty(u)) {
            var c = e.getModel([ "rich", u ]);
            gn(o[u] = {}, c, l, i, n);
        }
        return t.rich = o, gn(t, e, l, i, n, !0), i.forceRich && !i.textStyle && (i.textStyle = {}), 
        t;
    }
    function gn(t, e, i, n, r, a) {
        i = !r && i || gd, t.textFill = mn(e.getShallow("color"), n) || i.color, t.textStroke = mn(e.getShallow("textBorderColor"), n) || i.textBorderColor, 
        t.textStrokeWidth = O(e.getShallow("textBorderWidth"), i.textBorderWidth), t.insideRawTextPosition = t.textPosition, 
        r || (a && (t.insideRollbackOpt = n, vn(t)), null == t.textFill && (t.textFill = n.autoColor)), 
        t.fontStyle = e.getShallow("fontStyle") || i.fontStyle, t.fontWeight = e.getShallow("fontWeight") || i.fontWeight, 
        t.fontSize = e.getShallow("fontSize") || i.fontSize, t.fontFamily = e.getShallow("fontFamily") || i.fontFamily, 
        t.textAlign = e.getShallow("align"), t.textVerticalAlign = e.getShallow("verticalAlign") || e.getShallow("baseline"), 
        t.textLineHeight = e.getShallow("lineHeight"), t.textWidth = e.getShallow("width"), 
        t.textHeight = e.getShallow("height"), t.textTag = e.getShallow("tag"), a && n.disableBox || (t.textBackgroundColor = mn(e.getShallow("backgroundColor"), n), 
        t.textPadding = e.getShallow("padding"), t.textBorderColor = mn(e.getShallow("borderColor"), n), 
        t.textBorderWidth = e.getShallow("borderWidth"), t.textBorderRadius = e.getShallow("borderRadius"), 
        t.textBoxShadowColor = e.getShallow("shadowColor"), t.textBoxShadowBlur = e.getShallow("shadowBlur"), 
        t.textBoxShadowOffsetX = e.getShallow("shadowOffsetX"), t.textBoxShadowOffsetY = e.getShallow("shadowOffsetY")), 
        t.textShadowColor = e.getShallow("textShadowColor") || i.textShadowColor, t.textShadowBlur = e.getShallow("textShadowBlur") || i.textShadowBlur, 
        t.textShadowOffsetX = e.getShallow("textShadowOffsetX") || i.textShadowOffsetX, 
        t.textShadowOffsetY = e.getShallow("textShadowOffsetY") || i.textShadowOffsetY;
    }
    function mn(t, e) {
        return "auto" !== t ? t : e && e.autoColor ? e.autoColor : null;
    }
    function vn(t) {
        var e = t.insideRollbackOpt;
        if (e && null == t.textFill) {
            var i, n = e.useInsideStyle, r = t.insideRawTextPosition, a = e.autoColor;
            !1 !== n && (!0 === n || e.isRectText && r && "string" == typeof r && 0 <= r.indexOf("inside")) ? (i = {
                textFill: null,
                textStroke: t.textStroke,
                textStrokeWidth: t.textStrokeWidth
            }, t.textFill = "#fff", null == t.textStroke && (t.textStroke = a, null == t.textStrokeWidth && (t.textStrokeWidth = 2))) : null != a && (i = {
                textFill: null
            }, t.textFill = a), i && (t.insideRollback = i);
        }
    }
    function yn(t) {
        var e = t.insideRollback;
        e && (t.textFill = e.textFill, t.textStroke = e.textStroke, t.textStrokeWidth = e.textStrokeWidth, 
        t.insideRollback = null);
    }
    function xn(t, e) {
        var i = e || e.getModel("textStyle");
        return f([ t.fontStyle || i && i.getShallow("fontStyle") || "", t.fontWeight || i && i.getShallow("fontWeight") || "", (t.fontSize || i && i.getShallow("fontSize") || 12) + "px", t.fontFamily || i && i.getShallow("fontFamily") || "sans-serif" ].join(" "));
    }
    function _n(t, e, i, n, r, a) {
        if ("function" == typeof r && (a = r, r = null), n && n.isAnimationEnabled()) {
            var o = t ? "Update" : "", s = n.getShallow("animationDuration" + o), l = n.getShallow("animationEasing" + o), h = n.getShallow("animationDelay" + o);
            "function" == typeof h && (h = h(r, n.getAnimationDelayParams ? n.getAnimationDelayParams(e, r) : null)), 
            "function" == typeof s && (s = s(r)), 0 < s ? e.animateTo(i, s, h || 0, l, a, !!a) : (e.stopAnimation(), 
            e.attr(i), a && a());
        } else e.stopAnimation(), e.attr(i), a && a();
    }
    function wn(t, e, i, n, r) {
        _n(!0, t, e, i, n, r);
    }
    function bn(t, e, i, n, r) {
        _n(!1, t, e, i, n, r);
    }
    function Sn(t, e, i) {
        return e && !E(e) && (e = uh.getLocalTransform(e)), i && (e = gt([], e)), $([], t, e);
    }
    function Mn(t, e, n) {
        function r(t) {
            var e = {
                position: G(t.position),
                rotation: t.rotation
            };
            return t.shape && (e.shape = A({}, t.shape)), e;
        }
        if (t && e) {
            var a = (i = {}, t.traverse(function(t) {
                !t.isGroup && t.anid && (i[t.anid] = t);
            }), i);
            e.traverse(function(t) {
                if (!t.isGroup && t.anid) {
                    var e = a[t.anid];
                    if (e) {
                        var i = r(t);
                        t.attr(r(e)), wn(t, i, n, t.dataIndex);
                    }
                }
            });
        }
        var i;
    }
    function In(t, e, i) {
        var n = (e = A({
            rectHover: !0
        }, e)).style = {
            strokeNoScale: !0
        };
        return i = i || {
            x: -1,
            y: -1,
            width: 2,
            height: 2
        }, t ? 0 === t.indexOf("image://") ? (n.image = t.slice(8), C(n, i), new Fe(e)) : qi(t.replace("path://", ""), e, i, "center") : void 0;
    }
    function Tn(t, e, i) {
        this.parentModel = e, this.ecModel = i, this.option = t;
    }
    function Cn(t, e, i) {
        for (var n = 0; n < e.length && (!e[n] || null != (t = t && "object" == (void 0 === t ? "undefined" : _typeof(t)) ? t[e[n]] : null)); n++) ;
        return null == t && i && (t = i.get(e)), t;
    }
    function Dn(t, e) {
        var i = Id(t).getParent;
        return i ? i.call(t, e) : t.parentModel;
    }
    function An(t) {
        return [ t || "", Dd++, Math.random().toFixed(5) ].join("_");
    }
    function kn(t, e, i, n) {
        var r = e[1] - e[0], a = i[1] - i[0];
        if (0 === r) return 0 === a ? i[0] : (i[0] + i[1]) / 2;
        if (n) if (0 < r) {
            if (t <= e[0]) return i[0];
            if (t >= e[1]) return i[1];
        } else {
            if (t >= e[0]) return i[0];
            if (t <= e[1]) return i[1];
        } else {
            if (t === e[0]) return i[0];
            if (t === e[1]) return i[1];
        }
        return (t - e[0]) / r * a + i[0];
    }
    function Pn(t, e) {
        switch (t) {
          case "center":
          case "middle":
            t = "50%";
            break;

          case "left":
          case "top":
            t = "0%";
            break;

          case "right":
          case "bottom":
            t = "100%";
        }
        return "string" == typeof t ? (i = t, i.replace(/^\s+/, "").replace(/\s+$/, "")).match(/%$/) ? parseFloat(t) / 100 * e : parseFloat(t) : null == t ? NaN : +t;
        var i;
    }
    function Ln(t, e, i) {
        return null == e && (e = 10), e = Math.min(Math.max(0, e), 20), t = (+t).toFixed(e), 
        i ? t : +t;
    }
    function On(t) {
        var e = t.toString(), i = e.indexOf("e");
        if (0 < i) {
            var n = +e.slice(i + 1);
            return n < 0 ? -n : 0;
        }
        var r = e.indexOf(".");
        return r < 0 ? 0 : e.length - 1 - r;
    }
    function En(t, e) {
        var i = Math.log, n = Math.LN10, r = Math.floor(i(t[1] - t[0]) / n), a = Math.round(i(Math.abs(e[1] - e[0])) / n), o = Math.min(Math.max(-r + a, 0), 20);
        return isFinite(o) ? o : 20;
    }
    function zn(t, e, i) {
        if (!t[e]) return 0;
        var n = S(t, function(t, e) {
            return t + (isNaN(e) ? 0 : e);
        }, 0);
        if (0 === n) return 0;
        for (var r = Math.pow(10, i), a = D(t, function(t) {
            return (isNaN(t) ? 0 : t) / n * r * 100;
        }), o = 100 * r, s = D(a, function(t) {
            return Math.floor(t);
        }), l = S(s, function(t, e) {
            return t + e;
        }, 0), h = D(a, function(t, e) {
            return t - s[e];
        }); l < o; ) {
            for (var u = Number.NEGATIVE_INFINITY, c = null, d = 0, f = h.length; d < f; ++d) h[d] > u && (u = h[d], 
            c = d);
            ++s[c], h[c] = 0, ++l;
        }
        return s[e] / r;
    }
    function Bn(t) {
        var e = 2 * Math.PI;
        return (t % e + e) % e;
    }
    function Rn(t) {
        return -Ad < t && t < Ad;
    }
    function Nn(t) {
        if (t instanceof Date) return t;
        if ("string" == typeof t) {
            var e = kd.exec(t);
            if (!e) return new Date(NaN);
            if (e[8]) {
                var i = +e[4] || 0;
                return "Z" !== e[8].toUpperCase() && (i -= e[8].slice(0, 3)), new Date(Date.UTC(+e[1], +(e[2] || 1) - 1, +e[3] || 1, i, +(e[5] || 0), +e[6] || 0, +e[7] || 0));
            }
            return new Date(+e[1], +(e[2] || 1) - 1, +e[3] || 1, +e[4] || 0, +(e[5] || 0), +e[6] || 0, +e[7] || 0);
        }
        return new Date(null == t ? NaN : Math.round(t));
    }
    function Fn(t) {
        return Math.pow(10, Gn(t));
    }
    function Gn(t) {
        return Math.floor(Math.log(t) / Math.LN10);
    }
    function Vn(t, e) {
        var i = Gn(t), n = Math.pow(10, i), r = t / n;
        return t = (e ? r < 1.5 ? 1 : r < 2.5 ? 2 : r < 4 ? 3 : r < 7 ? 5 : 10 : r < 1 ? 1 : r < 2 ? 2 : r < 3 ? 3 : r < 5 ? 5 : 10) * n, 
        -20 <= i ? +t.toFixed(i < 0 ? -i : 0) : t;
    }
    function Hn(t) {
        return isNaN(t) ? "-" : (t = (t + "").split("."))[0].replace(/(\d{1,3})(?=(?:\d{3})+(?!\d))/g, "$1,") + (1 < t.length ? "." + t[1] : "");
    }
    function Wn(t, e) {
        return t = (t || "").toLowerCase().replace(/-(.)/g, function(t, e) {
            return e.toUpperCase();
        }), e && t && (t = t.charAt(0).toUpperCase() + t.slice(1)), t;
    }
    function Xn(t) {
        return null == t ? "" : (t + "").replace(Od, function(t, e) {
            return Ed[e];
        });
    }
    function qn(t, e, i) {
        P(e) || (e = [ e ]);
        var n = e.length;
        if (!n) return "";
        for (var r = e[0].$vars || [], a = 0; a < r.length; a++) {
            var o = zd[a];
            t = t.replace(Bd(o), Bd(o, 0));
        }
        for (var s = 0; s < n; s++) for (var l = 0; l < r.length; l++) {
            var h = e[s][r[l]];
            t = t.replace(Bd(zd[l], s), i ? Xn(h) : h);
        }
        return t;
    }
    function jn(t, e) {
        var i = (t = M(t) ? {
            color: t,
            extraCssText: e
        } : t || {}).color, n = t.type, r = (e = t.extraCssText, t.renderMode || "html"), a = t.markerId || "X";
        return i ? "html" === r ? "subItem" === n ? '<span style="display:inline-block;vertical-align:middle;margin-right:8px;margin-left:3px;border-radius:4px;width:4px;height:4px;background-color:' + Xn(i) + ";" + (e || "") + '"></span>' : '<span style="display:inline-block;margin-right:5px;border-radius:10px;width:10px;height:10px;background-color:' + Xn(i) + ";" + (e || "") + '"></span>' : {
            renderMode: r,
            content: "{marker" + a + "|}  ",
            style: {
                color: i
            }
        } : "";
    }
    function Un(t, e) {
        return "0000".substr(0, e - (t += "").length) + t;
    }
    function Yn(t, e, i) {
        ("week" === t || "month" === t || "quarter" === t || "half-year" === t || "year" === t) && (t = "MM-dd\nyyyy");
        var n = Nn(e), r = i ? "UTC" : "", a = n["get" + r + "FullYear"](), o = n["get" + r + "Month"]() + 1, s = n["get" + r + "Date"](), l = n["get" + r + "Hours"](), h = n["get" + r + "Minutes"](), u = n["get" + r + "Seconds"](), c = n["get" + r + "Milliseconds"]();
        return t.replace("MM", Un(o, 2)).replace("M", o).replace("yyyy", a).replace("yy", a % 100).replace("dd", Un(s, 2)).replace("d", s).replace("hh", Un(l, 2)).replace("h", l).replace("mm", Un(h, 2)).replace("m", h).replace("ss", Un(u, 2)).replace("s", u).replace("SSS", Un(c, 3));
    }
    function Zn(u, c, d, f, p) {
        var g = 0, m = 0;
        null == f && (f = 1 / 0), null == p && (p = 1 / 0);
        var v = 0;
        c.eachChild(function(t, e) {
            var i, n, r = t.position, a = t.getBoundingRect(), o = c.childAt(e + 1), s = o && o.getBoundingRect();
            if ("horizontal" === u) {
                var l = a.width + (s ? -s.x + a.x : 0);
                f < (i = g + l) || t.newline ? (g = 0, i = l, m += v + d, v = a.height) : v = Math.max(v, a.height);
            } else {
                var h = a.height + (s ? -s.y + a.y : 0);
                p < (n = m + h) || t.newline ? (g += v + d, m = 0, n = h, v = a.width) : v = Math.max(v, a.width);
            }
            t.newline || (r[0] = g, r[1] = m, "horizontal" === u ? g = i + d : m = n + d);
        });
    }
    function $n(t, e, i) {
        i = Ld(i || 0);
        var n = e.width, r = e.height, a = Pn(t.left, n), o = Pn(t.top, r), s = Pn(t.right, n), l = Pn(t.bottom, r), h = Pn(t.width, n), u = Pn(t.height, r), c = i[2] + i[0], d = i[1] + i[3], f = t.aspect;
        switch (isNaN(h) && (h = n - s - d - a), isNaN(u) && (u = r - l - c - o), null != f && (isNaN(h) && isNaN(u) && (n / r < f ? h = .8 * n : u = .8 * r), 
        isNaN(h) && (h = f * u), isNaN(u) && (u = h / f)), isNaN(a) && (a = n - s - h - d), 
        isNaN(o) && (o = r - l - u - c), t.left || t.right) {
          case "center":
            a = n / 2 - h / 2 - i[3];
            break;

          case "right":
            a = n - h - d;
        }
        switch (t.top || t.bottom) {
          case "middle":
          case "center":
            o = r / 2 - u / 2 - i[0];
            break;

          case "bottom":
            o = r - u - c;
        }
        a = a || 0, o = o || 0, isNaN(h) && (h = n - d - a - (s || 0)), isNaN(u) && (u = r - c - o - (l || 0));
        var p = new Yt(a + i[3], o + i[0], h, u);
        return p.margin = i, p;
    }
    function Kn(l, h, t) {
        function e(t, e) {
            var i = {}, n = 0, r = {}, a = 0;
            if (Gd(t, function(t) {
                r[t] = l[t];
            }), Gd(t, function(t) {
                u(h, t) && (i[t] = r[t] = h[t]), c(i, t) && n++, c(r, t) && a++;
            }), d[e]) return c(h, t[1]) ? r[t[2]] = null : c(h, t[2]) && (r[t[1]] = null), r;
            if (2 !== a && n) {
                if (2 <= n) return i;
                for (var o = 0; o < t.length; o++) {
                    var s = t[o];
                    if (!u(i, s) && u(l, s)) {
                        i[s] = l[s];
                        break;
                    }
                }
                return i;
            }
            return r;
        }
        function u(t, e) {
            return t.hasOwnProperty(e);
        }
        function c(t, e) {
            return null != t[e] && "auto" !== t[e];
        }
        function i(t, e, i) {
            Gd(t, function(t) {
                e[t] = i[t];
            });
        }
        !L(t) && (t = {});
        var d = t.ignoreSize;
        !P(d) && (d = [ d, d ]);
        var n = e(Hd[0], 0), r = e(Hd[1], 1);
        i(Hd[0], l, n), i(Hd[1], l, r);
    }
    function Qn(t) {
        return e = {}, (i = t) && e && Gd(Vd, function(t) {
            i.hasOwnProperty(t) && (e[t] = i[t]);
        }), e;
        var e, i;
    }
    function Jn(t) {
        var e = t.get("coordinateSystem"), i = {
            coordSysName: e,
            coordSysDims: [],
            axisMap: T(),
            categoryAxisMap: T()
        }, n = Kd[e];
        return n ? (n(t, i, i.axisMap, i.categoryAxisMap), i) : void 0;
    }
    function tr(t) {
        return "category" === t.get("type");
    }
    function er(t) {
        this.fromDataset = t.fromDataset, this.data = t.data || (t.sourceFormat === ef ? {} : []), 
        this.sourceFormat = t.sourceFormat || nf, this.seriesLayoutBy = t.seriesLayoutBy || af, 
        this.dimensionsDefine = t.dimensionsDefine, this.encodeDefine = t.encodeDefine && T(t.encodeDefine), 
        this.startIndex = t.startIndex || 0, this.dimensionsDetectCount = t.dimensionsDetectCount;
    }
    function ir(t) {
        var e, i, n = t.option, r = n.data, a = p(r) ? rf : Qd, o = !1, s = n.seriesLayoutBy, l = n.sourceHeader, h = n.dimensions, u = (i = (e = t).option).data ? void 0 : e.ecModel.getComponent("dataset", i.datasetIndex || 0);
        if (u) {
            var c = u.option;
            r = c.source, a = sf(u).sourceFormat, o = !0, s = s || c.seriesLayoutBy, null == l && (l = c.sourceHeader), 
            h = h || c.dimensions;
        }
        var d = function(t, e, i, n, r) {
            if (!t) return {
                dimensionsDefine: nr(r)
            };
            var a, o, s, l;
            if (e === Jd) "auto" === n || null == n ? rr(function(t) {
                null != t && "-" !== t && (M(t) ? null == o && (o = 1) : o = 0);
            }, i, t, 10) : o = n ? 1 : 0, r || 1 !== o || (r = [], rr(function(t, e) {
                r[e] = null != t ? t : "";
            }, i, t)), a = r ? r.length : i === of ? t.length : t[0] ? t[0].length : null; else if (e === tf) r || (r = function(t) {
                for (var e, i = 0; i < t.length && !(e = t[i++]); ) ;
                if (e) {
                    var n = [];
                    return R(e, function(t, e) {
                        n.push(e);
                    }), n;
                }
            }(t), s = !0); else if (e === ef) r || (r = [], s = !0, R(t, function(t, e) {
                r.push(e);
            })); else if (e === Qd) {
                var h = $e(t[0]);
                a = P(h) && h.length || 1;
            }
            return s && R(r, function(t, e) {
                "name" === (L(t) ? t.name : t) && (l = e);
            }), {
                startIndex: o,
                dimensionsDefine: nr(r),
                dimensionsDetectCount: a,
                potentialNameDimIndex: l
            };
        }(r, a, s, l, h), f = n.encode;
        !f && u && (f = function(t, e, i, n, r, a) {
            var o = Jn(t), s = {}, l = [], h = [], u = t.subType, c = T([ "pie", "map", "funnel" ]), d = T([ "line", "bar", "pictorialBar", "scatter", "effectScatter", "candlestick", "boxplot" ]);
            if (o && null != d.get(u)) {
                var f = t.ecModel, p = sf(f).datasetMap, g = e.uid + "_" + r, m = p.get(g) || p.set(g, {
                    categoryWayDim: 1,
                    valueWayDim: 0
                });
                R(o.coordSysDims, function(t) {
                    if (null == o.firstCategoryDimIndex) {
                        var e = m.valueWayDim++;
                        s[t] = e, h.push(e);
                    } else if (o.categoryAxisMap.get(t)) s[t] = 0, l.push(0); else {
                        var e = m.categoryWayDim++;
                        s[t] = e, h.push(e);
                    }
                });
            } else if (null != c.get(u)) {
                for (var v, y = 0; y < 5 && null == v; y++) ar(i, n, r, a.dimensionsDefine, a.startIndex, y) || (v = y);
                if (null != v) {
                    s.value = v;
                    var x = a.potentialNameDimIndex || Math.max(v - 1, 0);
                    h.push(x), l.push(x);
                }
            }
            return l.length && (s.itemName = l), h.length && (s.seriesName = h), s;
        }(t, u, r, a, s, d)), sf(t).source = new er({
            data: r,
            fromDataset: o,
            seriesLayoutBy: s,
            sourceFormat: a,
            dimensionsDefine: d.dimensionsDefine,
            startIndex: d.startIndex,
            dimensionsDetectCount: d.dimensionsDetectCount,
            encodeDefine: f
        });
    }
    function nr(t) {
        if (t) {
            var i = T();
            return D(t, function(t) {
                if (null == (t = A({}, L(t) ? t : {
                    name: t
                })).name) return t;
                t.name += "", null == t.displayName && (t.displayName = t.name);
                var e = i.get(t.name);
                return e ? t.name += "-" + e.count++ : i.set(t.name, {
                    count: 1
                }), t;
            });
        }
    }
    function rr(t, e, i, n) {
        if (null == n && (n = 1 / 0), e === of) for (var r = 0; r < i.length && r < n; r++) t(i[r] ? i[r][0] : null, r); else {
            var a = i[0] || [];
            for (r = 0; r < a.length && r < n; r++) t(a[r], r);
        }
    }
    function ar(t, e, i, n, r, a) {
        function o(t) {
            return (null == t || !isFinite(t) || "" === t) && (!(!M(t) || "-" === t) || void 0);
        }
        var s, l;
        if (p(t)) return !1;
        if (n && (l = L(l = n[a]) ? l.name : l), e === Jd) if (i === of) {
            for (var h = t[a], u = 0; u < (h || []).length && u < 5; u++) if (null != (s = o(h[r + u]))) return s;
        } else for (u = 0; u < t.length && u < 5; u++) {
            var c = t[r + u];
            if (c && null != (s = o(c[a]))) return s;
        } else if (e === tf) {
            if (!l) return;
            for (u = 0; u < t.length && u < 5; u++) {
                if ((d = t[u]) && null != (s = o(d[l]))) return s;
            }
        } else if (e === ef) {
            if (!l) return;
            if (!(h = t[l]) || p(h)) return !1;
            for (u = 0; u < h.length && u < 5; u++) if (null != (s = o(h[u]))) return s;
        } else if (e === Qd) for (u = 0; u < t.length && u < 5; u++) {
            var d, f = $e(d = t[u]);
            if (!P(f)) return !1;
            if (null != (s = o(f[a]))) return s;
        }
        return !1;
    }
    function or(t) {
        var i, e, n;
        t = t, this.option = {}, this.option[lf] = 1, this._componentsMap = T({
            series: []
        }), this._seriesIndices, this._seriesIndicesMap, i = t, e = this._theme.option, 
        n = i.color && !i.colorLayer, R(e, function(t, e) {
            "colorLayer" === e && n || jd.hasClass(e) || ("object" == (void 0 === t ? "undefined" : _typeof(t)) ? i[e] = i[e] ? m(i[e], t, !1) : b(t) : null == i[e] && (i[e] = t));
        }), m(t, Yd, !1), this.mergeOption(t);
    }
    function sr(t, e) {
        t._seriesIndicesMap = T(t._seriesIndices = D(e, function(t) {
            return t.componentIndex;
        }) || []);
    }
    function lr(t, e) {
        return e.hasOwnProperty("subType") ? u(t, function(t) {
            return t.subType === e.subType;
        }) : t;
    }
    function hr(e) {
        R(uf, function(t) {
            this[t] = _(e[t], e);
        }, this);
    }
    function ur() {
        this._coordinateSystems = [];
    }
    function cr(t) {
        this._api = t, this._timelineOptions = [], this._mediaList = [], this._mediaDefault, 
        this._currentMediaIndices = [], this._optionBackup, this._newBaseOption;
    }
    function dr(t, e, i) {
        var l = {
            width: e,
            height: i,
            aspectratio: e / i
        }, h = !0;
        return R(t, function(t, e) {
            var i, n, r, a = e.match(mf);
            if (a && a[1] && a[2]) {
                var o = a[1], s = a[2].toLowerCase();
                i = l[s], n = t, ("min" === (r = o) ? n <= i : "max" === r ? i <= n : i === n) || (h = !1);
            }
        }), h;
    }
    function fr(t) {
        var e = t && t.itemStyle;
        if (e) for (var i = 0, n = xf.length; i < n; i++) {
            var r = xf[i], a = e.normal, o = e.emphasis;
            a && a[r] && (t[r] = t[r] || {}, t[r].normal ? m(t[r].normal, a[r]) : t[r].normal = a[r], 
            a[r] = null), o && o[r] && (t[r] = t[r] || {}, t[r].emphasis ? m(t[r].emphasis, o[r]) : t[r].emphasis = o[r], 
            o[r] = null);
        }
    }
    function pr(t, e, i) {
        if (t && t[e] && (t[e].normal || t[e].emphasis)) {
            var n = t[e].normal, r = t[e].emphasis;
            n && (i ? (t[e].normal = t[e].emphasis = null, C(t[e], n)) : t[e] = n), r && (t.emphasis = t.emphasis || {}, 
            t.emphasis[e] = r);
        }
    }
    function gr(t) {
        pr(t, "itemStyle"), pr(t, "lineStyle"), pr(t, "areaStyle"), pr(t, "label"), pr(t, "labelLine"), 
        pr(t, "upperLabel"), pr(t, "edgeLabel");
    }
    function mr(t, e) {
        var i = yf(t) && t[e], n = yf(i) && i.textStyle;
        if (n) for (var r = 0, a = Bu.length; r < a; r++) {
            e = Bu[r];
            n.hasOwnProperty(e) && (i[e] = n[e]);
        }
    }
    function vr(t) {
        t && (gr(t), mr(t, "label"), t.emphasis && mr(t.emphasis, "label"));
    }
    function yr(t) {
        return P(t) ? t : t ? [ t ] : [];
    }
    function xr(t) {
        return (P(t) ? t[0] : t) || {};
    }
    function _r(e) {
        R(wf, function(t) {
            t[0] in e && !(t[1] in e) && (e[t[1]] = e[t[0]]);
        });
    }
    function wr(m) {
        R(m, function(u, c) {
            var d = [], f = [ NaN, NaN ], t = [ u.stackResultDimension, u.stackedOverDimension ], p = u.data, g = u.isStackedByIndex, e = p.map(t, function(t, e, i) {
                var n, r, a = p.get(u.stackedDimension, i);
                if (isNaN(a)) return f;
                g ? r = p.getRawIndex(i) : n = p.get(u.stackedByDimension, i);
                for (var o = NaN, s = c - 1; 0 <= s; s--) {
                    var l = m[s];
                    if (g || (r = l.data.rawIndexOf(l.stackedByDimension, n)), 0 <= r) {
                        var h = l.data.getByRawIndex(l.stackResultDimension, r);
                        if (0 <= a && 0 < h || a <= 0 && h < 0) {
                            a += h, o = h;
                            break;
                        }
                    }
                }
                return d[0] = a, d[1] = o, d;
            });
            p.hostModel.setData(e), u.data = e;
        });
    }
    function br(t, e) {
        er.isInstance(t) || (t = er.seriesDataToSource(t)), this._source = t;
        var i = this._data = t.data, n = t.sourceFormat;
        n === rf && (this._offset = 0, this._dimSize = e, this._data = i), A(this, If[n === Jd ? n + "_" + t.seriesLayoutBy : n]);
    }
    function Sr() {
        return this._data.length;
    }
    function Mr(t) {
        return this._data[t];
    }
    function Ir(t) {
        for (var e = 0; e < t.length; e++) this._data.push(t[e]);
    }
    function Tr(t, e, i) {
        return null != i ? t[i] : t;
    }
    function Cr(t, e, i, n) {
        return Dr(t[n], this._dimensionInfos[e]);
    }
    function Dr(t, e) {
        var i = e && e.type;
        if ("ordinal" === i) {
            var n = e && e.ordinalMeta;
            return n ? n.parseAndCollect(t) : t;
        }
        return "time" === i && "number" != typeof t && null != t && "-" !== t && (t = +Nn(t)), 
        null == t || "" === t ? NaN : +t;
    }
    function Ar(t, e, i) {
        if (t) {
            var n = t.getRawDataItem(e);
            if (null != n) {
                var r, a, o = t.getProvider().getSource().sourceFormat, s = t.getDimensionInfo(i);
                return s && (r = s.name, a = s.index), Tf[o](n, e, a, r);
            }
        }
    }
    function kr(t, e, i) {
        if (t) {
            var n = t.getProvider().getSource().sourceFormat;
            if (n === Qd || n === tf) {
                var r = t.getRawDataItem(e);
                return n !== Qd || L(r) || (r = null), r ? r[i] : void 0;
            }
        }
    }
    function Pr(t) {
        return new Lr(t);
    }
    function Lr(t) {
        t = t || {}, this._reset = t.reset, this._plan = t.plan, this._count = t.count, 
        this._onDirty = t.onDirty, this._dirty = !0, this.context;
    }
    function Or(t, e, i, n, r, a) {
        Pf.reset(i, n, r, a), t._callingProgress = e, t._callingProgress({
            start: i,
            end: n,
            count: n - i,
            next: Pf.next
        }, t.context);
    }
    function Er(t) {
        var i, e, n, r = t.name;
        Qe(t) || (t.name = (i = t.getRawData(), e = i.mapDimension("seriesName", !0), n = [], 
        R(e, function(t) {
            var e = i.getDimensionInfo(t);
            e.displayName && n.push(e.displayName);
        }), n.join(" ") || r));
    }
    function zr(t) {
        return t.model.getRawData().count();
    }
    function Br(t) {
        var e = t.model;
        return e.setData(e.getRawData().cloneShallow()), Rr;
    }
    function Rr(t, e) {
        t.end > e.outputData.count() && e.model.getRawData().cloneShallow(e.outputData);
    }
    function Nr(e, i) {
        R(e.CHANGABLE_METHODS, function(t) {
            e.wrapMethod(t, g(Fr, i));
        });
    }
    function Fr(t) {
        var e = Gr(t);
        e && e.setOutputEnd(this.count());
    }
    function Gr(t) {
        var e = (t.ecModel || {}).scheduler, i = e && e.getPipeline(t.uid);
        if (i) {
            var n = i.currentTask;
            if (n) {
                var r = n.agentStubMap;
                r && (n = r.get(t.uid));
            }
            return n;
        }
    }
    function Vr() {
        this.group = new Hh(), this.uid = An("viewChart"), this.renderTask = Pr({
            plan: Xr,
            reset: qr
        }), this.renderTask.context = {
            view: this
        };
    }
    function Hr(t, e) {
        if (t && (t.trigger(e), "group" === t.type)) for (var i = 0; i < t.childCount(); i++) Hr(t.childAt(i), e);
    }
    function Wr(e, t, i) {
        var n = ti(e, t);
        null != n ? R(Ye(n), function(t) {
            Hr(e.getItemGraphicEl(t), i);
        }) : e.eachItemGraphicEl(function(t) {
            Hr(t, i);
        });
    }
    function Xr(t) {
        return Nf(t.model);
    }
    function qr(t) {
        var e = t.model, i = t.ecModel, n = t.api, r = t.payload, a = e.pipelineContext.progressiveRender, o = t.view, s = r && Rf(r).updateMethod, l = a ? "incrementalPrepareRender" : s && o[s] ? s : "render";
        return "render" !== l && o[l](e, i, n, r), Gf[l];
    }
    function jr(t, i, n) {
        function r() {
            c = new Date().getTime(), d = null, t.apply(s, l || []);
        }
        var a, o, s, l, h, u = 0, c = 0, d = null;
        i = i || 0;
        var e = function() {
            a = new Date().getTime(), s = this, l = arguments;
            var t = h || i, e = h || n;
            h = null, o = a - (e ? u : c) - t, clearTimeout(d), e ? d = setTimeout(r, t) : 0 <= o ? r() : d = setTimeout(r, -o), 
            u = a;
        };
        return e.clear = function() {
            d && (clearTimeout(d), d = null);
        }, e.debounceNextCall = function(t) {
            h = t;
        }, e;
    }
    function Ur(t, e, i, n) {
        this.ecInstance = t, this.api = e, this.unfinished;
        i = this._dataProcessorHandlers = i.slice(), n = this._visualHandlers = n.slice();
        this._allHandlers = i.concat(n), this._stageTaskMap = T();
    }
    function Yr(s, t, l, h, u) {
        function c(t, e) {
            return t.setDirty && (!t.dirtyMap || t.dirtyMap.get(e.__pipeline.id));
        }
        var d;
        u = u || {}, R(t, function(i) {
            if (!u.visualType || u.visualType === i.visualType) {
                var t = s._stageTaskMap.get(i.uid), e = t.seriesTaskMap, n = t.overallTask;
                if (n) {
                    var r, a = n.agentStubMap;
                    a.each(function(t) {
                        c(u, t) && (t.dirty(), r = !0);
                    }), r && n.dirty(), Zf(n, h);
                    var o = s.getPerformArgs(n, u.block);
                    a.each(function(t) {
                        t.perform(o);
                    }), d |= n.perform(o);
                } else e && e.each(function(t) {
                    c(u, t) && t.dirty();
                    var e = s.getPerformArgs(t, u.block);
                    e.skip = !i.performRawSeries && l.isSeriesFiltered(t.context.model), Zf(t, h), d |= t.perform(e);
                });
            }
        }), s.unfinished |= d;
    }
    function Zr(t) {
        t.overallReset(t.ecModel, t.api, t.payload);
    }
    function $r(t) {
        return t.overallProgress && Kr;
    }
    function Kr() {
        this.agent.dirty(), this.getDownstream().dirty();
    }
    function Qr() {
        this.agent && this.agent.dirty();
    }
    function Jr(t) {
        return t.plan && t.plan(t.model, t.ecModel, t.api, t.payload);
    }
    function ta(t) {
        t.useClearVisual && t.data.clearAllVisual();
        var e = t.resetDefines = Ye(t.reset(t.model, t.ecModel, t.api, t.payload));
        return 1 < e.length ? D(e, function(t, e) {
            return ea(e);
        }) : $f;
    }
    function ea(a) {
        return function(t, e) {
            var i = e.data, n = e.resetDefines[a];
            if (n && n.dataEach) for (var r = t.start; r < t.end; r++) n.dataEach(i, r); else n && n.progress && n.progress(t, i);
        };
    }
    function ia(t) {
        return t.data.count();
    }
    function na(t, e, i) {
        var n = e.uid, r = t._pipelineMap.get(n);
        !r.head && (r.head = i), r.tail && r.tail.pipe(i), (r.tail = i).__idxInPipeline = r.count++, 
        i.__pipeline = r;
    }
    function ra(t, e) {
        for (var i in e.prototype) t[i] = B;
    }
    function aa(t) {
        M(t) && (t = new DOMParser().parseFromString(t, "text/xml"));
        for (9 === t.nodeType && (t = t.firstChild); "svg" !== t.nodeName.toLowerCase() || 1 !== t.nodeType; ) t = t.nextSibling;
        return t;
    }
    function oa(t, e) {
        t && t.__inheritedStyle && (e.__inheritedStyle || (e.__inheritedStyle = {}), C(e.__inheritedStyle, t.__inheritedStyle));
    }
    function sa(t) {
        for (var e = f(t).split(sp), i = [], n = 0; n < e.length; n += 2) {
            var r = parseFloat(e[n]), a = parseFloat(e[n + 1]);
            i.push([ r, a ]);
        }
        return i;
    }
    function la(t, e, i, n) {
        var r = e.__inheritedStyle || {}, a = "text" === e.type;
        if (1 === t.nodeType && (function(t, e) {
            var i = t.getAttribute("transform");
            if (i) {
                i = i.replace(/,/g, " ");
                var n = null, r = [];
                i.replace(dp, function(t, e, i) {
                    r.push(e, i);
                });
                for (var a = r.length - 1; 0 < a; a -= 2) {
                    var o = r[a], s = r[a - 1];
                    switch (n = n || lt(), s) {
                      case "translate":
                        o = f(o).split(sp), dt(n, n, [ parseFloat(o[0]), parseFloat(o[1] || 0) ]);
                        break;

                      case "scale":
                        o = f(o).split(sp), pt(n, n, [ parseFloat(o[0]), parseFloat(o[1] || o[0]) ]);
                        break;

                      case "rotate":
                        o = f(o).split(sp), ft(n, n, parseFloat(o[0]));
                        break;

                      case "skew":
                        o = f(o).split(sp), console.warn("Skew transform is not supported yet");
                        break;

                      case "matrix":
                        var o = f(o).split(sp);
                        n[0] = parseFloat(o[0]), n[1] = parseFloat(o[1]), n[2] = parseFloat(o[2]), n[3] = parseFloat(o[3]), 
                        n[4] = parseFloat(o[4]), n[5] = parseFloat(o[5]);
                    }
                }
            }
            e.setLocalTransform(n);
        }(t, e), A(r, function(t) {
            var e = t.getAttribute("style"), i = {};
            if (!e) return i;
            var n, r = {};
            for (fp.lastIndex = 0; null != (n = fp.exec(e)); ) r[n[1]] = n[2];
            for (var a in up) up.hasOwnProperty(a) && null != r[a] && (i[up[a]] = r[a]);
            return i;
        }(t)), !n)) for (var o in up) if (up.hasOwnProperty(o)) {
            var s = t.getAttribute(o);
            null != s && (r[up[o]] = s);
        }
        var l = a ? "textFill" : "fill", h = a ? "textStroke" : "stroke";
        e.style = e.style || new Zh();
        var u = e.style;
        null != r.fill && u.set(l, ha(r.fill, i)), null != r.stroke && u.set(h, ha(r.stroke, i)), 
        R([ "lineWidth", "opacity", "fillOpacity", "strokeOpacity", "miterLimit", "fontSize" ], function(t) {
            var e = "lineWidth" === t && a ? "textStrokeWidth" : t;
            null != r[t] && u.set(e, parseFloat(r[t]));
        }), r.textBaseline && "auto" !== r.textBaseline || (r.textBaseline = "alphabetic"), 
        "alphabetic" === r.textBaseline && (r.textBaseline = "bottom"), "start" === r.textAlign && (r.textAlign = "left"), 
        "end" === r.textAlign && (r.textAlign = "right"), R([ "lineDashOffset", "lineCap", "lineJoin", "fontWeight", "fontFamily", "fontStyle", "textAlign", "textBaseline" ], function(t) {
            null != r[t] && u.set(t, r[t]);
        }), r.lineDash && (e.style.lineDash = f(r.lineDash).split(sp)), u[h] && "none" !== u[h] && (e[h] = !0), 
        e.__inheritedStyle = r;
    }
    function ha(t, e) {
        var i = e && t && t.match(cp);
        return i ? e[f(i[1])] : t;
    }
    function ua(n) {
        return function(t, e, i) {
            t = t && t.toLowerCase(), th.prototype[n].call(this, t, e, i);
        };
    }
    function ca() {
        th.call(this);
    }
    function da(t, e, i) {
        function n(t, e) {
            return t.__prio - e.__prio;
        }
        i = i || {}, "string" == typeof e && (e = Lp[e]), this.id, this.group, this._dom = t;
        var r = this._zr = Ue(t, {
            renderer: i.renderer || "canvas",
            devicePixelRatio: i.devicePixelRatio,
            width: i.width,
            height: i.height
        });
        this._throttledZrFlush = jr(_(r.flush, r), 17), (e = b(e)) && Sf(e, !0), this._theme = e, 
        this._chartsViews = [], this._chartsMap = {}, this._componentsViews = [], this._componentsMap = {}, 
        this._coordSysMgr = new ur();
        var a, o, s, l, h = this._api = (o = (a = this)._coordSysMgr, A(new hr(a), {
            getCoordinateSystems: _(o.getCoordinateSystems, o),
            getComponentByElement: function(t) {
                for (;t; ) {
                    var e = t.__ecComponentInfo;
                    if (null != e) return a._model.getComponent(e.mainType, e.index);
                    t = t.parent;
                }
            }
        }));
        te(Pp, n), te(Dp, n), this._scheduler = new Ur(this, h, Dp, Pp), th.call(this, this._ecEventProcessor = new Ta()), 
        this._messageCenter = new ca(), this._initEvents(), this.resize = _(this.resize, this), 
        this._pendingActions = [], r.animation.on("frame", this._onframe, this), l = this, 
        (s = r).on("rendered", function() {
            l.trigger("rendered"), !s.animation.isFinished() || l[wp] || l._scheduler.unfinished || l._pendingActions.length || l.trigger("finished");
        }), x(this);
    }
    function fa(t, e, i) {
        var n, r = this._model, a = this._coordSysMgr.getCoordinateSystems();
        e = ii(r, e);
        for (var o = 0; o < a.length; o++) {
            var s = a[o];
            if (s[t] && null != (n = s[t](r, e, i))) return n;
        }
    }
    function pa(t) {
        var e = t._model, i = t._scheduler;
        i.restorePipelines(e), i.prepareStageTasks(), _a(t, "component", e, i), _a(t, "chart", e, i), 
        i.plan();
    }
    function ga(e, i, n, r, t) {
        function a(t) {
            t && t.__alive && t[i] && t[i](t.__model, o, e._api, n);
        }
        var o = e._model;
        if (r) {
            var s = {};
            s[r + "Id"] = n[r + "Id"], s[r + "Index"] = n[r + "Index"], s[r + "Name"] = n[r + "Name"];
            var l = {
                mainType: r,
                query: s
            };
            t && (l.subType = t);
            var h = n.excludeSeriesId;
            null != h && (h = T(Ye(h))), o && o.eachComponent(l, function(t) {
                h && null != h.get(t.id) || a(e["series" === r ? "_chartsMap" : "_componentsMap"][t.__viewId]);
            }, e);
        } else gp(e._componentsViews.concat(e._chartsViews), a);
    }
    function ma(t, e) {
        var i = t._chartsMap, n = t._scheduler;
        e.eachSeries(function(t) {
            n.updateStreamModes(t, i[t.__viewId]);
        });
    }
    function va(e, t) {
        var i = e.type, n = e.escapeConnect, r = Tp[i], a = r.actionInfo, o = (a.update || "update").split(":"), s = o.pop();
        o = null != o[0] && yp(o[0]), this[_p] = !0;
        var l = [ e ], h = !1;
        e.batch && (h = !0, l = D(e.batch, function(t) {
            return (t = C(A({}, t), e)).batch = null, t;
        }));
        var u, c = [], d = "highlight" === i || "downplay" === i;
        gp(l, function(t) {
            (u = (u = r.action(t, this._model, this._api)) || A({}, t)).type = a.event || u.type, 
            c.push(u), d ? ga(this, s, t, "series") : o && ga(this, s, t, o.main, o.sub);
        }, this), "none" === s || d || o || (this[wp] ? (pa(this), Mp.update.call(this, e), 
        this[wp] = !1) : Mp[s].call(this, e)), u = h ? {
            type: a.event || i,
            escapeConnect: n,
            batch: c
        } : c[0], this[_p] = !1, !t && this._messageCenter.trigger(u.type, u);
    }
    function ya(t) {
        for (var e = this._pendingActions; e.length; ) {
            var i = e.shift();
            va.call(this, i, t);
        }
    }
    function xa(t) {
        !t && this.trigger("updated");
    }
    function _a(t, e, r, a) {
        function i(t) {
            var e = "_ec_" + t.id + "_" + t.type, i = l[e];
            if (!i) {
                var n = yp(t.type);
                (i = new (o ? Ef.getClass(n.main, n.sub) : Vr.getClass(n.sub))()).init(r, u), l[e] = i, 
                s.push(i), h.add(i.group);
            }
            t.__viewId = i.__id = e, i.__alive = !0, i.__model = t, i.group.__ecComponentInfo = {
                mainType: t.mainType,
                index: t.componentIndex
            }, !o && a.prepareView(i, t, r, u);
        }
        for (var o = "component" === e, s = o ? t._componentsViews : t._chartsViews, l = o ? t._componentsMap : t._chartsMap, h = t._zr, u = t._api, n = 0; n < s.length; n++) s[n].__alive = !1;
        o ? r.eachComponent(function(t, e) {
            "series" !== t && i(e);
        }) : r.eachSeries(i);
        for (n = 0; n < s.length; ) {
            var c = s[n];
            c.__alive ? n++ : (!o && c.renderTask.dispose(), h.remove(c.group), c.dispose(r, u), 
            s.splice(n, 1), delete l[c.__id], c.__id = c.group.__ecComponentInfo = null);
        }
    }
    function wa(t) {
        t.clearColorPalette(), t.eachSeries(function(t) {
            t.clearColorPalette();
        });
    }
    function ba(t, e, i, n) {
        var r, a, o, s, l;
        r = t, a = e, o = i, s = n, gp(l || r._componentsViews, function(t) {
            var e = t.__model;
            t.render(e, a, o, s), Ia(e, t);
        }), gp(t._chartsViews, function(t) {
            t.__alive = !1;
        }), Sa(t, e, i, n), gp(t._chartsViews, function(t) {
            t.__alive || t.remove(e, i);
        });
    }
    function Sa(a, t, e, o, s) {
        var l, i, n, r, h, u = a._scheduler;
        t.eachSeries(function(t) {
            var e = a._chartsMap[t.__viewId];
            e.__alive = !0;
            var i, n, r = e.renderTask;
            u.updatePayload(r, o), s && s.get(t.uid) && r.dirty(), l |= r.perform(u.getPerformArgs(r)), 
            e.group.silent = !!t.get("silent"), Ia(t, e), i = e, n = t.get("blendMode") || null, 
            i.group.traverse(function(t) {
                t.isGroup || t.style.blend !== n && t.setStyle("blend", n), t.eachPendingDisplayable && t.eachPendingDisplayable(function(t) {
                    t.setStyle("blend", n);
                });
            });
        }), u.unfinished |= l, i = a._zr, n = t, r = i.storage, h = 0, r.traverse(function(t) {
            t.isGroup || h++;
        }), h > n.get("hoverLayerThreshold") && !Ll.node && r.traverse(function(t) {
            t.isGroup || (t.useHoverLayer = !0);
        }), jf(a._zr.dom, t);
    }
    function Ma(e, i) {
        gp(kp, function(t) {
            t(e, i);
        });
    }
    function Ia(t, e) {
        var i = t.get("z"), n = t.get("zlevel");
        e.group.traverse(function(t) {
            "group" !== t.type && (null != i && (t.z = i), null != n && (t.zlevel = n));
        });
    }
    function Ta() {
        this.eventInfo;
    }
    function Ca(t) {
        zp[t] = !1;
    }
    function Da(t) {
        return Ep[(e = t, i = Np, e.getAttribute ? e.getAttribute(i) : e[i])];
        var e, i;
    }
    function Aa(t, e) {
        Lp[t] = e;
    }
    function ka(t) {
        Ap.push(t);
    }
    function Pa(t, e) {
        za(Dp, t, e, 1e3);
    }
    function La(t, e, i) {
        "function" == typeof e && (i = e, e = "");
        var n = vp(t) ? t.type : [ t, t = {
            event: e
        } ][0];
        t.event = (t.event || n).toLowerCase(), e = t.event, pp(bp.test(n) && bp.test(e)), 
        Tp[n] || (Tp[n] = {
            action: i,
            actionInfo: t
        }), Cp[e] = n;
    }
    function Oa(t, e) {
        za(Pp, t, e, 1e3, "layout");
    }
    function Ea(t, e) {
        za(Pp, t, e, 3e3, "visual");
    }
    function za(t, e, i, n, r) {
        (mp(e) || vp(e)) && (i = e, e = n);
        var a = Ur.wrapStageHandler(i, r);
        return a.__prio = e, a.__raw = i, t.push(a), a;
    }
    function Ba(t, e) {
        Op[t] = e;
    }
    function Ra(t) {
        return jd.extend(t);
    }
    function Na(t) {
        return Ef.extend(t);
    }
    function Fa(t) {
        return Of.extend(t);
    }
    function Ga(t) {
        return Vr.extend(t);
    }
    function Va(t) {
        return t;
    }
    function Ha(t, e, i, n, r) {
        this._old = t, this._new = e, this._oldKeyGetter = i || Va, this._newKeyGetter = n || Va, 
        this.context = r;
    }
    function Wa(t, e, i, n, r) {
        for (var a = 0; a < t.length; a++) {
            var o = "_ec_" + r[n](t[a], a), s = e[o];
            null == s ? (i.push(o), e[o] = a) : (s.length || (e[o] = s = [ s ]), s.push(a));
        }
    }
    function Xa(t) {
        return 65535 < t._rawCount ? Xp : qp;
    }
    function qa(e, i) {
        R(jp.concat(i.__wrappedMethods || []), function(t) {
            i.hasOwnProperty(t) && (e[t] = i[t]);
        }), e.__wrappedMethods = i.__wrappedMethods, R(Up, function(t) {
            e[t] = b(i[t]);
        }), e._calculationInfo = A(i._calculationInfo);
    }
    function ja(t, e, i) {
        var n;
        if (null != e) {
            var r = t._chunkSize, a = Math.floor(i / r), o = i % r, s = t.dimensions[e], l = t._storage[s][a];
            if (l) {
                n = l[o];
                var h = t._dimensionInfos[s].ordinalMeta;
                h && h.categories.length && (n = h.categories[n]);
            }
        }
        return n;
    }
    function Ua(t) {
        return t;
    }
    function Ya(t) {
        return t < this._count && 0 <= t ? this._indices[t] : -1;
    }
    function Za(t, e) {
        var i = t._idList[e];
        return null == i && (i = ja(t, t._idDimIdx, e)), null == i && (i = "e\0\0" + e), 
        i;
    }
    function $a(t) {
        return P(t) || (t = [ t ]), t;
    }
    function Ka(t, e) {
        var i = t.dimensions, n = new Yp(D(i, t.getDimensionInfo, t), t.hostModel);
        qa(n, t);
        for (var r = n._storage = {}, a = t._storage, o = 0; o < i.length; o++) {
            var s = i[o];
            a[s] && (0 <= d(e, s) ? (r[s] = Qa(a[s]), n._rawExtent[s] = [ 1 / 0, -1 / 0 ], n._extent[s] = null) : r[s] = a[s]);
        }
        return n;
    }
    function Qa(t) {
        for (var e = new Array(t.length), i = 0; i < t.length; i++) e[i] = (n = t[i], r = void 0, 
        (r = n.constructor) === Array ? n.slice() : new r(n));
        var n, r;
        return e;
    }
    function Ja(t, e, i) {
        function l(t, e, i) {
            null != Gp.get(e) ? t.otherDims[e] = i : (t.coordDim = e, t.coordDimIndex = i, a.set(e, !0));
        }
        er.isInstance(e) || (e = er.seriesDataToSource(e)), i = i || {}, t = (t || []).slice();
        for (var n = (i.dimsDef || []).slice(), h = T(i.encodeDef), r = T(), a = T(), u = [], o = function(t, e, i, n) {
            var r = Math.max(t.dimensionsDetectCount || 1, e.length, i.length, n || 0);
            return R(e, function(t) {
                var e = t.dimsDef;
                e && (r = Math.max(r, e.length));
            }), r;
        }(e, t, n, i.dimCount), s = 0; s < o; s++) {
            var c = n[s] = A({}, L(n[s]) ? n[s] : {
                name: n[s]
            }), d = c.name, f = u[s] = {
                otherDims: {}
            };
            null != d && null == r.get(d) && (f.name = f.displayName = d, r.set(d, s)), null != c.type && (f.type = c.type), 
            null != c.displayName && (f.displayName = c.displayName);
        }
        h.each(function(t, i) {
            if (1 === (t = Ye(t).slice()).length && t[0] < 0) h.set(i, !1); else {
                var n = h.set(i, []);
                R(t, function(t, e) {
                    M(t) && (t = r.get(t)), null != t && t < o && (n[e] = t, l(u[t], i, e));
                });
            }
        });
        var p = 0;
        R(t, function(r) {
            var a, o, s;
            if (M(r)) a = r, r = {}; else {
                a = r.name;
                var t = r.ordinalMeta;
                r.ordinalMeta = null, (r = b(r)).ordinalMeta = t, o = r.dimsDef, s = r.otherDims, 
                r.name = r.coordDim = r.coordDimIndex = r.dimsDef = r.otherDims = null;
            }
            if (!1 !== (e = h.get(a))) {
                var e;
                if (!(e = Ye(e)).length) for (var i = 0; i < (o && o.length || 1); i++) {
                    for (;p < u.length && null != u[p].coordDim; ) p++;
                    p < u.length && e.push(p++);
                }
                R(e, function(t, e) {
                    var i = u[t];
                    if (l(C(i, r), a, e), null == i.name && o) {
                        var n = o[e];
                        !L(n) && (n = {
                            name: n
                        }), i.name = i.displayName = n.name, i.defaultTooltip = n.defaultTooltip;
                    }
                    s && C(i.otherDims, s);
                });
            }
        });
        var g, m, v = i.generateCoord, y = i.generateCoordCount, x = null != y;
        y = v ? y || 1 : 0;
        for (var _ = v || "value", w = 0; w < o; w++) {
            null == (f = u[w] = u[w] || {}).coordDim && (f.coordDim = to(_, a, x), f.coordDimIndex = 0, 
            (!v || y <= 0) && (f.isExtraCoord = !0), y--), null == f.name && (f.name = to(f.coordDim, r)), 
            null == f.type && (g = e, m = w, f.name, ar(g.data, g.sourceFormat, g.seriesLayoutBy, g.dimensionsDefine, g.startIndex, m)) && (f.type = "ordinal");
        }
        return u;
    }
    function to(t, e, i) {
        if (i || null != e.get(t)) {
            for (var n = 0; null != e.get(t + n); ) n++;
            t += n;
        }
        return e.set(t, !0), t;
    }
    function eo(t, i, e) {
        var n, r, a, o, s = (e = e || {}).byIndex, l = e.stackedCoordDimension, h = !(!t || !t.get("stack"));
        if (R(i, function(t, e) {
            M(t) && (i[e] = t = {
                name: t
            }), h && !t.isExtraCoord && (s || n || !t.ordinalMeta || (n = t), r || "ordinal" === t.type || "time" === t.type || l && l !== t.coordDim || (r = t));
        }), !r || s || n || (s = !0), r) {
            a = "__\0ecstackresult", o = "__\0ecstackedover", n && (n.createInvertedIndices = !0);
            var u = r.coordDim, c = r.type, d = 0;
            R(i, function(t) {
                t.coordDim === u && d++;
            }), i.push({
                name: a,
                coordDim: u,
                coordDimIndex: d,
                type: c,
                isExtraCoord: !0,
                isCalculationCoord: !0
            }), d++, i.push({
                name: o,
                coordDim: o,
                coordDimIndex: d,
                type: c,
                isExtraCoord: !0,
                isCalculationCoord: !0
            });
        }
        return {
            stackedDimension: r && r.name,
            stackedByDimension: n && n.name,
            isStackedByIndex: s,
            stackedOverDimension: o,
            stackResultDimension: a
        };
    }
    function io(t, e) {
        return !!e && e === t.getCalculationInfo("stackedDimension");
    }
    function no(t, e) {
        return io(t, e) ? t.getCalculationInfo("stackResultDimension") : e;
    }
    function ro(t, e, i) {
        i = i || {}, er.isInstance(t) || (t = er.seriesDataToSource(t));
        var n, r = e.get("coordinateSystem"), a = ur.get(r), o = Jn(e);
        o && (n = D(o.coordSysDims, function(t) {
            var e, i = {
                name: t
            }, n = o.axisMap.get(t);
            if (n) {
                var r = n.get("type");
                i.type = "category" === (e = r) ? "ordinal" : "time" === e ? "time" : "float";
            }
            return i;
        })), n || (n = a && (a.getDimensionsInfo ? a.getDimensionsInfo() : a.dimensions.slice()) || [ "x", "y" ]);
        var s, l, h = Kp(t, {
            coordDimensions: n,
            generateCoord: i.generateCoord
        });
        o && R(h, function(t, e) {
            var i = t.coordDim, n = o.categoryAxisMap.get(i);
            n && (null == s && (s = e), t.ordinalMeta = n.getOrdinalMeta()), null != t.otherDims.itemName && (l = !0);
        }), l || null == s || (h[s].otherDims.itemName = 0);
        var u = eo(e, h), c = new Yp(h, e);
        c.setCalculationInfo(u);
        var d = null != s && function(t) {
            if (t.sourceFormat === Qd) {
                var e = function(t) {
                    for (var e = 0; e < t.length && null == t[e]; ) e++;
                    return t[e];
                }(t.data || []);
                return null != e && !P($e(e));
            }
        }(t) ? function(t, e, i, n) {
            return n === s ? i : this.defaultDimValueGetter(t, e, i, n);
        } : null;
        return c.hasItemOption = !1, c.initData(t, null, d), c;
    }
    function ao(t) {
        this._setting = t || {}, this._extent = [ 1 / 0, -1 / 0 ], this._interval = 0, this.init && this.init.apply(this, arguments);
    }
    function oo(t) {
        this.categories = t.categories || [], this._needCollect = t.needCollect, this._deduplication = t.deduplication, 
        this._map;
    }
    function so(t) {
        return t._map || (t._map = T(t.categories));
    }
    function lo(t) {
        return L(t) && null != t.value ? t.value : t + "";
    }
    function ho(t) {
        return On(t) + 2;
    }
    function uo(t, e, i) {
        t[e] = Math.max(Math.min(t[e], i[1]), i[0]);
    }
    function co(t, e) {
        !isFinite(t[0]) && (t[0] = e[0]), !isFinite(t[1]) && (t[1] = e[1]), uo(t, 0, e), 
        uo(t, 1, e), t[0] > t[1] && (t[0] = t[1]);
    }
    function fo(t) {
        return t.get("stack") || rg + t.seriesIndex;
    }
    function po(t) {
        return t.dim + t.index;
    }
    function go(t, e) {
        var i = [];
        return e.eachSeriesByType(t, function(t) {
            yo(t) && !xo(t) && i.push(t);
        }), i;
    }
    function mo(t) {
        var h = [];
        return R(t, function(t) {
            var e = t.getData(), i = t.coordinateSystem.getBaseAxis(), n = i.getExtent(), r = "category" === i.type ? i.getBandWidth() : Math.abs(n[1] - n[0]) / e.count(), a = Pn(t.get("barWidth"), r), o = Pn(t.get("barMaxWidth"), r), s = t.get("barGap"), l = t.get("barCategoryGap");
            h.push({
                bandWidth: r,
                barWidth: a,
                barMaxWidth: o,
                barGap: s,
                barCategoryGap: l,
                axisKey: po(i),
                stackId: fo(t)
            });
        }), function(t) {
            var u = {};
            R(t, function(t) {
                var e = t.axisKey, i = t.bandWidth, n = u[e] || {
                    bandWidth: i,
                    remainedWidth: i,
                    autoWidthCount: 0,
                    categoryGap: "20%",
                    gap: "30%",
                    stacks: {}
                }, r = n.stacks;
                u[e] = n;
                var a = t.stackId;
                r[a] || n.autoWidthCount++, r[a] = r[a] || {
                    width: 0,
                    maxWidth: 0
                };
                var o = t.barWidth;
                o && !r[a].width && (r[a].width = o, o = Math.min(n.remainedWidth, o), n.remainedWidth -= o);
                var s = t.barMaxWidth;
                s && (r[a].maxWidth = s);
                var l = t.barGap;
                null != l && (n.gap = l);
                var h = t.barCategoryGap;
                null != h && (n.categoryGap = h);
            });
            var d = {};
            return R(u, function(t, i) {
                d[i] = {};
                var e = t.stacks, n = t.bandWidth, r = Pn(t.categoryGap, n), a = Pn(t.gap, 1), o = t.remainedWidth, s = t.autoWidthCount, l = (o - r) / (s + (s - 1) * a);
                l = Math.max(l, 0), R(e, function(t) {
                    var e = t.maxWidth;
                    e && e < l && (e = Math.min(e, o), t.width && (e = Math.min(e, t.width)), o -= e, 
                    t.width = e, s--);
                }), l = (o - r) / (s + (s - 1) * a), l = Math.max(l, 0);
                var h, u = 0;
                R(e, function(t) {
                    t.width || (t.width = l), u += (h = t).width * (1 + a);
                }), h && (u -= h.width * a);
                var c = -u / 2;
                R(e, function(t, e) {
                    d[i][e] = d[i][e] || {
                        offset: c,
                        width: t.width
                    }, c += t.width * (1 + a);
                });
            }), d;
        }(h);
    }
    function vo(t, e, i) {
        if (t && e) {
            var n = t[po(e)];
            return null != n && null != i && (n = n[fo(i)]), n;
        }
    }
    function yo(t) {
        return t.coordinateSystem && "cartesian2d" === t.coordinateSystem.type;
    }
    function xo(t) {
        return t.pipelineContext && t.pipelineContext.large;
    }
    function _o(t, e) {
        var i, n, r = e.getGlobalExtent();
        r[0] > r[1] ? (i = r[1], n = r[0]) : (i = r[0], n = r[1]);
        var a = e.toGlobalCoord(e.dataToCoord(0));
        return a < i && (a = i), n < a && (a = n), a;
    }
    function wo(t, e) {
        return vg(t, mg(e));
    }
    function bo(t, e) {
        var i, n, r, a = t.type, o = e.getMin(), s = e.getMax(), l = null != o, h = null != s, u = t.getExtent();
        "ordinal" === a ? i = e.getCategories().length : (P(n = e.get("boundaryGap")) || (n = [ n || 0, n || 0 ]), 
        "boolean" == typeof n[0] && (n = [ 0, 0 ]), n[0] = Pn(n[0], 1), n[1] = Pn(n[1], 1), 
        r = u[1] - u[0] || Math.abs(u[0])), null == o && (o = "ordinal" === a ? i ? 0 : NaN : u[0] - n[0] * r), 
        null == s && (s = "ordinal" === a ? i ? i - 1 : NaN : u[1] + n[1] * r), "dataMin" === o ? o = u[0] : "function" == typeof o && (o = o({
            min: u[0],
            max: u[1]
        })), "dataMax" === s ? s = u[1] : "function" == typeof s && (s = s({
            min: u[0],
            max: u[1]
        })), (null == o || !isFinite(o)) && (o = NaN), (null == s || !isFinite(s)) && (s = NaN), 
        t.setBlank(y(o) || y(s) || "ordinal" === a && !t.getOrdinalMeta().categories.length), 
        e.getNeedCrossZero() && (0 < o && 0 < s && !l && (o = 0), o < 0 && s < 0 && !h && (s = 0));
        var c = e.ecModel;
        if (c && "time" === a) {
            var d, f = go("bar", c);
            if (R(f, function(t) {
                d |= t.getBaseAxis() === e.axis;
            }), d) {
                var p = mo(f), g = function(t, e, i, n) {
                    var r = i.axis.getExtent(), a = r[1] - r[0], o = vo(n, i.axis);
                    if (void 0 === o) return {
                        min: t,
                        max: e
                    };
                    var s = 1 / 0;
                    R(o, function(t) {
                        s = Math.min(t.offset, s);
                    });
                    var l = -1 / 0;
                    R(o, function(t) {
                        l = Math.max(t.offset + t.width, l);
                    }), s = Math.abs(s), l = Math.abs(l);
                    var h = s + l, u = e - t, c = u / (1 - (s + l) / a) - u;
                    return {
                        min: t -= c * (s / h),
                        max: e += c * (l / h)
                    };
                }(o, s, e, p);
                o = g.min, s = g.max;
            }
        }
        return [ o, s ];
    }
    function So(t, e) {
        var i = bo(t, e), n = null != e.getMin(), r = null != e.getMax(), a = e.get("splitNumber");
        "log" === t.type && (t.base = e.get("logBase"));
        var o = t.type;
        t.setExtent(i[0], i[1]), t.niceExtent({
            splitNumber: a,
            fixMin: n,
            fixMax: r,
            minInterval: "interval" === o || "time" === o ? e.get("minInterval") : null,
            maxInterval: "interval" === o || "time" === o ? e.get("maxInterval") : null
        });
        var s = e.get("interval");
        null != s && t.setInterval && t.setInterval(s);
    }
    function Mo(t, e) {
        if (e = e || t.get("type")) switch (e) {
          case "category":
            return new tg(t.getOrdinalMeta ? t.getOrdinalMeta() : t.getCategories(), [ 1 / 0, -1 / 0 ]);

          case "value":
            return new ng();

          default:
            return (ao.getClass(e) || ng).create(t);
        }
    }
    function Io(i) {
        var e, n = i.getLabelModel().get("formatter"), r = "category" === i.type ? i.scale.getExtent()[0] : null;
        return "string" == typeof n ? (e = n, n = function(t) {
            return t = i.scale.getLabel(t), e.replace("{value}", null != t ? t : "");
        }) : "function" == typeof n ? function(t, e) {
            return null != r && (e = t - r), n(To(i, t), e);
        } : function(t) {
            return i.scale.getLabel(t);
        };
    }
    function To(t, e) {
        return "category" === t.type ? t.scale.getLabel(e) : e;
    }
    function Co(t, e) {
        if ("image" !== this.type) {
            var i = this.style, n = this.shape;
            n && "line" === n.symbolType ? i.stroke = t : this.__isEmptyBrush ? (i.stroke = t, 
            i.fill = e || "#fff") : (i.fill && (i.fill = t), i.stroke && (i.stroke = t)), this.dirty(!1);
        }
    }
    function Do(t, e, i, n, r, a, o) {
        var s, l = 0 === t.indexOf("empty");
        return l && (t = t.substr(5, 1).toLowerCase() + t.substr(6)), (s = 0 === t.indexOf("image://") ? ji(t.slice(8), new Yt(e, i, n, r), o ? "center" : "cover") : 0 === t.indexOf("path://") ? qi(t.slice(7), {}, new Yt(e, i, n, r), o ? "center" : "cover") : new kg({
            shape: {
                symbolType: t,
                x: e,
                y: i,
                width: n,
                height: r
            }
        })).__isEmptyBrush = l, s.setColor = Co, s.setColor(a), s;
    }
    function Ao(t, e) {
        return Math.abs(t - e) < Og;
    }
    function ko(t, e, i) {
        var n = 0, r = t[0];
        if (!r) return !1;
        for (var a = 1; a < t.length; a++) {
            var o = t[a];
            n += Pi(r[0], r[1], o[0], o[1], e, i), r = o;
        }
        var s = t[0];
        return Ao(r[0], s[0]) && Ao(r[1], s[1]) || (n += Pi(r[0], r[1], s[0], s[1], e, i)), 
        0 !== n;
    }
    function Po(t, e, i) {
        if (this.name = t, this.geometries = e, i) i = [ i[0], i[1] ]; else {
            var n = this.getBoundingRect();
            i = [ n.x + n.width / 2, n.y + n.height / 2 ];
        }
        this.center = i;
    }
    function Lo(t, e, i) {
        for (var n = [], r = e[0], a = e[1], o = 0; o < t.length; o += 2) {
            var s = t.charCodeAt(o) - 64, l = t.charCodeAt(o + 1) - 64;
            s = s >> 1 ^ -(1 & s), l = l >> 1 ^ -(1 & l), r = s += r, a = l += a, n.push([ s / i, l / i ]);
        }
        return n;
    }
    function Oo(t) {
        return "category" === t.type ? (a = (r = t).getLabelModel(), o = zo(r, a), !a.get("show") || r.scale.isBlank() ? {
            labels: [],
            labelCategoryInterval: o.labelCategoryInterval
        } : o) : (e = (i = t).scale.getTicks(), n = Io(i), {
            labels: D(e, function(t, e) {
                return {
                    formattedLabel: n(t, e),
                    rawLabel: i.scale.getLabel(t),
                    tickValue: t
                };
            })
        });
        var i, e, n, r, a, o;
    }
    function Eo(t, e) {
        return "category" === t.type ? function(t, e) {
            var i, n, r = Bo(t, "ticks"), a = Vo(e), o = Ro(r, a);
            if (o) return o;
            if ((!e.get("show") || t.scale.isBlank()) && (i = []), v(a)) i = Go(t, a, !0); else if ("auto" === a) {
                var s = zo(t, t.getLabelModel());
                n = s.labelCategoryInterval, i = D(s.labels, function(t) {
                    return t.tickValue;
                });
            } else i = Fo(t, n = a, !0);
            return No(r, a, {
                ticks: i,
                tickCategoryInterval: n
            });
        }(t, e) : {
            ticks: t.scale.getTicks()
        };
    }
    function zo(t, e) {
        var i, n, r, a, o = Bo(t, "labels"), s = Vo(e), l = Ro(o, s);
        return l || (v(s) ? i = Go(t, s) : i = Fo(t, n = "auto" === s ? null != (a = zg(r = t).autoInterval) ? a : zg(r).autoInterval = r.calculateCategoryInterval() : s), 
        No(o, s, {
            labels: i,
            labelCategoryInterval: n
        }));
    }
    function Bo(t, e) {
        return zg(t)[e] || (zg(t)[e] = []);
    }
    function Ro(t, e) {
        for (var i = 0; i < t.length; i++) if (t[i].key === e) return t[i].value;
    }
    function No(t, e, i) {
        return t.push({
            key: e,
            value: i
        }), i;
    }
    function Fo(t, e, i) {
        function n(t) {
            l.push(i ? t : {
                formattedLabel: r(t),
                rawLabel: a.getLabel(t),
                tickValue: t
            });
        }
        var r = Io(t), a = t.scale, o = a.getExtent(), s = t.getLabelModel(), l = [], h = Math.max((e || 0) + 1, 1), u = o[0], c = a.count();
        0 !== u && 1 < h && 2 < c / h && (u = Math.round(Math.ceil(u / h) * h));
        var d = s.get("showMinLabel"), f = s.get("showMaxLabel");
        d && u !== o[0] && n(o[0]);
        for (var p = u; p <= o[1]; p += h) n(p);
        return f && p !== o[1] && n(o[1]), l;
    }
    function Go(t, i, n) {
        var r = t.scale, a = Io(t), o = [];
        return R(r.getTicks(), function(t) {
            var e = r.getLabel(t);
            i(t, e) && o.push(n ? t : {
                formattedLabel: a(t),
                rawLabel: e,
                tickValue: t
            });
        }), o;
    }
    function Vo(t) {
        var e = t.get("interval");
        return null == e ? "auto" : e;
    }
    function Ho(t, e) {
        var i = (t[1] - t[0]) / e / 2;
        t[0] += i, t[1] -= i;
    }
    function Wo(t) {
        return this._axes[t];
    }
    function Xo(t) {
        Vg.call(this, t);
    }
    function qo(t, e) {
        return e.type || (e.data ? "category" : "value");
    }
    function jo(t, e) {
        return t.getCoordSysModel() === e;
    }
    function Uo(t, e, i) {
        this._coordsMap = {}, this._coordsList = [], this._axesMap = {}, this._axesList = [], 
        this._initCartesian(t, e, i), this.model = t;
    }
    function Yo(t, e, i, n) {
        function r(t) {
            return t.dim + "_" + t.index;
        }
        i.getAxesOnZeroOf = function() {
            return a ? [ a ] : [];
        };
        var a, o = t[e], s = i.model, l = s.get("axisLine.onZero"), h = s.get("axisLine.onZeroAxisIndex");
        if (l) {
            if (null != h) Zo(o[h]) && (a = o[h]); else for (var u in o) if (o.hasOwnProperty(u) && Zo(o[u]) && !n[r(o[u])]) {
                a = o[u];
                break;
            }
            a && (n[r(a)] = !0);
        }
    }
    function Zo(t) {
        return t && "category" !== t.type && "time" !== t.type && (e = t.scale.getExtent(), 
        i = e[0], n = e[1], !(0 < i && 0 < n || i < 0 && n < 0));
        var e, i, n;
    }
    function $o(e) {
        return D($g, function(t) {
            return e.getReferringComponents(t)[0];
        });
    }
    function Ko(t) {
        return "cartesian2d" === t.get("coordinateSystem");
    }
    function Qo(t, e) {
        var i = t.mapDimension("defaultedLabel", !0), n = i.length;
        if (1 === n) return Ar(t, e, i[0]);
        if (n) {
            for (var r = [], a = 0; a < i.length; a++) {
                var o = Ar(t, e, i[a]);
                r.push(o);
            }
            return r.join(" ");
        }
    }
    function Jo(t, e) {
        "outside" === t.textPosition && (t.textPosition = e);
    }
    function ts(t, e, i) {
        i.style.text = null, wn(i, {
            shape: {
                width: 0
            }
        }, e, t, function() {
            i.parent && i.parent.remove(i);
        });
    }
    function es(t, e, i) {
        i.style.text = null, wn(i, {
            shape: {
                r: i.shape.r0
            }
        }, e, t, function() {
            i.parent && i.parent.remove(i);
        });
    }
    function is(t, e, i, n, r, a, o, s) {
        var l = e.getItemVisual(i, "color"), h = e.getItemVisual(i, "opacity"), u = n.getModel("itemStyle"), c = n.getModel("emphasis.itemStyle").getBarItemStyle();
        s || t.setShape("r", u.get("barBorderRadius") || 0), t.useStyle(C({
            fill: l,
            opacity: h
        }, u.getBarItemStyle()));
        var d = n.getShallow("cursor");
        d && t.attr("cursor", d);
        var f, p, g, m, v, y;
        o ? r.height : r.width;
        s || (f = t.style, m = l, v = a, y = i, dn(f, p = c, (g = n).getModel("label"), g.getModel("emphasis.label"), {
            labelFetcher: v,
            labelDataIndex: y,
            defaultText: Qo(v.getData(), y),
            isRectText: !0,
            autoColor: m
        }), Jo(f), Jo(p)), un(t, c);
    }
    function ns(t, e, i) {
        var n = t.getData(), r = [], a = n.getLayout("valueAxisHorizontal") ? 1 : 0;
        r[1 - a] = n.getLayout("valueAxisStart");
        var o, s, l, h, u, c = new em({
            shape: {
                points: n.getLayout("largePoints")
            },
            incremental: !!i,
            __startPoint: r,
            __valueIdx: a
        });
        e.add(c), o = c, s = t, h = (l = n).getVisual("borderColor") || l.getVisual("color"), 
        u = s.getModel("itemStyle").getItemStyle([ "color", "borderColor" ]), o.useStyle(u), 
        o.style.fill = null, o.style.stroke = h, o.style.lineWidth = l.getLayout("barWidth");
    }
    function rs(t) {
        var e = {
            componentType: t.mainType,
            componentIndex: t.componentIndex
        };
        return e[t.mainType + "Index"] = t.componentIndex, e;
    }
    function as(t) {
        var e = t.get("tooltip");
        return t.get("silent") || !(t.get("triggerEvent") || e && e.show);
    }
    function os(t) {
        t && (t.ignore = !0);
    }
    function ss(t, e) {
        var i = t && t.getBoundingRect().clone(), n = e && e.getBoundingRect().clone();
        if (i && n) {
            var r = ht([]);
            return ft(r, r, -t.rotation), i.applyTransform(ct([], r, t.getLocalTransform())), 
            n.applyTransform(ct([], r, e.getLocalTransform())), i.intersect(n);
        }
    }
    function ls(t) {
        return "middle" === t || "center" === t;
    }
    function hs(t, e) {
        var p, g, i, o, m, v, y, n = {
            axesInfo: {},
            seriesInvolved: !1,
            coordSysAxesInfo: {},
            coordSysMap: {}
        };
        return p = n, i = e, o = (g = t).getComponent("tooltip"), m = g.getComponent("axisPointer"), 
        v = m.get("link", !0) || [], y = [], om(i.getCoordinateSystems(), function(c) {
            function t(t, e, i) {
                var n = i.model.getModel("axisPointer", m), r = n.get("show");
                if (r && ("auto" !== r || t || ds(n))) {
                    null == e && (e = n.get("triggerTooltip"));
                    var a = (n = t ? function(t, e, i, n, r, a) {
                        var o = e.getModel("axisPointer"), s = {};
                        om([ "type", "snap", "lineStyle", "shadowStyle", "label", "animation", "animationDurationUpdate", "animationEasingUpdate", "z" ], function(t) {
                            s[t] = b(o.get(t));
                        }), s.snap = "category" !== t.type && !!a, "cross" === o.get("type") && (s.type = "line");
                        var l = s.label || (s.label = {});
                        if (null == l.show && (l.show = !1), "cross" === r) {
                            var h = o.get("label.show");
                            if (l.show = null == h || h, !a) {
                                var u = s.lineStyle = o.get("crossStyle");
                                u && C(l, u.textStyle);
                            }
                        }
                        return t.model.getModel("axisPointer", new Tn(s, i, n));
                    }(i, f, m, g, t, e) : n).get("snap"), o = ps(i.model), s = e || a || "category" === i.type, l = p.axesInfo[o] = {
                        key: o,
                        axis: i,
                        coordSys: c,
                        axisPointerModel: n,
                        triggerTooltip: e,
                        involveSeries: s,
                        snap: a,
                        useHandle: ds(n),
                        seriesModels: []
                    };
                    d[o] = l, p.seriesInvolved |= s;
                    var h = function(t, e) {
                        for (var i = e.model, n = e.dim, r = 0; r < t.length; r++) {
                            var a = t[r] || {};
                            if (us(a[n + "AxisId"], i.id) || us(a[n + "AxisIndex"], i.componentIndex) || us(a[n + "AxisName"], i.name)) return r;
                        }
                    }(v, i);
                    if (null != h) {
                        var u = y[h] || (y[h] = {
                            axesInfo: {}
                        });
                        u.axesInfo[o] = l, u.mapper = v[h].mapper, l.linkGroup = u;
                    }
                }
            }
            if (c.axisPointerEnabled) {
                var e = ps(c.model), d = p.coordSysAxesInfo[e] = {}, i = (p.coordSysMap[e] = c).model, f = i.getModel("tooltip", o);
                if (om(c.getAxes(), sm(t, !1, null)), c.getTooltipAxes && o && f.get("show")) {
                    var n = "axis" === f.get("trigger"), r = "cross" === f.get("axisPointer.type"), a = c.getTooltipAxes(f.get("axisPointer.axis"));
                    (n || r) && om(a.baseAxes, sm(t, !r || "cross", n)), r && om(a.otherAxes, sm(t, "cross", !1));
                }
            }
        }), n.seriesInvolved && function(r, t) {
            t.eachSeries(function(i) {
                var n = i.coordinateSystem, t = i.get("tooltip.trigger", !0), e = i.get("tooltip.show", !0);
                n && "none" !== t && !1 !== t && "item" !== t && !1 !== e && !1 !== i.get("axisPointer.show", !0) && om(r.coordSysAxesInfo[ps(n.model)], function(t) {
                    var e = t.axis;
                    n.getAxis(e.dim) === e && (t.seriesModels.push(i), null == t.seriesDataCount && (t.seriesDataCount = 0), 
                    t.seriesDataCount += i.getData().count());
                });
            }, this);
        }(n, t), n;
    }
    function us(t, e) {
        return "all" === t || P(t) && 0 <= d(t, e) || t === e;
    }
    function cs(t) {
        var e = (t.ecModel.getComponent("axisPointer") || {}).coordSysAxesInfo;
        return e && e.axesInfo[ps(t)];
    }
    function ds(t) {
        return !!t.get("handle.show");
    }
    function ps(t) {
        return t.type + "||" + t.id;
    }
    function gs(t, e, i, n, r, a) {
        var o, s = lm.getAxisPointerClass(t.axisPointerClass);
        if (s) {
            var l = (o = cs(e)) && o.axisPointerModel;
            l ? (t._axisPointer || (t._axisPointer = new s())).render(e, l, n, a) : ms(t, n);
        }
    }
    function ms(t, e, i) {
        var n = t._axisPointer;
        n && n.dispose(e, i), t._axisPointer = null;
    }
    function vs(t, e, i) {
        i = i || {};
        var n = t.coordinateSystem, r = e.axis, a = {}, o = r.getAxesOnZeroOf()[0], s = r.position, l = o ? "onZero" : s, h = r.dim, u = n.getRect(), c = [ u.x, u.x + u.width, u.y, u.y + u.height ], d = {
            left: 0,
            right: 1,
            top: 0,
            bottom: 1,
            onZero: 2
        }, f = e.get("offset") || 0, p = "x" === h ? [ c[2] - f, c[3] + f ] : [ c[0] - f, c[1] + f ];
        if (o) {
            var g = o.toGlobalCoord(o.dataToCoord(0));
            p[d.onZero] = Math.max(Math.min(g, p[1]), p[0]);
        }
        a.position = [ "y" === h ? p[d[l]] : c[0], "x" === h ? p[d[l]] : c[3] ], a.rotation = Math.PI / 2 * ("x" === h ? 0 : 1);
        a.labelDirection = a.tickDirection = a.nameDirection = {
            top: -1,
            bottom: 1,
            left: -1,
            right: 1
        }[s], a.labelOffset = o ? p[d[s]] - p[d.onZero] : 0, e.get("axisTick.inside") && (a.tickDirection = -a.tickDirection), 
        k(i.labelInside, e.get("axisLabel.inside")) && (a.labelDirection = -a.labelDirection);
        var m = e.get("axisLabel.rotate");
        return a.labelRotate = "top" === l ? -m : m, a.z2 = 1, a;
    }
    function ys(t, e, i) {
        Hh.call(this), this.updateData(t, e, i);
    }
    function xs(t) {
        return [ t[0] / 2, t[1] / 2 ];
    }
    function _s(t, e) {
        this.parent.drift(t, e);
    }
    function ws() {
        !an(this) && Ss.call(this);
    }
    function bs() {
        !an(this) && Ms.call(this);
    }
    function Ss() {
        if (!this.incremental && !this.useHoverLayer) {
            var t = this.__symbolOriginalScale, e = t[1] / t[0];
            this.animateTo({
                scale: [ Math.max(1.1 * t[0], t[0] + 3), Math.max(1.1 * t[1], t[1] + 3 * e) ]
            }, 400, "elasticOut");
        }
    }
    function Ms() {
        this.incremental || this.useHoverLayer || this.animateTo({
            scale: this.__symbolOriginalScale
        }, 400, "elasticOut");
    }
    function Is(t) {
        this.group = new Hh(), this._symbolCtor = t || ys;
    }
    function Ts(t, e, i, n) {
        return !(!e || isNaN(e[0]) || isNaN(e[1]) || n.isIgnore && n.isIgnore(i) || n.clipShape && !n.clipShape.contain(e[0], e[1]) || "none" === t.getItemVisual(i, "symbol"));
    }
    function Cs(t) {
        return null == t || L(t) || (t = {
            isIgnore: t
        }), t || {};
    }
    function Ds(t) {
        var e = t.hostModel;
        return {
            itemStyle: e.getModel("itemStyle").getItemStyle([ "color" ]),
            hoverItemStyle: e.getModel("emphasis.itemStyle").getItemStyle(),
            symbolRotate: e.get("symbolRotate"),
            symbolOffset: e.get("symbolOffset"),
            hoverAnimation: e.get("hoverAnimation"),
            labelModel: e.getModel("label"),
            hoverLabelModel: e.getModel("emphasis.label"),
            cursorStyle: e.get("cursor")
        };
    }
    function As(t, e, i) {
        var n, r, a, o, s = t.getBaseAxis(), l = t.getOtherAxis(s), h = (r = i, a = 0, o = l.scale.getExtent(), 
        "start" === r ? a = o[0] : "end" === r ? a = o[1] : 0 < o[0] ? a = o[0] : o[1] < 0 && (a = o[1]), 
        a), u = s.dim, c = l.dim, d = e.mapDimension(c), f = e.mapDimension(u), p = "x" === c || "radius" === c ? 1 : 0, g = D(t.dimensions, function(t) {
            return e.mapDimension(t);
        }), m = e.getCalculationInfo("stackResultDimension");
        return (n |= io(e, g[0])) && (g[0] = m), (n |= io(e, g[1])) && (g[1] = m), {
            dataDimsForPoint: g,
            valueStart: h,
            valueAxisDim: c,
            baseAxisDim: u,
            stacked: !!n,
            valueDim: d,
            baseDim: f,
            baseDataOffset: p,
            stackedOverDimension: e.getCalculationInfo("stackedOverDimension")
        };
    }
    function ks(t, e, i, n) {
        var r = NaN;
        t.stacked && (r = i.get(i.getCalculationInfo("stackedOverDimension"), n)), isNaN(r) && (r = t.valueStart);
        var a = t.baseDataOffset, o = [];
        return o[a] = i.get(t.baseDim, n), o[1 - a] = r, e.dataToPoint(o);
    }
    function Ps(t) {
        return isNaN(t[0]) || isNaN(t[1]);
    }
    function Ls(t, e, i, n, r, a, o, s, l, h) {
        return "none" !== h && h ? function(t, e, i, n, r, a, o, s, l, h, u) {
            for (var c = 0, d = i, f = 0; f < n; f++) {
                var p = e[d];
                if (r <= d || d < 0) break;
                if (Ps(p)) {
                    if (u) {
                        d += a;
                        continue;
                    }
                    break;
                }
                if (d === i) t[0 < a ? "moveTo" : "lineTo"](p[0], p[1]); else if (0 < l) {
                    var g = e[c], m = "y" === h ? 1 : 0, v = (p[m] - g[m]) * l;
                    Sm(Im, g), Im[m] = g[m] + v, Sm(Tm, p), Tm[m] = p[m] - v, t.bezierCurveTo(Im[0], Im[1], Tm[0], Tm[1], p[0], p[1]);
                } else t.lineTo(p[0], p[1]);
                c = d, d += a;
            }
            return f;
        }.apply(this, arguments) : function(t, e, i, n, r, a, o, s, l, h, u) {
            for (var c = 0, d = i, f = 0; f < n; f++) {
                var p = e[d];
                if (r <= d || d < 0) break;
                if (Ps(p)) {
                    if (u) {
                        d += a;
                        continue;
                    }
                    break;
                }
                if (d === i) t[0 < a ? "moveTo" : "lineTo"](p[0], p[1]), Sm(Im, p); else if (0 < l) {
                    var g = d + a, m = e[g];
                    if (u) for (;m && Ps(e[g]); ) m = e[g += a];
                    var v = .5, y = e[c], m = e[g];
                    if (!m || Ps(m)) Sm(Tm, p); else {
                        var x, _;
                        if (Ps(m) && !u && (m = p), W(Mm, m, y), "x" === h || "y" === h) {
                            var w = "x" === h ? 0 : 1;
                            x = Math.abs(p[w] - y[w]), _ = Math.abs(p[w] - m[w]);
                        } else x = $l(p, y), _ = $l(p, m);
                        bm(Tm, p, Mm, -l * (1 - (v = _ / (_ + x))));
                    }
                    _m(Im, Im, s), wm(Im, Im, o), _m(Tm, Tm, s), wm(Tm, Tm, o), t.bezierCurveTo(Im[0], Im[1], Tm[0], Tm[1], p[0], p[1]), 
                    bm(Im, p, Mm, l * v);
                } else t.lineTo(p[0], p[1]);
                c = d, d += a;
            }
            return f;
        }.apply(this, arguments);
    }
    function Os(t, e) {
        var i = [ 1 / 0, 1 / 0 ], n = [ -1 / 0, -1 / 0 ];
        if (e) for (var r = 0; r < t.length; r++) {
            var a = t[r];
            a[0] < i[0] && (i[0] = a[0]), a[1] < i[1] && (i[1] = a[1]), a[0] > n[0] && (n[0] = a[0]), 
            a[1] > n[1] && (n[1] = a[1]);
        }
        return {
            min: e ? i : n,
            max: e ? n : i
        };
    }
    function Es(t, e) {
        if (t.length === e.length) {
            for (var i = 0; i < t.length; i++) {
                var n = t[i], r = e[i];
                if (n[0] !== r[0] || n[1] !== r[1]) return;
            }
            return !0;
        }
    }
    function zs(t) {
        return "number" == typeof t ? t : t ? .5 : 0;
    }
    function Bs(t) {
        var e = t.getGlobalExtent();
        if (t.onBand) {
            var i = t.getBandWidth() / 2 - 1, n = e[1] > e[0] ? 1 : -1;
            e[0] += n * i, e[1] -= n * i;
        }
        return e;
    }
    function Rs(t, e, i, n) {
        return "polar" === t.type ? function(t, e, i, n) {
            var r = t.getAngleAxis(), a = t.getRadiusAxis().getExtent().slice();
            a[0] > a[1] && a.reverse();
            var o = r.getExtent(), s = Math.PI / 180;
            i && (a[0] -= .5, a[1] += .5);
            var l = new Qc({
                shape: {
                    cx: Ln(t.cx, 1),
                    cy: Ln(t.cy, 1),
                    r0: Ln(a[0], 1),
                    r: Ln(a[1], 1),
                    startAngle: -o[0] * s,
                    endAngle: -o[1] * s,
                    clockwise: r.inverse
                }
            });
            return e && (l.shape.endAngle = -o[0] * s, bn(l, {
                shape: {
                    endAngle: -o[1] * s
                }
            }, n)), l;
        }(t, e, i, n) : function(t, e, i, n) {
            var r = Bs(t.getAxis("x")), a = Bs(t.getAxis("y")), o = t.getBaseAxis().isHorizontal(), s = Math.min(r[0], r[1]), l = Math.min(a[0], a[1]), h = Math.max(r[0], r[1]) - s, u = Math.max(a[0], a[1]) - l;
            if (i) s -= .5, h += .5, l -= .5, u += .5; else {
                var c = n.get("lineStyle.width") || 2, d = n.get("clipOverflow") ? c / 2 : Math.max(h, u);
                o ? (l -= d, u += 2 * d) : (s -= d, h += 2 * d);
            }
            var f = new id({
                shape: {
                    x: s,
                    y: l,
                    width: h,
                    height: u
                }
            });
            return e && (f.shape[o ? "width" : "height"] = 0, bn(f, {
                shape: {
                    width: h,
                    height: u
                }
            }, n)), f;
        }(t, e, i, n);
    }
    function Ns(t, e, i) {
        for (var n = e.getBaseAxis(), r = "x" === n.dim || "radius" === n.dim ? 0 : 1, a = [], o = 0; o < t.length - 1; o++) {
            var s = t[o + 1], l = t[o];
            a.push(l);
            var h = [];
            switch (i) {
              case "end":
                h[r] = s[r], h[1 - r] = l[1 - r], a.push(h);
                break;

              case "middle":
                var u = (l[r] + s[r]) / 2, c = [];
                h[r] = c[r] = u, h[1 - r] = l[1 - r], c[1 - r] = s[1 - r], a.push(h), a.push(c);
                break;

              default:
                h[r] = l[r], h[1 - r] = s[1 - r], a.push(h);
            }
        }
        return t[o] && a.push(t[o]), a;
    }
    function Fs(t, e, i) {
        var n = t.get("showAllSymbol"), r = "auto" === n;
        if (!n || r) {
            var a = i.getAxesByScale("ordinal")[0];
            if (a && (!r || !function(t, e) {
                var i = t.getExtent(), n = Math.abs(i[1] - i[0]) / t.scale.count();
                isNaN(n) && (n = 0);
                for (var r = e.count(), a = Math.max(1, Math.round(r / 5)), o = 0; o < r; o += a) if (1.5 * ys.getSymbolSize(e, o)[t.isHorizontal() ? 1 : 0] > n) return !1;
                return !0;
            }(a, e))) {
                var o = e.mapDimension(a.dim), s = {};
                return R(a.getViewLabels(), function(t) {
                    s[t.tickValue] = 1;
                }), function(t) {
                    return !s.hasOwnProperty(e.get(o, t));
                };
            }
        }
    }
    function Gs(t, e, i, n) {
        var r = e.getData(), a = this.dataIndex, o = r.getName(a), s = e.get("selectedOffset");
        n.dispatchAction({
            type: "pieToggleSelect",
            from: t,
            name: o,
            seriesId: e.id
        }), r.each(function(t) {
            Vs(r.getItemGraphicEl(t), r.getItemLayout(t), e.isSelected(r.getName(t)), s, i);
        });
    }
    function Vs(t, e, i, n, r) {
        var a = (e.startAngle + e.endAngle) / 2, o = i ? n : 0, s = [ Math.cos(a) * o, Math.sin(a) * o ];
        r ? t.animate().when(200, {
            position: s
        }).start("bounceOut") : t.attr("position", s);
    }
    function Hs(t, e) {
        function i() {
            a.ignore = a.hoverIgnore, o.ignore = o.hoverIgnore;
        }
        function n() {
            a.ignore = a.normalIgnore, o.ignore = o.normalIgnore;
        }
        Hh.call(this);
        var r = new Qc({
            z2: 2
        }), a = new ed(), o = new Yc();
        this.add(r), this.add(a), this.add(o), this.updateData(t, e, !0), this.on("emphasis", i).on("normal", n).on("mouseover", i).on("mouseout", n);
    }
    function Ws(r, t, e, i, n, a, o) {
        function s(t, e, i) {
            for (var n = t; n < e; n++) if (r[n].y += i, t < n && n + 1 < e && r[n + 1].y > r[n].y + r[n].height) return void l(n, i / 2);
            l(e - 1, i / 2);
        }
        function l(t, e) {
            for (var i = t; 0 <= i && (r[i].y -= e, !(0 < i && r[i].y > r[i - 1].y + r[i - 1].height)); i--) ;
        }
        function h(t, e, i, n, r, a) {
            for (var o = e ? Number.MAX_VALUE : 0, s = 0, l = t.length; s < l; s++) if ("center" !== t[s].position) {
                var h = Math.abs(t[s].y - n), u = t[s].len, c = t[s].len2, d = h < r + u ? Math.sqrt((r + u + c) * (r + u + c) - h * h) : Math.abs(t[s].x - i);
                e && o <= d && (d = o - 10), !e && d <= o && (d = o + 10), t[s].x = i + d * a, o = d;
            }
        }
        r.sort(function(t, e) {
            return t.y - e.y;
        });
        for (var u, c = 0, d = r.length, f = [], p = [], g = 0; g < d; g++) (u = r[g].y - c) < 0 && s(g, d, -u), 
        c = r[g].y + r[g].height;
        o - c < 0 && l(d - 1, c - o);
        for (g = 0; g < d; g++) r[g].y >= e ? p.push(r[g]) : f.push(r[g]);
        h(f, !1, t, e, i, n), h(p, !0, t, e, i, n);
    }
    function Xs(t, e, i) {
        Rg.call(this, t, e, i), this.type = "value", this.angle = 0, this.name = "", this.model;
    }
    function qs(t, e, i) {
        this._model = t, this.dimensions = [], this._indicatorAxes = D(t.getIndicatorModels(), function(t, e) {
            var i = "indicator_" + e, n = new Xs(i, new ng());
            return n.name = t.get("name"), (n.model = t).axis = n, this.dimensions.push(i), 
            n;
        }, this), this.resize(t, i), this.cx, this.cy, this.r, this.r0, this.startAngle;
    }
    function js(t, e) {
        return C({
            show: e
        }, t);
    }
    function Us(t, e) {
        function i() {
            a.ignore = a.hoverIgnore, o.ignore = o.hoverIgnore;
        }
        function n() {
            a.ignore = a.normalIgnore, o.ignore = o.normalIgnore;
        }
        Hh.call(this);
        var r = new td(), a = new ed(), o = new Yc();
        this.add(r), this.add(a), this.add(o), this.updateData(t, e, !0), this.on("emphasis", i).on("normal", n).on("mouseover", i).on("mouseout", n);
    }
    function Ys(t, e, i) {
        var r, a = {}, o = "toggleSelected" === t;
        return i.eachComponent("legend", function(n) {
            o && null != r ? n[r ? "select" : "unSelect"](e.name) : (n[t](e.name), r = n.isSelected(e.name)), 
            R(n.getData(), function(t) {
                var e = t.get("name");
                if ("\n" !== e && "" !== e) {
                    var i = n.isSelected(e);
                    a[e] = a.hasOwnProperty(e) ? a[e] && i : i;
                }
            });
        }), {
            name: e.name,
            selected: a
        };
    }
    function Zs(t, e) {
        e.dispatchAction({
            type: "legendToggleSelect",
            name: t
        });
    }
    function $s(t, e, i, n) {
        var r = i.getZr().storage.getDisplayList()[0];
        r && r.useHoverLayer || i.dispatchAction({
            type: "highlight",
            seriesName: t,
            name: e,
            excludeSeriesId: n
        });
    }
    function Ks(t, e, i, n) {
        var r = i.getZr().storage.getDisplayList()[0];
        r && r.useHoverLayer || i.dispatchAction({
            type: "downplay",
            seriesName: t,
            name: e,
            excludeSeriesId: n
        });
    }
    function Qs(t, e, i) {
        var n = [ 1, 1 ];
        n[t.getOrient().index] = 0, Kn(e, i, {
            type: "box",
            ignoreSize: n
        });
    }
    function Js(t, e, i, n, r) {
        var s, a, l, h, u, c, d, f, o = t.axis;
        if (!o.scale.isBlank() && o.containData(e)) {
            if (!t.involveSeries) return void i.showPointer(t, e);
            var p = (s = e, l = (a = t).axis, h = l.dim, u = s, c = [], d = Number.MAX_VALUE, 
            f = -1, ov(a.seriesModels, function(e) {
                var t, i, n = e.getData().mapDimension(h, !0);
                if (e.getAxisTooltipData) {
                    var r = e.getAxisTooltipData(n, s, l);
                    i = r.dataIndices, t = r.nestestValue;
                } else {
                    if (!(i = e.getData().indicesOfNearest(n[0], s, "category" === l.type ? .5 : null)).length) return;
                    t = e.getData().get(n[0], i[0]);
                }
                if (null != t && isFinite(t)) {
                    var a = s - t, o = Math.abs(a);
                    o <= d && ((o < d || 0 <= a && f < 0) && (d = o, f = a, u = t, c.length = 0), ov(i, function(t) {
                        c.push({
                            seriesIndex: e.seriesIndex,
                            dataIndexInside: t,
                            dataIndex: e.getData().getRawIndex(t)
                        });
                    }));
                }
            }), {
                payloadBatch: c,
                snapToValue: u
            }), g = p.payloadBatch, m = p.snapToValue;
            g[0] && null == r.seriesIndex && A(r, g[0]), !n && t.snap && o.containData(m) && null != m && (e = m), 
            i.showPointer(t, e, g, r), i.showTooltip(t, p, m);
        }
    }
    function tl(t, e, i, n) {
        t[e.key] = {
            value: i,
            payloadBatch: n
        };
    }
    function el(t, e, i, n) {
        var r = i.payloadBatch, a = e.axis, o = a.model, s = e.axisPointerModel;
        if (e.triggerTooltip && r.length) {
            var l = e.coordSys.model, h = ps(l), u = t.map[h];
            u || (u = t.map[h] = {
                coordSysId: l.id,
                coordSysIndex: l.componentIndex,
                coordSysType: l.type,
                coordSysMainType: l.mainType,
                dataByAxis: []
            }, t.list.push(u)), u.dataByAxis.push({
                axisDim: a.dim,
                axisIndex: o.componentIndex,
                axisType: o.type,
                axisId: o.id,
                value: n,
                valueLabelOpt: {
                    precision: s.get("label.precision"),
                    formatter: s.get("label.formatter")
                },
                seriesDataIndices: r.slice()
            });
        }
    }
    function il(t) {
        var e = t.axis.model, i = {}, n = i.axisDim = t.axis.dim;
        return i.axisIndex = i[n + "AxisIndex"] = e.componentIndex, i.axisName = i[n + "AxisName"] = e.name, 
        i.axisId = i[n + "AxisId"] = e.id, i;
    }
    function nl(t) {
        return !t || null == t[0] || isNaN(t[0]) || null == t[1] || isNaN(t[1]);
    }
    function rl(t, e, i) {
        if (!Ll.node) {
            var n = e.getZr();
            hv(n).records || (hv(n).records = {}), function(u, c) {
                function t(t, h) {
                    u.on(t, function(e) {
                        var n, r, t, i, a, o, s, l = (n = c, {
                            dispatchAction: function t(e) {
                                var i = r[e.type];
                                i ? i.push(e) : (e.dispatchAction = t, n.dispatchAction(e));
                            },
                            pendings: r = {
                                showTip: [],
                                hideTip: []
                            }
                        });
                        uv(hv(u).records, function(t) {
                            t && h(t, e, l.dispatchAction);
                        }), t = l.pendings, i = c, o = t.showTip.length, s = t.hideTip.length, o ? a = t.showTip[o - 1] : s && (a = t.hideTip[s - 1]), 
                        a && (a.dispatchAction = null, i.dispatchAction(a));
                    });
                }
                hv(u).initialized || (hv(u).initialized = !0, t("click", g(ol, "click")), t("mousemove", g(ol, "mousemove")), 
                t("globalout", al));
            }(n, e), (hv(n).records[t] || (hv(n).records[t] = {})).handler = i;
        }
    }
    function al(t, e, i) {
        t.handler("leave", null, i);
    }
    function ol(t, e, i, n) {
        e.handler(t, i, n);
    }
    function sl(t, e) {
        if (!Ll.node) {
            var i = e.getZr();
            (hv(i).records || {})[t] && (hv(i).records[t] = null);
        }
    }
    function ll() {}
    function hl(t, e, i, n) {
        (function i(n, t) {
            if (L(n) && L(t)) {
                var r = !0;
                return R(t, function(t, e) {
                    r = r && i(n[e], t);
                }), !!r;
            }
            return n === t;
        })(dv(i).lastProp, n) || (dv(i).lastProp = n, e ? wn(i, n, t) : (i.stopAnimation(), 
        i.attr(n)));
    }
    function ul(t, e) {
        t[e.get("label.show") ? "show" : "hide"]();
    }
    function cl(t) {
        return {
            position: t.position.slice(),
            rotation: t.rotation || 0
        };
    }
    function dl(t, e, i) {
        var n = e.get("z"), r = e.get("zlevel");
        t && t.traverse(function(t) {
            "group" !== t.type && (null != n && (t.z = n), null != r && (t.zlevel = r), t.silent = i);
        });
    }
    function fl(t, e, i, n, r) {
        var a = pl(i.get("value"), e.axis, e.ecModel, i.get("seriesDataIndices"), {
            precision: i.get("label.precision"),
            formatter: i.get("label.formatter")
        }), o = i.getModel("label"), s = Ld(o.get("padding") || 0), l = o.getFont(), h = ce(a, l), u = r.position, c = h.width + s[1] + s[3], d = h.height + s[0] + s[2], f = r.align;
        "right" === f && (u[0] -= c), "center" === f && (u[0] -= c / 2);
        var p, g, m, v, y, x, _ = r.verticalAlign;
        "bottom" === _ && (u[1] -= d), "middle" === _ && (u[1] -= d / 2), p = u, g = c, 
        m = d, y = (v = n).getWidth(), x = v.getHeight(), p[0] = Math.min(p[0] + g, y) - g, 
        p[1] = Math.min(p[1] + m, x) - m, p[0] = Math.max(p[0], 0), p[1] = Math.max(p[1], 0);
        var w = o.get("backgroundColor");
        w && "auto" !== w || (w = e.get("axisLine.lineStyle.color")), t.label = {
            shape: {
                x: 0,
                y: 0,
                width: c,
                height: d,
                r: o.get("borderRadius")
            },
            position: u.slice(),
            style: {
                text: a,
                textFont: l,
                textFill: o.getTextColor(),
                textPosition: "inside",
                fill: w,
                stroke: o.get("borderColor") || "transparent",
                lineWidth: o.get("borderWidth") || 0,
                shadowBlur: o.get("shadowBlur"),
                shadowColor: o.get("shadowColor"),
                shadowOffsetX: o.get("shadowOffsetX"),
                shadowOffsetY: o.get("shadowOffsetY")
            },
            z2: 10
        };
    }
    function pl(t, e, r, i, n) {
        t = e.scale.parse(t);
        var a = e.scale.getLabel(t, {
            precision: n.precision
        }), o = n.formatter;
        if (o) {
            var s = {
                value: To(e, t),
                seriesData: []
            };
            R(i, function(t) {
                var e = r.getSeriesByIndex(t.seriesIndex), i = t.dataIndexInside, n = e && e.getDataParams(i);
                n && s.seriesData.push(n);
            }), M(o) ? a = o.replace("{value}", a) : v(o) && (a = o(s));
        }
        return a;
    }
    function gl(t, e, i) {
        var n = lt();
        return ft(n, n, i.rotation), dt(n, n, i.position), Sn([ t.dataToCoord(e), (i.labelOffset || 0) + (i.labelDirection || 1) * (i.labelMargin || 0) ], n);
    }
    function ml(t, e) {
        var i = {};
        return i[e.dim + "AxisIndex"] = e.index, t.getCartesian(i);
    }
    function vl(t) {
        return "x" === t.dim ? 0 : 1;
    }
    function yl(r) {
        var i, n, t, e, a, o, s, l = [], h = r.get("transitionDuration"), u = r.get("backgroundColor"), c = r.getModel("textStyle"), d = r.get("padding");
        return h && l.push((s = "left " + (a = h) + "s " + (o = "cubic-bezier(0.23, 1, 0.32, 1)") + ",top " + a + "s " + o, 
        D(xv, function(t) {
            return t + "transition:" + s;
        }).join(";"))), u && (Ll.canvasSupported ? l.push("background-Color:" + u) : (l.push("background-Color:#" + kt(u)), 
        l.push("filter:alpha(opacity=70)"))), vv([ "width", "color", "radius" ], function(t) {
            var e = "border-" + t, i = yv(e), n = r.get(i);
            null != n && l.push(e + ":" + n + ("color" === t ? "" : "px"));
        }), l.push((n = [], t = (i = c).get("fontSize"), (e = i.getTextColor()) && n.push("color:" + e), 
        n.push("font:" + i.getFont()), t && n.push("line-height:" + Math.round(3 * t / 2) + "px"), 
        vv([ "decoration", "align" ], function(t) {
            var e = i.get(t);
            e && n.push("text-" + t + ":" + e);
        }), n.join(";"))), null != d && l.push("padding:" + Ld(d).join("px ") + "px"), l.join(";") + ";";
    }
    function xl(i, t) {
        if (Ll.wxa) return null;
        var e = document.createElement("div"), n = this._zr = t.getZr();
        this.el = e, this._x = t.getWidth() / 2, this._y = t.getHeight() / 2, i.appendChild(e), 
        this._container = i, this._show = !1, this._hideTimeout;
        var r = this;
        e.onmouseenter = function() {
            r._enterable && (clearTimeout(r._hideTimeout), r._show = !0), r._inContent = !0;
        }, e.onmousemove = function(t) {
            if (t = t || window.event, !r._enterable) {
                var e = n.handler;
                rt(i, t, !0), e.dispatch("mousemove", t);
            }
        }, e.onmouseleave = function() {
            r._enterable && r._show && r.hideLater(r._hideDelay), r._inContent = !1;
        };
    }
    function _l(t) {
        this._zr = t.getZr(), this._show = !1, this._hideTimeout;
    }
    function wl(t) {
        for (var e = t.pop(); t.length; ) {
            var i = t.pop();
            i && (Tn.isInstance(i) && (i = i.get("tooltip", !0)), "string" == typeof i && (i = {
                formatter: i
            }), e = new Tn(i, e, e.ecModel));
        }
        return e;
    }
    function bl(t, e) {
        return t.dispatchAction || _(e.dispatchAction, e);
    }
    function Sl(t) {
        return "center" === t || "middle" === t;
    }
    var Ml, Il, Tl, Cl, Dl, Al, kl = 2311, Pl = function() {
        return kl++;
    }, Ll = "object" == ("undefined" == typeof wx ? "undefined" : _typeof(wx)) && "function" == typeof wx.getSystemInfoSync ? {
        browser: {},
        os: {},
        node: !1,
        wxa: !0,
        canvasSupported: !0,
        svgSupported: !1,
        touchEventsSupported: !0,
        domSupported: !1
    } : "undefined" == typeof document && "undefined" != typeof self ? {
        browser: {},
        os: {},
        node: !1,
        worker: !0,
        canvasSupported: !0,
        domSupported: !1
    } : "undefined" == typeof navigator ? {
        browser: {},
        os: {},
        node: !0,
        worker: !1,
        canvasSupported: !0,
        svgSupported: !0,
        domSupported: !1
    } : (Ml = navigator.userAgent, Il = {}, Tl = Ml.match(/Firefox\/([\d.]+)/), Cl = Ml.match(/MSIE\s([\d.]+)/) || Ml.match(/Trident\/.+?rv:(([\d.]+))/), 
    Dl = Ml.match(/Edge\/([\d.]+)/), Al = /micromessenger/i.test(Ml), Tl && (Il.firefox = !0, 
    Il.version = Tl[1]), Cl && (Il.ie = !0, Il.version = Cl[1]), Dl && (Il.edge = !0, 
    Il.version = Dl[1]), Al && (Il.weChat = !0), {
        browser: Il,
        os: {},
        node: !1,
        canvasSupported: !!document.createElement("canvas").getContext,
        svgSupported: "undefined" != typeof SVGRect,
        touchEventsSupported: "ontouchstart" in window && !Il.ie && !Il.edge,
        pointerEventsSupported: "onpointerdown" in window && (Il.edge || Il.ie && 11 <= Il.version),
        domSupported: "undefined" != typeof document
    }), Ol = {
        "[object Function]": 1,
        "[object RegExp]": 1,
        "[object Date]": 1,
        "[object Error]": 1,
        "[object CanvasGradient]": 1,
        "[object CanvasPattern]": 1,
        "[object Image]": 1,
        "[object Canvas]": 1
    }, El = {
        "[object Int8Array]": 1,
        "[object Uint8Array]": 1,
        "[object Uint8ClampedArray]": 1,
        "[object Int16Array]": 1,
        "[object Uint16Array]": 1,
        "[object Int32Array]": 1,
        "[object Uint32Array]": 1,
        "[object Float32Array]": 1,
        "[object Float64Array]": 1
    }, zl = Object.prototype.toString, Bl = Array.prototype, Rl = Bl.forEach, Nl = Bl.filter, Fl = Bl.slice, Gl = Bl.map, Vl = Bl.reduce, Hl = {}, Wl = function() {
        return Hl.createCanvas();
    };
    Hl.createCanvas = function() {
        return document.createElement("canvas");
    };
    var Xl, ql = "__ec_primitive__";
    I.prototype = {
        constructor: I,
        get: function(t) {
            return this.data.hasOwnProperty(t) ? this.data[t] : null;
        },
        set: function(t, e) {
            return this.data[t] = e;
        },
        each: function(t, e) {
            for (var i in void 0 !== e && (t = _(t, e)), this.data) this.data.hasOwnProperty(i) && t(this.data[i], i);
        },
        removeKey: function(t) {
            delete this.data[t];
        }
    };
    var jl = (Object.freeze || Object)({
        $override: e,
        clone: b,
        merge: m,
        mergeAll: i,
        extend: A,
        defaults: C,
        createCanvas: Wl,
        getContext: n,
        indexOf: d,
        inherits: a,
        mixin: r,
        isArrayLike: E,
        each: R,
        map: D,
        reduce: S,
        filter: u,
        find: function(t, e, i) {
            if (t && e) for (var n = 0, r = t.length; n < r; n++) if (e.call(i, t[n], n, t)) return t[n];
        },
        bind: _,
        curry: g,
        isArray: P,
        isFunction: v,
        isString: M,
        isObject: L,
        isBuiltInObject: o,
        isTypedArray: p,
        isDom: s,
        eqNaN: y,
        retrieve: k,
        retrieve2: O,
        retrieve3: z,
        slice: l,
        normalizeCssArray: h,
        assert: c,
        trim: f,
        setAsPrimitive: x,
        isPrimitive: w,
        createHashMap: T,
        concatArray: function(t, e) {
            for (var i = new t.constructor(t.length + e.length), n = 0; n < t.length; n++) i[n] = t[n];
            var r = t.length;
            for (n = 0; n < e.length; n++) i[n + r] = e[n];
            return i;
        },
        noop: B
    }), Ul = "undefined" == typeof Float32Array ? Array : Float32Array, Yl = X, Zl = q, $l = Y, Kl = Z, Ql = (Object.freeze || Object)({
        create: N,
        copy: F,
        clone: G,
        set: function(t, e, i) {
            return t[0] = e, t[1] = i, t;
        },
        add: V,
        scaleAndAdd: H,
        sub: W,
        len: X,
        length: Yl,
        lenSquare: q,
        lengthSquare: Zl,
        mul: function(t, e, i) {
            return t[0] = e[0] * i[0], t[1] = e[1] * i[1], t;
        },
        div: function(t, e, i) {
            return t[0] = e[0] / i[0], t[1] = e[1] / i[1], t;
        },
        dot: function(t, e) {
            return t[0] * e[0] + t[1] * e[1];
        },
        scale: j,
        normalize: U,
        distance: Y,
        dist: $l,
        distanceSquare: Z,
        distSquare: Kl,
        negate: function(t, e) {
            return t[0] = -e[0], t[1] = -e[1], t;
        },
        lerp: function(t, e, i, n) {
            return t[0] = e[0] + n * (i[0] - e[0]), t[1] = e[1] + n * (i[1] - e[1]), t;
        },
        applyTransform: $,
        min: K,
        max: Q
    });
    J.prototype = {
        constructor: J,
        _dragStart: function(t) {
            var e = t.target;
            e && e.draggable && ((this._draggingTarget = e).dragging = !0, this._x = t.offsetX, 
            this._y = t.offsetY, this.dispatchToElement(tt(e, t), "dragstart", t.event));
        },
        _drag: function(t) {
            var e = this._draggingTarget;
            if (e) {
                var i = t.offsetX, n = t.offsetY, r = i - this._x, a = n - this._y;
                this._x = i, this._y = n, e.drift(r, a, t), this.dispatchToElement(tt(e, t), "drag", t.event);
                var o = this.findHover(i, n, e).target, s = this._dropTarget;
                e !== (this._dropTarget = o) && (s && o !== s && this.dispatchToElement(tt(s, t), "dragleave", t.event), 
                o && o !== s && this.dispatchToElement(tt(o, t), "dragenter", t.event));
            }
        },
        _dragEnd: function(t) {
            var e = this._draggingTarget;
            e && (e.dragging = !1), this.dispatchToElement(tt(e, t), "dragend", t.event), this._dropTarget && this.dispatchToElement(tt(this._dropTarget, t), "drop", t.event), 
            this._draggingTarget = null, this._dropTarget = null;
        }
    };
    var Jl = Array.prototype.slice, th = function(t) {
        this._$handlers = {}, this._$eventProcessor = t;
    };
    th.prototype = {
        constructor: th,
        one: function(t, e, i, n) {
            var r = this._$handlers;
            if ("function" == typeof e && (n = i, i = e, e = null), !i || !t) return this;
            e = et(this, e), r[t] || (r[t] = []);
            for (var a = 0; a < r[t].length; a++) if (r[t][a].h === i) return this;
            return r[t].push({
                h: i,
                one: !0,
                query: e,
                ctx: n || this
            }), this;
        },
        on: function(t, e, i, n) {
            var r = this._$handlers;
            if ("function" == typeof e && (n = i, i = e, e = null), !i || !t) return this;
            e = et(this, e), r[t] || (r[t] = []);
            for (var a = 0; a < r[t].length; a++) if (r[t][a].h === i) return this;
            return r[t].push({
                h: i,
                one: !1,
                query: e,
                ctx: n || this
            }), this;
        },
        isSilent: function(t) {
            var e = this._$handlers;
            return e[t] && e[t].length;
        },
        off: function(t, e) {
            var i = this._$handlers;
            if (!t) return this._$handlers = {}, this;
            if (e) {
                if (i[t]) {
                    for (var n = [], r = 0, a = i[t].length; r < a; r++) i[t][r].h !== e && n.push(i[t][r]);
                    i[t] = n;
                }
                i[t] && 0 === i[t].length && delete i[t];
            } else delete i[t];
            return this;
        },
        trigger: function(t) {
            var e = this._$handlers[t], i = this._$eventProcessor;
            if (e) {
                var n = arguments, r = n.length;
                3 < r && (n = Jl.call(n, 1));
                for (var a = e.length, o = 0; o < a; ) {
                    var s = e[o];
                    if (i && i.filter && null != s.query && !i.filter(t, s.query)) o++; else {
                        switch (r) {
                          case 1:
                            s.h.call(s.ctx);
                            break;

                          case 2:
                            s.h.call(s.ctx, n[1]);
                            break;

                          case 3:
                            s.h.call(s.ctx, n[1], n[2]);
                            break;

                          default:
                            s.h.apply(s.ctx, n);
                        }
                        s.one ? (e.splice(o, 1), a--) : o++;
                    }
                }
            }
            return i && i.afterTrigger && i.afterTrigger(t), this;
        },
        triggerWithContext: function(t) {
            var e = this._$handlers[t], i = this._$eventProcessor;
            if (e) {
                var n = arguments, r = n.length;
                4 < r && (n = Jl.call(n, 1, n.length - 1));
                for (var a = n[n.length - 1], o = e.length, s = 0; s < o; ) {
                    var l = e[s];
                    if (i && i.filter && null != l.query && !i.filter(t, l.query)) s++; else {
                        switch (r) {
                          case 1:
                            l.h.call(a);
                            break;

                          case 2:
                            l.h.call(a, n[1]);
                            break;

                          case 3:
                            l.h.call(a, n[1], n[2]);
                            break;

                          default:
                            l.h.apply(a, n);
                        }
                        l.one ? (e.splice(s, 1), o--) : s++;
                    }
                }
            }
            return i && i.afterTrigger && i.afterTrigger(t), this;
        }
    };
    var eh = "undefined" != typeof window && !!window.addEventListener, ih = /^(?:mouse|pointer|contextmenu|drag|drop)|click/, nh = eh ? function(t) {
        t.preventDefault(), t.stopPropagation(), t.cancelBubble = !0;
    } : function(t) {
        t.returnValue = !1, t.cancelBubble = !0;
    }, rh = "silent";
    ot.prototype.dispose = function() {};
    var ah = [ "click", "dblclick", "mousewheel", "mouseout", "mouseup", "mousedown", "mousemove", "contextmenu" ], oh = function(t, e, i, n) {
        th.call(this), this.storage = t, this.painter = e, this.painterRoot = n, i = i || new ot(), 
        this.proxy = null, this._hovered = {}, this._lastTouchMoment, this._lastX, this._lastY, 
        J.call(this), this.setHandlerProxy(i);
    };
    oh.prototype = {
        constructor: oh,
        setHandlerProxy: function(e) {
            this.proxy && this.proxy.dispose(), e && (R(ah, function(t) {
                e.on && e.on(t, this[t], this);
            }, this), e.handler = this), this.proxy = e;
        },
        mousemove: function(t) {
            var e = t.zrX, i = t.zrY, n = this._hovered, r = n.target;
            r && !r.__zr && (r = (n = this.findHover(n.x, n.y)).target);
            var a = this._hovered = this.findHover(e, i), o = a.target, s = this.proxy;
            s.setCursor && s.setCursor(o ? o.cursor : "default"), r && o !== r && this.dispatchToElement(n, "mouseout", t), 
            this.dispatchToElement(a, "mousemove", t), o && o !== r && this.dispatchToElement(a, "mouseover", t);
        },
        mouseout: function(t) {
            this.dispatchToElement(this._hovered, "mouseout", t);
            for (var e, i = t.toElement || t.relatedTarget; (i = i && i.parentNode) && 9 != i.nodeType && !(e = i === this.painterRoot); ) ;
            !e && this.trigger("globalout", {
                event: t
            });
        },
        resize: function() {
            this._hovered = {};
        },
        dispatch: function(t, e) {
            var i = this[t];
            i && i.call(this, e);
        },
        dispose: function() {
            this.proxy.dispose(), this.storage = this.proxy = this.painter = null;
        },
        setCursorStyle: function(t) {
            var e = this.proxy;
            e.setCursor && e.setCursor(t);
        },
        dispatchToElement: function(t, e, i) {
            var n, r, a = (t = t || {}).target;
            if (!a || !a.silent) {
                for (var o = "on" + e, s = {
                    type: e,
                    event: r = i,
                    target: (n = t).target,
                    topTarget: n.topTarget,
                    cancelBubble: !1,
                    offsetX: r.zrX,
                    offsetY: r.zrY,
                    gestureEvent: r.gestureEvent,
                    pinchX: r.pinchX,
                    pinchY: r.pinchY,
                    pinchScale: r.pinchScale,
                    wheelDelta: r.zrDelta,
                    zrByTouch: r.zrByTouch,
                    which: r.which,
                    stop: at
                }; a && (a[o] && (s.cancelBubble = a[o].call(a, s)), a.trigger(e, s), a = a.parent, 
                !s.cancelBubble); ) ;
                s.cancelBubble || (this.trigger(e, s), this.painter && this.painter.eachOtherLayer(function(t) {
                    "function" == typeof t[o] && t[o].call(t, s), t.trigger && t.trigger(e, s);
                }));
            }
        },
        findHover: function(t, e, i) {
            for (var n = this.storage.getDisplayList(), r = {
                x: t,
                y: e
            }, a = n.length - 1; 0 <= a; a--) {
                var o;
                if (n[a] !== i && !n[a].ignore && (o = st(n[a], t, e)) && (!r.topTarget && (r.topTarget = n[a]), 
                o !== rh)) {
                    r.target = n[a];
                    break;
                }
            }
            return r;
        }
    }, R([ "click", "mousedown", "mouseup", "mousewheel", "dblclick", "contextmenu" ], function(n) {
        oh.prototype[n] = function(t) {
            var e = this.findHover(t.zrX, t.zrY), i = e.target;
            if ("mousedown" === n) this._downEl = i, this._downPoint = [ t.zrX, t.zrY ], this._upEl = i; else if ("mouseup" === n) this._upEl = i; else if ("click" === n) {
                if (this._downEl !== this._upEl || !this._downPoint || 4 < $l(this._downPoint, [ t.zrX, t.zrY ])) return;
                this._downPoint = null;
            }
            this.dispatchToElement(e, n, t);
        };
    }), r(oh, th), r(oh, J);
    var sh = "undefined" == typeof Float32Array ? Array : Float32Array, lh = (Object.freeze || Object)({
        create: lt,
        identity: ht,
        copy: ut,
        mul: ct,
        translate: dt,
        rotate: ft,
        scale: pt,
        invert: gt,
        clone: function(t) {
            var e = lt();
            return ut(e, t), e;
        }
    }), hh = ht, uh = function(t) {
        (t = t || {}).position || (this.position = [ 0, 0 ]), null == t.rotation && (this.rotation = 0), 
        t.scale || (this.scale = [ 1, 1 ]), this.origin = this.origin || null;
    }, ch = uh.prototype;
    ch.transform = null, ch.needLocalTransform = function() {
        return mt(this.rotation) || mt(this.position[0]) || mt(this.position[1]) || mt(this.scale[0] - 1) || mt(this.scale[1] - 1);
    };
    var dh = [];
    ch.updateTransform = function() {
        var t = this.parent, e = t && t.transform, i = this.needLocalTransform(), n = this.transform;
        if (i || e) {
            n = n || lt(), i ? this.getLocalTransform(n) : hh(n), e && (i ? ct(n, t.transform, n) : ut(n, t.transform)), 
            this.transform = n;
            var r = this.globalScaleRatio;
            if (null != r && 1 !== r) {
                this.getGlobalScale(dh);
                var a = dh[0] < 0 ? -1 : 1, o = dh[1] < 0 ? -1 : 1, s = ((dh[0] - a) * r + a) / dh[0] || 0, l = ((dh[1] - o) * r + o) / dh[1] || 0;
                n[0] *= s, n[1] *= s, n[2] *= l, n[3] *= l;
            }
            this.invTransform = this.invTransform || lt(), gt(this.invTransform, n);
        } else n && hh(n);
    }, ch.getLocalTransform = function(t) {
        return uh.getLocalTransform(this, t);
    }, ch.setTransform = function(t) {
        var e = this.transform, i = t.dpr || 1;
        e ? t.setTransform(i * e[0], i * e[1], i * e[2], i * e[3], i * e[4], i * e[5]) : t.setTransform(i, 0, 0, i, 0, 0);
    }, ch.restoreTransform = function(t) {
        var e = t.dpr || 1;
        t.setTransform(e, 0, 0, e, 0, 0);
    };
    var fh = [], ph = lt();
    ch.setLocalTransform = function(t) {
        if (t) {
            var e = t[0] * t[0] + t[1] * t[1], i = t[2] * t[2] + t[3] * t[3], n = this.position, r = this.scale;
            mt(e - 1) && (e = Math.sqrt(e)), mt(i - 1) && (i = Math.sqrt(i)), t[0] < 0 && (e = -e), 
            t[3] < 0 && (i = -i), n[0] = t[4], n[1] = t[5], r[0] = e, r[1] = i, this.rotation = Math.atan2(-t[1] / i, t[0] / e);
        }
    }, ch.decomposeTransform = function() {
        if (this.transform) {
            var t = this.parent, e = this.transform;
            t && t.transform && (ct(fh, t.invTransform, e), e = fh);
            var i = this.origin;
            i && (i[0] || i[1]) && (ph[4] = i[0], ph[5] = i[1], ct(fh, e, ph), fh[4] -= i[0], 
            fh[5] -= i[1], e = fh), this.setLocalTransform(e);
        }
    }, ch.getGlobalScale = function(t) {
        var e = this.transform;
        return t = t || [], e ? (t[0] = Math.sqrt(e[0] * e[0] + e[1] * e[1]), t[1] = Math.sqrt(e[2] * e[2] + e[3] * e[3]), 
        e[0] < 0 && (t[0] = -t[0]), e[3] < 0 && (t[1] = -t[1])) : (t[0] = 1, t[1] = 1), 
        t;
    }, ch.transformCoordToLocal = function(t, e) {
        var i = [ t, e ], n = this.invTransform;
        return n && $(i, i, n), i;
    }, ch.transformCoordToGlobal = function(t, e) {
        var i = [ t, e ], n = this.transform;
        return n && $(i, i, n), i;
    }, uh.getLocalTransform = function(t, e) {
        hh(e = e || []);
        var i = t.origin, n = t.scale || [ 1, 1 ], r = t.rotation || 0, a = t.position || [ 0, 0 ];
        return i && (e[4] -= i[0], e[5] -= i[1]), pt(e, e, n), r && ft(e, e, r), i && (e[4] += i[0], 
        e[5] += i[1]), e[4] += a[0], e[5] += a[1], e;
    };
    var gh = {
        linear: function(t) {
            return t;
        },
        quadraticIn: function(t) {
            return t * t;
        },
        quadraticOut: function(t) {
            return t * (2 - t);
        },
        quadraticInOut: function(t) {
            return (t *= 2) < 1 ? .5 * t * t : -.5 * (--t * (t - 2) - 1);
        },
        cubicIn: function(t) {
            return t * t * t;
        },
        cubicOut: function(t) {
            return --t * t * t + 1;
        },
        cubicInOut: function(t) {
            return (t *= 2) < 1 ? .5 * t * t * t : .5 * ((t -= 2) * t * t + 2);
        },
        quarticIn: function(t) {
            return t * t * t * t;
        },
        quarticOut: function(t) {
            return 1 - --t * t * t * t;
        },
        quarticInOut: function(t) {
            return (t *= 2) < 1 ? .5 * t * t * t * t : -.5 * ((t -= 2) * t * t * t - 2);
        },
        quinticIn: function(t) {
            return t * t * t * t * t;
        },
        quinticOut: function(t) {
            return --t * t * t * t * t + 1;
        },
        quinticInOut: function(t) {
            return (t *= 2) < 1 ? .5 * t * t * t * t * t : .5 * ((t -= 2) * t * t * t * t + 2);
        },
        sinusoidalIn: function(t) {
            return 1 - Math.cos(t * Math.PI / 2);
        },
        sinusoidalOut: function(t) {
            return Math.sin(t * Math.PI / 2);
        },
        sinusoidalInOut: function(t) {
            return .5 * (1 - Math.cos(Math.PI * t));
        },
        exponentialIn: function(t) {
            return 0 === t ? 0 : Math.pow(1024, t - 1);
        },
        exponentialOut: function(t) {
            return 1 === t ? 1 : 1 - Math.pow(2, -10 * t);
        },
        exponentialInOut: function(t) {
            return 0 === t ? 0 : 1 === t ? 1 : (t *= 2) < 1 ? .5 * Math.pow(1024, t - 1) : .5 * (2 - Math.pow(2, -10 * (t - 1)));
        },
        circularIn: function(t) {
            return 1 - Math.sqrt(1 - t * t);
        },
        circularOut: function(t) {
            return Math.sqrt(1 - --t * t);
        },
        circularInOut: function(t) {
            return (t *= 2) < 1 ? -.5 * (Math.sqrt(1 - t * t) - 1) : .5 * (Math.sqrt(1 - (t -= 2) * t) + 1);
        },
        elasticIn: function(t) {
            var e, i = .1;
            return 0 === t ? 0 : 1 === t ? 1 : (!i || i < 1 ? (i = 1, e = .1) : e = .4 * Math.asin(1 / i) / (2 * Math.PI), 
            -i * Math.pow(2, 10 * (t -= 1)) * Math.sin(2 * (t - e) * Math.PI / .4));
        },
        elasticOut: function(t) {
            var e, i = .1;
            return 0 === t ? 0 : 1 === t ? 1 : (!i || i < 1 ? (i = 1, e = .1) : e = .4 * Math.asin(1 / i) / (2 * Math.PI), 
            i * Math.pow(2, -10 * t) * Math.sin(2 * (t - e) * Math.PI / .4) + 1);
        },
        elasticInOut: function(t) {
            var e, i = .1;
            return 0 === t ? 0 : 1 === t ? 1 : (!i || i < 1 ? (i = 1, e = .1) : e = .4 * Math.asin(1 / i) / (2 * Math.PI), 
            (t *= 2) < 1 ? -.5 * i * Math.pow(2, 10 * (t -= 1)) * Math.sin(2 * (t - e) * Math.PI / .4) : i * Math.pow(2, -10 * (t -= 1)) * Math.sin(2 * (t - e) * Math.PI / .4) * .5 + 1);
        },
        backIn: function(t) {
            return t * t * (2.70158 * t - 1.70158);
        },
        backOut: function(t) {
            return --t * t * (2.70158 * t + 1.70158) + 1;
        },
        backInOut: function(t) {
            var e = 2.5949095;
            return (t *= 2) < 1 ? .5 * t * t * ((e + 1) * t - e) : .5 * ((t -= 2) * t * ((e + 1) * t + e) + 2);
        },
        bounceIn: function(t) {
            return 1 - gh.bounceOut(1 - t);
        },
        bounceOut: function(t) {
            return t < 1 / 2.75 ? 7.5625 * t * t : t < 2 / 2.75 ? 7.5625 * (t -= 1.5 / 2.75) * t + .75 : t < 2.5 / 2.75 ? 7.5625 * (t -= 2.25 / 2.75) * t + .9375 : 7.5625 * (t -= 2.625 / 2.75) * t + .984375;
        },
        bounceInOut: function(t) {
            return t < .5 ? .5 * gh.bounceIn(2 * t) : .5 * gh.bounceOut(2 * t - 1) + .5;
        }
    };
    vt.prototype = {
        constructor: vt,
        step: function(t, e) {
            if (this._initialized || (this._startTime = t + this._delay, this._initialized = !0), 
            this._paused) this._pausedTime += e; else {
                var i = (t - this._startTime - this._pausedTime) / this._life;
                if (!(i < 0)) {
                    i = Math.min(i, 1);
                    var n = this.easing, r = "string" == typeof n ? gh[n] : n, a = "function" == typeof r ? r(i) : i;
                    return this.fire("frame", a), 1 == i ? this.loop ? (this.restart(t), "restart") : (this._needsRemove = !0, 
                    "destroy") : null;
                }
            }
        },
        restart: function(t) {
            var e = (t - this._startTime - this._pausedTime) % this._life;
            this._startTime = t - e + this.gap, this._pausedTime = 0, this._needsRemove = !1;
        },
        fire: function(t, e) {
            this[t = "on" + t] && this[t](this._target, e);
        },
        pause: function() {
            this._paused = !0;
        },
        resume: function() {
            this._paused = !1;
        }
    };
    var mh = function() {
        this.head = null, this.tail = null, this._len = 0;
    }, vh = mh.prototype;
    vh.insert = function(t) {
        var e = new yh(t);
        return this.insertEntry(e), e;
    }, vh.insertEntry = function(t) {
        this.head ? ((this.tail.next = t).prev = this.tail, t.next = null, this.tail = t) : this.head = this.tail = t, 
        this._len++;
    }, vh.remove = function(t) {
        var e = t.prev, i = t.next;
        e ? e.next = i : this.head = i, i ? i.prev = e : this.tail = e, t.next = t.prev = null, 
        this._len--;
    }, vh.len = function() {
        return this._len;
    }, vh.clear = function() {
        this.head = this.tail = null, this._len = 0;
    };
    var yh = function(t) {
        this.value = t, this.next, this.prev;
    }, xh = function(t) {
        this._list = new mh(), this._map = {}, this._maxSize = t || 10, this._lastRemovedEntry = null;
    }, _h = xh.prototype;
    _h.put = function(t, e) {
        var i = this._list, n = this._map, r = null;
        if (null == n[t]) {
            var a = i.len(), o = this._lastRemovedEntry;
            if (a >= this._maxSize && 0 < a) {
                var s = i.head;
                i.remove(s), delete n[s.key], r = s.value, this._lastRemovedEntry = s;
            }
            o ? o.value = e : o = new yh(e), o.key = t, i.insertEntry(o), n[t] = o;
        }
        return r;
    }, _h.get = function(t) {
        var e = this._map[t], i = this._list;
        return null != e ? (e !== i.tail && (i.remove(e), i.insertEntry(e)), e.value) : void 0;
    }, _h.clear = function() {
        this._list.clear(), this._map = {};
    };
    var wh = {
        transparent: [ 0, 0, 0, 0 ],
        aliceblue: [ 240, 248, 255, 1 ],
        antiquewhite: [ 250, 235, 215, 1 ],
        aqua: [ 0, 255, 255, 1 ],
        aquamarine: [ 127, 255, 212, 1 ],
        azure: [ 240, 255, 255, 1 ],
        beige: [ 245, 245, 220, 1 ],
        bisque: [ 255, 228, 196, 1 ],
        black: [ 0, 0, 0, 1 ],
        blanchedalmond: [ 255, 235, 205, 1 ],
        blue: [ 0, 0, 255, 1 ],
        blueviolet: [ 138, 43, 226, 1 ],
        brown: [ 165, 42, 42, 1 ],
        burlywood: [ 222, 184, 135, 1 ],
        cadetblue: [ 95, 158, 160, 1 ],
        chartreuse: [ 127, 255, 0, 1 ],
        chocolate: [ 210, 105, 30, 1 ],
        coral: [ 255, 127, 80, 1 ],
        cornflowerblue: [ 100, 149, 237, 1 ],
        cornsilk: [ 255, 248, 220, 1 ],
        crimson: [ 220, 20, 60, 1 ],
        cyan: [ 0, 255, 255, 1 ],
        darkblue: [ 0, 0, 139, 1 ],
        darkcyan: [ 0, 139, 139, 1 ],
        darkgoldenrod: [ 184, 134, 11, 1 ],
        darkgray: [ 169, 169, 169, 1 ],
        darkgreen: [ 0, 100, 0, 1 ],
        darkgrey: [ 169, 169, 169, 1 ],
        darkkhaki: [ 189, 183, 107, 1 ],
        darkmagenta: [ 139, 0, 139, 1 ],
        darkolivegreen: [ 85, 107, 47, 1 ],
        darkorange: [ 255, 140, 0, 1 ],
        darkorchid: [ 153, 50, 204, 1 ],
        darkred: [ 139, 0, 0, 1 ],
        darksalmon: [ 233, 150, 122, 1 ],
        darkseagreen: [ 143, 188, 143, 1 ],
        darkslateblue: [ 72, 61, 139, 1 ],
        darkslategray: [ 47, 79, 79, 1 ],
        darkslategrey: [ 47, 79, 79, 1 ],
        darkturquoise: [ 0, 206, 209, 1 ],
        darkviolet: [ 148, 0, 211, 1 ],
        deeppink: [ 255, 20, 147, 1 ],
        deepskyblue: [ 0, 191, 255, 1 ],
        dimgray: [ 105, 105, 105, 1 ],
        dimgrey: [ 105, 105, 105, 1 ],
        dodgerblue: [ 30, 144, 255, 1 ],
        firebrick: [ 178, 34, 34, 1 ],
        floralwhite: [ 255, 250, 240, 1 ],
        forestgreen: [ 34, 139, 34, 1 ],
        fuchsia: [ 255, 0, 255, 1 ],
        gainsboro: [ 220, 220, 220, 1 ],
        ghostwhite: [ 248, 248, 255, 1 ],
        gold: [ 255, 215, 0, 1 ],
        goldenrod: [ 218, 165, 32, 1 ],
        gray: [ 128, 128, 128, 1 ],
        green: [ 0, 128, 0, 1 ],
        greenyellow: [ 173, 255, 47, 1 ],
        grey: [ 128, 128, 128, 1 ],
        honeydew: [ 240, 255, 240, 1 ],
        hotpink: [ 255, 105, 180, 1 ],
        indianred: [ 205, 92, 92, 1 ],
        indigo: [ 75, 0, 130, 1 ],
        ivory: [ 255, 255, 240, 1 ],
        khaki: [ 240, 230, 140, 1 ],
        lavender: [ 230, 230, 250, 1 ],
        lavenderblush: [ 255, 240, 245, 1 ],
        lawngreen: [ 124, 252, 0, 1 ],
        lemonchiffon: [ 255, 250, 205, 1 ],
        lightblue: [ 173, 216, 230, 1 ],
        lightcoral: [ 240, 128, 128, 1 ],
        lightcyan: [ 224, 255, 255, 1 ],
        lightgoldenrodyellow: [ 250, 250, 210, 1 ],
        lightgray: [ 211, 211, 211, 1 ],
        lightgreen: [ 144, 238, 144, 1 ],
        lightgrey: [ 211, 211, 211, 1 ],
        lightpink: [ 255, 182, 193, 1 ],
        lightsalmon: [ 255, 160, 122, 1 ],
        lightseagreen: [ 32, 178, 170, 1 ],
        lightskyblue: [ 135, 206, 250, 1 ],
        lightslategray: [ 119, 136, 153, 1 ],
        lightslategrey: [ 119, 136, 153, 1 ],
        lightsteelblue: [ 176, 196, 222, 1 ],
        lightyellow: [ 255, 255, 224, 1 ],
        lime: [ 0, 255, 0, 1 ],
        limegreen: [ 50, 205, 50, 1 ],
        linen: [ 250, 240, 230, 1 ],
        magenta: [ 255, 0, 255, 1 ],
        maroon: [ 128, 0, 0, 1 ],
        mediumaquamarine: [ 102, 205, 170, 1 ],
        mediumblue: [ 0, 0, 205, 1 ],
        mediumorchid: [ 186, 85, 211, 1 ],
        mediumpurple: [ 147, 112, 219, 1 ],
        mediumseagreen: [ 60, 179, 113, 1 ],
        mediumslateblue: [ 123, 104, 238, 1 ],
        mediumspringgreen: [ 0, 250, 154, 1 ],
        mediumturquoise: [ 72, 209, 204, 1 ],
        mediumvioletred: [ 199, 21, 133, 1 ],
        midnightblue: [ 25, 25, 112, 1 ],
        mintcream: [ 245, 255, 250, 1 ],
        mistyrose: [ 255, 228, 225, 1 ],
        moccasin: [ 255, 228, 181, 1 ],
        navajowhite: [ 255, 222, 173, 1 ],
        navy: [ 0, 0, 128, 1 ],
        oldlace: [ 253, 245, 230, 1 ],
        olive: [ 128, 128, 0, 1 ],
        olivedrab: [ 107, 142, 35, 1 ],
        orange: [ 255, 165, 0, 1 ],
        orangered: [ 255, 69, 0, 1 ],
        orchid: [ 218, 112, 214, 1 ],
        palegoldenrod: [ 238, 232, 170, 1 ],
        palegreen: [ 152, 251, 152, 1 ],
        paleturquoise: [ 175, 238, 238, 1 ],
        palevioletred: [ 219, 112, 147, 1 ],
        papayawhip: [ 255, 239, 213, 1 ],
        peachpuff: [ 255, 218, 185, 1 ],
        peru: [ 205, 133, 63, 1 ],
        pink: [ 255, 192, 203, 1 ],
        plum: [ 221, 160, 221, 1 ],
        powderblue: [ 176, 224, 230, 1 ],
        purple: [ 128, 0, 128, 1 ],
        red: [ 255, 0, 0, 1 ],
        rosybrown: [ 188, 143, 143, 1 ],
        royalblue: [ 65, 105, 225, 1 ],
        saddlebrown: [ 139, 69, 19, 1 ],
        salmon: [ 250, 128, 114, 1 ],
        sandybrown: [ 244, 164, 96, 1 ],
        seagreen: [ 46, 139, 87, 1 ],
        seashell: [ 255, 245, 238, 1 ],
        sienna: [ 160, 82, 45, 1 ],
        silver: [ 192, 192, 192, 1 ],
        skyblue: [ 135, 206, 235, 1 ],
        slateblue: [ 106, 90, 205, 1 ],
        slategray: [ 112, 128, 144, 1 ],
        slategrey: [ 112, 128, 144, 1 ],
        snow: [ 255, 250, 250, 1 ],
        springgreen: [ 0, 255, 127, 1 ],
        steelblue: [ 70, 130, 180, 1 ],
        tan: [ 210, 180, 140, 1 ],
        teal: [ 0, 128, 128, 1 ],
        thistle: [ 216, 191, 216, 1 ],
        tomato: [ 255, 99, 71, 1 ],
        turquoise: [ 64, 224, 208, 1 ],
        violet: [ 238, 130, 238, 1 ],
        wheat: [ 245, 222, 179, 1 ],
        white: [ 255, 255, 255, 1 ],
        whitesmoke: [ 245, 245, 245, 1 ],
        yellow: [ 255, 255, 0, 1 ],
        yellowgreen: [ 154, 205, 50, 1 ]
    }, bh = new xh(20), Sh = null, Mh = Pt, Ih = Lt, Th = (Object.freeze || Object)({
        parse: Ct,
        lift: At,
        toHex: kt,
        fastLerp: Pt,
        fastMapToColor: Mh,
        lerp: Lt,
        mapToColor: Ih,
        modifyHSL: function(t, e, i, n) {
            return (t = Ct(t)) ? (t = function(t) {
                if (t) {
                    var e, i, n = t[0] / 255, r = t[1] / 255, a = t[2] / 255, o = Math.min(n, r, a), s = Math.max(n, r, a), l = s - o, h = (s + o) / 2;
                    if (0 === l) i = e = 0; else {
                        i = h < .5 ? l / (s + o) : l / (2 - s - o);
                        var u = ((s - n) / 6 + l / 2) / l, c = ((s - r) / 6 + l / 2) / l, d = ((s - a) / 6 + l / 2) / l;
                        n === s ? e = d - c : r === s ? e = 1 / 3 + u - d : a === s && (e = 2 / 3 + c - u), 
                        e < 0 && (e += 1), 1 < e && (e -= 1);
                    }
                    var f = [ 360 * e, i, h ];
                    return null != t[3] && f.push(t[3]), f;
                }
            }(t), null != e && (t[0] = (r = e, (r = Math.round(r)) < 0 ? 0 : 360 < r ? 360 : r)), 
            null != i && (t[1] = wt(i)), null != n && (t[2] = wt(n)), Ot(Dt(t), "rgba")) : void 0;
            var r;
        },
        modifyAlpha: function(t, e) {
            return (t = Ct(t)) && null != e ? (t[3] = xt(e), Ot(t, "rgba")) : void 0;
        },
        stringify: Ot
    }), Ch = Array.prototype.slice, Dh = function(t, e, i, n) {
        this._tracks = {}, this._target = t, this._loop = e || !1, this._getter = i || Et, 
        this._setter = n || zt, this._clipCount = 0, this._delay = 0, this._doneList = [], 
        this._onframeList = [], this._clipList = [];
    };
    Dh.prototype = {
        when: function(t, e) {
            var i = this._tracks;
            for (var n in e) if (e.hasOwnProperty(n)) {
                if (!i[n]) {
                    i[n] = [];
                    var r = this._getter(this._target, n);
                    if (null == r) continue;
                    0 !== t && i[n].push({
                        time: 0,
                        value: Wt(r)
                    });
                }
                i[n].push({
                    time: t,
                    value: e[n]
                });
            }
            return this;
        },
        during: function(t) {
            return this._onframeList.push(t), this;
        },
        pause: function() {
            for (var t = 0; t < this._clipList.length; t++) this._clipList[t].pause();
            this._paused = !0;
        },
        resume: function() {
            for (var t = 0; t < this._clipList.length; t++) this._clipList[t].resume();
            this._paused = !1;
        },
        isPaused: function() {
            return !!this._paused;
        },
        _doneCallback: function() {
            this._tracks = {}, this._clipList.length = 0;
            for (var t = this._doneList, e = t.length, i = 0; i < e; i++) t[i].call(this);
        },
        start: function(t, e) {
            var i, n = this, r = 0, a = function() {
                --r || n._doneCallback();
            };
            for (var o in this._tracks) if (this._tracks.hasOwnProperty(o)) {
                var s = qt(this, t, a, this._tracks[o], o, e);
                s && (this._clipList.push(s), r++, this.animation && this.animation.addClip(s), 
                i = s);
            }
            if (i) {
                var l = i.onframe;
                i.onframe = function(t, e) {
                    l(t, e);
                    for (var i = 0; i < n._onframeList.length; i++) n._onframeList[i](t, e);
                };
            }
            return r || this._doneCallback(), this;
        },
        stop: function(t) {
            for (var e = this._clipList, i = this.animation, n = 0; n < e.length; n++) {
                var r = e[n];
                t && r.onframe(this._target, 1), i && i.removeClip(r);
            }
            e.length = 0;
        },
        delay: function(t) {
            return this._delay = t, this;
        },
        done: function(t) {
            return t && this._doneList.push(t), this;
        },
        getClips: function() {
            return this._clipList;
        }
    };
    var Ah = 1;
    "undefined" != typeof window && (Ah = Math.max(window.devicePixelRatio || 1, 1));
    var kh = Ah, Ph = function() {}, Lh = Ph, Oh = function() {
        this.animators = [];
    };
    Oh.prototype = {
        constructor: Oh,
        animate: function(t, e) {
            var i, n = !1, r = this, a = this.__zr;
            if (t) {
                var o = t.split("."), s = r;
                n = "shape" === o[0];
                for (var l = 0, h = o.length; l < h; l++) s && (s = s[o[l]]);
                s && (i = s);
            } else i = r;
            if (i) {
                var u = r.animators, c = new Dh(i, e);
                return c.during(function() {
                    r.dirty(n);
                }).done(function() {
                    u.splice(d(u, c), 1);
                }), u.push(c), a && a.animation.addAnimator(c), c;
            }
            Lh('Property "' + t + '" is not existed in element ' + r.id);
        },
        stopAnimation: function(t) {
            for (var e = this.animators, i = e.length, n = 0; n < i; n++) e[n].stop(t);
            return e.length = 0, this;
        },
        animateTo: function(t, e, i, n, r, a) {
            jt(this, t, e, i, n, r, a);
        },
        animateFrom: function(t, e, i, n, r, a) {
            jt(this, t, e, i, n, r, a, !0);
        }
    };
    var Eh = function(t) {
        uh.call(this, t), th.call(this, t), Oh.call(this, t), this.id = t.id || Pl();
    };
    Eh.prototype = {
        type: "element",
        name: "",
        __zr: null,
        ignore: !1,
        clipPath: null,
        isGroup: !1,
        drift: function(t, e) {
            switch (this.draggable) {
              case "horizontal":
                e = 0;
                break;

              case "vertical":
                t = 0;
            }
            var i = this.transform;
            i || (i = this.transform = [ 1, 0, 0, 1, 0, 0 ]), i[4] += t, i[5] += e, this.decomposeTransform(), 
            this.dirty(!1);
        },
        beforeUpdate: function() {},
        afterUpdate: function() {},
        update: function() {
            this.updateTransform();
        },
        traverse: function() {},
        attrKV: function(t, e) {
            if ("position" === t || "scale" === t || "origin" === t) {
                if (e) {
                    var i = this[t];
                    i || (i = this[t] = []), i[0] = e[0], i[1] = e[1];
                }
            } else this[t] = e;
        },
        hide: function() {
            this.ignore = !0, this.__zr && this.__zr.refresh();
        },
        show: function() {
            this.ignore = !1, this.__zr && this.__zr.refresh();
        },
        attr: function(t, e) {
            if ("string" == typeof t) this.attrKV(t, e); else if (L(t)) for (var i in t) t.hasOwnProperty(i) && this.attrKV(i, t[i]);
            return this.dirty(!1), this;
        },
        setClipPath: function(t) {
            var e = this.__zr;
            e && t.addSelfToZr(e), this.clipPath && this.clipPath !== t && this.removeClipPath(), 
            (this.clipPath = t).__zr = e, (t.__clipTarget = this).dirty(!1);
        },
        removeClipPath: function() {
            var t = this.clipPath;
            t && (t.__zr && t.removeSelfFromZr(t.__zr), t.__zr = null, t.__clipTarget = null, 
            this.clipPath = null, this.dirty(!1));
        },
        addSelfToZr: function(t) {
            this.__zr = t;
            var e = this.animators;
            if (e) for (var i = 0; i < e.length; i++) t.animation.addAnimator(e[i]);
            this.clipPath && this.clipPath.addSelfToZr(t);
        },
        removeSelfFromZr: function(t) {
            this.__zr = null;
            var e = this.animators;
            if (e) for (var i = 0; i < e.length; i++) t.animation.removeAnimator(e[i]);
            this.clipPath && this.clipPath.removeSelfFromZr(t);
        }
    }, r(Eh, Oh), r(Eh, uh), r(Eh, th);
    var zh, Bh, Rh, Nh, Fh = $, Gh = Math.min, Vh = Math.max;
    Yt.prototype = {
        constructor: Yt,
        union: function(t) {
            var e = Gh(t.x, this.x), i = Gh(t.y, this.y);
            this.width = Vh(t.x + t.width, this.x + this.width) - e, this.height = Vh(t.y + t.height, this.y + this.height) - i, 
            this.x = e, this.y = i;
        },
        applyTransform: (zh = [], Bh = [], Rh = [], Nh = [], function(t) {
            if (t) {
                zh[0] = Rh[0] = this.x, zh[1] = Nh[1] = this.y, Bh[0] = Nh[0] = this.x + this.width, 
                Bh[1] = Rh[1] = this.y + this.height, Fh(zh, zh, t), Fh(Bh, Bh, t), Fh(Rh, Rh, t), 
                Fh(Nh, Nh, t), this.x = Gh(zh[0], Bh[0], Rh[0], Nh[0]), this.y = Gh(zh[1], Bh[1], Rh[1], Nh[1]);
                var e = Vh(zh[0], Bh[0], Rh[0], Nh[0]), i = Vh(zh[1], Bh[1], Rh[1], Nh[1]);
                this.width = e - this.x, this.height = i - this.y;
            }
        }),
        calculateTransform: function(t) {
            var e = t.width / this.width, i = t.height / this.height, n = lt();
            return dt(n, n, [ -this.x, -this.y ]), pt(n, n, [ e, i ]), dt(n, n, [ t.x, t.y ]), 
            n;
        },
        intersect: function(t) {
            if (!t) return !1;
            t instanceof Yt || (t = Yt.create(t));
            var e = this.x, i = this.x + this.width, n = this.y, r = this.y + this.height, a = t.x, o = t.x + t.width, s = t.y, l = t.y + t.height;
            return !(i < a || o < e || r < s || l < n);
        },
        contain: function(t, e) {
            return t >= this.x && t <= this.x + this.width && e >= this.y && e <= this.y + this.height;
        },
        clone: function() {
            return new Yt(this.x, this.y, this.width, this.height);
        },
        copy: function(t) {
            this.x = t.x, this.y = t.y, this.width = t.width, this.height = t.height;
        },
        plain: function() {
            return {
                x: this.x,
                y: this.y,
                width: this.width,
                height: this.height
            };
        }
    }, Yt.create = function(t) {
        return new Yt(t.x, t.y, t.width, t.height);
    };
    var Hh = function(t) {
        for (var e in t = t || {}, Eh.call(this, t), t) t.hasOwnProperty(e) && (this[e] = t[e]);
        this._children = [], this.__storage = null, this.__dirty = !0;
    };
    Hh.prototype = {
        constructor: Hh,
        isGroup: !0,
        type: "group",
        silent: !1,
        children: function() {
            return this._children.slice();
        },
        childAt: function(t) {
            return this._children[t];
        },
        childOfName: function(t) {
            for (var e = this._children, i = 0; i < e.length; i++) if (e[i].name === t) return e[i];
        },
        childCount: function() {
            return this._children.length;
        },
        add: function(t) {
            return t && t !== this && t.parent !== this && (this._children.push(t), this._doAdd(t)), 
            this;
        },
        addBefore: function(t, e) {
            if (t && t !== this && t.parent !== this && e && e.parent === this) {
                var i = this._children, n = i.indexOf(e);
                0 <= n && (i.splice(n, 0, t), this._doAdd(t));
            }
            return this;
        },
        _doAdd: function(t) {
            t.parent && t.parent.remove(t);
            var e = (t.parent = this).__storage, i = this.__zr;
            e && e !== t.__storage && (e.addToStorage(t), t instanceof Hh && t.addChildrenToStorage(e)), 
            i && i.refresh();
        },
        remove: function(t) {
            var e = this.__zr, i = this.__storage, n = this._children, r = d(n, t);
            return r < 0 || (n.splice(r, 1), t.parent = null, i && (i.delFromStorage(t), t instanceof Hh && t.delChildrenFromStorage(i)), 
            e && e.refresh()), this;
        },
        removeAll: function() {
            var t, e, i = this._children, n = this.__storage;
            for (e = 0; e < i.length; e++) t = i[e], n && (n.delFromStorage(t), t instanceof Hh && t.delChildrenFromStorage(n)), 
            t.parent = null;
            return i.length = 0, this;
        },
        eachChild: function(t, e) {
            for (var i = this._children, n = 0; n < i.length; n++) {
                var r = i[n];
                t.call(e, r, n);
            }
            return this;
        },
        traverse: function(t, e) {
            for (var i = 0; i < this._children.length; i++) {
                var n = this._children[i];
                t.call(e, n), "group" === n.type && n.traverse(t, e);
            }
            return this;
        },
        addChildrenToStorage: function(t) {
            for (var e = 0; e < this._children.length; e++) {
                var i = this._children[e];
                t.addToStorage(i), i instanceof Hh && i.addChildrenToStorage(t);
            }
        },
        delChildrenFromStorage: function(t) {
            for (var e = 0; e < this._children.length; e++) {
                var i = this._children[e];
                t.delFromStorage(i), i instanceof Hh && i.delChildrenFromStorage(t);
            }
        },
        dirty: function() {
            return this.__dirty = !0, this.__zr && this.__zr.refresh(), this;
        },
        getBoundingRect: function(t) {
            for (var e = null, i = new Yt(0, 0, 0, 0), n = t || this._children, r = [], a = 0; a < n.length; a++) {
                var o = n[a];
                if (!o.ignore && !o.invisible) {
                    var s = o.getBoundingRect(), l = o.getLocalTransform(r);
                    l ? (i.copy(s), i.applyTransform(l), (e = e || i.clone()).union(i)) : (e = e || s.clone()).union(s);
                }
            }
            return e || i;
        }
    }, a(Hh, Eh);
    var Wh = 32, Xh = 7, qh = function() {
        this._roots = [], this._displayList = [], this._displayListLen = 0;
    };
    qh.prototype = {
        constructor: qh,
        traverse: function(t, e) {
            for (var i = 0; i < this._roots.length; i++) this._roots[i].traverse(t, e);
        },
        getDisplayList: function(t, e) {
            return e = e || !1, t && this.updateDisplayList(e), this._displayList;
        },
        updateDisplayList: function(t) {
            this._displayListLen = 0;
            for (var e = this._roots, i = this._displayList, n = 0, r = e.length; n < r; n++) this._updateAndAddDisplayable(e[n], null, t);
            i.length = this._displayListLen, Ll.canvasSupported && te(i, ee);
        },
        _updateAndAddDisplayable: function(t, e, i) {
            if (!t.ignore || i) {
                t.beforeUpdate(), t.__dirty && t.update(), t.afterUpdate();
                var n = t.clipPath;
                if (n) {
                    e = e ? e.slice() : [];
                    for (var r = n, a = t; r; ) r.parent = a, r.updateTransform(), e.push(r), r = (a = r).clipPath;
                }
                if (t.isGroup) {
                    for (var o = t._children, s = 0; s < o.length; s++) {
                        var l = o[s];
                        t.__dirty && (l.__dirty = !0), this._updateAndAddDisplayable(l, e, i);
                    }
                    t.__dirty = !1;
                } else t.__clipPaths = e, this._displayList[this._displayListLen++] = t;
            }
        },
        addRoot: function(t) {
            t.__storage !== this && (t instanceof Hh && t.addChildrenToStorage(this), this.addToStorage(t), 
            this._roots.push(t));
        },
        delRoot: function(t) {
            if (null == t) {
                for (var e = 0; e < this._roots.length; e++) {
                    var i = this._roots[e];
                    i instanceof Hh && i.delChildrenFromStorage(this);
                }
                return this._roots = [], this._displayList = [], void (this._displayListLen = 0);
            }
            if (t instanceof Array) {
                e = 0;
                for (var n = t.length; e < n; e++) this.delRoot(t[e]);
            } else {
                var r = d(this._roots, t);
                0 <= r && (this.delFromStorage(t), this._roots.splice(r, 1), t instanceof Hh && t.delChildrenFromStorage(this));
            }
        },
        addToStorage: function(t) {
            return t && (t.__storage = this, t.dirty(!1)), this;
        },
        delFromStorage: function(t) {
            return t && (t.__storage = null), this;
        },
        dispose: function() {
            this._renderList = this._roots = null;
        },
        displayableSortFunc: ee
    };
    var jh = {
        shadowBlur: 1,
        shadowOffsetX: 1,
        shadowOffsetY: 1,
        textShadowBlur: 1,
        textShadowOffsetX: 1,
        textShadowOffsetY: 1,
        textBoxShadowBlur: 1,
        textBoxShadowOffsetX: 1,
        textBoxShadowOffsetY: 1
    }, Uh = function(t, e, i) {
        return jh.hasOwnProperty(e) ? i *= t.dpr : i;
    }, Yh = [ [ "shadowBlur", 0 ], [ "shadowOffsetX", 0 ], [ "shadowOffsetY", 0 ], [ "shadowColor", "#000" ], [ "lineCap", "butt" ], [ "lineJoin", "miter" ], [ "miterLimit", 10 ] ], Zh = function(t) {
        this.extendFrom(t, !1);
    };
    Zh.prototype = {
        constructor: Zh,
        fill: "#000",
        stroke: null,
        opacity: 1,
        fillOpacity: null,
        strokeOpacity: null,
        lineDash: null,
        lineDashOffset: 0,
        shadowBlur: 0,
        shadowOffsetX: 0,
        shadowOffsetY: 0,
        lineWidth: 1,
        strokeNoScale: !1,
        text: null,
        font: null,
        textFont: null,
        fontStyle: null,
        fontWeight: null,
        fontSize: null,
        fontFamily: null,
        textTag: null,
        textFill: "#000",
        textStroke: null,
        textWidth: null,
        textHeight: null,
        textStrokeWidth: 0,
        textLineHeight: null,
        textPosition: "inside",
        textRect: null,
        textOffset: null,
        textAlign: null,
        textVerticalAlign: null,
        textDistance: 5,
        textShadowColor: "transparent",
        textShadowBlur: 0,
        textShadowOffsetX: 0,
        textShadowOffsetY: 0,
        textBoxShadowColor: "transparent",
        textBoxShadowBlur: 0,
        textBoxShadowOffsetX: 0,
        textBoxShadowOffsetY: 0,
        transformText: !1,
        textRotation: 0,
        textOrigin: null,
        textBackgroundColor: null,
        textBorderColor: null,
        textBorderWidth: 0,
        textBorderRadius: 0,
        textPadding: null,
        rich: null,
        truncate: null,
        blend: null,
        bind: function(t, e, i) {
            for (var n = this, r = i && i.style, a = !r, o = 0; o < Yh.length; o++) {
                var s = Yh[o], l = s[0];
                (a || n[l] !== r[l]) && (t[l] = Uh(t, l, n[l] || s[1]));
            }
            if ((a || n.fill !== r.fill) && (t.fillStyle = n.fill), (a || n.stroke !== r.stroke) && (t.strokeStyle = n.stroke), 
            (a || n.opacity !== r.opacity) && (t.globalAlpha = null == n.opacity ? 1 : n.opacity), 
            (a || n.blend !== r.blend) && (t.globalCompositeOperation = n.blend || "source-over"), 
            this.hasStroke()) {
                var h = n.lineWidth;
                t.lineWidth = h / (this.strokeNoScale && e && e.getLineScale ? e.getLineScale() : 1);
            }
        },
        hasFill: function() {
            var t = this.fill;
            return null != t && "none" !== t;
        },
        hasStroke: function() {
            var t = this.stroke;
            return null != t && "none" !== t && 0 < this.lineWidth;
        },
        extendFrom: function(t, e) {
            if (t) for (var i in t) !t.hasOwnProperty(i) || !0 !== e && (!1 === e ? this.hasOwnProperty(i) : null == t[i]) || (this[i] = t[i]);
        },
        set: function(t, e) {
            "string" == typeof t ? this[t] = e : this.extendFrom(t, !0);
        },
        clone: function() {
            var t = new this.constructor();
            return t.extendFrom(this, !0), t;
        },
        getGradient: function(t, e, i) {
            for (var n = ("radial" === e.type ? ne : ie)(t, e, i), r = e.colorStops, a = 0; a < r.length; a++) n.addColorStop(r[a].offset, r[a].color);
            return n;
        }
    };
    for (var $h = Zh.prototype, Kh = 0; Kh < Yh.length; Kh++) {
        var Qh = Yh[Kh];
        Qh[0] in $h || ($h[Qh[0]] = Qh[1]);
    }
    Zh.getGradient = $h.getGradient;
    var Jh = function(t, e) {
        this.image = t, this.repeat = e, this.type = "pattern";
    }, tu = function(t, e, i) {
        var n;
        i = i || kh, "string" == typeof t ? n = ae(t, e, i) : L(t) && (t = (n = t).id), 
        this.id = t;
        var r = (this.dom = n).style;
        r && (n.onselectstart = re, r["-webkit-user-select"] = "none", r["user-select"] = "none", 
        r["-webkit-touch-callout"] = "none", r["-webkit-tap-highlight-color"] = "rgba(0,0,0,0)", 
        r.padding = 0, r.margin = 0, r["border-width"] = 0), this.domBack = null, this.ctxBack = null, 
        this.painter = e, this.config = null, this.clearColor = 0, this.motionBlur = !1, 
        this.lastFrameAlpha = .7, this.dpr = i;
    };
    tu.prototype = {
        constructor: tu,
        __dirty: !0,
        __used: !(Jh.prototype.getCanvasPattern = function(t) {
            return t.createPattern(this.image, this.repeat || "repeat");
        }),
        __drawIndex: 0,
        __startIndex: 0,
        __endIndex: 0,
        incremental: !1,
        getElementCount: function() {
            return this.__endIndex - this.__startIndex;
        },
        initContext: function() {
            this.ctx = this.dom.getContext("2d"), this.ctx.dpr = this.dpr;
        },
        createBackBuffer: function() {
            var t = this.dpr;
            this.domBack = ae("back-" + this.id, this.painter, t), this.ctxBack = this.domBack.getContext("2d"), 
            1 != t && this.ctxBack.scale(t, t);
        },
        resize: function(t, e) {
            var i = this.dpr, n = this.dom, r = n.style, a = this.domBack;
            r && (r.width = t + "px", r.height = e + "px"), n.width = t * i, n.height = e * i, 
            a && (a.width = t * i, a.height = e * i, 1 != i && this.ctxBack.scale(i, i));
        },
        clear: function(t, e) {
            var i, n = this.dom, r = this.ctx, a = n.width, o = n.height, s = (e = e || this.clearColor, 
            this.motionBlur && !t), l = this.lastFrameAlpha, h = this.dpr;
            (s && (this.domBack || this.createBackBuffer(), this.ctxBack.globalCompositeOperation = "copy", 
            this.ctxBack.drawImage(n, 0, 0, a / h, o / h)), r.clearRect(0, 0, a, o), e && "transparent" !== e) && (e.colorStops ? (i = e.__canvasGradient || Zh.getGradient(r, e, {
                x: 0,
                y: 0,
                width: a,
                height: o
            }), e.__canvasGradient = i) : e.image && (i = Jh.prototype.getCanvasPattern.call(e, r)), 
            r.save(), r.fillStyle = i || e, r.fillRect(0, 0, a, o), r.restore());
            if (s) {
                var u = this.domBack;
                r.save(), r.globalAlpha = l, r.drawImage(u, 0, 0, a, o), r.restore();
            }
        }
    };
    var eu = "undefined" != typeof window && (window.requestAnimationFrame && window.requestAnimationFrame.bind(window) || window.msRequestAnimationFrame && window.msRequestAnimationFrame.bind(window) || window.mozRequestAnimationFrame || window.webkitRequestAnimationFrame) || function(t) {
        setTimeout(t, 16);
    }, iu = new xh(50), nu = {}, ru = 0, au = 5e3, ou = /\{([a-zA-Z0-9_]+)\|([^}]*)\}/g, su = "12px sans-serif", lu = {
        measureText: function(t, e) {
            var i = n();
            return i.font = e || su, i.measureText(t);
        }
    }, hu = {
        left: 1,
        right: 1,
        center: 1
    }, uu = {
        top: 1,
        bottom: 1,
        middle: 1
    }, cu = [ [ "textShadowBlur", "shadowBlur", 0 ], [ "textShadowOffsetX", "shadowOffsetX", 0 ], [ "textShadowOffsetY", "shadowOffsetY", 0 ], [ "textShadowColor", "shadowColor", "transparent" ] ], du = new Yt(), fu = function() {};
    Ne.prototype = {
        constructor: Ne,
        type: "displayable",
        __dirty: !0,
        invisible: !(fu.prototype = {
            constructor: fu,
            drawRectText: function(t, e) {
                var i = this.style;
                e = i.textRect || e, this.__dirty && Se(i);
                var n = i.text;
                if (null != n && (n += ""), Re(n, i)) {
                    t.save();
                    var r = this.transform;
                    i.transformText ? this.setTransform(t) : r && (du.copy(e), du.applyTransform(r), 
                    e = du), Ie(this, t, n, i, e), t.restore();
                }
            }
        }),
        z: 0,
        z2: 0,
        zlevel: 0,
        draggable: !1,
        dragging: !1,
        silent: !1,
        culling: !1,
        cursor: "pointer",
        rectHover: !1,
        progressive: !1,
        incremental: !1,
        globalScaleRatio: 1,
        beforeBrush: function() {},
        afterBrush: function() {},
        brush: function() {},
        getBoundingRect: function() {},
        contain: function(t, e) {
            return this.rectContain(t, e);
        },
        traverse: function(t, e) {
            t.call(e, this);
        },
        rectContain: function(t, e) {
            var i = this.transformCoordToLocal(t, e);
            return this.getBoundingRect().contain(i[0], i[1]);
        },
        dirty: function() {
            this.__dirty = this.__dirtyText = !0, this._rect = null, this.__zr && this.__zr.refresh();
        },
        animateStyle: function(t) {
            return this.animate("style", t);
        },
        attrKV: function(t, e) {
            "style" !== t ? Eh.prototype.attrKV.call(this, t, e) : this.style.set(e);
        },
        setStyle: function(t, e) {
            return this.style.set(t, e), this.dirty(!1), this;
        },
        useStyle: function(t) {
            return this.style = new Zh(t, this), this.dirty(!1), this;
        }
    }, a(Ne, Eh), r(Ne, fu), Fe.prototype = {
        constructor: Fe,
        type: "image",
        brush: function(t, e) {
            var i = this.style, n = i.image;
            i.bind(t, this, e);
            var r = this._image = se(n, this._image, this, this.onload);
            if (r && he(r)) {
                var a = i.x || 0, o = i.y || 0, s = i.width, l = i.height, h = r.width / r.height;
                if (null == s && null != l ? s = l * h : null == l && null != s ? l = s / h : null == s && null == l && (s = r.width, 
                l = r.height), this.setTransform(t), i.sWidth && i.sHeight) {
                    var u = i.sx || 0, c = i.sy || 0;
                    t.drawImage(r, u, c, i.sWidth, i.sHeight, a, o, s, l);
                } else if (i.sx && i.sy) {
                    var d = s - (u = i.sx), f = l - (c = i.sy);
                    t.drawImage(r, u, c, d, f, a, o, s, l);
                } else t.drawImage(r, a, o, s, l);
                null != i.text && (this.restoreTransform(t), this.drawRectText(t, this.getBoundingRect()));
            }
        },
        getBoundingRect: function() {
            var t = this.style;
            return this._rect || (this._rect = new Yt(t.x || 0, t.y || 0, t.width || 0, t.height || 0)), 
            this._rect;
        }
    }, a(Fe, Ne);
    var pu = 314159, gu = new Yt(0, 0, 0, 0), mu = new Yt(0, 0, 0, 0), vu = function(t, e, i) {
        this.type = "canvas";
        var n = !t.nodeName || "CANVAS" === t.nodeName.toUpperCase();
        this._opts = i = A({}, i || {}), this.dpr = i.devicePixelRatio || kh, this._singleCanvas = n;
        var r = (this.root = t).style;
        r && (r["-webkit-tap-highlight-color"] = "transparent", r["-webkit-user-select"] = r["user-select"] = r["-webkit-touch-callout"] = "none", 
        t.innerHTML = ""), this.storage = e;
        var a, o, s, l = this._zlevelList = [], h = this._layers = {};
        if (this._layerConfig = {}, this._needsManuallyCompositing = !1, n) {
            var u = t.width, c = t.height;
            null != i.width && (u = i.width), null != i.height && (c = i.height), this.dpr = i.devicePixelRatio || 1, 
            t.width = u * this.dpr, t.height = c * this.dpr, this._width = u, this._height = c;
            var d = new tu(t, this, this.dpr);
            d.__builtin__ = !0, d.initContext(), (h[pu] = d).zlevel = pu, l.push(pu), this._domRoot = t;
        } else {
            this._width = this._getSize(0), this._height = this._getSize(1);
            var f = this._domRoot = (a = this._width, o = this._height, (s = document.createElement("div")).style.cssText = [ "position:relative", "overflow:hidden", "width:" + a + "px", "height:" + o + "px", "padding:0", "margin:0", "border-width:0" ].join(";") + ";", 
            s);
            t.appendChild(f);
        }
        this._hoverlayer = null, this._hoverElements = [];
    };
    vu.prototype = {
        constructor: vu,
        getType: function() {
            return "canvas";
        },
        isSingleCanvas: function() {
            return this._singleCanvas;
        },
        getViewportRoot: function() {
            return this._domRoot;
        },
        getViewportRootOffset: function() {
            var t = this.getViewportRoot();
            return t ? {
                offsetLeft: t.offsetLeft || 0,
                offsetTop: t.offsetTop || 0
            } : void 0;
        },
        refresh: function(t) {
            var e = this.storage.getDisplayList(!0), i = this._zlevelList;
            this._redrawId = Math.random(), this._paintList(e, t, this._redrawId);
            for (var n = 0; n < i.length; n++) {
                var r = i[n], a = this._layers[r];
                if (!a.__builtin__ && a.refresh) {
                    var o = 0 === n ? this._backgroundColor : null;
                    a.refresh(o);
                }
            }
            return this.refreshHover(), this;
        },
        addHover: function(t, e) {
            if (!t.__hoverMir) {
                var i = new t.constructor({
                    style: t.style,
                    shape: t.shape,
                    z: t.z,
                    z2: t.z2,
                    silent: t.silent
                });
                return (i.__from = t).__hoverMir = i, e && i.setStyle(e), this._hoverElements.push(i), 
                i;
            }
        },
        removeHover: function(t) {
            var e = t.__hoverMir, i = this._hoverElements, n = d(i, e);
            0 <= n && i.splice(n, 1), t.__hoverMir = null;
        },
        clearHover: function() {
            for (var t = this._hoverElements, e = 0; e < t.length; e++) {
                var i = t[e].__from;
                i && (i.__hoverMir = null);
            }
            t.length = 0;
        },
        refreshHover: function() {
            var t = this._hoverElements, e = t.length, i = this._hoverlayer;
            if (i && i.clear(), e) {
                te(t, this.storage.displayableSortFunc), i || (i = this._hoverlayer = this.getLayer(1e5));
                var n = {};
                i.ctx.save();
                for (var r = 0; r < e; ) {
                    var a = t[r], o = a.__from;
                    o && o.__zr ? (r++, o.invisible || (a.transform = o.transform, a.invTransform = o.invTransform, 
                    a.__clipPaths = o.__clipPaths, this._doPaintEl(a, i, !0, n))) : (t.splice(r, 1), 
                    o.__hoverMir = null, e--);
                }
                i.ctx.restore();
            }
        },
        getHoverLayer: function() {
            return this.getLayer(1e5);
        },
        _paintList: function(t, e, i) {
            if (this._redrawId === i) {
                e = e || !1, this._updateLayerStatus(t);
                var n = this._doPaintList(t, e);
                if (this._needsManuallyCompositing && this._compositeManually(), !n) {
                    var r = this;
                    eu(function() {
                        r._paintList(t, e, i);
                    });
                }
            }
        },
        _compositeManually: function() {
            var e = this.getLayer(pu).ctx, i = this._domRoot.width, n = this._domRoot.height;
            e.clearRect(0, 0, i, n), this.eachBuiltinLayer(function(t) {
                t.virtual && e.drawImage(t.dom, 0, 0, i, n);
            });
        },
        _doPaintList: function(t, e) {
            for (var i = [], n = 0; n < this._zlevelList.length; n++) {
                var r = this._zlevelList[n];
                (s = this._layers[r]).__builtin__ && s !== this._hoverlayer && (s.__dirty || e) && i.push(s);
            }
            for (var a = !0, o = 0; o < i.length; o++) {
                var s, l = (s = i[o]).ctx, h = {};
                l.save();
                var u = e ? s.__startIndex : s.__drawIndex, c = !e && s.incremental && Date.now, d = c && Date.now(), f = s.zlevel === this._zlevelList[0] ? this._backgroundColor : null;
                if (s.__startIndex === s.__endIndex) s.clear(!1, f); else if (u === s.__startIndex) {
                    var p = t[u];
                    p.incremental && p.notClear && !e || s.clear(!1, f);
                }
                -1 === u && (console.error("For some unknown reason. drawIndex is -1"), u = s.__startIndex);
                for (var g = u; g < s.__endIndex; g++) {
                    var m = t[g];
                    if (this._doPaintEl(m, s, e, h), m.__dirty = m.__dirtyText = !1, c) if (15 < Date.now() - d) break;
                }
                s.__drawIndex = g, s.__drawIndex < s.__endIndex && (a = !1), h.prevElClipPaths && l.restore(), 
                l.restore();
            }
            return Ll.wxa && R(this._layers, function(t) {
                t && t.ctx && t.ctx.draw && t.ctx.draw();
            }), a;
        },
        _doPaintEl: function(t, e, i, n) {
            var r, a, o, s = e.ctx, l = t.transform;
            if (!(!e.__dirty && !i || t.invisible || 0 === t.style.opacity || l && !l[0] && !l[3] || t.culling && (r = t, 
            a = this._width, o = this._height, gu.copy(r.getBoundingRect()), r.transform && gu.applyTransform(r.transform), 
            mu.width = a, mu.height = o, !gu.intersect(mu)))) {
                var h = t.__clipPaths;
                (!n.prevElClipPaths || function(t, e) {
                    if (t == e) return !1;
                    if (!t || !e || t.length !== e.length) return !0;
                    for (var i = 0; i < t.length; i++) if (t[i] !== e[i]) return !0;
                }(h, n.prevElClipPaths)) && (n.prevElClipPaths && (e.ctx.restore(), n.prevElClipPaths = null, 
                n.prevEl = null), h && (s.save(), function(t, e) {
                    for (var i = 0; i < t.length; i++) {
                        var n = t[i];
                        n.setTransform(e), e.beginPath(), n.buildPath(e, n.shape), e.clip(), n.restoreTransform(e);
                    }
                }(h, s), n.prevElClipPaths = h)), t.beforeBrush && t.beforeBrush(s), t.brush(s, n.prevEl || null), 
                (n.prevEl = t).afterBrush && t.afterBrush(s);
            }
        },
        getLayer: function(t, e) {
            this._singleCanvas && !this._needsManuallyCompositing && (t = pu);
            var i = this._layers[t];
            return i || ((i = new tu("zr_" + t, this, this.dpr)).zlevel = t, i.__builtin__ = !0, 
            this._layerConfig[t] && m(i, this._layerConfig[t], !0), e && (i.virtual = e), this.insertLayer(t, i), 
            i.initContext()), i;
        },
        insertLayer: function(t, e) {
            var i = this._layers, n = this._zlevelList, r = n.length, a = null, o = -1, s = this._domRoot;
            if (i[t]) Lh("ZLevel " + t + " has been used already"); else if ((l = e) && (l.__builtin__ || "function" == typeof l.resize && "function" == typeof l.refresh)) {
                var l;
                if (0 < r && t > n[0]) {
                    for (o = 0; o < r - 1 && !(n[o] < t && n[o + 1] > t); o++) ;
                    a = i[n[o]];
                }
                if (n.splice(o + 1, 0, t), !(i[t] = e).virtual) if (a) {
                    var h = a.dom;
                    h.nextSibling ? s.insertBefore(e.dom, h.nextSibling) : s.appendChild(e.dom);
                } else s.firstChild ? s.insertBefore(e.dom, s.firstChild) : s.appendChild(e.dom);
            } else Lh("Layer of zlevel " + t + " is not valid");
        },
        eachLayer: function(t, e) {
            var i, n, r = this._zlevelList;
            for (n = 0; n < r.length; n++) i = r[n], t.call(e, this._layers[i], i);
        },
        eachBuiltinLayer: function(t, e) {
            var i, n, r, a = this._zlevelList;
            for (r = 0; r < a.length; r++) n = a[r], (i = this._layers[n]).__builtin__ && t.call(e, i, n);
        },
        eachOtherLayer: function(t, e) {
            var i, n, r, a = this._zlevelList;
            for (r = 0; r < a.length; r++) n = a[r], (i = this._layers[n]).__builtin__ || t.call(e, i, n);
        },
        getLayers: function() {
            return this._layers;
        },
        _updateLayerStatus: function(t) {
            function e(t) {
                n && (n.__endIndex !== t && (n.__dirty = !0), n.__endIndex = t);
            }
            if (this.eachBuiltinLayer(function(t) {
                t.__dirty = t.__used = !1;
            }), this._singleCanvas) for (var i = 1; i < t.length; i++) {
                if ((o = t[i]).zlevel !== t[i - 1].zlevel || o.incremental) {
                    this._needsManuallyCompositing = !0;
                    break;
                }
            }
            var n = null, r = 0;
            for (i = 0; i < t.length; i++) {
                var a, o, s = (o = t[i]).zlevel;
                o.incremental ? ((a = this.getLayer(s + .001, this._needsManuallyCompositing)).incremental = !0, 
                r = 1) : a = this.getLayer(s + (0 < r ? .01 : 0), this._needsManuallyCompositing), 
                a.__builtin__ || Lh("ZLevel " + s + " has been used by unkown layer " + a.id), a !== n && (a.__used = !0, 
                a.__startIndex !== i && (a.__dirty = !0), a.__startIndex = i, a.__drawIndex = a.incremental ? -1 : i, 
                e(i), n = a), o.__dirty && (a.__dirty = !0, a.incremental && a.__drawIndex < 0 && (a.__drawIndex = i));
            }
            e(i), this.eachBuiltinLayer(function(t) {
                !t.__used && 0 < t.getElementCount() && (t.__dirty = !0, t.__startIndex = t.__endIndex = t.__drawIndex = 0), 
                t.__dirty && t.__drawIndex < 0 && (t.__drawIndex = t.__startIndex);
            });
        },
        clear: function() {
            return this.eachBuiltinLayer(this._clearLayer), this;
        },
        _clearLayer: function(t) {
            t.clear();
        },
        setBackgroundColor: function(t) {
            this._backgroundColor = t;
        },
        configLayer: function(t, e) {
            if (e) {
                var i = this._layerConfig;
                i[t] ? m(i[t], e, !0) : i[t] = e;
                for (var n = 0; n < this._zlevelList.length; n++) {
                    var r = this._zlevelList[n];
                    if (r === t || r === t + .01) m(this._layers[r], i[t], !0);
                }
            }
        },
        delLayer: function(t) {
            var e = this._layers, i = this._zlevelList, n = e[t];
            n && (n.dom.parentNode.removeChild(n.dom), delete e[t], i.splice(d(i, t), 1));
        },
        resize: function(e, i) {
            if (this._domRoot.style) {
                var t = this._domRoot;
                t.style.display = "none";
                var n = this._opts;
                if (null != e && (n.width = e), null != i && (n.height = i), e = this._getSize(0), 
                i = this._getSize(1), t.style.display = "", this._width != e || i != this._height) {
                    for (var r in t.style.width = e + "px", t.style.height = i + "px", this._layers) this._layers.hasOwnProperty(r) && this._layers[r].resize(e, i);
                    R(this._progressiveLayers, function(t) {
                        t.resize(e, i);
                    }), this.refresh(!0);
                }
                this._width = e, this._height = i;
            } else {
                if (null == e || null == i) return;
                this._width = e, this._height = i, this.getLayer(pu).resize(e, i);
            }
            return this;
        },
        clearLayer: function(t) {
            var e = this._layers[t];
            e && e.clear();
        },
        dispose: function() {
            this.root.innerHTML = "", this.root = this.storage = this._domRoot = this._layers = null;
        },
        getRenderedCanvas: function(t) {
            if (t = t || {}, this._singleCanvas && !this._compositeManually) return this._layers[pu].dom;
            var e = new tu("image", this, t.pixelRatio || this.dpr);
            if (e.initContext(), e.clear(!1, t.backgroundColor || this._backgroundColor), t.pixelRatio <= this.dpr) {
                this.refresh();
                var i = e.dom.width, n = e.dom.height, r = e.ctx;
                this.eachLayer(function(t) {
                    t.__builtin__ ? r.drawImage(t.dom, 0, 0, i, n) : t.renderToCanvas && (e.ctx.save(), 
                    t.renderToCanvas(e.ctx), e.ctx.restore());
                });
            } else for (var a = {}, o = this.storage.getDisplayList(!0), s = 0; s < o.length; s++) {
                var l = o[s];
                this._doPaintEl(l, e, !0, a);
            }
            return e.dom;
        },
        getWidth: function() {
            return this._width;
        },
        getHeight: function() {
            return this._height;
        },
        _getSize: function(t) {
            var e = this._opts, i = [ "width", "height" ][t], n = [ "clientWidth", "clientHeight" ][t], r = [ "paddingLeft", "paddingTop" ][t], a = [ "paddingRight", "paddingBottom" ][t];
            if (null != e[i] && "auto" !== e[i]) return parseFloat(e[i]);
            var o = this.root, s = document.defaultView.getComputedStyle(o);
            return (o[n] || Ge(s[i]) || Ge(o.style[i])) - (Ge(s[r]) || 0) - (Ge(s[a]) || 0) | 0;
        },
        pathToImage: function(t, e) {
            e = e || this.dpr;
            var i = document.createElement("canvas"), n = i.getContext("2d"), r = t.getBoundingRect(), a = t.style, o = a.shadowBlur * e, s = a.shadowOffsetX * e, l = a.shadowOffsetY * e, h = a.hasStroke() ? a.lineWidth : 0, u = Math.max(h / 2, -s + o), c = Math.max(h / 2, s + o), d = Math.max(h / 2, -l + o), f = Math.max(h / 2, l + o), p = r.width + u + c, g = r.height + d + f;
            i.width = p * e, i.height = g * e, n.scale(e, e), n.clearRect(0, 0, p, g), n.dpr = e;
            var m = {
                position: t.position,
                rotation: t.rotation,
                scale: t.scale
            };
            t.position = [ u - r.x, d - r.y ], t.rotation = 0, t.scale = [ 1, 1 ], t.updateTransform(), 
            t && t.brush(n);
            var v = new Fe({
                style: {
                    x: 0,
                    y: 0,
                    image: i
                }
            });
            return null != m.position && (v.position = t.position = m.position), null != m.rotation && (v.rotation = t.rotation = m.rotation), 
            null != m.scale && (v.scale = t.scale = m.scale), v;
        }
    };
    var yu = function(t) {
        t = t || {}, this.stage = t.stage || {}, this.onframe = t.onframe || function() {}, 
        this._clips = [], this._running = !1, this._time, this._pausedTime, this._pauseStart, 
        this._paused = !1, th.call(this);
    };
    yu.prototype = {
        constructor: yu,
        addClip: function(t) {
            this._clips.push(t);
        },
        addAnimator: function(t) {
            t.animation = this;
            for (var e = t.getClips(), i = 0; i < e.length; i++) this.addClip(e[i]);
        },
        removeClip: function(t) {
            var e = d(this._clips, t);
            0 <= e && this._clips.splice(e, 1);
        },
        removeAnimator: function(t) {
            for (var e = t.getClips(), i = 0; i < e.length; i++) this.removeClip(e[i]);
            t.animation = null;
        },
        _update: function() {
            for (var t = new Date().getTime() - this._pausedTime, e = t - this._time, i = this._clips, n = i.length, r = [], a = [], o = 0; o < n; o++) {
                var s = i[o], l = s.step(t, e);
                l && (r.push(l), a.push(s));
            }
            for (o = 0; o < n; ) i[o]._needsRemove ? (i[o] = i[n - 1], i.pop(), n--) : o++;
            n = r.length;
            for (o = 0; o < n; o++) a[o].fire(r[o]);
            this._time = t, this.onframe(e), this.trigger("frame", e), this.stage.update && this.stage.update();
        },
        _startLoop: function() {
            var e = this;
            this._running = !0, eu(function t() {
                e._running && (eu(t), !e._paused && e._update());
            });
        },
        start: function() {
            this._time = new Date().getTime(), this._pausedTime = 0, this._startLoop();
        },
        stop: function() {
            this._running = !1;
        },
        pause: function() {
            this._paused || (this._pauseStart = new Date().getTime(), this._paused = !0);
        },
        resume: function() {
            this._paused && (this._pausedTime += new Date().getTime() - this._pauseStart, this._paused = !1);
        },
        clear: function() {
            this._clips = [];
        },
        isFinished: function() {
            return !this._clips.length;
        },
        animate: function(t, e) {
            var i = new Dh(t, (e = e || {}).loop, e.getter, e.setter);
            return this.addAnimator(i), i;
        }
    }, r(yu, th);
    var xu = function() {
        this._track = [];
    };
    xu.prototype = {
        constructor: xu,
        recognize: function(t, e, i) {
            return this._doTrack(t, e, i), this._recognize(t);
        },
        clear: function() {
            return this._track.length = 0, this;
        },
        _doTrack: function(t, e, i) {
            var n = t.touches;
            if (n) {
                for (var r = {
                    points: [],
                    touches: [],
                    target: e,
                    event: t
                }, a = 0, o = n.length; a < o; a++) {
                    var s = n[a], l = it(i, s, {});
                    r.points.push([ l.zrX, l.zrY ]), r.touches.push(s);
                }
                this._track.push(r);
            }
        },
        _recognize: function(t) {
            for (var e in _u) if (_u.hasOwnProperty(e)) {
                var i = _u[e](this._track, t);
                if (i) return i;
            }
        }
    };
    var _u = {
        pinch: function(t, e) {
            var i, n = t.length;
            if (n) {
                var r = (t[n - 1] || {}).points, a = (t[n - 2] || {}).points || r;
                if (a && 1 < a.length && r && 1 < r.length) {
                    var o = Ve(r) / Ve(a);
                    !isFinite(o) && (o = 1), e.pinchScale = o;
                    var s = [ ((i = r)[0][0] + i[1][0]) / 2, (i[0][1] + i[1][1]) / 2 ];
                    return e.pinchX = s[0], e.pinchY = s[1], {
                        type: "pinch",
                        target: t[0].target,
                        event: e
                    };
                }
            }
        }
    }, wu = [ "click", "dblclick", "mousewheel", "mouseout", "mouseup", "mousedown", "mousemove", "contextmenu" ], bu = [ "touchstart", "touchend", "touchmove" ], Su = {
        pointerdown: 1,
        pointerup: 1,
        pointermove: 1,
        pointerout: 1
    }, Mu = D(wu, function(t) {
        var e = t.replace("mouse", "pointer");
        return Su[e] ? e : t;
    }), Iu = {
        mousemove: function(t) {
            t = rt(this.dom, t), this.trigger("mousemove", t);
        },
        mouseout: function(t) {
            var e = (t = rt(this.dom, t)).toElement || t.relatedTarget;
            if (e != this.dom) for (;e && 9 != e.nodeType; ) {
                if (e === this.dom) return;
                e = e.parentNode;
            }
            this.trigger("mouseout", t);
        },
        touchstart: function(t) {
            (t = rt(this.dom, t)).zrByTouch = !0, this._lastTouchMoment = new Date(), We(this, t, "start"), 
            Iu.mousemove.call(this, t), Iu.mousedown.call(this, t), Xe(this);
        },
        touchmove: function(t) {
            (t = rt(this.dom, t)).zrByTouch = !0, We(this, t, "change"), Iu.mousemove.call(this, t), 
            Xe(this);
        },
        touchend: function(t) {
            (t = rt(this.dom, t)).zrByTouch = !0, We(this, t, "end"), Iu.mouseup.call(this, t), 
            +new Date() - this._lastTouchMoment < 300 && Iu.click.call(this, t), Xe(this);
        },
        pointerdown: function(t) {
            Iu.mousedown.call(this, t);
        },
        pointermove: function(t) {
            qe(t) || Iu.mousemove.call(this, t);
        },
        pointerup: function(t) {
            Iu.mouseup.call(this, t);
        },
        pointerout: function(t) {
            qe(t) || Iu.mouseout.call(this, t);
        }
    };
    R([ "click", "mousedown", "mouseup", "mousewheel", "dblclick", "contextmenu" ], function(e) {
        Iu[e] = function(t) {
            t = rt(this.dom, t), this.trigger(e, t);
        };
    });
    var Tu = je.prototype;
    Tu.dispose = function() {
        for (var t = wu.concat(bu), e = 0; e < t.length; e++) {
            var i = t[e];
            n = this.dom, r = He(i), a = this._handlers[i], eh ? n.removeEventListener(r, a) : n.detachEvent("on" + r, a);
        }
        var n, r, a;
    }, Tu.setCursor = function(t) {
        this.dom.style && (this.dom.style.cursor = t || "default");
    }, r(je, th);
    var Cu = !Ll.canvasSupported, Du = {
        canvas: vu
    }, Au = {}, ku = function(t, e, i) {
        i = i || {}, this.dom = e, this.id = t;
        var n = this, r = new qh(), a = i.renderer;
        if (Cu) {
            if (!Du.vml) throw new Error("You need to require 'zrender/vml/vml' to support IE8");
            a = "vml";
        } else a && Du[a] || (a = "canvas");
        var o = new Du[a](e, r, i, t);
        this.storage = r, this.painter = o;
        var s = Ll.node || Ll.worker ? null : new je(o.getViewportRoot());
        this.handler = new oh(r, o, s, o.root), this.animation = new yu({
            stage: {
                update: _(this.flush, this)
            }
        }), this.animation.start(), this._needsRefresh;
        var l = r.delFromStorage, h = r.addToStorage;
        r.delFromStorage = function(t) {
            l.call(r, t), t && t.removeSelfFromZr(n);
        }, r.addToStorage = function(t) {
            h.call(r, t), t.addSelfToZr(n);
        };
    };
    ku.prototype = {
        constructor: ku,
        getId: function() {
            return this.id;
        },
        add: function(t) {
            this.storage.addRoot(t), this._needsRefresh = !0;
        },
        remove: function(t) {
            this.storage.delRoot(t), this._needsRefresh = !0;
        },
        configLayer: function(t, e) {
            this.painter.configLayer && this.painter.configLayer(t, e), this._needsRefresh = !0;
        },
        setBackgroundColor: function(t) {
            this.painter.setBackgroundColor && this.painter.setBackgroundColor(t), this._needsRefresh = !0;
        },
        refreshImmediately: function() {
            this._needsRefresh = !1, this.painter.refresh(), this._needsRefresh = !1;
        },
        refresh: function() {
            this._needsRefresh = !0;
        },
        flush: function() {
            var t;
            this._needsRefresh && (t = !0, this.refreshImmediately()), this._needsRefreshHover && (t = !0, 
            this.refreshHoverImmediately()), t && this.trigger("rendered");
        },
        addHover: function(t, e) {
            if (this.painter.addHover) {
                var i = this.painter.addHover(t, e);
                return this.refreshHover(), i;
            }
        },
        removeHover: function(t) {
            this.painter.removeHover && (this.painter.removeHover(t), this.refreshHover());
        },
        clearHover: function() {
            this.painter.clearHover && (this.painter.clearHover(), this.refreshHover());
        },
        refreshHover: function() {
            this._needsRefreshHover = !0;
        },
        refreshHoverImmediately: function() {
            this._needsRefreshHover = !1, this.painter.refreshHover && this.painter.refreshHover();
        },
        resize: function(t) {
            t = t || {}, this.painter.resize(t.width, t.height), this.handler.resize();
        },
        clearAnimation: function() {
            this.animation.clear();
        },
        getWidth: function() {
            return this.painter.getWidth();
        },
        getHeight: function() {
            return this.painter.getHeight();
        },
        pathToImage: function(t, e) {
            return this.painter.pathToImage(t, e);
        },
        setCursorStyle: function(t) {
            this.handler.setCursorStyle(t);
        },
        findHover: function(t, e) {
            return this.handler.findHover(t, e);
        },
        on: function(t, e, i) {
            this.handler.on(t, e, i);
        },
        off: function(t, e) {
            this.handler.off(t, e);
        },
        trigger: function(t, e) {
            this.handler.trigger(t, e);
        },
        clear: function() {
            this.storage.delRoot(), this.painter.clear();
        },
        dispose: function() {
            var t;
            this.animation.stop(), this.clear(), this.storage.dispose(), this.painter.dispose(), 
            this.handler.dispose(), this.animation = this.storage = this.painter = this.handler = null, 
            t = this.id, delete Au[t];
        }
    };
    var Pu = (Object.freeze || Object)({
        version: "4.0.5",
        init: Ue,
        dispose: function(t) {
            if (t) t.dispose(); else {
                for (var e in Au) Au.hasOwnProperty(e) && Au[e].dispose();
                Au = {};
            }
            return this;
        },
        getInstance: function(t) {
            return Au[t];
        },
        registerPainter: function(t, e) {
            Du[t] = e;
        }
    }), Lu = R, Ou = L, Eu = P, zu = "series\0", Bu = [ "fontStyle", "fontWeight", "fontSize", "fontFamily", "rich", "tag", "color", "textBorderColor", "textBorderWidth", "width", "height", "lineHeight", "align", "verticalAlign", "baseline", "shadowColor", "shadowBlur", "shadowOffsetX", "shadowOffsetY", "textShadowColor", "textShadowBlur", "textShadowOffsetX", "textShadowOffsetY", "backgroundColor", "borderColor", "borderWidth", "borderRadius", "padding" ], Ru = 0, Nu = ".", Fu = "___EC__COMPONENT__CONTAINER___", Gu = 0, Vu = function(s) {
        for (var t = 0; t < s.length; t++) s[t][1] || (s[t][1] = s[t][0]);
        return function(t, e, i) {
            for (var n = {}, r = 0; r < s.length; r++) {
                var a = s[r][1];
                if (!(e && 0 <= d(e, a) || i && d(i, a) < 0)) {
                    var o = t.getShallow(a);
                    null != o && (n[s[r][0]] = o);
                }
            }
            return n;
        };
    }, Hu = Vu([ [ "lineWidth", "width" ], [ "stroke", "color" ], [ "opacity" ], [ "shadowBlur" ], [ "shadowOffsetX" ], [ "shadowOffsetY" ], [ "shadowColor" ] ]), Wu = {
        getLineStyle: function(t) {
            var e = Hu(this, t), i = this.getLineDash(e.lineWidth);
            return i && (e.lineDash = i), e;
        },
        getLineDash: function(t) {
            null == t && (t = 1);
            var e = this.get("type"), i = Math.max(t, 2), n = 4 * t;
            return "solid" === e || null == e ? null : "dashed" === e ? [ n, n ] : [ i, i ];
        }
    }, Xu = Vu([ [ "fill", "color" ], [ "shadowBlur" ], [ "shadowOffsetX" ], [ "shadowOffsetY" ], [ "opacity" ], [ "shadowColor" ] ]), qu = {
        getAreaStyle: function(t, e) {
            return Xu(this, t, e);
        }
    }, ju = Math.pow, Uu = Math.sqrt, Yu = 1e-8, Zu = 1e-4, $u = Uu(3), Ku = 1 / 3, Qu = N(), Ju = N(), tc = N(), ec = Math.min, ic = Math.max, nc = Math.sin, rc = Math.cos, ac = 2 * Math.PI, oc = N(), sc = N(), lc = N(), hc = [], uc = [], cc = {
        M: 1,
        L: 2,
        C: 3,
        Q: 4,
        A: 5,
        Z: 6,
        R: 7
    }, dc = [], fc = [], pc = [], gc = [], mc = Math.min, vc = Math.max, yc = Math.cos, xc = Math.sin, _c = Math.sqrt, wc = Math.abs, bc = "undefined" != typeof Float32Array, Sc = function(t) {
        this._saveData = !t, this._saveData && (this.data = []), this._ctx = null;
    };
    Sc.prototype = {
        constructor: Sc,
        _xi: 0,
        _yi: 0,
        _x0: 0,
        _y0: 0,
        _ux: 0,
        _uy: 0,
        _len: 0,
        _lineDash: null,
        _dashOffset: 0,
        _dashIdx: 0,
        _dashSum: 0,
        setScale: function(t, e) {
            this._ux = wc(1 / kh / t) || 0, this._uy = wc(1 / kh / e) || 0;
        },
        getContext: function() {
            return this._ctx;
        },
        beginPath: function(t) {
            return (this._ctx = t) && t.beginPath(), t && (this.dpr = t.dpr), this._saveData && (this._len = 0), 
            this._lineDash && (this._lineDash = null, this._dashOffset = 0), this;
        },
        moveTo: function(t, e) {
            return this.addData(cc.M, t, e), this._ctx && this._ctx.moveTo(t, e), this._x0 = t, 
            this._y0 = e, this._xi = t, this._yi = e, this;
        },
        lineTo: function(t, e) {
            var i = wc(t - this._xi) > this._ux || wc(e - this._yi) > this._uy || this._len < 5;
            return this.addData(cc.L, t, e), this._ctx && i && (this._needsDash() ? this._dashedLineTo(t, e) : this._ctx.lineTo(t, e)), 
            i && (this._xi = t, this._yi = e), this;
        },
        bezierCurveTo: function(t, e, i, n, r, a) {
            return this.addData(cc.C, t, e, i, n, r, a), this._ctx && (this._needsDash() ? this._dashedBezierTo(t, e, i, n, r, a) : this._ctx.bezierCurveTo(t, e, i, n, r, a)), 
            this._xi = r, this._yi = a, this;
        },
        quadraticCurveTo: function(t, e, i, n) {
            return this.addData(cc.Q, t, e, i, n), this._ctx && (this._needsDash() ? this._dashedQuadraticTo(t, e, i, n) : this._ctx.quadraticCurveTo(t, e, i, n)), 
            this._xi = i, this._yi = n, this;
        },
        arc: function(t, e, i, n, r, a) {
            return this.addData(cc.A, t, e, i, i, n, r - n, 0, a ? 0 : 1), this._ctx && this._ctx.arc(t, e, i, n, r, a), 
            this._xi = yc(r) * i + t, this._yi = xc(r) * i + e, this;
        },
        arcTo: function(t, e, i, n, r) {
            return this._ctx && this._ctx.arcTo(t, e, i, n, r), this;
        },
        rect: function(t, e, i, n) {
            return this._ctx && this._ctx.rect(t, e, i, n), this.addData(cc.R, t, e, i, n), 
            this;
        },
        closePath: function() {
            this.addData(cc.Z);
            var t = this._ctx, e = this._x0, i = this._y0;
            return t && (this._needsDash() && this._dashedLineTo(e, i), t.closePath()), this._xi = e, 
            this._yi = i, this;
        },
        fill: function(t) {
            t && t.fill(), this.toStatic();
        },
        stroke: function(t) {
            t && t.stroke(), this.toStatic();
        },
        setLineDash: function(t) {
            if (t instanceof Array) {
                this._lineDash = t;
                for (var e = this._dashIdx = 0, i = 0; i < t.length; i++) e += t[i];
                this._dashSum = e;
            }
            return this;
        },
        setLineDashOffset: function(t) {
            return this._dashOffset = t, this;
        },
        len: function() {
            return this._len;
        },
        setData: function(t) {
            var e = t.length;
            this.data && this.data.length == e || !bc || (this.data = new Float32Array(e));
            for (var i = 0; i < e; i++) this.data[i] = t[i];
            this._len = e;
        },
        appendPath: function(t) {
            t instanceof Array || (t = [ t ]);
            for (var e = t.length, i = 0, n = this._len, r = 0; r < e; r++) i += t[r].len();
            bc && this.data instanceof Float32Array && (this.data = new Float32Array(n + i));
            for (r = 0; r < e; r++) for (var a = t[r].data, o = 0; o < a.length; o++) this.data[n++] = a[o];
            this._len = n;
        },
        addData: function(t) {
            if (this._saveData) {
                var e = this.data;
                this._len + arguments.length > e.length && (this._expandData(), e = this.data);
                for (var i = 0; i < arguments.length; i++) e[this._len++] = arguments[i];
                this._prevCmd = t;
            }
        },
        _expandData: function() {
            if (!(this.data instanceof Array)) {
                for (var t = [], e = 0; e < this._len; e++) t[e] = this.data[e];
                this.data = t;
            }
        },
        _needsDash: function() {
            return this._lineDash;
        },
        _dashedLineTo: function(t, e) {
            var i, n, r = this._dashSum, a = this._dashOffset, o = this._lineDash, s = this._ctx, l = this._xi, h = this._yi, u = t - l, c = e - h, d = _c(u * u + c * c), f = l, p = h, g = o.length;
            for (a < 0 && (a = r + a), f -= (a %= r) * (u /= d), p -= a * (c /= d); 0 < u && f <= t || u < 0 && t <= f || 0 == u && (0 < c && p <= e || c < 0 && e <= p); ) f += u * (i = o[n = this._dashIdx]), 
            p += c * i, this._dashIdx = (n + 1) % g, 0 < u && f < l || u < 0 && l < f || 0 < c && p < h || c < 0 && h < p || s[n % 2 ? "moveTo" : "lineTo"](0 <= u ? mc(f, t) : vc(f, t), 0 <= c ? mc(p, e) : vc(p, e));
            u = f - t, c = p - e, this._dashOffset = -_c(u * u + c * c);
        },
        _dashedBezierTo: function(t, e, i, n, r, a) {
            var o, s, l, h, u, c = this._dashSum, d = this._dashOffset, f = this._lineDash, p = this._ctx, g = this._xi, m = this._yi, v = pi, y = 0, x = this._dashIdx, _ = f.length, w = 0;
            for (d < 0 && (d = c + d), d %= c, o = 0; o < 1; o += .1) s = v(g, t, i, r, o + .1) - v(g, t, i, r, o), 
            l = v(m, e, n, a, o + .1) - v(m, e, n, a, o), y += _c(s * s + l * l);
            for (;x < _ && !(d < (w += f[x])); x++) ;
            for (o = (w - d) / y; o <= 1; ) h = v(g, t, i, r, o), u = v(m, e, n, a, o), x % 2 ? p.moveTo(h, u) : p.lineTo(h, u), 
            o += f[x] / y, x = (x + 1) % _;
            x % 2 != 0 && p.lineTo(r, a), s = r - h, l = a - u, this._dashOffset = -_c(s * s + l * l);
        },
        _dashedQuadraticTo: function(t, e, i, n) {
            var r = i, a = n;
            i = (i + 2 * t) / 3, n = (n + 2 * e) / 3, t = (this._xi + 2 * t) / 3, e = (this._yi + 2 * e) / 3, 
            this._dashedBezierTo(t, e, i, n, r, a);
        },
        toStatic: function() {
            var t = this.data;
            t instanceof Array && (t.length = this._len, bc && (this.data = new Float32Array(t)));
        },
        getBoundingRect: function() {
            dc[0] = dc[1] = pc[0] = pc[1] = Number.MAX_VALUE, fc[0] = fc[1] = gc[0] = gc[1] = -Number.MAX_VALUE;
            for (var t = this.data, e = 0, i = 0, n = 0, r = 0, a = 0; a < t.length; ) {
                var o = t[a++];
                switch (1 == a && (n = e = t[a], r = i = t[a + 1]), o) {
                  case cc.M:
                    e = n = t[a++], i = r = t[a++], pc[0] = n, pc[1] = r, gc[0] = n, gc[1] = r;
                    break;

                  case cc.L:
                    Si(e, i, t[a], t[a + 1], pc, gc), e = t[a++], i = t[a++];
                    break;

                  case cc.C:
                    Mi(e, i, t[a++], t[a++], t[a++], t[a++], t[a], t[a + 1], pc, gc), e = t[a++], i = t[a++];
                    break;

                  case cc.Q:
                    p = e, g = i, m = t[a++], v = t[a++], y = t[a], x = t[a + 1], _ = pc, w = gc, S = b = void 0, 
                    S = yi, M = ic(ec((b = _i)(p, m, y), 1), 0), I = ic(ec(b(g, v, x), 1), 0), T = S(p, m, y, M), 
                    C = S(g, v, x, I), _[0] = ec(p, y, T), _[1] = ec(g, x, C), w[0] = ic(p, y, T), w[1] = ic(g, x, C), 
                    e = t[a++], i = t[a++];
                    break;

                  case cc.A:
                    var s = t[a++], l = t[a++], h = t[a++], u = t[a++], c = t[a++], d = t[a++] + c, f = (t[a++], 
                    1 - t[a++]);
                    1 == a && (n = yc(c) * h + s, r = xc(c) * u + l), Ii(s, l, h, u, c, d, f, pc, gc), 
                    e = yc(d) * h + s, i = xc(d) * u + l;
                    break;

                  case cc.R:
                    Si(n = e = t[a++], r = i = t[a++], n + t[a++], r + t[a++], pc, gc);
                    break;

                  case cc.Z:
                    e = n, i = r;
                }
                K(dc, dc, pc), Q(fc, fc, gc);
            }
            var p, g, m, v, y, x, _, w, b, S, M, I, T, C;
            return 0 === a && (dc[0] = dc[1] = fc[0] = fc[1] = 0), new Yt(dc[0], dc[1], fc[0] - dc[0], fc[1] - dc[1]);
        },
        rebuildPath: function(t) {
            for (var e, i, n, r, a, o, s = this.data, l = this._ux, h = this._uy, u = this._len, c = 0; c < u; ) {
                var d = s[c++];
                switch (1 == c && (e = n = s[c], i = r = s[c + 1]), d) {
                  case cc.M:
                    e = n = s[c++], i = r = s[c++], t.moveTo(n, r);
                    break;

                  case cc.L:
                    a = s[c++], o = s[c++], (wc(a - n) > l || wc(o - r) > h || c === u - 1) && (t.lineTo(a, o), 
                    n = a, r = o);
                    break;

                  case cc.C:
                    t.bezierCurveTo(s[c++], s[c++], s[c++], s[c++], s[c++], s[c++]), n = s[c - 2], r = s[c - 1];
                    break;

                  case cc.Q:
                    t.quadraticCurveTo(s[c++], s[c++], s[c++], s[c++]), n = s[c - 2], r = s[c - 1];
                    break;

                  case cc.A:
                    var f = s[c++], p = s[c++], g = s[c++], m = s[c++], v = s[c++], y = s[c++], x = s[c++], _ = s[c++], w = m < g ? g : m, b = m < g ? 1 : g / m, S = m < g ? m / g : 1, M = v + y;
                    .001 < Math.abs(g - m) ? (t.translate(f, p), t.rotate(x), t.scale(b, S), t.arc(0, 0, w, v, M, 1 - _), 
                    t.scale(1 / b, 1 / S), t.rotate(-x), t.translate(-f, -p)) : t.arc(f, p, w, v, M, 1 - _), 
                    1 == c && (e = yc(v) * g + f, i = xc(v) * m + p), n = yc(M) * g + f, r = xc(M) * m + p;
                    break;

                  case cc.R:
                    e = n = s[c], i = r = s[c + 1], t.rect(s[c++], s[c++], s[c++], s[c++]);
                    break;

                  case cc.Z:
                    t.closePath(), n = e, r = i;
                }
            }
        }
    }, Sc.CMD = cc;
    var Mc = 2 * Math.PI, Ic = 2 * Math.PI, Tc = Sc.CMD, Cc = 2 * Math.PI, Dc = 1e-4, Ac = [ -1, -1, -1 ], kc = [ -1, -1 ], Pc = Jh.prototype.getCanvasPattern, Lc = Math.abs, Oc = new Sc(!0);
    Bi.prototype = {
        constructor: Bi,
        type: "path",
        __dirtyPath: !0,
        strokeContainThreshold: 5,
        brush: function(t, e) {
            var i, n = this.style, r = this.path || Oc, a = n.hasStroke(), o = n.hasFill(), s = n.fill, l = n.stroke, h = o && !!s.colorStops, u = a && !!l.colorStops, c = o && !!s.image, d = a && !!l.image;
            (n.bind(t, this, e), this.setTransform(t), this.__dirty) && (h && (i = i || this.getBoundingRect(), 
            this._fillGradient = n.getGradient(t, s, i)), u && (i = i || this.getBoundingRect(), 
            this._strokeGradient = n.getGradient(t, l, i)));
            h ? t.fillStyle = this._fillGradient : c && (t.fillStyle = Pc.call(s, t)), u ? t.strokeStyle = this._strokeGradient : d && (t.strokeStyle = Pc.call(l, t));
            var f = n.lineDash, p = n.lineDashOffset, g = !!t.setLineDash, m = this.getGlobalScale();
            if (r.setScale(m[0], m[1]), this.__dirtyPath || f && !g && a ? (r.beginPath(t), 
            f && !g && (r.setLineDash(f), r.setLineDashOffset(p)), this.buildPath(r, this.shape, !1), 
            this.path && (this.__dirtyPath = !1)) : (t.beginPath(), this.path.rebuildPath(t)), 
            o) if (null != n.fillOpacity) {
                var v = t.globalAlpha;
                t.globalAlpha = n.fillOpacity * n.opacity, r.fill(t), t.globalAlpha = v;
            } else r.fill(t);
            if (f && g && (t.setLineDash(f), t.lineDashOffset = p), a) if (null != n.strokeOpacity) {
                v = t.globalAlpha;
                t.globalAlpha = n.strokeOpacity * n.opacity, r.stroke(t), t.globalAlpha = v;
            } else r.stroke(t);
            f && g && t.setLineDash([]), null != n.text && (this.restoreTransform(t), this.drawRectText(t, this.getBoundingRect()));
        },
        buildPath: function() {},
        createPathProxy: function() {
            this.path = new Sc();
        },
        getBoundingRect: function() {
            var t = this._rect, e = this.style, i = !t;
            if (i) {
                var n = this.path;
                n || (n = this.path = new Sc()), this.__dirtyPath && (n.beginPath(), this.buildPath(n, this.shape, !1)), 
                t = n.getBoundingRect();
            }
            if (this._rect = t, e.hasStroke()) {
                var r = this._rectWithStroke || (this._rectWithStroke = t.clone());
                if (this.__dirty || i) {
                    r.copy(t);
                    var a = e.lineWidth, o = e.strokeNoScale ? this.getLineScale() : 1;
                    e.hasFill() || (a = Math.max(a, this.strokeContainThreshold || 4)), 1e-10 < o && (r.width += a / o, 
                    r.height += a / o, r.x -= a / o / 2, r.y -= a / o / 2);
                }
                return r;
            }
            return t;
        },
        contain: function(t, e) {
            var i = this.transformCoordToLocal(t, e), n = this.getBoundingRect(), r = this.style;
            if (t = i[0], e = i[1], n.contain(t, e)) {
                var a = this.path.data;
                if (r.hasStroke()) {
                    var o = r.lineWidth, s = r.strokeNoScale ? this.getLineScale() : 1;
                    if (1e-10 < s && (r.hasFill() || (o = Math.max(o, this.strokeContainThreshold)), 
                    zi(a, o / s, !0, t, e))) return !0;
                }
                if (r.hasFill()) return zi(a, 0, !1, t, e);
            }
            return !1;
        },
        dirty: function(t) {
            null == t && (t = !0), t && (this.__dirtyPath = t, this._rect = null), this.__dirty = this.__dirtyText = !0, 
            this.__zr && this.__zr.refresh(), this.__clipTarget && this.__clipTarget.dirty();
        },
        animateShape: function(t) {
            return this.animate("shape", t);
        },
        attrKV: function(t, e) {
            "shape" === t ? (this.setShape(e), this.__dirtyPath = !0, this._rect = null) : Ne.prototype.attrKV.call(this, t, e);
        },
        setShape: function(t, e) {
            var i = this.shape;
            if (i) {
                if (L(t)) for (var n in t) t.hasOwnProperty(n) && (i[n] = t[n]); else i[t] = e;
                this.dirty(!0);
            }
            return this;
        },
        getLineScale: function() {
            var t = this.transform;
            return t && 1e-10 < Lc(t[0] - 1) && 1e-10 < Lc(t[3] - 1) ? Math.sqrt(Lc(t[0] * t[3] - t[2] * t[1])) : 1;
        }
    }, Bi.extend = function(r) {
        var t = function(t) {
            Bi.call(this, t), r.style && this.style.extendFrom(r.style, !1);
            var e = r.shape;
            if (e) {
                this.shape = this.shape || {};
                var i = this.shape;
                for (var n in e) !i.hasOwnProperty(n) && e.hasOwnProperty(n) && (i[n] = e[n]);
            }
            r.init && r.init.call(this, t);
        };
        for (var e in a(t, Bi), r) "style" !== e && "shape" !== e && (t.prototype[e] = r[e]);
        return t;
    }, a(Bi, Ne);
    var Ec = Sc.CMD, zc = [ [], [], [] ], Bc = Math.sqrt, Rc = Math.atan2, Nc = function(t, e) {
        var i, n, r, a, o, s = t.data, l = Ec.M, h = Ec.C, u = Ec.L, c = Ec.R, d = Ec.A, f = Ec.Q;
        for (a = r = 0; r < s.length; ) {
            switch (i = s[r++], a = r, n = 0, i) {
              case l:
              case u:
                n = 1;
                break;

              case h:
                n = 3;
                break;

              case f:
                n = 2;
                break;

              case d:
                var p = e[4], g = e[5], m = Bc(e[0] * e[0] + e[1] * e[1]), v = Bc(e[2] * e[2] + e[3] * e[3]), y = Rc(-e[1] / v, e[0] / m);
                s[r] *= m, s[r++] += p, s[r] *= v, s[r++] += g, s[r++] *= m, s[r++] *= v, s[r++] += y, 
                s[r++] += y, a = r += 2;
                break;

              case c:
                x[0] = s[r++], x[1] = s[r++], $(x, x, e), s[a++] = x[0], s[a++] = x[1], x[0] += s[r++], 
                x[1] += s[r++], $(x, x, e), s[a++] = x[0], s[a++] = x[1];
            }
            for (o = 0; o < n; o++) {
                var x;
                (x = zc[o])[0] = s[r++], x[1] = s[r++], $(x, x, e), s[a++] = x[0], s[a++] = x[1];
            }
        }
    }, Fc = Math.sqrt, Gc = Math.sin, Vc = Math.cos, Hc = Math.PI, Wc = function(t) {
        return Math.sqrt(t[0] * t[0] + t[1] * t[1]);
    }, Xc = function(t, e) {
        return (t[0] * e[0] + t[1] * e[1]) / (Wc(t) * Wc(e));
    }, qc = function(t, e) {
        return (t[0] * e[1] < t[1] * e[0] ? -1 : 1) * Math.acos(Xc(t, e));
    }, jc = /([mlvhzcqtsa])([^mlvhzcqtsa]*)/gi, Uc = /-?([0-9]*\.)?[0-9]+([eE]-?[0-9]+)?/g, Yc = function(t) {
        Ne.call(this, t);
    };
    Yc.prototype = {
        constructor: Yc,
        type: "text",
        brush: function(t, e) {
            var i = this.style;
            this.__dirty && Se(i), i.fill = i.stroke = i.shadowBlur = i.shadowColor = i.shadowOffsetX = i.shadowOffsetY = null;
            var n = i.text;
            null != n && (n += ""), Re(n, i) && (this.setTransform(t), Ie(this, t, n, i, null, e), 
            this.restoreTransform(t));
        },
        getBoundingRect: function() {
            var t = this.style;
            if (this.__dirty && Se(t), !this._rect) {
                var e = t.text;
                null != e ? e += "" : e = "";
                var i = ce(t.text + "", t.font, t.textAlign, t.textVerticalAlign, t.textPadding, t.rich);
                if (i.x += t.x || 0, i.y += t.y || 0, Oe(t.textStroke, t.textStrokeWidth)) {
                    var n = t.textStrokeWidth;
                    i.x -= n / 2, i.y -= n / 2, i.width += n, i.height += n;
                }
                this._rect = i;
            }
            return this._rect;
        }
    }, a(Yc, Ne);
    var Zc = Bi.extend({
        type: "circle",
        shape: {
            cx: 0,
            cy: 0,
            r: 0
        },
        buildPath: function(t, e, i) {
            i && t.moveTo(e.cx + e.r, e.cy), t.arc(e.cx, e.cy, e.r, 0, 2 * Math.PI, !0);
        }
    }), $c = [ [ "shadowBlur", 0 ], [ "shadowColor", "#000" ], [ "shadowOffsetX", 0 ], [ "shadowOffsetY", 0 ] ], Kc = function(l) {
        return Ll.browser.ie && 11 <= Ll.browser.version ? function() {
            var t, e = this.__clipPaths, i = this.style;
            if (e) for (var n = 0; n < e.length; n++) {
                var r = e[n], a = r && r.shape, o = r && r.type;
                if (a && ("sector" === o && a.startAngle === a.endAngle || "rect" === o && (!a.width || !a.height))) {
                    for (var s = 0; s < $c.length; s++) $c[s][2] = i[$c[s][0]], i[$c[s][0]] = $c[s][1];
                    t = !0;
                    break;
                }
            }
            if (l.apply(this, arguments), t) for (s = 0; s < $c.length; s++) i[$c[s][0]] = $c[s][2];
        } : l;
    }, Qc = Bi.extend({
        type: "sector",
        shape: {
            cx: 0,
            cy: 0,
            r0: 0,
            r: 0,
            startAngle: 0,
            endAngle: 2 * Math.PI,
            clockwise: !0
        },
        brush: Kc(Bi.prototype.brush),
        buildPath: function(t, e) {
            var i = e.cx, n = e.cy, r = Math.max(e.r0 || 0, 0), a = Math.max(e.r, 0), o = e.startAngle, s = e.endAngle, l = e.clockwise, h = Math.cos(o), u = Math.sin(o);
            t.moveTo(h * r + i, u * r + n), t.lineTo(h * a + i, u * a + n), t.arc(i, n, a, o, s, !l), 
            t.lineTo(Math.cos(s) * r + i, Math.sin(s) * r + n), 0 !== r && t.arc(i, n, r, s, o, l), 
            t.closePath();
        }
    }), Jc = Bi.extend({
        type: "ring",
        shape: {
            cx: 0,
            cy: 0,
            r: 0,
            r0: 0
        },
        buildPath: function(t, e) {
            var i = e.cx, n = e.cy, r = 2 * Math.PI;
            t.moveTo(i + e.r, n), t.arc(i, n, e.r, 0, r, !1), t.moveTo(i + e.r0, n), t.arc(i, n, e.r0, 0, r, !0);
        }
    }), td = Bi.extend({
        type: "polygon",
        shape: {
            points: null,
            smooth: !1,
            smoothConstraint: null
        },
        buildPath: function(t, e) {
            Vi(t, e, !0);
        }
    }), ed = Bi.extend({
        type: "polyline",
        shape: {
            points: null,
            smooth: !1,
            smoothConstraint: null
        },
        style: {
            stroke: "#000",
            fill: null
        },
        buildPath: function(t, e) {
            Vi(t, e, !1);
        }
    }), id = Bi.extend({
        type: "rect",
        shape: {
            r: 0,
            x: 0,
            y: 0,
            width: 0,
            height: 0
        },
        buildPath: function(t, e) {
            var i = e.x, n = e.y, r = e.width, a = e.height;
            e.r ? be(t, e) : t.rect(i, n, r, a), t.closePath();
        }
    }), nd = Bi.extend({
        type: "line",
        shape: {
            x1: 0,
            y1: 0,
            x2: 0,
            y2: 0,
            percent: 1
        },
        style: {
            stroke: "#000",
            fill: null
        },
        buildPath: function(t, e) {
            var i = e.x1, n = e.y1, r = e.x2, a = e.y2, o = e.percent;
            0 !== o && (t.moveTo(i, n), o < 1 && (r = i * (1 - o) + r * o, a = n * (1 - o) + a * o), 
            t.lineTo(r, a));
        },
        pointAt: function(t) {
            var e = this.shape;
            return [ e.x1 * (1 - t) + e.x2 * t, e.y1 * (1 - t) + e.y2 * t ];
        }
    }), rd = [], ad = Bi.extend({
        type: "bezier-curve",
        shape: {
            x1: 0,
            y1: 0,
            x2: 0,
            y2: 0,
            cpx1: 0,
            cpy1: 0,
            percent: 1
        },
        style: {
            stroke: "#000",
            fill: null
        },
        buildPath: function(t, e) {
            var i = e.x1, n = e.y1, r = e.x2, a = e.y2, o = e.cpx1, s = e.cpy1, l = e.cpx2, h = e.cpy2, u = e.percent;
            0 !== u && (t.moveTo(i, n), null == l || null == h ? (u < 1 && (wi(i, o, r, u, rd), 
            o = rd[1], r = rd[2], wi(n, s, a, u, rd), s = rd[1], a = rd[2]), t.quadraticCurveTo(o, s, r, a)) : (u < 1 && (vi(i, o, l, r, u, rd), 
            o = rd[1], l = rd[2], r = rd[3], vi(n, s, h, a, u, rd), s = rd[1], h = rd[2], a = rd[3]), 
            t.bezierCurveTo(o, s, l, h, r, a)));
        },
        pointAt: function(t) {
            return Hi(this.shape, t, !1);
        },
        tangentAt: function(t) {
            var e = Hi(this.shape, t, !0);
            return U(e, e);
        }
    }), od = Bi.extend({
        type: "arc",
        shape: {
            cx: 0,
            cy: 0,
            r: 0,
            startAngle: 0,
            endAngle: 2 * Math.PI,
            clockwise: !0
        },
        style: {
            stroke: "#000",
            fill: null
        },
        buildPath: function(t, e) {
            var i = e.cx, n = e.cy, r = Math.max(e.r, 0), a = e.startAngle, o = e.endAngle, s = e.clockwise, l = Math.cos(a), h = Math.sin(a);
            t.moveTo(l * r + i, h * r + n), t.arc(i, n, r, a, o, !s);
        }
    }), sd = Bi.extend({
        type: "compound",
        shape: {
            paths: null
        },
        _updatePathDirty: function() {
            for (var t = this.__dirtyPath, e = this.shape.paths, i = 0; i < e.length; i++) t = t || e[i].__dirtyPath;
            this.__dirtyPath = t, this.__dirty = this.__dirty || t;
        },
        beforeBrush: function() {
            this._updatePathDirty();
            for (var t = this.shape.paths || [], e = this.getGlobalScale(), i = 0; i < t.length; i++) t[i].path || t[i].createPathProxy(), 
            t[i].path.setScale(e[0], e[1]);
        },
        buildPath: function(t, e) {
            for (var i = e.paths || [], n = 0; n < i.length; n++) i[n].buildPath(t, i[n].shape, !0);
        },
        afterBrush: function() {
            for (var t = this.shape.paths || [], e = 0; e < t.length; e++) t[e].__dirtyPath = !1;
        },
        getBoundingRect: function() {
            return this._updatePathDirty(), Bi.prototype.getBoundingRect.call(this);
        }
    }), ld = function(t) {
        this.colorStops = t || [];
    };
    ld.prototype = {
        constructor: ld,
        addColorStop: function(t, e) {
            this.colorStops.push({
                offset: t,
                color: e
            });
        }
    };
    var hd = function(t, e, i, n, r, a) {
        this.x = null == t ? 0 : t, this.y = null == e ? 0 : e, this.x2 = null == i ? 1 : i, 
        this.y2 = null == n ? 0 : n, this.type = "linear", this.global = a || !1, ld.call(this, r);
    };
    hd.prototype = {
        constructor: hd
    }, a(hd, ld);
    var ud = function(t, e, i, n, r) {
        this.x = null == t ? .5 : t, this.y = null == e ? .5 : e, this.r = null == i ? .5 : i, 
        this.type = "radial", this.global = r || !1, ld.call(this, n);
    };
    ud.prototype = {
        constructor: ud
    }, a(ud, ld), Wi.prototype.incremental = !0, Wi.prototype.clearDisplaybles = function() {
        this._displayables = [], this._temporaryDisplayables = [], this._cursor = 0, this.dirty(), 
        this.notClear = !1;
    }, Wi.prototype.addDisplayable = function(t, e) {
        e ? this._temporaryDisplayables.push(t) : this._displayables.push(t), this.dirty();
    }, Wi.prototype.addDisplayables = function(t, e) {
        e = e || !1;
        for (var i = 0; i < t.length; i++) this.addDisplayable(t[i], e);
    }, Wi.prototype.eachPendingDisplayable = function(t) {
        for (var e = this._cursor; e < this._displayables.length; e++) t && t(this._displayables[e]);
        for (e = 0; e < this._temporaryDisplayables.length; e++) t && t(this._temporaryDisplayables[e]);
    }, Wi.prototype.update = function() {
        this.updateTransform();
        for (var t = this._cursor; t < this._displayables.length; t++) {
            (e = this._displayables[t]).parent = this, e.update(), e.parent = null;
        }
        for (t = 0; t < this._temporaryDisplayables.length; t++) {
            var e;
            (e = this._temporaryDisplayables[t]).parent = this, e.update(), e.parent = null;
        }
    }, Wi.prototype.brush = function(t) {
        for (var e = this._cursor; e < this._displayables.length; e++) {
            (i = this._displayables[e]).beforeBrush && i.beforeBrush(t), i.brush(t, e === this._cursor ? null : this._displayables[e - 1]), 
            i.afterBrush && i.afterBrush(t);
        }
        this._cursor = e;
        for (e = 0; e < this._temporaryDisplayables.length; e++) {
            var i;
            (i = this._temporaryDisplayables[e]).beforeBrush && i.beforeBrush(t), i.brush(t, 0 === e ? null : this._temporaryDisplayables[e - 1]), 
            i.afterBrush && i.afterBrush(t);
        }
        this._temporaryDisplayables = [], this.notClear = !0;
    };
    var cd = [];
    Wi.prototype.getBoundingRect = function() {
        if (!this._rect) {
            for (var t = new Yt(1 / 0, 1 / 0, -1 / 0, -1 / 0), e = 0; e < this._displayables.length; e++) {
                var i = this._displayables[e], n = i.getBoundingRect().clone();
                i.needLocalTransform() && n.applyTransform(i.getLocalTransform(cd)), t.union(n);
            }
            this._rect = t;
        }
        return this._rect;
    }, Wi.prototype.contain = function(t, e) {
        var i = this.transformCoordToLocal(t, e);
        if (this.getBoundingRect().contain(i[0], i[1])) for (var n = 0; n < this._displayables.length; n++) {
            if (this._displayables[n].contain(t, e)) return !0;
        }
        return !1;
    }, a(Wi, Ne);
    var dd = Math.round, fd = Math.max, pd = Math.min, gd = {}, md = function(t, e) {
        for (var i = [], n = t.length, r = 0; r < n; r++) {
            var a = t[r];
            a.path || a.createPathProxy(), a.__dirtyPath && a.buildPath(a.path, a.shape, !0), 
            i.push(a.path);
        }
        var o = new Bi(e);
        return o.createPathProxy(), o.buildPath = function(t) {
            t.appendPath(i);
            var e = t.getContext();
            e && t.rebuildPath(e);
        }, o;
    }, vd = T(), yd = 0, xd = (Object.freeze || Object)({
        extendShape: Xi,
        extendPath: function(t, e) {
            return Bi.extend(Ni(t, e));
        },
        makePath: qi,
        makeImage: ji,
        mergePath: md,
        resizePath: Yi,
        subPixelOptimizeLine: Zi,
        subPixelOptimizeRect: $i,
        subPixelOptimize: Ki,
        setElementHoverStyle: rn,
        isInEmphasis: an,
        setHoverStyle: un,
        setAsHoverStyleTrigger: cn,
        setLabelStyle: dn,
        setTextStyle: fn,
        setText: function(t, e, i) {
            var n, r = {
                isRectText: !0
            };
            !1 === i ? n = !0 : r.autoColor = i, pn(t, e, r, n);
        },
        getFont: xn,
        updateProps: wn,
        initProps: bn,
        getTransform: function(t, e) {
            for (var i = ht([]); t && t !== e; ) ct(i, t.getLocalTransform(), i), t = t.parent;
            return i;
        },
        applyTransform: Sn,
        transformDirection: function(t, e, i) {
            var n = 0 === e[4] || 0 === e[5] || 0 === e[0] ? 1 : Math.abs(2 * e[4] / e[0]), r = 0 === e[4] || 0 === e[5] || 0 === e[2] ? 1 : Math.abs(2 * e[4] / e[2]), a = [ "left" === t ? -n : "right" === t ? n : 0, "top" === t ? -r : "bottom" === t ? r : 0 ];
            return a = Sn(a, e, i), Math.abs(a[0]) > Math.abs(a[1]) ? 0 < a[0] ? "right" : "left" : 0 < a[1] ? "bottom" : "top";
        },
        groupTransition: Mn,
        clipPointsByRect: function(t, n) {
            return D(t, function(t) {
                var e = t[0];
                e = fd(e, n.x), e = pd(e, n.x + n.width);
                var i = t[1];
                return i = fd(i, n.y), [ e, i = pd(i, n.y + n.height) ];
            });
        },
        clipRectByRect: function(t, e) {
            var i = fd(t.x, e.x), n = pd(t.x + t.width, e.x + e.width), r = fd(t.y, e.y), a = pd(t.y + t.height, e.y + e.height);
            return i <= n && r <= a ? {
                x: i,
                y: r,
                width: n - i,
                height: a - r
            } : void 0;
        },
        createIcon: In,
        Group: Hh,
        Image: Fe,
        Text: Yc,
        Circle: Zc,
        Sector: Qc,
        Ring: Jc,
        Polygon: td,
        Polyline: ed,
        Rect: id,
        Line: nd,
        BezierCurve: ad,
        Arc: od,
        IncrementalDisplayable: Wi,
        CompoundPath: sd,
        LinearGradient: hd,
        RadialGradient: ud,
        BoundingRect: Yt
    }), _d = [ "textStyle", "color" ], wd = {
        getTextColor: function(t) {
            var e = this.ecModel;
            return this.getShallow("color") || (!t && e ? e.get(_d) : null);
        },
        getFont: function() {
            return xn({
                fontStyle: this.getShallow("fontStyle"),
                fontWeight: this.getShallow("fontWeight"),
                fontSize: this.getShallow("fontSize"),
                fontFamily: this.getShallow("fontFamily")
            }, this.ecModel);
        },
        getTextRect: function(t) {
            return ce(t, this.getFont(), this.getShallow("align"), this.getShallow("verticalAlign") || this.getShallow("baseline"), this.getShallow("padding"), this.getShallow("rich"), this.getShallow("truncateText"));
        }
    }, bd = Vu([ [ "fill", "color" ], [ "stroke", "borderColor" ], [ "lineWidth", "borderWidth" ], [ "opacity" ], [ "shadowBlur" ], [ "shadowOffsetX" ], [ "shadowOffsetY" ], [ "shadowColor" ], [ "textPosition" ], [ "textAlign" ] ]), Sd = {
        getItemStyle: function(t, e) {
            var i = bd(this, t, e), n = this.getBorderLineDash();
            return n && (i.lineDash = n), i;
        },
        getBorderLineDash: function() {
            var t = this.get("borderType");
            return "solid" === t || null == t ? null : "dashed" === t ? [ 5, 5 ] : [ 1, 1 ];
        }
    }, Md = r, Id = ei();
    Tn.prototype = {
        constructor: Tn,
        init: null,
        mergeOption: function(t) {
            m(this.option, t, !0);
        },
        get: function(t, e) {
            return null == t ? this.option : Cn(this.option, this.parsePath(t), !e && Dn(this, t));
        },
        getShallow: function(t, e) {
            var i = this.option, n = null == i ? i : i[t], r = !e && Dn(this, t);
            return null == n && r && (n = r.getShallow(t)), n;
        },
        getModel: function(t, e) {
            var i;
            return new Tn(null == t ? this.option : Cn(this.option, t = this.parsePath(t)), e = e || (i = Dn(this, t)) && i.getModel(t), this.ecModel);
        },
        isEmpty: function() {
            return null == this.option;
        },
        restoreData: function() {},
        clone: function() {
            return new this.constructor(b(this.option));
        },
        setReadOnly: function() {},
        parsePath: function(t) {
            return "string" == typeof t && (t = t.split(".")), t;
        },
        customizeGetParent: function(t) {
            Id(this).getParent = t;
        },
        isAnimationEnabled: function() {
            if (!Ll.node) {
                if (null != this.option.animation) return !!this.option.animation;
                if (this.parentModel) return this.parentModel.isAnimationEnabled();
            }
        }
    }, si(Tn), li(Tn), Md(Tn, Wu), Md(Tn, qu), Md(Tn, wd), Md(Tn, Sd);
    var Td, Cd, Dd = 0, Ad = 1e-4, kd = /^(?:(\d{4})(?:[-\/](\d{1,2})(?:[-\/](\d{1,2})(?:[T ](\d{1,2})(?::(\d\d)(?::(\d\d)(?:[.,](\d+))?)?)?(Z|[\+\-]\d\d:?\d\d)?)?)?)?)?$/, Pd = (Object.freeze || Object)({
        linearMap: kn,
        parsePercent: Pn,
        round: Ln,
        asc: function(t) {
            return t.sort(function(t, e) {
                return t - e;
            }), t;
        },
        getPrecision: function(t) {
            if (t = +t, isNaN(t)) return 0;
            for (var e = 1, i = 0; Math.round(t * e) / e !== t; ) e *= 10, i++;
            return i;
        },
        getPrecisionSafe: On,
        getPixelPrecision: En,
        getPercentWithPrecision: zn,
        MAX_SAFE_INTEGER: 9007199254740991,
        remRadian: Bn,
        isRadianAroundZero: Rn,
        parseDate: Nn,
        quantity: Fn,
        nice: Vn,
        quantile: function(t, e) {
            var i = (t.length - 1) * e + 1, n = Math.floor(i), r = +t[n - 1], a = i - n;
            return a ? r + a * (t[n] - r) : r;
        },
        reformIntervals: function(t) {
            t.sort(function(t, e) {
                return function t(e, i, n) {
                    return e.interval[n] < i.interval[n] || e.interval[n] === i.interval[n] && (e.close[n] - i.close[n] == (n ? -1 : 1) || !n && t(e, i, 1));
                }(t, e, 0) ? -1 : 1;
            });
            for (var e = -1 / 0, i = 1, n = 0; n < t.length; ) {
                for (var r = t[n].interval, a = t[n].close, o = 0; o < 2; o++) r[o] <= e && (r[o] = e, 
                a[o] = o ? 1 : 1 - i), e = r[o], i = a[o];
                r[0] === r[1] && a[0] * a[1] != 1 ? t.splice(n, 1) : n++;
            }
            return t;
        },
        isNumeric: function(t) {
            return 0 <= t - parseFloat(t);
        }
    }), Ld = h, Od = /([&<>"'])/g, Ed = {
        "&": "&amp;",
        "<": "&lt;",
        ">": "&gt;",
        '"': "&quot;",
        "'": "&#39;"
    }, zd = [ "a", "b", "c", "d", "e", "f", "g" ], Bd = function(t, e) {
        return "{" + t + (null == e ? "" : e) + "}";
    }, Rd = pe, Nd = ce, Fd = (Object.freeze || Object)({
        addCommas: Hn,
        toCamelCase: Wn,
        normalizeCssArray: Ld,
        encodeHTML: Xn,
        formatTpl: qn,
        formatTplSimple: function(i, t, n) {
            return R(t, function(t, e) {
                i = i.replace("{" + e + "}", n ? Xn(t) : t);
            }), i;
        },
        getTooltipMarker: jn,
        formatTime: Yn,
        capitalFirst: function(t) {
            return t ? t.charAt(0).toUpperCase() + t.substr(1) : t;
        },
        truncateText: Rd,
        getTextRect: Nd
    }), Gd = R, Vd = [ "left", "right", "top", "bottom", "width", "height" ], Hd = [ [ "width", "left", "right" ], [ "height", "top", "bottom" ] ], Wd = Zn, Xd = (g(Zn, "vertical"), 
    g(Zn, "horizontal"), {
        getBoxLayoutParams: function() {
            return {
                left: this.get("left"),
                top: this.get("top"),
                right: this.get("right"),
                bottom: this.get("bottom"),
                width: this.get("width"),
                height: this.get("height")
            };
        }
    }), qd = ei(), jd = Tn.extend({
        type: "component",
        id: "",
        name: "",
        mainType: "",
        subType: "",
        componentIndex: 0,
        defaultOption: null,
        ecModel: null,
        dependentModels: [],
        uid: null,
        layoutMode: null,
        $constructor: function(t, e, i, n) {
            Tn.call(this, t, e, i, n), this.uid = An("ec_cpt_model");
        },
        init: function(t, e, i) {
            this.mergeDefaultAndTheme(t, i);
        },
        mergeDefaultAndTheme: function(t, e) {
            var i = this.layoutMode, n = i ? Qn(t) : {};
            m(t, e.getTheme().get(this.mainType)), m(t, this.getDefaultOption()), i && Kn(t, n, i);
        },
        mergeOption: function(t) {
            m(this.option, t, !0);
            var e = this.layoutMode;
            e && Kn(this.option, t, e);
        },
        optionUpdated: function() {},
        getDefaultOption: function() {
            var t = qd(this);
            if (!t.defaultOption) {
                for (var e = [], i = this.constructor; i; ) {
                    var n = i.prototype.defaultOption;
                    n && e.push(n), i = i.superClass;
                }
                for (var r = {}, a = e.length - 1; 0 <= a; a--) r = m(r, e[a], !0);
                t.defaultOption = r;
            }
            return t.defaultOption;
        },
        getReferringComponents: function(t) {
            return this.ecModel.queryComponents({
                mainType: t,
                index: this.get(t + "Index", !0),
                id: this.get(t + "Id", !0)
            });
        }
    });
    ci(jd, {
        registerWhenExtend: !0
    }), Cd = {}, (Td = jd).registerSubTypeDefaulter = function(t, e) {
        t = oi(t), Cd[t.main] = e;
    }, Td.determineSubType = function(t, e) {
        var i = e.type;
        if (!i) {
            var n = oi(t).main;
            Td.hasSubTypes(t) && Cd[n] && (i = Cd[n](e));
        }
        return i;
    }, function(t, h) {
        function f(o) {
            var s = {}, l = [];
            return R(o, function(i) {
                var e, n, r = u(s, i), t = r.originalDeps = h(i), a = (e = o, n = [], R(t, function(t) {
                    0 <= d(e, t) && n.push(t);
                }), n);
                r.entryCount = a.length, 0 === r.entryCount && l.push(i), R(a, function(t) {
                    d(r.predecessor, t) < 0 && r.predecessor.push(t);
                    var e = u(s, t);
                    d(e.successor, t) < 0 && e.successor.push(i);
                });
            }), {
                graph: s,
                noEntryList: l
            };
        }
        function u(t, e) {
            return t[e] || (t[e] = {
                predecessor: [],
                successor: []
            }), t[e];
        }
        t.topologicalTravel = function(t, e, i, n) {
            function r(t) {
                s[t].entryCount--, 0 === s[t].entryCount && l.push(t);
            }
            function a(t) {
                h[t] = !0, r(t);
            }
            if (t.length) {
                var o = f(e), s = o.graph, l = o.noEntryList, h = {};
                for (R(t, function(t) {
                    h[t] = !0;
                }); l.length; ) {
                    var u = l.pop(), c = s[u], d = !!h[u];
                    d && (i.call(n, u, c.originalDeps.slice()), delete h[u]), R(c.successor, d ? a : r);
                }
                R(h, function() {
                    throw new Error("Circle dependency may exists");
                });
            }
        };
    }(jd, function(t) {
        var e = [];
        return R(jd.getClassesByMainType(t), function(t) {
            e = e.concat(t.prototype.dependencies || []);
        }), e = D(e, function(t) {
            return oi(t).main;
        }), "dataset" !== t && d(e, "dataset") <= 0 && e.unshift("dataset"), e;
    }), r(jd, Xd);
    var Ud = "";
    "undefined" != typeof navigator && (Ud = navigator.platform || "");
    var Yd = {
        color: [ "#c23531", "#2f4554", "#61a0a8", "#d48265", "#91c7ae", "#749f83", "#ca8622", "#bda29a", "#6e7074", "#546570", "#c4ccd3" ],
        gradientColor: [ "#f6efa6", "#d88273", "#bf444c" ],
        textStyle: {
            fontFamily: Ud.match(/^Win/) ? "Microsoft YaHei" : "sans-serif",
            fontSize: 12,
            fontStyle: "normal",
            fontWeight: "normal"
        },
        blendMode: null,
        animation: "auto",
        animationDuration: 1e3,
        animationDurationUpdate: 300,
        animationEasing: "exponentialOut",
        animationEasingUpdate: "cubicOut",
        animationThreshold: 2e3,
        progressiveThreshold: 3e3,
        progressive: 400,
        hoverLayerThreshold: 3e3,
        useUTC: !1
    }, Zd = ei(), $d = {
        clearColorPalette: function() {
            Zd(this).colorIdx = 0, Zd(this).colorNameMap = {};
        },
        getColorFromPalette: function(t, e, i) {
            var n = Zd(e = e || this), r = n.colorIdx || 0, a = n.colorNameMap = n.colorNameMap || {};
            if (a.hasOwnProperty(t)) return a[t];
            var o = Ye(this.get("color", !0)), s = this.get("colorLayer", !0), l = null != i && s ? function(t, e) {
                for (var i = t.length, n = 0; n < i; n++) if (t[n].length > e) return t[n];
                return t[i - 1];
            }(s, i) : o;
            if ((l = l || o) && l.length) {
                var h = l[r];
                return t && (a[t] = h), n.colorIdx = (r + 1) % l.length, h;
            }
        }
    }, Kd = {
        cartesian2d: function(t, e, i, n) {
            var r = t.getReferringComponents("xAxis")[0], a = t.getReferringComponents("yAxis")[0];
            e.coordSysDims = [ "x", "y" ], i.set("x", r), i.set("y", a), tr(r) && (n.set("x", r), 
            e.firstCategoryDimIndex = 0), tr(a) && (n.set("y", a), e.firstCategoryDimIndex = 1);
        },
        singleAxis: function(t, e, i, n) {
            var r = t.getReferringComponents("singleAxis")[0];
            e.coordSysDims = [ "single" ], i.set("single", r), tr(r) && (n.set("single", r), 
            e.firstCategoryDimIndex = 0);
        },
        polar: function(t, e, i, n) {
            var r = t.getReferringComponents("polar")[0], a = r.findAxisModel("radiusAxis"), o = r.findAxisModel("angleAxis");
            e.coordSysDims = [ "radius", "angle" ], i.set("radius", a), i.set("angle", o), tr(a) && (n.set("radius", a), 
            e.firstCategoryDimIndex = 0), tr(o) && (n.set("angle", o), e.firstCategoryDimIndex = 1);
        },
        geo: function(t, e) {
            e.coordSysDims = [ "lng", "lat" ];
        },
        parallel: function(t, r, a, o) {
            var s = t.ecModel, e = s.getComponent("parallel", t.get("parallelIndex")), l = r.coordSysDims = e.dimensions.slice();
            R(e.parallelAxisIndex, function(t, e) {
                var i = s.getComponent("parallelAxis", t), n = l[e];
                a.set(n, i), tr(i) && null == r.firstCategoryDimIndex && (o.set(n, i), r.firstCategoryDimIndex = e);
            });
        }
    }, Qd = "original", Jd = "arrayRows", tf = "objectRows", ef = "keyedColumns", nf = "unknown", rf = "typedArray", af = "column", of = "row";
    er.seriesDataToSource = function(t) {
        return new er({
            data: t,
            sourceFormat: p(t) ? rf : Qd,
            fromDataset: !1
        });
    }, li(er);
    var sf = ei(), lf = "\0_ec_inner", hf = Tn.extend({
        init: function(t, e, i, n) {
            i = i || {}, this.option = null, this._theme = new Tn(i), this._optionManager = n;
        },
        setOption: function(t, e) {
            c(!(lf in t), "please use chart.getOption()"), this._optionManager.setOption(t, e), 
            this.resetOption(null);
        },
        resetOption: function(t) {
            var e = !1, i = this._optionManager;
            if (!t || "recreate" === t) {
                var n = i.mountOption("recreate" === t);
                this.option && "recreate" !== t ? (this.restoreData(), this.mergeOption(n)) : or.call(this, n), 
                e = !0;
            }
            if (("timeline" === t || "media" === t) && this.restoreData(), !t || "recreate" === t || "timeline" === t) {
                var r = i.getTimelineOption(this);
                r && (this.mergeOption(r), e = !0);
            }
            if (!t || "recreate" === t || "media" === t) {
                var a = i.getMediaOption(this, this._api);
                a.length && R(a, function(t) {
                    this.mergeOption(t, e = !0);
                }, this);
            }
            return e;
        },
        mergeOption: function(r) {
            var h = this.option, u = this._componentsMap, i = [];
            sf(this).datasetMap = T(), R(r, function(t, e) {
                null != t && (jd.hasClass(e) ? e && i.push(e) : h[e] = null == h[e] ? b(t) : m(h[e], t, !0));
            }), jd.topologicalTravel(i, jd.getAllClassMainTypes(), function(o, t) {
                var e, s, i = Ye(r[o]), n = Ke(u.get(o), i);
                e = n, s = T(), Lu(e, function(t) {
                    var e = t.exist;
                    e && s.set(e.id, t);
                }), Lu(e, function(t) {
                    var e = t.option;
                    c(!e || null == e.id || !s.get(e.id) || s.get(e.id) === t, "id duplicates: " + (e && e.id)), 
                    e && null != e.id && s.set(e.id, t), !t.keyInfo && (t.keyInfo = {});
                }), Lu(e, function(t, e) {
                    var i = t.exist, n = t.option, r = t.keyInfo;
                    if (Ou(n)) {
                        if (r.name = null != n.name ? n.name + "" : i ? i.name : zu + e, i) r.id = i.id; else if (null != n.id) r.id = n.id + ""; else for (var a = 0; r.id = "\0" + r.name + "\0" + a++, 
                        s.get(r.id); ) ;
                        s.set(r.id, t);
                    }
                }), R(n, function(t) {
                    var e, i, n, r = t.option;
                    L(r) && (t.keyInfo.mainType = o, t.keyInfo.subType = (e = o, i = r, n = t.exist, 
                    i.type ? i.type : n ? n.subType : jd.determineSubType(e, i)));
                });
                var l = function(e, t) {
                    P(t) || (t = t ? [ t ] : []);
                    var i = {};
                    return R(t, function(t) {
                        i[t] = (e.get(t) || []).slice();
                    }), i;
                }(u, t);
                h[o] = [], u.set(o, []), R(n, function(t, e) {
                    var i = t.exist, n = t.option;
                    if (c(L(n) || i, "Empty component definition"), n) {
                        var r = jd.getClass(o, t.keyInfo.subType, !0);
                        if (i && i instanceof r) i.name = t.keyInfo.name, i.mergeOption(n, this), i.optionUpdated(n, !1); else {
                            var a = A({
                                dependentModels: l,
                                componentIndex: e
                            }, t.keyInfo);
                            A(i = new r(n, this, this, a), a), i.init(n, this, this, a), i.optionUpdated(null, !0);
                        }
                    } else i.mergeOption({}, this), i.optionUpdated({}, !1);
                    u.get(o)[e] = i, h[o][e] = i.option;
                }, this), "series" === o && sr(this, u.get("series"));
            }, this), this._seriesIndicesMap = T(this._seriesIndices = this._seriesIndices || []);
        },
        getOption: function() {
            var n = b(this.option);
            return R(n, function(t, e) {
                if (jd.hasClass(e)) {
                    for (var i = (t = Ye(t)).length - 1; 0 <= i; i--) Je(t[i]) && t.splice(i, 1);
                    n[e] = t;
                }
            }), delete n[lf], n;
        },
        getTheme: function() {
            return this._theme;
        },
        getComponent: function(t, e) {
            var i = this._componentsMap.get(t);
            return i ? i[e || 0] : void 0;
        },
        queryComponents: function(t) {
            var e = t.mainType;
            if (!e) return [];
            var i, n = t.index, r = t.id, a = t.name, o = this._componentsMap.get(e);
            if (!o || !o.length) return [];
            if (null != n) P(n) || (n = [ n ]), i = u(D(n, function(t) {
                return o[t];
            }), function(t) {
                return !!t;
            }); else if (null != r) {
                var s = P(r);
                i = u(o, function(t) {
                    return s && 0 <= d(r, t.id) || !s && t.id === r;
                });
            } else if (null != a) {
                var l = P(a);
                i = u(o, function(t) {
                    return l && 0 <= d(a, t.name) || !l && t.name === a;
                });
            } else i = o.slice();
            return lr(i, t);
        },
        findComponents: function(t) {
            var e, i, n, r, a, o = t.query, s = t.mainType, l = (i = s + "Index", n = s + "Id", 
            r = s + "Name", !(e = o) || null == e[i] && null == e[n] && null == e[r] ? null : {
                mainType: s,
                index: e[i],
                id: e[n],
                name: e[r]
            }), h = l ? this.queryComponents(l) : this._componentsMap.get(s);
            return a = lr(h, t), t.filter ? u(a, t.filter) : a;
        },
        eachComponent: function(t, n, r) {
            var e = this._componentsMap;
            if ("function" == typeof t) r = n, n = t, e.each(function(t, i) {
                R(t, function(t, e) {
                    n.call(r, i, t, e);
                });
            }); else if (M(t)) R(e.get(t), n, r); else if (L(t)) {
                R(this.findComponents(t), n, r);
            }
        },
        getSeriesByName: function(e) {
            return u(this._componentsMap.get("series"), function(t) {
                return t.name === e;
            });
        },
        getSeriesByIndex: function(t) {
            return this._componentsMap.get("series")[t];
        },
        getSeriesByType: function(e) {
            return u(this._componentsMap.get("series"), function(t) {
                return t.subType === e;
            });
        },
        getSeries: function() {
            return this._componentsMap.get("series").slice();
        },
        getSeriesCount: function() {
            return this._componentsMap.get("series").length;
        },
        eachSeries: function(i, n) {
            R(this._seriesIndices, function(t) {
                var e = this._componentsMap.get("series")[t];
                i.call(n, e, t);
            }, this);
        },
        eachRawSeries: function(t, e) {
            R(this._componentsMap.get("series"), t, e);
        },
        eachSeriesByType: function(i, n, r) {
            R(this._seriesIndices, function(t) {
                var e = this._componentsMap.get("series")[t];
                e.subType === i && n.call(r, e, t);
            }, this);
        },
        eachRawSeriesByType: function(t, e, i) {
            return R(this.getSeriesByType(t), e, i);
        },
        isSeriesFiltered: function(t) {
            return null == this._seriesIndicesMap.get(t.componentIndex);
        },
        getCurrentSeriesIndices: function() {
            return (this._seriesIndices || []).slice();
        },
        filterSeries: function(t, e) {
            sr(this, u(this._componentsMap.get("series"), t, e));
        },
        restoreData: function(i) {
            var t = this._componentsMap;
            sr(this, t.get("series"));
            var n = [];
            t.each(function(t, e) {
                n.push(e);
            }), jd.topologicalTravel(n, jd.getAllClassMainTypes(), function(e) {
                R(t.get(e), function(t) {
                    ("series" !== e || !function(t, e) {
                        if (e) {
                            var i = e.seiresIndex, n = e.seriesId, r = e.seriesName;
                            return null != i && t.componentIndex !== i || null != n && t.id !== n || null != r && t.name !== r;
                        }
                    }(t, i)) && t.restoreData();
                });
            });
        }
    });
    r(hf, $d);
    var uf = [ "getDom", "getZr", "getWidth", "getHeight", "getDevicePixelRatio", "dispatchAction", "isDisposed", "on", "off", "getDataURL", "getConnectedDataURL", "getModel", "getOption", "getViewOfComponentModel", "getViewOfSeriesModel" ], cf = {};
    ur.prototype = {
        constructor: ur,
        create: function(i, n) {
            var r = [];
            R(cf, function(t) {
                var e = t.create(i, n);
                r = r.concat(e || []);
            }), this._coordinateSystems = r;
        },
        update: function(e, i) {
            R(this._coordinateSystems, function(t) {
                t.update && t.update(e, i);
            });
        },
        getCoordinateSystems: function() {
            return this._coordinateSystems.slice();
        }
    }, ur.register = function(t, e) {
        cf[t] = e;
    }, ur.get = function(t) {
        return cf[t];
    };
    var df = R, ff = b, pf = D, gf = m, mf = /^(min|max)?(.+)$/;
    cr.prototype = {
        constructor: cr,
        setOption: function(t, e) {
            t && R(Ye(t.series), function(t) {
                t && t.data && p(t.data) && x(t.data);
            }), t = ff(t, !0);
            var r, i, n = this._optionBackup, a = function(t, i, n) {
                var e, r, a = [], o = [], s = t.timeline;
                if (t.baseOption && (r = t.baseOption), (s || t.options) && (r = r || {}, a = (t.options || []).slice()), 
                t.media) {
                    r = r || {};
                    var l = t.media;
                    df(l, function(t) {
                        t && t.option && (t.query ? o.push(t) : e || (e = t));
                    });
                }
                return r || (r = t), r.timeline || (r.timeline = s), df([ r ].concat(a).concat(D(o, function(t) {
                    return t.option;
                })), function(e) {
                    df(i, function(t) {
                        t(e, n);
                    });
                }), {
                    baseOption: r,
                    timelineOptions: a,
                    mediaDefault: e,
                    mediaList: o
                };
            }.call(this, t, e, !n);
            this._newBaseOption = a.baseOption, n ? (r = n.baseOption, i = a.baseOption, df(i = i || {}, function(t, e) {
                if (null != t) {
                    var i = r[e];
                    if (jd.hasClass(e)) {
                        t = Ye(t);
                        var n = Ke(i = Ye(i), t);
                        r[e] = pf(n, function(t) {
                            return t.option && t.exist ? gf(t.exist, t.option, !0) : t.exist || t.option;
                        });
                    } else r[e] = gf(i, t, !0);
                }
            }), a.timelineOptions.length && (n.timelineOptions = a.timelineOptions), a.mediaList.length && (n.mediaList = a.mediaList), 
            a.mediaDefault && (n.mediaDefault = a.mediaDefault)) : this._optionBackup = a;
        },
        mountOption: function(t) {
            var e = this._optionBackup;
            return this._timelineOptions = pf(e.timelineOptions, ff), this._mediaList = pf(e.mediaList, ff), 
            this._mediaDefault = ff(e.mediaDefault), this._currentMediaIndices = [], ff(t ? e.baseOption : this._newBaseOption);
        },
        getTimelineOption: function(t) {
            var e, i = this._timelineOptions;
            if (i.length) {
                var n = t.getComponent("timeline");
                n && (e = ff(i[n.getCurrentIndex()], !0));
            }
            return e;
        },
        getMediaOption: function() {
            var t, e, i = this._api.getWidth(), n = this._api.getHeight(), r = this._mediaList, a = this._mediaDefault, o = [], s = [];
            if (!r.length && !a) return s;
            for (var l = 0, h = r.length; l < h; l++) dr(r[l].query, i, n) && o.push(l);
            return !o.length && a && (o = [ -1 ]), o.length && (t = o, e = this._currentMediaIndices, 
            !(t.join(",") === e.join(","))) && (s = pf(o, function(t) {
                return ff(-1 === t ? a.option : r[t].option);
            })), this._currentMediaIndices = o, s;
        }
    };
    var vf = R, yf = L, xf = [ "areaStyle", "lineStyle", "nodeStyle", "linkStyle", "chordStyle", "label", "labelLine" ], _f = function(e, t) {
        vf(yr(e.series), function(t) {
            yf(t) && function(t) {
                if (yf(t)) {
                    fr(t), gr(t), mr(t, "label"), mr(t, "upperLabel"), mr(t, "edgeLabel"), t.emphasis && (mr(t.emphasis, "label"), 
                    mr(t.emphasis, "upperLabel"), mr(t.emphasis, "edgeLabel")), (i = t.markPoint) && (fr(i), 
                    vr(i)), (n = t.markLine) && (fr(n), vr(n));
                    var e = t.markArea;
                    e && vr(e);
                    var i, n, r = t.data;
                    if ("graph" === t.type) {
                        r = r || t.nodes;
                        var a = t.links || t.edges;
                        if (a && !p(a)) for (var o = 0; o < a.length; o++) vr(a[o]);
                        R(t.categories, function(t) {
                            gr(t);
                        });
                    }
                    if (r && !p(r)) for (o = 0; o < r.length; o++) vr(r[o]);
                    if ((i = t.markPoint) && i.data) {
                        var s = i.data;
                        for (o = 0; o < s.length; o++) vr(s[o]);
                    }
                    if ((n = t.markLine) && n.data) {
                        var l = n.data;
                        for (o = 0; o < l.length; o++) P(l[o]) ? (vr(l[o][0]), vr(l[o][1])) : vr(l[o]);
                    }
                    "gauge" === t.type ? (mr(t, "axisLabel"), mr(t, "title"), mr(t, "detail")) : "treemap" === t.type ? (pr(t.breadcrumb, "itemStyle"), 
                    R(t.levels, function(t) {
                        gr(t);
                    })) : "tree" === t.type && gr(t.leaves);
                }
            }(t);
        });
        var i = [ "xAxis", "yAxis", "radiusAxis", "angleAxis", "singleAxis", "parallelAxis", "radar" ];
        t && i.push("valueAxis", "categoryAxis", "logAxis", "timeAxis"), vf(i, function(t) {
            vf(yr(e[t]), function(t) {
                t && (mr(t, "axisLabel"), mr(t.axisPointer, "label"));
            });
        }), vf(yr(e.parallel), function(t) {
            var e = t && t.parallelAxisDefault;
            mr(e, "axisLabel"), mr(e && e.axisPointer, "label");
        }), vf(yr(e.calendar), function(t) {
            pr(t, "itemStyle"), mr(t, "dayLabel"), mr(t, "monthLabel"), mr(t, "yearLabel");
        }), vf(yr(e.radar), function(t) {
            mr(t, "name");
        }), vf(yr(e.geo), function(t) {
            yf(t) && (vr(t), vf(yr(t.regions), function(t) {
                vr(t);
            }));
        }), vf(yr(e.timeline), function(t) {
            vr(t), pr(t, "label"), pr(t, "itemStyle"), pr(t, "controlStyle", !0);
            var e = t.data;
            P(e) && R(e, function(t) {
                L(t) && (pr(t, "label"), pr(t, "itemStyle"));
            });
        }), vf(yr(e.toolbox), function(t) {
            pr(t, "iconStyle"), vf(t.feature, function(t) {
                pr(t, "iconStyle");
            });
        }), mr(xr(e.axisPointer), "label"), mr(xr(e.tooltip).axisPointer, "label");
    }, wf = [ [ "x", "left" ], [ "y", "top" ], [ "x2", "right" ], [ "y2", "bottom" ] ], bf = [ "grid", "geo", "parallel", "legend", "toolbox", "title", "visualMap", "dataZoom", "timeline" ], Sf = function(i, t) {
        _f(i, t), i.series = Ye(i.series), R(i.series, function(t) {
            if (L(t)) {
                var e = t.type;
                if (("pie" === e || "gauge" === e) && null != t.clockWise && (t.clockwise = t.clockWise), 
                "gauge" === e) {
                    var i = function(t, e) {
                        e = e.split(",");
                        for (var i = t, n = 0; n < e.length && null != (i = i && i[e[n]]); n++) ;
                        return i;
                    }(t, "pointer.color");
                    null != i && function(t, e, i, n) {
                        e = e.split(",");
                        for (var r, a = t, o = 0; o < e.length - 1; o++) null == a[r = e[o]] && (a[r] = {}), 
                        a = a[r];
                        (n || null == a[e[o]]) && (a[e[o]] = i);
                    }(t, "itemStyle.normal.color", i);
                }
                _r(t);
            }
        }), i.dataRange && (i.visualMap = i.dataRange), R(bf, function(t) {
            var e = i[t];
            e && (P(e) || (e = [ e ]), R(e, function(t) {
                _r(t);
            }));
        });
    }, Mf = br.prototype;
    Mf.pure = !1;
    var If = {
        arrayRows_column: {
            pure: Mf.persistent = !0,
            count: function() {
                return Math.max(0, this._data.length - this._source.startIndex);
            },
            getItem: function(t) {
                return this._data[t + this._source.startIndex];
            },
            appendData: Ir
        },
        arrayRows_row: {
            pure: !0,
            count: function() {
                var t = this._data[0];
                return t ? Math.max(0, t.length - this._source.startIndex) : 0;
            },
            getItem: function(t) {
                t += this._source.startIndex;
                for (var e = [], i = this._data, n = 0; n < i.length; n++) {
                    var r = i[n];
                    e.push(r ? r[t] : null);
                }
                return e;
            },
            appendData: function() {
                throw new Error('Do not support appendData when set seriesLayoutBy: "row".');
            }
        },
        objectRows: {
            pure: !0,
            count: Sr,
            getItem: Mr,
            appendData: Ir
        },
        keyedColumns: {
            pure: !0,
            count: function() {
                var t = this._source.dimensionsDefine[0].name, e = this._data[t];
                return e ? e.length : 0;
            },
            getItem: function(t) {
                for (var e = [], i = this._source.dimensionsDefine, n = 0; n < i.length; n++) {
                    var r = this._data[i[n].name];
                    e.push(r ? r[t] : null);
                }
                return e;
            },
            appendData: function(t) {
                var r = this._data;
                R(t, function(t, e) {
                    for (var i = r[e] || (r[e] = []), n = 0; n < (t || []).length; n++) i.push(t[n]);
                });
            }
        },
        original: {
            count: Sr,
            getItem: Mr,
            appendData: Ir
        },
        typedArray: {
            persistent: !(Mf.getSource = function() {
                return this._source;
            }),
            pure: !0,
            count: function() {
                return this._data ? this._data.length / this._dimSize : 0;
            },
            getItem: function(t, e) {
                t -= this._offset, e = e || [];
                for (var i = this._dimSize * t, n = 0; n < this._dimSize; n++) e[n] = this._data[i + n];
                return e;
            },
            appendData: function(t) {
                this._data = t;
            },
            clean: function() {
                this._offset += this.count(), this._data = null;
            }
        }
    }, Tf = {
        arrayRows: Tr,
        objectRows: function(t, e, i, n) {
            return null != i ? t[n] : t;
        },
        keyedColumns: Tr,
        original: function(t, e, i) {
            var n = $e(t);
            return null != i && n instanceof Array ? n[i] : n;
        },
        typedArray: Tr
    }, Cf = {
        arrayRows: Cr,
        objectRows: function(t, e) {
            return Dr(t[e], this._dimensionInfos[e]);
        },
        keyedColumns: Cr,
        original: function(t, e, i, n) {
            var r, a = t && (null == t.value ? t : t.value);
            return !this._rawData.pure && (Ou(r = t) && !(r instanceof Array)) && (this.hasItemOption = !0), 
            Dr(a instanceof Array ? a[n] : a, this._dimensionInfos[e]);
        },
        typedArray: function(t, e, i, n) {
            return t[n];
        }
    }, Df = /\{@(.+?)\}/g, Af = {
        getDataParams: function(t, e) {
            var i = this.getData(e), n = this.getRawValue(t, e), r = i.getRawIndex(t), a = i.getName(t), o = i.getRawDataItem(t), s = i.getItemVisual(t, "color"), l = this.ecModel.getComponent("tooltip"), h = ai(l && l.get("renderMode")), u = this.mainType, c = "series" === u;
            return {
                componentType: u,
                componentSubType: this.subType,
                componentIndex: this.componentIndex,
                seriesType: c ? this.subType : null,
                seriesIndex: this.seriesIndex,
                seriesId: c ? this.id : null,
                seriesName: c ? this.name : null,
                name: a,
                dataIndex: r,
                data: o,
                dataType: e,
                value: n,
                color: s,
                marker: jn({
                    color: s,
                    renderMode: h
                }),
                $vars: [ "seriesName", "name", "value" ]
            };
        },
        getFormattedLabel: function(n, t, e, i, r) {
            t = t || "normal";
            var a = this.getData(e), o = a.getItemModel(n), s = this.getDataParams(n, e);
            null != i && s.value instanceof Array && (s.value = s.value[i]);
            var l = o.get("normal" === t ? [ r || "label", "formatter" ] : [ t, r || "label", "formatter" ]);
            return "function" == typeof l ? (s.status = t, l(s)) : "string" == typeof l ? qn(l, s).replace(Df, function(t, e) {
                var i = e.length;
                return "[" === e.charAt(0) && "]" === e.charAt(i - 1) && (e = +e.slice(1, i - 1)), 
                Ar(a, n, e);
            }) : void 0;
        },
        getRawValue: function(t, e) {
            return Ar(this.getData(e), t);
        },
        formatTooltip: function() {}
    }, kf = Lr.prototype;
    kf.perform = function(t) {
        function e(t) {
            return !(1 <= t) && (t = 1), t;
        }
        var i, n = this._upstream, r = t && t.skip;
        if (this._dirty && n) {
            var a = this.context;
            a.data = a.outputData = n.context.outputData;
        }
        this.__pipeline && (this.__pipeline.currentTask = this), this._plan && !r && (i = this._plan(this.context));
        var o, s = e(this._modBy), l = this._modDataCount || 0, h = e(t && t.modBy), u = t && t.modDataCount || 0;
        (s !== h || l !== u) && (i = "reset"), (this._dirty || "reset" === i) && (this._dirty = !1, 
        o = function(t, e) {
            var i, n;
            t._dueIndex = t._outputDueEnd = t._dueEnd = 0, t._settedOutputEnd = null, !e && t._reset && ((i = t._reset(t.context)) && i.progress && (n = i.forceFirstProgress, 
            i = i.progress), P(i) && !i.length && (i = null)), t._progress = i, t._modBy = t._modDataCount = null;
            var r = t._downstream;
            return r && r.dirty(), n;
        }(this, r)), this._modBy = h, this._modDataCount = u;
        var c = t && t.step;
        if (this._dueEnd = n ? n._outputDueEnd : this._count ? this._count(this.context) : 1 / 0, 
        this._progress) {
            var d = this._dueIndex, f = Math.min(null != c ? this._dueIndex + c : 1 / 0, this._dueEnd);
            if (!r && (o || d < f)) {
                var p = this._progress;
                if (P(p)) for (var g = 0; g < p.length; g++) Or(this, p[g], d, f, h, u); else Or(this, p, d, f, h, u);
            }
            this._dueIndex = f;
            var m = null != this._settedOutputEnd ? this._settedOutputEnd : f;
            this._outputDueEnd = m;
        } else this._dueIndex = this._outputDueEnd = null != this._settedOutputEnd ? this._settedOutputEnd : this._dueEnd;
        return this.unfinished();
    };
    var Pf = function() {
        function r() {
            return s < o ? s++ : null;
        }
        function a() {
            var t = s % u * l + Math.ceil(s / u), e = o <= s ? null : t < h ? t : s;
            return s++, e;
        }
        var o, s, l, h, u, c = {
            reset: function(t, e, i, n) {
                s = t, o = e, l = i, h = n, u = Math.ceil(h / l), c.next = 1 < l && 0 < h ? a : r;
            }
        };
        return c;
    }();
    kf.dirty = function() {
        this._dirty = !0, this._onDirty && this._onDirty(this.context);
    }, kf.unfinished = function() {
        return this._progress && this._dueIndex < this._dueEnd;
    }, kf.pipe = function(t) {
        (this._downstream !== t || this._dirty) && ((this._downstream = t)._upstream = this, 
        t.dirty());
    }, kf.dispose = function() {
        this._disposed || (this._upstream && (this._upstream._downstream = null), this._downstream && (this._downstream._upstream = null), 
        this._dirty = !1, this._disposed = !0);
    }, kf.getUpstream = function() {
        return this._upstream;
    }, kf.getDownstream = function() {
        return this._downstream;
    }, kf.setOutputEnd = function(t) {
        this._outputDueEnd = this._settedOutputEnd = t;
    };
    var Lf = ei(), Of = jd.extend({
        type: "series.__base__",
        seriesIndex: 0,
        coordinateSystem: null,
        defaultOption: null,
        legendDataProvider: null,
        visualColorAccessPath: "itemStyle.color",
        layoutMode: null,
        init: function(t, e, i) {
            this.seriesIndex = this.componentIndex, this.dataTask = Pr({
                count: zr,
                reset: Br
            }), this.dataTask.context = {
                model: this
            }, this.mergeDefaultAndTheme(t, i), ir(this);
            var n = this.getInitialData(t, i);
            Nr(n, this), this.dataTask.context.data = n, Lf(this).dataBeforeProcessed = n, Er(this);
        },
        mergeDefaultAndTheme: function(t, e) {
            var i = this.layoutMode, n = i ? Qn(t) : {}, r = this.subType;
            jd.hasClass(r) && (r += "Series"), m(t, e.getTheme().get(this.subType)), m(t, this.getDefaultOption()), 
            Ze(t, "label", [ "show" ]), this.fillDataTextStyle(t.data), i && Kn(t, n, i);
        },
        mergeOption: function(t, e) {
            t = m(this.option, t, !0), this.fillDataTextStyle(t.data);
            var i = this.layoutMode;
            i && Kn(this.option, t, i), ir(this);
            var n = this.getInitialData(t, e);
            Nr(n, this), this.dataTask.dirty(), this.dataTask.context.data = n, Lf(this).dataBeforeProcessed = n, 
            Er(this);
        },
        fillDataTextStyle: function(t) {
            if (t && !p(t)) for (var e = [ "show" ], i = 0; i < t.length; i++) t[i] && t[i].label && Ze(t[i], "label", e);
        },
        getInitialData: function() {},
        appendData: function(t) {
            this.getRawData().appendData(t.data);
        },
        getData: function(t) {
            var e = Gr(this);
            if (e) {
                var i = e.context.data;
                return null == t ? i : i.getLinkedData(t);
            }
            return Lf(this).data;
        },
        setData: function(t) {
            var e = Gr(this);
            if (e) {
                var i = e.context;
                i.data !== t && e.modifyOutputEnd && e.setOutputEnd(t.count()), i.outputData = t, 
                e !== this.dataTask && (i.data = t);
            }
            Lf(this).data = t;
        },
        getSource: function() {
            return sf(this).source;
        },
        getRawData: function() {
            return Lf(this).dataBeforeProcessed;
        },
        getBaseAxis: function() {
            var t = this.coordinateSystem;
            return t && t.getBaseAxis && t.getBaseAxis();
        },
        formatTooltip: function(r, u, t, c) {
            var d = this, e = "html" === (c = c || "html") ? "<br/>" : "\n", f = "richText" === c, p = {}, g = 0, m = this.getData(), a = m.mapDimension("defaultedTooltip", !0), i = a.length, n = this.getRawValue(r), o = P(n), v = m.getItemVisual(r, "color");
            L(v) && v.colorStops && (v = (v.colorStops[0] || {}).color), v = v || "transparent";
            var s, l = (1 < i || o && !i ? function(t) {
                function e(t, e) {
                    var i = m.getDimensionInfo(e);
                    if (i && !1 !== i.otherDims.tooltip) {
                        var n = i.type, r = "sub" + d.seriesIndex + "at" + g, a = jn({
                            color: v,
                            type: "subItem",
                            renderMode: c,
                            markerId: r
                        }), o = "string" == typeof a ? a : a.content, s = (l ? o + Xn(i.displayName || "-") + ": " : "") + Xn("ordinal" === n ? t + "" : "time" === n ? u ? "" : Yn("yyyy/MM/dd hh:mm:ss", t) : Hn(t));
                        s && h.push(s), f && (p[r] = v, ++g);
                    }
                }
                var l = S(t, function(t, e, i) {
                    var n = m.getDimensionInfo(i);
                    return t | (n && !1 !== n.tooltip && null != n.displayName);
                }, 0), h = [];
                a.length ? R(a, function(t) {
                    e(Ar(m, r, t), t);
                }) : R(t, e);
                var i = l ? f ? "\n" : "<br/>" : "", n = i + h.join(i || ", ");
                return {
                    renderMode: c,
                    content: n,
                    style: p
                };
            }(n) : (s = i ? Ar(m, r, a[0]) : o ? n[0] : n, {
                renderMode: c,
                content: Xn(Hn(s)),
                style: p
            })).content, h = d.seriesIndex + "at" + g, y = jn({
                color: v,
                type: "item",
                renderMode: c,
                markerId: h
            });
            p[h] = v, ++g;
            var x = m.getName(r), _ = this.name;
            Qe(this) || (_ = ""), _ = _ ? Xn(_) + (u ? ": " : e) : "";
            var w = "string" == typeof y ? y : y.content;
            return {
                html: u ? w + _ + l : _ + w + (x ? Xn(x) + ": " + l : l),
                markers: p
            };
        },
        isAnimationEnabled: function() {
            if (Ll.node) return !1;
            var t = this.getShallow("animation");
            return t && this.getData().count() > this.getShallow("animationThreshold") && (t = !1), 
            t;
        },
        restoreData: function() {
            this.dataTask.dirty();
        },
        getColorFromPalette: function(t, e, i) {
            var n = this.ecModel, r = $d.getColorFromPalette.call(this, t, e, i);
            return r || (r = n.getColorFromPalette(t, e, i)), r;
        },
        coordDimToDataDim: function(t) {
            return this.getRawData().mapDimension(t, !0);
        },
        getProgressive: function() {
            return this.get("progressive");
        },
        getProgressiveThreshold: function() {
            return this.get("progressiveThreshold");
        },
        getAxisTooltipData: null,
        getTooltipPosition: null,
        pipeTask: null,
        preventIncremental: null,
        pipelineContext: null
    });
    r(Of, Af), r(Of, $d);
    var Ef = function() {
        this.group = new Hh(), this.uid = An("viewComponent");
    };
    Ef.prototype = {
        constructor: Ef,
        init: function() {},
        render: function() {},
        dispose: function() {},
        filterForExposedEvent: null
    };
    var zf = Ef.prototype;
    zf.updateView = zf.updateLayout = zf.updateVisual = function() {}, si(Ef), ci(Ef, {
        registerWhenExtend: !0
    });
    var Bf = function() {
        var s = ei();
        return function(t) {
            var e = s(t), i = t.pipelineContext, n = e.large, r = e.progressiveRender, a = e.large = i.large, o = e.progressiveRender = i.progressiveRender;
            return !!(n ^ a || r ^ o) && "reset";
        };
    }, Rf = ei(), Nf = Bf(), Ff = Vr.prototype = {
        type: "chart",
        init: function() {},
        render: function() {},
        highlight: function(t, e, i, n) {
            Wr(t.getData(), n, "emphasis");
        },
        downplay: function(t, e, i, n) {
            Wr(t.getData(), n, "normal");
        },
        remove: function() {
            this.group.removeAll();
        },
        dispose: function() {},
        incrementalPrepareRender: null,
        incrementalRender: null,
        updateTransform: null,
        filterForExposedEvent: null
    };
    Ff.updateView = Ff.updateLayout = Ff.updateVisual = function(t, e, i, n) {
        this.render(t, e, i, n);
    }, si(Vr), ci(Vr, {
        registerWhenExtend: !0
    }), Vr.markUpdateMethod = function(t, e) {
        Rf(t).updateMethod = e;
    };
    var Gf = {
        incrementalPrepareRender: {
            progress: function(t, e) {
                e.view.incrementalRender(t, e.model, e.ecModel, e.api, e.payload);
            }
        },
        render: {
            forceFirstProgress: !0,
            progress: function(t, e) {
                e.view.render(e.model, e.ecModel, e.api, e.payload);
            }
        }
    }, Vf = "\0__throttleOriginMethod", Hf = "\0__throttleRate", Wf = "\0__throttleType", Xf = {
        createOnAllSeries: !0,
        performRawSeries: !0,
        reset: function(e, t) {
            var i = e.getData(), n = (e.visualColorAccessPath || "itemStyle.color").split("."), r = e.get(n) || e.getColorFromPalette(e.name, null, t.getSeriesCount());
            if (i.setVisual("color", r), !t.isSeriesFiltered(e)) {
                "function" != typeof r || r instanceof ld || i.each(function(t) {
                    i.setItemVisual(t, "color", r(e.getDataParams(t)));
                });
                return {
                    dataEach: i.hasItemOption ? function(t, e) {
                        var i = t.getItemModel(e).get(n, !0);
                        null != i && t.setItemVisual(e, "color", i);
                    } : null
                };
            }
        }
    }, qf = {
        toolbox: {
            brush: {
                title: {
                    rect: "矩形选择",
                    polygon: "圈选",
                    lineX: "横向选择",
                    lineY: "纵向选择",
                    keep: "保持选择",
                    clear: "清除选择"
                }
            },
            dataView: {
                title: "数据视图",
                lang: [ "数据视图", "关闭", "刷新" ]
            },
            dataZoom: {
                title: {
                    zoom: "区域缩放",
                    back: "区域缩放还原"
                }
            },
            magicType: {
                title: {
                    line: "切换为折线图",
                    bar: "切换为柱状图",
                    stack: "切换为堆叠",
                    tiled: "切换为平铺"
                }
            },
            restore: {
                title: "还原"
            },
            saveAsImage: {
                title: "保存为图片",
                lang: [ "右键另存为图片" ]
            }
        },
        series: {
            typeNames: {
                pie: "饼图",
                bar: "柱状图",
                line: "折线图",
                scatter: "散点图",
                effectScatter: "涟漪散点图",
                radar: "雷达图",
                tree: "树图",
                treemap: "矩形树图",
                boxplot: "箱型图",
                candlestick: "K线图",
                k: "K线图",
                heatmap: "热力图",
                map: "地图",
                parallel: "平行坐标图",
                lines: "线图",
                graph: "关系图",
                sankey: "桑基图",
                funnel: "漏斗图",
                gauge: "仪表盘图",
                pictorialBar: "象形柱图",
                themeRiver: "主题河流图",
                sunburst: "旭日图"
            }
        },
        aria: {
            general: {
                withTitle: "这是一个关于“{title}”的图表。",
                withoutTitle: "这是一个图表，"
            },
            series: {
                single: {
                    prefix: "",
                    withName: "图表类型是{seriesType}，表示{seriesName}。",
                    withoutName: "图表类型是{seriesType}。"
                },
                multiple: {
                    prefix: "它由{seriesCount}个图表系列组成。",
                    withName: "第{seriesId}个系列是一个表示{seriesName}的{seriesType}，",
                    withoutName: "第{seriesId}个系列是一个{seriesType}，",
                    separator: {
                        middle: "；",
                        end: "。"
                    }
                }
            },
            data: {
                allData: "其数据是——",
                partialData: "其中，前{displayCnt}项是——",
                withName: "{name}的数据是{value}",
                withoutName: "{value}",
                separator: {
                    middle: "，",
                    end: ""
                }
            }
        }
    }, jf = function(t, e) {
        function c(t, e) {
            if ("string" != typeof t) return t;
            var i = t;
            return R(e, function(t, e) {
                i = i.replace(new RegExp("\\{\\s*" + e + "\\s*\\}", "g"), t);
            }), i;
        }
        function d(t) {
            var e = a.get(t);
            if (null == e) {
                for (var i = t.split("."), n = qf.aria, r = 0; r < i.length; ++r) n = n[i[r]];
                return n;
            }
            return e;
        }
        var i, a = e.getModel("aria");
        if (a.get("show")) {
            if (a.get("description")) return void t.setAttribute("aria-label", a.get("description"));
            var f = 0;
            e.eachSeries(function() {
                ++f;
            }, this);
            var n, p = a.get("data.maxCount") || 10, r = a.get("series.maxCount") || 10, g = Math.min(f, r);
            if (!(f < 1)) {
                var o = ((i = e.getModel("title").option) && i.length && (i = i[0]), i && i.text);
                n = o ? c(d("general.withTitle"), {
                    title: o
                }) : d("general.withoutTitle");
                var m = [];
                n += c(d(1 < f ? "series.multiple.prefix" : "series.single.prefix"), {
                    seriesCount: f
                }), e.eachSeries(function(t, e) {
                    if (e < g) {
                        var i, n = t.get("name"), r = "series." + (1 < f ? "multiple" : "single") + ".";
                        i = c(i = d(n ? r + "withName" : r + "withoutName"), {
                            seriesId: t.seriesIndex,
                            seriesName: t.get("name"),
                            seriesType: (u = t.subType, qf.series.typeNames[u] || "自定义图")
                        });
                        var a = t.getData();
                        i += (window.data = a).count() > p ? c(d("data.partialData"), {
                            displayCnt: p
                        }) : d("data.allData");
                        for (var o = [], s = 0; s < a.count(); s++) if (s < p) {
                            var l = a.getName(s), h = Ar(a, s);
                            o.push(c(d(l ? "data.withName" : "data.withoutName"), {
                                name: l,
                                value: h
                            }));
                        }
                        i += o.join(d("data.separator.middle")) + d("data.separator.end"), m.push(i);
                    }
                    var u;
                }), n += m.join(d("series.multiple.separator.middle")) + d("series.multiple.separator.end"), 
                t.setAttribute("aria-label", n);
            }
        }
    }, Uf = Math.PI, Yf = Ur.prototype;
    Yf.restoreData = function(t, e) {
        t.restoreData(e), this._stageTaskMap.each(function(t) {
            var e = t.overallTask;
            e && e.dirty();
        });
    }, Yf.getPerformArgs = function(t, e) {
        if (t.__pipeline) {
            var i = this._pipelineMap.get(t.__pipeline.id), n = i.context, r = !e && i.progressiveEnabled && (!n || n.progressiveRender) && t.__idxInPipeline > i.blockIndex ? i.step : null, a = n && n.modDataCount;
            return {
                step: r,
                modBy: null != a ? Math.ceil(a / r) : null,
                modDataCount: a
            };
        }
    }, Yf.getPipeline = function(t) {
        return this._pipelineMap.get(t);
    }, Yf.updateStreamModes = function(t, e) {
        var i = this._pipelineMap.get(t.uid), n = t.getData().count(), r = i.progressiveEnabled && e.incrementalPrepareRender && n >= i.threshold, a = t.get("large") && n >= t.get("largeThreshold"), o = "mod" === t.get("progressiveChunkMode") ? n : null;
        t.pipelineContext = i.context = {
            progressiveRender: r,
            modDataCount: o,
            large: a
        };
    }, Yf.restorePipelines = function(t) {
        var n = this, r = n._pipelineMap = T();
        t.eachSeries(function(t) {
            var e = t.getProgressive(), i = t.uid;
            r.set(i, {
                id: i,
                head: null,
                tail: null,
                threshold: t.getProgressiveThreshold(),
                progressiveEnabled: e && !(t.preventIncremental && t.preventIncremental()),
                blockIndex: -1,
                step: Math.round(e || 700),
                count: 0
            }), na(n, t, t.dataTask);
        });
    }, Yf.prepareStageTasks = function() {
        var i = this._stageTaskMap, n = this.ecInstance.getModel(), r = this.api;
        R(this._allHandlers, function(t) {
            var e = i.get(t.uid) || i.set(t.uid, []);
            t.reset && function(n, r, t, a, o) {
                function e(t) {
                    var e = t.uid, i = s.get(e) || s.set(e, Pr({
                        plan: Jr,
                        reset: ta,
                        count: ia
                    }));
                    i.context = {
                        model: t,
                        ecModel: a,
                        api: o,
                        useClearVisual: r.isVisual && !r.isLayout,
                        plan: r.plan,
                        reset: r.reset,
                        scheduler: n
                    }, na(n, t, i);
                }
                var s = t.seriesTaskMap || (t.seriesTaskMap = T()), i = r.seriesType, l = r.getTargetSeries;
                r.createOnAllSeries ? a.eachRawSeries(e) : i ? a.eachRawSeriesByType(i, e) : l && l(a, o).each(e);
                var h = n._pipelineMap;
                s.each(function(t, e) {
                    h.get(e) || (t.dispose(), s.removeKey(e));
                });
            }(this, t, e, n, r), t.overallReset && function(n, t, e, i, r) {
                function a(t) {
                    var e = t.uid, i = s.get(e);
                    i || (i = s.set(e, Pr({
                        reset: $r,
                        onDirty: Qr
                    })), o.dirty()), i.context = {
                        model: t,
                        overallProgress: u,
                        modifyOutputEnd: c
                    }, i.agent = o, i.__block = u, na(n, t, i);
                }
                var o = e.overallTask = e.overallTask || Pr({
                    reset: Zr
                });
                o.context = {
                    ecModel: i,
                    api: r,
                    overallReset: t.overallReset,
                    scheduler: n
                };
                var s = o.agentStubMap = o.agentStubMap || T(), l = t.seriesType, h = t.getTargetSeries, u = !0, c = t.modifyOutputEnd;
                l ? i.eachRawSeriesByType(l, a) : h ? h(i, r).each(a) : (u = !1, R(i.getSeries(), a));
                var d = n._pipelineMap;
                s.each(function(t, e) {
                    d.get(e) || (t.dispose(), o.dirty(), s.removeKey(e));
                });
            }(this, t, e, n, r);
        }, this);
    }, Yf.prepareView = function(t, e, i, n) {
        var r = t.renderTask, a = r.context;
        a.model = e, a.ecModel = i, a.api = n, r.__block = !t.incrementalPrepareRender, 
        na(this, e, r);
    }, Yf.performDataProcessorTasks = function(t, e) {
        Yr(this, this._dataProcessorHandlers, t, e, {
            block: !0
        });
    }, Yf.performVisualTasks = function(t, e, i) {
        Yr(this, this._visualHandlers, t, e, i);
    }, Yf.performSeriesTasks = function(t) {
        var e;
        t.eachSeries(function(t) {
            e |= t.dataTask.perform();
        }), this.unfinished |= e;
    }, Yf.plan = function() {
        this._pipelineMap.each(function(t) {
            var e = t.tail;
            do {
                if (e.__block) {
                    t.blockIndex = e.__idxInPipeline;
                    break;
                }
                e = e.getUpstream();
            } while (e);
        });
    };
    var Zf = Yf.updatePayload = function(t, e) {
        "remain" !== e && (t.context.payload = e);
    }, $f = ea(0);
    Ur.wrapStageHandler = function(t, e) {
        return v(t) && (t = {
            overallReset: t,
            seriesType: function(t) {
                Kf = null;
                try {
                    t(Qf, Jf);
                } catch (t) {}
                return Kf;
            }(t)
        }), t.uid = An("stageHandler"), e && (t.visualType = e), t;
    };
    var Kf, Qf = {}, Jf = {};
    ra(Qf, hf), ra(Jf, hr), Qf.eachSeriesByType = Qf.eachRawSeriesByType = function(t) {
        Kf = t;
    }, Qf.eachComponent = function(t) {
        "series" === t.mainType && t.subType && (Kf = t.subType);
    };
    var tp = [ "#37A2DA", "#32C5E9", "#67E0E3", "#9FE6B8", "#FFDB5C", "#ff9f7f", "#fb7293", "#E062AE", "#E690D1", "#e7bcf3", "#9d96f5", "#8378EA", "#96BFFF" ], ep = {
        color: tp,
        colorLayer: [ [ "#37A2DA", "#ffd85c", "#fd7b5f" ], [ "#37A2DA", "#67E0E3", "#FFDB5C", "#ff9f7f", "#E062AE", "#9d96f5" ], [ "#37A2DA", "#32C5E9", "#9FE6B8", "#FFDB5C", "#ff9f7f", "#fb7293", "#e7bcf3", "#8378EA", "#96BFFF" ], tp ]
    }, ip = "#eee", np = function() {
        return {
            axisLine: {
                lineStyle: {
                    color: ip
                }
            },
            axisTick: {
                lineStyle: {
                    color: ip
                }
            },
            axisLabel: {
                textStyle: {
                    color: ip
                }
            },
            splitLine: {
                lineStyle: {
                    type: "dashed",
                    color: "#aaa"
                }
            },
            splitArea: {
                areaStyle: {
                    color: ip
                }
            }
        };
    }, rp = [ "#dd6b66", "#759aa0", "#e69d87", "#8dc1a9", "#ea7e53", "#eedd78", "#73a373", "#73b9bc", "#7289ab", "#91ca8c", "#f49f42" ], ap = {
        color: rp,
        backgroundColor: "#333",
        tooltip: {
            axisPointer: {
                lineStyle: {
                    color: ip
                },
                crossStyle: {
                    color: ip
                }
            }
        },
        legend: {
            textStyle: {
                color: ip
            }
        },
        textStyle: {
            color: ip
        },
        title: {
            textStyle: {
                color: ip
            }
        },
        toolbox: {
            iconStyle: {
                normal: {
                    borderColor: ip
                }
            }
        },
        dataZoom: {
            textStyle: {
                color: ip
            }
        },
        visualMap: {
            textStyle: {
                color: ip
            }
        },
        timeline: {
            lineStyle: {
                color: ip
            },
            itemStyle: {
                normal: {
                    color: rp[1]
                }
            },
            label: {
                normal: {
                    textStyle: {
                        color: ip
                    }
                }
            },
            controlStyle: {
                normal: {
                    color: ip,
                    borderColor: ip
                }
            }
        },
        timeAxis: np(),
        logAxis: np(),
        valueAxis: np(),
        categoryAxis: np(),
        line: {
            symbol: "circle"
        },
        graph: {
            color: rp
        },
        gauge: {
            title: {
                textStyle: {
                    color: ip
                }
            }
        },
        candlestick: {
            itemStyle: {
                normal: {
                    color: "#FD1050",
                    color0: "#0CF49B",
                    borderColor: "#FD1050",
                    borderColor0: "#0CF49B"
                }
            }
        }
    };
    ap.categoryAxis.splitLine.show = !1, jd.extend({
        type: "dataset",
        defaultOption: {
            seriesLayoutBy: af,
            sourceHeader: null,
            dimensions: null,
            source: null
        },
        optionUpdated: function() {
            !function(t) {
                var e = t.option.source, i = nf;
                if (p(e)) i = rf; else if (P(e)) {
                    0 === e.length && (i = Jd);
                    for (var n = 0, r = e.length; n < r; n++) {
                        var a = e[n];
                        if (null != a) {
                            if (P(a)) {
                                i = Jd;
                                break;
                            }
                            if (L(a)) {
                                i = tf;
                                break;
                            }
                        }
                    }
                } else if (L(e)) {
                    for (var o in e) if (e.hasOwnProperty(o) && E(e[o])) {
                        i = ef;
                        break;
                    }
                } else if (null != e) throw new Error("Invalid data");
                sf(t).sourceFormat = i;
            }(this);
        }
    }), Ef.extend({
        type: "dataset"
    });
    var op = Bi.extend({
        type: "ellipse",
        shape: {
            cx: 0,
            cy: 0,
            rx: 0,
            ry: 0
        },
        buildPath: function(t, e) {
            var i = e.cx, n = e.cy, r = e.rx, a = e.ry, o = .5522848 * r, s = .5522848 * a;
            t.moveTo(i - r, n), t.bezierCurveTo(i - r, n - s, i - o, n - a, i, n - a), t.bezierCurveTo(i + o, n - a, i + r, n - s, i + r, n), 
            t.bezierCurveTo(i + r, n + s, i + o, n + a, i, n + a), t.bezierCurveTo(i - o, n + a, i - r, n + s, i - r, n), 
            t.closePath();
        }
    }), sp = /[\s,]+/;
    var lp = {
        g: function(t, e) {
            var i = new Hh();
            return oa(e, i), la(t, i, this._defs), i;
        },
        rect: function(t, e) {
            var i = new id();
            return oa(e, i), la(t, i, this._defs), i.setShape({
                x: parseFloat(t.getAttribute("x") || 0),
                y: parseFloat(t.getAttribute("y") || 0),
                width: parseFloat(t.getAttribute("width") || 0),
                height: parseFloat(t.getAttribute("height") || 0)
            }), i;
        },
        circle: function(t, e) {
            var i = new Zc();
            return oa(e, i), la(t, i, this._defs), i.setShape({
                cx: parseFloat(t.getAttribute("cx") || 0),
                cy: parseFloat(t.getAttribute("cy") || 0),
                r: parseFloat(t.getAttribute("r") || 0)
            }), i;
        },
        line: function(t, e) {
            var i = new nd();
            return oa(e, i), la(t, i, this._defs), i.setShape({
                x1: parseFloat(t.getAttribute("x1") || 0),
                y1: parseFloat(t.getAttribute("y1") || 0),
                x2: parseFloat(t.getAttribute("x2") || 0),
                y2: parseFloat(t.getAttribute("y2") || 0)
            }), i;
        },
        ellipse: function(t, e) {
            var i = new op();
            return oa(e, i), la(t, i, this._defs), i.setShape({
                cx: parseFloat(t.getAttribute("cx") || 0),
                cy: parseFloat(t.getAttribute("cy") || 0),
                rx: parseFloat(t.getAttribute("rx") || 0),
                ry: parseFloat(t.getAttribute("ry") || 0)
            }), i;
        },
        polygon: function(t, e) {
            var i = t.getAttribute("points");
            i && (i = sa(i));
            var n = new td({
                shape: {
                    points: i || []
                }
            });
            return oa(e, n), la(t, n, this._defs), n;
        },
        polyline: function(t, e) {
            var i = new Bi();
            oa(e, i), la(t, i, this._defs);
            var n = t.getAttribute("points");
            return n && (n = sa(n)), new ed({
                shape: {
                    points: n || []
                }
            });
        },
        image: function(t, e) {
            var i = new Fe();
            return oa(e, i), la(t, i, this._defs), i.setStyle({
                image: t.getAttribute("xlink:href"),
                x: t.getAttribute("x"),
                y: t.getAttribute("y"),
                width: t.getAttribute("width"),
                height: t.getAttribute("height")
            }), i;
        },
        text: function(t, e) {
            var i = t.getAttribute("x") || 0, n = t.getAttribute("y") || 0, r = t.getAttribute("dx") || 0, a = t.getAttribute("dy") || 0;
            this._textX = parseFloat(i) + parseFloat(r), this._textY = parseFloat(n) + parseFloat(a);
            var o = new Hh();
            return oa(e, o), la(t, o, this._defs), o;
        },
        tspan: function(t, e) {
            var i = t.getAttribute("x"), n = t.getAttribute("y");
            null != i && (this._textX = parseFloat(i)), null != n && (this._textY = parseFloat(n));
            var r = t.getAttribute("dx") || 0, a = t.getAttribute("dy") || 0, o = new Hh();
            return oa(e, o), la(t, o, this._defs), this._textX += r, this._textY += a, o;
        },
        path: function(t, e) {
            var i = Fi(t.getAttribute("d") || "");
            return oa(e, i), la(t, i, this._defs), i;
        }
    }, hp = {
        lineargradient: function(t) {
            var e = parseInt(t.getAttribute("x1") || 0, 10), i = parseInt(t.getAttribute("y1") || 0, 10), n = parseInt(t.getAttribute("x2") || 10, 10), r = parseInt(t.getAttribute("y2") || 0, 10), a = new hd(e, i, n, r);
            return function(t, e) {
                for (var i = t.firstChild; i; ) {
                    if (1 === i.nodeType) {
                        var n = i.getAttribute("offset");
                        n = 0 < n.indexOf("%") ? parseInt(n, 10) / 100 : n ? parseFloat(n) : 0;
                        var r = i.getAttribute("stop-color") || "#000000";
                        e.addColorStop(n, r);
                    }
                    i = i.nextSibling;
                }
            }(t, a), a;
        },
        radialgradient: function() {}
    }, up = {
        fill: "fill",
        stroke: "stroke",
        "stroke-width": "lineWidth",
        opacity: "opacity",
        "fill-opacity": "fillOpacity",
        "stroke-opacity": "strokeOpacity",
        "stroke-dasharray": "lineDash",
        "stroke-dashoffset": "lineDashOffset",
        "stroke-linecap": "lineCap",
        "stroke-linejoin": "lineJoin",
        "stroke-miterlimit": "miterLimit",
        "font-family": "fontFamily",
        "font-size": "fontSize",
        "font-style": "fontStyle",
        "font-weight": "fontWeight",
        "text-align": "textAlign",
        "alignment-baseline": "textBaseline"
    }, cp = /url\(\s*#(.*?)\)/, dp = /(translate|scale|rotate|skewX|skewY|matrix)\(([\-\s0-9\.e,]*)\)/g, fp = /([^\s:;]+)\s*:\s*([^:;]+)/g, pp = (T(), 
    c), gp = R, mp = v, vp = L, yp = jd.parseClassType, xp = {
        PROCESSOR: {
            FILTER: 1e3,
            STATISTIC: 5e3
        },
        VISUAL: {
            LAYOUT: 1e3,
            GLOBAL: 2e3,
            CHART: 3e3,
            COMPONENT: 4e3,
            BRUSH: 5e3
        }
    }, _p = "__flagInMainProcess", wp = "__optionUpdated", bp = /^[a-zA-Z0-9_]+$/;
    ca.prototype.on = ua("on"), ca.prototype.off = ua("off"), ca.prototype.one = ua("one"), 
    r(ca, th);
    var Sp = da.prototype;
    Sp._onframe = function() {
        if (!this._disposed) {
            var t = this._scheduler;
            if (this[wp]) {
                var e = this[wp].silent;
                this[_p] = !0, pa(this), Mp.update.call(this), this[_p] = !1, this[wp] = !1, ya.call(this, e), 
                xa.call(this, e);
            } else if (t.unfinished) {
                var i = 1, n = this._model;
                this._api;
                t.unfinished = !1;
                do {
                    var r = +new Date();
                    t.performSeriesTasks(n), t.performDataProcessorTasks(n), ma(this, n), t.performVisualTasks(n), 
                    Sa(this, this._model, 0, "remain"), i -= +new Date() - r;
                } while (0 < i && t.unfinished);
                t.unfinished || this._zr.flush();
            }
        }
    }, Sp.getDom = function() {
        return this._dom;
    }, Sp.getZr = function() {
        return this._zr;
    }, Sp.setOption = function(t, e, i) {
        var n;
        if (vp(e) && (i = e.lazyUpdate, n = e.silent, e = e.notMerge), this[_p] = !0, !this._model || e) {
            var r = new cr(this._api), a = this._theme, o = this._model = new hf(null, null, a, r);
            o.scheduler = this._scheduler, o.init(null, null, a, r);
        }
        this._model.setOption(t, Ap), i ? (this[wp] = {
            silent: n
        }, this[_p] = !1) : (pa(this), Mp.update.call(this), this._zr.flush(), this[wp] = !1, 
        this[_p] = !1, ya.call(this, n), xa.call(this, n));
    }, Sp.setTheme = function() {
        console.error("ECharts#setTheme() is DEPRECATED in ECharts 3.0");
    }, Sp.getModel = function() {
        return this._model;
    }, Sp.getOption = function() {
        return this._model && this._model.getOption();
    }, Sp.getWidth = function() {
        return this._zr.getWidth();
    }, Sp.getHeight = function() {
        return this._zr.getHeight();
    }, Sp.getDevicePixelRatio = function() {
        return this._zr.painter.dpr || window.devicePixelRatio || 1;
    }, Sp.getRenderedCanvas = function(t) {
        if (Ll.canvasSupported) return (t = t || {}).pixelRatio = t.pixelRatio || 1, t.backgroundColor = t.backgroundColor || this._model.get("backgroundColor"), 
        this._zr.painter.getRenderedCanvas(t);
    }, Sp.getSvgDataUrl = function() {
        if (Ll.svgSupported) {
            var t = this._zr;
            return R(t.storage.getDisplayList(), function(t) {
                t.stopAnimation(!0);
            }), t.painter.pathToDataUrl();
        }
    }, Sp.getDataURL = function(t) {
        var e = (t = t || {}).excludeComponents, i = this._model, n = [], r = this;
        gp(e, function(t) {
            i.eachComponent({
                mainType: t
            }, function(t) {
                var e = r._componentsMap[t.__viewId];
                e.group.ignore || (n.push(e), e.group.ignore = !0);
            });
        });
        var a = "svg" === this._zr.painter.getType() ? this.getSvgDataUrl() : this.getRenderedCanvas(t).toDataURL("image/" + (t && t.type || "png"));
        return gp(n, function(t) {
            t.group.ignore = !1;
        }), a;
    }, Sp.getConnectedDataURL = function(n) {
        if (Ll.canvasSupported) {
            var r = this.group, a = Math.min, o = Math.max;
            if (zp[r]) {
                var s = 1 / 0, l = 1 / 0, h = -1 / 0, u = -1 / 0, c = [], i = n && n.pixelRatio || 1;
                R(Ep, function(t) {
                    if (t.group === r) {
                        var e = t.getRenderedCanvas(b(n)), i = t.getDom().getBoundingClientRect();
                        s = a(i.left, s), l = a(i.top, l), h = o(i.right, h), u = o(i.bottom, u), c.push({
                            dom: e,
                            left: i.left,
                            top: i.top
                        });
                    }
                });
                var t = (h *= i) - (s *= i), e = (u *= i) - (l *= i), d = Wl();
                d.width = t, d.height = e;
                var f = Ue(d);
                return gp(c, function(t) {
                    var e = new Fe({
                        style: {
                            x: t.left * i - s,
                            y: t.top * i - l,
                            image: t.dom
                        }
                    });
                    f.add(e);
                }), f.refreshImmediately(), d.toDataURL("image/" + (n && n.type || "png"));
            }
            return this.getDataURL(n);
        }
    }, Sp.convertToPixel = g(fa, "convertToPixel"), Sp.convertFromPixel = g(fa, "convertFromPixel"), 
    Sp.containPixel = function(t, r) {
        var a;
        return R(t = ii(this._model, t), function(t, n) {
            0 <= n.indexOf("Models") && R(t, function(t) {
                var e = t.coordinateSystem;
                if (e && e.containPoint) a |= !!e.containPoint(r); else if ("seriesModels" === n) {
                    var i = this._chartsMap[t.__viewId];
                    i && i.containPoint && (a |= i.containPoint(r, t));
                }
            }, this);
        }, this), !!a;
    }, Sp.getVisual = function(t, e) {
        var i = (t = ii(this._model, t, {
            defaultMainType: "series"
        })).seriesModel.getData(), n = t.hasOwnProperty("dataIndexInside") ? t.dataIndexInside : t.hasOwnProperty("dataIndex") ? i.indexOfRawIndex(t.dataIndex) : null;
        return null != n ? i.getItemVisual(n, e) : i.getVisual(e);
    }, Sp.getViewOfComponentModel = function(t) {
        return this._componentsMap[t.__viewId];
    }, Sp.getViewOfSeriesModel = function(t) {
        return this._chartsMap[t.__viewId];
    };
    var Mp = {
        prepareAndUpdate: function(t) {
            pa(this), Mp.update.call(this, t);
        },
        update: function(t) {
            var e = this._model, i = this._api, n = this._zr, r = this._coordSysMgr, a = this._scheduler;
            if (e) {
                a.restoreData(e, t), a.performSeriesTasks(e), r.create(e, i), a.performDataProcessorTasks(e, t), 
                ma(this, e), r.update(e, i), wa(e), a.performVisualTasks(e, t), ba(this, e, i, t);
                var o = e.get("backgroundColor") || "transparent";
                if (Ll.canvasSupported) n.setBackgroundColor(o); else {
                    var s = Ct(o);
                    o = Ot(s, "rgb"), 0 === s[3] && (o = "transparent");
                }
                Ma(e, i);
            }
        },
        updateTransform: function(r) {
            var a = this._model, o = this, s = this._api;
            if (a) {
                var l = [];
                a.eachComponent(function(t, e) {
                    var i = o.getViewOfComponentModel(e);
                    if (i && i.__alive) if (i.updateTransform) {
                        var n = i.updateTransform(e, a, s, r);
                        n && n.update && l.push(i);
                    } else l.push(i);
                });
                var n = T();
                a.eachSeries(function(t) {
                    var e = o._chartsMap[t.__viewId];
                    if (e.updateTransform) {
                        var i = e.updateTransform(t, a, s, r);
                        i && i.update && n.set(t.uid, 1);
                    } else n.set(t.uid, 1);
                }), wa(a), this._scheduler.performVisualTasks(a, r, {
                    setDirty: !0,
                    dirtyMap: n
                }), Sa(o, a, 0, r, n), Ma(a, this._api);
            }
        },
        updateView: function(t) {
            var e = this._model;
            e && (Vr.markUpdateMethod(t, "updateView"), wa(e), this._scheduler.performVisualTasks(e, t, {
                setDirty: !0
            }), ba(this, this._model, this._api, t), Ma(e, this._api));
        },
        updateVisual: function(t) {
            Mp.update.call(this, t);
        },
        updateLayout: function(t) {
            Mp.update.call(this, t);
        }
    };
    Sp.resize = function(t) {
        this._zr.resize(t);
        var e = this._model;
        if (this._loadingFX && this._loadingFX.resize(), e) {
            var i = e.resetOption("media"), n = t && t.silent;
            this[_p] = !0, i && pa(this), Mp.update.call(this), this[_p] = !1, ya.call(this, n), 
            xa.call(this, n);
        }
    }, Sp.showLoading = function(t, e) {
        if (vp(t) && (e = t, t = ""), t = t || "default", this.hideLoading(), Op[t]) {
            var i = Op[t](this._api, e), n = this._zr;
            this._loadingFX = i, n.add(i);
        }
    }, Sp.hideLoading = function() {
        this._loadingFX && this._zr.remove(this._loadingFX), this._loadingFX = null;
    }, Sp.makeActionFromEvent = function(t) {
        var e = A({}, t);
        return e.type = Cp[t.type], e;
    }, Sp.dispatchAction = function(t, e) {
        if (vp(e) || (e = {
            silent: !!e
        }), Tp[t.type] && this._model) {
            if (this[_p]) return void this._pendingActions.push(t);
            va.call(this, t, e.silent), e.flush ? this._zr.flush(!0) : !1 !== e.flush && Ll.browser.weChat && this._throttledZrFlush(), 
            ya.call(this, e.silent), xa.call(this, e.silent);
        }
    }, Sp.appendData = function(t) {
        var e = t.seriesIndex;
        this.getModel().getSeriesByIndex(e).appendData(t), this._scheduler.unfinished = !0;
    }, Sp.on = ua("on"), Sp.off = ua("off"), Sp.one = ua("one");
    var Ip = [ "click", "dblclick", "mouseover", "mouseout", "mousemove", "mousedown", "mouseup", "globalout", "contextmenu" ];
    Sp._initEvents = function() {
        gp(Ip, function(h) {
            this._zr.on(h, function(t) {
                var e, i = this.getModel(), n = t.target;
                if ("globalout" === h) e = {}; else if (n && null != n.dataIndex) {
                    var r = n.dataModel || i.getSeriesByIndex(n.seriesIndex);
                    e = r && r.getDataParams(n.dataIndex, n.dataType, n) || {};
                } else n && n.eventData && (e = A({}, n.eventData));
                if (e) {
                    var a = e.componentType, o = e.componentIndex;
                    ("markLine" === a || "markPoint" === a || "markArea" === a) && (a = "series", o = e.seriesIndex);
                    var s = a && null != o && i.getComponent(a, o), l = s && this["series" === s.mainType ? "_chartsMap" : "_componentsMap"][s.__viewId];
                    e.event = t, e.type = h, this._ecEventProcessor.eventInfo = {
                        targetEl: n,
                        packedEvent: e,
                        model: s,
                        view: l
                    }, this.trigger(h, e);
                }
            }, this);
        }, this), gp(Cp, function(t, e) {
            this._messageCenter.on(e, function(t) {
                this.trigger(e, t);
            }, this);
        }, this);
    }, Sp.isDisposed = function() {
        return this._disposed;
    }, Sp.clear = function() {
        this.setOption({
            series: []
        }, !0);
    }, Sp.dispose = function() {
        if (!this._disposed) {
            this._disposed = !0, ri(this.getDom(), Np, "");
            var e = this._api, i = this._model;
            gp(this._componentsViews, function(t) {
                t.dispose(i, e);
            }), gp(this._chartsViews, function(t) {
                t.dispose(i, e);
            }), this._zr.dispose(), delete Ep[this.id];
        }
    }, r(da, th), Ta.prototype = {
        constructor: Ta,
        normalizeQuery: function(t) {
            var s = {}, l = {}, h = {};
            if (M(t)) {
                var e = yp(t);
                s.mainType = e.main || null, s.subType = e.sub || null;
            } else {
                var u = [ "Index", "Name", "Id" ], c = {
                    name: 1,
                    dataIndex: 1,
                    dataType: 1
                };
                R(t, function(t, e) {
                    for (var i = !1, n = 0; n < u.length; n++) {
                        var r = u[n], a = e.lastIndexOf(r);
                        if (0 < a && a === e.length - r.length) {
                            var o = e.slice(0, a);
                            "data" !== o && (s.mainType = o, s[r.toLowerCase()] = t, i = !0);
                        }
                    }
                    c.hasOwnProperty(e) && (l[e] = t, i = !0), i || (h[e] = t);
                });
            }
            return {
                cptQuery: s,
                dataQuery: l,
                otherQuery: h
            };
        },
        filter: function(t, e) {
            function i(t, e, i, n) {
                return null == t[i] || e[n || i] === t[i];
            }
            var n = this.eventInfo;
            if (!n) return !0;
            var r = n.targetEl, a = n.packedEvent, o = n.model, s = n.view;
            if (!o || !s) return !0;
            var l = e.cptQuery, h = e.dataQuery;
            return i(l, o, "mainType") && i(l, o, "subType") && i(l, o, "index", "componentIndex") && i(l, o, "name") && i(l, o, "id") && i(h, a, "name") && i(h, a, "dataIndex") && i(h, a, "dataType") && (!s.filterForExposedEvent || s.filterForExposedEvent(t, e.otherQuery, r, a));
        },
        afterTrigger: function() {
            this.eventInfo = null;
        }
    };
    var Tp = {}, Cp = {}, Dp = [], Ap = [], kp = [], Pp = [], Lp = {}, Op = {}, Ep = {}, zp = {}, Bp = new Date() - 0, Rp = new Date() - 0, Np = "_echarts_instance_", Fp = Ca;
    Ea(2e3, Xf), ka(Sf), Pa(5e3, function(t) {
        var a = T();
        t.eachSeries(function(t) {
            var e = t.get("stack");
            if (e) {
                var i = a.get(e) || a.set(e, []), n = t.getData(), r = {
                    stackResultDimension: n.getCalculationInfo("stackResultDimension"),
                    stackedOverDimension: n.getCalculationInfo("stackedOverDimension"),
                    stackedDimension: n.getCalculationInfo("stackedDimension"),
                    stackedByDimension: n.getCalculationInfo("stackedByDimension"),
                    isStackedByIndex: n.getCalculationInfo("isStackedByIndex"),
                    data: n,
                    seriesModel: t
                };
                if (!r.stackedDimension || !r.isStackedByIndex && !r.stackedByDimension) return;
                i.length && n.setCalculationInfo("stackedOnSeries", i[i.length - 1].seriesModel), 
                i.push(r);
            }
        }), a.each(wr);
    }), Ba("default", function(n, t) {
        C(t = t || {}, {
            text: "loading",
            color: "#c23531",
            textColor: "#000",
            maskColor: "rgba(255, 255, 255, 0.8)",
            zlevel: 0
        });
        var r = new id({
            style: {
                fill: t.maskColor
            },
            zlevel: t.zlevel,
            z: 1e4
        }), a = new od({
            shape: {
                startAngle: -Uf / 2,
                endAngle: -Uf / 2 + .1,
                r: 10
            },
            style: {
                stroke: t.color,
                lineCap: "round",
                lineWidth: 5
            },
            zlevel: t.zlevel,
            z: 10001
        }), o = new id({
            style: {
                fill: "none",
                text: t.text,
                textPosition: "right",
                textDistance: 10,
                textFill: t.textColor
            },
            zlevel: t.zlevel,
            z: 10001
        });
        a.animateShape(!0).when(1e3, {
            endAngle: 3 * Uf / 2
        }).start("circularInOut"), a.animateShape(!0).when(1e3, {
            startAngle: 3 * Uf / 2
        }).delay(300).start("circularInOut");
        var e = new Hh();
        return e.add(a), e.add(o), e.add(r), e.resize = function() {
            var t = n.getWidth() / 2, e = n.getHeight() / 2;
            a.setShape({
                cx: t,
                cy: e
            });
            var i = a.shape.r;
            o.setShape({
                x: t - i,
                y: e - i,
                width: 2 * i,
                height: 2 * i
            }), r.setShape({
                x: 0,
                y: 0,
                width: n.getWidth(),
                height: n.getHeight()
            });
        }, e.resize(), e;
    }), La({
        type: "highlight",
        event: "highlight",
        update: "highlight"
    }, B), La({
        type: "downplay",
        event: "downplay",
        update: "downplay"
    }, B), Aa("light", ep), Aa("dark", ap);
    Ha.prototype = {
        constructor: Ha,
        add: function(t) {
            return this._add = t, this;
        },
        update: function(t) {
            return this._update = t, this;
        },
        remove: function(t) {
            return this._remove = t, this;
        },
        execute: function() {
            var t = this._old, e = this._new, i = {}, n = [], r = [];
            for (Wa(t, {}, n, "_oldKeyGetter", this), Wa(e, i, r, "_newKeyGetter", this), a = 0; a < t.length; a++) {
                if (null != (s = i[o = n[a]])) (h = s.length) ? (1 === h && (i[o] = null), s = s.unshift()) : i[o] = null, 
                this._update && this._update(s, a); else this._remove && this._remove(a);
            }
            for (var a = 0; a < r.length; a++) {
                var o = r[a];
                if (i.hasOwnProperty(o)) {
                    var s;
                    if (null == (s = i[o])) continue;
                    if (s.length) for (var l = 0, h = s.length; l < h; l++) this._add && this._add(s[l]); else this._add && this._add(s);
                }
            }
        }
    };
    var Gp = T([ "tooltip", "label", "itemName", "itemId", "seriesName" ]), Vp = L, Hp = "undefined", Wp = {
        float: ("undefined" == typeof Float64Array ? "undefined" : _typeof(Float64Array)) === Hp ? Array : Float64Array,
        int: ("undefined" == typeof Int32Array ? "undefined" : _typeof(Int32Array)) === Hp ? Array : Int32Array,
        ordinal: Array,
        number: Array,
        time: Array
    }, Xp = ("undefined" == typeof Uint32Array ? "undefined" : _typeof(Uint32Array)) === Hp ? Array : Uint32Array, qp = ("undefined" == typeof Uint16Array ? "undefined" : _typeof(Uint16Array)) === Hp ? Array : Uint16Array, jp = [ "hasItemOption", "_nameList", "_idList", "_invertedIndicesMap", "_rawData", "_chunkSize", "_chunkCount", "_dimValueGetter", "_count", "_rawCount", "_nameDimIdx", "_idDimIdx" ], Up = [ "_extent", "_approximateExtent", "_rawExtent" ], Yp = function(t, e) {
        t = t || [ "x", "y" ];
        for (var i = {}, n = [], r = {}, a = 0; a < t.length; a++) {
            var o = t[a];
            M(o) && (o = {
                name: o
            });
            var s = o.name;
            o.type = o.type || "float", o.coordDim || (o.coordDim = s, o.coordDimIndex = 0), 
            o.otherDims = o.otherDims || {}, n.push(s), (i[s] = o).index = a, o.createInvertedIndices && (r[s] = []);
        }
        this.dimensions = n, this._dimensionInfos = i, this.hostModel = e, this.dataType, 
        this._indices = null, this._count = 0, this._rawCount = 0, this._storage = {}, this._nameList = [], 
        this._idList = [], this._optionModels = [], this._visual = {}, this._layout = {}, 
        this._itemVisuals = [], this.hasItemVisual = {}, this._itemLayouts = [], this._graphicEls = [], 
        this._chunkSize = 1e5, this._chunkCount = 0, this._rawData, this._rawExtent = {}, 
        this._extent = {}, this._approximateExtent = {}, this._dimensionsSummary = function(a) {
            var t = {}, o = t.encode = {}, s = T(), l = [], h = [];
            R(a.dimensions, function(t) {
                var e, r = a.getDimensionInfo(t), i = r.coordDim;
                if (i) {
                    var n = o[i];
                    o.hasOwnProperty(i) || (n = o[i] = []), n[r.coordDimIndex] = t, r.isExtraCoord || (s.set(i, 1), 
                    !("ordinal" === (e = r.type) || "time" === e) && (l[0] = t)), r.defaultTooltip && h.push(t);
                }
                Gp.each(function(t, e) {
                    var i = o[e];
                    o.hasOwnProperty(e) || (i = o[e] = []);
                    var n = r.otherDims[e];
                    null != n && !1 !== n && (i[n] = r.name);
                });
            });
            var n = [], r = {};
            s.each(function(t, e) {
                var i = o[e];
                r[e] = i[0], n = n.concat(i);
            }), t.dataDimsOnCoord = n, t.encodeFirstDimNotExtra = r;
            var e = o.label;
            e && e.length && (l = e.slice());
            var i = o.tooltip;
            return i && i.length ? h = i.slice() : h.length || (h = l.slice()), o.defaultedLabel = l, 
            o.defaultedTooltip = h, t;
        }(this), this._invertedIndicesMap = r, this._calculationInfo = {};
    }, Zp = Yp.prototype;
    Zp.type = "list", Zp.hasItemOption = !0, Zp.getDimension = function(t) {
        return isNaN(t) || (t = this.dimensions[t] || t), t;
    }, Zp.getDimensionInfo = function(t) {
        return this._dimensionInfos[this.getDimension(t)];
    }, Zp.getDimensionsOnCoord = function() {
        return this._dimensionsSummary.dataDimsOnCoord.slice();
    }, Zp.mapDimension = function(t, e) {
        var i = this._dimensionsSummary;
        if (null == e) return i.encodeFirstDimNotExtra[t];
        var n = i.encode[t];
        return !0 === e ? (n || []).slice() : n && n[e];
    }, Zp.initData = function(t, e, i) {
        (er.isInstance(t) || E(t)) && (t = new br(t, this.dimensions.length)), this._rawData = t, 
        this._storage = {}, this._indices = null, this._nameList = e || [], this._idList = [], 
        this._nameRepeatCount = {}, i || (this.hasItemOption = !1), this.defaultDimValueGetter = Cf[this._rawData.getSource().sourceFormat], 
        this._dimValueGetter = i = i || this.defaultDimValueGetter, this._rawExtent = {}, 
        this._initDataFromProvider(0, t.count()), t.pure && (this.hasItemOption = !1);
    }, Zp.getProvider = function() {
        return this._rawData;
    }, Zp.appendData = function(t) {
        var e = this._rawData, i = this.count();
        e.appendData(t);
        var n = e.count();
        e.persistent || (n += i), this._initDataFromProvider(i, n);
    }, Zp._initDataFromProvider = function(t, e) {
        if (!(e <= t)) {
            for (var i, n = this._chunkSize, r = this._rawData, a = this._storage, o = this.dimensions, s = o.length, l = this._dimensionInfos, h = this._nameList, u = this._idList, c = this._rawExtent, d = this._nameRepeatCount = {}, f = this._chunkCount, p = f - 1, g = 0; g < s; g++) {
                c[T = o[g]] || (c[T] = [ 1 / 0, -1 / 0 ]);
                var m = l[T];
                0 === m.otherDims.itemName && (i = this._nameDimIdx = g), 0 === m.otherDims.itemId && (this._idDimIdx = g);
                var v = Wp[m.type];
                a[T] || (a[T] = []);
                var y = a[T][p];
                if (y && y.length < n) {
                    for (var x = new v(Math.min(e - p * n, n)), _ = 0; _ < y.length; _++) x[_] = y[_];
                    a[T][p] = x;
                }
                for (var w = f * n; w < e; w += n) a[T].push(new v(Math.min(e - w, n)));
                this._chunkCount = a[T].length;
            }
            for (var b = new Array(s), S = t; S < e; S++) {
                b = r.getItem(S, b);
                var M = Math.floor(S / n), I = S % n;
                for (w = 0; w < s; w++) {
                    var T, C = a[T = o[w]][M], D = this._dimValueGetter(b, T, S, w);
                    C[I] = D;
                    var A = c[T];
                    D < A[0] && (A[0] = D), D > A[1] && (A[1] = D);
                }
                if (!r.pure) {
                    var k = h[S];
                    if (b && null == k) if (null != b.name) h[S] = k = b.name; else if (null != i) {
                        var P = o[i], L = a[P][M];
                        if (L) {
                            k = L[I];
                            var O = l[P].ordinalMeta;
                            O && O.categories.length && (k = O.categories[k]);
                        }
                    }
                    var E = null == b ? null : b.id;
                    null == E && null != k && (d[k] = d[k] || 0, 0 < d[E = k] && (E += "__ec__" + d[k]), 
                    d[k]++), null != E && (u[S] = E);
                }
            }
            !r.persistent && r.clean && r.clean(), this._rawCount = this._count = e, this._extent = {}, 
            R(B = (z = this)._invertedIndicesMap, function(t, e) {
                var i = z._dimensionInfos[e].ordinalMeta;
                if (i) {
                    t = B[e] = new Xp(i.categories.length);
                    for (var n = 0; n < t.length; n++) t[n] = NaN;
                    for (n = 0; n < z._count; n++) t[z.get(e, n)] = n;
                }
            });
        }
        var z, B;
    }, Zp.count = function() {
        return this._count;
    }, Zp.getIndices = function() {
        var t = this._indices;
        if (t) {
            var e = t.constructor, i = this._count;
            if (e === Array) {
                r = new e(i);
                for (var n = 0; n < i; n++) r[n] = t[n];
            } else r = new e(t.buffer, 0, i);
        } else {
            var r = new (e = Xa(this))(this.count());
            for (n = 0; n < r.length; n++) r[n] = n;
        }
        return r;
    }, Zp.get = function(t, e) {
        if (!(0 <= e && e < this._count)) return NaN;
        var i = this._storage;
        if (!i[t]) return NaN;
        e = this.getRawIndex(e);
        var n = Math.floor(e / this._chunkSize), r = e % this._chunkSize;
        return i[t][n][r];
    }, Zp.getByRawIndex = function(t, e) {
        if (!(0 <= e && e < this._rawCount)) return NaN;
        var i = this._storage[t];
        if (!i) return NaN;
        var n = Math.floor(e / this._chunkSize), r = e % this._chunkSize;
        return i[n][r];
    }, Zp._getFast = function(t, e) {
        var i = Math.floor(e / this._chunkSize), n = e % this._chunkSize;
        return this._storage[t][i][n];
    }, Zp.getValues = function(t, e) {
        var i = [];
        P(t) || (e = t, t = this.dimensions);
        for (var n = 0, r = t.length; n < r; n++) i.push(this.get(t[n], e));
        return i;
    }, Zp.hasValue = function(t) {
        for (var e = this._dimensionsSummary.dataDimsOnCoord, i = this._dimensionInfos, n = 0, r = e.length; n < r; n++) if ("ordinal" !== i[e[n]].type && isNaN(this.get(e[n], t))) return !1;
        return !0;
    }, Zp.getDataExtent = function(t) {
        t = this.getDimension(t);
        var e = [ 1 / 0, -1 / 0 ];
        if (!this._storage[t]) return e;
        var i, n = this.count();
        if (!this._indices) return this._rawExtent[t].slice();
        if (i = this._extent[t]) return i.slice();
        for (var r = (i = e)[0], a = i[1], o = 0; o < n; o++) {
            var s = this._getFast(t, this.getRawIndex(o));
            s < r && (r = s), a < s && (a = s);
        }
        return i = [ r, a ], this._extent[t] = i;
    }, Zp.getApproximateExtent = function(t) {
        return t = this.getDimension(t), this._approximateExtent[t] || this.getDataExtent(t);
    }, Zp.setApproximateExtent = function(t, e) {
        e = this.getDimension(e), this._approximateExtent[e] = t.slice();
    }, Zp.getCalculationInfo = function(t) {
        return this._calculationInfo[t];
    }, Zp.setCalculationInfo = function(t, e) {
        Vp(t) ? A(this._calculationInfo, t) : this._calculationInfo[t] = e;
    }, Zp.getSum = function(t) {
        var e = 0;
        if (this._storage[t]) for (var i = 0, n = this.count(); i < n; i++) {
            var r = this.get(t, i);
            isNaN(r) || (e += r);
        }
        return e;
    }, Zp.getMedian = function(t) {
        var e = [];
        this.each(t, function(t) {
            isNaN(t) || e.push(t);
        });
        var i = [].concat(e).sort(function(t, e) {
            return t - e;
        }), n = this.count();
        return 0 === n ? 0 : n % 2 == 1 ? i[(n - 1) / 2] : (i[n / 2] + i[n / 2 - 1]) / 2;
    }, Zp.rawIndexOf = function(t, e) {
        var i = (t && this._invertedIndicesMap[t])[e];
        return null == i || isNaN(i) ? -1 : i;
    }, Zp.indexOfName = function(t) {
        for (var e = 0, i = this.count(); e < i; e++) if (this.getName(e) === t) return e;
        return -1;
    }, Zp.indexOfRawIndex = function(t) {
        if (!this._indices) return t;
        if (t >= this._rawCount || t < 0) return -1;
        var e = this._indices, i = e[t];
        if (null != i && i < this._count && i === t) return t;
        for (var n = 0, r = this._count - 1; n <= r; ) {
            var a = (n + r) / 2 | 0;
            if (e[a] < t) n = a + 1; else {
                if (!(e[a] > t)) return a;
                r = a - 1;
            }
        }
        return -1;
    }, Zp.indicesOfNearest = function(t, e, i) {
        var n = [];
        if (!this._storage[t]) return n;
        null == i && (i = 1 / 0);
        for (var r = Number.MAX_VALUE, a = -1, o = 0, s = this.count(); o < s; o++) {
            var l = e - this.get(t, o), h = Math.abs(l);
            l <= i && h <= r && ((h < r || 0 <= l && a < 0) && (r = h, a = l, n.length = 0), 
            n.push(o));
        }
        return n;
    }, Zp.getRawIndex = Ua, Zp.getRawDataItem = function(t) {
        if (this._rawData.persistent) return this._rawData.getItem(this.getRawIndex(t));
        for (var e = [], i = 0; i < this.dimensions.length; i++) {
            var n = this.dimensions[i];
            e.push(this.get(n, t));
        }
        return e;
    }, Zp.getName = function(t) {
        var e = this.getRawIndex(t);
        return this._nameList[e] || ja(this, this._nameDimIdx, e) || "";
    }, Zp.getId = function(t) {
        return Za(this, this.getRawIndex(t));
    }, Zp.each = function(t, e, i, n) {
        if (this._count) {
            "function" == typeof t && (n = i, i = e, e = t, t = []), i = i || n || this;
            for (var r = (t = D($a(t), this.getDimension, this)).length, a = 0; a < this.count(); a++) switch (r) {
              case 0:
                e.call(i, a);
                break;

              case 1:
                e.call(i, this.get(t[0], a), a);
                break;

              case 2:
                e.call(i, this.get(t[0], a), this.get(t[1], a), a);
                break;

              default:
                for (var o = 0, s = []; o < r; o++) s[o] = this.get(t[o], a);
                s[o] = a, e.apply(i, s);
            }
        }
    }, Zp.filterSelf = function(t, e, i, n) {
        if (this._count) {
            "function" == typeof t && (n = i, i = e, e = t, t = []), i = i || n || this, t = D($a(t), this.getDimension, this);
            for (var r = this.count(), a = new (Xa(this))(r), o = [], s = t.length, l = 0, h = t[0], u = 0; u < r; u++) {
                var c, d = this.getRawIndex(u);
                if (0 === s) c = e.call(i, u); else if (1 === s) {
                    var f = this._getFast(h, d);
                    c = e.call(i, f, u);
                } else {
                    for (var p = 0; p < s; p++) o[p] = this._getFast(h, d);
                    o[p] = u, c = e.apply(i, o);
                }
                c && (a[l++] = d);
            }
            return l < r && (this._indices = a), this._count = l, this._extent = {}, this.getRawIndex = this._indices ? Ya : Ua, 
            this;
        }
    }, Zp.selectRange = function(t) {
        if (this._count) {
            var e = [];
            for (var i in t) t.hasOwnProperty(i) && e.push(i);
            var n = e.length;
            if (n) {
                var r = this.count(), a = new (Xa(this))(r), o = 0, s = e[0], l = t[s][0], h = t[s][1], u = !1;
                if (!this._indices) {
                    var c = 0;
                    if (1 === n) {
                        for (var d = this._storage[e[0]], f = 0; f < this._chunkCount; f++) for (var p = d[f], g = Math.min(this._count - f * this._chunkSize, this._chunkSize), m = 0; m < g; m++) {
                            (l <= (w = p[m]) && w <= h || isNaN(w)) && (a[o++] = c), c++;
                        }
                        u = !0;
                    } else if (2 === n) {
                        d = this._storage[s];
                        var v = this._storage[e[1]], y = t[e[1]][0], x = t[e[1]][1];
                        for (f = 0; f < this._chunkCount; f++) {
                            p = d[f];
                            var _ = v[f];
                            for (g = Math.min(this._count - f * this._chunkSize, this._chunkSize), m = 0; m < g; m++) {
                                var w = p[m], b = _[m];
                                (l <= w && w <= h || isNaN(w)) && (y <= b && b <= x || isNaN(b)) && (a[o++] = c), 
                                c++;
                            }
                        }
                        u = !0;
                    }
                }
                if (!u) if (1 === n) for (m = 0; m < r; m++) {
                    var S = this.getRawIndex(m);
                    (l <= (w = this._getFast(s, S)) && w <= h || isNaN(w)) && (a[o++] = S);
                } else for (m = 0; m < r; m++) {
                    var M = !0;
                    for (S = this.getRawIndex(m), f = 0; f < n; f++) {
                        var I = e[f];
                        ((w = this._getFast(i, S)) < t[I][0] || w > t[I][1]) && (M = !1);
                    }
                    M && (a[o++] = this.getRawIndex(m));
                }
                return o < r && (this._indices = a), this._count = o, this._extent = {}, this.getRawIndex = this._indices ? Ya : Ua, 
                this;
            }
        }
    }, Zp.mapArray = function(t, e, i, n) {
        "function" == typeof t && (n = i, i = e, e = t, t = []), i = i || n || this;
        var r = [];
        return this.each(t, function() {
            r.push(e && e.apply(this, arguments));
        }, i), r;
    }, Zp.map = function(t, e, i, n) {
        i = i || n || this;
        var r = Ka(this, t = D($a(t), this.getDimension, this));
        r._indices = this._indices, r.getRawIndex = r._indices ? Ya : Ua;
        for (var a = r._storage, o = [], s = this._chunkSize, l = t.length, h = this.count(), u = [], c = r._rawExtent, d = 0; d < h; d++) {
            for (var f = 0; f < l; f++) u[f] = this.get(t[f], d);
            u[l] = d;
            var p = e && e.apply(i, u);
            if (null != p) {
                "object" != (void 0 === p ? "undefined" : _typeof(p)) && (o[0] = p, p = o);
                for (var g = this.getRawIndex(d), m = Math.floor(g / s), v = g % s, y = 0; y < p.length; y++) {
                    var x = t[y], _ = p[y], w = c[x], b = a[x];
                    b && (b[m][v] = _), _ < w[0] && (w[0] = _), _ > w[1] && (w[1] = _);
                }
            }
        }
        return r;
    }, Zp.downSample = function(t, e, i, n) {
        for (var r = Ka(this, [ t ]), a = r._storage, o = [], s = Math.floor(1 / e), l = a[t], h = this.count(), u = this._chunkSize, c = r._rawExtent[t], d = new (Xa(this))(h), f = 0, p = 0; p < h; p += s) {
            h - p < s && (s = h - p, o.length = s);
            for (var g = 0; g < s; g++) {
                var m = this.getRawIndex(p + g), v = Math.floor(m / u), y = m % u;
                o[g] = l[v][y];
            }
            var x = i(o), _ = this.getRawIndex(Math.min(p + n(o, x) || 0, h - 1)), w = _ % u;
            (l[Math.floor(_ / u)][w] = x) < c[0] && (c[0] = x), x > c[1] && (c[1] = x), d[f++] = _;
        }
        return r._count = f, r._indices = d, r.getRawIndex = Ya, r;
    }, Zp.getItemModel = function(t) {
        var e = this.hostModel;
        return new Tn(this.getRawDataItem(t), e, e && e.ecModel);
    }, Zp.diff = function(e) {
        var i = this;
        return new Ha(e ? e.getIndices() : [], this.getIndices(), function(t) {
            return Za(e, t);
        }, function(t) {
            return Za(i, t);
        });
    }, Zp.getVisual = function(t) {
        var e = this._visual;
        return e && e[t];
    }, Zp.setVisual = function(t, e) {
        if (Vp(t)) for (var i in t) t.hasOwnProperty(i) && this.setVisual(i, t[i]); else this._visual = this._visual || {}, 
        this._visual[t] = e;
    }, Zp.setLayout = function(t, e) {
        if (Vp(t)) for (var i in t) t.hasOwnProperty(i) && this.setLayout(i, t[i]); else this._layout[t] = e;
    }, Zp.getLayout = function(t) {
        return this._layout[t];
    }, Zp.getItemLayout = function(t) {
        return this._itemLayouts[t];
    }, Zp.setItemLayout = function(t, e, i) {
        this._itemLayouts[t] = i ? A(this._itemLayouts[t] || {}, e) : e;
    }, Zp.clearItemLayouts = function() {
        this._itemLayouts.length = 0;
    }, Zp.getItemVisual = function(t, e, i) {
        var n = this._itemVisuals[t], r = n && n[e];
        return null != r || i ? r : this.getVisual(e);
    }, Zp.setItemVisual = function(t, e, i) {
        var n = this._itemVisuals[t] || {}, r = this.hasItemVisual;
        if (this._itemVisuals[t] = n, Vp(e)) for (var a in e) e.hasOwnProperty(a) && (n[a] = e[a], 
        r[a] = !0); else n[e] = i, r[e] = !0;
    }, Zp.clearAllVisual = function() {
        this._visual = {}, this._itemVisuals = [], this.hasItemVisual = {};
    };
    var $p = function(t) {
        t.seriesIndex = this.seriesIndex, t.dataIndex = this.dataIndex, t.dataType = this.dataType;
    };
    Zp.setItemGraphicEl = function(t, e) {
        var i = this.hostModel;
        e && (e.dataIndex = t, e.dataType = this.dataType, e.seriesIndex = i && i.seriesIndex, 
        "group" === e.type && e.traverse($p, e)), this._graphicEls[t] = e;
    }, Zp.getItemGraphicEl = function(t) {
        return this._graphicEls[t];
    }, Zp.eachItemGraphicEl = function(i, n) {
        R(this._graphicEls, function(t, e) {
            t && i && i.call(n, t, e);
        });
    }, Zp.cloneShallow = function(t) {
        if (!t) {
            var e = D(this.dimensions, this.getDimensionInfo, this);
            t = new Yp(e, this.hostModel);
        }
        if (t._storage = this._storage, qa(t, this), this._indices) {
            var i = this._indices.constructor;
            t._indices = new i(this._indices);
        } else t._indices = null;
        return t.getRawIndex = t._indices ? Ya : Ua, t;
    }, Zp.wrapMethod = function(t, e) {
        var i = this[t];
        "function" == typeof i && (this.__wrappedMethods = this.__wrappedMethods || [], 
        this.__wrappedMethods.push(t), this[t] = function() {
            var t = i.apply(this, arguments);
            return e.apply(this, [ t ].concat(l(arguments)));
        });
    }, Zp.TRANSFERABLE_METHODS = [ "cloneShallow", "downSample", "map" ], Zp.CHANGABLE_METHODS = [ "filterSelf", "selectRange" ];
    var Kp = function(t, e) {
        return Ja((e = e || {}).coordDimensions || [], t, {
            dimsDef: e.dimensionsDefine || t.dimensionsDefine,
            encodeDef: e.encodeDefine || t.encodeDefine,
            dimCount: e.dimensionsCount,
            generateCoord: e.generateCoord,
            generateCoordCount: e.generateCoordCount
        });
    };
    ao.prototype.parse = function(t) {
        return t;
    }, ao.prototype.getSetting = function(t) {
        return this._setting[t];
    }, ao.prototype.contain = function(t) {
        var e = this._extent;
        return t >= e[0] && t <= e[1];
    }, ao.prototype.normalize = function(t) {
        var e = this._extent;
        return e[1] === e[0] ? .5 : (t - e[0]) / (e[1] - e[0]);
    }, ao.prototype.scale = function(t) {
        var e = this._extent;
        return t * (e[1] - e[0]) + e[0];
    }, ao.prototype.unionExtent = function(t) {
        var e = this._extent;
        t[0] < e[0] && (e[0] = t[0]), t[1] > e[1] && (e[1] = t[1]);
    }, ao.prototype.unionExtentFromData = function(t, e) {
        this.unionExtent(t.getApproximateExtent(e));
    }, ao.prototype.getExtent = function() {
        return this._extent.slice();
    }, ao.prototype.setExtent = function(t, e) {
        var i = this._extent;
        isNaN(t) || (i[0] = t), isNaN(e) || (i[1] = e);
    }, ao.prototype.isBlank = function() {
        return this._isBlank;
    }, ao.prototype.setBlank = function(t) {
        this._isBlank = t;
    }, ao.prototype.getLabel = null, si(ao), ci(ao, {
        registerWhenExtend: !0
    }), oo.createByAxisModel = function(t) {
        var e = t.option, i = e.data, n = i && D(i, lo);
        return new oo({
            categories: n,
            needCollect: !n,
            deduplication: !1 !== e.dedplication
        });
    };
    var Qp = oo.prototype;
    Qp.getOrdinal = function(t) {
        return so(this).get(t);
    }, Qp.parseAndCollect = function(t) {
        var e, i = this._needCollect;
        if ("string" != typeof t && !i) return t;
        if (i && !this._deduplication) return e = this.categories.length, this.categories[e] = t, 
        e;
        var n = so(this);
        return null == (e = n.get(t)) && (i ? (e = this.categories.length, this.categories[e] = t, 
        n.set(t, e)) : e = NaN), e;
    };
    var Jp = ao.prototype, tg = ao.extend({
        type: "ordinal",
        init: function(t, e) {
            (!t || P(t)) && (t = new oo({
                categories: t
            })), this._ordinalMeta = t, this._extent = e || [ 0, t.categories.length - 1 ];
        },
        parse: function(t) {
            return "string" == typeof t ? this._ordinalMeta.getOrdinal(t) : Math.round(t);
        },
        contain: function(t) {
            return t = this.parse(t), Jp.contain.call(this, t) && null != this._ordinalMeta.categories[t];
        },
        normalize: function(t) {
            return Jp.normalize.call(this, this.parse(t));
        },
        scale: function(t) {
            return Math.round(Jp.scale.call(this, t));
        },
        getTicks: function() {
            for (var t = [], e = this._extent, i = e[0]; i <= e[1]; ) t.push(i), i++;
            return t;
        },
        getLabel: function(t) {
            return this.isBlank() ? void 0 : this._ordinalMeta.categories[t];
        },
        count: function() {
            return this._extent[1] - this._extent[0] + 1;
        },
        unionExtentFromData: function(t, e) {
            this.unionExtent(t.getApproximateExtent(e));
        },
        getOrdinalMeta: function() {
            return this._ordinalMeta;
        },
        niceTicks: B,
        niceExtent: B
    });
    tg.create = function() {
        return new tg();
    };
    var eg = Ln, ig = Ln, ng = ao.extend({
        type: "interval",
        _interval: 0,
        _intervalPrecision: 2,
        setExtent: function(t, e) {
            var i = this._extent;
            isNaN(t) || (i[0] = parseFloat(t)), isNaN(e) || (i[1] = parseFloat(e));
        },
        unionExtent: function(t) {
            var e = this._extent;
            t[0] < e[0] && (e[0] = t[0]), t[1] > e[1] && (e[1] = t[1]), ng.prototype.setExtent.call(this, e[0], e[1]);
        },
        getInterval: function() {
            return this._interval;
        },
        setInterval: function(t) {
            this._interval = t, this._niceExtent = this._extent.slice(), this._intervalPrecision = ho(t);
        },
        getTicks: function() {
            return function(t, e, i, n) {
                var r = [];
                if (!t) return r;
                e[0] < i[0] && r.push(e[0]);
                for (var a = i[0]; a <= i[1] && (r.push(a), (a = eg(a + t, n)) !== r[r.length - 1]); ) if (1e4 < r.length) return [];
                return e[1] > (r.length ? r[r.length - 1] : i[1]) && r.push(e[1]), r;
            }(this._interval, this._extent, this._niceExtent, this._intervalPrecision);
        },
        getLabel: function(t, e) {
            if (null == t) return "";
            var i = e && e.precision;
            return null == i ? i = On(t) || 0 : "auto" === i && (i = this._intervalPrecision), 
            Hn(t = ig(t, i, !0));
        },
        niceTicks: function(t, e, i) {
            t = t || 5;
            var n = this._extent, r = n[1] - n[0];
            if (isFinite(r)) {
                r < 0 && (r = -r, n.reverse());
                var a = function(t, e, i, n) {
                    var r = {}, a = t[1] - t[0], o = r.interval = Vn(a / e, !0);
                    null != i && o < i && (o = r.interval = i), null != n && n < o && (o = r.interval = n);
                    var s = r.intervalPrecision = ho(o);
                    return co(r.niceTickExtent = [ eg(Math.ceil(t[0] / o) * o, s), eg(Math.floor(t[1] / o) * o, s) ], t), 
                    r;
                }(n, t, e, i);
                this._intervalPrecision = a.intervalPrecision, this._interval = a.interval, this._niceExtent = a.niceTickExtent;
            }
        },
        niceExtent: function(t) {
            var e = this._extent;
            if (e[0] === e[1]) if (0 !== e[0]) {
                var i = e[0];
                t.fixMax || (e[1] += i / 2), e[0] -= i / 2;
            } else e[1] = 1;
            var n = e[1] - e[0];
            isFinite(n) || (e[0] = 0, e[1] = 1), this.niceTicks(t.splitNumber, t.minInterval, t.maxInterval);
            var r = this._interval;
            t.fixMin || (e[0] = ig(Math.floor(e[0] / r) * r)), t.fixMax || (e[1] = ig(Math.ceil(e[1] / r) * r));
        }
    });
    ng.create = function() {
        return new ng();
    };
    var rg = "__ec_stack_", ag = "undefined" != typeof Float32Array ? Float32Array : Array, og = {
        seriesType: "bar",
        plan: Bf(),
        reset: function(t) {
            if (yo(t) && xo(t)) {
                var e = t.getData(), s = t.coordinateSystem, i = s.getBaseAxis(), l = s.getOtherAxis(i), h = e.mapDimension(l.dim), u = e.mapDimension(i.dim), c = l.isHorizontal(), d = c ? 0 : 1, f = vo(mo([ t ]), i, t).width;
                return .5 < f || (f = .5), {
                    progress: function(t, e) {
                        for (var i, n = new ag(2 * t.count), r = [], a = [], o = 0; null != (i = t.next()); ) a[d] = e.get(h, i), 
                        a[1 - d] = e.get(u, i), r = s.dataToPoint(a, null, r), n[o++] = r[0], n[o++] = r[1];
                        e.setLayout({
                            largePoints: n,
                            barWidth: f,
                            valueAxisStart: _o(0, l),
                            valueAxisHorizontal: c
                        });
                    }
                };
            }
        }
    }, sg = ng.prototype, lg = Math.ceil, hg = Math.floor, ug = 36e5, cg = 864e5, dg = ng.extend({
        type: "time",
        getLabel: function(t) {
            var e = this._stepLvl, i = new Date(t);
            return Yn(e[0], i, this.getSetting("useUTC"));
        },
        niceExtent: function(t) {
            var e = this._extent;
            if (e[0] === e[1] && (e[0] -= cg, e[1] += cg), e[1] === -1 / 0 && 1 / 0 === e[0]) {
                var i = new Date();
                e[1] = +new Date(i.getFullYear(), i.getMonth(), i.getDate()), e[0] = e[1] - cg;
            }
            this.niceTicks(t.splitNumber, t.minInterval, t.maxInterval);
            var n = this._interval;
            t.fixMin || (e[0] = Ln(hg(e[0] / n) * n)), t.fixMax || (e[1] = Ln(lg(e[1] / n) * n));
        },
        niceTicks: function(t, e, i) {
            t = t || 10;
            var n = this._extent, r = n[1] - n[0], a = r / t;
            null != e && a < e && (a = e), null != i && i < a && (a = i);
            var o = fg.length, s = function(t, e, i, n) {
                for (;i < n; ) {
                    var r = i + n >>> 1;
                    t[r][1] < e ? i = r + 1 : n = r;
                }
                return i;
            }(fg, a, 0, o), l = fg[Math.min(s, o - 1)], h = l[1];
            "year" === l[0] && (h *= Vn(r / h / t, !0));
            var u = this.getSetting("useUTC") ? 0 : 60 * new Date(+n[0] || +n[1]).getTimezoneOffset() * 1e3, c = [ Math.round(lg((n[0] - u) / h) * h + u), Math.round(hg((n[1] - u) / h) * h + u) ];
            co(c, n), this._stepLvl = l, this._interval = h, this._niceExtent = c;
        },
        parse: function(t) {
            return +Nn(t);
        }
    });
    R([ "contain", "normalize" ], function(e) {
        dg.prototype[e] = function(t) {
            return sg[e].call(this, this.parse(t));
        };
    });
    var fg = [ [ "hh:mm:ss", 1e3 ], [ "hh:mm:ss", 5e3 ], [ "hh:mm:ss", 1e4 ], [ "hh:mm:ss", 15e3 ], [ "hh:mm:ss", 3e4 ], [ "hh:mm\nMM-dd", 6e4 ], [ "hh:mm\nMM-dd", 3e5 ], [ "hh:mm\nMM-dd", 6e5 ], [ "hh:mm\nMM-dd", 9e5 ], [ "hh:mm\nMM-dd", 18e5 ], [ "hh:mm\nMM-dd", ug ], [ "hh:mm\nMM-dd", 72e5 ], [ "hh:mm\nMM-dd", 6 * ug ], [ "hh:mm\nMM-dd", 432e5 ], [ "MM-dd\nyyyy", cg ], [ "MM-dd\nyyyy", 2 * cg ], [ "MM-dd\nyyyy", 3 * cg ], [ "MM-dd\nyyyy", 4 * cg ], [ "MM-dd\nyyyy", 5 * cg ], [ "MM-dd\nyyyy", 6 * cg ], [ "week", 7 * cg ], [ "MM-dd\nyyyy", 864e6 ], [ "week", 14 * cg ], [ "week", 21 * cg ], [ "month", 31 * cg ], [ "week", 42 * cg ], [ "month", 62 * cg ], [ "week", 70 * cg ], [ "quarter", 95 * cg ], [ "month", 31 * cg * 4 ], [ "month", 13392e6 ], [ "half-year", 16416e6 ], [ "month", 31 * cg * 8 ], [ "month", 26784e6 ], [ "year", 380 * cg ] ];
    dg.create = function(t) {
        return new dg({
            useUTC: t.ecModel.get("useUTC")
        });
    };
    var pg = ao.prototype, gg = ng.prototype, mg = On, vg = Ln, yg = Math.floor, xg = Math.ceil, _g = Math.pow, wg = Math.log, bg = ao.extend({
        type: "log",
        base: 10,
        $constructor: function() {
            ao.apply(this, arguments), this._originalScale = new ng();
        },
        getTicks: function() {
            var i = this._originalScale, n = this._extent, r = i.getExtent();
            return D(gg.getTicks.call(this), function(t) {
                var e = Ln(_g(this.base, t));
                return e = t === n[0] && i.__fixMin ? wo(e, r[0]) : e, t === n[1] && i.__fixMax ? wo(e, r[1]) : e;
            }, this);
        },
        getLabel: gg.getLabel,
        scale: function(t) {
            return t = pg.scale.call(this, t), _g(this.base, t);
        },
        setExtent: function(t, e) {
            var i = this.base;
            t = wg(t) / wg(i), e = wg(e) / wg(i), gg.setExtent.call(this, t, e);
        },
        getExtent: function() {
            var t = this.base, e = pg.getExtent.call(this);
            e[0] = _g(t, e[0]), e[1] = _g(t, e[1]);
            var i = this._originalScale, n = i.getExtent();
            return i.__fixMin && (e[0] = wo(e[0], n[0])), i.__fixMax && (e[1] = wo(e[1], n[1])), 
            e;
        },
        unionExtent: function(t) {
            this._originalScale.unionExtent(t);
            var e = this.base;
            t[0] = wg(t[0]) / wg(e), t[1] = wg(t[1]) / wg(e), pg.unionExtent.call(this, t);
        },
        unionExtentFromData: function(t, e) {
            this.unionExtent(t.getApproximateExtent(e));
        },
        niceTicks: function(t) {
            t = t || 10;
            var e = this._extent, i = e[1] - e[0];
            if (!(1 / 0 === i || i <= 0)) {
                var n = Fn(i);
                for (t / i * n <= .5 && (n *= 10); !isNaN(n) && Math.abs(n) < 1 && 0 < Math.abs(n); ) n *= 10;
                var r = [ Ln(xg(e[0] / n) * n), Ln(yg(e[1] / n) * n) ];
                this._interval = n, this._niceExtent = r;
            }
        },
        niceExtent: function(t) {
            gg.niceExtent.call(this, t);
            var e = this._originalScale;
            e.__fixMin = t.fixMin, e.__fixMax = t.fixMax;
        }
    });
    R([ "contain", "normalize" ], function(e) {
        bg.prototype[e] = function(t) {
            return t = wg(t) / wg(this.base), pg[e].call(this, t);
        };
    }), bg.create = function() {
        return new bg();
    };
    var Sg = {
        getMin: function(t) {
            var e = this.option, i = t || null == e.rangeStart ? e.min : e.rangeStart;
            return this.axis && null != i && "dataMin" !== i && "function" != typeof i && !y(i) && (i = this.axis.scale.parse(i)), 
            i;
        },
        getMax: function(t) {
            var e = this.option, i = t || null == e.rangeEnd ? e.max : e.rangeEnd;
            return this.axis && null != i && "dataMax" !== i && "function" != typeof i && !y(i) && (i = this.axis.scale.parse(i)), 
            i;
        },
        getNeedCrossZero: function() {
            var t = this.option;
            return null == t.rangeStart && null == t.rangeEnd && !t.scale;
        },
        getCoordSysModel: B,
        setRange: function(t, e) {
            this.option.rangeStart = t, this.option.rangeEnd = e;
        },
        resetRange: function() {
            this.option.rangeStart = this.option.rangeEnd = null;
        }
    }, Mg = Xi({
        type: "triangle",
        shape: {
            cx: 0,
            cy: 0,
            width: 0,
            height: 0
        },
        buildPath: function(t, e) {
            var i = e.cx, n = e.cy, r = e.width / 2, a = e.height / 2;
            t.moveTo(i, n - a), t.lineTo(i + r, n + a), t.lineTo(i - r, n + a), t.closePath();
        }
    }), Ig = Xi({
        type: "diamond",
        shape: {
            cx: 0,
            cy: 0,
            width: 0,
            height: 0
        },
        buildPath: function(t, e) {
            var i = e.cx, n = e.cy, r = e.width / 2, a = e.height / 2;
            t.moveTo(i, n - a), t.lineTo(i + r, n), t.lineTo(i, n + a), t.lineTo(i - r, n), 
            t.closePath();
        }
    }), Tg = Xi({
        type: "pin",
        shape: {
            x: 0,
            y: 0,
            width: 0,
            height: 0
        },
        buildPath: function(t, e) {
            var i = e.x, n = e.y, r = e.width / 5 * 3, a = Math.max(r, e.height), o = r / 2, s = o * o / (a - o), l = n - a + o + s, h = Math.asin(s / o), u = Math.cos(h) * o, c = Math.sin(h), d = Math.cos(h), f = .6 * o, p = .7 * o;
            t.moveTo(i - u, l + s), t.arc(i, l, o, Math.PI - h, 2 * Math.PI + h), t.bezierCurveTo(i + u - c * f, l + s + d * f, i, n - p, i, n), 
            t.bezierCurveTo(i, n - p, i - u + c * f, l + s + d * f, i - u, l + s), t.closePath();
        }
    }), Cg = Xi({
        type: "arrow",
        shape: {
            x: 0,
            y: 0,
            width: 0,
            height: 0
        },
        buildPath: function(t, e) {
            var i = e.height, n = e.width, r = e.x, a = e.y, o = n / 3 * 2;
            t.moveTo(r, a), t.lineTo(r + o, a + i), t.lineTo(r, a + i / 4 * 3), t.lineTo(r - o, a + i), 
            t.lineTo(r, a), t.closePath();
        }
    }), Dg = {
        line: function(t, e, i, n, r) {
            r.x1 = t, r.y1 = e + n / 2, r.x2 = t + i, r.y2 = e + n / 2;
        },
        rect: function(t, e, i, n, r) {
            r.x = t, r.y = e, r.width = i, r.height = n;
        },
        roundRect: function(t, e, i, n, r) {
            r.x = t, r.y = e, r.width = i, r.height = n, r.r = Math.min(i, n) / 4;
        },
        square: function(t, e, i, n, r) {
            var a = Math.min(i, n);
            r.x = t, r.y = e, r.width = a, r.height = a;
        },
        circle: function(t, e, i, n, r) {
            r.cx = t + i / 2, r.cy = e + n / 2, r.r = Math.min(i, n) / 2;
        },
        diamond: function(t, e, i, n, r) {
            r.cx = t + i / 2, r.cy = e + n / 2, r.width = i, r.height = n;
        },
        pin: function(t, e, i, n, r) {
            r.x = t + i / 2, r.y = e + n / 2, r.width = i, r.height = n;
        },
        arrow: function(t, e, i, n, r) {
            r.x = t + i / 2, r.y = e + n / 2, r.width = i, r.height = n;
        },
        triangle: function(t, e, i, n, r) {
            r.cx = t + i / 2, r.cy = e + n / 2, r.width = i, r.height = n;
        }
    }, Ag = {};
    R({
        line: nd,
        rect: id,
        roundRect: id,
        square: id,
        circle: Zc,
        diamond: Ig,
        pin: Tg,
        arrow: Cg,
        triangle: Mg
    }, function(t, e) {
        Ag[e] = new t();
    });
    var kg = Xi({
        type: "symbol",
        shape: {
            symbolType: "",
            x: 0,
            y: 0,
            width: 0,
            height: 0
        },
        beforeBrush: function() {
            var t = this.style;
            "pin" === this.shape.symbolType && "inside" === t.textPosition && (t.textPosition = [ "50%", "40%" ], 
            t.textAlign = "center", t.textVerticalAlign = "middle");
        },
        buildPath: function(t, e, i) {
            var n = e.symbolType, r = Ag[n];
            "none" !== e.symbolType && (r || (r = Ag[n = "rect"]), Dg[n](e.x, e.y, e.width, e.height, r.shape), 
            r.buildPath(t, r.shape, i));
        }
    }), Pg = {
        isDimensionStacked: io,
        enableDataStack: eo,
        getStackedDimension: no
    }, Lg = (Object.freeze || Object)({
        createList: function(t) {
            return ro(t.getSource(), t);
        },
        getLayoutRect: $n,
        dataStack: Pg,
        createScale: function(t, e) {
            var i = e;
            Tn.isInstance(e) || r(i = new Tn(e), Sg);
            var n = Mo(i);
            return n.setExtent(t[0], t[1]), So(n, i), n;
        },
        mixinAxisModelCommonMethods: function(t) {
            r(t, Sg);
        },
        completeDimensions: Ja,
        createDimensions: Kp,
        createSymbol: Do
    }), Og = 1e-8;
    Po.prototype = {
        constructor: Po,
        properties: null,
        getBoundingRect: function() {
            var t = this._rect;
            if (t) return t;
            for (var e = Number.MAX_VALUE, i = [ e, e ], n = [ -e, -e ], r = [], a = [], o = this.geometries, s = 0; s < o.length; s++) {
                if ("polygon" === o[s].type) bi(o[s].exterior, r, a), K(i, i, r), Q(n, n, a);
            }
            return 0 === s && (i[0] = i[1] = n[0] = n[1] = 0), this._rect = new Yt(i[0], i[1], n[0] - i[0], n[1] - i[1]);
        },
        contain: function(t) {
            var e = this.getBoundingRect(), i = this.geometries;
            if (!e.contain(t[0], t[1])) return !1;
            t: for (var n = 0, r = i.length; n < r; n++) if ("polygon" === i[n].type) {
                var a = i[n].exterior, o = i[n].interiors;
                if (ko(a, t[0], t[1])) {
                    for (var s = 0; s < (o ? o.length : 0); s++) if (ko(o[s])) continue t;
                    return !0;
                }
            }
            return !1;
        },
        transformTo: function(t, e, i, n) {
            var r = this.getBoundingRect(), a = r.width / r.height;
            i ? n || (n = i / a) : i = a * n;
            for (var o = new Yt(t, e, i, n), s = r.calculateTransform(o), l = this.geometries, h = 0; h < l.length; h++) if ("polygon" === l[h].type) {
                for (var u = l[h].exterior, c = l[h].interiors, d = 0; d < u.length; d++) $(u[d], u[d], s);
                for (var f = 0; f < (c ? c.length : 0); f++) for (d = 0; d < c[f].length; d++) $(c[f][d], c[f][d], s);
            }
            (r = this._rect).copy(o), this.center = [ r.x + r.width / 2, r.y + r.height / 2 ];
        },
        cloneShallow: function(t) {
            null == t && (t = this.name);
            var e = new Po(t, this.geometries, this.center);
            return e._rect = this._rect, e.transformTo = null, e;
        }
    };
    var Eg = function(t) {
        return function(t) {
            if (!t.UTF8Encoding) return;
            var e = t.UTF8Scale;
            null == e && (e = 1024);
            for (var i = t.features, n = 0; n < i.length; n++) for (var r = i[n].geometry, a = r.coordinates, o = r.encodeOffsets, s = 0; s < a.length; s++) {
                var l = a[s];
                if ("Polygon" === r.type) a[s] = Lo(l, o[s], e); else if ("MultiPolygon" === r.type) for (var h = 0; h < l.length; h++) {
                    var u = l[h];
                    l[h] = Lo(u, o[s][h], e);
                }
            }
            t.UTF8Encoding = !1;
        }(t), D(u(t.features, function(t) {
            return t.geometry && t.properties && 0 < t.geometry.coordinates.length;
        }), function(t) {
            var e = t.properties, i = t.geometry, n = i.coordinates, r = [];
            "Polygon" === i.type && r.push({
                type: "polygon",
                exterior: n[0],
                interiors: n.slice(1)
            }), "MultiPolygon" === i.type && R(n, function(t) {
                t[0] && r.push({
                    type: "polygon",
                    exterior: t[0],
                    interiors: t.slice(1)
                });
            });
            var a = new Po(e.name, r, e.cp);
            return a.properties = e, a;
        });
    }, zg = ei(), Bg = [ 0, 1 ], Rg = function(t, e, i) {
        this.dim = t, this.scale = e, this._extent = i || [ 0, 0 ], this.inverse = !1, this.onBand = !1;
    };
    Rg.prototype = {
        constructor: Rg,
        contain: function(t) {
            var e = this._extent, i = Math.min(e[0], e[1]), n = Math.max(e[0], e[1]);
            return i <= t && t <= n;
        },
        containData: function(t) {
            return this.contain(this.dataToCoord(t));
        },
        getExtent: function() {
            return this._extent.slice();
        },
        getPixelPrecision: function(t) {
            return En(t || this.scale.getExtent(), this._extent);
        },
        setExtent: function(t, e) {
            var i = this._extent;
            i[0] = t, i[1] = e;
        },
        dataToCoord: function(t, e) {
            var i = this._extent, n = this.scale;
            return t = n.normalize(t), this.onBand && "ordinal" === n.type && Ho(i = i.slice(), n.count()), 
            kn(t, Bg, i, e);
        },
        coordToData: function(t, e) {
            var i = this._extent, n = this.scale;
            this.onBand && "ordinal" === n.type && Ho(i = i.slice(), n.count());
            var r = kn(t, i, Bg, e);
            return this.scale.scale(r);
        },
        pointToData: function() {},
        getTicksCoords: function(t) {
            var e = (t = t || {}).tickModel || this.getTickModel(), i = Eo(this, e), n = D(i.ticks, function(t) {
                return {
                    coord: this.dataToCoord(t),
                    tickValue: t
                };
            }, this), r = e.get("alignWithLabel");
            return function(t, e, i, n, r) {
                function a(t, e) {
                    return u ? e < t : t < e;
                }
                var o = e.length;
                if (t.onBand && !n && o) {
                    var s, l = t.getExtent();
                    if (1 === o) e[0].coord = l[0], s = e[1] = {
                        coord: l[0]
                    }; else {
                        var h = e[1].coord - e[0].coord;
                        R(e, function(t) {
                            t.coord -= h / 2;
                            var e = e || 0;
                            0 < e % 2 && (t.coord -= h / (2 * (e + 1)));
                        }), s = {
                            coord: e[o - 1].coord + h
                        }, e.push(s);
                    }
                    var u = l[0] > l[1];
                    a(e[0].coord, l[0]) && (r ? e[0].coord = l[0] : e.shift()), r && a(l[0], e[0].coord) && e.unshift({
                        coord: l[0]
                    }), a(l[1], s.coord) && (r ? s.coord = l[1] : e.pop()), r && a(s.coord, l[1]) && e.push({
                        coord: l[1]
                    });
                }
            }(this, n, i.tickCategoryInterval, r, t.clamp), n;
        },
        getViewLabels: function() {
            return Oo(this).labels;
        },
        getLabelModel: function() {
            return this.model.getModel("axisLabel");
        },
        getTickModel: function() {
            return this.model.getModel("axisTick");
        },
        getBandWidth: function() {
            var t = this._extent, e = this.scale.getExtent(), i = e[1] - e[0] + (this.onBand ? 1 : 0);
            0 === i && (i = 1);
            var n = Math.abs(t[1] - t[0]);
            return Math.abs(n) / i;
        },
        isHorizontal: null,
        getRotate: null,
        calculateCategoryInterval: function() {
            return function(t) {
                var e, i, n = (i = (e = t).getLabelModel(), {
                    axisRotate: e.getRotate ? e.getRotate() : e.isHorizontal && !e.isHorizontal() ? 90 : 0,
                    labelRotate: i.get("rotate") || 0,
                    font: i.getFont()
                }), r = Io(t), a = (n.axisRotate - n.labelRotate) / 180 * Math.PI, o = t.scale, s = o.getExtent(), l = o.count();
                if (s[1] - s[0] < 1) return 0;
                var h = 1;
                40 < l && (h = Math.max(1, Math.floor(l / 40)));
                for (var u = s[0], c = t.dataToCoord(u + 1) - t.dataToCoord(u), d = Math.abs(c * Math.cos(a)), f = Math.abs(c * Math.sin(a)), p = 0, g = 0; u <= s[1]; u += h) {
                    var m, v, y = ce(r(u), n.font, "center", "top");
                    m = 1.3 * y.width, v = 1.3 * y.height, p = Math.max(p, m, 7), g = Math.max(g, v, 7);
                }
                var x = p / d, _ = g / f;
                isNaN(x) && (x = 1 / 0), isNaN(_) && (_ = 1 / 0);
                var w = Math.max(0, Math.floor(Math.min(x, _))), b = zg(t.model), S = b.lastAutoInterval, M = b.lastTickCount;
                return null != S && null != M && Math.abs(S - w) <= 1 && Math.abs(M - l) <= 1 && w < S ? w = S : (b.lastTickCount = l, 
                b.lastAutoInterval = w), w;
            }(this);
        }
    };
    var Ng = Eg, Fg = {};
    R([ "map", "each", "filter", "indexOf", "inherits", "reduce", "filter", "bind", "curry", "isArray", "isString", "isObject", "isFunction", "extend", "defaults", "clone", "merge" ], function(t) {
        Fg[t] = jl[t];
    });
    var Gg = {};
    R([ "extendShape", "extendPath", "makePath", "makeImage", "mergePath", "resizePath", "createIcon", "setHoverStyle", "setLabelStyle", "setTextStyle", "setText", "getFont", "updateProps", "initProps", "getTransform", "clipPointsByRect", "clipRectByRect", "Group", "Image", "Text", "Circle", "Sector", "Ring", "Polygon", "Polyline", "Rect", "Line", "BezierCurve", "Arc", "IncrementalDisplayable", "CompoundPath", "LinearGradient", "RadialGradient", "BoundingRect" ], function(t) {
        Gg[t] = xd[t];
    });
    var Vg = function(t) {
        this._axes = {}, this._dimList = [], this.name = t || "";
    };
    Vg.prototype = {
        constructor: Vg,
        type: "cartesian",
        getAxis: function(t) {
            return this._axes[t];
        },
        getAxes: function() {
            return D(this._dimList, Wo, this);
        },
        getAxesByScale: function(e) {
            return e = e.toLowerCase(), u(this.getAxes(), function(t) {
                return t.scale.type === e;
            });
        },
        addAxis: function(t) {
            var e = t.dim;
            this._axes[e] = t, this._dimList.push(e);
        },
        dataToCoord: function(t) {
            return this._dataCoordConvert(t, "dataToCoord");
        },
        coordToData: function(t) {
            return this._dataCoordConvert(t, "coordToData");
        },
        _dataCoordConvert: function(t, e) {
            for (var i = this._dimList, n = t instanceof Array ? [] : {}, r = 0; r < i.length; r++) {
                var a = i[r], o = this._axes[a];
                n[a] = o[e](t[a]);
            }
            return n;
        }
    }, Xo.prototype = {
        constructor: Xo,
        type: "cartesian2d",
        dimensions: [ "x", "y" ],
        getBaseAxis: function() {
            return this.getAxesByScale("ordinal")[0] || this.getAxesByScale("time")[0] || this.getAxis("x");
        },
        containPoint: function(t) {
            var e = this.getAxis("x"), i = this.getAxis("y");
            return e.contain(e.toLocalCoord(t[0])) && i.contain(i.toLocalCoord(t[1]));
        },
        containData: function(t) {
            return this.getAxis("x").containData(t[0]) && this.getAxis("y").containData(t[1]);
        },
        dataToPoint: function(t, e, i) {
            var n = this.getAxis("x"), r = this.getAxis("y");
            return (i = i || [])[0] = n.toGlobalCoord(n.dataToCoord(t[0])), i[1] = r.toGlobalCoord(r.dataToCoord(t[1])), 
            i;
        },
        clampData: function(t, e) {
            var i = this.getAxis("x").scale, n = this.getAxis("y").scale, r = i.getExtent(), a = n.getExtent(), o = i.parse(t[0]), s = n.parse(t[1]);
            return (e = e || [])[0] = Math.min(Math.max(Math.min(r[0], r[1]), o), Math.max(r[0], r[1])), 
            e[1] = Math.min(Math.max(Math.min(a[0], a[1]), s), Math.max(a[0], a[1])), e;
        },
        pointToData: function(t, e) {
            var i = this.getAxis("x"), n = this.getAxis("y");
            return (e = e || [])[0] = i.coordToData(i.toLocalCoord(t[0])), e[1] = n.coordToData(n.toLocalCoord(t[1])), 
            e;
        },
        getOtherAxis: function(t) {
            return this.getAxis("x" === t.dim ? "y" : "x");
        }
    }, a(Xo, Vg);
    var Hg = function(t, e, i, n, r) {
        Rg.call(this, t, e, i), this.type = n || "value", this.position = r || "bottom";
    };
    Hg.prototype = {
        constructor: Hg,
        index: 0,
        getAxesOnZeroOf: null,
        model: null,
        isHorizontal: function() {
            var t = this.position;
            return "top" === t || "bottom" === t;
        },
        getGlobalExtent: function(t) {
            var e = this.getExtent();
            return e[0] = this.toGlobalCoord(e[0]), e[1] = this.toGlobalCoord(e[1]), t && e[0] > e[1] && e.reverse(), 
            e;
        },
        getOtherAxis: function() {
            this.grid.getOtherAxis();
        },
        pointToData: function(t, e) {
            return this.coordToData(this.toLocalCoord(t["x" === this.dim ? 0 : 1]), e);
        },
        toLocalCoord: null,
        toGlobalCoord: null
    }, a(Hg, Rg);
    var Wg = {
        show: !0,
        zlevel: 0,
        z: 0,
        inverse: !1,
        name: "",
        nameLocation: "end",
        nameRotate: null,
        nameTruncate: {
            maxWidth: null,
            ellipsis: "...",
            placeholder: "."
        },
        nameTextStyle: {},
        nameGap: 15,
        silent: !1,
        triggerEvent: !1,
        tooltip: {
            show: !1
        },
        axisPointer: {},
        axisLine: {
            show: !0,
            onZero: !0,
            onZeroAxisIndex: null,
            lineStyle: {
                color: "#333",
                width: 1,
                type: "solid"
            },
            symbol: [ "none", "none" ],
            symbolSize: [ 10, 15 ]
        },
        axisTick: {
            show: !0,
            inside: !1,
            length: 5,
            lineStyle: {
                width: 1
            }
        },
        axisLabel: {
            show: !0,
            inside: !1,
            rotate: 0,
            showMinLabel: null,
            showMaxLabel: null,
            margin: 8,
            fontSize: 12
        },
        splitLine: {
            show: !0,
            lineStyle: {
                color: [ "#ccc" ],
                width: 1,
                type: "solid"
            }
        },
        splitArea: {
            show: !1,
            areaStyle: {
                color: [ "rgba(250,250,250,0.3)", "rgba(200,200,200,0.3)" ]
            }
        }
    }, Xg = {};
    Xg.categoryAxis = m({
        boundaryGap: !0,
        deduplication: null,
        splitLine: {
            show: !1
        },
        axisTick: {
            alignWithLabel: !1,
            interval: "auto"
        },
        axisLabel: {
            interval: "auto"
        }
    }, Wg), Xg.valueAxis = m({
        boundaryGap: [ 0, 0 ],
        splitNumber: 5
    }, Wg), Xg.timeAxis = C({
        scale: !0,
        min: "dataMin",
        max: "dataMax"
    }, Xg.valueAxis), Xg.logAxis = C({
        scale: !0,
        logBase: 10
    }, Xg.valueAxis);
    var qg = [ "value", "category", "time", "log" ], jg = function(a, t, o, e) {
        R(qg, function(r) {
            t.extend({
                type: a + "Axis." + r,
                mergeDefaultAndTheme: function(t, e) {
                    var i = this.layoutMode, n = i ? Qn(t) : {};
                    m(t, e.getTheme().get(r + "Axis")), m(t, this.getDefaultOption()), t.type = o(a, t), 
                    i && Kn(t, n, i);
                },
                optionUpdated: function() {
                    "category" === this.option.type && (this.__ordinalMeta = oo.createByAxisModel(this));
                },
                getCategories: function(t) {
                    var e = this.option;
                    return "category" === e.type ? t ? e.data : this.__ordinalMeta.categories : void 0;
                },
                getOrdinalMeta: function() {
                    return this.__ordinalMeta;
                },
                defaultOption: i([ {}, Xg[r + "Axis"], e ], !0)
            });
        }), jd.registerSubTypeDefaulter(a + "Axis", g(o, a));
    }, Ug = jd.extend({
        type: "cartesian2dAxis",
        axis: null,
        init: function() {
            Ug.superApply(this, "init", arguments), this.resetRange();
        },
        mergeOption: function() {
            Ug.superApply(this, "mergeOption", arguments), this.resetRange();
        },
        restoreData: function() {
            Ug.superApply(this, "restoreData", arguments), this.resetRange();
        },
        getCoordSysModel: function() {
            return this.ecModel.queryComponents({
                mainType: "grid",
                index: this.option.gridIndex,
                id: this.option.gridId
            })[0];
        }
    });
    m(Ug.prototype, Sg);
    var Yg = {
        offset: 0
    };
    jg("x", Ug, qo, Yg), jg("y", Ug, qo, Yg), jd.extend({
        type: "grid",
        dependencies: [ "xAxis", "yAxis" ],
        layoutMode: "box",
        coordinateSystem: null,
        defaultOption: {
            show: !1,
            zlevel: 0,
            z: 0,
            left: "10%",
            top: 60,
            right: "10%",
            bottom: 60,
            containLabel: !1,
            backgroundColor: "rgba(0,0,0,0)",
            borderWidth: 1,
            borderColor: "#ccc"
        }
    });
    var Zg = Uo.prototype;
    Zg.type = "grid", Zg.axisPointerEnabled = !0, Zg.getRect = function() {
        return this._rect;
    }, Zg.update = function(t, e) {
        var i = this._axesMap;
        this._updateScale(t, this.model), R(i.x, function(t) {
            So(t.scale, t.model);
        }), R(i.y, function(t) {
            So(t.scale, t.model);
        });
        var n = {};
        R(i.x, function(t) {
            Yo(i, "y", t, n);
        }), R(i.y, function(t) {
            Yo(i, "x", t, n);
        }), this.resize(this.model, e);
    }, Zg.resize = function(t, e, i) {
        function n() {
            R(r, function(t) {
                var e, i, n, r, a = t.isHorizontal(), o = a ? [ 0, l.width ] : [ 0, l.height ], s = t.inverse ? 1 : 0;
                t.setExtent(o[s], o[1 - s]), e = t, i = a ? l.x : l.y, n = e.getExtent(), r = n[0] + n[1], 
                e.toGlobalCoord = "x" === e.dim ? function(t) {
                    return t + i;
                } : function(t) {
                    return r - t + i;
                }, e.toLocalCoord = "x" === e.dim ? function(t) {
                    return t - i;
                } : function(t) {
                    return r - t + i;
                };
            });
        }
        var l = $n(t.getBoxLayoutParams(), {
            width: e.getWidth(),
            height: e.getHeight()
        });
        this._rect = l;
        var r = this._axesList;
        n(), !i && t.get("containLabel") && (R(r, function(t) {
            if (!t.model.get("axisLabel.inside")) {
                var e = function(t) {
                    var e, i, n, r, a, o, s, l, h = t.model, u = t.scale;
                    if (h.get("axisLabel.show") && !u.isBlank()) {
                        var c, d, f = "category" === t.type, p = u.getExtent();
                        d = f ? u.count() : (c = u.getTicks()).length;
                        var g, m = t.getLabelModel(), v = Io(t), y = 1;
                        40 < d && (y = Math.ceil(d / 40));
                        for (var x = 0; x < d; x += y) {
                            var _ = v(c ? c[x] : p[0] + x), w = m.getTextRect(_), b = (e = w, i = m.get("rotate") || 0, 
                            n = i * Math.PI / 180, r = e.plain(), a = r.width, o = r.height, s = a * Math.cos(n) + o * Math.sin(n), 
                            l = a * Math.sin(n) + o * Math.cos(n), new Yt(r.x, r.y, s, l));
                            g ? g.union(b) : g = b;
                        }
                        return g;
                    }
                }(t);
                if (e) {
                    var i = t.isHorizontal() ? "height" : "width", n = t.model.get("axisLabel.margin");
                    l[i] -= e[i] + n, "top" === t.position ? l.y += e.height + n : "left" === t.position && (l.x += e.width + n);
                }
            }
        }), n());
    }, Zg.getAxis = function(t, e) {
        var i = this._axesMap[t];
        if (null != i) {
            if (null == e) for (var n in i) if (i.hasOwnProperty(n)) return i[n];
            return i[e];
        }
    }, Zg.getAxes = function() {
        return this._axesList.slice();
    }, Zg.getCartesian = function(t, e) {
        if (null != t && null != e) {
            var i = "x" + t + "y" + e;
            return this._coordsMap[i];
        }
        L(t) && (e = t.yAxisIndex, t = t.xAxisIndex);
        for (var n = 0, r = this._coordsList; n < r.length; n++) if (r[n].getAxis("x").index === t || r[n].getAxis("y").index === e) return r[n];
    }, Zg.getCartesians = function() {
        return this._coordsList.slice();
    }, Zg.convertToPixel = function(t, e, i) {
        var n = this._findConvertTarget(t, e);
        return n.cartesian ? n.cartesian.dataToPoint(i) : n.axis ? n.axis.toGlobalCoord(n.axis.dataToCoord(i)) : null;
    }, Zg.convertFromPixel = function(t, e, i) {
        var n = this._findConvertTarget(t, e);
        return n.cartesian ? n.cartesian.pointToData(i) : n.axis ? n.axis.coordToData(n.axis.toLocalCoord(i)) : null;
    }, Zg._findConvertTarget = function(t, e) {
        var i, n, r = e.seriesModel, a = e.xAxisModel || r && r.getReferringComponents("xAxis")[0], o = e.yAxisModel || r && r.getReferringComponents("yAxis")[0], s = e.gridModel, l = this._coordsList;
        if (r) d(l, i = r.coordinateSystem) < 0 && (i = null); else if (a && o) i = this.getCartesian(a.componentIndex, o.componentIndex); else if (a) n = this.getAxis("x", a.componentIndex); else if (o) n = this.getAxis("y", o.componentIndex); else if (s) {
            s.coordinateSystem === this && (i = this._coordsList[0]);
        }
        return {
            cartesian: i,
            axis: n
        };
    }, Zg.containPoint = function(t) {
        var e = this._coordsList[0];
        return e ? e.containPoint(t) : void 0;
    }, Zg._initCartesian = function(o, t) {
        function e(a) {
            return function(t, e) {
                if (jo(t, o)) {
                    var i = t.get("position");
                    "x" === a ? "top" !== i && "bottom" !== i && (s[i = "bottom"] && (i = "top" === i ? "bottom" : "top")) : "left" !== i && "right" !== i && (s[i = "left"] && (i = "left" === i ? "right" : "left")), 
                    s[i] = !0;
                    var n = new Hg(a, Mo(t), [ 0, 0 ], t.get("type"), i), r = "category" === n.type;
                    n.onBand = r && t.get("boundaryGap"), n.inverse = t.get("inverse"), (t.axis = n).model = t, 
                    n.grid = this, n.index = e, this._axesList.push(n), l[a][e] = n, h[a]++;
                }
            };
        }
        var s = {
            left: !1,
            right: !1,
            top: !1,
            bottom: !1
        }, l = {
            x: {},
            y: {}
        }, h = {
            x: 0,
            y: 0
        };
        return t.eachComponent("xAxis", e("x"), this), t.eachComponent("yAxis", e("y"), this), 
        h.x && h.y ? void R((this._axesMap = l).x, function(r, a) {
            R(l.y, function(t, e) {
                var i = "x" + a + "y" + e, n = new Xo(i);
                n.grid = this, n.model = o, this._coordsMap[i] = n, this._coordsList.push(n), n.addAxis(r), 
                n.addAxis(t);
            }, this);
        }, this) : (this._axesMap = {}, void (this._axesList = []));
    }, Zg._updateScale = function(t, l) {
        function h(e, i) {
            R(e.mapDimension(i.dim, !0), function(t) {
                i.scale.unionExtentFromData(e, no(e, t));
            });
        }
        R(this._axesList, function(t) {
            t.scale.setExtent(1 / 0, -1 / 0);
        }), t.eachSeries(function(t) {
            if (Ko(t)) {
                var e = $o(t), i = e[0], n = e[1];
                if (!jo(i, l) || !jo(n, l)) return;
                var r = this.getCartesian(i.componentIndex, n.componentIndex), a = t.getData(), o = r.getAxis("x"), s = r.getAxis("y");
                "list" === a.type && (h(a, o), h(a, s));
            }
        }, this);
    }, Zg.getTooltipAxes = function(n) {
        var r = [], a = [];
        return R(this.getCartesians(), function(t) {
            var e = null != n && "auto" !== n ? t.getAxis(n) : t.getBaseAxis(), i = t.getOtherAxis(e);
            d(r, e) < 0 && r.push(e), d(a, i) < 0 && a.push(i);
        }), {
            baseAxes: r,
            otherAxes: a
        };
    };
    var $g = [ "xAxis", "yAxis" ];
    Uo.create = function(n, r) {
        var a = [];
        return n.eachComponent("grid", function(t, e) {
            var i = new Uo(t, n, r);
            i.name = "grid_" + e, i.resize(t, r, !0), t.coordinateSystem = i, a.push(i);
        }), n.eachSeries(function(t) {
            if (Ko(t)) {
                var e = $o(t), i = e[0], n = e[1], r = i.getCoordSysModel().coordinateSystem;
                t.coordinateSystem = r.getCartesian(i.componentIndex, n.componentIndex);
            }
        }), a;
    }, Uo.dimensions = Uo.prototype.dimensions = Xo.prototype.dimensions, ur.register("cartesian2d", Uo), 
    Of.extend({
        type: "series.__base_bar__",
        getInitialData: function() {
            return ro(this.getSource(), this);
        },
        getMarkerPosition: function(t) {
            var e = this.coordinateSystem;
            if (e) {
                var i = e.dataToPoint(e.clampData(t)), n = this.getData(), r = n.getLayout("offset"), a = n.getLayout("size");
                return i[e.getBaseAxis().isHorizontal() ? 0 : 1] += r + a / 2, i;
            }
            return [ NaN, NaN ];
        },
        defaultOption: {
            zlevel: 0,
            z: 2,
            coordinateSystem: "cartesian2d",
            legendHoverLink: !0,
            barMinHeight: 0,
            barMinAngle: 0,
            large: !1,
            largeThreshold: 400,
            progressive: 3e3,
            progressiveChunkMode: "mod",
            itemStyle: {},
            emphasis: {}
        }
    }).extend({
        type: "series.bar",
        dependencies: [ "grid", "polar" ],
        brushSelector: "rect",
        getProgressive: function() {
            return !!this.get("large") && this.get("progressive");
        },
        getProgressiveThreshold: function() {
            var t = this.get("progressiveThreshold"), e = this.get("largeThreshold");
            return t < e && (t = e), t;
        }
    });
    var Kg = Vu([ [ "fill", "color" ], [ "stroke", "borderColor" ], [ "lineWidth", "borderWidth" ], [ "stroke", "barBorderColor" ], [ "lineWidth", "barBorderWidth" ], [ "opacity" ], [ "shadowBlur" ], [ "shadowOffsetX" ], [ "shadowOffsetY" ], [ "shadowColor" ] ]), Qg = [ "itemStyle", "barBorderWidth" ];
    A(Tn.prototype, {
        getBarItemStyle: function(t) {
            var e = Kg(this, t);
            if (this.getBorderLineDash) {
                var i = this.getBorderLineDash();
                i && (e.lineDash = i);
            }
            return e;
        }
    }), Ga({
        type: "bar",
        render: function(t, e, i) {
            this._updateDrawMode(t);
            var n = t.get("coordinateSystem");
            return ("cartesian2d" === n || "polar" === n) && (this._isLargeDraw ? this._renderLarge(t, e, i) : this._renderNormal(t, e, i)), 
            this.group;
        },
        incrementalPrepareRender: function(t) {
            this._clear(), this._updateDrawMode(t);
        },
        incrementalRender: function(t, e) {
            this._incrementalRenderLarge(t, e);
        },
        _updateDrawMode: function(t) {
            var e = t.pipelineContext.large;
            (null == this._isLargeDraw || e ^ this._isLargeDraw) && (this._isLargeDraw = e, 
            this._clear());
        },
        _renderNormal: function(a) {
            var o, s = this.group, l = a.getData(), h = this._data, u = a.coordinateSystem, t = u.getBaseAxis();
            "cartesian2d" === u.type ? o = t.isHorizontal() : "polar" === u.type && (o = "angle" === t.dim);
            var c = a.isAnimationEnabled() ? a : null;
            l.diff(h).add(function(t) {
                if (l.hasValue(t)) {
                    var e = l.getItemModel(t), i = tm[u.type](l, t, e), n = Jg[u.type](l, t, e, i, o, c);
                    l.setItemGraphicEl(t, n), s.add(n), is(n, l, t, e, i, a, o, "polar" === u.type);
                }
            }).update(function(t, e) {
                var i = h.getItemGraphicEl(e);
                if (l.hasValue(t)) {
                    var n = l.getItemModel(t), r = tm[u.type](l, t, n);
                    i ? wn(i, {
                        shape: r
                    }, c, t) : i = Jg[u.type](l, t, n, r, o, c, !0), l.setItemGraphicEl(t, i), s.add(i), 
                    is(i, l, t, n, r, a, o, "polar" === u.type);
                } else s.remove(i);
            }).remove(function(t) {
                var e = h.getItemGraphicEl(t);
                "cartesian2d" === u.type ? e && ts(t, c, e) : e && es(t, c, e);
            }).execute(), this._data = l;
        },
        _renderLarge: function(t) {
            this._clear(), ns(t, this.group);
        },
        _incrementalRenderLarge: function(t, e) {
            ns(e, this.group, !0);
        },
        dispose: B,
        remove: function(t) {
            this._clear(t);
        },
        _clear: function(e) {
            var t = this.group, i = this._data;
            e && e.get("animation") && i && !this._isLargeDraw ? i.eachItemGraphicEl(function(t) {
                "sector" === t.type ? es(t.dataIndex, e, t) : ts(t.dataIndex, e, t);
            }) : t.removeAll(), this._data = null;
        }
    });
    var Jg = {
        cartesian2d: function(t, e, i, n, r, a, o) {
            var s = new id({
                shape: A({}, n)
            });
            if (a) {
                var l = r ? "height" : "width", h = {};
                s.shape[l] = 0, h[l] = n[l], xd[o ? "updateProps" : "initProps"](s, {
                    shape: h
                }, a, e);
            }
            return s;
        },
        polar: function(t, e, i, n, r, a, o) {
            var s = n.startAngle < n.endAngle, l = new Qc({
                shape: C({
                    clockwise: s
                }, n)
            });
            if (a) {
                var h = r ? "r" : "endAngle", u = {};
                l.shape[h] = r ? 0 : n.startAngle, u[h] = n[h], xd[o ? "updateProps" : "initProps"](l, {
                    shape: u
                }, a, e);
            }
            return l;
        }
    }, tm = {
        cartesian2d: function(t, e, i) {
            var n, r, a = t.getItemLayout(e), o = (n = a, r = i.get(Qg) || 0, Math.min(r, Math.abs(n.width), Math.abs(n.height))), s = 0 < a.width ? 1 : -1, l = 0 < a.height ? 1 : -1;
            return {
                x: a.x + s * o / 2,
                y: a.y + l * o / 2,
                width: a.width - s * o,
                height: a.height - l * o
            };
        },
        polar: function(t, e) {
            var i = t.getItemLayout(e);
            return {
                cx: i.cx,
                cy: i.cy,
                r0: i.r0,
                r: i.r,
                startAngle: i.startAngle,
                endAngle: i.endAngle
            };
        }
    }, em = Bi.extend({
        type: "largeBar",
        shape: {
            points: []
        },
        buildPath: function(t, e) {
            for (var i = e.points, n = this.__startPoint, r = this.__valueIdx, a = 0; a < i.length; a += 2) n[this.__valueIdx] = i[a + r], 
            t.moveTo(n[0], n[1]), t.lineTo(i[a], i[a + 1]);
        }
    }), im = Math.PI, nm = function(t, e) {
        this.opt = e, this.axisModel = t, C(e, {
            labelOffset: 0,
            nameDirection: 1,
            tickDirection: 1,
            labelDirection: 1,
            silent: !0
        }), this.group = new Hh();
        var i = new Hh({
            position: e.position.slice(),
            rotation: e.rotation
        });
        i.updateTransform(), this._transform = i.transform, this._dumbGroup = i;
    };
    nm.prototype = {
        constructor: nm,
        hasBuilder: function(t) {
            return !!rm[t];
        },
        add: function(t) {
            rm[t].call(this);
        },
        getGroup: function() {
            return this.group;
        }
    };
    var rm = {
        axisLine: function() {
            var a = this.opt, t = this.axisModel;
            if (t.get("axisLine.show")) {
                var e = this.axisModel.axis.getExtent(), i = this._transform, o = [ e[0], 0 ], n = [ e[1], 0 ];
                i && ($(o, o, i), $(n, n, i));
                var s = A({
                    lineCap: "round"
                }, t.getModel("axisLine.lineStyle").getLineStyle());
                this.group.add(new nd(Zi({
                    anid: "line",
                    shape: {
                        x1: o[0],
                        y1: o[1],
                        x2: n[0],
                        y2: n[1]
                    },
                    style: s,
                    strokeContainThreshold: a.strokeContainThreshold || 5,
                    silent: !0,
                    z2: 1
                })));
                var l = t.get("axisLine.symbol"), r = t.get("axisLine.symbolSize"), h = t.get("axisLine.symbolOffset") || 0;
                if ("number" == typeof h && (h = [ h, h ]), null != l) {
                    "string" == typeof l && (l = [ l, l ]), ("string" == typeof r || "number" == typeof r) && (r = [ r, r ]);
                    var u = r[0], c = r[1];
                    R([ {
                        rotate: a.rotation + Math.PI / 2,
                        offset: h[0],
                        r: 0
                    }, {
                        rotate: a.rotation - Math.PI / 2,
                        offset: h[1],
                        r: Math.sqrt((o[0] - n[0]) * (o[0] - n[0]) + (o[1] - n[1]) * (o[1] - n[1]))
                    } ], function(t, e) {
                        if ("none" !== l[e] && null != l[e]) {
                            var i = Do(l[e], -u / 2, -c / 2, u, c, s.stroke, !0), n = t.r + t.offset, r = [ o[0] + n * Math.cos(a.rotation), o[1] - n * Math.sin(a.rotation) ];
                            i.attr({
                                rotation: t.rotate,
                                position: r,
                                silent: !0
                            }), this.group.add(i);
                        }
                    }, this);
                }
            }
        },
        axisTickLabel: function() {
            var t = this.axisModel, e = this.opt, i = function(t, e, i) {
                var n = e.axis;
                if (e.get("axisTick.show") && !n.scale.isBlank()) {
                    for (var r = e.getModel("axisTick"), a = r.getModel("lineStyle"), o = r.get("length"), s = n.getTicksCoords(), l = [], h = [], u = t._transform, c = [], d = 0; d < s.length; d++) {
                        var f = s[d].coord;
                        l[0] = f, h[l[1] = 0] = f, h[1] = i.tickDirection * o, u && ($(l, l, u), $(h, h, u));
                        var p = new nd(Zi({
                            anid: "tick_" + s[d].tickValue,
                            shape: {
                                x1: l[0],
                                y1: l[1],
                                x2: h[0],
                                y2: h[1]
                            },
                            style: C(a.getLineStyle(), {
                                stroke: e.get("axisLine.lineStyle.color")
                            }),
                            z2: 2,
                            silent: !0
                        }));
                        t.group.add(p), c.push(p);
                    }
                    return c;
                }
            }(this, t, e);
            !function(t, e, i) {
                var n = t.get("axisLabel.showMinLabel"), r = t.get("axisLabel.showMaxLabel");
                i = i || [];
                var a = (e = e || [])[0], o = e[1], s = e[e.length - 1], l = e[e.length - 2], h = i[0], u = i[1], c = i[i.length - 1], d = i[i.length - 2];
                !1 === n ? (os(a), os(h)) : ss(a, o) && (n ? (os(o), os(u)) : (os(a), os(h))), !1 === r ? (os(s), 
                os(c)) : ss(l, s) && (r ? (os(l), os(d)) : (os(s), os(c)));
            }(t, function(h, u, c) {
                var d = u.axis;
                if (k(c.axisLabelShow, u.get("axisLabel.show")) && !d.scale.isBlank()) {
                    var f = u.getModel("axisLabel"), p = f.get("margin"), t = d.getViewLabels(), e = (k(c.labelRotate, f.get("rotate")) || 0) * im / 180, g = am(c.rotation, e, c.labelDirection), m = u.getCategories(!0), v = [], y = as(u), x = u.get("triggerEvent");
                    return R(t, function(t, e) {
                        var i = t.tickValue, n = t.formattedLabel, r = t.rawLabel, a = f;
                        m && m[i] && m[i].textStyle && (a = new Tn(m[i].textStyle, f, u.ecModel));
                        var o = a.getTextColor() || u.get("axisLine.lineStyle.color"), s = [ d.dataToCoord(i), c.labelOffset + c.labelDirection * p ], l = new Yc({
                            anid: "label_" + i,
                            position: s,
                            rotation: g.rotation,
                            silent: y,
                            z2: 10
                        });
                        fn(l.style, a, {
                            text: n,
                            textAlign: a.getShallow("align", !0) || g.textAlign,
                            textVerticalAlign: a.getShallow("verticalAlign", !0) || a.getShallow("baseline", !0) || g.textVerticalAlign,
                            textFill: "function" == typeof o ? o("category" === d.type ? r : "value" === d.type ? i + "" : i, e) : o
                        }), x && (l.eventData = rs(u), l.eventData.targetType = "axisLabel", l.eventData.value = r), 
                        h._dumbGroup.add(l), l.updateTransform(), v.push(l), h.group.add(l), l.decomposeTransform();
                    }), v;
                }
            }(this, t, e), i);
        },
        axisName: function() {
            var t, e, i, n, r, a, o, s = this.opt, l = this.axisModel, h = k(s.axisName, l.get("name"));
            if (h) {
                var u, c, d = l.get("nameLocation"), f = s.nameDirection, p = l.getModel("nameTextStyle"), g = l.get("nameGap") || 0, m = this.axisModel.axis.getExtent(), v = m[0] > m[1] ? -1 : 1, y = [ "start" === d ? m[0] - v * g : "end" === d ? m[1] + v * g : (m[0] + m[1]) / 2, ls(d) ? s.labelOffset + f * g : 0 ], x = l.get("nameRotate");
                null != x && (x = x * im / 180), ls(d) ? u = am(s.rotation, null != x ? x : s.rotation, f) : (t = d, 
                e = m, r = Bn((x || 0) - s.rotation), a = e[0] > e[1], o = "start" === t && !a || "start" !== t && a, 
                Rn(r - im / 2) ? (n = o ? "bottom" : "top", i = "center") : Rn(r - 1.5 * im) ? (n = o ? "top" : "bottom", 
                i = "center") : (n = "middle", i = r < 1.5 * im && im / 2 < r ? o ? "left" : "right" : o ? "right" : "left"), 
                u = {
                    rotation: r,
                    textAlign: i,
                    textVerticalAlign: n
                }, null != (c = s.axisNameAvailableWidth) && (c = Math.abs(c / Math.sin(u.rotation)), 
                !isFinite(c) && (c = null)));
                var _ = p.getFont(), w = l.get("nameTruncate", !0) || {}, b = w.ellipsis, S = k(s.nameTruncateMaxWidth, w.maxWidth, c), M = null != b && null != S ? Rd(h, S, _, b, {
                    minChar: 2,
                    placeholder: w.placeholder
                }) : h, I = l.get("tooltip", !0), T = l.mainType, C = {
                    componentType: T,
                    name: h,
                    $vars: [ "name" ]
                };
                C[T + "Index"] = l.componentIndex;
                var D = new Yc({
                    anid: "name",
                    __fullText: h,
                    __truncatedText: M,
                    position: y,
                    rotation: u.rotation,
                    silent: as(l),
                    z2: 1,
                    tooltip: I && I.show ? A({
                        content: h,
                        formatter: function() {
                            return h;
                        },
                        formatterParams: C
                    }, I) : null
                });
                fn(D.style, p, {
                    text: M,
                    textFont: _,
                    textFill: p.getTextColor() || l.get("axisLine.lineStyle.color"),
                    textAlign: u.textAlign,
                    textVerticalAlign: u.textVerticalAlign
                }), l.get("triggerEvent") && (D.eventData = rs(l), D.eventData.targetType = "axisName", 
                D.eventData.name = h), this._dumbGroup.add(D), D.updateTransform(), this.group.add(D), 
                D.decomposeTransform();
            }
        }
    }, am = nm.innerTextLayout = function(t, e, i) {
        var n, r, a = Bn(e - t);
        return Rn(a) ? (r = 0 < i ? "top" : "bottom", n = "center") : Rn(a - im) ? (r = 0 < i ? "bottom" : "top", 
        n = "center") : (r = "middle", n = 0 < a && a < im ? 0 < i ? "right" : "left" : 0 < i ? "left" : "right"), 
        {
            rotation: a,
            textAlign: n,
            textVerticalAlign: r
        };
    }, om = R, sm = g, lm = Na({
        type: "axis",
        _axisPointer: null,
        axisPointerClass: null,
        render: function(t, e, i, n) {
            this.axisPointerClass && function(t) {
                var e = cs(t);
                if (e) {
                    var i = e.axisPointerModel, n = e.axis.scale, r = i.option, a = i.get("status"), o = i.get("value");
                    null != o && (o = n.parse(o));
                    var s = ds(i);
                    null == a && (r.status = s ? "show" : "hide");
                    var l = n.getExtent().slice();
                    l[0] > l[1] && l.reverse(), (null == o || o > l[1]) && (o = l[1]), o < l[0] && (o = l[0]), 
                    r.value = o, s && (r.status = e.axis.scale.isBlank() ? "hide" : "show");
                }
            }(t), lm.superApply(this, "render", arguments), gs(this, t, 0, i, 0, !0);
        },
        updateAxisPointer: function(t, e, i, n) {
            gs(this, t, 0, i, 0, !1);
        },
        remove: function(t, e) {
            var i = this._axisPointer;
            i && i.remove(e), lm.superApply(this, "remove", arguments);
        },
        dispose: function(t, e) {
            ms(this, e), lm.superApply(this, "dispose", arguments);
        }
    }), hm = [];
    lm.registerAxisPointerClass = function(t, e) {
        hm[t] = e;
    }, lm.getAxisPointerClass = function(t) {
        return t && hm[t];
    };
    var um = [ "axisLine", "axisTickLabel", "axisName" ], cm = [ "splitArea", "splitLine" ], dm = lm.extend({
        type: "cartesianAxis",
        axisPointerClass: "CartesianAxisPointer",
        render: function(e, t, i, n) {
            this.group.removeAll();
            var r = this._axisGroup;
            if (this._axisGroup = new Hh(), this.group.add(this._axisGroup), e.get("show")) {
                var a = e.getCoordSysModel(), o = vs(a, e), s = new nm(e, o);
                R(um, s.add, s), this._axisGroup.add(s.getGroup()), R(cm, function(t) {
                    e.get(t + ".show") && this["_" + t](e, a);
                }, this), Mn(r, this._axisGroup, e), dm.superCall(this, "render", e, t, i, n);
            }
        },
        remove: function() {
            this._splitAreaColors = null;
        },
        _splitLine: function(t, e) {
            var i = t.axis;
            if (!i.scale.isBlank()) {
                var n = t.getModel("splitLine"), r = n.getModel("lineStyle"), a = r.get("color");
                a = P(a) ? a : [ a ];
                for (var o = e.coordinateSystem.getRect(), s = i.isHorizontal(), l = 0, h = i.getTicksCoords({
                    tickModel: n
                }), u = [], c = [], d = r.getLineStyle(), f = 0; f < h.length; f++) {
                    var p = i.toGlobalCoord(h[f].coord);
                    s ? (u[0] = p, u[1] = o.y, c[0] = p, c[1] = o.y + o.height) : (u[0] = o.x, u[1] = p, 
                    c[0] = o.x + o.width, c[1] = p);
                    var g = l++ % a.length, m = h[f].tickValue;
                    this._axisGroup.add(new nd(Zi({
                        anid: null != m ? "line_" + h[f].tickValue : null,
                        shape: {
                            x1: u[0],
                            y1: u[1],
                            x2: c[0],
                            y2: c[1]
                        },
                        style: C({
                            stroke: a[g]
                        }, d),
                        silent: !0
                    })));
                }
            }
        },
        _splitArea: function(t, e) {
            var i = t.axis;
            if (!i.scale.isBlank()) {
                var n = t.getModel("splitArea"), r = n.getModel("areaStyle"), a = r.get("color"), o = e.coordinateSystem.getRect(), s = i.getTicksCoords({
                    tickModel: n,
                    clamp: !0
                });
                if (s.length) {
                    var l = a.length, h = this._splitAreaColors, u = T(), c = 0;
                    if (h) for (var d = 0; d < s.length; d++) {
                        var f = h.get(s[d].tickValue);
                        if (null != f) {
                            c = (f + (l - 1) * d) % l;
                            break;
                        }
                    }
                    var p = i.toGlobalCoord(s[0].coord), g = r.getAreaStyle();
                    a = P(a) ? a : [ a ];
                    for (d = 1; d < s.length; d++) {
                        var m, v, y, x, _ = i.toGlobalCoord(s[d].coord);
                        i.isHorizontal() ? (m = p, v = o.y, y = _ - m, x = o.height, p = m + y) : (m = o.x, 
                        v = p, y = o.width, p = v + (x = _ - v));
                        var w = s[d - 1].tickValue;
                        null != w && u.set(w, c), this._axisGroup.add(new id({
                            anid: null != w ? "area_" + w : null,
                            shape: {
                                x: m,
                                y: v,
                                width: y,
                                height: x
                            },
                            style: C({
                                fill: a[c]
                            }, g),
                            silent: !0
                        })), c = (c + 1) % l;
                    }
                    this._splitAreaColors = u;
                }
            }
        }
    });
    dm.extend({
        type: "xAxis"
    }), dm.extend({
        type: "yAxis"
    }), Na({
        type: "grid",
        render: function(t) {
            this.group.removeAll(), t.get("show") && this.group.add(new id({
                shape: t.coordinateSystem.getRect(),
                style: C({
                    fill: t.get("backgroundColor")
                }, t.getItemStyle()),
                silent: !0,
                z2: -1
            }));
        }
    }), ka(function(t) {
        t.xAxis && t.yAxis && !t.grid && (t.grid = {});
    }), Oa(g(function(t, e) {
        var i = go(t, e), T = mo(i), C = {};
        R(i, function(t) {
            var e = t.getData(), i = t.coordinateSystem, n = i.getBaseAxis(), r = fo(t), a = T[po(n)][r], o = a.offset, s = a.width, l = i.getOtherAxis(n), h = t.get("barMinHeight") || 0;
            C[r] = C[r] || [], e.setLayout({
                offset: o,
                size: s
            });
            for (var u = e.mapDimension(l.dim), c = e.mapDimension(n.dim), d = io(e, u), f = l.isHorizontal(), p = _o(0, l), g = 0, m = e.count(); g < m; g++) {
                var v = e.get(u, g), y = e.get(c, g);
                if (!isNaN(v)) {
                    var x, _, w, b, S, M = 0 <= v ? "p" : "n", I = p;
                    d && (C[r][y] || (C[r][y] = {
                        p: p,
                        n: p
                    }), I = C[r][y][M]), f ? (x = I, _ = (S = i.dataToPoint([ v, y ]))[1] + o, w = S[0] - p, 
                    b = s, Math.abs(w) < h && (w = (w < 0 ? -1 : 1) * h), d && (C[r][y][M] += w)) : (x = (S = i.dataToPoint([ y, v ]))[0] + o, 
                    _ = I, w = s, b = S[1] - p, Math.abs(b) < h && (b = (b <= 0 ? -1 : 1) * h), d && (C[r][y][M] += b)), 
                    e.setItemLayout(g, {
                        x: x,
                        y: _,
                        width: w,
                        height: b
                    });
                }
            }
        }, this);
    }, "bar")), Oa(og), Ea({
        seriesType: "bar",
        reset: function(t) {
            t.getData().setVisual("legendSymbol", "roundRect");
        }
    }), Of.extend({
        type: "series.line",
        dependencies: [ "grid", "polar" ],
        getInitialData: function() {
            return ro(this.getSource(), this);
        },
        defaultOption: {
            zlevel: 0,
            z: 2,
            coordinateSystem: "cartesian2d",
            legendHoverLink: !0,
            hoverAnimation: !0,
            clipOverflow: !0,
            label: {
                position: "top"
            },
            lineStyle: {
                width: 2,
                type: "solid"
            },
            step: !1,
            smooth: !1,
            smoothMonotone: null,
            symbol: "emptyCircle",
            symbolSize: 4,
            symbolRotate: null,
            showSymbol: !0,
            showAllSymbol: "auto",
            connectNulls: !1,
            sampling: "none",
            animationEasing: "linear",
            progressive: 0,
            hoverLayerThreshold: 1 / 0
        }
    });
    var fm = ys.prototype, pm = ys.getSymbolSize = function(t, e) {
        var i = t.getItemVisual(e, "symbolSize");
        return i instanceof Array ? i.slice() : [ +i, +i ];
    };
    fm._createSymbol = function(t, e, i, n, r) {
        this.removeAll();
        var a = Do(t, -1, -1, 2, 2, e.getItemVisual(i, "color"), r);
        a.attr({
            z2: 100,
            culling: !0,
            scale: xs(n)
        }), a.drift = _s, this._symbolType = t, this.add(a);
    }, fm.stopSymbolAnimation = function(t) {
        this.childAt(0).stopAnimation(t);
    }, fm.getSymbolPath = function() {
        return this.childAt(0);
    }, fm.getScale = function() {
        return this.childAt(0).scale;
    }, fm.highlight = function() {
        this.childAt(0).trigger("emphasis");
    }, fm.downplay = function() {
        this.childAt(0).trigger("normal");
    }, fm.setZ = function(t, e) {
        var i = this.childAt(0);
        i.zlevel = t, i.z = e;
    }, fm.setDraggable = function(t) {
        var e = this.childAt(0);
        e.draggable = t, e.cursor = t ? "move" : "pointer";
    }, fm.updateData = function(t, e, i) {
        this.silent = !1;
        var n = t.getItemVisual(e, "symbol") || "circle", r = t.hostModel, a = pm(t, e), o = n !== this._symbolType;
        if (o) {
            var s = t.getItemVisual(e, "symbolKeepAspect");
            this._createSymbol(n, t, e, a, s);
        } else {
            (l = this.childAt(0)).silent = !1, wn(l, {
                scale: xs(a)
            }, r, e);
        }
        if (this._updateCommon(t, e, a, i), o) {
            var l = this.childAt(0), h = i && i.fadeIn, u = {
                scale: l.scale.slice()
            };
            h && (u.style = {
                opacity: l.style.opacity
            }), l.scale = [ 0, 0 ], h && (l.style.opacity = 0), bn(l, u, r, e);
        }
        this._seriesModel = r;
    };
    var gm = [ "itemStyle" ], mm = [ "emphasis", "itemStyle" ], vm = [ "label" ], ym = [ "emphasis", "label" ];
    fm._updateCommon = function(e, t, i, n) {
        var r = this.childAt(0), a = e.hostModel, o = e.getItemVisual(t, "color");
        "image" !== r.type && r.useStyle({
            strokeNoScale: !0
        });
        var s = n && n.itemStyle, l = n && n.hoverItemStyle, h = n && n.symbolRotate, u = n && n.symbolOffset, c = n && n.labelModel, d = n && n.hoverLabelModel, f = n && n.hoverAnimation, p = n && n.cursorStyle;
        if (!n || e.hasItemOption) {
            var g = n && n.itemModel ? n.itemModel : e.getItemModel(t);
            s = g.getModel(gm).getItemStyle([ "color" ]), l = g.getModel(mm).getItemStyle(), 
            h = g.getShallow("symbolRotate"), u = g.getShallow("symbolOffset"), c = g.getModel(vm), 
            d = g.getModel(ym), f = g.getShallow("hoverAnimation"), p = g.getShallow("cursor");
        } else l = A({}, l);
        var m = r.style;
        r.attr("rotation", (h || 0) * Math.PI / 180 || 0), u && r.attr("position", [ Pn(u[0], i[0]), Pn(u[1], i[1]) ]), 
        p && r.attr("cursor", p), r.setColor(o, n && n.symbolInnerColor), r.setStyle(s);
        var v = e.getItemVisual(t, "opacity");
        null != v && (m.opacity = v);
        var y = e.getItemVisual(t, "liftZ"), x = r.__z2Origin;
        null != y ? null == x && (r.__z2Origin = r.z2, r.z2 += y) : null != x && (r.z2 = x, 
        r.__z2Origin = null);
        var _ = n && n.useNameLabel;
        dn(m, l, c, d, {
            labelFetcher: a,
            labelDataIndex: t,
            defaultText: function(t) {
                return _ ? e.getName(t) : Qo(e, t);
            },
            isRectText: !0,
            autoColor: o
        }), r.off("mouseover").off("mouseout").off("emphasis").off("normal"), r.hoverStyle = l, 
        un(r), r.__symbolOriginalScale = xs(i), f && a.isAnimationEnabled() && r.on("mouseover", ws).on("mouseout", bs).on("emphasis", Ss).on("normal", Ms);
    }, fm.fadeOut = function(t, e) {
        var i = this.childAt(0);
        this.silent = i.silent = !0, !(e && e.keepLabel) && (i.style.text = null), wn(i, {
            style: {
                opacity: 0
            },
            scale: [ 0, 0 ]
        }, this._seriesModel, this.dataIndex, t);
    }, a(ys, Hh);
    var xm = Is.prototype;
    xm.updateData = function(r, a) {
        a = Cs(a);
        var o = this.group, s = r.hostModel, l = this._data, h = this._symbolCtor, u = Ds(r);
        l || o.removeAll(), r.diff(l).add(function(t) {
            var e = r.getItemLayout(t);
            if (Ts(r, e, t, a)) {
                var i = new h(r, t, u);
                i.attr("position", e), r.setItemGraphicEl(t, i), o.add(i);
            }
        }).update(function(t, e) {
            var i = l.getItemGraphicEl(e), n = r.getItemLayout(t);
            return Ts(r, n, t, a) ? (i ? (i.updateData(r, t, u), wn(i, {
                position: n
            }, s)) : (i = new h(r, t)).attr("position", n), o.add(i), void r.setItemGraphicEl(t, i)) : void o.remove(i);
        }).remove(function(t) {
            var e = l.getItemGraphicEl(t);
            e && e.fadeOut(function() {
                o.remove(e);
            });
        }).execute(), this._data = r;
    }, xm.isPersistent = function() {
        return !0;
    }, xm.updateLayout = function() {
        var n = this._data;
        n && n.eachItemGraphicEl(function(t, e) {
            var i = n.getItemLayout(e);
            t.attr("position", i);
        });
    }, xm.incrementalPrepareUpdate = function(t) {
        this._seriesScope = Ds(t), this._data = null, this.group.removeAll();
    }, xm.incrementalUpdate = function(t, e, i) {
        function n(t) {
            t.isGroup || (t.incremental = t.useHoverLayer = !0);
        }
        i = Cs(i);
        for (var r = t.start; r < t.end; r++) {
            var a = e.getItemLayout(r);
            if (Ts(e, a, r, i)) {
                var o = new this._symbolCtor(e, r, this._seriesScope);
                o.traverse(n), o.attr("position", a), this.group.add(o), e.setItemGraphicEl(r, o);
            }
        }
    }, xm.remove = function(t) {
        var e = this.group, i = this._data;
        i && t ? i.eachItemGraphicEl(function(t) {
            t.fadeOut(function() {
                e.remove(t);
            });
        }) : e.removeAll();
    };
    var _m = K, wm = Q, bm = H, Sm = F, Mm = [], Im = [], Tm = [], Cm = Bi.extend({
        type: "ec-polyline",
        shape: {
            points: [],
            smooth: 0,
            smoothConstraint: !0,
            smoothMonotone: null,
            connectNulls: !1
        },
        style: {
            fill: null,
            stroke: "#000"
        },
        brush: Kc(Bi.prototype.brush),
        buildPath: function(t, e) {
            var i = e.points, n = 0, r = i.length, a = Os(i, e.smoothConstraint);
            if (e.connectNulls) {
                for (;0 < r && Ps(i[r - 1]); r--) ;
                for (;n < r && Ps(i[n]); n++) ;
            }
            for (;n < r; ) n += Ls(t, i, n, r, r, 1, a.min, a.max, e.smooth, e.smoothMonotone, e.connectNulls) + 1;
        }
    }), Dm = Bi.extend({
        type: "ec-polygon",
        shape: {
            points: [],
            stackedOnPoints: [],
            smooth: 0,
            stackedOnSmooth: 0,
            smoothConstraint: !0,
            smoothMonotone: null,
            connectNulls: !1
        },
        brush: Kc(Bi.prototype.brush),
        buildPath: function(t, e) {
            var i = e.points, n = e.stackedOnPoints, r = 0, a = i.length, o = e.smoothMonotone, s = Os(i, e.smoothConstraint), l = Os(n, e.smoothConstraint);
            if (e.connectNulls) {
                for (;0 < a && Ps(i[a - 1]); a--) ;
                for (;r < a && Ps(i[r]); r++) ;
            }
            for (;r < a; ) {
                var h = Ls(t, i, r, a, a, 1, s.min, s.max, e.smooth, o, e.connectNulls);
                Ls(t, n, r + h - 1, h, a, -1, l.min, l.max, e.stackedOnSmooth, o, e.connectNulls), 
                r += h + 1, t.closePath();
            }
        }
    });
    Vr.extend({
        type: "line",
        init: function() {
            var t = new Hh(), e = new Is();
            this.group.add(e.group), this._symbolDraw = e, this._lineGroup = t;
        },
        render: function(t, e, i) {
            var n = t.coordinateSystem, r = this.group, a = t.getData(), o = t.getModel("lineStyle"), s = t.getModel("areaStyle"), l = a.mapArray(a.getItemLayout), h = "polar" === n.type, u = this._coordSys, c = this._symbolDraw, d = this._polyline, f = this._polygon, p = this._lineGroup, g = t.get("animation"), m = !s.isEmpty(), v = s.get("origin"), y = function(t, e, i) {
                if (!i.valueDim) return [];
                for (var n = [], r = 0, a = e.count(); r < a; r++) n.push(ks(i, t, e, r));
                return n;
            }(n, a, As(n, a, v)), x = t.get("showSymbol"), _ = x && !h && Fs(t, a, n), w = this._data;
            w && w.eachItemGraphicEl(function(t, e) {
                t.__temp && (r.remove(t), w.setItemGraphicEl(e, null));
            }), x || c.remove(), r.add(p);
            var b = !h && t.get("step");
            d && u.type === n.type && b === this._step ? (m && !f ? f = this._newPolygon(l, y, n, g) : f && !m && (p.remove(f), 
            f = this._polygon = null), p.setClipPath(Rs(n, !1, !1, t)), x && c.updateData(a, {
                isIgnore: _,
                clipShape: Rs(n, !1, !0, t)
            }), a.eachItemGraphicEl(function(t) {
                t.stopAnimation(!0);
            }), Es(this._stackedOnPoints, y) && Es(this._points, l) || (g ? this._updateAnimation(a, y, n, i, b, v) : (b && (l = Ns(l, n, b), 
            y = Ns(y, n, b)), d.setShape({
                points: l
            }), f && f.setShape({
                points: l,
                stackedOnPoints: y
            })))) : (x && c.updateData(a, {
                isIgnore: _,
                clipShape: Rs(n, !1, !0, t)
            }), b && (l = Ns(l, n, b), y = Ns(y, n, b)), d = this._newPolyline(l, n, g), m && (f = this._newPolygon(l, y, n, g)), 
            p.setClipPath(Rs(n, !0, !1, t)));
            var S = function(t, e) {
                var i = t.getVisual("visualMeta");
                if (i && i.length && t.count() && "cartesian2d" === e.type) {
                    for (var n, r, a = i.length - 1; 0 <= a; a--) {
                        var o = i[a].dimension, s = t.dimensions[o], l = t.getDimensionInfo(s);
                        if ("x" === (n = l && l.coordDim) || "y" === n) {
                            r = i[a];
                            break;
                        }
                    }
                    if (r) {
                        var h = e.getAxis(n), u = D(r.stops, function(t) {
                            return {
                                coord: h.toGlobalCoord(h.dataToCoord(t.value)),
                                color: t.color
                            };
                        }), c = u.length, d = r.outerColors.slice();
                        c && u[0].coord > u[c - 1].coord && (u.reverse(), d.reverse());
                        var f = u[0].coord - 10, p = u[c - 1].coord + 10, g = p - f;
                        if (g < .001) return "transparent";
                        R(u, function(t) {
                            t.offset = (t.coord - f) / g;
                        }), u.push({
                            offset: c ? u[c - 1].offset : .5,
                            color: d[1] || "transparent"
                        }), u.unshift({
                            offset: c ? u[0].offset : .5,
                            color: d[0] || "transparent"
                        });
                        var m = new hd(0, 0, 0, 0, u, !0);
                        return m[n] = f, m[n + "2"] = p, m;
                    }
                }
            }(a, n) || a.getVisual("color");
            d.useStyle(C(o.getLineStyle(), {
                fill: "none",
                stroke: S,
                lineJoin: "bevel"
            }));
            var M = t.get("smooth");
            if (M = zs(t.get("smooth")), d.setShape({
                smooth: M,
                smoothMonotone: t.get("smoothMonotone"),
                connectNulls: t.get("connectNulls")
            }), f) {
                var I = a.getCalculationInfo("stackedOnSeries"), T = 0;
                f.useStyle(C(s.getAreaStyle(), {
                    fill: S,
                    opacity: .7,
                    lineJoin: "bevel"
                })), I && (T = zs(I.get("smooth"))), f.setShape({
                    smooth: M,
                    stackedOnSmooth: T,
                    smoothMonotone: t.get("smoothMonotone"),
                    connectNulls: t.get("connectNulls")
                });
            }
            this._data = a, this._coordSys = n, this._stackedOnPoints = y, this._points = l, 
            this._step = b, this._valueOrigin = v;
        },
        dispose: function() {},
        highlight: function(t, e, i, n) {
            var r = t.getData(), a = ti(r, n);
            if (!(a instanceof Array) && null != a && 0 <= a) {
                var o = r.getItemGraphicEl(a);
                if (!o) {
                    var s = r.getItemLayout(a);
                    if (!s) return;
                    (o = new ys(r, a)).position = s, o.setZ(t.get("zlevel"), t.get("z")), o.ignore = isNaN(s[0]) || isNaN(s[1]), 
                    o.__temp = !0, r.setItemGraphicEl(a, o), o.stopSymbolAnimation(!0), this.group.add(o);
                }
                o.highlight();
            } else Vr.prototype.highlight.call(this, t, e, i, n);
        },
        downplay: function(t, e, i, n) {
            var r = t.getData(), a = ti(r, n);
            if (null != a && 0 <= a) {
                var o = r.getItemGraphicEl(a);
                o && (o.__temp ? (r.setItemGraphicEl(a, null), this.group.remove(o)) : o.downplay());
            } else Vr.prototype.downplay.call(this, t, e, i, n);
        },
        _newPolyline: function(t) {
            var e = this._polyline;
            return e && this._lineGroup.remove(e), e = new Cm({
                shape: {
                    points: t
                },
                silent: !0,
                z2: 10
            }), this._lineGroup.add(e), this._polyline = e;
        },
        _newPolygon: function(t, e) {
            var i = this._polygon;
            return i && this._lineGroup.remove(i), i = new Dm({
                shape: {
                    points: t,
                    stackedOnPoints: e
                },
                silent: !0
            }), this._lineGroup.add(i), this._polygon = i;
        },
        _updateAnimation: function(t, e, i, n, r, a) {
            var o = this._polyline, s = this._polygon, l = t.hostModel, h = function(t, e, i, n, r, a, o, s) {
                for (var l = function(t, e) {
                    var i = [];
                    return e.diff(t).add(function(t) {
                        i.push({
                            cmd: "+",
                            idx: t
                        });
                    }).update(function(t, e) {
                        i.push({
                            cmd: "=",
                            idx: e,
                            idx1: t
                        });
                    }).remove(function(t) {
                        i.push({
                            cmd: "-",
                            idx: t
                        });
                    }).execute(), i;
                }(t, e), h = [], u = [], c = [], d = [], f = [], p = [], g = [], m = As(r, e, o), v = As(a, t, s), y = 0; y < l.length; y++) {
                    var x = l[y], _ = !0;
                    switch (x.cmd) {
                      case "=":
                        var w = t.getItemLayout(x.idx), b = e.getItemLayout(x.idx1);
                        (isNaN(w[0]) || isNaN(w[1])) && (w = b.slice()), h.push(w), u.push(b), c.push(i[x.idx]), 
                        d.push(n[x.idx1]), g.push(e.getRawIndex(x.idx1));
                        break;

                      case "+":
                        var S = x.idx;
                        h.push(r.dataToPoint([ e.get(m.dataDimsForPoint[0], S), e.get(m.dataDimsForPoint[1], S) ])), 
                        u.push(e.getItemLayout(S).slice()), c.push(ks(m, r, e, S)), d.push(n[S]), g.push(e.getRawIndex(S));
                        break;

                      case "-":
                        S = x.idx;
                        var M = t.getRawIndex(S);
                        M !== S ? (h.push(t.getItemLayout(S)), u.push(a.dataToPoint([ t.get(v.dataDimsForPoint[0], S), t.get(v.dataDimsForPoint[1], S) ])), 
                        c.push(i[S]), d.push(ks(v, a, t, S)), g.push(M)) : _ = !1;
                    }
                    _ && (f.push(x), p.push(p.length));
                }
                p.sort(function(t, e) {
                    return g[t] - g[e];
                });
                var I = [], T = [], C = [], D = [], A = [];
                for (y = 0; y < p.length; y++) S = p[y], I[y] = h[S], T[y] = u[S], C[y] = c[S], 
                D[y] = d[S], A[y] = f[S];
                return {
                    current: I,
                    next: T,
                    stackedOnCurrent: C,
                    stackedOnNext: D,
                    status: A
                };
            }(this._data, t, this._stackedOnPoints, e, this._coordSys, i, this._valueOrigin, a), u = h.current, c = h.stackedOnCurrent, d = h.next, f = h.stackedOnNext;
            r && (u = Ns(h.current, i, r), c = Ns(h.stackedOnCurrent, i, r), d = Ns(h.next, i, r), 
            f = Ns(h.stackedOnNext, i, r)), o.shape.__points = h.current, o.shape.points = u, 
            wn(o, {
                shape: {
                    points: d
                }
            }, l), s && (s.setShape({
                points: u,
                stackedOnPoints: c
            }), wn(s, {
                shape: {
                    points: d,
                    stackedOnPoints: f
                }
            }, l));
            for (var p = [], g = h.status, m = 0; m < g.length; m++) {
                if ("=" === g[m].cmd) {
                    var v = t.getItemGraphicEl(g[m].idx1);
                    v && p.push({
                        el: v,
                        ptIdx: m
                    });
                }
            }
            o.animators && o.animators.length && o.animators[0].during(function() {
                for (var t = 0; t < p.length; t++) {
                    p[t].el.attr("position", o.shape.__points[p[t].ptIdx]);
                }
            });
        },
        remove: function() {
            var i = this.group, n = this._data;
            this._lineGroup.removeAll(), this._symbolDraw.remove(!0), n && n.eachItemGraphicEl(function(t, e) {
                t.__temp && (i.remove(t), n.setItemGraphicEl(e, null));
            }), this._polyline = this._polygon = this._coordSys = this._points = this._stackedOnPoints = this._data = null;
        }
    });
    var Am = function(t, a, o) {
        return {
            seriesType: t,
            performRawSeries: !0,
            reset: function(l, t) {
                var e = l.getData(), i = l.get("symbol") || a, h = l.get("symbolSize"), n = l.get("symbolKeepAspect");
                if (e.setVisual({
                    legendSymbol: o || i,
                    symbol: i,
                    symbolSize: h,
                    symbolKeepAspect: n
                }), !t.isSeriesFiltered(l)) {
                    var r = "function" == typeof h;
                    return {
                        dataEach: e.hasItemOption || r ? function(t, e) {
                            if ("function" == typeof h) {
                                var i = l.getRawValue(e), n = l.getDataParams(e);
                                t.setItemVisual(e, "symbolSize", h(i, n));
                            }
                            if (t.hasItemOption) {
                                var r = t.getItemModel(e), a = r.getShallow("symbol", !0), o = r.getShallow("symbolSize", !0), s = r.getShallow("symbolKeepAspect", !0);
                                null != a && t.setItemVisual(e, "symbol", a), null != o && t.setItemVisual(e, "symbolSize", o), 
                                null != s && t.setItemVisual(e, "symbolKeepAspect", s);
                            }
                        } : null
                    };
                }
            }
        };
    }, km = {
        average: function(t) {
            for (var e = 0, i = 0, n = 0; n < t.length; n++) isNaN(t[n]) || (e += t[n], i++);
            return 0 === i ? NaN : e / i;
        },
        sum: function(t) {
            for (var e = 0, i = 0; i < t.length; i++) e += t[i] || 0;
            return e;
        },
        max: function(t) {
            for (var e = -1 / 0, i = 0; i < t.length; i++) t[i] > e && (e = t[i]);
            return isFinite(e) ? e : NaN;
        },
        min: function(t) {
            for (var e = 1 / 0, i = 0; i < t.length; i++) t[i] < e && (e = t[i]);
            return isFinite(e) ? e : NaN;
        },
        nearest: function(t) {
            return t[0];
        }
    }, Pm = function(t) {
        return Math.round(t.length / 2);
    };
    Ea(Am("line", "circle", "line")), Oa({
        seriesType: "line",
        plan: Bf(),
        reset: function(t) {
            var e = t.getData(), c = t.coordinateSystem, d = t.pipelineContext.large;
            if (c) {
                var f = D(c.dimensions, function(t) {
                    return e.mapDimension(t);
                }).slice(0, 2), p = f.length, i = e.getCalculationInfo("stackResultDimension");
                return io(e, f[0]) && (f[0] = i), io(e, f[1]) && (f[1] = i), p && {
                    progress: function(t, e) {
                        for (var i = t.end - t.start, n = d && new Float32Array(i * p), r = t.start, a = 0, o = [], s = []; r < t.end; r++) {
                            var l;
                            if (1 === p) {
                                var h = e.get(f[0], r);
                                l = !isNaN(h) && c.dataToPoint(h, null, s);
                            } else {
                                h = o[0] = e.get(f[0], r);
                                var u = o[1] = e.get(f[1], r);
                                l = !isNaN(h) && !isNaN(u) && c.dataToPoint(o, null, s);
                            }
                            d ? (n[a++] = l ? l[0] : NaN, n[a++] = l ? l[1] : NaN) : e.setItemLayout(r, l && l.slice() || [ NaN, NaN ]);
                        }
                        d && e.setLayout("symbolPoints", n);
                    }
                };
            }
        }
    }), Pa(xp.PROCESSOR.STATISTIC, {
        seriesType: "line",
        modifyOutputEnd: !0,
        reset: function(t) {
            var e = t.getData(), i = t.get("sampling"), n = t.coordinateSystem;
            if ("cartesian2d" === n.type && i) {
                var r, a = n.getBaseAxis(), o = n.getOtherAxis(a), s = a.getExtent(), l = s[1] - s[0], h = Math.round(e.count() / l);
                1 < h && ("string" == typeof i ? r = km[i] : "function" == typeof i && (r = i), 
                r && t.setData(e.downSample(e.mapDimension(o.dim), 1 / h, r, Pm)));
            }
        }
    });
    var Lm = function(t, e, i) {
        e = P(e) && {
            coordDimensions: e
        } || A({}, e);
        var n = t.getSource(), r = Kp(n, e), a = new Yp(r, t);
        return a.initData(n, i), a;
    }, Om = {
        updateSelectedMap: function(t) {
            this._targetList = P(t) ? t.slice() : [], this._selectTargetMap = S(t || [], function(t, e) {
                return t.set(e.name, e), t;
            }, T());
        },
        select: function(t, e) {
            var i = null != e ? this._targetList[e] : this._selectTargetMap.get(t);
            "single" === this.get("selectedMode") && this._selectTargetMap.each(function(t) {
                t.selected = !1;
            }), i && (i.selected = !0);
        },
        unSelect: function(t, e) {
            var i = null != e ? this._targetList[e] : this._selectTargetMap.get(t);
            i && (i.selected = !1);
        },
        toggleSelected: function(t, e) {
            var i = null != e ? this._targetList[e] : this._selectTargetMap.get(t);
            return null != i ? (this[i.selected ? "unSelect" : "select"](t, e), i.selected) : void 0;
        },
        isSelected: function(t, e) {
            var i = null != e ? this._targetList[e] : this._selectTargetMap.get(t);
            return i && i.selected;
        }
    }, Em = Fa({
        type: "series.pie",
        init: function(t) {
            Em.superApply(this, "init", arguments), this.legendDataProvider = function() {
                return this.getRawData();
            }, this.updateSelectedMap(this._createSelectableList()), this._defaultLabelLine(t);
        },
        mergeOption: function(t) {
            Em.superCall(this, "mergeOption", t), this.updateSelectedMap(this._createSelectableList());
        },
        getInitialData: function() {
            return Lm(this, [ "value" ]);
        },
        _createSelectableList: function() {
            for (var t = this.getRawData(), e = t.mapDimension("value"), i = [], n = 0, r = t.count(); n < r; n++) i.push({
                name: t.getName(n),
                value: t.get(e, n),
                selected: kr(t, n, "selected")
            });
            return i;
        },
        getDataParams: function(t) {
            var e = this.getData(), i = Em.superCall(this, "getDataParams", t), n = [];
            return e.each(e.mapDimension("value"), function(t) {
                n.push(t);
            }), i.percent = zn(n, t, e.hostModel.get("percentPrecision")), i.$vars.push("percent"), 
            i;
        },
        _defaultLabelLine: function(t) {
            Ze(t, "labelLine", [ "show" ]);
            var e = t.labelLine, i = t.emphasis.labelLine;
            e.show = e.show && t.label.show, i.show = i.show && t.emphasis.label.show;
        },
        defaultOption: {
            zlevel: 0,
            z: 2,
            legendHoverLink: !0,
            hoverAnimation: !0,
            center: [ "50%", "50%" ],
            radius: [ 0, "75%" ],
            clockwise: !0,
            startAngle: 90,
            minAngle: 0,
            selectedOffset: 10,
            hoverOffset: 10,
            avoidLabelOverlap: !0,
            percentPrecision: 2,
            stillShowZeroSum: !0,
            label: {
                rotate: !1,
                show: !0,
                position: "outer"
            },
            labelLine: {
                show: !0,
                length: 15,
                length2: 15,
                smooth: !1,
                lineStyle: {
                    width: 1,
                    type: "solid"
                }
            },
            itemStyle: {
                borderWidth: 1
            },
            animationType: "expansion",
            animationEasing: "cubicOut"
        }
    });
    r(Em, Om);
    var zm = Hs.prototype;
    zm.updateData = function(t, e, i) {
        function n() {
            a.stopAnimation(!0), a.animateTo({
                shape: {
                    r: l.r + o.get("hoverOffset")
                }
            }, 300, "elasticOut");
        }
        function r() {
            a.stopAnimation(!0), a.animateTo({
                shape: {
                    r: l.r
                }
            }, 300, "elasticOut");
        }
        var a = this.childAt(0), o = t.hostModel, s = t.getItemModel(e), l = t.getItemLayout(e), h = A({}, l);
        (h.label = null, i) ? (a.setShape(h), "scale" === o.getShallow("animationType") ? (a.shape.r = l.r0, 
        bn(a, {
            shape: {
                r: l.r
            }
        }, o, e)) : (a.shape.endAngle = l.startAngle, wn(a, {
            shape: {
                endAngle: l.endAngle
            }
        }, o, e))) : wn(a, {
            shape: h
        }, o, e);
        var u = t.getItemVisual(e, "color");
        a.useStyle(C({
            lineJoin: "bevel",
            fill: u
        }, s.getModel("itemStyle").getItemStyle())), a.hoverStyle = s.getModel("emphasis.itemStyle").getItemStyle();
        var c = s.getShallow("cursor");
        c && a.attr("cursor", c), Vs(this, t.getItemLayout(e), o.isSelected(null, e), o.get("selectedOffset"), o.get("animation")), 
        a.off("mouseover").off("mouseout").off("emphasis").off("normal"), s.get("hoverAnimation") && o.isAnimationEnabled() && a.on("mouseover", n).on("mouseout", r).on("emphasis", n).on("normal", r), 
        this._updateLabel(t, e), un(this);
    }, zm._updateLabel = function(t, e) {
        var i = this.childAt(1), n = this.childAt(2), r = t.hostModel, a = t.getItemModel(e), o = t.getItemLayout(e).label, s = t.getItemVisual(e, "color");
        wn(i, {
            shape: {
                points: o.linePoints || [ [ o.x, o.y ], [ o.x, o.y ], [ o.x, o.y ] ]
            }
        }, r, e), wn(n, {
            style: {
                x: o.x,
                y: o.y
            }
        }, r, e), n.attr({
            rotation: o.rotation,
            origin: [ o.x, o.y ],
            z2: 10
        });
        var l = a.getModel("label"), h = a.getModel("emphasis.label"), u = a.getModel("labelLine"), c = a.getModel("emphasis.labelLine");
        s = t.getItemVisual(e, "color");
        dn(n.style, n.hoverStyle = {}, l, h, {
            labelFetcher: t.hostModel,
            labelDataIndex: e,
            defaultText: t.getName(e),
            autoColor: s,
            useInsideStyle: !!o.inside
        }, {
            textAlign: o.textAlign,
            textVerticalAlign: o.verticalAlign,
            opacity: t.getItemVisual(e, "opacity")
        }), n.ignore = n.normalIgnore = !l.get("show"), n.hoverIgnore = !h.get("show"), 
        i.ignore = i.normalIgnore = !u.get("show"), i.hoverIgnore = !c.get("show"), i.setStyle({
            stroke: s,
            opacity: t.getItemVisual(e, "opacity")
        }), i.setStyle(u.getModel("lineStyle").getLineStyle()), i.hoverStyle = c.getModel("lineStyle").getLineStyle();
        var d = u.get("smooth");
        d && !0 === d && (d = .4), i.setShape({
            smooth: d
        });
    }, a(Hs, Hh);
    var Bm = (Vr.extend({
        type: "pie",
        init: function() {
            var t = new Hh();
            this._sectorGroup = t;
        },
        render: function(t, e, i, n) {
            if (!n || n.from !== this.uid) {
                var r = t.getData(), a = this._data, o = this.group, s = e.get("animation"), l = !a, h = t.get("animationType"), u = g(Gs, this.uid, t, s, i), c = t.get("selectedMode");
                if (r.diff(a).add(function(t) {
                    var e = new Hs(r, t);
                    l && "scale" !== h && e.eachChild(function(t) {
                        t.stopAnimation(!0);
                    }), c && e.on("click", u), r.setItemGraphicEl(t, e), o.add(e);
                }).update(function(t, e) {
                    var i = a.getItemGraphicEl(e);
                    i.updateData(r, t), i.off("click"), c && i.on("click", u), o.add(i), r.setItemGraphicEl(t, i);
                }).remove(function(t) {
                    var e = a.getItemGraphicEl(t);
                    o.remove(e);
                }).execute(), s && l && 0 < r.count() && "scale" !== h) {
                    var d = r.getItemLayout(0), f = Math.max(i.getWidth(), i.getHeight()) / 2, p = _(o.removeClipPath, o);
                    o.setClipPath(this._createClipPath(d.cx, d.cy, f, d.startAngle, d.clockwise, p, t));
                } else o.removeClipPath();
                this._data = r;
            }
        },
        dispose: function() {},
        _createClipPath: function(t, e, i, n, r, a, o) {
            var s = new Qc({
                shape: {
                    cx: t,
                    cy: e,
                    r0: 0,
                    r: i,
                    startAngle: n,
                    endAngle: n,
                    clockwise: r
                }
            });
            return bn(s, {
                shape: {
                    endAngle: n + (r ? 1 : -1) * Math.PI * 2
                }
            }, o, a), s;
        },
        containPoint: function(t, e) {
            var i = e.getData().getItemLayout(0);
            if (i) {
                var n = t[0] - i.cx, r = t[1] - i.cy, a = Math.sqrt(n * n + r * r);
                return a <= i.r && a >= i.r0;
            }
        }
    }), function(i, t) {
        R(t, function(a) {
            a.update = "updateView", La(a, function(t, e) {
                var r = {};
                return e.eachComponent({
                    mainType: "series",
                    subType: i,
                    query: t
                }, function(i) {
                    i[a.method] && i[a.method](t.name, t.dataIndex);
                    var n = i.getData();
                    n.each(function(t) {
                        var e = n.getName(t);
                        r[e] = i.isSelected(e) || !1;
                    });
                }), {
                    name: t.name,
                    selected: r
                };
            });
        });
    }), Rm = function(n) {
        return {
            getTargetSeries: function(t) {
                var e = {}, i = T();
                return t.eachSeriesByType(n, function(t) {
                    t.__paletteScope = e, i.set(t.uid, t);
                }), i;
            },
            reset: function(r) {
                var a = r.getRawData(), o = {}, s = r.getData();
                s.each(function(t) {
                    var e = s.getRawIndex(t);
                    o[e] = t;
                }), a.each(function(t) {
                    var e = o[t], i = null != e && s.getItemVisual(e, "color", !0);
                    if (i) a.setItemVisual(t, "color", i); else {
                        var n = a.getItemModel(t).get("itemStyle.color") || r.getColorFromPalette(a.getName(t) || t + "", r.__paletteScope, a.count());
                        a.setItemVisual(t, "color", n), null != e && s.setItemVisual(e, "color", n);
                    }
                });
            }
        };
    }, Nm = function(M, I, t, e) {
        var T, C, D = M.getData(), A = [], k = !1;
        D.each(function(t) {
            var e, i, n, r, a = D.getItemLayout(t), o = D.getItemModel(t), s = o.getModel("label"), l = s.get("position") || o.get("emphasis.label.position"), h = o.getModel("labelLine"), u = h.get("length"), c = h.get("length2"), d = (a.startAngle + a.endAngle) / 2, f = Math.cos(d), p = Math.sin(d);
            T = a.cx, C = a.cy;
            var g = "inside" === l || "inner" === l;
            if ("center" === l) e = a.cx, i = a.cy, r = "center"; else {
                var m = (g ? (a.r + a.r0) / 2 * f : a.r * f) + T, v = (g ? (a.r + a.r0) / 2 * p : a.r * p) + C;
                if (e = m + 3 * f, i = v + 3 * p, !g) {
                    var y = m + f * (u + I - a.r), x = v + p * (u + I - a.r), _ = y + (f < 0 ? -1 : 1) * c;
                    e = _ + (f < 0 ? -5 : 5), n = [ [ m, v ], [ y, x ], [ _, i = x ] ];
                }
                r = g ? "center" : 0 < f ? "left" : "right";
            }
            var w = s.getFont(), b = s.get("rotate") ? f < 0 ? -d + Math.PI : -d : 0, S = ce(M.getFormattedLabel(t, "normal") || D.getName(t), w, r, "top");
            k = !!b, a.label = {
                x: e,
                y: i,
                position: l,
                height: S.height,
                len: u,
                len2: c,
                linePoints: n,
                textAlign: r,
                verticalAlign: "middle",
                rotation: b,
                inside: g
            }, g || A.push(a.label);
        }), !k && M.get("avoidLabelOverlap") && function(t, e, i, n, r, a) {
            for (var o = [], s = [], l = 0; l < t.length; l++) t[l].x < e ? o.push(t[l]) : s.push(t[l]);
            for (Ws(s, e, i, n, 1, 0, a), Ws(o, e, i, n, -1, 0, a), l = 0; l < t.length; l++) {
                var h = t[l].linePoints;
                if (h) {
                    var u = h[1][0] - h[2][0];
                    h[2][0] = t[l].x < e ? t[l].x + 3 : t[l].x - 3, h[1][1] = h[2][1] = t[l].y, h[1][0] = h[2][0] + u;
                }
            }
        }(A, T, C, I, 0, e);
    }, Fm = 2 * Math.PI, Gm = Math.PI / 180, Vm = function(t) {
        return {
            seriesType: t,
            reset: function(t, e) {
                var n = e.findComponents({
                    mainType: "legend"
                });
                if (n && n.length) {
                    var r = t.getData();
                    r.filterSelf(function(t) {
                        for (var e = r.getName(t), i = 0; i < n.length; i++) if (!n[i].isSelected(e)) return !1;
                        return !0;
                    });
                }
            }
        };
    };
    Bm("pie", [ {
        type: "pieToggleSelect",
        event: "pieselectchanged",
        method: "toggleSelected"
    }, {
        type: "pieSelect",
        event: "pieselected",
        method: "select"
    }, {
        type: "pieUnSelect",
        event: "pieunselected",
        method: "unSelect"
    } ]), Ea(Rm("pie")), Oa(g(function(t, e, T) {
        e.eachSeriesByType(t, function(t) {
            var r = t.getData(), e = r.mapDimension("value"), i = t.get("center"), n = t.get("radius");
            P(n) || (n = [ 0, n ]), P(i) || (i = [ i, i ]);
            var a = T.getWidth(), o = T.getHeight(), s = Math.min(a, o), l = Pn(i[0], a), h = Pn(i[1], o), u = Pn(n[0], s / 2), c = Pn(n[1], s / 2), d = -t.get("startAngle") * Gm, f = t.get("minAngle") * Gm, p = 0;
            r.each(e, function(t) {
                !isNaN(t) && p++;
            });
            var g = r.getSum(e), m = Math.PI / (g || p) * 2, v = t.get("clockwise"), y = t.get("roseType"), x = t.get("stillShowZeroSum"), _ = r.getDataExtent(e);
            _[0] = 0;
            var w = Fm, b = 0, S = d, M = v ? 1 : -1;
            if (r.each(e, function(t, e) {
                var i;
                if (isNaN(t)) r.setItemLayout(e, {
                    angle: NaN,
                    startAngle: NaN,
                    endAngle: NaN,
                    clockwise: v,
                    cx: l,
                    cy: h,
                    r0: u,
                    r: y ? NaN : c
                }); else {
                    (i = "area" !== y ? 0 === g && x ? m : t * m : Fm / p) < f ? w -= i = f : b += t;
                    var n = S + M * i;
                    r.setItemLayout(e, {
                        angle: i,
                        startAngle: S,
                        endAngle: n,
                        clockwise: v,
                        cx: l,
                        cy: h,
                        r0: u,
                        r: y ? kn(t, _, [ u, c ]) : c
                    }), S = n;
                }
            }), w < Fm && p) if (w <= .001) {
                var I = Fm / p;
                r.each(e, function(t, e) {
                    if (!isNaN(t)) {
                        var i = r.getItemLayout(e);
                        i.angle = I, i.startAngle = d + M * e * I, i.endAngle = d + M * (e + 1) * I;
                    }
                });
            } else m = w / b, S = d, r.each(e, function(t, e) {
                if (!isNaN(t)) {
                    var i = r.getItemLayout(e), n = i.angle === f ? f : t * m;
                    i.startAngle = S, i.endAngle = S + M * n, S += M * n;
                }
            });
            Nm(t, c, 0, o);
        });
    }, "pie")), Pa(Vm("pie")), a(Xs, Rg), qs.prototype.getIndicatorAxes = function() {
        return this._indicatorAxes;
    }, qs.prototype.dataToPoint = function(t, e) {
        var i = this._indicatorAxes[e];
        return this.coordToPoint(i.dataToCoord(t), e);
    }, qs.prototype.coordToPoint = function(t, e) {
        var i = this._indicatorAxes[e].angle;
        return [ this.cx + t * Math.cos(i), this.cy - t * Math.sin(i) ];
    }, qs.prototype.pointToData = function(t) {
        var e = t[0] - this.cx, i = t[1] - this.cy, n = Math.sqrt(e * e + i * i);
        e /= n, i /= n;
        for (var r, a = Math.atan2(-i, e), o = 1 / 0, s = -1, l = 0; l < this._indicatorAxes.length; l++) {
            var h = this._indicatorAxes[l], u = Math.abs(a - h.angle);
            u < o && (r = h, s = l, o = u);
        }
        return [ s, +(r && r.coodToData(n)) ];
    }, qs.prototype.resize = function(t, e) {
        var i = t.get("center"), n = e.getWidth(), r = e.getHeight(), a = Math.min(n, r) / 2;
        this.cx = Pn(i[0], n), this.cy = Pn(i[1], r), this.startAngle = t.get("startAngle") * Math.PI / 180;
        var o = t.get("radius");
        ("string" == typeof o || "number" == typeof o) && (o = [ 0, o ]), this.r0 = Pn(o[0], a), 
        this.r = Pn(o[1], a), R(this._indicatorAxes, function(t, e) {
            t.setExtent(this.r0, this.r);
            var i = this.startAngle + e * Math.PI * 2 / this._indicatorAxes.length;
            i = Math.atan2(Math.sin(i), Math.cos(i)), t.angle = i;
        }, this);
    }, qs.prototype.update = function(i) {
        function d(t) {
            var e = Math.pow(10, Math.floor(Math.log(t) / Math.LN10)), i = t / e;
            return 2 === i ? i = 5 : i *= 2, i * e;
        }
        var n = this._indicatorAxes, r = this._model;
        R(n, function(t) {
            t.scale.setExtent(1 / 0, -1 / 0);
        }), i.eachSeriesByType("radar", function(t) {
            if ("radar" === t.get("coordinateSystem") && i.getComponent("radar", t.get("radarIndex")) === r) {
                var e = t.getData();
                R(n, function(t) {
                    t.scale.unionExtentFromData(e, e.mapDimension(t.dim));
                });
            }
        }, this);
        var f = r.get("splitNumber");
        R(n, function(t) {
            var e = bo(t.scale, t.model);
            So(t.scale, t.model);
            var i = t.model, n = t.scale, r = i.getMin(), a = i.getMax(), o = n.getInterval();
            if (null != r && null != a) n.setExtent(+r, +a), n.setInterval((a - r) / f); else if (null != r) for (var s; s = r + o * f, 
            n.setExtent(+r, s), n.setInterval(o), o = d(o), s < e[1] && isFinite(s) && isFinite(e[1]); ) ; else if (null != a) for (var l; l = a - o * f, 
            n.setExtent(l, +a), n.setInterval(o), o = d(o), l > e[0] && isFinite(l) && isFinite(e[0]); ) ; else {
                var h = n.getTicks().length - 1;
                f < h && (o = d(o));
                var u = Math.round((e[0] + e[1]) / 2 / o) * o, c = Math.round(f / 2);
                n.setExtent(Ln(u - c * o), Ln(u + (f - c) * o)), n.setInterval(o);
            }
        });
    }, qs.dimensions = [], qs.create = function(i, n) {
        var r = [];
        return i.eachComponent("radar", function(t) {
            var e = new qs(t, i, n);
            r.push(e), t.coordinateSystem = e;
        }), i.eachSeriesByType("radar", function(t) {
            "radar" === t.get("coordinateSystem") && (t.coordinateSystem = r[t.get("radarIndex") || 0]);
        }), r;
    }, ur.register("radar", qs);
    var Hm = Xg.valueAxis, Wm = (Ra({
        type: "radar",
        optionUpdated: function() {
            var r = this.get("boundaryGap"), a = this.get("splitNumber"), o = this.get("scale"), s = this.get("axisLine"), l = this.get("axisTick"), h = this.get("axisLabel"), u = this.get("name"), c = this.get("name.show"), d = this.get("name.formatter"), f = this.get("nameGap"), p = this.get("triggerEvent"), t = D(this.get("indicator") || [], function(t) {
                null != t.max && 0 < t.max && !t.min ? t.min = 0 : null != t.min && t.min < 0 && !t.max && (t.max = 0);
                var e = u;
                if (null != t.color && (e = C({
                    color: t.color
                }, u)), t = m(b(t), {
                    boundaryGap: r,
                    splitNumber: a,
                    scale: o,
                    axisLine: s,
                    axisTick: l,
                    axisLabel: h,
                    name: t.text,
                    nameLocation: "end",
                    nameGap: f,
                    nameTextStyle: e,
                    triggerEvent: p
                }, !1), c || (t.name = ""), "string" == typeof d) {
                    var i = t.name;
                    t.name = d.replace("{value}", null != i ? i : "");
                } else "function" == typeof d && (t.name = d(t.name, t));
                var n = A(new Tn(t, null, this.ecModel), Sg);
                return n.mainType = "radar", n.componentIndex = this.componentIndex, n;
            }, this);
            this.getIndicatorModels = function() {
                return t;
            };
        },
        defaultOption: {
            zlevel: 0,
            z: 0,
            center: [ "50%", "50%" ],
            radius: "75%",
            startAngle: 90,
            name: {
                show: !0
            },
            boundaryGap: [ 0, 0 ],
            splitNumber: 5,
            nameGap: 15,
            scale: !1,
            shape: "polygon",
            axisLine: m({
                lineStyle: {
                    color: "#bbb"
                }
            }, Hm.axisLine),
            axisLabel: js(Hm.axisLabel, !1),
            axisTick: js(Hm.axisTick, !1),
            splitLine: js(Hm.splitLine, !0),
            splitArea: js(Hm.splitArea, !0),
            indicator: []
        }
    }), [ "axisLine", "axisTickLabel", "axisName" ]);
    Na({
        type: "radar",
        render: function(t) {
            this.group.removeAll(), this._buildAxes(t), this._buildSplitLineAndArea(t);
        },
        _buildAxes: function(t) {
            var e = t.coordinateSystem;
            R(D(e.getIndicatorAxes(), function(t) {
                return new nm(t.model, {
                    position: [ e.cx, e.cy ],
                    rotation: t.angle,
                    labelDirection: -1,
                    tickDirection: -1,
                    nameDirection: 1
                });
            }), function(t) {
                R(Wm, t.add, t), this.group.add(t.getGroup());
            }, this);
        },
        _buildSplitLineAndArea: function(t) {
            function e(t, e, i) {
                var n = i % e.length;
                return t[n] = t[n] || [], n;
            }
            var n = t.coordinateSystem, i = n.getIndicatorAxes();
            if (i.length) {
                var r = t.get("shape"), a = t.getModel("splitLine"), o = t.getModel("splitArea"), s = a.getModel("lineStyle"), l = o.getModel("areaStyle"), h = a.get("show"), u = o.get("show"), c = s.get("color"), d = l.get("color");
                c = P(c) ? c : [ c ], d = P(d) ? d : [ d ];
                var f = [], p = [];
                if ("circle" === r) for (var g = i[0].getTicksCoords(), m = n.cx, v = n.cy, y = 0; y < g.length; y++) {
                    if (h) f[e(f, c, y)].push(new Zc({
                        shape: {
                            cx: m,
                            cy: v,
                            r: g[y].coord
                        }
                    }));
                    if (u && y < g.length - 1) p[e(p, d, y)].push(new Jc({
                        shape: {
                            cx: m,
                            cy: v,
                            r0: g[y].coord,
                            r: g[y + 1].coord
                        }
                    }));
                } else {
                    var x, _ = D(i, function(t, e) {
                        var i = t.getTicksCoords();
                        return x = null == x ? i.length - 1 : Math.min(i.length - 1, x), D(i, function(t) {
                            return n.coordToPoint(t.coord, e);
                        });
                    }), w = [];
                    for (y = 0; y <= x; y++) {
                        for (var b = [], S = 0; S < i.length; S++) b.push(_[S][y]);
                        if (b[0] && b.push(b[0].slice()), h) f[e(f, c, y)].push(new ed({
                            shape: {
                                points: b
                            }
                        }));
                        if (u && w) p[e(p, d, y - 1)].push(new td({
                            shape: {
                                points: b.concat(w)
                            }
                        }));
                        w = b.slice().reverse();
                    }
                }
                var M = s.getLineStyle(), I = l.getAreaStyle();
                R(p, function(t, e) {
                    this.group.add(md(t, {
                        style: C({
                            stroke: "none",
                            fill: d[e % d.length]
                        }, I),
                        silent: !0
                    }));
                }, this), R(f, function(t, e) {
                    this.group.add(md(t, {
                        style: C({
                            fill: "none",
                            stroke: c[e % c.length]
                        }, M),
                        silent: !0
                    }));
                }, this);
            }
        }
    });
    var Xm = Of.extend({
        type: "series.radar",
        dependencies: [ "radar" ],
        init: function() {
            Xm.superApply(this, "init", arguments), this.legendDataProvider = function() {
                return this.getRawData();
            };
        },
        getInitialData: function() {
            return Lm(this, {
                generateCoord: "indicator_",
                generateCoordCount: 1 / 0
            });
        },
        formatTooltip: function(i) {
            var n = this.getData(), t = this.coordinateSystem.getIndicatorAxes(), e = this.getData().getName(i);
            return Xn("" === e ? this.name : e) + "<br/>" + D(t, function(t) {
                var e = n.get(n.mapDimension(t.dim), i);
                return Xn(t.name + " : " + e);
            }).join("<br />");
        },
        defaultOption: {
            zlevel: 0,
            z: 2,
            coordinateSystem: "radar",
            legendHoverLink: !0,
            radarIndex: 0,
            lineStyle: {
                width: 2,
                type: "solid"
            },
            label: {
                position: "top"
            },
            symbol: "emptyCircle",
            symbolSize: 4
        }
    });
    Ga({
        type: "radar",
        render: function(l) {
            function h(t, e) {
                var i, n = t.getItemVisual(e, "symbol") || "circle", r = t.getItemVisual(e, "color");
                if ("none" !== n) {
                    var a = (P(i = t.getItemVisual(e, "symbolSize")) || (i = [ +i, +i ]), i), o = Do(n, -1, -1, 2, 2, r);
                    return o.attr({
                        style: {
                            strokeNoScale: !0
                        },
                        z2: 100,
                        scale: [ a[0] / 2, a[1] / 2 ]
                    }), o;
                }
            }
            function s(t, e, i, n, r, a) {
                i.removeAll();
                for (var o = 0; o < e.length - 1; o++) {
                    var s = h(n, r);
                    s && (t[s.__dimIdx = o] ? (s.attr("position", t[o]), xd[a ? "initProps" : "updateProps"](s, {
                        position: e[o]
                    }, l, r)) : s.attr("position", e[o]), i.add(s));
                }
            }
            function u(t) {
                return D(t, function() {
                    return [ e.cx, e.cy ];
                });
            }
            var e = l.coordinateSystem, v = this.group, y = l.getData(), c = this._data;
            y.diff(c).add(function(t) {
                var e = y.getItemLayout(t);
                if (e) {
                    var i = new td(), n = new ed(), r = {
                        shape: {
                            points: e
                        }
                    };
                    i.shape.points = u(e), n.shape.points = u(e), bn(i, r, l, t), bn(n, r, l, t);
                    var a = new Hh(), o = new Hh();
                    a.add(n), a.add(i), a.add(o), s(n.shape.points, e, o, y, t, !0), y.setItemGraphicEl(t, a);
                }
            }).update(function(t, e) {
                var i = c.getItemGraphicEl(e), n = i.childAt(0), r = i.childAt(1), a = i.childAt(2), o = {
                    shape: {
                        points: y.getItemLayout(t)
                    }
                };
                o.shape.points && (s(n.shape.points, o.shape.points, a, y, t, !1), wn(n, o, l), 
                wn(r, o, l), y.setItemGraphicEl(t, i));
            }).remove(function(t) {
                v.remove(c.getItemGraphicEl(t));
            }).execute(), y.eachItemGraphicEl(function(t, e) {
                function i() {
                    o.attr("ignore", d);
                }
                function n() {
                    o.attr("ignore", c);
                }
                var r = y.getItemModel(e), a = t.childAt(0), o = t.childAt(1), s = t.childAt(2), l = y.getItemVisual(e, "color");
                v.add(t), a.useStyle(C(r.getModel("lineStyle").getLineStyle(), {
                    fill: "none",
                    stroke: l
                })), a.hoverStyle = r.getModel("emphasis.lineStyle").getLineStyle();
                var h = r.getModel("areaStyle"), u = r.getModel("emphasis.areaStyle"), c = h.isEmpty() && h.parentModel.isEmpty(), d = u.isEmpty() && u.parentModel.isEmpty();
                d = d && c, o.ignore = c, o.useStyle(C(h.getAreaStyle(), {
                    fill: l,
                    opacity: .7
                })), o.hoverStyle = u.getAreaStyle();
                var f = r.getModel("itemStyle").getItemStyle([ "color" ]), p = r.getModel("emphasis.itemStyle").getItemStyle(), g = r.getModel("label"), m = r.getModel("emphasis.label");
                s.eachChild(function(t) {
                    t.setStyle(f), t.hoverStyle = b(p), dn(t.style, t.hoverStyle, g, m, {
                        labelFetcher: y.hostModel,
                        labelDataIndex: e,
                        labelDimIndex: t.__dimIdx,
                        defaultText: y.get(y.dimensions[t.__dimIdx], e),
                        autoColor: l,
                        isRectText: !0
                    });
                }), t.off("mouseover").off("mouseout").off("normal").off("emphasis"), t.on("emphasis", i).on("mouseover", i).on("normal", n).on("mouseout", n), 
                un(t);
            }), this._data = y;
        },
        remove: function() {
            this.group.removeAll(), this._data = null;
        },
        dispose: function() {}
    });
    Ea(Rm("radar")), Ea(Am("radar", "circle")), Oa(function(t) {
        t.eachSeriesByType("radar", function(t) {
            function e(t, e) {
                n[e] = n[e] || [], n[e][o] = r.dataToPoint(t, o);
            }
            var i = t.getData(), n = [], r = t.coordinateSystem;
            if (r) {
                for (var a = r.getIndicatorAxes(), o = 0; o < a.length; o++) i.each(i.mapDimension(a[o].dim), e);
                i.each(function(t) {
                    n[t][0] && n[t].push(n[t][0].slice()), i.setItemLayout(t, n[t]);
                });
            }
        });
    }), Pa(Vm("radar")), ka(function(e) {
        var t = e.polar;
        if (t) {
            P(t) || (t = [ t ]);
            var i = [];
            R(t, function(t) {
                t.indicator ? (t.type && !t.shape && (t.shape = t.type), e.radar = e.radar || [], 
                P(e.radar) || (e.radar = [ e.radar ]), e.radar.push(t)) : i.push(t);
            }), e.polar = i;
        }
        R(e.series, function(t) {
            t && "radar" === t.type && t.polarIndex && (t.radarIndex = t.polarIndex);
        });
    });
    var qm = Fa({
        type: "series.funnel",
        init: function(t) {
            qm.superApply(this, "init", arguments), this.legendDataProvider = function() {
                return this.getRawData();
            }, this._defaultLabelLine(t);
        },
        getInitialData: function() {
            return Lm(this, [ "value" ]);
        },
        _defaultLabelLine: function(t) {
            Ze(t, "labelLine", [ "show" ]);
            var e = t.labelLine, i = t.emphasis.labelLine;
            e.show = e.show && t.label.show, i.show = i.show && t.emphasis.label.show;
        },
        getDataParams: function(t) {
            var e = this.getData(), i = qm.superCall(this, "getDataParams", t), n = e.mapDimension("value"), r = e.getSum(n);
            return i.percent = r ? +(e.get(n, t) / r * 100).toFixed(2) : 0, i.$vars.push("percent"), 
            i;
        },
        defaultOption: {
            zlevel: 0,
            z: 2,
            legendHoverLink: !0,
            left: 80,
            top: 60,
            right: 80,
            bottom: 60,
            minSize: "0%",
            maxSize: "100%",
            sort: "descending",
            gap: 0,
            funnelAlign: "center",
            label: {
                show: !0,
                position: "outer"
            },
            labelLine: {
                show: !0,
                length: 20,
                lineStyle: {
                    width: 1,
                    type: "solid"
                }
            },
            itemStyle: {
                borderColor: "#fff",
                borderWidth: 1
            },
            emphasis: {
                label: {
                    show: !0
                }
            }
        }
    }), jm = Us.prototype, Um = [ "itemStyle", "opacity" ];
    jm.updateData = function(t, e, i) {
        var n = this.childAt(0), r = t.hostModel, a = t.getItemModel(e), o = t.getItemLayout(e), s = t.getItemModel(e).get(Um);
        s = null == s ? 1 : s, n.useStyle({}), i ? (n.setShape({
            points: o.points
        }), n.setStyle({
            opacity: 0
        }), bn(n, {
            style: {
                opacity: s
            }
        }, r, e)) : wn(n, {
            style: {
                opacity: s
            },
            shape: {
                points: o.points
            }
        }, r, e);
        var l = a.getModel("itemStyle"), h = t.getItemVisual(e, "color");
        n.setStyle(C({
            lineJoin: "round",
            fill: h
        }, l.getItemStyle([ "opacity" ]))), n.hoverStyle = l.getModel("emphasis").getItemStyle(), 
        this._updateLabel(t, e), un(this);
    }, jm._updateLabel = function(t, e) {
        var i = this.childAt(1), n = this.childAt(2), r = t.hostModel, a = t.getItemModel(e), o = t.getItemLayout(e).label, s = t.getItemVisual(e, "color");
        wn(i, {
            shape: {
                points: o.linePoints || o.linePoints
            }
        }, r, e), wn(n, {
            style: {
                x: o.x,
                y: o.y
            }
        }, r, e), n.attr({
            rotation: o.rotation,
            origin: [ o.x, o.y ],
            z2: 10
        });
        var l = a.getModel("label"), h = a.getModel("emphasis.label"), u = a.getModel("labelLine"), c = a.getModel("emphasis.labelLine");
        s = t.getItemVisual(e, "color");
        dn(n.style, n.hoverStyle = {}, l, h, {
            labelFetcher: t.hostModel,
            labelDataIndex: e,
            defaultText: t.getName(e),
            autoColor: s,
            useInsideStyle: !!o.inside
        }, {
            textAlign: o.textAlign,
            textVerticalAlign: o.verticalAlign
        }), n.ignore = n.normalIgnore = !l.get("show"), n.hoverIgnore = !h.get("show"), 
        i.ignore = i.normalIgnore = !u.get("show"), i.hoverIgnore = !c.get("show"), i.setStyle({
            stroke: s
        }), i.setStyle(u.getModel("lineStyle").getLineStyle()), i.hoverStyle = c.getModel("lineStyle").getLineStyle();
    }, a(Us, Hh);
    var Ym = (Vr.extend({
        type: "funnel",
        render: function(t) {
            var n = t.getData(), r = this._data, a = this.group;
            n.diff(r).add(function(t) {
                var e = new Us(n, t);
                n.setItemGraphicEl(t, e), a.add(e);
            }).update(function(t, e) {
                var i = r.getItemGraphicEl(e);
                i.updateData(n, t), a.add(i), n.setItemGraphicEl(t, i);
            }).remove(function(t) {
                var e = r.getItemGraphicEl(t);
                a.remove(e);
            }).execute(), this._data = n;
        },
        remove: function() {
            this.group.removeAll(), this._data = null;
        },
        dispose: function() {}
    }), function(t, S) {
        t.eachSeriesByType("funnel", function(t) {
            var e, r = t.getData(), a = r.mapDimension("value"), i = t.get("sort"), o = (e = S, 
            $n(t.getBoxLayoutParams(), {
                width: e.getWidth(),
                height: e.getHeight()
            })), n = function(t, e) {
                for (var i = t.mapDimension("value"), n = t.mapArray(i, function(t) {
                    return t;
                }), r = [], a = "ascending" === e, o = 0, s = t.count(); o < s; o++) r[o] = o;
                return "function" == typeof e ? r.sort(e) : "none" !== e && r.sort(function(t, e) {
                    return a ? n[t] - n[e] : n[e] - n[t];
                }), r;
            }(r, i), s = [ Pn(t.get("minSize"), o.width), Pn(t.get("maxSize"), o.width) ], l = r.getDataExtent(a), h = t.get("min"), u = t.get("max");
            null == h && (h = Math.min(l[0], 0)), null == u && (u = l[1]);
            var g, c = t.get("funnelAlign"), d = t.get("gap"), f = (o.height - d * (r.count() - 1)) / r.count(), p = o.y, m = function(t, e) {
                var i, n = kn(r.get(a, t) || 0, [ h, u ], s, !0);
                switch (c) {
                  case "left":
                    i = o.x;
                    break;

                  case "center":
                    i = o.x + (o.width - n) / 2;
                    break;

                  case "right":
                    i = o.x + o.width - n;
                }
                return [ [ i, e ], [ i + n, e ] ];
            };
            "ascending" === i && (f = -f, d = -d, p += o.height, n = n.reverse());
            for (var v = 0; v < n.length; v++) {
                var y = n[v], x = n[v + 1], _ = r.getItemModel(y).get("itemStyle.height");
                null == _ ? _ = f : (_ = Pn(_, o.height), "ascending" === i && (_ = -_));
                var w = m(y, p), b = m(x, p + _);
                p += _ + d, r.setItemLayout(y, {
                    points: w.concat(b.slice().reverse())
                });
            }
            (g = r).each(function(t) {
                var e, i, n, r, a = g.getItemModel(t), o = a.getModel("label").get("position"), s = a.getModel("labelLine"), l = g.getItemLayout(t), h = l.points, u = "inner" === o || "inside" === o || "center" === o;
                if (u) e = "center", r = [ [ i = (h[0][0] + h[1][0] + h[2][0] + h[3][0]) / 4, n = (h[0][1] + h[1][1] + h[2][1] + h[3][1]) / 4 ], [ i, n ] ]; else {
                    var c, d, f, p = s.get("length");
                    "left" === o ? (c = (h[3][0] + h[0][0]) / 2, d = (h[3][1] + h[0][1]) / 2, i = (f = c - p) - 5, 
                    e = "right") : (c = (h[1][0] + h[2][0]) / 2, d = (h[1][1] + h[2][1]) / 2, i = (f = c + p) + 5, 
                    e = "left"), r = [ [ c, d ], [ f, d ] ], n = d;
                }
                l.label = {
                    linePoints: r,
                    x: i,
                    y: n,
                    verticalAlign: "middle",
                    textAlign: e,
                    inside: u
                };
            });
        });
    });
    Ea(Rm("funnel")), Oa(Ym), Pa(Vm("funnel")), Ra({
        type: "title",
        layoutMode: {
            type: "box",
            ignoreSize: !0
        },
        defaultOption: {
            zlevel: 0,
            z: 6,
            show: !0,
            text: "",
            target: "blank",
            subtext: "",
            subtarget: "blank",
            left: 0,
            top: 0,
            backgroundColor: "rgba(0,0,0,0)",
            borderColor: "#ccc",
            borderWidth: 0,
            padding: 5,
            itemGap: 10,
            textStyle: {
                fontSize: 18,
                fontWeight: "bolder",
                color: "#333"
            },
            subtextStyle: {
                color: "#aaa"
            }
        }
    }), Na({
        type: "title",
        render: function(t, e, i) {
            if (this.group.removeAll(), t.get("show")) {
                var n = this.group, r = t.getModel("textStyle"), a = t.getModel("subtextStyle"), o = t.get("textAlign"), s = t.get("textBaseline"), l = new Yc({
                    style: fn({}, r, {
                        text: t.get("text"),
                        textFill: r.getTextColor()
                    }, {
                        disableBox: !0
                    }),
                    z2: 10
                }), h = l.getBoundingRect(), u = t.get("subtext"), c = new Yc({
                    style: fn({}, a, {
                        text: u,
                        textFill: a.getTextColor(),
                        y: h.height + t.get("itemGap"),
                        textVerticalAlign: "top"
                    }, {
                        disableBox: !0
                    }),
                    z2: 10
                }), d = t.get("link"), f = t.get("sublink"), p = t.get("triggerEvent", !0);
                l.silent = !d && !p, c.silent = !f && !p, d && l.on("click", function() {
                    window.open(d, "_" + t.get("target"));
                }), f && c.on("click", function() {
                    window.open(f, "_" + t.get("subtarget"));
                }), l.eventData = c.eventData = p ? {
                    componentType: "title",
                    componentIndex: t.componentIndex
                } : null, n.add(l), u && n.add(c);
                var g = n.getBoundingRect(), m = t.getBoxLayoutParams();
                m.width = g.width, m.height = g.height;
                var v = $n(m, {
                    width: i.getWidth(),
                    height: i.getHeight()
                }, t.get("padding"));
                o || ("middle" === (o = t.get("left") || t.get("right")) && (o = "center"), "right" === o ? v.x += v.width : "center" === o && (v.x += v.width / 2)), 
                s || ("center" === (s = t.get("top") || t.get("bottom")) && (s = "middle"), "bottom" === s ? v.y += v.height : "middle" === s && (v.y += v.height / 2), 
                s = s || "top"), n.attr("position", [ v.x, v.y ]);
                var y = {
                    textAlign: o,
                    textVerticalAlign: s
                };
                l.setStyle(y), c.setStyle(y), g = n.getBoundingRect();
                var x = v.margin, _ = t.getItemStyle([ "color", "opacity" ]);
                _.fill = t.get("backgroundColor");
                var w = new id({
                    shape: {
                        x: g.x - x[3],
                        y: g.y - x[0],
                        width: g.width + x[1] + x[3],
                        height: g.height + x[0] + x[2],
                        r: t.get("borderRadius")
                    },
                    style: _,
                    silent: !0
                });
                $i(w), n.add(w);
            }
        }
    });
    var Zm = Ra({
        type: "legend.plain",
        dependencies: [ "series" ],
        layoutMode: {
            type: "box",
            ignoreSize: !0
        },
        init: function(t, e, i) {
            this.mergeDefaultAndTheme(t, i), t.selected = t.selected || {};
        },
        mergeOption: function(t) {
            Zm.superCall(this, "mergeOption", t);
        },
        optionUpdated: function() {
            this._updateData(this.ecModel);
            var t = this._data;
            if (t[0] && "single" === this.get("selectedMode")) {
                for (var e = !1, i = 0; i < t.length; i++) {
                    var n = t[i].get("name");
                    if (this.isSelected(n)) {
                        this.select(n), e = !0;
                        break;
                    }
                }
                !e && this.select(t[0].get("name"));
            }
        },
        _updateData: function(a) {
            var o = [], s = [];
            a.eachRawSeries(function(t) {
                var e, i = t.name;
                if (s.push(i), t.legendDataProvider) {
                    var n = t.legendDataProvider(), r = n.mapArray(n.getName);
                    a.isSeriesFiltered(t) || (s = s.concat(r)), r.length ? o = o.concat(r) : e = !0;
                } else e = !0;
                e && Qe(t) && o.push(t.name);
            }), this._availableNames = s;
            var t = D(this.get("data") || o, function(t) {
                return ("string" == typeof t || "number" == typeof t) && (t = {
                    name: t
                }), new Tn(t, this, this.ecModel);
            }, this);
            this._data = t;
        },
        getData: function() {
            return this._data;
        },
        select: function(t) {
            var e = this.option.selected;
            "single" === this.get("selectedMode") && R(this._data, function(t) {
                e[t.get("name")] = !1;
            });
            e[t] = !0;
        },
        unSelect: function(t) {
            "single" !== this.get("selectedMode") && (this.option.selected[t] = !1);
        },
        toggleSelected: function(t) {
            var e = this.option.selected;
            e.hasOwnProperty(t) || (e[t] = !0), this[e[t] ? "unSelect" : "select"](t);
        },
        isSelected: function(t) {
            var e = this.option.selected;
            return !(e.hasOwnProperty(t) && !e[t]) && 0 <= d(this._availableNames, t);
        },
        defaultOption: {
            zlevel: 0,
            z: 4,
            show: !0,
            orient: "horizontal",
            left: "center",
            top: 0,
            align: "auto",
            backgroundColor: "rgba(0,0,0,0)",
            borderColor: "#ccc",
            borderRadius: 0,
            borderWidth: 0,
            padding: 5,
            itemGap: 10,
            itemWidth: 25,
            itemHeight: 14,
            inactiveColor: "#ccc",
            textStyle: {
                color: "#333"
            },
            selectedMode: !0,
            tooltip: {
                show: !1
            }
        }
    });
    La("legendToggleSelect", "legendselectchanged", g(Ys, "toggleSelected")), La("legendSelect", "legendselected", g(Ys, "select")), 
    La("legendUnSelect", "legendunselected", g(Ys, "unSelect"));
    var $m = g, Km = R, Qm = Hh, Jm = Na({
        type: "legend.plain",
        newlineDisabled: !1,
        init: function() {
            this.group.add(this._contentGroup = new Qm()), this._backgroundEl;
        },
        getContentGroup: function() {
            return this._contentGroup;
        },
        render: function(t, e, i) {
            if (this.resetInner(), t.get("show", !0)) {
                var n = t.get("align");
                n && "auto" !== n || (n = "right" === t.get("left") && "vertical" === t.get("orient") ? "right" : "left"), 
                this.renderInner(n, t, e, i);
                var r = t.getBoxLayoutParams(), a = {
                    width: i.getWidth(),
                    height: i.getHeight()
                }, o = t.get("padding"), s = $n(r, a, o), l = this.layoutInner(t, n, s), h = $n(C({
                    width: l.width,
                    height: l.height
                }, r), a, o);
                this.group.attr("position", [ h.x - l.x, h.y - l.y ]), this.group.add(this._backgroundEl = (u = l, 
                d = Ld((c = t).get("padding")), (f = c.getItemStyle([ "color", "opacity" ])).fill = c.get("backgroundColor"), 
                u = new id({
                    shape: {
                        x: u.x - d[3],
                        y: u.y - d[0],
                        width: u.width + d[1] + d[3],
                        height: u.height + d[0] + d[2],
                        r: c.get("borderRadius")
                    },
                    style: f,
                    silent: !0,
                    z2: -1
                })));
            }
            var u, c, d, f;
        },
        resetInner: function() {
            this.getContentGroup().removeAll(), this._backgroundEl && this.group.remove(this._backgroundEl);
        },
        renderInner: function(l, h, u, c) {
            var d = this.getContentGroup(), f = T(), p = h.get("selectedMode"), g = [];
            u.eachRawSeries(function(t) {
                !t.get("legendHoverLink") && g.push(t.id);
            }), Km(h.getData(), function(r, a) {
                var o = r.get("name");
                if (this.newlineDisabled || "" !== o && "\n" !== o) {
                    var t = u.getSeriesByName(o)[0];
                    if (!f.get(o)) if (t) {
                        var e = t.getData(), i = e.getVisual("color");
                        "function" == typeof i && (i = i(t.getDataParams(0)));
                        var n = e.getVisual("legendSymbol") || "roundRect", s = e.getVisual("symbol");
                        this._createItem(o, a, r, h, n, s, l, i, p).on("click", $m(Zs, o, c)).on("mouseover", $m($s, t.name, null, c, g)).on("mouseout", $m(Ks, t.name, null, c, g)), 
                        f.set(o, !0);
                    } else u.eachRawSeries(function(t) {
                        if (!f.get(o) && t.legendDataProvider) {
                            var e = t.legendDataProvider(), i = e.indexOfName(o);
                            if (i < 0) return;
                            var n = e.getItemVisual(i, "color");
                            this._createItem(o, a, r, h, "roundRect", null, l, n, p).on("click", $m(Zs, o, c)).on("mouseover", $m($s, null, o, c, g)).on("mouseout", $m(Ks, null, o, c, g)), 
                            f.set(o, !0);
                        }
                    }, this);
                } else d.add(new Qm({
                    newline: !0
                }));
            }, this);
        },
        _createItem: function(t, e, i, n, r, a, o, s, l) {
            var h = n.get("itemWidth"), u = n.get("itemHeight"), c = n.get("inactiveColor"), d = n.get("symbolKeepAspect"), f = n.isSelected(t), p = new Qm(), g = i.getModel("textStyle"), m = i.get("icon"), v = i.getModel("tooltip"), y = v.parentModel;
            if (r = m || r, p.add(Do(r, 0, 0, h, u, f ? s : c, null == d || d)), !m && a && (a !== r || "none" === a)) {
                var x = .8 * u;
                "none" === a && (a = "circle"), p.add(Do(a, (h - x) / 2, (u - x) / 2, x, x, f ? s : c, null == d || d));
            }
            var _ = "left" === o ? h + 5 : -5, w = o, b = n.get("formatter"), S = t;
            "string" == typeof b && b ? S = b.replace("{name}", null != t ? t : "") : "function" == typeof b && (S = b(t)), 
            p.add(new Yc({
                style: fn({}, g, {
                    text: S,
                    x: _,
                    y: u / 2,
                    textFill: f ? g.getTextColor() : c,
                    textAlign: w,
                    textVerticalAlign: "middle"
                })
            }));
            var M = new id({
                shape: p.getBoundingRect(),
                invisible: !0,
                tooltip: v.get("show") ? A({
                    content: t,
                    formatter: y.get("formatter", !0) || function() {
                        return t;
                    },
                    formatterParams: {
                        componentType: "legend",
                        legendIndex: n.componentIndex,
                        name: t,
                        $vars: [ "name" ]
                    }
                }, v.option) : null
            });
            return p.add(M), p.eachChild(function(t) {
                t.silent = !0;
            }), M.silent = !l, this.getContentGroup().add(p), un(p), p.__legendDataIndex = e, 
            p;
        },
        layoutInner: function(t, e, i) {
            var n = this.getContentGroup();
            Wd(t.get("orient"), n, t.get("itemGap"), i.width, i.height);
            var r = n.getBoundingRect();
            return n.attr("position", [ -r.x, -r.y ]), this.group.getBoundingRect();
        }
    });
    Pa(function(t) {
        var i = t.findComponents({
            mainType: "legend"
        });
        i && i.length && t.filterSeries(function(t) {
            for (var e = 0; e < i.length; e++) if (!i[e].isSelected(t.name)) return !1;
            return !0;
        });
    }), jd.registerSubTypeDefaulter("legend", function() {
        return "plain";
    });
    var tv = Zm.extend({
        type: "legend.scroll",
        setScrollDataIndex: function(t) {
            this.option.scrollDataIndex = t;
        },
        defaultOption: {
            scrollDataIndex: 0,
            pageButtonItemGap: 5,
            pageButtonGap: null,
            pageButtonPosition: "end",
            pageFormatter: "{current}/{total}",
            pageIcons: {
                horizontal: [ "M0,0L12,-10L12,10z", "M0,0L-12,-10L-12,10z" ],
                vertical: [ "M0,0L20,0L10,-20z", "M0,0L20,0L10,20z" ]
            },
            pageIconColor: "#2f4554",
            pageIconInactiveColor: "#aaa",
            pageIconSize: 15,
            pageTextStyle: {
                color: "#333"
            },
            animationDurationUpdate: 800
        },
        init: function(t, e, i, n) {
            var r = Qn(t);
            tv.superCall(this, "init", t, e, i, n), Qs(this, t, r);
        },
        mergeOption: function(t, e) {
            tv.superCall(this, "mergeOption", t, e), Qs(this, this.option, t);
        },
        getOrient: function() {
            return "vertical" === this.get("orient") ? {
                index: 1,
                name: "vertical"
            } : {
                index: 0,
                name: "horizontal"
            };
        }
    }), ev = Hh, iv = [ "width", "height" ], nv = [ "x", "y" ], rv = Jm.extend({
        type: "legend.scroll",
        newlineDisabled: !0,
        init: function() {
            rv.superCall(this, "init"), this._currentIndex = 0, this.group.add(this._containerGroup = new ev()), 
            this._containerGroup.add(this.getContentGroup()), this.group.add(this._controllerGroup = new ev()), 
            this._showController;
        },
        resetInner: function() {
            rv.superCall(this, "resetInner"), this._controllerGroup.removeAll(), this._containerGroup.removeClipPath(), 
            this._containerGroup.__rectSize = null;
        },
        renderInner: function(t, r, e, a) {
            function i(t, e) {
                var i = t + "DataIndex", n = In(r.get("pageIcons", !0)[r.getOrient().name][e], {
                    onclick: _(o._pageGo, o, i, r, a)
                }, {
                    x: -l[0] / 2,
                    y: -l[1] / 2,
                    width: l[0],
                    height: l[1]
                });
                n.name = t, s.add(n);
            }
            var o = this;
            rv.superCall(this, "renderInner", t, r, e, a);
            var s = this._controllerGroup, l = r.get("pageIconSize", !0);
            P(l) || (l = [ l, l ]), i("pagePrev", 0);
            var n = r.getModel("pageTextStyle");
            s.add(new Yc({
                name: "pageText",
                style: {
                    textFill: n.getTextColor(),
                    font: n.getFont(),
                    textVerticalAlign: "middle",
                    textAlign: "center"
                },
                silent: !0
            })), i("pageNext", 1);
        },
        layoutInner: function(t, e, i) {
            var n = this.getContentGroup(), r = this._containerGroup, a = this._controllerGroup, o = t.getOrient().index, s = iv[o], l = iv[1 - o], h = nv[1 - o];
            Wd(t.get("orient"), n, t.get("itemGap"), o ? i.width : null, o ? null : i.height), 
            Wd("horizontal", a, t.get("pageButtonItemGap", !0));
            var u = n.getBoundingRect(), c = a.getBoundingRect(), d = this._showController = u[s] > i[s], f = [ -u.x, -u.y ];
            f[o] = n.position[o];
            var p = [ 0, 0 ], g = [ -c.x, -c.y ], m = O(t.get("pageButtonGap", !0), t.get("itemGap", !0));
            d && ("end" === t.get("pageButtonPosition", !0) ? g[o] += i[s] - c[s] : p[o] += c[s] + m);
            g[1 - o] += u[l] / 2 - c[l] / 2, n.attr("position", f), r.attr("position", p), a.attr("position", g);
            var v = this.group.getBoundingRect();
            if ((v = {
                x: 0,
                y: 0
            })[s] = d ? i[s] : u[s], v[l] = Math.max(u[l], c[l]), v[h] = Math.min(0, c[h] + g[1 - o]), 
            r.__rectSize = i[s], d) {
                var y = {
                    x: 0,
                    y: 0
                };
                y[s] = Math.max(i[s] - c[s] - m, 0), y[l] = v[l], r.setClipPath(new id({
                    shape: y
                })), r.__rectSize = y[s];
            } else a.eachChild(function(t) {
                t.attr({
                    invisible: !0,
                    silent: !0
                });
            });
            var x = this._getPageInfo(t);
            return null != x.pageIndex && wn(n, {
                position: x.contentPosition
            }, !!d && t), this._updatePageInfoView(t, x), v;
        },
        _pageGo: function(t, e, i) {
            var n = this._getPageInfo(e)[t];
            null != n && i.dispatchAction({
                type: "legendScroll",
                scrollDataIndex: n,
                legendId: e.id
            });
        },
        _updatePageInfoView: function(n, r) {
            var a = this._controllerGroup;
            R([ "pagePrev", "pageNext" ], function(t) {
                var e = null != r[t + "DataIndex"], i = a.childOfName(t);
                i && (i.setStyle("fill", e ? n.get("pageIconColor", !0) : n.get("pageIconInactiveColor", !0)), 
                i.cursor = e ? "pointer" : "default");
            });
            var t = a.childOfName("pageText"), e = n.get("pageFormatter"), i = r.pageIndex, o = null != i ? i + 1 : 0, s = r.pageCount;
            t && e && t.setStyle("text", M(e) ? e.replace("{current}", o).replace("{total}", s) : e({
                current: o,
                total: s
            }));
        },
        _getPageInfo: function(t) {
            function n(t) {
                var e = t.getBoundingRect().clone();
                return e[f] += t.position[u], e;
            }
            var e, i, r, a, o = t.get("scrollDataIndex", !0), s = this.getContentGroup(), l = s.getBoundingRect(), h = this._containerGroup.__rectSize, u = t.getOrient().index, c = iv[u], d = iv[1 - u], f = nv[u], p = s.position.slice();
            this._showController ? s.eachChild(function(t) {
                t.__legendDataIndex === o && (a = t);
            }) : a = s.childAt(0);
            var g = h ? Math.ceil(l[c] / h) : 0;
            if (a) {
                var m = a.getBoundingRect(), v = a.position[u] + m[f];
                p[u] = -v - l[f], e = Math.floor(g * (v + m[f] + h / 2) / l[c]), e = l[c] && g ? Math.max(0, Math.min(g - 1, e)) : -1;
                var y = {
                    x: 0,
                    y: 0
                };
                y[c] = h, y[d] = l[d], y[f] = -p[u] - l[f];
                var x, _ = s.children();
                if (s.eachChild(function(t, e) {
                    var i = n(t);
                    i.intersect(y) && (null == x && (x = e), r = t.__legendDataIndex), e === _.length - 1 && i[f] + i[c] <= y[f] + y[c] && (r = null);
                }), null != x) {
                    var w = n(_[x]);
                    if (y[f] = w[f] + w[c] - y[c], x <= 0 && w[f] >= y[f]) i = null; else {
                        for (;0 < x && n(_[x - 1]).intersect(y); ) x--;
                        i = _[x].__legendDataIndex;
                    }
                }
            }
            return {
                contentPosition: p,
                pageIndex: e,
                pageCount: g,
                pagePrevDataIndex: i,
                pageNextDataIndex: r
            };
        }
    });
    La("legendScroll", "legendscroll", function(t, e) {
        var i = t.scrollDataIndex;
        null != i && e.eachComponent({
            mainType: "legend",
            subType: "scroll",
            query: t
        }, function(t) {
            t.setScrollDataIndex(i);
        });
    });
    var av = function(t, e) {
        var i, n = [], r = t.seriesIndex;
        if (null == r || !(i = e.getSeriesByIndex(r))) return {
            point: []
        };
        var a = i.getData(), o = ti(a, t);
        if (null == o || o < 0 || P(o)) return {
            point: []
        };
        var s = a.getItemGraphicEl(o), l = i.coordinateSystem;
        if (i.getTooltipPosition) n = i.getTooltipPosition(o) || []; else if (l && l.dataToPoint) n = l.dataToPoint(a.getValues(D(l.dimensions, function(t) {
            return a.mapDimension(t);
        }), o, !0)) || []; else if (s) {
            var h = s.getBoundingRect().clone();
            h.applyTransform(s.transform), n = [ h.x + h.width / 2, h.y + h.height / 2 ];
        }
        return {
            point: n,
            el: s
        };
    }, ov = R, sv = g, lv = ei(), hv = (Ra({
        type: "axisPointer",
        coordSysAxesInfo: null,
        defaultOption: {
            show: "auto",
            triggerOn: null,
            zlevel: 0,
            z: 50,
            type: "line",
            snap: !1,
            triggerTooltip: !0,
            value: null,
            status: null,
            link: [],
            animation: null,
            animationDurationUpdate: 200,
            lineStyle: {
                color: "#aaa",
                width: 1,
                type: "solid"
            },
            shadowStyle: {
                color: "rgba(150,150,150,0.3)"
            },
            label: {
                show: !0,
                formatter: null,
                precision: "auto",
                margin: 3,
                color: "#fff",
                padding: [ 5, 7, 5, 7 ],
                backgroundColor: "auto",
                borderColor: null,
                borderWidth: 0,
                shadowBlur: 3,
                shadowColor: "#aaa"
            },
            handle: {
                show: !1,
                icon: "M10.7,11.9v-1.3H9.3v1.3c-4.9,0.3-8.8,4.4-8.8,9.4c0,5,3.9,9.1,8.8,9.4h1.3c4.9-0.3,8.8-4.4,8.8-9.4C19.5,16.3,15.6,12.2,10.7,11.9z M13.3,24.4H6.7v-1.2h6.6z M13.3,22H6.7v-1.2h6.6z M13.3,19.6H6.7v-1.2h6.6z",
                size: 45,
                margin: 50,
                color: "#333",
                shadowBlur: 3,
                shadowColor: "#aaa",
                shadowOffsetX: 0,
                shadowOffsetY: 2,
                throttle: 40
            }
        }
    }), ei()), uv = R, cv = Na({
        type: "axisPointer",
        render: function(t, e, i) {
            var n = e.getComponent("tooltip"), r = t.get("triggerOn") || n && n.get("triggerOn") || "mousemove|click";
            rl("axisPointer", i, function(t, e, i) {
                "none" !== r && ("leave" === t || 0 <= r.indexOf(t)) && i({
                    type: "updateAxisPointer",
                    currTrigger: t,
                    x: e && e.offsetX,
                    y: e && e.offsetY
                });
            });
        },
        remove: function(t, e) {
            sl(e.getZr(), "axisPointer"), cv.superApply(this._model, "remove", arguments);
        },
        dispose: function(t, e) {
            sl("axisPointer", e), cv.superApply(this._model, "dispose", arguments);
        }
    }), dv = ei(), fv = b, pv = _;
    si((ll.prototype = {
        _group: null,
        _lastGraphicKey: null,
        _handle: null,
        _dragging: !1,
        _lastValue: null,
        _lastStatus: null,
        _payloadInfo: null,
        animationThreshold: 15,
        render: function(t, e, i, n) {
            var r = e.get("value"), a = e.get("status");
            if (this._axisModel = t, this._axisPointerModel = e, this._api = i, n || this._lastValue !== r || this._lastStatus !== a) {
                this._lastValue = r, this._lastStatus = a;
                var o = this._group, s = this._handle;
                if (!a || "hide" === a) return o && o.hide(), void (s && s.hide());
                o && o.show(), s && s.show();
                var l = {};
                this.makeElOption(l, r, t, e, i);
                var h = l.graphicKey;
                h !== this._lastGraphicKey && this.clear(i), this._lastGraphicKey = h;
                var u = this._moveAnimation = this.determineAnimation(t, e);
                if (o) {
                    var c = g(hl, e, u);
                    this.updatePointerEl(o, l, c, e), this.updateLabelEl(o, l, c, e);
                } else o = this._group = new Hh(), this.createPointerEl(o, l, t, e), this.createLabelEl(o, l, t, e), 
                i.getZr().add(o);
                dl(o, e, !0), this._renderHandle(r);
            }
        },
        remove: function(t) {
            this.clear(t);
        },
        dispose: function(t) {
            this.clear(t);
        },
        determineAnimation: function(t, e) {
            var i = e.get("animation"), n = t.axis, r = "category" === n.type, a = e.get("snap");
            if (!a && !r) return !1;
            if ("auto" === i || null == i) {
                var o = this.animationThreshold;
                if (r && n.getBandWidth() > o) return !0;
                if (a) {
                    var s = cs(t).seriesDataCount, l = n.getExtent();
                    return Math.abs(l[0] - l[1]) / s > o;
                }
                return !1;
            }
            return !0 === i;
        },
        makeElOption: function() {},
        createPointerEl: function(t, e) {
            var i = e.pointer;
            if (i) {
                var n = dv(t).pointerEl = new xd[i.type](fv(e.pointer));
                t.add(n);
            }
        },
        createLabelEl: function(t, e, i, n) {
            if (e.label) {
                var r = dv(t).labelEl = new id(fv(e.label));
                t.add(r), ul(r, n);
            }
        },
        updatePointerEl: function(t, e, i) {
            var n = dv(t).pointerEl;
            n && (n.setStyle(e.pointer.style), i(n, {
                shape: e.pointer.shape
            }));
        },
        updateLabelEl: function(t, e, i, n) {
            var r = dv(t).labelEl;
            r && (r.setStyle(e.label.style), i(r, {
                shape: e.label.shape,
                position: e.label.position
            }), ul(r, n));
        },
        _renderHandle: function(t) {
            if (!this._dragging && this.updateHandleTransform) {
                var e, i = this._axisPointerModel, n = this._api.getZr(), r = this._handle, a = i.getModel("handle"), o = i.get("status");
                if (!a.get("show") || !o || "hide" === o) return r && n.remove(r), void (this._handle = null);
                this._handle || (e = !0, r = this._handle = In(a.get("icon"), {
                    cursor: "move",
                    draggable: !0,
                    onmousemove: function(t) {
                        nh(t.event);
                    },
                    onmousedown: pv(this._onHandleDragMove, this, 0, 0),
                    drift: pv(this._onHandleDragMove, this),
                    ondragend: pv(this._onHandleDragEnd, this)
                }), n.add(r)), dl(r, i, !1);
                r.setStyle(a.getItemStyle(null, [ "color", "borderColor", "borderWidth", "opacity", "shadowColor", "shadowBlur", "shadowOffsetX", "shadowOffsetY" ]));
                var s = a.get("size");
                P(s) || (s = [ s, s ]), r.attr("scale", [ s[0] / 2, s[1] / 2 ]), function(t, e, i, n) {
                    var r = t[e];
                    if (r) {
                        var a = r[Vf] || r, o = r[Wf];
                        if (r[Hf] !== i || o !== n) {
                            if (null == i || !n) return t[e] = a;
                            (r = t[e] = jr(a, i, "debounce" === n))[Vf] = a, r[Wf] = n, r[Hf] = i;
                        }
                    }
                }(this, "_doDispatchAxisPointer", a.get("throttle") || 0, "fixRate"), this._moveHandleToValue(t, e);
            }
        },
        _moveHandleToValue: function(t, e) {
            hl(this._axisPointerModel, !e && this._moveAnimation, this._handle, cl(this.getHandleTransform(t, this._axisModel, this._axisPointerModel)));
        },
        _onHandleDragMove: function(t, e) {
            var i = this._handle;
            if (i) {
                this._dragging = !0;
                var n = this.updateHandleTransform(cl(i), [ t, e ], this._axisModel, this._axisPointerModel);
                this._payloadInfo = n, i.stopAnimation(), i.attr(cl(n)), dv(i).lastProp = null, 
                this._doDispatchAxisPointer();
            }
        },
        _doDispatchAxisPointer: function() {
            if (this._handle) {
                var t = this._payloadInfo, e = this._axisModel;
                this._api.dispatchAction({
                    type: "updateAxisPointer",
                    x: t.cursorPoint[0],
                    y: t.cursorPoint[1],
                    tooltipOption: t.tooltipOption,
                    axesInfo: [ {
                        axisDim: e.axis.dim,
                        axisIndex: e.componentIndex
                    } ]
                });
            }
        },
        _onHandleDragEnd: function() {
            if (this._dragging = !1, this._handle) {
                var t = this._axisPointerModel.get("value");
                this._moveHandleToValue(t), this._api.dispatchAction({
                    type: "hideTip"
                });
            }
        },
        getHandleTransform: null,
        updateHandleTransform: null,
        clear: function(t) {
            this._lastValue = null, this._lastStatus = null;
            var e = t.getZr(), i = this._group, n = this._handle;
            e && i && (this._lastGraphicKey = null, i && e.remove(i), n && e.remove(n), this._group = null, 
            this._handle = null, this._payloadInfo = null);
        },
        doClear: function() {},
        buildLabel: function(t, e, i) {
            return {
                x: t[i = i || 0],
                y: t[1 - i],
                width: e[i],
                height: e[1 - i]
            };
        }
    }).constructor = ll);
    var gv = ll.extend({
        makeElOption: function(t, e, i, n, r) {
            var a, o, s, l, h = i.axis, u = h.grid, c = n.get("type"), d = ml(u, h).getOtherAxis(h).getGlobalExtent(), f = h.toGlobalCoord(h.dataToCoord(e, !0));
            if (c && "none" !== c) {
                var p = (s = (a = n).get("type"), l = a.getModel(s + "Style"), "line" === s ? (o = l.getLineStyle()).fill = null : "shadow" === s && ((o = l.getAreaStyle()).stroke = null), 
                o), g = mv[c](h, f, d, p);
                g.style = p, t.graphicKey = g.type, t.pointer = g;
            }
            var m, v, y, x, _, w, b, S = vs(u.model, i);
            m = e, v = t, x = i, _ = n, w = r, b = nm.innerTextLayout((y = S).rotation, 0, y.labelDirection), 
            y.labelMargin = _.get("label.margin"), fl(v, x, _, w, {
                position: gl(x.axis, m, y),
                align: b.textAlign,
                verticalAlign: b.textVerticalAlign
            });
        },
        getHandleTransform: function(t, e, i) {
            var n = vs(e.axis.grid.model, e, {
                labelInside: !1
            });
            return n.labelMargin = i.get("handle.margin"), {
                position: gl(e.axis, t, n),
                rotation: n.rotation + (n.labelDirection < 0 ? Math.PI : 0)
            };
        },
        updateHandleTransform: function(t, e, i) {
            var n = i.axis, r = n.grid, a = n.getGlobalExtent(!0), o = ml(r, n).getOtherAxis(n).getGlobalExtent(), s = "x" === n.dim ? 0 : 1, l = t.position;
            l[s] += e[s], l[s] = Math.min(a[1], l[s]), l[s] = Math.max(a[0], l[s]);
            var h = (o[1] + o[0]) / 2, u = [ h, h ];
            u[s] = l[s];
            return {
                position: l,
                rotation: t.rotation,
                cursorPoint: u,
                tooltipOption: [ {
                    verticalAlign: "middle"
                }, {
                    align: "center"
                } ][s]
            };
        }
    }), mv = {
        line: function(t, e, i, n) {
            var r, a, o, s = (r = [ e, i[0] ], a = [ e, i[1] ], o = vl(t), {
                x1: r[o = o || 0],
                y1: r[1 - o],
                x2: a[o],
                y2: a[1 - o]
            });
            return Zi({
                shape: s,
                style: n
            }), {
                type: "Line",
                shape: s
            };
        },
        shadow: function(t, e, i) {
            var n, r, a, o = Math.max(1, t.getBandWidth()), s = i[1] - i[0];
            return {
                type: "Rect",
                shape: (n = [ e - o / 2, i[0] ], r = [ o, s ], a = vl(t), {
                    x: n[a = a || 0],
                    y: n[1 - a],
                    width: r[a],
                    height: r[1 - a]
                })
            };
        }
    };
    lm.registerAxisPointerClass("CartesianAxisPointer", gv), ka(function(t) {
        if (t) {
            (!t.axisPointer || 0 === t.axisPointer.length) && (t.axisPointer = {});
            var e = t.axisPointer.link;
            e && !P(e) && (t.axisPointer.link = [ e ]);
        }
    }), Pa(xp.PROCESSOR.STATISTIC, function(t, e) {
        t.getComponent("axisPointer").coordSysAxesInfo = hs(t, e);
    }), La({
        type: "updateAxisPointer",
        event: "updateAxisPointer",
        update: ":updateAxisPointer"
    }, function(t, e, i) {
        var r, n, a, o = t.currTrigger, s = [ t.x, t.y ], l = t, h = t.dispatchAction || _(i.dispatchAction, i), u = e.getComponent("axisPointer").coordSysAxesInfo;
        if (u) {
            nl(s) && (s = av({
                seriesIndex: l.seriesIndex,
                dataIndex: l.dataIndex
            }, e).point);
            var c = nl(s), d = l.axesInfo, f = u.axesInfo, p = "leave" === o || nl(s), g = {}, m = {}, v = {
                list: [],
                map: {}
            }, y = {
                showPointer: sv(tl, m),
                showTooltip: sv(el, v)
            };
            ov(u.coordSysMap, function(t, e) {
                var r = c || t.containPoint(s);
                ov(u.coordSysAxesInfo[e], function(t) {
                    var e = t.axis, i = function(t, e) {
                        for (var i = 0; i < (t || []).length; i++) {
                            var n = t[i];
                            if (e.axis.dim === n.axisDim && e.axis.model.componentIndex === n.axisIndex) return n;
                        }
                    }(d, t);
                    if (!p && r && (!d || i)) {
                        var n = i && i.value;
                        null != n || c || (n = e.pointToData(s)), null != n && Js(t, n, y, !1, g);
                    }
                });
            });
            var x = {};
            return ov(f, function(r, t) {
                var a = r.linkGroup;
                a && !m[t] && ov(a.axesInfo, function(t, e) {
                    var i = m[e];
                    if (t !== r && i) {
                        var n = i.value;
                        a.mapper && (n = r.axis.scale.parse(a.mapper(n, il(t), il(r)))), x[r.key] = n;
                    }
                });
            }), ov(x, function(t, e) {
                Js(f[e], t, y, !0, g);
            }), r = m, n = f, a = g.axesInfo = [], ov(n, function(t, e) {
                var i = t.axisPointerModel.option, n = r[e];
                n ? (!t.useHandle && (i.status = "show"), i.value = n.value, i.seriesDataIndices = (n.payloadBatch || []).slice()) : !t.useHandle && (i.status = "hide"), 
                "show" === i.status && a.push({
                    axisDim: t.axis.dim,
                    axisIndex: t.axis.model.componentIndex,
                    value: i.value
                });
            }), function(t, e, i, n) {
                if (!nl(e) && t.list.length) {
                    var r = ((t.list[0].dataByAxis[0] || {}).seriesDataIndices || [])[0] || {};
                    n({
                        type: "showTip",
                        escapeConnect: !0,
                        x: e[0],
                        y: e[1],
                        tooltipOption: i.tooltipOption,
                        position: i.position,
                        dataIndexInside: r.dataIndexInside,
                        dataIndex: r.dataIndex,
                        seriesIndex: r.seriesIndex,
                        dataByCoordSys: t.list
                    });
                } else n({
                    type: "hideTip"
                });
            }(v, s, t, h), function(t, e, i) {
                var n = i.getZr(), r = "axisPointerLastHighlights", a = lv(n)[r] || {}, o = lv(n)[r] = {};
                ov(t, function(t) {
                    var e = t.axisPointerModel.option;
                    "show" === e.status && ov(e.seriesDataIndices, function(t) {
                        var e = t.seriesIndex + " | " + t.dataIndex;
                        o[e] = t;
                    });
                });
                var s = [], l = [];
                R(a, function(t, e) {
                    !o[e] && l.push(t);
                }), R(o, function(t, e) {
                    !a[e] && s.push(t);
                }), l.length && i.dispatchAction({
                    type: "downplay",
                    escapeConnect: !0,
                    batch: l
                }), s.length && i.dispatchAction({
                    type: "highlight",
                    escapeConnect: !0,
                    batch: s
                });
            }(f, 0, i), g;
        }
    }), Ra({
        type: "tooltip",
        dependencies: [ "axisPointer" ],
        defaultOption: {
            zlevel: 0,
            z: 60,
            show: !0,
            showContent: !0,
            trigger: "item",
            triggerOn: "mousemove|click",
            alwaysShowContent: !1,
            displayMode: "single",
            renderMode: "auto",
            confine: !1,
            showDelay: 0,
            hideDelay: 100,
            transitionDuration: .4,
            enterable: !1,
            backgroundColor: "rgba(50,50,50,0.7)",
            borderColor: "#333",
            borderRadius: 4,
            borderWidth: 0,
            padding: 5,
            extraCssText: "",
            axisPointer: {
                type: "line",
                axis: "auto",
                animation: "auto",
                animationDurationUpdate: 200,
                animationEasingUpdate: "exponentialOut",
                crossStyle: {
                    color: "#999",
                    width: 1,
                    type: "dashed",
                    textStyle: {}
                }
            },
            textStyle: {
                color: "#fff",
                fontSize: 14
            }
        }
    });
    var vv = R, yv = Wn, xv = [ "", "-webkit-", "-moz-", "-o-" ];
    xl.prototype = {
        constructor: xl,
        _enterable: !0,
        update: function() {
            var t = this._container, e = t.currentStyle || document.defaultView.getComputedStyle(t), i = t.style;
            "absolute" !== i.position && "absolute" !== e.position && (i.position = "relative");
        },
        show: function(t) {
            clearTimeout(this._hideTimeout);
            var e = this.el;
            e.style.cssText = "position:absolute;display:block;border-style:solid;white-space:nowrap;z-index:9999999;" + yl(t) + ";left:" + this._x + "px;top:" + this._y + "px;" + (t.get("extraCssText") || ""), 
            e.style.display = e.innerHTML ? "block" : "none", e.style.pointerEvents = this._enterable ? "auto" : "none", 
            this._show = !0;
        },
        setContent: function(t) {
            this.el.innerHTML = null == t ? "" : t;
        },
        setEnterable: function(t) {
            this._enterable = t;
        },
        getSize: function() {
            var t = this.el;
            return [ t.clientWidth, t.clientHeight ];
        },
        moveTo: function(t, e) {
            var i, n = this._zr;
            n && n.painter && (i = n.painter.getViewportRootOffset()) && (t += i.offsetLeft, 
            e += i.offsetTop);
            var r = this.el.style;
            r.left = t + "px", r.top = e + "px", this._x = t, this._y = e;
        },
        hide: function() {
            this.el.style.display = "none", this._show = !1;
        },
        hideLater: function(t) {
            !this._show || this._inContent && this._enterable || (t ? (this._hideDelay = t, 
            this._show = !1, this._hideTimeout = setTimeout(_(this.hide, this), t)) : this.hide());
        },
        isShow: function() {
            return this._show;
        },
        getOuterSize: function() {
            var t = this.el.clientWidth, e = this.el.clientHeight;
            if (document.defaultView && document.defaultView.getComputedStyle) {
                var i = document.defaultView.getComputedStyle(this.el);
                i && (t += parseInt(i.paddingLeft, 10) + parseInt(i.paddingRight, 10) + parseInt(i.borderLeftWidth, 10) + parseInt(i.borderRightWidth, 10), 
                e += parseInt(i.paddingTop, 10) + parseInt(i.paddingBottom, 10) + parseInt(i.borderTopWidth, 10) + parseInt(i.borderBottomWidth, 10));
            }
            return {
                width: t,
                height: e
            };
        }
    }, _l.prototype = {
        constructor: _l,
        _enterable: !0,
        update: function() {},
        show: function() {
            this._hideTimeout && clearTimeout(this._hideTimeout), this.el.attr("show", !0), 
            this._show = !0;
        },
        setContent: function(t, e, i) {
            this.el && this._zr.remove(this.el);
            for (var n = {}, r = t, a = "{marker", o = r.indexOf(a); 0 <= o; ) {
                var s = r.indexOf("|}"), l = r.substr(o + a.length, s - o - a.length);
                n["marker" + l] = -1 < l.indexOf("sub") ? {
                    textWidth: 4,
                    textHeight: 4,
                    textBorderRadius: 2,
                    textBackgroundColor: e[l],
                    textOffset: [ 3, 0 ]
                } : {
                    textWidth: 10,
                    textHeight: 10,
                    textBorderRadius: 5,
                    textBackgroundColor: e[l]
                }, o = (r = r.substr(s + 1)).indexOf("{marker");
            }
            this.el = new Yc({
                style: {
                    rich: n,
                    text: t,
                    textLineHeight: 20,
                    textBackgroundColor: i.get("backgroundColor"),
                    textBorderRadius: i.get("borderRadius"),
                    textFill: i.get("textStyle.color"),
                    textPadding: i.get("padding")
                },
                z: i.get("z")
            }), this._zr.add(this.el);
            var h = this;
            this.el.on("mouseover", function() {
                h._enterable && (clearTimeout(h._hideTimeout), h._show = !0), h._inContent = !0;
            }), this.el.on("mouseout", function() {
                h._enterable && h._show && h.hideLater(h._hideDelay), h._inContent = !1;
            });
        },
        setEnterable: function(t) {
            this._enterable = t;
        },
        getSize: function() {
            var t = this.el.getBoundingRect();
            return [ t.width, t.height ];
        },
        moveTo: function(t, e) {
            this.el && this.el.attr("position", [ t, e ]);
        },
        hide: function() {
            this.el.hide(), this._show = !1;
        },
        hideLater: function(t) {
            !this._show || this._inContent && this._enterable || (t ? (this._hideDelay = t, 
            this._show = !1, this._hideTimeout = setTimeout(_(this.hide, this), t)) : this.hide());
        },
        isShow: function() {
            return this._show;
        },
        getOuterSize: function() {
            return this.getSize();
        }
    };
    var _v = _, wv = R, bv = Pn, Sv = new id({
        shape: {
            x: -1,
            y: -1,
            width: 2,
            height: 2
        }
    });
    Na({
        type: "tooltip",
        init: function(t, e) {
            if (!Ll.node) {
                var i, n = t.getComponent("tooltip").get("renderMode");
                this._renderMode = ai(n), "html" === this._renderMode ? (i = new xl(e.getDom(), e), 
                this._newLine = "<br/>") : (i = new _l(e), this._newLine = "\n"), this._tooltipContent = i;
            }
        },
        render: function(t, e, i) {
            if (!Ll.node) {
                this.group.removeAll(), this._tooltipModel = t, this._ecModel = e, this._api = i, 
                this._lastDataByCoordSys = null, this._alwaysShowContent = t.get("alwaysShowContent");
                var n = this._tooltipContent;
                n.update(), n.setEnterable(t.get("enterable")), this._initGlobalListener(), this._keepShow();
            }
        },
        _initGlobalListener: function() {
            var n = this._tooltipModel.get("triggerOn");
            rl("itemTooltip", this._api, _v(function(t, e, i) {
                "none" !== n && (0 <= n.indexOf(t) ? this._tryShow(e, i) : "leave" === t && this._hide(i));
            }, this));
        },
        _keepShow: function() {
            var t = this._tooltipModel, e = this._ecModel, i = this._api;
            if (null != this._lastX && null != this._lastY && "none" !== t.get("triggerOn")) {
                var n = this;
                clearTimeout(this._refreshUpdateTimeout), this._refreshUpdateTimeout = setTimeout(function() {
                    n.manuallyShowTip(t, e, i, {
                        x: n._lastX,
                        y: n._lastY
                    });
                });
            }
        },
        manuallyShowTip: function(t, e, i, n) {
            if (n.from !== this.uid && !Ll.node) {
                var r = bl(n, i);
                this._ticket = "";
                var a = n.dataByCoordSys;
                if (n.tooltip && null != n.x && null != n.y) {
                    var o = Sv;
                    o.position = [ n.x, n.y ], o.update(), o.tooltip = n.tooltip, this._tryShow({
                        offsetX: n.x,
                        offsetY: n.y,
                        target: o
                    }, r);
                } else if (a) this._tryShow({
                    offsetX: n.x,
                    offsetY: n.y,
                    position: n.position,
                    event: {},
                    dataByCoordSys: n.dataByCoordSys,
                    tooltipOption: n.tooltipOption
                }, r); else if (null != n.seriesIndex) {
                    if (this._manuallyAxisShowTip(t, e, i, n)) return;
                    var s = av(n, e), l = s.point[0], h = s.point[1];
                    null != l && null != h && this._tryShow({
                        offsetX: l,
                        offsetY: h,
                        position: n.position,
                        target: s.el,
                        event: {}
                    }, r);
                } else null != n.x && null != n.y && (i.dispatchAction({
                    type: "updateAxisPointer",
                    x: n.x,
                    y: n.y
                }), this._tryShow({
                    offsetX: n.x,
                    offsetY: n.y,
                    position: n.position,
                    target: i.getZr().findHover(n.x, n.y).target,
                    event: {}
                }, r));
            }
        },
        manuallyHideTip: function(t, e, i, n) {
            var r = this._tooltipContent;
            !this._alwaysShowContent && this._tooltipModel && r.hideLater(this._tooltipModel.get("hideDelay")), 
            this._lastX = this._lastY = null, n.from !== this.uid && this._hide(bl(n, i));
        },
        _manuallyAxisShowTip: function(t, e, i, n) {
            var r = n.seriesIndex, a = n.dataIndex, o = e.getComponent("axisPointer").coordSysAxesInfo;
            if (null != r && null != a && null != o) {
                var s = e.getSeriesByIndex(r);
                if (s) if ("axis" === (t = wl([ s.getData().getItemModel(a), s, (s.coordinateSystem || {}).model, t ])).get("trigger")) return i.dispatchAction({
                    type: "updateAxisPointer",
                    seriesIndex: r,
                    dataIndex: a,
                    position: n.position
                }), !0;
            }
        },
        _tryShow: function(t, e) {
            var i = t.target;
            if (this._tooltipModel) {
                this._lastX = t.offsetX, this._lastY = t.offsetY;
                var n = t.dataByCoordSys;
                n && n.length ? this._showAxisTooltip(n, t) : i && null != i.dataIndex ? (this._lastDataByCoordSys = null, 
                this._showSeriesItemTooltip(t, i, e)) : i && i.tooltip ? (this._lastDataByCoordSys = null, 
                this._showComponentItemTooltip(t, i, e)) : (this._lastDataByCoordSys = null, this._hide(e));
            }
        },
        _showOrMove: function(t, e) {
            var i = t.get("showDelay");
            e = _(e, this), clearTimeout(this._showTimout), 0 < i ? this._showTimout = setTimeout(e, i) : e();
        },
        _showAxisTooltip: function(t, e) {
            var d = this._ecModel, i = this._tooltipModel, n = [ e.offsetX, e.offsetY ], r = [], f = [], a = wl([ e.tooltipOption, i ]), p = this._renderMode, o = this._newLine, g = {};
            wv(t, function(t) {
                wv(t.dataByAxis, function(s) {
                    var l = d.getComponent(s.axisDim + "Axis", s.axisIndex), h = s.value, u = [];
                    if (l && null != h) {
                        var c = pl(h, l.axis, d, s.seriesDataIndices, s.valueLabelOpt);
                        R(s.seriesDataIndices, function(t) {
                            var e = d.getSeriesByIndex(t.seriesIndex), i = t.dataIndexInside, n = e && e.getDataParams(i);
                            if (n.axisDim = s.axisDim, n.axisIndex = s.axisIndex, n.axisType = s.axisType, n.axisId = s.axisId, 
                            n.axisValue = To(l.axis, h), n.axisValueLabel = c, n) {
                                f.push(n);
                                var r, a = e.formatTooltip(i, !0, null, p);
                                if (L(a)) {
                                    r = a.html;
                                    var o = a.markers;
                                    m(g, o);
                                } else r = a;
                                u.push(r);
                            }
                        });
                        var t = c;
                        r.push("html" !== p ? u.join(o) : (t ? Xn(t) + o : "") + u.join(o));
                    }
                });
            }, this), r.reverse(), r = r.join(this._newLine + this._newLine);
            var s = e.position;
            this._showOrMove(a, function() {
                this._updateContentNotChangedOnAxis(t) ? this._updatePosition(a, s, n[0], n[1], this._tooltipContent, f) : this._showTooltipContent(a, r, f, Math.random(), n[0], n[1], s, void 0, g);
            });
        },
        _showSeriesItemTooltip: function(t, e, i) {
            var n = this._ecModel, r = e.seriesIndex, a = n.getSeriesByIndex(r), o = e.dataModel || a, s = e.dataIndex, l = e.dataType, h = o.getData(), u = wl([ h.getItemModel(s), o, a && (a.coordinateSystem || {}).model, this._tooltipModel ]), c = u.get("trigger");
            if (null == c || "item" === c) {
                var d, f, p = o.getDataParams(s, l), g = o.formatTooltip(s, !1, l, this._renderMode);
                L(g) ? (d = g.html, f = g.markers) : (d = g, f = null);
                var m = "item_" + o.name + "_" + s;
                this._showOrMove(u, function() {
                    this._showTooltipContent(u, d, p, m, t.offsetX, t.offsetY, t.position, t.target, f);
                }), i({
                    type: "showTip",
                    dataIndexInside: s,
                    dataIndex: h.getRawIndex(s),
                    seriesIndex: r,
                    from: this.uid
                });
            }
        },
        _showComponentItemTooltip: function(t, e, i) {
            var n = e.tooltip;
            if ("string" == typeof n) {
                n = {
                    content: n,
                    formatter: n
                };
            }
            var r = new Tn(n, this._tooltipModel, this._ecModel), a = r.get("content"), o = Math.random();
            this._showOrMove(r, function() {
                this._showTooltipContent(r, a, r.get("formatterParams") || {}, o, t.offsetX, t.offsetY, t.position, e);
            }), i({
                type: "showTip",
                from: this.uid
            });
        },
        _showTooltipContent: function(i, t, n, e, r, a, o, s, l) {
            if (this._ticket = "", i.get("showContent") && i.get("show")) {
                var h = this._tooltipContent, u = i.get("formatter");
                o = o || i.get("position");
                var c = t;
                if (u && "string" == typeof u) c = qn(u, n, !0); else if ("function" == typeof u) {
                    var d = _v(function(t, e) {
                        t === this._ticket && (h.setContent(e, l, i), this._updatePosition(i, o, r, a, h, n, s));
                    }, this);
                    this._ticket = e, c = u(n, e, d);
                }
                h.setContent(c, l, i), h.show(i), this._updatePosition(i, o, r, a, h, n, s);
            }
        },
        _updatePosition: function(t, e, i, n, r, a, o) {
            var s = this._api.getWidth(), l = this._api.getHeight();
            e = e || t.get("position");
            var h, u, c, d, f, p, g, m, v, y, x, _, w, b, S, M, I = r.getSize(), T = t.get("align"), C = t.get("verticalAlign"), D = o && o.getBoundingRect().clone();
            if (o && D.applyTransform(o.transform), "function" == typeof e && (e = e([ i, n ], a, r.el, D, {
                viewSize: [ s, l ],
                contentSize: I.slice()
            })), P(e)) i = bv(e[0], s), n = bv(e[1], l); else if (L(e)) {
                e.width = I[0], e.height = I[1];
                var A = $n(e, {
                    width: s,
                    height: l
                });
                i = A.x, n = A.y, C = T = null;
            } else if ("string" == typeof e && o) {
                i = (k = function(t, e, i) {
                    var n = i[0], r = i[1], a = 0, o = 0, s = e.width, l = e.height;
                    switch (t) {
                      case "inside":
                        a = e.x + s / 2 - n / 2, o = e.y + l / 2 - r / 2;
                        break;

                      case "top":
                        a = e.x + s / 2 - n / 2, o = e.y - r - 5;
                        break;

                      case "bottom":
                        a = e.x + s / 2 - n / 2, o = e.y + l + 5;
                        break;

                      case "left":
                        a = e.x - n - 5, o = e.y + l / 2 - r / 2;
                        break;

                      case "right":
                        a = e.x + s + 5, o = e.y + l / 2 - r / 2;
                    }
                    return [ a, o ];
                }(e, D, I))[0], n = k[1];
            } else {
                var k;
                i = (k = (h = i, u = n, c = s, d = l, f = T ? null : 20, p = C ? null : 20, g = r.getOuterSize(), 
                m = g.width, v = g.height, null != f && (c < h + m + f ? h -= m + f : h += f), null != p && (d < u + v + p ? u -= v + p : u += p), 
                [ h, u ]))[0], n = k[1];
            }
            (T && (i -= Sl(T) ? I[0] / 2 : "right" === T ? I[0] : 0), C && (n -= Sl(C) ? I[1] / 2 : "bottom" === C ? I[1] : 0), 
            t.get("confine")) && (i = (k = (y = i, x = n, _ = s, w = l, b = r.getOuterSize(), 
            S = b.width, M = b.height, y = Math.min(y + S, _) - S, x = Math.min(x + M, w) - M, 
            [ y = Math.max(y, 0), x = Math.max(x, 0) ]))[0], n = k[1]);
            r.moveTo(i, n);
        },
        _updateContentNotChangedOnAxis: function(n) {
            var t = this._lastDataByCoordSys, o = !!t && t.length === n.length;
            return o && wv(t, function(t, e) {
                var i = t.dataByAxis || {}, a = (n[e] || {}).dataByAxis || [];
                (o &= i.length === a.length) && wv(i, function(t, e) {
                    var i = a[e] || {}, n = t.seriesDataIndices || [], r = i.seriesDataIndices || [];
                    (o &= t.value === i.value && t.axisType === i.axisType && t.axisId === i.axisId && n.length === r.length) && wv(n, function(t, e) {
                        var i = r[e];
                        o &= t.seriesIndex === i.seriesIndex && t.dataIndex === i.dataIndex;
                    });
                });
            }), this._lastDataByCoordSys = n, !!o;
        },
        _hide: function(t) {
            this._lastDataByCoordSys = null, t({
                type: "hideTip",
                from: this.uid
            });
        },
        dispose: function(t, e) {
            Ll.node || (this._tooltipContent.hide(), sl("itemTooltip", e));
        }
    }), La({
        type: "showTip",
        event: "showTip",
        update: "tooltip:manuallyShowTip"
    }, function() {}), La({
        type: "hideTip",
        event: "hideTip",
        update: "tooltip:manuallyHideTip"
    }, function() {}), t.version = "4.2.0", t.dependencies = {
        zrender: "4.0.5"
    }, t.PRIORITY = xp, t.init = function(t, e, i) {
        var n = Da(t);
        if (n) return n;
        var r = new da(t, e, i);
        return r.id = "ec_" + Bp++, Ep[r.id] = r, ri(t, Np, r.id), function(n) {
            function r(t, e) {
                for (var i = 0; i < t.length; i++) t[i][a] = e;
            }
            var a = "__connectUpdateStatus";
            gp(Cp, function(t, e) {
                n._messageCenter.on(e, function(t) {
                    if (zp[n.group] && 0 !== n[a]) {
                        if (t && t.escapeConnect) return;
                        var e = n.makeActionFromEvent(t), i = [];
                        gp(Ep, function(t) {
                            t !== n && t.group === n.group && i.push(t);
                        }), r(i, 0), gp(i, function(t) {
                            1 !== t[a] && t.dispatchAction(e);
                        }), r(i, 2);
                    }
                });
            });
        }(r), r;
    }, t.connect = function(e) {
        if (P(e)) {
            var t = e;
            e = null, gp(t, function(t) {
                null != t.group && (e = t.group);
            }), e = e || "g_" + Rp++, gp(t, function(t) {
                t.group = e;
            });
        }
        return zp[e] = !0, e;
    }, t.disConnect = Ca, t.disconnect = Fp, t.dispose = function(t) {
        "string" == typeof t ? t = Ep[t] : t instanceof da || (t = Da(t)), t instanceof da && !t.isDisposed() && t.dispose();
    }, t.getInstanceByDom = Da, t.getInstanceById = function(t) {
        return Ep[t];
    }, t.registerTheme = Aa, t.registerPreprocessor = ka, t.registerProcessor = Pa, 
    t.registerPostUpdate = function(t) {
        kp.push(t);
    }, t.registerAction = La, t.registerCoordinateSystem = function(t, e) {
        ur.register(t, e);
    }, t.getCoordinateSystemDimensions = function(t) {
        var e = ur.get(t);
        return e ? e.getDimensionsInfo ? e.getDimensionsInfo() : e.dimensions.slice() : void 0;
    }, t.registerLayout = Oa, t.registerVisual = Ea, t.registerLoading = Ba, t.extendComponentModel = Ra, 
    t.extendComponentView = Na, t.extendSeriesModel = Fa, t.extendChartView = Ga, t.setCanvasCreator = function(t) {
        e("createCanvas", t);
    }, t.registerMap = function(t, e, i) {
        fs.registerMap(t, e, i);
    }, t.getMap = function(t) {
        var e = fs.retrieveMap(t);
        return e && e[0] && {
            geoJson: e[0].geoJSON,
            specialAreas: e[0].specialAreas
        };
    }, t.dataTool = {}, t.zrender = Pu, t.number = Pd, t.format = Fd, t.throttle = jr, 
    t.helper = Lg, t.matrix = lh, t.vector = Ql, t.color = Th, t.parseGeoJSON = Eg, 
    t.parseGeoJson = Ng, t.util = Fg, t.graphic = Gg, t.List = Yp, t.Model = Tn, t.Axis = Rg, 
    t.env = Ll;
});