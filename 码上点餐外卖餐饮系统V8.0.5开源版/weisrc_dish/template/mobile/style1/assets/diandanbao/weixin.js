function showLoadingMask() {
    mask_num++, $("#ddb-loading").show()
}
function hideLoadingMask() {
    mask_num > 0 && mask_num--, 0 == mask_num && $("#ddb-loading").hide()
}
function clearLoadingMask() {
    mask_num = 0, $("#ddb-loading").hide()
}
function touchScroll(e) {
    var t = 0;
    $(e).on("touchstart", function (e) {
        t = this.scrollTop + e.originalEvent.touches[0].pageY
    }), $(e).on("touchmove", function (e) {
        this.scrollTop = t - e.originalEvent.touches[0].pageY
    })
}
!function (e, t) {
    "object" == typeof module && "object" == typeof module.exports ? module.exports = e.document ? t(e, !0) : function (e) {
        if (!e.document)throw new Error("jQuery requires a window with a document");
        return t(e)
    } : t(e)
}("undefined" != typeof window ? window : this, function (e, t) {
    function n(e) {
        var t = e.length, n = it.type(e);
        return "function" === n || it.isWindow(e) ? !1 : 1 === e.nodeType && t ? !0 : "array" === n || 0 === t || "number" == typeof t && t > 0 && t - 1 in e
    }

    function r(e, t, n) {
        if (it.isFunction(t))return it.grep(e, function (e, r) {
            return !!t.call(e, r, e) !== n
        });
        if (t.nodeType)return it.grep(e, function (e) {
            return e === t !== n
        });
        if ("string" == typeof t) {
            if (pt.test(t))return it.filter(t, e, n);
            t = it.filter(t, e)
        }
        return it.grep(e, function (e) {
            return it.inArray(e, t) >= 0 !== n
        })
    }

    function i(e, t) {
        do e = e[t]; while (e && 1 !== e.nodeType);
        return e
    }

    function o(e) {
        var t = bt[e] = {};
        return it.each(e.match(yt) || [], function (e, n) {
            t[n] = !0
        }), t
    }

    function a() {
        ht.addEventListener ? (ht.removeEventListener("DOMContentLoaded", s, !1), e.removeEventListener("load", s, !1)) : (ht.detachEvent("onreadystatechange", s), e.detachEvent("onload", s))
    }

    function s() {
        (ht.addEventListener || "load" === event.type || "complete" === ht.readyState) && (a(), it.ready())
    }

    function c(e, t, n) {
        if (void 0 === n && 1 === e.nodeType) {
            var r = "data-" + t.replace(Ct, "-$1").toLowerCase();
            if (n = e.getAttribute(r), "string" == typeof n) {
                try {
                    n = "true" === n ? !0 : "false" === n ? !1 : "null" === n ? null : +n + "" === n ? +n : St.test(n) ? it.parseJSON(n) : n
                } catch (i) {
                }
                it.data(e, t, n)
            } else n = void 0
        }
        return n
    }

    function l(e) {
        var t;
        for (t in e)if (("data" !== t || !it.isEmptyObject(e[t])) && "toJSON" !== t)return !1;
        return !0
    }

    function u(e, t, n, r) {
        if (it.acceptData(e)) {
            var i, o, a = it.expando, s = e.nodeType, c = s ? it.cache : e, l = s ? e[a] : e[a] && a;
            if (l && c[l] && (r || c[l].data) || void 0 !== n || "string" != typeof t)return l || (l = s ? e[a] = X.pop() || it.guid++ : a), c[l] || (c[l] = s ? {} : {toJSON: it.noop}), ("object" == typeof t || "function" == typeof t) && (r ? c[l] = it.extend(c[l], t) : c[l].data = it.extend(c[l].data, t)), o = c[l], r || (o.data || (o.data = {}), o = o.data), void 0 !== n && (o[it.camelCase(t)] = n), "string" == typeof t ? (i = o[t], null == i && (i = o[it.camelCase(t)])) : i = o, i
        }
    }

    function d(e, t, n) {
        if (it.acceptData(e)) {
            var r, i, o = e.nodeType, a = o ? it.cache : e, s = o ? e[it.expando] : it.expando;
            if (a[s]) {
                if (t && (r = n ? a[s] : a[s].data)) {
                    it.isArray(t) ? t = t.concat(it.map(t, it.camelCase)) : t in r ? t = [t] : (t = it.camelCase(t), t = t in r ? [t] : t.split(" ")), i = t.length;
                    for (; i--;)delete r[t[i]];
                    if (n ? !l(r) : !it.isEmptyObject(r))return
                }
                (n || (delete a[s].data, l(a[s]))) && (o ? it.cleanData([e], !0) : nt.deleteExpando || a != a.window ? delete a[s] : a[s] = null)
            }
        }
    }

    function p() {
        return !0
    }

    function f() {
        return !1
    }

    function h() {
        try {
            return ht.activeElement
        } catch (e) {
        }
    }

    function m(e) {
        var t = Nt.split("|"), n = e.createDocumentFragment();
        if (n.createElement)for (; t.length;)n.createElement(t.pop());
        return n
    }

    function g(e, t) {
        var n, r, i = 0, o = typeof e.getElementsByTagName !== xt ? e.getElementsByTagName(t || "*") : typeof e.querySelectorAll !== xt ? e.querySelectorAll(t || "*") : void 0;
        if (!o)for (o = [], n = e.childNodes || e; null != (r = n[i]); i++)!t || it.nodeName(r, t) ? o.push(r) : it.merge(o, g(r, t));
        return void 0 === t || t && it.nodeName(e, t) ? it.merge([e], o) : o
    }

    function v(e) {
        Mt.test(e.type) && (e.defaultChecked = e.checked)
    }

    function _(e, t) {
        return it.nodeName(e, "table") && it.nodeName(11 !== t.nodeType ? t : t.firstChild, "tr") ? e.getElementsByTagName("tbody")[0] || e.appendChild(e.ownerDocument.createElement("tbody")) : e
    }

    function y(e) {
        return e.type = (null !== it.find.attr(e, "type")) + "/" + e.type, e
    }

    function b(e) {
        var t = Gt.exec(e.type);
        return t ? e.type = t[1] : e.removeAttribute("type"), e
    }

    function $(e, t) {
        for (var n, r = 0; null != (n = e[r]); r++)it._data(n, "globalEval", !t || it._data(t[r], "globalEval"))
    }

    function w(e, t) {
        if (1 === t.nodeType && it.hasData(e)) {
            var n, r, i, o = it._data(e), a = it._data(t, o), s = o.events;
            if (s) {
                delete a.handle, a.events = {};
                for (n in s)for (r = 0, i = s[n].length; i > r; r++)it.event.add(t, n, s[n][r])
            }
            a.data && (a.data = it.extend({}, a.data))
        }
    }

    function x(e, t) {
        var n, r, i;
        if (1 === t.nodeType) {
            if (n = t.nodeName.toLowerCase(), !nt.noCloneEvent && t[it.expando]) {
                i = it._data(t);
                for (r in i.events)it.removeEvent(t, r, i.handle);
                t.removeAttribute(it.expando)
            }
            "script" === n && t.text !== e.text ? (y(t).text = e.text, b(t)) : "object" === n ? (t.parentNode && (t.outerHTML = e.outerHTML), nt.html5Clone && e.innerHTML && !it.trim(t.innerHTML) && (t.innerHTML = e.innerHTML)) : "input" === n && Mt.test(e.type) ? (t.defaultChecked = t.checked = e.checked, t.value !== e.value && (t.value = e.value)) : "option" === n ? t.defaultSelected = t.selected = e.defaultSelected : ("input" === n || "textarea" === n) && (t.defaultValue = e.defaultValue)
        }
    }

    function S(t, n) {
        var r, i = it(n.createElement(t)).appendTo(n.body), o = e.getDefaultComputedStyle && (r = e.getDefaultComputedStyle(i[0])) ? r.display : it.css(i[0], "display");
        return i.detach(), o
    }

    function C(e) {
        var t = ht, n = Zt[e];
        return n || (n = S(e, t), "none" !== n && n || (Jt = (Jt || it("<iframe frameborder='0' width='0' height='0'/>")).appendTo(t.documentElement), t = (Jt[0].contentWindow || Jt[0].contentDocument).document, t.write(), t.close(), n = S(e, t), Jt.detach()), Zt[e] = n), n
    }

    function k(e, t) {
        return {
            get: function () {
                var n = e();
                if (null != n)return n ? void delete this.get : (this.get = t).apply(this, arguments)
            }
        }
    }

    function T(e, t) {
        if (t in e)return t;
        for (var n = t.charAt(0).toUpperCase() + t.slice(1), r = t, i = fn.length; i--;)if (t = fn[i] + n, t in e)return t;
        return r
    }

    function E(e, t) {
        for (var n, r, i, o = [], a = 0, s = e.length; s > a; a++)r = e[a], r.style && (o[a] = it._data(r, "olddisplay"), n = r.style.display, t ? (o[a] || "none" !== n || (r.style.display = ""), "" === r.style.display && Et(r) && (o[a] = it._data(r, "olddisplay", C(r.nodeName)))) : (i = Et(r), (n && "none" !== n || !i) && it._data(r, "olddisplay", i ? n : it.css(r, "display"))));
        for (a = 0; s > a; a++)r = e[a], r.style && (t && "none" !== r.style.display && "" !== r.style.display || (r.style.display = t ? o[a] || "" : "none"));
        return e
    }

    function A(e, t, n) {
        var r = ln.exec(t);
        return r ? Math.max(0, r[1] - (n || 0)) + (r[2] || "px") : t
    }

    function M(e, t, n, r, i) {
        for (var o = n === (r ? "border" : "content") ? 4 : "width" === t ? 1 : 0, a = 0; 4 > o; o += 2)"margin" === n && (a += it.css(e, n + Tt[o], !0, i)), r ? ("content" === n && (a -= it.css(e, "padding" + Tt[o], !0, i)), "margin" !== n && (a -= it.css(e, "border" + Tt[o] + "Width", !0, i))) : (a += it.css(e, "padding" + Tt[o], !0, i), "padding" !== n && (a += it.css(e, "border" + Tt[o] + "Width", !0, i)));
        return a
    }

    function D(e, t, n) {
        var r = !0, i = "width" === t ? e.offsetWidth : e.offsetHeight, o = en(e), a = nt.boxSizing && "border-box" === it.css(e, "boxSizing", !1, o);
        if (0 >= i || null == i) {
            if (i = tn(e, t, o), (0 > i || null == i) && (i = e.style[t]), rn.test(i))return i;
            r = a && (nt.boxSizingReliable() || i === e.style[t]), i = parseFloat(i) || 0
        }
        return i + M(e, t, n || (a ? "border" : "content"), r, o) + "px"
    }

    function q(e, t, n, r, i) {
        return new q.prototype.init(e, t, n, r, i)
    }

    function L() {
        return setTimeout(function () {
            hn = void 0
        }), hn = it.now()
    }

    function O(e, t) {
        var n, r = {height: e}, i = 0;
        for (t = t ? 1 : 0; 4 > i; i += 2 - t)n = Tt[i], r["margin" + n] = r["padding" + n] = e;
        return t && (r.opacity = r.width = e), r
    }

    function P(e, t, n) {
        for (var r, i = (bn[t] || []).concat(bn["*"]), o = 0, a = i.length; a > o; o++)if (r = i[o].call(n, t, e))return r
    }

    function N(e, t, n) {
        var r, i, o, a, s, c, l, u, d = this, p = {}, f = e.style, h = e.nodeType && Et(e), m = it._data(e, "fxshow");
        n.queue || (s = it._queueHooks(e, "fx"), null == s.unqueued && (s.unqueued = 0, c = s.empty.fire, s.empty.fire = function () {
            s.unqueued || c()
        }), s.unqueued++, d.always(function () {
            d.always(function () {
                s.unqueued--, it.queue(e, "fx").length || s.empty.fire()
            })
        })), 1 === e.nodeType && ("height"in t || "width"in t) && (n.overflow = [f.overflow, f.overflowX, f.overflowY], l = it.css(e, "display"), u = "none" === l ? it._data(e, "olddisplay") || C(e.nodeName) : l, "inline" === u && "none" === it.css(e, "float") && (nt.inlineBlockNeedsLayout && "inline" !== C(e.nodeName) ? f.zoom = 1 : f.display = "inline-block")), n.overflow && (f.overflow = "hidden", nt.shrinkWrapBlocks() || d.always(function () {
            f.overflow = n.overflow[0], f.overflowX = n.overflow[1], f.overflowY = n.overflow[2]
        }));
        for (r in t)if (i = t[r], gn.exec(i)) {
            if (delete t[r], o = o || "toggle" === i, i === (h ? "hide" : "show")) {
                if ("show" !== i || !m || void 0 === m[r])continue;
                h = !0
            }
            p[r] = m && m[r] || it.style(e, r)
        } else l = void 0;
        if (it.isEmptyObject(p))"inline" === ("none" === l ? C(e.nodeName) : l) && (f.display = l); else {
            m ? "hidden"in m && (h = m.hidden) : m = it._data(e, "fxshow", {}), o && (m.hidden = !h), h ? it(e).show() : d.done(function () {
                it(e).hide()
            }), d.done(function () {
                var t;
                it._removeData(e, "fxshow");
                for (t in p)it.style(e, t, p[t])
            });
            for (r in p)a = P(h ? m[r] : 0, r, d), r in m || (m[r] = a.start, h && (a.end = a.start, a.start = "width" === r || "height" === r ? 1 : 0))
        }
    }

    function j(e, t) {
        var n, r, i, o, a;
        for (n in e)if (r = it.camelCase(n), i = t[r], o = e[n], it.isArray(o) && (i = o[1], o = e[n] = o[0]), n !== r && (e[r] = o, delete e[n]), a = it.cssHooks[r], a && "expand"in a) {
            o = a.expand(o), delete e[r];
            for (n in o)n in e || (e[n] = o[n], t[n] = i)
        } else t[r] = i
    }

    function R(e, t, n) {
        var r, i, o = 0, a = yn.length, s = it.Deferred().always(function () {
            delete c.elem
        }), c = function () {
            if (i)return !1;
            for (var t = hn || L(), n = Math.max(0, l.startTime + l.duration - t), r = n / l.duration || 0, o = 1 - r, a = 0, c = l.tweens.length; c > a; a++)l.tweens[a].run(o);
            return s.notifyWith(e, [l, o, n]), 1 > o && c ? n : (s.resolveWith(e, [l]), !1)
        }, l = s.promise({
            elem: e,
            props: it.extend({}, t),
            opts: it.extend(!0, {specialEasing: {}}, n),
            originalProperties: t,
            originalOptions: n,
            startTime: hn || L(),
            duration: n.duration,
            tweens: [],
            createTween: function (t, n) {
                var r = it.Tween(e, l.opts, t, n, l.opts.specialEasing[t] || l.opts.easing);
                return l.tweens.push(r), r
            },
            stop: function (t) {
                var n = 0, r = t ? l.tweens.length : 0;
                if (i)return this;
                for (i = !0; r > n; n++)l.tweens[n].run(1);
                return t ? s.resolveWith(e, [l, t]) : s.rejectWith(e, [l, t]), this
            }
        }), u = l.props;
        for (j(u, l.opts.specialEasing); a > o; o++)if (r = yn[o].call(l, e, u, l.opts))return r;
        return it.map(u, P, l), it.isFunction(l.opts.start) && l.opts.start.call(e, l), it.fx.timer(it.extend(c, {
            elem: e,
            anim: l,
            queue: l.opts.queue
        })), l.progress(l.opts.progress).done(l.opts.done, l.opts.complete).fail(l.opts.fail).always(l.opts.always)
    }

    function I(e) {
        return function (t, n) {
            "string" != typeof t && (n = t, t = "*");
            var r, i = 0, o = t.toLowerCase().match(yt) || [];
            if (it.isFunction(n))for (; r = o[i++];)"+" === r.charAt(0) ? (r = r.slice(1) || "*", (e[r] = e[r] || []).unshift(n)) : (e[r] = e[r] || []).push(n)
        }
    }

    function U(e, t, n, r) {
        function i(s) {
            var c;
            return o[s] = !0, it.each(e[s] || [], function (e, s) {
                var l = s(t, n, r);
                return "string" != typeof l || a || o[l] ? a ? !(c = l) : void 0 : (t.dataTypes.unshift(l), i(l), !1)
            }), c
        }

        var o = {}, a = e === zn;
        return i(t.dataTypes[0]) || !o["*"] && i("*")
    }

    function B(e, t) {
        var n, r, i = it.ajaxSettings.flatOptions || {};
        for (r in t)void 0 !== t[r] && ((i[r] ? e : n || (n = {}))[r] = t[r]);
        return n && it.extend(!0, e, n), e
    }

    function F(e, t, n) {
        for (var r, i, o, a, s = e.contents, c = e.dataTypes; "*" === c[0];)c.shift(), void 0 === i && (i = e.mimeType || t.getResponseHeader("Content-Type"));
        if (i)for (a in s)if (s[a] && s[a].test(i)) {
            c.unshift(a);
            break
        }
        if (c[0]in n)o = c[0]; else {
            for (a in n) {
                if (!c[0] || e.converters[a + " " + c[0]]) {
                    o = a;
                    break
                }
                r || (r = a)
            }
            o = o || r
        }
        return o ? (o !== c[0] && c.unshift(o), n[o]) : void 0
    }

    function H(e, t, n, r) {
        var i, o, a, s, c, l = {}, u = e.dataTypes.slice();
        if (u[1])for (a in e.converters)l[a.toLowerCase()] = e.converters[a];
        for (o = u.shift(); o;)if (e.responseFields[o] && (n[e.responseFields[o]] = t), !c && r && e.dataFilter && (t = e.dataFilter(t, e.dataType)), c = o, o = u.shift())if ("*" === o)o = c; else if ("*" !== c && c !== o) {
            if (a = l[c + " " + o] || l["* " + o], !a)for (i in l)if (s = i.split(" "), s[1] === o && (a = l[c + " " + s[0]] || l["* " + s[0]])) {
                a === !0 ? a = l[i] : l[i] !== !0 && (o = s[0], u.unshift(s[1]));
                break
            }
            if (a !== !0)if (a && e["throws"])t = a(t); else try {
                t = a(t)
            } catch (d) {
                return {state: "parsererror", error: a ? d : "No conversion from " + c + " to " + o}
            }
        }
        return {state: "success", data: t}
    }

    function z(e, t, n, r) {
        var i;
        if (it.isArray(t))it.each(t, function (t, i) {
            n || Xn.test(e) ? r(e, i) : z(e + "[" + ("object" == typeof i ? t : "") + "]", i, n, r)
        }); else if (n || "object" !== it.type(t))r(e, t); else for (i in t)z(e + "[" + i + "]", t[i], n, r)
    }

    function V() {
        try {
            return new e.XMLHttpRequest
        } catch (t) {
        }
    }

    function W() {
        try {
            return new e.ActiveXObject("Microsoft.XMLHTTP")
        } catch (t) {
        }
    }

    function G(e) {
        return it.isWindow(e) ? e : 9 === e.nodeType ? e.defaultView || e.parentWindow : !1
    }

    var X = [], Y = X.slice, Q = X.concat, K = X.push, J = X.indexOf, Z = {}, et = Z.toString, tt = Z.hasOwnProperty, nt = {}, rt = "1.11.1", it = function (e, t) {
        return new it.fn.init(e, t)
    }, ot = /^[\s\uFEFF\xA0]+|[\s\uFEFF\xA0]+$/g, at = /^-ms-/, st = /-([\da-z])/gi, ct = function (e, t) {
        return t.toUpperCase()
    };
    it.fn = it.prototype = {
        jquery: rt, constructor: it, selector: "", length: 0, toArray: function () {
            return Y.call(this)
        }, get: function (e) {
            return null != e ? 0 > e ? this[e + this.length] : this[e] : Y.call(this)
        }, pushStack: function (e) {
            var t = it.merge(this.constructor(), e);
            return t.prevObject = this, t.context = this.context, t
        }, each: function (e, t) {
            return it.each(this, e, t)
        }, map: function (e) {
            return this.pushStack(it.map(this, function (t, n) {
                return e.call(t, n, t)
            }))
        }, slice: function () {
            return this.pushStack(Y.apply(this, arguments))
        }, first: function () {
            return this.eq(0)
        }, last: function () {
            return this.eq(-1)
        }, eq: function (e) {
            var t = this.length, n = +e + (0 > e ? t : 0);
            return this.pushStack(n >= 0 && t > n ? [this[n]] : [])
        }, end: function () {
            return this.prevObject || this.constructor(null)
        }, push: K, sort: X.sort, splice: X.splice
    }, it.extend = it.fn.extend = function () {
        var e, t, n, r, i, o, a = arguments[0] || {}, s = 1, c = arguments.length, l = !1;
        for ("boolean" == typeof a && (l = a, a = arguments[s] || {}, s++), "object" == typeof a || it.isFunction(a) || (a = {}), s === c && (a = this, s--); c > s; s++)if (null != (i = arguments[s]))for (r in i)e = a[r], n = i[r], a !== n && (l && n && (it.isPlainObject(n) || (t = it.isArray(n))) ? (t ? (t = !1, o = e && it.isArray(e) ? e : []) : o = e && it.isPlainObject(e) ? e : {}, a[r] = it.extend(l, o, n)) : void 0 !== n && (a[r] = n));
        return a
    }, it.extend({
        expando: "jQuery" + (rt + Math.random()).replace(/\D/g, ""), isReady: !0, error: function (e) {
            throw new Error(e)
        }, noop: function () {
        }, isFunction: function (e) {
            return "function" === it.type(e)
        }, isArray: Array.isArray || function (e) {
            return "array" === it.type(e)
        }, isWindow: function (e) {
            return null != e && e == e.window
        }, isNumeric: function (e) {
            return !it.isArray(e) && e - parseFloat(e) >= 0
        }, isEmptyObject: function (e) {
            var t;
            for (t in e)return !1;
            return !0
        }, isPlainObject: function (e) {
            var t;
            if (!e || "object" !== it.type(e) || e.nodeType || it.isWindow(e))return !1;
            try {
                if (e.constructor && !tt.call(e, "constructor") && !tt.call(e.constructor.prototype, "isPrototypeOf"))return !1
            } catch (n) {
                return !1
            }
            if (nt.ownLast)for (t in e)return tt.call(e, t);
            for (t in e);
            return void 0 === t || tt.call(e, t)
        }, type: function (e) {
            return null == e ? e + "" : "object" == typeof e || "function" == typeof e ? Z[et.call(e)] || "object" : typeof e
        }, globalEval: function (t) {
            t && it.trim(t) && (e.execScript || function (t) {
                e.eval.call(e, t)
            })(t)
        }, camelCase: function (e) {
            return e.replace(at, "ms-").replace(st, ct)
        }, nodeName: function (e, t) {
            return e.nodeName && e.nodeName.toLowerCase() === t.toLowerCase()
        }, each: function (e, t, r) {
            var i, o = 0, a = e.length, s = n(e);
            if (r) {
                if (s)for (; a > o && (i = t.apply(e[o], r), i !== !1); o++); else for (o in e)if (i = t.apply(e[o], r), i === !1)break
            } else if (s)for (; a > o && (i = t.call(e[o], o, e[o]), i !== !1); o++); else for (o in e)if (i = t.call(e[o], o, e[o]), i === !1)break;
            return e
        }, trim: function (e) {
            return null == e ? "" : (e + "").replace(ot, "")
        }, makeArray: function (e, t) {
            var r = t || [];
            return null != e && (n(Object(e)) ? it.merge(r, "string" == typeof e ? [e] : e) : K.call(r, e)), r
        }, inArray: function (e, t, n) {
            var r;
            if (t) {
                if (J)return J.call(t, e, n);
                for (r = t.length, n = n ? 0 > n ? Math.max(0, r + n) : n : 0; r > n; n++)if (n in t && t[n] === e)return n
            }
            return -1
        }, merge: function (e, t) {
            for (var n = +t.length, r = 0, i = e.length; n > r;)e[i++] = t[r++];
            if (n !== n)for (; void 0 !== t[r];)e[i++] = t[r++];
            return e.length = i, e
        }, grep: function (e, t, n) {
            for (var r, i = [], o = 0, a = e.length, s = !n; a > o; o++)r = !t(e[o], o), r !== s && i.push(e[o]);
            return i
        }, map: function (e, t, r) {
            var i, o = 0, a = e.length, s = n(e), c = [];
            if (s)for (; a > o; o++)i = t(e[o], o, r), null != i && c.push(i); else for (o in e)i = t(e[o], o, r), null != i && c.push(i);
            return Q.apply([], c)
        }, guid: 1, proxy: function (e, t) {
            var n, r, i;
            return "string" == typeof t && (i = e[t], t = e, e = i), it.isFunction(e) ? (n = Y.call(arguments, 2), r = function () {
                return e.apply(t || this, n.concat(Y.call(arguments)))
            }, r.guid = e.guid = e.guid || it.guid++, r) : void 0
        }, now: function () {
            return +new Date
        }, support: nt
    }), it.each("Boolean Number String Function Array Date RegExp Object Error".split(" "), function (e, t) {
        Z["[object " + t + "]"] = t.toLowerCase()
    });
    var lt = function (e) {
        function t(e, t, n, r) {
            var i, o, a, s, c, l, d, f, h, m;
            if ((t ? t.ownerDocument || t : U) !== q && D(t), t = t || q, n = n || [], !e || "string" != typeof e)return n;
            if (1 !== (s = t.nodeType) && 9 !== s)return [];
            if (O && !r) {
                if (i = _t.exec(e))if (a = i[1]) {
                    if (9 === s) {
                        if (o = t.getElementById(a), !o || !o.parentNode)return n;
                        if (o.id === a)return n.push(o), n
                    } else if (t.ownerDocument && (o = t.ownerDocument.getElementById(a)) && R(t, o) && o.id === a)return n.push(o), n
                } else {
                    if (i[2])return Z.apply(n, t.getElementsByTagName(e)), n;
                    if ((a = i[3]) && $.getElementsByClassName && t.getElementsByClassName)return Z.apply(n, t.getElementsByClassName(a)), n
                }
                if ($.qsa && (!P || !P.test(e))) {
                    if (f = d = I, h = t, m = 9 === s && e, 1 === s && "object" !== t.nodeName.toLowerCase()) {
                        for (l = C(e), (d = t.getAttribute("id")) ? f = d.replace(bt, "\\$&") : t.setAttribute("id", f), f = "[id='" + f + "'] ", c = l.length; c--;)l[c] = f + p(l[c]);
                        h = yt.test(e) && u(t.parentNode) || t, m = l.join(",")
                    }
                    if (m)try {
                        return Z.apply(n, h.querySelectorAll(m)), n
                    } catch (g) {
                    } finally {
                        d || t.removeAttribute("id")
                    }
                }
            }
            return T(e.replace(ct, "$1"), t, n, r)
        }

        function n() {
            function e(n, r) {
                return t.push(n + " ") > w.cacheLength && delete e[t.shift()], e[n + " "] = r
            }

            var t = [];
            return e
        }

        function r(e) {
            return e[I] = !0, e
        }

        function i(e) {
            var t = q.createElement("div");
            try {
                return !!e(t)
            } catch (n) {
                return !1
            } finally {
                t.parentNode && t.parentNode.removeChild(t), t = null
            }
        }

        function o(e, t) {
            for (var n = e.split("|"), r = e.length; r--;)w.attrHandle[n[r]] = t
        }

        function a(e, t) {
            var n = t && e, r = n && 1 === e.nodeType && 1 === t.nodeType && (~t.sourceIndex || X) - (~e.sourceIndex || X);
            if (r)return r;
            if (n)for (; n = n.nextSibling;)if (n === t)return -1;
            return e ? 1 : -1
        }

        function s(e) {
            return function (t) {
                var n = t.nodeName.toLowerCase();
                return "input" === n && t.type === e
            }
        }

        function c(e) {
            return function (t) {
                var n = t.nodeName.toLowerCase();
                return ("input" === n || "button" === n) && t.type === e
            }
        }

        function l(e) {
            return r(function (t) {
                return t = +t, r(function (n, r) {
                    for (var i, o = e([], n.length, t), a = o.length; a--;)n[i = o[a]] && (n[i] = !(r[i] = n[i]))
                })
            })
        }

        function u(e) {
            return e && typeof e.getElementsByTagName !== G && e
        }

        function d() {
        }

        function p(e) {
            for (var t = 0, n = e.length, r = ""; n > t; t++)r += e[t].value;
            return r
        }

        function f(e, t, n) {
            var r = t.dir, i = n && "parentNode" === r, o = F++;
            return t.first ? function (t, n, o) {
                for (; t = t[r];)if (1 === t.nodeType || i)return e(t, n, o)
            } : function (t, n, a) {
                var s, c, l = [B, o];
                if (a) {
                    for (; t = t[r];)if ((1 === t.nodeType || i) && e(t, n, a))return !0
                } else for (; t = t[r];)if (1 === t.nodeType || i) {
                    if (c = t[I] || (t[I] = {}), (s = c[r]) && s[0] === B && s[1] === o)return l[2] = s[2];
                    if (c[r] = l, l[2] = e(t, n, a))return !0
                }
            }
        }

        function h(e) {
            return e.length > 1 ? function (t, n, r) {
                for (var i = e.length; i--;)if (!e[i](t, n, r))return !1;
                return !0
            } : e[0]
        }

        function m(e, n, r) {
            for (var i = 0, o = n.length; o > i; i++)t(e, n[i], r);
            return r
        }

        function g(e, t, n, r, i) {
            for (var o, a = [], s = 0, c = e.length, l = null != t; c > s; s++)(o = e[s]) && (!n || n(o, r, i)) && (a.push(o), l && t.push(s));
            return a
        }

        function v(e, t, n, i, o, a) {
            return i && !i[I] && (i = v(i)), o && !o[I] && (o = v(o, a)), r(function (r, a, s, c) {
                var l, u, d, p = [], f = [], h = a.length, v = r || m(t || "*", s.nodeType ? [s] : s, []), _ = !e || !r && t ? v : g(v, p, e, s, c), y = n ? o || (r ? e : h || i) ? [] : a : _;
                if (n && n(_, y, s, c), i)for (l = g(y, f), i(l, [], s, c), u = l.length; u--;)(d = l[u]) && (y[f[u]] = !(_[f[u]] = d));
                if (r) {
                    if (o || e) {
                        if (o) {
                            for (l = [], u = y.length; u--;)(d = y[u]) && l.push(_[u] = d);
                            o(null, y = [], l, c)
                        }
                        for (u = y.length; u--;)(d = y[u]) && (l = o ? tt.call(r, d) : p[u]) > -1 && (r[l] = !(a[l] = d))
                    }
                } else y = g(y === a ? y.splice(h, y.length) : y), o ? o(null, a, y, c) : Z.apply(a, y)
            })
        }

        function _(e) {
            for (var t, n, r, i = e.length, o = w.relative[e[0].type], a = o || w.relative[" "], s = o ? 1 : 0, c = f(function (e) {
                return e === t
            }, a, !0), l = f(function (e) {
                return tt.call(t, e) > -1
            }, a, !0), u = [function (e, n, r) {
                return !o && (r || n !== E) || ((t = n).nodeType ? c(e, n, r) : l(e, n, r))
            }]; i > s; s++)if (n = w.relative[e[s].type])u = [f(h(u), n)]; else {
                if (n = w.filter[e[s].type].apply(null, e[s].matches), n[I]) {
                    for (r = ++s; i > r && !w.relative[e[r].type]; r++);
                    return v(s > 1 && h(u), s > 1 && p(e.slice(0, s - 1).concat({value: " " === e[s - 2].type ? "*" : ""})).replace(ct, "$1"), n, r > s && _(e.slice(s, r)), i > r && _(e = e.slice(r)), i > r && p(e))
                }
                u.push(n)
            }
            return h(u)
        }

        function y(e, n) {
            var i = n.length > 0, o = e.length > 0, a = function (r, a, s, c, l) {
                var u, d, p, f = 0, h = "0", m = r && [], v = [], _ = E, y = r || o && w.find.TAG("*", l), b = B += null == _ ? 1 : Math.random() || .1, $ = y.length;
                for (l && (E = a !== q && a); h !== $ && null != (u = y[h]); h++) {
                    if (o && u) {
                        for (d = 0; p = e[d++];)if (p(u, a, s)) {
                            c.push(u);
                            break
                        }
                        l && (B = b)
                    }
                    i && ((u = !p && u) && f--, r && m.push(u))
                }
                if (f += h, i && h !== f) {
                    for (d = 0; p = n[d++];)p(m, v, a, s);
                    if (r) {
                        if (f > 0)for (; h--;)m[h] || v[h] || (v[h] = K.call(c));
                        v = g(v)
                    }
                    Z.apply(c, v), l && !r && v.length > 0 && f + n.length > 1 && t.uniqueSort(c)
                }
                return l && (B = b, E = _), m
            };
            return i ? r(a) : a
        }

        var b, $, w, x, S, C, k, T, E, A, M, D, q, L, O, P, N, j, R, I = "sizzle" + -new Date, U = e.document, B = 0, F = 0, H = n(), z = n(), V = n(), W = function (e, t) {
            return e === t && (M = !0), 0
        }, G = "undefined", X = 1 << 31, Y = {}.hasOwnProperty, Q = [], K = Q.pop, J = Q.push, Z = Q.push, et = Q.slice, tt = Q.indexOf || function (e) {
                for (var t = 0, n = this.length; n > t; t++)if (this[t] === e)return t;
                return -1
            }, nt = "checked|selected|async|autofocus|autoplay|controls|defer|disabled|hidden|ismap|loop|multiple|open|readonly|required|scoped", rt = "[\\x20\\t\\r\\n\\f]", it = "(?:\\\\.|[\\w-]|[^\\x00-\\xa0])+", ot = it.replace("w", "w#"), at = "\\[" + rt + "*(" + it + ")(?:" + rt + "*([*^$|!~]?=)" + rt + "*(?:'((?:\\\\.|[^\\\\'])*)'|\"((?:\\\\.|[^\\\\\"])*)\"|(" + ot + "))|)" + rt + "*\\]", st = ":(" + it + ")(?:\\((('((?:\\\\.|[^\\\\'])*)'|\"((?:\\\\.|[^\\\\\"])*)\")|((?:\\\\.|[^\\\\()[\\]]|" + at + ")*)|.*)\\)|)", ct = new RegExp("^" + rt + "+|((?:^|[^\\\\])(?:\\\\.)*)" + rt + "+$", "g"), lt = new RegExp("^" + rt + "*," + rt + "*"), ut = new RegExp("^" + rt + "*([>+~]|" + rt + ")" + rt + "*"), dt = new RegExp("=" + rt + "*([^\\]'\"]*?)" + rt + "*\\]", "g"), pt = new RegExp(st), ft = new RegExp("^" + ot + "$"), ht = {
            ID: new RegExp("^#(" + it + ")"),
            CLASS: new RegExp("^\\.(" + it + ")"),
            TAG: new RegExp("^(" + it.replace("w", "w*") + ")"),
            ATTR: new RegExp("^" + at),
            PSEUDO: new RegExp("^" + st),
            CHILD: new RegExp("^:(only|first|last|nth|nth-last)-(child|of-type)(?:\\(" + rt + "*(even|odd|(([+-]|)(\\d*)n|)" + rt + "*(?:([+-]|)" + rt + "*(\\d+)|))" + rt + "*\\)|)", "i"),
            bool: new RegExp("^(?:" + nt + ")$", "i"),
            needsContext: new RegExp("^" + rt + "*[>+~]|:(even|odd|eq|gt|lt|nth|first|last)(?:\\(" + rt + "*((?:-\\d)?\\d*)" + rt + "*\\)|)(?=[^-]|$)", "i")
        }, mt = /^(?:input|select|textarea|button)$/i, gt = /^h\d$/i, vt = /^[^{]+\{\s*\[native \w/, _t = /^(?:#([\w-]+)|(\w+)|\.([\w-]+))$/, yt = /[+~]/, bt = /'|\\/g, $t = new RegExp("\\\\([\\da-f]{1,6}" + rt + "?|(" + rt + ")|.)", "ig"), wt = function (e, t, n) {
            var r = "0x" + t - 65536;
            return r !== r || n ? t : 0 > r ? String.fromCharCode(r + 65536) : String.fromCharCode(r >> 10 | 55296, 1023 & r | 56320)
        };
        try {
            Z.apply(Q = et.call(U.childNodes), U.childNodes), Q[U.childNodes.length].nodeType
        } catch (xt) {
            Z = {
                apply: Q.length ? function (e, t) {
                    J.apply(e, et.call(t))
                } : function (e, t) {
                    for (var n = e.length, r = 0; e[n++] = t[r++];);
                    e.length = n - 1
                }
            }
        }
        $ = t.support = {}, S = t.isXML = function (e) {
            var t = e && (e.ownerDocument || e).documentElement;
            return t ? "HTML" !== t.nodeName : !1
        }, D = t.setDocument = function (e) {
            var t, n = e ? e.ownerDocument || e : U, r = n.defaultView;
            return n !== q && 9 === n.nodeType && n.documentElement ? (q = n, L = n.documentElement, O = !S(n), r && r !== r.top && (r.addEventListener ? r.addEventListener("unload", function () {
                D()
            }, !1) : r.attachEvent && r.attachEvent("onunload", function () {
                D()
            })), $.attributes = i(function (e) {
                return e.className = "i", !e.getAttribute("className")
            }), $.getElementsByTagName = i(function (e) {
                return e.appendChild(n.createComment("")), !e.getElementsByTagName("*").length
            }), $.getElementsByClassName = vt.test(n.getElementsByClassName) && i(function (e) {
                    return e.innerHTML = "<div class='a'></div><div class='a i'></div>", e.firstChild.className = "i", 2 === e.getElementsByClassName("i").length
                }), $.getById = i(function (e) {
                return L.appendChild(e).id = I, !n.getElementsByName || !n.getElementsByName(I).length
            }), $.getById ? (w.find.ID = function (e, t) {
                if (typeof t.getElementById !== G && O) {
                    var n = t.getElementById(e);
                    return n && n.parentNode ? [n] : []
                }
            }, w.filter.ID = function (e) {
                var t = e.replace($t, wt);
                return function (e) {
                    return e.getAttribute("id") === t
                }
            }) : (delete w.find.ID, w.filter.ID = function (e) {
                var t = e.replace($t, wt);
                return function (e) {
                    var n = typeof e.getAttributeNode !== G && e.getAttributeNode("id");
                    return n && n.value === t
                }
            }), w.find.TAG = $.getElementsByTagName ? function (e, t) {
                return typeof t.getElementsByTagName !== G ? t.getElementsByTagName(e) : void 0
            } : function (e, t) {
                var n, r = [], i = 0, o = t.getElementsByTagName(e);
                if ("*" === e) {
                    for (; n = o[i++];)1 === n.nodeType && r.push(n);
                    return r
                }
                return o
            }, w.find.CLASS = $.getElementsByClassName && function (e, t) {
                    return typeof t.getElementsByClassName !== G && O ? t.getElementsByClassName(e) : void 0
                }, N = [], P = [], ($.qsa = vt.test(n.querySelectorAll)) && (i(function (e) {
                e.innerHTML = "<select msallowclip=''><option selected=''></option></select>", e.querySelectorAll("[msallowclip^='']").length && P.push("[*^$]=" + rt + "*(?:''|\"\")"), e.querySelectorAll("[selected]").length || P.push("\\[" + rt + "*(?:value|" + nt + ")"), e.querySelectorAll(":checked").length || P.push(":checked")
            }), i(function (e) {
                var t = n.createElement("input");
                t.setAttribute("type", "hidden"), e.appendChild(t).setAttribute("name", "D"), e.querySelectorAll("[name=d]").length && P.push("name" + rt + "*[*^$|!~]?="), e.querySelectorAll(":enabled").length || P.push(":enabled", ":disabled"), e.querySelectorAll("*,:x"), P.push(",.*:")
            })), ($.matchesSelector = vt.test(j = L.matches || L.webkitMatchesSelector || L.mozMatchesSelector || L.oMatchesSelector || L.msMatchesSelector)) && i(function (e) {
                $.disconnectedMatch = j.call(e, "div"), j.call(e, "[s!='']:x"), N.push("!=", st)
            }), P = P.length && new RegExp(P.join("|")), N = N.length && new RegExp(N.join("|")), t = vt.test(L.compareDocumentPosition), R = t || vt.test(L.contains) ? function (e, t) {
                var n = 9 === e.nodeType ? e.documentElement : e, r = t && t.parentNode;
                return e === r || !(!r || 1 !== r.nodeType || !(n.contains ? n.contains(r) : e.compareDocumentPosition && 16 & e.compareDocumentPosition(r)))
            } : function (e, t) {
                if (t)for (; t = t.parentNode;)if (t === e)return !0;
                return !1
            }, W = t ? function (e, t) {
                if (e === t)return M = !0, 0;
                var r = !e.compareDocumentPosition - !t.compareDocumentPosition;
                return r ? r : (r = (e.ownerDocument || e) === (t.ownerDocument || t) ? e.compareDocumentPosition(t) : 1, 1 & r || !$.sortDetached && t.compareDocumentPosition(e) === r ? e === n || e.ownerDocument === U && R(U, e) ? -1 : t === n || t.ownerDocument === U && R(U, t) ? 1 : A ? tt.call(A, e) - tt.call(A, t) : 0 : 4 & r ? -1 : 1)
            } : function (e, t) {
                if (e === t)return M = !0, 0;
                var r, i = 0, o = e.parentNode, s = t.parentNode, c = [e], l = [t];
                if (!o || !s)return e === n ? -1 : t === n ? 1 : o ? -1 : s ? 1 : A ? tt.call(A, e) - tt.call(A, t) : 0;
                if (o === s)return a(e, t);
                for (r = e; r = r.parentNode;)c.unshift(r);
                for (r = t; r = r.parentNode;)l.unshift(r);
                for (; c[i] === l[i];)i++;
                return i ? a(c[i], l[i]) : c[i] === U ? -1 : l[i] === U ? 1 : 0
            }, n) : q
        }, t.matches = function (e, n) {
            return t(e, null, null, n)
        }, t.matchesSelector = function (e, n) {
            if ((e.ownerDocument || e) !== q && D(e), n = n.replace(dt, "='$1']"), !(!$.matchesSelector || !O || N && N.test(n) || P && P.test(n)))try {
                var r = j.call(e, n);
                if (r || $.disconnectedMatch || e.document && 11 !== e.document.nodeType)return r
            } catch (i) {
            }
            return t(n, q, null, [e]).length > 0
        }, t.contains = function (e, t) {
            return (e.ownerDocument || e) !== q && D(e), R(e, t)
        }, t.attr = function (e, t) {
            (e.ownerDocument || e) !== q && D(e);
            var n = w.attrHandle[t.toLowerCase()], r = n && Y.call(w.attrHandle, t.toLowerCase()) ? n(e, t, !O) : void 0;
            return void 0 !== r ? r : $.attributes || !O ? e.getAttribute(t) : (r = e.getAttributeNode(t)) && r.specified ? r.value : null
        }, t.error = function (e) {
            throw new Error("Syntax error, unrecognized expression: " + e)
        }, t.uniqueSort = function (e) {
            var t, n = [], r = 0, i = 0;
            if (M = !$.detectDuplicates, A = !$.sortStable && e.slice(0), e.sort(W), M) {
                for (; t = e[i++];)t === e[i] && (r = n.push(i));
                for (; r--;)e.splice(n[r], 1)
            }
            return A = null, e
        }, x = t.getText = function (e) {
            var t, n = "", r = 0, i = e.nodeType;
            if (i) {
                if (1 === i || 9 === i || 11 === i) {
                    if ("string" == typeof e.textContent)return e.textContent;
                    for (e = e.firstChild; e; e = e.nextSibling)n += x(e)
                } else if (3 === i || 4 === i)return e.nodeValue
            } else for (; t = e[r++];)n += x(t);
            return n
        }, w = t.selectors = {
            cacheLength: 50,
            createPseudo: r,
            match: ht,
            attrHandle: {},
            find: {},
            relative: {
                ">": {dir: "parentNode", first: !0},
                " ": {dir: "parentNode"},
                "+": {dir: "previousSibling", first: !0},
                "~": {dir: "previousSibling"}
            },
            preFilter: {
                ATTR: function (e) {
                    return e[1] = e[1].replace($t, wt), e[3] = (e[3] || e[4] || e[5] || "").replace($t, wt), "~=" === e[2] && (e[3] = " " + e[3] + " "), e.slice(0, 4)
                }, CHILD: function (e) {
                    return e[1] = e[1].toLowerCase(), "nth" === e[1].slice(0, 3) ? (e[3] || t.error(e[0]), e[4] = +(e[4] ? e[5] + (e[6] || 1) : 2 * ("even" === e[3] || "odd" === e[3])), e[5] = +(e[7] + e[8] || "odd" === e[3])) : e[3] && t.error(e[0]), e
                }, PSEUDO: function (e) {
                    var t, n = !e[6] && e[2];
                    return ht.CHILD.test(e[0]) ? null : (e[3] ? e[2] = e[4] || e[5] || "" : n && pt.test(n) && (t = C(n, !0)) && (t = n.indexOf(")", n.length - t) - n.length) && (e[0] = e[0].slice(0, t), e[2] = n.slice(0, t)), e.slice(0, 3))
                }
            },
            filter: {
                TAG: function (e) {
                    var t = e.replace($t, wt).toLowerCase();
                    return "*" === e ? function () {
                        return !0
                    } : function (e) {
                        return e.nodeName && e.nodeName.toLowerCase() === t
                    }
                }, CLASS: function (e) {
                    var t = H[e + " "];
                    return t || (t = new RegExp("(^|" + rt + ")" + e + "(" + rt + "|$)")) && H(e, function (e) {
                            return t.test("string" == typeof e.className && e.className || typeof e.getAttribute !== G && e.getAttribute("class") || "")
                        })
                }, ATTR: function (e, n, r) {
                    return function (i) {
                        var o = t.attr(i, e);
                        return null == o ? "!=" === n : n ? (o += "", "=" === n ? o === r : "!=" === n ? o !== r : "^=" === n ? r && 0 === o.indexOf(r) : "*=" === n ? r && o.indexOf(r) > -1 : "$=" === n ? r && o.slice(-r.length) === r : "~=" === n ? (" " + o + " ").indexOf(r) > -1 : "|=" === n ? o === r || o.slice(0, r.length + 1) === r + "-" : !1) : !0
                    }
                }, CHILD: function (e, t, n, r, i) {
                    var o = "nth" !== e.slice(0, 3), a = "last" !== e.slice(-4), s = "of-type" === t;
                    return 1 === r && 0 === i ? function (e) {
                        return !!e.parentNode
                    } : function (t, n, c) {
                        var l, u, d, p, f, h, m = o !== a ? "nextSibling" : "previousSibling", g = t.parentNode, v = s && t.nodeName.toLowerCase(), _ = !c && !s;
                        if (g) {
                            if (o) {
                                for (; m;) {
                                    for (d = t; d = d[m];)if (s ? d.nodeName.toLowerCase() === v : 1 === d.nodeType)return !1;
                                    h = m = "only" === e && !h && "nextSibling"
                                }
                                return !0
                            }
                            if (h = [a ? g.firstChild : g.lastChild], a && _) {
                                for (u = g[I] || (g[I] = {}), l = u[e] || [], f = l[0] === B && l[1], p = l[0] === B && l[2], d = f && g.childNodes[f]; d = ++f && d && d[m] || (p = f = 0) || h.pop();)if (1 === d.nodeType && ++p && d === t) {
                                    u[e] = [B, f, p];
                                    break
                                }
                            } else if (_ && (l = (t[I] || (t[I] = {}))[e]) && l[0] === B)p = l[1]; else for (; (d = ++f && d && d[m] || (p = f = 0) || h.pop()) && ((s ? d.nodeName.toLowerCase() !== v : 1 !== d.nodeType) || !++p || (_ && ((d[I] || (d[I] = {}))[e] = [B, p]), d !== t)););
                            return p -= i, p === r || p % r === 0 && p / r >= 0
                        }
                    }
                }, PSEUDO: function (e, n) {
                    var i, o = w.pseudos[e] || w.setFilters[e.toLowerCase()] || t.error("unsupported pseudo: " + e);
                    return o[I] ? o(n) : o.length > 1 ? (i = [e, e, "", n], w.setFilters.hasOwnProperty(e.toLowerCase()) ? r(function (e, t) {
                        for (var r, i = o(e, n), a = i.length; a--;)r = tt.call(e, i[a]), e[r] = !(t[r] = i[a])
                    }) : function (e) {
                        return o(e, 0, i)
                    }) : o
                }
            },
            pseudos: {
                not: r(function (e) {
                    var t = [], n = [], i = k(e.replace(ct, "$1"));
                    return i[I] ? r(function (e, t, n, r) {
                        for (var o, a = i(e, null, r, []), s = e.length; s--;)(o = a[s]) && (e[s] = !(t[s] = o))
                    }) : function (e, r, o) {
                        return t[0] = e, i(t, null, o, n), !n.pop()
                    }
                }), has: r(function (e) {
                    return function (n) {
                        return t(e, n).length > 0
                    }
                }), contains: r(function (e) {
                    return function (t) {
                        return (t.textContent || t.innerText || x(t)).indexOf(e) > -1
                    }
                }), lang: r(function (e) {
                    return ft.test(e || "") || t.error("unsupported lang: " + e), e = e.replace($t, wt).toLowerCase(), function (t) {
                        var n;
                        do if (n = O ? t.lang : t.getAttribute("xml:lang") || t.getAttribute("lang"))return n = n.toLowerCase(), n === e || 0 === n.indexOf(e + "-"); while ((t = t.parentNode) && 1 === t.nodeType);
                        return !1
                    }
                }), target: function (t) {
                    var n = e.location && e.location.hash;
                    return n && n.slice(1) === t.id
                }, root: function (e) {
                    return e === L
                }, focus: function (e) {
                    return e === q.activeElement && (!q.hasFocus || q.hasFocus()) && !!(e.type || e.href || ~e.tabIndex)
                }, enabled: function (e) {
                    return e.disabled === !1
                }, disabled: function (e) {
                    return e.disabled === !0
                }, checked: function (e) {
                    var t = e.nodeName.toLowerCase();
                    return "input" === t && !!e.checked || "option" === t && !!e.selected
                }, selected: function (e) {
                    return e.parentNode && e.parentNode.selectedIndex, e.selected === !0
                }, empty: function (e) {
                    for (e = e.firstChild; e; e = e.nextSibling)if (e.nodeType < 6)return !1;
                    return !0
                }, parent: function (e) {
                    return !w.pseudos.empty(e)
                }, header: function (e) {
                    return gt.test(e.nodeName)
                }, input: function (e) {
                    return mt.test(e.nodeName)
                }, button: function (e) {
                    var t = e.nodeName.toLowerCase();
                    return "input" === t && "button" === e.type || "button" === t
                }, text: function (e) {
                    var t;
                    return "input" === e.nodeName.toLowerCase() && "text" === e.type && (null == (t = e.getAttribute("type")) || "text" === t.toLowerCase())
                }, first: l(function () {
                    return [0]
                }), last: l(function (e, t) {
                    return [t - 1]
                }), eq: l(function (e, t, n) {
                    return [0 > n ? n + t : n]
                }), even: l(function (e, t) {
                    for (var n = 0; t > n; n += 2)e.push(n);
                    return e
                }), odd: l(function (e, t) {
                    for (var n = 1; t > n; n += 2)e.push(n);
                    return e
                }), lt: l(function (e, t, n) {
                    for (var r = 0 > n ? n + t : n; --r >= 0;)e.push(r);
                    return e
                }), gt: l(function (e, t, n) {
                    for (var r = 0 > n ? n + t : n; ++r < t;)e.push(r);
                    return e
                })
            }
        }, w.pseudos.nth = w.pseudos.eq;
        for (b in{radio: !0, checkbox: !0, file: !0, password: !0, image: !0})w.pseudos[b] = s(b);
        for (b in{submit: !0, reset: !0})w.pseudos[b] = c(b);
        return d.prototype = w.filters = w.pseudos, w.setFilters = new d, C = t.tokenize = function (e, n) {
            var r, i, o, a, s, c, l, u = z[e + " "];
            if (u)return n ? 0 : u.slice(0);
            for (s = e, c = [], l = w.preFilter; s;) {
                (!r || (i = lt.exec(s))) && (i && (s = s.slice(i[0].length) || s), c.push(o = [])), r = !1, (i = ut.exec(s)) && (r = i.shift(), o.push({
                    value: r,
                    type: i[0].replace(ct, " ")
                }), s = s.slice(r.length));
                for (a in w.filter)!(i = ht[a].exec(s)) || l[a] && !(i = l[a](i)) || (r = i.shift(), o.push({
                    value: r,
                    type: a,
                    matches: i
                }), s = s.slice(r.length));
                if (!r)break
            }
            return n ? s.length : s ? t.error(e) : z(e, c).slice(0)
        }, k = t.compile = function (e, t) {
            var n, r = [], i = [], o = V[e + " "];
            if (!o) {
                for (t || (t = C(e)), n = t.length; n--;)o = _(t[n]), o[I] ? r.push(o) : i.push(o);
                o = V(e, y(i, r)), o.selector = e
            }
            return o
        }, T = t.select = function (e, t, n, r) {
            var i, o, a, s, c, l = "function" == typeof e && e, d = !r && C(e = l.selector || e);
            if (n = n || [], 1 === d.length) {
                if (o = d[0] = d[0].slice(0), o.length > 2 && "ID" === (a = o[0]).type && $.getById && 9 === t.nodeType && O && w.relative[o[1].type]) {
                    if (t = (w.find.ID(a.matches[0].replace($t, wt), t) || [])[0], !t)return n;
                    l && (t = t.parentNode), e = e.slice(o.shift().value.length)
                }
                for (i = ht.needsContext.test(e) ? 0 : o.length; i-- && (a = o[i], !w.relative[s = a.type]);)if ((c = w.find[s]) && (r = c(a.matches[0].replace($t, wt), yt.test(o[0].type) && u(t.parentNode) || t))) {
                    if (o.splice(i, 1), e = r.length && p(o), !e)return Z.apply(n, r), n;
                    break
                }
            }
            return (l || k(e, d))(r, t, !O, n, yt.test(e) && u(t.parentNode) || t), n
        }, $.sortStable = I.split("").sort(W).join("") === I, $.detectDuplicates = !!M, D(), $.sortDetached = i(function (e) {
            return 1 & e.compareDocumentPosition(q.createElement("div"))
        }), i(function (e) {
            return e.innerHTML = "<a href='#'></a>", "#" === e.firstChild.getAttribute("href")
        }) || o("type|href|height|width", function (e, t, n) {
            return n ? void 0 : e.getAttribute(t, "type" === t.toLowerCase() ? 1 : 2)
        }), $.attributes && i(function (e) {
            return e.innerHTML = "<input/>", e.firstChild.setAttribute("value", ""), "" === e.firstChild.getAttribute("value")
        }) || o("value", function (e, t, n) {
            return n || "input" !== e.nodeName.toLowerCase() ? void 0 : e.defaultValue
        }), i(function (e) {
            return null == e.getAttribute("disabled")
        }) || o(nt, function (e, t, n) {
            var r;
            return n ? void 0 : e[t] === !0 ? t.toLowerCase() : (r = e.getAttributeNode(t)) && r.specified ? r.value : null
        }), t
    }(e);
    it.find = lt, it.expr = lt.selectors, it.expr[":"] = it.expr.pseudos, it.unique = lt.uniqueSort, it.text = lt.getText, it.isXMLDoc = lt.isXML, it.contains = lt.contains;
    var ut = it.expr.match.needsContext, dt = /^<(\w+)\s*\/?>(?:<\/\1>|)$/, pt = /^.[^:#\[\.,]*$/;
    it.filter = function (e, t, n) {
        var r = t[0];
        return n && (e = ":not(" + e + ")"), 1 === t.length && 1 === r.nodeType ? it.find.matchesSelector(r, e) ? [r] : [] : it.find.matches(e, it.grep(t, function (e) {
            return 1 === e.nodeType
        }))
    }, it.fn.extend({
        find: function (e) {
            var t, n = [], r = this, i = r.length;
            if ("string" != typeof e)return this.pushStack(it(e).filter(function () {
                for (t = 0; i > t; t++)if (it.contains(r[t], this))return !0
            }));
            for (t = 0; i > t; t++)it.find(e, r[t], n);
            return n = this.pushStack(i > 1 ? it.unique(n) : n), n.selector = this.selector ? this.selector + " " + e : e, n
        }, filter: function (e) {
            return this.pushStack(r(this, e || [], !1))
        }, not: function (e) {
            return this.pushStack(r(this, e || [], !0))
        }, is: function (e) {
            return !!r(this, "string" == typeof e && ut.test(e) ? it(e) : e || [], !1).length
        }
    });
    var ft, ht = e.document, mt = /^(?:\s*(<[\w\W]+>)[^>]*|#([\w-]*))$/, gt = it.fn.init = function (e, t) {
        var n, r;
        if (!e)return this;
        if ("string" == typeof e) {
            if (n = "<" === e.charAt(0) && ">" === e.charAt(e.length - 1) && e.length >= 3 ? [null, e, null] : mt.exec(e), !n || !n[1] && t)return !t || t.jquery ? (t || ft).find(e) : this.constructor(t).find(e);
            if (n[1]) {
                if (t = t instanceof it ? t[0] : t, it.merge(this, it.parseHTML(n[1], t && t.nodeType ? t.ownerDocument || t : ht, !0)), dt.test(n[1]) && it.isPlainObject(t))for (n in t)it.isFunction(this[n]) ? this[n](t[n]) : this.attr(n, t[n]);
                return this
            }
            if (r = ht.getElementById(n[2]), r && r.parentNode) {
                if (r.id !== n[2])return ft.find(e);
                this.length = 1, this[0] = r
            }
            return this.context = ht, this.selector = e, this
        }
        return e.nodeType ? (this.context = this[0] = e, this.length = 1, this) : it.isFunction(e) ? "undefined" != typeof ft.ready ? ft.ready(e) : e(it) : (void 0 !== e.selector && (this.selector = e.selector, this.context = e.context), it.makeArray(e, this))
    };
    gt.prototype = it.fn, ft = it(ht);
    var vt = /^(?:parents|prev(?:Until|All))/, _t = {children: !0, contents: !0, next: !0, prev: !0};
    it.extend({
        dir: function (e, t, n) {
            for (var r = [], i = e[t]; i && 9 !== i.nodeType && (void 0 === n || 1 !== i.nodeType || !it(i).is(n));)1 === i.nodeType && r.push(i), i = i[t];
            return r
        }, sibling: function (e, t) {
            for (var n = []; e; e = e.nextSibling)1 === e.nodeType && e !== t && n.push(e);
            return n
        }
    }), it.fn.extend({
        has: function (e) {
            var t, n = it(e, this), r = n.length;
            return this.filter(function () {
                for (t = 0; r > t; t++)if (it.contains(this, n[t]))return !0
            })
        }, closest: function (e, t) {
            for (var n, r = 0, i = this.length, o = [], a = ut.test(e) || "string" != typeof e ? it(e, t || this.context) : 0; i > r; r++)for (n = this[r]; n && n !== t; n = n.parentNode)if (n.nodeType < 11 && (a ? a.index(n) > -1 : 1 === n.nodeType && it.find.matchesSelector(n, e))) {
                o.push(n);
                break
            }
            return this.pushStack(o.length > 1 ? it.unique(o) : o)
        }, index: function (e) {
            return e ? "string" == typeof e ? it.inArray(this[0], it(e)) : it.inArray(e.jquery ? e[0] : e, this) : this[0] && this[0].parentNode ? this.first().prevAll().length : -1
        }, add: function (e, t) {
            return this.pushStack(it.unique(it.merge(this.get(), it(e, t))))
        }, addBack: function (e) {
            return this.add(null == e ? this.prevObject : this.prevObject.filter(e))
        }
    }), it.each({
        parent: function (e) {
            var t = e.parentNode;
            return t && 11 !== t.nodeType ? t : null
        }, parents: function (e) {
            return it.dir(e, "parentNode")
        }, parentsUntil: function (e, t, n) {
            return it.dir(e, "parentNode", n)
        }, next: function (e) {
            return i(e, "nextSibling")
        }, prev: function (e) {
            return i(e, "previousSibling")
        }, nextAll: function (e) {
            return it.dir(e, "nextSibling")
        }, prevAll: function (e) {
            return it.dir(e, "previousSibling")
        }, nextUntil: function (e, t, n) {
            return it.dir(e, "nextSibling", n)
        }, prevUntil: function (e, t, n) {
            return it.dir(e, "previousSibling", n)
        }, siblings: function (e) {
            return it.sibling((e.parentNode || {}).firstChild, e)
        }, children: function (e) {
            return it.sibling(e.firstChild)
        }, contents: function (e) {
            return it.nodeName(e, "iframe") ? e.contentDocument || e.contentWindow.document : it.merge([], e.childNodes)
        }
    }, function (e, t) {
        it.fn[e] = function (n, r) {
            var i = it.map(this, t, n);
            return "Until" !== e.slice(-5) && (r = n), r && "string" == typeof r && (i = it.filter(r, i)), this.length > 1 && (_t[e] || (i = it.unique(i)), vt.test(e) && (i = i.reverse())), this.pushStack(i)
        }
    });
    var yt = /\S+/g, bt = {};
    it.Callbacks = function (e) {
        e = "string" == typeof e ? bt[e] || o(e) : it.extend({}, e);
        var t, n, r, i, a, s, c = [], l = !e.once && [], u = function (o) {
            for (n = e.memory && o, r = !0, a = s || 0, s = 0, i = c.length, t = !0; c && i > a; a++)if (c[a].apply(o[0], o[1]) === !1 && e.stopOnFalse) {
                n = !1;
                break
            }
            t = !1, c && (l ? l.length && u(l.shift()) : n ? c = [] : d.disable())
        }, d = {
            add: function () {
                if (c) {
                    var r = c.length;
                    !function o(t) {
                        it.each(t, function (t, n) {
                            var r = it.type(n);
                            "function" === r ? e.unique && d.has(n) || c.push(n) : n && n.length && "string" !== r && o(n)
                        })
                    }(arguments), t ? i = c.length : n && (s = r, u(n))
                }
                return this
            }, remove: function () {
                return c && it.each(arguments, function (e, n) {
                    for (var r; (r = it.inArray(n, c, r)) > -1;)c.splice(r, 1), t && (i >= r && i--, a >= r && a--)
                }), this
            }, has: function (e) {
                return e ? it.inArray(e, c) > -1 : !(!c || !c.length)
            }, empty: function () {
                return c = [], i = 0, this
            }, disable: function () {
                return c = l = n = void 0, this
            }, disabled: function () {
                return !c
            }, lock: function () {
                return l = void 0, n || d.disable(), this
            }, locked: function () {
                return !l
            }, fireWith: function (e, n) {
                return !c || r && !l || (n = n || [], n = [e, n.slice ? n.slice() : n], t ? l.push(n) : u(n)), this
            }, fire: function () {
                return d.fireWith(this, arguments), this
            }, fired: function () {
                return !!r
            }
        };
        return d
    }, it.extend({
        Deferred: function (e) {
            var t = [["resolve", "done", it.Callbacks("once memory"), "resolved"], ["reject", "fail", it.Callbacks("once memory"), "rejected"], ["notify", "progress", it.Callbacks("memory")]], n = "pending", r = {
                state: function () {
                    return n
                }, always: function () {
                    return i.done(arguments).fail(arguments), this
                }, then: function () {
                    var e = arguments;
                    return it.Deferred(function (n) {
                        it.each(t, function (t, o) {
                            var a = it.isFunction(e[t]) && e[t];
                            i[o[1]](function () {
                                var e = a && a.apply(this, arguments);
                                e && it.isFunction(e.promise) ? e.promise().done(n.resolve).fail(n.reject).progress(n.notify) : n[o[0] + "With"](this === r ? n.promise() : this, a ? [e] : arguments)
                            })
                        }), e = null
                    }).promise()
                }, promise: function (e) {
                    return null != e ? it.extend(e, r) : r
                }
            }, i = {};
            return r.pipe = r.then, it.each(t, function (e, o) {
                var a = o[2], s = o[3];
                r[o[1]] = a.add, s && a.add(function () {
                    n = s
                }, t[1 ^ e][2].disable, t[2][2].lock), i[o[0]] = function () {
                    return i[o[0] + "With"](this === i ? r : this, arguments), this
                }, i[o[0] + "With"] = a.fireWith
            }), r.promise(i), e && e.call(i, i), i
        }, when: function (e) {
            var t, n, r, i = 0, o = Y.call(arguments), a = o.length, s = 1 !== a || e && it.isFunction(e.promise) ? a : 0, c = 1 === s ? e : it.Deferred(), l = function (e, n, r) {
                return function (i) {
                    n[e] = this, r[e] = arguments.length > 1 ? Y.call(arguments) : i, r === t ? c.notifyWith(n, r) : --s || c.resolveWith(n, r)
                }
            };
            if (a > 1)for (t = new Array(a), n = new Array(a), r = new Array(a); a > i; i++)o[i] && it.isFunction(o[i].promise) ? o[i].promise().done(l(i, r, o)).fail(c.reject).progress(l(i, n, t)) : --s;
            return s || c.resolveWith(r, o), c.promise()
        }
    });
    var $t;
    it.fn.ready = function (e) {
        return it.ready.promise().done(e), this
    }, it.extend({
        isReady: !1, readyWait: 1, holdReady: function (e) {
            e ? it.readyWait++ : it.ready(!0)
        }, ready: function (e) {
            if (e === !0 ? !--it.readyWait : !it.isReady) {
                if (!ht.body)return setTimeout(it.ready);
                it.isReady = !0, e !== !0 && --it.readyWait > 0 || ($t.resolveWith(ht, [it]), it.fn.triggerHandler && (it(ht).triggerHandler("ready"), it(ht).off("ready")))
            }
        }
    }), it.ready.promise = function (t) {
        if (!$t)if ($t = it.Deferred(), "complete" === ht.readyState)setTimeout(it.ready); else if (ht.addEventListener)ht.addEventListener("DOMContentLoaded", s, !1), e.addEventListener("load", s, !1); else {
            ht.attachEvent("onreadystatechange", s), e.attachEvent("onload", s);
            var n = !1;
            try {
                n = null == e.frameElement && ht.documentElement
            } catch (r) {
            }
            n && n.doScroll && !function i() {
                if (!it.isReady) {
                    try {
                        n.doScroll("left")
                    } catch (e) {
                        return setTimeout(i, 50)
                    }
                    a(), it.ready()
                }
            }()
        }
        return $t.promise(t)
    };
    var wt, xt = "undefined";
    for (wt in it(nt))break;
    nt.ownLast = "0" !== wt, nt.inlineBlockNeedsLayout = !1, it(function () {
        var e, t, n, r;
        n = ht.getElementsByTagName("body")[0], n && n.style && (t = ht.createElement("div"), r = ht.createElement("div"), r.style.cssText = "position:absolute;border:0;width:0;height:0;top:0;left:-9999px", n.appendChild(r).appendChild(t), typeof t.style.zoom !== xt && (t.style.cssText = "display:inline;margin:0;border:0;padding:1px;width:1px;zoom:1", nt.inlineBlockNeedsLayout = e = 3 === t.offsetWidth, e && (n.style.zoom = 1)), n.removeChild(r))
    }), function () {
        var e = ht.createElement("div");
        if (null == nt.deleteExpando) {
            nt.deleteExpando = !0;
            try {
                delete e.test
            } catch (t) {
                nt.deleteExpando = !1
            }
        }
        e = null
    }(), it.acceptData = function (e) {
        var t = it.noData[(e.nodeName + " ").toLowerCase()], n = +e.nodeType || 1;
        return 1 !== n && 9 !== n ? !1 : !t || t !== !0 && e.getAttribute("classid") === t
    };
    var St = /^(?:\{[\w\W]*\}|\[[\w\W]*\])$/, Ct = /([A-Z])/g;
    it.extend({
        cache: {},
        noData: {"applet ": !0, "embed ": !0, "object ": "clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"},
        hasData: function (e) {
            return e = e.nodeType ? it.cache[e[it.expando]] : e[it.expando], !!e && !l(e)
        },
        data: function (e, t, n) {
            return u(e, t, n)
        },
        removeData: function (e, t) {
            return d(e, t)
        },
        _data: function (e, t, n) {
            return u(e, t, n, !0)
        },
        _removeData: function (e, t) {
            return d(e, t, !0)
        }
    }), it.fn.extend({
        data: function (e, t) {
            var n, r, i, o = this[0], a = o && o.attributes;
            if (void 0 === e) {
                if (this.length && (i = it.data(o), 1 === o.nodeType && !it._data(o, "parsedAttrs"))) {
                    for (n = a.length; n--;)a[n] && (r = a[n].name, 0 === r.indexOf("data-") && (r = it.camelCase(r.slice(5)), c(o, r, i[r])));
                    it._data(o, "parsedAttrs", !0)
                }
                return i
            }
            return "object" == typeof e ? this.each(function () {
                it.data(this, e)
            }) : arguments.length > 1 ? this.each(function () {
                it.data(this, e, t)
            }) : o ? c(o, e, it.data(o, e)) : void 0
        }, removeData: function (e) {
            return this.each(function () {
                it.removeData(this, e)
            })
        }
    }), it.extend({
        queue: function (e, t, n) {
            var r;
            return e ? (t = (t || "fx") + "queue", r = it._data(e, t), n && (!r || it.isArray(n) ? r = it._data(e, t, it.makeArray(n)) : r.push(n)), r || []) : void 0
        }, dequeue: function (e, t) {
            t = t || "fx";
            var n = it.queue(e, t), r = n.length, i = n.shift(), o = it._queueHooks(e, t), a = function () {
                it.dequeue(e, t)
            };
            "inprogress" === i && (i = n.shift(), r--), i && ("fx" === t && n.unshift("inprogress"), delete o.stop, i.call(e, a, o)), !r && o && o.empty.fire()
        }, _queueHooks: function (e, t) {
            var n = t + "queueHooks";
            return it._data(e, n) || it._data(e, n, {
                    empty: it.Callbacks("once memory").add(function () {
                        it._removeData(e, t + "queue"), it._removeData(e, n)
                    })
                })
        }
    }), it.fn.extend({
        queue: function (e, t) {
            var n = 2;
            return "string" != typeof e && (t = e, e = "fx", n--), arguments.length < n ? it.queue(this[0], e) : void 0 === t ? this : this.each(function () {
                var n = it.queue(this, e, t);
                it._queueHooks(this, e), "fx" === e && "inprogress" !== n[0] && it.dequeue(this, e)
            })
        }, dequeue: function (e) {
            return this.each(function () {
                it.dequeue(this, e)
            })
        }, clearQueue: function (e) {
            return this.queue(e || "fx", [])
        }, promise: function (e, t) {
            var n, r = 1, i = it.Deferred(), o = this, a = this.length, s = function () {
                --r || i.resolveWith(o, [o])
            };
            for ("string" != typeof e && (t = e, e = void 0), e = e || "fx"; a--;)n = it._data(o[a], e + "queueHooks"), n && n.empty && (r++, n.empty.add(s));
            return s(), i.promise(t)
        }
    });
    var kt = /[+-]?(?:\d*\.|)\d+(?:[eE][+-]?\d+|)/.source, Tt = ["Top", "Right", "Bottom", "Left"], Et = function (e, t) {
        return e = t || e, "none" === it.css(e, "display") || !it.contains(e.ownerDocument, e)
    }, At = it.access = function (e, t, n, r, i, o, a) {
        var s = 0, c = e.length, l = null == n;
        if ("object" === it.type(n)) {
            i = !0;
            for (s in n)it.access(e, t, s, n[s], !0, o, a)
        } else if (void 0 !== r && (i = !0, it.isFunction(r) || (a = !0), l && (a ? (t.call(e, r), t = null) : (l = t, t = function (e, t, n) {
                return l.call(it(e), n)
            })), t))for (; c > s; s++)t(e[s], n, a ? r : r.call(e[s], s, t(e[s], n)));
        return i ? e : l ? t.call(e) : c ? t(e[0], n) : o
    }, Mt = /^(?:checkbox|radio)$/i;
    !function () {
        var e = ht.createElement("input"), t = ht.createElement("div"), n = ht.createDocumentFragment();
        if (t.innerHTML = "  <link/><table></table><a href='/a'>a</a><input type='checkbox'/>", nt.leadingWhitespace = 3 === t.firstChild.nodeType, nt.tbody = !t.getElementsByTagName("tbody").length, nt.htmlSerialize = !!t.getElementsByTagName("link").length, nt.html5Clone = "<:nav></:nav>" !== ht.createElement("nav").cloneNode(!0).outerHTML, e.type = "checkbox", e.checked = !0, n.appendChild(e), nt.appendChecked = e.checked, t.innerHTML = "<textarea>x</textarea>", nt.noCloneChecked = !!t.cloneNode(!0).lastChild.defaultValue, n.appendChild(t), t.innerHTML = "<input type='radio' checked='checked' name='t'/>", nt.checkClone = t.cloneNode(!0).cloneNode(!0).lastChild.checked, nt.noCloneEvent = !0, t.attachEvent && (t.attachEvent("onclick", function () {
                nt.noCloneEvent = !1
            }), t.cloneNode(!0).click()), null == nt.deleteExpando) {
            nt.deleteExpando = !0;
            try {
                delete t.test
            } catch (r) {
                nt.deleteExpando = !1
            }
        }
    }(), function () {
        var t, n, r = ht.createElement("div");
        for (t in{
            submit: !0,
            change: !0,
            focusin: !0
        })n = "on" + t, (nt[t + "Bubbles"] = n in e) || (r.setAttribute(n, "t"), nt[t + "Bubbles"] = r.attributes[n].expando === !1);
        r = null
    }();
    var Dt = /^(?:input|select|textarea)$/i, qt = /^key/, Lt = /^(?:mouse|pointer|contextmenu)|click/, Ot = /^(?:focusinfocus|focusoutblur)$/, Pt = /^([^.]*)(?:\.(.+)|)$/;
    it.event = {
        global: {},
        add: function (e, t, n, r, i) {
            var o, a, s, c, l, u, d, p, f, h, m, g = it._data(e);
            if (g) {
                for (n.handler && (c = n, n = c.handler, i = c.selector), n.guid || (n.guid = it.guid++), (a = g.events) || (a = g.events = {}), (u = g.handle) || (u = g.handle = function (e) {
                    return typeof it === xt || e && it.event.triggered === e.type ? void 0 : it.event.dispatch.apply(u.elem, arguments)
                }, u.elem = e), t = (t || "").match(yt) || [""], s = t.length; s--;)o = Pt.exec(t[s]) || [], f = m = o[1], h = (o[2] || "").split(".").sort(), f && (l = it.event.special[f] || {}, f = (i ? l.delegateType : l.bindType) || f, l = it.event.special[f] || {}, d = it.extend({
                    type: f,
                    origType: m,
                    data: r,
                    handler: n,
                    guid: n.guid,
                    selector: i,
                    needsContext: i && it.expr.match.needsContext.test(i),
                    namespace: h.join(".")
                }, c), (p = a[f]) || (p = a[f] = [], p.delegateCount = 0, l.setup && l.setup.call(e, r, h, u) !== !1 || (e.addEventListener ? e.addEventListener(f, u, !1) : e.attachEvent && e.attachEvent("on" + f, u))), l.add && (l.add.call(e, d), d.handler.guid || (d.handler.guid = n.guid)), i ? p.splice(p.delegateCount++, 0, d) : p.push(d), it.event.global[f] = !0);
                e = null
            }
        },
        remove: function (e, t, n, r, i) {
            var o, a, s, c, l, u, d, p, f, h, m, g = it.hasData(e) && it._data(e);
            if (g && (u = g.events)) {
                for (t = (t || "").match(yt) || [""], l = t.length; l--;)if (s = Pt.exec(t[l]) || [], f = m = s[1], h = (s[2] || "").split(".").sort(), f) {
                    for (d = it.event.special[f] || {}, f = (r ? d.delegateType : d.bindType) || f, p = u[f] || [], s = s[2] && new RegExp("(^|\\.)" + h.join("\\.(?:.*\\.|)") + "(\\.|$)"), c = o = p.length; o--;)a = p[o], !i && m !== a.origType || n && n.guid !== a.guid || s && !s.test(a.namespace) || r && r !== a.selector && ("**" !== r || !a.selector) || (p.splice(o, 1), a.selector && p.delegateCount--, d.remove && d.remove.call(e, a));
                    c && !p.length && (d.teardown && d.teardown.call(e, h, g.handle) !== !1 || it.removeEvent(e, f, g.handle), delete u[f])
                } else for (f in u)it.event.remove(e, f + t[l], n, r, !0);
                it.isEmptyObject(u) && (delete g.handle, it._removeData(e, "events"))
            }
        },
        trigger: function (t, n, r, i) {
            var o, a, s, c, l, u, d, p = [r || ht], f = tt.call(t, "type") ? t.type : t, h = tt.call(t, "namespace") ? t.namespace.split(".") : [];
            if (s = u = r = r || ht, 3 !== r.nodeType && 8 !== r.nodeType && !Ot.test(f + it.event.triggered) && (f.indexOf(".") >= 0 && (h = f.split("."), f = h.shift(), h.sort()), a = f.indexOf(":") < 0 && "on" + f, t = t[it.expando] ? t : new it.Event(f, "object" == typeof t && t), t.isTrigger = i ? 2 : 3, t.namespace = h.join("."), t.namespace_re = t.namespace ? new RegExp("(^|\\.)" + h.join("\\.(?:.*\\.|)") + "(\\.|$)") : null, t.result = void 0, t.target || (t.target = r), n = null == n ? [t] : it.makeArray(n, [t]), l = it.event.special[f] || {}, i || !l.trigger || l.trigger.apply(r, n) !== !1)) {
                if (!i && !l.noBubble && !it.isWindow(r)) {
                    for (c = l.delegateType || f, Ot.test(c + f) || (s = s.parentNode); s; s = s.parentNode)p.push(s), u = s;
                    u === (r.ownerDocument || ht) && p.push(u.defaultView || u.parentWindow || e)
                }
                for (d = 0; (s = p[d++]) && !t.isPropagationStopped();)t.type = d > 1 ? c : l.bindType || f, o = (it._data(s, "events") || {})[t.type] && it._data(s, "handle"), o && o.apply(s, n), o = a && s[a], o && o.apply && it.acceptData(s) && (t.result = o.apply(s, n), t.result === !1 && t.preventDefault());
                if (t.type = f, !i && !t.isDefaultPrevented() && (!l._default || l._default.apply(p.pop(), n) === !1) && it.acceptData(r) && a && r[f] && !it.isWindow(r)) {
                    u = r[a], u && (r[a] = null), it.event.triggered = f;
                    try {
                        r[f]()
                    } catch (m) {
                    }
                    it.event.triggered = void 0, u && (r[a] = u)
                }
                return t.result
            }
        },
        dispatch: function (e) {
            e = it.event.fix(e);
            var t, n, r, i, o, a = [], s = Y.call(arguments), c = (it._data(this, "events") || {})[e.type] || [], l = it.event.special[e.type] || {};
            if (s[0] = e, e.delegateTarget = this, !l.preDispatch || l.preDispatch.call(this, e) !== !1) {
                for (a = it.event.handlers.call(this, e, c), t = 0; (i = a[t++]) && !e.isPropagationStopped();)for (e.currentTarget = i.elem, o = 0; (r = i.handlers[o++]) && !e.isImmediatePropagationStopped();)(!e.namespace_re || e.namespace_re.test(r.namespace)) && (e.handleObj = r, e.data = r.data, n = ((it.event.special[r.origType] || {}).handle || r.handler).apply(i.elem, s), void 0 !== n && (e.result = n) === !1 && (e.preventDefault(), e.stopPropagation()));
                return l.postDispatch && l.postDispatch.call(this, e), e.result
            }
        },
        handlers: function (e, t) {
            var n, r, i, o, a = [], s = t.delegateCount, c = e.target;
            if (s && c.nodeType && (!e.button || "click" !== e.type))for (; c != this; c = c.parentNode || this)if (1 === c.nodeType && (c.disabled !== !0 || "click" !== e.type)) {
                for (i = [], o = 0; s > o; o++)r = t[o], n = r.selector + " ", void 0 === i[n] && (i[n] = r.needsContext ? it(n, this).index(c) >= 0 : it.find(n, this, null, [c]).length), i[n] && i.push(r);
                i.length && a.push({elem: c, handlers: i})
            }
            return s < t.length && a.push({elem: this, handlers: t.slice(s)}), a
        },
        fix: function (e) {
            if (e[it.expando])return e;
            var t, n, r, i = e.type, o = e, a = this.fixHooks[i];
            for (a || (this.fixHooks[i] = a = Lt.test(i) ? this.mouseHooks : qt.test(i) ? this.keyHooks : {}), r = a.props ? this.props.concat(a.props) : this.props, e = new it.Event(o), t = r.length; t--;)n = r[t], e[n] = o[n];
            return e.target || (e.target = o.srcElement || ht), 3 === e.target.nodeType && (e.target = e.target.parentNode), e.metaKey = !!e.metaKey, a.filter ? a.filter(e, o) : e
        },
        props: "altKey bubbles cancelable ctrlKey currentTarget eventPhase metaKey relatedTarget shiftKey target timeStamp view which".split(" "),
        fixHooks: {},
        keyHooks: {
            props: "char charCode key keyCode".split(" "), filter: function (e, t) {
                return null == e.which && (e.which = null != t.charCode ? t.charCode : t.keyCode), e
            }
        },
        mouseHooks: {
            props: "button buttons clientX clientY fromElement offsetX offsetY pageX pageY screenX screenY toElement".split(" "),
            filter: function (e, t) {
                var n, r, i, o = t.button, a = t.fromElement;
                return null == e.pageX && null != t.clientX && (r = e.target.ownerDocument || ht, i = r.documentElement, n = r.body, e.pageX = t.clientX + (i && i.scrollLeft || n && n.scrollLeft || 0) - (i && i.clientLeft || n && n.clientLeft || 0), e.pageY = t.clientY + (i && i.scrollTop || n && n.scrollTop || 0) - (i && i.clientTop || n && n.clientTop || 0)), !e.relatedTarget && a && (e.relatedTarget = a === e.target ? t.toElement : a), e.which || void 0 === o || (e.which = 1 & o ? 1 : 2 & o ? 3 : 4 & o ? 2 : 0), e
            }
        },
        special: {
            load: {noBubble: !0}, focus: {
                trigger: function () {
                    if (this !== h() && this.focus)try {
                        return this.focus(), !1
                    } catch (e) {
                    }
                }, delegateType: "focusin"
            }, blur: {
                trigger: function () {
                    return this === h() && this.blur ? (this.blur(), !1) : void 0
                }, delegateType: "focusout"
            }, click: {
                trigger: function () {
                    return it.nodeName(this, "input") && "checkbox" === this.type && this.click ? (this.click(), !1) : void 0
                }, _default: function (e) {
                    return it.nodeName(e.target, "a")
                }
            }, beforeunload: {
                postDispatch: function (e) {
                    void 0 !== e.result && e.originalEvent && (e.originalEvent.returnValue = e.result)
                }
            }
        },
        simulate: function (e, t, n, r) {
            var i = it.extend(new it.Event, n, {type: e, isSimulated: !0, originalEvent: {}});
            r ? it.event.trigger(i, null, t) : it.event.dispatch.call(t, i), i.isDefaultPrevented() && n.preventDefault()
        }
    }, it.removeEvent = ht.removeEventListener ? function (e, t, n) {
        e.removeEventListener && e.removeEventListener(t, n, !1)
    } : function (e, t, n) {
        var r = "on" + t;
        e.detachEvent && (typeof e[r] === xt && (e[r] = null), e.detachEvent(r, n))
    }, it.Event = function (e, t) {
        return this instanceof it.Event ? (e && e.type ? (this.originalEvent = e, this.type = e.type, this.isDefaultPrevented = e.defaultPrevented || void 0 === e.defaultPrevented && e.returnValue === !1 ? p : f) : this.type = e, t && it.extend(this, t), this.timeStamp = e && e.timeStamp || it.now(), void(this[it.expando] = !0)) : new it.Event(e, t)
    }, it.Event.prototype = {
        isDefaultPrevented: f,
        isPropagationStopped: f,
        isImmediatePropagationStopped: f,
        preventDefault: function () {
            var e = this.originalEvent;
            this.isDefaultPrevented = p, e && (e.preventDefault ? e.preventDefault() : e.returnValue = !1)
        },
        stopPropagation: function () {
            var e = this.originalEvent;
            this.isPropagationStopped = p, e && (e.stopPropagation && e.stopPropagation(), e.cancelBubble = !0)
        },
        stopImmediatePropagation: function () {
            var e = this.originalEvent;
            this.isImmediatePropagationStopped = p, e && e.stopImmediatePropagation && e.stopImmediatePropagation(), this.stopPropagation()
        }
    }, it.each({
        mouseenter: "mouseover",
        mouseleave: "mouseout",
        pointerenter: "pointerover",
        pointerleave: "pointerout"
    }, function (e, t) {
        it.event.special[e] = {
            delegateType: t, bindType: t, handle: function (e) {
                var n, r = this, i = e.relatedTarget, o = e.handleObj;
                return (!i || i !== r && !it.contains(r, i)) && (e.type = o.origType, n = o.handler.apply(this, arguments), e.type = t), n
            }
        }
    }), nt.submitBubbles || (it.event.special.submit = {
        setup: function () {
            return it.nodeName(this, "form") ? !1 : void it.event.add(this, "click._submit keypress._submit", function (e) {
                var t = e.target, n = it.nodeName(t, "input") || it.nodeName(t, "button") ? t.form : void 0;
                n && !it._data(n, "submitBubbles") && (it.event.add(n, "submit._submit", function (e) {
                    e._submit_bubble = !0
                }), it._data(n, "submitBubbles", !0))
            })
        }, postDispatch: function (e) {
            e._submit_bubble && (delete e._submit_bubble, this.parentNode && !e.isTrigger && it.event.simulate("submit", this.parentNode, e, !0))
        }, teardown: function () {
            return it.nodeName(this, "form") ? !1 : void it.event.remove(this, "._submit")
        }
    }), nt.changeBubbles || (it.event.special.change = {
        setup: function () {
            return Dt.test(this.nodeName) ? (("checkbox" === this.type || "radio" === this.type) && (it.event.add(this, "propertychange._change", function (e) {
                "checked" === e.originalEvent.propertyName && (this._just_changed = !0)
            }), it.event.add(this, "click._change", function (e) {
                this._just_changed && !e.isTrigger && (this._just_changed = !1), it.event.simulate("change", this, e, !0)
            })), !1) : void it.event.add(this, "beforeactivate._change", function (e) {
                var t = e.target;
                Dt.test(t.nodeName) && !it._data(t, "changeBubbles") && (it.event.add(t, "change._change", function (e) {
                    !this.parentNode || e.isSimulated || e.isTrigger || it.event.simulate("change", this.parentNode, e, !0)
                }), it._data(t, "changeBubbles", !0))
            })
        }, handle: function (e) {
            var t = e.target;
            return this !== t || e.isSimulated || e.isTrigger || "radio" !== t.type && "checkbox" !== t.type ? e.handleObj.handler.apply(this, arguments) : void 0
        }, teardown: function () {
            return it.event.remove(this, "._change"), !Dt.test(this.nodeName)
        }
    }), nt.focusinBubbles || it.each({focus: "focusin", blur: "focusout"}, function (e, t) {
        var n = function (e) {
            it.event.simulate(t, e.target, it.event.fix(e), !0)
        };
        it.event.special[t] = {
            setup: function () {
                var r = this.ownerDocument || this, i = it._data(r, t);
                i || r.addEventListener(e, n, !0), it._data(r, t, (i || 0) + 1)
            }, teardown: function () {
                var r = this.ownerDocument || this, i = it._data(r, t) - 1;
                i ? it._data(r, t, i) : (r.removeEventListener(e, n, !0), it._removeData(r, t))
            }
        }
    }), it.fn.extend({
        on: function (e, t, n, r, i) {
            var o, a;
            if ("object" == typeof e) {
                "string" != typeof t && (n = n || t, t = void 0);
                for (o in e)this.on(o, t, n, e[o], i);
                return this
            }
            if (null == n && null == r ? (r = t, n = t = void 0) : null == r && ("string" == typeof t ? (r = n, n = void 0) : (r = n, n = t, t = void 0)), r === !1)r = f; else if (!r)return this;
            return 1 === i && (a = r, r = function (e) {
                return it().off(e), a.apply(this, arguments)
            }, r.guid = a.guid || (a.guid = it.guid++)), this.each(function () {
                it.event.add(this, e, r, n, t)
            })
        }, one: function (e, t, n, r) {
            return this.on(e, t, n, r, 1)
        }, off: function (e, t, n) {
            var r, i;
            if (e && e.preventDefault && e.handleObj)return r = e.handleObj, it(e.delegateTarget).off(r.namespace ? r.origType + "." + r.namespace : r.origType, r.selector, r.handler), this;
            if ("object" == typeof e) {
                for (i in e)this.off(i, t, e[i]);
                return this
            }
            return (t === !1 || "function" == typeof t) && (n = t, t = void 0), n === !1 && (n = f), this.each(function () {
                it.event.remove(this, e, n, t)
            })
        }, trigger: function (e, t) {
            return this.each(function () {
                it.event.trigger(e, t, this)
            })
        }, triggerHandler: function (e, t) {
            var n = this[0];
            return n ? it.event.trigger(e, t, n, !0) : void 0
        }
    });
    var Nt = "abbr|article|aside|audio|bdi|canvas|data|datalist|details|figcaption|figure|footer|header|hgroup|mark|meter|nav|output|progress|section|summary|time|video", jt = / jQuery\d+="(?:null|\d+)"/g, Rt = new RegExp("<(?:" + Nt + ")[\\s/>]", "i"), It = /^\s+/, Ut = /<(?!area|br|col|embed|hr|img|input|link|meta|param)(([\w:]+)[^>]*)\/>/gi, Bt = /<([\w:]+)/, Ft = /<tbody/i, Ht = /<|&#?\w+;/, zt = /<(?:script|style|link)/i, Vt = /checked\s*(?:[^=]|=\s*.checked.)/i, Wt = /^$|\/(?:java|ecma)script/i, Gt = /^true\/(.*)/, Xt = /^\s*<!(?:\[CDATA\[|--)|(?:\]\]|--)>\s*$/g, Yt = {
        option: [1, "<select multiple='multiple'>", "</select>"],
        legend: [1, "<fieldset>", "</fieldset>"],
        area: [1, "<map>", "</map>"],
        param: [1, "<object>", "</object>"],
        thead: [1, "<table>", "</table>"],
        tr: [2, "<table><tbody>", "</tbody></table>"],
        col: [2, "<table><tbody></tbody><colgroup>", "</colgroup></table>"],
        td: [3, "<table><tbody><tr>", "</tr></tbody></table>"],
        _default: nt.htmlSerialize ? [0, "", ""] : [1, "X<div>", "</div>"]
    }, Qt = m(ht), Kt = Qt.appendChild(ht.createElement("div"));
    Yt.optgroup = Yt.option, Yt.tbody = Yt.tfoot = Yt.colgroup = Yt.caption = Yt.thead, Yt.th = Yt.td, it.extend({
        clone: function (e, t, n) {
            var r, i, o, a, s, c = it.contains(e.ownerDocument, e);
            if (nt.html5Clone || it.isXMLDoc(e) || !Rt.test("<" + e.nodeName + ">") ? o = e.cloneNode(!0) : (Kt.innerHTML = e.outerHTML, Kt.removeChild(o = Kt.firstChild)), !(nt.noCloneEvent && nt.noCloneChecked || 1 !== e.nodeType && 11 !== e.nodeType || it.isXMLDoc(e)))for (r = g(o), s = g(e), a = 0; null != (i = s[a]); ++a)r[a] && x(i, r[a]);
            if (t)if (n)for (s = s || g(e), r = r || g(o), a = 0; null != (i = s[a]); a++)w(i, r[a]); else w(e, o);
            return r = g(o, "script"), r.length > 0 && $(r, !c && g(e, "script")), r = s = i = null, o
        }, buildFragment: function (e, t, n, r) {
            for (var i, o, a, s, c, l, u, d = e.length, p = m(t), f = [], h = 0; d > h; h++)if (o = e[h], o || 0 === o)if ("object" === it.type(o))it.merge(f, o.nodeType ? [o] : o); else if (Ht.test(o)) {
                for (s = s || p.appendChild(t.createElement("div")), c = (Bt.exec(o) || ["", ""])[1].toLowerCase(), u = Yt[c] || Yt._default, s.innerHTML = u[1] + o.replace(Ut, "<$1></$2>") + u[2], i = u[0]; i--;)s = s.lastChild;
                if (!nt.leadingWhitespace && It.test(o) && f.push(t.createTextNode(It.exec(o)[0])), !nt.tbody)for (o = "table" !== c || Ft.test(o) ? "<table>" !== u[1] || Ft.test(o) ? 0 : s : s.firstChild, i = o && o.childNodes.length; i--;)it.nodeName(l = o.childNodes[i], "tbody") && !l.childNodes.length && o.removeChild(l);
                for (it.merge(f, s.childNodes), s.textContent = ""; s.firstChild;)s.removeChild(s.firstChild);
                s = p.lastChild
            } else f.push(t.createTextNode(o));
            for (s && p.removeChild(s), nt.appendChecked || it.grep(g(f, "input"), v), h = 0; o = f[h++];)if ((!r || -1 === it.inArray(o, r)) && (a = it.contains(o.ownerDocument, o), s = g(p.appendChild(o), "script"), a && $(s), n))for (i = 0; o = s[i++];)Wt.test(o.type || "") && n.push(o);
            return s = null, p
        }, cleanData: function (e, t) {
            for (var n, r, i, o, a = 0, s = it.expando, c = it.cache, l = nt.deleteExpando, u = it.event.special; null != (n = e[a]); a++)if ((t || it.acceptData(n)) && (i = n[s], o = i && c[i])) {
                if (o.events)for (r in o.events)u[r] ? it.event.remove(n, r) : it.removeEvent(n, r, o.handle);
                c[i] && (delete c[i], l ? delete n[s] : typeof n.removeAttribute !== xt ? n.removeAttribute(s) : n[s] = null, X.push(i))
            }
        }
    }), it.fn.extend({
        text: function (e) {
            return At(this, function (e) {
                return void 0 === e ? it.text(this) : this.empty().append((this[0] && this[0].ownerDocument || ht).createTextNode(e))
            }, null, e, arguments.length)
        }, append: function () {
            return this.domManip(arguments, function (e) {
                if (1 === this.nodeType || 11 === this.nodeType || 9 === this.nodeType) {
                    var t = _(this, e);
                    t.appendChild(e)
                }
            })
        }, prepend: function () {
            return this.domManip(arguments, function (e) {
                if (1 === this.nodeType || 11 === this.nodeType || 9 === this.nodeType) {
                    var t = _(this, e);
                    t.insertBefore(e, t.firstChild)
                }
            })
        }, before: function () {
            return this.domManip(arguments, function (e) {
                this.parentNode && this.parentNode.insertBefore(e, this)
            })
        }, after: function () {
            return this.domManip(arguments, function (e) {
                this.parentNode && this.parentNode.insertBefore(e, this.nextSibling)
            })
        }, remove: function (e, t) {
            for (var n, r = e ? it.filter(e, this) : this, i = 0; null != (n = r[i]); i++)t || 1 !== n.nodeType || it.cleanData(g(n)), n.parentNode && (t && it.contains(n.ownerDocument, n) && $(g(n, "script")), n.parentNode.removeChild(n));
            return this
        }, empty: function () {
            for (var e, t = 0; null != (e = this[t]); t++) {
                for (1 === e.nodeType && it.cleanData(g(e, !1)); e.firstChild;)e.removeChild(e.firstChild);
                e.options && it.nodeName(e, "select") && (e.options.length = 0)
            }
            return this
        }, clone: function (e, t) {
            return e = null == e ? !1 : e, t = null == t ? e : t, this.map(function () {
                return it.clone(this, e, t)
            })
        }, html: function (e) {
            return At(this, function (e) {
                var t = this[0] || {}, n = 0, r = this.length;
                if (void 0 === e)return 1 === t.nodeType ? t.innerHTML.replace(jt, "") : void 0;
                if (!("string" != typeof e || zt.test(e) || !nt.htmlSerialize && Rt.test(e) || !nt.leadingWhitespace && It.test(e) || Yt[(Bt.exec(e) || ["", ""])[1].toLowerCase()])) {
                    e = e.replace(Ut, "<$1></$2>");
                    try {
                        for (; r > n; n++)t = this[n] || {}, 1 === t.nodeType && (it.cleanData(g(t, !1)), t.innerHTML = e);
                        t = 0
                    } catch (i) {
                    }
                }
                t && this.empty().append(e)
            }, null, e, arguments.length)
        }, replaceWith: function () {
            var e = arguments[0];
            return this.domManip(arguments, function (t) {
                e = this.parentNode, it.cleanData(g(this)), e && e.replaceChild(t, this)
            }), e && (e.length || e.nodeType) ? this : this.remove()
        }, detach: function (e) {
            return this.remove(e, !0)
        }, domManip: function (e, t) {
            e = Q.apply([], e);
            var n, r, i, o, a, s, c = 0, l = this.length, u = this, d = l - 1, p = e[0], f = it.isFunction(p);
            if (f || l > 1 && "string" == typeof p && !nt.checkClone && Vt.test(p))return this.each(function (n) {
                var r = u.eq(n);
                f && (e[0] = p.call(this, n, r.html())), r.domManip(e, t)
            });
            if (l && (s = it.buildFragment(e, this[0].ownerDocument, !1, this), n = s.firstChild, 1 === s.childNodes.length && (s = n), n)) {
                for (o = it.map(g(s, "script"), y), i = o.length; l > c; c++)r = s, c !== d && (r = it.clone(r, !0, !0), i && it.merge(o, g(r, "script"))), t.call(this[c], r, c);
                if (i)for (a = o[o.length - 1].ownerDocument, it.map(o, b), c = 0; i > c; c++)r = o[c], Wt.test(r.type || "") && !it._data(r, "globalEval") && it.contains(a, r) && (r.src ? it._evalUrl && it._evalUrl(r.src) : it.globalEval((r.text || r.textContent || r.innerHTML || "").replace(Xt, "")));
                s = n = null
            }
            return this
        }
    }), it.each({
        appendTo: "append",
        prependTo: "prepend",
        insertBefore: "before",
        insertAfter: "after",
        replaceAll: "replaceWith"
    }, function (e, t) {
        it.fn[e] = function (e) {
            for (var n, r = 0, i = [], o = it(e), a = o.length - 1; a >= r; r++)n = r === a ? this : this.clone(!0), it(o[r])[t](n), K.apply(i, n.get());
            return this.pushStack(i)
        }
    });
    var Jt, Zt = {};
    !function () {
        var e;
        nt.shrinkWrapBlocks = function () {
            if (null != e)return e;
            e = !1;
            var t, n, r;
            return n = ht.getElementsByTagName("body")[0], n && n.style ? (t = ht.createElement("div"), r = ht.createElement("div"), r.style.cssText = "position:absolute;border:0;width:0;height:0;top:0;left:-9999px", n.appendChild(r).appendChild(t), typeof t.style.zoom !== xt && (t.style.cssText = "-webkit-box-sizing:content-box;-moz-box-sizing:content-box;box-sizing:content-box;display:block;margin:0;border:0;padding:1px;width:1px;zoom:1", t.appendChild(ht.createElement("div")).style.width = "5px", e = 3 !== t.offsetWidth), n.removeChild(r), e) : void 0
        }
    }();
    var en, tn, nn = /^margin/, rn = new RegExp("^(" + kt + ")(?!px)[a-z%]+$", "i"), on = /^(top|right|bottom|left)$/;
    e.getComputedStyle ? (en = function (e) {
        return e.ownerDocument.defaultView.getComputedStyle(e, null)
    }, tn = function (e, t, n) {
        var r, i, o, a, s = e.style;
        return n = n || en(e), a = n ? n.getPropertyValue(t) || n[t] : void 0, n && ("" !== a || it.contains(e.ownerDocument, e) || (a = it.style(e, t)), rn.test(a) && nn.test(t) && (r = s.width, i = s.minWidth, o = s.maxWidth, s.minWidth = s.maxWidth = s.width = a, a = n.width, s.width = r, s.minWidth = i, s.maxWidth = o)), void 0 === a ? a : a + ""
    }) : ht.documentElement.currentStyle && (en = function (e) {
        return e.currentStyle
    }, tn = function (e, t, n) {
        var r, i, o, a, s = e.style;
        return n = n || en(e), a = n ? n[t] : void 0, null == a && s && s[t] && (a = s[t]), rn.test(a) && !on.test(t) && (r = s.left, i = e.runtimeStyle, o = i && i.left, o && (i.left = e.currentStyle.left), s.left = "fontSize" === t ? "1em" : a, a = s.pixelLeft + "px", s.left = r, o && (i.left = o)), void 0 === a ? a : a + "" || "auto"
    }), function () {
        function t() {
            var t, n, r, i;
            n = ht.getElementsByTagName("body")[0], n && n.style && (t = ht.createElement("div"), r = ht.createElement("div"), r.style.cssText = "position:absolute;border:0;width:0;height:0;top:0;left:-9999px", n.appendChild(r).appendChild(t), t.style.cssText = "-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;display:block;margin-top:1%;top:1%;border:1px;padding:1px;width:4px;position:absolute", o = a = !1, c = !0, e.getComputedStyle && (o = "1%" !== (e.getComputedStyle(t, null) || {}).top, a = "4px" === (e.getComputedStyle(t, null) || {width: "4px"}).width, i = t.appendChild(ht.createElement("div")), i.style.cssText = t.style.cssText = "-webkit-box-sizing:content-box;-moz-box-sizing:content-box;box-sizing:content-box;display:block;margin:0;border:0;padding:0", i.style.marginRight = i.style.width = "0", t.style.width = "1px", c = !parseFloat((e.getComputedStyle(i, null) || {}).marginRight)), t.innerHTML = "<table><tr><td></td><td>t</td></tr></table>", i = t.getElementsByTagName("td"), i[0].style.cssText = "margin:0;border:0;padding:0;display:none", s = 0 === i[0].offsetHeight, s && (i[0].style.display = "", i[1].style.display = "none", s = 0 === i[0].offsetHeight), n.removeChild(r))
        }

        var n, r, i, o, a, s, c;
        n = ht.createElement("div"), n.innerHTML = "  <link/><table></table><a href='/a'>a</a><input type='checkbox'/>", i = n.getElementsByTagName("a")[0], r = i && i.style, r && (r.cssText = "float:left;opacity:.5", nt.opacity = "0.5" === r.opacity, nt.cssFloat = !!r.cssFloat, n.style.backgroundClip = "content-box", n.cloneNode(!0).style.backgroundClip = "", nt.clearCloneStyle = "content-box" === n.style.backgroundClip, nt.boxSizing = "" === r.boxSizing || "" === r.MozBoxSizing || "" === r.WebkitBoxSizing, it.extend(nt, {
            reliableHiddenOffsets: function () {
                return null == s && t(), s
            }, boxSizingReliable: function () {
                return null == a && t(), a
            }, pixelPosition: function () {
                return null == o && t(), o
            }, reliableMarginRight: function () {
                return null == c && t(), c
            }
        }))
    }(), it.swap = function (e, t, n, r) {
        var i, o, a = {};
        for (o in t)a[o] = e.style[o], e.style[o] = t[o];
        i = n.apply(e, r || []);
        for (o in t)e.style[o] = a[o];
        return i
    };
    var an = /alpha\([^)]*\)/i, sn = /opacity\s*=\s*([^)]*)/, cn = /^(none|table(?!-c[ea]).+)/, ln = new RegExp("^(" + kt + ")(.*)$", "i"), un = new RegExp("^([+-])=(" + kt + ")", "i"), dn = {
        position: "absolute",
        visibility: "hidden",
        display: "block"
    }, pn = {letterSpacing: "0", fontWeight: "400"}, fn = ["Webkit", "O", "Moz", "ms"];
    it.extend({
        cssHooks: {
            opacity: {
                get: function (e, t) {
                    if (t) {
                        var n = tn(e, "opacity");
                        return "" === n ? "1" : n
                    }
                }
            }
        },
        cssNumber: {
            columnCount: !0,
            fillOpacity: !0,
            flexGrow: !0,
            flexShrink: !0,
            fontWeight: !0,
            lineHeight: !0,
            opacity: !0,
            order: !0,
            orphans: !0,
            widows: !0,
            zIndex: !0,
            zoom: !0
        },
        cssProps: {"float": nt.cssFloat ? "cssFloat" : "styleFloat"},
        style: function (e, t, n, r) {
            if (e && 3 !== e.nodeType && 8 !== e.nodeType && e.style) {
                var i, o, a, s = it.camelCase(t), c = e.style;
                if (t = it.cssProps[s] || (it.cssProps[s] = T(c, s)), a = it.cssHooks[t] || it.cssHooks[s], void 0 === n)return a && "get"in a && void 0 !== (i = a.get(e, !1, r)) ? i : c[t];
                if (o = typeof n, "string" === o && (i = un.exec(n)) && (n = (i[1] + 1) * i[2] + parseFloat(it.css(e, t)), o = "number"), null != n && n === n && ("number" !== o || it.cssNumber[s] || (n += "px"), nt.clearCloneStyle || "" !== n || 0 !== t.indexOf("background") || (c[t] = "inherit"), !(a && "set"in a && void 0 === (n = a.set(e, n, r)))))try {
                    c[t] = n
                } catch (l) {
                }
            }
        },
        css: function (e, t, n, r) {
            var i, o, a, s = it.camelCase(t);
            return t = it.cssProps[s] || (it.cssProps[s] = T(e.style, s)), a = it.cssHooks[t] || it.cssHooks[s], a && "get"in a && (o = a.get(e, !0, n)), void 0 === o && (o = tn(e, t, r)), "normal" === o && t in pn && (o = pn[t]), "" === n || n ? (i = parseFloat(o), n === !0 || it.isNumeric(i) ? i || 0 : o) : o
        }
    }), it.each(["height", "width"], function (e, t) {
        it.cssHooks[t] = {
            get: function (e, n, r) {
                return n ? cn.test(it.css(e, "display")) && 0 === e.offsetWidth ? it.swap(e, dn, function () {
                    return D(e, t, r)
                }) : D(e, t, r) : void 0
            }, set: function (e, n, r) {
                var i = r && en(e);
                return A(e, n, r ? M(e, t, r, nt.boxSizing && "border-box" === it.css(e, "boxSizing", !1, i), i) : 0)
            }
        }
    }), nt.opacity || (it.cssHooks.opacity = {
        get: function (e, t) {
            return sn.test((t && e.currentStyle ? e.currentStyle.filter : e.style.filter) || "") ? .01 * parseFloat(RegExp.$1) + "" : t ? "1" : ""
        }, set: function (e, t) {
            var n = e.style, r = e.currentStyle, i = it.isNumeric(t) ? "alpha(opacity=" + 100 * t + ")" : "", o = r && r.filter || n.filter || "";
            n.zoom = 1, (t >= 1 || "" === t) && "" === it.trim(o.replace(an, "")) && n.removeAttribute && (n.removeAttribute("filter"), "" === t || r && !r.filter) || (n.filter = an.test(o) ? o.replace(an, i) : o + " " + i)
        }
    }), it.cssHooks.marginRight = k(nt.reliableMarginRight, function (e, t) {
        return t ? it.swap(e, {display: "inline-block"}, tn, [e, "marginRight"]) : void 0
    }), it.each({margin: "", padding: "", border: "Width"}, function (e, t) {
        it.cssHooks[e + t] = {
            expand: function (n) {
                for (var r = 0, i = {}, o = "string" == typeof n ? n.split(" ") : [n]; 4 > r; r++)i[e + Tt[r] + t] = o[r] || o[r - 2] || o[0];
                return i
            }
        }, nn.test(e) || (it.cssHooks[e + t].set = A)
    }), it.fn.extend({
        css: function (e, t) {
            return At(this, function (e, t, n) {
                var r, i, o = {}, a = 0;
                if (it.isArray(t)) {
                    for (r = en(e), i = t.length; i > a; a++)o[t[a]] = it.css(e, t[a], !1, r);
                    return o
                }
                return void 0 !== n ? it.style(e, t, n) : it.css(e, t)
            }, e, t, arguments.length > 1)
        }, show: function () {
            return E(this, !0)
        }, hide: function () {
            return E(this)
        }, toggle: function (e) {
            return "boolean" == typeof e ? e ? this.show() : this.hide() : this.each(function () {
                Et(this) ? it(this).show() : it(this).hide()
            })
        }
    }), it.Tween = q, q.prototype = {
        constructor: q, init: function (e, t, n, r, i, o) {
            this.elem = e, this.prop = n, this.easing = i || "swing", this.options = t, this.start = this.now = this.cur(), this.end = r, this.unit = o || (it.cssNumber[n] ? "" : "px")
        }, cur: function () {
            var e = q.propHooks[this.prop];
            return e && e.get ? e.get(this) : q.propHooks._default.get(this)
        }, run: function (e) {
            var t, n = q.propHooks[this.prop];
            return this.pos = t = this.options.duration ? it.easing[this.easing](e, this.options.duration * e, 0, 1, this.options.duration) : e, this.now = (this.end - this.start) * t + this.start, this.options.step && this.options.step.call(this.elem, this.now, this), n && n.set ? n.set(this) : q.propHooks._default.set(this), this
        }
    }, q.prototype.init.prototype = q.prototype, q.propHooks = {
        _default: {
            get: function (e) {
                var t;
                return null == e.elem[e.prop] || e.elem.style && null != e.elem.style[e.prop] ? (t = it.css(e.elem, e.prop, ""), t && "auto" !== t ? t : 0) : e.elem[e.prop]
            }, set: function (e) {
                it.fx.step[e.prop] ? it.fx.step[e.prop](e) : e.elem.style && (null != e.elem.style[it.cssProps[e.prop]] || it.cssHooks[e.prop]) ? it.style(e.elem, e.prop, e.now + e.unit) : e.elem[e.prop] = e.now
            }
        }
    }, q.propHooks.scrollTop = q.propHooks.scrollLeft = {
        set: function (e) {
            e.elem.nodeType && e.elem.parentNode && (e.elem[e.prop] = e.now)
        }
    }, it.easing = {
        linear: function (e) {
            return e
        }, swing: function (e) {
            return .5 - Math.cos(e * Math.PI) / 2
        }
    }, it.fx = q.prototype.init, it.fx.step = {};
    var hn, mn, gn = /^(?:toggle|show|hide)$/, vn = new RegExp("^(?:([+-])=|)(" + kt + ")([a-z%]*)$", "i"), _n = /queueHooks$/, yn = [N], bn = {
        "*": [function (e, t) {
            var n = this.createTween(e, t), r = n.cur(), i = vn.exec(t), o = i && i[3] || (it.cssNumber[e] ? "" : "px"), a = (it.cssNumber[e] || "px" !== o && +r) && vn.exec(it.css(n.elem, e)), s = 1, c = 20;
            if (a && a[3] !== o) {
                o = o || a[3], i = i || [], a = +r || 1;
                do s = s || ".5", a /= s, it.style(n.elem, e, a + o); while (s !== (s = n.cur() / r) && 1 !== s && --c)
            }
            return i && (a = n.start = +a || +r || 0, n.unit = o, n.end = i[1] ? a + (i[1] + 1) * i[2] : +i[2]), n
        }]
    };
    it.Animation = it.extend(R, {
        tweener: function (e, t) {
            it.isFunction(e) ? (t = e, e = ["*"]) : e = e.split(" ");
            for (var n, r = 0, i = e.length; i > r; r++)n = e[r], bn[n] = bn[n] || [], bn[n].unshift(t)
        }, prefilter: function (e, t) {
            t ? yn.unshift(e) : yn.push(e)
        }
    }), it.speed = function (e, t, n) {
        var r = e && "object" == typeof e ? it.extend({}, e) : {
            complete: n || !n && t || it.isFunction(e) && e,
            duration: e,
            easing: n && t || t && !it.isFunction(t) && t
        };
        return r.duration = it.fx.off ? 0 : "number" == typeof r.duration ? r.duration : r.duration in it.fx.speeds ? it.fx.speeds[r.duration] : it.fx.speeds._default, (null == r.queue || r.queue === !0) && (r.queue = "fx"), r.old = r.complete, r.complete = function () {
            it.isFunction(r.old) && r.old.call(this), r.queue && it.dequeue(this, r.queue)
        }, r
    }, it.fn.extend({
        fadeTo: function (e, t, n, r) {
            return this.filter(Et).css("opacity", 0).show().end().animate({opacity: t}, e, n, r)
        }, animate: function (e, t, n, r) {
            var i = it.isEmptyObject(e), o = it.speed(t, n, r), a = function () {
                var t = R(this, it.extend({}, e), o);
                (i || it._data(this, "finish")) && t.stop(!0)
            };
            return a.finish = a, i || o.queue === !1 ? this.each(a) : this.queue(o.queue, a)
        }, stop: function (e, t, n) {
            var r = function (e) {
                var t = e.stop;
                delete e.stop, t(n)
            };
            return "string" != typeof e && (n = t, t = e, e = void 0), t && e !== !1 && this.queue(e || "fx", []), this.each(function () {
                var t = !0, i = null != e && e + "queueHooks", o = it.timers, a = it._data(this);
                if (i)a[i] && a[i].stop && r(a[i]); else for (i in a)a[i] && a[i].stop && _n.test(i) && r(a[i]);
                for (i = o.length; i--;)o[i].elem !== this || null != e && o[i].queue !== e || (o[i].anim.stop(n), t = !1, o.splice(i, 1));
                (t || !n) && it.dequeue(this, e)
            })
        }, finish: function (e) {
            return e !== !1 && (e = e || "fx"), this.each(function () {
                var t, n = it._data(this), r = n[e + "queue"], i = n[e + "queueHooks"], o = it.timers, a = r ? r.length : 0;
                for (n.finish = !0, it.queue(this, e, []), i && i.stop && i.stop.call(this, !0), t = o.length; t--;)o[t].elem === this && o[t].queue === e && (o[t].anim.stop(!0), o.splice(t, 1));
                for (t = 0; a > t; t++)r[t] && r[t].finish && r[t].finish.call(this);
                delete n.finish
            })
        }
    }), it.each(["toggle", "show", "hide"], function (e, t) {
        var n = it.fn[t];
        it.fn[t] = function (e, r, i) {
            return null == e || "boolean" == typeof e ? n.apply(this, arguments) : this.animate(O(t, !0), e, r, i)
        }
    }), it.each({
        slideDown: O("show"),
        slideUp: O("hide"),
        slideToggle: O("toggle"),
        fadeIn: {opacity: "show"},
        fadeOut: {opacity: "hide"},
        fadeToggle: {opacity: "toggle"}
    }, function (e, t) {
        it.fn[e] = function (e, n, r) {
            return this.animate(t, e, n, r)
        }
    }), it.timers = [], it.fx.tick = function () {
        var e, t = it.timers, n = 0;
        for (hn = it.now(); n < t.length; n++)e = t[n], e() || t[n] !== e || t.splice(n--, 1);
        t.length || it.fx.stop(), hn = void 0
    }, it.fx.timer = function (e) {
        it.timers.push(e), e() ? it.fx.start() : it.timers.pop()
    }, it.fx.interval = 13, it.fx.start = function () {
        mn || (mn = setInterval(it.fx.tick, it.fx.interval))
    }, it.fx.stop = function () {
        clearInterval(mn), mn = null
    }, it.fx.speeds = {slow: 600, fast: 200, _default: 400}, it.fn.delay = function (e, t) {
        return e = it.fx ? it.fx.speeds[e] || e : e, t = t || "fx", this.queue(t, function (t, n) {
            var r = setTimeout(t, e);
            n.stop = function () {
                clearTimeout(r)
            }
        })
    }, function () {
        var e, t, n, r, i;
        t = ht.createElement("div"), t.setAttribute("className", "t"), t.innerHTML = "  <link/><table></table><a href='/a'>a</a><input type='checkbox'/>", r = t.getElementsByTagName("a")[0], n = ht.createElement("select"), i = n.appendChild(ht.createElement("option")), e = t.getElementsByTagName("input")[0], r.style.cssText = "top:1px", nt.getSetAttribute = "t" !== t.className, nt.style = /top/.test(r.getAttribute("style")), nt.hrefNormalized = "/a" === r.getAttribute("href"), nt.checkOn = !!e.value, nt.optSelected = i.selected, nt.enctype = !!ht.createElement("form").enctype, n.disabled = !0, nt.optDisabled = !i.disabled, e = ht.createElement("input"), e.setAttribute("value", ""), nt.input = "" === e.getAttribute("value"), e.value = "t", e.setAttribute("type", "radio"), nt.radioValue = "t" === e.value
    }();
    var $n = /\r/g;
    it.fn.extend({
        val: function (e) {
            var t, n, r, i = this[0];
            {
                if (arguments.length)return r = it.isFunction(e), this.each(function (n) {
                    var i;
                    1 === this.nodeType && (i = r ? e.call(this, n, it(this).val()) : e, null == i ? i = "" : "number" == typeof i ? i += "" : it.isArray(i) && (i = it.map(i, function (e) {
                        return null == e ? "" : e + ""
                    })), t = it.valHooks[this.type] || it.valHooks[this.nodeName.toLowerCase()], t && "set"in t && void 0 !== t.set(this, i, "value") || (this.value = i))
                });
                if (i)return t = it.valHooks[i.type] || it.valHooks[i.nodeName.toLowerCase()], t && "get"in t && void 0 !== (n = t.get(i, "value")) ? n : (n = i.value, "string" == typeof n ? n.replace($n, "") : null == n ? "" : n)
            }
        }
    }), it.extend({
        valHooks: {
            option: {
                get: function (e) {
                    var t = it.find.attr(e, "value");
                    return null != t ? t : it.trim(it.text(e))
                }
            }, select: {
                get: function (e) {
                    for (var t, n, r = e.options, i = e.selectedIndex, o = "select-one" === e.type || 0 > i, a = o ? null : [], s = o ? i + 1 : r.length, c = 0 > i ? s : o ? i : 0; s > c; c++)if (n = r[c], !(!n.selected && c !== i || (nt.optDisabled ? n.disabled : null !== n.getAttribute("disabled")) || n.parentNode.disabled && it.nodeName(n.parentNode, "optgroup"))) {
                        if (t = it(n).val(), o)return t;
                        a.push(t)
                    }
                    return a
                }, set: function (e, t) {
                    for (var n, r, i = e.options, o = it.makeArray(t), a = i.length; a--;)if (r = i[a], it.inArray(it.valHooks.option.get(r), o) >= 0)try {
                        r.selected = n = !0
                    } catch (s) {
                        r.scrollHeight
                    } else r.selected = !1;
                    return n || (e.selectedIndex = -1), i
                }
            }
        }
    }), it.each(["radio", "checkbox"], function () {
        it.valHooks[this] = {
            set: function (e, t) {
                return it.isArray(t) ? e.checked = it.inArray(it(e).val(), t) >= 0 : void 0
            }
        }, nt.checkOn || (it.valHooks[this].get = function (e) {
            return null === e.getAttribute("value") ? "on" : e.value
        })
    });
    var wn, xn, Sn = it.expr.attrHandle, Cn = /^(?:checked|selected)$/i, kn = nt.getSetAttribute, Tn = nt.input;
    it.fn.extend({
        attr: function (e, t) {
            return At(this, it.attr, e, t, arguments.length > 1)
        }, removeAttr: function (e) {
            return this.each(function () {
                it.removeAttr(this, e)
            })
        }
    }), it.extend({
        attr: function (e, t, n) {
            var r, i, o = e.nodeType;
            if (e && 3 !== o && 8 !== o && 2 !== o)return typeof e.getAttribute === xt ? it.prop(e, t, n) : (1 === o && it.isXMLDoc(e) || (t = t.toLowerCase(), r = it.attrHooks[t] || (it.expr.match.bool.test(t) ? xn : wn)), void 0 === n ? r && "get"in r && null !== (i = r.get(e, t)) ? i : (i = it.find.attr(e, t), null == i ? void 0 : i) : null !== n ? r && "set"in r && void 0 !== (i = r.set(e, n, t)) ? i : (e.setAttribute(t, n + ""), n) : void it.removeAttr(e, t))
        }, removeAttr: function (e, t) {
            var n, r, i = 0, o = t && t.match(yt);
            if (o && 1 === e.nodeType)for (; n = o[i++];)r = it.propFix[n] || n, it.expr.match.bool.test(n) ? Tn && kn || !Cn.test(n) ? e[r] = !1 : e[it.camelCase("default-" + n)] = e[r] = !1 : it.attr(e, n, ""), e.removeAttribute(kn ? n : r)
        }, attrHooks: {
            type: {
                set: function (e, t) {
                    if (!nt.radioValue && "radio" === t && it.nodeName(e, "input")) {
                        var n = e.value;
                        return e.setAttribute("type", t), n && (e.value = n), t
                    }
                }
            }
        }
    }), xn = {
        set: function (e, t, n) {
            return t === !1 ? it.removeAttr(e, n) : Tn && kn || !Cn.test(n) ? e.setAttribute(!kn && it.propFix[n] || n, n) : e[it.camelCase("default-" + n)] = e[n] = !0, n
        }
    }, it.each(it.expr.match.bool.source.match(/\w+/g), function (e, t) {
        var n = Sn[t] || it.find.attr;
        Sn[t] = Tn && kn || !Cn.test(t) ? function (e, t, r) {
            var i, o;
            return r || (o = Sn[t], Sn[t] = i, i = null != n(e, t, r) ? t.toLowerCase() : null, Sn[t] = o), i
        } : function (e, t, n) {
            return n ? void 0 : e[it.camelCase("default-" + t)] ? t.toLowerCase() : null
        }
    }), Tn && kn || (it.attrHooks.value = {
        set: function (e, t, n) {
            return it.nodeName(e, "input") ? void(e.defaultValue = t) : wn && wn.set(e, t, n)
        }
    }), kn || (wn = {
        set: function (e, t, n) {
            var r = e.getAttributeNode(n);
            return r || e.setAttributeNode(r = e.ownerDocument.createAttribute(n)), r.value = t += "", "value" === n || t === e.getAttribute(n) ? t : void 0
        }
    }, Sn.id = Sn.name = Sn.coords = function (e, t, n) {
        var r;
        return n ? void 0 : (r = e.getAttributeNode(t)) && "" !== r.value ? r.value : null
    }, it.valHooks.button = {
        get: function (e, t) {
            var n = e.getAttributeNode(t);
            return n && n.specified ? n.value : void 0
        }, set: wn.set
    }, it.attrHooks.contenteditable = {
        set: function (e, t, n) {
            wn.set(e, "" === t ? !1 : t, n)
        }
    }, it.each(["width", "height"], function (e, t) {
        it.attrHooks[t] = {
            set: function (e, n) {
                return "" === n ? (e.setAttribute(t, "auto"), n) : void 0
            }
        }
    })), nt.style || (it.attrHooks.style = {
        get: function (e) {
            return e.style.cssText || void 0
        }, set: function (e, t) {
            return e.style.cssText = t + ""
        }
    });
    var En = /^(?:input|select|textarea|button|object)$/i, An = /^(?:a|area)$/i;
    it.fn.extend({
        prop: function (e, t) {
            return At(this, it.prop, e, t, arguments.length > 1)
        }, removeProp: function (e) {
            return e = it.propFix[e] || e, this.each(function () {
                try {
                    this[e] = void 0, delete this[e]
                } catch (t) {
                }
            })
        }
    }), it.extend({
        propFix: {"for": "htmlFor", "class": "className"}, prop: function (e, t, n) {
            var r, i, o, a = e.nodeType;
            if (e && 3 !== a && 8 !== a && 2 !== a)return o = 1 !== a || !it.isXMLDoc(e), o && (t = it.propFix[t] || t, i = it.propHooks[t]), void 0 !== n ? i && "set"in i && void 0 !== (r = i.set(e, n, t)) ? r : e[t] = n : i && "get"in i && null !== (r = i.get(e, t)) ? r : e[t]
        }, propHooks: {
            tabIndex: {
                get: function (e) {
                    var t = it.find.attr(e, "tabindex");
                    return t ? parseInt(t, 10) : En.test(e.nodeName) || An.test(e.nodeName) && e.href ? 0 : -1
                }
            }
        }
    }), nt.hrefNormalized || it.each(["href", "src"], function (e, t) {
        it.propHooks[t] = {
            get: function (e) {
                return e.getAttribute(t, 4)
            }
        }
    }), nt.optSelected || (it.propHooks.selected = {
        get: function (e) {
            var t = e.parentNode;
            return t && (t.selectedIndex, t.parentNode && t.parentNode.selectedIndex), null
        }
    }), it.each(["tabIndex", "readOnly", "maxLength", "cellSpacing", "cellPadding", "rowSpan", "colSpan", "useMap", "frameBorder", "contentEditable"], function () {
        it.propFix[this.toLowerCase()] = this
    }), nt.enctype || (it.propFix.enctype = "encoding");
    var Mn = /[\t\r\n\f]/g;
    it.fn.extend({
        addClass: function (e) {
            var t, n, r, i, o, a, s = 0, c = this.length, l = "string" == typeof e && e;
            if (it.isFunction(e))return this.each(function (t) {
                it(this).addClass(e.call(this, t, this.className))
            });
            if (l)for (t = (e || "").match(yt) || []; c > s; s++)if (n = this[s], r = 1 === n.nodeType && (n.className ? (" " + n.className + " ").replace(Mn, " ") : " ")) {
                for (o = 0; i = t[o++];)r.indexOf(" " + i + " ") < 0 && (r += i + " ");
                a = it.trim(r), n.className !== a && (n.className = a)
            }
            return this
        }, removeClass: function (e) {
            var t, n, r, i, o, a, s = 0, c = this.length, l = 0 === arguments.length || "string" == typeof e && e;
            if (it.isFunction(e))return this.each(function (t) {
                it(this).removeClass(e.call(this, t, this.className))
            });
            if (l)for (t = (e || "").match(yt) || []; c > s; s++)if (n = this[s], r = 1 === n.nodeType && (n.className ? (" " + n.className + " ").replace(Mn, " ") : "")) {
                for (o = 0; i = t[o++];)for (; r.indexOf(" " + i + " ") >= 0;)r = r.replace(" " + i + " ", " ");
                a = e ? it.trim(r) : "", n.className !== a && (n.className = a)
            }
            return this
        }, toggleClass: function (e, t) {
            var n = typeof e;
            return "boolean" == typeof t && "string" === n ? t ? this.addClass(e) : this.removeClass(e) : this.each(it.isFunction(e) ? function (n) {
                it(this).toggleClass(e.call(this, n, this.className, t), t)
            } : function () {
                if ("string" === n)for (var t, r = 0, i = it(this), o = e.match(yt) || []; t = o[r++];)i.hasClass(t) ? i.removeClass(t) : i.addClass(t); else(n === xt || "boolean" === n) && (this.className && it._data(this, "__className__", this.className), this.className = this.className || e === !1 ? "" : it._data(this, "__className__") || "")
            })
        }, hasClass: function (e) {
            for (var t = " " + e + " ", n = 0, r = this.length; r > n; n++)if (1 === this[n].nodeType && (" " + this[n].className + " ").replace(Mn, " ").indexOf(t) >= 0)return !0;
            return !1
        }
    }), it.each("blur focus focusin focusout load resize scroll unload click dblclick mousedown mouseup mousemove mouseover mouseout mouseenter mouseleave change select submit keydown keypress keyup error contextmenu".split(" "), function (e, t) {
        it.fn[t] = function (e, n) {
            return arguments.length > 0 ? this.on(t, null, e, n) : this.trigger(t)
        }
    }), it.fn.extend({
        hover: function (e, t) {
            return this.mouseenter(e).mouseleave(t || e)
        }, bind: function (e, t, n) {
            return this.on(e, null, t, n)
        }, unbind: function (e, t) {
            return this.off(e, null, t)
        }, delegate: function (e, t, n, r) {
            return this.on(t, e, n, r)
        }, undelegate: function (e, t, n) {
            return 1 === arguments.length ? this.off(e, "**") : this.off(t, e || "**", n)
        }
    });
    var Dn = it.now(), qn = /\?/, Ln = /(,)|(\[|{)|(}|])|"(?:[^"\\\r\n]|\\["\\\/bfnrt]|\\u[\da-fA-F]{4})*"\s*:?|true|false|null|-?(?!0\d)\d+(?:\.\d+|)(?:[eE][+-]?\d+|)/g;
    it.parseJSON = function (t) {
        if (e.JSON && e.JSON.parse)return e.JSON.parse(t + "");
        var n, r = null, i = it.trim(t + "");
        return i && !it.trim(i.replace(Ln, function (e, t, i, o) {
            return n && t && (r = 0), 0 === r ? e : (n = i || t, r += !o - !i, "")
        })) ? Function("return " + i)() : it.error("Invalid JSON: " + t)
    }, it.parseXML = function (t) {
        var n, r;
        if (!t || "string" != typeof t)return null;
        try {
            e.DOMParser ? (r = new DOMParser, n = r.parseFromString(t, "text/xml")) : (n = new ActiveXObject("Microsoft.XMLDOM"), n.async = "false", n.loadXML(t))
        } catch (i) {
            n = void 0
        }
        return n && n.documentElement && !n.getElementsByTagName("parsererror").length || it.error("Invalid XML: " + t), n
    };
    var On, Pn, Nn = /#.*$/, jn = /([?&])_=[^&]*/, Rn = /^(.*?):[ \t]*([^\r\n]*)\r?$/gm, In = /^(?:about|app|app-storage|.+-extension|file|res|widget):$/, Un = /^(?:GET|HEAD)$/, Bn = /^\/\//, Fn = /^([\w.+-]+:)(?:\/\/(?:[^\/?#]*@|)([^\/?#:]*)(?::(\d+)|)|)/, Hn = {}, zn = {}, Vn = "*/".concat("*");
    try {
        Pn = location.href
    } catch (Wn) {
        Pn = ht.createElement("a"), Pn.href = "", Pn = Pn.href
    }
    On = Fn.exec(Pn.toLowerCase()) || [], it.extend({
        active: 0,
        lastModified: {},
        etag: {},
        ajaxSettings: {
            url: Pn,
            type: "GET",
            isLocal: In.test(On[1]),
            global: !0,
            processData: !0,
            async: !0,
            contentType: "application/x-www-form-urlencoded; charset=UTF-8",
            accepts: {
                "*": Vn,
                text: "text/plain",
                html: "text/html",
                xml: "application/xml, text/xml",
                json: "application/json, text/javascript"
            },
            contents: {xml: /xml/, html: /html/, json: /json/},
            responseFields: {xml: "responseXML", text: "responseText", json: "responseJSON"},
            converters: {"* text": String, "text html": !0, "text json": it.parseJSON, "text xml": it.parseXML},
            flatOptions: {url: !0, context: !0}
        },
        ajaxSetup: function (e, t) {
            return t ? B(B(e, it.ajaxSettings), t) : B(it.ajaxSettings, e)
        },
        ajaxPrefilter: I(Hn),
        ajaxTransport: I(zn),
        ajax: function (e, t) {
            function n(e, t, n, r) {
                var i, u, v, _, b, w = t;
                2 !== y && (y = 2, s && clearTimeout(s), l = void 0, a = r || "", $.readyState = e > 0 ? 4 : 0, i = e >= 200 && 300 > e || 304 === e, n && (_ = F(d, $, n)), _ = H(d, _, $, i), i ? (d.ifModified && (b = $.getResponseHeader("Last-Modified"), b && (it.lastModified[o] = b), b = $.getResponseHeader("etag"), b && (it.etag[o] = b)), 204 === e || "HEAD" === d.type ? w = "nocontent" : 304 === e ? w = "notmodified" : (w = _.state, u = _.data, v = _.error, i = !v)) : (v = w, (e || !w) && (w = "error", 0 > e && (e = 0))), $.status = e, $.statusText = (t || w) + "", i ? h.resolveWith(p, [u, w, $]) : h.rejectWith(p, [$, w, v]), $.statusCode(g), g = void 0, c && f.trigger(i ? "ajaxSuccess" : "ajaxError", [$, d, i ? u : v]), m.fireWith(p, [$, w]), c && (f.trigger("ajaxComplete", [$, d]), --it.active || it.event.trigger("ajaxStop")))
            }

            "object" == typeof e && (t = e, e = void 0), t = t || {};
            var r, i, o, a, s, c, l, u, d = it.ajaxSetup({}, t), p = d.context || d, f = d.context && (p.nodeType || p.jquery) ? it(p) : it.event, h = it.Deferred(), m = it.Callbacks("once memory"), g = d.statusCode || {}, v = {}, _ = {}, y = 0, b = "canceled", $ = {
                readyState: 0,
                getResponseHeader: function (e) {
                    var t;
                    if (2 === y) {
                        if (!u)for (u = {}; t = Rn.exec(a);)u[t[1].toLowerCase()] = t[2];
                        t = u[e.toLowerCase()]
                    }
                    return null == t ? null : t
                },
                getAllResponseHeaders: function () {
                    return 2 === y ? a : null
                },
                setRequestHeader: function (e, t) {
                    var n = e.toLowerCase();
                    return y || (e = _[n] = _[n] || e, v[e] = t), this
                },
                overrideMimeType: function (e) {
                    return y || (d.mimeType = e), this
                },
                statusCode: function (e) {
                    var t;
                    if (e)if (2 > y)for (t in e)g[t] = [g[t], e[t]]; else $.always(e[$.status]);
                    return this
                },
                abort: function (e) {
                    var t = e || b;
                    return l && l.abort(t), n(0, t), this
                }
            };
            if (h.promise($).complete = m.add, $.success = $.done, $.error = $.fail, d.url = ((e || d.url || Pn) + "").replace(Nn, "").replace(Bn, On[1] + "//"), d.type = t.method || t.type || d.method || d.type, d.dataTypes = it.trim(d.dataType || "*").toLowerCase().match(yt) || [""], null == d.crossDomain && (r = Fn.exec(d.url.toLowerCase()), d.crossDomain = !(!r || r[1] === On[1] && r[2] === On[2] && (r[3] || ("http:" === r[1] ? "80" : "443")) === (On[3] || ("http:" === On[1] ? "80" : "443")))), d.data && d.processData && "string" != typeof d.data && (d.data = it.param(d.data, d.traditional)), U(Hn, d, t, $), 2 === y)return $;
            c = d.global, c && 0 === it.active++ && it.event.trigger("ajaxStart"), d.type = d.type.toUpperCase(), d.hasContent = !Un.test(d.type), o = d.url, d.hasContent || (d.data && (o = d.url += (qn.test(o) ? "&" : "?") + d.data, delete d.data), d.cache === !1 && (d.url = jn.test(o) ? o.replace(jn, "$1_=" + Dn++) : o + (qn.test(o) ? "&" : "?") + "_=" + Dn++)), d.ifModified && (it.lastModified[o] && $.setRequestHeader("If-Modified-Since", it.lastModified[o]), it.etag[o] && $.setRequestHeader("If-None-Match", it.etag[o])), (d.data && d.hasContent && d.contentType !== !1 || t.contentType) && $.setRequestHeader("Content-Type", d.contentType), $.setRequestHeader("Accept", d.dataTypes[0] && d.accepts[d.dataTypes[0]] ? d.accepts[d.dataTypes[0]] + ("*" !== d.dataTypes[0] ? ", " + Vn + "; q=0.01" : "") : d.accepts["*"]);
            for (i in d.headers)$.setRequestHeader(i, d.headers[i]);
            if (d.beforeSend && (d.beforeSend.call(p, $, d) === !1 || 2 === y))return $.abort();
            b = "abort";
            for (i in{success: 1, error: 1, complete: 1})$[i](d[i]);
            if (l = U(zn, d, t, $)) {
                $.readyState = 1, c && f.trigger("ajaxSend", [$, d]), d.async && d.timeout > 0 && (s = setTimeout(function () {
                    $.abort("timeout")
                }, d.timeout));
                try {
                    y = 1, l.send(v, n)
                } catch (w) {
                    if (!(2 > y))throw w;
                    n(-1, w)
                }
            } else n(-1, "No Transport");
            return $
        },
        getJSON: function (e, t, n) {
            return it.get(e, t, n, "json")
        },
        getScript: function (e, t) {
            return it.get(e, void 0, t, "script")
        }
    }), it.each(["get", "post"], function (e, t) {
        it[t] = function (e, n, r, i) {
            return it.isFunction(n) && (i = i || r, r = n, n = void 0), it.ajax({
                url: e,
                type: t,
                dataType: i,
                data: n,
                success: r
            })
        }
    }), it.each(["ajaxStart", "ajaxStop", "ajaxComplete", "ajaxError", "ajaxSuccess", "ajaxSend"], function (e, t) {
        it.fn[t] = function (e) {
            return this.on(t, e)
        }
    }), it._evalUrl = function (e) {
        return it.ajax({url: e, type: "GET", dataType: "script", async: !1, global: !1, "throws": !0})
    }, it.fn.extend({
        wrapAll: function (e) {
            if (it.isFunction(e))return this.each(function (t) {
                it(this).wrapAll(e.call(this, t))
            });
            if (this[0]) {
                var t = it(e, this[0].ownerDocument).eq(0).clone(!0);
                this[0].parentNode && t.insertBefore(this[0]), t.map(function () {
                    for (var e = this; e.firstChild && 1 === e.firstChild.nodeType;)e = e.firstChild;
                    return e
                }).append(this)
            }
            return this
        }, wrapInner: function (e) {
            return this.each(it.isFunction(e) ? function (t) {
                it(this).wrapInner(e.call(this, t))
            } : function () {
                var t = it(this), n = t.contents();
                n.length ? n.wrapAll(e) : t.append(e)
            })
        }, wrap: function (e) {
            var t = it.isFunction(e);
            return this.each(function (n) {
                it(this).wrapAll(t ? e.call(this, n) : e)
            })
        }, unwrap: function () {
            return this.parent().each(function () {
                it.nodeName(this, "body") || it(this).replaceWith(this.childNodes)
            }).end()
        }
    }), it.expr.filters.hidden = function (e) {
        return e.offsetWidth <= 0 && e.offsetHeight <= 0 || !nt.reliableHiddenOffsets() && "none" === (e.style && e.style.display || it.css(e, "display"))
    }, it.expr.filters.visible = function (e) {
        return !it.expr.filters.hidden(e)
    };
    var Gn = /%20/g, Xn = /\[\]$/, Yn = /\r?\n/g, Qn = /^(?:submit|button|image|reset|file)$/i, Kn = /^(?:input|select|textarea|keygen)/i;
    it.param = function (e, t) {
        var n, r = [], i = function (e, t) {
            t = it.isFunction(t) ? t() : null == t ? "" : t, r[r.length] = encodeURIComponent(e) + "=" + encodeURIComponent(t)
        };
        if (void 0 === t && (t = it.ajaxSettings && it.ajaxSettings.traditional), it.isArray(e) || e.jquery && !it.isPlainObject(e))it.each(e, function () {
            i(this.name, this.value)
        }); else for (n in e)z(n, e[n], t, i);
        return r.join("&").replace(Gn, "+")
    }, it.fn.extend({
        serialize: function () {
            return it.param(this.serializeArray())
        }, serializeArray: function () {
            return this.map(function () {
                var e = it.prop(this, "elements");
                return e ? it.makeArray(e) : this
            }).filter(function () {
                var e = this.type;
                return this.name && !it(this).is(":disabled") && Kn.test(this.nodeName) && !Qn.test(e) && (this.checked || !Mt.test(e))
            }).map(function (e, t) {
                var n = it(this).val();
                return null == n ? null : it.isArray(n) ? it.map(n, function (e) {
                    return {name: t.name, value: e.replace(Yn, "\r\n")}
                }) : {name: t.name, value: n.replace(Yn, "\r\n")}
            }).get()
        }
    }), it.ajaxSettings.xhr = void 0 !== e.ActiveXObject ? function () {
        return !this.isLocal && /^(get|post|head|put|delete|options)$/i.test(this.type) && V() || W()
    } : V;
    var Jn = 0, Zn = {}, er = it.ajaxSettings.xhr();
    e.ActiveXObject && it(e).on("unload", function () {
        for (var e in Zn)Zn[e](void 0, !0)
    }), nt.cors = !!er && "withCredentials"in er, er = nt.ajax = !!er, er && it.ajaxTransport(function (e) {
        if (!e.crossDomain || nt.cors) {
            var t;
            return {
                send: function (n, r) {
                    var i, o = e.xhr(), a = ++Jn;
                    if (o.open(e.type, e.url, e.async, e.username, e.password), e.xhrFields)for (i in e.xhrFields)o[i] = e.xhrFields[i];
                    e.mimeType && o.overrideMimeType && o.overrideMimeType(e.mimeType), e.crossDomain || n["X-Requested-With"] || (n["X-Requested-With"] = "XMLHttpRequest");
                    for (i in n)void 0 !== n[i] && o.setRequestHeader(i, n[i] + "");
                    o.send(e.hasContent && e.data || null), t = function (n, i) {
                        var s, c, l;
                        if (t && (i || 4 === o.readyState))if (delete Zn[a], t = void 0, o.onreadystatechange = it.noop, i)4 !== o.readyState && o.abort(); else {
                            l = {}, s = o.status, "string" == typeof o.responseText && (l.text = o.responseText);
                            try {
                                c = o.statusText
                            } catch (u) {
                                c = ""
                            }
                            s || !e.isLocal || e.crossDomain ? 1223 === s && (s = 204) : s = l.text ? 200 : 404
                        }
                        l && r(s, c, l, o.getAllResponseHeaders())
                    }, e.async ? 4 === o.readyState ? setTimeout(t) : o.onreadystatechange = Zn[a] = t : t()
                }, abort: function () {
                    t && t(void 0, !0)
                }
            }
        }
    }), it.ajaxSetup({
        accepts: {script: "text/javascript, application/javascript, application/ecmascript, application/x-ecmascript"},
        contents: {script: /(?:java|ecma)script/},
        converters: {
            "text script": function (e) {
                return it.globalEval(e), e
            }
        }
    }), it.ajaxPrefilter("script", function (e) {
        void 0 === e.cache && (e.cache = !1), e.crossDomain && (e.type = "GET", e.global = !1)
    }), it.ajaxTransport("script", function (e) {
        if (e.crossDomain) {
            var t, n = ht.head || it("head")[0] || ht.documentElement;
            return {
                send: function (r, i) {
                    t = ht.createElement("script"), t.async = !0, e.scriptCharset && (t.charset = e.scriptCharset), t.src = e.url, t.onload = t.onreadystatechange = function (e, n) {
                        (n || !t.readyState || /loaded|complete/.test(t.readyState)) && (t.onload = t.onreadystatechange = null, t.parentNode && t.parentNode.removeChild(t), t = null, n || i(200, "success"))
                    }, n.insertBefore(t, n.firstChild)
                }, abort: function () {
                    t && t.onload(void 0, !0)
                }
            }
        }
    });
    var tr = [], nr = /(=)\?(?=&|$)|\?\?/;
    it.ajaxSetup({
        jsonp: "callback", jsonpCallback: function () {
            var e = tr.pop() || it.expando + "_" + Dn++;
            return this[e] = !0, e
        }
    }), it.ajaxPrefilter("json jsonp", function (t, n, r) {
        var i, o, a, s = t.jsonp !== !1 && (nr.test(t.url) ? "url" : "string" == typeof t.data && !(t.contentType || "").indexOf("application/x-www-form-urlencoded") && nr.test(t.data) && "data");
        return s || "jsonp" === t.dataTypes[0] ? (i = t.jsonpCallback = it.isFunction(t.jsonpCallback) ? t.jsonpCallback() : t.jsonpCallback, s ? t[s] = t[s].replace(nr, "$1" + i) : t.jsonp !== !1 && (t.url += (qn.test(t.url) ? "&" : "?") + t.jsonp + "=" + i), t.converters["script json"] = function () {
            return a || it.error(i + " was not called"), a[0]
        }, t.dataTypes[0] = "json", o = e[i], e[i] = function () {
            a = arguments
        }, r.always(function () {
            e[i] = o, t[i] && (t.jsonpCallback = n.jsonpCallback, tr.push(i)), a && it.isFunction(o) && o(a[0]), a = o = void 0
        }), "script") : void 0
    }), it.parseHTML = function (e, t, n) {
        if (!e || "string" != typeof e)return null;
        "boolean" == typeof t && (n = t, t = !1), t = t || ht;
        var r = dt.exec(e), i = !n && [];
        return r ? [t.createElement(r[1])] : (r = it.buildFragment([e], t, i), i && i.length && it(i).remove(), it.merge([], r.childNodes))
    };
    var rr = it.fn.load;
    it.fn.load = function (e, t, n) {
        if ("string" != typeof e && rr)return rr.apply(this, arguments);
        var r, i, o, a = this, s = e.indexOf(" ");
        return s >= 0 && (r = it.trim(e.slice(s, e.length)), e = e.slice(0, s)), it.isFunction(t) ? (n = t, t = void 0) : t && "object" == typeof t && (o = "POST"), a.length > 0 && it.ajax({
            url: e,
            type: o,
            dataType: "html",
            data: t
        }).done(function (e) {
            i = arguments, a.html(r ? it("<div>").append(it.parseHTML(e)).find(r) : e)
        }).complete(n && function (e, t) {
            a.each(n, i || [e.responseText, t, e])
        }), this
    }, it.expr.filters.animated = function (e) {
        return it.grep(it.timers, function (t) {
            return e === t.elem
        }).length
    };
    var ir = e.document.documentElement;
    it.offset = {
        setOffset: function (e, t, n) {
            var r, i, o, a, s, c, l, u = it.css(e, "position"), d = it(e), p = {};
            "static" === u && (e.style.position = "relative"), s = d.offset(), o = it.css(e, "top"), c = it.css(e, "left"), l = ("absolute" === u || "fixed" === u) && it.inArray("auto", [o, c]) > -1, l ? (r = d.position(), a = r.top, i = r.left) : (a = parseFloat(o) || 0, i = parseFloat(c) || 0), it.isFunction(t) && (t = t.call(e, n, s)), null != t.top && (p.top = t.top - s.top + a), null != t.left && (p.left = t.left - s.left + i), "using"in t ? t.using.call(e, p) : d.css(p)
        }
    }, it.fn.extend({
        offset: function (e) {
            if (arguments.length)return void 0 === e ? this : this.each(function (t) {
                it.offset.setOffset(this, e, t)
            });
            var t, n, r = {top: 0, left: 0}, i = this[0], o = i && i.ownerDocument;
            if (o)return t = o.documentElement, it.contains(t, i) ? (typeof i.getBoundingClientRect !== xt && (r = i.getBoundingClientRect()), n = G(o), {
                top: r.top + (n.pageYOffset || t.scrollTop) - (t.clientTop || 0),
                left: r.left + (n.pageXOffset || t.scrollLeft) - (t.clientLeft || 0)
            }) : r
        }, position: function () {
            if (this[0]) {
                var e, t, n = {top: 0, left: 0}, r = this[0];
                return "fixed" === it.css(r, "position") ? t = r.getBoundingClientRect() : (e = this.offsetParent(), t = this.offset(), it.nodeName(e[0], "html") || (n = e.offset()), n.top += it.css(e[0], "borderTopWidth", !0), n.left += it.css(e[0], "borderLeftWidth", !0)), {
                    top: t.top - n.top - it.css(r, "marginTop", !0),
                    left: t.left - n.left - it.css(r, "marginLeft", !0)
                }
            }
        }, offsetParent: function () {
            return this.map(function () {
                for (var e = this.offsetParent || ir; e && !it.nodeName(e, "html") && "static" === it.css(e, "position");)e = e.offsetParent;
                return e || ir
            })
        }
    }), it.each({scrollLeft: "pageXOffset", scrollTop: "pageYOffset"}, function (e, t) {
        var n = /Y/.test(t);
        it.fn[e] = function (r) {
            return At(this, function (e, r, i) {
                var o = G(e);
                return void 0 === i ? o ? t in o ? o[t] : o.document.documentElement[r] : e[r] : void(o ? o.scrollTo(n ? it(o).scrollLeft() : i, n ? i : it(o).scrollTop()) : e[r] = i)
            }, e, r, arguments.length, null)
        }
    }), it.each(["top", "left"], function (e, t) {
        it.cssHooks[t] = k(nt.pixelPosition, function (e, n) {
            return n ? (n = tn(e, t), rn.test(n) ? it(e).position()[t] + "px" : n) : void 0
        })
    }), it.each({Height: "height", Width: "width"}, function (e, t) {
        it.each({padding: "inner" + e, content: t, "": "outer" + e}, function (n, r) {
            it.fn[r] = function (r, i) {
                var o = arguments.length && (n || "boolean" != typeof r), a = n || (r === !0 || i === !0 ? "margin" : "border");
                return At(this, function (t, n, r) {
                    var i;
                    return it.isWindow(t) ? t.document.documentElement["client" + e] : 9 === t.nodeType ? (i = t.documentElement, Math.max(t.body["scroll" + e], i["scroll" + e], t.body["offset" + e], i["offset" + e], i["client" + e])) : void 0 === r ? it.css(t, n, a) : it.style(t, n, r, a)
                }, t, o ? r : void 0, o, null)
            }
        })
    }), it.fn.size = function () {
        return this.length
    }, it.fn.andSelf = it.fn.addBack, "function" == typeof define && define.amd && define("jquery", [], function () {
        return it
    });
    var or = e.jQuery, ar = e.$;
    return it.noConflict = function (t) {
        return e.$ === it && (e.$ = ar), t && e.jQuery === it && (e.jQuery = or), it
    }, typeof t === xt && (e.jQuery = e.$ = it), it
}), function (e, t, n) {
    "use strict";
    function r(e, t) {
        return t = t || Error, function () {
            var n, r, i = arguments[0], o = "[" + (e ? e + ":" : "") + i + "] ", a = arguments[1], s = arguments;
            for (n = o + a.replace(/\{\d+\}/g, function (e) {
                    var t = +e.slice(1, -1);
                    return t + 2 < s.length ? dt(s[t + 2]) : e
                }), n = n + "\nhttp://errors.angularjs.org/1.3.3/" + (e ? e + "/" : "") + i, r = 2; r < arguments.length; r++)n = n + (2 == r ? "?" : "&") + "p" + (r - 2) + "=" + encodeURIComponent(dt(arguments[r]));
            return new t(n)
        }
    }

    function i(e) {
        if (null == e || C(e))return !1;
        var t = e.length;
        return e.nodeType === di && t ? !0 : b(e) || ii(e) || 0 === t || "number" == typeof t && t > 0 && t - 1 in e
    }

    function o(e, t, n) {
        var r, a;
        if (e)if (x(e))for (r in e)"prototype" == r || "length" == r || "name" == r || e.hasOwnProperty && !e.hasOwnProperty(r) || t.call(n, e[r], r, e); else if (ii(e) || i(e)) {
            var s = "object" != typeof e;
            for (r = 0, a = e.length; a > r; r++)(s || r in e) && t.call(n, e[r], r, e)
        } else if (e.forEach && e.forEach !== o)e.forEach(t, n, e); else for (r in e)e.hasOwnProperty(r) && t.call(n, e[r], r, e);
        return e
    }

    function a(e) {
        return Object.keys(e).sort()
    }

    function s(e, t, n) {
        for (var r = a(e), i = 0; i < r.length; i++)t.call(n, e[r[i]], r[i]);
        return r
    }

    function c(e) {
        return function (t, n) {
            e(n, t)
        }
    }

    function l() {
        return ++ni
    }

    function u(e, t) {
        t ? e.$$hashKey = t : delete e.$$hashKey
    }

    function d(e) {
        for (var t = e.$$hashKey, n = 1, r = arguments.length; r > n; n++) {
            var i = arguments[n];
            if (i)for (var o = Object.keys(i), a = 0, s = o.length; s > a; a++) {
                var c = o[a];
                e[c] = i[c]
            }
        }
        return u(e, t), e
    }

    function p(e) {
        return parseInt(e, 10)
    }

    function f(e, t) {
        return d(new (d(function () {
        }, {prototype: e})), t)
    }

    function h() {
    }

    function m(e) {
        return e
    }

    function g(e) {
        return function () {
            return e
        }
    }

    function v(e) {
        return "undefined" == typeof e
    }

    function _(e) {
        return "undefined" != typeof e
    }

    function y(e) {
        return null !== e && "object" == typeof e
    }

    function b(e) {
        return "string" == typeof e
    }

    function $(e) {
        return "number" == typeof e
    }

    function w(e) {
        return "[object Date]" === Zr.call(e)
    }

    function x(e) {
        return "function" == typeof e
    }

    function S(e) {
        return "[object RegExp]" === Zr.call(e)
    }

    function C(e) {
        return e && e.window === e
    }

    function k(e) {
        return e && e.$evalAsync && e.$watch
    }

    function T(e) {
        return "[object File]" === Zr.call(e)
    }

    function E(e) {
        return "[object Blob]" === Zr.call(e)
    }

    function A(e) {
        return "boolean" == typeof e
    }

    function M(e) {
        return e && x(e.then)
    }

    function D(e) {
        return !(!e || !(e.nodeName || e.prop && e.attr && e.find))
    }

    function q(e) {
        var t, n = {}, r = e.split(",");
        for (t = 0; t < r.length; t++)n[r[t]] = !0;
        return n
    }

    function L(e) {
        return Br(e.nodeName || e[0].nodeName)
    }

    function O(e, t) {
        var n = e.indexOf(t);
        return n >= 0 && e.splice(n, 1), t
    }

    function P(e, t, n, r) {
        if (C(e) || k(e))throw ei("cpws", "Can't copy! Making copies of Window or Scope instances is not supported.");
        if (t) {
            if (e === t)throw ei("cpi", "Can't copy! Source and destination are identical.");
            if (n = n || [], r = r || [], y(e)) {
                var i = n.indexOf(e);
                if (-1 !== i)return r[i];
                n.push(e), r.push(t)
            }
            var a;
            if (ii(e)) {
                t.length = 0;
                for (var s = 0; s < e.length; s++)a = P(e[s], null, n, r), y(e[s]) && (n.push(e[s]), r.push(a)), t.push(a)
            } else {
                var c = t.$$hashKey;
                ii(t) ? t.length = 0 : o(t, function (e, n) {
                    delete t[n]
                });
                for (var l in e)e.hasOwnProperty(l) && (a = P(e[l], null, n, r), y(e[l]) && (n.push(e[l]), r.push(a)), t[l] = a);
                u(t, c)
            }
        } else if (t = e, e)if (ii(e))t = P(e, [], n, r); else if (w(e))t = new Date(e.getTime()); else if (S(e))t = new RegExp(e.source, e.toString().match(/[^\/]*$/)[0]), t.lastIndex = e.lastIndex; else if (y(e)) {
            var d = Object.create(Object.getPrototypeOf(e));
            t = P(e, d, n, r)
        }
        return t
    }

    function N(e, t) {
        if (ii(e)) {
            t = t || [];
            for (var n = 0, r = e.length; r > n; n++)t[n] = e[n]
        } else if (y(e)) {
            t = t || {};
            for (var i in e)("$" !== i.charAt(0) || "$" !== i.charAt(1)) && (t[i] = e[i])
        }
        return t || e
    }

    function j(e, t) {
        if (e === t)return !0;
        if (null === e || null === t)return !1;
        if (e !== e && t !== t)return !0;
        var r, i, o, a = typeof e, s = typeof t;
        if (a == s && "object" == a) {
            if (!ii(e)) {
                if (w(e))return w(t) ? j(e.getTime(), t.getTime()) : !1;
                if (S(e) && S(t))return e.toString() == t.toString();
                if (k(e) || k(t) || C(e) || C(t) || ii(t))return !1;
                o = {};
                for (i in e)if ("$" !== i.charAt(0) && !x(e[i])) {
                    if (!j(e[i], t[i]))return !1;
                    o[i] = !0
                }
                for (i in t)if (!o.hasOwnProperty(i) && "$" !== i.charAt(0) && t[i] !== n && !x(t[i]))return !1;
                return !0
            }
            if (!ii(t))return !1;
            if ((r = e.length) == t.length) {
                for (i = 0; r > i; i++)if (!j(e[i], t[i]))return !1;
                return !0
            }
        }
        return !1
    }

    function R(e, t, n) {
        return e.concat(Qr.call(t, n))
    }

    function I(e, t) {
        return Qr.call(e, t || 0)
    }

    function U(e, t) {
        var n = arguments.length > 2 ? I(arguments, 2) : [];
        return !x(t) || t instanceof RegExp ? t : n.length ? function () {
            return arguments.length ? t.apply(e, R(n, arguments, 0)) : t.apply(e, n)
        } : function () {
            return arguments.length ? t.apply(e, arguments) : t.call(e)
        }
    }

    function B(e, r) {
        var i = r;
        return "string" == typeof e && "$" === e.charAt(0) && "$" === e.charAt(1) ? i = n : C(r) ? i = "$WINDOW" : r && t === r ? i = "$DOCUMENT" : k(r) && (i = "$SCOPE"), i
    }

    function F(e, t) {
        return "undefined" == typeof e ? n : JSON.stringify(e, B, t ? "  " : null)
    }

    function H(e) {
        return b(e) ? JSON.parse(e) : e
    }

    function z(e) {
        e = Gr(e).clone();
        try {
            e.empty()
        } catch (t) {
        }
        var n = Gr("<div>").append(e).html();
        try {
            return e[0].nodeType === pi ? Br(n) : n.match(/^(<[^>]+>)/)[1].replace(/^<([\w\-]+)/, function (e, t) {
                return "<" + Br(t)
            })
        } catch (t) {
            return Br(n)
        }
    }

    function V(e) {
        try {
            return decodeURIComponent(e)
        } catch (t) {
        }
    }

    function W(e) {
        var t, n, r = {};
        return o((e || "").split("&"), function (e) {
            if (e && (t = e.replace(/\+/g, "%20").split("="), n = V(t[0]), _(n))) {
                var i = _(t[1]) ? V(t[1]) : !0;
                Fr.call(r, n) ? ii(r[n]) ? r[n].push(i) : r[n] = [r[n], i] : r[n] = i
            }
        }), r
    }

    function G(e) {
        var t = [];
        return o(e, function (e, n) {
            ii(e) ? o(e, function (e) {
                t.push(Y(n, !0) + (e === !0 ? "" : "=" + Y(e, !0)))
            }) : t.push(Y(n, !0) + (e === !0 ? "" : "=" + Y(e, !0)))
        }), t.length ? t.join("&") : ""
    }

    function X(e) {
        return Y(e, !0).replace(/%26/gi, "&").replace(/%3D/gi, "=").replace(/%2B/gi, "+")
    }

    function Y(e, t) {
        return encodeURIComponent(e).replace(/%40/gi, "@").replace(/%3A/gi, ":").replace(/%24/g, "$").replace(/%2C/gi, ",").replace(/%3B/gi, ";").replace(/%20/g, t ? "%20" : "+")
    }

    function Q(e, t) {
        var n, r, i = ci.length;
        for (e = Gr(e), r = 0; i > r; ++r)if (n = ci[r] + t, b(n = e.attr(n)))return n;
        return null
    }

    function K(e, t) {
        var n, r, i = {};
        o(ci, function (t) {
            var i = t + "app";
            !n && e.hasAttribute && e.hasAttribute(i) && (n = e, r = e.getAttribute(i))
        }), o(ci, function (t) {
            var i, o = t + "app";
            !n && (i = e.querySelector("[" + o.replace(":", "\\:") + "]")) && (n = i, r = i.getAttribute(o))
        }), n && (i.strictDi = null !== Q(n, "strict-di"), t(n, r ? [r] : [], i))
    }

    function J(n, r, i) {
        y(i) || (i = {});
        var a = {strictDi: !1};
        i = d(a, i);
        var s = function () {
            if (n = Gr(n), n.injector()) {
                var e = n[0] === t ? "document" : z(n);
                throw ei("btstrpd", "App Already Bootstrapped with this Element '{0}'", e.replace(/</, "&lt;").replace(/>/, "&gt;"))
            }
            r = r || [], r.unshift(["$provide", function (e) {
                e.value("$rootElement", n)
            }]), i.debugInfoEnabled && r.push(["$compileProvider", function (e) {
                e.debugInfoEnabled(!0)
            }]), r.unshift("ng");
            var o = Ft(r, i.strictDi);
            return o.invoke(["$rootScope", "$rootElement", "$compile", "$injector", function (e, t, n, r) {
                e.$apply(function () {
                    t.data("$injector", r), n(t)(e)
                })
            }]), o
        }, c = /^NG_ENABLE_DEBUG_INFO!/, l = /^NG_DEFER_BOOTSTRAP!/;
        return e && c.test(e.name) && (i.debugInfoEnabled = !0, e.name = e.name.replace(c, "")), e && !l.test(e.name) ? s() : (e.name = e.name.replace(l, ""), void(ti.resumeBootstrap = function (e) {
            o(e, function (e) {
                r.push(e)
            }), s()
        }))
    }

    function Z() {
        e.name = "NG_ENABLE_DEBUG_INFO!" + e.name, e.location.reload()
    }

    function et(e) {
        return ti.element(e).injector().get("$$testability")
    }

    function tt(e, t) {
        return t = t || "_", e.replace(li, function (e, n) {
            return (n ? t : "") + e.toLowerCase()
        })
    }

    function nt() {
        var t;
        ui || (Xr = e.jQuery, Xr && Xr.fn.on ? (Gr = Xr, d(Xr.fn, {
            scope: Mi.scope,
            isolateScope: Mi.isolateScope,
            controller: Mi.controller,
            injector: Mi.injector,
            inheritedData: Mi.inheritedData
        }), t = Xr.cleanData, Xr.cleanData = function (e) {
            var n;
            if (ri)ri = !1; else for (var r, i = 0; null != (r = e[i]); i++)n = Xr._data(r, "events"), n && n.$destroy && Xr(r).triggerHandler("$destroy");
            t(e)
        }) : Gr = yt, ti.element = Gr, ui = !0)
    }

    function rt(e, t, n) {
        if (!e)throw ei("areq", "Argument '{0}' is {1}", t || "?", n || "required");
        return e
    }

    function it(e, t, n) {
        return n && ii(e) && (e = e[e.length - 1]), rt(x(e), t, "not a function, got " + (e && "object" == typeof e ? e.constructor.name || "Object" : typeof e)), e
    }

    function ot(e, t) {
        if ("hasOwnProperty" === e)throw ei("badname", "hasOwnProperty is not a valid {0} name", t)
    }

    function at(e, t, n) {
        if (!t)return e;
        for (var r, i = t.split("."), o = e, a = i.length, s = 0; a > s; s++)r = i[s], e && (e = (o = e)[r]);
        return !n && x(e) ? U(o, e) : e
    }

    function st(e) {
        var t = e[0], n = e[e.length - 1], r = [t];
        do {
            if (t = t.nextSibling, !t)break;
            r.push(t)
        } while (t !== n);
        return Gr(r)
    }

    function ct() {
        return Object.create(null)
    }

    function lt(e) {
        function t(e, t, n) {
            return e[t] || (e[t] = n())
        }

        var n = r("$injector"), i = r("ng"), o = t(e, "angular", Object);
        return o.$$minErr = o.$$minErr || r, t(o, "module", function () {
            var e = {};
            return function (r, o, a) {
                var s = function (e, t) {
                    if ("hasOwnProperty" === e)throw i("badname", "hasOwnProperty is not a valid {0} name", t)
                };
                return s(r, "module"), o && e.hasOwnProperty(r) && (e[r] = null), t(e, r, function () {
                    function e(e, n, r, i) {
                        return i || (i = t), function () {
                            return i[r || "push"]([e, n, arguments]), l
                        }
                    }

                    if (!o)throw n("nomod", "Module '{0}' is not available! You either misspelled the module name or forgot to load it. If registering a module ensure that you specify the dependencies as the second argument.", r);
                    var t = [], i = [], s = [], c = e("$injector", "invoke", "push", i), l = {
                        _invokeQueue: t,
                        _configBlocks: i,
                        _runBlocks: s,
                        requires: o,
                        name: r,
                        provider: e("$provide", "provider"),
                        factory: e("$provide", "factory"),
                        service: e("$provide", "service"),
                        value: e("$provide", "value"),
                        constant: e("$provide", "constant", "unshift"),
                        animation: e("$animateProvider", "register"),
                        filter: e("$filterProvider", "register"),
                        controller: e("$controllerProvider", "register"),
                        directive: e("$compileProvider", "directive"),
                        config: c,
                        run: function (e) {
                            return s.push(e), this
                        }
                    };
                    return a && c(a), l
                })
            }
        })
    }

    function ut(e) {
        var t = [];
        return JSON.stringify(e, function (e, n) {
            if (n = B(e, n), y(n)) {
                if (t.indexOf(n) >= 0)return "<<already seen>>";
                t.push(n)
            }
            return n
        })
    }

    function dt(e) {
        return "function" == typeof e ? e.toString().replace(/ \{[\s\S]*$/, "") : "undefined" == typeof e ? "undefined" : "string" != typeof e ? ut(e) : e
    }

    function pt(t) {
        d(t, {
            bootstrap: J,
            copy: P,
            extend: d,
            equals: j,
            element: Gr,
            forEach: o,
            injector: Ft,
            noop: h,
            bind: U,
            toJson: F,
            fromJson: H,
            identity: m,
            isUndefined: v,
            isDefined: _,
            isString: b,
            isFunction: x,
            isObject: y,
            isNumber: $,
            isElement: D,
            isArray: ii,
            version: gi,
            isDate: w,
            lowercase: Br,
            uppercase: Hr,
            callbacks: {counter: 0},
            getTestability: et,
            $$minErr: r,
            $$csp: si,
            reloadWithDebugInfo: Z
        }), Yr = lt(e);
        try {
            Yr("ngLocale")
        } catch (n) {
            Yr("ngLocale", []).provider("$locale", hn)
        }
        Yr("ng", ["ngLocale"], ["$provide", function (e) {
            e.provider({$$sanitizeUri: Vn}), e.provider("$compile", Yt).directive({
                a: wo,
                input: Bo,
                textarea: Bo,
                form: To,
                script: qa,
                select: Pa,
                style: ja,
                option: Na,
                ngBind: aa,
                ngBindHtml: ca,
                ngBindTemplate: sa,
                ngClass: la,
                ngClassEven: da,
                ngClassOdd: ua,
                ngCloak: pa,
                ngController: fa,
                ngForm: Eo,
                ngHide: ka,
                ngIf: ga,
                ngInclude: va,
                ngInit: ya,
                ngNonBindable: ba,
                ngPluralize: $a,
                ngRepeat: wa,
                ngShow: Ca,
                ngStyle: Ta,
                ngSwitch: Ea,
                ngSwitchWhen: Aa,
                ngSwitchDefault: Ma,
                ngOptions: Oa,
                ngTransclude: Da,
                ngModel: Qo,
                ngList: na,
                ngChange: Ko,
                pattern: Zo,
                ngPattern: Zo,
                required: Jo,
                ngRequired: Jo,
                minlength: ta,
                ngMinlength: ta,
                maxlength: ea,
                ngMaxlength: ea,
                ngValue: ia,
                ngModelOptions: oa
            }).directive({ngInclude: _a}).directive(xo).directive(ha), e.provider({
                $anchorScroll: Ht,
                $animate: Ui,
                $browser: Wt,
                $cacheFactory: Gt,
                $controller: Zt,
                $document: en,
                $exceptionHandler: tn,
                $filter: rr,
                $interpolate: pn,
                $interval: fn,
                $http: cn,
                $httpBackend: un,
                $location: Tn,
                $log: En,
                $parse: In,
                $rootScope: zn,
                $q: Un,
                $$q: Bn,
                $sce: Yn,
                $sceDelegate: Xn,
                $sniffer: Qn,
                $templateCache: Xt,
                $templateRequest: Kn,
                $$testability: Jn,
                $timeout: Zn,
                $window: nr,
                $$rAF: Hn,
                $$asyncCallback: zt
            })
        }])
    }

    function ft() {
        return ++_i
    }

    function ht(e) {
        return e.replace($i, function (e, t, n, r) {
            return r ? n.toUpperCase() : n
        }).replace(wi, "Moz$1")
    }

    function mt(e) {
        return !ki.test(e)
    }

    function gt(e) {
        var t = e.nodeType;
        return t === di || !t || t === hi
    }

    function vt(e, t) {
        var n, r, i, a, s = t.createDocumentFragment(), c = [];
        if (mt(e))c.push(t.createTextNode(e)); else {
            for (n = n || s.appendChild(t.createElement("div")), r = (Ti.exec(e) || ["", ""])[1].toLowerCase(), i = Ai[r] || Ai._default, n.innerHTML = i[1] + e.replace(Ei, "<$1></$2>") + i[2], a = i[0]; a--;)n = n.lastChild;
            c = R(c, n.childNodes), n = s.firstChild, n.textContent = ""
        }
        return s.textContent = "", s.innerHTML = "", o(c, function (e) {
            s.appendChild(e)
        }), s
    }

    function _t(e, n) {
        n = n || t;
        var r;
        return (r = Ci.exec(e)) ? [n.createElement(r[1])] : (r = vt(e, n)) ? r.childNodes : []
    }

    function yt(e) {
        if (e instanceof yt)return e;
        var t;
        if (b(e) && (e = oi(e), t = !0), !(this instanceof yt)) {
            if (t && "<" != e.charAt(0))throw Si("nosel", "Looking up elements via selectors is not supported by jqLite! See: http://docs.angularjs.org/api/angular.element");
            return new yt(e)
        }
        t ? At(this, _t(e)) : At(this, e)
    }

    function bt(e) {
        return e.cloneNode(!0)
    }

    function $t(e, t) {
        if (t || xt(e), e.querySelectorAll)for (var n = e.querySelectorAll("*"), r = 0, i = n.length; i > r; r++)xt(n[r])
    }

    function wt(e, t, n, r) {
        if (_(r))throw Si("offargs", "jqLite#off() does not support the `selector` argument");
        var i = St(e), a = i && i.events, s = i && i.handle;
        if (s)if (t)o(t.split(" "), function (t) {
            if (_(n)) {
                var r = a[t];
                if (O(r || [], n), r && r.length > 0)return
            }
            bi(e, t, s), delete a[t]
        }); else for (t in a)"$destroy" !== t && bi(e, t, s), delete a[t]
    }

    function xt(e, t) {
        var r = e.ng339, i = r && vi[r];
        if (i) {
            if (t)return void delete i.data[t];
            i.handle && (i.events.$destroy && i.handle({}, "$destroy"), wt(e)), delete vi[r], e.ng339 = n
        }
    }

    function St(e, t) {
        var r = e.ng339, i = r && vi[r];
        return t && !i && (e.ng339 = r = ft(), i = vi[r] = {events: {}, data: {}, handle: n}), i
    }

    function Ct(e, t, n) {
        if (gt(e)) {
            var r = _(n), i = !r && t && !y(t), o = !t, a = St(e, !i), s = a && a.data;
            if (r)s[t] = n; else {
                if (o)return s;
                if (i)return s && s[t];
                d(s, t)
            }
        }
    }

    function kt(e, t) {
        return e.getAttribute ? (" " + (e.getAttribute("class") || "") + " ").replace(/[\n\t]/g, " ").indexOf(" " + t + " ") > -1 : !1
    }

    function Tt(e, t) {
        t && e.setAttribute && o(t.split(" "), function (t) {
            e.setAttribute("class", oi((" " + (e.getAttribute("class") || "") + " ").replace(/[\n\t]/g, " ").replace(" " + oi(t) + " ", " ")))
        })
    }

    function Et(e, t) {
        if (t && e.setAttribute) {
            var n = (" " + (e.getAttribute("class") || "") + " ").replace(/[\n\t]/g, " ");
            o(t.split(" "), function (e) {
                e = oi(e), -1 === n.indexOf(" " + e + " ") && (n += e + " ")
            }), e.setAttribute("class", oi(n))
        }
    }

    function At(e, t) {
        if (t)if (t.nodeType)e[e.length++] = t; else {
            var n = t.length;
            if ("number" == typeof n && t.window !== t) {
                if (n)for (var r = 0; n > r; r++)e[e.length++] = t[r]
            } else e[e.length++] = t
        }
    }

    function Mt(e, t) {
        return Dt(e, "$" + (t || "ngController") + "Controller")
    }

    function Dt(e, t, r) {
        e.nodeType == hi && (e = e.documentElement);
        for (var i = ii(t) ? t : [t]; e;) {
            for (var o = 0, a = i.length; a > o; o++)if ((r = Gr.data(e, i[o])) !== n)return r;
            e = e.parentNode || e.nodeType === mi && e.host
        }
    }

    function qt(e) {
        for ($t(e, !0); e.firstChild;)e.removeChild(e.firstChild)
    }

    function Lt(e, t) {
        t || $t(e);
        var n = e.parentNode;
        n && n.removeChild(e)
    }

    function Ot(t, n) {
        n = n || e, "complete" === n.document.readyState ? n.setTimeout(t) : Gr(n).on("load", t)
    }

    function Pt(e, t) {
        var n = Di[t.toLowerCase()];
        return n && qi[L(e)] && n
    }

    function Nt(e, t) {
        var n = e.nodeName;
        return ("INPUT" === n || "TEXTAREA" === n) && Li[t]
    }

    function jt(e, t) {
        var n = function (n, r) {
            n.isDefaultPrevented = function () {
                return n.defaultPrevented
            };
            var i = t[r || n.type], o = i ? i.length : 0;
            if (o) {
                if (v(n.immediatePropagationStopped)) {
                    var a = n.stopImmediatePropagation;
                    n.stopImmediatePropagation = function () {
                        n.immediatePropagationStopped = !0, n.stopPropagation && n.stopPropagation(), a && a.call(n)
                    }
                }
                n.isImmediatePropagationStopped = function () {
                    return n.immediatePropagationStopped === !0
                }, o > 1 && (i = N(i));
                for (var s = 0; o > s; s++)n.isImmediatePropagationStopped() || i[s].call(e, n)
            }
        };
        return n.elem = e, n
    }

    function Rt(e, t) {
        var n = e && e.$$hashKey;
        if (n)return "function" == typeof n && (n = e.$$hashKey()), n;
        var r = typeof e;
        return n = "function" == r || "object" == r && null !== e ? e.$$hashKey = r + ":" + (t || l)() : r + ":" + e
    }

    function It(e, t) {
        if (t) {
            var n = 0;
            this.nextUid = function () {
                return ++n
            }
        }
        o(e, this.put, this)
    }

    function Ut(e) {
        var t = e.toString().replace(ji, ""), n = t.match(Oi);
        return n ? "function(" + (n[1] || "").replace(/[\s\r\n]+/, " ") + ")" : "fn"
    }

    function Bt(e, t, n) {
        var r, i, a, s;
        if ("function" == typeof e) {
            if (!(r = e.$inject)) {
                if (r = [], e.length) {
                    if (t)throw b(n) && n || (n = e.name || Ut(e)), Ri("strictdi", "{0} is not using explicit annotation and cannot be invoked in strict mode", n);
                    i = e.toString().replace(ji, ""), a = i.match(Oi), o(a[1].split(Pi), function (e) {
                        e.replace(Ni, function (e, t, n) {
                            r.push(n)
                        })
                    })
                }
                e.$inject = r
            }
        } else ii(e) ? (s = e.length - 1, it(e[s], "fn"), r = e.slice(0, s)) : it(e, "fn", !0);
        return r
    }

    function Ft(e, t) {
        function r(e) {
            return function (t, n) {
                return y(t) ? void o(t, c(e)) : e(t, n)
            }
        }

        function i(e, t) {
            if (ot(e, "service"), (x(t) || ii(t)) && (t = k.instantiate(t)), !t.$get)throw Ri("pget", "Provider '{0}' must define $get factory method.", e);
            return C[e + $] = t
        }

        function a(e, t) {
            return function () {
                var r = E.invoke(t, this, n, e);
                if (v(r))throw Ri("undef", "Provider '{0}' must return a value from $get factory method.", e);
                return r
            }
        }

        function s(e, t, n) {
            return i(e, {$get: n !== !1 ? a(e, t) : t})
        }

        function l(e, t) {
            return s(e, ["$injector", function (e) {
                return e.instantiate(t)
            }])
        }

        function u(e, t) {
            return s(e, g(t), !1)
        }

        function d(e, t) {
            ot(e, "constant"), C[e] = t, T[e] = t
        }

        function p(e, t) {
            var n = k.get(e + $), r = n.$get;
            n.$get = function () {
                var e = E.invoke(r, n);
                return E.invoke(t, null, {$delegate: e})
            }
        }

        function f(e) {
            var t, n = [];
            return o(e, function (e) {
                function r(e) {
                    var t, n;
                    for (t = 0, n = e.length; n > t; t++) {
                        var r = e[t], i = k.get(r[0]);
                        i[r[1]].apply(i, r[2])
                    }
                }

                if (!S.get(e)) {
                    S.put(e, !0);
                    try {
                        b(e) ? (t = Yr(e), n = n.concat(f(t.requires)).concat(t._runBlocks), r(t._invokeQueue), r(t._configBlocks)) : x(e) ? n.push(k.invoke(e)) : ii(e) ? n.push(k.invoke(e)) : it(e, "module")
                    } catch (i) {
                        throw ii(e) && (e = e[e.length - 1]), i.message && i.stack && -1 == i.stack.indexOf(i.message) && (i = i.message + "\n" + i.stack), Ri("modulerr", "Failed to instantiate module {0} due to:\n{1}", e, i.stack || i.message || i)
                    }
                }
            }), n
        }

        function m(e, n) {
            function r(t) {
                if (e.hasOwnProperty(t)) {
                    if (e[t] === _)throw Ri("cdep", "Circular dependency found: {0}", t + " <- " + w.join(" <- "));
                    return e[t]
                }
                try {
                    return w.unshift(t), e[t] = _, e[t] = n(t)
                } catch (r) {
                    throw e[t] === _ && delete e[t], r
                } finally {
                    w.shift()
                }
            }

            function i(e, n, i, o) {
                "string" == typeof i && (o = i, i = null);
                var a, s, c, l = [], u = Bt(e, t, o);
                for (s = 0, a = u.length; a > s; s++) {
                    if (c = u[s], "string" != typeof c)throw Ri("itkn", "Incorrect injection token! Expected service name as string, got {0}", c);
                    l.push(i && i.hasOwnProperty(c) ? i[c] : r(c))
                }
                return ii(e) && (e = e[a]), e.apply(n, l)
            }

            function o(e, t, n) {
                var r, o, a = function () {
                };
                return a.prototype = (ii(e) ? e[e.length - 1] : e).prototype, r = new a, o = i(e, r, t, n), y(o) || x(o) ? o : r
            }

            return {
                invoke: i, instantiate: o, get: r, annotate: Bt, has: function (t) {
                    return C.hasOwnProperty(t + $) || e.hasOwnProperty(t)
                }
            }
        }

        t = t === !0;
        var _ = {}, $ = "Provider", w = [], S = new It([], !0), C = {
            $provide: {
                provider: r(i),
                factory: r(s),
                service: r(l),
                value: r(u),
                constant: r(d),
                decorator: p
            }
        }, k = C.$injector = m(C, function () {
            throw Ri("unpr", "Unknown provider: {0}", w.join(" <- "))
        }), T = {}, E = T.$injector = m(T, function (e) {
            var t = k.get(e + $);
            return E.invoke(t.$get, t, n, e)
        });
        return o(f(e), function (e) {
            E.invoke(e || h)
        }), E
    }

    function Ht() {
        var e = !0;
        this.disableAutoScrolling = function () {
            e = !1
        }, this.$get = ["$window", "$location", "$rootScope", function (t, n, r) {
            function i(e) {
                var t = null;
                return Array.prototype.some.call(e, function (e) {
                    return "a" === L(e) ? (t = e, !0) : void 0
                }), t
            }

            function o() {
                var e = s.yOffset;
                if (x(e))e = e(); else if (D(e)) {
                    var n = e[0], r = t.getComputedStyle(n);
                    e = "fixed" !== r.position ? 0 : n.getBoundingClientRect().bottom
                } else $(e) || (e = 0);
                return e
            }

            function a(e) {
                if (e) {
                    e.scrollIntoView();
                    var n = o();
                    if (n) {
                        var r = e.getBoundingClientRect().top;
                        t.scrollBy(0, r - n)
                    }
                } else t.scrollTo(0, 0)
            }

            function s() {
                var e, t = n.hash();
                t ? (e = c.getElementById(t)) ? a(e) : (e = i(c.getElementsByName(t))) ? a(e) : "top" === t && a(null) : a(null)
            }

            var c = t.document;
            return e && r.$watch(function () {
                return n.hash()
            }, function (e, t) {
                (e !== t || "" !== e) && Ot(function () {
                    r.$evalAsync(s)
                })
            }), s
        }]
    }

    function zt() {
        this.$get = ["$$rAF", "$timeout", function (e, t) {
            return e.supported ? function (t) {
                return e(t)
            } : function (e) {
                return t(e, 0, !1)
            }
        }]
    }

    function Vt(e, t, r, i) {
        function a(e) {
            try {
                e.apply(null, I(arguments, 1))
            } finally {
                if (w--, 0 === w)for (; x.length;)try {
                    x.pop()()
                } catch (t) {
                    r.error(t)
                }
            }
        }

        function s(e, t) {
            !function n() {
                o(C, function (e) {
                    e()
                }), S = t(n, e)
            }()
        }

        function c() {
            l(), u()
        }

        function l() {
            k = e.history.state, k = v(k) ? null : k, j(k, L) && (k = L), L = k
        }

        function u() {
            (E !== p.url() || T !== k) && (E = p.url(), T = k, o(D, function (e) {
                e(p.url(), k)
            }))
        }

        function d(e) {
            try {
                return decodeURIComponent(e)
            } catch (t) {
                return e
            }
        }

        var p = this, f = t[0], m = e.location, g = e.history, _ = e.setTimeout, y = e.clearTimeout, $ = {};
        p.isMock = !1;
        var w = 0, x = [];
        p.$$completeOutstandingRequest = a, p.$$incOutstandingRequestCount = function () {
            w++
        }, p.notifyWhenNoOutstandingRequests = function (e) {
            o(C, function (e) {
                e()
            }), 0 === w ? e() : x.push(e)
        };
        var S, C = [];
        p.addPollFn = function (e) {
            return v(S) && s(100, _), C.push(e), e
        };
        var k, T, E = m.href, A = t.find("base"), M = null;
        l(), T = k, p.url = function (t, n, r) {
            if (v(r) && (r = null), m !== e.location && (m = e.location), g !== e.history && (g = e.history), t) {
                var o = T === r;
                if (E === t && (!i.history || o))return;
                var a = E && yn(E) === yn(t);
                return E = t, T = r, !i.history || a && o ? (a || (M = t), n ? m.replace(t) : m.href = t) : (g[n ? "replaceState" : "pushState"](r, "", t), l(), T = k), p
            }
            return M || m.href.replace(/%27/g, "'")
        }, p.state = function () {
            return k
        };
        var D = [], q = !1, L = null;
        p.onUrlChange = function (t) {
            return q || (i.history && Gr(e).on("popstate", c), Gr(e).on("hashchange", c), q = !0), D.push(t), t
        }, p.$$checkUrlChange = u, p.baseHref = function () {
            var e = A.attr("href");
            return e ? e.replace(/^(https?\:)?\/\/[^\/]*/, "") : ""
        };
        var O = {}, P = "", N = p.baseHref();
        p.cookies = function (e, t) {
            var i, o, a, s, c;
            if (!e) {
                if (f.cookie !== P)for (P = f.cookie, o = P.split("; "), O = {}, s = 0; s < o.length; s++)a = o[s], c = a.indexOf("="), c > 0 && (e = d(a.substring(0, c)), O[e] === n && (O[e] = d(a.substring(c + 1))));
                return O
            }
            t === n ? f.cookie = encodeURIComponent(e) + "=;path=" + N + ";expires=Thu, 01 Jan 1970 00:00:00 GMT" : b(t) && (i = (f.cookie = encodeURIComponent(e) + "=" + encodeURIComponent(t) + ";path=" + N).length + 1, i > 4096 && r.warn("Cookie '" + e + "' possibly not set or overflowed because it was too large (" + i + " > 4096 bytes)!"))
        }, p.defer = function (e, t) {
            var n;
            return w++, n = _(function () {
                delete $[n], a(e)
            }, t || 0), $[n] = !0, n
        }, p.defer.cancel = function (e) {
            return $[e] ? (delete $[e], y(e), a(h), !0) : !1
        }
    }

    function Wt() {
        this.$get = ["$window", "$log", "$sniffer", "$document", function (e, t, n, r) {
            return new Vt(e, r, t, n)
        }]
    }

    function Gt() {
        this.$get = function () {
            function e(e, n) {
                function i(e) {
                    e != p && (f ? f == e && (f = e.n) : f = e, o(e.n, e.p), o(e, p), p = e, p.n = null)
                }

                function o(e, t) {
                    e != t && (e && (e.p = t), t && (t.n = e))
                }

                if (e in t)throw r("$cacheFactory")("iid", "CacheId '{0}' is already taken!", e);
                var a = 0, s = d({}, n, {id: e}), c = {}, l = n && n.capacity || Number.MAX_VALUE, u = {}, p = null, f = null;
                return t[e] = {
                    put: function (e, t) {
                        if (l < Number.MAX_VALUE) {
                            var n = u[e] || (u[e] = {key: e});
                            i(n)
                        }
                        if (!v(t))return e in c || a++, c[e] = t, a > l && this.remove(f.key), t
                    }, get: function (e) {
                        if (l < Number.MAX_VALUE) {
                            var t = u[e];
                            if (!t)return;
                            i(t)
                        }
                        return c[e]
                    }, remove: function (e) {
                        if (l < Number.MAX_VALUE) {
                            var t = u[e];
                            if (!t)return;
                            t == p && (p = t.p), t == f && (f = t.n), o(t.n, t.p), delete u[e]
                        }
                        delete c[e], a--
                    }, removeAll: function () {
                        c = {}, a = 0, u = {}, p = f = null
                    }, destroy: function () {
                        c = null, s = null, u = null, delete t[e]
                    }, info: function () {
                        return d({}, s, {size: a})
                    }
                }
            }

            var t = {};
            return e.info = function () {
                var e = {};
                return o(t, function (t, n) {
                    e[n] = t.info()
                }), e
            }, e.get = function (e) {
                return t[e]
            }, e
        }
    }

    function Xt() {
        this.$get = ["$cacheFactory", function (e) {
            return e("templates")
        }]
    }

    function Yt(e, r) {
        function i(e, t) {
            var n = /^\s*([@&]|=(\*?))(\??)\s*(\w*)\s*$/, r = {};
            return o(e, function (e, i) {
                var o = e.match(n);
                if (!o)throw Bi("iscp", "Invalid isolate scope definition for directive '{0}'. Definition: {... {1}: '{2}' ...}", t, i, e);
                r[i] = {mode: o[1][0], collection: "*" === o[2], optional: "?" === o[3], attrName: o[4] || i}
            }), r
        }

        var a = {}, s = "Directive", l = /^\s*directive\:\s*([\w\-]+)\s+(.*)$/, u = /(([\w\-]+)(?:\:([^;]+))?;?)/, p = q("ngSrc,ngSrcset,src,srcset"), v = /^(?:(\^\^?)?(\?)?(\^\^?)?)?/, $ = /^(on[a-z]+|formaction)$/;
        this.directive = function S(t, n) {
            return ot(t, "directive"), b(t) ? (rt(n, "directiveFactory"), a.hasOwnProperty(t) || (a[t] = [], e.factory(t + s, ["$injector", "$exceptionHandler", function (e, n) {
                var r = [];
                return o(a[t], function (o, a) {
                    try {
                        var s = e.invoke(o);
                        x(s) ? s = {compile: g(s)} : !s.compile && s.link && (s.compile = g(s.link)), s.priority = s.priority || 0, s.index = a, s.name = s.name || t, s.require = s.require || s.controller && s.name, s.restrict = s.restrict || "EA", y(s.scope) && (s.$$isolateBindings = i(s.scope, s.name)), r.push(s)
                    } catch (c) {
                        n(c)
                    }
                }), r
            }])), a[t].push(n)) : o(t, c(S)), this
        }, this.aHrefSanitizationWhitelist = function (e) {
            return _(e) ? (r.aHrefSanitizationWhitelist(e), this) : r.aHrefSanitizationWhitelist()
        }, this.imgSrcSanitizationWhitelist = function (e) {
            return _(e) ? (r.imgSrcSanitizationWhitelist(e), this) : r.imgSrcSanitizationWhitelist()
        };
        var w = !0;
        this.debugInfoEnabled = function (e) {
            return _(e) ? (w = e, this) : w
        }, this.$get = ["$injector", "$interpolate", "$exceptionHandler", "$templateRequest", "$parse", "$controller", "$rootScope", "$document", "$sce", "$animate", "$$sanitizeUri", function (e, r, i, c, g, _, S, C, T, E, A) {
            function M(e, t) {
                try {
                    e.addClass(t)
                } catch (n) {
                }
            }

            function D(e, t, n, r, i) {
                e instanceof Gr || (e = Gr(e)), o(e, function (t, n) {
                    t.nodeType == pi && t.nodeValue.match(/\S+/) && (e[n] = Gr(t).wrap("<span></span>").parent()[0])
                });
                var a = P(e, t, e, n, r, i);
                D.$$addScopeClass(e);
                var s = null;
                return function (t, n, r) {
                    rt(t, "scope"), r = r || {};
                    var i = r.parentBoundTranscludeFn, o = r.transcludeControllers, c = r.futureParentElement;
                    i && i.$$boundTransclude && (i = i.$$boundTransclude), s || (s = q(c));
                    var l;
                    if (l = "html" !== s ? Gr(J(s, Gr("<div>").append(e).html())) : n ? Mi.clone.call(e) : e, o)for (var u in o)l.data("$" + u + "Controller", o[u].instance);
                    return D.$$addScopeInfo(l, t), n && n(l, t), a && a(t, l, l, i), l
                }
            }

            function q(e) {
                var t = e && e[0];
                return t && "foreignobject" !== L(t) && t.toString().match(/SVG/) ? "svg" : "html"
            }

            function P(e, t, r, i, o, a) {
                function s(e, r, i, o) {
                    var a, s, c, l, u, d, p, f, g;
                    if (h) {
                        var v = r.length;
                        for (g = new Array(v), u = 0; u < m.length; u += 3)p = m[u], g[p] = r[p]
                    } else g = r;
                    for (u = 0, d = m.length; d > u;)c = g[m[u++]], a = m[u++], s = m[u++], a ? (a.scope ? (l = e.$new(), D.$$addScopeInfo(Gr(c), l)) : l = e, f = a.transcludeOnThisElement ? N(e, a.transclude, o, a.elementTranscludeOnThisElement) : !a.templateOnThisElement && o ? o : !o && t ? N(e, t) : null, a(s, l, c, i, f)) : s && s(e, c.childNodes, n, o)
                }

                for (var c, l, u, d, p, f, h, m = [], g = 0; g < e.length; g++)c = new at, l = R(e[g], [], c, 0 === g ? i : n, o), u = l.length ? F(l, e[g], c, t, r, null, [], [], a) : null, u && u.scope && D.$$addScopeClass(c.$$element), p = u && u.terminal || !(d = e[g].childNodes) || !d.length ? null : P(d, u ? (u.transcludeOnThisElement || !u.templateOnThisElement) && u.transclude : t), (u || p) && (m.push(g, u, p), f = !0, h = h || u), a = null;
                return f ? s : null
            }

            function N(e, t, n) {
                var r = function (r, i, o, a, s) {
                    return r || (r = e.$new(!1, s), r.$$transcluded = !0), t(r, i, {
                        parentBoundTranscludeFn: n,
                        transcludeControllers: o,
                        futureParentElement: a
                    })
                };
                return r
            }

            function R(e, t, n, r, i) {
                var o, a, s = e.nodeType, c = n.$attr;
                switch (s) {
                    case di:
                        V(t, Qt(L(e)), "E", r, i);
                        for (var d, p, f, h, m, g, v = e.attributes, _ = 0, y = v && v.length; y > _; _++) {
                            var $ = !1, w = !1;
                            d = v[_], p = d.name, m = oi(d.value), h = Qt(p), (g = dt.test(h)) && (p = tt(h.substr(6), "-"));
                            var x = h.replace(/(Start|End)$/, "");
                            W(x) && h === x + "Start" && ($ = p, w = p.substr(0, p.length - 5) + "end", p = p.substr(0, p.length - 6)), f = Qt(p.toLowerCase()), c[f] = p, (g || !n.hasOwnProperty(f)) && (n[f] = m, Pt(e, f) && (n[f] = !0)), et(e, t, m, f, g), V(t, f, "A", r, i, $, w)
                        }
                        if (a = e.className, b(a) && "" !== a)for (; o = u.exec(a);)f = Qt(o[2]), V(t, f, "C", r, i) && (n[f] = oi(o[3])), a = a.substr(o.index + o[0].length);
                        break;
                    case pi:
                        K(t, e.nodeValue);
                        break;
                    case fi:
                        try {
                            o = l.exec(e.nodeValue), o && (f = Qt(o[1]), V(t, f, "M", r, i) && (n[f] = oi(o[2])))
                        } catch (S) {
                        }
                }
                return t.sort(Y), t
            }

            function U(e, t, n) {
                var r = [], i = 0;
                if (t && e.hasAttribute && e.hasAttribute(t)) {
                    do {
                        if (!e)throw Bi("uterdir", "Unterminated attribute, found '{0}' but no matching '{1}' found.", t, n);
                        e.nodeType == di && (e.hasAttribute(t) && i++, e.hasAttribute(n) && i--), r.push(e), e = e.nextSibling
                    } while (i > 0)
                } else r.push(e);
                return Gr(r)
            }

            function B(e, t, n) {
                return function (r, i, o, a, s) {
                    return i = U(i[0], t, n), e(r, i, o, a, s)
                }
            }

            function F(e, a, s, c, l, u, d, p, f) {
                function h(e, t, n, r) {
                    e && (n && (e = B(e, n, r)), e.require = C.require, e.directiveName = T, (O === C || C.$$isolateScope) && (e = it(e, {isolateScope: !0})), d.push(e)), t && (n && (t = B(t, n, r)), t.require = C.require, t.directiveName = T, (O === C || C.$$isolateScope) && (t = it(t, {isolateScope: !0})), p.push(t))
                }

                function m(e, t, n, r) {
                    var i, a, s = "data", c = !1, l = n;
                    if (b(t)) {
                        if (a = t.match(v), t = t.substring(a[0].length), a[3] && (a[1] ? a[3] = null : a[1] = a[3]), "^" === a[1] ? s = "inheritedData" : "^^" === a[1] && (s = "inheritedData", l = n.parent()), "?" === a[2] && (c = !0), i = null, r && "data" === s && (i = r[t]) && (i = i.instance), i = i || l[s]("$" + t + "Controller"), !i && !c)throw Bi("ctreq", "Controller '{0}', required by directive '{1}', can't be found!", t, e);
                        return i || null
                    }
                    return ii(t) && (i = [], o(t, function (t) {
                        i.push(m(e, t, n, r))
                    })), i
                }

                function $(e, t, i, c, l) {
                    function u(e, t, r) {
                        var i;
                        return k(e) || (r = t, t = e, e = n), W && (i = $), r || (r = W ? x.parent() : x), l(e, t, i, r, A)
                    }

                    var f, h, v, y, b, $, w, x, C;
                    if (a === i ? (C = s, x = s.$$element) : (x = Gr(i), C = new at(x, s)), O && (b = t.$new(!0)), l && (w = u, w.$$boundTransclude = l), L && (S = {}, $ = {}, o(L, function (e) {
                            var n, r = {
                                $scope: e === O || e.$$isolateScope ? b : t,
                                $element: x,
                                $attrs: C,
                                $transclude: w
                            };
                            y = e.controller, "@" == y && (y = C[e.name]), n = _(y, r, !0, e.controllerAs), $[e.name] = n, W || x.data("$" + e.name + "Controller", n.instance), S[e.name] = n
                        })), O) {
                        D.$$addScopeInfo(x, b, !0, !(P && (P === O || P === O.$$originalDirective))), D.$$addScopeClass(x, !0);
                        var T = S && S[O.name], E = b;
                        T && T.identifier && O.bindToController === !0 && (E = T.instance), o(b.$$isolateBindings = O.$$isolateBindings, function (e, n) {
                            var i, o, a, s, c = e.attrName, l = e.optional, u = e.mode;
                            switch (u) {
                                case"@":
                                    C.$observe(c, function (e) {
                                        E[n] = e
                                    }), C.$$observers[c].$$scope = t, C[c] && (E[n] = r(C[c])(t));
                                    break;
                                case"=":
                                    if (l && !C[c])return;
                                    o = g(C[c]), s = o.literal ? j : function (e, t) {
                                        return e === t || e !== e && t !== t
                                    }, a = o.assign || function () {
                                            throw i = E[n] = o(t), Bi("nonassign", "Expression '{0}' used with directive '{1}' is non-assignable!", C[c], O.name)
                                        }, i = E[n] = o(t);
                                    var d = function (e) {
                                        return s(e, E[n]) || (s(e, i) ? a(t, e = E[n]) : E[n] = e), i = e
                                    };
                                    d.$stateful = !0;
                                    var p;
                                    p = e.collection ? t.$watchCollection(C[c], d) : t.$watch(g(C[c], d), null, o.literal), b.$on("$destroy", p);
                                    break;
                                case"&":
                                    o = g(C[c]), E[n] = function (e) {
                                        return o(t, e)
                                    }
                            }
                        })
                    }
                    for (S && (o(S, function (e) {
                        e()
                    }), S = null), f = 0, h = d.length; h > f; f++)v = d[f], ot(v, v.isolateScope ? b : t, x, C, v.require && m(v.directiveName, v.require, x, $), w);
                    var A = t;
                    for (O && (O.template || null === O.templateUrl) && (A = b), e && e(A, i.childNodes, n, l), f = p.length - 1; f >= 0; f--)v = p[f], ot(v, v.isolateScope ? b : t, x, C, v.require && m(v.directiveName, v.require, x, $), w)
                }

                f = f || {};
                for (var w, S, C, T, E, A, M, q = -Number.MAX_VALUE, L = f.controllerDirectives, O = f.newIsolateScopeDirective, P = f.templateDirective, N = f.nonTlbTranscludeDirective, F = !1, V = !1, W = f.hasElementTranscludeDirective, Y = s.$$element = Gr(a), K = u, Z = c, et = 0, tt = e.length; tt > et; et++) {
                    C = e[et];
                    var rt = C.$$start, st = C.$$end;
                    if (rt && (Y = U(a, rt, st)), E = n, q > C.priority)break;
                    if ((M = C.scope) && (C.templateUrl || (y(M) ? (Q("new/isolated scope", O || w, C, Y), O = C) : Q("new/isolated scope", O, C, Y)), w = w || C), T = C.name, !C.templateUrl && C.controller && (M = C.controller, L = L || {}, Q("'" + T + "' controller", L[T], C, Y), L[T] = C), (M = C.transclude) && (F = !0, C.$$tlb || (Q("transclusion", N, C, Y), N = C), "element" == M ? (W = !0, q = C.priority, E = Y, Y = s.$$element = Gr(t.createComment(" " + T + ": " + s[T] + " ")), a = Y[0], nt(l, I(E), a), Z = D(E, c, q, K && K.name, {nonTlbTranscludeDirective: N})) : (E = Gr(bt(a)).contents(), Y.empty(), Z = D(E, c))), C.template)if (V = !0, Q("template", P, C, Y), P = C, M = x(C.template) ? C.template(Y, s) : C.template, M = ut(M), C.replace) {
                        if (K = C, E = mt(M) ? [] : Jt(J(C.templateNamespace, oi(M))), a = E[0], 1 != E.length || a.nodeType !== di)throw Bi("tplrt", "Template for directive '{0}' must have exactly one root element. {1}", T, "");
                        nt(l, Y, a);
                        var ct = {$attr: {}}, lt = R(a, [], ct), dt = e.splice(et + 1, e.length - (et + 1));
                        O && H(lt), e = e.concat(lt).concat(dt), G(s, ct), tt = e.length
                    } else Y.html(M);
                    if (C.templateUrl)V = !0, Q("template", P, C, Y), P = C, C.replace && (K = C), $ = X(e.splice(et, e.length - et), Y, s, l, F && Z, d, p, {
                        controllerDirectives: L,
                        newIsolateScopeDirective: O,
                        templateDirective: P,
                        nonTlbTranscludeDirective: N
                    }), tt = e.length; else if (C.compile)try {
                        A = C.compile(Y, s, Z), x(A) ? h(null, A, rt, st) : A && h(A.pre, A.post, rt, st)
                    } catch (pt) {
                        i(pt, z(Y))
                    }
                    C.terminal && ($.terminal = !0, q = Math.max(q, C.priority))
                }
                return $.scope = w && w.scope === !0, $.transcludeOnThisElement = F, $.elementTranscludeOnThisElement = W, $.templateOnThisElement = V, $.transclude = Z, f.hasElementTranscludeDirective = W, $
            }

            function H(e) {
                for (var t = 0, n = e.length; n > t; t++)e[t] = f(e[t], {$$isolateScope: !0})
            }

            function V(t, r, o, c, l, u, d) {
                if (r === l)return null;
                var p = null;
                if (a.hasOwnProperty(r))for (var h, m = e.get(r + s), g = 0, v = m.length; v > g; g++)try {
                    h = m[g], (c === n || c > h.priority) && -1 != h.restrict.indexOf(o) && (u && (h = f(h, {
                        $$start: u,
                        $$end: d
                    })), t.push(h), p = h)
                } catch (_) {
                    i(_)
                }
                return p
            }

            function W(t) {
                if (a.hasOwnProperty(t))for (var n, r = e.get(t + s), i = 0, o = r.length; o > i; i++)if (n = r[i], n.multiElement)return !0;
                return !1
            }

            function G(e, t) {
                var n = t.$attr, r = e.$attr, i = e.$$element;
                o(e, function (r, i) {
                    "$" != i.charAt(0) && (t[i] && t[i] !== r && (r += ("style" === i ? ";" : " ") + t[i]), e.$set(i, r, !0, n[i]))
                }), o(t, function (t, o) {
                    "class" == o ? (M(i, t), e["class"] = (e["class"] ? e["class"] + " " : "") + t) : "style" == o ? (i.attr("style", i.attr("style") + ";" + t), e.style = (e.style ? e.style + ";" : "") + t) : "$" == o.charAt(0) || e.hasOwnProperty(o) || (e[o] = t, r[o] = n[o])
                })
            }

            function X(e, t, n, r, i, a, s, l) {
                var u, p, f = [], h = t[0], m = e.shift(), g = d({}, m, {
                    templateUrl: null,
                    transclude: null,
                    replace: null,
                    $$originalDirective: m
                }), v = x(m.templateUrl) ? m.templateUrl(t, n) : m.templateUrl, _ = m.templateNamespace;
                return t.empty(), c(T.getTrustedResourceUrl(v)).then(function (c) {
                    var d, b, $, w;
                    if (c = ut(c), m.replace) {
                        if ($ = mt(c) ? [] : Jt(J(_, oi(c))), d = $[0], 1 != $.length || d.nodeType !== di)throw Bi("tplrt", "Template for directive '{0}' must have exactly one root element. {1}", m.name, v);
                        b = {$attr: {}}, nt(r, t, d);
                        var x = R(d, [], b);
                        y(m.scope) && H(x), e = x.concat(e), G(n, b)
                    } else d = h, t.html(c);
                    for (e.unshift(g), u = F(e, d, n, i, t, m, a, s, l), o(r, function (e, n) {
                        e == d && (r[n] = t[0])
                    }), p = P(t[0].childNodes, i); f.length;) {
                        var S = f.shift(), C = f.shift(), k = f.shift(), T = f.shift(), E = t[0];
                        if (!S.$$destroyed) {
                            if (C !== h) {
                                var A = C.className;
                                l.hasElementTranscludeDirective && m.replace || (E = bt(d)), nt(k, Gr(C), E), M(Gr(E), A)
                            }
                            w = u.transcludeOnThisElement ? N(S, u.transclude, T) : T, u(p, S, E, r, w)
                        }
                    }
                    f = null
                }), function (e, t, n, r, i) {
                    var o = i;
                    t.$$destroyed || (f ? (f.push(t), f.push(n), f.push(r), f.push(o)) : (u.transcludeOnThisElement && (o = N(t, u.transclude, i)), u(p, t, n, r, o)))
                }
            }

            function Y(e, t) {
                var n = t.priority - e.priority;
                return 0 !== n ? n : e.name !== t.name ? e.name < t.name ? -1 : 1 : e.index - t.index
            }

            function Q(e, t, n, r) {
                if (t)throw Bi("multidir", "Multiple directives [{0}, {1}] asking for {2} on: {3}", t.name, n.name, e, z(r))
            }

            function K(e, t) {
                var n = r(t, !0);
                n && e.push({
                    priority: 0, compile: function (e) {
                        var t = e.parent(), r = !!t.length;
                        return r && D.$$addBindingClass(t), function (e, t) {
                            var i = t.parent();
                            r || D.$$addBindingClass(i), D.$$addBindingInfo(i, n.expressions), e.$watch(n, function (e) {
                                t[0].nodeValue = e
                            })
                        }
                    }
                })
            }

            function J(e, n) {
                switch (e = Br(e || "html")) {
                    case"svg":
                    case"math":
                        var r = t.createElement("div");
                        return r.innerHTML = "<" + e + ">" + n + "</" + e + ">", r.childNodes[0].childNodes;
                    default:
                        return n
                }
            }

            function Z(e, t) {
                if ("srcdoc" == t)return T.HTML;
                var n = L(e);
                return "xlinkHref" == t || "form" == n && "action" == t || "img" != n && ("src" == t || "ngSrc" == t) ? T.RESOURCE_URL : void 0
            }

            function et(e, t, n, i, o) {
                var a = r(n, !0);
                if (a) {
                    if ("multiple" === i && "select" === L(e))throw Bi("selmulti", "Binding to the 'multiple' attribute is not supported. Element: {0}", z(e));
                    t.push({
                        priority: 100, compile: function () {
                            return {
                                pre: function (t, n, s) {
                                    var c = s.$$observers || (s.$$observers = {});
                                    if ($.test(i))throw Bi("nodomevents", "Interpolations for HTML DOM event attributes are disallowed.  Please use the ng- versions (such as ng-click instead of onclick) instead.");
                                    s[i] && (a = r(s[i], !0, Z(e, i), p[i] || o), a && (s[i] = a(t), (c[i] || (c[i] = [])).$$inter = !0, (s.$$observers && s.$$observers[i].$$scope || t).$watch(a, function (e, t) {
                                        "class" === i && e != t ? s.$updateClass(e, t) : s.$set(i, e)
                                    })))
                                }
                            }
                        }
                    })
                }
            }

            function nt(e, n, r) {
                var i, o, a = n[0], s = n.length, c = a.parentNode;
                if (e)for (i = 0, o = e.length; o > i; i++)if (e[i] == a) {
                    e[i++] = r;
                    for (var l = i, u = l + s - 1, d = e.length; d > l; l++, u++)d > u ? e[l] = e[u] : delete e[l];
                    e.length -= s - 1, e.context === a && (e.context = r);
                    break
                }
                c && c.replaceChild(r, a);
                var p = t.createDocumentFragment();
                p.appendChild(a), Gr(r).data(Gr(a).data()), Xr ? (ri = !0, Xr.cleanData([a])) : delete Gr.cache[a[Gr.expando]];
                for (var f = 1, h = n.length; h > f; f++) {
                    var m = n[f];
                    Gr(m).remove(), p.appendChild(m), delete n[f]
                }
                n[0] = r, n.length = 1
            }

            function it(e, t) {
                return d(function () {
                    return e.apply(null, arguments)
                }, e, t)
            }

            function ot(e, t, n, r, o, a) {
                try {
                    e(t, n, r, o, a)
                } catch (s) {
                    i(s, z(n))
                }
            }

            var at = function (e, t) {
                if (t) {
                    var n, r, i, o = Object.keys(t);
                    for (n = 0, r = o.length; r > n; n++)i = o[n], this[i] = t[i]
                } else this.$attr = {};
                this.$$element = e
            };
            at.prototype = {
                $normalize: Qt, $addClass: function (e) {
                    e && e.length > 0 && E.addClass(this.$$element, e)
                }, $removeClass: function (e) {
                    e && e.length > 0 && E.removeClass(this.$$element, e)
                }, $updateClass: function (e, t) {
                    var n = Kt(e, t);
                    n && n.length && E.addClass(this.$$element, n);
                    var r = Kt(t, e);
                    r && r.length && E.removeClass(this.$$element, r)
                }, $set: function (e, t, r, a) {
                    var s, c = this.$$element[0], l = Pt(c, e), u = Nt(c, e), d = e;
                    if (l ? (this.$$element.prop(e, t), a = l) : u && (this[u] = t, d = u), this[e] = t, a ? this.$attr[e] = a : (a = this.$attr[e], a || (this.$attr[e] = a = tt(e, "-"))), s = L(this.$$element), "a" === s && "href" === e || "img" === s && "src" === e)this[e] = t = A(t, "src" === e); else if ("img" === s && "srcset" === e) {
                        for (var p = "", f = oi(t), h = /(\s+\d+x\s*,|\s+\d+w\s*,|\s+,|,\s+)/, m = /\s/.test(f) ? h : /(,)/, g = f.split(m), v = Math.floor(g.length / 2), _ = 0; v > _; _++) {
                            var y = 2 * _;
                            p += A(oi(g[y]), !0), p += " " + oi(g[y + 1])
                        }
                        var b = oi(g[2 * _]).split(/\s/);
                        p += A(oi(b[0]), !0), 2 === b.length && (p += " " + oi(b[1])), this[e] = t = p
                    }
                    r !== !1 && (null === t || t === n ? this.$$element.removeAttr(a) : this.$$element.attr(a, t));
                    var $ = this.$$observers;
                    $ && o($[d], function (e) {
                        try {
                            e(t)
                        } catch (n) {
                            i(n)
                        }
                    })
                }, $observe: function (e, t) {
                    var n = this, r = n.$$observers || (n.$$observers = ct()), i = r[e] || (r[e] = []);
                    return i.push(t), S.$evalAsync(function () {
                        !i.$$inter && n.hasOwnProperty(e) && t(n[e])
                    }), function () {
                        O(i, t)
                    }
                }
            };
            var st = r.startSymbol(), lt = r.endSymbol(), ut = "{{" == st || "}}" == lt ? m : function (e) {
                return e.replace(/\{\{/g, st).replace(/}}/g, lt)
            }, dt = /^ngAttr[A-Z]/;
            return D.$$addBindingInfo = w ? function (e, t) {
                var n = e.data("$binding") || [];
                ii(t) ? n = n.concat(t) : n.push(t), e.data("$binding", n)
            } : h, D.$$addBindingClass = w ? function (e) {
                M(e, "ng-binding")
            } : h, D.$$addScopeInfo = w ? function (e, t, n, r) {
                var i = n ? r ? "$isolateScopeNoTemplate" : "$isolateScope" : "$scope";
                e.data(i, t)
            } : h, D.$$addScopeClass = w ? function (e, t) {
                M(e, t ? "ng-isolate-scope" : "ng-scope")
            } : h, D
        }]
    }

    function Qt(e) {
        return ht(e.replace(Fi, ""))
    }

    function Kt(e, t) {
        var n = "", r = e.split(/\s+/), i = t.split(/\s+/);
        e:for (var o = 0; o < r.length; o++) {
            for (var a = r[o], s = 0; s < i.length; s++)if (a == i[s])continue e;
            n += (n.length > 0 ? " " : "") + a
        }
        return n
    }

    function Jt(e) {
        e = Gr(e);
        var t = e.length;
        if (1 >= t)return e;
        for (; t--;) {
            var n = e[t];
            n.nodeType === fi && Kr.call(e, t, 1)
        }
        return e
    }

    function Zt() {
        var e = {}, t = !1, i = /^(\S+)(\s+as\s+(\w+))?$/;
        this.register = function (t, n) {
            ot(t, "controller"), y(t) ? d(e, t) : e[t] = n
        }, this.allowGlobals = function () {
            t = !0
        }, this.$get = ["$injector", "$window", function (o, a) {
            function s(e, t, n, i) {
                if (!e || !y(e.$scope))throw r("$controller")("noscp", "Cannot export controller '{0}' as '{1}'! No $scope object provided via `locals`.", i, t);
                e.$scope[t] = n
            }

            return function (r, c, l, u) {
                var p, f, h, m;
                if (l = l === !0, u && b(u) && (m = u), b(r) && (f = r.match(i), h = f[1], m = m || f[3], r = e.hasOwnProperty(h) ? e[h] : at(c.$scope, h, !0) || (t ? at(a, h, !0) : n), it(r, h, !0)), l) {
                    var g = function () {
                    };
                    return g.prototype = (ii(r) ? r[r.length - 1] : r).prototype, p = new g, m && s(c, m, p, h || r.name), d(function () {
                        return o.invoke(r, p, c, h), p
                    }, {instance: p, identifier: m})
                }
                return p = o.instantiate(r, c, h), m && s(c, m, p, h || r.name), p
            }
        }]
    }

    function en() {
        this.$get = ["$window", function (e) {
            return Gr(e.document)
        }]
    }

    function tn() {
        this.$get = ["$log", function (e) {
            return function () {
                e.error.apply(e, arguments)
            }
        }]
    }

    function nn(e, t) {
        if (b(e)) {
            e = e.replace(Gi, "");
            var n = t("Content-Type");
            (n && 0 === n.indexOf(Hi) && e.trim() || Vi.test(e) && Wi.test(e)) && (e = H(e))
        }
        return e
    }

    function rn(e) {
        var t, n, r, i = {};
        return e ? (o(e.split("\n"), function (e) {
            r = e.indexOf(":"), t = Br(oi(e.substr(0, r))), n = oi(e.substr(r + 1)), t && (i[t] = i[t] ? i[t] + ", " + n : n)
        }), i) : i
    }

    function on(e) {
        var t = y(e) ? e : n;
        return function (n) {
            return t || (t = rn(e)), n ? t[Br(n)] || null : t
        }
    }

    function an(e, t, n) {
        return x(n) ? n(e, t) : (o(n, function (n) {
            e = n(e, t)
        }), e)
    }

    function sn(e) {
        return e >= 200 && 300 > e
    }

    function cn() {
        var e = this.defaults = {
            transformResponse: [nn],
            transformRequest: [function (e) {
                return !y(e) || T(e) || E(e) ? e : F(e)
            }],
            headers: {common: {Accept: "application/json, text/plain, */*"}, post: N(zi), put: N(zi), patch: N(zi)},
            xsrfCookieName: "XSRF-TOKEN",
            xsrfHeaderName: "X-XSRF-TOKEN"
        }, t = !1;
        this.useApplyAsync = function (e) {
            return _(e) ? (t = !!e, this) : t
        };
        var r = this.interceptors = [];
        this.$get = ["$httpBackend", "$browser", "$cacheFactory", "$rootScope", "$q", "$injector", function (i, a, c, l, u, p) {
            function f(t) {
                function r(e) {
                    var t = d({}, e);
                    return t.data = e.data ? an(e.data, e.headers, a.transformResponse) : e.data, sn(e.status) ? t : u.reject(t)
                }

                function i(t) {
                    function n(e) {
                        var t;
                        o(e, function (n, r) {
                            x(n) && (t = n(), null != t ? e[r] = t : delete e[r])
                        })
                    }

                    var r, i, a, s = e.headers, c = d({}, t.headers);
                    s = d({}, s.common, s[Br(t.method)]);
                    e:for (r in s) {
                        i = Br(r);
                        for (a in c)if (Br(a) === i)continue e;
                        c[r] = s[r]
                    }
                    return n(c), c
                }

                var a = {
                    method: "get",
                    transformRequest: e.transformRequest,
                    transformResponse: e.transformResponse
                }, s = i(t);
                d(a, t), a.headers = s, a.method = Hr(a.method);
                var c = function (t) {
                    s = t.headers;
                    var n = an(t.data, on(s), t.transformRequest);
                    return v(n) && o(s, function (e, t) {
                        "content-type" === Br(t) && delete s[t]
                    }), v(t.withCredentials) && !v(e.withCredentials) && (t.withCredentials = e.withCredentials), g(t, n, s).then(r, r)
                }, l = [c, n], p = u.when(a);
                for (o(C, function (e) {
                    (e.request || e.requestError) && l.unshift(e.request, e.requestError), (e.response || e.responseError) && l.push(e.response, e.responseError)
                }); l.length;) {
                    var f = l.shift(), h = l.shift();
                    p = p.then(f, h)
                }
                return p.success = function (e) {
                    return p.then(function (t) {
                        e(t.data, t.status, t.headers, a)
                    }), p
                }, p.error = function (e) {
                    return p.then(null, function (t) {
                        e(t.data, t.status, t.headers, a)
                    }), p
                }, p
            }

            function h() {
                o(arguments, function (e) {
                    f[e] = function (t, n) {
                        return f(d(n || {}, {method: e, url: t}))
                    }
                })
            }

            function m() {
                o(arguments, function (e) {
                    f[e] = function (t, n, r) {
                        return f(d(r || {}, {method: e, url: t, data: n}))
                    }
                })
            }

            function g(r, o, s) {
                function c(e, n, r, i) {
                    function o() {
                        d(n, e, r, i)
                    }

                    h && (sn(e) ? h.put(w, [e, n, rn(r), i]) : h.remove(w)), t ? l.$applyAsync(o) : (o(), l.$$phase || l.$apply())
                }

                function d(e, t, n, i) {
                    t = Math.max(t, 0), (sn(t) ? g.resolve : g.reject)({
                        data: e,
                        status: t,
                        headers: on(n),
                        config: r,
                        statusText: i
                    })
                }

                function p() {
                    var e = f.pendingRequests.indexOf(r);
                    -1 !== e && f.pendingRequests.splice(e, 1)
                }

                var h, m, g = u.defer(), b = g.promise, w = $(r.url, r.params);
                if (f.pendingRequests.push(r), b.then(p, p), !r.cache && !e.cache || r.cache === !1 || "GET" !== r.method && "JSONP" !== r.method || (h = y(r.cache) ? r.cache : y(e.cache) ? e.cache : S), h)if (m = h.get(w), _(m)) {
                    if (M(m))return m.then(p, p), m;
                    ii(m) ? d(m[1], m[0], N(m[2]), m[3]) : d(m, 200, {}, "OK")
                } else h.put(w, b);
                if (v(m)) {
                    var x = tr(r.url) ? a.cookies()[r.xsrfCookieName || e.xsrfCookieName] : n;
                    x && (s[r.xsrfHeaderName || e.xsrfHeaderName] = x), i(r.method, w, o, c, s, r.timeout, r.withCredentials, r.responseType)
                }
                return b
            }

            function $(e, t) {
                if (!t)return e;
                var n = [];
                return s(t, function (e, t) {
                    null === e || v(e) || (ii(e) || (e = [e]), o(e, function (e) {
                        y(e) && (e = w(e) ? e.toISOString() : F(e)), n.push(Y(t) + "=" + Y(e))
                    }))
                }), n.length > 0 && (e += (-1 == e.indexOf("?") ? "?" : "&") + n.join("&")), e
            }

            var S = c("$http"), C = [];
            return o(r, function (e) {
                C.unshift(b(e) ? p.get(e) : p.invoke(e))
            }), f.pendingRequests = [], h("get", "delete", "head", "jsonp"), m("post", "put", "patch"), f.defaults = e, f
        }]
    }

    function ln() {
        return new e.XMLHttpRequest
    }

    function un() {
        this.$get = ["$browser", "$window", "$document", function (e, t, n) {
            return dn(e, ln, e.defer, t.angular.callbacks, n[0])
        }]
    }

    function dn(e, t, n, r, i) {
        function a(e, t, n) {
            var o = i.createElement("script"), a = null;
            return o.type = "text/javascript", o.src = e, o.async = !0, a = function (e) {
                bi(o, "load", a), bi(o, "error", a), i.body.removeChild(o), o = null;
                var s = -1, c = "unknown";
                e && ("load" !== e.type || r[t].called || (e = {type: "error"}), c = e.type, s = "error" === e.type ? 404 : 200), n && n(s, c)
            }, yi(o, "load", a), yi(o, "error", a), i.body.appendChild(o), a
        }

        return function (i, s, c, l, u, d, p, f) {
            function m() {
                y && y(), b && b.abort()
            }

            function g(t, r, i, o, a) {
                x && n.cancel(x), y = b = null, t(r, i, o, a), e.$$completeOutstandingRequest(h)
            }

            if (e.$$incOutstandingRequestCount(), s = s || e.url(), "jsonp" == Br(i)) {
                var v = "_" + (r.counter++).toString(36);
                r[v] = function (e) {
                    r[v].data = e, r[v].called = !0
                };
                var y = a(s.replace("JSON_CALLBACK", "angular.callbacks." + v), v, function (e, t) {
                    g(l, e, r[v].data, "", t), r[v] = h
                })
            } else {
                var b = t();
                b.open(i, s, !0), o(u, function (e, t) {
                    _(e) && b.setRequestHeader(t, e)
                }), b.onload = function () {
                    var e = b.statusText || "", t = "response"in b ? b.response : b.responseText, n = 1223 === b.status ? 204 : b.status;
                    0 === n && (n = t ? 200 : "file" == er(s).protocol ? 404 : 0), g(l, n, t, b.getAllResponseHeaders(), e)
                };
                var $ = function () {
                    g(l, -1, null, null, "")
                };
                if (b.onerror = $, b.onabort = $, p && (b.withCredentials = !0), f)try {
                    b.responseType = f
                } catch (w) {
                    if ("json" !== f)throw w
                }
                b.send(c || null)
            }
            if (d > 0)var x = n(m, d); else M(d) && d.then(m)
        }
    }

    function pn() {
        var e = "{{", t = "}}";
        this.startSymbol = function (t) {
            return t ? (e = t, this) : e
        }, this.endSymbol = function (e) {
            return e ? (t = e, this) : t
        }, this.$get = ["$parse", "$exceptionHandler", "$sce", function (n, r, i) {
            function o(e) {
                return "\\\\\\" + e
            }

            function a(o, a, p, f) {
                function h(n) {
                    return n.replace(l, e).replace(u, t)
                }

                function m(e) {
                    try {
                        return e = A(e), f && !_(e) ? e : M(e)
                    } catch (t) {
                        var n = Xi("interr", "Can't interpolate: {0}\n{1}", o, t.toString());
                        r(n)
                    }
                }

                f = !!f;
                for (var g, y, b, $ = 0, w = [], S = [], C = o.length, k = [], T = []; C > $;) {
                    if (-1 == (g = o.indexOf(e, $)) || -1 == (y = o.indexOf(t, g + s))) {
                        $ !== C && k.push(h(o.substring($)));
                        break
                    }
                    $ !== g && k.push(h(o.substring($, g))), b = o.substring(g + s, y), w.push(b), S.push(n(b, m)), $ = y + c, T.push(k.length), k.push("")
                }
                if (p && k.length > 1)throw Xi("noconcat", "Error while interpolating: {0}\nStrict Contextual Escaping disallows interpolations that concatenate multiple expressions when a trusted value is required.  See http://docs.angularjs.org/api/ng.$sce", o);
                if (!a || w.length) {
                    var E = function (e) {
                        for (var t = 0, n = w.length; n > t; t++) {
                            if (f && v(e[t]))return;
                            k[T[t]] = e[t]
                        }
                        return k.join("")
                    }, A = function (e) {
                        return p ? i.getTrusted(p, e) : i.valueOf(e)
                    }, M = function (e) {
                        if (null == e)return "";
                        switch (typeof e) {
                            case"string":
                                break;
                            case"number":
                                e = "" + e;
                                break;
                            default:
                                e = F(e)
                        }
                        return e
                    };
                    return d(function (e) {
                        var t = 0, n = w.length, i = new Array(n);
                        try {
                            for (; n > t; t++)i[t] = S[t](e);
                            return E(i)
                        } catch (a) {
                            var s = Xi("interr", "Can't interpolate: {0}\n{1}", o, a.toString());
                            r(s)
                        }
                    }, {
                        exp: o, expressions: w, $$watchDelegate: function (e, t, n) {
                            var r;
                            return e.$watchGroup(S, function (n, i) {
                                var o = E(n);
                                x(t) && t.call(this, o, n !== i ? r : o, e), r = o
                            }, n)
                        }
                    })
                }
            }

            var s = e.length, c = t.length, l = new RegExp(e.replace(/./g, o), "g"), u = new RegExp(t.replace(/./g, o), "g");
            return a.startSymbol = function () {
                return e
            }, a.endSymbol = function () {
                return t
            }, a
        }]
    }

    function fn() {
        this.$get = ["$rootScope", "$window", "$q", "$$q", function (e, t, n, r) {
            function i(i, a, s, c) {
                var l = t.setInterval, u = t.clearInterval, d = 0, p = _(c) && !c, f = (p ? r : n).defer(), h = f.promise;
                return s = _(s) ? s : 0, h.then(null, null, i), h.$$intervalId = l(function () {
                    f.notify(d++), s > 0 && d >= s && (f.resolve(d), u(h.$$intervalId), delete o[h.$$intervalId]), p || e.$apply()
                }, a), o[h.$$intervalId] = f, h
            }

            var o = {};
            return i.cancel = function (e) {
                return e && e.$$intervalId in o ? (o[e.$$intervalId].reject("canceled"), t.clearInterval(e.$$intervalId), delete o[e.$$intervalId], !0) : !1
            }, i
        }]
    }

    function hn() {
        this.$get = function () {
            return {
                id: "en-us",
                NUMBER_FORMATS: {
                    DECIMAL_SEP: ".",
                    GROUP_SEP: ",",
                    PATTERNS: [{
                        minInt: 1,
                        minFrac: 0,
                        maxFrac: 3,
                        posPre: "",
                        posSuf: "",
                        negPre: "-",
                        negSuf: "",
                        gSize: 3,
                        lgSize: 3
                    }, {
                        minInt: 1,
                        minFrac: 2,
                        maxFrac: 2,
                        posPre: "\xa4",
                        posSuf: "",
                        negPre: "(\xa4",
                        negSuf: ")",
                        gSize: 3,
                        lgSize: 3
                    }],
                    CURRENCY_SYM: "$"
                },
                DATETIME_FORMATS: {
                    MONTH: "January,February,March,April,May,June,July,August,September,October,November,December".split(","),
                    SHORTMONTH: "Jan,Feb,Mar,Apr,May,Jun,Jul,Aug,Sep,Oct,Nov,Dec".split(","),
                    DAY: "Sunday,Monday,Tuesday,Wednesday,Thursday,Friday,Saturday".split(","),
                    SHORTDAY: "Sun,Mon,Tue,Wed,Thu,Fri,Sat".split(","),
                    AMPMS: ["AM", "PM"],
                    medium: "MMM d, y h:mm:ss a",
                    "short": "M/d/yy h:mm a",
                    fullDate: "EEEE, MMMM d, y",
                    longDate: "MMMM d, y",
                    mediumDate: "MMM d, y",
                    shortDate: "M/d/yy",
                    mediumTime: "h:mm:ss a",
                    shortTime: "h:mm a"
                },
                pluralCat: function (e) {
                    return 1 === e ? "one" : "other"
                }
            }
        }
    }

    function mn(e) {
        for (var t = e.split("/"), n = t.length; n--;)t[n] = X(t[n]);
        return t.join("/")
    }

    function gn(e, t) {
        var n = er(e);
        t.$$protocol = n.protocol, t.$$host = n.hostname, t.$$port = p(n.port) || Qi[n.protocol] || null
    }

    function vn(e, t) {
        var n = "/" !== e.charAt(0);
        n && (e = "/" + e);
        var r = er(e);
        t.$$path = decodeURIComponent(n && "/" === r.pathname.charAt(0) ? r.pathname.substring(1) : r.pathname), t.$$search = W(r.search), t.$$hash = decodeURIComponent(r.hash), t.$$path && "/" != t.$$path.charAt(0) && (t.$$path = "/" + t.$$path)
    }

    function _n(e, t) {
        return 0 === t.indexOf(e) ? t.substr(e.length) : void 0
    }

    function yn(e) {
        var t = e.indexOf("#");
        return -1 == t ? e : e.substr(0, t)
    }

    function bn(e) {
        return e.substr(0, yn(e).lastIndexOf("/") + 1)
    }

    function $n(e) {
        return e.substring(0, e.indexOf("/", e.indexOf("//") + 2))
    }

    function wn(e, t) {
        this.$$html5 = !0, t = t || "";
        var r = bn(e);
        gn(e, this), this.$$parse = function (e) {
            var t = _n(r, e);
            if (!b(t))throw Ki("ipthprfx", 'Invalid url "{0}", missing path prefix "{1}".', e, r);
            vn(t, this), this.$$path || (this.$$path = "/"), this.$$compose()
        }, this.$$compose = function () {
            var e = G(this.$$search), t = this.$$hash ? "#" + X(this.$$hash) : "";
            this.$$url = mn(this.$$path) + (e ? "?" + e : "") + t, this.$$absUrl = r + this.$$url.substr(1)
        }, this.$$parseLinkUrl = function (i, o) {
            if (o && "#" === o[0])return this.hash(o.slice(1)), !0;
            var a, s, c;
            return (a = _n(e, i)) !== n ? (s = a, c = (a = _n(t, a)) !== n ? r + (_n("/", a) || a) : e + s) : (a = _n(r, i)) !== n ? c = r + a : r == i + "/" && (c = r), c && this.$$parse(c), !!c
        }
    }

    function xn(e, t) {
        var n = bn(e);
        gn(e, this), this.$$parse = function (r) {
            function i(e, t, n) {
                var r, i = /^\/[A-Z]:(\/.*)/;
                return 0 === t.indexOf(n) && (t = t.replace(n, "")), i.exec(t) ? e : (r = i.exec(e), r ? r[1] : e)
            }

            var o = _n(e, r) || _n(n, r), a = "#" == o.charAt(0) ? _n(t, o) : this.$$html5 ? o : "";
            if (!b(a))throw Ki("ihshprfx", 'Invalid url "{0}", missing hash prefix "{1}".', r, t);
            vn(a, this), this.$$path = i(this.$$path, a, e), this.$$compose()
        }, this.$$compose = function () {
            var n = G(this.$$search), r = this.$$hash ? "#" + X(this.$$hash) : "";
            this.$$url = mn(this.$$path) + (n ? "?" + n : "") + r, this.$$absUrl = e + (this.$$url ? t + this.$$url : "")
        }, this.$$parseLinkUrl = function (t) {
            return yn(e) == yn(t) ? (this.$$parse(t), !0) : !1
        }
    }

    function Sn(e, t) {
        this.$$html5 = !0, xn.apply(this, arguments);
        var n = bn(e);
        this.$$parseLinkUrl = function (r, i) {
            if (i && "#" === i[0])return this.hash(i.slice(1)), !0;
            var o, a;
            return e == yn(r) ? o = r : (a = _n(n, r)) ? o = e + t + a : n === r + "/" && (o = n), o && this.$$parse(o), !!o
        }, this.$$compose = function () {
            var n = G(this.$$search), r = this.$$hash ? "#" + X(this.$$hash) : "";
            this.$$url = mn(this.$$path) + (n ? "?" + n : "") + r, this.$$absUrl = e + t + this.$$url
        }
    }

    function Cn(e) {
        return function () {
            return this[e]
        }
    }

    function kn(e, t) {
        return function (n) {
            return v(n) ? this[e] : (this[e] = t(n), this.$$compose(), this)
        }
    }

    function Tn() {
        var t = "", n = {enabled: !1, requireBase: !0, rewriteLinks: !0};
        this.hashPrefix = function (e) {
            return _(e) ? (t = e, this) : t
        }, this.html5Mode = function (e) {
            return A(e) ? (n.enabled = e, this) : y(e) ? (A(e.enabled) && (n.enabled = e.enabled), A(e.requireBase) && (n.requireBase = e.requireBase), A(e.rewriteLinks) && (n.rewriteLinks = e.rewriteLinks), this) : n
        }, this.$get = ["$rootScope", "$browser", "$sniffer", "$rootElement", function (r, i, o, a) {
            function s(e, t, n) {
                var r = l.url(), o = l.$$state;
                try {
                    i.url(e, t, n), l.$$state = i.state()
                } catch (a) {
                    throw l.url(r), l.$$state = o, a
                }
            }

            function c(e, t) {
                r.$broadcast("$locationChangeSuccess", l.absUrl(), e, l.$$state, t)
            }

            var l, u, d, p = i.baseHref(), f = i.url();
            if (n.enabled) {
                if (!p && n.requireBase)throw Ki("nobase", "$location in HTML5 mode requires a <base> tag to be present!");
                d = $n(f) + (p || "/"), u = o.history ? wn : Sn
            } else d = yn(f), u = xn;
            l = new u(d, "#" + t), l.$$parseLinkUrl(f, f), l.$$state = i.state();
            var h = /^\s*(javascript|mailto):/i;
            a.on("click", function (t) {
                if (n.rewriteLinks && !t.ctrlKey && !t.metaKey && 2 != t.which) {
                    for (var o = Gr(t.target); "a" !== L(o[0]);)if (o[0] === a[0] || !(o = o.parent())[0])return;
                    var s = o.prop("href"), c = o.attr("href") || o.attr("xlink:href");
                    y(s) && "[object SVGAnimatedString]" === s.toString() && (s = er(s.animVal).href), h.test(s) || !s || o.attr("target") || t.isDefaultPrevented() || l.$$parseLinkUrl(s, c) && (t.preventDefault(), l.absUrl() != i.url() && (r.$apply(), e.angular["ff-684208-preventDefault"] = !0))
                }
            }), l.absUrl() != f && i.url(l.absUrl(), !0);
            var m = !0;
            return i.onUrlChange(function (e, t) {
                r.$evalAsync(function () {
                    var n, i = l.absUrl(), o = l.$$state;
                    l.$$parse(e), l.$$state = t, n = r.$broadcast("$locationChangeStart", e, i, t, o).defaultPrevented, l.absUrl() === e && (n ? (l.$$parse(i), l.$$state = o, s(i, !1, o)) : (m = !1, c(i, o)))
                }), r.$$phase || r.$digest()
            }), r.$watch(function () {
                var e = i.url(), t = i.state(), n = l.$$replace, a = e !== l.absUrl() || l.$$html5 && o.history && t !== l.$$state;
                (m || a) && (m = !1, r.$evalAsync(function () {
                    var i = l.absUrl(), o = r.$broadcast("$locationChangeStart", i, e, l.$$state, t).defaultPrevented;
                    l.absUrl() === i && (o ? (l.$$parse(e), l.$$state = t) : (a && s(i, n, t === l.$$state ? null : l.$$state), c(e, t)))
                })), l.$$replace = !1
            }), l
        }]
    }

    function En() {
        var e = !0, t = this;
        this.debugEnabled = function (t) {
            return _(t) ? (e = t, this) : e
        }, this.$get = ["$window", function (n) {
            function r(e) {
                return e instanceof Error && (e.stack ? e = e.message && -1 === e.stack.indexOf(e.message) ? "Error: " + e.message + "\n" + e.stack : e.stack : e.sourceURL && (e = e.message + "\n" + e.sourceURL + ":" + e.line)), e
            }

            function i(e) {
                var t = n.console || {}, i = t[e] || t.log || h, a = !1;
                try {
                    a = !!i.apply
                } catch (s) {
                }
                return a ? function () {
                    var e = [];
                    return o(arguments, function (t) {
                        e.push(r(t))
                    }), i.apply(t, e)
                } : function (e, t) {
                    i(e, null == t ? "" : t)
                }
            }

            return {
                log: i("log"), info: i("info"), warn: i("warn"), error: i("error"), debug: function () {
                    var n = i("debug");
                    return function () {
                        e && n.apply(t, arguments)
                    }
                }()
            }
        }]
    }

    function An(e, t) {
        if ("__defineGetter__" === e || "__defineSetter__" === e || "__lookupGetter__" === e || "__lookupSetter__" === e || "__proto__" === e)throw Zi("isecfld", "Attempting to access a disallowed field in Angular expressions! Expression: {0}", t);
        return e
    }

    function Mn(e, t) {
        if (e) {
            if (e.constructor === e)throw Zi("isecfn", "Referencing Function in Angular expressions is disallowed! Expression: {0}", t);
            if (e.window === e)throw Zi("isecwindow", "Referencing the Window in Angular expressions is disallowed! Expression: {0}", t);
            if (e.children && (e.nodeName || e.prop && e.attr && e.find))throw Zi("isecdom", "Referencing DOM nodes in Angular expressions is disallowed! Expression: {0}", t);
            if (e === Object)throw Zi("isecobj", "Referencing Object in Angular expressions is disallowed! Expression: {0}", t)
        }
        return e
    }

    function Dn(e, t) {
        if (e) {
            if (e.constructor === e)throw Zi("isecfn", "Referencing Function in Angular expressions is disallowed! Expression: {0}", t);
            if (e === eo || e === to || e === no)throw Zi("isecff", "Referencing call, apply or bind in Angular expressions is disallowed! Expression: {0}", t)
        }
    }

    function qn(e) {
        return e.constant
    }

    function Ln(e, t, n, r) {
        Mn(e, r);
        for (var i, o = t.split("."), a = 0; o.length > 1; a++) {
            i = An(o.shift(), r);
            var s = Mn(e[i], r);
            s || (s = {}, e[i] = s), e = s
        }
        return i = An(o.shift(), r), Mn(e[i], r), e[i] = n, n
    }

    function On(e) {
        return "constructor" == e
    }

    function Pn(e, t, r, i, o, a, s) {
        An(e, a), An(t, a), An(r, a), An(i, a), An(o, a);
        var c = function (e) {
            return Mn(e, a)
        }, l = s || On(e) ? c : m, u = s || On(t) ? c : m, d = s || On(r) ? c : m, p = s || On(i) ? c : m, f = s || On(o) ? c : m;
        return function (a, s) {
            var c = s && s.hasOwnProperty(e) ? s : a;
            return null == c ? c : (c = l(c[e]), t ? null == c ? n : (c = u(c[t]), r ? null == c ? n : (c = d(c[r]), i ? null == c ? n : (c = p(c[i]), o ? null == c ? n : c = f(c[o]) : c) : c) : c) : c)
        }
    }

    function Nn(e, t) {
        return function (n, r) {
            return e(n, r, Mn, t)
        }
    }

    function jn(e, t, r) {
        var i = t.expensiveChecks, a = i ? lo : co, s = a[e];
        if (s)return s;
        var c = e.split("."), l = c.length;
        if (t.csp)s = 6 > l ? Pn(c[0], c[1], c[2], c[3], c[4], r, i) : function (e, t) {
            var o, a = 0;
            do o = Pn(c[a++], c[a++], c[a++], c[a++], c[a++], r, i)(e, t), t = n, e = o; while (l > a);
            return o
        }; else {
            var u = "";
            i && (u += "s = eso(s, fe);\nl = eso(l, fe);\n");
            var d = i;
            o(c, function (e, t) {
                An(e, r);
                var n = (t ? "s" : '((l&&l.hasOwnProperty("' + e + '"))?l:s)') + "." + e;
                (i || On(e)) && (n = "eso(" + n + ", fe)", d = !0), u += "if(s == null) return undefined;\ns=" + n + ";\n"
            }), u += "return s;";
            var p = new Function("s", "l", "eso", "fe", u);
            p.toString = g(u), d && (p = Nn(p, r)), s = p
        }
        return s.sharedGetter = !0, s.assign = function (t, n) {
            return Ln(t, e, n, e)
        }, a[e] = s, s
    }

    function Rn(e) {
        return x(e.valueOf) ? e.valueOf() : uo.call(e)
    }

    function In() {
        var e = ct(), t = ct();
        this.$get = ["$filter", "$sniffer", function (n, r) {
            function i(e) {
                var t = e;
                return e.sharedGetter && (t = function (t, n) {
                    return e(t, n)
                }, t.literal = e.literal, t.constant = e.constant, t.assign = e.assign), t
            }

            function a(e, t) {
                for (var n = 0, r = e.length; r > n; n++) {
                    var i = e[n];
                    i.constant || (i.inputs ? a(i.inputs, t) : -1 === t.indexOf(i) && t.push(i))
                }
                return t
            }

            function s(e, t) {
                return null == e || null == t ? e === t : "object" == typeof e && (e = Rn(e), "object" == typeof e) ? !1 : e === t || e !== e && t !== t
            }

            function c(e, t, n, r) {
                var i, o = r.$$inputs || (r.$$inputs = a(r.inputs, []));
                if (1 === o.length) {
                    var c = s;
                    return o = o[0], e.$watch(function (e) {
                        var t = o(e);
                        return s(t, c) || (i = r(e), c = t && Rn(t)), i
                    }, t, n)
                }
                for (var l = [], u = 0, d = o.length; d > u; u++)l[u] = s;
                return e.$watch(function (e) {
                    for (var t = !1, n = 0, a = o.length; a > n; n++) {
                        var c = o[n](e);
                        (t || (t = !s(c, l[n]))) && (l[n] = c && Rn(c))
                    }
                    return t && (i = r(e)), i
                }, t, n)
            }

            function l(e, t, n, r) {
                var i, o;
                return i = e.$watch(function (e) {
                    return r(e)
                }, function (e, n, r) {
                    o = e, x(t) && t.apply(this, arguments), _(e) && r.$$postDigest(function () {
                        _(o) && i()
                    })
                }, n)
            }

            function u(e, t, n, r) {
                function i(e) {
                    var t = !0;
                    return o(e, function (e) {
                        _(e) || (t = !1)
                    }), t
                }

                var a, s;
                return a = e.$watch(function (e) {
                    return r(e)
                }, function (e, n, r) {
                    s = e, x(t) && t.call(this, e, n, r), i(e) && r.$$postDigest(function () {
                        i(s) && a()
                    })
                }, n)
            }

            function d(e, t, n, r) {
                var i;
                return i = e.$watch(function (e) {
                    return r(e)
                }, function () {
                    x(t) && t.apply(this, arguments), i()
                }, n)
            }

            function p(e, t) {
                if (!t)return e;
                var n = e.$$watchDelegate, r = n !== u && n !== l, i = r ? function (n, r) {
                    var i = e(n, r);
                    return t(i, n, r)
                } : function (n, r) {
                    var i = e(n, r), o = t(i, n, r);
                    return _(i) ? o : i
                };
                return e.$$watchDelegate && e.$$watchDelegate !== c ? i.$$watchDelegate = e.$$watchDelegate : t.$stateful || (i.$$watchDelegate = c, i.inputs = [e]), i
            }

            var f = {csp: r.csp, expensiveChecks: !1}, m = {csp: r.csp, expensiveChecks: !0};
            return function (r, o, a) {
                var s, g, v;
                switch (typeof r) {
                    case"string":
                        v = r = r.trim();
                        var _ = a ? t : e;
                        if (s = _[v], !s) {
                            ":" === r.charAt(0) && ":" === r.charAt(1) && (g = !0, r = r.substring(2));
                            var y = a ? m : f, b = new ao(y), $ = new so(b, n, y);
                            s = $.parse(r), s.constant ? s.$$watchDelegate = d : g ? (s = i(s), s.$$watchDelegate = s.literal ? u : l) : s.inputs && (s.$$watchDelegate = c), _[v] = s
                        }
                        return p(s, o);
                    case"function":
                        return p(r, o);
                    default:
                        return p(h, o)
                }
            }
        }]
    }

    function Un() {
        this.$get = ["$rootScope", "$exceptionHandler", function (e, t) {
            return Fn(function (t) {
                e.$evalAsync(t)
            }, t)
        }]
    }

    function Bn() {
        this.$get = ["$browser", "$exceptionHandler", function (e, t) {
            return Fn(function (t) {
                e.defer(t)
            }, t)
        }]
    }

    function Fn(e, t) {
        function i(e, t, n) {
            function r(t) {
                return function (n) {
                    i || (i = !0, t.call(e, n))
                }
            }

            var i = !1;
            return [r(t), r(n)]
        }

        function a() {
            this.$$state = {status: 0}
        }

        function s(e, t) {
            return function (n) {
                t.call(e, n)
            }
        }

        function c(e) {
            var r, i, o;
            o = e.pending, e.processScheduled = !1, e.pending = n;
            for (var a = 0, s = o.length; s > a; ++a) {
                i = o[a][0], r = o[a][e.status];
                try {
                    x(r) ? i.resolve(r(e.value)) : 1 === e.status ? i.resolve(e.value) : i.reject(e.value)
                } catch (c) {
                    i.reject(c), t(c)
                }
            }
        }

        function l(t) {
            !t.processScheduled && t.pending && (t.processScheduled = !0, e(function () {
                c(t)
            }))
        }

        function u() {
            this.promise = new a, this.resolve = s(this, this.resolve), this.reject = s(this, this.reject), this.notify = s(this, this.notify)
        }

        function d(e) {
            var t = new u, n = 0, r = ii(e) ? [] : {};
            return o(e, function (e, i) {
                n++, v(e).then(function (e) {
                    r.hasOwnProperty(i) || (r[i] = e, --n || t.resolve(r))
                }, function (e) {
                    r.hasOwnProperty(i) || t.reject(e)
                })
            }), 0 === n && t.resolve(r), t.promise
        }

        var p = r("$q", TypeError), f = function () {
            return new u
        };
        a.prototype = {
            then: function (e, t, n) {
                var r = new u;
                return this.$$state.pending = this.$$state.pending || [], this.$$state.pending.push([r, e, t, n]), this.$$state.status > 0 && l(this.$$state), r.promise
            }, "catch": function (e) {
                return this.then(null, e)
            }, "finally": function (e, t) {
                return this.then(function (t) {
                    return g(t, !0, e)
                }, function (t) {
                    return g(t, !1, e)
                }, t)
            }
        }, u.prototype = {
            resolve: function (e) {
                this.promise.$$state.status || (e === this.promise ? this.$$reject(p("qcycle", "Expected promise to be resolved with value other than itself '{0}'", e)) : this.$$resolve(e))
            }, $$resolve: function (e) {
                var n, r;
                r = i(this, this.$$resolve, this.$$reject);
                try {
                    (y(e) || x(e)) && (n = e && e.then), x(n) ? (this.promise.$$state.status = -1, n.call(e, r[0], r[1], this.notify)) : (this.promise.$$state.value = e, this.promise.$$state.status = 1, l(this.promise.$$state))
                } catch (o) {
                    r[1](o), t(o)
                }
            }, reject: function (e) {
                this.promise.$$state.status || this.$$reject(e)
            }, $$reject: function (e) {
                this.promise.$$state.value = e, this.promise.$$state.status = 2, l(this.promise.$$state)
            }, notify: function (n) {
                var r = this.promise.$$state.pending;
                this.promise.$$state.status <= 0 && r && r.length && e(function () {
                    for (var e, i, o = 0, a = r.length; a > o; o++) {
                        i = r[o][0], e = r[o][3];
                        try {
                            i.notify(x(e) ? e(n) : n)
                        } catch (s) {
                            t(s)
                        }
                    }
                })
            }
        };
        var h = function (e) {
            var t = new u;
            return t.reject(e), t.promise
        }, m = function (e, t) {
            var n = new u;
            return t ? n.resolve(e) : n.reject(e), n.promise
        }, g = function (e, t, n) {
            var r = null;
            try {
                x(n) && (r = n())
            } catch (i) {
                return m(i, !1)
            }
            return M(r) ? r.then(function () {
                return m(e, t)
            }, function (e) {
                return m(e, !1)
            }) : m(e, t)
        }, v = function (e, t, n, r) {
            var i = new u;
            return i.resolve(e), i.promise.then(t, n, r)
        }, _ = function b(e) {
            function t(e) {
                r.resolve(e)
            }

            function n(e) {
                r.reject(e)
            }

            if (!x(e))throw p("norslvr", "Expected resolverFn, got '{0}'", e);
            if (!(this instanceof b))return new b(e);
            var r = new u;
            return e(t, n), r.promise
        };
        return _.defer = f, _.reject = h, _.when = v, _.all = d, _
    }

    function Hn() {
        this.$get = ["$window", "$timeout", function (e, t) {
            var n = e.requestAnimationFrame || e.webkitRequestAnimationFrame || e.mozRequestAnimationFrame, r = e.cancelAnimationFrame || e.webkitCancelAnimationFrame || e.mozCancelAnimationFrame || e.webkitCancelRequestAnimationFrame, i = !!n, o = i ? function (e) {
                var t = n(e);
                return function () {
                    r(t)
                }
            } : function (e) {
                var n = t(e, 16.66, !1);
                return function () {
                    t.cancel(n)
                }
            };
            return o.supported = i, o
        }]
    }

    function zn() {
        var e = 10, t = r("$rootScope"), n = null, a = null;
        this.digestTtl = function (t) {
            return arguments.length && (e = t), e
        }, this.$get = ["$injector", "$exceptionHandler", "$parse", "$browser", function (r, s, c, u) {
            function d() {
                this.$id = l(), this.$$phase = this.$parent = this.$$watchers = this.$$nextSibling = this.$$prevSibling = this.$$childHead = this.$$childTail = null, this.$root = this, this.$$destroyed = !1, this.$$listeners = {}, this.$$listenerCount = {}, this.$$isolateBindings = null
            }

            function p(e) {
                if ($.$$phase)throw t("inprog", "{0} already in progress", $.$$phase);
                $.$$phase = e
            }

            function f() {
                $.$$phase = null
            }

            function m(e, t, n) {
                do e.$$listenerCount[n] -= t, 0 === e.$$listenerCount[n] && delete e.$$listenerCount[n]; while (e = e.$parent)
            }

            function g() {
            }

            function _() {
                for (; C.length;)try {
                    C.shift()()
                } catch (e) {
                    s(e)
                }
                a = null
            }

            function b() {
                null === a && (a = u.defer(function () {
                    $.$apply(_)
                }))
            }

            d.prototype = {
                constructor: d, $new: function (e, t) {
                    function n() {
                        r.$$destroyed = !0
                    }

                    var r;
                    return t = t || this, e ? (r = new d, r.$root = this.$root) : (this.$$ChildScope || (this.$$ChildScope = function () {
                        this.$$watchers = this.$$nextSibling = this.$$childHead = this.$$childTail = null, this.$$listeners = {}, this.$$listenerCount = {}, this.$id = l(), this.$$ChildScope = null
                    }, this.$$ChildScope.prototype = this), r = new this.$$ChildScope), r.$parent = t, r.$$prevSibling = t.$$childTail, t.$$childHead ? (t.$$childTail.$$nextSibling = r, t.$$childTail = r) : t.$$childHead = t.$$childTail = r, (e || t != this) && r.$on("$destroy", n), r
                }, $watch: function (e, t, r) {
                    var i = c(e);
                    if (i.$$watchDelegate)return i.$$watchDelegate(this, t, r, i);
                    var o = this, a = o.$$watchers, s = {fn: t, last: g, get: i, exp: e, eq: !!r};
                    return n = null, x(t) || (s.fn = h), a || (a = o.$$watchers = []), a.unshift(s), function () {
                        O(a, s), n = null
                    }
                }, $watchGroup: function (e, t) {
                    function n() {
                        c = !1, l ? (l = !1, t(i, i, s)) : t(i, r, s)
                    }

                    var r = new Array(e.length), i = new Array(e.length), a = [], s = this, c = !1, l = !0;
                    if (!e.length) {
                        var u = !0;
                        return s.$evalAsync(function () {
                            u && t(i, i, s)
                        }), function () {
                            u = !1
                        }
                    }
                    return 1 === e.length ? this.$watch(e[0], function (e, n, o) {
                        i[0] = e, r[0] = n, t(i, e === n ? i : r, o)
                    }) : (o(e, function (e, t) {
                        var o = s.$watch(e, function (e, o) {
                            i[t] = e, r[t] = o, c || (c = !0, s.$evalAsync(n))
                        });
                        a.push(o)
                    }), function () {
                        for (; a.length;)a.shift()()
                    })
                }, $watchCollection: function (e, t) {
                    function n(e) {
                        o = e;
                        var t, n, r, s, c;
                        if (!v(o)) {
                            if (y(o))if (i(o)) {
                                a !== f && (a = f, g = a.length = 0, d++), t = o.length, g !== t && (d++, a.length = g = t);
                                for (var l = 0; t > l; l++)c = a[l], s = o[l], r = c !== c && s !== s, r || c === s || (d++, a[l] = s)
                            } else {
                                a !== h && (a = h = {}, g = 0, d++), t = 0;
                                for (n in o)o.hasOwnProperty(n) && (t++, s = o[n], c = a[n], n in a ? (r = c !== c && s !== s, r || c === s || (d++, a[n] = s)) : (g++, a[n] = s, d++));
                                if (g > t) {
                                    d++;
                                    for (n in a)o.hasOwnProperty(n) || (g--, delete a[n])
                                }
                            } else a !== o && (a = o, d++);
                            return d
                        }
                    }

                    function r() {
                        if (m ? (m = !1, t(o, o, l)) : t(o, s, l), u)if (y(o))if (i(o)) {
                            s = new Array(o.length);
                            for (var e = 0; e < o.length; e++)s[e] = o[e]
                        } else {
                            s = {};
                            for (var n in o)Fr.call(o, n) && (s[n] = o[n])
                        } else s = o
                    }

                    n.$stateful = !0;
                    var o, a, s, l = this, u = t.length > 1, d = 0, p = c(e, n), f = [], h = {}, m = !0, g = 0;
                    return this.$watch(p, r)
                }, $digest: function () {
                    var r, i, o, c, l, d, h, m, v, y, b = e, C = this, k = [];
                    p("$digest"), u.$$checkUrlChange(), this === $ && null !== a && (u.defer.cancel(a), _()), n = null;
                    do {
                        for (d = !1, m = C; w.length;) {
                            try {
                                y = w.shift(), y.scope.$eval(y.expression)
                            } catch (T) {
                                s(T)
                            }
                            n = null
                        }
                        e:do {
                            if (c = m.$$watchers)for (l = c.length; l--;)try {
                                if (r = c[l])if ((i = r.get(m)) === (o = r.last) || (r.eq ? j(i, o) : "number" == typeof i && "number" == typeof o && isNaN(i) && isNaN(o))) {
                                    if (r === n) {
                                        d = !1;
                                        break e
                                    }
                                } else d = !0, n = r, r.last = r.eq ? P(i, null) : i, r.fn(i, o === g ? i : o, m), 5 > b && (v = 4 - b, k[v] || (k[v] = []), k[v].push({
                                    msg: x(r.exp) ? "fn: " + (r.exp.name || r.exp.toString()) : r.exp,
                                    newVal: i,
                                    oldVal: o
                                }))
                            } catch (T) {
                                s(T)
                            }
                            if (!(h = m.$$childHead || m !== C && m.$$nextSibling))for (; m !== C && !(h = m.$$nextSibling);)m = m.$parent
                        } while (m = h);
                        if ((d || w.length) && !b--)throw f(), t("infdig", "{0} $digest() iterations reached. Aborting!\nWatchers fired in the last 5 iterations: {1}", e, k)
                    } while (d || w.length);
                    for (f(); S.length;)try {
                        S.shift()()
                    } catch (T) {
                        s(T)
                    }
                }, $destroy: function () {
                    if (!this.$$destroyed) {
                        var e = this.$parent;
                        if (this.$broadcast("$destroy"), this.$$destroyed = !0, this !== $) {
                            for (var t in this.$$listenerCount)m(this, this.$$listenerCount[t], t);
                            e.$$childHead == this && (e.$$childHead = this.$$nextSibling), e.$$childTail == this && (e.$$childTail = this.$$prevSibling), this.$$prevSibling && (this.$$prevSibling.$$nextSibling = this.$$nextSibling), this.$$nextSibling && (this.$$nextSibling.$$prevSibling = this.$$prevSibling), this.$destroy = this.$digest = this.$apply = this.$evalAsync = this.$applyAsync = h, this.$on = this.$watch = this.$watchGroup = function () {
                                return h
                            }, this.$$listeners = {}, this.$parent = this.$$nextSibling = this.$$prevSibling = this.$$childHead = this.$$childTail = this.$root = this.$$watchers = null
                        }
                    }
                }, $eval: function (e, t) {
                    return c(e)(this, t)
                }, $evalAsync: function (e) {
                    $.$$phase || w.length || u.defer(function () {
                        w.length && $.$digest()
                    }), w.push({scope: this, expression: e})
                }, $$postDigest: function (e) {
                    S.push(e)
                }, $apply: function (e) {
                    try {
                        return p("$apply"), this.$eval(e)
                    } catch (t) {
                        s(t)
                    } finally {
                        f();
                        try {
                            //$.$digest()
                        } catch (t) {
                            throw s(t), t
                        }
                    }
                }, $applyAsync: function (e) {
                    function t() {
                        n.$eval(e)
                    }

                    var n = this;
                    e && C.push(t), b()
                }, $on: function (e, t) {
                    var n = this.$$listeners[e];
                    n || (this.$$listeners[e] = n = []), n.push(t);
                    var r = this;
                    do r.$$listenerCount[e] || (r.$$listenerCount[e] = 0), r.$$listenerCount[e]++; while (r = r.$parent);
                    var i = this;
                    return function () {
                        var r = n.indexOf(t);
                        -1 !== r && (n[r] = null, m(i, 1, e))
                    }
                }, $emit: function (e) {
                    var t, n, r, i = [], o = this, a = !1, c = {
                        name: e, targetScope: o, stopPropagation: function () {
                            a = !0
                        }, preventDefault: function () {
                            c.defaultPrevented = !0
                        }, defaultPrevented: !1
                    }, l = R([c], arguments, 1);
                    do {
                        for (t = o.$$listeners[e] || i, c.currentScope = o, n = 0, r = t.length; r > n; n++)if (t[n])try {
                            t[n].apply(null, l)
                        } catch (u) {
                            s(u)
                        } else t.splice(n, 1), n--, r--;
                        if (a)return c.currentScope = null, c;
                        o = o.$parent
                    } while (o);
                    return c.currentScope = null, c
                }, $broadcast: function (e) {
                    var t = this, n = t, r = t, i = {
                        name: e, targetScope: t, preventDefault: function () {
                            i.defaultPrevented = !0
                        }, defaultPrevented: !1
                    };
                    if (!t.$$listenerCount[e])return i;
                    for (var o, a, c, l = R([i], arguments, 1); n = r;) {
                        for (i.currentScope = n, o = n.$$listeners[e] || [], a = 0, c = o.length; c > a; a++)if (o[a])try {
                            o[a].apply(null, l)
                        } catch (u) {
                            s(u)
                        } else o.splice(a, 1), a--, c--;
                        if (!(r = n.$$listenerCount[e] && n.$$childHead || n !== t && n.$$nextSibling))for (; n !== t && !(r = n.$$nextSibling);)n = n.$parent
                    }
                    return i.currentScope = null, i
                }
            };
            var $ = new d, w = $.$$asyncQueue = [], S = $.$$postDigestQueue = [], C = $.$$applyAsyncQueue = [];
            return $
        }]
    }

    function Vn() {
        var e = /^\s*(https?|ftp|mailto|tel|file):/, t = /^\s*((https?|ftp|file|blob):|data:image\/)/;
        this.aHrefSanitizationWhitelist = function (t) {
            return _(t) ? (e = t, this) : e
        }, this.imgSrcSanitizationWhitelist = function (e) {
            return _(e) ? (t = e, this) : t
        }, this.$get = function () {
            return function (n, r) {
                var i, o = r ? t : e;
                return i = er(n).href, "" === i || i.match(o) ? n : "unsafe:" + i
            }
        }
    }

    function Wn(e) {
        if ("self" === e)return e;
        if (b(e)) {
            if (e.indexOf("***") > -1)throw po("iwcard", "Illegal sequence *** in string matcher.  String: {0}", e);
            return e = ai(e).replace("\\*\\*", ".*").replace("\\*", "[^:/.?&;]*"), new RegExp("^" + e + "$")
        }
        if (S(e))return new RegExp("^" + e.source + "$");
        throw po("imatcher", 'Matchers may only be "self", string patterns or RegExp objects')
    }

    function Gn(e) {
        var t = [];
        return _(e) && o(e, function (e) {
            t.push(Wn(e))
        }), t
    }

    function Xn() {
        this.SCE_CONTEXTS = fo;
        var e = ["self"], t = [];
        this.resourceUrlWhitelist = function (t) {
            return arguments.length && (e = Gn(t)), e
        }, this.resourceUrlBlacklist = function (e) {
            return arguments.length && (t = Gn(e)), t
        }, this.$get = ["$injector", function (r) {
            function i(e, t) {
                return "self" === e ? tr(t) : !!e.exec(t.href)
            }

            function o(n) {
                var r, o, a = er(n.toString()), s = !1;
                for (r = 0, o = e.length; o > r; r++)if (i(e[r], a)) {
                    s = !0;
                    break
                }
                if (s)for (r = 0, o = t.length; o > r; r++)if (i(t[r], a)) {
                    s = !1;
                    break
                }
                return s
            }

            function a(e) {
                var t = function (e) {
                    this.$$unwrapTrustedValue = function () {
                        return e
                    }
                };
                return e && (t.prototype = new e), t.prototype.valueOf = function () {
                    return this.$$unwrapTrustedValue()
                }, t.prototype.toString = function () {
                    return this.$$unwrapTrustedValue().toString()
                }, t
            }

            function s(e, t) {
                var r = p.hasOwnProperty(e) ? p[e] : null;
                if (!r)throw po("icontext", "Attempted to trust a value in invalid context. Context: {0}; Value: {1}", e, t);
                if (null === t || t === n || "" === t)return t;
                if ("string" != typeof t)throw po("itype", "Attempted to trust a non-string value in a content requiring a string: Context: {0}", e);
                return new r(t)
            }

            function c(e) {
                return e instanceof d ? e.$$unwrapTrustedValue() : e
            }

            function l(e, t) {
                if (null === t || t === n || "" === t)return t;
                var r = p.hasOwnProperty(e) ? p[e] : null;
                if (r && t instanceof r)return t.$$unwrapTrustedValue();
                if (e === fo.RESOURCE_URL) {
                    if (o(t))return t;
                    throw po("insecurl", "Blocked loading resource from url not allowed by $sceDelegate policy.  URL: {0}", t.toString())
                }
                if (e === fo.HTML)return u(t);
                throw po("unsafe", "Attempting to use an unsafe value in a safe context.")
            }

            var u = function () {
                throw po("unsafe", "Attempting to use an unsafe value in a safe context.")
            };
            r.has("$sanitize") && (u = r.get("$sanitize"));
            var d = a(), p = {};
            return p[fo.HTML] = a(d), p[fo.CSS] = a(d), p[fo.URL] = a(d), p[fo.JS] = a(d), p[fo.RESOURCE_URL] = a(p[fo.URL]), {
                trustAs: s,
                getTrusted: l,
                valueOf: c
            }
        }]
    }

    function Yn() {
        var e = !0;
        this.enabled = function (t) {
            return arguments.length && (e = !!t), e
        }, this.$get = ["$parse", "$sceDelegate", function (t, n) {
            if (e && 8 > Wr)throw po("iequirks", "Strict Contextual Escaping does not support Internet Explorer version < 11 in quirks mode.  You can fix this by adding the text <!doctype html> to the top of your HTML document.  See http://docs.angularjs.org/api/ng.$sce for more information.");
            var r = N(fo);
            r.isEnabled = function () {
                return e
            }, r.trustAs = n.trustAs, r.getTrusted = n.getTrusted, r.valueOf = n.valueOf, e || (r.trustAs = r.getTrusted = function (e, t) {
                return t
            }, r.valueOf = m), r.parseAs = function (e, n) {
                var i = t(n);
                return i.literal && i.constant ? i : t(n, function (t) {
                    return r.getTrusted(e, t)
                })
            };
            var i = r.parseAs, a = r.getTrusted, s = r.trustAs;
            return o(fo, function (e, t) {
                var n = Br(t);
                r[ht("parse_as_" + n)] = function (t) {
                    return i(e, t)
                }, r[ht("get_trusted_" + n)] = function (t) {
                    return a(e, t)
                }, r[ht("trust_as_" + n)] = function (t) {
                    return s(e, t)
                }
            }), r
        }]
    }

    function Qn() {
        this.$get = ["$window", "$document", function (e, t) {
            var n, r, i = {}, o = p((/android (\d+)/.exec(Br((e.navigator || {}).userAgent)) || [])[1]), a = /Boxee/i.test((e.navigator || {}).userAgent), s = t[0] || {}, c = /^(Moz|webkit|ms)(?=[A-Z])/, l = s.body && s.body.style, u = !1, d = !1;
            if (l) {
                for (var f in l)if (r = c.exec(f)) {
                    n = r[0], n = n.substr(0, 1).toUpperCase() + n.substr(1);
                    break
                }
                n || (n = "WebkitOpacity"in l && "webkit"), u = !!("transition"in l || n + "Transition"in l), d = !!("animation"in l || n + "Animation"in l), !o || u && d || (u = b(s.body.style.webkitTransition), d = b(s.body.style.webkitAnimation))
            }
            return {
                history: !(!e.history || !e.history.pushState || 4 > o || a), hasEvent: function (e) {
                    if ("input" == e && 9 == Wr)return !1;
                    if (v(i[e])) {
                        var t = s.createElement("div");
                        i[e] = "on" + e in t
                    }
                    return i[e]
                }, csp: si(), vendorPrefix: n, transitions: u, animations: d, android: o
            }
        }]
    }

    function Kn() {
        this.$get = ["$templateCache", "$http", "$q", function (e, t, n) {
            function r(i, o) {
                function a() {
                    if (s.totalPendingRequests--, !o)throw Bi("tpload", "Failed to load template: {0}", i);
                    return n.reject()
                }

                var s = r;
                s.totalPendingRequests++;
                var c = t.defaults && t.defaults.transformResponse;
                if (ii(c)) {
                    var l = c;
                    c = [];
                    for (var u = 0; u < l.length; ++u) {
                        var d = l[u];
                        d !== nn && c.push(d)
                    }
                } else c === nn && (c = null);
                var p = {cache: e, transformResponse: c};
                return t.get(i, p).then(function (t) {
                    var n = t.data;
                    return s.totalPendingRequests--, e.put(i, n), n
                }, a)
            }

            return r.totalPendingRequests = 0, r
        }]
    }

    function Jn() {
        this.$get = ["$rootScope", "$browser", "$location", function (e, t, n) {
            var r = {};
            return r.findBindings = function (e, t, n) {
                var r = e.getElementsByClassName("ng-binding"), i = [];
                return o(r, function (e) {
                    var r = ti.element(e).data("$binding");
                    r && o(r, function (r) {
                        if (n) {
                            var o = new RegExp("(^|\\s)" + ai(t) + "(\\s|\\||$)");
                            o.test(r) && i.push(e)
                        } else-1 != r.indexOf(t) && i.push(e)
                    })
                }), i
            }, r.findModels = function (e, t, n) {
                for (var r = ["ng-", "data-ng-", "ng\\:"], i = 0; i < r.length; ++i) {
                    var o = n ? "=" : "*=", a = "[" + r[i] + "model" + o + '"' + t + '"]', s = e.querySelectorAll(a);
                    if (s.length)return s
                }
            }, r.getLocation = function () {
                return n.url()
            }, r.setLocation = function (t) {
                t !== n.url() && (n.url(t), e.$digest())
            }, r.whenStable = function (e) {
                t.notifyWhenNoOutstandingRequests(e)
            }, r
        }]
    }

    function Zn() {
        this.$get = ["$rootScope", "$browser", "$q", "$$q", "$exceptionHandler", function (e, t, n, r, i) {
            function o(o, s, c) {
                var l, u = _(c) && !c, d = (u ? r : n).defer(), p = d.promise;
                return l = t.defer(function () {
                    try {
                        d.resolve(o())
                    } catch (t) {
                        d.reject(t), i(t)
                    } finally {
                        delete a[p.$$timeoutId]
                    }
                    u || e.$apply()
                }, s), p.$$timeoutId = l, a[l] = d, p
            }

            var a = {};
            return o.cancel = function (e) {
                return e && e.$$timeoutId in a ? (a[e.$$timeoutId].reject("canceled"), delete a[e.$$timeoutId], t.defer.cancel(e.$$timeoutId)) : !1
            }, o
        }]
    }

    function er(e) {
        var t = e;
        return Wr && (ho.setAttribute("href", t), t = ho.href), ho.setAttribute("href", t), {
            href: ho.href,
            protocol: ho.protocol ? ho.protocol.replace(/:$/, "") : "",
            host: ho.host,
            search: ho.search ? ho.search.replace(/^\?/, "") : "",
            hash: ho.hash ? ho.hash.replace(/^#/, "") : "",
            hostname: ho.hostname,
            port: ho.port,
            pathname: "/" === ho.pathname.charAt(0) ? ho.pathname : "/" + ho.pathname
        }
    }

    function tr(e) {
        var t = b(e) ? er(e) : e;
        return t.protocol === mo.protocol && t.host === mo.host
    }

    function nr() {
        this.$get = g(e)
    }

    function rr(e) {
        function t(r, i) {
            if (y(r)) {
                var a = {};
                return o(r, function (e, n) {
                    a[n] = t(n, e)
                }), a
            }
            return e.factory(r + n, i)
        }

        var n = "Filter";
        this.register = t, this.$get = ["$injector", function (e) {
            return function (t) {
                return e.get(t + n)
            }
        }], t("currency", or), t("date", gr), t("filter", ir), t("json", vr), t("limitTo", _r), t("lowercase", bo), t("number", ar), t("orderBy", yr), t("uppercase", $o)
    }

    function ir() {
        return function (e, t, n) {
            if (!ii(e))return e;
            var r = typeof n, i = [];
            i.check = function (e, t) {
                for (var n = 0; n < i.length; n++)if (!i[n](e, t))return !1;
                return !0
            }, "function" !== r && (n = "boolean" === r && n ? function (e, t) {
                return ti.equals(e, t)
            } : function (e, t) {
                if (e && t && "object" == typeof e && "object" == typeof t) {
                    for (var r in e)if ("$" !== r.charAt(0) && Fr.call(e, r) && n(e[r], t[r]))return !0;
                    return !1
                }
                return t = ("" + t).toLowerCase(), ("" + e).toLowerCase().indexOf(t) > -1
            });
            var o = function (e, t) {
                if ("string" == typeof t && "!" === t.charAt(0))return !o(e, t.substr(1));
                switch (typeof e) {
                    case"boolean":
                    case"number":
                    case"string":
                        return n(e, t);
                    case"object":
                        switch (typeof t) {
                            case"object":
                                return n(e, t);
                            default:
                                for (var r in e)if ("$" !== r.charAt(0) && o(e[r], t))return !0
                        }
                        return !1;
                    case"array":
                        for (var i = 0; i < e.length; i++)if (o(e[i], t))return !0;
                        return !1;
                    default:
                        return !1
                }
            };
            switch (typeof t) {
                case"boolean":
                case"number":
                case"string":
                    t = {$: t};
                case"object":
                    for (var a in t)!function (e) {
                        "undefined" != typeof t[e] && i.push(function (n) {
                            return o("$" == e ? n : n && n[e], t[e])
                        })
                    }(a);
                    break;
                case"function":
                    i.push(t);
                    break;
                default:
                    return e
            }
            for (var s = [], c = 0; c < e.length; c++) {
                var l = e[c];
                i.check(l, c) && s.push(l)
            }
            return s
        }
    }

    function or(e) {
        var t = e.NUMBER_FORMATS;
        return function (e, n, r) {
            return v(n) && (n = t.CURRENCY_SYM), v(r) && (r = 2), null == e ? e : sr(e, t.PATTERNS[1], t.GROUP_SEP, t.DECIMAL_SEP, r).replace(/\u00A4/g, n)
        }
    }

    function ar(e) {
        var t = e.NUMBER_FORMATS;
        return function (e, n) {
            return null == e ? e : sr(e, t.PATTERNS[0], t.GROUP_SEP, t.DECIMAL_SEP, n)
        }
    }

    function sr(e, t, n, r, i) {
        if (!isFinite(e) || y(e))return "";
        var o = 0 > e;
        e = Math.abs(e);
        var a = e + "", s = "", c = [], l = !1;
        if (-1 !== a.indexOf("e")) {
            var u = a.match(/([\d\.]+)e(-?)(\d+)/);
            u && "-" == u[2] && u[3] > i + 1 ? (a = "0", e = 0) : (s = a, l = !0)
        }
        if (l)i > 0 && e > -1 && 1 > e && (s = e.toFixed(i)); else {
            var d = (a.split(go)[1] || "").length;
            v(i) && (i = Math.min(Math.max(t.minFrac, d), t.maxFrac)), e = +(Math.round(+(e.toString() + "e" + i)).toString() + "e" + -i), 0 === e && (o = !1);
            var p = ("" + e).split(go), f = p[0];
            p = p[1] || "";
            var h, m = 0, g = t.lgSize, _ = t.gSize;
            if (f.length >= g + _)for (m = f.length - g, h = 0; m > h; h++)(m - h) % _ === 0 && 0 !== h && (s += n), s += f.charAt(h);
            for (h = m; h < f.length; h++)(f.length - h) % g === 0 && 0 !== h && (s += n), s += f.charAt(h);
            for (; p.length < i;)p += "0";
            i && "0" !== i && (s += r + p.substr(0, i))
        }
        return c.push(o ? t.negPre : t.posPre), c.push(s), c.push(o ? t.negSuf : t.posSuf), c.join("")
    }

    function cr(e, t, n) {
        var r = "";
        for (0 > e && (r = "-", e = -e), e = "" + e; e.length < t;)e = "0" + e;
        return n && (e = e.substr(e.length - t)), r + e
    }

    function lr(e, t, n, r) {
        return n = n || 0, function (i) {
            var o = i["get" + e]();
            return (n > 0 || o > -n) && (o += n), 0 === o && -12 == n && (o = 12), cr(o, t, r)
        }
    }

    function ur(e, t) {
        return function (n, r) {
            var i = n["get" + e](), o = Hr(t ? "SHORT" + e : e);
            return r[o][i]
        }
    }

    function dr(e) {
        var t = -1 * e.getTimezoneOffset(), n = t >= 0 ? "+" : "";
        return n += cr(Math[t > 0 ? "floor" : "ceil"](t / 60), 2) + cr(Math.abs(t % 60), 2)
    }

    function pr(e) {
        var t = new Date(e, 0, 1).getDay();
        return new Date(e, 0, (4 >= t ? 5 : 12) - t)
    }

    function fr(e) {
        return new Date(e.getFullYear(), e.getMonth(), e.getDate() + (4 - e.getDay()))
    }

    function hr(e) {
        return function (t) {
            var n = pr(t.getFullYear()), r = fr(t), i = +r - +n, o = 1 + Math.round(i / 6048e5);
            return cr(o, e)
        }
    }

    function mr(e, t) {
        return e.getHours() < 12 ? t.AMPMS[0] : t.AMPMS[1]
    }

    function gr(e) {
        function t(e) {
            var t;
            if (t = e.match(n)) {
                var r = new Date(0), i = 0, o = 0, a = t[8] ? r.setUTCFullYear : r.setFullYear, s = t[8] ? r.setUTCHours : r.setHours;
                t[9] && (i = p(t[9] + t[10]), o = p(t[9] + t[11])), a.call(r, p(t[1]), p(t[2]) - 1, p(t[3]));
                var c = p(t[4] || 0) - i, l = p(t[5] || 0) - o, u = p(t[6] || 0), d = Math.round(1e3 * parseFloat("0." + (t[7] || 0)));
                return s.call(r, c, l, u, d), r
            }
            return e
        }

        var n = /^(\d{4})-?(\d\d)-?(\d\d)(?:T(\d\d)(?::?(\d\d)(?::?(\d\d)(?:\.(\d+))?)?)?(Z|([+-])(\d\d):?(\d\d))?)?$/;
        return function (n, r, i) {
            var a, s, c = "", l = [];
            if (r = r || "mediumDate", r = e.DATETIME_FORMATS[r] || r, b(n) && (n = yo.test(n) ? p(n) : t(n)), $(n) && (n = new Date(n)), !w(n))return n;
            for (; r;)s = _o.exec(r), s ? (l = R(l, s, 1), r = l.pop()) : (l.push(r), r = null);
            return i && "UTC" === i && (n = new Date(n.getTime()), n.setMinutes(n.getMinutes() + n.getTimezoneOffset())), o(l, function (t) {
                a = vo[t], c += a ? a(n, e.DATETIME_FORMATS) : t.replace(/(^'|'$)/g, "").replace(/''/g, "'")
            }), c
        }
    }

    function vr() {
        return function (e) {
            return F(e, !0)
        }
    }

    function _r() {
        return function (e, t) {
            if ($(e) && (e = e.toString()), !ii(e) && !b(e))return e;
            if (t = 1 / 0 === Math.abs(Number(t)) ? Number(t) : p(t), b(e))return t ? t >= 0 ? e.slice(0, t) : e.slice(t, e.length) : "";
            var n, r, i = [];
            for (t > e.length ? t = e.length : t < -e.length && (t = -e.length), t > 0 ? (n = 0, r = t) : (n = e.length + t, r = e.length); r > n; n++)i.push(e[n]);
            return i
        }
    }

    function yr(e) {
        return function (t, n, r) {
            function o(e, t) {
                for (var r = 0; r < n.length; r++) {
                    var i = n[r](e, t);
                    if (0 !== i)return i
                }
                return 0
            }

            function a(e, t) {
                return t ? function (t, n) {
                    return e(n, t)
                } : e
            }

            function s(e, t) {
                var n = typeof e, r = typeof t;
                return n == r ? (w(e) && w(t) && (e = e.valueOf(), t = t.valueOf()), "string" == n && (e = e.toLowerCase(), t = t.toLowerCase()), e === t ? 0 : t > e ? -1 : 1) : r > n ? -1 : 1
            }

            return i(t) ? (n = ii(n) ? n : [n], 0 === n.length && (n = ["+"]), n = n.map(function (t) {
                var n = !1, r = t || m;
                if (b(t)) {
                    if (("+" == t.charAt(0) || "-" == t.charAt(0)) && (n = "-" == t.charAt(0), t = t.substring(1)), "" === t)return a(function (e, t) {
                        return s(e, t)
                    }, n);
                    if (r = e(t), r.constant) {
                        var i = r();
                        return a(function (e, t) {
                            return s(e[i], t[i])
                        }, n)
                    }
                }
                return a(function (e, t) {
                    return s(r(e), r(t))
                }, n)
            }), Qr.call(t).sort(a(o, r))) : t
        }
    }

    function br(e) {
        return x(e) && (e = {link: e}), e.restrict = e.restrict || "AC", g(e)
    }

    function $r(e, t) {
        e.$name = t
    }

    function wr(e, t, r, i, a) {
        var s = this, c = [], l = s.$$parentForm = e.parent().controller("form") || So;
        s.$error = {}, s.$$success = {}, s.$pending = n, s.$name = a(t.name || t.ngForm || "")(r), s.$dirty = !1, s.$pristine = !0, s.$valid = !0, s.$invalid = !1, s.$submitted = !1, l.$addControl(s), s.$rollbackViewValue = function () {
            o(c, function (e) {
                e.$rollbackViewValue()
            })
        }, s.$commitViewValue = function () {
            o(c, function (e) {
                e.$commitViewValue()
            })
        }, s.$addControl = function (e) {
            ot(e.$name, "input"), c.push(e), e.$name && (s[e.$name] = e)
        }, s.$$renameControl = function (e, t) {
            var n = e.$name;
            s[n] === e && delete s[n], s[t] = e, e.$name = t
        }, s.$removeControl = function (e) {
            e.$name && s[e.$name] === e && delete s[e.$name], o(s.$pending, function (t, n) {
                s.$setValidity(n, null, e)
            }), o(s.$error, function (t, n) {
                s.$setValidity(n, null, e)
            }), O(c, e)
        }, Nr({
            ctrl: this, $element: e, set: function (e, t, n) {
                var r = e[t];
                if (r) {
                    var i = r.indexOf(n);
                    -1 === i && r.push(n)
                } else e[t] = [n]
            }, unset: function (e, t, n) {
                var r = e[t];
                r && (O(r, n), 0 === r.length && delete e[t])
            }, parentForm: l, $animate: i
        }), s.$setDirty = function () {
            i.removeClass(e, zo), i.addClass(e, Vo), s.$dirty = !0, s.$pristine = !1, l.$setDirty()
        }, s.$setPristine = function () {
            i.setClass(e, zo, Vo + " " + Co), s.$dirty = !1, s.$pristine = !0, s.$submitted = !1, o(c, function (e) {
                e.$setPristine()
            })
        }, s.$setUntouched = function () {
            o(c, function (e) {
                e.$setUntouched()
            })
        }, s.$setSubmitted = function () {
            i.addClass(e, Co), s.$submitted = !0, l.$setSubmitted()
        }
    }

    function xr(e) {
        e.$formatters.push(function (t) {
            return e.$isEmpty(t) ? t : t.toString()
        })
    }

    function Sr(e, t, n, r, i, o) {
        Cr(e, t, n, r, i, o), xr(r)
    }

    function Cr(e, t, n, r, i, o) {
        var a = t[0].placeholder, s = {}, c = Br(t[0].type);
        if (!i.android) {
            var l = !1;
            t.on("compositionstart", function () {
                l = !0
            }), t.on("compositionend", function () {
                l = !1, u()
            })
        }
        var u = function (e) {
            if (!l) {
                var i = t.val(), o = e && e.type;
                if (Wr && "input" === (e || s).type && t[0].placeholder !== a)return void(a = t[0].placeholder);
                "password" === c || n.ngTrim && "false" === n.ngTrim || (i = oi(i)), (r.$viewValue !== i || "" === i && r.$$hasNativeValidators) && r.$setViewValue(i, o)
            }
        };
        if (i.hasEvent("input"))t.on("input", u); else {
            var d, p = function (e) {
                d || (d = o.defer(function () {
                    u(e), d = null
                }))
            };
            t.on("keydown", function (e) {
                var t = e.keyCode;
                91 === t || t > 15 && 19 > t || t >= 37 && 40 >= t || p(e)
            }), i.hasEvent("paste") && t.on("paste cut", p)
        }
        t.on("change", u), r.$render = function () {
            t.val(r.$isEmpty(r.$modelValue) ? "" : r.$viewValue)
        }
    }

    function kr(e, t) {
        if (w(e))return e;
        if (b(e)) {
            Po.lastIndex = 0;
            var n = Po.exec(e);
            if (n) {
                var r = +n[1], i = +n[2], o = 0, a = 0, s = 0, c = 0, l = pr(r), u = 7 * (i - 1);
                return t && (o = t.getHours(), a = t.getMinutes(), s = t.getSeconds(), c = t.getMilliseconds()), new Date(r, 0, l.getDate() + u, o, a, s, c)
            }
        }
        return 0 / 0
    }

    function Tr(e, t) {
        return function (n, r) {
            var i, a;
            if (w(n))return n;
            if (b(n)) {
                if ('"' == n.charAt(0) && '"' == n.charAt(n.length - 1) && (n = n.substring(1, n.length - 1)), Ao.test(n))return new Date(n);
                if (e.lastIndex = 0, i = e.exec(n))return i.shift(), a = r ? {
                    yyyy: r.getFullYear(),
                    MM: r.getMonth() + 1,
                    dd: r.getDate(),
                    HH: r.getHours(),
                    mm: r.getMinutes(),
                    ss: r.getSeconds(),
                    sss: r.getMilliseconds() / 1e3
                } : {yyyy: 1970, MM: 1, dd: 1, HH: 0, mm: 0, ss: 0, sss: 0}, o(i, function (e, n) {
                    n < t.length && (a[t[n]] = +e)
                }), new Date(a.yyyy, a.MM - 1, a.dd, a.HH, a.mm, a.ss || 0, 1e3 * a.sss || 0)
            }
            return 0 / 0
        }
    }

    function Er(e, t, r, i) {
        return function (o, a, s, c, l, u, d) {
            function p(e) {
                return _(e) ? w(e) ? e : r(e) : n
            }

            Ar(o, a, s, c), Cr(o, a, s, c, l, u);
            var f, h = c && c.$options && c.$options.timezone;
            if (c.$$parserName = e, c.$parsers.push(function (e) {
                    if (c.$isEmpty(e))return null;
                    if (t.test(e)) {
                        var i = r(e, f);
                        return "UTC" === h && i.setMinutes(i.getMinutes() - i.getTimezoneOffset()), i
                    }
                    return n
                }), c.$formatters.push(function (e) {
                    if (!c.$isEmpty(e)) {
                        if (!w(e))throw Io("datefmt", "Expected `{0}` to be a date", e);
                        if (f = e, f && "UTC" === h) {
                            var t = 6e4 * f.getTimezoneOffset();
                            f = new Date(f.getTime() + t)
                        }
                        return d("date")(e, i, h)
                    }
                    return f = null, ""
                }), _(s.min) || s.ngMin) {
                var m;
                c.$validators.min = function (e) {
                    return c.$isEmpty(e) || v(m) || r(e) >= m
                }, s.$observe("min", function (e) {
                    m = p(e), c.$validate()
                })
            }
            if (_(s.max) || s.ngMax) {
                var g;
                c.$validators.max = function (e) {
                    return c.$isEmpty(e) || v(g) || r(e) <= g
                }, s.$observe("max", function (e) {
                    g = p(e), c.$validate()
                })
            }
            c.$isEmpty = function (e) {
                return !e || e.getTime && e.getTime() !== e.getTime()
            }
        }
    }

    function Ar(e, t, r, i) {
        var o = t[0], a = i.$$hasNativeValidators = y(o.validity);
        a && i.$parsers.push(function (e) {
            var r = t.prop(Ur) || {};
            return r.badInput && !r.typeMismatch ? n : e
        })
    }

    function Mr(e, t, r, i, o, a) {
        if (Ar(e, t, r, i), Cr(e, t, r, i, o, a), i.$$parserName = "number", i.$parsers.push(function (e) {
                return i.$isEmpty(e) ? null : qo.test(e) ? parseFloat(e) : n
            }), i.$formatters.push(function (e) {
                if (!i.$isEmpty(e)) {
                    if (!$(e))throw Io("numfmt", "Expected `{0}` to be a number", e);
                    e = e.toString()
                }
                return e
            }), r.min || r.ngMin) {
            var s;
            i.$validators.min = function (e) {
                return i.$isEmpty(e) || v(s) || e >= s
            }, r.$observe("min", function (e) {
                _(e) && !$(e) && (e = parseFloat(e, 10)), s = $(e) && !isNaN(e) ? e : n, i.$validate()
            })
        }
        if (r.max || r.ngMax) {
            var c;
            i.$validators.max = function (e) {
                return i.$isEmpty(e) || v(c) || c >= e
            }, r.$observe("max", function (e) {
                _(e) && !$(e) && (e = parseFloat(e, 10)), c = $(e) && !isNaN(e) ? e : n, i.$validate()
            })
        }
    }

    function Dr(e, t, n, r, i, o) {
        Cr(e, t, n, r, i, o), xr(r), r.$$parserName = "url", r.$validators.url = function (e) {
            return r.$isEmpty(e) || Mo.test(e)
        }
    }

    function qr(e, t, n, r, i, o) {
        Cr(e, t, n, r, i, o), xr(r), r.$$parserName = "email", r.$validators.email = function (e) {
            return r.$isEmpty(e) || Do.test(e)
        }
    }

    function Lr(e, t, n, r) {
        v(n.name) && t.attr("name", l());
        var i = function (e) {
            t[0].checked && r.$setViewValue(n.value, e && e.type)
        };
        t.on("click", i), r.$render = function () {
            var e = n.value;
            t[0].checked = e == r.$viewValue
        }, n.$observe("value", r.$render)
    }

    function Or(e, t, n, i, o) {
        var a;
        if (_(i)) {
            if (a = e(i), !a.constant)throw r("ngModel")("constexpr", "Expected constant expression for `{0}`, but saw `{1}`.", n, i);
            return a(t)
        }
        return o
    }

    function Pr(e, t, n, r, i, o, a, s) {
        var c = Or(s, e, "ngTrueValue", n.ngTrueValue, !0), l = Or(s, e, "ngFalseValue", n.ngFalseValue, !1), u = function (e) {
            r.$setViewValue(t[0].checked, e && e.type)
        };
        t.on("click", u), r.$render = function () {
            t[0].checked = r.$viewValue
        }, r.$isEmpty = function (e) {
            return e !== c
        }, r.$formatters.push(function (e) {
            return j(e, c)
        }), r.$parsers.push(function (e) {
            return e ? c : l
        })
    }

    function Nr(e) {
        function t(e, t, c) {
            t === n ? r("$pending", e, c) : i("$pending", e, c), A(t) ? t ? (d(s.$error, e, c), u(s.$$success, e, c)) : (u(s.$error, e, c), d(s.$$success, e, c)) : (d(s.$error, e, c), d(s.$$success, e, c)), s.$pending ? (o(Xo, !0), s.$valid = s.$invalid = n, a("", null)) : (o(Xo, !1), s.$valid = jr(s.$error), s.$invalid = !s.$valid, a("", s.$valid));
            var l;
            l = s.$pending && s.$pending[e] ? n : s.$error[e] ? !1 : s.$$success[e] ? !0 : null, a(e, l), p.$setValidity(e, l, s)
        }

        function r(e, t, n) {
            s[e] || (s[e] = {}), u(s[e], t, n)
        }

        function i(e, t, r) {
            s[e] && d(s[e], t, r), jr(s[e]) && (s[e] = n)
        }

        function o(e, t) {
            t && !l[e] ? (f.addClass(c, e), l[e] = !0) : !t && l[e] && (f.removeClass(c, e), l[e] = !1)
        }

        function a(e, t) {
            e = e ? "-" + tt(e, "-") : "", o(Fo + e, t === !0), o(Ho + e, t === !1)
        }

        var s = e.ctrl, c = e.$element, l = {}, u = e.set, d = e.unset, p = e.parentForm, f = e.$animate;
        l[Ho] = !(l[Fo] = c.hasClass(Fo)), s.$setValidity = t
    }

    function jr(e) {
        if (e)for (var t in e)return !1;
        return !0
    }

    function Rr(e, t) {
        return e = "ngClass" + e, ["$animate", function (n) {
            function r(e, t) {
                var n = [];
                e:for (var r = 0; r < e.length; r++) {
                    for (var i = e[r], o = 0; o < t.length; o++)if (i == t[o])continue e;
                    n.push(i)
                }
                return n
            }

            function i(e) {
                if (ii(e))return e;
                if (b(e))return e.split(" ");
                if (y(e)) {
                    var t = [];
                    return o(e, function (e, n) {
                        e && (t = t.concat(n.split(" ")))
                    }), t
                }
                return e
            }

            return {
                restrict: "AC", link: function (a, s, c) {
                    function l(e) {
                        var t = d(e, 1);
                        c.$addClass(t)
                    }

                    function u(e) {
                        var t = d(e, -1);
                        c.$removeClass(t)
                    }

                    function d(e, t) {
                        var n = s.data("$classCounts") || {}, r = [];
                        return o(e, function (e) {
                            (t > 0 || n[e]) && (n[e] = (n[e] || 0) + t, n[e] === +(t > 0) && r.push(e))
                        }), s.data("$classCounts", n), r.join(" ")
                    }

                    function p(e, t) {
                        var i = r(t, e), o = r(e, t);
                        i = d(i, 1), o = d(o, -1), i && i.length && n.addClass(s, i), o && o.length && n.removeClass(s, o)
                    }

                    function f(e) {
                        if (t === !0 || a.$index % 2 === t) {
                            var n = i(e || []);
                            if (h) {
                                if (!j(e, h)) {
                                    var r = i(h);
                                    p(r, n)
                                }
                            } else l(n)
                        }
                        h = N(e)
                    }

                    var h;
                    a.$watch(c[e], f, !0), c.$observe("class", function () {
                        f(a.$eval(c[e]))
                    }), "ngClass" !== e && a.$watch("$index", function (n, r) {
                        var o = 1 & n;
                        if (o !== (1 & r)) {
                            var s = i(a.$eval(c[e]));
                            o === t ? l(s) : u(s)
                        }
                    })
                }
            }
        }]
    }

    var Ir = /^\/(.+)\/([a-z]*)$/, Ur = "validity", Br = function (e) {
        return b(e) ? e.toLowerCase() : e
    }, Fr = Object.prototype.hasOwnProperty, Hr = function (e) {
        return b(e) ? e.toUpperCase() : e
    }, zr = function (e) {
        return b(e) ? e.replace(/[A-Z]/g, function (e) {
            return String.fromCharCode(32 | e.charCodeAt(0))
        }) : e
    }, Vr = function (e) {
        return b(e) ? e.replace(/[a-z]/g, function (e) {
            return String.fromCharCode(-33 & e.charCodeAt(0))
        }) : e
    };
    "i" !== "I".toLowerCase() && (Br = zr, Hr = Vr);
    var Wr, Gr, Xr, Yr, Qr = [].slice, Kr = [].splice, Jr = [].push, Zr = Object.prototype.toString, ei = r("ng"), ti = e.angular || (e.angular = {}), ni = 0;
    Wr = t.documentMode, h.$inject = [], m.$inject = [];
    var ri, ii = Array.isArray, oi = function (e) {
        return b(e) ? e.trim() : e
    }, ai = function (e) {
        return e.replace(/([-()\[\]{}+?*.$\^|,:#<!\\])/g, "\\$1").replace(/\x08/g, "\\x08")
    }, si = function () {
        if (_(si.isActive_))return si.isActive_;
        var e = !(!t.querySelector("[ng-csp]") && !t.querySelector("[data-ng-csp]"));
        if (!e)try {
            new Function("")
        } catch (n) {
            e = !0
        }
        return si.isActive_ = e
    }, ci = ["ng-", "data-ng-", "ng:", "x-ng-"], li = /[A-Z]/g, ui = !1, di = 1, pi = 3, fi = 8, hi = 9, mi = 11, gi = {
        full: "1.3.3",
        major: 1,
        minor: 3,
        dot: 3,
        codeName: "undersea-arithmetic"
    };
    yt.expando = "ng339";
    var vi = yt.cache = {}, _i = 1, yi = function (e, t, n) {
        e.addEventListener(t, n, !1)
    }, bi = function (e, t, n) {
        e.removeEventListener(t, n, !1)
    };
    yt._data = function (e) {
        return this.cache[e[this.expando]] || {}
    };
    var $i = /([\:\-\_]+(.))/g, wi = /^moz([A-Z])/, xi = {
        mouseleave: "mouseout",
        mouseenter: "mouseover"
    }, Si = r("jqLite"), Ci = /^<(\w+)\s*\/?>(?:<\/\1>|)$/, ki = /<|&#?\w+;/, Ti = /<([\w:]+)/, Ei = /<(?!area|br|col|embed|hr|img|input|link|meta|param)(([\w:]+)[^>]*)\/>/gi, Ai = {
        option: [1, '<select multiple="multiple">', "</select>"],
        thead: [1, "<table>", "</table>"],
        col: [2, "<table><colgroup>", "</colgroup></table>"],
        tr: [2, "<table><tbody>", "</tbody></table>"],
        td: [3, "<table><tbody><tr>", "</tr></tbody></table>"],
        _default: [0, "", ""]
    };
    Ai.optgroup = Ai.option, Ai.tbody = Ai.tfoot = Ai.colgroup = Ai.caption = Ai.thead, Ai.th = Ai.td;
    var Mi = yt.prototype = {
        ready: function (n) {
            function r() {
                i || (i = !0, n())
            }

            var i = !1;
            "complete" === t.readyState ? setTimeout(r) : (this.on("DOMContentLoaded", r), yt(e).on("load", r))
        }, toString: function () {
            var e = [];
            return o(this, function (t) {
                e.push("" + t)
            }), "[" + e.join(", ") + "]"
        }, eq: function (e) {
            return Gr(e >= 0 ? this[e] : this[this.length + e])
        }, length: 0, push: Jr, sort: [].sort, splice: [].splice
    }, Di = {};
    o("multiple,selected,checked,disabled,readOnly,required,open".split(","), function (e) {
        Di[Br(e)] = e
    });
    var qi = {};
    o("input,select,option,textarea,button,form,details".split(","), function (e) {
        qi[e] = !0
    });
    var Li = {ngMinlength: "minlength", ngMaxlength: "maxlength", ngMin: "min", ngMax: "max", ngPattern: "pattern"};
    o({data: Ct, removeData: xt}, function (e, t) {
        yt[t] = e
    }), o({
        data: Ct, inheritedData: Dt, scope: function (e) {
            return Gr.data(e, "$scope") || Dt(e.parentNode || e, ["$isolateScope", "$scope"])
        }, isolateScope: function (e) {
            return Gr.data(e, "$isolateScope") || Gr.data(e, "$isolateScopeNoTemplate")
        }, controller: Mt, injector: function (e) {
            return Dt(e, "$injector")
        }, removeAttr: function (e, t) {
            e.removeAttribute(t)
        }, hasClass: kt, css: function (e, t, n) {
            return t = ht(t), _(n) ? void(e.style[t] = n) : e.style[t]
        }, attr: function (e, t, r) {
            var i = Br(t);
            if (Di[i]) {
                if (!_(r))return e[t] || (e.attributes.getNamedItem(t) || h).specified ? i : n;
                r ? (e[t] = !0, e.setAttribute(t, i)) : (e[t] = !1, e.removeAttribute(i))
            } else if (_(r))e.setAttribute(t, r); else if (e.getAttribute) {
                var o = e.getAttribute(t, 2);
                return null === o ? n : o
            }
        }, prop: function (e, t, n) {
            return _(n) ? void(e[t] = n) : e[t]
        }, text: function () {
            function e(e, t) {
                if (v(t)) {
                    var n = e.nodeType;
                    return n === di || n === pi ? e.textContent : ""
                }
                e.textContent = t
            }

            return e.$dv = "", e
        }(), val: function (e, t) {
            if (v(t)) {
                if (e.multiple && "select" === L(e)) {
                    var n = [];
                    return o(e.options, function (e) {
                        e.selected && n.push(e.value || e.text)
                    }), 0 === n.length ? null : n
                }
                return e.value
            }
            e.value = t
        }, html: function (e, t) {
            return v(t) ? e.innerHTML : ($t(e, !0), void(e.innerHTML = t))
        }, empty: qt
    }, function (e, t) {
        yt.prototype[t] = function (t, r) {
            var i, o, a = this.length;
            if (e !== qt && (2 == e.length && e !== kt && e !== Mt ? t : r) === n) {
                if (y(t)) {
                    for (i = 0; a > i; i++)if (e === Ct)e(this[i], t); else for (o in t)e(this[i], o, t[o]);
                    return this
                }
                for (var s = e.$dv, c = s === n ? Math.min(a, 1) : a, l = 0; c > l; l++) {
                    var u = e(this[l], t, r);
                    s = s ? s + u : u
                }
                return s
            }
            for (i = 0; a > i; i++)e(this[i], t, r);
            return this
        }
    }), o({
        removeData: xt, on: function Ra(e, t, n, r) {
            if (_(r))throw Si("onargs", "jqLite#on() does not support the `selector` or `eventData` parameters");
            if (gt(e)) {
                var i = St(e, !0), o = i.events, a = i.handle;
                a || (a = i.handle = jt(e, o));
                for (var s = t.indexOf(" ") >= 0 ? t.split(" ") : [t], c = s.length; c--;) {
                    t = s[c];
                    var l = o[t];
                    l || (o[t] = [], "mouseenter" === t || "mouseleave" === t ? Ra(e, xi[t], function (e) {
                        var n = this, r = e.relatedTarget;
                        (!r || r !== n && !n.contains(r)) && a(e, t)
                    }) : "$destroy" !== t && yi(e, t, a), l = o[t]), l.push(n)
                }
            }
        }, off: wt, one: function (e, t, n) {
            e = Gr(e), e.on(t, function r() {
                e.off(t, n), e.off(t, r)
            }), e.on(t, n)
        }, replaceWith: function (e, t) {
            var n, r = e.parentNode;
            $t(e), o(new yt(t), function (t) {
                n ? r.insertBefore(t, n.nextSibling) : r.replaceChild(t, e), n = t
            })
        }, children: function (e) {
            var t = [];
            return o(e.childNodes, function (e) {
                e.nodeType === di && t.push(e)
            }), t
        }, contents: function (e) {
            return e.contentDocument || e.childNodes || []
        }, append: function (e, t) {
            var n = e.nodeType;
            if (n === di || n === mi) {
                t = new yt(t);
                for (var r = 0, i = t.length; i > r; r++) {
                    var o = t[r];
                    e.appendChild(o)
                }
            }
        }, prepend: function (e, t) {
            if (e.nodeType === di) {
                var n = e.firstChild;
                o(new yt(t), function (t) {
                    e.insertBefore(t, n)
                })
            }
        }, wrap: function (e, t) {
            t = Gr(t).eq(0).clone()[0];
            var n = e.parentNode;
            n && n.replaceChild(t, e), t.appendChild(e)
        }, remove: Lt, detach: function (e) {
            Lt(e, !0)
        }, after: function (e, t) {
            var n = e, r = e.parentNode;
            t = new yt(t);
            for (var i = 0, o = t.length; o > i; i++) {
                var a = t[i];
                r.insertBefore(a, n.nextSibling), n = a
            }
        }, addClass: Et, removeClass: Tt, toggleClass: function (e, t, n) {
            t && o(t.split(" "), function (t) {
                var r = n;
                v(r) && (r = !kt(e, t)), (r ? Et : Tt)(e, t)
            })
        }, parent: function (e) {
            var t = e.parentNode;
            return t && t.nodeType !== mi ? t : null
        }, next: function (e) {
            return e.nextElementSibling
        }, find: function (e, t) {
            return e.getElementsByTagName ? e.getElementsByTagName(t) : []
        }, clone: bt, triggerHandler: function (e, t, n) {
            var r, i, a, s = t.type || t, c = St(e), l = c && c.events, u = l && l[s];
            u && (r = {
                preventDefault: function () {
                    this.defaultPrevented = !0
                }, isDefaultPrevented: function () {
                    return this.defaultPrevented === !0
                }, stopImmediatePropagation: function () {
                    this.immediatePropagationStopped = !0
                }, isImmediatePropagationStopped: function () {
                    return this.immediatePropagationStopped === !0
                }, stopPropagation: h, type: s, target: e
            }, t.type && (r = d(r, t)), i = N(u), a = n ? [r].concat(n) : [r], o(i, function (t) {
                r.isImmediatePropagationStopped() || t.apply(e, a)
            }))
        }
    }, function (e, t) {
        yt.prototype[t] = function (t, n, r) {
            for (var i, o = 0, a = this.length; a > o; o++)v(i) ? (i = e(this[o], t, n, r), _(i) && (i = Gr(i))) : At(i, e(this[o], t, n, r));
            return _(i) ? i : this
        }, yt.prototype.bind = yt.prototype.on, yt.prototype.unbind = yt.prototype.off
    }), It.prototype = {
        put: function (e, t) {
            this[Rt(e, this.nextUid)] = t
        }, get: function (e) {
            return this[Rt(e, this.nextUid)]
        }, remove: function (e) {
            var t = this[e = Rt(e, this.nextUid)];
            return delete this[e], t
        }
    };
    var Oi = /^function\s*[^\(]*\(\s*([^\)]*)\)/m, Pi = /,/, Ni = /^\s*(_?)(\S+?)\1\s*$/, ji = /((\/\/.*$)|(\/\*[\s\S]*?\*\/))/gm, Ri = r("$injector");
    Ft.$$annotate = Bt;
    var Ii = r("$animate"), Ui = ["$provide", function (e) {
        this.$$selectors = {}, this.register = function (t, n) {
            var r = t + "-animation";
            if (t && "." != t.charAt(0))throw Ii("notcsel", "Expecting class selector starting with '.' got '{0}'.", t);
            this.$$selectors[t.substr(1)] = r, e.factory(r, n)
        }, this.classNameFilter = function (e) {
            return 1 === arguments.length && (this.$$classNameFilter = e instanceof RegExp ? e : null), this.$$classNameFilter
        }, this.$get = ["$$q", "$$asyncCallback", "$rootScope", function (e, t, n) {
            function r(t) {
                var r, i = e.defer();
                return i.promise.$$cancelFn = function () {
                    r && r()
                }, n.$$postDigest(function () {
                    r = t(function () {
                        i.resolve()
                    })
                }), i.promise
            }

            function i(e, t) {
                var n = [], r = [], i = ct();
                return o((e.attr("class") || "").split(/\s+/), function (e) {
                    i[e] = !0
                }), o(t, function (e, t) {
                    var o = i[t];
                    e === !1 && o ? r.push(t) : e !== !0 || o || n.push(t)
                }), n.length + r.length > 0 && [n.length ? n : null, r.length ? r : null]
            }

            function a(e, t, n) {
                for (var r = 0, i = t.length; i > r; ++r) {
                    var o = t[r];
                    e[o] = n
                }
            }

            function s() {
                return l || (l = e.defer(), t(function () {
                    l.resolve(), l = null
                })), l.promise
            }

            function c(e, t) {
                if (ti.isObject(t)) {
                    var n = d(t.from || {}, t.to || {});
                    e.css(n)
                }
            }

            var l;
            return {
                animate: function (e, t, n) {
                    return c(e, {from: t, to: n}), s()
                }, enter: function (e, t, n, r) {
                    return c(e, r), n ? n.after(e) : t.prepend(e), s()
                }, leave: function (e) {
                    return e.remove(), s()
                }, move: function (e, t, n, r) {
                    return this.enter(e, t, n, r)
                }, addClass: function (e, t, n) {
                    return this.setClass(e, t, [], n)
                }, $$addClassImmediately: function (e, t, n) {
                    return e = Gr(e), t = b(t) ? t : ii(t) ? t.join(" ") : "", o(e, function (e) {
                        Et(e, t)
                    }), c(e, n), s()
                }, removeClass: function (e, t, n) {
                    return this.setClass(e, [], t, n)
                }, $$removeClassImmediately: function (e, t, n) {
                    return e = Gr(e), t = b(t) ? t : ii(t) ? t.join(" ") : "", o(e, function (e) {
                        Tt(e, t)
                    }), c(e, n), s()
                }, setClass: function (e, t, n, o) {
                    var s = this, c = "$$animateClasses", l = !1;
                    e = Gr(e);
                    var u = e.data(c);
                    u ? o && u.options && (u.options = ti.extend(u.options || {}, o)) : (u = {
                        classes: {},
                        options: o
                    }, l = !0);
                    var d = u.classes;
                    return t = ii(t) ? t : t.split(" "), n = ii(n) ? n : n.split(" "), a(d, t, !0), a(d, n, !1), l && (u.promise = r(function (t) {
                        var n = e.data(c);
                        if (e.removeData(c), n) {
                            var r = i(e, n.classes);
                            r && s.$$setClassImmediately(e, r[0], r[1], n.options)
                        }
                        t()
                    }), e.data(c, u)), u.promise
                }, $$setClassImmediately: function (e, t, n, r) {
                    return t && this.$$addClassImmediately(e, t), n && this.$$removeClassImmediately(e, n), c(e, r), s()
                }, enabled: h, cancel: h
            }
        }]
    }], Bi = r("$compile");
    Yt.$inject = ["$provide", "$$sanitizeUriProvider"];
    var Fi = /^((?:x|data)[\:\-_])/i, Hi = "application/json", zi = {"Content-Type": Hi + ";charset=utf-8"}, Vi = /^\s*(\[|\{[^\{])/, Wi = /[\}\]]\s*$/, Gi = /^\)\]\}',?\n/, Xi = r("$interpolate"), Yi = /^([^\?#]*)(\?([^#]*))?(#(.*))?$/, Qi = {
        http: 80,
        https: 443,
        ftp: 21
    }, Ki = r("$location"), Ji = {
        $$html5: !1, $$replace: !1, absUrl: Cn("$$absUrl"), url: function (e) {
            if (v(e))return this.$$url;
            var t = Yi.exec(e);
            return t[1] && this.path(decodeURIComponent(t[1])), (t[2] || t[1]) && this.search(t[3] || ""), this.hash(t[5] || ""), this
        }, protocol: Cn("$$protocol"), host: Cn("$$host"), port: Cn("$$port"), path: kn("$$path", function (e) {
            return e = null !== e ? e.toString() : "", "/" == e.charAt(0) ? e : "/" + e
        }), search: function (e, t) {
            switch (arguments.length) {
                case 0:
                    return this.$$search;
                case 1:
                    if (b(e) || $(e))e = e.toString(), this.$$search = W(e); else {
                        if (!y(e))throw Ki("isrcharg", "The first argument of the `$location#search()` call must be a string or an object.");
                        e = P(e, {}), o(e, function (t, n) {
                            null == t && delete e[n]
                        }), this.$$search = e
                    }
                    break;
                default:
                    v(t) || null === t ? delete this.$$search[e] : this.$$search[e] = t
            }
            return this.$$compose(), this
        }, hash: kn("$$hash", function (e) {
            return null !== e ? e.toString() : ""
        }), replace: function () {
            return this.$$replace = !0, this
        }
    };
    o([Sn, xn, wn], function (e) {
        e.prototype = Object.create(Ji), e.prototype.state = function (t) {
            if (!arguments.length)return this.$$state;
            if (e !== wn || !this.$$html5)throw Ki("nostate", "History API state support is available only in HTML5 mode and only in browsers supporting HTML5 History API");
            return this.$$state = v(t) ? null : t, this
        }
    });
    var Zi = r("$parse"), eo = Function.prototype.call, to = Function.prototype.apply, no = Function.prototype.bind, ro = ct();
    o({
        "null": function () {
            return null
        }, "true": function () {
            return !0
        }, "false": function () {
            return !1
        }, undefined: function () {
        }
    }, function (e, t) {
        e.constant = e.literal = e.sharedGetter = !0, ro[t] = e
    }), ro["this"] = function (e) {
        return e
    }, ro["this"].sharedGetter = !0;
    var io = d(ct(), {
        "+": function (e, t, r, i) {
            return r = r(e, t), i = i(e, t), _(r) ? _(i) ? r + i : r : _(i) ? i : n
        }, "-": function (e, t, n, r) {
            return n = n(e, t), r = r(e, t), (_(n) ? n : 0) - (_(r) ? r : 0)
        }, "*": function (e, t, n, r) {
            return n(e, t) * r(e, t)
        }, "/": function (e, t, n, r) {
            return n(e, t) / r(e, t)
        }, "%": function (e, t, n, r) {
            return n(e, t) % r(e, t)
        }, "===": function (e, t, n, r) {
            return n(e, t) === r(e, t)
        }, "!==": function (e, t, n, r) {
            return n(e, t) !== r(e, t)
        }, "==": function (e, t, n, r) {
            return n(e, t) == r(e, t)
        }, "!=": function (e, t, n, r) {
            return n(e, t) != r(e, t)
        }, "<": function (e, t, n, r) {
            return n(e, t) < r(e, t)
        }, ">": function (e, t, n, r) {
            return n(e, t) > r(e, t)
        }, "<=": function (e, t, n, r) {
            return n(e, t) <= r(e, t)
        }, ">=": function (e, t, n, r) {
            return n(e, t) >= r(e, t)
        }, "&&": function (e, t, n, r) {
            return n(e, t) && r(e, t)
        }, "||": function (e, t, n, r) {
            return n(e, t) || r(e, t)
        }, "!": function (e, t, n) {
            return !n(e, t)
        }, "=": !0, "|": !0
    }), oo = {n: "\n", f: "\f", r: "\r", t: "	", v: "", "'": "'", '"': '"'}, ao = function (e) {
        this.options = e
    };
    ao.prototype = {
        constructor: ao, lex: function (e) {
            for (this.text = e, this.index = 0, this.tokens = []; this.index < this.text.length;) {
                var t = this.text.charAt(this.index);
                if ('"' === t || "'" === t)this.readString(t); else if (this.isNumber(t) || "." === t && this.isNumber(this.peek()))this.readNumber(); else if (this.isIdent(t))this.readIdent(); else if (this.is(t, "(){}[].,;:?"))this.tokens.push({
                    index: this.index,
                    text: t
                }), this.index++; else if (this.isWhitespace(t))this.index++; else {
                    var n = t + this.peek(), r = n + this.peek(2), i = io[t], o = io[n], a = io[r];
                    if (i || o || a) {
                        var s = a ? r : o ? n : t;
                        this.tokens.push({index: this.index, text: s, operator: !0}), this.index += s.length
                    } else this.throwError("Unexpected next character ", this.index, this.index + 1)
                }
            }
            return this.tokens
        }, is: function (e, t) {
            return -1 !== t.indexOf(e)
        }, peek: function (e) {
            var t = e || 1;
            return this.index + t < this.text.length ? this.text.charAt(this.index + t) : !1
        }, isNumber: function (e) {
            return e >= "0" && "9" >= e && "string" == typeof e
        }, isWhitespace: function (e) {
            return " " === e || "\r" === e || "	" === e || "\n" === e || "" === e || "\xa0" === e
        }, isIdent: function (e) {
            return e >= "a" && "z" >= e || e >= "A" && "Z" >= e || "_" === e || "$" === e
        }, isExpOperator: function (e) {
            return "-" === e || "+" === e || this.isNumber(e)
        }, throwError: function (e, t, n) {
            n = n || this.index;
            var r = _(t) ? "s " + t + "-" + this.index + " [" + this.text.substring(t, n) + "]" : " " + n;
            throw Zi("lexerr", "Lexer Error: {0} at column{1} in expression [{2}].", e, r, this.text)
        }, readNumber: function () {
            for (var e = "", t = this.index; this.index < this.text.length;) {
                var n = Br(this.text.charAt(this.index));
                if ("." == n || this.isNumber(n))e += n; else {
                    var r = this.peek();
                    if ("e" == n && this.isExpOperator(r))e += n; else if (this.isExpOperator(n) && r && this.isNumber(r) && "e" == e.charAt(e.length - 1))e += n; else {
                        if (!this.isExpOperator(n) || r && this.isNumber(r) || "e" != e.charAt(e.length - 1))break;
                        this.throwError("Invalid exponent")
                    }
                }
                this.index++
            }
            this.tokens.push({index: t, text: e, constant: !0, value: Number(e)})
        }, readIdent: function () {
            for (var e = this.index; this.index < this.text.length;) {
                var t = this.text.charAt(this.index);
                if (!this.isIdent(t) && !this.isNumber(t))break;
                this.index++
            }
            this.tokens.push({index: e, text: this.text.slice(e, this.index), identifier: !0})
        }, readString: function (e) {
            var t = this.index;
            this.index++;
            for (var n = "", r = e, i = !1; this.index < this.text.length;) {
                var o = this.text.charAt(this.index);
                if (r += o, i) {
                    if ("u" === o) {
                        var a = this.text.substring(this.index + 1, this.index + 5);
                        a.match(/[\da-f]{4}/i) || this.throwError("Invalid unicode escape [\\u" + a + "]"), this.index += 4, n += String.fromCharCode(parseInt(a, 16))
                    } else {
                        var s = oo[o];
                        n += s || o
                    }
                    i = !1
                } else if ("\\" === o)i = !0; else {
                    if (o === e)return this.index++, void this.tokens.push({index: t, text: r, constant: !0, value: n});
                    n += o
                }
                this.index++
            }
            this.throwError("Unterminated quote", t)
        }
    };
    var so = function (e, t, n) {
        this.lexer = e, this.$filter = t, this.options = n
    };
    so.ZERO = d(function () {
        return 0
    }, {sharedGetter: !0, constant: !0}), so.prototype = {
        constructor: so, parse: function (e) {
            this.text = e, this.tokens = this.lexer.lex(e);
            var t = this.statements();
            return 0 !== this.tokens.length && this.throwError("is an unexpected token", this.tokens[0]), t.literal = !!t.literal, t.constant = !!t.constant, t
        }, primary: function () {
            var e;
            this.expect("(") ? (e = this.filterChain(), this.consume(")")) : this.expect("[") ? e = this.arrayDeclaration() : this.expect("{") ? e = this.object() : this.peek().identifier ? e = this.identifier() : this.peek().constant ? e = this.constant() : this.throwError("not a primary expression", this.peek());
            for (var t, n; t = this.expect("(", "[", ".");)"(" === t.text ? (e = this.functionCall(e, n), n = null) : "[" === t.text ? (n = e, e = this.objectIndex(e)) : "." === t.text ? (n = e, e = this.fieldAccess(e)) : this.throwError("IMPOSSIBLE");
            return e
        }, throwError: function (e, t) {
            throw Zi("syntax", "Syntax Error: Token '{0}' {1} at column {2} of the expression [{3}] starting at [{4}].", t.text, e, t.index + 1, this.text, this.text.substring(t.index))
        }, peekToken: function () {
            if (0 === this.tokens.length)throw Zi("ueoe", "Unexpected end of expression: {0}", this.text);
            return this.tokens[0]
        }, peek: function (e, t, n, r) {
            return this.peekAhead(0, e, t, n, r)
        }, peekAhead: function (e, t, n, r, i) {
            if (this.tokens.length > e) {
                var o = this.tokens[e], a = o.text;
                if (a === t || a === n || a === r || a === i || !t && !n && !r && !i)return o
            }
            return !1
        }, expect: function (e, t, n, r) {
            var i = this.peek(e, t, n, r);
            return i ? (this.tokens.shift(), i) : !1
        }, consume: function (e) {
            if (0 === this.tokens.length)throw Zi("ueoe", "Unexpected end of expression: {0}", this.text);
            var t = this.expect(e);
            return t || this.throwError("is unexpected, expecting [" + e + "]", this.peek()), t
        }, unaryFn: function (e, t) {
            var n = io[e];
            return d(function (e, r) {
                return n(e, r, t)
            }, {constant: t.constant, inputs: [t]})
        }, binaryFn: function (e, t, n, r) {
            var i = io[t];
            return d(function (t, r) {
                return i(t, r, e, n)
            }, {constant: e.constant && n.constant, inputs: !r && [e, n]})
        }, identifier: function () {
            for (var e = this.consume().text; this.peek(".") && this.peekAhead(1).identifier && !this.peekAhead(2, "(");)e += this.consume().text + this.consume().text;
            return ro[e] || jn(e, this.options, this.text)
        }, constant: function () {
            var e = this.consume().value;
            return d(function () {
                return e
            }, {constant: !0, literal: !0})
        }, statements: function () {
            for (var e = []; ;)if (this.tokens.length > 0 && !this.peek("}", ")", ";", "]") && e.push(this.filterChain()), !this.expect(";"))return 1 === e.length ? e[0] : function (t, n) {
                for (var r, i = 0, o = e.length; o > i; i++)r = e[i](t, n);
                return r
            }
        }, filterChain: function () {
            for (var e, t = this.expression(); e = this.expect("|");)t = this.filter(t);
            return t
        }, filter: function (e) {
            var t, r, i = this.$filter(this.consume().text);
            if (this.peek(":"))for (t = [], r = []; this.expect(":");)t.push(this.expression());
            var o = [e].concat(t || []);
            return d(function (o, a) {
                var s = e(o, a);
                if (r) {
                    r[0] = s;
                    for (var c = t.length; c--;)r[c + 1] = t[c](o, a);
                    return i.apply(n, r)
                }
                return i(s)
            }, {constant: !i.$stateful && o.every(qn), inputs: !i.$stateful && o})
        }, expression: function () {
            return this.assignment()
        }, assignment: function () {
            var e, t, n = this.ternary();
            return (t = this.expect("=")) ? (n.assign || this.throwError("implies assignment but [" + this.text.substring(0, t.index) + "] can not be assigned to", t), e = this.ternary(), d(function (t, r) {
                return n.assign(t, e(t, r), r)
            }, {inputs: [n, e]})) : n
        }, ternary: function () {
            var e, t, n = this.logicalOR();
            if ((t = this.expect("?")) && (e = this.assignment(), this.consume(":"))) {
                var r = this.assignment();
                return d(function (t, i) {
                    return n(t, i) ? e(t, i) : r(t, i)
                }, {constant: n.constant && e.constant && r.constant})
            }
            return n
        }, logicalOR: function () {
            for (var e, t = this.logicalAND(); e = this.expect("||");)t = this.binaryFn(t, e.text, this.logicalAND(), !0);
            return t
        }, logicalAND: function () {
            var e, t = this.equality();
            return (e = this.expect("&&")) && (t = this.binaryFn(t, e.text, this.logicalAND(), !0)), t
        }, equality: function () {
            var e, t = this.relational();
            return (e = this.expect("==", "!=", "===", "!==")) && (t = this.binaryFn(t, e.text, this.equality())), t
        }, relational: function () {
            var e, t = this.additive();
            return (e = this.expect("<", ">", "<=", ">=")) && (t = this.binaryFn(t, e.text, this.relational())), t
        }, additive: function () {
            for (var e, t = this.multiplicative(); e = this.expect("+", "-");)t = this.binaryFn(t, e.text, this.multiplicative());
            return t
        }, multiplicative: function () {
            for (var e, t = this.unary(); e = this.expect("*", "/", "%");)t = this.binaryFn(t, e.text, this.unary());
            return t
        }, unary: function () {
            var e;
            return this.expect("+") ? this.primary() : (e = this.expect("-")) ? this.binaryFn(so.ZERO, e.text, this.unary()) : (e = this.expect("!")) ? this.unaryFn(e.text, this.unary()) : this.primary()
        }, fieldAccess: function (e) {
            var t = this.text, n = this.consume().text, r = jn(n, this.options, t);
            return d(function (t, n, i) {
                return r(i || e(t, n))
            }, {
                assign: function (r, i, o) {
                    var a = e(r, o);
                    return a || e.assign(r, a = {}), Ln(a, n, i, t)
                }
            })
        }, objectIndex: function (e) {
            var t = this.text, r = this.expression();
            return this.consume("]"), d(function (i, o) {
                var a, s = e(i, o), c = r(i, o);
                return An(c, t), s ? a = Mn(s[c], t) : n
            }, {
                assign: function (n, i, o) {
                    var a = An(r(n, o), t), s = Mn(e(n, o), t);
                    return s || e.assign(n, s = {}), s[a] = i
                }
            })
        }, functionCall: function (e, t) {
            var n = [];
            if (")" !== this.peekToken().text)do n.push(this.expression()); while (this.expect(","));
            this.consume(")");
            var r = this.text, i = n.length ? [] : null;
            return function (o, a) {
                var s = t ? t(o, a) : o, c = e(o, a, s) || h;
                if (i)for (var l = n.length; l--;)i[l] = Mn(n[l](o, a), r);
                Mn(s, r), Dn(c, r);
                var u = c.apply ? c.apply(s, i) : c(i[0], i[1], i[2], i[3], i[4]);
                return Mn(u, r)
            }
        }, arrayDeclaration: function () {
            var e = [];
            if ("]" !== this.peekToken().text)do {
                if (this.peek("]"))break;
                e.push(this.expression())
            } while (this.expect(","));
            return this.consume("]"), d(function (t, n) {
                for (var r = [], i = 0, o = e.length; o > i; i++)r.push(e[i](t, n));
                return r
            }, {literal: !0, constant: e.every(qn), inputs: e})
        }, object: function () {
            var e = [], t = [];
            if ("}" !== this.peekToken().text)do {
                if (this.peek("}"))break;
                var n = this.consume();
                n.constant ? e.push(n.value) : n.identifier ? e.push(n.text) : this.throwError("invalid key", n), this.consume(":"), t.push(this.expression())
            } while (this.expect(","));
            return this.consume("}"), d(function (n, r) {
                for (var i = {}, o = 0, a = t.length; a > o; o++)i[e[o]] = t[o](n, r);
                return i
            }, {literal: !0, constant: t.every(qn), inputs: t})
        }
    };
    var co = ct(), lo = ct(), uo = Object.prototype.valueOf, po = r("$sce"), fo = {
        HTML: "html",
        CSS: "css",
        URL: "url",
        RESOURCE_URL: "resourceUrl",
        JS: "js"
    }, Bi = r("$compile"), ho = t.createElement("a"), mo = er(e.location.href);
    rr.$inject = ["$provide"], or.$inject = ["$locale"], ar.$inject = ["$locale"];
    var go = ".", vo = {
        yyyy: lr("FullYear", 4),
        yy: lr("FullYear", 2, 0, !0),
        y: lr("FullYear", 1),
        MMMM: ur("Month"),
        MMM: ur("Month", !0),
        MM: lr("Month", 2, 1),
        M: lr("Month", 1, 1),
        dd: lr("Date", 2),
        d: lr("Date", 1),
        HH: lr("Hours", 2),
        H: lr("Hours", 1),
        hh: lr("Hours", 2, -12),
        h: lr("Hours", 1, -12),
        mm: lr("Minutes", 2),
        m: lr("Minutes", 1),
        ss: lr("Seconds", 2),
        s: lr("Seconds", 1),
        sss: lr("Milliseconds", 3),
        EEEE: ur("Day"),
        EEE: ur("Day", !0),
        a: mr,
        Z: dr,
        ww: hr(2),
        w: hr(1)
    }, _o = /((?:[^yMdHhmsaZEw']+)|(?:'(?:[^']|'')*')|(?:E+|y+|M+|d+|H+|h+|m+|s+|a|Z|w+))(.*)/, yo = /^\-?\d+$/;
    gr.$inject = ["$locale"];
    var bo = g(Br), $o = g(Hr);
    yr.$inject = ["$parse"];
    var wo = g({
        restrict: "E", compile: function (e, t) {
            return t.href || t.xlinkHref || t.name ? void 0 : function (e, t) {
                var n = "[object SVGAnimatedString]" === Zr.call(t.prop("href")) ? "xlink:href" : "href";
                t.on("click", function (e) {
                    t.attr(n) || e.preventDefault()
                })
            }
        }
    }), xo = {};
    o(Di, function (e, t) {
        if ("multiple" != e) {
            var n = Qt("ng-" + t);
            xo[n] = function () {
                return {
                    restrict: "A", priority: 100, link: function (e, r, i) {
                        e.$watch(i[n], function (e) {
                            i.$set(t, !!e)
                        })
                    }
                }
            }
        }
    }), o(Li, function (e, t) {
        xo[t] = function () {
            return {
                priority: 100, link: function (e, n, r) {
                    if ("ngPattern" === t && "/" == r.ngPattern.charAt(0)) {
                        var i = r.ngPattern.match(Ir);
                        if (i)return void r.$set("ngPattern", new RegExp(i[1], i[2]))
                    }
                    e.$watch(r[t], function (e) {
                        r.$set(t, e)
                    })
                }
            }
        }
    }), o(["src", "srcset", "href"], function (e) {
        var t = Qt("ng-" + e);
        xo[t] = function () {
            return {
                priority: 99, link: function (n, r, i) {
                    var o = e, a = e;
                    "href" === e && "[object SVGAnimatedString]" === Zr.call(r.prop("href")) && (a = "xlinkHref", i.$attr[a] = "xlink:href", o = null), i.$observe(t, function (t) {
                        return t ? (i.$set(a, t), void(Wr && o && r.prop(o, i[a]))) : void("href" === e && i.$set(a, null))
                    })
                }
            }
        }
    });
    var So = {
        $addControl: h,
        $$renameControl: $r,
        $removeControl: h,
        $setValidity: h,
        $setDirty: h,
        $setPristine: h,
        $setSubmitted: h
    }, Co = "ng-submitted";
    wr.$inject = ["$element", "$attrs", "$scope", "$animate", "$interpolate"];
    var ko = function (e) {
        return ["$timeout", function (t) {
            var r = {
                name: "form", restrict: e ? "EAC" : "E", controller: wr, compile: function (e) {
                    return e.addClass(zo).addClass(Fo), {
                        pre: function (e, r, i, o) {
                            if (!("action"in i)) {
                                var a = function (t) {
                                    e.$apply(function () {
                                        o.$commitViewValue(), o.$setSubmitted()
                                    }), t.preventDefault ? t.preventDefault() : t.returnValue = !1
                                };
                                yi(r[0], "submit", a), r.on("$destroy", function () {
                                    t(function () {
                                        bi(r[0], "submit", a)
                                    }, 0, !1)
                                })
                            }
                            var s = o.$$parentForm, c = o.$name;
                            c && (Ln(e, c, o, c), i.$observe(i.name ? "name" : "ngForm", function (t) {
                                c !== t && (Ln(e, c, n, c), c = t, Ln(e, c, o, c), s.$$renameControl(o, c))
                            })), r.on("$destroy", function () {
                                s.$removeControl(o), c && Ln(e, c, n, c), d(o, So)
                            })
                        }
                    }
                }
            };
            return r
        }]
    }, To = ko(), Eo = ko(!0), Ao = /\d{4}-[01]\d-[0-3]\dT[0-2]\d:[0-5]\d:[0-5]\d\.\d+([+-][0-2]\d:[0-5]\d|Z)/, Mo = /^(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?$/, Do = /^[a-z0-9!#$%&'*+\/=?^_`{|}~.-]+@[a-z0-9]([a-z0-9-]*[a-z0-9])?(\.[a-z0-9]([a-z0-9-]*[a-z0-9])?)*$/i, qo = /^\s*(\-|\+)?(\d+|(\d*(\.\d*)))\s*$/, Lo = /^(\d{4})-(\d{2})-(\d{2})$/, Oo = /^(\d{4})-(\d\d)-(\d\d)T(\d\d):(\d\d)(?::(\d\d)(\.\d{1,3})?)?$/, Po = /^(\d{4})-W(\d\d)$/, No = /^(\d{4})-(\d\d)$/, jo = /^(\d\d):(\d\d)(?::(\d\d)(\.\d{1,3})?)?$/, Ro = /(\s+|^)default(\s+|$)/, Io = new r("ngModel"), Uo = {
        text: Sr,
        date: Er("date", Lo, Tr(Lo, ["yyyy", "MM", "dd"]), "yyyy-MM-dd"),
        "datetime-local": Er("datetimelocal", Oo, Tr(Oo, ["yyyy", "MM", "dd", "HH", "mm", "ss", "sss"]), "yyyy-MM-ddTHH:mm:ss.sss"),
        time: Er("time", jo, Tr(jo, ["HH", "mm", "ss", "sss"]), "HH:mm:ss.sss"),
        week: Er("week", Po, kr, "yyyy-Www"),
        month: Er("month", No, Tr(No, ["yyyy", "MM"]), "yyyy-MM"),
        number: Mr,
        url: Dr,
        email: qr,
        radio: Lr,
        checkbox: Pr,
        hidden: h,
        button: h,
        submit: h,
        reset: h,
        file: h
    }, Bo = ["$browser", "$sniffer", "$filter", "$parse", function (e, t, n, r) {
        return {
            restrict: "E", require: ["?ngModel"], link: {
                pre: function (i, o, a, s) {
                    s[0] && (Uo[Br(a.type)] || Uo.text)(i, o, a, s[0], t, e, n, r)
                }
            }
        }
    }], Fo = "ng-valid", Ho = "ng-invalid", zo = "ng-pristine", Vo = "ng-dirty", Wo = "ng-untouched", Go = "ng-touched", Xo = "ng-pending", Yo = ["$scope", "$exceptionHandler", "$attrs", "$element", "$parse", "$animate", "$timeout", "$rootScope", "$q", "$interpolate", function (e, t, r, i, a, s, c, l, u, d) {
        this.$viewValue = Number.NaN, this.$modelValue = Number.NaN, this.$validators = {}, this.$asyncValidators = {}, this.$parsers = [], this.$formatters = [], this.$viewChangeListeners = [], this.$untouched = !0, this.$touched = !1, this.$pristine = !0, this.$dirty = !1, this.$valid = !0, this.$invalid = !1, this.$error = {}, this.$$success = {}, this.$pending = n, this.$name = d(r.name || "", !1)(e);
        var p = a(r.ngModel), f = null, m = this, g = function () {
            var t = p(e);
            return m.$options && m.$options.getterSetter && x(t) && (t = t()), t
        }, y = function () {
            var t;
            m.$options && m.$options.getterSetter && x(t = p(e)) ? t(m.$modelValue) : p.assign(e, m.$modelValue)
        };
        this.$$setOptions = function (e) {
            if (m.$options = e, !(p.assign || e && e.getterSetter))throw Io("nonassign", "Expression '{0}' is non-assignable. Element: {1}", r.ngModel, z(i))
        }, this.$render = h, this.$isEmpty = function (e) {
            return v(e) || "" === e || null === e || e !== e
        };
        var b = i.inheritedData("$formController") || So, w = 0;
        Nr({
            ctrl: this, $element: i, set: function (e, t) {
                e[t] = !0
            }, unset: function (e, t) {
                delete e[t]
            }, parentForm: b, $animate: s
        }), this.$setPristine = function () {
            m.$dirty = !1, m.$pristine = !0, s.removeClass(i, Vo), s.addClass(i, zo)
        }, this.$setUntouched = function () {
            m.$touched = !1, m.$untouched = !0, s.setClass(i, Wo, Go)
        }, this.$setTouched = function () {
            m.$touched = !0, m.$untouched = !1, s.setClass(i, Go, Wo)
        }, this.$rollbackViewValue = function () {
            c.cancel(f), m.$viewValue = m.$$lastCommittedViewValue, m.$render()
        }, this.$validate = function () {
            $(m.$modelValue) && isNaN(m.$modelValue) || this.$$parseAndValidate()
        }, this.$$runValidators = function (e, t, r, i) {
            function a(e) {
                var t = m.$$parserName || "parse";
                if (e === n)l(t, null); else if (l(t, e), !e)return o(m.$validators, function (e, t) {
                    l(t, null)
                }), o(m.$asyncValidators, function (e, t) {
                    l(t, null)
                }), !1;
                return !0
            }

            function s() {
                var e = !0;
                return o(m.$validators, function (n, i) {
                    var o = n(t, r);
                    e = e && o, l(i, o)
                }), e ? !0 : (o(m.$asyncValidators, function (e, t) {
                    l(t, null)
                }), !1)
            }

            function c() {
                var e = [], i = !0;
                o(m.$asyncValidators, function (o, a) {
                    var s = o(t, r);
                    if (!M(s))throw Io("$asyncValidators", "Expected asynchronous validator to return a promise but got '{0}' instead.", s);
                    l(a, n), e.push(s.then(function () {
                        l(a, !0)
                    }, function () {
                        i = !1, l(a, !1)
                    }))
                }), e.length ? u.all(e).then(function () {
                    d(i)
                }, h) : d(!0)
            }

            function l(e, t) {
                p === w && m.$setValidity(e, t)
            }

            function d(e) {
                p === w && i(e)
            }

            w++;
            var p = w;
            return a(e) && s() ? void c() : void d(!1)
        }, this.$commitViewValue = function () {
            var e = m.$viewValue;
            c.cancel(f), (m.$$lastCommittedViewValue !== e || "" === e && m.$$hasNativeValidators) && (m.$$lastCommittedViewValue = e, m.$pristine && (m.$dirty = !0, m.$pristine = !1, s.removeClass(i, zo), s.addClass(i, Vo), b.$setDirty()), this.$$parseAndValidate())
        }, this.$$parseAndValidate = function () {
            function e() {
                m.$modelValue !== a && m.$$writeModelToScope()
            }

            var t = m.$$lastCommittedViewValue, r = t, i = v(r) ? n : !0;
            if (i)for (var o = 0; o < m.$parsers.length; o++)if (r = m.$parsers[o](r), v(r)) {
                i = !1;
                break
            }
            $(m.$modelValue) && isNaN(m.$modelValue) && (m.$modelValue = g());
            var a = m.$modelValue, s = m.$options && m.$options.allowInvalid;
            s && (m.$modelValue = r, e()), m.$$runValidators(i, r, t, function (t) {
                s || (m.$modelValue = t ? r : n, e())
            })
        }, this.$$writeModelToScope = function () {
            y(m.$modelValue), o(m.$viewChangeListeners, function (e) {
                try {
                    e()
                } catch (n) {
                    t(n)
                }
            })
        }, this.$setViewValue = function (e, t) {
            m.$viewValue = e, (!m.$options || m.$options.updateOnDefault) && m.$$debounceViewValueCommit(t)
        }, this.$$debounceViewValueCommit = function (t) {
            var n, r = 0, i = m.$options;
            i && _(i.debounce) && (n = i.debounce, $(n) ? r = n : $(n[t]) ? r = n[t] : $(n["default"]) && (r = n["default"])), c.cancel(f), r ? f = c(function () {
                m.$commitViewValue()
            }, r) : l.$$phase ? m.$commitViewValue() : e.$apply(function () {
                m.$commitViewValue()
            })
        }, e.$watch(function () {
            var e = g();
            if (e !== m.$modelValue) {
                m.$modelValue = e;
                for (var t = m.$formatters, r = t.length, i = e; r--;)i = t[r](i);
                m.$viewValue !== i && (m.$viewValue = m.$$lastCommittedViewValue = i, m.$render(), m.$$runValidators(n, e, i, h))
            }
            return e
        })
    }], Qo = function () {
        return {
            restrict: "A",
            require: ["ngModel", "^?form", "^?ngModelOptions"],
            controller: Yo,
            priority: 1,
            compile: function (e) {
                return e.addClass(zo).addClass(Wo).addClass(Fo), {
                    pre: function (e, t, n, r) {
                        var i = r[0], o = r[1] || So;
                        i.$$setOptions(r[2] && r[2].$options), o.$addControl(i), n.$observe("name", function (e) {
                            i.$name !== e && o.$$renameControl(i, e)
                        }), e.$on("$destroy", function () {
                            o.$removeControl(i)
                        })
                    }, post: function (e, t, n, r) {
                        var i = r[0];
                        i.$options && i.$options.updateOn && t.on(i.$options.updateOn, function (e) {
                            i.$$debounceViewValueCommit(e && e.type)
                        }), t.on("blur", function () {
                            i.$touched || e.$apply(function () {
                                i.$setTouched()
                            })
                        })
                    }
                }
            }
        }
    }, Ko = g({
        restrict: "A", require: "ngModel", link: function (e, t, n, r) {
            r.$viewChangeListeners.push(function () {
                e.$eval(n.ngChange)
            })
        }
    }), Jo = function () {
        return {
            restrict: "A", require: "?ngModel", link: function (e, t, n, r) {
                r && (n.required = !0, r.$validators.required = function (e) {
                    return !n.required || !r.$isEmpty(e)
                }, n.$observe("required", function () {
                    r.$validate()
                }))
            }
        }
    }, Zo = function () {
        return {
            restrict: "A", require: "?ngModel", link: function (e, t, i, o) {
                if (o) {
                    var a, s = i.ngPattern || i.pattern;
                    i.$observe("pattern", function (e) {
                        if (b(e) && e.length > 0 && (e = new RegExp("^" + e + "$")), e && !e.test)throw r("ngPattern")("noregexp", "Expected {0} to be a RegExp but was {1}. Element: {2}", s, e, z(t));
                        a = e || n, o.$validate()
                    }), o.$validators.pattern = function (e) {
                        return o.$isEmpty(e) || v(a) || a.test(e)
                    }
                }
            }
        }
    }, ea = function () {
        return {
            restrict: "A", require: "?ngModel", link: function (e, t, n, r) {
                if (r) {
                    var i = 0;
                    n.$observe("maxlength", function (e) {
                        i = p(e) || 0, r.$validate()
                    }), r.$validators.maxlength = function (e, t) {
                        return r.$isEmpty(e) || t.length <= i
                    }
                }
            }
        }
    }, ta = function () {
        return {
            restrict: "A", require: "?ngModel", link: function (e, t, n, r) {
                if (r) {
                    var i = 0;
                    n.$observe("minlength", function (e) {
                        i = p(e) || 0, r.$validate()
                    }), r.$validators.minlength = function (e, t) {
                        return r.$isEmpty(e) || t.length >= i
                    }
                }
            }
        }
    }, na = function () {
        return {
            restrict: "A", priority: 100, require: "ngModel", link: function (e, t, r, i) {
                var a = t.attr(r.$attr.ngList) || ", ", s = "false" !== r.ngTrim, c = s ? oi(a) : a, l = function (e) {
                    if (!v(e)) {
                        var t = [];
                        return e && o(e.split(c), function (e) {
                            e && t.push(s ? oi(e) : e)
                        }), t
                    }
                };
                i.$parsers.push(l), i.$formatters.push(function (e) {
                    return ii(e) ? e.join(a) : n
                }), i.$isEmpty = function (e) {
                    return !e || !e.length
                }
            }
        }
    }, ra = /^(true|false|\d+)$/, ia = function () {
        return {
            restrict: "A", priority: 100, compile: function (e, t) {
                return ra.test(t.ngValue) ? function (e, t, n) {
                    n.$set("value", e.$eval(n.ngValue))
                } : function (e, t, n) {
                    e.$watch(n.ngValue, function (e) {
                        n.$set("value", e)
                    })
                }
            }
        }
    }, oa = function () {
        return {
            restrict: "A", controller: ["$scope", "$attrs", function (e, t) {
                var r = this;
                this.$options = e.$eval(t.ngModelOptions), this.$options.updateOn !== n ? (this.$options.updateOnDefault = !1, this.$options.updateOn = oi(this.$options.updateOn.replace(Ro, function () {
                    return r.$options.updateOnDefault = !0, " "
                }))) : this.$options.updateOnDefault = !0
            }]
        }
    }, aa = ["$compile", function (e) {
        return {
            restrict: "AC", compile: function (t) {
                return e.$$addBindingClass(t), function (t, r, i) {
                    e.$$addBindingInfo(r, i.ngBind), r = r[0], t.$watch(i.ngBind, function (e) {
                        r.textContent = e === n ? "" : e
                    })
                }
            }
        }
    }], sa = ["$interpolate", "$compile", function (e, t) {
        return {
            compile: function (r) {
                return t.$$addBindingClass(r), function (r, i, o) {
                    var a = e(i.attr(o.$attr.ngBindTemplate));
                    t.$$addBindingInfo(i, a.expressions), i = i[0], o.$observe("ngBindTemplate", function (e) {
                        i.textContent = e === n ? "" : e
                    })
                }
            }
        }
    }], ca = ["$sce", "$parse", "$compile", function (e, t, n) {
        return {
            restrict: "A", compile: function (r, i) {
                var o = t(i.ngBindHtml), a = t(i.ngBindHtml, function (e) {
                    return (e || "").toString()
                });
                return n.$$addBindingClass(r), function (t, r, i) {
                    n.$$addBindingInfo(r, i.ngBindHtml), t.$watch(a, function () {
                        r.html(e.getTrustedHtml(o(t)) || "")
                    })
                }
            }
        }
    }], la = Rr("", !0), ua = Rr("Odd", 0), da = Rr("Even", 1), pa = br({
        compile: function (e, t) {
            t.$set("ngCloak", n), e.removeClass("ng-cloak")
        }
    }), fa = [function () {
        return {restrict: "A", scope: !0, controller: "@", priority: 500}
    }], ha = {}, ma = {blur: !0, focus: !0};
    o("click dblclick mousedown mouseup mouseover mouseout mousemove mouseenter mouseleave keydown keyup keypress submit focus blur copy cut paste".split(" "), function (e) {
        var t = Qt("ng-" + e);
        ha[t] = ["$parse", "$rootScope", function (n, r) {
            return {
                restrict: "A", compile: function (i, o) {
                    var a = n(o[t], null, !0);
                    return function (t, n) {
                        n.on(e, function (n) {
                            var i = function () {
                                a(t, {$event: n})
                            };
                            ma[e] && r.$$phase ? t.$evalAsync(i) : t.$apply(i)
                        })
                    }
                }
            }
        }]
    });
    var ga = ["$animate", function (e) {
        return {
            multiElement: !0,
            transclude: "element",
            priority: 600,
            terminal: !0,
            restrict: "A",
            $$tlb: !0,
            link: function (n, r, i, o, a) {
                var s, c, l;
                n.$watch(i.ngIf, function (n) {
                    n ? c || a(function (n, o) {
                        c = o, n[n.length++] = t.createComment(" end ngIf: " + i.ngIf + " "), s = {clone: n}, e.enter(n, r.parent(), r)
                    }) : (l && (l.remove(), l = null), c && (c.$destroy(), c = null), s && (l = st(s.clone), e.leave(l).then(function () {
                        l = null
                    }), s = null))
                })
            }
        }
    }], va = ["$templateRequest", "$anchorScroll", "$animate", "$sce", function (e, t, n, r) {
        return {
            restrict: "ECA",
            priority: 400,
            terminal: !0,
            transclude: "element",
            controller: ti.noop,
            compile: function (i, o) {
                var a = o.ngInclude || o.src, s = o.onload || "", c = o.autoscroll;
                return function (i, o, l, u, d) {
                    var p, f, h, m = 0, g = function () {
                        f && (f.remove(), f = null), p && (p.$destroy(), p = null), h && (n.leave(h).then(function () {
                            f = null
                        }), f = h, h = null)
                    };
                    i.$watch(r.parseAsResourceUrl(a), function (r) {
                        var a = function () {
                            !_(c) || c && !i.$eval(c) || t()
                        }, l = ++m;
                        r ? (e(r, !0).then(function (e) {
                            if (l === m) {
                                var t = i.$new();
                                u.template = e;
                                var c = d(t, function (e) {
                                    g(), n.enter(e, null, o).then(a)
                                });
                                p = t, h = c, p.$emit("$includeContentLoaded", r), i.$eval(s)
                            }
                        }, function () {
                            l === m && (g(), i.$emit("$includeContentError", r))
                        }), i.$emit("$includeContentRequested", r)) : (g(), u.template = null)
                    })
                }
            }
        }
    }], _a = ["$compile", function (e) {
        return {
            restrict: "ECA", priority: -400, require: "ngInclude", link: function (n, r, i, o) {
                return /SVG/.test(r[0].toString()) ? (r.empty(), void e(vt(o.template, t).childNodes)(n, function (e) {
                    r.append(e)
                }, {futureParentElement: r})) : (r.html(o.template), void e(r.contents())(n))
            }
        }
    }], ya = br({
        priority: 450, compile: function () {
            return {
                pre: function (e, t, n) {
                    e.$eval(n.ngInit)
                }
            }
        }
    }), ba = br({terminal: !0, priority: 1e3}), $a = ["$locale", "$interpolate", function (e, t) {
        var n = /{}/g;
        return {
            restrict: "EA", link: function (r, i, a) {
                var s = a.count, c = a.$attr.when && i.attr(a.$attr.when), l = a.offset || 0, u = r.$eval(c) || {}, d = {}, p = t.startSymbol(), f = t.endSymbol(), h = /^when(Minus)?(.+)$/;
                o(a, function (e, t) {
                    h.test(t) && (u[Br(t.replace("when", "").replace("Minus", "-"))] = i.attr(a.$attr[t]))
                }), o(u, function (e, r) {
                    d[r] = t(e.replace(n, p + s + "-" + l + f))
                }), r.$watch(function () {
                    var t = parseFloat(r.$eval(s));
                    return isNaN(t) ? "" : (t in u || (t = e.pluralCat(t - l)), d[t](r))
                }, function (e) {
                    i.text(e)
                })
            }
        }
    }], wa = ["$parse", "$animate", function (e, a) {
        var s = "$$NG_REMOVED", c = r("ngRepeat"), l = function (e, t, n, r, i, o, a) {
            e[n] = r, i && (e[i] = o), e.$index = t, e.$first = 0 === t, e.$last = t === a - 1, e.$middle = !(e.$first || e.$last), e.$odd = !(e.$even = 0 === (1 & t))
        }, u = function (e) {
            return e.clone[0]
        }, d = function (e) {
            return e.clone[e.clone.length - 1]
        };
        return {
            restrict: "A",
            multiElement: !0,
            transclude: "element",
            priority: 1e3,
            terminal: !0,
            $$tlb: !0,
            compile: function (r, p) {
                var f = p.ngRepeat, h = t.createComment(" end ngRepeat: " + f + " "), m = f.match(/^\s*([\s\S]+?)\s+in\s+([\s\S]+?)(?:\s+as\s+([\s\S]+?))?(?:\s+track\s+by\s+([\s\S]+?))?\s*$/);
                if (!m)throw c("iexp", "Expected expression in form of '_item_ in _collection_[ track by _id_]' but got '{0}'.", f);
                var g = m[1], v = m[2], _ = m[3], y = m[4];
                if (m = g.match(/^(?:([\$\w]+)|\(([\$\w]+)\s*,\s*([\$\w]+)\))$/), !m)throw c("iidexp", "'_item_' in '_item_ in _collection_' should be an identifier or '(_key_, _value_)' expression, but got '{0}'.", g);
                var b = m[3] || m[1], $ = m[2];
                if (_ && (!/^[$a-zA-Z_][$a-zA-Z0-9_]*$/.test(_) || /^(null|undefined|this|\$index|\$first|\$middle|\$last|\$even|\$odd|\$parent)$/.test(_)))throw c("badident", "alias '{0}' is invalid --- must be a valid JS identifier which is not a reserved name.", _);
                var w, x, S, C, k = {$id: Rt};
                return y ? w = e(y) : (S = function (e, t) {
                    return Rt(t)
                }, C = function (e) {
                    return e
                }), function (e, t, r, p, m) {
                    w && (x = function (t, n, r) {
                        return $ && (k[$] = t), k[b] = n, k.$index = r, w(e, k)
                    });
                    var g = ct();
                    e.$watchCollection(v, function (r) {
                        var p, v, y, w, k, T, E, A, M, D, q, L, O = t[0], P = ct();
                        if (_ && (e[_] = r), i(r))M = r, A = x || S; else {
                            A = x || C, M = [];
                            for (var N in r)r.hasOwnProperty(N) && "$" != N.charAt(0) && M.push(N);
                            M.sort()
                        }
                        for (w = M.length, q = new Array(w), p = 0; w > p; p++)if (k = r === M ? p : M[p], T = r[k], E = A(k, T, p), g[E])D = g[E], delete g[E], P[E] = D, q[p] = D; else {
                            if (P[E])throw o(q, function (e) {
                                e && e.scope && (g[e.id] = e)
                            }), c("dupes", "Duplicates in a repeater are not allowed. Use 'track by' expression to specify unique keys. Repeater: {0}, Duplicate key: {1}, Duplicate value: {2}", f, E, T);
                            q[p] = {id: E, scope: n, clone: n}, P[E] = !0
                        }
                        for (var j in g) {
                            if (D = g[j], L = st(D.clone), a.leave(L), L[0].parentNode)for (p = 0, v = L.length; v > p; p++)L[p][s] = !0;
                            D.scope.$destroy()
                        }
                        for (p = 0; w > p; p++)if (k = r === M ? p : M[p], T = r[k], D = q[p], D.scope) {
                            y = O;
                            do y = y.nextSibling; while (y && y[s]);
                            u(D) != y && a.move(st(D.clone), null, Gr(O)), O = d(D), l(D.scope, p, b, T, $, k, w)
                        } else m(function (e, t) {
                            D.scope = t;
                            var n = h.cloneNode(!1);
                            e[e.length++] = n, a.enter(e, null, Gr(O)), O = n, D.clone = e, P[D.id] = D, l(D.scope, p, b, T, $, k, w)
                        });
                        g = P
                    })
                }
            }
        }
    }], xa = "ng-hide", Sa = "ng-hide-animate", Ca = ["$animate", function (e) {
        return {
            restrict: "A", multiElement: !0, link: function (t, n, r) {
                t.$watch(r.ngShow, function (t) {
                    e[t ? "removeClass" : "addClass"](n, xa, {tempClasses: Sa})
                })
            }
        }
    }], ka = ["$animate", function (e) {
        return {
            restrict: "A", multiElement: !0, link: function (t, n, r) {
                t.$watch(r.ngHide, function (t) {
                    e[t ? "addClass" : "removeClass"](n, xa, {tempClasses: Sa})
                })
            }
        }
    }], Ta = br(function (e, t, n) {
        e.$watch(n.ngStyle, function (e, n) {
            n && e !== n && o(n, function (e, n) {
                t.css(n, "")
            }), e && t.css(e)
        }, !0)
    }), Ea = ["$animate", function (e) {
        return {
            restrict: "EA", require: "ngSwitch", controller: ["$scope", function () {
                this.cases = {}
            }], link: function (n, r, i, a) {
                var s = i.ngSwitch || i.on, c = [], l = [], u = [], d = [], p = function (e, t) {
                    return function () {
                        e.splice(t, 1)
                    }
                };
                n.$watch(s, function (n) {
                    var r, i;
                    for (r = 0, i = u.length; i > r; ++r)e.cancel(u[r]);
                    for (u.length = 0, r = 0, i = d.length; i > r; ++r) {
                        var s = st(l[r].clone);
                        d[r].$destroy();
                        var f = u[r] = e.leave(s);
                        f.then(p(u, r))
                    }
                    l.length = 0, d.length = 0, (c = a.cases["!" + n] || a.cases["?"]) && o(c, function (n) {
                        n.transclude(function (r, i) {
                            d.push(i);
                            var o = n.element;
                            r[r.length++] = t.createComment(" end ngSwitchWhen: ");
                            var a = {clone: r};
                            l.push(a), e.enter(r, o.parent(), o)
                        })
                    })
                })
            }
        }
    }], Aa = br({
        transclude: "element",
        priority: 1200,
        require: "^ngSwitch",
        multiElement: !0,
        link: function (e, t, n, r, i) {
            r.cases["!" + n.ngSwitchWhen] = r.cases["!" + n.ngSwitchWhen] || [], r.cases["!" + n.ngSwitchWhen].push({
                transclude: i,
                element: t
            })
        }
    }), Ma = br({
        transclude: "element",
        priority: 1200,
        require: "^ngSwitch",
        multiElement: !0,
        link: function (e, t, n, r, i) {
            r.cases["?"] = r.cases["?"] || [], r.cases["?"].push({transclude: i, element: t})
        }
    }), Da = br({
        restrict: "EAC", link: function (e, t, n, i, o) {
            if (!o)throw r("ngTransclude")("orphan", "Illegal use of ngTransclude directive in the template! No parent directive that requires a transclusion found. Element: {0}", z(t));
            o(function (e) {
                t.empty(), t.append(e)
            })
        }
    }), qa = ["$templateCache", function (e) {
        return {
            restrict: "E", terminal: !0, compile: function (t, n) {
                if ("text/ng-template" == n.type) {
                    var r = n.id, i = t[0].text;
                    e.put(r, i)
                }
            }
        }
    }], La = r("ngOptions"), Oa = g({restrict: "A", terminal: !0}), Pa = ["$compile", "$parse", function (e, r) {
        var i = /^\s*([\s\S]+?)(?:\s+as\s+([\s\S]+?))?(?:\s+group\s+by\s+([\s\S]+?))?\s+for\s+(?:([\$\w][\$\w]*)|(?:\(\s*([\$\w][\$\w]*)\s*,\s*([\$\w][\$\w]*)\s*\)))\s+in\s+([\s\S]+?)(?:\s+track\s+by\s+([\s\S]+?))?$/, s = {$setViewValue: h};
        return {
            restrict: "E",
            require: ["select", "?ngModel"],
            controller: ["$element", "$scope", "$attrs", function (e, t, n) {
                var r, i, o = this, a = {}, c = s;
                o.databound = n.ngModel, o.init = function (e, t, n) {
                    c = e, r = t, i = n
                }, o.addOption = function (t, n) {
                    ot(t, '"option value"'), a[t] = !0, c.$viewValue == t && (e.val(t), i.parent() && i.remove()), n && n[0].hasAttribute("selected") && (n[0].selected = !0)
                }, o.removeOption = function (e) {
                    this.hasOption(e) && (delete a[e], c.$viewValue == e && this.renderUnknownOption(e))
                }, o.renderUnknownOption = function (t) {
                    var n = "? " + Rt(t) + " ?";
                    i.val(n), e.prepend(i), e.val(n), i.prop("selected", !0)
                }, o.hasOption = function (e) {
                    return a.hasOwnProperty(e)
                }, t.$on("$destroy", function () {
                    o.renderUnknownOption = h
                })
            }],
            link: function (s, c, l, u) {
                function d(e, t, n, r) {
                    n.$render = function () {
                        var e = n.$viewValue;
                        r.hasOption(e) ? (C.parent() && C.remove(), t.val(e), "" === e && h.prop("selected", !0)) : v(e) && h ? t.val("") : r.renderUnknownOption(e)
                    }, t.on("change", function () {
                        e.$apply(function () {
                            C.parent() && C.remove(), n.$setViewValue(t.val())
                        })
                    })
                }

                function p(e, t, n) {
                    var r;
                    n.$render = function () {
                        var e = new It(n.$viewValue);
                        o(t.find("option"), function (t) {
                            t.selected = _(e.get(t.value))
                        })
                    }, e.$watch(function () {
                        j(r, n.$viewValue) || (r = N(n.$viewValue), n.$render())
                    }), t.on("change", function () {
                        e.$apply(function () {
                            var e = [];
                            o(t.find("option"), function (t) {
                                t.selected && e.push(t.value)
                            }), n.$setViewValue(e)
                        })
                    })
                }

                function f(t, s, c) {
                    function l(e, n, r) {
                        return R[T] = r, M && (R[M] = n), e(t, R)
                    }

                    function u() {
                        t.$apply(function () {
                            var e, n = L(t) || [];
                            if (y)e = [], o(s.val(), function (t) {
                                t = P ? N[t] : t, e.push(d(t, n[t]))
                            }); else {
                                var r = P ? N[s.val()] : s.val();
                                e = d(r, n[r])
                            }
                            c.$setViewValue(e), v()
                        })
                    }

                    function d(e, t) {
                        if ("?" === e)return n;
                        if ("" === e)return null;
                        var r = A ? A : q;
                        return l(r, e, t)
                    }

                    function p() {
                        var e, n = L(t);
                        if (n && ii(n)) {
                            e = new Array(n.length);
                            for (var r = 0, i = n.length; i > r; r++)e[r] = l(k, r, n[r]);
                            return e
                        }
                        if (n) {
                            e = {};
                            for (var o in n)n.hasOwnProperty(o) && (e[o] = l(k, o, n[o]))
                        }
                        return e
                    }

                    function f(e) {
                        var t;
                        if (y)if (P && ii(e)) {
                            t = new It([]);
                            for (var n = 0; n < e.length; n++)t.put(l(P, null, e[n]), !0)
                        } else t = new It(e); else P && (e = l(P, null, e));
                        return function (n, r) {
                            var i;
                            return i = P ? P : A ? A : q, y ? _(t.remove(l(i, n, r))) : e === l(i, n, r)
                        }
                    }

                    function h() {
                        w || (t.$$postDigest(v), w = !0)
                    }

                    function g(e, t, n) {
                        e[t] = e[t] || 0, e[t] += n ? 1 : -1
                    }

                    function v() {
                        w = !1;
                        var e, n, r, i, u, d, p, h, v, b, C, T, E, A, q, O, I, U = {"": []}, B = [""], F = c.$viewValue, H = L(t) || [], z = M ? a(H) : H, V = {}, W = f(F), G = !1;
                        for (N = {}, T = 0; b = z.length, b > T; T++)p = T, M && (p = z[T], "$" === p.charAt(0)) || (h = H[p], e = l(D, p, h) || "", (n = U[e]) || (n = U[e] = [], B.push(e)), E = W(p, h), G = G || E, O = l(k, p, h), O = _(O) ? O : "", I = P ? P(t, R) : M ? z[T] : T, P && (N[I] = p), n.push({
                            id: I,
                            label: O,
                            selected: E
                        }));
                        for (y || ($ || null === F ? U[""].unshift({
                            id: "",
                            label: "",
                            selected: !G
                        }) : G || U[""].unshift({id: "?", label: "", selected: !0})), C = 0, v = B.length; v > C; C++) {
                            for (e = B[C], n = U[e], j.length <= C ? (i = {
                                element: S.clone().attr("label", e),
                                label: n.label
                            }, u = [i], j.push(u), s.append(i.element)) : (u = j[C], i = u[0], i.label != e && i.element.attr("label", i.label = e)), A = null, T = 0, b = n.length; b > T; T++)r = n[T], (d = u[T + 1]) ? (A = d.element, d.label !== r.label && (g(V, d.label, !1), g(V, r.label, !0), A.text(d.label = r.label), A.prop("label", d.label)), d.id !== r.id && A.val(d.id = r.id), A[0].selected !== r.selected && (A.prop("selected", d.selected = r.selected), Wr && A.prop("selected", d.selected))) : ("" === r.id && $ ? q = $ : (q = x.clone()).val(r.id).prop("selected", r.selected).attr("selected", r.selected).prop("label", r.label).text(r.label), u.push(d = {
                                element: q,
                                label: r.label,
                                id: r.id,
                                selected: r.selected
                            }), g(V, r.label, !0), A ? A.after(q) : i.element.append(q), A = q);
                            for (T++; u.length > T;)r = u.pop(), g(V, r.label, !1), r.element.remove();
                            o(V, function (e, t) {
                                e > 0 ? m.addOption(t) : 0 > e && m.removeOption(t)
                            })
                        }
                        for (; j.length > C;)j.pop()[0].element.remove()
                    }

                    var C;
                    if (!(C = b.match(i)))throw La("iexp", "Expected expression in form of '_select_ (as _label_)? for (_key_,)?_value_ in _collection_' but got '{0}'. Element: {1}", b, z(s));
                    var k = r(C[2] || C[1]), T = C[4] || C[6], E = / as /.test(C[0]) && C[1], A = E ? r(E) : null, M = C[5], D = r(C[3] || ""), q = r(C[2] ? C[1] : T), L = r(C[7]), O = C[8], P = O ? r(C[8]) : null, N = {}, j = [[{
                        element: s,
                        label: ""
                    }]], R = {};
                    $ && (e($)(t), $.removeClass("ng-scope"), $.remove()), s.empty(), s.on("change", u), c.$render = v, t.$watchCollection(L, h), t.$watchCollection(p, h), y && t.$watchCollection(function () {
                        return c.$modelValue
                    }, h)
                }

                if (u[1]) {
                    for (var h, m = u[0], g = u[1], y = l.multiple, b = l.ngOptions, $ = !1, w = !1, x = Gr(t.createElement("option")), S = Gr(t.createElement("optgroup")), C = x.clone(), k = 0, T = c.children(), E = T.length; E > k; k++)if ("" === T[k].value) {
                        h = $ = T.eq(k);
                        break
                    }
                    m.init(g, $, C), y && (g.$isEmpty = function (e) {
                        return !e || 0 === e.length
                    }), b ? f(s, c, g) : y ? p(s, c, g) : d(s, c, g, m)
                }
            }
        }
    }], Na = ["$interpolate", function (e) {
        var t = {addOption: h, removeOption: h};
        return {
            restrict: "E", priority: 100, compile: function (n, r) {
                if (v(r.value)) {
                    var i = e(n.text(), !0);
                    i || r.$set("value", n.text())
                }
                return function (e, n, r) {
                    var o = "$selectController", a = n.parent(), s = a.data(o) || a.parent().data(o);
                    s && s.databound || (s = t), i ? e.$watch(i, function (e, t) {
                        r.$set("value", e), t !== e && s.removeOption(t), s.addOption(e, n)
                    }) : s.addOption(r.value, n), n.on("$destroy", function () {
                        s.removeOption(r.value)
                    })
                }
            }
        }
    }], ja = g({restrict: "E", terminal: !1});
    return e.angular.bootstrap ? void console.log("WARNING: Tried to load angular more than once.") : (nt(), pt(ti), void Gr(t).ready(function () {
        K(t, J)
    }))
}(window, document), !window.angular.$$csp() && window.angular.element(document).find("head").prepend('<style type="text/css">@charset "UTF-8";[ng\\:cloak],[ng-cloak],[data-ng-cloak],[x-ng-cloak],.ng-cloak,.x-ng-cloak,.ng-hide:not(.ng-hide-animate){display:none !important;}ng\\:form{display:block;}</style>'), function (e, t) {
    "use strict";
    function n() {
        function e(e, n) {
            return t.extend(new (t.extend(function () {
            }, {prototype: e})), n)
        }

        function n(e, t) {
            var n = t.caseInsensitiveMatch, r = {originalPath: e, regexp: e}, i = r.keys = [];
            return e = e.replace(/([().])/g, "\\$1").replace(/(\/)?:(\w+)([\?\*])?/g, function (e, t, n, r) {
                var o = "?" === r ? r : null, a = "*" === r ? r : null;
                return i.push({
                    name: n,
                    optional: !!o
                }), t = t || "", "" + (o ? "" : t) + "(?:" + (o ? t : "") + (a && "(.+?)" || "([^/]+)") + (o || "") + ")" + (o || "")
            }).replace(/([\/$\*])/g, "\\$1"), r.regexp = new RegExp("^" + e + "$", n ? "i" : ""), r
        }

        var r = {};
        this.when = function (e, i) {
            var o = t.copy(i);
            if (t.isUndefined(o.reloadOnSearch) && (o.reloadOnSearch = !0), t.isUndefined(o.caseInsensitiveMatch) && (o.caseInsensitiveMatch = this.caseInsensitiveMatch), r[e] = t.extend(o, e && n(e, o)), e) {
                var a = "/" == e[e.length - 1] ? e.substr(0, e.length - 1) : e + "/";
                r[a] = t.extend({redirectTo: e}, n(a, o))
            }
            return this
        }, this.caseInsensitiveMatch = !1, this.otherwise = function (e) {
            return "string" == typeof e && (e = {redirectTo: e}), this.when(null, e), this
        }, this.$get = ["$rootScope", "$location", "$routeParams", "$q", "$injector", "$templateRequest", "$sce", function (n, i, o, a, c, l, u) {
            function d(e, t) {
                var n = t.keys, r = {};
                if (!t.regexp)return null;
                var i = t.regexp.exec(e);
                if (!i)return null;
                for (var o = 1, a = i.length; a > o; ++o) {
                    var s = n[o - 1], c = i[o];
                    s && c && (r[s.name] = c)
                }
                return r
            }

            function p(e) {
                var r = y.current;
                g = h(), v = g && r && g.$$route === r.$$route && t.equals(g.pathParams, r.pathParams) && !g.reloadOnSearch && !_, v || !r && !g || n.$broadcast("$routeChangeStart", g, r).defaultPrevented && e && e.preventDefault()
            }

            function f() {
                var e = y.current, r = g;
                v ? (e.params = r.params, t.copy(e.params, o), n.$broadcast("$routeUpdate", e)) : (r || e) && (_ = !1, y.current = r, r && r.redirectTo && (t.isString(r.redirectTo) ? i.path(m(r.redirectTo, r.params)).search(r.params).replace() : i.url(r.redirectTo(r.pathParams, i.path(), i.search())).replace()), a.when(r).then(function () {
                    if (r) {
                        var e, n, i = t.extend({}, r.resolve);
                        return t.forEach(i, function (e, n) {
                            i[n] = t.isString(e) ? c.get(e) : c.invoke(e, null, null, n)
                        }), t.isDefined(e = r.template) ? t.isFunction(e) && (e = e(r.params)) : t.isDefined(n = r.templateUrl) && (t.isFunction(n) && (n = n(r.params)), n = u.getTrustedResourceUrl(n), t.isDefined(n) && (r.loadedTemplateUrl = n, e = l(n))), t.isDefined(e) && (i.$template = e), a.all(i)
                    }
                }).then(function (i) {
                    r == y.current && (r && (r.locals = i, t.copy(r.params, o)), n.$broadcast("$routeChangeSuccess", r, e))
                }, function (t) {
                    r == y.current && n.$broadcast("$routeChangeError", r, e, t)
                }))
            }

            function h() {
                var n, o;
                return t.forEach(r, function (r) {
                    !o && (n = d(i.path(), r)) && (o = e(r, {
                        params: t.extend({}, i.search(), n),
                        pathParams: n
                    }), o.$$route = r)
                }), o || r[null] && e(r[null], {params: {}, pathParams: {}})
            }

            function m(e, n) {
                var r = [];
                return t.forEach((e || "").split(":"), function (e, t) {
                    if (0 === t)r.push(e); else {
                        var i = e.match(/(\w+)(.*)/), o = i[1];
                        r.push(n[o]), r.push(i[2] || ""), delete n[o]
                    }
                }), r.join("")
            }

            var g, v, _ = !1, y = {
                routes: r, reload: function () {
                    _ = !0, n.$evalAsync(function () {
                        p(), f()
                    })
                }, updateParams: function (e) {
                    if (!this.current || !this.current.$$route)throw s("norout", "Tried updating route when with no current route");
                    var n = {}, r = this;
                    t.forEach(Object.keys(e), function (t) {
                        r.current.pathParams[t] || (n[t] = e[t])
                    }), e = t.extend({}, this.current.params, e), i.path(m(this.current.$$route.originalPath, e)), i.search(t.extend({}, i.search(), n))
                }
            };
            return n.$on("$locationChangeStart", p), n.$on("$locationChangeSuccess", f), y
        }]
    }

    function r() {
        this.$get = function () {
            return {}
        }
    }

    function i(e, n, r) {
        return {
            restrict: "ECA", terminal: !0, priority: 400, transclude: "element", link: function (i, o, a, s, c) {
                function l() {
                    f && (r.cancel(f), f = null), d && (d.$destroy(), d = null), p && (f = r.leave(p), f.then(function () {
                        f = null
                    }), p = null)
                }

                function u() {
                    var a = e.current && e.current.locals, s = a && a.$template;
                    if (t.isDefined(s)) {
                        var u = i.$new(), f = e.current, g = c(u, function (e) {
                            r.enter(e, null, p || o).then(function () {
                                !t.isDefined(h) || h && !i.$eval(h) || n()
                            }), l()
                        });
                        p = g, d = f.scope = u, d.$emit("$viewContentLoaded"), d.$eval(m)
                    } else l()
                }

                var d, p, f, h = a.autoscroll, m = a.onload || "";
                i.$on("$routeChangeSuccess", u), u()
            }
        }
    }

    function o(e, t, n) {
        return {
            restrict: "ECA", priority: -400, link: function (r, i) {
                var o = n.current, a = o.locals;
                i.html(a.$template);
                var s = e(i.contents());
                if (o.controller) {
                    a.$scope = r;
                    var c = t(o.controller, a);
                    o.controllerAs && (r[o.controllerAs] = c), i.data("$ngControllerController", c), i.children().data("$ngControllerController", c)
                }
                s(r)
            }
        }
    }

    var a = t.module("ngRoute", ["ng"]).provider("$route", n), s = t.$$minErr("ngRoute");
    a.provider("$routeParams", r), a.directive("ngView", i), a.directive("ngView", o), i.$inject = ["$route", "$anchorScroll", "$animate"], o.$inject = ["$compile", "$controller", "$route"]
}(window, window.angular), function (e, t, n) {
    "use strict";
    function r(e) {
        return null != e && "" !== e && "hasOwnProperty" !== e && s.test("." + e)
    }

    function i(e, t) {
        if (!r(t))throw a("badmember", 'Dotted member path "@{0}" is invalid.', t);
        for (var i = t.split("."), o = 0, s = i.length; s > o && e !== n; o++) {
            var c = i[o];
            e = null !== e ? e[c] : n
        }
        return e
    }

    function o(e, n) {
        n = n || {}, t.forEach(n, function (e, t) {
            delete n[t]
        });
        for (var r in e)!e.hasOwnProperty(r) || "$" === r.charAt(0) && "$" === r.charAt(1) || (n[r] = e[r]);
        return n
    }

    var a = t.$$minErr("$resource"), s = /^(\.[a-zA-Z_$][0-9a-zA-Z_$]*)+$/;
    t.module("ngResource", ["ng"]).provider("$resource", function () {
        var e = this;
        this.defaults = {
            stripTrailingSlashes: !0,
            actions: {
                get: {method: "GET"},
                save: {method: "POST"},
                query: {method: "GET", isArray: !0},
                remove: {method: "DELETE"},
                "delete": {method: "DELETE"}
            }
        }, this.$get = ["$http", "$q", function (r, s) {
            function c(e) {
                return l(e, !0).replace(/%26/gi, "&").replace(/%3D/gi, "=").replace(/%2B/gi, "+")
            }

            function l(e, t) {
                return encodeURIComponent(e).replace(/%40/gi, "@").replace(/%3A/gi, ":").replace(/%24/g, "$").replace(/%2C/gi, ",").replace(/%20/g, t ? "%20" : "+")
            }

            function u(t, n) {
                this.template = t, this.defaults = h({}, e.defaults, n), this.urlParams = {}
            }

            function d(c, l, v, _) {
                function y(e, t) {
                    var n = {};
                    return t = h({}, l, t), f(t, function (t, r) {
                        g(t) && (t = t()), n[r] = t && t.charAt && "@" == t.charAt(0) ? i(e, t.substr(1)) : t
                    }), n
                }

                function b(e) {
                    return e.resource
                }

                function $(e) {
                    o(e || {}, this)
                }

                var w = new u(c, _);
                return v = h({}, e.defaults.actions, v), $.prototype.toJSON = function () {
                    var e = h({}, this);
                    return delete e.$promise, delete e.$resolved, e
                }, f(v, function (e, i) {
                    var c = /^(POST|PUT|PATCH)$/i.test(e.method);
                    $[i] = function (l, u, d, v) {
                        var _, x, S, C = {};
                        switch (arguments.length) {
                            case 4:
                                S = v, x = d;
                            case 3:
                            case 2:
                                if (!g(u)) {
                                    C = l, _ = u, x = d;
                                    break
                                }
                                if (g(l)) {
                                    x = l, S = u;
                                    break
                                }
                                x = u, S = d;
                            case 1:
                                g(l) ? x = l : c ? _ = l : C = l;
                                break;
                            case 0:
                                break;
                            default:
                                throw a("badargs", "Expected up to 4 arguments [params, data, success, error], got {0} arguments", arguments.length)
                        }
                        var k = this instanceof $, T = k ? _ : e.isArray ? [] : new $(_), E = {}, A = e.interceptor && e.interceptor.response || b, M = e.interceptor && e.interceptor.responseError || n;
                        f(e, function (e, t) {
                            "params" != t && "isArray" != t && "interceptor" != t && (E[t] = m(e))
                        }), c && (E.data = _), w.setUrlParams(E, h({}, y(_, e.params || {}), C), e.url);
                        var D = r(E).then(function (n) {
                            var r = n.data, s = T.$promise;
                            if (r) {
                                if (t.isArray(r) !== !!e.isArray)throw a("badcfg", "Error in resource configuration for action `{0}`. Expected response to contain an {1} but got an {2}", i, e.isArray ? "array" : "object", t.isArray(r) ? "array" : "object");
                                e.isArray ? (T.length = 0, f(r, function (e) {
                                    T.push("object" == typeof e ? new $(e) : e)
                                })) : (o(r, T), T.$promise = s)
                            }
                            return T.$resolved = !0, n.resource = T, n
                        }, function (e) {
                            return T.$resolved = !0, (S || p)(e), s.reject(e)
                        });
                        return D = D.then(function (e) {
                            var t = A(e);
                            return (x || p)(t, e.headers), t
                        }, M), k ? D : (T.$promise = D, T.$resolved = !1, T)
                    }, $.prototype["$" + i] = function (e, t, n) {
                        g(e) && (n = t, t = e, e = {});
                        var r = $[i].call(this, e, this, t, n);
                        return r.$promise || r
                    }
                }), $.bind = function (e) {
                    return d(c, h({}, l, e), v)
                }, $
            }

            var p = t.noop, f = t.forEach, h = t.extend, m = t.copy, g = t.isFunction;
            return u.prototype = {
                setUrlParams: function (e, n, r) {
                    var i, o, s = this, l = r || s.template, u = s.urlParams = {};
                    f(l.split(/\W/), function (e) {
                        if ("hasOwnProperty" === e)throw a("badname", "hasOwnProperty is not a valid parameter name.");
                        !new RegExp("^\\d+$").test(e) && e && new RegExp("(^|[^\\\\]):" + e + "(\\W|$)").test(l) && (u[e] = !0)
                    }), l = l.replace(/\\:/g, ":"), n = n || {}, f(s.urlParams, function (e, r) {
                        i = n.hasOwnProperty(r) ? n[r] : s.defaults[r], t.isDefined(i) && null !== i ? (o = c(i), l = l.replace(new RegExp(":" + r + "(\\W|$)", "g"), function (e, t) {
                            return o + t
                        })) : l = l.replace(new RegExp("(/?):" + r + "(\\W|$)", "g"), function (e, t, n) {
                            return "/" == n.charAt(0) ? n : t + n
                        })
                    }), s.defaults.stripTrailingSlashes && (l = l.replace(/\/+$/, "") || "/"), l = l.replace(/\/\.(?=\w+($|\?))/, "."), e.url = l.replace(/\/\\\./, "/."), f(n, function (t, n) {
                        s.urlParams[n] || (e.params = e.params || {}, e.params[n] = t)
                    })
                }
            }, d
        }]
    })
}(window, window.angular), function (e, t) {
    "use strict";
    function n() {
        this.$get = ["$$sanitizeUri", function (e) {
            return function (t) {
                var n = [];
                return o(t, c(n, function (t, n) {
                    return !/^unsafe/.test(e(t, n))
                })), n.join("")
            }
        }]
    }

    function r(e) {
        var n = [], r = c(n, t.noop);
        return r.chars(e), n.join("")
    }

    function i(e) {
        var t, n = {}, r = e.split(",");
        for (t = 0; t < r.length; t++)n[r[t]] = !0;
        return n
    }

    function o(e, n) {
        function r(e, r, o, s) {
            if (r = t.lowercase(r), S[r])for (; y.last() && C[y.last()];)i("", y.last());
            x[r] && y.last() == r && i("", r), s = b[r] || !!s, s || y.push(r);
            var c = {};
            o.replace(p, function (e, t, n, r, i) {
                var o = n || r || i || "";
                c[t] = a(o)
            }), n.start && n.start(r, c, s)
        }

        function i(e, r) {
            var i, o = 0;
            if (r = t.lowercase(r))for (o = y.length - 1; o >= 0 && y[o] != r; o--);
            if (o >= 0) {
                for (i = y.length - 1; i >= o; i--)n.end && n.end(y[i]);
                y.length = o
            }
        }

        "string" != typeof e && (e = null === e || "undefined" == typeof e ? "" : "" + e);
        var o, s, c, _, y = [], $ = e;
        for (y.last = function () {
            return y[y.length - 1]
        }; e;) {
            if (_ = "", s = !0, y.last() && T[y.last()] ? (e = e.replace(new RegExp("(.*)<\\s*\\/\\s*" + y.last() + "[^>]*>", "i"), function (e, t) {
                    return t = t.replace(m, "$1").replace(v, "$1"), n.chars && n.chars(a(t)), ""
                }), i("", y.last())) : (0 === e.indexOf("<!--") ? (o = e.indexOf("--", 4), o >= 0 && e.lastIndexOf("-->", o) === o && (n.comment && n.comment(e.substring(4, o)), e = e.substring(o + 3), s = !1)) : g.test(e) ? (c = e.match(g), c && (e = e.replace(c[0], ""), s = !1)) : h.test(e) ? (c = e.match(d), c && (e = e.substring(c[0].length), c[0].replace(d, i), s = !1)) : f.test(e) && (c = e.match(u), c ? (c[4] && (e = e.substring(c[0].length), c[0].replace(u, r)), s = !1) : (_ += "<", e = e.substring(1))), s && (o = e.indexOf("<"), _ += 0 > o ? e : e.substring(0, o), e = 0 > o ? "" : e.substring(o), n.chars && n.chars(a(_)))), e == $)throw l("badparse", "The sanitizer was unable to parse the following block of html: {0}", e);
            $ = e
        }
        i()
    }

    function a(e) {
        if (!e)return "";
        var t = O.exec(e), n = t[1], r = t[3], i = t[2];
        return i && (L.innerHTML = i.replace(/</g, "&lt;"), i = "textContent"in L ? L.textContent : L.innerText), n + i + r
    }

    function s(e) {
        return e.replace(/&/g, "&amp;").replace(_, function (e) {
            var t = e.charCodeAt(0), n = e.charCodeAt(1);
            return "&#" + (1024 * (t - 55296) + (n - 56320) + 65536) + ";"
        }).replace(y, function (e) {
            return "&#" + e.charCodeAt(0) + ";"
        }).replace(/</g, "&lt;").replace(/>/g, "&gt;")
    }

    function c(e, n) {
        var r = !1, i = t.bind(e, e.push);
        return {
            start: function (e, o, a) {
                e = t.lowercase(e), !r && T[e] && (r = e), r || E[e] !== !0 || (i("<"), i(e), t.forEach(o, function (r, o) {
                    var a = t.lowercase(o), c = "img" === e && "src" === a || "background" === a;
                    q[a] !== !0 || A[a] === !0 && !n(r, c) || (i(" "), i(o), i('="'), i(s(r)), i('"'))
                }), i(a ? "/>" : ">"))
            }, end: function (e) {
                e = t.lowercase(e), r || E[e] !== !0 || (i("</"), i(e), i(">")), e == r && (r = !1)
            }, chars: function (e) {
                r || i(s(e))
            }
        }
    }

    var l = t.$$minErr("$sanitize"), u = /^<((?:[a-zA-Z])[\w:-]*)((?:\s+[\w:-]+(?:\s*=\s*(?:(?:"[^"]*")|(?:'[^']*')|[^>\s]+))?)*)\s*(\/?)\s*(>?)/, d = /^<\/\s*([\w:-]+)[^>]*>/, p = /([\w:-]+)(?:\s*=\s*(?:(?:"((?:[^"])*)")|(?:'((?:[^'])*)')|([^>\s]+)))?/g, f = /^</, h = /^<\//, m = /<!--(.*?)-->/g, g = /<!DOCTYPE([^>]*?)>/i, v = /<!\[CDATA\[(.*?)]]>/g, _ = /[\uD800-\uDBFF][\uDC00-\uDFFF]/g, y = /([^\#-~| |!])/g, b = i("area,br,col,hr,img,wbr"), $ = i("colgroup,dd,dt,li,p,tbody,td,tfoot,th,thead,tr"), w = i("rp,rt"), x = t.extend({}, w, $), S = t.extend({}, $, i("address,article,aside,blockquote,caption,center,del,dir,div,dl,figure,figcaption,footer,h1,h2,h3,h4,h5,h6,header,hgroup,hr,ins,map,menu,nav,ol,pre,script,section,table,ul")), C = t.extend({}, w, i("a,abbr,acronym,b,bdi,bdo,big,br,cite,code,del,dfn,em,font,i,img,ins,kbd,label,map,mark,q,ruby,rp,rt,s,samp,small,span,strike,strong,sub,sup,time,tt,u,var")), k = i("animate,animateColor,animateMotion,animateTransform,circle,defs,desc,ellipse,font-face,font-face-name,font-face-src,g,glyph,hkern,image,linearGradient,line,marker,metadata,missing-glyph,mpath,path,polygon,polyline,radialGradient,rect,set,stop,svg,switch,text,title,tspan,use"), T = i("script,style"), E = t.extend({}, b, S, C, x, k), A = i("background,cite,href,longdesc,src,usemap,xlink:href"), M = i("abbr,align,alt,axis,bgcolor,border,cellpadding,cellspacing,class,clear,color,cols,colspan,compact,coords,dir,face,headers,height,hreflang,hspace,ismap,lang,language,nohref,nowrap,rel,rev,rows,rowspan,rules,scope,scrolling,shape,size,span,start,summary,target,title,type,valign,value,vspace,width"), D = i("accent-height,accumulate,additive,alphabetic,arabic-form,ascent,attributeName,attributeType,baseProfile,bbox,begin,by,calcMode,cap-height,class,color,color-rendering,content,cx,cy,d,dx,dy,descent,display,dur,end,fill,fill-rule,font-family,font-size,font-stretch,font-style,font-variant,font-weight,from,fx,fy,g1,g2,glyph-name,gradientUnits,hanging,height,horiz-adv-x,horiz-origin-x,ideographic,k,keyPoints,keySplines,keyTimes,lang,marker-end,marker-mid,marker-start,markerHeight,markerUnits,markerWidth,mathematical,max,min,offset,opacity,orient,origin,overline-position,overline-thickness,panose-1,path,pathLength,points,preserveAspectRatio,r,refX,refY,repeatCount,repeatDur,requiredExtensions,requiredFeatures,restart,rotate,rx,ry,slope,stemh,stemv,stop-color,stop-opacity,strikethrough-position,strikethrough-thickness,stroke,stroke-dasharray,stroke-dashoffset,stroke-linecap,stroke-linejoin,stroke-miterlimit,stroke-opacity,stroke-width,systemLanguage,target,text-anchor,to,transform,type,u1,u2,underline-position,underline-thickness,unicode,unicode-range,units-per-em,values,version,viewBox,visibility,width,widths,x,x-height,x1,x2,xlink:actuate,xlink:arcrole,xlink:role,xlink:show,xlink:title,xlink:type,xml:base,xml:lang,xml:space,xmlns,xmlns:xlink,y,y1,y2,zoomAndPan"), q = t.extend({}, A, D, M), L = document.createElement("pre"), O = /^(\s*)([\s\S]*?)(\s*)$/;
    t.module("ngSanitize", []).provider("$sanitize", n), t.module("ngSanitize").filter("linky", ["$sanitize", function (e) {
        var n = /((ftp|https?):\/\/|(mailto:)?[A-Za-z0-9._%+-]+@)\S*[^\s.;,(){}<>"]/, i = /^mailto:/;
        return function (o, a) {
            function s(e) {
                e && f.push(r(e))
            }

            function c(e, n) {
                f.push("<a "), t.isDefined(a) && (f.push('target="'), f.push(a), f.push('" ')), f.push('href="'), f.push(e), f.push('">'), s(n), f.push("</a>")
            }

            if (!o)return o;
            for (var l, u, d, p = o, f = []; l = p.match(n);)u = l[0], l[2] == l[3] && (u = "mailto:" + u), d = l.index, s(p.substr(0, d)), c(u, l[0].replace(i, "")), p = p.substring(d + l[0].length);
            return s(p), e(f.join(""))
        }
    }])
}(window, window.angular), function (e, t, n) {
    "use strict";
    t.module("ngCookies", ["ng"]).factory("$cookies", ["$rootScope", "$browser", function (e, r) {
        function i() {
            var e, i, o, c;
            for (e in s)u(a[e]) && r.cookies(e, n);
            for (e in a)i = a[e], t.isString(i) || (i = "" + i, a[e] = i), i !== s[e] && (r.cookies(e, i), c = !0);
            if (c) {
                c = !1, o = r.cookies();
                for (e in a)a[e] !== o[e] && (u(o[e]) ? delete a[e] : a[e] = o[e], c = !0)
            }
        }

        var o, a = {}, s = {}, c = !1, l = t.copy, u = t.isUndefined;
        return r.addPollFn(function () {
            var t = r.cookies();
            o != t && (o = t, l(t, s), l(t, a), c && e.$apply())
        })(), c = !0, e.$watch(i), a
    }]).factory("$cookieStore", ["$cookies", function (e) {
        return {
            get: function (n) {
                var r = e[n];
                return r ? t.fromJson(r) : r
            }, put: function (n, r) {
                e[n] = t.toJson(r)
            }, remove: function (t) {
                delete e[t]
            }
        }
    }])
}(window, window.angular), function () {
    var e = "/common/js_error_report";
    if (window.reportJsError = function (t) {
            var n = printStackTrace();
            $.ajax({
                type: "POST",
                url: e,
                dataType: "application/json",
                data: {js_error: {url: window.location.href, error_message: t, stack_trace: n}}
            })
        }, window.onerror = function (t, n, r, i, o) {
            var a = printStackTrace({e: o});
            $.ajax({
                type: "POST",
                url: e,
                dataType: "application/json",
                data: {js_error: {url: window.location.href, error_message: t, stack_trace: a}}
            })
        }, "undefined" != typeof angular) {
        var t = angular.module("errorReporter", []);
        t.factory("stacktraceService", function () {
            return {print: printStackTrace}
        }), t.factory("$exceptionHandler", ["$log", "$window", "stacktraceService", function (t, n, r) {
            return function (i, o) {
                t.error.apply(t, arguments);
                try {
                    var a = i.toString(), s = r.print({e: i});
                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: e,
                        data: {js_error: {url: n.location.href, error_message: a, stack_trace: s, cause: o || ""}}
                    })
                } catch (c) {
                    t.warn("Error logging failed"), t.log(c)
                }
            }
        }])
    }
}();
var version_timestamp = "?v201505121200";
!function () {
    if ("" == window.location.search) {
        var e = window.location.href, t = e.indexOf("#");
        -1 != t ? -1 == e.lastIndexOf("?", t) && (window.location.href = e.substring(0, t) + "?" + e.substring(t)) : -1 == e.lastIndexOf("?") && (window.location.href = e + "?")
    }
}(), String.prototype.supplant = function (e) {
    return this.replace(/{([^{}]*)}/g, function (t, n) {
        var r = e[n];
        return "string" == typeof r || "number" == typeof r ? r : t
    })
};
var mask_num = 0;
$(document).ready(function () {
    $(document).on("touchmove", ".ddb-box", function (e) {
        e.preventDefault()
    })
}), window.addEventListener("load", function () {
    FastClick.attach(document.body)
}, !1);
var UrlParser = function () {
    function e(e) {
        e = e || window.location.href;
        var t = $("<a>", {href: e})[0], n = t.search, r = {};
        if (n)for (var i = n.slice(1).split("&"), o = 0; o < i.length; o++) {
            var a = i[o].split("=", 2);
            r[decodeURIComponent(a[0])] = decodeURIComponent(a[1])
        }
        return r
    }

    var t = function (t, n) {
        var r = e(n);
        t = t || function () {
            };
        for (var i in r)t(i, r[i])
    }, n = function (t) {
        var n = e(window.location.href);
        return t ? n[t] : n
    }, r = function () {
        return window.location.origin + window.location.pathname
    }, i = function (t, n, r) {
        var i = e(t), o = $("<a>", {href: t})[0];
        i[n] = r, o.search = "?";
        for (var a in i)o.search.length > 1 && (o.search += "&"), i[a] && (o.search += a + "=" + i[a]);
        return o.href
    };
    return {query_parameter: n, page_url_without_query: r, change_parameter: i, each_parameter: t}
}();
!function () {
    var e = function (e, t) {
        this.ngModule = t, this.moduleName = e;
        for (var n in this.ngModule) {
            var r = this.ngModule[n];
            if ("function" == typeof r) {
                var i = this;
                this[n] = new function () {
                    var e = r;
                    return function () {
                        return e.apply(i.ngModule, arguments), i
                    }
                }
            }
        }
    }, t = {
        modules: {}, module: function (t, n) {
            var r = this.modules[t];
            if ("undefined" != n) {
                var i = angular.module(t, n), r = new e(t, i);
                this.modules[t] = r
            }
            return r
        }, buildAppDependencies: function (e) {
            var t = [].concat(e);
            for (var n in this.modules)t.push(n);
            return t
        }, inferModuleName: function (e) {
            var t, n, r = /(Service|Factory|Controller|Directive)$/.exec(e);
            return null != r ? (r = r[0], t = pluralize(r.toLowerCase()), n = e.substr(0, e.length - r.length).toLowerCase(), n = pluralize(n, 1)) : (t = "miscellanies", n = pluralize(e, 1)), "diandanbao_app." + t + "." + n
        }
    }, n = ["service", "factory", "controller", "directive"];
    jQuery.each(n, function (e, n) {
        t[n] = function () {
            var e, r, i, o = n;
            switch (arguments.length) {
                case 2:
                    r = arguments[0], e = t.inferModuleName(r), i = arguments[1];
                    break;
                case 3:
                    e = arguments[0], r = arguments[1], i = arguments[2];
                    break;
                default:
                    throw"illegal argument length: " + arguments.length, arguments
            }
            return t.module(e, [])[o](r, i)
        }
    }), window.Diandanbao = t
}(), function (e, t) {
    "object" == typeof exports ? module.exports = t() : "function" == typeof define && define.amd ? define(t) : e.printStackTrace = t()
}(this, function () {
    function e(t) {
        t = t || {guess: !0};
        var n = t.e || null, r = !!t.guess, i = new e.implementation, o = i.run(n);
        return r ? i.guessAnonymousFunctions(o) : o
    }

    return e.implementation = function () {
    }, e.implementation.prototype = {
        run: function (e, t) {
            return e = e || this.createException(), t = t || this.mode(e), "other" === t ? this.other(arguments.callee) : this[t](e)
        }, createException: function () {
            try {
                this.undef()
            } catch (e) {
                return e
            }
        }, mode: function (e) {
            return e.arguments && e.stack ? "chrome" : e.stack && e.sourceURL ? "safari" : e.stack && e.number ? "ie" : e.stack && e.fileName ? "firefox" : e.message && e["opera#sourceloc"] ? e.stacktrace ? e.message.indexOf("\n") > -1 && e.message.split("\n").length > e.stacktrace.split("\n").length ? "opera9" : "opera10a" : "opera9" : e.message && e.stack && e.stacktrace ? e.stacktrace.indexOf("called from line") < 0 ? "opera10b" : "opera11" : e.stack && !e.fileName ? "chrome" : "other"
        }, instrumentFunction: function (t, n, r) {
            t = t || window;
            var i = t[n];
            t[n] = function () {
                return r.call(this, e().slice(4)), t[n]._instrumented.apply(this, arguments)
            }, t[n]._instrumented = i
        }, deinstrumentFunction: function (e, t) {
            e[t].constructor === Function && e[t]._instrumented && e[t]._instrumented.constructor === Function && (e[t] = e[t]._instrumented)
        }, chrome: function (e) {
            return (e.stack + "\n").replace(/^[\s\S]+?\s+at\s+/, " at ").replace(/^\s+(at eval )?at\s+/gm, "").replace(/^([^\(]+?)([\n$])/gm, "{anonymous}() ($1)$2").replace(/^Object.<anonymous>\s*\(([^\)]+)\)/gm, "{anonymous}() ($1)").replace(/^(.+) \((.+)\)$/gm, "$1@$2").split("\n").slice(0, -1)
        }, safari: function (e) {
            return e.stack.replace(/\[native code\]\n/m, "").replace(/^(?=\w+Error\:).*$\n/m, "").replace(/^@/gm, "{anonymous}()@").split("\n")
        }, ie: function (e) {
            return e.stack.replace(/^\s*at\s+(.*)$/gm, "$1").replace(/^Anonymous function\s+/gm, "{anonymous}() ").replace(/^(.+)\s+\((.+)\)$/gm, "$1@$2").split("\n").slice(1)
        }, firefox: function (e) {
            return e.stack.replace(/(?:\n@:0)?\s+$/m, "").replace(/^(?:\((\S*)\))?@/gm, "{anonymous}($1)@").split("\n")
        }, opera11: function (e) {
            for (var t = "{anonymous}", n = /^.*line (\d+), column (\d+)(?: in (.+))? in (\S+):$/, r = e.stacktrace.split("\n"), i = [], o = 0, a = r.length; a > o; o += 2) {
                var s = n.exec(r[o]);
                if (s) {
                    var c = s[4] + ":" + s[1] + ":" + s[2], l = s[3] || "global code";
                    l = l.replace(/<anonymous function: (\S+)>/, "$1").replace(/<anonymous function>/, t), i.push(l + "@" + c + " -- " + r[o + 1].replace(/^\s+/, ""))
                }
            }
            return i
        }, opera10b: function (e) {
            for (var t = /^(.*)@(.+):(\d+)$/, n = e.stacktrace.split("\n"), r = [], i = 0, o = n.length; o > i; i++) {
                var a = t.exec(n[i]);
                if (a) {
                    var s = a[1] ? a[1] + "()" : "global code";
                    r.push(s + "@" + a[2] + ":" + a[3])
                }
            }
            return r
        }, opera10a: function (e) {
            for (var t = "{anonymous}", n = /Line (\d+).*script (?:in )?(\S+)(?:: In function (\S+))?$/i, r = e.stacktrace.split("\n"), i = [], o = 0, a = r.length; a > o; o += 2) {
                var s = n.exec(r[o]);
                if (s) {
                    var c = s[3] || t;
                    i.push(c + "()@" + s[2] + ":" + s[1] + " -- " + r[o + 1].replace(/^\s+/, ""))
                }
            }
            return i
        }, opera9: function (e) {
            for (var t = "{anonymous}", n = /Line (\d+).*script (?:in )?(\S+)/i, r = e.message.split("\n"), i = [], o = 2, a = r.length; a > o; o += 2) {
                var s = n.exec(r[o]);
                s && i.push(t + "()@" + s[2] + ":" + s[1] + " -- " + r[o + 1].replace(/^\s+/, ""))
            }
            return i
        }, other: function (e) {
            for (var t, n, r = "{anonymous}", i = /function(?:\s+([\w$]+))?\s*\(/, o = [], a = 10, s = Array.prototype.slice; e && o.length < a;) {
                t = i.test(e.toString()) ? RegExp.$1 || r : r;
                try {
                    n = s.call(e.arguments || [])
                } catch (c) {
                    n = ["Cannot access arguments: " + c]
                }
                o[o.length] = t + "(" + this.stringifyArguments(n) + ")";
                try {
                    e = e.caller
                } catch (c) {
                    o[o.length] = "Cannot access caller: " + c;
                    break
                }
            }
            return o
        }, stringifyArguments: function (e) {
            for (var t = [], n = Array.prototype.slice, r = 0; r < e.length; ++r) {
                var i = e[r];
                void 0 === i ? t[r] = "undefined" : null === i ? t[r] = "null" : i.constructor && (t[r] = i.constructor === Array ? i.length < 3 ? "[" + this.stringifyArguments(i) + "]" : "[" + this.stringifyArguments(n.call(i, 0, 1)) + "..." + this.stringifyArguments(n.call(i, -1)) + "]" : i.constructor === Object ? "#object" : i.constructor === Function ? "#function" : i.constructor === String ? '"' + i + '"' : i.constructor === Number ? i : "?")
            }
            return t.join(",")
        }, sourceCache: {}, ajax: function (e) {
            var t = this.createXMLHTTPObject();
            if (t)try {
                return t.open("GET", e, !1), t.send(null), t.responseText
            } catch (n) {
            }
            return ""
        }, createXMLHTTPObject: function () {
            for (var e, t = [function () {
                return new XMLHttpRequest
            }, function () {
                return new ActiveXObject("Msxml2.XMLHTTP")
            }, function () {
                return new ActiveXObject("Msxml3.XMLHTTP")
            }, function () {
                return new ActiveXObject("Microsoft.XMLHTTP")
            }], n = 0; n < t.length; n++)try {
                return e = t[n](), this.createXMLHTTPObject = t[n], e
            } catch (r) {
            }
        }, isSameDomain: function (e) {
            return "undefined" != typeof location && -1 !== e.indexOf(location.hostname)
        }, getSource: function (e) {
            return e in this.sourceCache || (this.sourceCache[e] = this.ajax(e).split("\n")), this.sourceCache[e]
        }, guessAnonymousFunctions: function (e) {
            for (var t = 0; t < e.length; ++t) {
                var n = /\{anonymous\}\(.*\)@(.*)/, r = /^(.*?)(?::(\d+))(?::(\d+))?(?: -- .+)?$/, i = e[t], o = n.exec(i);
                if (o) {
                    var a = r.exec(o[1]);
                    if (a) {
                        var s = a[1], c = a[2], l = a[3] || 0;
                        if (s && this.isSameDomain(s) && c) {
                            var u = this.guessAnonymousFunction(s, c, l);
                            e[t] = i.replace("{anonymous}", u)
                        }
                    }
                }
            }
            return e
        }, guessAnonymousFunction: function (e, t) {
            var n;
            try {
                n = this.findFunctionName(this.getSource(e), t)
            } catch (r) {
                n = "getSource failed with url: " + e + ", exception: " + r.toString()
            }
            return n
        }, findFunctionName: function (e, t) {
            for (var n, r, i, o = /function\s+([^(]*?)\s*\(([^)]*)\)/, a = /['"]?([$_A-Za-z][$_A-Za-z0-9]*)['"]?\s*[:=]\s*function\b/, s = /['"]?([$_A-Za-z][$_A-Za-z0-9]*)['"]?\s*[:=]\s*(?:eval|new Function)\b/, c = "", l = Math.min(t, 20), u = 0; l > u; ++u)if (n = e[t - u - 1], i = n.indexOf("//"), i >= 0 && (n = n.substr(0, i)), n) {
                if (c = n + c, r = a.exec(c), r && r[1])return r[1];
                if (r = o.exec(c), r && r[1])return r[1];
                if (r = s.exec(c), r && r[1])return r[1]
            }
            return "(?)"
        }
    }, e
});
var Swiper = function (e, t) {
    "use strict";
    function n(e, t) {
        return document.querySelectorAll ? (t || document).querySelectorAll(e) : jQuery(e, t)
    }

    function r(e) {
        return "[object Array]" === Object.prototype.toString.apply(e) ? !0 : !1
    }

    function i() {
        var e = D - O;
        return t.freeMode && (e = D - O), t.slidesPerView > E.slides.length && !t.centeredSlides && (e = 0), 0 > e && (e = 0), e
    }

    function o() {
        function e(e) {
            var n = new Image;
            n.onload = function () {
                "undefined" != typeof E && null !== E && (void 0 !== E.imagesLoaded && E.imagesLoaded++, E.imagesLoaded === E.imagesToLoad.length && (E.reInit(), t.onImagesReady && E.fireCallback(t.onImagesReady, E)))
            }, n.src = e
        }

        var r = E.h.addEventListener, i = "wrapper" === t.eventTarget ? E.wrapper : E.container;
        if (E.browser.ie10 || E.browser.ie11 ? (r(i, E.touchEvents.touchStart, m), r(document, E.touchEvents.touchMove, g), r(document, E.touchEvents.touchEnd, v)) : (E.support.touch && (r(i, "touchstart", m), r(i, "touchmove", g), r(i, "touchend", v)), t.simulateTouch && (r(i, "mousedown", m), r(document, "mousemove", g), r(document, "mouseup", v))), t.autoResize && r(window, "resize", E.resizeFix), a(), E._wheelEvent = !1, t.mousewheelControl) {
            if (void 0 !== document.onmousewheel && (E._wheelEvent = "mousewheel"), !E._wheelEvent)try {
                new WheelEvent("wheel"), E._wheelEvent = "wheel"
            } catch (o) {
            }
            E._wheelEvent || (E._wheelEvent = "DOMMouseScroll"), E._wheelEvent && r(E.container, E._wheelEvent, l)
        }
        if (t.keyboardControl && r(document, "keydown", c), t.updateOnImagesReady) {
            E.imagesToLoad = n("img", E.container);
            for (var s = 0; s < E.imagesToLoad.length; s++)e(E.imagesToLoad[s].getAttribute("src"))
        }
    }

    function a() {
        var e, r = E.h.addEventListener;
        if (t.preventLinks) {
            var i = n("a", E.container);
            for (e = 0; e < i.length; e++)r(i[e], "click", f)
        }
        if (t.releaseFormElements) {
            var o = n("input, textarea, select", E.container);
            for (e = 0; e < o.length; e++)r(o[e], E.touchEvents.touchStart, h, !0)
        }
        if (t.onSlideClick)for (e = 0; e < E.slides.length; e++)r(E.slides[e], "click", u);
        if (t.onSlideTouch)for (e = 0; e < E.slides.length; e++)r(E.slides[e], E.touchEvents.touchStart, d)
    }

    function s() {
        var e, r = E.h.removeEventListener;
        if (t.onSlideClick)for (e = 0; e < E.slides.length; e++)r(E.slides[e], "click", u);
        if (t.onSlideTouch)for (e = 0; e < E.slides.length; e++)r(E.slides[e], E.touchEvents.touchStart, d);
        if (t.releaseFormElements) {
            var i = n("input, textarea, select", E.container);
            for (e = 0; e < i.length; e++)r(i[e], E.touchEvents.touchStart, h, !0)
        }
        if (t.preventLinks) {
            var o = n("a", E.container);
            for (e = 0; e < o.length; e++)r(o[e], "click", f)
        }
    }

    function c(e) {
        var t = e.keyCode || e.charCode;
        if (!(e.shiftKey || e.altKey || e.ctrlKey || e.metaKey)) {
            if (37 === t || 39 === t || 38 === t || 40 === t) {
                for (var n = !1, r = E.h.getOffset(E.container), i = E.h.windowScroll().left, o = E.h.windowScroll().top, a = E.h.windowWidth(), s = E.h.windowHeight(), c = [[r.left, r.top], [r.left + E.width, r.top], [r.left, r.top + E.height], [r.left + E.width, r.top + E.height]], l = 0; l < c.length; l++) {
                    var u = c[l];
                    u[0] >= i && u[0] <= i + a && u[1] >= o && u[1] <= o + s && (n = !0)
                }
                if (!n)return
            }
            R ? ((37 === t || 39 === t) && (e.preventDefault ? e.preventDefault() : e.returnValue = !1), 39 === t && E.swipeNext(), 37 === t && E.swipePrev()) : ((38 === t || 40 === t) && (e.preventDefault ? e.preventDefault() : e.returnValue = !1), 40 === t && E.swipeNext(), 38 === t && E.swipePrev())
        }
    }

    function l(e) {
        var n = E._wheelEvent, r = 0;
        if (e.detail)r = -e.detail; else if ("mousewheel" === n)if (t.mousewheelControlForceToAxis)if (R) {
            if (!(Math.abs(e.wheelDeltaX) > Math.abs(e.wheelDeltaY)))return;
            r = e.wheelDeltaX
        } else {
            if (!(Math.abs(e.wheelDeltaY) > Math.abs(e.wheelDeltaX)))return;
            r = e.wheelDeltaY
        } else r = e.wheelDelta; else if ("DOMMouseScroll" === n)r = -e.detail; else if ("wheel" === n)if (t.mousewheelControlForceToAxis)if (R) {
            if (!(Math.abs(e.deltaX) > Math.abs(e.deltaY)))return;
            r = -e.deltaX
        } else {
            if (!(Math.abs(e.deltaY) > Math.abs(e.deltaX)))return;
            r = -e.deltaY
        } else r = Math.abs(e.deltaX) > Math.abs(e.deltaY) ? -e.deltaX : -e.deltaY;
        if (t.freeMode) {
            var o = E.getWrapperTranslate() + r;
            if (o > 0 && (o = 0), o < -i() && (o = -i()), E.setWrapperTransition(0), E.setWrapperTranslate(o), E.updateActiveSlide(o), 0 === o || o === -i())return
        } else(new Date).getTime() - W > 60 && (0 > r ? E.swipeNext() : E.swipePrev()), W = (new Date).getTime();
        return t.autoplay && E.stopAutoplay(!0), e.preventDefault ? e.preventDefault() : e.returnValue = !1, !1
    }

    function u(e) {
        E.allowSlideClick && (p(e), E.fireCallback(t.onSlideClick, E, e))
    }

    function d(e) {
        p(e), E.fireCallback(t.onSlideTouch, E, e)
    }

    function p(e) {
        if (e.currentTarget)E.clickedSlide = e.currentTarget; else {
            var n = e.srcElement;
            do {
                if (n.className.indexOf(t.slideClass) > -1)break;
                n = n.parentNode
            } while (n);
            E.clickedSlide = n
        }
        E.clickedSlideIndex = E.slides.indexOf(E.clickedSlide), E.clickedSlideLoopIndex = E.clickedSlideIndex - (E.loopedSlides || 0)
    }

    function f(e) {
        return E.allowLinks ? void 0 : (e.preventDefault ? e.preventDefault() : e.returnValue = !1, t.preventLinksPropagation && "stopPropagation"in e && e.stopPropagation(), !1)
    }

    function h(e) {
        return e.stopPropagation ? e.stopPropagation() : e.returnValue = !1, !1
    }

    function m(e) {
        if (t.preventLinks && (E.allowLinks = !0), E.isTouched || t.onlyExternal)return !1;
        var n = e.target || e.srcElement;
        document.activeElement && document.activeElement !== n && document.activeElement.blur();
        var r = "input select textarea".split(" ");
        if (t.noSwiping && n && _(n))return !1;
        if (J = !1, E.isTouched = !0, K = "touchstart" === e.type, !K && "which"in e && 3 === e.which)return !1;
        if (!K || 1 === e.targetTouches.length) {
            E.callPlugins("onTouchStartBegin"), !K && !E.isAndroid && r.indexOf(n.tagName.toLowerCase()) < 0 && (e.preventDefault ? e.preventDefault() : e.returnValue = !1);
            var i = K ? e.targetTouches[0].pageX : e.pageX || e.clientX, o = K ? e.targetTouches[0].pageY : e.pageY || e.clientY;
            E.touches.startX = E.touches.currentX = i, E.touches.startY = E.touches.currentY = o, E.touches.start = E.touches.current = R ? i : o, E.setWrapperTransition(0), E.positions.start = E.positions.current = E.getWrapperTranslate(), E.setWrapperTranslate(E.positions.start), E.times.start = (new Date).getTime(), L = void 0, t.moveStartThreshold > 0 && (X = !1), t.onTouchStart && E.fireCallback(t.onTouchStart, E, e), E.callPlugins("onTouchStartEnd")
        }
    }

    function g(e) {
        if (E.isTouched && !t.onlyExternal && (!K || "mousemove" !== e.type)) {
            var n = K ? e.targetTouches[0].pageX : e.pageX || e.clientX, r = K ? e.targetTouches[0].pageY : e.pageY || e.clientY;
            if ("undefined" == typeof L && R && (L = !!(L || Math.abs(r - E.touches.startY) > Math.abs(n - E.touches.startX))), "undefined" != typeof L || R || (L = !!(L || Math.abs(r - E.touches.startY) < Math.abs(n - E.touches.startX))), L)return void(E.isTouched = !1);
            if (R) {
                if (!t.swipeToNext && n < E.touches.startX || !t.swipeToPrev && n > E.touches.startX)return
            } else if (!t.swipeToNext && r < E.touches.startY || !t.swipeToPrev && r > E.touches.startY)return;
            if (e.assignedToSwiper)return void(E.isTouched = !1);
            if (e.assignedToSwiper = !0, t.preventLinks && (E.allowLinks = !1), t.onSlideClick && (E.allowSlideClick = !1), t.autoplay && E.stopAutoplay(!0), !K || 1 === e.touches.length) {
                if (E.isMoved || (E.callPlugins("onTouchMoveStart"), t.loop && (E.fixLoop(), E.positions.start = E.getWrapperTranslate()), t.onTouchMoveStart && E.fireCallback(t.onTouchMoveStart, E)), E.isMoved = !0, e.preventDefault ? e.preventDefault() : e.returnValue = !1, E.touches.current = R ? n : r, E.positions.current = (E.touches.current - E.touches.start) * t.touchRatio + E.positions.start, E.positions.current > 0 && t.onResistanceBefore && E.fireCallback(t.onResistanceBefore, E, E.positions.current), E.positions.current < -i() && t.onResistanceAfter && E.fireCallback(t.onResistanceAfter, E, Math.abs(E.positions.current + i())), t.resistance && "100%" !== t.resistance) {
                    var o;
                    if (E.positions.current > 0 && (o = 1 - E.positions.current / O / 2, E.positions.current = .5 > o ? O / 2 : E.positions.current * o), E.positions.current < -i()) {
                        var a = (E.touches.current - E.touches.start) * t.touchRatio + (i() + E.positions.start);
                        o = (O + a) / O;
                        var s = E.positions.current - a * (1 - o) / 2, c = -i() - O / 2;
                        E.positions.current = c > s || 0 >= o ? c : s
                    }
                }
                if (t.resistance && "100%" === t.resistance && (E.positions.current > 0 && (!t.freeMode || t.freeModeFluid) && (E.positions.current = 0), E.positions.current < -i() && (!t.freeMode || t.freeModeFluid) && (E.positions.current = -i())), !t.followFinger)return;
                if (t.moveStartThreshold)if (Math.abs(E.touches.current - E.touches.start) > t.moveStartThreshold || X) {
                    if (!X)return X = !0, void(E.touches.start = E.touches.current);
                    E.setWrapperTranslate(E.positions.current)
                } else E.positions.current = E.positions.start; else E.setWrapperTranslate(E.positions.current);
                return (t.freeMode || t.watchActiveIndex) && E.updateActiveSlide(E.positions.current), t.grabCursor && (E.container.style.cursor = "move", E.container.style.cursor = "grabbing", E.container.style.cursor = "-moz-grabbin", E.container.style.cursor = "-webkit-grabbing"), Y || (Y = E.touches.current), Q || (Q = (new Date).getTime()), E.velocity = (E.touches.current - Y) / ((new Date).getTime() - Q) / 2, Math.abs(E.touches.current - Y) < 2 && (E.velocity = 0), Y = E.touches.current, Q = (new Date).getTime(), E.callPlugins("onTouchMoveEnd"), t.onTouchMove && E.fireCallback(t.onTouchMove, E, e), !1
            }
        }
    }

    function v(e) {
        if (L && E.swipeReset(), !t.onlyExternal && E.isTouched) {
            E.isTouched = !1, t.grabCursor && (E.container.style.cursor = "move", E.container.style.cursor = "grab", E.container.style.cursor = "-moz-grab", E.container.style.cursor = "-webkit-grab"), E.positions.current || 0 === E.positions.current || (E.positions.current = E.positions.start), t.followFinger && E.setWrapperTranslate(E.positions.current), E.times.end = (new Date).getTime(), E.touches.diff = E.touches.current - E.touches.start, E.touches.abs = Math.abs(E.touches.diff), E.positions.diff = E.positions.current - E.positions.start, E.positions.abs = Math.abs(E.positions.diff);
            var n = E.positions.diff, r = E.positions.abs, o = E.times.end - E.times.start;
            5 > r && 300 > o && E.allowLinks === !1 && (t.freeMode || 0 === r || E.swipeReset(), t.preventLinks && (E.allowLinks = !0), t.onSlideClick && (E.allowSlideClick = !0)), setTimeout(function () {
                "undefined" != typeof E && null !== E && (t.preventLinks && (E.allowLinks = !0), t.onSlideClick && (E.allowSlideClick = !0))
            }, 100);
            var a = i();
            if (!E.isMoved && t.freeMode)return E.isMoved = !1, t.onTouchEnd && E.fireCallback(t.onTouchEnd, E, e), void E.callPlugins("onTouchEnd");
            if (!E.isMoved || E.positions.current > 0 || E.positions.current < -a)return E.swipeReset(), t.onTouchEnd && E.fireCallback(t.onTouchEnd, E, e), void E.callPlugins("onTouchEnd");
            if (E.isMoved = !1, t.freeMode) {
                if (t.freeModeFluid) {
                    var s, c = 1e3 * t.momentumRatio, l = E.velocity * c, u = E.positions.current + l, d = !1, p = 20 * Math.abs(E.velocity) * t.momentumBounceRatio;
                    -a > u && (t.momentumBounce && E.support.transitions ? (-p > u + a && (u = -a - p), s = -a, d = !0, J = !0) : u = -a), u > 0 && (t.momentumBounce && E.support.transitions ? (u > p && (u = p), s = 0, d = !0, J = !0) : u = 0), 0 !== E.velocity && (c = Math.abs((u - E.positions.current) / E.velocity)), E.setWrapperTranslate(u), E.setWrapperTransition(c), t.momentumBounce && d && E.wrapperTransitionEnd(function () {
                        J && (t.onMomentumBounce && E.fireCallback(t.onMomentumBounce, E), E.callPlugins("onMomentumBounce"), E.setWrapperTranslate(s), E.setWrapperTransition(300))
                    }), E.updateActiveSlide(u)
                }
                return (!t.freeModeFluid || o >= 300) && E.updateActiveSlide(E.positions.current), t.onTouchEnd && E.fireCallback(t.onTouchEnd, E, e), void E.callPlugins("onTouchEnd")
            }
            q = 0 > n ? "toNext" : "toPrev", "toNext" === q && 300 >= o && (30 > r || !t.shortSwipes ? E.swipeReset() : E.swipeNext(!0)), "toPrev" === q && 300 >= o && (30 > r || !t.shortSwipes ? E.swipeReset() : E.swipePrev(!0));
            var f = 0;
            if ("auto" === t.slidesPerView) {
                for (var h, m = Math.abs(E.getWrapperTranslate()), g = 0, v = 0; v < E.slides.length; v++)if (h = R ? E.slides[v].getWidth(!0, t.roundLengths) : E.slides[v].getHeight(!0, t.roundLengths), g += h, g > m) {
                    f = h;
                    break
                }
                f > O && (f = O)
            } else f = M * t.slidesPerView;
            "toNext" === q && o > 300 && (r >= f * t.longSwipesRatio ? E.swipeNext(!0) : E.swipeReset()), "toPrev" === q && o > 300 && (r >= f * t.longSwipesRatio ? E.swipePrev(!0) : E.swipeReset()), t.onTouchEnd && E.fireCallback(t.onTouchEnd, E, e), E.callPlugins("onTouchEnd")
        }
    }

    function _(e) {
        var n = !1;
        do e.className.indexOf(t.noSwipingClass) > -1 && (n = !0), e = e.parentElement; while (!n && e.parentElement && -1 === e.className.indexOf(t.wrapperClass));
        return !n && e.className.indexOf(t.wrapperClass) > -1 && e.className.indexOf(t.noSwipingClass) > -1 && (n = !0), n
    }

    function y(e, t) {
        var n, r = document.createElement("div");
        return r.innerHTML = t, n = r.firstChild, n.className += " " + e, n.outerHTML
    }

    function b(e, n, r) {
        function i() {
            var o = +new Date, d = o - a;
            s += c * d / (1e3 / 60), u = "toNext" === l ? s > e : e > s, u ? (E.setWrapperTranslate(Math.ceil(s)), E._DOMAnimating = !0, window.setTimeout(function () {
                i()
            }, 1e3 / 60)) : (t.onSlideChangeEnd && ("to" === n ? r.runCallbacks === !0 && E.fireCallback(t.onSlideChangeEnd, E, l) : E.fireCallback(t.onSlideChangeEnd, E, l)), E.setWrapperTranslate(e), E._DOMAnimating = !1)
        }

        var o = "to" === n && r.speed >= 0 ? r.speed : t.speed, a = +new Date;
        if (E.support.transitions || !t.DOMAnimation)E.setWrapperTranslate(e), E.setWrapperTransition(o); else {
            var s = E.getWrapperTranslate(), c = Math.ceil((e - s) / o * (1e3 / 60)), l = s > e ? "toNext" : "toPrev", u = "toNext" === l ? s > e : e > s;
            if (E._DOMAnimating)return;
            i()
        }
        E.updateActiveSlide(e), t.onSlideNext && "next" === n && E.fireCallback(t.onSlideNext, E, e), t.onSlidePrev && "prev" === n && E.fireCallback(t.onSlidePrev, E, e), t.onSlideReset && "reset" === n && E.fireCallback(t.onSlideReset, E, e), ("next" === n || "prev" === n || "to" === n && r.runCallbacks === !0) && $(n)
    }

    function $(e) {
        if (E.callPlugins("onSlideChangeStart"), t.onSlideChangeStart)if (t.queueStartCallbacks && E.support.transitions) {
            if (E._queueStartCallbacks)return;
            E._queueStartCallbacks = !0, E.fireCallback(t.onSlideChangeStart, E, e), E.wrapperTransitionEnd(function () {
                E._queueStartCallbacks = !1
            })
        } else E.fireCallback(t.onSlideChangeStart, E, e);
        if (t.onSlideChangeEnd)if (E.support.transitions)if (t.queueEndCallbacks) {
            if (E._queueEndCallbacks)return;
            E._queueEndCallbacks = !0, E.wrapperTransitionEnd(function (n) {
                E.fireCallback(t.onSlideChangeEnd, n, e)
            })
        } else E.wrapperTransitionEnd(function (n) {
            E.fireCallback(t.onSlideChangeEnd, n, e)
        }); else t.DOMAnimation || setTimeout(function () {
            E.fireCallback(t.onSlideChangeEnd, E, e)
        }, 10)
    }

    function w() {
        var e = E.paginationButtons;
        if (e)for (var t = 0; t < e.length; t++)E.h.removeEventListener(e[t], "click", S)
    }

    function x() {
        var e = E.paginationButtons;
        if (e)for (var t = 0; t < e.length; t++)E.h.addEventListener(e[t], "click", S)
    }

    function S(e) {
        for (var n, r = e.target || e.srcElement, i = E.paginationButtons, o = 0; o < i.length; o++)r === i[o] && (n = o);
        t.autoplay && E.stopAutoplay(!0), E.swipeTo(n)
    }

    function C() {
        Z = setTimeout(function () {
            t.loop ? (E.fixLoop(), E.swipeNext(!0)) : E.swipeNext(!0) || (t.autoplayStopOnLast ? (clearTimeout(Z), Z = void 0) : E.swipeTo(0)), E.wrapperTransitionEnd(function () {
                "undefined" != typeof Z && C()
            })
        }, t.autoplay)
    }

    function k() {
        E.calcSlides(), t.loader.slides.length > 0 && 0 === E.slides.length && E.loadSlides(), t.loop && E.createLoop(), E.init(), o(), t.pagination && E.createPagination(!0), t.loop || t.initialSlide > 0 ? E.swipeTo(t.initialSlide, 0, !1) : E.updateActiveSlide(0), t.autoplay && E.startAutoplay(), E.centerIndex = E.activeIndex, t.onSwiperCreated && E.fireCallback(t.onSwiperCreated, E), E.callPlugins("onSwiperCreated")
    }

    if (!document.body.outerHTML && document.body.__defineGetter__ && HTMLElement) {
        var T = HTMLElement.prototype;
        T.__defineGetter__ && T.__defineGetter__("outerHTML", function () {
            return (new XMLSerializer).serializeToString(this)
        })
    }
    if (window.getComputedStyle || (window.getComputedStyle = function (e) {
            return this.el = e, this.getPropertyValue = function (t) {
                var n = /(\-([a-z]){1})/g;
                return "float" === t && (t = "styleFloat"), n.test(t) && (t = t.replace(n, function () {
                    return arguments[2].toUpperCase()
                })), e.currentStyle[t] ? e.currentStyle[t] : null
            }, this
        }), Array.prototype.indexOf || (Array.prototype.indexOf = function (e, t) {
            for (var n = t || 0, r = this.length; r > n; n++)if (this[n] === e)return n;
            return -1
        }), (document.querySelectorAll || window.jQuery) && "undefined" != typeof e && (e.nodeType || 0 !== n(e).length)) {
        var E = this;
        E.touches = {
            start: 0,
            startX: 0,
            startY: 0,
            current: 0,
            currentX: 0,
            currentY: 0,
            diff: 0,
            abs: 0
        }, E.positions = {start: 0, abs: 0, diff: 0, current: 0}, E.times = {
            start: 0,
            end: 0
        }, E.id = (new Date).getTime(), E.container = e.nodeType ? e : n(e)[0], E.isTouched = !1, E.isMoved = !1, E.activeIndex = 0, E.centerIndex = 0, E.activeLoaderIndex = 0, E.activeLoopIndex = 0, E.previousIndex = null, E.velocity = 0, E.snapGrid = [], E.slidesGrid = [], E.imagesToLoad = [], E.imagesLoaded = 0, E.wrapperLeft = 0, E.wrapperRight = 0, E.wrapperTop = 0, E.wrapperBottom = 0, E.isAndroid = navigator.userAgent.toLowerCase().indexOf("android") >= 0;
        var A, M, D, q, L, O, P = {
            eventTarget: "wrapper",
            mode: "horizontal",
            touchRatio: 1,
            speed: 300,
            freeMode: !1,
            freeModeFluid: !1,
            momentumRatio: 1,
            momentumBounce: !0,
            momentumBounceRatio: 1,
            slidesPerView: 1,
            slidesPerGroup: 1,
            slidesPerViewFit: !0,
            simulateTouch: !0,
            followFinger: !0,
            shortSwipes: !0,
            longSwipesRatio: .5,
            moveStartThreshold: !1,
            onlyExternal: !1,
            createPagination: !0,
            pagination: !1,
            paginationElement: "span",
            paginationClickable: !1,
            paginationAsRange: !0,
            resistance: !0,
            scrollContainer: !1,
            preventLinks: !0,
            preventLinksPropagation: !1,
            noSwiping: !1,
            noSwipingClass: "swiper-no-swiping",
            initialSlide: 0,
            keyboardControl: !1,
            mousewheelControl: !1,
            mousewheelControlForceToAxis: !1,
            useCSS3Transforms: !0,
            autoplay: !1,
            autoplayDisableOnInteraction: !0,
            autoplayStopOnLast: !1,
            loop: !1,
            loopAdditionalSlides: 0,
            roundLengths: !1,
            calculateHeight: !1,
            cssWidthAndHeight: !1,
            updateOnImagesReady: !0,
            releaseFormElements: !0,
            watchActiveIndex: !1,
            visibilityFullFit: !1,
            offsetPxBefore: 0,
            offsetPxAfter: 0,
            offsetSlidesBefore: 0,
            offsetSlidesAfter: 0,
            centeredSlides: !1,
            queueStartCallbacks: !1,
            queueEndCallbacks: !1,
            autoResize: !0,
            resizeReInit: !1,
            DOMAnimation: !0,
            loader: {slides: [], slidesHTMLType: "inner", surroundGroups: 1, logic: "reload", loadAllSlides: !1},
            swipeToPrev: !0,
            swipeToNext: !0,
            slideElement: "div",
            slideClass: "swiper-slide",
            slideActiveClass: "swiper-slide-active",
            slideVisibleClass: "swiper-slide-visible",
            slideDuplicateClass: "swiper-slide-duplicate",
            wrapperClass: "swiper-wrapper",
            paginationElementClass: "swiper-pagination-switch",
            paginationActiveClass: "swiper-active-switch",
            paginationVisibleClass: "swiper-visible-switch"
        };
        t = t || {};
        for (var N in P)if (N in t && "object" == typeof t[N])for (var j in P[N])j in t[N] || (t[N][j] = P[N][j]); else N in t || (t[N] = P[N]);
        E.params = t, t.scrollContainer && (t.freeMode = !0, t.freeModeFluid = !0), t.loop && (t.resistance = "100%");
        var R = "horizontal" === t.mode, I = ["mousedown", "mousemove", "mouseup"];
        E.browser.ie10 && (I = ["MSPointerDown", "MSPointerMove", "MSPointerUp"]), E.browser.ie11 && (I = ["pointerdown", "pointermove", "pointerup"]), E.touchEvents = {
            touchStart: E.support.touch || !t.simulateTouch ? "touchstart" : I[0],
            touchMove: E.support.touch || !t.simulateTouch ? "touchmove" : I[1],
            touchEnd: E.support.touch || !t.simulateTouch ? "touchend" : I[2]
        };
        for (var U = E.container.childNodes.length - 1; U >= 0; U--)if (E.container.childNodes[U].className)for (var B = E.container.childNodes[U].className.split(/\s+/), F = 0; F < B.length; F++)B[F] === t.wrapperClass && (A = E.container.childNodes[U]);
        E.wrapper = A, E._extendSwiperSlide = function (e) {
            return e.append = function () {
                return t.loop ? e.insertAfter(E.slides.length - E.loopedSlides) : (E.wrapper.appendChild(e), E.reInit()), e
            }, e.prepend = function () {
                return t.loop ? (E.wrapper.insertBefore(e, E.slides[E.loopedSlides]), E.removeLoopedSlides(), E.calcSlides(), E.createLoop()) : E.wrapper.insertBefore(e, E.wrapper.firstChild), E.reInit(), e
            }, e.insertAfter = function (n) {
                if ("undefined" == typeof n)return !1;
                var r;
                return t.loop ? (r = E.slides[n + 1 + E.loopedSlides], r ? E.wrapper.insertBefore(e, r) : E.wrapper.appendChild(e), E.removeLoopedSlides(), E.calcSlides(), E.createLoop()) : (r = E.slides[n + 1], E.wrapper.insertBefore(e, r)), E.reInit(), e
            }, e.clone = function () {
                return E._extendSwiperSlide(e.cloneNode(!0))
            }, e.remove = function () {
                E.wrapper.removeChild(e), E.reInit()
            }, e.html = function (t) {
                return "undefined" == typeof t ? e.innerHTML : (e.innerHTML = t, e)
            }, e.index = function () {
                for (var t, n = E.slides.length - 1; n >= 0; n--)e === E.slides[n] && (t = n);
                return t
            }, e.isActive = function () {
                return e.index() === E.activeIndex ? !0 : !1
            }, e.swiperSlideDataStorage || (e.swiperSlideDataStorage = {}), e.getData = function (t) {
                return e.swiperSlideDataStorage[t]
            }, e.setData = function (t, n) {
                return e.swiperSlideDataStorage[t] = n, e
            }, e.data = function (t, n) {
                return "undefined" == typeof n ? e.getAttribute("data-" + t) : (e.setAttribute("data-" + t, n), e)
            }, e.getWidth = function (t, n) {
                return E.h.getWidth(e, t, n)
            }, e.getHeight = function (t, n) {
                return E.h.getHeight(e, t, n)
            }, e.getOffset = function () {
                return E.h.getOffset(e)
            }, e
        }, E.calcSlides = function (e) {
            var n = E.slides ? E.slides.length : !1;
            E.slides = [], E.displaySlides = [];
            for (var r = 0; r < E.wrapper.childNodes.length; r++)if (E.wrapper.childNodes[r].className)for (var i = E.wrapper.childNodes[r].className, o = i.split(/\s+/), c = 0; c < o.length; c++)o[c] === t.slideClass && E.slides.push(E.wrapper.childNodes[r]);
            for (r = E.slides.length - 1; r >= 0; r--)E._extendSwiperSlide(E.slides[r]);
            n !== !1 && (n !== E.slides.length || e) && (s(), a(), E.updateActiveSlide(), E.params.pagination && E.createPagination(), E.callPlugins("numberOfSlidesChanged"))
        }, E.createSlide = function (e, n, r) {
            n = n || E.params.slideClass, r = r || t.slideElement;
            var i = document.createElement(r);
            return i.innerHTML = e || "", i.className = n, E._extendSwiperSlide(i)
        }, E.appendSlide = function (e, t, n) {
            return e ? e.nodeType ? E._extendSwiperSlide(e).append() : E.createSlide(e, t, n).append() : void 0
        }, E.prependSlide = function (e, t, n) {
            return e ? e.nodeType ? E._extendSwiperSlide(e).prepend() : E.createSlide(e, t, n).prepend() : void 0
        }, E.insertSlideAfter = function (e, t, n, r) {
            return "undefined" == typeof e ? !1 : t.nodeType ? E._extendSwiperSlide(t).insertAfter(e) : E.createSlide(t, n, r).insertAfter(e)
        }, E.removeSlide = function (e) {
            if (E.slides[e]) {
                if (t.loop) {
                    if (!E.slides[e + E.loopedSlides])return !1;
                    E.slides[e + E.loopedSlides].remove(), E.removeLoopedSlides(), E.calcSlides(), E.createLoop()
                } else E.slides[e].remove();
                return !0
            }
            return !1
        }, E.removeLastSlide = function () {
            return E.slides.length > 0 ? (t.loop ? (E.slides[E.slides.length - 1 - E.loopedSlides].remove(), E.removeLoopedSlides(), E.calcSlides(), E.createLoop()) : E.slides[E.slides.length - 1].remove(), !0) : !1
        }, E.removeAllSlides = function () {
            for (var e = E.slides.length - 1; e >= 0; e--)E.slides[e].remove()
        }, E.getSlide = function (e) {
            return E.slides[e]
        }, E.getLastSlide = function () {
            return E.slides[E.slides.length - 1]
        }, E.getFirstSlide = function () {
            return E.slides[0]
        }, E.activeSlide = function () {
            return E.slides[E.activeIndex]
        }, E.fireCallback = function () {
            var e = arguments[0];
            if ("[object Array]" === Object.prototype.toString.call(e))for (var n = 0; n < e.length; n++)"function" == typeof e[n] && e[n](arguments[1], arguments[2], arguments[3], arguments[4], arguments[5]); else"[object String]" === Object.prototype.toString.call(e) ? t["on" + e] && E.fireCallback(t["on" + e], arguments[1], arguments[2], arguments[3], arguments[4], arguments[5]) : e(arguments[1], arguments[2], arguments[3], arguments[4], arguments[5])
        }, E.addCallback = function (e, t) {
            var n, i = this;
            return i.params["on" + e] ? r(this.params["on" + e]) ? this.params["on" + e].push(t) : "function" == typeof this.params["on" + e] ? (n = this.params["on" + e], this.params["on" + e] = [], this.params["on" + e].push(n), this.params["on" + e].push(t)) : void 0 : (this.params["on" + e] = [], this.params["on" + e].push(t))
        }, E.removeCallbacks = function (e) {
            E.params["on" + e] && (E.params["on" + e] = null)
        };
        var H = [];
        for (var z in E.plugins)if (t[z]) {
            var V = E.plugins[z](E, t[z]);
            V && H.push(V)
        }
        E.callPlugins = function (e, t) {
            t || (t = {});
            for (var n = 0; n < H.length; n++)e in H[n] && H[n][e](t)
        }, !E.browser.ie10 && !E.browser.ie11 || t.onlyExternal || E.wrapper.classList.add("swiper-wp8-" + (R ? "horizontal" : "vertical")), t.freeMode && (E.container.className += " swiper-free-mode"), E.initialized = !1, E.init = function (e, n) {
            var r = E.h.getWidth(E.container, !1, t.roundLengths), i = E.h.getHeight(E.container, !1, t.roundLengths);
            if (r !== E.width || i !== E.height || e) {
                E.width = r, E.height = i;
                var o, a, s, c, l, u, d;
                O = R ? r : i;
                var p = E.wrapper;
                if (e && E.calcSlides(n), "auto" === t.slidesPerView) {
                    var f = 0, h = 0;
                    t.slidesOffset > 0 && (p.style.paddingLeft = "", p.style.paddingRight = "", p.style.paddingTop = "", p.style.paddingBottom = ""), p.style.width = "", p.style.height = "", t.offsetPxBefore > 0 && (R ? E.wrapperLeft = t.offsetPxBefore : E.wrapperTop = t.offsetPxBefore), t.offsetPxAfter > 0 && (R ? E.wrapperRight = t.offsetPxAfter : E.wrapperBottom = t.offsetPxAfter), t.centeredSlides && (R ? (E.wrapperLeft = (O - this.slides[0].getWidth(!0, t.roundLengths)) / 2, E.wrapperRight = (O - E.slides[E.slides.length - 1].getWidth(!0, t.roundLengths)) / 2) : (E.wrapperTop = (O - E.slides[0].getHeight(!0, t.roundLengths)) / 2, E.wrapperBottom = (O - E.slides[E.slides.length - 1].getHeight(!0, t.roundLengths)) / 2)), R ? (E.wrapperLeft >= 0 && (p.style.paddingLeft = E.wrapperLeft + "px"), E.wrapperRight >= 0 && (p.style.paddingRight = E.wrapperRight + "px")) : (E.wrapperTop >= 0 && (p.style.paddingTop = E.wrapperTop + "px"), E.wrapperBottom >= 0 && (p.style.paddingBottom = E.wrapperBottom + "px")), u = 0;
                    var m = 0;
                    for (E.snapGrid = [], E.slidesGrid = [], s = 0, d = 0; d < E.slides.length; d++) {
                        o = E.slides[d].getWidth(!0, t.roundLengths), a = E.slides[d].getHeight(!0, t.roundLengths), t.calculateHeight && (s = Math.max(s, a));
                        var g = R ? o : a;
                        if (t.centeredSlides) {
                            var v = d === E.slides.length - 1 ? 0 : E.slides[d + 1].getWidth(!0, t.roundLengths), _ = d === E.slides.length - 1 ? 0 : E.slides[d + 1].getHeight(!0, t.roundLengths), y = R ? v : _;
                            if (g > O) {
                                if (t.slidesPerViewFit)E.snapGrid.push(u + E.wrapperLeft), E.snapGrid.push(u + g - O + E.wrapperLeft); else for (var b = 0; b <= Math.floor(g / (O + E.wrapperLeft)); b++)E.snapGrid.push(0 === b ? u + E.wrapperLeft : u + E.wrapperLeft + O * b);
                                E.slidesGrid.push(u + E.wrapperLeft)
                            } else E.snapGrid.push(m), E.slidesGrid.push(m);
                            m += g / 2 + y / 2
                        } else {
                            if (g > O)if (t.slidesPerViewFit)E.snapGrid.push(u), E.snapGrid.push(u + g - O); else if (0 !== O)for (var $ = 0; $ <= Math.floor(g / O); $++)E.snapGrid.push(u + O * $); else E.snapGrid.push(u); else E.snapGrid.push(u);
                            E.slidesGrid.push(u)
                        }
                        u += g, f += o, h += a
                    }
                    t.calculateHeight && (E.height = s), R ? (D = f + E.wrapperRight + E.wrapperLeft, p.style.width = f + "px", p.style.height = E.height + "px") : (D = h + E.wrapperTop + E.wrapperBottom, p.style.width = E.width + "px", p.style.height = h + "px")
                } else if (t.scrollContainer)p.style.width = "", p.style.height = "", c = E.slides[0].getWidth(!0, t.roundLengths), l = E.slides[0].getHeight(!0, t.roundLengths), D = R ? c : l, p.style.width = c + "px", p.style.height = l + "px", M = R ? c : l; else {
                    if (t.calculateHeight) {
                        for (s = 0, l = 0, R || (E.container.style.height = ""), p.style.height = "", d = 0; d < E.slides.length; d++)E.slides[d].style.height = "", s = Math.max(E.slides[d].getHeight(!0), s), R || (l += E.slides[d].getHeight(!0));
                        a = s, E.height = a, R ? l = a : (O = a, E.container.style.height = O + "px")
                    } else a = R ? E.height : E.height / t.slidesPerView, t.roundLengths && (a = Math.ceil(a)), l = R ? E.height : E.slides.length * a;
                    for (o = R ? E.width / t.slidesPerView : E.width, t.roundLengths && (o = Math.ceil(o)), c = R ? E.slides.length * o : E.width, M = R ? o : a, t.offsetSlidesBefore > 0 && (R ? E.wrapperLeft = M * t.offsetSlidesBefore : E.wrapperTop = M * t.offsetSlidesBefore), t.offsetSlidesAfter > 0 && (R ? E.wrapperRight = M * t.offsetSlidesAfter : E.wrapperBottom = M * t.offsetSlidesAfter), t.offsetPxBefore > 0 && (R ? E.wrapperLeft = t.offsetPxBefore : E.wrapperTop = t.offsetPxBefore), t.offsetPxAfter > 0 && (R ? E.wrapperRight = t.offsetPxAfter : E.wrapperBottom = t.offsetPxAfter), t.centeredSlides && (R ? (E.wrapperLeft = (O - M) / 2, E.wrapperRight = (O - M) / 2) : (E.wrapperTop = (O - M) / 2, E.wrapperBottom = (O - M) / 2)), R ? (E.wrapperLeft > 0 && (p.style.paddingLeft = E.wrapperLeft + "px"), E.wrapperRight > 0 && (p.style.paddingRight = E.wrapperRight + "px")) : (E.wrapperTop > 0 && (p.style.paddingTop = E.wrapperTop + "px"), E.wrapperBottom > 0 && (p.style.paddingBottom = E.wrapperBottom + "px")), D = R ? c + E.wrapperRight + E.wrapperLeft : l + E.wrapperTop + E.wrapperBottom, parseFloat(c) > 0 && (!t.cssWidthAndHeight || "height" === t.cssWidthAndHeight) && (p.style.width = c + "px"), parseFloat(l) > 0 && (!t.cssWidthAndHeight || "width" === t.cssWidthAndHeight) && (p.style.height = l + "px"), u = 0, E.snapGrid = [], E.slidesGrid = [], d = 0; d < E.slides.length; d++)E.snapGrid.push(u), E.slidesGrid.push(u), u += M, parseFloat(o) > 0 && (!t.cssWidthAndHeight || "height" === t.cssWidthAndHeight) && (E.slides[d].style.width = o + "px"), parseFloat(a) > 0 && (!t.cssWidthAndHeight || "width" === t.cssWidthAndHeight) && (E.slides[d].style.height = a + "px")
                }
                E.initialized ? (E.callPlugins("onInit"), t.onInit && E.fireCallback(t.onInit, E)) : (E.callPlugins("onFirstInit"), t.onFirstInit && E.fireCallback(t.onFirstInit, E)), E.initialized = !0
            }
        }, E.reInit = function (e) {
            E.init(!0, e)
        }, E.resizeFix = function (e) {
            E.callPlugins("beforeResizeFix"), E.init(t.resizeReInit || e), t.freeMode ? E.getWrapperTranslate() < -i() && (E.setWrapperTransition(0), E.setWrapperTranslate(-i())) : (E.swipeTo(t.loop ? E.activeLoopIndex : E.activeIndex, 0, !1), t.autoplay && (E.support.transitions && "undefined" != typeof Z ? "undefined" != typeof Z && (clearTimeout(Z), Z = void 0, E.startAutoplay()) : "undefined" != typeof et && (clearInterval(et), et = void 0, E.startAutoplay()))), E.callPlugins("afterResizeFix")
        }, E.destroy = function () {
            var e = E.h.removeEventListener, n = "wrapper" === t.eventTarget ? E.wrapper : E.container;
            E.browser.ie10 || E.browser.ie11 ? (e(n, E.touchEvents.touchStart, m), e(document, E.touchEvents.touchMove, g), e(document, E.touchEvents.touchEnd, v)) : (E.support.touch && (e(n, "touchstart", m), e(n, "touchmove", g), e(n, "touchend", v)), t.simulateTouch && (e(n, "mousedown", m), e(document, "mousemove", g), e(document, "mouseup", v))), t.autoResize && e(window, "resize", E.resizeFix), s(), t.paginationClickable && w(), t.mousewheelControl && E._wheelEvent && e(E.container, E._wheelEvent, l), t.keyboardControl && e(document, "keydown", c), t.autoplay && E.stopAutoplay(), E.callPlugins("onDestroy"), E = null
        }, E.disableKeyboardControl = function () {
            t.keyboardControl = !1, E.h.removeEventListener(document, "keydown", c)
        }, E.enableKeyboardControl = function () {
            t.keyboardControl = !0, E.h.addEventListener(document, "keydown", c)
        };
        var W = (new Date).getTime();
        if (E.disableMousewheelControl = function () {
                return E._wheelEvent ? (t.mousewheelControl = !1, E.h.removeEventListener(E.container, E._wheelEvent, l), !0) : !1
            }, E.enableMousewheelControl = function () {
                return E._wheelEvent ? (t.mousewheelControl = !0, E.h.addEventListener(E.container, E._wheelEvent, l), !0) : !1
            }, t.grabCursor) {
            var G = E.container.style;
            G.cursor = "move", G.cursor = "grab", G.cursor = "-moz-grab", G.cursor = "-webkit-grab"
        }
        E.allowSlideClick = !0, E.allowLinks = !0;
        var X, Y, Q, K = !1, J = !0;
        E.swipeNext = function (e) {
            !e && t.loop && E.fixLoop(), !e && t.autoplay && E.stopAutoplay(!0), E.callPlugins("onSwipeNext");
            var n = E.getWrapperTranslate(), r = n;
            if ("auto" === t.slidesPerView) {
                for (var o = 0; o < E.snapGrid.length; o++)if (-n >= E.snapGrid[o] && -n < E.snapGrid[o + 1]) {
                    r = -E.snapGrid[o + 1];
                    break
                }
            } else {
                var a = M * t.slidesPerGroup;
                r = -(Math.floor(Math.abs(n) / Math.floor(a)) * a + a)
            }
            return r < -i() && (r = -i()), r === n ? !1 : (b(r, "next"), !0)
        }, E.swipePrev = function (e) {
            !e && t.loop && E.fixLoop(), !e && t.autoplay && E.stopAutoplay(!0), E.callPlugins("onSwipePrev");
            var n, r = Math.ceil(E.getWrapperTranslate());
            if ("auto" === t.slidesPerView) {
                n = 0;
                for (var i = 1; i < E.snapGrid.length; i++) {
                    if (-r === E.snapGrid[i]) {
                        n = -E.snapGrid[i - 1];
                        break
                    }
                    if (-r > E.snapGrid[i] && -r < E.snapGrid[i + 1]) {
                        n = -E.snapGrid[i];
                        break
                    }
                }
            } else {
                var o = M * t.slidesPerGroup;
                n = -(Math.ceil(-r / o) - 1) * o
            }
            return n > 0 && (n = 0), n === r ? !1 : (b(n, "prev"), !0)
        }, E.swipeReset = function () {
            E.callPlugins("onSwipeReset");
            {
                var e, n = E.getWrapperTranslate(), r = M * t.slidesPerGroup;
                -i()
            }
            if ("auto" === t.slidesPerView) {
                e = 0;
                for (var o = 0; o < E.snapGrid.length; o++) {
                    if (-n === E.snapGrid[o])return;
                    if (-n >= E.snapGrid[o] && -n < E.snapGrid[o + 1]) {
                        e = E.positions.diff > 0 ? -E.snapGrid[o + 1] : -E.snapGrid[o];
                        break
                    }
                }
                -n >= E.snapGrid[E.snapGrid.length - 1] && (e = -E.snapGrid[E.snapGrid.length - 1]), n <= -i() && (e = -i())
            } else e = 0 > n ? Math.round(n / r) * r : 0, n <= -i() && (e = -i());
            return t.scrollContainer && (e = 0 > n ? n : 0), e < -i() && (e = -i()), t.scrollContainer && O > M && (e = 0), e === n ? !1 : (b(e, "reset"), !0)
        }, E.swipeTo = function (e, n, r) {
            e = parseInt(e, 10), E.callPlugins("onSwipeTo", {index: e, speed: n}), t.loop && (e += E.loopedSlides);
            var o = E.getWrapperTranslate();
            if (!(e > E.slides.length - 1 || 0 > e)) {
                var a;
                return a = "auto" === t.slidesPerView ? -E.slidesGrid[e] : -e * M, a < -i() && (a = -i()), a === o ? !1 : (r = r === !1 ? !1 : !0, b(a, "to", {
                    index: e,
                    speed: n,
                    runCallbacks: r
                }), !0)
            }
        }, E._queueStartCallbacks = !1, E._queueEndCallbacks = !1, E.updateActiveSlide = function (e) {
            if (E.initialized && 0 !== E.slides.length) {
                E.previousIndex = E.activeIndex, "undefined" == typeof e && (e = E.getWrapperTranslate()), e > 0 && (e = 0);
                var n;
                if ("auto" === t.slidesPerView) {
                    if (E.activeIndex = E.slidesGrid.indexOf(-e), E.activeIndex < 0) {
                        for (n = 0; n < E.slidesGrid.length - 1 && !(-e > E.slidesGrid[n] && -e < E.slidesGrid[n + 1]); n++);
                        var r = Math.abs(E.slidesGrid[n] + e), i = Math.abs(E.slidesGrid[n + 1] + e);
                        E.activeIndex = i >= r ? n : n + 1
                    }
                } else E.activeIndex = Math[t.visibilityFullFit ? "ceil" : "round"](-e / M);
                if (E.activeIndex === E.slides.length && (E.activeIndex = E.slides.length - 1), E.activeIndex < 0 && (E.activeIndex = 0), E.slides[E.activeIndex]) {
                    if (E.calcVisibleSlides(e), E.support.classList) {
                        var o;
                        for (n = 0; n < E.slides.length; n++)o = E.slides[n], o.classList.remove(t.slideActiveClass), E.visibleSlides.indexOf(o) >= 0 ? o.classList.add(t.slideVisibleClass) : o.classList.remove(t.slideVisibleClass);
                        E.slides[E.activeIndex].classList.add(t.slideActiveClass)
                    } else {
                        var a = new RegExp("\\s*" + t.slideActiveClass), s = new RegExp("\\s*" + t.slideVisibleClass);
                        for (n = 0; n < E.slides.length; n++)E.slides[n].className = E.slides[n].className.replace(a, "").replace(s, ""), E.visibleSlides.indexOf(E.slides[n]) >= 0 && (E.slides[n].className += " " + t.slideVisibleClass);
                        E.slides[E.activeIndex].className += " " + t.slideActiveClass
                    }
                    if (t.loop) {
                        var c = E.loopedSlides;
                        E.activeLoopIndex = E.activeIndex - c, E.activeLoopIndex >= E.slides.length - 2 * c && (E.activeLoopIndex = E.slides.length - 2 * c - E.activeLoopIndex), E.activeLoopIndex < 0 && (E.activeLoopIndex = E.slides.length - 2 * c + E.activeLoopIndex), E.activeLoopIndex < 0 && (E.activeLoopIndex = 0)
                    } else E.activeLoopIndex = E.activeIndex;
                    t.pagination && E.updatePagination(e)
                }
            }
        }, E.createPagination = function (e) {
            if (t.paginationClickable && E.paginationButtons && w(), E.paginationContainer = t.pagination.nodeType ? t.pagination : n(t.pagination)[0], t.createPagination) {
                var r = "", i = E.slides.length, o = i;
                t.loop && (o -= 2 * E.loopedSlides);
                for (var a = 0; o > a; a++)r += "<" + t.paginationElement + ' class="' + t.paginationElementClass + '"></' + t.paginationElement + ">";
                E.paginationContainer.innerHTML = r
            }
            E.paginationButtons = n("." + t.paginationElementClass, E.paginationContainer), e || E.updatePagination(), E.callPlugins("onCreatePagination"), t.paginationClickable && x()
        }, E.updatePagination = function (e) {
            if (t.pagination && !(E.slides.length < 1)) {
                var r = n("." + t.paginationActiveClass, E.paginationContainer);
                if (r) {
                    var i = E.paginationButtons;
                    if (0 !== i.length) {
                        for (var o = 0; o < i.length; o++)i[o].className = t.paginationElementClass;
                        var a = t.loop ? E.loopedSlides : 0;
                        if (t.paginationAsRange) {
                            E.visibleSlides || E.calcVisibleSlides(e);
                            var s, c = [];
                            for (s = 0; s < E.visibleSlides.length; s++) {
                                var l = E.slides.indexOf(E.visibleSlides[s]) - a;
                                t.loop && 0 > l && (l = E.slides.length - 2 * E.loopedSlides + l), t.loop && l >= E.slides.length - 2 * E.loopedSlides && (l = E.slides.length - 2 * E.loopedSlides - l, l = Math.abs(l)), c.push(l)
                            }
                            for (s = 0; s < c.length; s++)i[c[s]] && (i[c[s]].className += " " + t.paginationVisibleClass);
                            t.loop ? void 0 !== i[E.activeLoopIndex] && (i[E.activeLoopIndex].className += " " + t.paginationActiveClass) : i[E.activeIndex].className += " " + t.paginationActiveClass
                        } else t.loop ? i[E.activeLoopIndex] && (i[E.activeLoopIndex].className += " " + t.paginationActiveClass + " " + t.paginationVisibleClass) : i[E.activeIndex].className += " " + t.paginationActiveClass + " " + t.paginationVisibleClass
                    }
                }
            }
        }, E.calcVisibleSlides = function (e) {
            var n = [], r = 0, i = 0, o = 0;
            R && E.wrapperLeft > 0 && (e += E.wrapperLeft), !R && E.wrapperTop > 0 && (e += E.wrapperTop);
            for (var a = 0; a < E.slides.length; a++) {
                r += i, i = "auto" === t.slidesPerView ? R ? E.h.getWidth(E.slides[a], !0, t.roundLengths) : E.h.getHeight(E.slides[a], !0, t.roundLengths) : M, o = r + i;
                var s = !1;
                t.visibilityFullFit ? (r >= -e && -e + O >= o && (s = !0), -e >= r && o >= -e + O && (s = !0)) : (o > -e && -e + O >= o && (s = !0), r >= -e && -e + O > r && (s = !0), -e > r && o > -e + O && (s = !0)), s && n.push(E.slides[a])
            }
            0 === n.length && (n = [E.slides[E.activeIndex]]), E.visibleSlides = n
        };
        var Z, et;
        E.startAutoplay = function () {
            if (E.support.transitions) {
                if ("undefined" != typeof Z)return !1;
                if (!t.autoplay)return;
                E.callPlugins("onAutoplayStart"), t.onAutoplayStart && E.fireCallback(t.onAutoplayStart, E), C()
            } else {
                if ("undefined" != typeof et)return !1;
                if (!t.autoplay)return;
                E.callPlugins("onAutoplayStart"), t.onAutoplayStart && E.fireCallback(t.onAutoplayStart, E), et = setInterval(function () {
                    t.loop ? (E.fixLoop(), E.swipeNext(!0)) : E.swipeNext(!0) || (t.autoplayStopOnLast ? (clearInterval(et), et = void 0) : E.swipeTo(0))
                }, t.autoplay)
            }
        }, E.stopAutoplay = function (e) {
            if (E.support.transitions) {
                if (!Z)return;
                Z && clearTimeout(Z), Z = void 0, e && !t.autoplayDisableOnInteraction && E.wrapperTransitionEnd(function () {
                    C()
                }), E.callPlugins("onAutoplayStop"), t.onAutoplayStop && E.fireCallback(t.onAutoplayStop, E)
            } else et && clearInterval(et), et = void 0, E.callPlugins("onAutoplayStop"), t.onAutoplayStop && E.fireCallback(t.onAutoplayStop, E)
        }, E.loopCreated = !1, E.removeLoopedSlides = function () {
            if (E.loopCreated)for (var e = 0; e < E.slides.length; e++)E.slides[e].getData("looped") === !0 && E.wrapper.removeChild(E.slides[e])
        }, E.createLoop = function () {
            if (0 !== E.slides.length) {
                E.loopedSlides = "auto" === t.slidesPerView ? t.loopedSlides || 1 : t.slidesPerView + t.loopAdditionalSlides, E.loopedSlides > E.slides.length && (E.loopedSlides = E.slides.length);
                var e, n = "", r = "", i = "", o = E.slides.length, a = Math.floor(E.loopedSlides / o), s = E.loopedSlides % o;
                for (e = 0; a * o > e; e++) {
                    var c = e;
                    if (e >= o) {
                        var l = Math.floor(e / o);
                        c = e - o * l
                    }
                    i += E.slides[c].outerHTML
                }
                for (e = 0; s > e; e++)r += y(t.slideDuplicateClass, E.slides[e].outerHTML);
                for (e = o - s; o > e; e++)n += y(t.slideDuplicateClass, E.slides[e].outerHTML);
                var u = n + i + A.innerHTML + i + r;
                for (A.innerHTML = u, E.loopCreated = !0, E.calcSlides(), e = 0; e < E.slides.length; e++)(e < E.loopedSlides || e >= E.slides.length - E.loopedSlides) && E.slides[e].setData("looped", !0);
                E.callPlugins("onCreateLoop")
            }
        }, E.fixLoop = function () {
            var e;
            E.activeIndex < E.loopedSlides ? (e = E.slides.length - 3 * E.loopedSlides + E.activeIndex, E.swipeTo(e, 0, !1)) : ("auto" === t.slidesPerView && E.activeIndex >= 2 * E.loopedSlides || E.activeIndex > E.slides.length - 2 * t.slidesPerView) && (e = -E.slides.length + E.activeIndex + E.loopedSlides, E.swipeTo(e, 0, !1))
        }, E.loadSlides = function () {
            var e = "";
            E.activeLoaderIndex = 0;
            for (var n = t.loader.slides, r = t.loader.loadAllSlides ? n.length : t.slidesPerView * (1 + t.loader.surroundGroups), i = 0; r > i; i++)e += "outer" === t.loader.slidesHTMLType ? n[i] : "<" + t.slideElement + ' class="' + t.slideClass + '" data-swiperindex="' + i + '">' + n[i] + "</" + t.slideElement + ">";
            E.wrapper.innerHTML = e, E.calcSlides(!0), t.loader.loadAllSlides || E.wrapperTransitionEnd(E.reloadSlides, !0)
        }, E.reloadSlides = function () {
            var e = t.loader.slides, n = parseInt(E.activeSlide().data("swiperindex"), 10);
            if (!(0 > n || n > e.length - 1)) {
                E.activeLoaderIndex = n;
                var r = Math.max(0, n - t.slidesPerView * t.loader.surroundGroups), i = Math.min(n + t.slidesPerView * (1 + t.loader.surroundGroups) - 1, e.length - 1);
                if (n > 0) {
                    var o = -M * (n - r);
                    E.setWrapperTranslate(o), E.setWrapperTransition(0)
                }
                var a;
                if ("reload" === t.loader.logic) {
                    E.wrapper.innerHTML = "";
                    var s = "";
                    for (a = r; i >= a; a++)s += "outer" === t.loader.slidesHTMLType ? e[a] : "<" + t.slideElement + ' class="' + t.slideClass + '" data-swiperindex="' + a + '">' + e[a] + "</" + t.slideElement + ">";
                    E.wrapper.innerHTML = s
                } else {
                    var c = 1e3, l = 0;
                    for (a = 0; a < E.slides.length; a++) {
                        var u = E.slides[a].data("swiperindex");
                        r > u || u > i ? E.wrapper.removeChild(E.slides[a]) : (c = Math.min(u, c), l = Math.max(u, l))
                    }
                    for (a = r; i >= a; a++) {
                        var d;
                        c > a && (d = document.createElement(t.slideElement), d.className = t.slideClass, d.setAttribute("data-swiperindex", a), d.innerHTML = e[a], E.wrapper.insertBefore(d, E.wrapper.firstChild)), a > l && (d = document.createElement(t.slideElement), d.className = t.slideClass, d.setAttribute("data-swiperindex", a), d.innerHTML = e[a], E.wrapper.appendChild(d))
                    }
                }
                E.reInit(!0)
            }
        }, k()
    }
};
Swiper.prototype = {
    plugins: {}, wrapperTransitionEnd: function (e, t) {
        "use strict";
        function n(s) {
            if (s.target === o && (e(i), i.params.queueEndCallbacks && (i._queueEndCallbacks = !1), !t))for (r = 0; r < a.length; r++)i.h.removeEventListener(o, a[r], n)
        }

        var r, i = this, o = i.wrapper, a = ["webkitTransitionEnd", "transitionend", "oTransitionEnd", "MSTransitionEnd", "msTransitionEnd"];
        if (e)for (r = 0; r < a.length; r++)i.h.addEventListener(o, a[r], n)
    }, getWrapperTranslate: function (e) {
        "use strict";
        var t, n, r, i, o = this.wrapper;
        return "undefined" == typeof e && (e = "horizontal" === this.params.mode ? "x" : "y"), this.support.transforms && this.params.useCSS3Transforms ? (r = window.getComputedStyle(o, null), window.WebKitCSSMatrix ? i = new WebKitCSSMatrix("none" === r.webkitTransform ? "" : r.webkitTransform) : (i = r.MozTransform || r.OTransform || r.MsTransform || r.msTransform || r.transform || r.getPropertyValue("transform").replace("translate(", "matrix(1, 0, 0, 1,"), t = i.toString().split(",")), "x" === e && (n = window.WebKitCSSMatrix ? i.m41 : parseFloat(16 === t.length ? t[12] : t[4])), "y" === e && (n = window.WebKitCSSMatrix ? i.m42 : parseFloat(16 === t.length ? t[13] : t[5]))) : ("x" === e && (n = parseFloat(o.style.left, 10) || 0), "y" === e && (n = parseFloat(o.style.top, 10) || 0)), n || 0
    }, setWrapperTranslate: function (e, t, n) {
        "use strict";
        var r, i = this.wrapper.style, o = {x: 0, y: 0, z: 0};
        3 === arguments.length ? (o.x = e, o.y = t, o.z = n) : ("undefined" == typeof t && (t = "horizontal" === this.params.mode ? "x" : "y"), o[t] = e), this.support.transforms && this.params.useCSS3Transforms ? (r = this.support.transforms3d ? "translate3d(" + o.x + "px, " + o.y + "px, " + o.z + "px)" : "translate(" + o.x + "px, " + o.y + "px)", i.webkitTransform = i.MsTransform = i.msTransform = i.MozTransform = i.OTransform = i.transform = r) : (i.left = o.x + "px", i.top = o.y + "px"), this.callPlugins("onSetWrapperTransform", o), this.params.onSetWrapperTransform && this.fireCallback(this.params.onSetWrapperTransform, this, o)
    }, setWrapperTransition: function (e) {
        "use strict";
        var t = this.wrapper.style;
        t.webkitTransitionDuration = t.MsTransitionDuration = t.msTransitionDuration = t.MozTransitionDuration = t.OTransitionDuration = t.transitionDuration = e / 1e3 + "s", this.callPlugins("onSetWrapperTransition", {duration: e}), this.params.onSetWrapperTransition && this.fireCallback(this.params.onSetWrapperTransition, this, e)
    }, h: {
        getWidth: function (e, t, n) {
            "use strict";
            var r = window.getComputedStyle(e, null).getPropertyValue("width"), i = parseFloat(r);
            return (isNaN(i) || r.indexOf("%") > 0 || 0 > i) && (i = e.offsetWidth - parseFloat(window.getComputedStyle(e, null).getPropertyValue("padding-left")) - parseFloat(window.getComputedStyle(e, null).getPropertyValue("padding-right"))), t && (i += parseFloat(window.getComputedStyle(e, null).getPropertyValue("padding-left")) + parseFloat(window.getComputedStyle(e, null).getPropertyValue("padding-right"))), n ? Math.ceil(i) : i
        }, getHeight: function (e, t, n) {
            "use strict";
            if (t)return e.offsetHeight;
            var r = window.getComputedStyle(e, null).getPropertyValue("height"), i = parseFloat(r);
            return (isNaN(i) || r.indexOf("%") > 0 || 0 > i) && (i = e.offsetHeight - parseFloat(window.getComputedStyle(e, null).getPropertyValue("padding-top")) - parseFloat(window.getComputedStyle(e, null).getPropertyValue("padding-bottom"))), t && (i += parseFloat(window.getComputedStyle(e, null).getPropertyValue("padding-top")) + parseFloat(window.getComputedStyle(e, null).getPropertyValue("padding-bottom"))), n ? Math.ceil(i) : i
        }, getOffset: function (e) {
            "use strict";
            var t = e.getBoundingClientRect(), n = document.body, r = e.clientTop || n.clientTop || 0, i = e.clientLeft || n.clientLeft || 0, o = window.pageYOffset || e.scrollTop, a = window.pageXOffset || e.scrollLeft;
            return document.documentElement && !window.pageYOffset && (o = document.documentElement.scrollTop, a = document.documentElement.scrollLeft), {
                top: t.top + o - r,
                left: t.left + a - i
            }
        }, windowWidth: function () {
            "use strict";
            return window.innerWidth ? window.innerWidth : document.documentElement && document.documentElement.clientWidth ? document.documentElement.clientWidth : void 0
        }, windowHeight: function () {
            "use strict";
            return window.innerHeight ? window.innerHeight : document.documentElement && document.documentElement.clientHeight ? document.documentElement.clientHeight : void 0
        }, windowScroll: function () {
            "use strict";
            return "undefined" != typeof pageYOffset ? {
                left: window.pageXOffset,
                top: window.pageYOffset
            } : document.documentElement ? {
                left: document.documentElement.scrollLeft,
                top: document.documentElement.scrollTop
            } : void 0
        }, addEventListener: function (e, t, n, r) {
            "use strict";
            "undefined" == typeof r && (r = !1), e.addEventListener ? e.addEventListener(t, n, r) : e.attachEvent && e.attachEvent("on" + t, n)
        }, removeEventListener: function (e, t, n, r) {
            "use strict";
            "undefined" == typeof r && (r = !1), e.removeEventListener ? e.removeEventListener(t, n, r) : e.detachEvent && e.detachEvent("on" + t, n)
        }
    }, setTransform: function (e, t) {
        "use strict";
        var n = e.style;
        n.webkitTransform = n.MsTransform = n.msTransform = n.MozTransform = n.OTransform = n.transform = t
    }, setTranslate: function (e, t) {
        "use strict";
        var n = e.style, r = {
            x: t.x || 0,
            y: t.y || 0,
            z: t.z || 0
        }, i = this.support.transforms3d ? "translate3d(" + r.x + "px," + r.y + "px," + r.z + "px)" : "translate(" + r.x + "px," + r.y + "px)";
        n.webkitTransform = n.MsTransform = n.msTransform = n.MozTransform = n.OTransform = n.transform = i, this.support.transforms || (n.left = r.x + "px", n.top = r.y + "px")
    }, setTransition: function (e, t) {
        "use strict";
        var n = e.style;
        n.webkitTransitionDuration = n.MsTransitionDuration = n.msTransitionDuration = n.MozTransitionDuration = n.OTransitionDuration = n.transitionDuration = t + "ms"
    }, support: {
        touch: window.Modernizr && Modernizr.touch === !0 || function () {
            "use strict";
            return !!("ontouchstart"in window || window.DocumentTouch && document instanceof DocumentTouch)
        }(), transforms3d: window.Modernizr && Modernizr.csstransforms3d === !0 || function () {
            "use strict";
            var e = document.createElement("div").style;
            return "webkitPerspective"in e || "MozPerspective"in e || "OPerspective"in e || "MsPerspective"in e || "perspective"in e
        }(), transforms: window.Modernizr && Modernizr.csstransforms === !0 || function () {
            "use strict";
            var e = document.createElement("div").style;
            return "transform"in e || "WebkitTransform"in e || "MozTransform"in e || "msTransform"in e || "MsTransform"in e || "OTransform"in e
        }(), transitions: window.Modernizr && Modernizr.csstransitions === !0 || function () {
            "use strict";
            var e = document.createElement("div").style;
            return "transition"in e || "WebkitTransition"in e || "MozTransition"in e || "msTransition"in e || "MsTransition"in e || "OTransition"in e
        }(), classList: function () {
            "use strict";
            var e = document.createElement("div");
            return "classList"in e
        }()
    }, browser: {
        ie8: function () {
            "use strict";
            var e = -1;
            if ("Microsoft Internet Explorer" === navigator.appName) {
                var t = navigator.userAgent, n = new RegExp(/MSIE ([0-9]{1,}[\.0-9]{0,})/);
                null !== n.exec(t) && (e = parseFloat(RegExp.$1))
            }
            return -1 !== e && 9 > e
        }(), ie10: window.navigator.msPointerEnabled, ie11: window.navigator.pointerEnabled
    }
}, (window.jQuery || window.Zepto) && !function (e) {
    "use strict";
    e.fn.swiper = function (t) {
        var n;
        return this.each(function (r) {
            var i = e(this);
            if (!i.data("swiper")) {
                var o = new Swiper(i[0], t);
                r || (n = o), i.data("swiper", o)
            }
        }), n
    }
}(window.jQuery || window.Zepto), "undefined" != typeof module && (module.exports = Swiper), "function" == typeof define && define.amd && define([], function () {
    "use strict";
    return Swiper
}), function (e, t) {
    "function" == typeof require && "object" == typeof exports && "object" == typeof module ? module.exports = t() : "function" == typeof define && define.amd ? define(function () {
        return t()
    }) : e.pluralize = t()
}(this, function () {
    function e(e) {
        return e.charAt(0).toUpperCase() + e.substr(1).toLowerCase()
    }

    function t(e) {
        return "string" == typeof e ? new RegExp("^" + e + "$", "i") : e
    }

    function n(t, n) {
        return t === t.toUpperCase() ? n.toUpperCase() : t[0] === t[0].toUpperCase() ? e(n) : n.toLowerCase()
    }

    function r(e, t) {
        return e.replace(/\$(&|\d{1,2})/g, function (e, n) {
            return "&" === n ? t[0] : t[n] || ""
        })
    }

    function i(e, t) {
        if (!e.length || l.hasOwnProperty(e))return e;
        for (var i = t.length; i--;) {
            var o = t[i];
            if (o[0].test(e))return e.replace(o[0], function (e, t, i) {
                var a = r(o[1], arguments);
                return "" === e ? n(i[t - 1], a) : n(e, a)
            })
        }
        return e
    }

    function o(e, t, r) {
        return function (o) {
            var a = o.toLowerCase();
            return t.hasOwnProperty(a) ? n(o, a) : e.hasOwnProperty(a) ? n(o, e[a]) : i(o, r)
        }
    }

    function a(e, t, n) {
        var r = 1 === t ? a.singular(e) : a.plural(e);
        return (n ? t + " " : "") + r
    }

    var s = [], c = [], l = {}, u = {}, d = {};
    return a.plural = o(d, u, s), a.singular = o(u, d, c), a.addPluralRule = function (e, n) {
        s.push([t(e), n])
    }, a.addSingularRule = function (e, n) {
        c.push([t(e), n])
    }, a.addUncountableRule = function (e) {
        return "string" == typeof e ? l[e.toLowerCase()] = !0 : (a.addPluralRule(e, "$&"), void a.addSingularRule(e, "$&"))
    }, a.addIrregularRule = function (e, t) {
        t = t.toLowerCase(), e = e.toLowerCase(), d[e] = t, u[t] = e
    }, [["I", "we"], ["me", "us"], ["he", "they"], ["she", "they"], ["them", "them"], ["myself", "ourselves"], ["yourself", "yourselves"], ["itself", "themselves"], ["herself", "themselves"], ["himself", "themselves"], ["themself", "themselves"], ["this", "these"], ["that", "those"], ["volcano", "volcanoes"], ["tornado", "tornadoes"], ["torpedo", "torpedoes"], ["genus", "genera"], ["viscus", "viscera"], ["stigma", "stigmata"], ["stoma", "stomata"], ["dogma", "dogmata"], ["lemma", "lemmata"], ["schema", "schemata"], ["anathema", "anathemata"], ["ox", "oxen"], ["axe", "axes"], ["die", "dice"], ["yes", "yeses"], ["foot", "feet"], ["eave", "eaves"], ["beau", "beaus"], ["goose", "geese"], ["tooth", "teeth"], ["quiz", "quizzes"], ["human", "humans"], ["proof", "proofs"], ["carve", "carves"], ["valve", "valves"], ["thief", "thieves"], ["genie", "genies"], ["groove", "grooves"], ["pickaxe", "pickaxes"], ["whiskey", "whiskies"]].forEach(function (e) {
        return a.addIrregularRule(e[0], e[1])
    }), [[/s?$/i, "s"], [/([^aeiou]ese)$/i, "$1"], [/^(ax|test)is$/i, "$1es"], [/(alias|[^aou]us|tlas|gas|ris)$/i, "$1es"], [/(e[mn]u)s?$/i, "$1s"], [/([^l]ias|[aeiou]las|[emjzr]as|[iu]am)$/i, "$1"], [/(alumn|syllab|octop|vir|radi|nucle|fung|cact|stimul|termin|bacill|foc|uter|loc)(?:us|i)$/i, "$1i"], [/^(alumn|alg|vertebr)(?:a|ae)$/i, "$1ae"], [/(her|at|gr)o$/i, "$1oes"], [/^(agend|addend|millenni|dat|extrem|bacteri|desiderat|strat|candelabr|errat|ov|symposi|curricul|automat|quor)(?:a|um)$/i, "$1a"], [/^(apheli|hyperbat|periheli|asyndet|noumen|phenomen|criteri|organ|prolegomen|\w+hedr)(?:a|on)$/i, "$1a"], [/sis$/i, "ses"], [/(?:(i)fe|(ar|l|[eo][ao])f)$/i, "$1$2ves"], [/([^aeiouy]|qu)y$/i, "$1ies"], [/([^ch][ieo][ln])ey$/i, "$1ies"], [/(x|ch|ss|sh|zz)$/i, "$1es"], [/(matr|cod|mur|sil|vert|ind)(?:ix|ex)$/i, "$1ices"], [/^(m|l)(?:ice|ouse)$/i, "$1ice"], [/(pe)(?:rson|ople)$/i, "$1ople"], [/(child)(?:ren)?$/i, "$1ren"], [/(eau)x?$/i, "$1x"], [/m[ae]n$/i, "men"]].forEach(function (e) {
        return a.addPluralRule(e[0], e[1])
    }), [[/s$/i, ""], [/(ss)$/i, "$1"], [/((a)naly|(b)a|(d)iagno|(p)arenthe|(p)rogno|(s)ynop|(t)he)(?:sis|ses)$/i, "$1sis"], [/(^analy)(?:sis|ses)$/i, "$1sis"], [/([^aeflor])ves$/i, "$1fe"], [/(hive|tive|dr?ive)s$/i, "$1"], [/(ar|(?:wo|[ae])l|[eo][ao])ves$/i, "$1f"], [/([^aeiouy]|qu)ies$/i, "$1y"], [/(^[pl]|zomb|^(?:neck)?t|[aeo][lt]|cut)ies$/i, "$1ie"], [/([^c][eor]n|smil)ies$/i, "$1ey"], [/^(m|l)ice$/i, "$1ouse"], [/(x|ch|ss|sh|zz|tto|go|cho|alias|[^aou]us|tlas|gas|(?:her|at|gr)o|ris)(?:es)?$/i, "$1"], [/(e[mn]u)s?$/i, "$1"], [/(movie|twelve)s$/i, "$1"], [/(cris|test|diagnos)(?:is|es)$/i, "$1is"], [/(alumn|syllab|octop|vir|radi|nucle|fung|cact|stimul|termin|bacill|foc|uter|loc)(?:us|i)$/i, "$1us"], [/^(agend|addend|millenni|dat|extrem|bacteri|desiderat|strat|candelabr|errat|ov|symposi|curricul|automat|quor)a$/i, "$1um"], [/^(apheli|hyperbat|periheli|asyndet|noumen|phenomen|criteri|organ|prolegomen|\w+hedr)a$/i, "$1on"], [/^(alumn|alg|vertebr)ae$/i, "$1a"], [/(cod|mur|sil|vert|ind)ices$/i, "$1ex"], [/(matr)ices$/i, "$1ix"], [/(pe)(rson|ople)$/i, "$1rson"], [/(child)ren$/i, "$1"], [/(eau)[sx]?$/i, "$1"], [/men$/i, "man"]].forEach(function (e) {
        return a.addSingularRule(e[0], e[1])
    }), ["advice", "agenda", "bison", "bream", "buffalo", "carp", "chassis", "cod", "cooperation", "corps", "digestion", "debris", "diabetes", "energy", "equipment", "elk", "excretion", "expertise", "flounder", "gallows", "graffiti", "headquarters", "health", "herpes", "highjinks", "homework", "information", "jeans", "justice", "kudos", "labour", "machinery", "mackerel", "media", "mews", "moose", "news", "pike", "plankton", "pliers", "pollution", "premises", "rain", "rice", "salmon", "scissors", "series", "sewage", "shambles", "shrimp", "species", "staff", "swine", "trout", "tuna", "whiting", "wildebeest", "wildlife", /pox$/i, /ois$/i, /deer$/i, /fish$/i, /sheep$/i, /measles$/i, /[^aeiou]ese$/i].forEach(a.addUncountableRule), a
}), function (e, t) {
    "use strict";
    function n() {
    }

    var r = Object.create(n.prototype, {
        version: {value: "2.0.15"},
        radius: {value: 6378137},
        minLat: {value: -90},
        maxLat: {value: 90},
        minLon: {value: -180},
        maxLon: {value: 180},
        sexagesimalPattern: {value: /^([0-9]{1,3})\xb0\s*([0-9]{1,3}(?:\.(?:[0-9]{1,2}))?)'\s*(([0-9]{1,3}(\.([0-9]{1,2}))?)"\s*)?([NEOSW]?)$/},
        measures: {
            value: Object.create(Object.prototype, {
                m: {value: 1},
                km: {value: .001},
                cm: {value: 100},
                mm: {value: 1e3},
                mi: {value: 1 / 1609.344},
                sm: {value: 1 / 1852.216},
                ft: {value: 100 / 30.48},
                "in": {value: 100 / 2.54},
                yd: {value: 1 / .9144}
            })
        },
        prototype: {value: n.prototype},
        extend: {
            value: function (e, t) {
                for (var n in e)("undefined" == typeof r.prototype[n] || t === !0) && (r.prototype[n] = e[n])
            }
        }
    });
    "undefined" == typeof Number.prototype.toRad && (Number.prototype.toRad = function () {
        return this * Math.PI / 180
    }), "undefined" == typeof Number.prototype.toDeg && (Number.prototype.toDeg = function () {
        return 180 * this / Math.PI
    }), r.extend({
        decimal: {}, sexagesimal: {}, distance: null, getKeys: function (e) {
            if ("[object Array]" == Object.prototype.toString.call(e))return {
                longitude: e.length >= 1 ? 0 : t,
                latitude: e.length >= 2 ? 1 : t,
                elevation: e.length >= 3 ? 2 : t
            };
            var n = function (t) {
                var n;
                return t.every(function (t) {
                    return "object" != typeof e ? !0 : e.hasOwnProperty(t) ? function () {
                        return n = t, !1
                    }() : !0
                }), n
            }, r = n(["lng", "lon", "longitude"]), i = n(["lat", "latitude"]), o = n(["alt", "altitude", "elevation", "elev"]);
            return "undefined" == typeof i && "undefined" == typeof r && "undefined" == typeof o ? t : {
                latitude: i,
                longitude: r,
                elevation: o
            }
        }, getLat: function (e, t) {
            return t === !0 ? e[this.getKeys(e).latitude] : this.useDecimal(e[this.getKeys(e).latitude])
        }, latitude: function (e) {
            return this.getLat.call(this, e)
        }, getLon: function (e, t) {
            return t === !0 ? e[this.getKeys(e).longitude] : this.useDecimal(e[this.getKeys(e).longitude])
        }, longitude: function (e) {
            return this.getLon.call(this, e)
        }, getElev: function (e) {
            return e[this.getKeys(e).elevation]
        }, elevation: function (e) {
            return this.getElev.call(this, e)
        }, coords: function (e, t) {
            var n = {
                latitude: t === !0 ? e[this.getKeys(e).latitude] : this.useDecimal(e[this.getKeys(e).latitude]),
                longitude: t === !0 ? e[this.getKeys(e).longitude] : this.useDecimal(e[this.getKeys(e).longitude])
            }, r = e[this.getKeys(e).elevation];
            return "undefined" != typeof r && (n.elevation = r), n
        }, validate: function (e) {
            var t = this.getKeys(e);
            if ("undefined" == typeof t || "undefined" == typeof t.latitude || "undefined" === t.longitude)return !1;
            var n = e[t.latitude], r = e[t.longitude];
            return "undefined" == typeof n || !this.isDecimal(n) && !this.isSexagesimal(n) ? !1 : "undefined" == typeof r || !this.isDecimal(r) && !this.isSexagesimal(r) ? !1 : (n = this.useDecimal(n), r = this.useDecimal(r), n < this.minLat || n > this.maxLat || r < this.minLon || r > this.maxLon ? !1 : !0)
        }, getDistance: function (e, t, n) {
            n = Math.floor(n) || 1;
            var i, o, a, s, c, l, u, d = this.coords(e), p = this.coords(t), f = 6378137, h = 6356752.314245, m = 1 / 298.257223563, g = (p.longitude - d.longitude).toRad(), v = Math.atan((1 - m) * Math.tan(parseFloat(d.latitude).toRad())), _ = Math.atan((1 - m) * Math.tan(parseFloat(p.latitude).toRad())), y = Math.sin(v), b = Math.cos(v), $ = Math.sin(_), w = Math.cos(_), x = g, S = 100;
            do {
                var C = Math.sin(x), k = Math.cos(x);
                if (l = Math.sqrt(w * C * w * C + (b * $ - y * w * k) * (b * $ - y * w * k)), 0 === l)return r.distance = 0;
                i = y * $ + b * w * k, o = Math.atan2(l, i), a = b * w * C / l, s = 1 - a * a, c = i - 2 * y * $ / s, isNaN(c) && (c = 0);
                var T = m / 16 * s * (4 + m * (4 - 3 * s));
                u = x, x = g + (1 - T) * m * a * (o + T * l * (c + T * i * (-1 + 2 * c * c)))
            } while (Math.abs(x - u) > 1e-12 && --S > 0);
            if (0 === S)return 0 / 0;
            var E = s * (f * f - h * h) / (h * h), A = 1 + E / 16384 * (4096 + E * (-768 + E * (320 - 175 * E))), M = E / 1024 * (256 + E * (-128 + E * (74 - 47 * E))), D = M * l * (c + M / 4 * (i * (-1 + 2 * c * c) - M / 6 * c * (-3 + 4 * l * l) * (-3 + 4 * c * c))), q = h * A * (o - D);
            if (q = q.toFixed(3), "undefined" != typeof this.elevation(e) && "undefined" != typeof this.elevation(t)) {
                var L = Math.abs(this.elevation(e) - this.elevation(t));
                q = Math.sqrt(q * q + L * L)
            }
            return this.distance = Math.floor(Math.round(q / n) * n)
        }, getDistanceSimple: function (e, t, n) {
            n = Math.floor(n) || 1;
            var i = Math.round(Math.acos(Math.sin(this.latitude(t).toRad()) * Math.sin(this.latitude(e).toRad()) + Math.cos(this.latitude(t).toRad()) * Math.cos(this.latitude(e).toRad()) * Math.cos(this.longitude(e).toRad() - this.longitude(t).toRad())) * this.radius);
            return r.distance = Math.floor(Math.round(i / n) * n)
        }, getCenter: function (e) {
            if (!e.length)return !1;
            var t, n, r = function (e) {
                return Math.max.apply(Math, e)
            }, i = function (e) {
                return Math.min.apply(Math, e)
            }, o = {latitude: [], longitude: []};
            for (var a in e)o.latitude.push(this.latitude(e[a])), o.longitude.push(this.longitude(e[a]));
            var s = i(o.latitude), c = i(o.longitude), l = r(o.latitude), u = r(o.longitude);
            t = ((s + l) / 2).toFixed(6), n = ((c + u) / 2).toFixed(6);
            var d = this.convertUnit("km", this.getDistance({latitude: s, longitude: c}, {latitude: l, longitude: u}));
            return {latitude: t, longitude: n, distance: d}
        }, getBounds: function (e) {
            if (!e.length)return !1;
            var t = this.elevation(e[0]), n = {maxLat: -1 / 0, minLat: 1 / 0, maxLng: -1 / 0, minLng: 1 / 0};
            "undefined" != typeof t && (n.maxElev = 0, n.minElev = 1 / 0);
            for (var r = 0, i = e.length; i > r; ++r)n.maxLat = Math.max(this.latitude(e[r]), n.maxLat), n.minLat = Math.min(this.latitude(e[r]), n.minLat), n.maxLng = Math.max(this.longitude(e[r]), n.maxLng), n.minLng = Math.min(this.longitude(e[r]), n.minLng), t && (n.maxElev = Math.max(this.elevation(e[r]), n.maxElev), n.minElev = Math.min(this.elevation(e[r]), n.minElev));
            return n
        }, getBoundsOfDistance: function (e, t) {
            var n, r, i = this.latitude(e), o = this.longitude(e), a = i.toRad(), s = o.toRad(), c = t / this.radius, l = a - c, u = a + c, d = this.maxLat.toRad(), p = this.minLat.toRad(), f = this.maxLon.toRad(), h = this.minLon.toRad();
            if (l > p && d > u) {
                var m = Math.asin(Math.sin(c) / Math.cos(a));
                n = s - m, h > n && (n += 2 * Math.PI), r = s + m, r > f && (r -= 2 * Math.PI)
            } else l = Math.max(l, p), u = Math.min(u, d), n = h, r = f;
            return [{latitude: l.toDeg(), longitude: n.toDeg()}, {latitude: u.toDeg(), longitude: r.toDeg()}]
        }, isPointInside: function (e, t) {
            for (var n = !1, r = -1, i = t.length, o = i - 1; ++r < i; o = r)(this.longitude(t[r]) <= this.longitude(e) && this.longitude(e) < this.longitude(t[o]) || this.longitude(t[o]) <= this.longitude(e) && this.longitude(e) < this.longitude(t[r])) && this.latitude(e) < (this.latitude(t[o]) - this.latitude(t[r])) * (this.longitude(e) - this.longitude(t[r])) / (this.longitude(t[o]) - this.longitude(t[r])) + this.latitude(t[r]) && (n = !n);
            return n
        }, preparePolygonForIsPointInsideOptimized: function (e) {
            for (var t = 0, n = e.length - 1; t < e.length; t++)this.longitude(e[n]) === this.longitude(e[t]) ? (e[t].constant = this.latitude(e[t]), e[t].multiple = 0) : (e[t].constant = this.latitude(e[t]) - this.longitude(e[t]) * this.latitude(e[n]) / (this.longitude(e[n]) - this.longitude(e[t])) + this.longitude(e[t]) * this.latitude(e[t]) / (this.longitude(e[n]) - this.longitude(e[t])), e[t].multiple = (this.latitude(e[n]) - this.latitude(e[t])) / (this.longitude(e[n]) - this.longitude(e[t]))), n = t
        }, isPointInsideWithPreparedPolygon: function (e, t) {
            for (var n = !1, r = this.longitude(e), i = this.latitude(e), o = 0, a = t.length - 1; o < t.length; o++)(this.longitude(t[o]) < r && this.longitude(t[a]) >= r || this.longitude(t[a]) < r && this.longitude(t[o]) >= r) && (n ^= r * t[o].multiple + t[o].constant < i), a = o;
            return n
        }, isInside: function () {
            return this.isPointInside.apply(this, arguments)
        }, isPointInCircle: function (e, t, n) {
            return this.getDistance(e, t) < n
        }, withinRadius: function () {
            return this.isPointInCircle.apply(this, arguments)
        }, getRhumbLineBearing: function (e, t) {
            var n = this.longitude(t).toRad() - this.longitude(e).toRad(), r = Math.log(Math.tan(this.latitude(t).toRad() / 2 + Math.PI / 4) / Math.tan(this.latitude(e).toRad() / 2 + Math.PI / 4));
            return Math.abs(n) > Math.PI && (n = n > 0 ? -1 * (2 * Math.PI - n) : 2 * Math.PI + n), (Math.atan2(n, r).toDeg() + 360) % 360
        }, getBearing: function (e, t) {
            t.latitude = this.latitude(t), t.longitude = this.longitude(t), e.latitude = this.latitude(e), e.longitude = this.longitude(e);
            var n = (Math.atan2(Math.sin(t.longitude.toRad() - e.longitude.toRad()) * Math.cos(t.latitude.toRad()), Math.cos(e.latitude.toRad()) * Math.sin(t.latitude.toRad()) - Math.sin(e.latitude.toRad()) * Math.cos(t.latitude.toRad()) * Math.cos(t.longitude.toRad() - e.longitude.toRad())).toDeg() + 360) % 360;
            return n
        }, getCompassDirection: function (e, t, n) {
            var r, i;
            switch (i = "circle" == n ? this.getBearing(e, t) : this.getRhumbLineBearing(e, t), Math.round(i / 22.5)) {
                case 1:
                    r = {exact: "NNE", rough: "N"};
                    break;
                case 2:
                    r = {exact: "NE", rough: "N"};
                    break;
                case 3:
                    r = {exact: "ENE", rough: "E"};
                    break;
                case 4:
                    r = {exact: "E", rough: "E"};
                    break;
                case 5:
                    r = {exact: "ESE", rough: "E"};
                    break;
                case 6:
                    r = {exact: "SE", rough: "E"};
                    break;
                case 7:
                    r = {exact: "SSE", rough: "S"};
                    break;
                case 8:
                    r = {exact: "S", rough: "S"};
                    break;
                case 9:
                    r = {exact: "SSW", rough: "S"};
                    break;
                case 10:
                    r = {exact: "SW", rough: "S"};
                    break;
                case 11:
                    r = {exact: "WSW", rough: "W"};
                    break;
                case 12:
                    r = {exact: "W", rough: "W"};
                    break;
                case 13:
                    r = {exact: "WNW", rough: "W"};
                    break;
                case 14:
                    r = {exact: "NW", rough: "W"};
                    break;
                case 15:
                    r = {exact: "NNW", rough: "N"};
                    break;
                default:
                    r = {exact: "N", rough: "N"}
            }
            return r.bearing = i, r
        }, getDirection: function () {
            return this.getCompassDirection.apply(this, arguments)
        }, orderByDistance: function (e, t) {
            var n = [];
            for (var r in t) {
                var i = this.getDistance(e, t[r]);
                n.push({key: r, latitude: this.latitude(t[r]), longitude: this.longitude(t[r]), distance: i})
            }
            return n.sort(function (e, t) {
                return e.distance - t.distance
            })
        }, findNearest: function (e, t, n, r) {
            n = n || 0, r = r || 1;
            var i = this.orderByDistance(e, t);
            return 1 === r ? i[n] : i.splice(n, r)
        }, getPathLength: function (e) {
            for (var t, n = 0, r = 0, i = e.length; i > r; ++r)t && (n += this.getDistance(this.coords(e[r]), t)), t = this.coords(e[r]);
            return n
        }, getSpeed: function (e, t, n) {
            var i = n && n.unit || "km";
            "mph" == i ? i = "mi" : "kmh" == i && (i = "km");
            var o = r.getDistance(e, t), a = 1 * t.time / 1e3 - 1 * e.time / 1e3, s = o / a * 3600, c = Math.round(s * this.measures[i] * 1e4) / 1e4;
            return c
        }, convertUnit: function (e, t, n) {
            if (0 === t || "undefined" == typeof t) {
                if (0 === this.distance)return 0;
                t = this.distance
            }
            if (e = e || "m", n = null == n ? 4 : n, "undefined" != typeof this.measures[e])return this.round(t * this.measures[e], n);
            throw new Error("Unknown unit for conversion.")
        }, useDecimal: function (e) {
            if ("[object Array]" === Object.prototype.toString.call(e)) {
                var t = this;
                return e = e.map(function (e) {
                    if (t.isDecimal(e))return t.useDecimal(e);
                    if ("object" == typeof e) {
                        if (t.validate(e))return t.coords(e);
                        for (var n in e)e[n] = t.useDecimal(e[n]);
                        return e
                    }
                    return t.isSexagesimal(e) ? t.sexagesimal2decimal(e) : e
                })
            }
            if ("object" == typeof e && this.validate(e))return this.coords(e);
            if ("object" == typeof e) {
                for (var n in e)e[n] = this.useDecimal(e[n]);
                return e
            }
            if (this.isDecimal(e))return parseFloat(e);
            if (this.isSexagesimal(e) === !0)return parseFloat(this.sexagesimal2decimal(e));
            throw new Error("Unknown format.")
        }, decimal2sexagesimal: function (e) {
            if (e in this.sexagesimal)return this.sexagesimal[e];
            var t = e.toString().split("."), n = Math.abs(t[0]), r = 60 * ("0." + t[1]), i = r.toString().split(".");
            return r = Math.floor(r), i = (60 * ("0." + i[1])).toFixed(2), this.sexagesimal[e] = n + "\xb0 " + r + "' " + i + '"', this.sexagesimal[e]
        }, sexagesimal2decimal: function (e) {
            if (e in this.decimal)return this.decimal[e];
            var t = new RegExp(this.sexagesimalPattern), n = t.exec(e), r = 0, i = 0;
            n && (r = parseFloat(n[2] / 60), i = parseFloat(n[4] / 3600) || 0);
            var o = (parseFloat(n[1]) + r + i).toFixed(8);
            return o = parseFloat("S" == n[7] || "W" == n[7] ? -o : o), this.decimal[e] = o, o
        }, isDecimal: function (e) {
            return e = e.toString().replace(/\s*/, ""), !isNaN(parseFloat(e)) && parseFloat(e) == e
        }, isSexagesimal: function (e) {
            return e = e.toString().replace(/\s*/, ""), this.sexagesimalPattern.test(e)
        }, round: function (e, t) {
            var n = Math.pow(10, t);
            return Math.round(e * n) / n
        }
    }), "undefined" != typeof module && "undefined" != typeof module.exports ? e.geolib = module.exports = r : "function" == typeof define && define.amd ? define("geolib", [], function () {
        return r
    }) : e.geolib = r
}(this), function (e, t) {
    var n = {
        getElevation: function () {
            "undefined" != typeof e.navigator ? this.getElevationClient.apply(this, arguments) : this.getElevationServer.apply(this, arguments)
        }, getElevationClient: function (t, n) {
            if (!e.google)throw new Error("Google maps api not loaded");
            if (0 === t.length)return n(null, null);
            if (1 === t.length)return n(new Error("getElevation requires at least 2 points."));
            for (var r = [], i = 0; i < t.length; i++)r.push(new google.maps.LatLng(this.latitude(t[i]), this.longitude(t[i])));
            var o = {path: r, samples: r.length}, a = new google.maps.ElevationService, s = this;
            a.getElevationAlongPath(o, function (e, r) {
                s.elevationHandler(e, r, t, n)
            })
        }, getElevationServer: function (e, t) {
            if (0 === e.length)return t(null, null);
            if (1 === e.length)return t(new Error("getElevation requires at least 2 points."));
            for (var n = require("googlemaps"), r = [], i = 0; i < e.length; i++)r.push(this.latitude(e[i]) + "," + this.longitude(e[i]));
            var o = this;
            n.elevationFromPath(r.join("|"), r.length, function (n, r) {
                o.elevationHandler(r.results, r.status, e, t)
            })
        }, elevationHandler: function (e, t, n, r) {
            var i = [];
            if ("OK" == t) {
                for (var o = 0; o < e.length; o++)i.push({
                    lat: this.latitude(n[o]),
                    lng: this.longitude(n[o]),
                    elev: e[o].elevation
                });
                r(null, i)
            } else r(new Error("Could not get elevation using Google's API"), elevationResult.status)
        }, getGrade: function (e) {
            var t = Math.abs(this.elevation(e[e.length - 1]) - this.elevation(e[0])), n = this.getPathLength(e);
            return Math.floor(t / n * 100)
        }, getTotalElevationGainAndLoss: function (e) {
            for (var t = 0, n = 0, r = 0; r < e.length - 1; r++) {
                var i = this.elevation(e[r]) - this.elevation(e[r + 1]);
                i > 0 ? n += i : t += Math.abs(i)
            }
            return {gain: t, loss: n}
        }
    };
    "undefined" != typeof module && "undefined" != typeof module.exports ? (t = require("geolib"), t.extend(n)) : "function" == typeof define && define.amd ? define(["geolib"], function (e) {
        return e.extend(n), e
    }) : t.extend(n)
}(this, this.geolib), function () {
    "use strict";
    function e(n, r) {
        function i(e, t) {
            return function () {
                return e.apply(t, arguments)
            }
        }

        var o;
        if (r = r || {}, this.trackingClick = !1, this.trackingClickStart = 0, this.targetElement = null, this.touchStartX = 0, this.touchStartY = 0, this.lastTouchIdentifier = 0, this.touchBoundary = r.touchBoundary || 10, this.layer = n, this.tapDelay = r.tapDelay || 200, !e.notNeeded(n)) {
            for (var a = ["onMouse", "onClick", "onTouchStart", "onTouchMove", "onTouchEnd", "onTouchCancel"], s = this, c = 0, l = a.length; l > c; c++)s[a[c]] = i(s[a[c]], s);
            t && (n.addEventListener("mouseover", this.onMouse, !0), n.addEventListener("mousedown", this.onMouse, !0), n.addEventListener("mouseup", this.onMouse, !0)), n.addEventListener("click", this.onClick, !0), n.addEventListener("touchstart", this.onTouchStart, !1), n.addEventListener("touchmove", this.onTouchMove, !1), n.addEventListener("touchend", this.onTouchEnd, !1), n.addEventListener("touchcancel", this.onTouchCancel, !1), Event.prototype.stopImmediatePropagation || (n.removeEventListener = function (e, t, r) {
                var i = Node.prototype.removeEventListener;
                "click" === e ? i.call(n, e, t.hijacked || t, r) : i.call(n, e, t, r)
            }, n.addEventListener = function (e, t, r) {
                var i = Node.prototype.addEventListener;
                "click" === e ? i.call(n, e, t.hijacked || (t.hijacked = function (e) {
                    e.propagationStopped || t(e)
                }), r) : i.call(n, e, t, r)
            }), "function" == typeof n.onclick && (o = n.onclick, n.addEventListener("click", function (e) {
                o(e)
            }, !1), n.onclick = null)
        }
    }

    var t = navigator.userAgent.indexOf("Android") > 0, n = /iP(ad|hone|od)/.test(navigator.userAgent), r = n && /OS 4_\d(_\d)?/.test(navigator.userAgent), i = n && /OS ([6-9]|\d{2})_\d/.test(navigator.userAgent), o = navigator.userAgent.indexOf("BB10") > 0;
    e.prototype.needsClick = function (e) {
        switch (e.nodeName.toLowerCase()) {
            case"button":
            case"select":
            case"textarea":
                if (e.disabled)return !0;
                break;
            case"input":
                if (n && "file" === e.type || e.disabled)return !0;
                break;
            case"label":
            case"video":
                return !0
        }
        return /\bneedsclick\b/.test(e.className)
    }, e.prototype.needsFocus = function (e) {
        switch (e.nodeName.toLowerCase()) {
            case"textarea":
                return !0;
            case"select":
                return !t;
            case"input":
                switch (e.type) {
                    case"button":
                    case"checkbox":
                    case"file":
                    case"image":
                    case"radio":
                    case"submit":
                        return !1
                }
                return !e.disabled && !e.readOnly;
            default:
                return /\bneedsfocus\b/.test(e.className)
        }
    }, e.prototype.sendClick = function (e, t) {
        var n, r;
        document.activeElement && document.activeElement !== e && document.activeElement.blur(), r = t.changedTouches[0], n = document.createEvent("MouseEvents"), n.initMouseEvent(this.determineEventType(e), !0, !0, window, 1, r.screenX, r.screenY, r.clientX, r.clientY, !1, !1, !1, !1, 0, null), n.forwardedTouchEvent = !0, e.dispatchEvent(n)
    }, e.prototype.determineEventType = function (e) {
        return t && "select" === e.tagName.toLowerCase() ? "mousedown" : "click"
    }, e.prototype.focus = function (e) {
        var t;
        n && e.setSelectionRange && 0 !== e.type.indexOf("date") && "time" !== e.type && "month" !== e.type ? (t = e.value.length, e.setSelectionRange(t, t)) : e.focus()
    }, e.prototype.updateScrollParent = function (e) {
        var t, n;
        if (t = e.fastClickScrollParent, !t || !t.contains(e)) {
            n = e;
            do {
                if (n.scrollHeight > n.offsetHeight) {
                    t = n, e.fastClickScrollParent = n;
                    break
                }
                n = n.parentElement
            } while (n)
        }
        t && (t.fastClickLastScrollTop = t.scrollTop)
    }, e.prototype.getTargetElementFromEventTarget = function (e) {
        return e.nodeType === Node.TEXT_NODE ? e.parentNode : e
    }, e.prototype.onTouchStart = function (e) {
        var t, i, o;
        if (e.targetTouches.length > 1)return !0;
        if (t = this.getTargetElementFromEventTarget(e.target), i = e.targetTouches[0], n) {
            if (o = window.getSelection(), o.rangeCount && !o.isCollapsed)return !0;
            if (!r) {
                if (i.identifier && i.identifier === this.lastTouchIdentifier)return e.preventDefault(), !1;
                this.lastTouchIdentifier = i.identifier, this.updateScrollParent(t)
            }
        }
        return this.trackingClick = !0, this.trackingClickStart = e.timeStamp, this.targetElement = t, this.touchStartX = i.pageX, this.touchStartY = i.pageY, e.timeStamp - this.lastClickTime < this.tapDelay && e.preventDefault(), !0
    }, e.prototype.touchHasMoved = function (e) {
        var t = e.changedTouches[0], n = this.touchBoundary;
        return Math.abs(t.pageX - this.touchStartX) > n || Math.abs(t.pageY - this.touchStartY) > n ? !0 : !1
    }, e.prototype.onTouchMove = function (e) {
        return this.trackingClick ? ((this.targetElement !== this.getTargetElementFromEventTarget(e.target) || this.touchHasMoved(e)) && (this.trackingClick = !1, this.targetElement = null), !0) : !0
    }, e.prototype.findControl = function (e) {
        return void 0 !== e.control ? e.control : e.htmlFor ? document.getElementById(e.htmlFor) : e.querySelector("button, input:not([type=hidden]), keygen, meter, output, progress, select, textarea")
    }, e.prototype.onTouchEnd = function (e) {
        var o, a, s, c, l, u = this.targetElement;
        if (!this.trackingClick)return !0;
        if (e.timeStamp - this.lastClickTime < this.tapDelay)return this.cancelNextClick = !0, !0;
        if (this.cancelNextClick = !1, this.lastClickTime = e.timeStamp, a = this.trackingClickStart, this.trackingClick = !1, this.trackingClickStart = 0, i && (l = e.changedTouches[0], u = document.elementFromPoint(l.pageX - window.pageXOffset, l.pageY - window.pageYOffset) || u, u.fastClickScrollParent = this.targetElement.fastClickScrollParent), s = u.tagName.toLowerCase(), "label" === s) {
            if (o = this.findControl(u)) {
                if (this.focus(u), t)return !1;
                u = o
            }
        } else if (this.needsFocus(u))return e.timeStamp - a > 100 || n && window.top !== window && "input" === s ? (this.targetElement = null, !1) : (this.focus(u), this.sendClick(u, e), n && "select" === s || (this.targetElement = null, e.preventDefault()), !1);
        return n && !r && (c = u.fastClickScrollParent, c && c.fastClickLastScrollTop !== c.scrollTop) ? !0 : (this.needsClick(u) || (e.preventDefault(), this.sendClick(u, e)), !1)
    }, e.prototype.onTouchCancel = function () {
        this.trackingClick = !1, this.targetElement = null
    }, e.prototype.onMouse = function (e) {
        return this.targetElement ? e.forwardedTouchEvent ? !0 : e.cancelable && (!this.needsClick(this.targetElement) || this.cancelNextClick) ? (e.stopImmediatePropagation ? e.stopImmediatePropagation() : e.propagationStopped = !0, e.stopPropagation(), e.preventDefault(), !1) : !0 : !0
    }, e.prototype.onClick = function (e) {
        var t;
        return this.trackingClick ? (this.targetElement = null, this.trackingClick = !1, !0) : "submit" === e.target.type && 0 === e.detail ? !0 : (t = this.onMouse(e), t || (this.targetElement = null), t)
    }, e.prototype.destroy = function () {
        var e = this.layer;
        t && (e.removeEventListener("mouseover", this.onMouse, !0), e.removeEventListener("mousedown", this.onMouse, !0), e.removeEventListener("mouseup", this.onMouse, !0)), e.removeEventListener("click", this.onClick, !0), e.removeEventListener("touchstart", this.onTouchStart, !1), e.removeEventListener("touchmove", this.onTouchMove, !1), e.removeEventListener("touchend", this.onTouchEnd, !1), e.removeEventListener("touchcancel", this.onTouchCancel, !1)
    }, e.notNeeded = function (e) {
        var n, r, i;
        if ("undefined" == typeof window.ontouchstart)return !0;
        if (r = +(/Chrome\/([0-9]+)/.exec(navigator.userAgent) || [, 0])[1]) {
            if (!t)return !0;
            if (n = document.querySelector("meta[name=viewport]")) {
                if (-1 !== n.content.indexOf("user-scalable=no"))return !0;
                if (r > 31 && document.documentElement.scrollWidth <= window.outerWidth)return !0
            }
        }
        if (o && (i = navigator.userAgent.match(/Version\/([0-9]*)\.([0-9]*)/), i[1] >= 10 && i[2] >= 3 && (n = document.querySelector("meta[name=viewport]")))) {
            if (-1 !== n.content.indexOf("user-scalable=no"))return !0;
            if (document.documentElement.scrollWidth <= window.outerWidth)return !0
        }
        return "none" === e.style.msTouchAction ? !0 : !1
    }, e.attach = function (t, n) {
        return new e(t, n)
    }, "function" == typeof define && "object" == typeof define.amd && define.amd ? define(function () {
        return e
    }) : "undefined" != typeof module && module.exports ? (module.exports = e.attach, module.exports.FastClick = e) : window.FastClick = e
}(), function (e) {
    function t(e) {
        var t = document.createElement("DIV");
        return t.innerHTML = e, t.textContent || t.innerText || ""
    }

    function n() {
        wx.config({
            debug: !1,
            appId: i,
            timestamp: parseInt(o),
            nonceStr: a,
            signature: s,
            jsApiList: ["checkJsApi", "onMenuShareTimeline", "onMenuShareAppMessage", "onMenuShareQQ", "onMenuShareWeibo", "hideMenuItems", "showMenuItems", "hideAllNonBaseMenuItem", "showAllNonBaseMenuItem", "translateVoice", "startRecord", "stopRecord", "onRecordEnd", "playVoice", "pauseVoice", "stopVoice", "uploadVoice", "downloadVoice", "chooseImage", "previewImage", "uploadImage", "downloadImage", "getNetworkType", "openLocation", "getLocation", "hideOptionMenu", "showOptionMenu", "closeWindow", "scanQRCode", "chooseWXPay", "openProductSpecificView", "addCard", "chooseCard", "openCard"]
        })
    }

    function r() {
    }

    var i = e('meta[name="wxConfigAppId"]').attr("content"), o = e('meta[name="wxConfigTimestamp"]').attr("content"), a = e('meta[name="wxConfigNonceStr"]').attr("content"), s = e('meta[name="wxConfigSignature"]').attr("content"), c = {
        title: "",
        desc: "",
        link: "",
        imgUrl: "",
        success: function (e) {
            l.shareSuccess && l.shareSuccess(e, this)
        },
        cancel: function (e) {
            l.shareCancel && l.shareCancel(e, this)
        },
        complete: function (e) {
            l.shareComplete && l.shareComplete(e, this)
        },
        fail: function (e) {
            l.shareFail && l.shareFail(e, this)
        },
        trigger: function (e) {
            l.shareTrigger && l.shareTrigger(e, this), this.desc = t(this.desc)
        }
    }, l = {}, u = {};
    u.isWeixinConfigOK = !1, u.init = function () {
        var e = this;
        n(), wx.ready(function () {
            e.isWeixinConfigOK = !0, wx.onMenuShareTimeline(c), wx.onMenuShareAppMessage(c), wx.onMenuShareQQ(c), wx.onMenuShareWeibo(c)
        }), wx.error(function () {
            e.isWeixinConfigOK = !1, alert("\u52a0\u8f7d\u5fae\u4fe1jssdk\u5931\u8d25\uff0c\u8bf7\u7ba1\u7406\u5458\u68c0\u67e5\u5982\u4e0b\u4fe1\u606f\uff1a\u516c\u4f17\u53f7\u5e73\u53f0\u7684JS\u63a5\u53e3\u5b89\u5168\u57df\u540d\u987b\u8bbe\u7f6e\u4e3adiandanbao.com\uff0c\u7b2c\u4e09\u65b9\u5e73\u53f0\u7684\u4e3b\u516c\u4f17\u8d26\u53f7AppId\u548cAppSecret\u662f\u5426\u8bbe\u7f6e\u6b63\u786e\u3002"), r()
        })
    }, u.bindShareCallback = function (t, n, r, i, o) {
        if ("function" == typeof t)l.shareTrigger = t, l.shareSuccess = n, l.shareFail = r, l.shareCancel = i, l.shareComplete = o; else {
            var a = t;
            e.each("shareTrigger shareSuccess shareFail shareCancel shareComplete".split(/\s+/), function (e, t) {
                l[t] = a[t]
            })
        }
    }, u.openInWeixin = function () {
        return /MicroMessenger/i.test(navigator.userAgent)
    }, u.init(), window.WeixinApi = u
}(jQuery), function () {
    "use strict";
    angular.module("rn-lazy", []).directive("rnLazyBackground", ["$document", "$parse", function (e, t) {
        return {
            restrict: "A", link: function (n, r, i) {
                function o(e) {
                    a && (e.html(""), e.append(a), e.css({"background-image": null}))
                }

                var a = null;
                angular.isDefined(i.rnLazyLoader) && (a = angular.element(e[0].querySelector(i.rnLazyLoader)).clone());
                var s = t(i.rnLazyBackground);
                n.$watch(s, function () {
                    o(r);
                    var t = s(n), c = e[0].createElement("img");
                    c.onload = function () {
                        a && a.remove(), angular.isDefined(i.rnLazyLoadingClass) && r.removeClass(i.rnLazyLoadingClass), angular.isDefined(i.rnLazyLoadedClass) && r.addClass(i.rnLazyLoadedClass), r.css({"background-image": "url(" + this.src + ")"})
                    }, c.onerror = function () {
                    }, c.src = t
                })
            }
        }
    }])
}(), angular.module("diandanbao_app.constants", []).constant("DiandanbaoConst", {
    shop_slug: window.location.pathname.split("/")[3],
    baseUrl: "/weixin/shops/" + window.location.pathname.split("/")[3],
    directiveTemplateBaseUrl: "/weixin/client_partials/directives",
    oauth_user_info_url: angular.element('meta[name="oauth_user_info_url"]').attr("content")
}), angular.module("diandanbao_app.route_config", []).provider("RouteConfig", function () {
    this.$get = function () {
        function e() {
            return n
        }

        function t(e) {
            n = n.concat(e)
        }

        var n = [], r = [{
            path: "/",
            templateUrl: "/weixin/client_partials/shops/show.html",
            controller: "shopController"
        }], i = [{
            path: "/branches/:branch_id/reservation_time_points",
            templateUrl: "/weixin/client_partials/reservation_time_points/index.html",
            controller: "reservationTimePointsController"
        }], o = [{
            path: "/branches",
            templateUrl: "/weixin/client_partials/branches/index.html",
            controller: "branchesController"
        }, {
            path: "/delivery_branches",
            templateUrl: "/weixin/client_partials/branches/delivery_index.html",
            controller: "deliveryBranchesController"
        }, {
            path: "/branches/:branch_id",
            templateUrl: "/weixin/client_partials/branches/show.html",
            controller: "branchController"
        }, {
            path: "/branches/:branch_id/introduction",
            templateUrl: "/weixin/client_partials/branches/introduction.html",
            controller: "branchController"
        }], a = [{
            path: "/search",
            templateUrl: "/weixin/client_partials/searches/index.html",
            controller: "searchController"
        }], s = [{
            path: "/branches/:branch_id/combos",
            templateUrl: "/weixin/client_partials/combos/index.html",
            controller: "combosController"
        }], c = [{
            path: "/branches/:branch_id/products/delivery",
            templateUrl: "/weixin/client_partials/products/delivery.html",
            controller: "deliveryProductsController"
        }, {
            path: "/branches/:branch_id/products/eat_in_hall",
            templateUrl: "/weixin/client_partials/products/eat_in_hall.html",
            controller: "eatInHallProductsController"
        }, {
            path: "/branches/:branch_id/products/reservation",
            templateUrl: "/weixin/client_partials/products/reservation.html",
            controller: "reservationProductsController"
        }, {
            path: "/branches/:branch_id/products/search",
            templateUrl: "/weixin/client_partials/products/search.html",
            controller: "searchProductsController"
        }, {
            path: "/branches/:branch_id/products/:product_id",
            templateUrl: "/weixin/client_partials/products/show.html",
            controller: "productController"
        }], l = [{
            path: "/promotions",
            templateUrl: "/weixin/client_partials/promotions/index.html",
            controller: "promotionsController"
        }, {
            path: "/promotions/:promotion_id",
            templateUrl: "/weixin/client_partials/promotions/show.html",
            controller: "promotionController"
        }], u = [{
            path: "/branches/:branch_id/guest_queue",
            templateUrl: "/weixin/client_partials/guest_queues/show.html",
            controller: "guestQueueController"
        }, {
            path: "/branches/:branch_id/guest_queues/new_guest",
            templateUrl: "/weixin/client_partials/guest_queues/new_guest.html",
            controller: "newGuestQueueController"
        }, {
            path: "/branches/:branch_id/guest_queue_qr_code/:qr_code_id",
            templateUrl: "/weixin/client_partials/guest_queues/bind_user.html",
            controller: "bindUserGuestQueueController"
        }], d = [{
            path: "/branches/:branch_id/pay_online",
            templateUrl: "/weixin/client_partials/pay_onlines/new.html",
            controller: "newPayOnlineController"
        }], p = [{
            path: "/branches/:branch_id/orders/delivery/new",
            templateUrl: "/weixin/client_partials/orders/delivery/new.html",
            controller: "newDeliveryOrderController"
        }, {
            path: "/branches/:branch_id/orders/eat_in_hall/new",
            templateUrl: "/weixin/client_partials/orders/eat_in_hall/new.html",
            controller: "newEatInHallOrderController"
        }, {
            path: "/branches/:branch_id/orders/reservation/new",
            templateUrl: "/weixin/client_partials/orders/reservation/new.html",
            controller: "newReservationOrderController"
        }, {
            path: "/branches/:branch_id/orders/groupon/new",
            templateUrl: "/weixin/client_partials/orders/groupon/new.html",
            controller: "newGrouponOrderController"
        }, {
            path: "/branches/:branch_id/orders/recharge/new",
            templateUrl: "/weixin/client_partials/orders/recharge/new.html",
            controller: "newRechargeOrderController"
        }, {
            path: "/orders/nav",
            templateUrl: "/weixin/client_partials/orders/nav.html",
            controller: "ordersNavController"
        }, {
            path: "/orders/delivery",
            templateUrl: "/weixin/client_partials/orders/delivery/index.html",
            controller: "deliveryOrdersController"
        }, {
            path: "/orders/reservation",
            templateUrl: "/weixin/client_partials/orders/reservation/index.html",
            controller: "reservationOrdersController"
        }, {
            path: "/orders/eat_in_hall",
            templateUrl: "/weixin/client_partials/orders/eat_in_hall/index.html",
            controller: "eatInHallOrdersController"
        }, {
            path: "/orders/groupon",
            templateUrl: "/weixin/client_partials/orders/groupon/index.html",
            controller: "grouponOrdersController"
        }, {
            path: "/orders/recharge",
            templateUrl: "/weixin/client_partials/orders/recharge/index.html",
            controller: "rechargeOrdersController"
        }, {
            path: "/orders/payment",
            templateUrl: "/weixin/client_partials/orders/payment/index.html",
            controller: "paymentOrdersController"
        }, {
            path: "/branches/:branch_id/orders/delivery/:order_id",
            templateUrl: "/weixin/client_partials/orders/delivery/show.html",
            controller: "deliveryOrderController"
        }, {
            path: "/branches/:branch_id/orders/reservation/:order_id",
            templateUrl: "/weixin/client_partials/orders/reservation/show.html",
            controller: "reservationOrderController"
        }, {
            path: "/branches/:branch_id/orders/eat_in_hall/:order_id",
            templateUrl: "/weixin/client_partials/orders/eat_in_hall/show.html",
            controller: "eatInHallOrderController"
        }, {
            path: "/branches/:branch_id/orders/groupon/:order_id",
            templateUrl: "/weixin/client_partials/orders/groupon/show.html",
            controller: "grouponOrderController"
        }, {
            path: "/branches/:branch_id/orders/recharge/:order_id",
            templateUrl: "/weixin/client_partials/orders/recharge/show.html",
            controller: "rechargeOrderController"
        }, {
            path: "/branches/:branch_id/orders/payment/:order_id",
            templateUrl: "/weixin/client_partials/orders/payment/show.html",
            controller: "paymentOrderController"
        }, {
            path: "/branches/:branch_id/order_success/:order_id/:order_type",
            templateUrl: "/weixin/client_partials/orders/order_success.html",
            controller: "orderSuccessController"
        }, {
            path: "/branches/:branch_id/orders/:order_type/:order_id/invoice",
            templateUrl: "/weixin/client_partials/orders/invoice/new.html",
            controller: "invoiceController"
        }, {
            path: "/branches/:branch_id/orders/:order_type/:order_id/deliveryman_location",
            templateUrl: "/weixin/client_partials/orders/delivery/deliveryman_location.html",
            controller: "deliverymanLocationController"
        }, {
            path: "/branches/:branch_id/orders/:order_id/:order_type/append_itemable",
            templateUrl: "/weixin/client_partials/orders/append_itemable.html",
            controller: "orderAppendItemableController"
        }, {
            path: "/branches/:branch_id/orders/invitation/:order_id",
            templateUrl: "/weixin/client_partials/orders/invitation/show.html",
            controller: "invitationOrderController"
        }], f = [{
            path: "/branches/:branch_id/orders/:order_id/comment",
            templateUrl: "/weixin/client_partials/orders/comment/show.html",
            controller: "orderCommentController"
        }, {
            path: "/branches/:branch_id/orders/:order_id/comment/new",
            templateUrl: "/weixin/client_partials/orders/comment/new.html",
            controller: "newOrderCommentController"
        }], h = [{
            path: "/addresses",
            templateUrl: "/weixin/client_partials/addresses/index.html",
            controller: "addressesController"
        }, {
            path: "/addresses/new",
            templateUrl: "/weixin/client_partials/addresses/new.html",
            controller: "newAddressController"
        }, {
            path: "/addresses/:address_id/edit",
            templateUrl: "/weixin/client_partials/addresses/new.html",
            controller: "editAddressController"
        }, {
            path: "/addresses/:address_id/chose_location",
            templateUrl: "/weixin/client_partials/addresses/chose_location.html",
            controller: "choseAddressLocationController"
        }, {
            path: "/addresses/chose_location",
            templateUrl: "/weixin/client_partials/addresses/chose_location.html",
            controller: "choseAddressLocationController"
        }], m = [{
            path: "/user/profile",
            templateUrl: "/weixin/client_partials/user/profile.html",
            controller: "userController"
        }, {
            path: "/user/vip-info",
            templateUrl: "/weixin/client_partials/user/vip-info.html",
            controller: "userController"
        }, {
            path: "/user/update-vip-info",
            templateUrl: "/weixin/client_partials/user/update-vip-info.html",
            controller: "userUpdateVipInfoController"
        }, {
            path: "/user/update-pay-password",
            templateUrl: "/weixin/client_partials/user/update-pay-password.html",
            controller: "userUpdatePayPasswordController"
        }, {
            path: "/user/bind-vip",
            templateUrl: "/weixin/client_partials/user/bind-vip.html",
            controller: "userBindVipController"
        }], g = [{
            path: "/favorite_branches",
            templateUrl: "/weixin/client_partials/favorite_branches/index.html",
            controller: "favoriteBranchesController"
        }], v = [{
            path: "/branches/:branch_id/comments",
            templateUrl: "/weixin/client_partials/comments/index.html",
            controller: "commentsController"
        }], _ = [{
            path: "/branches/:branch_id/tables/:table_id",
            templateUrl: "/weixin/client_partials/tables/show.html",
            controller: "tableController"
        }], y = [{
            path: "/articles/:article_id",
            templateUrl: "/weixin/client_partials/articles/show.html",
            controller: "articleController"
        }], b = [{
            path: "/sign_records",
            templateUrl: "/weixin/client_partials/sign_records/index.html",
            controller: "signRecordsController"
        }], $ = [{
            path: "/tuans",
            templateUrl: "/weixin/client_partials/tuans/index.html",
            controller: "tuansController"
        }, {
            path: "/tuans/:tuan_id",
            templateUrl: "/weixin/client_partials/tuans/show.html",
            controller: "tuanController"
        }], w = [{
            path: "/user/coupon_nav",
            templateUrl: "/weixin/client_partials/coupon/nav.html",
            controller: "userController"
        }, {
            path: "/user/coupons",
            templateUrl: "/weixin/client_partials/coupon/coupons/index.html",
            controller: "couponsController"
        }, {
            path: "/user/coupons/:base_coupon_id",
            templateUrl: "/weixin/client_partials/coupon/coupons/show.html",
            controller: "couponController"
        }, {
            path: "/user/groupons",
            templateUrl: "/weixin/client_partials/coupon/groupons/index.html",
            controller: "grouponsController"
        }, {
            path: "/user/groupons/:base_coupon_id",
            templateUrl: "/weixin/client_partials/coupon/groupons/show.html",
            controller: "grouponController"
        }, {
            path: "/user/vouchers",
            templateUrl: "/weixin/client_partials/coupon/vouchers/index.html",
            controller: "vouchersController"
        }, {
            path: "/user/vouchers/:base_coupon_id",
            templateUrl: "/weixin/client_partials/coupon/vouchers/show.html",
            controller: "voucherController"
        }, {
            path: "/user/sharable_coupons",
            templateUrl: "/weixin/client_partials/coupon/sharable_coupons/index.html",
            controller: "userSharableCouponsController"
        }, {
            path: "/user/sharable_coupons/:sharable_coupon_id",
            templateUrl: "/weixin/client_partials/coupon/sharable_coupons/show.html",
            controller: "userSharableCouponController"
        }, {
            path: "/sharable_coupons/:sharable_coupon_id",
            templateUrl: "/weixin/client_partials/sharable_coupons/show.html",
            controller: "sharableCouponController"
        }], x = [{
            path: "/wechat_share_records",
            templateUrl: "/weixin/client_partials/wechat_share_records/index.html",
            controller: "wechatShareRecordsController"
        }, {
            path: "/wechat_share_records/:wechat_share_record_id",
            templateUrl: "/weixin/client_partials/wechat_share_records/show.html",
            controller: "wechatShareRecordController"
        }], S = [{
            path: "/censor-report",
            templateUrl: "/weixin/client_partials/censor_reports/new.html",
            controller: "censorReportController"
        }, {
            path: "/merchant_apply",
            templateUrl: "/weixin/client_partials/merchant_applies/show.html",
            controller: "merchantApplyController"
        }, {
            path: "/contact_us",
            templateUrl: "/weixin/client_partials/user/contact_us.html",
            controller: "userController"
        }], C = [{
            path: "/exchange_codes/:exchange_code_id",
            templateUrl: "/weixin/client_partials/exchange_codes/show.html",
            controller: "exchangeCodeController"
        }], k = [{
            path: "/recharge_products",
            templateUrl: "/weixin/client_partials/recharge_products/index.html",
            controller: "rechargeProductsController"
        }];
        return t(r), t(i), t(o), t(c), t(s), t(l), t(u), t(p), t(h), t(m), t(g), t(v), t(d), t(_), t(a), t(f), t(y), t(b), t($), t(w), t(S), t(x), t(C), t(k), {get: e}
    }
}), angular.module("diandanbao_app.directives.bg_image", []).directive("bgImage", function () {
    return {
        link: function (e, t, n) {
            var r = n.bgImage;
            r && t.css({
                background: "-moz-linear-gradient(right, rgba(255,255,255,0) 0%, rgba(255,255,255,0.99) 50%, rgba(255,255,255,1) 100%),url(" + r + ")",
                background: " -o-linear-gradient(right, rgba(255,255,255,0) 0%, rgba(255,255,255,0.99) 50%, rgba(255,255,255,1) 100%),url(" + r + ")",
                background: "-webkit-linear-gradient(right, rgba(255,255,255,0) 0%, rgba(255,255,255,0.99) 50%, rgba(255,255,255,1) 100%),url(" + r + ")",
                "background-size": "contain",
                "background-repeat": "no-repeat",
                "background-position": "right"
            })
        }
    }
}), angular.module("diandanbao_app.directives.branch_list", []).directive("branchList", ["$location", function () {
    return {
        restrict: "EA",
        scope: {branch_index_layout: "=ngBranchIndexLayout", branches: "=ngBranches"},
        replace: !0,
        templateUrl: "/weixin/client_partials/branches/list.html" + version_timestamp,
        link: function (e) {
            e.getArray = function (e) {
                for (var t = [], n = 0; n < Math.ceil(e); n++)t.push(n);
                return t
            }
        }
    }
}]), angular.module("diandanbao_app.directives.comment", []).directive("commentList", ["$location", function () {
    return {
        restrict: "EA",
        scope: {comments: "=ngComments"},
        replace: !0,
        template: '<div><div ng-repeat="comment in comments" class="comment-item"><div class="comment-info"><div class="nickname">{{comment.nickname}}</div><div class="comment-level red"><i class="fa fa-star" ng-repeat="i in getNumber(comment.rating) track by $index"></i><i class="fa fa-star-o" ng-repeat="i in getNumber(5-comment.rating) track by $index"></i></div></div><div class="time">{{comment.created_at|moment}}</div><div class="content">{{comment.content}}</div><div ng-if="comment.comments!=null"  class="comment-reply"><div  class="comment-info"><div class="nickname">{{comment.comments[0].nickname}}\u56de\u590d\uff1a</div></div><div class="time">{{comment.comments[0].created_at|moment}}</div><div class="content">{{comment.comments[0].content}}</div><div></div></div></div>',
        link: function (e) {
            e.getNumber = function (e) {
                return new Array(Math.min(e, 5))
            }
        }
    }
}]), Diandanbao.module("diandanbao_app.directives.common_footer", []).directive("commonFooter", ["$rootScope", "$location", function (e, t) {
    return {
        restrict: "EA",
        replace: !0,
        template: '<div class="ddb-nav-footer"><a class="nav-item" ng-class="{\'active\': active_home_icon()}" href="#/" ><i class="fa fa-home"></i><div class="nav-text">\u9996\u9875</div></a><a class="nav-item" ng-class="{\'active\': active_search_icon()}" href="#/search" ng-if="!current_shop.is_single"><i class="fa fa-search"></i><div class="nav-text">\u641c\u7d22</div></a><a class="nav-item" ng-class="{\'active\': active_favourite_icon()}" href="#/favorite_branches" ng-if="!current_shop.is_single"><i class="fa fa-star"></i><div class="nav-text">\u6536\u85cf</div></a><a class="nav-item" ng-class="{\'active\': active_branch_icon()}" ng-href="#/branches/{{current_shop.default_branch_id}}" ng-if="current_shop.is_single"><i class="fa fa-star"></i><div class="nav-text">\u95e8\u5e97\u4ecb\u7ecd</div></a><a class="nav-item" ng-class="{\'active\': active_user_icon()}" href="#/user/profile"><i class="fa fa-user"></i><div class="nav-text">\u6211\u7684</div></a></div>',
        link: function (e) {
            var n = t.path();
            e.active_home_icon = function () {
                return -1 != ["/"].indexOf(n) ? !0 : !1
            }, e.active_search_icon = function () {
                return "/search" === n ? !0 : !1
            }, e.active_favourite_icon = function () {
                return "/favorite_branches" === n ? !0 : !1
            }, e.active_branch_icon = function () {
                return -1 != n.indexOf("/introduction") ? !0 : !1
            }, e.active_user_icon = function () {
                return -1 != ["/user/profile", "/user/coupon_nav", "/orders/nav", "/contact_us"].indexOf(n) ? !0 : !1
            }
        }
    }
}]), Diandanbao.module("diandanbao_app.directives.common_header", []).directive("commonHeader", ["$rootScope", function () {
    return {
        restrict: "EA",
        replace: !0,
        template: '<div class="ddb-nav-header"><div class="nav-left-item" ng-click="back()"><i class="fa fa-angle-left"></i></div><div class="header-title">{{header_title}}</div></div>',
        link: function () {
        }
    }
}]), Diandanbao.module("diandanbao_app.directives.common_header_shop", []).directive("commonHeaderShop", ["$rootScope", function () {
    return {
        restrict: "EA",
        replace: !0,
        template: '<div class="ddb-nav-header label-red"><div class="location-header left overflow-ellipsis">{{city_name||\'\u5b9a\u4f4d\u4e2d\'}} <i class="fa fa-map-marker"></i></div><a class="search-input-box" href="#/search" ng-if="!current_shop.is_single"><i class="fa fa-search"></i>\u5bfb\u627e\u95e8\u5e97</a></div>',
        link: function () {
        }
    }
}]), Diandanbao.module("diandanbao_app.directives.datetimepicker", []).directive("datetimepicker", function () {
    return {
        restrict: "EA", link: function (e, t) {
            t.DateTimePicker({
                mode: "datetime",
                defaultDate: new Date,
                dateTimeFormat: "yyyy-MM-dd HH:mm:ss",
                shortDayNames: ["\u661f\u671f\u65e5", "\u661f\u671f\u4e00", "\u661f\u671f\u4e8c", "\u661f\u671f\u4e09", "\u661f\u671f\u56db", "\u661f\u671f\u4e94", "\u661f\u671f\u516d"],
                fullDayNames: ["\u661f\u671f\u65e5", "\u661f\u671f\u4e00", "\u661f\u671f\u4e8c", "\u661f\u671f\u4e09", "\u661f\u671f\u56db", "\u661f\u671f\u4e94", "\u661f\u671f\u516d"],
                shortMonthNames: ["1\u6708", "2\u6708", "3\u6708", "4\u6708", "5\u6708", "6\u6708", "7\u6708", "8\u6708", "9\u6708", "10\u6708", "11\u6708", "12\u6708"],
                fullMonthNames: ["1\u6708", "2\u6708", "3\u6708", "4\u6708", "5\u6708", "6\u6708", "7\u6708", "8\u6708", "9\u6708", "10\u6708", "11\u6708", "12\u6708"],
                titleContentDate: "\u8f93\u5165\u65e5\u671f",
                titleContentTime: "\u8f93\u5165\u65f6\u95f4",
                titleContentDateTime: "\u8f93\u5165\u65e5\u671f\u65f6\u95f4",
                setButtonContent: "\u8bbe\u7f6e",
                clearButtonContent: "\u6e05\u7a7a",
                animationDuration: "400",
                isPopup: !0,
                addEventHandlers: function () {
                }
            })
        }
    }
}).directive("datepicker", function () {
    return {
        restrict: "EA", link: function (e, t) {
            t.DateTimePicker({
                mode: "date",
                defaultDate: new Date,
                dateFormat: "yyyy-MM-dd",
                shortDayNames: ["\u661f\u671f\u65e5", "\u661f\u671f\u4e00", "\u661f\u671f\u4e8c", "\u661f\u671f\u4e09", "\u661f\u671f\u56db", "\u661f\u671f\u4e94", "\u661f\u671f\u516d"],
                fullDayNames: ["\u661f\u671f\u65e5", "\u661f\u671f\u4e00", "\u661f\u671f\u4e8c", "\u661f\u671f\u4e09", "\u661f\u671f\u56db", "\u661f\u671f\u4e94", "\u661f\u671f\u516d"],
                shortMonthNames: ["1\u6708", "2\u6708", "3\u6708", "4\u6708", "5\u6708", "6\u6708", "7\u6708", "8\u6708", "9\u6708", "10\u6708", "11\u6708", "12\u6708"],
                fullMonthNames: ["1\u6708", "2\u6708", "3\u6708", "4\u6708", "5\u6708", "6\u6708", "7\u6708", "8\u6708", "9\u6708", "10\u6708", "11\u6708", "12\u6708"],
                titleContentDate: "\u8f93\u5165\u65e5\u671f",
                titleContentTime: "\u8f93\u5165\u65f6\u95f4",
                titleContentDateTime: "\u8f93\u5165\u65e5\u671f\u65f6\u95f4",
                setButtonContent: "\u8bbe\u7f6e",
                clearButtonContent: "\u6e05\u7a7a",
                animationDuration: "400",
                isPopup: !0,
                addEventHandlers: function () {
                }
            })
        }
    }
}), angular.module("diandanbao_app.directives.cart_btn", []).directive("cartMinusBtn", [function () {
    return {
        restrict: "EA",
        replace: !0,
        template: '<span class="fa-stack"><i class="fa fa-circle-thin fa-stack-2x"></i><i class="fa fa-minus fa-stack-1x"></i></span>',
        link: function () {
        }
    }
}]).directive("cartPlusBtn", [function () {
    return {
        restrict: "EA",
        replace: !0,
        template: '<span class="fa-stack"><i class="fa fa-circle-thin fa-stack-2x"></i><i class="fa fa-plus fa-stack-1x"></i></span>',
        link: function () {
        }
    }
}]), angular.module("diandanbao_app.directives.footer_cart", []).directive("ddbFooterCart", ["$rootScope", "SnapCartService", "BaseCartService", "CartAction", function (e, t, n, r) {
    return {
        restrict: "EA",
        scope: {cart_type: "@cartType", branch_id: "@branchId", check_stock: "=checkStock", snap: "=snap"},
        replace: !0,
        templateUrl: "/weixin/client_partials/carts/ddb-footer.html" + version_timestamp,
        link: function (i) {
            function o() {
                i.snap ? t.get(i.cart_type, i.branch_id, function (t) {
                    i.cart = t, e.$broadcast("cart:snap:change", t)
                }) : n.get(i.cart_type, i.branch_id, function (t) {
                    i.cart = t, e.$broadcast("cart:change", t)
                })
            }

            i.cart = null, i.show_content = !1, i.currency = e.currency, i.$watch("branch_id", function () {
                i.branch_id && i.cart_type && (o(), r.action(i))
            }), i.toggle_content = function () {
                i.show_content = !i.show_content
            }
        }
    }
}]), Diandanbao.module("diandanbao_app.directives.ddb_order_state", []).directive("ddbOrderState", [function () {
    return {
        restrict: "EA",
        replace: !0,
        scope: {state: "@ddbState", active: "=ddbActive", hide_left: "=ddbHideLeft", hide_right: "=ddbHideRight"},
        template: '<div class="order-state" ng-class="{\'active\': active}"><div class="order-state-header"><div class="square"><div class="line-through" ng-hide="hide_left"></div></div><i class="fa fa-check-circle"></i><div class="square"><div class="line-through" ng-hide="hide_right"></div></div></div><div class="order-state-body">{{state}}</div></div>',
        link: function () {
        }
    }
}]), Diandanbao.module("diandanbao_app.directives.filterNav", []).directive("filterNavTabs", ["$rootScope", function (e) {
    return {
        templateUrl: e.directive_partial("filter-nav/filter-nav-tabs"),
        replace: !0,
        restrict: "E",
        transclude: !0,
        scope: {onPickup: "=onPickup"},
        controller: ["$element", "$scope", function (e, t) {
            var n = t.panes = [];
            this.addPane = function (e) {
                n.push(e)
            }, this.pickup = function (r) {
                t.select(), t.onPickup.apply(e, [r, $.map(n, function (e) {
                    return e.pickupFilter
                })])
            }, t.toggle = function (e) {
                0 == e.selected ? t.select(e) : (e.selected = !1, t.mask = !1)
            }, t.select = function (e) {
                $.each(n, function (e, t) {
                    t.selected = !1
                }), e ? (e.selected = !0, t.mask = !0) : t.mask = !1
            }
        }]
    }
}]).directive("filterNavPane", ["$rootScope", function (e) {
    return {
        require: "^filterNavTabs",
        templateUrl: e.directive_partial("filter-nav/filter-nav-pane"),
        replace: !0,
        restrict: "E",
        scope: {top: "=filter"},
        controller: ["$element", "$scope", function (e, t) {
            this.selectItem = function (e) {
                this.mark(e), t.sub = e, t.current = e.parent, t.parent = t.current.parent
            }, this.mark = t.mark = function (e) {
                var t = !1;
                if (e && !e.marked) {
                    e.marked = !0;
                    var n = e.collection;
                    n && n.length > 0 && (e.hasSub = !0, $.each(n, function (n, r) {
                        r.parent = e;
                        var i = r.collection;
                        i && i.length > 0 && (r.hasSub = !0, t = !0)
                    }))
                }
                return t
            }, this.pickup = function (e) {
                t.pickupFilter = e, t.tabsCtrl.pickup(e)
            }
        }],
        link: function (e, t, n, r) {
            e.tabsCtrl = r, r.addPane(e), e.multiLevel = e.mark(e.top), e.current = e.top, e.pickupFilter = e.top
        }
    }
}]).directive("filterNavSubPane", ["$rootScope", "QueryService", function (e, t) {
    return {
        require: "^filterNavPane",
        templateUrl: e.directive_partial("filter-nav/filter-nav-sub-pane"),
        replace: !0,
        restrict: "E",
        scope: {pickupFilter: "=", filter: "=filter"},
        link: function (e, n, r, i) {
            e.selectItem = function (e) {
                i.selectItem(e)
            }, e.pickup = function (e) {
                i.pickup(e)
            };
            var o = t.getCombineQuery();
            if (e.filter) {
                var a = e.filter.collection;
                a && angular.forEach(a.concat(e.filter), function (t) {
                    o[t.op] == t.value && e.pickup(t)
                })
            }
        }
    }
}]), angular.module("diandanbao_app.directives.include-replace", []).directive("includeReplace", function () {
    return {
        require: "ngInclude", restrict: "A", link: function (e, t) {
            t.replaceWith(t.children())
        }
    }
}), angular.module("diandanbao_app.directives.modal", []).directive("ngConfirmDialog", ["$compile", function () {
    return {
        restrict: "EA",
        scope: {
            show: "=ngShow",
            title: "@ngTitle",
            confirm_text: "@ngConfirmText",
            cancel_text: "@ngCancelText",
            cancel_callback: "&ngCancel",
            confirm_callback: "&ngConfirm"
        },
        transclude: !0,
        template: '<div class="ddb-box" ng-if="show"><div class="box-mask"></div><div class="ddb-alert"><div class="alert-title">{{title||"\u63d0\u793a"}}</div><div class="alert-body" ng-transclude></div><div class="alert-footer"><div class="box-button" ng-click="hideModal() ; confirm_callback()">{{confirm_text || "\u786e\u8ba4"}}</div><div class="box-button" ng-click="hideModal() ; cancel_callback()">{{cancel_text || "\u53d6\u6d88"}}</div></div></div></div>',
        link: function (e) {
            e.hideModal = function () {
                return e.show = !1, !0
            }
        }
    }
}]).directive("ngAlertDialog", function () {
    return {
        restrict: "EA",
        scope: {show: "=ngShow", title: "@ngTitle", confirm_text: "@ngClickText", confirm_callback: "&ngClick"},
        transclude: !0,
        template: '<div class="ddb-box" ng-if="show"><div class="box-mask"></div><div class="ddb-alert"><div class="alert-title">{{title||"\u63d0\u793a"}}</div><div class="alert-body" ng-transclude></div><div class="alert-footer"><div class="box-button" ng-click="hideModal() && confirm_callback()">{{confirm_text || "\u6211\u77e5\u9053\u4e86"}}</div></div></div></div>',
        link: function (e) {
            e.hideModal = function () {
                return e.show = !1, !0
            }
        }
    }
}).directive("ngTip", function () {
    return {
        restrict: "EA",
        scope: {show: "=ngShow"},
        transclude: !0,
        template: '<div class="ddb-box" ng-if="show"><div class="box-mask"></div><div class="ddb-alert"><div class="close" ng-click="hideModal()"><i class="fa fa-close"></i></div><div class="body" ng-transclude></div></div></div>',
        link: function (e) {
            e.hideModal = function () {
                return e.show = !1, !0
            }
        }
    }
}), Diandanbao.module("diandanbao_app.directives.rating_stars", []).directive("ratingStars", ["$location", function () {
    return {
        restrict: "EA",
        scope: {rating: "=ngRating"},
        replace: !0,
        template: '<div><i class="fa fa-star" ng-repeat="i in getRating(rating) track by $index"></i><i class="fa fa-star-o" ng-repeat="i in getRating(5 - rating) track by $index"></i></div>',
        link: function (e) {
            e.getRating = function (e) {
                return new Array(Math.min(e || 0, 5))
            }
        }
    }
}]), angular.module("diandanbao_app.directives.swiper_slider", []).directive("ngSwiperSlider", function () {
    return {
        restrict: "EA", scope: {sliders: "=", clickSlider: "=ngClick"}, link: function (e, t) {
            e.$watch("sliders", function (e) {
                var n = angular.element('<div class="swiper-container"></div>'), r = angular.element('<div class="swiper-wrapper"></div>');
                if (e)for (var i = 0; i < e.length; i++) {
                    var o = e[i], a = '<div class="swiper-slide">';
                    o.url && (a += '<a href="' + o.url + '">'), a += '<img src="' + o.img + '"/>', o.url && (a += "</a>"), a += "</div>";
                    var s = angular.element(a);
                    r.append(s)
                }
                n.append(r), n.append('<div class="my-pagination"></div>'), t.html(n);
                $(t).find(".swiper-container").swiper({
                    mode: "horizontal",
                    loop: !0,
                    autoplay: 3e3,
                    speed: 1e3,
                    roundLengths: !0,
                    pagination: ".my-pagination",
                    paginationClickable: !0,
                    visibilityFullFit: !0
                })
            })
        }
    }
}), angular.module("diandanbao_app.filters.filter", []).filter("unsafe", ["$sce", function (e) {
    return function (t) {
        return e.trustAsHtml(t)
    }
}]).filter("moment", ["$filter", function (e) {
    return function (t) {
        var n = new Date(Date.parse(t)), r = new Date, i = Math.floor((r.getTime() - n.getTime()) / 1e3), o = Math.floor(i / 60), a = Math.floor(o / 60), s = Math.floor(a / 24);
        return 0 == o ? "\u521a\u521a" : o >= 1 && 59 >= o ? "" + o + "\u5206\u949f\u524d" : a >= 1 && 23 >= a ? "" + a + "\u5c0f\u65f6\u524d" : s >= 1 && 7 >= s ? "" + s + "\u5929\u524d" : e("date")(n, "yyyy-MM-dd")
    }
}]).filter("distance", function () {
    return function (e) {
        return void 0 == e ? "\u8ddd\u79bb\u672a\u77e5" : e > 1e3 ? parseInt(e / 1e3) + "\u5343\u7c73" : parseInt(e) + "\u7c73"
    }
}).filter("range", function () {
    return function (e, t) {
        t = parseInt(t);
        for (var n = 0; t > n; n++)e.push(n);
        return e
    }
}), angular.module("diandanbao_app.services.article", []).factory("ArticleService", ["$rootScope", "$resource", "DiandanbaoConst", function (e, t, n) {
    function r(e, t) {
        i.get({article_id: e}, t)
    }

    var i = t(n.baseUrl + "/articles/:article_id", {format: "json"}, {
        query: {method: "GET", isArray: !0, cache: !0},
        get: {method: "GET", cache: !0}
    });
    return {get: r}
}]), Diandanbao.factory("BranchService", ["DiandanbaoConst", "$resource", "GeolocationService", function (e, t, n) {
    function r(e, t) {
        return e + "?" + $.map(t, function (e, t) {
                return "filters[" + t + "]=" + e
            }).join("&")
    }

    var i = e.baseUrl + "/branches", o = function (e, t) {
        n.distance(e, t)
    }, a = t(i + "/:id.json", {}, {
        filters: {
            method: "get",
            isArray: !0,
            cache: !0,
            url: r(i + "/filters.json", {branch_type_filter: "", zone_filter: "", branch_sort_filter: ""})
        },
        query: {method: "GET", isArray: !0, cache: !0},
        queryNews: {method: "GET", isArray: !0, cache: !1},
        get: {method: "GET", cache: !0}
    });
    return {
        query: a.query,
        queryNews: a.queryNews,
        filters: a.filters,
        delivery_filters: a.delivery_filters,
        get: a.get,
        calculate_distance_of_branch: o
    }
}]), Diandanbao.factory("BaseCartService", ["$rootScope", "$resource", "DiandanbaoConst", function (e, t, n) {
    function r(e) {
        var t;
        switch (e) {
            case"delivery":
                t = f;
                break;
            case"eat_in_hall":
                t = h;
                break;
            case"reservation":
                t = m;
                break;
            case"groupon":
                t = g;
                break;
            case"recharge":
                t = v;
                break;
            case"payment":
                t = _
        }
        return t
    }

    function i(e, t, n) {
        var i = r(e);
        i.get({branch_id: t}, n)
    }

    function o(e, t, n, i, o) {
        var a = r(e);
        a.add_itemable({branch_id: t}, {itemable_type: n, itemable_id: i}, o)
    }

    function a(e, t, n, i, o) {
        var a = r(e);
        a.remove_itemable({branch_id: t}, {itemable_type: n, itemable_id: i}, o)
    }

    function s(e, t, n) {
        var i = r(e);
        i.clear({branch_id: t}, n)
    }

    function c(e, t, n, i) {
        var o = r(e);
        o.update_cart({branch_id: t}, {cart: n}, i)
    }

    function l(e, t, n, i) {
        var o = r(e);
        o.update({branch_id: t}, {cart: n}, i)
    }

    function u(e, t, n, i) {
        var o = r(e);
        o.apply_coupon({branch_id: t}, {coupon_id: n}, i)
    }

    function d(e, t, n, i) {
        var o = r(e);
        o.add_combo_package({branch_id: t}, {combo_package: n}, i)
    }

    var p = {
        add_itemable: {method: "post", params: {action: "add_itemable"}},
        remove_itemable: {method: "post", params: {action: "remove_itemable"}},
        clear: {method: "post", params: {action: "clear"}},
        update_cart: {method: "post", params: {action: "update_cart"}},
        update: {method: "post", params: {action: "patch"}},
        apply_coupon: {method: "post", params: {action: "apply_coupon"}},
        add_combo_package: {method: "post", params: {action: "add_combo_package"}}
    }, f = t(n.baseUrl + "/branches/:branch_id/delivery_cart/:action", {format: "json"}, angular.extend({
        update_shipment: {
            method: "post",
            params: {action: "update_shipment"}
        }
    }, p)), h = t(n.baseUrl + "/branches/:branch_id/eat_in_hall_cart/:action", {format: "json"}, angular.extend({}, p)), m = t(n.baseUrl + "/branches/:branch_id/reservation_cart/:action", {format: "json"}, angular.extend({}, p)), g = t(n.baseUrl + "/branches/:branch_id/groupon_cart/:action", {format: "json"}, angular.extend({
        add_tuan: {
            method: "post",
            params: {action: "add_tuan"}
        }
    }, p)), v = t(n.baseUrl + "/branches/:branch_id/recharge_cart/:action", {format: "json"}, angular.extend({
        add_recharge_product: {
            method: "post",
            params: {action: "add_recharge_product"}
        }
    }, p)), _ = t(n.baseUrl + "/branches/:branch_id/payment_cart/:action", {format: "json"}, angular.extend({}, p));
    return {
        get_resource: r,
        get: i,
        add_itemable: o,
        remove_itemable: a,
        clear: s,
        update_cart: c,
        update: l,
        apply_coupon: u,
        add_combo_package: d
    }
}]), Diandanbao.factory("DeliveryCartService", ["BaseCartService", function (e) {
    function t(t, n) {
        e.get(c, t, n)
    }

    function n(t, n, r, i) {
        e.add_itemable(c, t, n, r, i)
    }

    function r(t, n, r, i) {
        e.remove_itemable(c, t, n, r, i)
    }

    function i(t, n) {
        e.clear(c, t, n)
    }

    function o(t, n, r) {
        e.update(c, t, n, r)
    }

    function a(t, n, r) {
        e.update_cart(c, t, n, r)
    }

    function s(t, n, r) {
        var i = e.get_resource(c);
        i.update_shipment({branch_id: t}, {shipment: n}, r)
    }

    var c = "delivery";
    return {get: t, add_itemable: n, remove_itemable: r, clear: i, update_cart: a, update: o, update_shipment: s}
}]), Diandanbao.factory("EatInHallCartService", ["BaseCartService", function (e) {
    function t(t, n) {
        e.get(s, t, n)
    }

    function n(t, n, r, i) {
        e.add_itemable(s, t, n, r, i)
    }

    function r(t, n, r, i) {
        e.add_itemable(s, t, n, r, i)
    }

    function i(t, n) {
        e.clear(s, t, n)
    }

    function o(t, n, r) {
        e.update(s, t, n, r)
    }

    function a(t, n, r) {
        e.update_cart(s, t, n, r)
    }

    var s = "eat_in_hall";
    return {get: t, add_itemable: n, remove_itemable: r, clear: i, update_cart: a, update: o}
}]), Diandanbao.factory("GrouponCartService", ["BaseCartService", function (e) {
    function t(t, n) {
        e.get(c, t, n)
    }

    function n(t, n, r, i) {
        e.add_itemable(c, t, n, r, i)
    }

    function r(t, n, r, i) {
        e.remove_itemable(c, t, n, r, i)
    }

    function i(t, n) {
        e.clear(c, t, n)
    }

    function o(t, n, r) {
        e.update(c, t, n, r)
    }

    function a(t, n, r) {
        e.update_cart(c, t, n, r)
    }

    function s(t, n, r) {
        var i = e.get_resource(c);
        i.add_tuan({branch_id: t}, {tuan_id: n}, r)
    }

    var c = "groupon";
    return {get: t, add_itemable: n, remove_itemable: r, clear: i, update_cart: a, update: o, add_tuan: s}
}]), Diandanbao.factory("RechargeCartService", ["BaseCartService", function (e) {
    function t(t, n) {
        e.get(c, t, n)
    }

    function n(t, n, r, i) {
        e.add_itemable(c, t, n, r, i)
    }

    function r(t, n, r, i) {
        e.remove_itemable(c, t, n, r, i)
    }

    function i(t, n) {
        e.clear(c, t, n)
    }

    function o(t, n, r) {
        e.update(c, t, n, r)
    }

    function a(t, n, r) {
        e.update_cart(c, t, n, r)
    }

    function s(t, n, r) {
        var i = e.get_resource(c);
        i.add_recharge_product({branch_id: t}, {recharge_product_id: n}, r)
    }

    var c = "recharge";
    return {get: t, add_itemable: n, remove_itemable: r, clear: i, update_cart: a, update: o, add_recharge_product: s}
}]), Diandanbao.factory("ReservationCartService", ["BaseCartService", function (e) {
    function t(t, n) {
        e.get(s, t, n)
    }

    function n(t, n, r, i) {
        e.add_itemable(s, t, n, r, i)
    }

    function r(t, n, r, i) {
        e.add_itemable(s, t, n, r, i)
    }

    function i(t, n) {
        e.clear(s, t, n)
    }

    function o(t, n, r) {
        e.update(s, t, n, r)
    }

    function a(t, n, r) {
        e.update_cart(s, t, n, r)
    }

    var s = "reservation";
    return {get: t, add_itemable: n, remove_itemable: r, clear: i, update_cart: a, update: o}
}]), Diandanbao.factory("SnapCartService", ["BaseCartService", function (e) {
    function t(e) {
        var t;
        switch (e) {
            case"delivery":
                t = d.delivery;
                break;
            case"reservation":
                t = d.reservation;
                break;
            case"eat_in_hall":
                t = d.eat_in_hall;
                break;
            case"groupon":
                t = d.groupon;
                break;
            case"recharge":
                t = d.recharge;
                break;
            case"payment":
                t = d.payment
        }
        return t
    }

    function n(e, n, r) {
        t(e)[n] = r
    }

    function r(r, i, o) {
        var a = t(r)[i];
        a ? o && o(a) : e.get(r, i, function (e) {
            a = e, l(a), n(r, i, a), o && o(a)
        })
    }

    function i(e, t, n, i) {
        r(e, t, function (e) {
            var t = !0;
            if (angular.forEach(e.line_items, function (e) {
                    t && e.itemable_type == n.itemable_type && e.itemable_id == n.itemable_id && (e.quantity++, t = !1)
                }), t) {
                var r = {
                    itemable_type: n.itemable_type,
                    itemable_id: n.itemable_id,
                    stock_quantity: n.stock_quantity,
                    quantity: 1,
                    price: n.price,
                    name: n.name,
                    category_ids: n.category_ids
                };
                n.original_price && (r.original_price = n.original_price), e.line_items.push(r)
            }
            l(e), i && i(e)
        })
    }

    function o(e, t, n, i) {
        r(e, t, function (e) {
            var t = !0;
            angular.forEach(e.line_items, function (e) {
                t && e.itemable_type == n.itemable_type && e.itemable_id == n.itemable_id && (e.quantity > 0 && e.quantity--, t = !1)
            }), l(e), i && i(e)
        })
    }

    function a(e, t, n) {
        r(e, t, function (e) {
            angular.forEach(e.line_items, function (e) {
                e.quantity = 0
            }), l(e), n && n(e)
        })
    }

    function s(t, i, o) {
        r(t, i, function (r) {
            e.update_cart(t, i, {line_items_attributes: c(r)}, function (e) {
                n(t, i, e), o && o(e)
            })
        })
    }

    function c(e) {
        var t = {}, n = 1;
        return angular.forEach(e.line_items, function (e) {
            var r = {id: e.id, itemable_type: e.itemable_type, itemable_id: e.itemable_id, quantity: e.quantity};
            t[n] = r, n++
        }), t
    }

    function l(e) {
        var t = 0, n = 0, r = 0;
        return angular.forEach(e.line_items, function (e) {
            t += e.quantity * parseFloat(e.price), n += e.quantity * parseFloat(e.original_price), r += e.quantity
        }), e.total = t, e.item_total = n, e.item_count = r, t
    }

    function u(e, n) {
        t(e)[n] = null
    }

    var d = {};
    return d.delivery = [], d.reservation = [], d.eat_in_hall = [], d.groupon = [], d.recharge = [], d.payment = [], {
        get: r,
        set_cart: n,
        add_itemable: i,
        remove_itemable: o,
        clear: a,
        destroy: u,
        update_cart: s
    }
}]), Diandanbao.factory("CategoryCache", ["$cacheFactory", function (e) {
    return e("category-cache")
}]), angular.module("diandanbao_app.services.category", []).factory("CategoryService", ["$rootScope", "$resource", "DiandanbaoConst", function (e, t, n) {
    function r(e, t, n) {
        i.query({branch_id: e, support_type: t}, n)
    }

    var i = t(n.baseUrl + "/branches/:branch_id/categories/:id/:action", {format: "json"}, {
        query: {
            method: "GET",
            isArray: !0,
            cache: !0
        }
    });
    return {query: r}
}]), Diandanbao.factory("CensorReportService", ["$resource", "$location", "DiandanbaoConst", function (e, t, n) {
    var r = e(n.baseUrl + "/censor_reports", {format: "json"}, {});
    return {
        report: function (e, t, n) {
            r.save({}, {censor_report: {title: e, desc: t}}, n)
        }
    }
}]), angular.module("diandanbao_app.services.combo_package", []).factory("ComboPackageService", ["$resource", "DiandanbaoConst", function (e, t) {
    function n(e, t, n) {
        r.create({branch_id: e}, {combo_package: combo_packgae_params}, n)
    }

    var r = e(t.baseUrl + "/branches/:branch_id/combo_packages/:id/:action", {format: "json"});
    return {create: n}
}]), angular.module("diandanbao_app.services.combo", []).factory("ComboService", ["$resource", "DiandanbaoConst", function (e, t) {
    function n(e, t, n) {
        r.query({branch_id: e, order_type: t}, n)
    }

    var r = e(t.baseUrl + "/branches/:branch_id/combos/:id/:action", {format: "json"}, {
        query: {
            method: "GET",
            isArray: !0,
            cache: !0
        }, get: {method: "GET", cache: !0}
    });
    return {query: n}
}]), angular.module("diandanbao_app.services.comment", []).factory("CommentService", ["$resource", "DiandanbaoConst", function (e, t) {
    function n(e, t) {
        r.query({branch_id: e}, t)
    }

    var r = e(t.baseUrl + "/branches/:branch_id/comments/:action", {format: "json"}, {
        query: {
            method: "GET",
            isArray: !0,
            cache: !0
        }, get: {method: "GET", cache: !0}
    });
    return {query: n}
}]), angular.module("diandanbao_app.services.cart_action", []).factory("CartAction", ["$rootScope", "$routeParams", "SnapCartService", "BaseCartService", "BranchService", function (e, t, n, r, i) {
    function o(o) {
        o.branch_id = o.branch_id || t.branch_id, o.cart_type = o.cart_type || o.order_type || "delivery", i.get({id: o.branch_id}, function (e) {
            o.branch = e
        }), o.add_itemable = function (t, i) {
            if (o.need_check_stock(t)) {
                var a = !1;
                if ("undefined" == typeof t.quantity && t.stock_quantity - 1 < 0 && (a = !0), t.stock_quantity - t.quantity <= 0 && (a = !0), a)return void o.$emit("events:receive_errors", "\u5e93\u5b58\u4e0d\u591f\u5566")
            }
            i = "undefined" != typeof i ? i : !0, i ? n.add_itemable(o.cart_type, o.branch_id, t, function (t) {
                e.$broadcast("cart:snap:change", t)
            }) : r.add_itemable(o.cart_type, o.branch_id, t.itemable_type, t.itemable_id, function (t) {
                n.set_cart(o.cart_type, o.branch_id, t), e.$broadcast("cart:change", t)
            })
        }, o.remove_itemable = function (t, i) {
            i = "undefined" != typeof i ? i : !0, i ? n.remove_itemable(o.cart_type, o.branch_id, t, function (t) {
                e.$broadcast("cart:snap:change", t)
            }) : r.remove_itemable(o.cart_type, o.branch_id, t.itemable_type, t.itemable_id, function (t) {
                n.set_cart(o.cart_type, o.branch_id, t), e.$broadcast("cart:change", t)
            })
        }, o.stock_of = function (e) {
            return void 0 == e.quantity ? e.stock_quantity : e.stock_quantity - e.quantity
        }, o.can_minus = function (e) {
            return e.quantity > 0
        }, o.can_plus = function (e) {
            return o.need_check_stock(e) ? o.stock_of(e) > 0 ? !0 : !1 : !0
        }, o.need_check_stock = function (e) {
            return (o.check_stock || o.branch && o.branch.check_stock) && "Diandanbao::Variant" == e.itemable_type
        }
    }

    return {action: o}
}]), Diandanbao.factory("ExchangeCodeService", ["$rootScope", "$resource", "DiandanbaoConst", function (e, t, n) {
    function r(e, t) {
        s.get({id: e}, t)
    }

    function i(e, t) {
        s.get_permissions({id: e}, t)
    }

    function o(e, t) {
        s.get_qrcode({id: e}, t)
    }

    function a(e, t) {
        s.exchange({id: e}, {}, t)
    }

    var s = t(n.baseUrl + "/exchange_codes/:id/:action", {format: "json"}, {
        get_permissions: {
            method: "get",
            params: {action: "get_permissions"}
        },
        get_qrcode: {method: "get", params: {action: "get_qrcode"}},
        exchange: {method: "post", params: {action: "exchange"}}
    });
    return {get: r, get_permissions: i, get_qrcode: o, exchange: a}
}]), Diandanbao.factory("GeolocationService", ["$rootScope", "$interval", "$resource", "$http", "DiandanbaoConst", "ShopService", function (e, t, n, r, i, o) {
    var a, s = !1, c = !0, l = function (e, t) {
        s && (e = "[GeolocationService] " + e, "undefined" != typeof t ? (console.info(e, t), c && alert(e + JSON.stringify(t))) : (console.info(e), c && alert(e)))
    }, u = [], d = null, p = "unknown", f = {
        isInitialized: function () {
            return !1
        }, initDaemon: null, daemonInterval: 500, supportAddress: !1, name: null, initCurrentPosition: function () {
            var e = this;
            WeixinApi.openInWeixin() ? (l("initCurrentPosition by Weixin"), wx.ready(function () {
                wx.getLocation({
                    success: function (t) {
                        l("getLocation", t);
                        {
                            var n = t.latitude, r = t.longitude;
                            t.speed, t.accuracy
                        }
                        a = {
                            gps: {lng: r, lat: n},
                            point: {lng: r, lat: n}
                        }, e.afterInitCurrentPosition ? e.afterInitCurrentPosition(a) : e.applyCallbacks(!0)
                    }, fail: function () {
                        l("fallback to use tencent map"), e.fetchCurrentLocationByTMap()
                    }, complete: function (e) {
                        l("getLocation complete", e)
                    }, cancel: function (e) {
                        l("getLocation cancel", e)
                    }
                })
            })) : e.fetchCurrentLocationByTMap()
        }, fetchCurrentLocationByTMap: function () {
            var e = this;
            l("initCurrentPosition by tencent map"), "undefined" == typeof qq || "undefined" == typeof qq.maps ? (window._ng_callback_geolocation_service = function () {
                e.getCurrentLocationByTMap(), delete window._ng_callback_geolocation_service
            }, $.getScript("http://map.qq.com/api/js?v=2.exp&libraries=convertor&callback=_ng_callback_geolocation_service")) : this.getCurrentLocationByTMap()
        }, getCurrentLocationByTMap: function () {
            var e = this;
            new qq.maps.CityService({
                complete: function (t) {
                    l("initCurrentPosition", t);
                    var n = t.detail.latLng;
                    a = {
                        point: {
                            lng: n.getLng(),
                            lat: n.getLat()
                        }
                    }, e.afterInitCurrentPosition ? e.afterInitCurrentPosition(a) : e.applyCallbacks(!0)
                }
            }).searchLocalCity()
        }, applyCallbacks: function (t) {
            for (l("apply callbacks: length=", u.length); u.length > 0;) {
                var n = u.shift();
                if (t)e.$apply(function () {
                    try {
                        n(a)
                    } catch (e) {
                        l("execute callback error: " + n.toString())
                    }
                }); else try {
                    n(a)
                } catch (r) {
                    l("execute callback error: " + n.toString())
                }
            }
        }, initCurrentPositionRoutine: function () {
            l("initCurrentPositionRoutine start, name=" + this.name);
            var e = this;
            e.isInitialized() ? this.initCurrentPosition() : e.initDaemon = t(function () {
                e.isInitialized() && (l("initCurrentPosition clear daemon"), t.cancel(e.initDaemon), e.initCurrentPosition())
            }, e.daemonInterval)
        }
    }, h = angular.extend(angular.extend({}, f), {
        name: "\u817e\u8baf\u5730\u56fe",
        supportAddress: !0,
        isInitialized: function () {
            return "undefined" != typeof qq && "undefined" != typeof qq.maps
        },
        afterInitCurrentPosition: function (e) {
            var t = this;
            if (l("convert gps location start", e), e.gps) {
                var n = new qq.maps.LatLng(e.gps.lat, e.gps.lng);
                qq.maps.convertor.translate(n, 1, function (n) {
                    l("convert to tencent coords success", n), e.point.lat = n[0].lat, e.point.lng = n[0].lng, t.geocode(e)
                })
            } else t.geocode(e)
        },
        geocode: function (e) {
            l("getGeocoding start", e);
            var t = this, n = new qq.maps.Geocoder, r = e.point, i = new qq.maps.LatLng(r.lat, r.lng);
            n.setComplete(function (n) {
                l("getGeocoding returns", n);
                var r = n.detail.addressComponents;
                e.address = {
                    formatted_address: n.detail.address,
                    country: r.country,
                    province: r.province,
                    city: r.city,
                    district: r.district,
                    street: r.street,
                    street_number: r.streetNumber
                }, t.applyCallbacks(!0)
            }), n.setError(function () {
                t.supportAddress = !1, t.applyCallbacks(!0)
            }), n.getAddress(i)
        }
    }), m = angular.extend(angular.extend({}, f), {
        name: "\u8c37\u6b4c\u5730\u56fe",
        supportAddress: !0,
        geocodingRequestUrl: "http://maps.googleapis.com/maps/api/geocode/json?sensor=true&&latlng=",
        geocoder: null,
        isInitialized: function () {
            return "undefined" != typeof google && "undefined" != typeof google.maps
        },
        getGeocoding: function (e, t, n) {
            l("getGeocoding start", e), null == this.geocoder && (this.geocoder = new google.maps.Geocoder);
            var r = new google.maps.LatLng(e.lat, e.lng);
            this.geocoder.geocode({latLng: r}, function (e, r) {
                if (r == google.maps.GeocoderStatus.OK)if (l("getGeocoding returns", e), e[0]) {
                    var i = e[0], o = !1;
                    if (angular.forEach("street_address route locality political".split(" "), function (e) {
                            i.types.indexOf(e) >= 0 && (o = !0)
                        }), o) {
                        var a = {formatted_address: i.formatted_address};
                        if (angular.forEach(i.address_components, function (e) {
                                var t = e.types;
                                t instanceof Array || (t = [t]), t.indexOf("country") >= 0 ? a.country = e.long_name : t.indexOf("administrative_area_level_1") >= 0 ? a.province = e.long_name : t.indexOf("administrative_area_level_2") >= 0 || t.indexOf("administrative_area_level_3") >= 0 || (t.indexOf("locality") >= 0 ? a.city = e.long_name : t.indexOf("sublocality_level_1") >= 0 ? a.district = e.long_name : t.indexOf("route") >= 0 ? a.street = e.long_name : t.indexOf("street_number") >= 0 && (a.street_number = e.long_name))
                            }), a.street_number && (a.formatted_address = a.formatted_address.replace(a.street_number, "")), l("getGeocoding build address:", a), t)return void t(a)
                    } else alert("getGeocoding invalid result type"), l("getGeocoding invalid result type")
                } else alert("getGeocoding no results"), l("getGeocoding no results"); else alert("getGeocoding falied" + r), l("getGeocoding falied", r);
                n && n()
            })
        },
        afterInitCurrentPosition: function (e) {
            var t = this;
            this.getGeocoding(e.point, function (n) {
                e.address = n, t.applyCallbacks()
            }, function () {
                alert("\u67e5\u8be2\u8c37\u6b4c\u5730\u56fe\u4fe1\u606f\u5931\u8d25"), t.supportAddress = !1, t.applyCallbacks()
            })
        }
    });
    o.get(function (e) {
        s = e.debug, d = e.enable_foreign ? m : h, d.initCurrentPositionRoutine()
    });
    var g = function (e) {
        //var t, r = e.point.lat, o = e.point.lng;
        //t = d.supportAddress ? e.address.formatted_address : p;
        //var a = n(i.baseUrl + "/user/:action", {format: "json"}, {
        //    update_location: {
        //        method: "POST",
        //        params: {action: "update_location"}
        //    }
        //});
        //a.update_location({}, {user: {latitude: r, longitude: o, city_name: t}}, function () {
        //})
    };
    u.push(g);
    var v = function (e, t) {
        if ("undefined" != typeof a) {
            var n = geolib.getDistance({latitude: a.point.lat, longitude: a.point.lng}, {
                latitude: e.latitude,
                longitude: e.longitude
            });
            return t(n), n
        }
        return !1
    }, _ = function (e) {
        if ("undefined" != typeof a && d.supportAddress) {
            var t = "\u5b9a\u4f4d\u4e2d";
            return angular.forEach("country province city district".split(" "), function (e) {
                a.address && a.address[e] && (t = a.address[e])
            }), e(t), t
        }
        return !1
    }, y = function (e) {
        if ("undefined" != typeof a) {
            var t = {lat: a.point.lat, lng: a.point.lng, city: d.supportAddress ? a.address.city : p};
            return e(t), t
        }
        return !1
    }, b = function (e, t) {
        0 == v(e, t) && u.push(function () {
            v(e, t)
        })
    }, w = function (e) {
        0 == _(e) && u.push(function () {
            _(e)
        })
    }, x = function (e) {
        0 == y(e) && u.push(function () {
            y(e)
        })
    }, S = function (e) {
        null == a ? u.push(e) : e(a)
    }, C = function (e, t, n) {
        geocoder = new google.maps.Geocoder, geocoder.geocode({address: e}, function (e, r) {
            if (r == google.maps.GeocoderStatus.OK) {
                var i = e[0].geometry.location;
                t(i)
            } else n(r)
        })
    };
    return {distance: b, get_city_name: w, get_location_address: x, get_current_position: S, code_address: C}
}]), angular.module("diandanbao_app.services.guest_queue", []).factory("GuestQueueService", ["$http", "$rootScope", "$resource", "DiandanbaoConst", function (e, t, n, r) {
    function i(e, t) {
        l.get({branch_id: e}, t)
    }

    function o(e, t, n) {
        l.save({branch_id: e}, {guest_queue: t}, n)
    }

    function a(e, t) {
        l.cancel({branch_id: e}, {}, t)
    }

    function s(e, t, n) {
        l.get_by_qr_code({branch_id: e, qr_code_id: t}, n)
    }

    function c(e, t, n) {
        l.bind_user({branch_id: e}, {guest_queue_id: t}, n)
    }

    var l = n(r.baseUrl + "/branches/:branch_id/guest_queue/:action", {format: "json"}, {
        cancel: {
            method: "post",
            params: {action: "cancel"}
        },
        bind_user: {method: "post", params: {action: "bind_user"}},
        get_by_qr_code: {method: "get", params: {action: "get_by_qr_code"}}
    });
    return {get: i, bind_user: c, get_by_qr_code: s, create: o, cancel: a}
}]), Diandanbao.factory("HistoryUrlService", ["$location", function (e) {
    function t(e, t) {
        if (t = "undefined" != typeof t ? t : !0, d = t, e && e.match("^#/"))r(e.slice(1)); else if (e && e.match("^/"))r(e); else {
            var n = "http://", i = /^http|^https/;
            e = e.match(i) ? e : n + e, window.location.href = e
        }
    }

    function n() {
        1 == u.length && u.push(l), back_url = a(), r(back_url.url)
    }

    function r(t) {
        e.url(t)
    }

    function i() {
        current_url = e.url(), current_path = e.path(), current_search = e.search(), current_hash = e.hash(), s(current_url) ? u.pop() : u[u.length - 1].url !== current_url && (d && !o(current_path) ? u.push({
            url: current_url,
            path: current_path,
            search: current_search,
            hash: current_hash
        }) : d = !0)
    }

    function o(e) {
        var t = ["tables", "/edit", "/addresses/new", "/comment/new", "/new_guest", "/pay_online", "/user/apply-vip", "/user/update-pay-password", "/groupon/new", "/guest_queue_qr_code"], n = !1;
        return angular.forEach(t, function (t) {
            !n && e.match(t) && (n = !0)
        }), n
    }

    function a() {
        return e.url() == u[u.length - 1].url ? u[u.length - 2] : u[u.length - 1]
    }

    function s(e) {
        return u.length >= 2 && u[u.length - 2].url === e
    }

    function c() {
        u = [l]
    }

    var l = {url: "/", path: "/", search: {}, hash: ""}, u = [l], d = !0;
    return {go: t, back: n, is_back_url: s, push_current_url: i, clear_history_url: c}
}]), angular.module("diandanbao_app.services.invoice", []).factory("InvoiceService", ["$resource", "DiandanbaoConst", function (e, t) {
    function n(e, t, n, i) {
        r.create({branch_id: e, order_id: t}, {invoice: n}, i)
    }

    var r = e(t.baseUrl + "/branches/:branch_id/invoices", {format: "json"}, {create: {method: "POST"}});
    return {create: n}
}]), Diandanbao.factory("LoadMoreServiceFactory", [function () {
    var e = function (e) {
        var t, n, r, i, o;
        this.handler = e;
        var a = this;
        this.reload = function () {
            t = [], n = Date.now(), r = 1, i = !1, o = !1, a.update()
        }, this.update = function () {
            var e = this.handler;
            e.update && e.update(t)
        }, this.reload(), this.loadMore = function () {
            var e = this.handler;
            o ? e.onLockMore && e.onLockMore() : !i && e.onLoadMore && (o = !0, e.onLoadMore(r, e.per_page || 10, n, function (n) {
                o = !1, n.length > 0 ? (t = t.concat(n), r += 1, a.update()) : (i = !0, e.onNoMore && e.onNoMore())
            }))
        }, this.isLoading = function () {
            return o
        }
    }, t = {};
    return {
        createLoadMoreService: function (n) {
            var r;
            return n.id ? t[n.id] ? (r = t[n.id], r.handler = n, r.update()) : (r = new e(n), t[n.id] = r, r.loadMore()) : (serivce = new e(n), serivce.loadMore()), r
        }
    }
}]), Diandanbao.factory("LocationService", ["$rootScope", "$interval", "$resource", "$http", "DiandanbaoConst", "ShopService", "GeolocationService", function (e, t, n, r, i, o, a) {
    var s = 31.2235019388734, c = 121.47994995117188, l = null, u = null, d = "cursor:pointer;border:1px solid rgba(255,255,0.5);border-right: 1px solid #aaa;border-bottom: 1px solid #aaa;text-align:center;", p = document.createElement("div");
    p.appendChild(document.createTextNode("\u4f7f\u7528\u6b64\u4f4d\u7f6e")), p.style.cssText = d + "font-size:16px;font-weight:bold;line-height:40px;color:red;margin-right:12px;margin-bottom:30px;padding-left:8px;padding-right:8px;background-color:white;";
    var f = document.createElement("div");
    f.innerHTML = "<i class='fa fa-crosshairs'></i>", f.style.cssText = d + "width:40px;height:40px;line-height:40px;font-size:16px;margin-left:12px;margin-top: 10px;background-color: white; font-size:20px;";
    var h = function (e) {
        a.get_current_position(function (t) {
            e(t.point)
        })
    }, m = function () {
        null == l && o.get(function (e) {
            l = e.enable_foreign ? b : y
        })
    }, g = function (e, t, n, r) {
        u = !1, (null == t || null == n) && (u = !0);
        var t = t || c, n = n || s;
        l.show_picker(e, t, n, r)
    }, v = function (e, t, n, r) {
        var i = new qq.maps.LatLng(n, t), o = "", a = null, s = new qq.maps.Map(document.getElementById(e), {disableDoubleClickZoom: !0}), c = function () {
            h(function (e) {
                i = new qq.maps.LatLng(e.lat, e.lng), d(i)
            })
        }, l = new qq.maps.Geocoder({
            complete: function (e) {
                o = e.detail.address
            }
        });
        f.onclick = c;
        new qq.maps.Control({content: f, map: s, align: qq.maps.ALIGN.TOP_LEFT});
        p.onclick = function () {
            r(i, o)
        };
        {
            var d = (new qq.maps.Control({content: p, map: s, align: qq.maps.ALIGN.BOTTOM_RIGHT}), function (e) {
                null == a ? a = new qq.maps.Marker({
                    position: e,
                    map: s
                }) : a.setPosition(e), s.panTo(e), l.getAddress(e)
            }), m = function (e) {
                i = new qq.maps.LatLng(e.latLng.lat, e.latLng.lng), d(i)
            };
            qq.maps.event.addListener(s, "click", m)
        }
        s.panTo(i), s.zoomTo(this.zoom_level), d(i), u && c()
    }, _ = function (e, t, n, r) {
        var i = new google.maps.LatLng(n, t), o = "", a = null, s = {
            zoom: this.zoom_level,
            center: i
        }, c = new google.maps.Map(document.getElementById(e), s), l = function () {
            h(function (e) {
                i = new google.maps.LatLng(e.lat, e.lng), d(i), c.setCenter(i)
            })
        }, d = function (e) {
            null == a ? a = new google.maps.Marker({position: e, map: c}) : a.setPosition(e)
        };
        c.addListener("click", function (e) {
            i = new google.maps.LatLng(e.latLng.lat(), e.latLng.lng()), d(i), c.setCenter(i)
        }), p.index = 1, p.onclick = function () {
            var e = {lat: i.lat(), lng: i.lng()};
            r(e, o)
        }, c.controls[google.maps.ControlPosition.RIGHT_BOTTOM].push(p), f.index = 1, f.onclick = l, c.controls[google.maps.ControlPosition.LEFT_TOP].push(f), d(i), u && l()
    }, y = {zoom_level: 13, show_picker: v}, b = {zoom_level: 15, show_picker: _};
    return m(), {show_picker: g}
}]), Diandanbao.factory("MerchantApplyService", ["$resource", "$location", "DiandanbaoConst", function (e, t, n) {
    var r = e(n.baseUrl + "/user/merchant_apply/:action", {format: "json"}, {
        cancel: {
            method: "post",
            params: {action: "cancel"}
        }
    });
    return {get: r.get, save: r.save, cancel: r.cancel}
}]), Diandanbao.factory("BaseOrderService", ["$rootScope", "$resource", "DiandanbaoConst", "SnapCartService", "UserService", function (e, t, n, r, i) {
    function o(e) {
        var t;
        switch (e) {
            case"delivery":
                t = u;
                break;
            case"eat_in_hall":
                t = d;
                break;
            case"reservation":
                t = p;
                break;
            case"groupon":
                t = f;
                break;
            case"recharge":
                t = h;
                break;
            case"payment":
                t = m
        }
        return t
    }

    function a() {
        i.refresh()
    }

    function s(e, t, n, i) {
        var s = o(e);
        s.save({branch_id: t}, {order: n}, function (n) {
            r.destroy(e, t), i && i(n), a()
        })
    }

    function c(e, t, n, r, i) {
        var a = o(e);
        a.append_itemables({branch_id: t, id: n}, {itemables: r}, i)
    }

    var l = {
        get_pay_online: {method: "get", params: {action: "get_pay_online"}},
        cancel: {method: "post", params: {action: "cancel"}},
        confirm: {method: "post", params: {action: "confirm"}},
        complete: {method: "post", params: {action: "complete"}},
        append_itemables: {method: "post", params: {action: "append_itemables"}},
        association_domains: {method: "get", params: {action: "association_domains"}},
        get_permissions: {method: "get", params: {action: "get_permissions"}}
    }, u = t(n.baseUrl + "/branches/:branch_id/delivery_orders/:id/:action", {format: "json"}, angular.extend({
        delivery_zones: {
            method: "get",
            params: {action: "delivery_zones"},
            isArray: !0
        },
        delivery_times: {method: "get", params: {action: "delivery_times"}, isArray: !0},
        delivery_dates: {method: "get", params: {action: "delivery_dates"}, isArray: !0},
        hasten: {method: "post", params: {action: "hasten"}},
        refresh_location: {method: "get", params: {action: "refresh_location"}}
    }, l)), d = t(n.baseUrl + "/branches/:branch_id/eat_in_hall_orders/:id/:action", {format: "json"}, angular.extend({
        get_order_by_table: {
            method: "get",
            params: {action: "get_order_by_table"}
        },
        hasten: {method: "post", params: {action: "hasten"}},
        call_waiter: {method: "post", params: {action: "call_waiter"}}
    }, l)), p = t(n.baseUrl + "/branches/:branch_id/reservation_orders/:id/:action", {format: "json"}, angular.extend({}, l)), f = t(n.baseUrl + "/branches/:branch_id/groupon_orders/:id/:action", {format: "json"}, angular.extend({}, l)), h = t(n.baseUrl + "/branches/:branch_id/recharge_orders/:id/:action", {format: "json"}, angular.extend({}, l)), m = t(n.baseUrl + "/branches/:branch_id/payment_orders/:id/:action", {format: "json"}, angular.extend({}, l)), g = {};
    return angular.forEach(["get", "get_pay_online", "cancel", "confirm", "complete", "get_permissions"], function (e) {
        g[e] = function (t, n, r, i) {
            var a = o(t);
            a[e]({branch_id: n, id: r}, {}, i)
        }
    }), angular.forEach(["association_domains"], function (e) {
        g[e] = function (t, n, r) {
            var i = o(t);
            i[e]({branch_id: n}, {}, r)
        }
    }), angular.extend(g, {create: s, append_itemables: c, get_resource: o})
}]), Diandanbao.factory("DeliveryOrderService", ["BaseOrderService", function (e) {
    function t(t, n) {
        var r = e.get_resource(a);
        r.delivery_zones({branch_id: t}, n)
    }

    function n(t, n, r) {
        var i = e.get_resource(a);
        i.delivery_times({branch_id: t, delivery_date: n}, r)
    }

    function r(t, n) {
        var r = e.get_resource(a);
        r.delivery_dates({branch_id: t}, n)
    }

    function i(t, n, r) {
        var i = e.get_resource(a);
        i.hasten({branch_id: t, id: n}, {}, r)
    }

    function o(t, n, r) {
        var i = e.get_resource(a);
        i.refresh_location({branch_id: t, id: n}, r)
    }

    var a = "delivery", s = {};
    return s.create = function (t, n, r) {
        e.create(a, t, n, r)
    }, angular.extend(s, {delivery_zones: t, delivery_times: n, delivery_dates: r, refresh_location: o, hasten: i})
}]), Diandanbao.factory("EatInHallOrderService", ["BaseOrderService", function (e) {
    function t(t, n, r) {
        e.create(o, t, n, r)
    }

    function n(t, n, r) {
        var i = e.get_resource(o);
        i.get_order_by_table({branch_id: t, table_id: n}, r)
    }

    function r(t, n, r) {
        var i = e.get_resource(o);
        i.hasten({branch_id: t, id: n}, {}, r)
    }

    function i(t, n, r, i) {
        var a = e.get_resource(o);
        a.call_waiter({branch_id: t, id: n, service_name: r}, {}, i)
    }

    var o = "eat_in_hall";
    return {create: t, get_order_by_table: n, hasten: r, call_waiter: i}
}]), Diandanbao.factory("GrouponOrderService", ["BaseOrderService", function (e) {
    function t(t, r, i) {
        e.create(n, t, r, i)
    }

    var n = "groupon";
    return {create: t}
}]), Diandanbao.factory("InvitationOrderService", ["$resource", "DiandanbaoConst", function (e, t) {
    var n = e(t.baseUrl + "/branches/:branch_id/invitation_orders/:id/:action", {format: "json"}, {
        agree: {
            method: "post",
            params: {action: "agree"}
        }, disagree: {method: "post", params: {action: "disagree"}}
    }), r = {};
    return angular.forEach("get agree disagree".split(" "), function (e) {
        r[e] = function () {
            n[e].apply(n, arguments)
        }
    }), r
}]), Diandanbao.factory("OrderCommentService", ["$resource", "DiandanbaoConst", function (e, t) {
    function n(e, t, n, i) {
        r.save({branch_id: e, order_id: t}, {order_comment: n}, i)
    }

    var r = e(t.baseUrl + "/branches/:branch_id/orders/:order_id/order_comment/:action", {format: "json"}, {});
    return {create: n}
}]), Diandanbao.factory("PaymentOrderService", ["BaseOrderService", function (e) {
    function t(t, r, i) {
        e.create(n, t, r, i)
    }

    var n = "payment";
    return {create: t}
}]), Diandanbao.factory("RechargeOrderService", ["BaseOrderService", function (e) {
    function t(t, r, i) {
        e.create(n, t, r, i)
    }

    var n = "recharge";
    return {create: t}
}]), Diandanbao.factory("ReservationOrderService", ["BaseOrderService", function (e) {
    function t(t, r, i) {
        e.create(n, t, r, i)
    }

    var n = "reservation";
    return {create: t}
}]), angular.module("diandanbao_app.services.product", []).factory("ProductService", ["$rootScope", "$resource", "DiandanbaoConst", function (e, t, n) {
    function r(e, t) {
        o.query(e, function (e) {
            angular.forEach(e, function (e) {
                for (var t = e.variants.length, n = 0; t > n; n++)e.variants[n].price = e.variant_prices[n]
            }), t && t(e)
        })
    }

    function i(e, t, n) {
        o.get({branch_id: e, id: t}, n)
    }

    var o = t(n.baseUrl + "/branches/:branch_id/products/:id/:action", {format: "json"}, {
        query: {
            method: "GET",
            isArray: !0,
            cache: !0
        }, get: {method: "GET", cache: !0}
    });
    return {query: r, get: i}
}]), angular.module("diandanbao_app.services.promotion", []).factory("PromotionService", ["$rootScope", "$resource", "DiandanbaoConst", function (e, t, n) {
    function r(e) {
        a.query({}, e)
    }

    function i(t) {
        t(e.current_shop.promotions_show_on_index)
    }

    function o(e, t) {
        a.get({id: e}, t)
    }

    var a = t(n.baseUrl + "/promotions/:id/:action", {format: "json"}, {
        query: {
            method: "GET",
            isArray: !0,
            cache: !0
        }
    });
    return {query: r, show_on_index: i, get: o}
}]), Diandanbao.factory("QueryService", ["$location", function (e) {
    function t(e, t) {
        return UrlParser.each_parameter(function (t, r) {
            var i = t.indexOf(n);
            if (0 == i) {
                var o = t.substring("_ng_".length);
                e[o] = r
            }
        }, t), e
    }

    var n = "_ng_query", r = {};
    return t(r), {
        getQuery: function () {
            return angular.extend({}, r)
        }, getNgQuery: function () {
            return t({}, e.url())
        }, getCombineQuery: function () {
            return angular.extend(this.getQuery(), this.getNgQuery())
        }, buildQueryString: function (e) {
            return $.map(e, function (e, t) {
                return "_ng_" + encodeURIComponent(t) + "=" + encodeURIComponent(e)
            }).join("&")
        }
    }
}]), Diandanbao.factory("RechargeProductService", ["DiandanbaoConst", "$resource", function (e, t) {
    var n = t(e.baseUrl + "/recharge_products/:action", {format: "json"}, {
        query: {
            method: "GET",
            isArray: !0,
            cache: !0
        }
    });
    return {
        query: function (e) {
            n.query({}, e)
        }
    }
}]), Diandanbao.factory("ReservationDateService", [function () {
    function e(e) {
        for (var r = [], i = 0; e > i; i++) {
            var o = new Date;
            o.setDate(o.getDate() + i);
            var a = {position: i, value: o};
            a.first_label = 0 === i ? "\u4eca\u5929" : 1 === i ? "\u660e\u5929" : 2 === i ? "\u540e\u5929" : n(o, "MM-dd"), a.second_label = 2 >= i ? n(o, "MM-dd") + t(o) : t(o), r.push(a)
        }
        return r
    }

    function t(e) {
        var t = ["\u5468\u65e5", "\u5468\u4e00", "\u5468\u4e8c", "\u5468\u4e09", "\u5468\u56db", "\u5468\u4e94", "\u5468\u516d"];
        return t[e.getDay()]
    }

    function n(e, t) {
        var n = {
            "M+": e.getMonth() + 1,
            "d+": e.getDate(),
            "h+": e.getHours(),
            "m+": e.getMinutes(),
            "s+": e.getSeconds(),
            "q+": Math.floor((e.getMonth() + 3) / 3),
            S: e.getMilliseconds()
        };
        /(y+)/.test(t) && (t = t.replace(RegExp.$1, (e.getFullYear() + "").substr(4 - RegExp.$1.length)));
        for (var r in n)new RegExp("(" + r + ")").test(t) && (t = t.replace(RegExp.$1, 1 == RegExp.$1.length ? n[r] : ("00" + n[r]).substr(("" + n[r]).length)));
        return t
    }

    return {get: e}
}]), Diandanbao.factory("SearchService", ["DiandanbaoConst", "BranchService", function (e, t) {
    function n(e) {
        e(r)
    }

    var r = JSON.parse(angular.element('meta[name="search_words_json"]').attr("content"));
    return {
        getSearchWord: n, search: function (e, n) {
            return t.query({"query[name_cont]": e}, n)
        }
    }
}]), Diandanbao.factory("SharableCouponService", ["$rootScope", "$resource", "DiandanbaoConst", function (e, t, n) {
    function r(e, t) {
        o.get({id: e}, t)
    }

    function i(e, t) {
        o.receive({id: e}, {}, t)
    }

    var o = t(n.baseUrl + "/sharable_coupons/:id/:action", {format: "json"}, {
        receive: {
            method: "post",
            params: {action: "receive"}
        }
    });
    return {receive: i, get: r}
}]), Diandanbao.factory("ShopService", ["DiandanbaoConst", function () {
    function e(e) {
        e(r)
    }

    function t(e) {
        var t = [];
        return r.is_support_alipay && e.alipay && t.push({
            name: "\u652f\u4ed8\u5b9d",
            value: "alipay"
        }), r.is_support_wechatpay && e.wechatpay && t.push({
            name: "\u5fae\u4fe1\u652f\u4ed8",
            value: "wechatpay"
        }), r.is_support_baidupay && e.baidupay && t.push({
            name: "\u767e\u5ea6\u94b1\u5305",
            value: "baidupay"
        }), e.pay_on_face && t.push({
            name: "\u73b0\u91d1\u7ed3\u8d26",
            value: "pay_on_face"
        }), e.pay_on_arrive && t.push({
            name: "\u5230\u5e97\u4ed8\u6b3e",
            value: "pay_on_arrive"
        }), e.pay_on_receive && t.push({
            name: "\u8d27\u5230\u4ed8\u6b3e",
            value: "pay_on_receive"
        }), e.vip_card_pay && t.push({name: "\u4f1a\u5458\u5361\u652f\u4ed8", value: "vip_card_pay"}), t
    }

    function n(t, n) {
        e(function (e) {
            angular.forEach(e.branch_types, function (e) {
                e.id === t && n(e)
            })
        })
    }

    var r = JSON.parse(angular.element('meta[name="shop_json"]').attr("content"));
    return {get: e, get_branch_type: n, get_pay_methods: t}
}]), angular.module("diandanbao_app.services.sign_record", []).service("SignRecordService", ["$resource", "DiandanbaoConst", function (e, t) {
    function n(e) {
        i.query({}, e)
    }

    function r(e) {
        i.save({}, {}, e)
    }

    var i = e(t.baseUrl + "/user/sign_records/:id/:action", {format: "json"}, {
        query: {
            method: "GET",
            isArray: !0,
            cache: !0
        }, get: {method: "GET", cache: !0}
    });
    return {query: n, sign: r}
}]), Diandanbao.factory("StaticMapUrlService", ["ShopService", function (e) {
    function t() {
        return c ? "size=340x600" : "size=340*600"
    }

    function n(e) {
        return "center=" + r(e)
    }

    function r(e) {
        return longitude = e.longitude, latitude = e.latitude, c ? "" + latitude + "," + longitude : "" + longitude + "," + latitude
    }

    function i(e) {
        last_point = e.pop(), e.reverse();
        var t = c ? "" : "markers=";
        for (mks = []; e.length > 0;)point = e.pop(), pstr = c ? "markers=color:gray%7C" + r(point) : r(point) + ",gray", mks.push(pstr);
        last_point_str = c ? "markers=color:red%7Clabel:A%7C" + r(last_point) : r(last_point) + ",red,A", mks.push(last_point_str);
        var n = c ? "&" : "|";
        return t + mks.join(n)
    }

    function o() {
        null == s && e.get(function (e) {
            c = e.enable_foreign ? !0 : !1
        })
    }

    function a(e) {
        o();
        var r = c ? l : u;
        return last_point = e[e.length - 1], r + [t(), n(last_point), d, i(e)].join("&")
    }

    var s = null, c = null, l = "https://maps.googleapis.com/maps/api/staticmap?", u = "http://st.map.qq.com/api?", d = "zoom=13";
    return {map_url: a}
}]), Diandanbao.factory("TableZoneService", ["DiandanbaoConst", "$resource", function (e, t) {
    function n(e, t) {
        r.query({branch_id: e}, t)
    }

    var r = t(e.baseUrl + "/branches/:branch_id/table_zones/:id/:action", {format: "json"}, {
        query: {
            method: "GET",
            isArray: !0,
            cache: !0
        }, get: {method: "GET", cache: !0}
    });
    return {query: n}
}]), Diandanbao.factory("TuanService", ["DiandanbaoConst", "$resource", function (e, t) {
    function n(e, t) {
        "function" == typeof e ? i.query({}, e) : i.query(e, t)
    }

    function r(e, t) {
        i.get({id: e}, t)
    }

    var i = t(e.baseUrl + "/tuans/:id/:action", {format: "json"}, {
        query: {method: "GET", isArray: !0, cache: !0},
        get: {method: "GET", cache: !0}
    });
    return {query: n, get: r}
}]), angular.module("diandanbao_app.services.url_helper", []).factory("UrlHelperService", ["$rootScope", "BranchService", "ProductService", function (e) {
    function t(t, n) {
        e.go("/branches/" + t.branch_id + "/products/" + t.id + "?cart_type=" + n)
    }

    function n(t, n) {
        e.go("/branches/" + t + "/products/search?cart_type=" + n)
    }

    function r(t, n) {
        e.go("/branches/" + t + "/products/" + n)
    }

    return {go_show_product: t, go_search_product: n, go_products_list: r}
}]), Diandanbao.factory("AddressService", ["$rootScope", "$resource", "DiandanbaoConst", function (e, t, n) {
    function r(e) {
        m.push(e)
    }

    function i() {
        return 0 == m.length ? null : m.pop()
    }

    function o(e) {
        g = e
    }

    function a() {
        g = null
    }

    function s() {
        return null == g ? {name: "", phone: "", content: "", city_name: "", latitude: null, longitude: null} : g
    }

    function c(e) {
        h.query({}, e)
    }

    function l(e, t) {
        h.save({}, {address: e}, t)
    }

    function u(e, t, n) {
        h.update({id: e}, {address: t}, n)
    }

    function d(e, t) {
        h.get({id: e}, t)
    }

    function p(e, t) {
        h.destroy({id: e}, {}, t)
    }

    function f(e, t) {
        h.set_default({id: e}, {}, t)
    }

    var h = t(n.baseUrl + "/user/addresses/:id/:action", {format: "json"}, {
        update: {
            method: "post",
            params: {action: "patch"}
        },
        set_default: {method: "post", params: {action: "set_default"}, isArray: !0},
        destroy: {method: "post", params: {action: "delete"}}
    }), m = [], g = null;
    return {
        query: c,
        create: l,
        update: u,
        destroy: p,
        set_default: f,
        restore_url: i,
        store_url: r,
        restore_address: s,
        store_address: o,
        delete_store_address: a,
        get: d
    }
}]), Diandanbao.factory("BaseUserCouponService", ["$rootScope", "$resource", "DiandanbaoConst", function (e, t, n) {
    function r(e) {
        var t;
        switch (e) {
            case"coupon":
                t = s;
                break;
            case"groupon":
                t = c;
                break;
            case"voucher":
                t = l
        }
        return t
    }

    function i(e, t) {
        var n = r(e);
        n.query({}, t)
    }

    function o(e, t, n) {
        var i = r(e);
        i.get({id: t}, n)
    }

    var a = {}, s = t(n.baseUrl + "/user/coupons/:id/:action", {format: "json"}, angular.extend({}, a)), c = t(n.baseUrl + "/user/groupons/:id/:action", {format: "json"}, angular.extend({}, a)), l = t(n.baseUrl + "/user/vouchers/:id/:action", {format: "json"}, angular.extend({}, a));
    return {get_resource: r, query: i, get: o}
}]), Diandanbao.factory("CouponService", ["$rootScope", "$resource", "DiandanbaoConst", function (e, t, n) {
    function r(e) {
        o.query({}, e)
    }

    function i(e, t) {
        o.get({id: e}, t)
    }

    var o = t(n.baseUrl + "/user/coupons/:id/:action", {format: "json"}, {});
    return {query: r, get: i}
}]), Diandanbao.module("diandanbao_app.services.favorite_branch", []).factory("FavoriteBranchService", ["$rootScope", "$resource", "DiandanbaoConst", function (e, t, n) {
    function r(e) {
        a.query({}, e)
    }

    function i(e, t) {
        a.save({id: e}, t)
    }

    function o(e, t) {
        a.destroy({id: e}, {}, t)
    }

    var a = t(n.baseUrl + "/user/favorite_branches/:id/:action", {format: "json"}, {
        destroy: {
            method: "post",
            params: {action: "delete"}
        }
    });
    return {query: r, save: i, destroy: o}
}]), Diandanbao.factory("BaseUserOrderService", ["$rootScope", "$resource", "DiandanbaoConst", "SnapCartService", function (e, t, n) {
    function r(e) {
        var t;
        switch (e) {
            case"delivery":
                t = a;
                break;
            case"eat_in_hall":
                t = s;
                break;
            case"reservation":
                t = c;
                break;
            case"groupon":
                t = l;
                break;
            case"recharge":
                t = u;
                break;
            case"payment":
                t = d
        }
        return t
    }

    function i(e, t) {
        var n = r(e);
        n.query({}, t)
    }

    var o = {}, a = t(n.baseUrl + "/delivery_orders/:id/:action", {format: "json"}, angular.extend({}, o)), s = t(n.baseUrl + "/eat_in_hall_orders/:id/:action", {format: "json"}, angular.extend({}, o)), c = t(n.baseUrl + "/reservation_orders/:id/:action", {format: "json"}, angular.extend({}, o)), l = t(n.baseUrl + "/groupon_orders/:id/:action", {format: "json"}, angular.extend({}, o)), u = t(n.baseUrl + "/recharge_orders/:id/:action", {format: "json"}, angular.extend({}, o)), d = t(n.baseUrl + "/payment_orders/:id/:action", {format: "json"}, angular.extend({}, o));
    return {query: i}
}]), Diandanbao.factory("UserSharableCouponService", ["$rootScope", "$resource", "DiandanbaoConst", function (e, t, n) {
    function r(e) {
        o.query({}, e)
    }

    function i(e, t) {
        o.get({id: e}, t)
    }

    var o = t(n.baseUrl + "/user/sharable_coupons/:id/:action", {format: "json"}, {});
    return {query: r, get: i}
}]), angular.module("diandanbao_app.services.user", []).factory("UserService", ["$http", "$rootScope", "$resource", "DiandanbaoConst", function (e, t, n, r) {
    function i(e) {
        e(h)
    }

    function o(e) {
        h = e
    }

    function a(e) {
        m.show(function (t) {
            o(t), e && e(t)
        })
    }

    function s(e, t) {
        m.update_vip_info({}, {vip_info: e}, function (e) {
            o(e), t && t(e)
        })
    }

    function c(e) {
        m.apply_vip({}, {}, e)
    }

    function l(e, t, n) {
        m.update_pay_password({}, {current_pay_password: e, new_pay_password: t}, function (e) {
            o(e), n && n(e)
        })
    }

    function u(e, t) {
        m.send_validation_code({to: e}, {}, t)
    }

    function d(e, t, n) {
        e ? 6 == t.length ? m.is_correct_code({code: t}, {}, n) : n({is_correct: !1}) : n({is_correct: !0})
    }

    function p(e, t) {
        m.authenticate_password({}, {password: e}, t)
    }

    function f(e, t, n) {
        m.bind_vip({}, {phone: e, password: t}, n)
    }

    var h = JSON.parse(angular.element('meta[name="user_json"]').attr("content")), m = n(r.baseUrl + "/user/:action", {format: "json"}, {
        show: {method: "get"},
        update_vip_info: {method: "post", params: {action: "update_vip_info"}},
        apply_vip: {method: "post", params: {action: "apply_vip"}},
        update_pay_password: {method: "post", params: {action: "update_pay_password"}},
        send_validation_code: {method: "post", params: {action: "send_validation_code"}},
        is_correct_code: {method: "get", params: {action: "is_correct_code"}},
        authenticate_password: {method: "post", params: {action: "authenticate_password"}},
        bind_vip: {method: "post", params: {action: "bind_vip"}}
    });
    return {
        get: i,
        set: o,
        refresh: a,
        update_vip_info: s,
        apply_vip: c,
        update_pay_password: l,
        send_validation_code: u,
        is_correct_code: d,
        authenticate_password: p,
        bind_vip: f
    }
}]), angular.module("diandanbao_app.services.wechat_share_record_service", []).factory("WechatShareRecordService", ["$rootScope", "$resource", "DiandanbaoConst", function (e, t, n) {
    function r(e, t) {
        t = t || function () {
            }, e.img_url = e.imgUrl, s.confirm({id: e.id}, {wechat_share_record: e}, t)
    }

    function i(e, t) {
        s.get({id: e}, t)
    }

    function o(e) {
        s.query({}, e)
    }

    function a(e, t) {
        s.save({trigger_timestamp: e}, t)
    }

    var s = t(n.baseUrl + "/wechat_share_records/:id/:action", {format: "json"}, {
        confirm: {
            method: "post",
            params: {action: "confirm"}
        }
    });
    return {update: r, create_id: a, get: i, query: o}
}]), Diandanbao.factory("ZoneService", ["DiandanbaoConst", "$resource", function (e, t) {
    var n = t(e.baseUrl + "/zones/:action", {format: "json"}, {
        query: {method: "GET", isArray: !0, cache: !0},
        get_zone_by_city: {method: "GET", cache: !0, params: {action: "get_zone_by_city"}}
    });
    return {
        query: function (e, t) {
            n.query(e, t)
        }, get_zone_by_city: function (e, t) {
            n.get_zone_by_city(e, t)
        }
    }
}]), angular.module("diandanbao_app.controllers.address", []).controller("addressesController", ["$rootScope", "$scope", "$compile", "$location", "AddressService", "UserService", function (e, t, n, r, i, o) {
    e.header_title = "\u5730\u5740\u7ba1\u7406", t.is_editing = !1, o.get(function (e) {
        t.user = e
    }), i.query(function (e) {
        t.addresses = e, angular.forEach(e, function (e) {
            e.is_default && (t.user.default_address_id = e.id)
        }), console.log(e)
    }), t.set_default = function (e) {
        var n = function () {
            var e = i.restore_url();
            e && r.path(e)
        };
        return e.id == t.user.default_address_id ? void n() : void i.set_default(e.id, function (r) {
            t.addresses = r, t.user.default_address_id = e.id, n()
        })
    }, t.new_address = function () {
        e.go("/addresses/new", !1)
    }, t.destroy = function (e) {
        i.destroy(e.id, function () {
            var n = t.addresses.indexOf(e);
            t.addresses.splice(n, 1)
        })
    }, t.location = function (t, n) {
        i.store_url(r.path()), e.go("/addresses/" + n.id + "/chose_location", !1), t.stopPropagation()
    }, t.toggle_edit_state = function () {
        t.is_editing = !t.is_editing
    }
}]).factory("ValidationCodeHelper", ["ShopService", "UserService", function (e, t) {
    var n = function (n, r) {
        r.is_code_sent = !1, r.validation_code = "", e.get(function (e) {
            r.is_use_validation_sms = e.use_validation_sms
        }), r.is_phone_changed = function () {
            var e = r.address && r.address.phone != r.original_phone;
            return e
        }, r.is_need_validation = function () {
            return r.is_use_validation_sms && r.is_phone_changed()
        }, r.send_code = function () {
            if (!r.is_code_sent) {
                var e = r.address.phone;
                e.match(/^\d{11}$/) ? t.send_validation_code(e, function () {
                    r.is_code_sent = !0, r.$emit("events:success_info", "\u9a8c\u8bc1\u7801\u5df2\u7ecf\u53d1\u9001\uff0c\u8bf7\u67e5\u770b\u77ed\u4fe1\u5e76\u5c06\u6536\u5230\u7684\u9a8c\u8bc1\u7801\u6b63\u786e\u586b\u5199\u3002");
                    var e = 60, t = setInterval(function () {
                        r.$apply(function () {
                            0 >= e ? (r.button_value = "\u91cd\u65b0\u53d1\u9001\u9a8c\u8bc1\u7801", r.is_code_sent = !1, clearInterval(t)) : (r.button_value = e + "\u79d2\u540e\u53ef\u91cd\u65b0\u53d1\u9001", e--)
                        })
                    }, 1e3)
                }) : n.$emit("events:receive_errors", "\u8bf7\u586b\u5199\u6b63\u786e\u7684\u624b\u673a\u53f7\u7801")
            }
        }, r.is_correct_code = t.is_correct_code
    };
    return {commonAction: n}
}]).controller("newAddressController", ["$rootScope", "$scope", "$location", "baseAddressController", "AddressService", "ValidationCodeHelper", "GeolocationService", function (e, t, n, r, i, o, a) {
    r.action(t, function () {
    }), t.address = i.restore_address(), t.chose_location = function (t) {
        i.store_address(t), e.go("/addresses/chose_location", !1)
    }, e.header_title = "\u65b0\u5efa\u5730\u5740", t.original_phone = null, o.commonAction(e, t), t.submit = function () {
        t.can_submit() && t.is_correct_code(t.is_need_validation(), t.validation_code, function (n) {
            if (n.is_correct)if (!t.enable_foreign || t.address.latitude && t.address.longitude) {
                if (t.lack_latlng())return void e.$emit("events:receive_errors", "\u8bf7\u6807\u6ce8\u5730\u5740");
                s(t.address)
            } else e.$emit("events:success_info", "\u7cfb\u7edf\u4e3a\u60a8\u5b9a\u4f4d\u4e2d... , \u5982\u679c\u5b9a\u4f4d\u4e0d\u6b63\u786e\uff0c\u60a8\u53ef\u4ee5\u70b9\u51fb\u5730\u56fe\u624b\u52a8\u8bbe\u7f6e\u60a8\u7684\u4f4d\u7f6e"), a.code_address(t.address.content, function (e) {
                t.address.latitude = e.lat(), t.address.longitude = e.lng()
            }, function (t) {
                e.$emit("events:receive_errors", t)
            }); else e.$emit("events:receive_errors", "\u9a8c\u8bc1\u7801\u9519\u8bef")
        })
    };
    var s = function (t) {
        i.create(t, function (t) {
            i.delete_store_address();
            var r = i.restore_url();
            r && i.set_default(t.id, function () {
                n.path(r)
            }), e.go("/addresses")
        })
    }
}]).controller("editAddressController", ["$rootScope", "$scope", "$routeParams", "$location", "baseAddressController", "AddressService", "ValidationCodeHelper", function (e, t, n, r, i, o, a) {
    i.action(t, function () {
    }), e.header_title = "\u4fee\u6539\u5730\u5740", o.get(n.address_id, function (n) {
        t.address = n, t.original_phone = n.phone, t.enable_foreign && (null == t.address.latitude || null == t.address.longitude) && (o.store_url(r.path()), e.go("/addresses/" + n.id + "/chose_location", !1))
    }), a.commonAction(e, t), t.submit = function () {
        t.can_submit() && t.is_correct_code(t.is_need_validation(), t.validation_code, function (n) {
            if (n.is_correct) {
                if (t.lack_latlng())return void e.$emit("events:receive_errors", "\u8bf7\u6807\u6ce8\u5730\u5740");
                o.update(t.address.id, t.address, function () {
                    e.go("/addresses")
                })
            } else e.$emit("events:receive_errors", "\u9a8c\u8bc1\u7801\u9519\u8bef")
        })
    }, t.chose_location = function (t) {
        o.store_url(r.path()), e.go("/addresses/" + t.id + "/chose_location", !1)
    }
}]).controller("choseAddressLocationController", ["$rootScope", "$scope", "$routeParams", "AddressService", "GeolocationService", "LocationService", function (e, t, n, r, i, o) {
    function a(e, n) {
        o.show_picker("map", e, n, function (e, n) {
            t.address.longitude = e.lng, t.address.latitude = e.lat, t.address.city_name = n, c(t.address)
        })
    }

    var s = !1, c = null, l = n.address_id;
    "undefined" == typeof l ? (s = !0, c = function (n) {
        n.content = n.city_name, r.store_address(n), t.$apply(function () {
            e.go("/addresses/new")
        })
    }) : c = function (t) {
        r.update(t.id, t, function () {
            var t = r.restore_url();
            e.go(t ? t : "/addresses")
        })
    }, s ? (t.address = r.restore_address(), a(t.address.longitude, t.address.latitude)) : r.get(n.address_id, function (e) {
        t.address = e, a(e.longitude, e.latitude)
    })
}]).factory("baseAddressController", ["$rootScope", "AddressService", "StaticMapUrlService", "ShopService", function (e, t, n, r) {
    function i(t) {
        t.enable_foreign = !1, r.get(function (e) {
            t.enable_foreign = e.enable_foreign
        }), t.address_image_url = function (e) {
            return null == e || null == e.latitude ? null : n.map_url([e])
        }, t.can_submit = function () {
            var n = [];
            return (null == t.address.name || "" == t.address.name) && n.push("\u8bf7\u586b\u5199\u59d3\u540d"), (null == t.address.phone || "" == t.address.phone) && n.push("\u8bf7\u586b\u5199\u7535\u8bdd"), (null == t.address.content || "" == t.address.content) && n.push("\u8bf7\u586b\u5199\u5730\u5740"), n.length > 0 ? (e.$emit("events:receive_errors", n), !1) : !0
        }, t.lack_latlng = function () {
            return t.enable_foreign ? null == t.address.latitude || null == t.address.longitude : !1
        }
    }

    return {action: i}
}]), angular.module("diandanbao_app.controllers.article", []).controller("articleController", ["$rootScope", "$scope", "$routeParams", "ArticleService", function (e, t, n, r) {
    r.get(n.article_id, function (e) {
        t.article = e
    })
}]), Diandanbao.module("diandanbao_app.controllers.branch", []).factory("BranchesHelper", ["$rootScope", "$route", "BranchService", "QueryService", "LoadMoreServiceFactory", function (e, t, n, r, i) {
    return {
        executeCommonAction: function (e, o) {
            e.branch_request_params = r.getCombineQuery(), angular.extend(e.branch_request_params, o);
            var a = i.createLoadMoreService({
                id: t.current.controller, onLoadMore: function (t, r, i, o) {
                    angular.extend(e.branch_request_params, {
                        page: t,
                        per_page: r,
                        "query[created_at_lteq]": new Date(i)
                    }), n.query(e.branch_request_params, function (e) {
                        console.log(e), o && o(e)
                    })
                }, update: function (t) {
                    e.branches = t
                }
            });
            n.filters({}, function (t) {
                e.navFilters = t
            }), e.onPickupFilter = function (t, n) {
                e.branch_request_params = {}, $.each(n, function (t, n) {
                    e.branch_request_params[n.op] = n.value
                }), angular.extend(e.branch_request_params, o), a.reload(), a.loadMore()
            }, $(document).on("scroll", function () {
                a.isLoading() || $(document).scrollTop() + $(window).height() > $(document).height() - 30 && a.loadMore()
            })
        }
    }
}]).controller("branchesController", ["$rootScope", "$scope", "BranchesHelper", function (e, t, n) {
    e.header_title = "\u95e8\u5e97\u5217\u8868", n.executeCommonAction(t, {})
}]).controller("deliveryBranchesController", ["$rootScope", "$scope", "BranchesHelper", function (e, t, n) {
    e.header_title = "\u95e8\u5e97\u5217\u8868", n.executeCommonAction(t, {"query[use_delivery_setting_eq]": !0})
}]).controller("branchController", ["$rootScope", "$scope", "$routeParams", "$location", "BranchService", "GeolocationService", "FavoriteBranchService", "ShopService", function (e, t, n, r, i, o, a, s) {
    var c = n.branch_id;
    s.get(function (e) {
        t.enable_foreign = e.enable_foreign
    });
    var l = function (t) {
        e.shareRecordTrigger = {
            triggerBeforeCreateRecord: function (e, n) {
                angular.extend(n, {title: t.name, imgUrl: t.image})
            }
        }
    };
    i.get({id: c}, function (n) {
        t.branch = n, s.get_branch_type(t.branch.branch_type_id, function (e) {
            t.branch_type = e
        }), e.header_title = t.branch.name, l(t.branch)
    }), o.get_location_address(function (e) {
        t.location_address = e
    }), t.open_location = function () {
        wx.openLocation({
            latitude: parseFloat(t.branch.latitude),
            longitude: parseFloat(t.branch.longitude),
            name: t.branch.name,
            address: t.branch.address,
            scale: 14,
            infoUrl: ""
        })
    }, t.toggleFavorite = function () {
        t.branch.is_followed ? a.destroy(c, function () {
            t.branch.is_followed = !t.branch.is_followed
        }) : a.save(c, function () {
            t.branch.is_followed = !t.branch.is_followed
        })
    }
}]), Diandanbao.controller("censorReportController", ["$rootScope", "$location", "$scope", "CensorReportService", function (e, t, n, r) {
    e.header_title = "\u4e3e\u62a5", n.data = {}, n.report = function () {
        r.report(n.data.title, n.data.desc, function () {
            n.visible = !1, n.data = {}, e.$emit("events:success_info", "\u63d0\u4ea4\u6210\u529f\uff0c\u8c22\u8c22\u60a8\u7684\u53cd\u9988"), t.path("/")
        })
    }
}]), Diandanbao.module("diandanbao_app.controllers.combos", []).controller("combosController", ["$rootScope", "$scope", "$routeParams", "$location", "ComboService", "BranchService", "BaseCartService", "SnapCartService", function (e, t, n, r, i, o, a, s) {
    function c() {
        var e = {combo_id: t.active_combo.id, items: []};
        return angular.forEach(t.active_combo.combo_items, function (t) {
            angular.forEach(t.variants, function (n) {
                n.quantity > 0 && e.items.push({combo_item_id: t.id, variant_id: n.id, quantity: n.quantity})
            })
        }), e
    }

    function l() {
        var e = "";
        return angular.forEach(t.active_combo.combo_items, function (t) {
            angular.forEach(t.variants, function (t) {
                t.quantity > 0 && (e = e + t.name + "*" + t.quantity + " ")
            })
        }), e
    }

    function u(e) {
        angular.forEach(e.combo_items, function (e) {
            e.quantity = 0, e.show = !1, angular.forEach(e.variants, function (e) {
                e.quantity = 0
            })
        })
    }

    t.branch_id = n.branch_id, t.order_type = r.search().order_type, t.combos = [], t.active_combo = null, o.get({id: t.branch_id}, function (e) {
        t.branch = e
    }), i.query(t.branch_id, t.order_type, function (e) {
        t.combos = e, t.active_combo = e[0], angular.forEach(t.combos, function (e) {
            u(e)
        })
    }), t.change_active_combo = function (e) {
        t.active_combo = e
    }, t.stock_of = function (e) {
        return void 0 == e.quantity ? e.stock_quantity : e.stock_quantity - e.quantity
    }, t.can_add = function (e) {
        return e.quantity < e.select_count
    }, t.add_item = function (e, n) {
        t.can_add(e, n) && (e.quantity++, n.quantity++)
    }, t.can_remove = function (e, t) {
        return t.quantity > 0
    }, t.remove_item = function (e, n) {
        t.can_remove(e, n) && (e.quantity--, n.quantity--)
    }, t.toggle_combo_item = function (e) {
        e.show = !e.show
    }, t.can_submit = function () {
        var e = !0;
        return t.active_combo && 0 !== t.active_combo.combo_items.length ? angular.forEach(t.active_combo.combo_items, function (t) {
            t.quantity !== t.select_count && (e = !1)
        }) : e = !1, e
    }, t.submit = function () {
        t.can_submit() && e.confirm(t.active_combo.name, l(), function () {
            a.add_combo_package(t.order_type, t.branch_id, c(), function (n) {
                s.set_cart(t.order_type, t.branch_id, n), e.confirm("", "\u6dfb\u52a0\u5b8c\u6210", function () {
                    e.reload()
                }, "\u7ee7\u7eed\u9009\u8d2d", function () {
                    e.go_products_list(t.branch_id, t.order_type)
                }, "\u8fd4\u56de")
            })
        })
    }
}]), angular.module("diandanbao_app.controllers.comment", []).controller("commentsController", ["$rootScope", "$scope", "$routeParams", "CommentService", "BranchService", function (e, t, n, r, i) {
    i.get({id: n.branch_id}, function (t) {
        e.header_title = t.name
    }), r.query(n.branch_id, function (e) {
        t.comments = e
    })
}]), Diandanbao.module("diandanbao_app.controllers.coupon", []).controller("couponController", ["$rootScope", "$scope", "BaseCouponController", function (e, t, n) {
    t.header_title = "\u4f18\u60e0\u52b5\u8be6\u60c5", t.coupon_type = "coupon", n.action(t)
}]).controller("grouponController", ["$rootScope", "$scope", "BaseCouponController", function (e, t, n) {
    t.header_title = "\u56e2\u8d2d\u5238\u8be6\u60c5", t.coupon_type = "groupon", n.action(t)
}]).controller("voucherController", ["$rootScope", "$scope", "BaseCouponController", function (e, t, n) {
    t.header_title = "\u4ee3\u91d1\u5238\u8be6\u60c5", t.coupon_type = "voucher", n.action(t)
}]).factory("BaseCouponController", ["$rootScope", "$routeParams", "BaseUserCouponService", function (e, t, n) {
    function r(r) {
        r.base_coupon_id = t.base_coupon_id, n.get(r.coupon_type, r.base_coupon_id, function (e) {
            console.log(e), r.base_coupon = e
        }), r.can_exchange_code = function () {
            var e = r.base_coupon;
            return !e.expired && !e.applied_at && !e.refund_at && "pending" == e.exchange_code_state
        }, r.go_exchange_code = function () {
            var t = r.base_coupon;
            e.go("/exchange_codes/" + t.exchange_code_id)
        }
    }

    return {action: r}
}]), Diandanbao.module("diandanbao_app.controllers.coupons", []).controller("couponsController", ["$rootScope", "$scope", "BaseCouponsController", function (e, t, n) {
    t.header_title = "\u4f18\u60e0\u52b5", t.coupon_type = "coupon", n.action(t, function () {
    })
}]).controller("grouponsController", ["$rootScope", "$scope", "BaseCouponsController", function (e, t, n) {
    t.header_title = "\u56e2\u8d2d\u5238", t.coupon_type = "groupon", n.action(t)
}]).controller("vouchersController", ["$rootScope", "$scope", "BaseCouponsController", function (e, t, n) {
    t.header_title = "\u4ee3\u91d1\u5238", t.coupon_type = "voucher", n.action(t)
}]).factory("BaseCouponsController", ["$rootScope", "$routeParams", "BaseUserCouponService", function (e, t, n) {
    function r(t) {
        n.query(t.coupon_type, function (e) {
            console.log(e), t.all_base_coupons = e, t.available_base_coupons = e.filter(function (e) {
                return !e.expired && !e.applied_at && !e.refund_at
            }), t.applied_base_coupons = e.filter(function (e) {
                return e.applied_at
            }), t.expired_base_coupons = e.filter(function (e) {
                return e.expired
            }), t.refund_base_coupons = e.filter(function (e) {
                return e.refund_at
            }), t.change_filter_tab("available")
        }), t.change_filter_tab = function (e) {
            switch (t.tab = e, e) {
                case"available":
                    t.base_coupons = t.available_base_coupons;
                    break;
                case"applied":
                    t.base_coupons = t.applied_base_coupons;
                    break;
                case"expired":
                    t.base_coupons = t.expired_base_coupons;
                    break;
                case"refund":
                    t.base_coupons = t.refund_base_coupons
            }
        }, t.can_exchange_code = function (e) {
            return !e.expired && !e.applied_at && !e.refund_at && "pending" == e.exchange_code_state
        }, t.go_exchange_code = function (t) {
            e.go("/exchange_codes/" + t.exchange_code_id)
        }, t.go_show = function (n) {
            e.go("/user/" + t.coupon_type + "s/" + n.id)
        }
    }

    return {action: r}
}]), Diandanbao.module("diandanbao_app.controllers.sharable_coupon", []).controller("userSharableCouponsController", ["$rootScope", "$scope", "UserSharableCouponService", function (e, t, n) {
    t.header_title = "\u4f18\u60e0\u5238\u7ea2\u5305", n.query(function (e) {
        t.sharable_coupons = e
    }), t.go_show = function (t) {
        e.go("/user/sharable_coupons/" + t.id)
    }
}]).controller("userSharableCouponController", ["$rootScope", "$scope", "$routeParams", "UserSharableCouponService", function (e, t, n, r) {
    t.header_title = "\u4f18\u60e0\u5238\u7ea2\u5305\u8be6\u60c5", t.sharable_coupon_id = n.sharable_coupon_id, r.get(t.sharable_coupon_id, function (e) {
        t.sharable_coupon = e
    })
}]), Diandanbao.module("diandanbao_app.controllers.deliveryman_location", []).controller("deliverymanLocationController", ["$rootScope", "$scope", "$routeParams", "BaseOrderService", "DeliveryOrderService", "StaticMapUrlService", function (e, t, n, r, i, o) {
    t.header_title = "\u5f53\u524d\u914d\u9001\u5458\u4f4d\u7f6e", t.order_type = "delivery", t.branch_id = n.branch_id, t.order_id = n.order_id, r.get(t.order_type, t.branch_id, t.order_id, function (e) {
        t.order = e
    }), t.location_image_url = function (e) {
        return o.map_url([e])
    }, t.refresh_location = function () {
        i.refresh_location(t.branch_id, t.order_id, function (e) {
            t.order.deliveryman_location = e
        })
    }
}]), Diandanbao.module("diandanbao_app.controllers.exchange_codes", []).controller("exchangeCodeController", ["$rootScope", "$scope", "$routeParams", "ExchangeCodeService", function (e, t, n, r) {
    e.header_title = "\u5151\u6362\u7801", t.exchange_code_id = n.exchange_code_id, t.permissions = [], r.get(t.exchange_code_id, function (e) {
        t.exchange_code = e
    }), r.get_permissions(t.exchange_code_id, function (n) {
        t.permissions = n.permissions, t.can_show() || (e.$emit("events:receive_errors", "\u60a8\u6ca1\u6709\u6743\u9650\u67e5\u770b\u8be5\u5151\u6362\u7801!"), e.go("/"))
    }), t.can_show = function () {
        return t.permissions.indexOf("show") >= 0
    }, t.can_exchange = function () {
        return t.permissions.indexOf("exchange") >= 0 && "pending" == t.exchange_code.state
    }, t.can_get_qrcode = function () {
        return t.permissions.indexOf("get_qrcode") >= 0 && "pending" == t.exchange_code.state
    }, t.exchange = function () {
        r.exchange(t.exchange_code_id, function () {
            e.reload()
        })
    }, t.get_qrcode = function () {
        r.get_qrcode(t.exchange_code_id, function (e) {
            t.qrcode = e
        })
    }
}]), Diandanbao.module("diandanbao_app.controllers.favorite_branch", []).controller("favoriteBranchesController", ["$rootScope", "$scope", "$compile", "$location", "FavoriteBranchService", "UserService", "BranchService", function (e, t, n, r, i, o) {
    e.header_title = "\u95e8\u5e97\u6536\u85cf", o.get(function (e) {
        t.user = e
    }), i.query(function (e) {
        t.branches = e
    })
}]), angular.module("diandanbao_app.controllers.guest_queue", []).controller("guestQueueController", ["$rootScope", "$scope", "$location", "$routeParams", "GuestQueueService", "BranchService", function (e, t, n, r, i, o) {
    e.header_title = "\u5fae\u4fe1\u6392\u53f7", o.get({id: r.branch_id}, function (e) {
        t.branch = e
    }), t.refresh_state = function () {
        i.get(r.branch_id, function (e) {
            t.guest_queue = e
        })
    }, t.cancel = function () {
        i.cancel(r.branch_id, function () {
            t.$emit("events:success_info", "\u5df2\u7ecf\u6210\u529f\u53d6\u6d88\u6392\u53f7"), t.refresh_state()
        })
    }, t.refresh_state()
}]).controller("newGuestQueueController", ["$scope", "$location", "$routeParams", "GuestQueueService", "BranchService", function (e, t, n, r, i) {
    e.header_title = "\u6211\u8981\u6392\u53f7", e.guest_queue = {}, e.queue_settings = [], e.branch_id = n.branch_id, i.get({id: e.branch_id}, function (t) {
        e.branch = t
    }), r.get(n.branch_id, function (t) {
        e.queue_settings = t.queue_settings
    }), e.chooseQueueSetting = function (t) {
        e.guest_queue.queue_setting_id = t.id
    }, e.submit = function () {
        e.guest_queue.guest_num ? r.create(n.branch_id, e.guest_queue, function () {
            t.path("/branches/" + n.branch_id + "/guest_queue")
        }) : e.$emit("events:success_info", "\u5ba2\u4eba\u6570\u91cf\u4e0d\u80fd\u4e3a\u7a7a")
    }
}]).controller("bindUserGuestQueueController", ["$scope", "$rootScope", "$routeParams", "GuestQueueService", "BranchService", "UserService", function (e, t, n, r, i, o) {
    e.header_title = "\u6392\u53f7\u7ed1\u5b9a", e.guest_queue = {}, e.branch_id = n.branch_id, e.qr_code_id = n.qr_code_id, i.get({id: e.branch_id}, function (t) {
        e.branch = t
    }), o.get(function (t) {
        e.user = t
    }), r.get_by_qr_code(e.branch_id, e.qr_code_id, function (n) {
        e.guest_queue = n, "queueing" != e.guest_queue.workflow_state ? (t.alert("\u8be5\u6392\u53f7" + e.guest_queue.workflow_state_name), t.go("/branches/" + e.branch_id + "/guest_queue")) : e.guest_queue.base_user_id ? e.guest_queue.base_user_id == e.user.id ? t.go("/branches/" + e.branch_id + "/guest_queue") : (t.alert("\u8be5\u6392\u53f7\u5df2\u88ab\u5176\u4ed6\u4eba\u7ed1\u5b9a"), t.go("/branches/" + e.branch_id + "/guest_queue")) : r.bind_user(e.branch_id, e.guest_queue.id, function (n) {
            n.state ? t.go("/branches/" + e.branch_id + "/guest_queue") : (t.alert(n.error), t.go("/branches/" + e.branch_id + "/guest_queue"))
        })
    })
}]), angular.module("diandanbao_app.controllers.invoice", []).controller("invoiceController", ["$rootScope", "$scope", "$routeParams", "InvoiceService", function (e, t, n, r) {
    t.header_title = "\u7d22\u8981\u53d1\u7968", t.branch_id = n.branch_id, t.order_type = n.order_type, t.order_id = n.order_id, t.invoice = {
        payer: "personal",
        title: null,
        order_id: t.order_id
    }, t.change_payer = function (e) {
        t.invoice.payer = e
    }, t.can_submit = function () {
        return "company" != t.invoice.payer || null != t.invoice.title && "" != t.invoice.title ? !0 : !1
    }, t.submit = function () {
        t.can_submit() ? r.create(t.branch_id, t.order_id, t.invoice, function () {
            e.go("/branches/" + t.branch_id + "/orders/" + t.order_type + "/" + t.order_id)
        }) : e.$emit("events:receive_errors", "\u8bf7\u586b\u5199\u516c\u53f8\u540d\u79f0")
    }
}]), Diandanbao.controller("merchantApplyController", ["$rootScope", "$location", "$scope", "MerchantApplyService", function (e, t, n, r) {
    e.header_title = "\u5165\u9a7b\u7533\u8bf7", n.merchantApply = {}, n.refresh = function () {
        r.get({}, function (e) {
            n.merchantApply = e
        })
    }, n.refresh(), n.can_apply = function () {
        return n.merchantApply.phone && n.merchantApply.note
    }, n.apply = function () {
        n.can_apply() ? r.save(n.merchantApply, function () {
            n.refresh(), e.$emit("events:success_info", "\u7533\u8bf7\u63d0\u4ea4\u6210\u529f")
        }) : e.$emit("events:success_info", "\u8bf7\u5148\u586b\u5199\u4fe1\u606f\u540e\u518d\u63d0\u4ea4")
    }, n.cancel = function () {
        r.cancel({}, function () {
            n.refresh(), e.$emit("events:success_info", "\u7533\u8bf7\u5df2\u53d6\u6d88")
        })
    }
}]), Diandanbao.controller("invitationOrderController", ["$rootScope", "$scope", "$routeParams", "$location", "WechatShareRecordService", "ShopService", "BranchService", "InvitationOrderService", "UserService", "DiandanbaoConst", function (e, t, n, r, i, o, a, s, c, l) {
    t.show_share_nav = !1, c.get(function (e) {
        t.user = e
    }), a.get({id: n.branch_id}, function (e) {
        t.branch = e
    }), o.get(function (e) {
        t.shop = e
    });
    var u = {
        branch_id: n.branch_id,
        id: n.order_id,
        wechat_share_record_trigger_timestamp: UrlParser.query_parameter("wechat_share_record_trigger_timestamp")
    };
    s.get(u, function (e) {
        t.order = e, t.show_share_nav = e.is_my_order, e.is_my_order || (t.show_opinion_btn = null == e.opinion ? !0 : !1), t.guests = e.guests
    }), e.shareRecordTrigger = {
        triggerBeforeCreateRecord: function (e, r) {
            var i = "/branches/{branch_id}/orders/invitation/{order_id}".supplant({
                branch_id: n.branch_id,
                order_id: n.order_id
            }), o = UrlParser.change_parameter(r.link, "_ng_path", i);
            angular.extend(r, {
                title: "\u9080\u8bf7\u51fd",
                desc: "\u6211\u5728" + t.branch.name + "\u9884\u8ba2\u4e86\u5ea7\u4f4d\uff0c\u9080\u60a8\u4e00\u5757\u4e3e\u676f\u5171\u805a\u5427",
                imgUrl: window.location.origin + "/assets/diandanbao/yao.png",
                link: UrlParser.change_parameter(l.oauth_user_info_url, "redirect_uri", encodeURIComponent(o))
            })
        }
    }, t.toggle_show_option_btn = function () {
        t.show_opinion_btn = !t.show_opinion_btn
    }, t.agree = function () {
        s.agree(u, !0, function (t) {
            console.info(t), e.reload()
        })
    }, t.disagree = function () {
        s.disagree(u, !1, function (t) {
            console.info(t), e.reload()
        })
    }, t.go_map_link = function () {
        var e = void 0;
        e = t.shop.enable_foreign ? "https://www.google.com/maps/place/{latitude},{longitude}".supplant({
            latitude: t.branch.latitude,
            longitude: t.branch.longitude
        }) : "http://apis.map.qq.com/uri/v1/routeplan?type=drive&fromcoord=CurrentLocation&tocoord={latitude},{longitude}&to={branch_name}&referer=\u70b9\u5355\u5b9d".supplant({
            latitude: t.branch.latitude,
            longitude: t.branch.longitude,
            branch_name: t.branch.name
        }), window.location.href = e
    }, t.iknow = function () {
        t.show_share_nav = !1
    }
}]), angular.module("diandanbao_app.controllers.new_order", []).controller("newDeliveryOrderController", ["$rootScope", "$scope", "$location", "$timeout", "BaseNewOrderController", "AddressService", "DeliveryCartService", "DeliveryOrderService", "UserService", "$routeParams", function (e, t, n, r, i, o, a, s, c, l) {
    e.header_title = "\u5916\u5356\u8ba2\u5355", t.cart_type = "delivery", i.action(t, function () {
        t.note = "", t.addresses = [], t.current_address = null, t.delivery_zones = [], t.delivery_times = [], t.delivery_dates = [], t.current_delivery_zone = null, t.current_delivery_time = null, t.current_delivery_date = null, t.need_location = !1, c.get(function (n) {
            t.current_user_is_blocked = n.is_blocked, n.is_blocked && e.$emit("events:receive_errors", ["\u60a8\u5df2\u88ab\u5546\u5bb6\u7981\u6b62\u4e0b\u5355\uff01"])
        }), t.errors = function () {
            if (t.current_user_is_blocked)return ["\u60a8\u5df2\u88ab\u5546\u5bb6\u7981\u6b62\u4e0b\u5355\uff01"];
            var e = t.is_form_contents_valid(), n = t.is_distance_of_branch_to_address_valid(t.current_address), i = t.base_errors();
            return t.flatten_errors([e, n, i, r()])
        };
        var r = function () {
            var e = [];
            return t.branch.is_in_service || e.push("\u8be5\u95e8\u5e97\u8fd8\u672a\u8425\u4e1a"), t.cart && t.cart.total > 0 || e.push("\u60a8\u8fd8\u672a\u9009\u62e9\u4ea7\u54c1"), t.cart && parseFloat(t.cart.item_total) >= parseFloat(t.branch.support_delivery_if_amount_gt) || e.push("\u6700\u4f4e " + t.currency + t.branch.support_delivery_if_amount_gt + " \u8d77\u9001"), e
        };
        t.can_submit = function () {
            var e = [t.base_can_submit(), t.branch.is_in_service, t.current_address, t.cart && t.cart.total > 0, t.cart && parseFloat(t.cart.item_total) >= parseFloat(t.branch.support_delivery_if_amount_gt), !t.current_user_is_blocked], n = e.reduce(function (e, t) {
                return e && t
            });
            return n
        }, t.submit = function () {
            var n = t.errors();
            return n.length > 0 ? void e.$emit("events:receive_errors", n) : void(t.can_submit() && (e.is_submiting = !0, s.create(t.branch_id, {
                shipment: {
                    address_id: t.current_address.id,
                    delivery_zone_id: t.current_delivery_zone_id(),
                    delivery_time_id: t.current_delivery_time_id(),
                    delivery_date: t.current_delivery_date_str()
                },
                note: t.note,
                pay_method: t.current_pay_method.value,
                credits_deduction: t.deduction.credits,
                card_deduction: t.deduction.card,
                form_contents: t.form_contents()
            }, function (n) {
                e.is_submiting = !1, e.go("/branches/" + t.branch_id + "/order_success/" + n.order.id + "/delivery", !1)
            })))
        }, o.query(function (e) {
            t.addresses = e, angular.forEach(e, function (e) {
                e.is_default && (t.current_address = e, t.enable_foreign && (t.need_location = t.branch.is_charge_by_distance && (null == t.current_address.longitude || null == t.current_address.latitude)), 0 == t.need_location && t.update_shipment())
            }), t.current_address || (o.store_url(n.path()), n.path("/addresses/new"))
        }), t.change_address = function () {
            o.store_url(n.path()), n.path("/addresses")
        }, t.branch.is_charge_by_distance || s.delivery_zones(l.branch_id, function (e) {
            t.delivery_zones = t.delivery_zones.concat(e), angular.forEach(t.delivery_zones, function (e) {
                e.id == t.cart.shipment.delivery_zone_id && (t.current_delivery_zone = e)
            }), t.delivery_zones.length > 0 && !t.current_delivery_zone && (t.current_delivery_zone = t.delivery_zones[0])
        }), t.can_select_delivery_zone = function () {
            return !t.branch.is_charge_by_distance && t.delivery_zones.length > 0
        }, t.change_delivery_zone = function () {
            t.update_shipment()
        }, t.current_delivery_zone_id = function () {
            return t.current_delivery_zone ? t.current_delivery_zone.id : void 0
        }, s.delivery_times(l.branch_id, null, function (e) {
            u(e)
        });
        var u = function (e) {
            t.delivery_times = e;
            var n = null;
            angular.forEach(e, function (e) {
                e.id == t.cart.shipment.delivery_time_id && (n = e)
            }), t.current_delivery_time = n || e[0]
        };
        t.change_delivery_time = function () {
            t.update_shipment()
        }, t.current_delivery_time_id = function () {
            return t.current_delivery_time ? t.current_delivery_time.id : void 0
        }, s.delivery_dates(l.branch_id, function (e) {
            t.delivery_dates = t.delivery_dates.concat(e), angular.forEach(t.delivery_dates, function (e) {
                e.date == t.cart.shipment.delivery_date && (t.current_delivery_date = e)
            })
        }), t.change_delivery_date = function () {
            s.delivery_times(l.branch_id, t.current_delivery_date_str(), function (e) {
                u(e)
            })
        }, t.current_delivery_date_str = function () {
            return t.current_delivery_date ? t.current_delivery_date.date : void 0
        }, t.location = function () {
            o.store_url(n.path()), e.go("/addresses/" + t.current_address.id + "/chose_location", !1)
        }, t.update_shipment = function () {
            a.update_shipment(t.branch_id, {
                address_id: t.current_address.id,
                delivery_zone_id: t.current_delivery_zone_id(),
                delivery_time_id: t.current_delivery_time_id(),
                delivery_date: t.current_delivery_date_str()
            }, function (e) {
                t.cart = e
            })
        }, i.use_coupon_setting(t, t.cart_type)
    })
}]).controller("newEatInHallOrderController", ["$rootScope", "$scope", "$timeout", "BaseNewOrderController", "EatInHallOrderService", function (e, t, n, r, i) {
    e.header_title = "\u5802\u70b9\u8ba2\u5355", t.cart_type = "eat_in_hall", r.action(t, function () {
        t.cart.table_id || (e.clear_history_url(), e.go("/branches/" + t.branch_id)), r.use_coupon_setting(t, t.cart_type)
    }), t.errors = function () {
        var e = t.is_form_contents_valid(), n = t.base_errors();
        return t.flatten_errors([e, n, a()])
    };
    var o = function () {
        return t.cart && (null == t.cart.guest_num || "" == t.cart.guest_num)
    }, a = function () {
        var e = [];
        return t.cart && t.cart.total || e.push("\u60a8\u8fd8\u672a\u9009\u62e9\u4ea7\u54c1"), o() && e.push("\u8bf7\u586b\u5199\u5c31\u9910\u4eba\u6570"), e
    };
    t.can_submit = function () {
        return t.base_can_submit() && t.cart && t.cart.total > 0 && !o()
    }, t.submit = function () {
        var n = t.errors();
        return n.length > 0 ? void e.$emit("events:receive_errors", n) : void(t.can_submit() && (e.is_submiting = !0, i.create(t.branch_id, {
            note: t.note,
            pay_method: t.current_pay_method.value,
            credits_deduction: t.deduction.credits,
            card_deduction: t.deduction.card,
            form_contents: t.form_contents(),
            guest_num: t.cart.guest_num
        }, function (n) {
            e.is_submiting = !1, e.go("/branches/" + t.branch_id + "/order_success/" + n.order.id + "/eat_in_hall", !1)
        })))
    }
}]).controller("newReservationOrderController", ["$rootScope", "$scope", "$location", "$timeout", "BaseNewOrderController", "ReservationOrderService", "AddressService", "UserService", function (e, t, n, r, i, o, a, s) {
    e.header_title = "\u9884\u8ba2\u8ba2\u5355", t.cart_type = "reservation", i.action(t, function () {
        t.cart.reservation_date_str && t.cart.reservation_time_point_str || (e.clear_history_url(), e.go("/branches/" + t.branch_id + "/reservation_time_points"));
        var n = t.branch.reservation_setting.prepayment_type;
        "only_table" == n ? t.show_for_table = !0 : "only_order" == n ? (t.show_for_order = !0, t.cart.item_count > 0 && (t.prepayment_type = "prepay_for_order")) : (t.cart.item_count > 0 && (t.prepayment_type = "prepay_for_order"), t.show_for_table = !0, t.show_for_order = !0)
    }), t.note = null, t.prepay_total = function () {
        return "prepay_for_table" == t.prepayment_type ? t.cart.table_zone.reservation_price : "prepay_for_order" == t.prepayment_type ? t.cart.total : void 0
    }, t.errors = function () {
        var e = t.is_form_contents_valid(), n = t.base_errors();
        return t.flatten_errors([e, n, c()])
    };
    var c = function () {
        var e = [];
        return t.prepayment_type || e.push("\u8bf7\u9009\u62e9\u9884\u8ba2\u64cd\u4f5c\u7684\u7c7b\u578b"), "prepay_for_order" == t.prepayment_type && parseFloat(t.cart.total) < parseFloat(t.cart.table_zone.min_reservation_price) && e.push("\u4e0d\u5f97\u4f4e\u4e8e\u8d77\u5b9a\u4ef7\uff1a " + t.currency + t.cart.table_zone.min_reservation_price), (null == t.user.reservation_gender || "" == t.user.reservation_gender) && e.push("\u8bf7\u9009\u62e9\u6027\u522b"), (null == t.user.reservation_name || "" == t.user.reservation_name) && e.push("\u8bf7\u586b\u5199\u60a8\u7684\u59d3\u540d"), (null == t.user.reservation_phone || "" == t.user.reservation_phone) && e.push("\u8bf7\u586b\u5199\u60a8\u7684\u8054\u7cfb\u7535\u8bdd"), e
    };
    t.can_submit = function () {
        return t.base_can_submit() ? "prepay_for_table" == t.prepayment_type ? !0 : "prepay_for_order" == t.prepayment_type ? parseFloat(t.cart.total) >= parseFloat(t.cart.table_zone.min_reservation_price) : !1 : !1
    }, t.submit = function () {
        var n = t.errors();
        return n.length > 0 ? void e.$emit("events:receive_errors", n) : void(t.can_submit() && (e.is_submiting = !0, o.create(t.branch_id, {
            note: t.note,
            name: t.user.reservation_name,
            phone: t.user.reservation_phone,
            gender: t.user.reservation_gender,
            prepayment_type: t.prepayment_type,
            pay_method: t.current_pay_method.value,
            credits_deduction: t.deduction.credits,
            card_deduction: t.deduction.card,
            form_contents: t.form_contents()
        }, function (n) {
            e.is_submiting = !1, e.go("/branches/" + t.branch_id + "/order_success/" + n.order.id + "/reservation", !1)
        })))
    }, t.go_to_reservation_products = function () {
        s.set(t.user), e.go("/branches/" + t.branch_id + "/products/reservation")
    }
}]).controller("newGrouponOrderController", ["$rootScope", "$scope", "$timeout", "BaseNewOrderController", "GrouponOrderService", function (e, t, n, r, i) {
    e.header_title = "\u56e2\u8d2d\u8ba2\u5355", t.cart_type = "groupon", r.action(t, function () {
    }), t.errors = function () {
        var e = t.base_errors();
        return t.flatten_errors([e, o()])
    };
    var o = function () {
        var e = [];
        return t.cart && t.cart.total > 0 || e.push("\u60a8\u8fd8\u672a\u9009\u62e9\u4ea7\u54c1"), e
    };
    t.can_submit = function () {
        return t.base_can_submit() && t.cart && t.cart.total > 0
    }, t.submit = function () {
        var n = t.errors();
        return n.length > 0 ? void e.$emit("events:receive_errors", n) : void(t.can_submit() && (e.is_submiting = !0, i.create(t.branch_id, {
            note: t.note,
            pay_method: t.current_pay_method.value,
            credits_deduction: t.deduction.credits,
            card_deduction: t.deduction.card
        }, function (n) {
            e.is_submiting = !1, e.go("/branches/" + t.branch_id + "/order_success/" + n.order.id + "/groupon", !1)
        })))
    }
}]).controller("newRechargeOrderController", ["$rootScope", "$scope", "$timeout", "BaseNewOrderController", "RechargeOrderService", function (e, t, n, r, i) {
    e.header_title = "\u5145\u503c\u8ba2\u5355", t.cart_type = "recharge", r.action(t, function () {
    }), t.errors = function () {
        var e = t.base_errors();
        return t.flatten_errors([e, o()])
    };
    var o = function () {
        var e = [];
        return t.cart && t.cart.total > 0 || e.push("\u60a8\u8fd8\u672a\u9009\u62e9\u4ea7\u54c1"), e
    };
    t.can_submit = function () {
        return t.base_can_submit() && t.cart && t.cart.total > 0
    }, t.submit = function () {
        var n = t.errors();
        return n.length > 0 ? void e.$emit("events:receive_errors", n) : void(t.can_submit() && (e.is_submiting = !0, i.create(t.branch_id, {
            note: t.note,
            pay_method: t.current_pay_method.value,
            credits_deduction: t.deduction.credits,
            card_deduction: t.deduction.card
        }, function (n) {
            e.is_submiting = !1, e.go("/branches/" + t.branch_id + "/order_success/" + n.order.id + "/recharge", !1)
        })))
    }
}]).factory("BaseNewOrderController", ["$rootScope", "$routeParams", "BaseCartService", "BranchService", "CartAction", "SnapCartService", "ShopService", "UserService", "BaseOrderService", function (e, t, n, r, i, o, a, s, c) {
    function l(c, l) {
        function u() {
            var e = c.cart.total;
            return "reservation" == c.cart_type && (e = parseFloat(c.cart.total) * c.cart.table_zone.reservation_price_percent / 100), e
        }

        c.branch_id = t.branch_id, c.branch = null, c.cart = null, c.pay_method_setting = {}, c.pay_methods = [], c.current_pay_method = null, c.user = null, c.deduction = {}, i.action(c), c.change_pay_method = function (t) {
            "vip_card_pay" === t.value ? c.user.is_vip ? e.password_modal.open(function () {
                c.current_pay_method = t
            }) : e.$emit("events:receive_errors", "\u5bf9\u4e0d\u8d77\uff0c \u60a8\u8fd8\u4e0d\u662f\u4f1a\u5458, \u5982\u60f3\u7533\u8bf7\u4f1a\u5458\u53ef\u5728\u7528\u6237\u4e2d\u5fc3\u4e0b\u7684\u4f1a\u5458\u5361\u4e2d\u7533\u8bf7") : c.current_pay_method = t
        }, c.base_errors = function () {
            var e = [];
            return c.current_pay_method || e.push("\u8bf7\u9009\u62e9\u652f\u4ed8\u65b9\u5f0f"), !c.deduction.credits || c.deduction.credits > 0 && c.deduction.credits <= parseFloat(c.user.credits_wallet) || e.push("\u79ef\u5206\u62b5\u6263\u4e0d\u5408\u6cd5"), !c.deduction.card || c.deduction.card > 0 && c.deduction.card <= parseFloat(c.user.card_wallet) || e.push("\u4f59\u989d\u62b5\u6263\u4e0d\u5408\u6cd5"), e
        }, c.base_can_submit = function () {
            return !e.is_submiting && c.current_pay_method && (!c.deduction.credits || c.deduction.credits > 0 && c.deduction.credits <= parseFloat(c.user.credits_wallet)) && (!c.deduction.card || c.deduction.card > 0 && c.deduction.card <= parseFloat(c.user.card_wallet))
        }, s.refresh(function (e) {
            c.user = e
        }), a.get(function (e) {
            c.enable_foreign = e.enable_foreign
        }), r.get({id: c.branch_id}, function (e) {
            c.branch = e, c.pay_method_setting = e.pay_method_setting[c.cart_type], c.pay_methods = a.get_pay_methods(c.pay_method_setting), c.form_elements = c.branch.form_elements.filter(function (e) {
                return -1 != e.support_order_types.indexOf(c.cart_type)
            }), n.get(c.cart_type, c.branch_id, function (e) {
                c.cart = e, l && l()
            }), r.calculate_distance_of_branch(c.branch, function (e) {
                c.branch.distance = e
            })
        }), e.$on("cart:change", function (e, t) {
            c.cart = t, o.set_cart(c.cart_type, c.branch_id, t)
        }), c.form_contents = function () {
            var e = [];
            return $.each(c.form_elements, function () {
                e.push(this.record)
            }), e
        };
        var d = function (e, t) {
            if (t.longitude && t.latitude) {
                var n = geolib.getDistance({latitude: e.latitude, longitude: e.longitude}, {
                    latitude: t.latitude,
                    longitude: t.longitude
                });
                return n
            }
            return void 0
        };
        c.is_distance_of_branch_to_address_valid = function (e) {
            var t = [];
            return c.enable_foreign || e.latitude && e.longitude || (e.latitude = c.user.last_latitude, e.longitude = c.user.last_longitude), distance = d(c.branch, e), c.enable_foreign && void 0 == distance && !c.branch.support_order_if_not_in_delivery_radius && t.push("\u8bf7\u7f16\u8f91\u60a8\u7684\u6536\u8d27\u5730\u5740\uff0c\u5e76\u4e3a\u5176\u6807\u6ce8\u4f4d\u7f6e"), distance && distance > 1e3 * c.branch.delivery_radius && !c.branch.support_order_if_not_in_delivery_radius && t.push("\u60a8\u7684\u6536\u8d27\u5730\u5740\u5df2\u7ecf\u8d85\u8fc7\u6211\u4eec\u7684\u914d\u9001\u8303\u56f4: " + c.branch.delivery_radius + " \u516c\u91cc"), t
        }, c.is_form_contents_valid = function () {
            var e = [];
            return $.each(c.form_elements, function () {
                "undefined" == typeof this.record.content && (this.record.content = "");
                var t = $.trim(this.record.content);
                this.need && "" === t && e.push(this.label + "\u4e0d\u80fd\u4e3a\u7a7a")
            }), e
        }, c.flatten_errors = function (e) {
            var t = [];
            return angular.forEach(e, function (e) {
                angular.forEach(e, function (e) {
                    t.push(e)
                })
            }), t
        }, c.deduction_credits = function () {
            var e = u();
            c.deduction.credits = parseFloat(c.user.credits_wallet) >= 100 * parseFloat(e) ? 100 * parseFloat(e) : parseFloat(c.user.credits_wallet)
        }, c.deduction_password_authenticate = function () {
            e.password_modal.open(function () {
                var e = u();
                c.deduction.card = parseFloat(parseFloat(c.user.card_wallet) >= parseFloat(e) ? e : user_amount)
            })
        }
    }

    var u = function (r, i) {
        r.coupons = [], r.cart.coupon && (r.coupons.unshift(r.cart.coupon), r.current_coupon = r.cart.coupon);
        var o = {id: 0, name: "\u4e0d\u4f7f\u7528\u4f18\u60e0\u5238", coupon_no: null, coupon_min_usable_amount: 0};
        r.coupons.unshift(o), null == r.current_coupon && (r.current_coupon = o), c.association_domains(i, t.branch_id, function (e) {
            r.coupons = r.coupons.concat(e.coupons)
        }), r.apply_coupon = function () {
            parseFloat(r.current_coupon.coupon_min_usable_amount) > parseFloat(r.cart.total) && (r.current_coupon = o, e.alert("\u5f53\u524d\u4f18\u60e0\u5238\u7684\u6700\u5c0f\u4f7f\u7528\u91d1\u989d\u5927\u4e8e\u8ba2\u5355\u603b\u4ef7 \u4e0d\u80fd\u4f7f\u7528")), n.apply_coupon(i, t.branch_id, r.current_coupon.id, function (e) {
                r.cart = e
            })
        }, r.get_coupon_label = function (e) {
            var t = e.name;
            return null != e.coupon_no && (t += " " + coupon_no), t
        }
    };
    return {use_coupon_setting: u, action: l}
}]), Diandanbao.module("diandanbao_app.controllers.order_append_itemable", []).controller("orderAppendItemableController", ["$rootScope", "$scope", "$routeParams", "BranchService", "BaseOrderService", "ProductService", "CategoryService", function (e, t, n, r, i, o, a) {
    function s() {
        t.update_variant_quantity(t.cart), t.update_category_quantity(t.cart)
    }

    function c(e) {
        var t = 0, n = 0;
        return angular.forEach(e.line_items, function (e) {
            t += e.quantity * parseFloat(e.price), n += e.quantity
        }), e.total = t, e.item_count = n, t
    }

    touchScroll("#category-list-div"), touchScroll("#product-list-div"), t.header_title = "\u8ffd\u52a0\u5546\u54c1", t.branch_id = n.branch_id, t.order_type = n.order_type, t.order_id = n.order_id, t.branch = null, t.categories = [], t.active_category = null, t.active_sub_category = null, t.all_variants = [], t.cart = {line_items: []}, r.get({id: t.branch_id}, function (e) {
        t.branch = e
    }), i.get(t.order_type, t.branch_id, t.order_id, function (e) {
        t.order = e
    }), a.query(t.branch_id, t.order_type, function (e) {
        t.categories = e, t.active_category = t.categories[0], t.active_category && t.query_products()
    }), t.query_products = function () {
        var e = t.active_sub_category || t.active_category;
        e.products ? t.products = e.products : o.query({
            branch_id: t.branch_id,
            order_type: t.order_type,
            category_id: e.id
        }, function (n) {
            e.products = n, angular.forEach(n, function (e) {
                e.active_variant = 1 == e.variants.length ? e.variants[0] : e.variants[1], angular.forEach(e.variants, function (e) {
                    t.all_variants.push(e)
                })
            }), t.products = n, t.cart && (t.update_variant_quantity(t.cart), t.update_category_quantity(t.cart))
        })
    }, t.active_variant = function (e, t) {
        e.active_variant = t
    }, t.change_active_category = function (e) {
        t.active_category = e, t.active_sub_category = null, t.query_products()
    }, t.change_sub_categroy = function (e) {
        t.active_sub_category = e, t.query_products()
    }, t.update_variant_quantity = function (e) {
        angular.forEach(e.line_items, function (e) {
            angular.forEach(t.all_variants, function (t) {
                t.itemable_type == e.itemable_type && t.itemable_id == e.itemable_id && (t.quantity = e.quantity)
            })
        })
    }, t.update_category_quantity = function (e) {
        angular.forEach(t.categories, function (t) {
            t.quantity = 0, angular.forEach(e.line_items, function (e) {
                var n = e.category_ids.filter(function (e) {
                    return -1 != t.all_ids.indexOf(e)
                });
                n.length > 0 && (t.quantity += e.quantity || 0)
            })
        })
    }, t.can_submit = function () {
        return t.cart.total && t.cart.total > 0
    }, t.submit = function () {
        if (t.can_submit()) {
            var n = [];
            angular.forEach(t.cart.line_items, function (e) {
                n.push({variant_id: e.itemable_id, quantity: e.quantity})
            }), i.append_itemables(t.order_type, t.branch_id, t.order_id, n, function () {
                e.go("/branches/" + t.branch_id + "/orders/" + t.order_type + "/" + t.order_id)
            })
        }
    }, t.add_itemable = function (e) {
        if (t.need_check_stock(e)) {
            if ("undefined" == typeof e.quantity && e.stock_quantity - 1 <= 0)return;
            if (e.stock_quantity - e.quantity <= 0)return
        }
        var n = !0;
        if (angular.forEach(t.cart.line_items, function (t) {
                n && t.itemable_type == e.itemable_type && t.itemable_id == e.itemable_id && (t.quantity++, n = !1)
            }), n) {
            var r = {
                itemable_type: e.itemable_type,
                itemable_id: e.itemable_id,
                stock_quantity: e.stock_quantity,
                quantity: 1,
                price: e.price,
                name: e.name,
                category_ids: e.category_ids
            };
            t.cart.line_items.push(r)
        }
        c(t.cart), s()
    }, t.remove_itemable = function (e) {
        var n = !0;
        angular.forEach(t.cart.line_items, function (t) {
            n && t.itemable_type == e.itemable_type && t.itemable_id == e.itemable_id && (t.quantity > 0 && t.quantity--, n = !1)
        }), c(t.cart), s()
    }, t.stock_of = function (e) {
        return void 0 == e.quantity ? e.stock_quantity : e.stock_quantity - e.quantity
    }, t.can_minus = function (e) {
        return e.quantity > 0
    }, t.can_plus = function (e) {
        return t.need_check_stock(e) ? t.stock_of(e) > 0 ? !0 : !1 : !0
    }, t.need_check_stock = function (e) {
        return (t.check_stock || t.branch && t.branch.check_stock) && "Diandanbao::Variant" == e.itemable_type
    }
}]),Diandanbao.module("diandanbao_app.controllers.order_comment", []).controller("orderCommentController", ["$rootScope", "$scope", "OrderCommentController", function (e, t) {
    t.header_title = "\u8ba2\u5355\u8bc4\u8bba"
}]).controller("newOrderCommentController", ["$rootScope", "$scope", "$routeParams", "OrderCommentService", function (e, t, n, r) {
    t.header_title = "\u8ba2\u5355\u8bc4\u8bba", t.comment = {content: "", rating: 5}, t.change_rating = function (e) {
        var n = jQuery(".fa.rating-star");
        n.slice(0, e).each(function (e, t) {
            $(t).removeClass("fa-star-o").addClass("fa-star")
        }), n.slice(e).each(function (e, t) {
            $(t).removeClass("fa-star").addClass("fa-star-o")
        }), t.comment.rating = e
    }, t.can_submit = function () {
        return t.comment.content
    }, t.submit = function () {
        t.can_submit() && r.create(n.branch_id, n.order_id, t.comment, function () {
            t.$emit("events:success_info", "\u6210\u529f\u53d1\u8868\u8bc4\u8bba"), e.go("/user/profile")
        })
    }
}]),angular.module("diandanbao_app.controllers.order", []).controller("deliveryOrderController", ["$rootScope", "$scope", "$location", "$interval", "BaseOrderController", "DeliveryOrderService", "HastenController", function (e, t, n, r, i, o, a) {
    t.header_title = "\u5916\u5356\u8ba2\u5355", t.order_type = "delivery", i.action(t, function () {
        a.action(t, o), t.$on("destroy", function () {
            r.cancel(t.hasten_countdown_stop)
        })
    }), t.can_track_deliveryman = function () {
        return !0
    }, t.deliveryman_location = function () {
        o.refresh_location(t.branch_id, t.order_id, function (n) {
            t.order.deliveryman_location = n, t.order.deliveryman_location.latitude ? e.go("/branches/{branch_id}/orders/delivery/{order_id}/deliveryman_location".supplant({
                branch_id: t.branch_id,
                order_id: t.order_id
            })) : e.$emit("events:receive_errors", "\u5f53\u524d\u8ba2\u5355\u6ca1\u6709\u914d\u9001\u4fe1\u606f")
        })
    }
}]).controller("eatInHallOrderController", ["$rootScope", "$scope", "$interval", "BaseOrderController", "EatInHallOrderService", "HastenController", function (e, t, n, r, i, o) {
    t.header_title = "\u5802\u70b9\u8ba2\u5355", t.order_type = "eat_in_hall", r.action(t, function () {
        o.action(t, i), t.order.last_call_waiter_at_before_now && (t.call_waiter_countdown_stop = n(function () {
            t.order.last_call_waiter_at_before_now++, t.order.last_call_waiter_at_before_now >= 300 && (t.order.last_call_waiter_at_before_now = void 0, n.cancel(t.call_waiter_countdown_stop))
        }, 1e3)), t.$on("$destroy", function () {
            n.cancel(t.hasten_countdown_stop), n.cancel(t.call_waiter_countdown_stop)
        }), t.can_call_waiter = function () {
            return -1 != t.permissions.indexOf("call_waiter") && t.order && t.can_service()
        }, t.can_call_waiter_now = function () {
            return t.can_call_waiter() && !t.order.last_call_waiter_at_before_now
        }, t.call_waiter_countdown = function () {
            if (t.order.last_call_waiter_at_before_now) {
                var e = 300 - t.order.last_call_waiter_at_before_now;
                return "" + Math.floor(e / 60) + ":" + ("0" + e % 60).slice(-2)
            }
        }, t.choose_waiter_service_item = !1, t.show_options = function (e) {
            t.can_call_waiter_now() && (t.choose_waiter_service_item = null != e ? e : t.choose_waiter_service_item ? !1 : !0)
        }, t.call_waiter = function (n) {
            t.can_call_waiter_now() && i.call_waiter(t.branch_id, t.order_id, n, function () {
                t.show_options(!1), t.$emit("events:success_info", "\u547c\u53eb\u670d\u52a1\u5458\u6210\u529f, \u8bf7\u8010\u5fc3\u7b49\u5f85..."), e.reload()
            })
        }
    })
}]).controller("reservationOrderController", ["$rootScope", "$scope", "BaseOrderController", "DiandanbaoConst", function (e, t, n, r) {
    t.header_title = "\u9884\u8ba2\u8ba2\u5355", t.order_type = "reservation", n.action(t, function () {
        e.shareRecordTrigger = {
            triggerBeforeCreateRecord: function (e, n) {
                var i = "/branches/{branch_id}/orders/invitation/{order_id}".supplant({
                    branch_id: t.branch_id,
                    order_id: t.order_id
                }), o = UrlParser.change_parameter(n.link, "_ng_path", i);
                angular.extend(n, {
                    title: "\u9080\u8bf7\u51fd",
                    desc: "\u6211\u5728" + t.branch.name + "\u9884\u8ba2\u4e86\u5ea7\u4f4d\uff0c\u9080\u60a8\u4e00\u5757\u4e3e\u676f\u5171\u805a\u5427",
                    imgUrl: window.location.origin + "/assets/diandanbao/yao.png",
                    link: UrlParser.change_parameter(r.oauth_user_info_url, "redirect_uri", encodeURIComponent(o))
                })
            }
        }, t.go_invitation_order = function () {
            e.go("/branches/{branch_id}/orders/invitation/{order_id}".supplant({
                branch_id: t.branch_id,
                order_id: t.order_id
            }))
        }
    })
}]).controller("grouponOrderController", ["$rootScope", "$scope", "BaseOrderController", function (e, t, n) {
    t.header_title = "\u56e2\u8d2d\u8ba2\u5355", t.order_type = "groupon", n.action(t, function () {
    })
}]).controller("rechargeOrderController", ["$rootScope", "$scope", "BaseOrderController", function (e, t, n) {
    t.header_title = "\u5145\u503c\u8ba2\u5355", t.order_type = "recharge", n.action(t, function () {
    })
}]).controller("paymentOrderController", ["$rootScope", "$scope", "BaseOrderController", function (e, t, n) {
    t.header_title = "\u4e70\u5355\u8ba2\u5355", t.order_type = "payment", n.action(t, function () {
    })
}]).controller("orderSuccessController", ["$rootScope", "$scope", "$routeParams", "BaseOrderController", function (e, t, n, r) {
    t.header_title = "\u8ba2\u5355\u5df2\u63d0\u4ea4", t.order_type = n.order_type, t.branch_id = n.branch_id, t.order_id = n.order_id, r.action(t, function () {
    })
}]).factory("HastenController", ["$rootScope", "$interval", function (e, t) {
    function n(n, r) {
        n.order.last_hasten_at_before_now && (n.hasten_countdown_stop = t(function () {
            n.order.last_hasten_at_before_now++, n.order.last_hasten_at_before_now >= 300 && (n.order.last_hasten_at_before_now = void 0, t.cancel(n.hasten_countdown_stop))
        }, 1e3)), n.can_service = function () {
            return ["pending", "confirmed", "merged"].indexOf(n.order.state) >= 0
        }, n.can_hasten = function () {
            return -1 != n.permissions.indexOf("hasten") && n.order && n.can_service()
        }, n.can_hasten_now = function () {
            return n.can_hasten() && !n.order.last_hasten_at_before_now
        }, n.hasten_countdown = function () {
            if (n.order.last_hasten_at_before_now) {
                var e = 300 - n.order.last_hasten_at_before_now;
                return "" + Math.floor(e / 60) + ":" + ("0" + e % 60).slice(-2)
            }
        }, n.hasten = function () {
            n.can_hasten_now() && r.hasten(n.branch_id, n.order_id, function () {
                n.$emit("events:success_info", "\u50ac\u5355\u6210\u529f, \u8bf7\u8010\u5fc3\u7b49\u5f85..."), e.reload()
            })
        }
    }

    return {action: n}
}]).factory("BaseOrderController", ["$rootScope", "$routeParams", "$window", "BaseOrderService", "BranchService", "ShopService", "DiandanbaoConst", function (e, t, n, r, i, o, a) {
    function s(s, c) {
        s.branch_id = t.branch_id, s.order_id = t.order_id, s.order = null, s.permissions = [], o.get(function (e) {
            s.enable_foreign = e.enable_foreign
        }), i.get({id: s.branch_id}, function (e) {
            s.branch = e, r.get(s.order_type, s.branch_id, s.order_id, function (e) {
                s.order = e, c && c()
            })
        }), r.get_permissions(s.order_type, s.branch_id, s.order_id, function (e) {
            s.permissions = e.permissions
        }), s.can_cancel = function () {
            return -1 != s.permissions.indexOf("cancel") && s.order && "pending" == s.order.state && "completed" != s.order.payment_state
        }, s.can_pay_online = function () {
            return -1 != s.permissions.indexOf("pay_online") && s.order && "canceled" != s.order.state && ["pending", "processing", "checkout"].indexOf(s.order.payment_state) >= 0
        }, s.can_confirm = function () {
            return -1 != s.permissions.indexOf("confirm") && s.order && "pending" == s.order.state
        }, s.can_complete = function () {
            return -1 != s.permissions.indexOf("complete") && s.order && "confirmed" == s.order.state
        }, s.can_exchange_code = function () {
            return -1 != s.permissions.indexOf("exchange_code") && s.order && s.order.exchange_code_id && ["pending", "confirmed"].indexOf(s.order.state) >= 0 && ["reservation"].indexOf(s.order_type) >= 0
        }, s.can_append_itemable = function () {
            return -1 != s.permissions.indexOf("append_itemable") && s.order
        }, s.go_append_itemable = function () {
            e.go("/branches/" + s.branch_id + "/orders/" + s.order_id + "/" + s.order_type + "/append_itemable")
        }, s.cancel = function () {
            s.can_cancel() && r.cancel(s.order_type, s.branch_id, s.order_id, function () {
                e.reload()
            })
        }, s.can_ask_for_invoice = function () {
            return s.branch && s.branch.support_invoice && s.order && "canceled" != s.order.state && null == s.order.invoice
        }, s.ask_for_invoice = function () {
            e.go("/branches/" + s.branch_id + "/orders/" + s.order_type + "/" + s.order_id + "/invoice")
        }, s.confirm = function () {
            s.can_confirm() && r.confirm(s.order_type, s.branch_id, s.order_id, function () {
                e.reload()
            })
        }, s.complete = function () {
            s.can_complete() && r.complete(s.order_type, s.branch_id, s.order_id, function () {
                e.reload()
            })
        }, s.go_exchange_code = function () {
            e.go("/exchange_codes/" + s.order.exchange_code_id)
        };
        var l = function (e) {
            wx.chooseWXPay({
                timestamp: e.timeStamp,
                nonceStr: e.nonceStr,
                "package": e.package,
                paySign: e.paySign,
                success: function () {
                    s.$emit("events:success_info", "\u652f\u4ed8\u6210\u529f\uff0c\u7b49\u5f853\u79d2\u540e\u8fd4\u56de... ...")
                },
                fail: function () {
                    alert("\u652f\u4ed8\u5931\u8d25\uff0c\u8bf7\u68c0\u67e5\u9519\u8bef\u6216\u8005\u91cd\u65b0\u5c1d\u8bd5\uff01")
                },
                cancel: function () {
                    alert("\u652f\u4ed8\u53d6\u6d88\uff01")
                }
            })
        }, u = function () {
            window.location.href = a.baseUrl + "?act=invoke_wechatpay_v3&order_id=" + s.order_id
        };
        s.pay_online = function () {
            s.can_pay_online() && r.get_pay_online(s.order_type, s.branch_id, s.order_id, function (e) {
                switch (e.method) {
                    case"alipay":
                        $("body").replaceWith("<body><iframe src='" + e.data + "' height='100%' width='100%'></iframe></body>");
                        break;
                    case"baidupay":
                        n.location.href = e.data;
                        break;
                    case"wechatpay":
                        switch (e.data_type) {
                            case"NATIVE":
                                alert("events:receive_errors", "\u4e0d\u5e94\u8be5\u4f7f\u7528 NATIVE \u65b9\u5f0f\u7684\u5fae\u4fe1\u652f\u4ed8");
                                break;
                            case"JSAPI":
                                "legacy" == e.version ? l(e.data) : u(e.data)
                        }
                        break;
                    case"exception":
                        alert("\u5fae\u4fe1\u652f\u4ed8\u51fa\u9519\u4e86\uff01\u8bf7\u68c0\u67e5\u540e\u53f0\u5fae\u4fe1\u652f\u4ed8\u53c2\u6570\u8bbe\u7f6e\u662f\u5426\u6b63\u786e.\n" + JSON.stringify(e.data))
                }
            })
        }
    }

    return {action: s}
}]),angular.module("diandanbao_app.controllers.orders", []).controller("ordersNavController", ["$rootScope", "$scope", function (e) {
    e.header_title = "\u8ba2\u5355\u4e2d\u5fc3"
}]).controller("deliveryOrdersController", ["$rootScope", "$scope", "BaseOrdersController", function (e, t, n) {
    e.header_title = "\u5916\u5356\u8ba2\u5355", t.order_type = "delivery", n.action(t, function () {
    })
}]).controller("reservationOrdersController", ["$rootScope", "$scope", "BaseOrdersController", function (e, t, n) {
    e.header_title = "\u9884\u8ba2\u8bb0\u5f55", t.order_type = "reservation", n.action(t, function () {
    })
}]).controller("eatInHallOrdersController", ["$rootScope", "$scope", "BaseOrdersController", function (e, t, n) {
    e.header_title = "\u70b9\u5355\u8bb0\u5f55", t.order_type = "eat_in_hall", n.action(t, function () {
    })
}]).controller("grouponOrdersController", ["$rootScope", "$scope", "BaseOrdersController", function (e, t, n) {
    e.header_title = "\u56e2\u8d2d\u8bb0\u5f55", t.order_type = "groupon", n.action(t, function () {
    })
}]).controller("rechargeOrdersController", ["$rootScope", "$scope", "BaseOrdersController", function (e, t, n) {
    e.header_title = "\u5145\u503c\u8bb0\u5f55", t.order_type = "recharge", n.action(t, function () {
    })
}]).controller("paymentOrdersController", ["$rootScope", "$scope", "BaseOrdersController", function (e, t, n) {
    e.header_title = "\u4e70\u5355\u8bb0\u5f55", t.order_type = "payment", n.action(t, function () {
    })
}]).factory("BaseOrdersController", ["$rootScope", "$routeParams", "BaseUserOrderService", function (e, t, n) {
    function r(t) {
        var r = function (e) {
            return e.filter(function (e) {
                return "completed" == e.state && !e.is_commented
            })
        };
        t.orders = [], n.query(t.order_type, function (e) {
            t.orders = e, t.all_orders = e, t.no_comments = r(e)
        }), t.tab_key = "all", t.change_filter_tab = function (e) {
            t.tab_key = e, t.orders = "no-comments" == e ? t.no_comments : t.all_orders
        }, t.go_detail = function (n) {
            e.go("/branches/" + n.branch_id + "/orders/" + t.order_type + "/" + n.id)
        }, t.go_new_comment = function (t) {
            e.go("/branches/" + t.branch_id + "/orders/" + t.id + "/comment/new")
        }
    }

    return {action: r}
}]),angular.module("diandanbao_app.controllers.pay_online", []).controller("newPayOnlineController", ["$rootScope", "$scope", "$routeParams", "ShopService", "BranchService", "PaymentOrderService", function (e, t, n, r, i, o) {
    t.branch_id = n.branch_id, t.shop = null, t.payment_methods = [], i.get({id: t.branch_id}, function (n) {
        t.branch = n, e.header_title = n.name
    }), r.get(function (e) {
        t.shop = e, e.is_support_alipay && t.payment_methods.push({
            name: "\u652f\u4ed8\u5b9d",
            value: "alipay"
        }), e.is_support_wechatpay && t.payment_methods.push({
            name: "\u5fae\u4fe1\u652f\u4ed8",
            value: "wechatpay"
        }), e.is_support_baidupay && t.payment_methods.push({
            name: "\u767e\u5ea6\u94b1\u5305",
            value: "baidupay"
        }), t.active_payment_method = t.payment_methods[0]
    }), t.choose_payment_method = function (e) {
        t.active_payment_method = e
    }, t.can_submit = function () {
        return t.active_payment_method && t.amount > 0
    }, t.submit = function () {
        t.can_submit() && o.create(t.branch_id, {
            amount: t.amount,
            payment_method: t.active_payment_method.value
        }, function (n) {
            n.order && n.order.id && e.go("/branches/" + t.branch_id + "/orders/payment/" + n.order.id)
        })
    }
}]),angular.module("diandanbao_app.controllers.product", []).controller("deliveryProductsController", ["$rootScope", "$scope", "BaseProductsController", function (e, t, n) {
    t.cart_type = "delivery", n.action(t, function () {
        0 != t.branch.receive_delivery_order_within_days || t.branch.delivery_today_can_order || (e.alert("\u5916\u9001\u65f6\u95f4\u5df2\u8fc7, \u8bf7\u660e\u5929\u518d\u6765"), e.back())
    }), t.reasons = function () {
        var e = [];
        return t.branch && t.branch.is_in_service || e.push("\u8be5\u5546\u5bb6\u8fd8\u672a\u8425\u4e1a"), t.cart && t.cart.total > 0 || e.push("\u60a8\u8fd8\u672a\u9009\u62e9\u4ea7\u54c1"), t.cart.total >= parseFloat(t.branch.support_delivery_if_amount_gt) || e.push("\u6700\u4f4e " + t.currency + t.branch.support_delivery_if_amount_gt + " \u8d77\u9001"), e
    }, t.can_submit = function () {
        return t.branch && t.branch.is_in_service && t.cart && t.cart.total > 0 && t.cart.total >= parseFloat(t.branch.support_delivery_if_amount_gt)
    }
}]).controller("eatInHallProductsController", ["$rootScope", "$scope", "BaseProductsController", function (e, t, n) {
    t.cart_type = "eat_in_hall", n.action(t, function () {
        t.cart.table_id || e.go("/branches/" + t.branch_id)
    }), t.reasons = function () {
        var e = [];
        return t.cart && t.cart.total > 0 || e.push("\u60a8\u8fd8\u672a\u9009\u62e9\u4ea7\u54c1"), e
    }, t.can_submit = function () {
        return t.cart && t.cart.total > 0
    }
}]).controller("reservationProductsController", ["$rootScope", "$scope", "BaseProductsController", function (e, t, n) {
    t.cart_type = "reservation", n.action(t, function () {
        t.cart.reservation_date_str && t.cart.reservation_time_point_str || e.go("/branches/" + t.branch_id + "/reservation_time_points")
    }), t.reasons = function () {
        var e = [];
        return t.cart && t.cart.total >= t.cart.table_zone.min_reservation_price || e.push("\u4e0d\u5f97\u4f4e\u4e8e\u8d77\u5b9a\u4ef7\uff1a " + t.currency + t.cart.table_zone.min_reservation_price), e
    }, t.can_submit = function () {
        return t.cart && t.cart.total >= t.cart.table_zone.min_reservation_price
    }
}]).factory("BaseProductsController", ["$rootScope", "$location", "$routeParams", "ProductService", "BranchService", "CategoryService", "CartAction", "SnapCartService", "UrlHelperService", "CategoryCache", function (e, t, n, r, i, o, a, s, c, l) {
    function u(t, c) {
        function u() {
            var e = t.get_category_cache();
            e.category_id && t.categories.some(function (n) {
                return n.id == e.category_id ? (t.active_category = n, e.sub_category_id && t.active_category.categories && t.active_category.categories.some(function (n) {
                    return n.id == e.sub_category_id ? (t.active_sub_category = n, !0) : void 0
                }), !0) : void 0
            })
        }

        touchScroll("#category-list-div"), touchScroll("#product-list-div"), t.notice_switch = !0, t.branch_id = n.branch_id, t.branch = null, t.categories = [], t.active_category = null, t.active_sub_category = null, t.all_variants = [], t.cart = null, a.action(t), i.get({id: n.branch_id}, function (e) {
            t.branch = e
        }), o.query(n.branch_id, t.cart_type, function (e) {
            t.categories = e, u(), t.active_category || (t.active_category = t.categories[0])
        }), t.query_products = function () {
            var e = t.active_sub_category || t.active_category;
            e.products ? (t.products = e.products, t.check_default_sub_category()) : r.query({
                branch_id: t.branch_id,
                order_type: t.cart_type,
                category_id: e.id,
                date: t.cart ? t.cart.reservation_date : null
            }, function (n) {
                e.products = n, angular.forEach(n, function (e) {
                    e.active_variant = 1 == e.variants.length ? e.variants[0] : e.variants[1], angular.forEach(e.variants, function (e) {
                        t.all_variants.push(e)
                    })
                }), t.products = n, t.cart && (t.update_variant_quantity(t.cart), t.update_category_quantity(t.cart)), t.check_default_sub_category()
            })
        }, t.check_default_sub_category = function () {
            0 == t.products.length && null == t.active_sub_category && t.active_category.categories.length > 0 && (t.active_sub_category = t.active_category.categories[0], t.query_products())
        }, t.active_variant = function (e, t) {
            e.active_variant = t
        }, t.toggle_notice_switch = function () {
            t.notice_switch = !t.notice_switch
        }, t.change_active_category = function (e) {
            t.active_category = e, t.active_sub_category = null, t.query_products()
        }, t.change_sub_categroy = function (e) {
            t.active_sub_category = e, t.query_products()
        }, t.is_show_default_sub_category = function (e) {
            return e && e.categories.length > 0 && e.products && e.products.length > 0
        }, t.update_variant_quantity = function (e) {
            angular.forEach(e.line_items, function (e) {
                angular.forEach(t.all_variants, function (t) {
                    t.itemable_type == e.itemable_type && t.itemable_id == e.itemable_id && (t.quantity = e.quantity)
                })
            })
        }, t.update_category_quantity = function (e) {
            angular.forEach(t.categories, function (t) {
                t.quantity = 0, angular.forEach(e.line_items, function (e) {
                    var n = e.category_ids.filter(function (e) {
                        return -1 != t.all_ids.indexOf(e)
                    });
                    n.length > 0 && (t.quantity += e.quantity || 0)
                })
            })
        }, e.$on("cart:snap:change", function (e, n) {
            t.update_variant_quantity(n), t.update_category_quantity(n), n && !t.cart ? (t.cart = n, c && c()) : t.cart = n, t.active_category && t.query_products()
        }), t.submit = function () {
            t.can_submit() ? s.update_cart(t.cart_type, t.branch_id, function () {
                e.go("/branches/" + t.branch_id + "/orders/" + t.cart_type + "/new", !1)
            }) : e.$emit("events:receive_errors", t.reasons())
        }, t.go_show_product_with_update = function (n) {
            t.cache_category(), s.update_cart(t.cart_type, t.branch_id, function () {
                e.go_show_product(n, t.cart_type)
            })
        }, t.go_search_product_with_update = function () {
            t.cache_category(), s.update_cart(t.cart_type, t.branch_id, function () {
                e.go_search_product(t.branch_id, t.cart_type)
            })
        }, t.go_combos = function () {
            t.cache_category(), s.update_cart(t.cart_type, t.branch_id, function () {
                e.go("/branches/" + t.branch_id + "/combos?order_type=" + t.cart_type)
            })
        }, t.cache_category = function () {
            l.put("category_id", t.active_category.id), t.active_sub_category && l.put("sub_category_id", t.active_sub_category.id)
        }, t.get_category_cache = function () {
            return {category_id: l.get("category_id"), sub_category_id: l.get("sub_category_id")}
        }
    }

    return {action: u}
}]).controller("productController", ["$rootScope", "$routeParams", "$location", "$scope", "ProductService", "BaseCartService", "CartAction", function (e, t, n, r, i, o, a) {
    e.header_title = "\u8be6\u60c5", r.branch_id = t.branch_id, r.product_id = t.product_id, r.product = null, r.master_variant = null, r.cart_type = n.search().cart_type || "delivery", a.action(r), i.get(r.branch_id, r.product_id, function (e) {
        r.product = e, r.product.rect_images = [], angular.forEach(e.images, function (e) {
            r.product.rect_images.push({img: e.rect_large_url})
        }), r.master_variant = r.product.variants[0], o.get(r.cart_type, r.branch_id, function (e) {
            r.cart = e, r.update_variant_quantity()
        })
    }), r.update_variant_quantity = function () {
        angular.forEach(r.product.variants, function (e) {
            e.quantity = 0, angular.forEach(r.cart.line_items, function (t) {
                "Diandanbao::Variant" == t.itemable_type && t.itemable_id == e.id && (e.quantity = t.quantity)
            })
        })
    }, e.$on("cart:change", function (e, t) {
        r.cart = t, r.update_variant_quantity()
    })
}]).controller("searchProductsController", ["$rootScope", "$scope", "$routeParams", "$location", "ProductService", "CartAction", "BaseCartService", function (e, t, n, r, i, o, a) {
    function s() {
        angular.forEach(t.products, function (e) {
            e.active_variant = 1 == e.variants.length ? e.variants[0] : e.variants[1]
        })
    }

    function c() {
        angular.forEach(t.products, function (e) {
            angular.forEach(e.variants, function (e) {
                e.quantity = 0, angular.forEach(t.cart.line_items, function (t) {
                    e.itemable_type == t.itemable_type && e.itemable_id == t.itemable_id && (e.quantity = t.quantity)
                })
            })
        })
    }

    e.header_title = "\u641c\u7d22", t.branch_id = n.branch_id, t.cart_type = r.search().cart_type, t.query_string = null, t.products = [], t.cart = null, o.action(t), a.get(t.cart_type, t.branch_id, function (e) {
        t.cart = e
    }), t.search = function () {
        t.query_string && i.query({
            branch_id: t.branch_id,
            order_type: t.cart_type,
            name: t.query_string
        }, function (e) {
            t.products = e, s(), c()
        })
    }, t.$watch("query_string", function () {
        t.search()
    }), t.active_variant = function (e, t) {
        e.active_variant = t
    }, e.$on("cart:change", function (e, n) {
        t.cart = n, c()
    }), t.clear_query_string = function () {
        t.query_string = null
    }
}]),angular.module("diandanbao_app.controllers.promotion", []).controller("promotionsController", ["$rootScope", "$scope", "PromotionService", function (e, t, n) {
    e.header_title = "\u4f18\u60e0\u4fc3\u9500", n.query(function (e) {
        t.promotions = e
    })
}]).controller("promotionController", ["$rootScope", "$scope", "$routeParams", "PromotionService", function (e, t, n, r) {
    e.header_title = "\u4f18\u60e0\u4fc3\u9500", t.promotion_id = n.promotion_id, r.get(t.promotion_id, function (e) {
        t.promotion = e
    })
}]),Diandanbao.module("diandanbao_app.controllers.recharge_products", []).controller("rechargeProductsController", ["$rootScope", "$scope", "$routeParams", "ShopService", "RechargeProductService", "RechargeCartService", function (e, t, n, r, i, o) {
    e.header_title = "\u5145\u503c", t.recharge_products = [], t.shop = null, i.query(function (e) {
        t.recharge_products = e, console.log(e)
    }), r.get(function (e) {
        t.shop = e
    }), t.select = function (n) {
        o.add_recharge_product(t.shop.abstract_branch_id, n.id, function () {
            e.go("/branches/" + t.shop.abstract_branch_id + "/orders/recharge/new")
        })
    }
}]),Diandanbao.controller("reservationTimePointsController", ["$rootScope", "$routeParams", "$scope", "BranchService", "TableZoneService", "ReservationDateService", "ReservationCartService", "SnapCartService", function (e, t, n, r, i, o, a, s) {
    e.header_title = "\u9884\u8ba2\u65f6\u95f4", n.branch_id = t.branch_id, n.branch = null, n.reservation_dates = 0, n.active_date = null, n.table_zones = [], r.get({id: n.branch_id}, function (e) {
        n.branch = e, n.reservation_dates = o.get(n.branch.reservation_setting.max_reservation_days), n.active_date = n.reservation_dates[0]
    }), i.query(n.branch_id, function (e) {
        n.table_zones = e
    }), n.select_date = function (e) {
        n.active_date = e
    }, n.show_date = function (e) {
        return Math.abs(e.position - n.active_date.position) <= 1
    }, n.go_new_reservation_order = function (t) {
        n.is_sale_out(t) || a.update(n.branch_id, {
            reservation_date: n.active_date.value,
            reservation_time_point_id: t.id
        }, function (t) {
            s.set_cart("reservation", n.branch_id, t), e.go("/branches/" + n.branch_id + "/orders/reservation/new")
        })
    }, n.is_sale_out = function (e) {
        return e.is_sale_outs[n.active_date.position]
    }
}]),angular.module("diandanbao_app.controllers.search", []).controller("searchController", ["$rootScope", "$scope", "$location", "SearchService", function (e, t, n, r) {
    function i(e) {
        var n = e.localId;
        wx.translateVoice({
            localId: n, isShowProgressTips: 1, success: function (e) {
                t.$apply(function () {
                    e.translateResult && (t.word = e.translateResult.replace("?", "").replace(".", "").replace("\u3002", ""))
                })
            }
        })
    }

    r.getSearchWord(function (e) {
        t.search_words = e
    }), setTimeout(function () {
        angular.element("input[type='text']:first-child").focus()
    }), t.$watch("word", function () {
        r.search(t.word, function (e) {
            t.branch_results = e
        })
    }), t.update = function (e) {
        t.word = e
    }, t.is_recording = !1, t.startRecord = function () {
        t.is_recording = !0, wx.startRecord({
            fail: function () {
                alert("\u7528\u6237\u62d2\u7edd\u6388\u6743\u5f55\u97f3")
            }
        })
    }, t.stopRecord = function () {
        t.is_recording = !1, wx.stopRecord({success: i})
    }, wx.stopRecord({
        success: function () {
            t.is_recording = !1
        }
    }), wx.onVoiceRecordEnd({complete: i})
}]),Diandanbao.controller("sharableCouponController", ["$rootScope", "$scope", "$routeParams", "SharableCouponService", function (e, t, n, r) {
    e.header_title = "\u9886\u53d6\u4f18\u60e0\u5238", t.sharable_coupon_id = n.sharable_coupon_id, r.get(t.sharable_coupon_id, function (n) {
        t.sharable_coupon = n, r.receive(t.sharable_coupon_id, function (n) {
            "ok" === n.status ? (t.sharable_coupon.receive_count += 1, t.coupon_received = !0, t.$emit("events:success_info", "\u606d\u559c\uff0c\u60a8\u6210\u529f\u62a2\u5230\u4e86\u4e00\u5f20\u4f18\u60e0\u5238(" + t.sharable_coupon.coupon_version_name + ")\uff0c\u53ef\u7528\u4e8e\u5728" + e.current_shop.name + "\u8fdb\u884c\u6d88\u8d39\u62b5\u6263\u54e6...")) : (t.coupon_received = !1, t.coupon_received_reason = n.errors)
        })
    })
}]),angular.module("diandanbao_app.controllers.shop", []).controller("shopController", ["$rootScope", "$scope", "$location", "ShopService", "PromotionService", "GeolocationService", function (e, t, n, r, i, o) {
    t.shop = null, t.custom_weixin_info = null, t.hot_links = [], t.usable_links = [], t.promotions = [], t.nav_group_size = 3, r.get(function (e) {
        t.shop = e, t.custom_weixin_info = e.custom_weixin_info, t.hot_links = t.custom_weixin_info.home_hot_links, "single" == t.shop.shop_type && (t.hot_links = t.shop.single_branch_links.concat(t.custom_weixin_info.home_hot_links)), "classic" == t.custom_weixin_info.layout_type && (t.nav_group_size = 4, t.usable_links = t.custom_weixin_info.home_usable_links)
    }), o.get_city_name(function (e) {
        t.city_name = e
    }), t.is_classic_layout = function () {
        return "classic" === t.custom_weixin_info.layout_type
    }, i.show_on_index(function (e) {
        t.promotions = e
    }), t.click_slider = function (e) {
        console.log(e)
    }
}]),angular.module("diandanbao_app.controllers.sign_record", []).controller("signRecordsController", ["$scope", "$rootScope", "SignRecordService", "UserService", function (e, t, n, r) {
    t.header_title = "\u6bcf\u65e5\u7b7e\u5230", e.user = null, e.load_time = new Date, r.get(function (t) {
        e.user = t
    }), e.can_sign = function () {
        return e.user && !e.user.today_signed
    }, e.sign = function () {
        e.can_sign() && n.sign(function (t) {
            t && (e.user.today_signed = !0, e.user.sign_records_count = t.sign_records_count, e.user.continuous_sign_count = t.continuous_sign_count)
        })
    }
}]),Diandanbao.module("diandanbao_app.controllers.tables", []).controller("tableController", ["$rootScope", "$scope", "$routeParams", "EatInHallCartService", "EatInHallOrderService", function (e, t, n, r, i) {
    t.branch_id = n.branch_id, t.table_id = n.table_id, i.get_order_by_table(t.branch_id, t.table_id, function (i) {
        console.log(i), console.log(n), i && i.id ? e.go("/branches/" + t.branch_id + "/orders/eat_in_hall/" + i.id) : r.update(t.branch_id, {table_id: t.table_id}, function () {
            e.go("/branches/" + t.branch_id + "/products/eat_in_hall")
        })
    })
}]),Diandanbao.module("diandanbao_app.controllers.tuans", []).controller("tuansController", ["$rootScope", "$scope", "$routeParams", "TuanService", "ShopService", "QueryService", "ZoneService", function (e, t, n, r, i, o, a) {
    t.tuans = [], t.branch_type_arrays = [], i.get(function (e) {
        t.shop = e, t.branch_type_arrays = [];
        var n = angular.copy(t.shop.branch_types, []);
        n.unshift({id: 0, image: null, bg_color: "#72C02C", icon: "fa-globe", name: "\u5168\u90e8\u7c7b\u578b"});
        for (var r = 4, i = 0; i < n.length; i += r)t.branch_type_arrays.push(n.slice(i, i + r))
    });
    var s = o.getCombineQuery();
    r.query(s, function (e) {
        t.tuans = e
    }), t.current_zone_id = parseInt(s["query[in_zone]"]) || 0, a.query({hierarchy: !0}, function (e) {
        if (t.zones = e, t.current_zone_id) {
            var n = !1;
            angular.forEach(t.zones, function (e) {
                if (!n) {
                    if (e.id == t.current_zone_id)return t.zone_name = e.name, void(n = !0);
                    angular.forEach(e.sub_zones, arguments.callee)
                }
            })
        }
        t.zones.unshift({id: 0, name: "\u5168\u90e8\u533a\u57df", parent_zone_id: null})
    }), t.filter_by_branch_type = function (t) {
        0 == t ? delete s["query[branch_branch_type_id_eq]"] : s["query[branch_branch_type_id_eq]"] = t, e.go("/tuans?" + o.buildQueryString(s))
    }, t.filter_by_zone = function (n) {
        0 == n ? delete s["query[in_zone]"] : s["query[in_zone]"] = n, n == t.current_zone_id && (t.active_select_zone = !t.active_select_zone), e.go("/tuans?" + o.buildQueryString(s))
    }
}]).controller("tuanController", ["$rootScope", "$scope", "$routeParams", "TuanService", "GrouponCartService", function (e, t, n, r, i) {
    t.tuan_id = n.tuan_id, r.get(t.tuan_id, function (e) {
        t.tuan = e
    }), t.add_tuan = function () {
        i.add_tuan(t.tuan.branch_id, t.tuan.id, function () {
            e.go("/branches/" + t.tuan.branch_id + "/orders/groupon/new")
        })
    }
}]),angular.module("diandanbao_app.controllers.user", []).controller("userController", ["$rootScope", "$scope", "$location", "UserService", "ShopService", function (e, t, n, r, i) {
    e.header_title = "\u7528\u6237\u4e2d\u5fc3", "/user/coupon_nav" === n.path() && (e.header_title = "\u5238\u5305\u4e2d\u5fc3"), r.get(function (e) {
        t.user = e
    }), t.apply_vip = function () {
        !t.user.vip_info || t.user.vip_info.name && t.user.vip_info.phone ? r.apply_vip(function () {
            e.$broadcast("events:success_info", "\u7533\u8bf7\u6210\u529f\uff0c\u7b49\u5f85\u5ba1\u6838"), t.user.vip_info.is_apply_vip = !0
        }) : e.confirm("\u8bf7\u5148\u586b\u5199\u4e2a\u4eba\u4fe1\u606f", "\u5728\u7533\u8bf7\u6210\u4f1a\u4f1a\u5458\u4e4b\u524d\uff0c\u8bf7\u5148\u5b8c\u5584\u60a8\u7684\u4e2a\u4eba\u4fe1\u606f", function () {
            n.path("/user/update-vip-info")
        })
    }, i.get(function (e) {
        t.has_tutorial = e.has_tutorial
    }), t.show_tutorial = UrlParser.change_parameter(window.location.href, "act", "show_tutorial").split("#")[0]
}]).controller("userUpdateVipInfoController", ["$rootScope", "$scope", "UserService", function (e, t, n) {
    e.header_title = "\u4fee\u6539\u4f1a\u5458\u4fe1\u606f", t.vip_info = {
        name: "",
        phone: "",
        sex: "",
        id_number: "",
        birthday: "",
        address: "",
        email: ""
    }, t.sex_collection = [{value: "male", name: "\u5148\u751f"}, {
        value: "female",
        name: "\u5973\u58eb"
    }], n.get(function (n) {
        t.user = n, t.vip_info.name = n.vip_info.name, t.vip_info.phone = n.vip_info.phone, t.vip_info.sex = n.vip_info.sex, t.vip_info.id_number = n.vip_info.id_number, t.vip_info.birthday = n.vip_info.birthday, t.vip_info.address = n.vip_info.address, t.vip_info.email = n.vip_info.email, t.user.is_vip || (e.header_title = "\u4fee\u6539\u7528\u6237\u4fe1\u606f")
    }), t.can_submit = function () {
        return !0
    }, t.submit = function () {
        t.can_submit() && n.update_vip_info(t.vip_info, function () {
            e.go("/user/vip-info")
        })
    }
}]).controller("userUpdatePayPasswordController", ["$rootScope", "$scope", "UserService", function (e, t, n) {
    e.header_title = "\u66f4\u6539\u652f\u4ed8\u5bc6\u7801", t.current_pay_password = "", t.new_pay_password = "", n.get(function (e) {
        t.user = e
    }), t.can_submit = function () {
        return t.new_pay_password
    }, t.submit = function () {
        t.can_submit() && n.update_pay_password(t.current_pay_password, t.new_pay_password, function (n) {
            t.user = n, e.$broadcast("events:success_info", "\u652f\u4ed8\u5bc6\u7801\u4fee\u6539\u6210\u529f"), e.go("/user/vip-info")
        })
    }
}]).controller("userBindVipController", ["$rootScope", "$scope", "UserService", function (e, t, n) {
    e.header_title = "\u7ed1\u5b9a\u4f1a\u5458", t.phone = "", t.password = "", n.get(function (e) {
        t.user = e
    }), t.can_submit = function () {
        return t.phone && t.password
    }, t.submit = function () {
        t.can_submit() && n.bind_vip(t.phone, t.password, function () {
            e.$broadcast("events:success_info", "\u7ed1\u5b9a\u4f1a\u5458\u6210\u529f"), e.go("/user/vip-info")
        })
    }
}]),Diandanbao.module("diandanbao_app.controllers.wechat_share_records", []).controller("wechatShareRecordsController", ["$rootScope", "$scope", "$routeParams", "WechatShareRecordService", function (e, t, n, r) {
    e.header_title = "\u6211\u7684\u5206\u4eab", r.query(function (e) {
        t.wechat_share_records = e
    })
}]).controller("wechatShareRecordController", ["$rootScope", "$scope", "$routeParams", "WechatShareRecordService", function (e, t, n, r) {
    e.header_title = "\u5206\u4eab\u8be6\u60c5", r.get(n.wechat_share_record_id, function (e) {
        t.wechat_share_record = e
    })
}]),angular.module("diandanbao", Diandanbao.buildAppDependencies(["ngRoute", "ngResource", "ngSanitize", "rn-lazy", "diandanbao_app.filters.filter", "diandanbao_app.directives.swiper_slider", "diandanbao_app.directives.include-replace", "diandanbao_app.directives.modal", "diandanbao_app.directives.bg_image", "diandanbao_app.directives.cart_btn", "diandanbao_app.directives.footer_cart", "diandanbao_app.directives.comment", "diandanbao_app.directives.branch_list", "diandanbao_app.route_config", "diandanbao_app.constants", "diandanbao_app.controllers.shop", "diandanbao_app.controllers.article", "diandanbao_app.services.promotion", "diandanbao_app.controllers.promotion", "diandanbao_app.services.product", "diandanbao_app.controllers.product", "diandanbao_app.controllers.orders", "diandanbao_app.controllers.order", "diandanbao_app.controllers.new_order", "diandanbao_app.controllers.pay_online", "diandanbao_app.controllers.address", "diandanbao_app.controllers.invoice", "diandanbao_app.services.user", "diandanbao_app.controllers.user", "diandanbao_app.services.guest_queue", "diandanbao_app.controllers.guest_queue", "diandanbao_app.services.comment", "diandanbao_app.controllers.comment", "diandanbao_app.services.search", "diandanbao_app.controllers.search", "diandanbao_app.services.cart_action", "diandanbao_app.services.combo", "diandanbao_app.services.combo_package", "diandanbao_app.services.category", "diandanbao_app.services.wechat_share_record_service", "diandanbao_app.controllers.wechat_share_records", "diandanbao_app.services.article", "diandanbao_app.services.invoice", "diandanbao_app.services.sign_record", "diandanbao_app.controllers.sign_record", "diandanbao_app.services.url_helper"])).config(["$httpProvider", function (e) {
    e.defaults.headers.common["X-CSRF-Token"] = $("meta[name=csrf-token]").attr("content"), e.defaults.headers.post["Content-Type"] = "application/json", e.defaults.transformRequest.push(function (e) {
        return showLoadingMask(), e
    }), e.defaults.transformResponse.push(function (e) {
        return hideLoadingMask(), e
    });
    var t = ["$rootScope", "$q", function (e, t) {
        function n(n) {
            if (400 == n.status) {
                e.is_submiting = !1;
                var r = t.defer();
                return n.data.error ? e.$emit("events:receive_errors", n.data.error) : n.data.errors ? e.$emit("events:receive_errors", n.data.errors) : e.$emit("events:receive_errors", n.data), r.promise
            }
            return t.reject(n)
        }

        return {responseError: n}
    }];
    e.interceptors.push(t)
}]).config(["$routeProvider", "RouteConfigProvider", function (e, t) {
    var n = t.$get().get();
    angular.forEach(n, function (t) {
        e.when(t.path, {templateUrl: t.templateUrl + version_timestamp, controller: t.controller})
    }), e.otherwise({redirectTo: "/"})
}]).config(["$locationProvider", function (e) {
    e.html5mode = !0, e.hashPrefix = "!"
}]).run(["$location", "$route", "$rootScope", "$timeout", "$routeParams", "ShopService", "WechatShareRecordService", "HistoryUrlService", "UrlHelperService", "DiandanbaoConst", "UserService", function (e, t, n, r, i, o, a, s, c, l, u) {
    n.is_submiting = !1, n.is_in_weixin = WeixinApi.openInWeixin(), n.oauth_user_info_url = l.oauth_user_info_url, n.partial = function (e) {
        return "/weixin/client_partials/" + e + ".html" + version_timestamp
    }, n.directive_partial = function (e) {
        return n.partial("directives/" + e)
    }, n.go = function (e, t) {
        s.go(e, t)
    }, n.back = function () {
        s.back()
    }, n.reload = function () {
        t.reload()
    }, n.clear_history_url = function () {
        s.clear_history_url()
    }, n.Math = window.Math, n.go_show_product = function (e, t, n, r) {
        var i, o;
        n && (i = n.id), r && (o = r.id), c.go_show_product(e, t, i, o)
    }, n.go_search_product = function (e, t) {
        c.go_search_product(e, t)
    }, n.go_products_list = function (e, t) {
        c.go_products_list(e, t)
    }, n.scanQrCode = function (e) {
        n.is_in_weixin ? wx.scanQRCode({
            desc: e, needResult: 0, scanType: ["qrCode", "barCode"], success: function () {
            }, fail: function () {
                alert("\u5546\u5bb6\u6240\u4f7f\u7528\u7684\u666e\u901a\u8ba2\u9605\u53f7\u4e0d\u652f\u6301\u81ea\u52a8\u5f00\u542f\u626b\u63cf\u5668\uff0c\u8bf7\u70b9\u51fb\u5fae\u4fe1\u804a\u5929\u4e3b\u754c\u9762\u7684\u626b\u4e00\u626b\u529f\u80fd\u6765\u8fdb\u884c\u626b\u7801")
            }
        }) : alert("\u60a8\u4f7f\u7528\u7684\u4e0d\u662f\u624b\u673a\u7aef\u5fae\u4fe1\uff0c\u65e0\u6cd5\u626b\u7801")
    }, n.toggle_show_eat_in_hall_select = function () {
        n.show_eat_in_hall_select = !n.show_eat_in_hall_select
    }, n.$on("$routeChangeStart", function () {
        s.is_back_url(e.url()) && clearLoadingMask(), s.push_current_url(), $(document).off("scroll")
    }), n.$on("$routeChangeSuccess", function () {
        n.shareRecordTrigger = {triggerBeforeCreateRecord: null, triggerBeforeCommitRecord: null}
    }), n.$on("events:success_info", function (e, t, r) {
        n.alert_content = t, setTimeout(function () {
            n.$apply(function () {
                n.alert_content = void 0
            })
        }, r || 4e3)
    }), n.$on("events:receive_errors", function (e, t, r) {
        n.alert_content = t instanceof Array ? t.join(", ") : t, setTimeout(function () {
            n.$apply(function () {
                n.alert_content = void 0
            })
        }, r || 4e3)
    }), e.search().error && n.$emit("events:receive_errors", e.search().error), n.password_modal = {
        show: !1,
        user: null,
        password: null,
        success: null,
        authenticate: function () {
            u.authenticate_password(n.password_modal.password, function (e) {
                e.result ? n.password_modal.success && n.password_modal.success() : n.$emit("events:receive_errors", "\u652f\u4ed8\u5bc6\u7801\u9519\u8bef")
            })
        },
        open: function (e) {
            u.get(function (e) {
                n.password_modal.user = e
            }), n.password_modal.success = e, n.password_modal.password = null, n.password_modal.show = !0, $("input.password-modal-input").select()
        },
        close: function () {
            n.password_modal.success = null, n.password_modal.password = null, n.password_modal.show = !1
        }
    }, n.alert = function (e) {
        n.$emit("events:receive_errors", e)
    }, n.confirm = function (e, t, r, i, o, a) {
        n.confirm_modal = {
            title: e, content: t, confirm: function () {
                n.hide_confirm(), r && r()
            }, confirm_text: i || "\u786e\u5b9a", cancel: function () {
                n.hide_confirm(), o && o()
            }, cancel_text: a || "\u53d6\u6d88", show: !0
        }
    }, n.hide_confirm = function () {
        n.confirm_modal.show = !1
    }, o.get(function (t) {
        n.current_shop = t, n.currency = t.currency;
        var r = function (e, t) {
            t.share_type = e.share_type, n.shareRecordTrigger.triggerBeforeCommitRecord && n.shareRecordTrigger.triggerBeforeCommitRecord(e, t), a.update(t)
        }, o = function (r, o) {
            var s = (new Date).getTime();
            o.imgUrl = t.image, o.link = UrlParser.page_url_without_query(), o.link = UrlParser.change_parameter(o.link, "wechat_share_record_trigger_timestamp", s), o.desc = t.introduction || "\u8d26\u53f7\u4ecb\u7ecd", o.title = t.name || "\u5fae\u4fe1\u70b9\u5355", i.sharable_coupon_id ? (o.title = "\u70b9\u51fb\u9886\u53d6\u4f18\u60e0\u5238\u7ea2\u5305 \u6765\u81ea" + t.name, o.desc = "\u6211\u5728" + t.name + "\u4e0a\u62a2\u5230\u4e86\u4e0d\u5c11\u7ea2\u5305\uff0c\u9001\u4f60\u4e00\u4e2a, \u4e0b\u5355\u53ef\u76f4\u63a5\u62b5\u6263!", o.imgUrl = window.location.origin + "/assets/diandanbao/hongbao.jpg", o.link = UrlParser.change_parameter(o.link, "_ng_path", "/sharable_coupons/" + i.sharable_coupon_id)) : o.link = UrlParser.change_parameter(o.link, "_ng_path", e.path()), n.shareRecordTrigger.triggerBeforeCreateRecord && n.shareRecordTrigger.triggerBeforeCreateRecord(r, o), a.create_id(s, function (e) {
                o.id = e.id
            })
        };
        WeixinApi.bindShareCallback(o, r), function () {
            var n = UrlParser.query_parameter("_ng_path");
            ["/", ""].indexOf(e.path()) >= 0 && (n ? e.url(n) : t.default_branch_id && !t.is_single && e.url("/branches/" + t.default_branch_id))
        }()
    })
}]);