Object.defineProperty(exports, "__esModule", {
    value: !0
});

var _createClass = function() {
    function i(t, s) {
        for (var e = 0; e < s.length; e++) {
            var i = s[e];
            i.enumerable = i.enumerable || !1, i.configurable = !0, "value" in i && (i.writable = !0), 
            Object.defineProperty(t, i.key, i);
        }
    }
    return function(t, s, e) {
        return s && i(t.prototype, s), e && i(t, e), t;
    };
}();

function _toConsumableArray(t) {
    if (Array.isArray(t)) {
        for (var s = 0, e = Array(t.length); s < t.length; s++) e[s] = t[s];
        return e;
    }
    return Array.from(t);
}

function _classCallCheck(t, s) {
    if (!(t instanceof s)) throw new TypeError("Cannot call a class as a function");
}

var QR = require("./qrcode.js"), Painter = function() {
    function e(t, s) {
        _classCallCheck(this, e), this.ctx = t, this.data = s;
    }
    return _createClass(e, [ {
        key: "paint",
        value: function(t) {
            this.style = {
                width: this.data.width.toPx(),
                height: this.data.height.toPx()
            }, this._background();
            var s = !0, e = !1, i = void 0;
            try {
                for (var r, h = this.data.views[Symbol.iterator](); !(s = (r = h.next()).done); s = !0) {
                    var c = r.value;
                    this._drawAbsolute(c);
                }
            } catch (t) {
                e = !0, i = t;
            } finally {
                try {
                    !s && h.return && h.return();
                } finally {
                    if (e) throw i;
                }
            }
            this.ctx.draw(!1, function() {
                t();
            });
        }
    }, {
        key: "_background",
        value: function() {
            this.ctx.save();
            var t = this.style, s = t.width, e = t.height, i = this.data.background;
            this.ctx.translate(s / 2, e / 2), this._doClip(this.data.borderRadius, s, e), i ? i.startsWith("#") || i.startsWith("rgba") ? (this.ctx.setFillStyle(i), 
            this.ctx.fillRect(-s / 2, -e / 2, s, e)) : this.ctx.drawImage(i, -s / 2, -e / 2, s, e) : (this.ctx.setFillStyle("#fff"), 
            this.ctx.fillRect(-s / 2, -e / 2, s, e)), this.ctx.restore();
        }
    }, {
        key: "_drawAbsolute",
        value: function(t) {
            switch (t.css.length && (t.css = Object.assign.apply(Object, _toConsumableArray(t.css))), 
            t.type) {
              case "image":
                this._drawAbsImage(t);
                break;

              case "text":
                this._fillAbsText(t);
                break;

              case "rect":
                this._drawAbsRect(t);
                break;

              case "qrcode":
                this._drawQRCode(t);
            }
        }
    }, {
        key: "_doClip",
        value: function(t, s, e) {
            if (t && s && e) {
                var i = Math.min(t.toPx(), s / 2, e / 2);
                this.ctx.setGlobalAlpha(0), this.ctx.setFillStyle("white"), this.ctx.beginPath(), 
                this.ctx.arc(-s / 2 + i, -e / 2 + i, i, 1 * Math.PI, 1.5 * Math.PI), this.ctx.lineTo(s / 2 - i, -e / 2), 
                this.ctx.arc(s / 2 - i, -e / 2 + i, i, 1.5 * Math.PI, 2 * Math.PI), this.ctx.lineTo(s / 2, e / 2 - i), 
                this.ctx.arc(s / 2 - i, e / 2 - i, i, 0, .5 * Math.PI), this.ctx.lineTo(-s / 2 + i, e / 2), 
                this.ctx.arc(-s / 2 + i, e / 2 - i, i, .5 * Math.PI, 1 * Math.PI), this.ctx.closePath(), 
                this.ctx.fill(), getApp().systemInfo && getApp().systemInfo.version <= "6.6.6" && "ios" === getApp().systemInfo.platform || this.ctx.clip(), 
                this.ctx.setGlobalAlpha(1);
            }
        }
    }, {
        key: "_doBorder",
        value: function(t, s, e) {
            var i = t.css, r = i.borderRadius, h = i.borderWidth, c = i.borderColor;
            if (h) {
                this.ctx.save(), this._preProcess(t, !0);
                var a = void 0;
                a = r ? Math.min(r.toPx(), s / 2, e / 2) : 0;
                var o = h.toPx();
                this.ctx.setLineWidth(o), this.ctx.setStrokeStyle(c || "black"), this.ctx.beginPath(), 
                this.ctx.arc(-s / 2 + a, -e / 2 + a, a + o / 2, 1 * Math.PI, 1.5 * Math.PI), this.ctx.lineTo(s / 2 - a, -e / 2 - o / 2), 
                this.ctx.arc(s / 2 - a, -e / 2 + a, a + o / 2, 1.5 * Math.PI, 2 * Math.PI), this.ctx.lineTo(s / 2 + o / 2, e / 2 - a), 
                this.ctx.arc(s / 2 - a, e / 2 - a, a + o / 2, 0, .5 * Math.PI), this.ctx.lineTo(-s / 2 + a, e / 2 + o / 2), 
                this.ctx.arc(-s / 2 + a, e / 2 - a, a + o / 2, .5 * Math.PI, 1 * Math.PI), this.ctx.closePath(), 
                this.ctx.stroke(), this.ctx.restore();
            }
        }
    }, {
        key: "_preProcess",
        value: function(t, s) {
            var e = void 0, i = void 0, r = void 0, h = void 0, c = void 0;
            if ("text" === t.type) {
                var a = "bold" === t.css.fontWeight ? "bold" : "normal";
                t.css.fontSize = t.css.fontSize ? t.css.fontSize : "20rpx", this.ctx.font = "normal " + a + " " + t.css.fontSize.toPx() + "px sans-serif";
                var o = this.ctx.measureText(t.text).width;
                e = t.css.width ? t.css.width.toPx() : o;
                var l = Math.ceil(o / e), n = t.css.maxLines < l ? t.css.maxLines : l, x = t.css.lineHeight ? t.css.lineHeight.toPx() : t.css.fontSize.toPx();
                i = x * n, r = t.css.right ? this.style.width - t.css.right.toPx(!0) : t.css.left ? t.css.left.toPx(!0) : 0, 
                h = t.css.bottom ? this.style.height - i - t.css.bottom.toPx(!0) : t.css.top ? t.css.top.toPx(!0) : 0, 
                c = {
                    lines: n,
                    lineHeight: x
                };
            } else {
                if (!t.css.width || !t.css.height) return void console.error("You should set width and height");
                e = t.css.width.toPx(), i = t.css.height.toPx(), r = t.css.right ? this.style.width - t.css.right.toPx(!0) : t.css.left ? t.css.left.toPx(!0) : 0, 
                h = t.css.bottom ? this.style.height - i - t.css.bottom.toPx(!0) : t.css.top ? t.css.top.toPx(!0) : 0;
            }
            var d = t.css.rotate ? this._getAngle(t.css.rotate) : 0;
            switch (t.css.align ? t.css.align : t.css.right ? "right" : "left") {
              case "center":
                this.ctx.translate(r, h + i / 2);
                break;

              case "right":
                this.ctx.translate(r - e / 2, h + i / 2);
                break;

              default:
                this.ctx.translate(r + e / 2, h + i / 2);
            }
            return this.ctx.rotate(d), s || this._doClip(t.css.borderRadius, e, i), {
                width: e,
                height: i,
                x: r,
                y: h,
                extra: c
            };
        }
    }, {
        key: "_drawQRCode",
        value: function(t) {
            this.ctx.save();
            var s = this._preProcess(t), e = s.width, i = s.height;
            QR.api.draw(t.content, this.ctx, -e / 2, -i / 2, e, i, t.css.background, t.css.color), 
            this.ctx.restore(), this._doBorder(t, e, i);
        }
    }, {
        key: "_drawAbsImage",
        value: function(t) {
            if (t.url) {
                this.ctx.save();
                var s = this._preProcess(t), e = s.width, i = s.height, r = void 0, h = void 0, c = 0, a = 0;
                i < e ? (h = Math.round(t.sWidth / e * i), r = t.sWidth) : (r = Math.round(t.sHeight / i * e), 
                h = t.sHeight), t.sWidth > r && (c = Math.round((t.sWidth - r) / 2)), t.sHeight > h && (a = Math.round((t.sHeight - h) / 2)), 
                "aspectFit" === t.css.mode ? this.ctx.drawImage(t.url, -e / 2, -i / 2, e, i) : this.ctx.drawImage(t.url, c, a, r, h, -e / 2, -i / 2, e, i), 
                this.ctx.restore(), this._doBorder(t, e, i);
            }
        }
    }, {
        key: "_fillAbsText",
        value: function(t) {
            if (t.text) {
                this.ctx.save();
                var s = this._preProcess(t), e = s.width, i = s.height, r = s.extra;
                this.ctx.setFillStyle(t.css.color || "black");
                for (var h = r.lines, c = r.lineHeight, a = Math.round(t.text.length / h), o = 0, l = 0, n = 0; n < h; ++n) {
                    l = a;
                    for (var x = t.text.substr(o, l), d = this.ctx.measureText(x).width; o + l <= t.text.length && (e - d > t.css.fontSize.toPx() || e < d); ) {
                        if (d < e) x = t.text.substr(o, ++l); else {
                            if (x.length <= 1) break;
                            x = t.text.substr(o, --l);
                        }
                        d = this.ctx.measureText(x).width;
                    }
                    if (o += x.length, n === h - 1 && o < t.text.length) {
                        for (;this.ctx.measureText(x + "...").width > e && !(x.length <= 1); ) x = x.substring(0, x.length - 1);
                        x += "...", d = this.ctx.measureText(x).width;
                    }
                    this.ctx.setTextAlign(t.css.align ? t.css.align : "left");
                    var u = void 0;
                    switch (t.css.align) {
                      case "center":
                        u = 0;
                        break;

                      case "right":
                        u = e / 2;
                        break;

                      default:
                        u = -e / 2;
                    }
                    var f = -i / 2 + (0 === n ? t.css.fontSize.toPx() : t.css.fontSize.toPx() + n * c);
                    "stroke" === t.css.textStyle ? this.ctx.strokeText(x, u, f, d) : this.ctx.fillText(x, u, f, d);
                    var g = t.css.fontSize.toPx();
                    t.css.textDecoration && (this.ctx.beginPath(), /\bunderline\b/.test(t.css.textDecoration) && (this.ctx.moveTo(u, f), 
                    this.ctx.lineTo(u + d, f)), /\boverline\b/.test(t.css.textDecoration) && (this.ctx.moveTo(u, f - g), 
                    this.ctx.lineTo(u + d, f - g)), /\bline-through\b/.test(t.css.textDecoration) && (this.ctx.moveTo(u, f - g / 3), 
                    this.ctx.lineTo(u + d, f - g / 3)), this.ctx.closePath(), this.ctx.setStrokeStyle(t.css.color), 
                    this.ctx.stroke());
                }
                this.ctx.restore(), this._doBorder(t, e, i);
            }
        }
    }, {
        key: "_drawAbsRect",
        value: function(t) {
            this.ctx.save();
            var s = this._preProcess(t), e = s.width, i = s.height;
            this.ctx.setFillStyle(t.css.color), this.ctx.fillRect(-e / 2, -i / 2, e, i), this.ctx.restore(), 
            this._doBorder(t, e, i);
        }
    }, {
        key: "_getAngle",
        value: function(t) {
            return Number(t) * Math.PI / 180;
        }
    } ]), e;
}();

exports.default = Painter;