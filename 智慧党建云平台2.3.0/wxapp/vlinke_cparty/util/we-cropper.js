var t = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function(t) {
    return typeof t;
} : function(t) {
    return t && "function" == typeof Symbol && t.constructor === Symbol && t !== Symbol.prototype ? "symbol" : typeof t;
};

!function(e, o) {
    "object" === ("undefined" == typeof exports ? "undefined" : t(exports)) && "undefined" != typeof module ? module.exports = o() : "function" == typeof define && define.amd ? define(o) : e.WeCropper = o();
}(void 0, function() {
    function e(t) {
        return "function" == typeof t;
    }
    function o(t) {
        return t.charAt(0).toUpperCase() + t.slice(1);
    }
    function n(t) {
        for (var e = [], o = arguments.length - 1; o-- > 0; ) e[o] = arguments[o + 1];
        l.forEach(function(o, n) {
            void 0 !== e[n] && (t[o] = e[n]);
        });
    }
    function r(t, e) {
        Object.defineProperties(t, e);
    }
    function a() {
        return f || (f = wx.getSystemInfoSync()), f;
    }
    function i(t, e) {
        return "data:" + e + ";base64," + t;
    }
    function c(t) {
        return "image/" + (t = t.toLowerCase().replace(/jpg/i, "jpeg")).match(/png|jpeg|bmp|gif/)[0];
    }
    function u(t) {
        var e = "";
        if ("string" == typeof t) e = t; else for (var o = 0; o < t.length; o++) e += String.fromCharCode(t[o]);
        return y.encode(e);
    }
    function d(t, e, o, n, r, a) {
        wx.canvasGetImageData({
            canvasId: t,
            x: e,
            y: o,
            width: n,
            height: r,
            success: function(t) {
                a(t);
            },
            fail: function(t) {
                a(null), console.error("canvasGetImageData error: " + t);
            }
        });
    }
    function s(t) {
        var e = t.width, o = t.height, n = e * o * 3, r = n + 54, a = [ 66, 77, 255 & r, r >> 8 & 255, r >> 16 & 255, r >> 24 & 255, 0, 0, 0, 0, 54, 0, 0, 0 ], i = [ 40, 0, 0, 0, 255 & e, e >> 8 & 255, e >> 16 & 255, e >> 24 & 255, 255 & o, o >> 8 & 255, o >> 16 & 255, o >> 24 & 255, 1, 0, 24, 0, 0, 0, 0, 0, 255 & n, n >> 8 & 255, n >> 16 & 255, n >> 24 & 255, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0 ], c = (4 - 3 * e % 4) % 4, d = t.data, s = "", h = e << 2, f = o, l = String.fromCharCode;
        do {
            for (var g = h * (f - 1), v = "", p = 0; p < e; p++) {
                var y = p << 2;
                v += l(d[g + y + 2]) + l(d[g + y + 1]) + l(d[g + y]);
            }
            for (var x = 0; x < c; x++) v += String.fromCharCode(0);
            s += v;
        } while (--f);
        return u(a.concat(i)) + u(s);
    }
    function h(t, o, n, r, a, u, h) {
        void 0 === h && (h = function() {}), void 0 === u && (u = "png"), u = c(u), /bmp/.test(u) ? d(t, o, n, r, a, function(t) {
            var o = s(t);
            e(h) && h(i(o, "image/" + u));
        }) : console.error("暂不支持生成'" + u + "'类型的base64图片");
    }
    var f = void 0, l = [ "touchstarted", "touchmoved", "touchended" ], g = {}, v = {
        id: {
            default: "cropper",
            get: function() {
                return g.id;
            },
            set: function(t) {
                "string" != typeof t && console.error("id：" + t + " is invalid"), g.id = t;
            }
        },
        width: {
            default: 750,
            get: function() {
                return g.width;
            },
            set: function(t) {
                "number" != typeof t && console.error("width：" + t + " is invalid"), g.width = t;
            }
        },
        height: {
            default: 750,
            get: function() {
                return g.height;
            },
            set: function(t) {
                "number" != typeof t && console.error("height：" + t + " is invalid"), g.height = t;
            }
        },
        scale: {
            default: 2.5,
            get: function() {
                return g.scale;
            },
            set: function(t) {
                "number" != typeof t && console.error("scale：" + t + " is invalid"), g.scale = t;
            }
        },
        zoom: {
            default: 5,
            get: function() {
                return g.zoom;
            },
            set: function(t) {
                "number" != typeof t ? console.error("zoom：" + t + " is invalid") : (t < 0 || t > 10) && console.error("zoom should be ranged in 0 ~ 10"), 
                g.zoom = t;
            }
        },
        src: {
            default: "cropper",
            get: function() {
                return g.src;
            },
            set: function(t) {
                "string" != typeof t && console.error("id：" + t + " is invalid"), g.src = t;
            }
        },
        cut: {
            default: {},
            get: function() {
                return g.cut;
            },
            set: function(e) {
                "object" !== (void 0 === e ? "undefined" : t(e)) && console.error("id：" + e + " is invalid"), 
                g.cut = e;
            }
        },
        onReady: {
            default: null,
            get: function() {
                return g.ready;
            },
            set: function(t) {
                g.ready = t;
            }
        },
        onBeforeImageLoad: {
            default: null,
            get: function() {
                return g.beforeImageLoad;
            },
            set: function(t) {
                g.beforeImageLoad = t;
            }
        },
        onImageLoad: {
            default: null,
            get: function() {
                return g.imageLoad;
            },
            set: function(t) {
                g.imageLoad = t;
            }
        },
        onBeforeDraw: {
            default: null,
            get: function() {
                return g.beforeDraw;
            },
            set: function(t) {
                g.beforeDraw = t;
            }
        }
    }, p = "undefined" != typeof window ? window : "undefined" != typeof global ? global : "undefined" != typeof self ? self : {}, y = function(t, e) {
        return e = {
            exports: {}
        }, t(e, e.exports), e.exports;
    }(function(e, o) {
        !function(n) {
            var r = o, a = e && e.exports == r && e, i = "object" == (void 0 === p ? "undefined" : t(p)) && p;
            i.global !== i && i.window !== i || (n = i);
            var c = function(t) {
                this.message = t;
            };
            (c.prototype = new Error()).name = "InvalidCharacterError";
            var u = function(t) {
                throw new c(t);
            }, d = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/", s = /[\t\n\f\r ]/g, h = {
                encode: function(t) {
                    t = String(t), /[^\0-\xFF]/.test(t) && u("The string to be encoded contains characters outside of the Latin1 range.");
                    for (var e, o = t.length % 3, n = "", r = -1, a = t.length - o; ++r < a; ) e = (t.charCodeAt(r) << 16) + (t.charCodeAt(++r) << 8) + t.charCodeAt(++r), 
                    n += d.charAt(e >> 18 & 63) + d.charAt(e >> 12 & 63) + d.charAt(e >> 6 & 63) + d.charAt(63 & e);
                    return 2 == o ? (e = (t.charCodeAt(r) << 8) + t.charCodeAt(++r), n += d.charAt(e >> 10) + d.charAt(e >> 4 & 63) + d.charAt(e << 2 & 63) + "=") : 1 == o && (e = t.charCodeAt(r), 
                    n += d.charAt(e >> 2) + d.charAt(e << 4 & 63) + "=="), n;
                },
                decode: function(t) {
                    var e = (t = String(t).replace(s, "")).length;
                    e % 4 == 0 && (e = (t = t.replace(/==?$/, "")).length), (e % 4 == 1 || /[^+a-zA-Z0-9/]/.test(t)) && u("Invalid character: the string to be decoded is not correctly encoded.");
                    for (var o, n, r = 0, a = "", i = -1; ++i < e; ) n = d.indexOf(t.charAt(i)), o = r % 4 ? 64 * o + n : n, 
                    r++ % 4 && (a += String.fromCharCode(255 & o >> (-2 * r & 6)));
                    return a;
                },
                version: "0.1.0"
            };
            if (r && !r.nodeType) if (a) a.exports = h; else for (var f in h) h.hasOwnProperty(f) && (r[f] = h[f]); else n.base64 = h;
        }(p);
    }), x = {
        convertToImage: h,
        convertToBMP: function(t, e) {
            void 0 === t && (t = {});
            var o = t.canvasId, n = t.x, r = t.y, a = t.width, i = t.height;
            return void 0 === e && (e = function() {}), h(o, n, r, a, i, "bmp", e);
        }
    }, m = function(t, e, o, n, r) {
        var a, i, c;
        return a = Math.round(r.x - n.x), i = Math.round(r.y - n.y), c = Math.round(Math.sqrt(a * a + i * i)), 
        t + .001 * o * (c - e);
    }, b = {
        touchStart: function(t) {
            var e = this, o = t.touches, r = o[0], a = o[1];
            n(e, !0, null, null), e.__oneTouchStart(r), t.touches.length >= 2 && e.__twoTouchStart(r, a);
        },
        touchMove: function(t) {
            var e = this, o = t.touches, r = o[0], a = o[1];
            n(e, null, !0), 1 === t.touches.length && e.__oneTouchMove(r), t.touches.length >= 2 && e.__twoTouchMove(r, a);
        },
        touchEnd: function(t) {
            var e = this;
            n(e, !1, !1, !0), e.__xtouchEnd();
        }
    }, w = function(t) {
        var e = this, o = {};
        return r(e, v), Object.keys(v).forEach(function(t) {
            o[t] = v[t].default;
        }), Object.assign(e, o, t), e.prepare(), e.attachPage(), e.createCtx(), e.observer(), 
        e.cutt(), e.methods(), e.init(), e.update(), e;
    };
    return w.prototype.init = function() {
        var t = this, e = t.src;
        return t.version = "1.2.0", "function" == typeof t.onReady && t.onReady(t.ctx, t), 
        e && t.pushOrign(e), n(t, !1, !1, !1), t.oldScale = 1, t.newScale = 1, t;
    }, Object.assign(w.prototype, b), w.prototype.prepare = function() {
        var t = this, e = a().windowWidth;
        t.attachPage = function() {
            var e = getCurrentPages();
            e[e.length - 1].wecropper = t;
        }, t.createCtx = function() {
            var e = t.id;
            e ? t.ctx = wx.createCanvasContext(e) : console.error("constructor: create canvas context failed, 'id' must be valuable");
        }, t.deviceRadio = e / 750;
    }, w.prototype.observer = function() {
        var t = this, e = [ "ready", "beforeImageLoad", "beforeDraw", "imageLoad" ];
        t.on = function(n, r) {
            return e.indexOf(n) > -1 ? "function" == typeof r && ("ready" === n ? r(t) : t["on" + o(n)] = r) : console.error("event: " + n + " is invalid"), 
            t;
        };
    }, w.prototype.methods = function() {
        var t = this, o = t.id, n = t.deviceRadio, r = t.width, a = t.height, i = t.cut, c = i.x;
        void 0 === c && (c = 0);
        var u = i.y;
        void 0 === u && (u = 0);
        var d = i.width;
        void 0 === d && (d = r);
        var s = i.height;
        void 0 === s && (s = a), t.updateCanvas = function() {
            return t.croperTarget && t.ctx.drawImage(t.croperTarget, t.imgLeft, t.imgTop, t.scaleWidth, t.scaleHeight), 
            e(t.onBeforeDraw) && t.onBeforeDraw(t.ctx, t), t.setBoundStyle(), t.ctx.draw(), 
            t;
        }, t.pushOrign = function(o) {
            return t.src = o, e(t.onBeforeImageLoad) && t.onBeforeImageLoad(t.ctx, t), wx.getImageInfo({
                src: o,
                success: function(o) {
                    var n = o.width / o.height;
                    t.croperTarget = o.path, n < d / s ? (t.rectX = c, t.baseWidth = d, t.baseHeight = d / n, 
                    t.rectY = u - Math.abs((s - t.baseHeight) / 2)) : (t.rectY = u, t.baseWidth = s * n, 
                    t.baseHeight = s, t.rectX = c - Math.abs((d - t.baseWidth) / 2)), t.imgLeft = t.rectX, 
                    t.imgTop = t.rectY, t.scaleWidth = t.baseWidth, t.scaleHeight = t.baseHeight, t.updateCanvas(), 
                    e(t.onImageLoad) && t.onImageLoad(t.ctx, t);
                }
            }), t.update(), t;
        }, t.getCropperBase64 = function(t) {
            void 0 === t && (t = function() {}), x.convertToBMP({
                canvasId: o,
                x: c,
                y: u,
                width: d,
                height: s
            }, t);
        }, t.getCropperImage = function() {
            for (var r = [], a = arguments.length; a--; ) r[a] = arguments[a];
            var i = toString.call(r[0]), h = r[r.length - 1];
            switch (i) {
              case "[object Object]":
                var f = r[0].quality;
                void 0 === f && (f = 10), "number" != typeof f ? console.error("quality：" + f + " is invalid") : (f < 0 || f > 10) && console.error("quality should be ranged in 0 ~ 10"), 
                wx.canvasToTempFilePath({
                    canvasId: o,
                    x: c,
                    y: u,
                    width: d,
                    height: s,
                    destWidth: d * f / (10 * n),
                    destHeight: s * f / (10 * n),
                    success: function(o) {
                        e(h) && h.call(t, o.tempFilePath);
                    },
                    fail: function(o) {
                        e(h) && h.call(t, null);
                    }
                });
                break;

              case "[object Function]":
                wx.canvasToTempFilePath({
                    canvasId: o,
                    x: c,
                    y: u,
                    width: d,
                    height: s,
                    destWidth: d / n,
                    destHeight: s / n,
                    success: function(o) {
                        e(h) && h.call(t, o.tempFilePath);
                    },
                    fail: function(o) {
                        e(h) && h.call(t, null);
                    }
                });
            }
            return t;
        };
    }, w.prototype.cutt = function() {
        var t = this, e = t.width, o = t.height, n = t.cut, r = n.x;
        void 0 === r && (r = 0);
        var a = n.y;
        void 0 === a && (a = 0);
        var i = n.width;
        void 0 === i && (i = e);
        var c = n.height;
        void 0 === c && (c = o), t.outsideBound = function(e, o) {
            t.imgLeft = e >= r ? r : t.scaleWidth + e - r <= i ? r + i - t.scaleWidth : e, t.imgTop = o >= a ? a : t.scaleHeight + o - a <= c ? a + c - t.scaleHeight : o;
        }, t.setBoundStyle = function(n) {
            void 0 === n && (n = {});
            var u = n.color;
            void 0 === u && (u = "#04b00f");
            var d = n.mask;
            void 0 === d && (d = "rgba(0, 0, 0, 0.3)");
            var s = n.lineWidth;
            void 0 === s && (s = 1);
            var h = [ {
                start: {
                    x: r - s,
                    y: a + 10 - s
                },
                step1: {
                    x: r - s,
                    y: a - s
                },
                step2: {
                    x: r + 10 - s,
                    y: a - s
                }
            }, {
                start: {
                    x: r - s,
                    y: a + c - 10 + s
                },
                step1: {
                    x: r - s,
                    y: a + c + s
                },
                step2: {
                    x: r + 10 - s,
                    y: a + c + s
                }
            }, {
                start: {
                    x: r + i - 10 + s,
                    y: a - s
                },
                step1: {
                    x: r + i + s,
                    y: a - s
                },
                step2: {
                    x: r + i + s,
                    y: a + 10 - s
                }
            }, {
                start: {
                    x: r + i + s,
                    y: a + c - 10 + s
                },
                step1: {
                    x: r + i + s,
                    y: a + c + s
                },
                step2: {
                    x: r + i - 10 + s,
                    y: a + c + s
                }
            } ];
            t.ctx.beginPath(), t.ctx.setFillStyle(d), t.ctx.fillRect(0, 0, r, o), t.ctx.fillRect(r, 0, i, a), 
            t.ctx.fillRect(r, a + c, i, o - a - c), t.ctx.fillRect(r + i, 0, e - r - i, o), 
            t.ctx.fill(), h.forEach(function(e) {
                t.ctx.beginPath(), t.ctx.setStrokeStyle(u), t.ctx.setLineWidth(s), t.ctx.moveTo(e.start.x, e.start.y), 
                t.ctx.lineTo(e.step1.x, e.step1.y), t.ctx.lineTo(e.step2.x, e.step2.y), t.ctx.stroke();
            });
        };
    }, w.prototype.update = function() {
        var t = this;
        t.src && (t.__oneTouchStart = function(e) {
            t.touchX0 = Math.round(e.x), t.touchY0 = Math.round(e.y);
        }, t.__oneTouchMove = function(e) {
            var o, n;
            if (t.touchended) return t.updateCanvas();
            o = Math.round(e.x - t.touchX0), n = Math.round(e.y - t.touchY0);
            var r = Math.round(t.rectX + o), a = Math.round(t.rectY + n);
            t.outsideBound(r, a), t.updateCanvas();
        }, t.__twoTouchStart = function(e, o) {
            var n, r, a;
            t.touchX1 = Math.round(t.rectX + t.scaleWidth / 2), t.touchY1 = Math.round(t.rectY + t.scaleHeight / 2), 
            n = Math.round(o.x - e.x), r = Math.round(o.y - e.y), a = Math.round(Math.sqrt(n * n + r * r)), 
            t.oldDistance = a;
        }, t.__twoTouchMove = function(e, o) {
            var n = t.oldScale, r = t.oldDistance, a = t.scale, i = t.zoom;
            t.newScale = m(n, r, i, e, o), t.newScale <= 1 && (t.newScale = 1), t.newScale >= a && (t.newScale = a), 
            t.scaleWidth = Math.round(t.newScale * t.baseWidth), t.scaleHeight = Math.round(t.newScale * t.baseHeight);
            var c = Math.round(t.touchX1 - t.scaleWidth / 2), u = Math.round(t.touchY1 - t.scaleHeight / 2);
            t.outsideBound(c, u), t.updateCanvas();
        }, t.__xtouchEnd = function() {
            t.oldScale = t.newScale, t.rectX = t.imgLeft, t.rectY = t.imgTop;
        });
    }, w;
});