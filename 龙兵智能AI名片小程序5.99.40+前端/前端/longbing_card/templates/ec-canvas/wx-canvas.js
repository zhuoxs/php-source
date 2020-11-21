Object.defineProperty(exports, "__esModule", {
    value: !0
});

var _createClass = function() {
    function a(e, t) {
        for (var n = 0; n < t.length; n++) {
            var a = t[n];
            a.enumerable = a.enumerable || !1, a.configurable = !0, "value" in a && (a.writable = !0), 
            Object.defineProperty(e, a.key, a);
        }
    }
    return function(e, t, n) {
        return t && a(e.prototype, t), n && a(e, n), e;
    };
}();

function _classCallCheck(e, t) {
    if (!(e instanceof t)) throw new TypeError("Cannot call a class as a function");
}

var WxCanvas = function() {
    function n(e, t) {
        _classCallCheck(this, n), this.ctx = e, this.canvasId = t, this.chart = null, this._initStyle(e), 
        this._initEvent();
    }
    return _createClass(n, [ {
        key: "getContext",
        value: function(e) {
            if ("2d" === e) return this.ctx;
        }
    }, {
        key: "setChart",
        value: function(e) {
            this.chart = e;
        }
    }, {
        key: "attachEvent",
        value: function() {}
    }, {
        key: "detachEvent",
        value: function() {}
    }, {
        key: "_initCanvas",
        value: function(e, n) {
            e.util.getContext = function() {
                return n;
            }, e.util.$override("measureText", function(e, t) {
                return n.font = t || "12px sans-serif", n.measureText(e);
            });
        }
    }, {
        key: "_initStyle",
        value: function(n) {
            var e = arguments;
            [ "fillStyle", "strokeStyle", "globalAlpha", "textAlign", "textBaseAlign", "shadow", "lineWidth", "lineCap", "lineJoin", "lineDash", "miterLimit", "fontSize" ].forEach(function(t) {
                Object.defineProperty(n, t, {
                    set: function(e) {
                        ("fillStyle" !== t && "strokeStyle" !== t || "none" !== e && null !== e) && n["set" + t.charAt(0).toUpperCase() + t.slice(1)](e);
                    }
                });
            }), n.createRadialGradient = function() {
                return n.createCircularGradient(e);
            };
        }
    }, {
        key: "_initEvent",
        value: function() {
            var a = this;
            this.event = {};
            [ {
                wxName: "touchStart",
                ecName: "mousedown"
            }, {
                wxName: "touchMove",
                ecName: "mousemove"
            }, {
                wxName: "touchEnd",
                ecName: "mouseup"
            }, {
                wxName: "touchEnd",
                ecName: "click"
            } ].forEach(function(n) {
                a.event[n.wxName] = function(e) {
                    var t = e.touches[0];
                    a.chart._zr.handler.dispatch(n.ecName, {
                        zrX: "tap" === n.wxName ? t.clientX : t.x,
                        zrY: "tap" === n.wxName ? t.clientY : t.y
                    });
                };
            });
        }
    } ]), n;
}();

exports.default = WxCanvas;