!function (a, b) {
    "object" == typeof exports && "object" == typeof module ? module.exports = b() : "function" == typeof define && define.amd ? define([], b) : "object" == typeof exports ? exports["html2canvas"] = b() : a["html2canvas"] = b()
}(this, function () {
    return function (a) {
        function c(d) {
            if (b[d])return b[d].exports;
            var e = b[d] = {i: d, l: !1, exports: {}};
            return a[d].call(e.exports, e, e.exports, c), e.l = !0, e.exports
        }

        var b = {};
        return c.m = a, c.c = b, c.d = function (a, b, d) {
            c.o(a, b) || Object.defineProperty(a, b, {configurable: !1, enumerable: !0, get: d})
        }, c.n = function (a) {
            var b = a && a.__esModule ? function () {
                return a["default"]
            } : function () {
                return a
            };
            return c.d(b, "a", b), b
        }, c.o = function (a, b) {
            return Object.prototype.hasOwnProperty.call(a, b)
        }, c.p = "", c(c.s = 27)
    }([function (a, b) {
        "use strict";
        function f(a, b) {
            if (!(a instanceof b))throw new TypeError("Cannot call a class as a function")
        }

        var d, e, g, h, i, j, k, l, m, n, o, p, q, r;
        Object.defineProperty(b, "__esModule", {value: !0}), d = function () {
            function a(a, b) {
                var h, g, c = [], d = !0, e = !1, f = void 0;
                try {
                    for (g = a[Symbol.iterator](); !(d = (h = g.next()).done) && (c.push(h.value), !b || c.length !== b); d = !0);
                } catch (i) {
                    e = !0, f = i
                } finally {
                    try {
                        !d && g["return"] && g["return"]()
                    } finally {
                        if (e)throw f
                    }
                }
                return c
            }

            return function (b, c) {
                if (Array.isArray(b))return b;
                if (Symbol.iterator in Object(b))return a(b, c);
                throw new TypeError("Invalid attempt to destructure non-iterable instance")
            }
        }(), e = function () {
            function a(a, b) {
                var c, d;
                for (c = 0; c < b.length; c++)d = b[c], d.enumerable = d.enumerable || !1, d.configurable = !0, "value" in d && (d.writable = !0), Object.defineProperty(a, d.key, d)
            }

            return function (b, c, d) {
                return c && a(b.prototype, c), d && a(b, d), b
            }
        }(), g = /^#([a-f0-9]{3})$/i, h = function (a) {
            var b = a.match(g);
            return b ? [parseInt(b[1][0] + b[1][0], 16), parseInt(b[1][1] + b[1][1], 16), parseInt(b[1][2] + b[1][2], 16), null] : !1
        }, i = /^#([a-f0-9]{6})$/i, j = function (a) {
            var b = a.match(i);
            return b ? [parseInt(b[1].substring(0, 2), 16), parseInt(b[1].substring(2, 4), 16), parseInt(b[1].substring(4, 6), 16), null] : !1
        }, k = /^rgb\(\s*(\d{1,3})\s*,\s*(\d{1,3})\s*,\s*(\d{1,3})\s*\)$/, l = function (a) {
            var b = a.match(k);
            return b ? [Number(b[1]), Number(b[2]), Number(b[3]), null] : !1
        }, m = /^rgba\(\s*(\d{1,3})\s*,\s*(\d{1,3})\s*,\s*(\d{1,3})\s*,\s*(\d?\.?\d+)\s*\)$/, n = function (a) {
            var b = a.match(m);
            return b && b.length > 4 ? [Number(b[1]), Number(b[2]), Number(b[3]), Number(b[4])] : !1
        }, o = function (a) {
            return [Math.min(a[0], 255), Math.min(a[1], 255), Math.min(a[2], 255), a.length > 3 ? a[3] : null]
        }, p = function (a) {
            var b = r[a.toLowerCase()];
            return b ? b : !1
        }, q = function () {
            function a(b) {
                f(this, a);
                var c = Array.isArray(b) ? o(b) : h(b) || l(b) || n(b) || p(b) || j(b) || [0, 0, 0, null], e = d(c, 4),
                    g = e[0], i = e[1], k = e[2], m = e[3];
                this.r = g, this.g = i, this.b = k, this.a = m
            }

            return e(a, [{
                key: "isTransparent", value: function () {
                    return 0 === this.a
                }
            }, {
                key: "toString", value: function () {
                    return null !== this.a && 1 !== this.a ? "rgba(" + this.r + "," + this.g + "," + this.b + "," + this.a + ")" : "rgb(" + this.r + "," + this.g + "," + this.b + ")"
                }
            }]), a
        }(), b.default = q, r = {
            transparent: [0, 0, 0, 0],
            aliceblue: [240, 248, 255, null],
            antiquewhite: [250, 235, 215, null],
            aqua: [0, 255, 255, null],
            aquamarine: [127, 255, 212, null],
            azure: [240, 255, 255, null],
            beige: [245, 245, 220, null],
            bisque: [255, 228, 196, null],
            black: [0, 0, 0, null],
            blanchedalmond: [255, 235, 205, null],
            blue: [0, 0, 255, null],
            blueviolet: [138, 43, 226, null],
            brown: [165, 42, 42, null],
            burlywood: [222, 184, 135, null],
            cadetblue: [95, 158, 160, null],
            chartreuse: [127, 255, 0, null],
            chocolate: [210, 105, 30, null],
            coral: [255, 127, 80, null],
            cornflowerblue: [100, 149, 237, null],
            cornsilk: [255, 248, 220, null],
            crimson: [220, 20, 60, null],
            cyan: [0, 255, 255, null],
            darkblue: [0, 0, 139, null],
            darkcyan: [0, 139, 139, null],
            darkgoldenrod: [184, 134, 11, null],
            darkgray: [169, 169, 169, null],
            darkgreen: [0, 100, 0, null],
            darkgrey: [169, 169, 169, null],
            darkkhaki: [189, 183, 107, null],
            darkmagenta: [139, 0, 139, null],
            darkolivegreen: [85, 107, 47, null],
            darkorange: [255, 140, 0, null],
            darkorchid: [153, 50, 204, null],
            darkred: [139, 0, 0, null],
            darksalmon: [233, 150, 122, null],
            darkseagreen: [143, 188, 143, null],
            darkslateblue: [72, 61, 139, null],
            darkslategray: [47, 79, 79, null],
            darkslategrey: [47, 79, 79, null],
            darkturquoise: [0, 206, 209, null],
            darkviolet: [148, 0, 211, null],
            deeppink: [255, 20, 147, null],
            deepskyblue: [0, 191, 255, null],
            dimgray: [105, 105, 105, null],
            dimgrey: [105, 105, 105, null],
            dodgerblue: [30, 144, 255, null],
            firebrick: [178, 34, 34, null],
            floralwhite: [255, 250, 240, null],
            forestgreen: [34, 139, 34, null],
            fuchsia: [255, 0, 255, null],
            gainsboro: [220, 220, 220, null],
            ghostwhite: [248, 248, 255, null],
            gold: [255, 215, 0, null],
            goldenrod: [218, 165, 32, null],
            gray: [128, 128, 128, null],
            green: [0, 128, 0, null],
            greenyellow: [173, 255, 47, null],
            grey: [128, 128, 128, null],
            honeydew: [240, 255, 240, null],
            hotpink: [255, 105, 180, null],
            indianred: [205, 92, 92, null],
            indigo: [75, 0, 130, null],
            ivory: [255, 255, 240, null],
            khaki: [240, 230, 140, null],
            lavender: [230, 230, 250, null],
            lavenderblush: [255, 240, 245, null],
            lawngreen: [124, 252, 0, null],
            lemonchiffon: [255, 250, 205, null],
            lightblue: [173, 216, 230, null],
            lightcoral: [240, 128, 128, null],
            lightcyan: [224, 255, 255, null],
            lightgoldenrodyellow: [250, 250, 210, null],
            lightgray: [211, 211, 211, null],
            lightgreen: [144, 238, 144, null],
            lightgrey: [211, 211, 211, null],
            lightpink: [255, 182, 193, null],
            lightsalmon: [255, 160, 122, null],
            lightseagreen: [32, 178, 170, null],
            lightskyblue: [135, 206, 250, null],
            lightslategray: [119, 136, 153, null],
            lightslategrey: [119, 136, 153, null],
            lightsteelblue: [176, 196, 222, null],
            lightyellow: [255, 255, 224, null],
            lime: [0, 255, 0, null],
            limegreen: [50, 205, 50, null],
            linen: [250, 240, 230, null],
            magenta: [255, 0, 255, null],
            maroon: [128, 0, 0, null],
            mediumaquamarine: [102, 205, 170, null],
            mediumblue: [0, 0, 205, null],
            mediumorchid: [186, 85, 211, null],
            mediumpurple: [147, 112, 219, null],
            mediumseagreen: [60, 179, 113, null],
            mediumslateblue: [123, 104, 238, null],
            mediumspringgreen: [0, 250, 154, null],
            mediumturquoise: [72, 209, 204, null],
            mediumvioletred: [199, 21, 133, null],
            midnightblue: [25, 25, 112, null],
            mintcream: [245, 255, 250, null],
            mistyrose: [255, 228, 225, null],
            moccasin: [255, 228, 181, null],
            navajowhite: [255, 222, 173, null],
            navy: [0, 0, 128, null],
            oldlace: [253, 245, 230, null],
            olive: [128, 128, 0, null],
            olivedrab: [107, 142, 35, null],
            orange: [255, 165, 0, null],
            orangered: [255, 69, 0, null],
            orchid: [218, 112, 214, null],
            palegoldenrod: [238, 232, 170, null],
            palegreen: [152, 251, 152, null],
            paleturquoise: [175, 238, 238, null],
            palevioletred: [219, 112, 147, null],
            papayawhip: [255, 239, 213, null],
            peachpuff: [255, 218, 185, null],
            peru: [205, 133, 63, null],
            pink: [255, 192, 203, null],
            plum: [221, 160, 221, null],
            powderblue: [176, 224, 230, null],
            purple: [128, 0, 128, null],
            rebeccapurple: [102, 51, 153, null],
            red: [255, 0, 0, null],
            rosybrown: [188, 143, 143, null],
            royalblue: [65, 105, 225, null],
            saddlebrown: [139, 69, 19, null],
            salmon: [250, 128, 114, null],
            sandybrown: [244, 164, 96, null],
            seagreen: [46, 139, 87, null],
            seashell: [255, 245, 238, null],
            sienna: [160, 82, 45, null],
            silver: [192, 192, 192, null],
            skyblue: [135, 206, 235, null],
            slateblue: [106, 90, 205, null],
            slategray: [112, 128, 144, null],
            slategrey: [112, 128, 144, null],
            snow: [255, 250, 250, null],
            springgreen: [0, 255, 127, null],
            steelblue: [70, 130, 180, null],
            tan: [210, 180, 140, null],
            teal: [0, 128, 128, null],
            thistle: [216, 191, 216, null],
            tomato: [255, 99, 71, null],
            turquoise: [64, 224, 208, null],
            violet: [238, 130, 238, null],
            wheat: [245, 222, 179, null],
            white: [255, 255, 255, null],
            whitesmoke: [245, 245, 245, null],
            yellow: [255, 255, 0, null],
            yellowgreen: [154, 205, 50, null]
        }, b.TRANSPARENT = new q([0, 0, 0, 0])
    }, function (a, b) {
        "use strict";
        function e(a, b) {
            if (!(a instanceof b))throw new TypeError("Cannot call a class as a function")
        }

        var d, g, h, i;
        Object.defineProperty(b, "__esModule", {value: !0}), d = function () {
            function a(a, b) {
                var c, d;
                for (c = 0; c < b.length; c++)d = b[c], d.enumerable = d.enumerable || !1, d.configurable = !0, "value" in d && (d.writable = !0), Object.defineProperty(a, d.key, d)
            }

            return function (b, c, d) {
                return c && a(b.prototype, c), d && a(b, d), b
            }
        }(), g = b.LENGTH_TYPE = {PX: 0, PERCENTAGE: 1}, h = function () {
            function a(b) {
                e(this, a), this.type = "%" === b.substr(b.length - 1) ? g.PERCENTAGE : g.PX;
                var c = parseFloat(b);
                isNaN(c) && console.error('Invalid value given for Length: "' + b + '"'), this.value = isNaN(c) ? 0 : c
            }

            return d(a, [{
                key: "isPercentage", value: function () {
                    return this.type === g.PERCENTAGE
                }
            }, {
                key: "getAbsoluteValue", value: function (a) {
                    return this.isPercentage() ? a * (this.value / 100) : this.value
                }
            }], [{
                key: "create", value: function (b) {
                    return new a(b)
                }
            }]), a
        }(), b.default = h, i = function k(a) {
            var b = a.parent;
            return b ? k(b) : parseFloat(a.style.font.fontSize)
        }, b.calculateLengthFromValueWithUnit = function (a, b, c) {
            switch (c) {
                case"px":
                case"%":
                    return new h(b + c);
                case"em":
                case"rem":
                    var d = new h(b);
                    return d.value *= "em" === c ? parseFloat(a.style.font.fontSize) : i(a), d;
                default:
                    return new h("0")
            }
        }
    }, function (a, b, c) {
        "use strict";
        function i(a) {
            return a && a.__esModule ? a : {"default": a}
        }

        function j(a, b) {
            if (!(a instanceof b))throw new TypeError("Cannot call a class as a function")
        }

        var d, e, f, g, h, k, l, m, n, o, p, q, w, A, B;
        Object.defineProperty(b, "__esModule", {value: !0}), b.parseBoundCurves = b.calculatePaddingBoxPath = b.calculateBorderBoxPath = b.parsePathForBorder = b.parseDocumentSize = b.calculateContentBox = b.calculatePaddingBox = b.parseBounds = b.Bounds = void 0, d = function () {
            function a(a, b) {
                var c, d;
                for (c = 0; c < b.length; c++)d = b[c], d.enumerable = d.enumerable || !1, d.configurable = !0, "value" in d && (d.writable = !0), Object.defineProperty(a, d.key, d)
            }

            return function (b, c, d) {
                return c && a(b.prototype, c), d && a(b, d), b
            }
        }(), e = c(7), f = i(e), g = c(32), h = i(g), k = 0, l = 1, m = 2, n = 3, o = 0, p = 1, q = b.Bounds = function () {
            function a(b, c, d, e) {
                j(this, a), this.left = b, this.top = c, this.width = d, this.height = e
            }

            return d(a, null, [{
                key: "fromClientRect", value: function (b, c, d) {
                    return new a(b.left + c, b.top + d, b.width, b.height)
                }
            }]), a
        }(), b.parseBounds = function (a, b, c) {
            return q.fromClientRect(a.getBoundingClientRect(), b, c)
        }, b.calculatePaddingBox = function (a, b) {
            return new q(a.left + b[n].borderWidth, a.top + b[k].borderWidth, a.width - (b[l].borderWidth + b[n].borderWidth), a.height - (b[k].borderWidth + b[m].borderWidth))
        }, b.calculateContentBox = function (a, b, c) {
            var d = b[k].value, e = b[l].value, f = b[m].value, g = b[n].value;
            return new q(a.left + g + c[n].borderWidth, a.top + d + c[k].borderWidth, a.width - (c[l].borderWidth + c[n].borderWidth + g + e), a.height - (c[k].borderWidth + c[m].borderWidth + d + f))
        }, b.parseDocumentSize = function (a) {
            var d, e, b = a.body, c = a.documentElement;
            if (!b || !c)throw new Error("Unable to get document size");
            return d = Math.max(Math.max(b.scrollWidth, c.scrollWidth), Math.max(b.offsetWidth, c.offsetWidth), Math.max(b.clientWidth, c.clientWidth)), e = Math.max(Math.max(b.scrollHeight, c.scrollHeight), Math.max(b.offsetHeight, c.offsetHeight), Math.max(b.clientHeight, c.clientHeight)), new q(0, 0, d, e)
        }, b.parsePathForBorder = function (a, b) {
            switch (b) {
                case k:
                    return w(a.topLeftOuter, a.topLeftInner, a.topRightOuter, a.topRightInner);
                case l:
                    return w(a.topRightOuter, a.topRightInner, a.bottomRightOuter, a.bottomRightInner);
                case m:
                    return w(a.bottomRightOuter, a.bottomRightInner, a.bottomLeftOuter, a.bottomLeftInner);
                case n:
                default:
                    return w(a.bottomLeftOuter, a.bottomLeftInner, a.topLeftOuter, a.topLeftInner)
            }
        }, w = function (a, b, c, d) {
            var e = [];
            return a instanceof h.default ? e.push(a.subdivide(.5, !1)) : e.push(a), c instanceof h.default ? e.push(c.subdivide(.5, !0)) : e.push(c), d instanceof h.default ? e.push(d.subdivide(.5, !0).reverse()) : e.push(d), b instanceof h.default ? e.push(b.subdivide(.5, !1).reverse()) : e.push(b), e
        }, b.calculateBorderBoxPath = function (a) {
            return [a.topLeftOuter, a.topRightOuter, a.bottomRightOuter, a.bottomLeftOuter]
        }, b.calculatePaddingBoxPath = function (a) {
            return [a.topLeftInner, a.topRightInner, a.bottomRightInner, a.bottomLeftInner]
        }, b.parseBoundCurves = function (a, b, c) {
            var t, u, v, w, x, d = c[A.TOP_LEFT][o].getAbsoluteValue(a.width),
                e = c[A.TOP_LEFT][p].getAbsoluteValue(a.height), g = c[A.TOP_RIGHT][o].getAbsoluteValue(a.width),
                h = c[A.TOP_RIGHT][p].getAbsoluteValue(a.height), i = c[A.BOTTOM_RIGHT][o].getAbsoluteValue(a.width),
                j = c[A.BOTTOM_RIGHT][p].getAbsoluteValue(a.height), q = c[A.BOTTOM_LEFT][o].getAbsoluteValue(a.width),
                r = c[A.BOTTOM_LEFT][p].getAbsoluteValue(a.height), s = [];
            return s.push((d + g) / a.width), s.push((q + i) / a.width), s.push((e + r) / a.height), s.push((h + j) / a.height), t = Math.max.apply(Math, s), t > 1 && (d /= t, e /= t, g /= t, h /= t, i /= t, j /= t, q /= t, r /= t), u = a.width - g, v = a.height - j, w = a.width - i, x = a.height - r, {
                topLeftOuter: d > 0 || e > 0 ? B(a.left, a.top, d, e, A.TOP_LEFT) : new f.default(a.left, a.top),
                topLeftInner: d > 0 || e > 0 ? B(a.left + b[n].borderWidth, a.top + b[k].borderWidth, Math.max(0, d - b[n].borderWidth), Math.max(0, e - b[k].borderWidth), A.TOP_LEFT) : new f.default(a.left + b[n].borderWidth, a.top + b[k].borderWidth),
                topRightOuter: g > 0 || h > 0 ? B(a.left + u, a.top, g, h, A.TOP_RIGHT) : new f.default(a.left + a.width, a.top),
                topRightInner: g > 0 || h > 0 ? B(a.left + Math.min(u, a.width + b[n].borderWidth), a.top + b[k].borderWidth, u > a.width + b[n].borderWidth ? 0 : g - b[n].borderWidth, h - b[k].borderWidth, A.TOP_RIGHT) : new f.default(a.left + a.width - b[l].borderWidth, a.top + b[k].borderWidth),
                bottomRightOuter: i > 0 || j > 0 ? B(a.left + w, a.top + v, i, j, A.BOTTOM_RIGHT) : new f.default(a.left + a.width, a.top + a.height),
                bottomRightInner: i > 0 || j > 0 ? B(a.left + Math.min(w, a.width - b[n].borderWidth), a.top + Math.min(v, a.height + b[k].borderWidth), Math.max(0, i - b[l].borderWidth), j - b[m].borderWidth, A.BOTTOM_RIGHT) : new f.default(a.left + a.width - b[l].borderWidth, a.top + a.height - b[m].borderWidth),
                bottomLeftOuter: q > 0 || r > 0 ? B(a.left, a.top + x, q, r, A.BOTTOM_LEFT) : new f.default(a.left, a.top + a.height),
                bottomLeftInner: q > 0 || r > 0 ? B(a.left + b[n].borderWidth, a.top + x, Math.max(0, q - b[n].borderWidth), r - b[m].borderWidth, A.BOTTOM_LEFT) : new f.default(a.left + b[n].borderWidth, a.top + a.height - b[m].borderWidth)
            }
        }, A = {TOP_LEFT: 0, TOP_RIGHT: 1, BOTTOM_RIGHT: 2, BOTTOM_LEFT: 3}, B = function (a, b, c, d, e) {
            var g = 4 * ((Math.sqrt(2) - 1) / 3), i = c * g, j = d * g, k = a + c, l = b + d;
            switch (e) {
                case A.TOP_LEFT:
                    return new h.default(new f.default(a, l), new f.default(a, l - j), new f.default(k - i, b), new f.default(k, b));
                case A.TOP_RIGHT:
                    return new h.default(new f.default(a, b), new f.default(a + i, b), new f.default(k, l - j), new f.default(k, l));
                case A.BOTTOM_RIGHT:
                    return new h.default(new f.default(k, b), new f.default(k, b + j), new f.default(a + i, l), new f.default(a, l));
                case A.BOTTOM_LEFT:
                default:
                    return new h.default(new f.default(k, l), new f.default(k - i, l), new f.default(a, b + j), new f.default(a, b))
            }
        }
    }, function (a, b) {
        "use strict";
        Object.defineProperty(b, "__esModule", {value: !0}), b.contains = function (a, b) {
            return 0 !== (a & b)
        }, b.distance = function (a, b) {
            return Math.sqrt(a * a + b * b)
        }, b.copyCSSStyles = function (a, b) {
            var c, d;
            for (c = a.length - 1; c >= 0; c--)d = a.item(c), "content" !== d && b.style.setProperty(d, a.getPropertyValue(d));
            return b
        }, b.SMALL_IMAGE = "data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7"
    }, function (a, b, c) {
        "use strict";
        function n(a) {
            return a && a.__esModule ? a : {"default": a}
        }

        function o(a, b) {
            if (!(a instanceof b))throw new TypeError("Cannot call a class as a function")
        }

        var d, e, f, g, h, i, j, k, l, m, p, q, r, s, t, u, x, D, E, F, G, H, I, J;
        Object.defineProperty(b, "__esModule", {value: !0}), b.parseBackgroundImage = b.parseBackground = b.calculateBackgroundRepeatPath = b.calculateBackgroundPosition = b.calculateBackgroungPositioningArea = b.calculateBackgroungPaintingArea = b.calculateGradientBackgroundSize = b.calculateBackgroundSize = b.BACKGROUND_ORIGIN = b.BACKGROUND_CLIP = b.BACKGROUND_SIZE = b.BACKGROUND_REPEAT = void 0, d = c(0), e = n(d), f = c(1), g = n(f), h = c(31), i = n(h), j = c(7), k = n(j), l = c(2), m = c(17), p = b.BACKGROUND_REPEAT = {
            REPEAT: 0,
            NO_REPEAT: 1,
            REPEAT_X: 2,
            REPEAT_Y: 3
        }, q = b.BACKGROUND_SIZE = {AUTO: 0, CONTAIN: 1, COVER: 2, LENGTH: 3}, r = b.BACKGROUND_CLIP = {
            BORDER_BOX: 0,
            PADDING_BOX: 1,
            CONTENT_BOX: 2
        }, s = b.BACKGROUND_ORIGIN = r, t = "auto", u = function K(a) {
            switch (o(this, K), a) {
                case"contain":
                    this.size = q.CONTAIN;
                    break;
                case"cover":
                    this.size = q.COVER;
                    break;
                case"auto":
                    this.size = q.AUTO;
                    break;
                default:
                    this.value = new g.default(a)
            }
        }, b.calculateBackgroundSize = function (a, b, c) {
            var g, h, d = 0, e = 0, f = a.size;
            return f[0].size === q.CONTAIN || f[0].size === q.COVER ? (g = c.width / c.height, h = b.width / b.height, h > g != (f[0].size === q.COVER) ? new i.default(c.width, c.width / h) : new i.default(c.height * h, c.height)) : (f[0].value && (d = f[0].value.getAbsoluteValue(c.width)), f[0].size === q.AUTO && f[1].size === q.AUTO ? e = b.height : f[1].size === q.AUTO ? e = d / b.width * b.height : f[1].value && (e = f[1].value.getAbsoluteValue(c.height)), f[0].size === q.AUTO && (d = e / b.height * b.width), new i.default(d, e))
        }, b.calculateGradientBackgroundSize = function (a, b) {
            var c = a.size, d = c[0].value ? c[0].value.getAbsoluteValue(b.width) : b.width,
                e = c[1].value ? c[1].value.getAbsoluteValue(b.height) : c[0].value ? d : b.height;
            return new i.default(d, e)
        }, x = new u(t), b.calculateBackgroungPaintingArea = function (a, b) {
            switch (b) {
                case r.BORDER_BOX:
                    return l.calculateBorderBoxPath(a);
                case r.PADDING_BOX:
                default:
                    return l.calculatePaddingBoxPath(a)
            }
        }, b.calculateBackgroungPositioningArea = function (a, b, c, d) {
            var f, g, h, i, e = l.calculatePaddingBox(b, d);
            switch (a) {
                case s.BORDER_BOX:
                    return b;
                case s.CONTENT_BOX:
                    return f = c[m.PADDING_SIDES.LEFT].getAbsoluteValue(b.width), g = c[m.PADDING_SIDES.RIGHT].getAbsoluteValue(b.width), h = c[m.PADDING_SIDES.TOP].getAbsoluteValue(b.width), i = c[m.PADDING_SIDES.BOTTOM].getAbsoluteValue(b.width), new l.Bounds(e.left + f, e.top + h, e.width - f - g, e.height - h - i);
                case s.PADDING_BOX:
                default:
                    return e
            }
        }, b.calculateBackgroundPosition = function (a, b, c) {
            return new k.default(a[0].getAbsoluteValue(c.width - b.width), a[1].getAbsoluteValue(c.height - b.height))
        }, b.calculateBackgroundRepeatPath = function (a, b, c, d, e) {
            var f = a.repeat;
            switch (f) {
                case p.REPEAT_X:
                    return [new k.default(Math.round(e.left), Math.round(d.top + b.y)), new k.default(Math.round(e.left + e.width), Math.round(d.top + b.y)), new k.default(Math.round(e.left + e.width), Math.round(c.height + d.top + b.y)), new k.default(Math.round(e.left), Math.round(c.height + d.top + b.y))];
                case p.REPEAT_Y:
                    return [new k.default(Math.round(d.left + b.x), Math.round(e.top)), new k.default(Math.round(d.left + b.x + c.width), Math.round(e.top)), new k.default(Math.round(d.left + b.x + c.width), Math.round(e.height + e.top)), new k.default(Math.round(d.left + b.x), Math.round(e.height + e.top))];
                case p.NO_REPEAT:
                    return [new k.default(Math.round(d.left + b.x), Math.round(d.top + b.y)), new k.default(Math.round(d.left + b.x + c.width), Math.round(d.top + b.y)), new k.default(Math.round(d.left + b.x + c.width), Math.round(d.top + b.y + c.height)), new k.default(Math.round(d.left + b.x), Math.round(d.top + b.y + c.height))];
                default:
                    return [new k.default(Math.round(e.left), Math.round(e.top)), new k.default(Math.round(e.left + e.width), Math.round(e.top)), new k.default(Math.round(e.left + e.width), Math.round(e.height + e.top)), new k.default(Math.round(e.left), Math.round(e.height + e.top))]
            }
        }, b.parseBackground = function (a, b) {
            return {
                backgroundColor: new e.default(a.backgroundColor),
                backgroundImage: G(a, b),
                backgroundClip: D(a.backgroundClip),
                backgroundOrigin: E(a.backgroundOrigin)
            }
        }, D = function (a) {
            switch (a) {
                case"padding-box":
                    return r.PADDING_BOX;
                case"content-box":
                    return r.CONTENT_BOX
            }
            return r.BORDER_BOX
        }, E = function (a) {
            switch (a) {
                case"padding-box":
                    return s.PADDING_BOX;
                case"content-box":
                    return s.CONTENT_BOX
            }
            return s.BORDER_BOX
        }, F = function (a) {
            switch (a.trim()) {
                case"no-repeat":
                    return p.NO_REPEAT;
                case"repeat-x":
                case"repeat no-repeat":
                    return p.REPEAT_X;
                case"repeat-y":
                case"no-repeat repeat":
                    return p.REPEAT_Y;
                case"repeat":
                    return p.REPEAT
            }
            return console.error('Invalid background-repeat value "' + a + '"'), p.REPEAT
        }, G = function (a, b) {
            var c = J(a.backgroundImage).map(function (a) {
                if ("url" === a.method) {
                    var c = b.loadImage(a.args[0]);
                    a.args = c ? [c] : []
                }
                return a
            }), d = a.backgroundPosition.split(","), e = a.backgroundRepeat.split(","), f = a.backgroundSize.split(",");
            return c.map(function (a, b) {
                var c = (f[b] || t).trim().split(" ").map(H), g = (d[b] || t).trim().split(" ").map(I);
                return {
                    source: a,
                    repeat: F("string" == typeof e[b] ? e[b] : e[0]),
                    size: c.length < 2 ? [c[0], x] : [c[0], c[1]],
                    position: g.length < 2 ? [g[0], g[0]] : [g[0], g[1]]
                }
            })
        }, H = function (a) {
            return "auto" === a ? x : new u(a)
        }, I = function (a) {
            switch (a) {
                case"bottom":
                case"right":
                    return new g.default("100%");
                case"left":
                case"top":
                    return new g.default("0%");
                case"auto":
                    return new g.default("0")
            }
            return new g.default(a)
        }, J = b.parseBackgroundImage = function (a) {
            var b = /^\s$/, c = [], d = [], e = "", f = null, g = "", h = 0, i = 0, j = function () {
                var b, a = "";
                e && ('"' === g.substr(0, 1) && (g = g.substr(1, g.length - 2)), g && d.push(g.trim()), b = e.indexOf("-", 1) + 1, "-" === e.substr(0, 1) && b > 0 && (a = e.substr(0, b).toLowerCase(), e = e.substr(b)), e = e.toLowerCase(), "none" !== e && c.push({
                    prefix: a,
                    method: e,
                    args: d
                })), d = [], e = g = ""
            };
            return a.split("").forEach(function (a) {
                if (0 !== h || !b.test(a)) {
                    switch (a) {
                        case'"':
                            f ? f === a && (f = null) : f = a;
                            break;
                        case"(":
                            if (f)break;
                            if (0 === h)return h = 1, void 0;
                            i++;
                            break;
                        case")":
                            if (f)break;
                            if (1 === h) {
                                if (0 === i)return h = 0, j(), void 0;
                                i--
                            }
                            break;
                        case",":
                            if (f)break;
                            if (0 === h)return j(), void 0;
                            if (1 === h && 0 === i && !e.match(/^url$/i))return d.push(g.trim()), g = "", void 0
                    }
                    0 === h ? e += a : g += a
                }
            }), j(), c
        }
    }, function (a, b) {
        "use strict";
        Object.defineProperty(b, "__esModule", {value: !0}), b.PATH = {VECTOR: 0, BEZIER_CURVE: 1, CIRCLE: 2}
    }, function (a, b, c) {
        "use strict";
        function F(a) {
            return a && a.__esModule ? a : {"default": a}
        }

        function G(a, b) {
            if (!(a instanceof b))throw new TypeError("Cannot call a class as a function")
        }

        var d, e, f, g, h, i, j, k, l, m, n, o, p, q, r, s, t, u, v, w, x, y, z, A, B, C, D, E, H, I, J;
        Object.defineProperty(b, "__esModule", {value: !0}), d = function () {
            function a(a, b) {
                var c, d;
                for (c = 0; c < b.length; c++)d = b[c], d.enumerable = d.enumerable || !1, d.configurable = !0, "value" in d && (d.writable = !0), Object.defineProperty(a, d.key, d)
            }

            return function (b, c, d) {
                return c && a(b.prototype, c), d && a(b, d), b
            }
        }(), e = c(0), f = F(e), g = c(3), h = c(4), i = c(12), j = c(33), k = c(34), l = c(35), m = c(36), n = c(37), o = c(38), p = c(8), q = c(39), r = c(40), s = c(18), t = c(17), u = c(19), v = c(11), w = c(41), x = c(20), y = c(42), z = c(43), A = c(44), B = c(45), C = c(2), D = c(21), E = c(14), H = ["INPUT", "TEXTAREA", "SELECT"], I = function () {
            function a(b, c, d, e) {
                var F, I, K, L, M, N, O, P, Q, g = this;
                G(this, a), this.parent = c, this.tagName = b.tagName, this.index = e, this.childNodes = [], this.listItems = [], "number" == typeof b.start && (this.listStart = b.start), F = b.ownerDocument.defaultView, I = F.pageXOffset, K = F.pageYOffset, L = F.getComputedStyle(b, null), M = k.parseDisplay(L.display), N = "radio" === b.type || "checkbox" === b.type, O = u.parsePosition(L.position), this.style = {
                    background: N ? D.INPUT_BACKGROUND : h.parseBackground(L, d),
                    border: N ? D.INPUT_BORDERS : i.parseBorder(L),
                    borderRadius: (b instanceof F.HTMLInputElement || b instanceof HTMLInputElement) && N ? D.getInputBorderRadius(b) : j.parseBorderRadius(L),
                    color: N ? D.INPUT_COLOR : new f.default(L.color),
                    display: M,
                    "float": l.parseCSSFloat(L.float),
                    font: m.parseFont(L),
                    letterSpacing: n.parseLetterSpacing(L.letterSpacing),
                    listStyle: M === k.DISPLAY.LIST_ITEM ? p.parseListStyle(L) : null,
                    lineBreak: o.parseLineBreak(L.lineBreak),
                    margin: q.parseMargin(L),
                    opacity: parseFloat(L.opacity),
                    overflow: -1 === H.indexOf(b.tagName) ? r.parseOverflow(L.overflow) : r.OVERFLOW.HIDDEN,
                    overflowWrap: s.parseOverflowWrap(L.overflowWrap ? L.overflowWrap : L.wordWrap),
                    padding: t.parsePadding(L),
                    position: O,
                    textDecoration: v.parseTextDecoration(L),
                    textShadow: w.parseTextShadow(L.textShadow),
                    textTransform: x.parseTextTransform(L.textTransform),
                    transform: y.parseTransform(L),
                    visibility: z.parseVisibility(L.visibility),
                    wordBreak: A.parseWordBreak(L.wordBreak),
                    zIndex: B.parseZIndex(O !== u.POSITION.STATIC ? L.zIndex : "auto")
                }, this.isTransformed() && (b.style.transform = "matrix(1,0,0,1,0,0)"), M === k.DISPLAY.LIST_ITEM && (P = E.getListOwner(this), P && (Q = P.listItems.length, P.listItems.push(this), this.listIndex = b.hasAttribute("value") && "number" == typeof b.value ? b.value : 0 === Q ? "number" == typeof P.listStart ? P.listStart : 1 : P.listItems[Q - 1].listIndex + 1)), "IMG" === b.tagName && b.addEventListener("load", function () {
                    g.bounds = C.parseBounds(b, I, K), g.curvedBounds = C.parseBoundCurves(g.bounds, g.style.border, g.style.borderRadius)
                }), this.image = J(b, d), this.bounds = N ? D.reformatInputBounds(C.parseBounds(b, I, K)) : C.parseBounds(b, I, K), this.curvedBounds = C.parseBoundCurves(this.bounds, this.style.border, this.style.borderRadius), this.name = "" + b.tagName.toLowerCase() + (b.id ? "#" + b.id : "") + b.className.toString().split(" ").map(function (a) {
                        return a.length ? "." + a : ""
                    }).join("")
            }

            return d(a, [{
                key: "getClipPaths", value: function () {
                    var a = this.parent ? this.parent.getClipPaths() : [],
                        b = this.style.overflow !== r.OVERFLOW.VISIBLE;
                    return b ? a.concat([C.calculatePaddingBoxPath(this.curvedBounds)]) : a
                }
            }, {
                key: "isInFlow", value: function () {
                    return this.isRootElement() && !this.isFloating() && !this.isAbsolutelyPositioned()
                }
            }, {
                key: "isVisible", value: function () {
                    return !g.contains(this.style.display, k.DISPLAY.NONE) && this.style.opacity > 0 && this.style.visibility === z.VISIBILITY.VISIBLE
                }
            }, {
                key: "isAbsolutelyPositioned", value: function () {
                    return this.style.position !== u.POSITION.STATIC && this.style.position !== u.POSITION.RELATIVE
                }
            }, {
                key: "isPositioned", value: function () {
                    return this.style.position !== u.POSITION.STATIC
                }
            }, {
                key: "isFloating", value: function () {
                    return this.style.float !== l.FLOAT.NONE
                }
            }, {
                key: "isRootElement", value: function () {
                    return null === this.parent
                }
            }, {
                key: "isTransformed", value: function () {
                    return null !== this.style.transform
                }
            }, {
                key: "isPositionedWithZIndex", value: function () {
                    return this.isPositioned() && !this.style.zIndex.auto
                }
            }, {
                key: "isInlineLevel", value: function () {
                    return g.contains(this.style.display, k.DISPLAY.INLINE) || g.contains(this.style.display, k.DISPLAY.INLINE_BLOCK) || g.contains(this.style.display, k.DISPLAY.INLINE_FLEX) || g.contains(this.style.display, k.DISPLAY.INLINE_GRID) || g.contains(this.style.display, k.DISPLAY.INLINE_LIST_ITEM) || g.contains(this.style.display, k.DISPLAY.INLINE_TABLE)
                }
            }, {
                key: "isInlineBlockOrInlineTable", value: function () {
                    return g.contains(this.style.display, k.DISPLAY.INLINE_BLOCK) || g.contains(this.style.display, k.DISPLAY.INLINE_TABLE)
                }
            }]), a
        }(), b.default = I, J = function (a, b) {
            var c, d, e, f;
            if (a instanceof a.ownerDocument.defaultView.SVGSVGElement || a instanceof SVGSVGElement)return c = new XMLSerializer, b.loadImage("data:image/svg+xml," + encodeURIComponent(c.serializeToString(a)));
            switch (a.tagName) {
                case"IMG":
                    return d = a, b.loadImage(d.currentSrc || d.src);
                case"CANVAS":
                    return e = a, b.loadCanvas(e);
                case"IFRAME":
                    if (f = a.getAttribute("data-html2canvas-internal-iframe-key"))return f
            }
            return null
        }
    }, function (a, b, c) {
        "use strict";
        function e(a, b) {
            if (!(a instanceof b))throw new TypeError("Cannot call a class as a function")
        }

        var d, f;
        Object.defineProperty(b, "__esModule", {value: !0}), d = c(5), f = function g(a, b) {
            e(this, g), this.type = d.PATH.VECTOR, this.x = a, this.y = b, isNaN(a) && console.error("Invalid x value given for Vector"), isNaN(b) && console.error("Invalid y value given for Vector")
        }, b.default = f
    }, function (a, b, c) {
        "use strict";
        var d, e, f, g, i;
        Object.defineProperty(b, "__esModule", {value: !0}), b.parseListStyle = b.parseListStyleType = b.LIST_STYLE_TYPE = b.LIST_STYLE_POSITION = void 0, d = c(4), e = b.LIST_STYLE_POSITION = {
            INSIDE: 0,
            OUTSIDE: 1
        }, f = b.LIST_STYLE_TYPE = {
            NONE: -1,
            DISC: 0,
            CIRCLE: 1,
            SQUARE: 2,
            DECIMAL: 3,
            CJK_DECIMAL: 4,
            DECIMAL_LEADING_ZERO: 5,
            LOWER_ROMAN: 6,
            UPPER_ROMAN: 7,
            LOWER_GREEK: 8,
            LOWER_ALPHA: 9,
            UPPER_ALPHA: 10,
            ARABIC_INDIC: 11,
            ARMENIAN: 12,
            BENGALI: 13,
            CAMBODIAN: 14,
            CJK_EARTHLY_BRANCH: 15,
            CJK_HEAVENLY_STEM: 16,
            CJK_IDEOGRAPHIC: 17,
            DEVANAGARI: 18,
            ETHIOPIC_NUMERIC: 19,
            GEORGIAN: 20,
            GUJARATI: 21,
            GURMUKHI: 22,
            HEBREW: 22,
            HIRAGANA: 23,
            HIRAGANA_IROHA: 24,
            JAPANESE_FORMAL: 25,
            JAPANESE_INFORMAL: 26,
            KANNADA: 27,
            KATAKANA: 28,
            KATAKANA_IROHA: 29,
            KHMER: 30,
            KOREAN_HANGUL_FORMAL: 31,
            KOREAN_HANJA_FORMAL: 32,
            KOREAN_HANJA_INFORMAL: 33,
            LAO: 34,
            LOWER_ARMENIAN: 35,
            MALAYALAM: 36,
            MONGOLIAN: 37,
            MYANMAR: 38,
            ORIYA: 39,
            PERSIAN: 40,
            SIMP_CHINESE_FORMAL: 41,
            SIMP_CHINESE_INFORMAL: 42,
            TAMIL: 43,
            TELUGU: 44,
            THAI: 45,
            TIBETAN: 46,
            TRAD_CHINESE_FORMAL: 47,
            TRAD_CHINESE_INFORMAL: 48,
            UPPER_ARMENIAN: 49,
            DISCLOSURE_OPEN: 50,
            DISCLOSURE_CLOSED: 51
        }, g = b.parseListStyleType = function (a) {
            switch (a) {
                case"disc":
                    return f.DISC;
                case"circle":
                    return f.CIRCLE;
                case"square":
                    return f.SQUARE;
                case"decimal":
                    return f.DECIMAL;
                case"cjk-decimal":
                    return f.CJK_DECIMAL;
                case"decimal-leading-zero":
                    return f.DECIMAL_LEADING_ZERO;
                case"lower-roman":
                    return f.LOWER_ROMAN;
                case"upper-roman":
                    return f.UPPER_ROMAN;
                case"lower-greek":
                    return f.LOWER_GREEK;
                case"lower-alpha":
                    return f.LOWER_ALPHA;
                case"upper-alpha":
                    return f.UPPER_ALPHA;
                case"arabic-indic":
                    return f.ARABIC_INDIC;
                case"armenian":
                    return f.ARMENIAN;
                case"bengali":
                    return f.BENGALI;
                case"cambodian":
                    return f.CAMBODIAN;
                case"cjk-earthly-branch":
                    return f.CJK_EARTHLY_BRANCH;
                case"cjk-heavenly-stem":
                    return f.CJK_HEAVENLY_STEM;
                case"cjk-ideographic":
                    return f.CJK_IDEOGRAPHIC;
                case"devanagari":
                    return f.DEVANAGARI;
                case"ethiopic-numeric":
                    return f.ETHIOPIC_NUMERIC;
                case"georgian":
                    return f.GEORGIAN;
                case"gujarati":
                    return f.GUJARATI;
                case"gurmukhi":
                    return f.GURMUKHI;
                case"hebrew":
                    return f.HEBREW;
                case"hiragana":
                    return f.HIRAGANA;
                case"hiragana-iroha":
                    return f.HIRAGANA_IROHA;
                case"japanese-formal":
                    return f.JAPANESE_FORMAL;
                case"japanese-informal":
                    return f.JAPANESE_INFORMAL;
                case"kannada":
                    return f.KANNADA;
                case"katakana":
                    return f.KATAKANA;
                case"katakana-iroha":
                    return f.KATAKANA_IROHA;
                case"khmer":
                    return f.KHMER;
                case"korean-hangul-formal":
                    return f.KOREAN_HANGUL_FORMAL;
                case"korean-hanja-formal":
                    return f.KOREAN_HANJA_FORMAL;
                case"korean-hanja-informal":
                    return f.KOREAN_HANJA_INFORMAL;
                case"lao":
                    return f.LAO;
                case"lower-armenian":
                    return f.LOWER_ARMENIAN;
                case"malayalam":
                    return f.MALAYALAM;
                case"mongolian":
                    return f.MONGOLIAN;
                case"myanmar":
                    return f.MYANMAR;
                case"oriya":
                    return f.ORIYA;
                case"persian":
                    return f.PERSIAN;
                case"simp-chinese-formal":
                    return f.SIMP_CHINESE_FORMAL;
                case"simp-chinese-informal":
                    return f.SIMP_CHINESE_INFORMAL;
                case"tamil":
                    return f.TAMIL;
                case"telugu":
                    return f.TELUGU;
                case"thai":
                    return f.THAI;
                case"tibetan":
                    return f.TIBETAN;
                case"trad-chinese-formal":
                    return f.TRAD_CHINESE_FORMAL;
                case"trad-chinese-informal":
                    return f.TRAD_CHINESE_INFORMAL;
                case"upper-armenian":
                    return f.UPPER_ARMENIAN;
                case"disclosure-open":
                    return f.DISCLOSURE_OPEN;
                case"disclosure-closed":
                    return f.DISCLOSURE_CLOSED;
                case"none":
                default:
                    return f.NONE
            }
        }, b.parseListStyle = function (a) {
            var b = d.parseBackgroundImage(a.getPropertyValue("list-style-image"));
            return {
                listStyleType: g(a.getPropertyValue("list-style-type")),
                listStyleImage: b.length ? b[0] : null,
                listStylePosition: i(a.getPropertyValue("list-style-position"))
            }
        }, i = function (a) {
            switch (a) {
                case"inside":
                    return e.INSIDE;
                case"outside":
                default:
                    return e.OUTSIDE
            }
        }
    }, function (a, b, c) {
        "use strict";
        function g(a, b) {
            if (!(a instanceof b))throw new TypeError("Cannot call a class as a function")
        }

        function k(a, b, c) {
            return a.length > 0 ? b + c.toUpperCase() : a
        }

        var d, e, f, h, i, j;
        Object.defineProperty(b, "__esModule", {value: !0}), d = function () {
            function a(a, b) {
                var c, d;
                for (c = 0; c < b.length; c++)d = b[c], d.enumerable = d.enumerable || !1, d.configurable = !0, "value" in d && (d.writable = !0), Object.defineProperty(a, d.key, d)
            }

            return function (b, c, d) {
                return c && a(b.prototype, c), d && a(b, d), b
            }
        }(), e = c(20), f = c(22), h = function () {
            function a(b, c, d) {
                g(this, a), this.text = b, this.parent = c, this.bounds = d
            }

            return d(a, null, [{
                key: "fromTextNode", value: function (b, c) {
                    var d = j(b.data, c.style.textTransform);
                    return new a(d, c, f.parseTextBounds(d, c, b))
                }
            }]), a
        }(), b.default = h, i = /(^|\s|:|-|\(|\))([a-z])/g, j = function (a, b) {
            switch (b) {
                case e.TEXT_TRANSFORM.LOWERCASE:
                    return a.toLowerCase();
                case e.TEXT_TRANSFORM.CAPITALIZE:
                    return a.replace(i, k);
                case e.TEXT_TRANSFORM.UPPERCASE:
                    return a.toUpperCase();
                default:
                    return a
            }
        }
    }, function (a, b, c) {
        "use strict";
        var d, e, f, g, h, i, j, k, l;
        Object.defineProperty(b, "__esModule", {value: !0}), d = c(23), e = function (a) {
            var c, d, e, f, b = 123;
            return a.createRange && (c = a.createRange(), c.getBoundingClientRect && (d = a.createElement("boundtest"), d.style.height = b + "px", d.style.display = "block", a.body.appendChild(d), c.selectNode(d), e = c.getBoundingClientRect(), f = Math.round(e.height), a.body.removeChild(d), f === b)) ? !0 : !1
        }, f = function (a, b) {
            var c = new Image, d = a.createElement("canvas"), e = d.getContext("2d");
            return new Promise(function (a) {
                c.src = b;
                var f = function () {
                    try {
                        e.drawImage(c, 0, 0), d.toDataURL()
                    } catch (b) {
                        return a(!1)
                    }
                    return a(!0)
                };
                c.onload = f, c.onerror = function () {
                    return a(!1)
                }, c.complete === !0 && setTimeout(function () {
                    f()
                }, 500)
            })
        }, g = function () {
            return "undefined" != typeof(new Image).crossOrigin
        }, h = function () {
            return "string" == typeof(new XMLHttpRequest).responseType
        }, i = function (a) {
            var b = new Image, c = a.createElement("canvas"), d = c.getContext("2d");
            b.src = "data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg'></svg>";
            try {
                d.drawImage(b, 0, 0), c.toDataURL()
            } catch (e) {
                return !1
            }
            return !0
        }, j = function (a) {
            return 0 === a[0] && 255 === a[1] && 0 === a[2] && 255 === a[3]
        }, k = function (a) {
            var e, f, g, h, b = a.createElement("canvas"), c = 100;
            return b.width = c, b.height = c, e = b.getContext("2d"), e.fillStyle = "rgb(0, 255, 0)", e.fillRect(0, 0, c, c), f = new Image, g = b.toDataURL(), f.src = g, h = d.createForeignObjectSVG(c, c, 0, 0, f), e.fillStyle = "red", e.fillRect(0, 0, c, c), d.loadSerializedSVG(h).then(function (b) {
                var f, h;
                return e.drawImage(b, 0, 0), f = e.getImageData(0, 0, c, c).data, e.fillStyle = "red", e.fillRect(0, 0, c, c), h = a.createElement("div"), h.style.backgroundImage = "url(" + g + ")", h.style.height = c + "px", j(f) ? d.loadSerializedSVG(d.createForeignObjectSVG(c, c, 0, 0, h)) : Promise.reject(!1)
            }).then(function (a) {
                return e.drawImage(a, 0, 0), j(e.getImageData(0, 0, c, c).data)
            }).catch(function () {
                return !1
            })
        }, l = {
            get SUPPORT_RANGE_BOUNDS() {
                var a = e(document);
                return Object.defineProperty(l, "SUPPORT_RANGE_BOUNDS", {value: a}), a
            }, get SUPPORT_SVG_DRAWING() {
                var a = i(document);
                return Object.defineProperty(l, "SUPPORT_SVG_DRAWING", {value: a}), a
            }, get SUPPORT_BASE64_DRAWING() {
                return function (a) {
                    var b = f(document, a);
                    return Object.defineProperty(l, "SUPPORT_BASE64_DRAWING", {
                        value: function () {
                            return b
                        }
                    }), b
                }
            }, get SUPPORT_FOREIGNOBJECT_DRAWING() {
                var a = "function" == typeof Array.from && "function" == typeof window.fetch ? k(document) : Promise.resolve(!1);
                return Object.defineProperty(l, "SUPPORT_FOREIGNOBJECT_DRAWING", {value: a}), a
            }, get SUPPORT_CORS_IMAGES() {
                var a = g();
                return Object.defineProperty(l, "SUPPORT_CORS_IMAGES", {value: a}), a
            }, get SUPPORT_RESPONSE_TYPE() {
                var a = h();
                return Object.defineProperty(l, "SUPPORT_RESPONSE_TYPE", {value: a}), a
            }, get SUPPORT_CORS_XHR() {
                var a = "withCredentials" in new XMLHttpRequest;
                return Object.defineProperty(l, "SUPPORT_CORS_XHR", {value: a}), a
            }
        }, b.default = l
    }, function (a, b, c) {
        "use strict";
        function f(a) {
            return a && a.__esModule ? a : {"default": a}
        }

        var d, e, g, h, i, j, k, l;
        Object.defineProperty(b, "__esModule", {value: !0}), b.parseTextDecoration = b.TEXT_DECORATION_LINE = b.TEXT_DECORATION = b.TEXT_DECORATION_STYLE = void 0, d = c(0), e = f(d), g = b.TEXT_DECORATION_STYLE = {
            SOLID: 0,
            DOUBLE: 1,
            DOTTED: 2,
            DASHED: 3,
            WAVY: 4
        }, h = b.TEXT_DECORATION = {NONE: null}, i = b.TEXT_DECORATION_LINE = {
            UNDERLINE: 1,
            OVERLINE: 2,
            LINE_THROUGH: 3,
            BLINK: 4
        }, j = function (a) {
            switch (a) {
                case"underline":
                    return i.UNDERLINE;
                case"overline":
                    return i.OVERLINE;
                case"line-through":
                    return i.LINE_THROUGH
            }
            return i.BLINK
        }, k = function (a) {
            return "none" === a ? null : a.split(" ").map(j)
        }, l = function (a) {
            switch (a) {
                case"double":
                    return g.DOUBLE;
                case"dotted":
                    return g.DOTTED;
                case"dashed":
                    return g.DASHED;
                case"wavy":
                    return g.WAVY
            }
            return g.SOLID
        }, b.parseTextDecoration = function (a) {
            var c, d, b = k(a.textDecorationLine ? a.textDecorationLine : a.textDecoration);
            return null === b ? h.NONE : (c = a.textDecorationColor ? new e.default(a.textDecorationColor) : null, d = l(a.textDecorationStyle), {
                textDecorationLine: b,
                textDecorationColor: c,
                textDecorationStyle: d
            })
        }
    }, function (a, b, c) {
        "use strict";
        function f(a) {
            return a && a.__esModule ? a : {"default": a}
        }

        var d, e, g, h, i, j;
        Object.defineProperty(b, "__esModule", {value: !0}), b.parseBorder = b.BORDER_SIDES = b.BORDER_STYLE = void 0, d = c(0), e = f(d), g = b.BORDER_STYLE = {
            NONE: 0,
            SOLID: 1
        }, h = b.BORDER_SIDES = {TOP: 0, RIGHT: 1, BOTTOM: 2, LEFT: 3}, i = Object.keys(h).map(function (a) {
            return a.toLowerCase()
        }), j = function (a) {
            switch (a) {
                case"none":
                    return g.NONE
            }
            return g.SOLID
        }, b.parseBorder = function (a) {
            return i.map(function (b) {
                var c = new e.default(a.getPropertyValue("border-" + b + "-color")),
                    d = j(a.getPropertyValue("border-" + b + "-style")),
                    f = parseFloat(a.getPropertyValue("border-" + b + "-width"));
                return {borderColor: c, borderStyle: d, borderWidth: isNaN(f) ? 0 : f}
            })
        }
    }, function (a, b) {
        "use strict";
        var f, g, h;
        for (Object.defineProperty(b, "__esModule", {value: !0}), b.toCodePoints = function (a) {
            for (var e, f, b = [], c = 0, d = a.length; d > c;)e = a.charCodeAt(c++), e >= 55296 && 56319 >= e && d > c ? (f = a.charCodeAt(c++), 56320 === (64512 & f) ? b.push(((1023 & e) << 10) + (1023 & f) + 65536) : (b.push(e), c--)) : b.push(e);
            return b
        }, b.fromCodePoint = function () {
            var a, b, c, d, e;
            if (String.fromCodePoint)return String.fromCodePoint.apply(String, arguments);
            if (a = arguments.length, !a)return "";
            for (b = [], c = -1, d = ""; ++c < a;)e = arguments.length <= c ? void 0 : arguments[c], 65535 >= e ? b.push(e) : (e -= 65536, b.push((e >> 10) + 55296, e % 1024 + 56320)), (c + 1 === a || b.length > 16384) && (d += String.fromCharCode.apply(String, b), b.length = 0);
            return d
        }, f = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/", g = "undefined" == typeof Uint8Array ? [] : new Uint8Array(256), h = 0; h < f.length; h++)g[f.charCodeAt(h)] = h;
        b.decode = function (a) {
            var k, l, b = .75 * a.length, c = a.length, d = void 0, e = 0, f = void 0, h = void 0, i = void 0,
                j = void 0;
            for ("=" === a[a.length - 1] && (b--, "=" === a[a.length - 2] && b--), k = "undefined" != typeof ArrayBuffer && "undefined" != typeof Uint8Array && "undefined" != typeof Uint8Array.prototype.slice ? new ArrayBuffer(b) : new Array(b), l = Array.isArray(k) ? k : new Uint8Array(k), d = 0; c > d; d += 4)f = g[a.charCodeAt(d)], h = g[a.charCodeAt(d + 1)], i = g[a.charCodeAt(d + 2)], j = g[a.charCodeAt(d + 3)], l[e++] = f << 2 | h >> 4, l[e++] = (15 & h) << 4 | i >> 2, l[e++] = (3 & i) << 6 | 63 & j;
            return k
        }, b.polyUint16Array = function (a) {
            var d, b = a.length, c = [];
            for (d = 0; b > d; d += 2)c.push(a[d + 1] << 8 | a[d]);
            return c
        }, b.polyUint32Array = function (a) {
            var d, b = a.length, c = [];
            for (d = 0; b > d; d += 4)c.push(a[d + 3] << 24 | a[d + 2] << 16 | a[d + 1] << 8 | a[d]);
            return c
        }
    }, function (a, b, c) {
        "use strict";
        function k(a) {
            return a && a.__esModule ? a : {"default": a}
        }

        var d, e, f, g, h, i, j, l, m, p, q, r, s, t, u, v, w, x, y, z, A, B, C, D, E, F, G;
        Object.defineProperty(b, "__esModule", {value: !0}), b.createCounterText = b.inlineListItemElement = b.getListOwner = void 0, d = c(3), e = c(6), f = k(e), g = c(9), h = k(g), i = c(8), j = c(24), l = 7, m = ["OL", "UL", "MENU"], b.getListOwner = function (a) {
            var c, b = a.parent;
            if (!b)return null;
            do {
                if (c = -1 !== m.indexOf(b.tagName))return b;
                b = b.parent
            } while (b);
            return a.parent
        }, b.inlineListItemElement = function (a, b, c) {
            var g, j, k, m, n, o, p, q, e = b.style.listStyle;
            if (e) {
                switch (g = a.ownerDocument.defaultView.getComputedStyle(a, null), j = a.ownerDocument.createElement("html2canvaswrapper"), d.copyCSSStyles(g, j), j.style.position = "absolute", j.style.bottom = "auto", j.style.display = "block", j.style.letterSpacing = "normal", e.listStylePosition) {
                    case i.LIST_STYLE_POSITION.OUTSIDE:
                        j.style.left = "auto", j.style.right = a.ownerDocument.defaultView.innerWidth - b.bounds.left - b.style.margin[1].getAbsoluteValue(b.bounds.width) + l + "px", j.style.textAlign = "right";
                        break;
                    case i.LIST_STYLE_POSITION.INSIDE:
                        j.style.left = b.bounds.left - b.style.margin[3].getAbsoluteValue(b.bounds.width) + "px", j.style.right = "auto", j.style.textAlign = "left"
                }
                k = void 0, m = b.style.margin[0].getAbsoluteValue(b.bounds.width), n = e.listStyleImage, n ? "url" === n.method ? (o = a.ownerDocument.createElement("img"), o.src = n.args[0], j.style.top = b.bounds.top - m + "px", j.style.width = "auto", j.style.height = "auto", j.appendChild(o)) : (p = .5 * parseFloat(b.style.font.fontSize), j.style.top = b.bounds.top - m + b.bounds.height - 1.5 * p + "px", j.style.width = p + "px", j.style.height = p + "px", j.style.backgroundImage = g.listStyleImage) : "number" == typeof b.listIndex && (k = a.ownerDocument.createTextNode(G(b.listIndex, e.listStyleType, !0)), j.appendChild(k), j.style.top = b.bounds.top - m + "px"), q = a.ownerDocument.body, q.appendChild(j), k ? (b.childNodes.push(h.default.fromTextNode(k, b)), q.removeChild(j)) : b.childNodes.push(new f.default(j, b, c, 0))
            }
        }, p = {
            integers: [1e3, 900, 500, 400, 100, 90, 50, 40, 10, 9, 5, 4, 1],
            values: ["M", "CM", "D", "CD", "C", "XC", "L", "XL", "X", "IX", "V", "IV", "I"]
        }, q = {
            integers: [9e3, 8e3, 7e3, 6e3, 5e3, 4e3, 3e3, 2e3, 1e3, 900, 800, 700, 600, 500, 400, 300, 200, 100, 90, 80, 70, 60, 50, 40, 30, 20, 10, 9, 8, 7, 6, 5, 4, 3, 2, 1],
            values: ["Ք", "Փ", "Ւ", "Ց", "Ր", "Տ", "Վ", "Ս", "Ռ", "Ջ", "Պ", "Չ", "Ո", "Շ", "Ն", "Յ", "Մ", "Ճ", "Ղ", "Ձ", "Հ", "Կ", "Ծ", "Խ", "Լ", "Ի", "Ժ", "Թ", "Ը", "Է", "Զ", "Ե", "Դ", "Գ", "Բ", "Ա"]
        }, r = {
            integers: [1e4, 9e3, 8e3, 7e3, 6e3, 5e3, 4e3, 3e3, 2e3, 1e3, 400, 300, 200, 100, 90, 80, 70, 60, 50, 40, 30, 20, 19, 18, 17, 16, 15, 10, 9, 8, 7, 6, 5, 4, 3, 2, 1],
            values: ["י׳", "ט׳", "ח׳", "ז׳", "ו׳", "ה׳", "ד׳", "ג׳", "ב׳", "א׳", "ת", "ש", "ר", "ק", "צ", "פ", "ע", "ס", "נ", "מ", "ל", "כ", "יט", "יח", "יז", "טז", "טו", "י", "ט", "ח", "ז", "ו", "ה", "ד", "ג", "ב", "א"]
        }, s = {
            integers: [1e4, 9e3, 8e3, 7e3, 6e3, 5e3, 4e3, 3e3, 2e3, 1e3, 900, 800, 700, 600, 500, 400, 300, 200, 100, 90, 80, 70, 60, 50, 40, 30, 20, 10, 9, 8, 7, 6, 5, 4, 3, 2, 1],
            values: ["ჵ", "ჰ", "ჯ", "ჴ", "ხ", "ჭ", "წ", "ძ", "ც", "ჩ", "შ", "ყ", "ღ", "ქ", "ფ", "ჳ", "ტ", "ს", "რ", "ჟ", "პ", "ო", "ჲ", "ნ", "მ", "ლ", "კ", "ი", "თ", "ჱ", "ზ", "ვ", "ე", "დ", "გ", "ბ", "ა"]
        }, t = function (a, b, c, d, e, f) {
            return b > a || a > c ? G(a, e, f.length > 0) : d.integers.reduce(function (b, c, e) {
                    for (; a >= c;)a -= c, b += d.values[e];
                    return b
                }, "") + f
        }, u = function (a, b, c, d) {
            var e = "";
            do c || a--, e = d(a) + e, a /= b; while (a * b >= b);
            return e
        }, v = function (a, b, c, d, e) {
            var f = c - b + 1;
            return (0 > a ? "-" : "") + (u(Math.abs(a), f, d, function (a) {
                    return j.fromCodePoint(Math.floor(a % f) + b)
                }) + e)
        }, w = function (a, b) {
            var c = arguments.length > 2 && void 0 !== arguments[2] ? arguments[2] : ". ", d = b.length;
            return u(Math.abs(a), d, !1, function (a) {
                    return b[Math.floor(a % d)]
                }) + c
        }, x = 1, y = 2, z = 4, A = 8, B = function (a, b, c, e, f, g) {
            var h, j, k, l;
            if (-9999 > a || a > 9999)return G(a, i.LIST_STYLE_TYPE.CJK_DECIMAL, f.length > 0);
            if (h = Math.abs(a), j = f, 0 === h)return b[0] + j;
            for (k = 0; h > 0 && 4 >= k; k++)l = h % 10, 0 === l && d.contains(g, x) && "" !== j ? j = b[l] + j : l > 1 || 1 === l && 0 === k || 1 === l && 1 === k && d.contains(g, y) || 1 === l && 1 === k && d.contains(g, z) && a > 100 || 1 === l && k > 1 && d.contains(g, A) ? j = b[l] + (k > 0 ? c[k - 1] : "") + j : 1 === l && k > 0 && (j = c[k - 1] + j), h = Math.floor(h / 10);
            return (0 > a ? e : "") + j
        }, C = "十百千萬", D = "拾佰仟萬", E = "マイナス", F = "마이너스 ", G = b.createCounterText = function (a, b, c) {
            var g, d = c ? ". " : "", e = c ? "、" : "", f = c ? ", " : "";
            switch (b) {
                case i.LIST_STYLE_TYPE.DISC:
                    return "•";
                case i.LIST_STYLE_TYPE.CIRCLE:
                    return "◦";
                case i.LIST_STYLE_TYPE.SQUARE:
                    return "◾";
                case i.LIST_STYLE_TYPE.DECIMAL_LEADING_ZERO:
                    return g = v(a, 48, 57, !0, d), g.length < 4 ? "0" + g : g;
                case i.LIST_STYLE_TYPE.CJK_DECIMAL:
                    return w(a, "〇一二三四五六七八九", e);
                case i.LIST_STYLE_TYPE.LOWER_ROMAN:
                    return t(a, 1, 3999, p, i.LIST_STYLE_TYPE.DECIMAL, d).toLowerCase();
                case i.LIST_STYLE_TYPE.UPPER_ROMAN:
                    return t(a, 1, 3999, p, i.LIST_STYLE_TYPE.DECIMAL, d);
                case i.LIST_STYLE_TYPE.LOWER_GREEK:
                    return v(a, 945, 969, !1, d);
                case i.LIST_STYLE_TYPE.LOWER_ALPHA:
                    return v(a, 97, 122, !1, d);
                case i.LIST_STYLE_TYPE.UPPER_ALPHA:
                    return v(a, 65, 90, !1, d);
                case i.LIST_STYLE_TYPE.ARABIC_INDIC:
                    return v(a, 1632, 1641, !0, d);
                case i.LIST_STYLE_TYPE.ARMENIAN:
                case i.LIST_STYLE_TYPE.UPPER_ARMENIAN:
                    return t(a, 1, 9999, q, i.LIST_STYLE_TYPE.DECIMAL, d);
                case i.LIST_STYLE_TYPE.LOWER_ARMENIAN:
                    return t(a, 1, 9999, q, i.LIST_STYLE_TYPE.DECIMAL, d).toLowerCase();
                case i.LIST_STYLE_TYPE.BENGALI:
                    return v(a, 2534, 2543, !0, d);
                case i.LIST_STYLE_TYPE.CAMBODIAN:
                case i.LIST_STYLE_TYPE.KHMER:
                    return v(a, 6112, 6121, !0, d);
                case i.LIST_STYLE_TYPE.CJK_EARTHLY_BRANCH:
                    return w(a, "子丑寅卯辰巳午未申酉戌亥", e);
                case i.LIST_STYLE_TYPE.CJK_HEAVENLY_STEM:
                    return w(a, "甲乙丙丁戊己庚辛壬癸", e);
                case i.LIST_STYLE_TYPE.CJK_IDEOGRAPHIC:
                case i.LIST_STYLE_TYPE.TRAD_CHINESE_INFORMAL:
                    return B(a, "零一二三四五六七八九", C, "負", e, y | z | A);
                case i.LIST_STYLE_TYPE.TRAD_CHINESE_FORMAL:
                    return B(a, "零壹貳參肆伍陸柒捌玖", D, "負", e, x | y | z | A);
                case i.LIST_STYLE_TYPE.SIMP_CHINESE_INFORMAL:
                    return B(a, "零一二三四五六七八九", C, "负", e, y | z | A);
                case i.LIST_STYLE_TYPE.SIMP_CHINESE_FORMAL:
                    return B(a, "零壹贰叁肆伍陆柒捌玖", D, "负", e, x | y | z | A);
                case i.LIST_STYLE_TYPE.JAPANESE_INFORMAL:
                    return B(a, "〇一二三四五六七八九", "十百千万", E, e, 0);
                case i.LIST_STYLE_TYPE.JAPANESE_FORMAL:
                    return B(a, "零壱弐参四伍六七八九", "拾百千万", E, e, x | y | z);
                case i.LIST_STYLE_TYPE.KOREAN_HANGUL_FORMAL:
                    return B(a, "영일이삼사오육칠팔구", "십백천만", F, f, x | y | z);
                case i.LIST_STYLE_TYPE.KOREAN_HANJA_INFORMAL:
                    return B(a, "零一二三四五六七八九", "十百千萬", F, f, 0);
                case i.LIST_STYLE_TYPE.KOREAN_HANJA_FORMAL:
                    return B(a, "零壹貳參四五六七八九", "拾百千", F, f, x | y | z);
                case i.LIST_STYLE_TYPE.DEVANAGARI:
                    return v(a, 2406, 2415, !0, d);
                case i.LIST_STYLE_TYPE.GEORGIAN:
                    return t(a, 1, 19999, s, i.LIST_STYLE_TYPE.DECIMAL, d);
                case i.LIST_STYLE_TYPE.GUJARATI:
                    return v(a, 2790, 2799, !0, d);
                case i.LIST_STYLE_TYPE.GURMUKHI:
                    return v(a, 2662, 2671, !0, d);
                case i.LIST_STYLE_TYPE.HEBREW:
                    return t(a, 1, 10999, r, i.LIST_STYLE_TYPE.DECIMAL, d);
                case i.LIST_STYLE_TYPE.HIRAGANA:
                    return w(a, "あいうえおかきくけこさしすせそたちつてとなにぬねのはひふへほまみむめもやゆよらりるれろわゐゑをん");
                case i.LIST_STYLE_TYPE.HIRAGANA_IROHA:
                    return w(a, "いろはにほへとちりぬるをわかよたれそつねならむうゐのおくやまけふこえてあさきゆめみしゑひもせす");
                case i.LIST_STYLE_TYPE.KANNADA:
                    return v(a, 3302, 3311, !0, d);
                case i.LIST_STYLE_TYPE.KATAKANA:
                    return w(a, "アイウエオカキクケコサシスセソタチツテトナニヌネノハヒフヘホマミムメモヤユヨラリルレロワヰヱヲン", e);
                case i.LIST_STYLE_TYPE.KATAKANA_IROHA:
                    return w(a, "イロハニホヘトチリヌルヲワカヨタレソツネナラムウヰノオクヤマケフコエテアサキユメミシヱヒモセス", e);
                case i.LIST_STYLE_TYPE.LAO:
                    return v(a, 3792, 3801, !0, d);
                case i.LIST_STYLE_TYPE.MONGOLIAN:
                    return v(a, 6160, 6169, !0, d);
                case i.LIST_STYLE_TYPE.MYANMAR:
                    return v(a, 4160, 4169, !0, d);
                case i.LIST_STYLE_TYPE.ORIYA:
                    return v(a, 2918, 2927, !0, d);
                case i.LIST_STYLE_TYPE.PERSIAN:
                    return v(a, 1776, 1785, !0, d);
                case i.LIST_STYLE_TYPE.TAMIL:
                    return v(a, 3046, 3055, !0, d);
                case i.LIST_STYLE_TYPE.TELUGU:
                    return v(a, 3174, 3183, !0, d);
                case i.LIST_STYLE_TYPE.THAI:
                    return v(a, 3664, 3673, !0, d);
                case i.LIST_STYLE_TYPE.TIBETAN:
                    return v(a, 3872, 3881, !0, d);
                case i.LIST_STYLE_TYPE.DECIMAL:
                default:
                    return v(a, 48, 57, !0, d)
            }
        }
    }, function (a, b, c) {
        "use strict";
        function g(a, b) {
            if (!(a instanceof b))throw new TypeError("Cannot call a class as a function")
        }

        var d, e, f, h, i;
        Object.defineProperty(b, "__esModule", {value: !0}), d = function () {
            function a(a, b) {
                var c, d;
                for (c = 0; c < b.length; c++)d = b[c], d.enumerable = d.enumerable || !1, d.configurable = !0, "value" in d && (d.writable = !0), Object.defineProperty(a, d.key, d)
            }

            return function (b, c, d) {
                return c && a(b.prototype, c), d && a(b, d), b
            }
        }(), e = c(5), f = c(11), h = function (a, b) {
            var c = Math.max.apply(null, a.colorStops.map(function (a) {
                return a.stop
            })), d = 1 / Math.max(1, c);
            a.colorStops.forEach(function (a) {
                b.addColorStop(d * a.stop, a.color.toString())
            })
        }, i = function () {
            function a(b) {
                g(this, a), this.canvas = b ? b : document.createElement("canvas")
            }

            return d(a, [{
                key: "render", value: function (a) {
                    this.ctx = this.canvas.getContext("2d"), this.options = a, this.canvas.width = Math.floor(a.width * a.scale), this.canvas.height = Math.floor(a.height * a.scale), this.canvas.style.width = a.width + "px", this.canvas.style.height = a.height + "px", this.ctx.scale(this.options.scale, this.options.scale), this.ctx.translate(-a.x, -a.y), this.ctx.textBaseline = "bottom", a.logger.log("Canvas renderer initialized (" + a.width + "x" + a.height + " at " + a.x + "," + a.y + ") with scale " + this.options.scale)
                }
            }, {
                key: "clip", value: function (a, b) {
                    var c = this;
                    a.length && (this.ctx.save(), a.forEach(function (a) {
                        c.path(a), c.ctx.clip()
                    })), b(), a.length && this.ctx.restore()
                }
            }, {
                key: "drawImage", value: function (a, b, c) {
                    this.ctx.drawImage(a, b.left, b.top, b.width, b.height, c.left, c.top, c.width, c.height)
                }
            }, {
                key: "drawShape", value: function (a, b) {
                    this.path(a), this.ctx.fillStyle = b.toString(), this.ctx.fill()
                }
            }, {
                key: "fill", value: function (a) {
                    this.ctx.fillStyle = a.toString(), this.ctx.fill()
                }
            }, {
                key: "getTarget", value: function () {
                    return this.canvas.getContext("2d").setTransform(1, 0, 0, 1, 0, 0), Promise.resolve(this.canvas)
                }
            }, {
                key: "path", value: function (a) {
                    var b = this;
                    this.ctx.beginPath(), Array.isArray(a) ? a.forEach(function (a, c) {
                        var d = a.type === e.PATH.VECTOR ? a : a.start;
                        0 === c ? b.ctx.moveTo(d.x, d.y) : b.ctx.lineTo(d.x, d.y), a.type === e.PATH.BEZIER_CURVE && b.ctx.bezierCurveTo(a.startControl.x, a.startControl.y, a.endControl.x, a.endControl.y, a.end.x, a.end.y)
                    }) : this.ctx.arc(a.x + a.radius, a.y + a.radius, a.radius, 0, 2 * Math.PI, !0), this.ctx.closePath()
                }
            }, {
                key: "rectangle", value: function (a, b, c, d, e) {
                    this.ctx.fillStyle = e.toString(), this.ctx.fillRect(a, b, c, d)
                }
            }, {
                key: "renderLinearGradient", value: function (a, b) {
                    var c = this.ctx.createLinearGradient(a.left + b.direction.x1, a.top + b.direction.y1, a.left + b.direction.x0, a.top + b.direction.y0);
                    h(b, c), this.ctx.fillStyle = c, this.ctx.fillRect(a.left, a.top, a.width, a.height)
                }
            }, {
                key: "renderRadialGradient", value: function (a, b) {
                    var g, i, j, k, c = this, d = a.left + b.center.x, e = a.top + b.center.y,
                        f = this.ctx.createRadialGradient(d, e, 0, d, e, b.radius.x);
                    f && (h(b, f), this.ctx.fillStyle = f, b.radius.x !== b.radius.y ? (g = a.left + .5 * a.width, i = a.top + .5 * a.height, j = b.radius.y / b.radius.x, k = 1 / j, this.transform(g, i, [1, 0, 0, j, 0, 0], function () {
                        return c.ctx.fillRect(a.left, k * (a.top - i) + i, a.width, a.height * k)
                    })) : this.ctx.fillRect(a.left, a.top, a.width, a.height))
                }
            }, {
                key: "renderRepeat", value: function (a, b, c, d, e) {
                    this.path(a), this.ctx.fillStyle = this.ctx.createPattern(this.resizeImage(b, c), "repeat"), this.ctx.translate(d, e), this.ctx.fill(), this.ctx.translate(-d, -e)
                }
            }, {
                key: "renderTextNode", value: function (a, b, c, d, e) {
                    var g = this;
                    this.ctx.font = [c.fontStyle, c.fontVariant, c.fontWeight, c.fontSize, c.fontFamily].join(" "), a.forEach(function (a) {
                        if (g.ctx.fillStyle = b.toString(), e && a.text.trim().length ? e.slice(0).reverse().forEach(function (b) {
                                g.ctx.shadowColor = b.color.toString(), g.ctx.shadowOffsetX = b.offsetX * g.options.scale, g.ctx.shadowOffsetY = b.offsetY * g.options.scale, g.ctx.shadowBlur = b.blur, g.ctx.fillText(a.text, a.bounds.left, a.bounds.top + a.bounds.height)
                            }) : g.ctx.fillText(a.text, a.bounds.left, a.bounds.top + a.bounds.height), null !== d) {
                            var h = d.textDecorationColor || b;
                            d.textDecorationLine.forEach(function (b) {
                                var d, e, i, j;
                                switch (b) {
                                    case f.TEXT_DECORATION_LINE.UNDERLINE:
                                        d = g.options.fontMetrics.getMetrics(c), e = d.baseline, g.rectangle(a.bounds.left, Math.round(a.bounds.top + e), a.bounds.width, 1, h);
                                        break;
                                    case f.TEXT_DECORATION_LINE.OVERLINE:
                                        g.rectangle(a.bounds.left, Math.round(a.bounds.top), a.bounds.width, 1, h);
                                        break;
                                    case f.TEXT_DECORATION_LINE.LINE_THROUGH:
                                        i = g.options.fontMetrics.getMetrics(c), j = i.middle, g.rectangle(a.bounds.left, Math.ceil(a.bounds.top + j), a.bounds.width, 1, h)
                                }
                            })
                        }
                    })
                }
            }, {
                key: "resizeImage", value: function (a, b) {
                    var c, d;
                    return a.width === b.width && a.height === b.height ? a : (c = this.canvas.ownerDocument.createElement("canvas"), c.width = b.width, c.height = b.height, d = c.getContext("2d"), d.drawImage(a, 0, 0, a.width, a.height, 0, 0, b.width, b.height), c)
                }
            }, {
                key: "setOpacity", value: function (a) {
                    this.ctx.globalAlpha = a
                }
            }, {
                key: "transform", value: function (a, b, c, d) {
                    this.ctx.save(), this.ctx.translate(a, b), this.ctx.transform(c[0], c[1], c[2], c[3], c[4], c[5]), this.ctx.translate(-a, -b), d(), this.ctx.restore()
                }
            }]), a
        }(), b.default = i
    }, function (a, b) {
        "use strict";
        function e(a, b) {
            if (!(a instanceof b))throw new TypeError("Cannot call a class as a function")
        }

        var d, f;
        Object.defineProperty(b, "__esModule", {value: !0}), d = function () {
            function a(a, b) {
                var c, d;
                for (c = 0; c < b.length; c++)d = b[c], d.enumerable = d.enumerable || !1, d.configurable = !0, "value" in d && (d.writable = !0), Object.defineProperty(a, d.key, d)
            }

            return function (b, c, d) {
                return c && a(b.prototype, c), d && a(b, d), b
            }
        }(), f = function () {
            function a(b, c, d) {
                e(this, a), this.enabled = "undefined" != typeof window && b, this.start = d ? d : Date.now(), this.id = c
            }

            return d(a, [{
                key: "child", value: function (b) {
                    return new a(this.enabled, b, this.start)
                }
            }, {
                key: "log", value: function () {
                    if (this.enabled && window.console && window.console.log) {
                        for (var a = arguments.length, b = Array(a), c = 0; a > c; c++)b[c] = arguments[c];
                        Function.prototype.bind.call(window.console.log, window.console).apply(window.console, [Date.now() - this.start + "ms", this.id ? "html2canvas (" + this.id + "):" : "html2canvas:"].concat([].slice.call(b, 0)))
                    }
                }
            }, {
                key: "error", value: function () {
                    if (this.enabled && window.console && window.console.error) {
                        for (var a = arguments.length, b = Array(a), c = 0; a > c; c++)b[c] = arguments[c];
                        Function.prototype.bind.call(window.console.error, window.console).apply(window.console, [Date.now() - this.start + "ms", this.id ? "html2canvas (" + this.id + "):" : "html2canvas:"].concat([].slice.call(b, 0)))
                    }
                }
            }]), a
        }(), b.default = f
    }, function (a, b, c) {
        "use strict";
        function f(a) {
            return a && a.__esModule ? a : {"default": a}
        }

        var d, e, h;
        Object.defineProperty(b, "__esModule", {value: !0}), b.parsePadding = b.PADDING_SIDES = void 0, d = c(1), e = f(d), b.PADDING_SIDES = {
            TOP: 0,
            RIGHT: 1,
            BOTTOM: 2,
            LEFT: 3
        }, h = ["top", "right", "bottom", "left"], b.parsePadding = function (a) {
            return h.map(function (b) {
                return new e.default(a.getPropertyValue("padding-" + b))
            })
        }
    }, function (a, b) {
        "use strict";
        Object.defineProperty(b, "__esModule", {value: !0});
        var d = b.OVERFLOW_WRAP = {NORMAL: 0, BREAK_WORD: 1};
        b.parseOverflowWrap = function (a) {
            switch (a) {
                case"break-word":
                    return d.BREAK_WORD;
                case"normal":
                default:
                    return d.NORMAL
            }
        }
    }, function (a, b) {
        "use strict";
        Object.defineProperty(b, "__esModule", {value: !0});
        var d = b.POSITION = {STATIC: 0, RELATIVE: 1, ABSOLUTE: 2, FIXED: 3, STICKY: 4};
        b.parsePosition = function (a) {
            switch (a) {
                case"relative":
                    return d.RELATIVE;
                case"absolute":
                    return d.ABSOLUTE;
                case"fixed":
                    return d.FIXED;
                case"sticky":
                    return d.STICKY
            }
            return d.STATIC
        }
    }, function (a, b) {
        "use strict";
        Object.defineProperty(b, "__esModule", {value: !0});
        var d = b.TEXT_TRANSFORM = {NONE: 0, LOWERCASE: 1, UPPERCASE: 2, CAPITALIZE: 3};
        b.parseTextTransform = function (a) {
            switch (a) {
                case"uppercase":
                    return d.UPPERCASE;
                case"lowercase":
                    return d.LOWERCASE;
                case"capitalize":
                    return d.CAPITALIZE
            }
            return d.NONE
        }
    }, function (a, b, c) {
        "use strict";
        function s(a) {
            return a && a.__esModule ? a : {"default": a}
        }

        var d, e, f, g, h, i, j, k, l, m, n, o, r, u, v, w, z, A, B, C, D, E, K, L;
        Object.defineProperty(b, "__esModule", {value: !0}), b.reformatInputBounds = b.inlineSelectElement = b.inlineTextAreaElement = b.inlineInputElement = b.getInputBorderRadius = b.INPUT_BACKGROUND = b.INPUT_BORDERS = b.INPUT_COLOR = void 0, d = c(9), e = s(d), f = c(4), g = c(12), h = c(50), i = s(h), j = c(7), k = s(j), l = c(0), m = s(l), n = c(1), o = s(n), c(2), c(22), r = c(3), b.INPUT_COLOR = new m.default([42, 42, 42]), u = new m.default([165, 165, 165]), v = new m.default([222, 222, 222]), w = {
            borderWidth: 1,
            borderColor: u,
            borderStyle: g.BORDER_STYLE.SOLID
        }, b.INPUT_BORDERS = [w, w, w, w], b.INPUT_BACKGROUND = {
            backgroundColor: v,
            backgroundImage: [],
            backgroundClip: f.BACKGROUND_CLIP.PADDING_BOX,
            backgroundOrigin: f.BACKGROUND_ORIGIN.PADDING_BOX
        }, z = new o.default("50%"), A = [z, z], B = [A, A, A, A], C = new o.default("3px"), D = [C, C], E = [D, D, D, D], b.getInputBorderRadius = function (a) {
            return "radio" === a.type ? B : E
        }, b.inlineInputElement = function (a, b) {
            if ("radio" === a.type || "checkbox" === a.type) {
                if (a.checked) {
                    var c = Math.min(b.bounds.width, b.bounds.height);
                    b.childNodes.push("checkbox" === a.type ? [new k.default(b.bounds.left + .39363 * c, b.bounds.top + .79 * c), new k.default(b.bounds.left + .16 * c, b.bounds.top + .5549 * c), new k.default(b.bounds.left + .27347 * c, b.bounds.top + .44071 * c), new k.default(b.bounds.left + .39694 * c, b.bounds.top + .5649 * c), new k.default(b.bounds.left + .72983 * c, b.bounds.top + .23 * c), new k.default(b.bounds.left + .84 * c, b.bounds.top + .34085 * c), new k.default(b.bounds.left + .39363 * c, b.bounds.top + .79 * c)] : new i.default(b.bounds.left + c / 4, b.bounds.top + c / 4, c / 4))
                }
            } else K(L(a), a, b, !1)
        }, b.inlineTextAreaElement = function (a, b) {
            K(a.value, a, b, !0)
        }, b.inlineSelectElement = function (a, b) {
            var c = a.options[a.selectedIndex || 0];
            K(c ? c.text || "" : "", a, b, !1)
        }, b.reformatInputBounds = function (a) {
            return a.width > a.height ? (a.left += (a.width - a.height) / 2, a.width = a.height) : a.width < a.height && (a.top += (a.height - a.width) / 2, a.height = a.width), a
        }, K = function (a, b, c, d) {
            var g, h, f = b.ownerDocument.body;
            a.length > 0 && f && (g = b.ownerDocument.createElement("html2canvaswrapper"), r.copyCSSStyles(b.ownerDocument.defaultView.getComputedStyle(b, null), g), g.style.position = "absolute", g.style.left = c.bounds.left + "px", g.style.top = c.bounds.top + "px", d || (g.style.whiteSpace = "nowrap"), h = b.ownerDocument.createTextNode(a), g.appendChild(h), f.appendChild(g), c.childNodes.push(e.default.fromTextNode(h, c)), f.removeChild(g))
        }, L = function (a) {
            var b = "password" === a.type ? new Array(a.value.length + 1).join("•") : a.value;
            return 0 === b.length ? a.placeholder || "" : b
        }
    }, function (a, b, c) {
        "use strict";
        function i(a) {
            return a && a.__esModule ? a : {"default": a}
        }

        function j(a, b) {
            if (!(a instanceof b))throw new TypeError("Cannot call a class as a function")
        }

        var d, e, f, g, h, k, m, n;
        Object.defineProperty(b, "__esModule", {value: !0}), b.parseTextBounds = b.TextBounds = void 0, d = c(2), e = c(11), f = c(10), g = i(f), h = c(24), k = b.TextBounds = function o(a, b) {
            j(this, o), this.text = a, this.bounds = b
        }, b.parseTextBounds = function (a, b, c) {
            var r, s, t, d = 0 !== b.style.letterSpacing, f = d ? h.toCodePoints(a).map(function (a) {
                    return h.fromCodePoint(a)
                }) : h.breakWords(a, b), i = f.length, j = c.parentNode ? c.parentNode.ownerDocument.defaultView : null,
                l = j ? j.pageXOffset : 0, o = j ? j.pageYOffset : 0, p = [], q = 0;
            for (r = 0; i > r; r++)s = f[r], b.style.textDecoration !== e.TEXT_DECORATION.NONE || s.trim().length > 0 ? g.default.SUPPORT_RANGE_BOUNDS ? p.push(new k(s, n(c, q, s.length, l, o))) : (t = c.splitText(s.length), p.push(new k(s, m(c, l, o))), c = t) : g.default.SUPPORT_RANGE_BOUNDS || (c = c.splitText(s.length)), q += s.length;
            return p
        }, m = function (a, b, c) {
            var f, g, e = a.ownerDocument.createElement("html2canvaswrapper");
            return e.appendChild(a.cloneNode(!0)), f = a.parentNode, f ? (f.replaceChild(e, a), g = d.parseBounds(e, b, c), e.firstChild && f.replaceChild(e.firstChild, e), g) : new d.Bounds(0, 0, 0, 0)
        }, n = function (a, b, c, e, f) {
            var g = a.ownerDocument.createRange();
            return g.setStart(a, b), g.setEnd(a, b + c), d.Bounds.fromClientRect(g.getBoundingClientRect(), e, f)
        }
    }, function (a, b) {
        "use strict";
        function e(a, b) {
            if (!(a instanceof b))throw new TypeError("Cannot call a class as a function")
        }

        var d, f, g, h;
        Object.defineProperty(b, "__esModule", {value: !0}), d = function () {
            function a(a, b) {
                var c, d;
                for (c = 0; c < b.length; c++)d = b[c], d.enumerable = d.enumerable || !1, d.configurable = !0, "value" in d && (d.writable = !0), Object.defineProperty(a, d.key, d)
            }

            return function (b, c, d) {
                return c && a(b.prototype, c), d && a(b, d), b
            }
        }(), f = function () {
            function a(b) {
                e(this, a), this.element = b
            }

            return d(a, [{
                key: "render", value: function (a) {
                    var c, b = this;
                    return this.options = a, this.canvas = document.createElement("canvas"), this.ctx = this.canvas.getContext("2d"), this.canvas.width = Math.floor(a.width) * a.scale, this.canvas.height = Math.floor(a.height) * a.scale, this.canvas.style.width = a.width + "px", this.canvas.style.height = a.height + "px", a.logger.log("ForeignObject renderer initialized (" + a.width + "x" + a.height + " at " + a.x + "," + a.y + ") with scale " + a.scale), c = g(Math.max(a.windowWidth, a.width) * a.scale, Math.max(a.windowHeight, a.height) * a.scale, a.scrollX * a.scale, a.scrollY * a.scale, this.element), h(c).then(function (c) {
                        return a.backgroundColor && (b.ctx.fillStyle = a.backgroundColor.toString(), b.ctx.fillRect(0, 0, a.width * a.scale, a.height * a.scale)), b.ctx.drawImage(c, -a.x * a.scale, -a.y * a.scale), b.canvas
                    })
                }
            }]), a
        }(), b.default = f, g = b.createForeignObjectSVG = function (a, b, c, d, e) {
            var f = "http://www.w3.org/2000/svg", g = document.createElementNS(f, "svg"),
                h = document.createElementNS(f, "foreignObject");
            return g.setAttributeNS(null, "width", a), g.setAttributeNS(null, "height", b), h.setAttributeNS(null, "width", "100%"), h.setAttributeNS(null, "height", "100%"), h.setAttributeNS(null, "x", c), h.setAttributeNS(null, "y", d), h.setAttributeNS(null, "externalResourcesRequired", "true"), g.appendChild(h), h.appendChild(e), g
        }, h = b.loadSerializedSVG = function (a) {
            return new Promise(function (b, c) {
                var d = new Image;
                d.onload = function () {
                    return b(d)
                }, d.onerror = c, d.src = "data:image/svg+xml;charset=utf-8," + encodeURIComponent((new XMLSerializer).serializeToString(a))
            })
        }
    }, function (a, b, c) {
        "use strict";
        var d, e;
        Object.defineProperty(b, "__esModule", {value: !0}), b.breakWords = b.fromCodePoint = b.toCodePoints = void 0, d = c(46), Object.defineProperty(b, "toCodePoints", {
            enumerable: !0,
            get: function () {
                return d.toCodePoints
            }
        }), Object.defineProperty(b, "fromCodePoint", {
            enumerable: !0, get: function () {
                return d.fromCodePoint
            }
        }), e = c(18), b.breakWords = function (a, b) {
            for (var c = d.LineBreaker(a, {
                lineBreak: b.style.lineBreak,
                wordBreak: b.style.overflowWrap === e.OVERFLOW_WRAP.BREAK_WORD ? "break-word" : b.style.wordBreak
            }), f = [], g = void 0; !(g = c.next()).done;)f.push(g.value.slice());
            return f
        }
    }, function (a, b, c) {
        "use strict";
        function f(a, b) {
            if (!(a instanceof b))throw new TypeError("Cannot call a class as a function")
        }

        var d, e, g;
        Object.defineProperty(b, "__esModule", {value: !0}), b.FontMetrics = void 0, d = function () {
            function a(a, b) {
                var c, d;
                for (c = 0; c < b.length; c++)d = b[c], d.enumerable = d.enumerable || !1, d.configurable = !0, "value" in d && (d.writable = !0), Object.defineProperty(a, d.key, d)
            }

            return function (b, c, d) {
                return c && a(b.prototype, c), d && a(b, d), b
            }
        }(), e = c(3), g = "Hidden Text", b.FontMetrics = function () {
            function a(b) {
                f(this, a), this._data = {}, this._document = b
            }

            return d(a, [{
                key: "_parseMetrics", value: function (a) {
                    var h, i, b = this._document.createElement("div"), c = this._document.createElement("img"),
                        d = this._document.createElement("span"), f = this._document.body;
                    if (!f)throw new Error("No document found for font metrics");
                    return b.style.visibility = "hidden", b.style.fontFamily = a.fontFamily, b.style.fontSize = a.fontSize, b.style.margin = "0", b.style.padding = "0", f.appendChild(b), c.src = e.SMALL_IMAGE, c.width = 1, c.height = 1, c.style.margin = "0", c.style.padding = "0", c.style.verticalAlign = "baseline", d.style.fontFamily = a.fontFamily, d.style.fontSize = a.fontSize, d.style.margin = "0", d.style.padding = "0", d.appendChild(this._document.createTextNode(g)), b.appendChild(d), b.appendChild(c), h = c.offsetTop - d.offsetTop + 2, b.removeChild(d), b.appendChild(this._document.createTextNode(g)), b.style.lineHeight = "normal", c.style.verticalAlign = "super", i = c.offsetTop - b.offsetTop + 2, f.removeChild(b), {
                        baseline: h,
                        middle: i
                    }
                }
            }, {
                key: "getMetrics", value: function (a) {
                    var b = a.fontFamily + " " + a.fontSize;
                    return void 0 === this._data[b] && (this._data[b] = this._parseMetrics(a)), this._data[b]
                }
            }]), a
        }()
    }, function (a, b, c) {
        "use strict";
        function f(a) {
            return a && a.__esModule ? a : {"default": a}
        }

        var d, e;
        Object.defineProperty(b, "__esModule", {value: !0}), b.Proxy = void 0, d = c(10), e = f(d), b.Proxy = function (a, b) {
            if (!b.proxy)return Promise.reject("No proxy defined");
            var c = b.proxy;
            return new Promise(function (d, f) {
                var i, g = e.default.SUPPORT_CORS_XHR && e.default.SUPPORT_RESPONSE_TYPE ? "blob" : "text",
                    h = e.default.SUPPORT_CORS_XHR ? new XMLHttpRequest : new XDomainRequest;
                h.onload = function () {
                    if (h instanceof XMLHttpRequest)if (200 === h.status)if ("text" === g) d(h.response); else {
                        var b = new FileReader;
                        b.addEventListener("load", function () {
                            return d(b.result)
                        }, !1), b.addEventListener("error", function (a) {
                            return f(a)
                        }, !1), b.readAsDataURL(h.response)
                    } else f("Failed to proxy resource " + a.substring(0, 256) + " with status code " + h.status); else d(h.responseText)
                }, h.onerror = f, h.open("GET", c + "?url=" + encodeURIComponent(a) + "&responseType=" + g), "text" !== g && h instanceof XMLHttpRequest && (h.responseType = g), b.imageTimeout && (i = b.imageTimeout, h.timeout = i, h.ontimeout = function () {
                    return f("Timed out (" + i + "ms) proxying " + a.substring(0, 256))
                }), h.send()
            })
        }
    }, function (a, b, c) {
        "use strict";
        function j(a) {
            return a && a.__esModule ? a : {"default": a}
        }

        var d = Object.assign || function (a) {
                var b, c, d;
                for (b = 1; b < arguments.length; b++) {
                    c = arguments[b];
                    for (d in c)Object.prototype.hasOwnProperty.call(c, d) && (a[d] = c[d])
                }
                return a
            }, e = c(15), f = j(e), g = c(16), h = j(g), i = c(28), k = function (a, b) {
            var g, j, k, l, c = b || {}, e = new h.default("boolean" == typeof c.logging ? c.logging : !0);
            return e.log("html2canvas 1.0.0-alpha.12"), "function" == typeof c.onrendered && e.error("onrendered option is deprecated, html2canvas returns a Promise with the canvas as the value"), (g = a.ownerDocument) ? (j = g.defaultView, k = {
                async: !0,
                allowTaint: !1,
                backgroundColor: "#ffffff",
                imageTimeout: 15e3,
                logging: !0,
                proxy: null,
                removeContainer: !0,
                foreignObjectRendering: !1,
                scale: j.devicePixelRatio || 1,
                target: new f.default(c.canvas),
                useCORS: !1,
                windowWidth: j.innerWidth,
                windowHeight: j.innerHeight,
                scrollX: j.pageXOffset,
                scrollY: j.pageYOffset
            }, l = i.renderElement(a, d({}, k, c), e), l.catch(function (a) {
                throw e.error(a), a
            })) : Promise.reject("Provided element is not within a Document")
        };
        k.CanvasRenderer = f.default, a.exports = k
    }, function (a, b, c) {
        "use strict";
        function s(a) {
            return a && a.__esModule ? a : {"default": a}
        }

        var d, e, g, h, i, j, k, l, m, n, o, p, q, r;
        Object.defineProperty(b, "__esModule", {value: !0}), b.renderElement = void 0, d = function () {
            function a(a, b) {
                var h, g, c = [], d = !0, e = !1, f = void 0;
                try {
                    for (g = a[Symbol.iterator](); !(d = (h = g.next()).done) && (c.push(h.value), !b || c.length !== b); d = !0);
                } catch (i) {
                    e = !0, f = i
                } finally {
                    try {
                        !d && g["return"] && g["return"]()
                    } finally {
                        if (e)throw f
                    }
                }
                return c
            }

            return function (b, c) {
                if (Array.isArray(b))return b;
                if (Symbol.iterator in Object(b))return a(b, c);
                throw new TypeError("Invalid attempt to destructure non-iterable instance")
            }
        }(), e = c(16), s(e), g = c(29), h = c(51), i = s(h), j = c(23), k = s(j), l = c(10), m = s(l), n = c(2), o = c(54), p = c(25), q = c(0), r = s(q), b.renderElement = function u(a, b, c) {
            var e = a.ownerDocument, f = new n.Bounds(b.scrollX, b.scrollY, b.windowWidth, b.windowHeight),
                h = e.documentElement ? new r.default(getComputedStyle(e.documentElement).backgroundColor) : q.TRANSPARENT,
                j = e.body ? new r.default(getComputedStyle(e.body).backgroundColor) : q.TRANSPARENT,
                l = a === e.documentElement ? h.isTransparent() ? j.isTransparent() ? b.backgroundColor ? new r.default(b.backgroundColor) : null : j : h : b.backgroundColor ? new r.default(b.backgroundColor) : null;
            return (b.foreignObjectRendering ? m.default.SUPPORT_FOREIGNOBJECT_DRAWING : Promise.resolve(!1)).then(function (h) {
                return h ? function (d) {
                    return c.log("Document cloned, using foreignObject rendering"), d.inlineFonts(e).then(function () {
                        return d.resourceLoader.ready()
                    }).then(function () {
                        var f = new k.default(d.documentElement), g = e.defaultView, h = g.pageXOffset,
                            i = g.pageYOffset, j = "HTML" === a.tagName || "BODY" === a.tagName,
                            m = j ? n.parseDocumentSize(e) : n.parseBounds(a, h, i), o = m.width, p = m.height,
                            q = m.left, r = m.top;
                        return f.render({
                            backgroundColor: l,
                            logger: c,
                            scale: b.scale,
                            x: "number" == typeof b.x ? b.x : q,
                            y: "number" == typeof b.y ? b.y : r,
                            width: "number" == typeof b.width ? b.width : Math.ceil(o),
                            height: "number" == typeof b.height ? b.height : Math.ceil(p),
                            windowWidth: b.windowWidth,
                            windowHeight: b.windowHeight,
                            scrollX: b.scrollX,
                            scrollY: b.scrollY
                        })
                    })
                }(new o.DocumentCloner(a, b, c, !0, u)) : o.cloneWindow(e, f, a, b, c, u).then(function (a) {
                    var m, o, f = d(a, 3), h = f[0], j = f[1], k = f[2];
                    return c.log("Document cloned, using computed rendering"), m = g.NodeParser(j, k, c), o = j.ownerDocument, l === m.container.style.background.backgroundColor && (m.container.style.background.backgroundColor = q.TRANSPARENT), k.ready().then(function (a) {
                        var f, g, k, q, r, s, t, u, v, w, x, y, d = new p.FontMetrics(o);
                        return c.log("Starting renderer"), f = o.defaultView, g = f.pageXOffset, k = f.pageYOffset, q = "HTML" === j.tagName || "BODY" === j.tagName, r = q ? n.parseDocumentSize(e) : n.parseBounds(j, g, k), s = r.width, t = r.height, u = r.left, v = r.top, w = {
                            backgroundColor: l,
                            fontMetrics: d,
                            imageStore: a,
                            logger: c,
                            scale: b.scale,
                            x: "number" == typeof b.x ? b.x : u,
                            y: "number" == typeof b.y ? b.y : v,
                            width: "number" == typeof b.width ? b.width : Math.ceil(s),
                            height: "number" == typeof b.height ? b.height : Math.ceil(t)
                        }, Array.isArray(b.target) ? Promise.all(b.target.map(function (a) {
                            var b = new i.default(a, w);
                            return b.render(m)
                        })) : (x = new i.default(b.target, w), y = x.render(m), b.removeContainer === !0 && (h.parentNode ? h.parentNode.removeChild(h) : c.log("Cannot detach cloned iframe as it is not in the DOM anymore")), y)
                    })
                })
            })
        }
    }, function (a, b, c) {
        "use strict";
        function m(a) {
            return a && a.__esModule ? a : {"default": a}
        }

        var d, e, f, g, h, i, j, k, l, o, p, q, r, s;
        Object.defineProperty(b, "__esModule", {value: !0}), b.NodeParser = void 0, d = c(30), e = m(d), f = c(6), g = m(f), h = c(9), i = m(h), j = c(21), k = c(14), l = c(8), b.NodeParser = function (a, b, c) {
            var d, f, h;
            return c.log("Starting node parsing"), d = 0, f = new g.default(a, null, b, d++), h = new e.default(f, null, !0), p(a, f, h, b, d), c.log("Finished parsing node tree"), h
        }, o = ["SCRIPT", "HEAD", "TITLE", "OBJECT", "BR", "OPTION"], p = function u(a, b, c, d, f) {
            var m, h, n, p, s, t, v, w, x, y, z, A;
            if (f > 5e4)throw new Error("Recursion error while parsing node tree");
            for (h = a.firstChild; h; h = m)m = h.nextSibling, n = h.ownerDocument.defaultView, h instanceof n.Text || h instanceof Text || n.parent && h instanceof n.parent.Text ? h.data.trim().length > 0 && b.childNodes.push(i.default.fromTextNode(h, b)) : h instanceof n.HTMLElement || h instanceof HTMLElement || n.parent && h instanceof n.parent.HTMLElement ? -1 === o.indexOf(h.nodeName) && (p = new g.default(h, b, d, f++), p.isVisible() && ("INPUT" === h.tagName ? j.inlineInputElement(h, p) : "TEXTAREA" === h.tagName ? j.inlineTextAreaElement(h, p) : "SELECT" === h.tagName ? j.inlineSelectElement(h, p) : p.style.listStyle && p.style.listStyle.listStyleType !== l.LIST_STYLE_TYPE.NONE && k.inlineListItemElement(h, p, d), s = "TEXTAREA" !== h.tagName, t = q(p, h), t || r(p) ? (v = t || p.isPositioned() ? c.getRealParentStackingContext() : c, w = new e.default(p, v, t), v.contexts.push(w), s && u(h, p, w, d, f)) : (c.children.push(p), s && u(h, p, c, d, f)))) : (h instanceof n.SVGSVGElement || h instanceof SVGSVGElement || n.parent && h instanceof n.parent.SVGSVGElement) && (x = new g.default(h, b, d, f++), y = q(x, h), y || r(x) ? (z = y || x.isPositioned() ? c.getRealParentStackingContext() : c, A = new e.default(x, z, y), z.contexts.push(A)) : c.children.push(x))
        }, q = function (a, b) {
            return a.isRootElement() || a.isPositionedWithZIndex() || a.style.opacity < 1 || a.isTransformed() || s(a, b)
        }, r = function (a) {
            return a.isPositioned() || a.isFloating()
        }, s = function (a, b) {
            return "BODY" === b.nodeName && a.parent instanceof g.default && a.parent.style.background.backgroundColor.isTransparent()
        }
    }, function (a, b, c) {
        "use strict";
        function h(a) {
            return a && a.__esModule ? a : {"default": a}
        }

        function i(a, b) {
            if (!(a instanceof b))throw new TypeError("Cannot call a class as a function")
        }

        var d, e, j;
        Object.defineProperty(b, "__esModule", {value: !0}), d = function () {
            function a(a, b) {
                var c, d;
                for (c = 0; c < b.length; c++)d = b[c], d.enumerable = d.enumerable || !1, d.configurable = !0, "value" in d && (d.writable = !0), Object.defineProperty(a, d.key, d)
            }

            return function (b, c, d) {
                return c && a(b.prototype, c), d && a(b, d), b
            }
        }(), e = c(6), h(e), c(19), j = function () {
            function a(b, c, d) {
                i(this, a), this.container = b, this.parent = c, this.contexts = [], this.children = [], this.treatAsRealStackingContext = d
            }

            return d(a, [{
                key: "getOpacity", value: function () {
                    return this.parent ? this.container.style.opacity * this.parent.getOpacity() : this.container.style.opacity
                }
            }, {
                key: "getRealParentStackingContext", value: function () {
                    return !this.parent || this.treatAsRealStackingContext ? this : this.parent.getRealParentStackingContext()
                }
            }]), a
        }(), b.default = j
    }, function (a, b) {
        "use strict";
        function d(a, b) {
            if (!(a instanceof b))throw new TypeError("Cannot call a class as a function")
        }

        Object.defineProperty(b, "__esModule", {value: !0});
        var e = function f(a, b) {
            d(this, f), this.width = a, this.height = b
        };
        b.default = e
    }, function (a, b, c) {
        "use strict";
        function h(a) {
            return a && a.__esModule ? a : {"default": a}
        }

        function i(a, b) {
            if (!(a instanceof b))throw new TypeError("Cannot call a class as a function")
        }

        var d, e, f, g, j, k;
        Object.defineProperty(b, "__esModule", {value: !0}), d = function () {
            function a(a, b) {
                var c, d;
                for (c = 0; c < b.length; c++)d = b[c], d.enumerable = d.enumerable || !1, d.configurable = !0, "value" in d && (d.writable = !0), Object.defineProperty(a, d.key, d)
            }

            return function (b, c, d) {
                return c && a(b.prototype, c), d && a(b, d), b
            }
        }(), e = c(5), f = c(7), g = h(f), j = function (a, b, c) {
            return new g.default(a.x + (b.x - a.x) * c, a.y + (b.y - a.y) * c)
        }, k = function () {
            function a(b, c, d, f) {
                i(this, a), this.type = e.PATH.BEZIER_CURVE, this.start = b, this.startControl = c, this.endControl = d, this.end = f
            }

            return d(a, [{
                key: "subdivide", value: function (b, c) {
                    var d = j(this.start, this.startControl, b), e = j(this.startControl, this.endControl, b),
                        f = j(this.endControl, this.end, b), g = j(d, e, b), h = j(e, f, b), i = j(g, h, b);
                    return c ? new a(this.start, d, g, i) : new a(i, h, f, this.end)
                }
            }, {
                key: "reverse", value: function () {
                    return new a(this.end, this.endControl, this.startControl, this.start)
                }
            }]), a
        }(), b.default = k
    }, function (a, b, c) {
        "use strict";
        function g(a) {
            return a && a.__esModule ? a : {"default": a}
        }

        var d, e, f, h;
        Object.defineProperty(b, "__esModule", {value: !0}), b.parseBorderRadius = void 0, d = function () {
            function a(a, b) {
                var h, g, c = [], d = !0, e = !1, f = void 0;
                try {
                    for (g = a[Symbol.iterator](); !(d = (h = g.next()).done) && (c.push(h.value), !b || c.length !== b); d = !0);
                } catch (i) {
                    e = !0, f = i
                } finally {
                    try {
                        !d && g["return"] && g["return"]()
                    } finally {
                        if (e)throw f
                    }
                }
                return c
            }

            return function (b, c) {
                if (Array.isArray(b))return b;
                if (Symbol.iterator in Object(b))return a(b, c);
                throw new TypeError("Invalid attempt to destructure non-iterable instance")
            }
        }(), e = c(1), f = g(e), h = ["top-left", "top-right", "bottom-right", "bottom-left"], b.parseBorderRadius = function (a) {
            return h.map(function (b) {
                var c = a.getPropertyValue("border-" + b + "-radius"), e = c.split(" ").map(f.default.create),
                    g = d(e, 2), h = g[0], i = g[1];
                return "undefined" == typeof i ? [h, h] : [h, i]
            })
        }
    }, function (a, b) {
        "use strict";
        var d, e, f;
        Object.defineProperty(b, "__esModule", {value: !0}), d = b.DISPLAY = {
            NONE: 1,
            BLOCK: 2,
            INLINE: 4,
            RUN_IN: 8,
            FLOW: 16,
            FLOW_ROOT: 32,
            TABLE: 64,
            FLEX: 128,
            GRID: 256,
            RUBY: 512,
            SUBGRID: 1024,
            LIST_ITEM: 2048,
            TABLE_ROW_GROUP: 4096,
            TABLE_HEADER_GROUP: 8192,
            TABLE_FOOTER_GROUP: 16384,
            TABLE_ROW: 32768,
            TABLE_CELL: 65536,
            TABLE_COLUMN_GROUP: 1 << 17,
            TABLE_COLUMN: 1 << 18,
            TABLE_CAPTION: 1 << 19,
            RUBY_BASE: 1 << 20,
            RUBY_TEXT: 1 << 21,
            RUBY_BASE_CONTAINER: 1 << 22,
            RUBY_TEXT_CONTAINER: 1 << 23,
            CONTENTS: 1 << 24,
            INLINE_BLOCK: 1 << 25,
            INLINE_LIST_ITEM: 1 << 26,
            INLINE_TABLE: 1 << 27,
            INLINE_FLEX: 1 << 28,
            INLINE_GRID: 1 << 29
        }, e = function (a) {
            switch (a) {
                case"block":
                    return d.BLOCK;
                case"inline":
                    return d.INLINE;
                case"run-in":
                    return d.RUN_IN;
                case"flow":
                    return d.FLOW;
                case"flow-root":
                    return d.FLOW_ROOT;
                case"table":
                    return d.TABLE;
                case"flex":
                    return d.FLEX;
                case"grid":
                    return d.GRID;
                case"ruby":
                    return d.RUBY;
                case"subgrid":
                    return d.SUBGRID;
                case"list-item":
                    return d.LIST_ITEM;
                case"table-row-group":
                    return d.TABLE_ROW_GROUP;
                case"table-header-group":
                    return d.TABLE_HEADER_GROUP;
                case"table-footer-group":
                    return d.TABLE_FOOTER_GROUP;
                case"table-row":
                    return d.TABLE_ROW;
                case"table-cell":
                    return d.TABLE_CELL;
                case"table-column-group":
                    return d.TABLE_COLUMN_GROUP;
                case"table-column":
                    return d.TABLE_COLUMN;
                case"table-caption":
                    return d.TABLE_CAPTION;
                case"ruby-base":
                    return d.RUBY_BASE;
                case"ruby-text":
                    return d.RUBY_TEXT;
                case"ruby-base-container":
                    return d.RUBY_BASE_CONTAINER;
                case"ruby-text-container":
                    return d.RUBY_TEXT_CONTAINER;
                case"contents":
                    return d.CONTENTS;
                case"inline-block":
                    return d.INLINE_BLOCK;
                case"inline-list-item":
                    return d.INLINE_LIST_ITEM;
                case"inline-table":
                    return d.INLINE_TABLE;
                case"inline-flex":
                    return d.INLINE_FLEX;
                case"inline-grid":
                    return d.INLINE_GRID
            }
            return d.NONE
        }, f = function (a, b) {
            return a | e(b)
        }, b.parseDisplay = function (a) {
            return a.split(" ").reduce(f, 0)
        }
    }, function (a, b) {
        "use strict";
        Object.defineProperty(b, "__esModule", {value: !0});
        var d = b.FLOAT = {NONE: 0, LEFT: 1, RIGHT: 2, INLINE_START: 3, INLINE_END: 4};
        b.parseCSSFloat = function (a) {
            switch (a) {
                case"left":
                    return d.LEFT;
                case"right":
                    return d.RIGHT;
                case"inline-start":
                    return d.INLINE_START;
                case"inline-end":
                    return d.INLINE_END
            }
            return d.NONE
        }
    }, function (a, b) {
        "use strict";
        Object.defineProperty(b, "__esModule", {value: !0});
        var d = function (a) {
            switch (a) {
                case"normal":
                    return 400;
                case"bold":
                    return 700
            }
            var b = parseInt(a, 10);
            return isNaN(b) ? 400 : b
        };
        b.parseFont = function (a) {
            var b = a.fontFamily, c = a.fontSize, e = a.fontStyle, f = a.fontVariant, g = d(a.fontWeight);
            return {fontFamily: b, fontSize: c, fontStyle: e, fontVariant: f, fontWeight: g}
        }
    }, function (a, b) {
        "use strict";
        Object.defineProperty(b, "__esModule", {value: !0}), b.parseLetterSpacing = function (a) {
            if ("normal" === a)return 0;
            var b = parseFloat(a);
            return isNaN(b) ? 0 : b
        }
    }, function (a, b) {
        "use strict";
        Object.defineProperty(b, "__esModule", {value: !0});
        var d = b.LINE_BREAK = {NORMAL: "normal", STRICT: "strict"};
        b.parseLineBreak = function (a) {
            switch (a) {
                case"strict":
                    return d.STRICT;
                case"normal":
                default:
                    return d.NORMAL
            }
        }
    }, function (a, b, c) {
        "use strict";
        function f(a) {
            return a && a.__esModule ? a : {"default": a}
        }

        var d, e, g;
        Object.defineProperty(b, "__esModule", {value: !0}), b.parseMargin = void 0, d = c(1), e = f(d), g = ["top", "right", "bottom", "left"], b.parseMargin = function (a) {
            return g.map(function (b) {
                return new e.default(a.getPropertyValue("margin-" + b))
            })
        }
    }, function (a, b) {
        "use strict";
        Object.defineProperty(b, "__esModule", {value: !0});
        var d = b.OVERFLOW = {VISIBLE: 0, HIDDEN: 1, SCROLL: 2, AUTO: 3};
        b.parseOverflow = function (a) {
            switch (a) {
                case"hidden":
                    return d.HIDDEN;
                case"scroll":
                    return d.SCROLL;
                case"auto":
                    return d.AUTO;
                case"visible":
                default:
                    return d.VISIBLE
            }
        }
    }, function (a, b, c) {
        "use strict";
        function f(a) {
            return a && a.__esModule ? a : {"default": a}
        }

        var d, e, g;
        Object.defineProperty(b, "__esModule", {value: !0}), b.parseTextShadow = void 0, d = c(0), e = f(d), g = /^([+-]|\d|\.)$/i, b.parseTextShadow = function (a) {
            var b, c, d, f, h, i, j, k, l, m;
            if ("none" === a || "string" != typeof a)return null;
            for (b = "", c = !1, d = [], f = [], h = 0, i = null, j = function () {
                b.length && (c ? d.push(parseFloat(b)) : i = new e.default(b)), c = !1, b = ""
            }, k = function () {
                d.length && null !== i && f.push({
                    color: i,
                    offsetX: d[0] || 0,
                    offsetY: d[1] || 0,
                    blur: d[2] || 0
                }), d.splice(0, d.length), i = null
            }, l = 0; l < a.length; l++)switch (m = a[l]) {
                case"(":
                    b += m, h++;
                    break;
                case")":
                    b += m, h--;
                    break;
                case",":
                    0 === h ? (j(), k()) : b += m;
                    break;
                case" ":
                    0 === h ? j() : b += m;
                    break;
                default:
                    0 === b.length && g.test(m) && (c = !0), b += m
            }
            return j(), k(), 0 === f.length ? null : f
        }
    }, function (a, b, c) {
        "use strict";
        function f(a) {
            return a && a.__esModule ? a : {"default": a}
        }

        var d, e, g, h, j, k;
        Object.defineProperty(b, "__esModule", {value: !0}), b.parseTransform = void 0, d = c(1), e = f(d), g = function (a) {
            return parseFloat(a.trim())
        }, h = /(matrix|matrix3d)\((.+)\)/, b.parseTransform = function (a) {
            var b = k(a.transform || a.webkitTransform || a.mozTransform || a.msTransform || a.oTransform);
            return null === b ? null : {
                transform: b,
                transformOrigin: j(a.transformOrigin || a.webkitTransformOrigin || a.mozTransformOrigin || a.msTransformOrigin || a.oTransformOrigin)
            }
        }, j = function (a) {
            var b, c;
            return "string" != typeof a ? (b = new e.default("0"), [b, b]) : (c = a.split(" ").map(e.default.create), [c[0], c[1]])
        }, k = function (a) {
            var b, c, d;
            return "none" === a || "string" != typeof a ? null : (b = a.match(h), b ? "matrix" === b[1] ? (c = b[2].split(",").map(g), [c[0], c[1], c[2], c[3], c[4], c[5]]) : (d = b[2].split(",").map(g), [d[0], d[1], d[4], d[5], d[12], d[13]]) : null)
        }
    }, function (a, b) {
        "use strict";
        Object.defineProperty(b, "__esModule", {value: !0});
        var d = b.VISIBILITY = {VISIBLE: 0, HIDDEN: 1, COLLAPSE: 2};
        b.parseVisibility = function (a) {
            switch (a) {
                case"hidden":
                    return d.HIDDEN;
                case"collapse":
                    return d.COLLAPSE;
                case"visible":
                default:
                    return d.VISIBLE
            }
        }
    }, function (a, b) {
        "use strict";
        Object.defineProperty(b, "__esModule", {value: !0});
        var d = b.WORD_BREAK = {NORMAL: "normal", BREAK_ALL: "break-all", KEEP_ALL: "keep-all"};
        b.parseWordBreak = function (a) {
            switch (a) {
                case"break-all":
                    return d.BREAK_ALL;
                case"keep-all":
                    return d.KEEP_ALL;
                case"normal":
                default:
                    return d.NORMAL
            }
        }
    }, function (a, b) {
        "use strict";
        Object.defineProperty(b, "__esModule", {value: !0}), b.parseZIndex = function (a) {
            var b = "auto" === a;
            return {auto: b, order: b ? 0 : parseInt(a, 10)}
        }
    }, function (a, b, c) {
        "use strict";
        var d, e;
        Object.defineProperty(b, "__esModule", {value: !0}), d = c(13), Object.defineProperty(b, "toCodePoints", {
            enumerable: !0,
            get: function () {
                return d.toCodePoints
            }
        }), Object.defineProperty(b, "fromCodePoint", {
            enumerable: !0, get: function () {
                return d.fromCodePoint
            }
        }), e = c(47), Object.defineProperty(b, "LineBreaker", {
            enumerable: !0, get: function () {
                return e.LineBreaker
            }
        })
    }, function (a, b, c) {
        "use strict";
        function j(a) {
            return a && a.__esModule ? a : {"default": a}
        }

        function k(a) {
            if (Array.isArray(a)) {
                for (var b = 0, c = Array(a.length); b < a.length; b++)c[b] = a[b];
                return c
            }
            return Array.from(a)
        }

        function l(a, b) {
            if (!(a instanceof b))throw new TypeError("Cannot call a class as a function")
        }

        var d, e, f, g, h, i, m, n, o, p, q, r, s, t, u, v, w, x, y, z, A, B, C, D, E, F, G, H, I, J, K, L, M, N, O, P,
            Q, R, S, T, U, V, W, X, Y, Z, $, _, ab, bb, db, eb, fb, gb, hb, ib, jb, kb, lb, mb, nb, ob, pb, qb, rb, tb,
            vb;
        Object.defineProperty(b, "__esModule", {value: !0}), b.LineBreaker = b.inlineBreakOpportunities = b.lineBreakAtIndex = b.codePointsToCharacterClasses = b.UnicodeTrie = b.BREAK_ALLOWED = b.BREAK_NOT_ALLOWED = b.BREAK_MANDATORY = b.classes = b.LETTER_NUMBER_MODIFIER = void 0, d = function () {
            function a(a, b) {
                var c, d;
                for (c = 0; c < b.length; c++)d = b[c], d.enumerable = d.enumerable || !1, d.configurable = !0, "value" in d && (d.writable = !0), Object.defineProperty(a, d.key, d)
            }

            return function (b, c, d) {
                return c && a(b.prototype, c), d && a(b, d), b
            }
        }(), e = function () {
            function a(a, b) {
                var h, g, c = [], d = !0, e = !1, f = void 0;
                try {
                    for (g = a[Symbol.iterator](); !(d = (h = g.next()).done) && (c.push(h.value), !b || c.length !== b); d = !0);
                } catch (i) {
                    e = !0, f = i
                } finally {
                    try {
                        !d && g["return"] && g["return"]()
                    } finally {
                        if (e)throw f
                    }
                }
                return c
            }

            return function (b, c) {
                if (Array.isArray(b))return b;
                if (Symbol.iterator in Object(b))return a(b, c);
                throw new TypeError("Invalid attempt to destructure non-iterable instance")
            }
        }(), f = c(48), g = c(49), h = j(g), i = c(13), m = b.LETTER_NUMBER_MODIFIER = 50, n = 1, o = 2, p = 3, q = 4, r = 5, s = 6, t = 7, u = 8, v = 9, w = 10, x = 11, y = 12, z = 13, A = 14, B = 15, C = 16, D = 17, E = 18, F = 19, G = 20, H = 21, I = 22, J = 23, K = 24, L = 25, M = 26, N = 27, O = 28, P = 29, Q = 30, R = 31, S = 32, T = 33, U = 34, V = 35, W = 36, X = 37, Y = 38, Z = 39, $ = 40, _ = 41, ab = 42, bb = 43, b.classes = {
            BK: n,
            CR: o,
            LF: p,
            CM: q,
            NL: r,
            SG: s,
            WJ: t,
            ZW: u,
            GL: v,
            SP: w,
            ZWJ: x,
            B2: y,
            BA: z,
            BB: A,
            HY: B,
            CB: C,
            CL: D,
            CP: E,
            EX: F,
            IN: G,
            NS: H,
            OP: I,
            QU: J,
            IS: K,
            NU: L,
            PO: M,
            PR: N,
            SY: O,
            AI: P,
            AL: Q,
            CJ: R,
            EB: S,
            EM: T,
            H2: U,
            H3: V,
            HL: W,
            ID: X,
            JL: Y,
            JV: Z,
            JT: $,
            RI: _,
            SA: ab,
            XX: bb
        }, db = b.BREAK_MANDATORY = "!", eb = b.BREAK_NOT_ALLOWED = "×", fb = b.BREAK_ALLOWED = "÷", gb = b.UnicodeTrie = f.createTrieFromBase64(h.default), hb = [Q, W], ib = [n, o, p, r], jb = [w, u], kb = [N, M], lb = ib.concat(jb), mb = [Y, Z, $, U, V], nb = [B, z], ob = b.codePointsToCharacterClasses = function (a) {
            var b = arguments.length > 1 && void 0 !== arguments[1] ? arguments[1] : "strict", c = [], d = [], e = [];
            return a.forEach(function (a, f) {
                var h, g = gb.get(a);
                return g > m ? (e.push(!0), g -= m) : e.push(!1), -1 !== ["normal", "auto", "loose"].indexOf(b) && -1 !== [8208, 8211, 12316, 12448].indexOf(a) ? (d.push(f), c.push(C)) : g === q || g === x ? 0 === f ? (d.push(f), c.push(Q)) : (h = c[f - 1], -1 === lb.indexOf(h) ? (d.push(d[f - 1]), c.push(h)) : (d.push(f), c.push(Q))) : (d.push(f), g === R ? c.push("strict" === b ? H : X) : g === ab ? c.push(Q) : g === P ? c.push(Q) : g === bb ? a >= 131072 && 196605 >= a || a >= 196608 && 262141 >= a ? c.push(X) : c.push(Q) : (c.push(g), void 0))
            }), [d, c, e]
        }, pb = function (a, b, c, d) {
            var f, g, h, i, j, k, e = d[c];
            if (Array.isArray(a) ? -1 !== a.indexOf(e) : a === e)for (f = c; f <= d.length;) {
                if (f++, g = d[f], g === b)return !0;
                if (g !== w)break
            }
            if (e === w)for (h = c; h > 0;) {
                if (h--, i = d[h], Array.isArray(a) ? -1 !== a.indexOf(i) : a === i)for (j = c; j <= d.length;) {
                    if (j++, k = d[j], k === b)return !0;
                    if (k !== w)break
                }
                if (i !== w)break
            }
            return !1
        }, qb = function (a, b) {
            for (var d, c = a; c >= 0;) {
                if (d = b[c], d !== w)return d;
                c--
            }
            return 0
        }, rb = function (a, b, c, d, e) {
            var f, g, h, i, j, k, l, m, n, q, r, s;
            if (0 === c[d])return eb;
            if (f = d - 1, Array.isArray(e) && e[f] === !0)return eb;
            if (g = f - 1, h = f + 1, i = b[f], j = g >= 0 ? b[g] : 0, k = b[h], i === o && k === p)return eb;
            if (-1 !== ib.indexOf(i))return db;
            if (-1 !== ib.indexOf(k))return eb;
            if (-1 !== jb.indexOf(k))return eb;
            if (qb(f, b) === u)return fb;
            if (gb.get(a[f]) === x && (k === X || k === S || k === T))return eb;
            if (i === t || k === t)return eb;
            if (i === v)return eb;
            if (-1 === [w, z, B].indexOf(i) && k === v)return eb;
            if (-1 !== [D, E, F, K, O].indexOf(k))return eb;
            if (qb(f, b) === I)return eb;
            if (pb(J, I, f, b))return eb;
            if (pb([D, E], H, f, b))return eb;
            if (pb(y, y, f, b))return eb;
            if (i === w)return fb;
            if (i === J || k === J)return eb;
            if (k === C || i === C)return fb;
            if (-1 !== [z, B, H].indexOf(k) || i === A)return eb;
            if (j === W && -1 !== nb.indexOf(i))return eb;
            if (i === O && k === W)return eb;
            if (k === G && -1 !== hb.concat(G, F, L, X, S, T).indexOf(i))return eb;
            if (-1 !== hb.indexOf(k) && i === L || -1 !== hb.indexOf(i) && k === L)return eb;
            if (i === N && -1 !== [X, S, T].indexOf(k) || -1 !== [X, S, T].indexOf(i) && k === M)return eb;
            if (-1 !== hb.indexOf(i) && -1 !== kb.indexOf(k) || -1 !== kb.indexOf(i) && -1 !== hb.indexOf(k))return eb;
            if (-1 !== [N, M].indexOf(i) && (k === L || -1 !== [I, B].indexOf(k) && b[h + 1] === L) || -1 !== [I, B].indexOf(i) && k === L || i === L && -1 !== [L, O, K].indexOf(k))return eb;
            if (-1 !== [L, O, K, D, E].indexOf(k))for (l = f; l >= 0;) {
                if (m = b[l], m === L)return eb;
                if (-1 === [O, K].indexOf(m))break;
                l--
            }
            if (-1 !== [N, M].indexOf(k))for (n = -1 !== [D, E].indexOf(i) ? g : f; n >= 0;) {
                if (q = b[n], q === L)return eb;
                if (-1 === [O, K].indexOf(q))break;
                n--
            }
            if (Y === i && -1 !== [Y, Z, U, V].indexOf(k) || -1 !== [Z, U].indexOf(i) && -1 !== [Z, $].indexOf(k) || -1 !== [$, V].indexOf(i) && k === $)return eb;
            if (-1 !== mb.indexOf(i) && -1 !== [G, M].indexOf(k) || -1 !== mb.indexOf(k) && i === N)return eb;
            if (-1 !== hb.indexOf(i) && -1 !== hb.indexOf(k))return eb;
            if (i === K && -1 !== hb.indexOf(k))return eb;
            if (-1 !== hb.concat(L).indexOf(i) && k === I || -1 !== hb.concat(L).indexOf(k) && i === E)return eb;
            if (i === _ && k === _) {
                for (r = c[f], s = 1; r > 0 && (r--, b[r] === _);)s++;
                if (0 !== s % 2)return eb
            }
            return i === S && k === T ? eb : fb
        }, b.lineBreakAtIndex = function (a, b) {
            if (0 === b)return eb;
            if (b >= a.length)return db;
            var c = ob(a), d = e(c, 2), f = d[0], g = d[1];
            return rb(a, g, f, b)
        }, tb = function (a, b) {
            var c, d, f, g, h, i;
            return b || (b = {
                lineBreak: "normal",
                wordBreak: "normal"
            }), c = ob(a, b.lineBreak), d = e(c, 3), f = d[0], g = d[1], h = d[2], ("break-all" === b.wordBreak || "break-word" === b.wordBreak) && (g = g.map(function (a) {
                return -1 !== [L, Q, ab].indexOf(a) ? X : a
            })), i = "keep-all" === b.wordBreak ? h.map(function (b, c) {
                return b && a[c] >= 19968 && a[c] <= 40959
            }) : null, [f, g, i]
        }, b.inlineBreakOpportunities = function (a, b) {
            var c = i.toCodePoints(a), d = eb, f = tb(c, b), g = e(f, 3), h = g[0], j = g[1], k = g[2];
            return c.forEach(function (a, b) {
                d += i.fromCodePoint(a) + (b >= c.length - 1 ? db : rb(c, j, h, b + 1, k))
            }), d
        }, vb = function () {
            function a(b, c, d, e) {
                l(this, a), this._codePoints = b, this.required = c === db, this.start = d, this.end = e
            }

            return d(a, [{
                key: "slice", value: function () {
                    return i.fromCodePoint.apply(void 0, k(this._codePoints.slice(this.start, this.end)))
                }
            }]), a
        }(), b.LineBreaker = function (a, b) {
            var c = i.toCodePoints(a), d = tb(c, b), f = e(d, 3), g = f[0], h = f[1], j = f[2], k = c.length, l = 0,
                m = 0;
            return {
                next: function () {
                    var a, b;
                    if (m >= k)return {done: !0};
                    for (a = eb; k > m && (a = rb(c, h, g, ++m, j)) === eb;);
                    return a !== eb || m === k ? (b = new vb(c, a, l, m), l = m, {value: b, done: !1}) : {done: !0}
                }
            }
        }
    }, function (a, b, c) {
        "use strict";
        function f(a, b) {
            if (!(a instanceof b))throw new TypeError("Cannot call a class as a function")
        }

        var d, e, g, h, i, j, k, l, m, n, o, p, q, r, s, t, u, w;
        Object.defineProperty(b, "__esModule", {value: !0}), b.Trie = b.createTrieFromBase64 = b.UTRIE2_INDEX_2_MASK = b.UTRIE2_INDEX_2_BLOCK_LENGTH = b.UTRIE2_OMITTED_BMP_INDEX_1_LENGTH = b.UTRIE2_INDEX_1_OFFSET = b.UTRIE2_UTF8_2B_INDEX_2_LENGTH = b.UTRIE2_UTF8_2B_INDEX_2_OFFSET = b.UTRIE2_INDEX_2_BMP_LENGTH = b.UTRIE2_LSCP_INDEX_2_LENGTH = b.UTRIE2_DATA_MASK = b.UTRIE2_DATA_BLOCK_LENGTH = b.UTRIE2_LSCP_INDEX_2_OFFSET = b.UTRIE2_SHIFT_1_2 = b.UTRIE2_INDEX_SHIFT = b.UTRIE2_SHIFT_1 = b.UTRIE2_SHIFT_2 = void 0, d = function () {
            function a(a, b) {
                var c, d;
                for (c = 0; c < b.length; c++)d = b[c], d.enumerable = d.enumerable || !1, d.configurable = !0, "value" in d && (d.writable = !0), Object.defineProperty(a, d.key, d)
            }

            return function (b, c, d) {
                return c && a(b.prototype, c), d && a(b, d), b
            }
        }(), e = c(13), g = b.UTRIE2_SHIFT_2 = 5, h = b.UTRIE2_SHIFT_1 = 11, i = b.UTRIE2_INDEX_SHIFT = 2, j = b.UTRIE2_SHIFT_1_2 = h - g, k = b.UTRIE2_LSCP_INDEX_2_OFFSET = 65536 >> g, l = b.UTRIE2_DATA_BLOCK_LENGTH = 1 << g, m = b.UTRIE2_DATA_MASK = l - 1, n = b.UTRIE2_LSCP_INDEX_2_LENGTH = 1024 >> g, o = b.UTRIE2_INDEX_2_BMP_LENGTH = k + n, p = b.UTRIE2_UTF8_2B_INDEX_2_OFFSET = o, q = b.UTRIE2_UTF8_2B_INDEX_2_LENGTH = 32, r = b.UTRIE2_INDEX_1_OFFSET = p + q, s = b.UTRIE2_OMITTED_BMP_INDEX_1_LENGTH = 65536 >> h, t = b.UTRIE2_INDEX_2_BLOCK_LENGTH = 1 << j, u = b.UTRIE2_INDEX_2_MASK = t - 1, b.createTrieFromBase64 = function (a) {
            var b = e.decode(a), c = Array.isArray(b) ? e.polyUint32Array(b) : new Uint32Array(b),
                d = Array.isArray(b) ? e.polyUint16Array(b) : new Uint16Array(b), f = 24, g = d.slice(f / 2, c[4] / 2),
                h = 2 === c[5] ? d.slice((f + c[4]) / 2) : c.slice(Math.ceil((f + c[4]) / 4));
            return new w(c[0], c[1], c[2], c[3], g, h)
        }, w = b.Trie = function () {
            function a(b, c, d, e, g, h) {
                f(this, a), this.initialValue = b, this.errorValue = c, this.highStart = d, this.highValueIndex = e, this.index = g, this.data = h
            }

            return d(a, [{
                key: "get", value: function (a) {
                    var b = void 0;
                    if (a >= 0) {
                        if (55296 > a || a > 56319 && 65535 >= a)return b = this.index[a >> g], b = (b << i) + (a & m), this.data[b];
                        if (65535 >= a)return b = this.index[k + (a - 55296 >> g)], b = (b << i) + (a & m), this.data[b];
                        if (a < this.highStart)return b = r - s + (a >> h), b = this.index[b], b += a >> g & u, b = this.index[b], b = (b << i) + (a & m), this.data[b];
                        if (1114111 >= a)return this.data[this.highValueIndex]
                    }
                    return this.errorValue
                }
            }]), a
        }()
    }, function (a) {
        "use strict";
        a.exports = "KwAAAAAAAAAACA4AIDoAAPAfAAACAAAAAAAIABAAGABAAEgAUABYAF4AZgBeAGYAYABoAHAAeABeAGYAfACEAIAAiACQAJgAoACoAK0AtQC9AMUAXgBmAF4AZgBeAGYAzQDVAF4AZgDRANkA3gDmAOwA9AD8AAQBDAEUARoBIgGAAIgAJwEvATcBPwFFAU0BTAFUAVwBZAFsAXMBewGDATAAiwGTAZsBogGkAawBtAG8AcIBygHSAdoB4AHoAfAB+AH+AQYCDgIWAv4BHgImAi4CNgI+AkUCTQJTAlsCYwJrAnECeQKBAk0CiQKRApkCoQKoArACuALAAsQCzAIwANQC3ALkAjAA7AL0AvwCAQMJAxADGAMwACADJgMuAzYDPgOAAEYDSgNSA1IDUgNaA1oDYANiA2IDgACAAGoDgAByA3YDfgOAAIQDgACKA5IDmgOAAIAAogOqA4AAgACAAIAAgACAAIAAgACAAIAAgACAAIAAgACAAIAAgACAAK8DtwOAAIAAvwPHA88D1wPfAyAD5wPsA/QD/AOAAIAABAQMBBIEgAAWBB4EJgQuBDMEIAM7BEEEXgBJBCADUQRZBGEEaQQwADAAcQQ+AXkEgQSJBJEEgACYBIAAoASoBK8EtwQwAL8ExQSAAIAAgACAAIAAgACgAM0EXgBeAF4AXgBeAF4AXgBeANUEXgDZBOEEXgDpBPEE+QQBBQkFEQUZBSEFKQUxBTUFPQVFBUwFVAVcBV4AYwVeAGsFcwV7BYMFiwWSBV4AmgWgBacFXgBeAF4AXgBeAKsFXgCyBbEFugW7BcIFwgXIBcIFwgXQBdQF3AXkBesF8wX7BQMGCwYTBhsGIwYrBjMGOwZeAD8GRwZNBl4AVAZbBl4AXgBeAF4AXgBeAF4AXgBeAF4AXgBeAGMGXgBqBnEGXgBeAF4AXgBeAF4AXgBeAF4AXgB5BoAG4wSGBo4GkwaAAIADHgR5AF4AXgBeAJsGgABGA4AAowarBrMGswagALsGwwbLBjAA0wbaBtoG3QbaBtoG2gbaBtoG2gblBusG8wb7BgMHCwcTBxsHCwcjBysHMAc1BzUHOgdCB9oGSgdSB1oHYAfaBloHaAfaBlIH2gbaBtoG2gbaBtoG2gbaBjUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHbQdeAF4ANQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQd1B30HNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1B4MH2gaKB68EgACAAIAAgACAAIAAgACAAI8HlwdeAJ8HpweAAIAArwe3B14AXgC/B8UHygcwANAH2AfgB4AA6AfwBz4B+AcACFwBCAgPCBcIogEYAR8IJwiAAC8INwg/CCADRwhPCFcIXwhnCEoDGgSAAIAAgABvCHcIeAh5CHoIewh8CH0Idwh4CHkIegh7CHwIfQh3CHgIeQh6CHsIfAh9CHcIeAh5CHoIewh8CH0Idwh4CHkIegh7CHwIfQh3CHgIeQh6CHsIfAh9CHcIeAh5CHoIewh8CH0Idwh4CHkIegh7CHwIfQh3CHgIeQh6CHsIfAh9CHcIeAh5CHoIewh8CH0Idwh4CHkIegh7CHwIfQh3CHgIeQh6CHsIfAh9CHcIeAh5CHoIewh8CH0Idwh4CHkIegh7CHwIfQh3CHgIeQh6CHsIfAh9CHcIeAh5CHoIewh8CH0Idwh4CHkIegh7CHwIfQh3CHgIeQh6CHsIfAh9CHcIeAh5CHoIewh8CH0Idwh4CHkIegh7CHwIfQh3CHgIeQh6CHsIfAh9CHcIeAh5CHoIewh8CH0Idwh4CHkIegh7CHwIfQh3CHgIeQh6CHsIfAh9CHcIeAh5CHoIewh8CH0Idwh4CHkIegh7CHwIfQh3CHgIeQh6CHsIfAh9CHcIeAh5CHoIewh8CH0Idwh4CHkIegh7CHwIfQh3CHgIeQh6CHsIfAh9CHcIeAh5CHoIewh8CH0Idwh4CHkIegh7CHwIfQh3CHgIeQh6CHsIfAh9CHcIeAh5CHoIewh8CH0Idwh4CHkIegh7CHwIfQh3CHgIeQh6CHsIfAh9CHcIeAh5CHoIewh8CH0Idwh4CHkIegh7CHwIfQh3CHgIeQh6CHsIfAh9CHcIeAh5CHoIewh8CH0Idwh4CHkIegh7CHwIfQh3CHgIeQh6CHsIfAh9CHcIeAh5CHoIewh8CH0Idwh4CHkIegh7CHwIfQh3CHgIeQh6CHsIfAh9CHcIeAh5CHoIewh8CH0Idwh4CHkIegh7CHwIfQh3CHgIeQh6CHsIfAh9CHcIeAh5CHoIewh8CH0Idwh4CHkIegh7CHwIhAiLCI4IMAAwADAAMAAwADAAMAAwADAAMAAwADAAMAAwADAAMAAwADAAMAAwADAAMAAwADAAMAAwADAAMAAwADAAMAAwAJYIlgiWCJYIlgiWCJYIlgiWCJYIlgiWCJYIlgiWCJYIlgiWCJYIlgiWCJYIlgiWCJYIlgiWCJYIlgiWCJYIlggwADAAMAAwADAAMAAwADAAMAAwADAAMAAwADAAMAAwADAAMAAwADAAMAAwADAAMAAwADAAMAAwADAAMAAwADAAMAAwADAAMAAwADAAMAAwADAAMAAwADAAMAAwADAAMAAwADAAMAAwADAAMAAwADAAMAAwADAAMAAwADAAMAAwADAAMAAwADAAMAAwADAAMAAwADAAMAAwADAAMAAwADAAMAAwADAAMAAwADAAMAAwADAAMAAwADAAMAAwADAAMAAwADAAMAAwADAAMAAwADAAMAAwADAAMAAwADAAMAAwADAAMAAwADAAMAAwADAAMAAwADAAMAAwADAAMAAwADAAMAAwADAAMAAwADAAMAAwADAAMAAwADAAMAAwADAAMAAwADAAMAAwADAAMAAwADAAMAAwADAAMAAwADAAMAAwADAAMAAwADAAMAAwADAAMAAwADAAMAAwADAAMAAwADAAMAAwADAAMAAwADAAMAAwADAAMAAwADAAMAAwADAAMAAwADAAMAAwADAAMAAwADAANQc1BzUHNQc1BzUHNQc1BzUHNQc1B54INQc1B6II2gaqCLIIugiAAIAAvgjGCIAAgACAAIAAgACAAIAAgACAAIAAywiHAYAA0wiAANkI3QjlCO0I9Aj8CIAAgACAAAIJCgkSCRoJIgknCTYHLwk3CZYIlgiWCJYIlgiWCJYIlgiWCJYIlgiWCJYIlgiWCJYIlgiWCJYIlgiWCJYIlgiWCJYIlgiWCJYIlgiWCJYIlgiAAIAAAAFAAXgBeAGAAcABeAHwAQACQAKAArQC9AJ4AXgBeAE0A3gBRAN4A7AD8AMwBGgEAAKcBNwEFAUwBXAF4QkhCmEKnArcCgAHHAsABz4LAAcABwAHAAd+C6ABoAG+C/4LAAcABwAHAAc+DF4MAAcAB54M3gweDV4Nng3eDaABoAGgAaABoAGgAaABoAGgAaABoAGgAaABoAGgAaABoAGgAaABoAEeDqABVg6WDqABoQ6gAaABoAHXDvcONw/3DvcO9w73DvcO9w73DvcO9w73DvcO9w73DvcO9w73DvcO9w73DvcO9w73DvcO9w73DvcO9w73DvcO9w73DncPAAcABwAHAAcABwAHAAcABwAHAAcABwAHAAcABwAHAAcABwAHAAcABwAHAAcABwAHAAcABwAHAAcABwAHAAcABwAHAAcABwAHAAcABwAHAAcABwAHAAcABwAHAAcABwAHAAcABwAHAAcABwAHAAcABwAHAAcABwAHAAcABwAHAAcABwAHAAcABwAHAAcABwAHAAcABwAHAAcABwAHAAcABwAHAAcABwAHAAcABwAHAAcABwAHAAcABwAHAAcABwAHAAcABwAHAAcABwAHAAcABwAHAAcABwAHAAcABwAHAAcABwAHAAcABwAHAAcABwAHAAcABwAHAAcABwAHAAcABwAHAAcABwAHAAcABwAHAAcABwAHAAcABwAHAAcABwAHAAcABwAHAAcABwAHAAcABwAHAAcABwAHAAcABwAHAAcABwAHAAcABwAHAAcABwAHAAcABwAHAAcABwAHAAcABwAHAAcABwAHAAcABwAHAAcABwAHAAcABwAHAAcABwAHAAcABwAHAAcABwAHAAcABwAHAAcABwAHAAcABwAHAAcABwAHAAcABwAHAAcABwAHAAcABwAHAAcABwAHAAcABwAHAAcABwAHAAcABwAHAAcABwAHAAcABwAHAAcABwAHAAcABwAHAAcABwAHAAcABwAHAAcABwAHAAcABwAHAAcABwAHAAcABwAHAAcABwAHAAcABwAHAAcABwAHAAcABwAHAAcABwAHAAcABwAHAAcABwAHAAcABwAHAAcABwAHAAcABwAHAAcABwAHAAcABwAHAAcABwAHAAcABwAHAAcABwAHAAcABwAHAAcABwAHAAcABwAHAAcABwAHAAcAB7cPPwlGCU4JMACAAIAAgABWCV4JYQmAAGkJcAl4CXwJgAkwADAAMAAwAIgJgACLCZMJgACZCZ8JowmrCYAAswkwAF4AXgB8AIAAuwkABMMJyQmAAM4JgADVCTAAMAAwADAAgACAAIAAgACAAIAAgACAAIAAqwYWBNkIMAAwADAAMADdCeAJ6AnuCR4E9gkwAP4JBQoNCjAAMACAABUK0wiAAB0KJAosCjQKgAAwADwKQwqAAEsKvQmdCVMKWwowADAAgACAALcEMACAAGMKgABrCjAAMAAwADAAMAAwADAAMAAwADAAMAAeBDAAMAAwADAAMAAwADAAMAAwADAAMAAwAIkEPQFzCnoKiQSCCooKkAqJBJgKoAqkCokEGAGsCrQKvArBCjAAMADJCtEKFQHZCuEK/gHpCvEKMAAwADAAMACAAIwE+QowAIAAPwEBCzAAMAAwADAAMACAAAkLEQswAIAAPwEZCyELgAAOCCkLMAAxCzkLMAAwADAAMAAwADAAXgBeAEELMAAwADAAMAAwADAAMAAwAEkLTQtVC4AAXAtkC4AAiQkwADAAMAAwADAAMAAwADAAbAtxC3kLgAuFC4sLMAAwAJMLlwufCzAAMAAwADAAMAAwADAAMAAwADAAMAAwADAAMAAwADAAMAAwADAAMAAwAIAAgACAAIAAgACAAIAAgACAAIAAgACAAIAAgACAAIAAgACAAIAAgACAAIAAgACAAIAAgACAAIAApwswADAAMACAAIAAgACvC4AAgACAAIAAgACAALcLMAAwADAAMAAwADAAMAAwADAAMAAwADAAMAAwADAAMAAwADAAMAAwADAAgACAAIAAgACAAIAAgACAAIAAgACAAIAAgACAAIAAgACAAIAAvwuAAMcLgACAAIAAgACAAIAAyguAAIAAgACAAIAA0QswADAAMAAwADAAMAAwADAAMAAwADAAMAAwADAAMAAwADAAMAAwADAAMAAwADAAMAAwADAAMAAwADAAMAAwADAAgACAAIAAgACAAIAAgACAAIAAgACAAIAAgACAANkLgACAAIAA4AswADAAMAAwADAAMAAwADAAMAAwADAAMAAwAIAAgACAAIAAgACAAIAAgACAAIAAgACAAIAAgACAAIAAgACJCR4E6AswADAAhwHwC4AA+AsADAgMEAwwADAAMAAwADAAMAAwADAAMAAwADAAMAAwADAAMAAwADAAMAAwADAAMAAwADAAMAAwADAAMACAAIAAGAwdDCUMMAAwAC0MNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQw1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHPQwwADAAMAAwADAAMAAwADAAMAAwADAAMAAwADAAMAAwADAAMAAwADAAMAAwADAAMAAwADAAMAAwADAAMAAwADAAMAAwADAAMAAwADAAMAAwADUHNQc1BzUHNQc1BzUHNQc2BzAAMAA5DDUHNQc1BzUHNQc1BzUHNQc1BzUHNQdFDDAAMAAwADAAMAAwADAAMAAwADAAMAAwADAAMAAwADAAMAAwADAAMAAwADAAMAAwADAAMAAwADAAMAAwADAAMAAwADAAMAAwADAAMAAwADAAgACAAIAATQxSDFoMMAAwADAAMAAwADAAMAAwADAAMAAwADAAMAAwADAAMAAwADAAMAAwADAAMAAwADAAMAAwAF4AXgBeAF4AXgBeAF4AYgxeAGoMXgBxDHkMfwxeAIUMXgBeAI0MMAAwADAAMAAwAF4AXgCVDJ0MMAAwADAAMABeAF4ApQxeAKsMswy7DF4Awgy9DMoMXgBeAF4AXgBeAF4AXgBeAF4AXgDRDNkMeQBqCeAM3Ax8AOYM7Az0DPgMXgBeAF4AXgBeAF4AXgBeAF4AXgBeAF4AXgBeAF4AXgCgAAANoAAHDQ4NFg0wADAAMAAwADAAMAAwADAAMAAwADAAMAAwADAAMAAwADAAMAAwADAAMAAwADAAMAAwADAAMAAwADAAMAAwADAAMAAwADAAMAAwADAAMAAwADAAMAAeDSYNMAAwADAAMAAwADAAMAAwADAAMAAwADAAMAAwADAAMAAwADAAMAAwADAAMAAwADAAMAAwADAAMAAwADAAMAAwADAAMAAwADAAMAAwADAAMAAwADAAMAAwADAAMAAwADAAMAAwADAAMAAwADAAMAAwADAAMAAwADAAMAAwAIAAgACAAIAAgACAAC4NMABeAF4ANg0wADAAMAAwADAAMAAwADAAMAAwADAAMAAwADAAMAAwADAAMAAwADAAMAAwADAAMAAwADAAMAAwADAAMAAwADAAMAAwADAAMAAwAD4NRg1ODVYNXg1mDTAAbQ0wADAAMAAwADAAMAAwADAA2gbaBtoG2gbaBtoG2gbaBnUNeg3CBYANwgWFDdoGjA3aBtoG2gbaBtoG2gbaBtoG2gbaBtoG2gaUDZwNpA2oDdoG2gawDbcNvw3HDdoG2gbPDdYN3A3fDeYN2gbsDfMN2gbaBvoN/g3aBgYODg7aBl4AXgBeABYOXgBeACUG2gYeDl4AJA5eACwO2w3aBtoGMQ45DtoG2gbaBtoGQQ7aBtoG2gbaBtoG2gbaBtoG2gbaBtoG2gbaBtoG2gbaBtoG2gbaBtoG2gbaBtoG2gbaBtoG2gbaBtoG2gbaBtoG2gbaBtoG2gbaBtoG2gbaBtoG2gbaBtoG2gbaBtoG2gZJDjUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1B1EO2gY1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQdZDjUHNQc1BzUHNQc1B2EONQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHaA41BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1B3AO2gbaBtoG2gbaBtoG2gbaBtoG2gbaBtoG2gbaBtoG2gbaBtoG2gbaBtoG2gbaBtoG2gbaBtoG2gbaBtoG2gbaBtoG2gbaBtoG2gbaBtoG2gbaBtoG2gbaBtoG2gbaBtoG2gbaBtoG2gbaBtoG2gbaBtoG2gbaBtoG2gbaBtoG2gY1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1BzUHNQc1B2EO2gbaBtoG2gbaBtoG2gbaBtoG2gbaBtoG2gbaBtoG2gbaBtoG2gbaBtoG2gbaBtoG2gbaBtoG2gbaBtoG2gbaBtoG2gbaBtoG2gbaBtoG2gbaBtoG2gbaBtoG2gZJDtoG2gbaBtoG2gbaBtoG2gbaBtoG2gbaBtoG2gbaBtoG2gbaBtoG2gbaBtoG2gbaBtoG2gbaBtoG2gbaBtoG2gbaBtoG2gbaBtoG2gbaBtoG2gbaBtoG2gbaBtoG2gbaBtoG2gbaBtoG2gbaBtoG2gbaBtoG2gbaBtoG2gbaBkkOeA6gAKAAoAAwADAAMAAwAKAAoACgAKAAoACgAKAAgA4wADAAMAAwADAAMAAwADAAMAAwADAAMAAwADAAMAAwADAAMAAwADAAMAAwADAAMAAwADAAMAAwADAAMAAwADAAMAAwADAAMAAwADAAMAAwADAAMAAwADAAMAAwADAAMAD//wQABAAEAAQABAAEAAQABAAEAA0AAwABAAEAAgAEAAQABAAEAAQABAAEAAQABAAEAAQABAAEAAQABAAEAAQABAAKABMAFwAeABsAGgAeABcAFgASAB4AGwAYAA8AGAAcAEsASwBLAEsASwBLAEsASwBLAEsAGAAYAB4AHgAeABMAHgBQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAFgAbABIAHgAeAB4AUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQABYADQARAB4ABAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAACsAKwArACsAKwArACsAKwArACsAKwArACsAKwArACsAKwArACsAKwArACsAKwArACsAKwArACsAKwArACsAKwArACsAKwArACsAKwArACsAKwArACsAKwArACsAKwArACsAKwArACsAKwArACsAKwArACsAKwArACsAKwArACsABAAEAAQABAAEAAUABAAEAAQABAAEAAQABAAEAAQABAAEAAQABAAEAAQABAAEAAQABAAEAAQABAAEAAQABAAEAAkAFgAaABsAGwAbAB4AHQAdAB4ATwAXAB4ADQAeAB4AGgAbAE8ATwAOAFAAHQAdAB0ATwBPABcATwBPAE8AFgBQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAHQAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB0AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgBQAB4AHgAeAB4AUABQAFAAUAAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgBQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUAAeAB4AHgAeAFAATwBAAE8ATwBPAEAATwBQAFAATwBQAB4AHgAeAB4AHgAeAB0AHQAdAB0AHgAdAB4ADgBQAFAAUABQAFAAHgAeAB4AHgAeAB4AHgBQAB4AUAAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4ABAAEAAQABAAEAAQABAAEAAQABAAEAAQABAAEAAQABAAEAAQABAAEAAQABAAEAAQABAAEAAQABAAEAAQABAAEAAQABAAEAAQABAAEAAQABAAEAAQABAAEAAQABAAEAAQABAAEAAQABAAEAAQABAAEAAQABAAEAAQABAAEAAQABAAEAAQABAAJAAQABAAEAAQABAAEAAQABAAEAAQABAAEAAkACQAJAAkACQAJAAkABAAEAAQABAAEAAQABAAEAAQABAAEAAQABAAeAB4AHgAeAFAAHgAeAB4AKwArAFAAUABQAFAAGABQACsAKwArACsAHgAeAFAAHgBQAFAAUAArAFAAKwAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AKwAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4ABAAEAAQABAAEAAQABAAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgArAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUAArACsAUAAeAB4AHgAeAB4AHgArAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAKwAYAA0AKwArAB4AHgAbACsABAAEAAQABAAEAAQABAAEAAQABAAEAAQABAAEAAQABAAEAAQABAAEAAQABAAEAAQABAAEAAQABAAEAAQABAAEAAQABAAEAAQABAAEAAQABAAEAAQABAAEAAQADQAEAB4ABAAEAB4ABAAEABMABAArACsAKwArACsAKwArACsAVgBWAFYAVgBWAFYAVgBWAFYAVgBWAFYAVgBWAFYAVgBWAFYAVgBWAFYAVgBWAFYAVgBWAFYAKwArACsAKwArAFYAVgBWAB4AHgArACsAKwArACsAKwArACsAKwArACsAHgAeAB4AHgAeAB4AHgAeAB4AGgAaABoAGAAYAB4AHgAEAAQABAAEAAQABAAEAAQABAAEAAQAEwAEACsAEwATAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUAAEAAQABAAEAAQABAAEAAQABAAEAAQABAAEAAQABAAEAAQABAAEAAQABABLAEsASwBLAEsASwBLAEsASwBLABoAGQAZAB4AUABQAAQAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQABMAUAAEAAQABAAEAAQABAAEAB4AHgAEAAQABAAEAAQABABQAFAABAAEAB4ABAAEAAQABABQAFAASwBLAEsASwBLAEsASwBLAEsASwBQAFAAUAAeAB4AUAAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AKwAeAFAABABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUAAEAAQABAAEAAQABAAEAAQABAAEAAQABAAEAAQABAAEAAQABAAEACsAKwBQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAABAAEAAQABAAEAAQABAAEAAQABAAEAFAAKwArACsAKwArACsAKwArACsAKwArACsAKwArAEsASwBLAEsASwBLAEsASwBLAEsAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAABAAEAAQABAAEAAQABAAEAAQAUABQAB4AHgAYABMAUAArACsAKwArACsAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUAAEAAQABAAEAFAABAAEAAQABAAEAFAABAAEAAQAUAAEAAQABAAEAAQAKwArAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeACsAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUAAEAAQABAArACsAHgArAFAAUABQAFAAUABQAFAAUABQAFAAUAArACsAKwArACsAKwArACsAKwArACsAKwArACsAKwArACsAKwArACsAKwBQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUAArAFAAUABQAFAAUABQAFAAUAArACsAKwArACsAKwArACsAKwArACsAKwArACsAKwArACsAKwArACsAKwArAAQABAAEAAQABAAEAAQABAAEAAQABAAEAAQABAAeAAQABAAEAAQABAAEAAQABAAEAAQABAAEAAQABAAEAAQABAAEAAQABAAEAAQABAAEAAQABAAEAAQABABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUAAEAAQABABQAAQABAAEAAQABAAEAAQABAAEAAQABAAEAAQABAAEAAQABAAEAFAABAAEAAQABAAEAAQABABQAFAAUABQAFAAUABQAFAAUABQAAQABAANAA0ASwBLAEsASwBLAEsASwBLAEsASwAeAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAABAAEAAQAKwBQAFAAUABQAFAAUABQAFAAKwArAFAAUAArACsAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQACsAUABQAFAAUABQAFAAUAArAFAAKwArACsAUABQAFAAUAArACsABABQAAQABAAEAAQABAAEAAQAKwArAAQABAArACsABAAEAAQAUAArACsAKwArACsAKwArACsABAArACsAKwArAFAAUAArAFAAUABQAAQABAArACsASwBLAEsASwBLAEsASwBLAEsASwBQAFAAGgAaAFAAUABQAFAAUABMAB4AGwBQAB4AKwArACsABAAEAAQAKwBQAFAAUABQAFAAUAArACsAKwArAFAAUAArACsAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQACsAUABQAFAAUABQAFAAUAArAFAAUAArAFAAUAArAFAAUAArACsABAArAAQABAAEAAQABAArACsAKwArAAQABAArACsABAAEAAQAKwArACsABAArACsAKwArACsAKwArAFAAUABQAFAAKwBQACsAKwArACsAKwArACsASwBLAEsASwBLAEsASwBLAEsASwAEAAQAUABQAFAABAArACsAKwArACsAKwArACsAKwArACsABAAEAAQAKwBQAFAAUABQAFAAUABQAFAAUAArAFAAUABQACsAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQACsAUABQAFAAUABQAFAAUAArAFAAUAArAFAAUABQAFAAUAArACsABABQAAQABAAEAAQABAAEAAQABAArAAQABAAEACsABAAEAAQAKwArAFAAKwArACsAKwArACsAKwArACsAKwArACsAKwArACsAUABQAAQABAArACsASwBLAEsASwBLAEsASwBLAEsASwAeABsAKwArACsAKwArACsAKwBQAAQABAAEAAQABAAEACsABAAEAAQAKwBQAFAAUABQAFAAUABQAFAAKwArAFAAUAArACsAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUAAEAAQABAAEAAQAKwArAAQABAArACsABAAEAAQAKwArACsAKwArACsAKwArAAQABAArACsAKwArAFAAUAArAFAAUABQAAQABAArACsASwBLAEsASwBLAEsASwBLAEsASwAeAFAAUABQAFAAUABQAFAAKwArACsAKwArACsAKwArACsAKwAEAFAAKwBQAFAAUABQAFAAUAArACsAKwBQAFAAUAArAFAAUABQAFAAKwArACsAUABQACsAUAArAFAAUAArACsAKwBQAFAAKwArACsAUABQAFAAKwArACsAUABQAFAAUABQAFAAUABQAFAAUABQAFAAKwArACsAKwAEAAQABAAEAAQAKwArACsABAAEAAQAKwAEAAQABAAEACsAKwBQACsAKwArACsAKwArAAQAKwArACsAKwArACsAKwArACsAKwBLAEsASwBLAEsASwBLAEsASwBLAFAAUABQAB4AHgAeAB4AHgAeABsAHgArACsAKwArACsABAAEAAQABAArAFAAUABQAFAAUABQAFAAUAArAFAAUABQACsAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAKwBQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQACsAKwArAFAABAAEAAQABAAEAAQABAArAAQABAAEACsABAAEAAQABAArACsAKwArACsAKwArAAQABAArAFAAUABQACsAKwArACsAKwBQAFAABAAEACsAKwBLAEsASwBLAEsASwBLAEsASwBLACsAKwArACsAKwArACsAKwBQAFAAUABQAFAAUABQAB4AUAAEAAQABAArAFAAUABQAFAAUABQAFAAUAArAFAAUABQACsAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAKwBQAFAAUABQAFAAUABQAFAAUABQACsAUABQAFAAUABQACsAKwAEAFAABAAEAAQABAAEAAQABAArAAQABAAEACsABAAEAAQABAArACsAKwArACsAKwArAAQABAArACsAKwArACsAKwArAFAAKwBQAFAABAAEACsAKwBLAEsASwBLAEsASwBLAEsASwBLACsAUABQACsAKwArACsAKwArACsAKwArACsAKwArACsAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAABAAEAFAABAAEAAQABAAEAAQABAArAAQABAAEACsABAAEAAQABABQAB4AKwArACsAKwBQAFAAUAAEAFAAUABQAFAAUABQAFAAUABQAFAABAAEACsAKwBLAEsASwBLAEsASwBLAEsASwBLAFAAUABQAFAAUABQAFAAUABQABoAUABQAFAAUABQAFAAKwArAAQABAArAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQACsAKwArAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUAArAFAAUABQAFAAUABQAFAAUABQACsAUAArACsAUABQAFAAUABQAFAAUAArACsAKwAEACsAKwArACsABAAEAAQABAAEAAQAKwAEACsABAAEAAQABAAEAAQABAAEACsAKwArACsAKwArAEsASwBLAEsASwBLAEsASwBLAEsAKwArAAQABAAeACsAKwArACsAKwArACsAKwArACsAKwArAFwAXABcAFwAXABcAFwAXABcAFwAXABcAFwAXABcAFwAXABcAFwAXABcAFwAXABcAFwAXABcAFwAXABcAFwAXAAqAFwAXAAqACoAKgAqACoAKgAqACsAKwArACsAGwBcAFwAXABcAFwAXABcACoAKgAqACoAKgAqACoAKgAeAEsASwBLAEsASwBLAEsASwBLAEsADQANACsAKwArACsAKwBcAFwAKwBcACsAKwBcAFwAKwBcACsAKwBcACsAKwArACsAKwArAFwAXABcAFwAKwBcAFwAXABcAFwAXABcACsAXABcAFwAKwBcACsAXAArACsAXABcACsAXABcAFwAXAAqAFwAXAAqACoAKgAqACoAKgArACoAKgBcACsAKwBcAFwAXABcAFwAKwBcACsAKgAqACoAKgAqACoAKwArAEsASwBLAEsASwBLAEsASwBLAEsAKwArAFwAXABcAFwAUAAOAA4ADgAOAB4ADgAOAAkADgAOAA0ACQATABMAEwATABMACQAeABMAHgAeAB4ABAAEAB4AHgAeAB4AHgAeAEsASwBLAEsASwBLAEsASwBLAEsAUABQAFAAUABQAFAAUABQAFAAUAANAAQAHgAEAB4ABAAWABEAFgARAAQABABQAFAAUABQAFAAUABQAFAAKwBQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUAArACsAKwArAAQABAAEAAQABAAEAAQABAAEAAQABAAEAAQABAANAAQABAAEAAQABAANAAQABABQAFAAUABQAFAABAAEAAQABAAEAAQABAAEAAQABAAEACsABAAEAAQABAAEAAQABAAEAAQABAAEAAQABAAEAAQABAAEAAQABAAEAAQABAAEAAQABAAEAAQABAAEAAQABAAEACsADQANAB4AHgAeAB4AHgAeAAQAHgAeAB4AHgAeAB4AKwAeAB4ADgAOAA0ADgAeAB4AHgAeAB4ACQAJACsAKwArACsAKwBcAFwAXABcAFwAXABcAFwAXABcAFwAXABcAFwAXABcAFwAXABcAFwAXABcAFwAXABcAFwAXABcAFwAXABcAFwAXABcAFwAKgAqACoAKgAqACoAKgAqACoAKgAqACoAKgAqACoAKgAqACoAKgAqAFwASwBLAEsASwBLAEsASwBLAEsASwANAA0AHgAeAB4AHgBcAFwAXABcAFwAXAAqACoAKgAqAFwAXABcAFwAKgAqACoAXAAqACoAKgBcAFwAKgAqACoAKgAqACoAKgBcAFwAXAAqACoAKgAqAFwAXABcAFwAXABcAFwAXABcAFwAXABcAFwAKgAqACoAKgAqACoAKgAqACoAKgAqACoAXAAqAEsASwBLAEsASwBLAEsASwBLAEsAKgAqACoAKgAqACoAUABQAFAAUABQAFAAKwBQACsAKwArACsAKwBQACsAKwBQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUAAeAFAAUABQAFAAWABYAFgAWABYAFgAWABYAFgAWABYAFgAWABYAFgAWABYAFgAWABYAFgAWABYAFgAWABYAFgAWABYAFgAWABYAFkAWQBZAFkAWQBZAFkAWQBZAFkAWQBZAFkAWQBZAFkAWQBZAFkAWQBZAFkAWQBZAFkAWQBZAFkAWQBZAFkAWQBaAFoAWgBaAFoAWgBaAFoAWgBaAFoAWgBaAFoAWgBaAFoAWgBaAFoAWgBaAFoAWgBaAFoAWgBaAFoAWgBaAFoAUABQAFAAUABQAFAAUABQAFAAKwBQAFAAUABQACsAKwBQAFAAUABQAFAAUABQACsAUAArAFAAUABQAFAAKwArAFAAUABQAFAAUABQAFAAUABQACsAUABQAFAAUAArACsAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQACsAUABQAFAAUAArACsAUABQAFAAUABQAFAAUAArAFAAKwBQAFAAUABQACsAKwBQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUAArAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUAArAFAAUABQAFAAKwArAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQACsAKwAEAAQABAAeAA0AHgAeAB4AHgAeAB4AHgBQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAKwArACsAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUAAeAB4AHgAeAB4AHgAeAB4AHgAeACsAKwArACsAKwArAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAKwArAFAAUABQAFAAUABQACsAKwANAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUAAeAB4AUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAA0AUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQABYAEQArACsAKwBQAFAAUABQAFAAUABQAFAAUABQAFAADQANAA0AUABQAFAAUABQAFAAUABQAFAAUABQACsAKwArACsAKwArACsAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUAArAFAAUABQAFAABAAEAAQAKwArACsAKwArACsAKwArACsAKwArAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAAQABAAEAA0ADQArACsAKwArACsAKwArACsAKwBQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUAAEAAQAKwArACsAKwArACsAKwArACsAKwArACsAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUAArAFAAUABQACsABAAEACsAKwArACsAKwArACsAKwArACsAKwArAFwAXABcAFwAXABcAFwAXABcAFwAXABcAFwAXABcAFwAXABcAFwAXAAqACoAKgAqACoAKgAqACoAKgAqACoAKgAqACoAKgAqACoAKgAqACoADQANABUAXAANAB4ADQAbAFwAKgArACsASwBLAEsASwBLAEsASwBLAEsASwArACsAKwArACsAKwBQAFAAUABQAFAAUABQAFAAUABQACsAKwArACsAKwArAB4AHgATABMADQANAA4AHgATABMAHgAEAAQABAAJACsASwBLAEsASwBLAEsASwBLAEsASwArACsAKwArACsAKwBQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUAArACsAKwArACsAKwArACsAUABQAFAAUABQAAQABABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAABABQACsAKwArACsAKwBQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQACsAKwArACsAKwArACsAKwArACsAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUAArAAQABAAEAAQABAAEAAQABAAEAAQABAAEACsAKwArACsABAAEAAQABAAEAAQABAAEAAQABAAEAAQAKwArACsAKwAeACsAKwArABMAEwBLAEsASwBLAEsASwBLAEsASwBLAFwAXABcAFwAXABcAFwAXABcAFwAXABcAFwAXABcAFwAXABcACsAKwBcAFwAXABcAFwAKwArACsAKwArACsAKwArACsAKwArAFwAXABcAFwAXABcAFwAXABcAFwAXABcACsAKwArACsAXABcAFwAXABcAFwAXABcAFwAXABcAFwAXABcAFwAXABcAFwAKwArACsAKwArACsASwBLAEsASwBLAEsASwBLAEsASwBcACsAKwArACoAKgBQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAABAAEAAQABAAEACsAKwAeAB4AXABcAFwAXABcAFwAXABcAFwAXABcAFwAXABcAFwAXABcAFwAXABcAFwAKgAqACoAKgAqACoAKgAqACoAKgArACoAKgAqACoAKgAqACoAKgAqACoAKgAqACoAKgAqACoAKgAqACoAKgAqACoAKgAqACoAKgAqACoAKgArACsABABLAEsASwBLAEsASwBLAEsASwBLACsAKwArACsAKwArAEsASwBLAEsASwBLAEsASwBLAEsAKwArACsAKwArACsAKgAqACoAKgAqACoAKgBcACoAKgAqACoAKgAqACsAKwAEAAQABAAEAAQABAAEAAQABAAEAAQABAAEAAQABAArAAQABAAEAAQABABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUAAEAAQABAAEAAQAUABQAFAAUABQAFAAUAArACsAKwArAEsASwBLAEsASwBLAEsASwBLAEsADQANAB4ADQANAA0ADQAeAB4AHgAeAB4AHgAeAB4AHgAeAAQABAAEAAQABAAEAAQABAAEAB4AHgAeAB4AHgAeAB4AHgAeACsAKwArAAQABAAEAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAAQABAAEAAQABAAEAAQABAAEAAQABAAEAAQAUABQAEsASwBLAEsASwBLAEsASwBLAEsAUABQAFAAUABQAFAAUABQAAQABAAEAAQABAAEAAQABAAEAAQABAAEAAQABAArACsAKwArACsAKwArACsAHgAeAB4AHgBQAFAAUABQAAQABAAEAAQABAAEAAQABAAEAAQABAAEAAQABAAEAAQABAAEAAQABAArACsAKwANAA0ADQANAA0ASwBLAEsASwBLAEsASwBLAEsASwArACsAKwBQAFAAUABLAEsASwBLAEsASwBLAEsASwBLAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUAANAA0AUABQAFAAUABQAFAAUABQAFAAKwArACsAKwArACsAKwArACsAKwArACsAKwArACsAKwArACsAKwArACsAKwArAB4AHgAeAB4AHgAeAB4AHgArACsAKwArACsAKwArACsABAAEAAQAHgAEAAQABAAEAAQABAAEAAQABAAEAAQABAAEAFAAUABQAFAABABQAFAAUABQAAQABAAEAFAAUAAEAAQABAArACsAKwArACsAKwAEAAQABAAEAAQABAAEAAQABAAEAAQABAAEAAQABAAEAAQABAAEAAQABAAEAAQABAAEAAQAKwAEAAQABAAEAAQAHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgArACsAUABQAFAAUABQAFAAKwArAFAAUABQAFAAUABQAFAAUAArAFAAKwBQACsAUAArAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AKwArAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeACsAHgAeAB4AHgAeAB4AHgAeAFAAHgAeAB4AUABQAFAAKwAeAB4AHgAeAB4AHgAeAB4AHgAeAFAAUABQAFAAKwArAB4AHgAeAB4AHgAeACsAHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgArACsAUABQAFAAKwAeAB4AHgAeAB4AHgAeAA4AHgArAA0ADQANAA0ADQANAA0ACQANAA0ADQAIAAQACwAEAAQADQAJAA0ADQAMAB0AHQAeABcAFwAWABcAFwAXABYAFwAdAB0AHgAeABQAFAAUAA0AAQABAAQABAAEAAQABAAJABoAGgAaABoAGgAaABoAGgAeABcAFwAdABUAFQAeAB4AHgAeAB4AHgAYABYAEQAVABUAFQAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgANAB4ADQANAA0ADQAeAA0ADQANAAcAHgAeAB4AHgArAAQABAAEAAQABAAEAAQABAAEAAQAUABQACsAKwBPAFAAUABQAFAAUAAeAB4AHgAWABEATwBQAE8ATwBPAE8AUABQAFAAUABQAB4AHgAeABYAEQArAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAKwArACsAGwAbABsAGwAbABsAGwAaABsAGwAbABsAGwAbABsAGwAbABsAGwAbABsAGwAaABsAGwAbABsAGgAbABsAGgAbABsAGwAbABsAGwAbABsAGwAbABsAGwAbABsAGwAbABsABAAEAAQABAAEAAQABAAEAAQABAAEAAQABAAEAAQABAAEACsAKwArACsAKwArACsAKwArACsAKwArACsAKwArAB4AHgBQABoAHgAdAB4AUAAeABoAHgAeAB4AHgAeAB4AHgAeAB4ATwAeAFAAGwAeAB4AUABQAFAAUABQAB4AHgAeAB0AHQAeAFAAHgBQAB4AUAAeAFAATwBQAFAAHgAeAB4AHgAeAB4AHgBQAFAAUABQAFAAHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgBQAB4AUABQAFAAUABPAE8AUABQAFAAUABQAE8AUABQAE8AUABPAE8ATwBPAE8ATwBPAE8ATwBPAE8ATwBQAFAAUABQAE8ATwBPAE8ATwBPAE8ATwBPAE8AUABQAFAAUABQAFAAUABQAFAAHgAeAFAAUABQAFAATwAeAB4AKwArACsAKwAdAB0AHQAdAB0AHQAdAB0AHQAdAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAdAB4AHQAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHQAeAB0AHQAeAB4AHgAdAB0AHgAeAB0AHgAeAB4AHQAeAB0AGwAbAB4AHQAeAB4AHgAeAB0AHgAeAB0AHQAdAB0AHgAeAB0AHgAdAB4AHQAdAB0AHQAdAB0AHgAdAB4AHgAeAB4AHgAdAB0AHQAdAB4AHgAeAB4AHQAdAB4AHgAeAB4AHgAeAB4AHgAeAB4AHQAeAB4AHgAdAB4AHgAeAB4AHgAdAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHQAdAB4AHgAdAB0AHQAdAB4AHgAdAB0AHgAeAB0AHQAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAdAB0AHgAeAB0AHQAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB0AHgAeAB4AHQAeAB4AHgAeAB4AHgAeAB0AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAdAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeABQAHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAWABEAFgARAB4AHgAeAB4AHgAeAB0AHgAeAB4AHgAeAB4AHgAlACUAHgAeAB4AHgAeAB4AHgAeAB4AFgARAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeACUAJQAlACUAHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AKwArACsAKwArACsAKwArACsAKwArACsAKwArACsAKwArACsAKwArACsAKwArACsAKwBPAE8ATwBPAE8ATwBPAE8ATwBPAE8ATwBPAE8ATwBPAE8ATwBPAE8ATwBPAE8ATwBPAE8ATwBPAE8ATwBPAE8AHQAdAB0AHQAdAB0AHQAdAB0AHQAdAB0AHQAdAB0AHQAdAB0AHQAdAB0AHQAdAB0AHQAdAB0AHQAdAB0AHQAdAB0AHQBPAE8ATwBPAE8ATwBPAE8ATwBPAE8ATwBPAE8ATwBPAE8ATwBPAE8ATwBQAB0AHQAdAB0AHQAdAB0AHQAdAB0AHQAdAB4AHgAeAB4AHQAdAB0AHQAdAB0AHQAdAB0AHQAdAB0AHQAdAB0AHQAdAB0AHQAdAB0AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB0AHQAdAB0AHQAdAB0AHQAdAB0AHQAdAB0AHQAdAB0AHgAeAB0AHQAdAB0AHgAeAB4AHgAeAB4AHgAeAB4AHgAdAB0AHgAdAB0AHQAdAB0AHQAdAB4AHgAeAB4AHgAeAB4AHgAdAB0AHgAeAB0AHQAeAB4AHgAeAB0AHQAeAB4AHgAeAB0AHQAdAB4AHgAdAB4AHgAdAB0AHQAdAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHQAdAB0AHQAeAB4AHgAeAB4AHgAeAB4AHgAdAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AJQAlACUAJQAeAB0AHQAeAB4AHQAeAB4AHgAeAB0AHQAeAB4AHgAeACUAJQAdAB0AJQAeACUAJQAlACAAJQAlAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AJQAlACUAHgAeAB4AHgAdAB4AHQAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHQAdAB4AHQAdAB0AHgAdACUAHQAdAB4AHQAdAB4AHQAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAlAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB0AHQAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AJQAlACUAJQAlACUAJQAlACUAJQAlACUAHQAdAB0AHQAlAB4AJQAlACUAHQAlACUAHQAdAB0AJQAlAB0AHQAlAB0AHQAlACUAJQAeAB0AHgAeAB4AHgAdAB0AJQAdAB0AHQAdAB0AHQAlACUAJQAlACUAHQAlACUAIAAlAB0AHQAlACUAJQAlACUAJQAlACUAHgAeAB4AJQAlACAAIAAgACAAHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAdAB4AHgAeABcAFwAXABcAFwAXAB4AEwATACUAHgAeAB4AFgARABYAEQAWABEAFgARABYAEQAWABEAFgARAE8ATwBPAE8ATwBPAE8ATwBPAE8ATwBPAE8ATwBPAE8ATwBPAE8ATwBPAE8AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAWABEAHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AFgARABYAEQAWABEAFgARABYAEQAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeABYAEQAWABEAFgARABYAEQAWABEAFgARABYAEQAWABEAFgARABYAEQAWABEAHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AFgARABYAEQAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeABYAEQAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHQAdAB0AHQAdAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AKwArAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AKwArACsAHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AKwAeAB4AHgAeAB4AHgAeAB4AHgArACsAKwArACsAKwArACsAKwArACsAKwArAB4AHgAeAB4AKwArACsAKwArACsAKwArACsAKwArACsAKwArACsAKwAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAEAAQABAAeAB4AKwArACsAKwArABMADQANAA0AUAATAA0AUABQAFAAUABQAFAAUABQACsAKwArACsAKwArACsAUAANACsAKwArACsAKwArACsAKwArACsAKwArACsAKwAEAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUAArACsAKwArACsAKwArACsAKwBQAFAAUABQAFAAUABQACsAUABQAFAAUABQAFAAUAArAFAAUABQAFAAUABQAFAAKwBQAFAAUABQAFAAUABQACsAFwAXABcAFwAXABcAFwAXABcAFwAXABcAFwAXAA0ADQANAA0ADQANAA0ADQAeAA0AFgANAB4AHgAXABcAHgAeABcAFwAWABEAFgARABYAEQAWABEADQANAA0ADQATAFAADQANAB4ADQANAB4AHgAeAB4AHgAMAAwADQANAA0AHgANAA0AFgANAA0ADQANAA0ADQANACsAKwArACsAKwArACsAKwArACsAKwArACsAKwArACsAKwArACsAKwArACsAJQAlACUAJQAlACUAJQAlACUAJQAlACUAJQAlACUAJQAlACUAJQAlACUAJQAlACUAJQAlACsAJQAlACUAJQAlACUAJQAlACUAJQAlACUAJQAlACUAJQAlACUAJQAlACUAJQAlACUAJQAlACUAJQAlACUAJQAlACUAKwArACsAKwArACsAKwArACsAKwArACsAJQAlACUAJQAlACUAJQAlACUAJQAlACUAJQAlACUAJQAlACUAJQAlACUAJQArACsAKwArACsAKwArACsAKwArACsAKwArACsAKwArACsAKwAlACUAJQAlACUAJQAlACUAJQAlACUAJQArACsAKwArAA0AEQARACUAJQBHAFcAVwAWABEAFgARABYAEQAWABEAFgARACUAJQAWABEAFgARABYAEQAWABEAFQAWABEAEQAlAFcAVwBXAFcAVwBXAFcAVwBXAAQABAAEAAQABAAEACUAVwBXAFcAVwA2ACUAJQBXAFcAVwBHAEcAJQAlACUAKwBRAFcAUQBXAFEAVwBRAFcAUQBXAFcAVwBXAFcAVwBXAFcAVwBXAFcAVwBXAFcAVwBXAFcAVwBXAFcAVwBXAFcAVwBXAFEAVwBXAFcAVwBXAFcAVwBXAFcAVwBXAFcAVwBXAFcAVwBXAFcAVwBXAFcAVwBXAFcAVwBXAFcAVwBXAFcAVwBRAFcAUQBXAFEAVwBXAFcAVwBXAFcAUQBXAFcAVwBXAFcAVwBRAFEAKwArAAQABAAVABUARwBHAFcAFQBRAFcAUQBXAFEAVwBRAFcAUQBXAFcAVwBXAFcAVwBXAFcAVwBXAFcAVwBXAFcAVwBXAFcAVwBXAFcAVwBXAFcAVwBXAFEAVwBRAFcAUQBXAFcAVwBXAFcAVwBRAFcAVwBXAFcAVwBXAFEAUQBXAFcAVwBXABUAUQBHAEcAVwArACsAKwArACsAVwBXAFcAVwBXAFcAVwBXAFcAVwBXAFcAVwBXAFcAVwBXAFcAVwBXAFcAVwBXAFcAVwBXAFcAVwBXAFcAKwArAFcAVwBXAFcAVwBXAFcAVwBXAFcAVwBXAFcAVwBXAFcAVwBXAFcAVwBXAFcAVwBXAFcAVwBXAFcAVwBXAFcAVwBXAFcAVwBXAFcAVwArACUAJQBXAFcAVwBXACUAJQAlACUAJQAlACUAJQAlACUAVwBXAFcAVwBXAFcAVwBXAFcAVwBXAFcAVwBXAFcAVwBXAFcAVwBXAFcAVwBXAFcAVwBXAFcAKwArACsAKwArACUAJQAlACUAKwArACsAKwArACsAKwArACsAKwArACsAUQBRAFEAUQBRAFEAUQBRAFEAUQBRAFEAUQBRAFEAUQAlACUAJQAlACUAJQAlACUAJQAlACUAJQAlACUAJQAlACUAJQAlACUAJQAlACUAJQAlACUAJQAlACUAJQAlACsAVwBXAFcAVwBXAFcAVwBXAFcAVwAlACUAJQAlACUAJQAlACUAJQAlACUAJQAlACUAJQAlACUAJQAlACUAJQAlAE8ATwBPAE8ATwBPAE8ATwAlAFcAVwBXAFcAVwBXAFcAVwBXAFcAVwBXAFcAVwBXACUAJQAlACUAJQAlACUAJQAlACUAJQAlACUAJQAlACUAJQBXAFcAVwBXAFcAVwBXAFcAVwBXAFcAVwBXAFcAVwBXAFcAVwBXAFcAVwBXAFcAVwBXACUAJQAlACUAJQAlACUAJQAlACUAVwBXAFcAVwBXAFcAVwBXAFcAVwBXACUAJQAlACUAJQAlACUAJQAlACUAJQAlACUAJQAlACUAJQAlACUAJQAlAFcAVwBXAFcAVwBXAFcAVwBXAFcAVwBXAFcAVwBXAFcAVwBXAFcAVwBXAEcAVwBXAFcAVwBXAFcAVwBXAFcAVwBXAFcAVwBXAFcAKwArACsAJQAlACUAJQAlACUAJQAlACUAJQAlACUAJQAlACUAJQAlACUAJQArACsAKwArACsAKwArACsAKwBQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAADQATAA0AUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABLAEsASwBLAEsASwBLAEsASwBLAFAAUAArACsAKwArACsAKwArACsAKwArACsAKwArACsAKwArACsAKwArACsAHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAFAABAAEAAQABAAeAAQABAAEAAQABAAEAAQABAAEAAQAHgBQAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AUABQAAQABABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAAQABAAeAA0ADQANAA0ADQArACsAKwArACsAKwArACsAHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAFAAUABQAFAAUABQAFAAUABQAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AUAAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgBQAB4AHgAeAB4AHgAeAFAAHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgArAB4AHgAeAB4AHgAeAB4AHgArACsAKwArACsAKwArACsAKwArACsAKwArACsAKwArACsAKwArACsAKwArACsAUABQAFAAUABQAFAAUABQAFAAUABQAAQAUABQAFAABABQAFAAUABQAAQAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAAQABAAEAAQABAAeAB4AHgAeACsAKwArACsAUABQAFAAUABQAFAAHgAeABoAHgArACsAKwArACsAKwBQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAADgAOABMAEwArACsAKwArACsAKwArACsABAAEAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAAQABAAEAAQABAAEACsAKwArACsAKwArACsAKwANAA0ASwBLAEsASwBLAEsASwBLAEsASwArACsAKwArACsAKwAEAAQABAAEAAQABAAEAAQABAAEAAQABAAEAAQABAAEAAQABABQAFAAUABQAFAAUAAeAB4AHgBQAA4AUAArACsAUABQAFAAUABQAFAABAAEAAQABAAEAAQABAAEAA0ADQBQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAAQABAAEAAQABAAEAAQABAAEAAQABAAEAAQAKwArACsAKwArACsAKwArACsAKwArAB4AWABYAFgAWABYAFgAWABYAFgAWABYAFgAWABYAFgAWABYAFgAWABYAFgAWABYAFgAWABYAFgAWABYACsAKwArAAQAHgAeAB4AHgAeAB4ADQANAA0AHgAeAB4AHgArAFAASwBLAEsASwBLAEsASwBLAEsASwArACsAKwArAB4AHgBcAFwAXABcAFwAKgBcAFwAXABcAFwAXABcAFwAXABcAEsASwBLAEsASwBLAEsASwBLAEsAXABcAFwAXABcACsAUABQAFAAUABQAFAAUABQAFAABAAEAAQABAAEAAQABAAEAAQABAAEAAQABAAEACsAKwArACsAKwArACsAKwArAFAAUABQAAQAUABQAFAAUABQAFAAUABQAAQABAArACsASwBLAEsASwBLAEsASwBLAEsASwArACsAHgANAA0ADQBcAFwAXABcAFwAXABcAFwAXABcAFwAXABcAFwAXABcAFwAXABcAFwAXABcAFwAKgAqACoAXAAqACoAKgBcAFwAXABcAFwAXABcAFwAXABcAFwAXABcAFwAXABcAFwAXAAqAFwAKgAqACoAXABcACoAKgBcAFwAXABcAFwAKgAqAFwAKgBcACsAKwArACsAKwArACsAKwArACsAKwArACsAKwArACsAKwArACsAKwArACsAKwArAFwAXABcACoAKgBQAFAAUABQAFAAUABQAFAAUABQAFAABAAEAAQABAAEAA0ADQBQAFAAUAAEAAQAKwArACsAKwArACsAKwArACsAKwBQAFAAUABQAFAAUAArACsAUABQAFAAUABQAFAAKwArAFAAUABQAFAAUABQACsAKwArACsAKwArACsAKwArAFAAUABQAFAAUABQAFAAKwBQAFAAUABQAFAAUABQACsAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUAAEAAQABAAEAAQABAAEAAQADQAEAAQAKwArAEsASwBLAEsASwBLAEsASwBLAEsAKwArACsAKwArACsAVABVAFUAVQBVAFUAVQBVAFUAVQBVAFUAVQBVAFUAVQBVAFUAVQBVAFUAVQBVAFUAVQBVAFUAVQBUAFUAVQBVAFUAVQBVAFUAVQBVAFUAVQBVAFUAVQBVAFUAVQBVAFUAVQBVAFUAVQBVAFUAVQBVACsAKwArACsAKwArACsAKwArACsAKwArAFkAWQBZAFkAWQBZAFkAWQBZAFkAWQBZAFkAWQBZAFkAWQBZAFkAKwArACsAKwBaAFoAWgBaAFoAWgBaAFoAWgBaAFoAWgBaAFoAWgBaAFoAWgBaAFoAWgBaAFoAWgBaAFoAWgBaAFoAKwArACsAKwAGAAYABgAGAAYABgAGAAYABgAGAAYABgAGAAYABgAGAAYABgAGAAYABgAGAAYABgAGAAYABgAGAAYABgAGAAYAVwBXAFcAVwBXAFcAVwBXAFcAVwBXAFcAVwBXACUAJQBXAFcAVwBXAFcAVwBXAFcAVwBXAFcAVwBXAFcAVwBXAFcAVwBXAFcAVwBXAFcAVwBXAFcAJQAlACUAJQAlACUAUABQAFAAUABQAFAAUAArACsAKwArACsAKwArACsAKwArACsAKwBQAFAAUABQAFAAKwArACsAKwArAFYABABWAFYAVgBWAFYAVgBWAFYAVgBWAB4AVgBWAFYAVgBWAFYAVgBWAFYAVgBWAFYAVgArAFYAVgBWAFYAVgArAFYAKwBWAFYAKwBWAFYAKwBWAFYAVgBWAFYAVgBWAFYAVgBWAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AKwArACsAKwArACsAKwArACsAKwArACsAKwArACsAKwArAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAEQAWAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAKwArAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUAArACsAKwArACsAKwArACsAKwArACsAKwArACsAKwArACsAKwArACsAKwArACsAKwBQAFAAUABQAFAAUABQAFAAUABQAFAAUAAaAB4AKwArAAQABAAEAAQABAAEAAQABAAEAAQABAAEAAQABAAEAAQAGAARABEAGAAYABMAEwAWABEAFAArACsAKwArACsAKwAEAAQABAAEAAQABAAEAAQABAAEAAQABAAEAAQABAAEACUAJQAlACUAJQAWABEAFgARABYAEQAWABEAFgARABYAEQAlACUAFgARACUAJQAlACUAJQAlACUAEQAlABEAKwAVABUAEwATACUAFgARABYAEQAWABEAJQAlACUAJQAlACUAJQAlACsAJQAbABoAJQArACsAKwArAFAAUABQAFAAUAArAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAKwArAAcAKwATACUAJQAbABoAJQAlABYAEQAlACUAEQAlABEAJQBXAFcAVwBXAFcAVwBXAFcAVwBXABUAFQAlACUAJQATACUAVwBXAFcAVwBXAFcAVwBXAFcAVwBXAFcAVwBXAFcAVwBXAFcAVwBXAFcAVwBXAFcAVwBXABYAJQARACUAJQAlAFcAVwBXAFcAVwBXAFcAVwBXAFcAVwBXAFcAVwBXAFcAVwBXAFcAVwBXAFcAVwBXAFcAVwAWACUAEQAlABYAEQARABYAEQARABUAVwBRAFEAUQBRAFEAUQBRAFEAUQBRAFcAVwBXAFcAVwBXAFcAVwBXAFcAVwBXAFcAVwBXAFcAVwBXAFcAVwBXAFcAVwBXAFcAVwBXAFcAVwBXAFcAVwBXAEcARwArACsAVwBXAFcAVwBXAFcAKwArAFcAVwBXAFcAVwBXACsAKwBXAFcAVwBXAFcAVwArACsAVwBXAFcAKwArACsAGgAbACUAJQAlABsAGwArAB4AHgAeAB4AHgAeAB4AKwArACsAKwArACsAKwArACsAKwAEAAQABAAQAB0AKwArAFAAUABQAFAAUABQAFAAUABQAFAAUABQACsAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUAArAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAKwBQAFAAKwBQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUAArACsAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQACsAKwBQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUAArACsAKwArACsADQANAA0AKwArACsAKwBQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQACsAKwArAB4AHgAeAB4AHgAeAB4AHgAeAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgBQAFAAHgAeAB4AKwAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgArACsAKwArAB4AKwArACsAKwArACsAKwArACsAKwArACsAKwArACsAKwArACsAKwArACsAKwArACsAKwArACsAKwArACsAKwAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4ABAArACsAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQACsAKwArACsAKwArACsAKwArACsAKwArACsAKwArAAQAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAKwArACsAKwArACsAKwArACsAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUAArACsAKwArACsAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUAAEAAQABAAEAAQAKwArACsAKwArAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQACsADQBQAFAAUABQACsAKwArACsAUABQAFAAUABQAFAAUABQAA0AUABQAFAAUABQACsAKwArACsAKwArACsAKwArACsAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAKwArAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUAArACsAKwArAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAKwArACsAKwArACsAKwArAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAKwArACsAKwArACsAKwArACsAKwArAB4AKwArACsAKwArACsAKwArACsAKwArACsAKwArACsAKwBQAFAAUABQAFAAUAArACsAUAArAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQACsAUABQACsAKwArAFAAKwArAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUAArAA0AUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAB4AHgBQAFAAUABQAFAAUABQACsAKwArACsAKwArACsAUABQAFAAUABQAFAAUABQAFAAKwArACsAKwArACsAKwArACsAKwArACsAKwArACsAKwBQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQACsAUABQACsAKwArACsAKwBQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAKwArACsADQBQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAKwArACsAKwArAB4AUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAKwArACsAKwBQAFAAUABQAFAABAAEAAQAKwAEAAQAKwArACsAKwArAAQABAAEAAQAUABQAFAAUAArAFAAUABQACsAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQACsAKwArACsABAAEAAQAKwArACsAKwAEAFAAUABQAFAAUABQAFAAUAArACsAKwArACsAKwArACsADQANAA0ADQANAA0ADQANAB4AKwArACsAKwArACsAKwBQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAB4AUABQAFAAUABQAFAAUABQAB4AUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAABAAEACsAKwArACsAUABQAFAAUABQAA0ADQANAA0ADQANABQAKwArACsAKwArACsAKwArACsAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUAArACsAKwANAA0ADQANAA0ADQANAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQACsAKwArACsAKwArACsAHgAeAB4AHgArACsAKwArACsAKwArACsAKwArACsAKwBQAFAAUABQAFAAUABQACsAKwArACsAKwArACsAKwArACsAKwArACsAKwArACsAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUAArACsAKwArACsAKwArACsAKwArACsAKwArAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAKwArACsAKwArACsAKwBQAFAAUABQAFAAUAAEAAQABAAEAAQABAAEAA0ADQAeAB4AHgAeAB4AKwArACsAKwBQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAEsASwBLAEsASwBLAEsASwBLAEsAKwArACsAKwArACsAKwArACsAKwArACsAKwArACsABABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAAQABAAEAAQABAAEAAQABAAEAAQABAAeAB4AHgANAA0ADQANACsAKwArACsAKwArACsAKwArACsAKwArACsAKwBQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAKwArACsAKwArACsAKwBLAEsASwBLAEsASwBLAEsASwBLACsAKwArACsAKwArAFAAUABQAFAAUABQAFAABAAEAAQABAAEAAQABAAEAAQABAAEAAQABAAEACsASwBLAEsASwBLAEsASwBLAEsASwANAA0ADQANACsAKwArACsAKwArACsAKwArACsAKwArAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAABAAeAA4AUAArACsAKwArACsAKwArACsAKwAEAFAAUABQAFAADQANAB4ADQAeAAQABAAEAB4AKwArAEsASwBLAEsASwBLAEsASwBLAEsAUAAOAFAADQANAA0AKwBQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAKwArACsAKwArACsAKwArACsAKwArAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQACsAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUAAEAAQABAAEAAQABAAEAAQABAAEAAQABAANAA0AHgANAA0AHgAEACsAUABQAFAAUABQAFAAUAArAFAAKwBQAFAAUABQACsAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAKwBQAFAAUABQAFAAUABQAFAAUABQAA0AKwArACsAKwArACsAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUAAEAAQABAAEAAQABAAEAAQABAAEAAQAKwArACsAKwArAEsASwBLAEsASwBLAEsASwBLAEsAKwArACsAKwArACsABAAEAAQABAArAFAAUABQAFAAUABQAFAAUAArACsAUABQACsAKwBQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAAQABAAEAAQABAArACsABAAEACsAKwAEAAQABAArACsAUAArACsAKwArACsAKwAEACsAKwArACsAKwBQAFAAUABQAFAABAAEACsAKwAEAAQABAAEAAQABAAEACsAKwArAAQABAAEAAQABAArACsAKwArACsAKwArACsAKwArACsABAAEAAQABAAEAAQABABQAFAAUABQAA0ADQANAA0AHgBLAEsASwBLAEsASwBLAEsASwBLACsADQArAB4AKwArAAQABAAEAAQAUABQAB4AUAArACsAKwArACsAKwArACsASwBLAEsASwBLAEsASwBLAEsASwArACsAKwArACsAKwBQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUAAEAAQABAAEAAQABAAEACsAKwAEAAQABAAEAAQABAAEAAQABAAOAA0ADQATABMAHgAeAB4ADQANAA0ADQANAA0ADQANAA0ADQANAA0ADQANAA0AUABQAFAAUAAEAAQAKwArAAQADQANAB4AUAArACsAKwArACsAKwArACsAKwArACsASwBLAEsASwBLAEsASwBLAEsASwArACsAKwArACsAKwAOAA4ADgAOAA4ADgAOAA4ADgAOAA4ADgAOACsAKwArACsAKwArACsAKwArACsAKwArACsAKwArACsAKwArACsASwBLAEsASwBLAEsASwBLAEsASwArACsAKwArACsAKwArACsAKwArACsAKwArACsAKwArACsAKwArACsAKwArAFwAXABcAFwAXABcAFwAXABcAFwAXABcAFwAXABcAFwAXABcAFwAXABcAFwAXABcAFwAXAArACsAKwAqACoAKgAqACoAKgAqACoAKgAqACoAKgAqACoAKgArACsAKwArAEsASwBLAEsASwBLAEsASwBLAEsAXABcAA0ADQANACoASwBLAEsASwBLAEsASwBLAEsASwBQAFAAUABQAFAAUABQAFAAUAArACsAKwArACsAKwArACsAKwArACsAKwBQAFAABAAEAAQABAAEAAQABAAEAAQABABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUAAEAAQABAAEAAQABAAEAFAABAAEAAQABAAOAB4ADQANAA0ADQAOAB4ABAArACsAKwArACsAKwArACsAUAAEAAQABAAEAAQABAAEAAQABAAEAAQAUABQAFAAUAArACsAUABQAFAAUAAEAAQABAAEAAQABAAEAAQABAAEAAQABAAEAAQABAAEAA0ADQANACsADgAOAA4ADQANACsAKwArACsAKwArACsAKwArACsAKwArACsAKwArACsAKwArACsAKwArACsAKwArACsAKwArACsAKwBQAFAAUABQAFAAUABQAFAAUAArAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAABAAEAAQABAAEAAQABAAEACsABAAEAAQABAAEAAQABAAEAFAADQANAA0ADQANACsAKwArACsAKwArACsAKwArACsASwBLAEsASwBLAEsASwBLAEsASwBQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUAArACsAKwAOABMAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAKwArAAQABAAEAAQABAAEAAQABAAEAAQABAAEAAQABAArAAQABAAEAAQABAAEAAQABAAEAAQABAAEAAQABAArACsAKwArACsAKwArACsAKwBQAFAAUABQAFAAUABQACsAUABQACsAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUAAEAAQABAAEAAQABAArACsAKwAEACsABAAEACsABAAEAAQABAAEAAQABABQAAQAKwArACsAKwArACsAKwArAEsASwBLAEsASwBLAEsASwBLAEsAKwArACsAKwArACsAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQACsAKwArACsAKwArAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQACsADQANAA0ADQANACsAKwArACsAKwArACsAKwArACsAKwBQAFAAUABQACsAKwArACsAKwArACsAKwArACsAKwArACsAKwArACsAKwArACsAKwArACsAKwArACsAKwArACsAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAASABIAEgAQwBDAEMAUABQAFAAUABDAFAAUABQAEgAQwBIAEMAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAASABDAEMAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAKwArACsAKwArACsAKwArACsAKwArACsAKwArACsAKwArAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABIAEMAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUAArACsAKwArACsAKwArACsAKwArACsAKwArACsAKwArACsAKwArACsAKwArACsAKwArAEsASwBLAEsASwBLAEsASwBLAEsAKwArACsAKwANAA0AKwArACsAKwArACsAKwArACsAKwArACsAKwArACsAKwBQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAKwArAAQABAAEAAQABAANACsAKwArACsAKwArACsAKwArACsAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUAAEAAQABAAEAAQABAAEAA0ADQANAB4AHgAeAB4AHgAeAFAAUABQAFAADQAeACsAKwArACsAKwArACsAKwArACsASwBLAEsASwBLAEsASwBLAEsASwArAFAAUABQAFAAUABQAFAAKwBQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUAArACsAKwArACsAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUAArACsAKwArACsAKwArACsAKwArACsAKwArACsAKwArAFAAUABQAFAAUAArACsAKwArACsAKwArACsAKwArACsAUAAEAAQABAAEAAQABAAEAAQABAAEAAQABAAEAAQABAAEAAQABAAEAAQABAAEAAQABAAEAAQABAAEAAQABAAEAAQABAAEACsAKwArACsAKwArACsAKwArACsAKwArACsAKwArACsABAAEAAQABABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAEcARwArACsAKwArACsAKwArACsAKwArACsAKwArACsAKwArACsAKwArACsAKwArACsAKwArACsAKwArACsAKwBXAFcAVwBXAFcAVwBXAFcAVwBXAFcAVwBXACsAKwArACsAKwArACsAKwArACsAKwArACsAKwArACsAKwArACsAVwBXAFcAVwBXAFcAVwBXAFcAVwBXAFcAVwBXAFcAVwBXAFcAVwArACsAKwArACsAKwArACsAKwArACsAKwArAFcAVwBXAFcAVwBXAFcAVwBXAFcAVwBXAFcAVwBXAFcAVwBXAFcAVwBXAFcAVwBXAFcAVwBXAFcAKwArACsAKwBQAFAAUABQAFAAUABQAFAAUABQAFAAKwArACsAKwArAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAKwArACsAKwArACsAKwBQAFAAUABQAFAAUABQAFAAUABQACsAKwAeAAQABAANAAQABAAEAAQAKwArACsAKwArACsAKwArACsAKwArACsAKwArACsAKwArACsAKwArACsAKwArACsAKwArACsAKwAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeACsAKwArACsAKwArACsAKwArACsAHgAeAB4AHgAeAB4AHgArACsAHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4ABAAEAAQABAAEAB4AHgAeAAQABAAEAAQABAAEAAQABAAEAAQABAAEAAQABAAEAAQABAAEAAQABAAEAAQAHgAeAAQABAAEAAQABAAEAAQAHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAEAAQABAAEAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AKwArACsAKwArACsAKwArACsAKwArACsAKwArACsAKwArACsAKwArACsAKwArAB4AHgAEAAQABAAeACsAKwArACsAKwArACsAKwArACsAKwArACsAKwArACsAKwArACsAKwArACsAKwArACsAKwAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AKwArACsAKwArACsAKwArACsAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAKwArACsAKwArACsAKwArACsAKwArACsAKwArAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeACsAHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgArAFAAUAArACsAUAArACsAUABQACsAKwBQAFAAUABQACsAHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AKwBQACsAUABQAFAAUABQAFAAUAArAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgArAFAAUABQAFAAKwArAFAAUABQAFAAUABQAFAAUAArAFAAUABQAFAAUABQAFAAKwAeAB4AUABQAFAAUABQACsAUAArACsAKwBQAFAAUABQAFAAUABQACsAHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgArACsAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUAAeAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAFAAUABQAFAAUABQAFAAUABQAFAAUAAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAHgAeAB4AHgAeAB4AHgAeAB4AKwArAEsASwBLAEsASwBLAEsASwBLAEsASwBLAEsASwBLAEsASwBLAEsASwBLAEsASwBLAEsASwBLAEsASwBLAEsASwBLAEsABAAEAAQABAAEAAQABAAEAAQABAAEAAQABAAEAAQABAAEAAQABAAEAAQABAAEAB4AHgAeAB4ABAAEAAQABAAEAAQABAAEAAQABAAEAAQABAAEAB4AHgAeAB4AHgAeAB4AHgAEAB4AHgAeAB4AHgAeAB4AHgAeAB4ABAAeAB4ADQANAA0ADQAeACsAKwArACsAKwArACsAKwArACsAKwArACsAKwArAAQABAAEAAQABAArAAQABAAEAAQABAAEAAQABAAEAAQABAAEAAQABAAEACsAKwArACsAKwArACsAKwArACsAKwArACsAKwArACsABAAEAAQABAAEAAQABAArAAQABAAEAAQABAAEAAQABAAEAAQABAAEAAQABAAEAAQABAArACsABAAEAAQABAAEAAQABAArAAQABAArAAQABAAEAAQABAArACsAKwArACsAKwArACsAKwArACsAKwArACsAKwArACsAKwArACsAKwBQAFAAUABQAFAAKwArAFAAUABQAFAAUABQAFAAUABQAAQABAAEAAQABAAEAAQAKwArACsAKwArACsAKwArACsAHgAeAB4AHgAEAAQABAAEAAQABAAEACsAKwArACsAKwBLAEsASwBLAEsASwBLAEsASwBLACsAKwArACsAFgAWAFAAUABQAFAAKwBQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUAArAFAAUAArAFAAKwArAFAAKwBQAFAAUABQAFAAUABQAFAAUABQACsAUABQAFAAUAArAFAAKwBQACsAKwArACsAKwArAFAAKwArACsAKwBQACsAUAArAFAAKwBQAFAAUAArAFAAUAArAFAAKwArAFAAKwBQACsAUAArAFAAKwBQACsAUABQACsAUAArACsAUABQAFAAUAArAFAAUABQAFAAUABQAFAAKwBQAFAAUABQACsAUABQAFAAUAArAFAAKwBQAFAAUABQAFAAUABQAFAAUABQACsAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQACsAKwArACsAKwBQAFAAUAArAFAAUABQAFAAUAArAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUABQAFAAUAArACsAKwArACsAKwArACsAKwArACsAKwArACsAKwArAB4AHgArACsAKwArACsAKwArACsAKwArACsAKwArACsATwBPAE8ATwBPAE8ATwBPAE8ATwBPAE8ATwAlACUAJQAdAB0AHQAdAB0AHQAdAB0AHQAdAB0AHQAdAB0AHQAdAB0AHQAeACUAHQAdAB0AHQAdAB0AHQAdAB0AHQAdAB0AHQAdAB0AHQAdAB0AHgAeACUAJQAlACUAHQAdAB0AHQAdAB0AHQAdAB0AHQAdAB0AHQAdAB0AHQAdACUAJQAlACUAJQAlACUAJQAlACUAJQAlACUAJQAlACUAJQAlACUAJQAlACkAKQApACkAKQApACkAKQApACkAKQApACkAKQApACkAKQApACkAKQApACkAKQApACkAKQAlACUAJQAlACUAIAAlACUAJQAlACUAJQAlACUAJQAlACUAJQAlACUAJQAlACUAJQAlACUAJQAlAB4AHgAlACUAJQAlACUAJQAlACUAJQAlACUAJQAlACUAJQAlACUAJQAlACUAJQAlACUAHgAeACUAJQAlACUAJQAeACUAJQAlACUAJQAgACAAIAAlACUAIAAlACUAIAAgACAAJQAlACUAJQAlACUAJQAlACUAJQAlACUAJQAlACUAJQAlACUAJQAlACUAJQAlACUAJQAlACUAJQAlACUAIQAhACEAIQAhACUAJQAgACAAJQAlACAAIAAgACAAIAAgACAAIAAgACAAIAAlACUAJQAlACUAJQAlACUAJQAlACUAJQAlACUAJQAlACUAIAAgACAAIAAlACUAJQAlACAAJQAgACAAIAAgACAAIAAgACAAIAAlACUAJQAgACUAJQAlACUAIAAgACAAJQAgACAAIAAlACUAJQAlACUAJQAlACUAJQAlACUAJQAlACUAJQAlACUAJQAlACUAJQAlACUAJQAeACUAHgAlAB4AJQAlACUAJQAlACAAJQAlACUAJQAeACUAHgAeACUAJQAlACUAJQAlACUAJQAlACUAJQAlACUAHgAeAB4AHgAeAB4AHgAlACUAJQAlACUAJQAlACUAJQAlACUAJQAlACUAJQAlAB4AHgAeAB4AHgAeAB4AHgAeAB4AJQAlACUAJQAlACUAJQAlACUAJQAlACUAJQAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeACUAJQAlACUAJQAlACUAJQAlACUAJQAlACUAJQAlACUAJQAlACUAJQAlACUAIAAgACUAJQAlACUAIAAlACUAJQAlACUAJQAlACUAJQAlACUAJQAlACUAJQAlACUAIAAlACUAJQAlACAAIAAlACUAJQAlACUAJQAlACUAJQAlACUAJQAlACUAJQAlACUAJQAlACUAJQAeAB4AHgAeAB4AHgAeAB4AJQAlACUAJQAlACUAJQAlACUAJQAlACUAJQAlACUAJQAlACUAJQAlAB4AHgAeAB4AHgAeACUAJQAlACUAJQAlACUAIAAgACAAJQAlACUAIAAgACAAIAAgAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AFwAXABcAFQAVABUAHgAeAB4AHgAlACUAJQAgACUAJQAlACUAJQAlACUAJQAlACUAJQAlACUAJQAlACUAIAAgACAAJQAlACUAJQAlACUAJQAlACUAIAAlACUAJQAlACUAJQAlACUAJQAlACUAIAAlACUAJQAlACUAJQAlACUAJQAlACUAJQAlACUAJQAlACUAJQAlAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAlACUAJQAlACUAJQAlACUAJQAlACUAJQAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAlACUAJQAlAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AJQAlACUAJQAlACUAJQAlAB4AHgAeAB4AHgAeAB4AHgAeAB4AJQAlACUAJQAlACUAHgAeAB4AHgAeAB4AHgAeACUAJQAlACUAJQAlACUAJQAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeAB4AHgAeACUAJQAlACUAJQAlACUAJQAlACUAJQAlACAAIAAgACAAIAAlACAAIAAlACUAJQAlACUAJQAgACUAJQAlACUAJQAlACUAJQAlACAAIAAgACAAIAAgACAAIAAgACAAJQAlACUAIAAgACUAJQAlACUAJQAlACUAJQAlACUAJQAlACUAJQAlACUAJQAlACAAIAAgACAAIAAgACAAIAAgACAAIAAgACAAJQAlACUAJQAlACUAJQAlACUAJQAlACUAJQAlACUAJQAlACUAJQAlACUAJQAlACUAJQAlACUAJQAlACUAJQAlACsAKwBXAFcAVwBXAFcAVwBXAFcAVwBXAFcAVwBXAFcAVwBXAFcAVwBXAFcAVwBXAFcAJQAlACUAJQAlACUAJQAlACUAVwBXAFcAVwBXAFcAVwBXAFcAVwBXAFcAVwBXAFcAVwBXAFcAVwBXAFcAJQAlACUAJQAlACUAJQAlACUAJQAlAFcAVwBXAFcAVwBXAFcAVwBXAFcAVwBXAFcAVwBXAFcAVwBXAFcAVwBXAFcAVwBXAFcAVwBXAFcAVwBXACUAJQAlACUAJQAlACUAJQAlACUAJQAlACUAJQBXAFcAVwBXAFcAVwBXAFcAVwBXAFcAVwBXAFcAVwBXAFcAJQAlACUAJQAlACUAJQAlACUAJQAlACUAJQAlACUAJQAlACUAJQAlACUAJQAlACUAJQAlACUAJQAlACUAJQArAAQAKwArACsAKwArACsAKwArACsAKwArACsAKwArACsAKwArACsAKwArACsAKwArACsAKwArACsAKwArACsABAAEAAQABAAEAAQABAAEAAQABAAEAAQABAAEAAQABAArACsAKwArACsAKwArACsAKwArACsAKwArACsAKwArACsAKwArACsA"
    }, function (a, b, c) {
        "use strict";
        function e(a, b) {
            if (!(a instanceof b))throw new TypeError("Cannot call a class as a function")
        }

        var d, f;
        Object.defineProperty(b, "__esModule", {value: !0}), d = c(5), f = function g(a, b, c) {
            e(this, g), this.type = d.PATH.CIRCLE, this.x = a, this.y = b, this.radius = c, isNaN(a) && console.error("Invalid x value given for Circle"), isNaN(b) && console.error("Invalid y value given for Circle"), isNaN(c) && console.error("Invalid radius value given for Circle")
        }, b.default = f
    }, function (a, b, c) {
        "use strict";
        function m(a) {
            return a && a.__esModule ? a : {"default": a}
        }

        function n(a, b) {
            if (!(a instanceof b))throw new TypeError("Cannot call a class as a function")
        }

        var d, e, f, h, i, j, k, l, o, p, q, r;
        Object.defineProperty(b, "__esModule", {value: !0}), d = function () {
            function a(a, b) {
                var h, g, c = [], d = !0, e = !1, f = void 0;
                try {
                    for (g = a[Symbol.iterator](); !(d = (h = g.next()).done) && (c.push(h.value), !b || c.length !== b); d = !0);
                } catch (i) {
                    e = !0, f = i
                } finally {
                    try {
                        !d && g["return"] && g["return"]()
                    } finally {
                        if (e)throw f
                    }
                }
                return c
            }

            return function (b, c) {
                if (Array.isArray(b))return b;
                if (Symbol.iterator in Object(b))return a(b, c);
                throw new TypeError("Invalid attempt to destructure non-iterable instance")
            }
        }(), e = function () {
            function a(a, b) {
                var c, d;
                for (c = 0; c < b.length; c++)d = b[c], d.enumerable = d.enumerable || !1, d.configurable = !0, "value" in d && (d.writable = !0), Object.defineProperty(a, d.key, d)
            }

            return function (b, c, d) {
                return c && a(b.prototype, c), d && a(b, d), b
            }
        }(), f = c(2), c(25), h = c(52), i = c(9), j = m(i), k = c(4), l = c(12), o = function () {
            function a(b, c) {
                n(this, a), this.target = b, this.options = c, b.render(c)
            }

            return e(a, [{
                key: "renderNode", value: function (a) {
                    a.isVisible() && (this.renderNodeBackgroundAndBorders(a), this.renderNodeContent(a))
                }
            }, {
                key: "renderNodeContent", value: function (a) {
                    var b = this, c = function () {
                        var c, d, e, g;
                        a.childNodes.length && a.childNodes.forEach(function (c) {
                            if (c instanceof j.default) {
                                var d = c.parent.style;
                                b.target.renderTextNode(c.bounds, d.color, d.font, d.textDecoration, d.textShadow)
                            } else b.target.drawShape(c, a.style.color)
                        }), a.image && (c = b.options.imageStore.get(a.image), c && (d = f.calculateContentBox(a.bounds, a.style.padding, a.style.border), e = "number" == typeof c.width && c.width > 0 ? c.width : d.width, g = "number" == typeof c.height && c.height > 0 ? c.height : d.height, e > 0 && g > 0 && b.target.clip([f.calculatePaddingBoxPath(a.curvedBounds)], function () {
                            b.target.drawImage(c, new f.Bounds(0, 0, e, g), d)
                        })))
                    }, d = a.getClipPaths();
                    d.length ? this.target.clip(d, c) : c()
                }
            }, {
                key: "renderNodeBackgroundAndBorders", value: function (a) {
                    var f, b = this,
                        c = !a.style.background.backgroundColor.isTransparent() || a.style.background.backgroundImage.length,
                        d = a.style.border.some(function (a) {
                            return a.borderStyle !== l.BORDER_STYLE.NONE && !a.borderColor.isTransparent()
                        }), e = function () {
                            var d = k.calculateBackgroungPaintingArea(a.curvedBounds, a.style.background.backgroundClip);
                            c && b.target.clip([d], function () {
                                a.style.background.backgroundColor.isTransparent() || b.target.fill(a.style.background.backgroundColor), b.renderBackgroundImage(a)
                            }), a.style.border.forEach(function (c, d) {
                                c.borderStyle === l.BORDER_STYLE.NONE || c.borderColor.isTransparent() || b.renderBorder(c, d, a.curvedBounds)
                            })
                        };
                    (c || d) && (f = a.parent ? a.parent.getClipPaths() : [], f.length ? this.target.clip(f, e) : e())
                }
            }, {
                key: "renderBackgroundImage", value: function (a) {
                    var b = this;
                    a.style.background.backgroundImage.slice(0).reverse().forEach(function (c) {
                        "url" === c.source.method && c.source.args.length ? b.renderBackgroundRepeat(a, c) : /gradient/i.test(c.source.method) && b.renderBackgroundGradient(a, c)
                    })
                }
            }, {
                key: "renderBackgroundRepeat", value: function (a, b) {
                    var d, e, f, g, h, i, c = this.options.imageStore.get(b.source.args[0]);
                    c && (d = k.calculateBackgroungPositioningArea(a.style.background.backgroundOrigin, a.bounds, a.style.padding, a.style.border), e = k.calculateBackgroundSize(b, c, d), f = k.calculateBackgroundPosition(b.position, e, d), g = k.calculateBackgroundRepeatPath(b, f, e, d, a.bounds), h = Math.round(d.left + f.x), i = Math.round(d.top + f.y), this.target.renderRepeat(g, c, e, h, i))
                }
            }, {
                key: "renderBackgroundGradient", value: function (a, b) {
                    var c = k.calculateBackgroungPositioningArea(a.style.background.backgroundOrigin, a.bounds, a.style.padding, a.style.border),
                        d = k.calculateGradientBackgroundSize(b, c),
                        e = k.calculateBackgroundPosition(b.position, d, c),
                        g = new f.Bounds(Math.round(c.left + e.x), Math.round(c.top + e.y), d.width, d.height),
                        i = h.parseGradient(a, b.source, g);
                    if (i)switch (i.type) {
                        case h.GRADIENT_TYPE.LINEAR_GRADIENT:
                            this.target.renderLinearGradient(g, i);
                            break;
                        case h.GRADIENT_TYPE.RADIAL_GRADIENT:
                            this.target.renderRadialGradient(g, i)
                    }
                }
            }, {
                key: "renderBorder", value: function (a, b, c) {
                    this.target.drawShape(f.parsePathForBorder(c, b), a.borderColor)
                }
            }, {
                key: "renderStack", value: function (a) {
                    var c, d, b = this;
                    a.container.isVisible() && (c = a.getOpacity(), c !== this._opacity && (this.target.setOpacity(a.getOpacity()), this._opacity = c), d = a.container.style.transform, null !== d ? this.target.transform(a.container.bounds.left + d.transformOrigin[0].value, a.container.bounds.top + d.transformOrigin[1].value, d.transform, function () {
                        return b.renderStackContent(a)
                    }) : this.renderStackContent(a))
                }
            }, {
                key: "renderStackContent", value: function (a) {
                    var b = q(a), c = d(b, 5), e = c[0], f = c[1], g = c[2], h = c[3], i = c[4], j = p(a), k = d(j, 2),
                        l = k[0], m = k[1];
                    this.renderNodeBackgroundAndBorders(a.container), e.sort(r).forEach(this.renderStack, this), this.renderNodeContent(a.container), m.forEach(this.renderNode, this), h.forEach(this.renderStack, this), i.forEach(this.renderStack, this), l.forEach(this.renderNode, this), f.forEach(this.renderStack, this), g.sort(r).forEach(this.renderStack, this)
                }
            }, {
                key: "render", value: function (a) {
                    var c, b = this;
                    return this.options.backgroundColor && this.target.rectangle(this.options.x, this.options.y, this.options.width, this.options.height, this.options.backgroundColor), this.renderStack(a), c = this.target.getTarget(), c.then(function (a) {
                        return b.options.logger.log("Render completed"), a
                    })
                }
            }]), a
        }(), b.default = o, p = function (a) {
            var e, f, b = [], c = [], d = a.children.length;
            for (e = 0; d > e; e++)f = a.children[e], f.isInlineLevel() ? b.push(f) : c.push(f);
            return [b, c]
        }, q = function (a) {
            var h, i, b = [], c = [], d = [], e = [], f = [], g = a.contexts.length;
            for (h = 0; g > h; h++)i = a.contexts[h], i.container.isPositioned() || i.container.style.opacity < 1 || i.container.isTransformed() ? i.container.style.zIndex.order < 0 ? b.push(i) : i.container.style.zIndex.order > 0 ? d.push(i) : c.push(i) : i.container.isFloating() ? e.push(i) : f.push(i);
            return [b, c, d, e, f]
        }, r = function (a, b) {
            return a.container.style.zIndex.order > b.container.style.zIndex.order ? 1 : a.container.style.zIndex.order < b.container.style.zIndex.order ? -1 : a.container.index > b.container.index ? 1 : -1
        }
    }, function (a, b, c) {
        "use strict";
        function m(a) {
            return a && a.__esModule ? a : {"default": a}
        }

        function n(a, b) {
            if (!(a instanceof b))throw new TypeError("Cannot call a class as a function")
        }

        var d, e, g, h, i, j, k, l, o, p, q, r, s, t, u, v, w, x, z, A, B, C, D, E, F, G, H, I, J;
        Object.defineProperty(b, "__esModule", {value: !0}), b.transformWebkitRadialGradientArgs = b.parseGradient = b.RadialGradient = b.LinearGradient = b.RADIAL_GRADIENT_SHAPE = b.GRADIENT_TYPE = void 0, d = function () {
            function a(a, b) {
                var h, g, c = [], d = !0, e = !1, f = void 0;
                try {
                    for (g = a[Symbol.iterator](); !(d = (h = g.next()).done) && (c.push(h.value), !b || c.length !== b); d = !0);
                } catch (i) {
                    e = !0, f = i
                } finally {
                    try {
                        !d && g["return"] && g["return"]()
                    } finally {
                        if (e)throw f
                    }
                }
                return c
            }

            return function (b, c) {
                if (Array.isArray(b))return b;
                if (Symbol.iterator in Object(b))return a(b, c);
                throw new TypeError("Invalid attempt to destructure non-iterable instance")
            }
        }(), e = c(6), m(e), g = c(53), h = c(0), i = m(h), j = c(1), k = m(j), l = c(3), o = /^(to )?(left|top|right|bottom)( (left|top|right|bottom))?$/i, p = /^([+-]?\d*\.?\d+)% ([+-]?\d*\.?\d+)%$/i, q = /(px)|%|( 0)$/i, r = /^(from|to|color-stop)\((?:([\d.]+)(%)?,\s*)?(.+?)\)$/i, s = /^\s*(circle|ellipse)?\s*((?:([\d.]+)(px|r?em|%)\s*(?:([\d.]+)(px|r?em|%))?)|closest-side|closest-corner|farthest-side|farthest-corner)?\s*(?:at\s*(?:(left|center|right)|([\d.]+)(px|r?em|%))\s+(?:(top|center|bottom)|([\d.]+)(px|r?em|%)))?(?:\s|$)/i, t = b.GRADIENT_TYPE = {
            LINEAR_GRADIENT: 0,
            RADIAL_GRADIENT: 1
        }, u = b.RADIAL_GRADIENT_SHAPE = {CIRCLE: 0, ELLIPSE: 1}, v = {
            left: new k.default("0%"),
            top: new k.default("0%"),
            center: new k.default("50%"),
            right: new k.default("100%"),
            bottom: new k.default("100%")
        }, w = b.LinearGradient = function K(a, b) {
            n(this, K), this.type = t.LINEAR_GRADIENT, this.colorStops = a, this.direction = b
        }, x = b.RadialGradient = function L(a, b, c, d) {
            n(this, L), this.type = t.RADIAL_GRADIENT, this.colorStops = a, this.shape = b, this.center = c, this.radius = d
        }, b.parseGradient = function (a, b, c) {
            var d = b.args, e = b.method, f = b.prefix;
            return "linear-gradient" === e ? A(d, c, !!f) : "gradient" === e && "linear" === d[0] ? A(["to bottom"].concat(J(d.slice(3))), c, !!f) : "radial-gradient" === e ? B(a, "-webkit-" === f ? I(d) : d, c) : "gradient" === e && "radial" === d[0] ? B(a, J(I(d.slice(1))), c) : void 0
        }, z = function (a, b, c) {
            var e, f, g, h, j, l, m, n, o, p, r, s, t, u, d = [];
            for (e = b; e < a.length; e++)f = a[e], g = q.test(f), h = f.lastIndexOf(" "), j = new i.default(g ? f.substring(0, h) : f), l = g ? new k.default(f.substring(h + 1)) : e === b ? new k.default("0%") : e === a.length - 1 ? new k.default("100%") : null, d.push({
                color: j,
                stop: l
            });
            for (m = d.map(function (a) {
                var b = a.color, d = a.stop, e = 0 === c ? 0 : d ? d.getAbsoluteValue(c) / c : null;
                return {color: b, stop: e}
            }), n = m[0].stop, o = 0; o < m.length; o++)if (null !== n)if (p = m[o].stop, null === p) {
                for (r = o; null === m[r].stop;)r++;
                for (s = r - o + 1, t = m[r].stop, u = (t - n) / s; r > o; o++)n = m[o].stop = n + u
            } else n = p;
            return m
        }, A = function (a, b, c) {
            var d = g.parseAngle(a[0]), e = o.test(a[0]), f = e || null !== d || p.test(a[0]),
                h = f ? null !== d ? C(c ? d - .5 * Math.PI : d, b) : e ? E(a[0], b) : F(a[0], b) : C(Math.PI, b),
                i = f ? 1 : 0,
                j = Math.min(l.distance(Math.abs(h.x0) + Math.abs(h.x1), Math.abs(h.y0) + Math.abs(h.y1)), 2 * b.width, 2 * b.height);
            return new w(z(a, i, j), h)
        }, B = function (a, b, c) {
            var h, i, d = b[0].match(s),
                e = d && ("circle" === d[1] || void 0 !== d[3] && void 0 === d[5]) ? u.CIRCLE : u.ELLIPSE, f = {},
                g = {};
            return d && (void 0 !== d[3] && (f.x = j.calculateLengthFromValueWithUnit(a, d[3], d[4]).getAbsoluteValue(c.width)), void 0 !== d[5] && (f.y = j.calculateLengthFromValueWithUnit(a, d[5], d[6]).getAbsoluteValue(c.height)), d[7] ? g.x = v[d[7].toLowerCase()] : void 0 !== d[8] && (g.x = j.calculateLengthFromValueWithUnit(a, d[8], d[9])), d[10] ? g.y = v[d[10].toLowerCase()] : void 0 !== d[11] && (g.y = j.calculateLengthFromValueWithUnit(a, d[11], d[12]))), h = {
                x: void 0 === g.x ? c.width / 2 : g.x.getAbsoluteValue(c.width),
                y: void 0 === g.y ? c.height / 2 : g.y.getAbsoluteValue(c.height)
            }, i = H(d && d[2] || "farthest-corner", e, h, f, c), new x(z(b, d ? 1 : 0, Math.min(i.x, i.y)), e, h, i)
        }, C = function (a, b) {
            var c = b.width, d = b.height, e = .5 * c, f = .5 * d,
                g = Math.abs(c * Math.sin(a)) + Math.abs(d * Math.cos(a)), h = g / 2, i = e + Math.sin(a) * h,
                j = f - Math.cos(a) * h, k = c - i, l = d - j;
            return {x0: i, x1: k, y0: j, y1: l}
        }, D = function (a) {
            return Math.acos(a.width / 2 / (l.distance(a.width, a.height) / 2))
        }, E = function (a, b) {
            switch (a) {
                case"bottom":
                case"to top":
                    return C(0, b);
                case"left":
                case"to right":
                    return C(Math.PI / 2, b);
                case"right":
                case"to left":
                    return C(3 * Math.PI / 2, b);
                case"top right":
                case"right top":
                case"to bottom left":
                case"to left bottom":
                    return C(Math.PI + D(b), b);
                case"top left":
                case"left top":
                case"to bottom right":
                case"to right bottom":
                    return C(Math.PI - D(b), b);
                case"bottom left":
                case"left bottom":
                case"to top right":
                case"to right top":
                    return C(D(b), b);
                case"bottom right":
                case"right bottom":
                case"to top left":
                case"to left top":
                    return C(2 * Math.PI - D(b), b);
                case"top":
                case"to bottom":
                default:
                    return C(Math.PI, b)
            }
        }, F = function (a, b) {
            var c = a.split(" ").map(parseFloat), e = d(c, 2), f = e[0], g = e[1],
                h = f / 100 * b.width / (g / 100 * b.height);
            return C(Math.atan(isNaN(h) ? 1 : h) + Math.PI / 2, b)
        }, G = function (a, b, c, d) {
            var e = [{x: 0, y: 0}, {x: 0, y: a.height}, {x: a.width, y: 0}, {x: a.width, y: a.height}];
            return e.reduce(function (a, e) {
                var f = l.distance(b - e.x, c - e.y);
                return (d ? f < a.optimumDistance : f > a.optimumDistance) ? {optimumCorner: e, optimumDistance: f} : a
            }, {optimumDistance: d ? 1 / 0 : -1 / 0, optimumCorner: null}).optimumCorner
        }, H = function (a, b, c, d, e) {
            var j, k, m, n, f = c.x, g = c.y, h = 0, i = 0;
            switch (a) {
                case"closest-side":
                    b === u.CIRCLE ? h = i = Math.min(Math.abs(f), Math.abs(f - e.width), Math.abs(g), Math.abs(g - e.height)) : b === u.ELLIPSE && (h = Math.min(Math.abs(f), Math.abs(f - e.width)), i = Math.min(Math.abs(g), Math.abs(g - e.height)));
                    break;
                case"closest-corner":
                    b === u.CIRCLE ? h = i = Math.min(l.distance(f, g), l.distance(f, g - e.height), l.distance(f - e.width, g), l.distance(f - e.width, g - e.height)) : b === u.ELLIPSE && (j = Math.min(Math.abs(g), Math.abs(g - e.height)) / Math.min(Math.abs(f), Math.abs(f - e.width)), k = G(e, f, g, !0), h = l.distance(k.x - f, (k.y - g) / j), i = j * h);
                    break;
                case"farthest-side":
                    b === u.CIRCLE ? h = i = Math.max(Math.abs(f), Math.abs(f - e.width), Math.abs(g), Math.abs(g - e.height)) : b === u.ELLIPSE && (h = Math.max(Math.abs(f), Math.abs(f - e.width)), i = Math.max(Math.abs(g), Math.abs(g - e.height)));
                    break;
                case"farthest-corner":
                    b === u.CIRCLE ? h = i = Math.max(l.distance(f, g), l.distance(f, g - e.height), l.distance(f - e.width, g), l.distance(f - e.width, g - e.height)) : b === u.ELLIPSE && (m = Math.max(Math.abs(g), Math.abs(g - e.height)) / Math.max(Math.abs(f), Math.abs(f - e.width)), n = G(e, f, g, !1), h = l.distance(n.x - f, (n.y - g) / m), i = m * h);
                    break;
                default:
                    h = d.x || 0, i = void 0 !== d.y ? d.y : h
            }
            return {x: h, y: i}
        }, I = b.transformWebkitRadialGradientArgs = function (a) {
            var k, l, m, n, o, p, b = "", c = "", d = "", e = "", f = 0,
                g = /^(left|center|right|\d+(?:px|r?em|%)?)(?:\s+(top|center|bottom|\d+(?:px|r?em|%)?))?$/i,
                h = /^(circle|ellipse)?\s*(closest-side|closest-corner|farthest-side|farthest-corner|contain|cover)?$/i,
                i = /^\d+(px|r?em|%)?(?:\s+\d+(px|r?em|%)?)?$/i, j = a[f].match(g);
            return j && f++, k = a[f].match(h), k && (b = k[1] || "", d = k[2] || "", "contain" === d ? d = "closest-side" : "cover" === d && (d = "farthest-corner"), f++), l = a[f].match(i), l && f++, m = a[f].match(g), m && f++, n = a[f].match(i), n && f++, o = m || j, o && o[1] && (e = o[1] + (/^\d+$/.test(o[1]) ? "px" : ""), o[2] && (e += " " + o[2] + (/^\d+$/.test(o[2]) ? "px" : ""))), p = n || l, p && (c = p[0], p[1] || (c += "px")), !e || b || c || d || (c = e, e = ""), e && (e = "at " + e), [[b, d, c, e].filter(function (a) {
                return !!a
            }).join(" ")].concat(a.slice(f))
        }, J = function (a) {
            return a.map(function (a) {
                return a.match(r)
            }).map(function (b, c) {
                if (!b)return a[c];
                switch (b[1]) {
                    case"from":
                        return b[4] + " 0%";
                    case"to":
                        return b[4] + " 100%";
                    case"color-stop":
                        return "%" === b[3] ? b[4] + " " + b[2] : b[4] + " " + 100 * parseFloat(b[2]) + "%"
                }
            })
        }
    }, function (a, b) {
        "use strict";
        Object.defineProperty(b, "__esModule", {value: !0});
        var d = /([+-]?\d*\.?\d+)(deg|grad|rad|turn)/i;
        b.parseAngle = function (a) {
            var c, b = a.match(d);
            if (b)switch (c = parseFloat(b[1]), b[2].toLowerCase()) {
                case"deg":
                    return Math.PI * c / 180;
                case"grad":
                    return Math.PI / 200 * c;
                case"rad":
                    return c;
                case"turn":
                    return 2 * Math.PI * c
            }
            return null
        }
    }, function (a, b, c) {
        "use strict";
        function o(a) {
            return a && a.__esModule ? a : {"default": a}
        }

        function p(a, b) {
            if (!(a instanceof b))throw new TypeError("Cannot call a class as a function")
        }

        var d, e, f, g, h, i, j, k, l, m, n, q, r, s, t, u, v, w, y, z, A, B, C, D, E, F, G, H, I, J, K, M;
        Object.defineProperty(b, "__esModule", {value: !0}), b.cloneWindow = b.DocumentCloner = void 0, d = function () {
            function a(a, b) {
                var h, g, c = [], d = !0, e = !1, f = void 0;
                try {
                    for (g = a[Symbol.iterator](); !(d = (h = g.next()).done) && (c.push(h.value), !b || c.length !== b); d = !0);
                } catch (i) {
                    e = !0, f = i
                } finally {
                    try {
                        !d && g["return"] && g["return"]()
                    } finally {
                        if (e)throw f
                    }
                }
                return c
            }

            return function (b, c) {
                if (Array.isArray(b))return b;
                if (Symbol.iterator in Object(b))return a(b, c);
                throw new TypeError("Invalid attempt to destructure non-iterable instance")
            }
        }(), e = function () {
            function a(a, b) {
                var c, d;
                for (c = 0; c < b.length; c++)d = b[c], d.enumerable = d.enumerable || !1, d.configurable = !0, "value" in d && (d.writable = !0), Object.defineProperty(a, d.key, d)
            }

            return function (b, c, d) {
                return c && a(b.prototype, c), d && a(b, d), b
            }
        }(), f = c(2), g = c(26), h = c(55), i = o(h), j = c(3), k = c(4), l = c(15), m = o(l), n = c(56), q = "data-html2canvas-ignore", r = b.DocumentCloner = function () {
            function a(b, c, d, e, f) {
                p(this, a), this.referenceElement = b, this.scrolledElements = [], this.copyStyles = e, this.inlineImages = e, this.logger = d, this.options = c, this.renderer = f, this.resourceLoader = new i.default(c, d, window), this.pseudoContentData = {
                    counters: {},
                    quoteDepth: 0
                }, this.documentElement = this.cloneNode(b.ownerDocument.documentElement)
            }

            return e(a, [{
                key: "inlineAllImages", value: function (a) {
                    var c, b = this;
                    this.inlineImages && a && (c = a.style, Promise.all(k.parseBackgroundImage(c.backgroundImage).map(function (a) {
                        return "url" === a.method ? b.resourceLoader.inlineImage(a.args[0]).then(function (a) {
                            return a && "string" == typeof a.src ? 'url("' + a.src + '")' : "none"
                        }).catch(function (a) {
                            b.logger.log("Unable to load image", a)
                        }) : Promise.resolve("" + a.prefix + a.method + "(" + a.args.join(",") + ")")
                    })).then(function (a) {
                        a.length > 1 && (c.backgroundColor = ""), c.backgroundImage = a.join(",")
                    }), a instanceof HTMLImageElement && this.resourceLoader.inlineImage(a.src).then(function (b) {
                        var c, d;
                        b && a instanceof HTMLImageElement && a.parentNode && (c = a.parentNode, d = j.copyCSSStyles(a.style, b.cloneNode(!1)), c.replaceChild(d, a))
                    }).catch(function (a) {
                        b.logger.log("Unable to load image", a)
                    }))
                }
            }, {
                key: "inlineFonts", value: function (a) {
                    var b = this;
                    return Promise.all(Array.from(a.styleSheets).map(function (c) {
                        return c.href ? fetch(c.href).then(function (a) {
                            return a.text()
                        }).then(function (a) {
                            return t(a, c.href)
                        }).catch(function (a) {
                            return b.logger.log("Unable to load stylesheet", a), []
                        }) : s(c, a)
                    })).then(function (a) {
                        return a.reduce(function (a, b) {
                            return a.concat(b)
                        }, [])
                    }).then(function (a) {
                        return Promise.all(a.map(function (a) {
                            return fetch(a.formats[0].src).then(function (a) {
                                return a.blob()
                            }).then(function (a) {
                                return new Promise(function (b, c) {
                                    var d = new FileReader;
                                    d.onerror = c, d.onload = function () {
                                        var a = d.result;
                                        b(a)
                                    }, d.readAsDataURL(a)
                                })
                            }).then(function (b) {
                                return a.fontFace.setProperty("src", 'url("' + b + '")'), "@font-face {" + a.fontFace.cssText + " "
                            })
                        }))
                    }).then(function (c) {
                        var d = a.createElement("style");
                        d.textContent = c.join("\n"), b.documentElement.appendChild(d)
                    })
                }
            }, {
                key: "createElementClone", value: function (a) {
                    var c, e, g, h, i, k, l, n, b = this;
                    if (this.copyStyles && a instanceof HTMLCanvasElement) {
                        c = a.ownerDocument.createElement("img");
                        try {
                            return c.src = a.toDataURL(), c
                        } catch (d) {
                            this.logger.log("Unable to clone canvas contents, canvas is tainted")
                        }
                    }
                    return a instanceof HTMLIFrameElement ? (e = a.cloneNode(!1), g = G(), e.setAttribute("data-html2canvas-internal-iframe-key", g), h = f.parseBounds(a, 0, 0), i = h.width, k = h.height, this.resourceLoader.cache[g] = I(a, this.options).then(function (a) {
                        return b.renderer(a, {
                            async: b.options.async,
                            allowTaint: b.options.allowTaint,
                            backgroundColor: "#ffffff",
                            canvas: null,
                            imageTimeout: b.options.imageTimeout,
                            logging: b.options.logging,
                            proxy: b.options.proxy,
                            removeContainer: b.options.removeContainer,
                            scale: b.options.scale,
                            foreignObjectRendering: b.options.foreignObjectRendering,
                            useCORS: b.options.useCORS,
                            target: new m.default,
                            width: i,
                            height: k,
                            x: 0,
                            y: 0,
                            windowWidth: a.ownerDocument.defaultView.innerWidth,
                            windowHeight: a.ownerDocument.defaultView.innerHeight,
                            scrollX: a.ownerDocument.defaultView.pageXOffset,
                            scrollY: a.ownerDocument.defaultView.pageYOffset
                        }, b.logger.child(g))
                    }).then(function (b) {
                        return new Promise(function (c, d) {
                            var f = document.createElement("img");
                            f.onload = function () {
                                return c(b)
                            }, f.onerror = d, f.src = b.toDataURL(), e.parentNode && e.parentNode.replaceChild(j.copyCSSStyles(a.ownerDocument.defaultView.getComputedStyle(a), f), e)
                        })
                    }), e) : a instanceof HTMLStyleElement && a.sheet && a.sheet.cssRules ? (l = [].slice.call(a.sheet.cssRules, 0).reduce(function (a, c) {
                        try {
                            return c && c.cssText ? a + c.cssText : a
                        } catch (d) {
                            return b.logger.log("Unable to access cssText property", c.name), a
                        }
                    }, ""), n = a.cloneNode(!1), n.textContent = l, n) : a.cloneNode(!1)
                }
            }, {
                key: "cloneNode", value: function (a) {
                    var g, h, i, k,
                        b = a.nodeType === Node.TEXT_NODE ? document.createTextNode(a.nodeValue) : this.createElementClone(a),
                        c = a.ownerDocument.defaultView, d = a instanceof c.HTMLElement ? c.getComputedStyle(a) : null,
                        e = a instanceof c.HTMLElement ? c.getComputedStyle(a, ":before") : null,
                        f = a instanceof c.HTMLElement ? c.getComputedStyle(a, ":after") : null;
                    for (this.referenceElement === a && b instanceof c.HTMLElement && (this.clonedReferenceElement = b), b instanceof c.HTMLBodyElement && D(b), g = n.parseCounterReset(d, this.pseudoContentData), h = n.resolvePseudoContent(a, e, this.pseudoContentData), i = a.firstChild; i; i = i.nextSibling)i.nodeType === Node.ELEMENT_NODE && ("SCRIPT" === i.nodeName || i.hasAttribute(q) || "function" == typeof this.options.ignoreElements && this.options.ignoreElements(i)) || this.copyStyles && "STYLE" === i.nodeName || b.appendChild(this.cloneNode(i));
                    if (k = n.resolvePseudoContent(a, f, this.pseudoContentData), n.popCounters(g, this.pseudoContentData), a instanceof c.HTMLElement && b instanceof c.HTMLElement)switch (e && this.inlineAllImages(w(a, b, e, h, y)), f && this.inlineAllImages(w(a, b, f, k, z)), !d || !this.copyStyles || a instanceof HTMLIFrameElement || j.copyCSSStyles(d, b), this.inlineAllImages(b), (0 !== a.scrollTop || 0 !== a.scrollLeft) && this.scrolledElements.push([b, a.scrollLeft, a.scrollTop]), a.nodeName) {
                        case"CANVAS":
                            this.copyStyles || v(a, b);
                            break;
                        case"TEXTAREA":
                        case"SELECT":
                            b.value = a.value
                    }
                    return b
                }
            }]), a
        }(), s = function (a, b) {
            return (a.cssRules ? Array.from(a.cssRules) : []).filter(function (a) {
                return a.type === CSSRule.FONT_FACE_RULE
            }).map(function (a) {
                var e, f, g, c = k.parseBackgroundImage(a.style.getPropertyValue("src")), d = [];
                for (e = 0; e < c.length; e++)"url" === c[e].method && c[e + 1] && "format" === c[e + 1].method && (f = b.createElement("a"), f.href = c[e].args[0], b.body && b.body.appendChild(f), g = {
                    src: f.href,
                    format: c[e + 1].args[0]
                }, d.push(g));
                return {
                    formats: d.filter(function (a) {
                        return /^woff/i.test(a.format)
                    }), fontFace: a.style
                }
            }).filter(function (a) {
                return a.formats.length
            })
        }, t = function (a, b) {
            var e, c = document.implementation.createHTMLDocument(""), d = document.createElement("base");
            return d.href = b, e = document.createElement("style"), e.textContent = a, c.head && c.head.appendChild(d), c.body && c.body.appendChild(e), e.sheet ? s(e.sheet, c) : []
        }, u = function (a, b, c) {
            !a.defaultView || b === a.defaultView.pageXOffset && c === a.defaultView.pageYOffset || a.defaultView.scrollTo(b, c)
        }, v = function (a, b) {
            var c, d;
            try {
                b && (b.width = a.width, b.height = a.height, c = a.getContext("2d"), d = b.getContext("2d"), c ? d.putImageData(c.getImageData(0, 0, a.width, a.height), 0, 0) : d.drawImage(a, 0, 0))
            } catch (e) {
            }
        }, w = function (a, b, c, d, e) {
            var f, g, h, i, l;
            if (c && c.content && "none" !== c.content && "-moz-alt-content" !== c.content && "none" !== c.display) {
                if (f = b.ownerDocument.createElement("html2canvaspseudoelement"), j.copyCSSStyles(c, f), d)for (g = d.length, h = 0; g > h; h++)switch (i = d[h], i.type) {
                    case n.PSEUDO_CONTENT_ITEM_TYPE.IMAGE:
                        l = b.ownerDocument.createElement("img"), l.src = k.parseBackgroundImage("url(" + i.value + ")")[0].args[0], l.style.opacity = "1", f.appendChild(l);
                        break;
                    case n.PSEUDO_CONTENT_ITEM_TYPE.TEXT:
                        f.appendChild(b.ownerDocument.createTextNode(i.value))
                }
                return f.className = A + " " + B, b.className += e === y ? " " + A : " " + B, e === y ? b.insertBefore(f, b.firstChild) : b.appendChild(f), f
            }
        }, y = ":before", z = ":after", A = "___html2canvas___pseudoelement_before", B = "___html2canvas___pseudoelement_after", C = '{\n    content: "" !important;\n    display: none !important;\n}', D = function (a) {
            E(a, "." + A + y + C + "\n         ." + B + z + C)
        }, E = function (a, b) {
            var c = a.ownerDocument.createElement("style");
            c.innerHTML = b, a.appendChild(c)
        }, F = function (a) {
            var b = d(a, 3), c = b[0], e = b[1], f = b[2];
            c.scrollLeft = e, c.scrollTop = f
        }, G = function () {
            return Math.ceil(Date.now() + 1e7 * Math.random()).toString(16)
        }, H = /^data:text\/(.+);(base64)?,(.*)$/i, I = function (a, b) {
            try {
                return Promise.resolve(a.contentWindow.document.documentElement)
            } catch (c) {
                return b.proxy ? g.Proxy(a.src, b).then(function (a) {
                    var b = a.match(H);
                    return b ? "base64" === b[2] ? window.atob(decodeURIComponent(b[3])) : decodeURIComponent(b[3]) : Promise.reject()
                }).then(function (b) {
                    return J(a.ownerDocument, f.parseBounds(a, 0, 0)).then(function (a) {
                        var e, c = a.contentWindow, d = c.document;
                        return d.open(), d.write(b), e = K(a).then(function () {
                            return d.documentElement
                        }), d.close(), e
                    })
                }) : Promise.reject()
            }
        }, J = function (a, b) {
            var c = a.createElement("iframe");
            return c.className = "html2canvas-container", c.style.visibility = "hidden", c.style.position = "fixed", c.style.left = "-10000px", c.style.top = "0px", c.style.border = "0", c.width = b.width.toString(), c.height = b.height.toString(), c.scrolling = "no", c.setAttribute(q, "true"), a.body ? (a.body.appendChild(c), Promise.resolve(c)) : Promise.reject("Body element not found in Document that is getting rendered")
        }, K = function (a) {
            var b = a.contentWindow, c = b.document;
            return new Promise(function (d) {
                b.onload = a.onload = c.onreadystatechange = function () {
                    var b = setInterval(function () {
                        c.body.childNodes.length > 0 && "complete" === c.readyState && (clearInterval(b), d(a))
                    }, 50)
                }
            })
        }, b.cloneWindow = function (a, b, c, d, e, f) {
            var g = new r(c, d, e, !1, f), h = a.defaultView.pageXOffset, i = a.defaultView.pageYOffset;
            return J(a, b).then(function (e) {
                var f = e.contentWindow, j = f.document, k = K(e).then(function () {
                    var h, i;
                    return g.scrolledElements.forEach(F), f.scrollTo(b.left, b.top), !/(iPad|iPhone|iPod)/g.test(navigator.userAgent) || f.scrollY === b.top && f.scrollX === b.left || (j.documentElement.style.top = -b.top + "px", j.documentElement.style.left = -b.left + "px", j.documentElement.style.position = "absolute"), h = Promise.resolve([e, g.clonedReferenceElement, g.resourceLoader]), i = d.onclone, g.clonedReferenceElement instanceof f.HTMLElement || g.clonedReferenceElement instanceof a.defaultView.HTMLElement || g.clonedReferenceElement instanceof HTMLElement ? "function" == typeof i ? Promise.resolve().then(function () {
                        return i(j)
                    }).then(function () {
                        return h
                    }) : h : Promise.reject("Error finding the " + c.nodeName + " in the cloned document")
                });
                return j.open(), j.write(M(document.doctype) + "<html></html>"), u(c.ownerDocument, h, i), j.replaceChild(j.adoptNode(g.documentElement), j.documentElement), j.close(), k
            })
        }, M = function (a) {
            var b = "";
            return a && (b += "<!DOCTYPE ", a.name && (b += a.name), a.internalSubset && (b += a.internalSubset), a.publicId && (b += '"' + a.publicId + '"'), a.systemId && (b += '"' + a.systemId + '"'), b += ">"), b
        }
    }, function (a, b, c) {
        "use strict";
        function h(a) {
            return a && a.__esModule ? a : {"default": a}
        }

        function i(a, b) {
            if (!(a instanceof b))throw new TypeError("Cannot call a class as a function")
        }

        var d, e, f, g, j, k, l, m, n, o, p, q, r, s;
        Object.defineProperty(b, "__esModule", {value: !0}), b.ResourceStore = void 0, d = function () {
            function a(a, b) {
                var c, d;
                for (c = 0; c < b.length; c++)d = b[c], d.enumerable = d.enumerable || !1, d.configurable = !0, "value" in d && (d.writable = !0), Object.defineProperty(a, d.key, d)
            }

            return function (b, c, d) {
                return c && a(b.prototype, c), d && a(b, d), b
            }
        }(), e = c(10), f = h(e), g = c(26), j = function () {
            function a(b, c, d) {
                i(this, a), this.options = b, this._window = d, this.origin = this.getOrigin(d.location.href), this.cache = {}, this.logger = c, this._index = 0
            }

            return d(a, [{
                key: "loadImage", value: function (a) {
                    var b = this;
                    if (this.hasResourceInCache(a))return a;
                    if (q(a))return this.cache[a] = s(a, this.options.imageTimeout || 0), a;
                    if (!r(a) || f.default.SUPPORT_SVG_DRAWING) {
                        if (this.options.allowTaint === !0 || o(a) || this.isSameOrigin(a))return this.addImage(a, a, !1);
                        if (!this.isSameOrigin(a)) {
                            if ("string" == typeof this.options.proxy)return this.cache[a] = g.Proxy(a, this.options).then(function (a) {
                                return s(a, b.options.imageTimeout || 0)
                            }), a;
                            if (this.options.useCORS === !0 && f.default.SUPPORT_CORS_IMAGES)return this.addImage(a, a, !0)
                        }
                    }
                }
            }, {
                key: "inlineImage", value: function (a) {
                    var b = this;
                    return o(a) ? s(a, this.options.imageTimeout || 0) : this.hasResourceInCache(a) ? this.cache[a] : this.isSameOrigin(a) || "string" != typeof this.options.proxy ? this.xhrImage(a) : this.cache[a] = g.Proxy(a, this.options).then(function (a) {
                        return s(a, b.options.imageTimeout || 0)
                    })
                }
            }, {
                key: "xhrImage", value: function (a) {
                    var b = this;
                    return this.cache[a] = new Promise(function (c, d) {
                        var f, e = new XMLHttpRequest;
                        e.onreadystatechange = function () {
                            if (4 === e.readyState)if (200 !== e.status) d("Failed to fetch image " + a.substring(0, 256) + " with status code " + e.status); else {
                                var b = new FileReader;
                                b.addEventListener("load", function () {
                                    var a = b.result;
                                    c(a)
                                }, !1), b.addEventListener("error", function (a) {
                                    return d(a)
                                }, !1), b.readAsDataURL(e.response)
                            }
                        }, e.responseType = "blob", b.options.imageTimeout && (f = b.options.imageTimeout, e.timeout = f, e.ontimeout = function () {
                            return d("Timed out (" + f + "ms) fetching " + a.substring(0, 256))
                        }), e.open("GET", a, !0), e.send()
                    }).then(function (a) {
                        return s(a, b.options.imageTimeout || 0)
                    }), this.cache[a]
                }
            }, {
                key: "loadCanvas", value: function (a) {
                    var b = String(this._index++);
                    return this.cache[b] = Promise.resolve(a), b
                }
            }, {
                key: "hasResourceInCache", value: function (a) {
                    return "undefined" != typeof this.cache[a]
                }
            }, {
                key: "addImage", value: function (a, b, c) {

                    var e, d = this;
                    return this.logger.log("Added image " + a.substring(0, 256)), $.ajax({
                        type: "HEAD",
                        async: !1,
                        url: b
                    }).fail(function () {
                        b = "public/js/cros_pic.php?url=" + b
                    }), e = function (a) {
                        return new Promise(function (e, f) {
                            var h, g = new Image;
                            g.onload = function () {
                                return e(g)
                            }, (!a || c) && (g.crossOrigin = "anonymous"), g.onerror = f, g.src = b, g.complete === !0 && setTimeout(function () {
                                e(g)
                            }, 500), d.options.imageTimeout && (h = d.options.imageTimeout, setTimeout(function () {
                                return f("Timed out (" + h + "ms) fetching " + b.substring(0, 256))
                            }, h))
                        })
                    }, this.cache[a] = p(b) && !r(b) ? f.default.SUPPORT_BASE64_DRAWING(b).then(e) : e(!0), a
                }
            }, {
                key: "isSameOrigin", value: function (a) {
                    return this.getOrigin(a) === this.origin
                }
            }, {
                key: "getOrigin", value: function (a) {
                    var b = this._link || (this._link = this._window.document.createElement("a"));
                    return b.href = a, b.href = b.href, b.protocol + b.hostname + b.port
                }
            }, {
                key: "ready", value: function () {
                    var a = this, b = Object.keys(this.cache), c = b.map(function (b) {
                        return a.cache[b].catch(function (b) {
                            return a.logger.log("Unable to load image", b), null
                        })
                    });
                    return Promise.all(c).then(function (c) {
                        return a.logger.log("Finished loading " + c.length + " images", c), new k(b, c)
                    })
                }
            }]), a
        }(), b.default = j, k = b.ResourceStore = function () {
            function a(b, c) {
                i(this, a), this._keys = b, this._resources = c
            }

            return d(a, [{
                key: "get", value: function (a) {
                    var b = this._keys.indexOf(a);
                    return -1 === b ? null : this._resources[b]
                }
            }]), a
        }(), l = /^data:image\/svg\+xml/i, m = /^data:image\/.*;base64,/i, n = /^data:image\/.*/i, o = function (a) {
            return n.test(a)
        }, p = function (a) {
            return m.test(a)
        }, q = function (a) {
            return "blob" === a.substr(0, 4)
        }, r = function (a) {
            return "svg" === a.substr(-3).toLowerCase() || l.test(a)
        }, s = function (a, b) {
            return new Promise(function (c, d) {
                var e = new Image;
                e.onload = function () {
                    return c(e)
                }, e.onerror = d, e.src = a, e.complete === !0 && setTimeout(function () {
                    c(e)
                }, 500), b && setTimeout(function () {
                    return d("Timed out (" + b + "ms) loading image")
                }, b)
            })
        }
    }, function (a, b, c) {
        "use strict";
        var d, e, f, g, h, l, m, n, o;
        Object.defineProperty(b, "__esModule", {value: !0}), b.parseContent = b.resolvePseudoContent = b.popCounters = b.parseCounterReset = b.TOKEN_TYPE = b.PSEUDO_CONTENT_ITEM_TYPE = void 0, d = function () {
            function a(a, b) {
                var h, g, c = [], d = !0, e = !1, f = void 0;
                try {
                    for (g = a[Symbol.iterator](); !(d = (h = g.next()).done) && (c.push(h.value), !b || c.length !== b); d = !0);
                } catch (i) {
                    e = !0, f = i
                } finally {
                    try {
                        !d && g["return"] && g["return"]()
                    } finally {
                        if (e)throw f
                    }
                }
                return c
            }

            return function (b, c) {
                if (Array.isArray(b))return b;
                if (Symbol.iterator in Object(b))return a(b, c);
                throw new TypeError("Invalid attempt to destructure non-iterable instance")
            }
        }(), e = c(14), f = c(8), g = b.PSEUDO_CONTENT_ITEM_TYPE = {TEXT: 0, IMAGE: 1}, h = b.TOKEN_TYPE = {
            STRING: 0,
            ATTRIBUTE: 1,
            URL: 2,
            COUNTER: 3,
            COUNTERS: 4,
            OPENQUOTE: 5,
            CLOSEQUOTE: 6
        }, b.parseCounterReset = function (a, b) {
            var c, e, f, g, h, i, j, k, l;
            if (!a || !a.counterReset || "none" === a.counterReset)return [];
            for (c = [], e = a.counterReset.split(/\s*,\s*/), f = e.length, g = 0; f > g; g++)h = e[g].split(/\s+/), i = d(h, 2), j = i[0], k = i[1], c.push(j), l = b.counters[j], l || (l = b.counters[j] = []), l.push(parseInt(k || 0, 10));
            return c
        }, b.popCounters = function (a, b) {
            var d, c = a.length;
            for (d = 0; c > d; d++)b.counters[a[d]].pop()
        }, b.resolvePseudoContent = function (a, b, c) {
            var e, f, i, j, k, m, p, q, r, s, t, u, v, w;
            if (!b || !b.content || "none" === b.content || "-moz-alt-content" === b.content || "none" === b.display)return null;
            for (e = l(b.content), f = e.length, i = [], j = "", k = b.counterIncrement, k && "none" !== k && (m = k.split(/\s+/), p = d(m, 2), q = p[0], r = p[1], s = c.counters[q], s && (s[s.length - 1] += void 0 === r ? 1 : parseInt(r, 10))), t = 0; f > t; t++)switch (u = e[t], u.type) {
                case h.STRING:
                    j += u.value || "";
                    break;
                case h.ATTRIBUTE:
                    a instanceof HTMLElement && u.value && (j += a.getAttribute(u.value) || "");
                    break;
                case h.COUNTER:
                    v = c.counters[u.name || ""], v && (j += o([v[v.length - 1]], "", u.format));
                    break;
                case h.COUNTERS:
                    w = c.counters[u.name || ""], w && (j += o(w, u.glue, u.format));
                    break;
                case h.OPENQUOTE:
                    j += n(b, !0, c.quoteDepth), c.quoteDepth++;
                    break;
                case h.CLOSEQUOTE:
                    c.quoteDepth--, j += n(b, !1, c.quoteDepth);
                    break;
                case h.URL:
                    j && (i.push({type: g.TEXT, value: j}), j = ""), i.push({type: g.IMAGE, value: u.value || ""})
            }
            return j && i.push({type: g.TEXT, value: j}), i
        }, l = b.parseContent = function (a, b) {
            var c, d, e, f, g, i, j, k, l, n, o, p;
            if (b && b[a])return b[a];
            for (c = [], d = a.length, e = !1, f = !1, g = !1, i = "", j = "", k = [], l = 0; d > l; l++) {
                switch (n = a.charAt(l)) {
                    case"'":
                    case'"':
                        f ? i += n : (e = !e, g || e || (c.push({type: h.STRING, value: i}), i = ""));
                        break;
                    case"\\":
                        f ? (i += n, f = !1) : f = !0;
                        break;
                    case"(":
                        e ? i += n : (g = !0, j = i, i = "", k = []);
                        break;
                    case")":
                        if (e) i += n; else if (g) {
                            switch (i && k.push(i), j) {
                                case"attr":
                                    k.length > 0 && c.push({type: h.ATTRIBUTE, value: k[0]});
                                    break;
                                case"counter":
                                    k.length > 0 && (o = {
                                        type: h.COUNTER,
                                        name: k[0]
                                    }, k.length > 1 && (o.format = k[1]), c.push(o));
                                    break;
                                case"counters":
                                    k.length > 0 && (p = {
                                        type: h.COUNTERS,
                                        name: k[0]
                                    }, k.length > 1 && (p.glue = k[1]), k.length > 2 && (p.format = k[2]), c.push(p));
                                    break;
                                case"url":
                                    k.length > 0 && c.push({type: h.URL, value: k[0]})
                            }
                            g = !1, i = ""
                        }
                        break;
                    case",":
                        e ? i += n : g && (k.push(i), i = "");
                        break;
                    case" ":
                    case"	":
                        e ? i += n : i && (m(c, i), i = "");
                        break;
                    default:
                        i += n
                }
                "\\" !== n && (f = !1)
            }
            return i && m(c, i), b && (b[a] = c), c
        }, m = function (a, b) {
            switch (b) {
                case"open-quote":
                    a.push({type: h.OPENQUOTE});
                    break;
                case"close-quote":
                    a.push({type: h.CLOSEQUOTE})
            }
        }, n = function (a, b, c) {
            var d = a.quotes ? a.quotes.split(/\s+/) : ["'\"'", "'\"'"], e = 2 * c;
            return e >= d.length && (e = d.length - 2), b || ++e, d[e].replace(/^["']|["']$/g, "")
        }, o = function (a, b, c) {
            var h, d = a.length, g = "";
            for (h = 0; d > h; h++)h > 0 && (g += b || ""), g += e.createCounterText(a[h], f.parseListStyleType(c || "decimal"), !1);
            return g
        }
    }])
});