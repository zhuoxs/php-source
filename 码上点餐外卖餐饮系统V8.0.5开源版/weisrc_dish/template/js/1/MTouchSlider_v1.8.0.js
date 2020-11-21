var MTouchLoopSlider = (function() {
    var g = (/webkit/i).test(navigator.appVersion) ? "webkit": (/firefox/i).test(navigator.userAgent) ? "Moz": "opera" in window ? "O": (/MSIE/i).test(navigator.userAgent) ? "ms": "", k = "WebKitCSSMatrix" in window && "m11" in new WebKitCSSMatrix(), c = "translate" + (k ? "3d(" : "("), j = k ? ",0)": ")", h = window.console || {
        log: function() {}
    }, d = window.MData || (function() {
        function p(t) {
            var s = new RegExp("\\-([a-z])", "g");
            if (!s.test(t)) {
                return t
            }
            return t.toLowerCase().replace(s, RegExp.$1.toUpperCase())
        }
        function r(s) {
            return s.replace(/([A-Z])/g, "-$1").toLowerCase()
        }
        function q(u, t, s) {
            u.setAttribute("data-" + r(t), s)
        }
        function o(u, t) {
            var s = u.getAttribute("data-" + r(t));
            return s || undefined
        }
        return function(w, t, s) {
            if (arguments.length > 2) {
                try {
                    w.dataset[p(t)] = s
                } catch (u) {
                    q(w, t, s)
                }
            } else {
                try {
                    return w.dataset[p(t)]
                } catch (u) {
                    return o(w, t)
                }
            }
        }
    }()), i = window._forEach || function(o, q) {
        if (typeof o === "string") {
            try {
                o = e(o)
            } catch (p) {
                h.log(p);
                return 
            }
        }
        Array.prototype.forEach.call(o, q)
    }, a = window._q || function(q, p) {
        if (p && typeof p === "string") {
            try {
                p = a(p)
            } catch (o) {
                h.log(o);
                return 
            }
        }
        return (p || document).querySelector(q)
    }, e = window._qAll || function(q, p) {
        if (p && typeof p === "string") {
            try {
                p = a(p)
            } catch (o) {
                h.log(o);
                return 
            }
        }
        return (p || document).querySelectorAll(q)
    }, b = window._qConcat || function() {
        var r = 0, q = arguments.length, p = [];
        for (; r < q; r++) {
            var o = arguments[r];
            if (typeof o === "string") {
                o = e(o)
            } else {
                if ("nodeType" in o && o.nodeType === 1) {
                    o = [o]
                }
            }
            i(o, function(s) {
                p.push(s)
            })
        }
        return p
    }, l = window._delegate || function() {
        var o = arguments[0], q = arguments[1], p = Array.prototype.slice.call(arguments, 2);
        if (p.length == 1 && p[0] instanceof Array) {
            p = p[0]
        }
        return function() {
            var r = [], t = 0, s = arguments.length;
            for (; t < s; t++) {
                r[t] = arguments[t]
            }
            r = r.concat(p);
            o.apply(q, r)
        }
    }, n = function(r, q, o) {
        var p = o ? 6.18 * 4 * 0.01: 0;
        r.style[g + "TransitionDuration"] = p + "s";
        r.style[g + "Transform"] = c + q + "px,0" + j
    }, m = function() {
        return (new Date).getTime()
    };
    var f = function(q) {
        var r = {
            outerDom: ".tloopslider",
            innerDom: ".tinner",
            itemDom: "section",
            autoplay: true,
            autotimeout: 5000
        };
        for (var p in r) {
            if (!(p in q)) {
                q[p] = r[p]
            }
        }
        this._config = q;
        this._outer = a(q.outerDom);
        this._inner = a(q.innerDom, this._outer);
        this._items = e(q.itemDom, this._inner);
        this._autoItv = null;
        if (this._items.length < 2) {
            return 
        }
        this.setWidth(this._outer.clientWidth);
        this._events = {
            ts: l(this._ets, this),
            tm: l(this._etm, this),
            te: l(this._ete, this)
        };
        var o = ("defaultIndex" in q) ? (typeof q.defaultIndex != "undefined") ? parseInt(q.defaultIndex): 0: 0;
        this._default = o;
        this._range = this._getRange(o);
        this._render();
        this._inner.addEventListener("touchstart", this._events.ts)
    };
    f.prototype = {
        setWidth: function(p) {
            this._w = p;
            var o = this._w;
            this._outer.style.width = o + "px";
            this._inner.style.width = 3 * o + "px";
            i(this._items, function(q) {
                q.style.width = o + "px"
            })
        },
        fixHeight: function() {
            this._inner.style.height = this._items[this._range[1]].clientHeight + "px"
        },
        setCurrent: function(o) {
            if (isNaN(o)) {
                o = 0
            }
            this._range = this._getRange(o);
            this._render()
        },
        _getRange: function(o) {
            if (isNaN(o)) {
                o = 0
            }
            var p = [o];
            p.unshift(o == 0 ? this._items.length-1 : o-1);
            p.push(o == this._items.length-1 ? 0 : o + 1);
            return p
        },
        _render: function() {
            this._disableAuto();
            this._inner.removeEventListener("touchstart", this._events.ts);
            this._inner.removeEventListener("touchmove", this._events.tm);
            this._inner.removeEventListener("touchend", this._events.te);
            this._inner.removeEventListener("touchcancel", this._events.te);
            var o = this;
            this._inner.innerHTML = "";
            i(this._range, function(p) {
                o._inner.appendChild(o._items[p])
            });
            n(this._inner, - this._w, false);
            this.fixHeight();
            this._inner.addEventListener("touchstart", this._events.ts);
            this._enableAuto()
        },
        _enableAuto: function() {
            if (!this._config.autoplay) {
                return 
            }
            if (this._autoItv !== null) {
                return 
            }
            var o = this;
            this._autoItv = window.setTimeout(function() {
                n(o._inner, -2 * o._w, true);
                o._inner.addEventListener("webkitTransitionEnd", function(p) {
                    p.currentTarget.removeEventListener("webkitTransitionEnd", arguments.callee);
                    o._ontransend(2)
                })
            }, o._config.autotimeout)
        },
        _disableAuto: function() {
            if (!this._config.autoplay) {
                return 
            }
            window.clearTimeout(this._autoItv);
            this._autoItv = null
        },
        _ets: function(q) {
            this._disableAuto();
            this._directionLocked = false;
            var p = this._outer.getBoundingClientRect().left, o = this._inner.getBoundingClientRect().left;
            this.dinfo_start = {
                time: m(),
                localX: q.touches[0].clientX - p,
                stageX: q.touches[0].clientX,
                stageY: q.touches[0].clientY,
                innerLeft: o - p
            };
            this._inner.addEventListener("touchmove", this._events.tm);
            this._inner.addEventListener("touchend", this._events.te);
            this._inner.addEventListener("touchcancel", this._events.te)
        },
        _etm: function(t) {
            var s, q, p = t.touches[0].pageX - this.dinfo_start.stageX, o = t.touches[0].pageY - this.dinfo_start.stageY;
            if (this._directionLocked === "y") {
                return 
            } else {
                if (this._directionLocked === "x") {
                    t.preventDefault()
                } else {
                    s = Math.abs(p);
                    q = Math.abs(o);
                    if (s < 4) {
                        return 
                    }
                    if (q > s * 0.58) {
                        this._directionLocked = "y";
                        return 
                    } else {
                        t.preventDefault();
                        this._directionLocked = "x"
                    }
                }
            }
            var r = t.touches[0].clientX - this.dinfo_start.stageX + this.dinfo_start.innerLeft;
            n(this._inner, r, false)
        },
        _ete: function(t) {
            t.preventDefault();
            this._inner.removeEventListener("touchmove", this._events.tm);
            this._inner.removeEventListener("touchend", this._events.te);
            this._inner.removeEventListener("touchcancel", this._events.te);
            var u = this._outer.getBoundingClientRect().left, o = this._inner.getBoundingClientRect().left;
            this.dinfo_end = {
                time: m(),
                innerLeft: o - u
            };
            var w = this, z = this.dinfo_end.innerLeft - this.dinfo_start.innerLeft, x = Math.abs(z) < 5, s = this.dinfo_end.time - this.dinfo_start.time, q = s > 300, r = z < 0, y =- this._w, p = null;
            if (!q) {
                if (!x) {
                    y = r?-2 * this._w : 0;
                    p = r ? 2 : 0
                }
            } else {
                if (Math.abs(z) > 0.5 * this._w) {
                    y = r?-2 * this._w : 0;
                    p = r ? 2 : 0
                }
            }
            t.currentTarget.removeEventListener("touchstart", this._events.ts);
            n(this._inner, y, true);
            if (p != null) {
                this._inner.addEventListener("webkitTransitionEnd", function(v) {
                    v.currentTarget.removeEventListener("webkitTransitionEnd", arguments.callee);
                    w._ontransend(p);
                    v.currentTarget.addEventListener("touchstart", w._events.ts)
                })
            } else {
                t.currentTarget.addEventListener("touchstart", w._events.ts)
            }
        },
        _ontransend: function(o) {
            this._range = this._getRange(this._range[o]);
            this._render();
            if ("callback" in this._config && typeof this._config.callback == "function") {
                this._config.callback.call(this, this._outer, this._items[this._range[1]], this._range[1])
            }
        }
    };
    return f
}());
var MTouchSlider = (function() {
    return function(f, a) {
        var d = new MTouchLoopSlider({
            outerDom: f.id !== "" ? "#" + f.id: "." + f.classList.item(0),
            innerDom: a.barCls,
            itemDom: a.pageCls,
            defaultIndex: a.defaultTab,
            autoplay: parseInt(MData(f, "auto-play")),
            autotimeout: parseInt(MData(f, "auto-time")),
            callback: function(j, i, h) {
                d._curr = h;
                c(h);
                var k = MData(f, "drag-callback");
                if (k.length && (k in window) && (typeof window[k] == "function")) {
                    window[k].call(d, j, i, h)
                }
            }
        });
        d._curr = d._default;
        d._ilng = d._items.length;
        d._parts = d._items;
        d._ele = d._outer;
        d._bar = d._inner;
        var e = function(i, j) {
            var k = document.createElement("canvas"), h = k.getContext("2d");
            if (!j) {
                j = 4
            }
            k.width = j * 2;
            k.height = j * 2;
            h.fillStyle = i;
            h.beginPath();
            h.arc(j, j, j, Math.PI * 2, 0, true);
            h.closePath();
            h.fill();
            MData(k, "color", i);
            return k
        }, c = function(h) {
            _forEach(d._dots, function(j, i, k) {
                j.style.opacity = 0.4
            });
            if (d._dots[h]) {
                d._dots[h].style.opacity = 1
            }
        };
        d._dotCtn = f.querySelector(a.dotsCls || ".sld_dots");
        d._dots = [];
        d._isRelLayout=!!MData(d._dotCtn, "relativeLayout");
        if (d._dotCtn && d._isRelLayout) {
            d._dotCtn.style.width = 13 * d._ilng + "px";
            d._dotCtn.style.marginLeft = 0.5 * (d._w-13 * d._ilng) + "px"
        } else {
            d._dotCtn.style.marginLeft = 0.5 * (d._w-13 * (d._ilng-1)) + "px"
        }
        for (var b = 0; b < d._ilng; b++) {
            d._parts[b].style.width = d._w + "px";
            if (MData(d._ele, "minHeight")) {
                d._parts[b].style.minHeight = MData(d._ele, "minHeight") + "px"
            }
            var g = e(MData(d._ele, "dotColor"));
            d._dots[b] = g;
            if (d._dotCtn) {
                if (!d._isRelLayout) {
                    d._dotCtn.style.left = 13 * b + "px"
                }
                d._dotCtn.appendChild(g)
            } else {
                g.style.top = "0";
                g.style.left = (13 * b + 0.5 * (d._w-13 * (d._ilng-1))) + "px";
                d._bar.parentNode.insertAdjacentElement("afterBegin", g)
            }
        }
        c(d._default);
        return d
    }
}());
