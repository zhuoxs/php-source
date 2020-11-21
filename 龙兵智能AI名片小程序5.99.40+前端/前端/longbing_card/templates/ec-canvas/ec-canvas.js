var _wxCanvas = require("./wx-canvas"), _wxCanvas2 = _interopRequireDefault(_wxCanvas), _echarts = require("./echarts"), echarts = _interopRequireWildcard(_echarts);

function _interopRequireWildcard(t) {
    if (t && t.__esModule) return t;
    var a = {};
    if (null != t) for (var e in t) Object.prototype.hasOwnProperty.call(t, e) && (a[e] = t[e]);
    return a.default = t, a;
}

function _interopRequireDefault(t) {
    return t && t.__esModule ? t : {
        default: t
    };
}

var ctx = void 0;

Component({
    properties: {
        canvasId: {
            type: String,
            value: "ec-canvas"
        },
        ec: {
            type: Object
        }
    },
    data: {},
    ready: function() {
        this.data.ec ? this.data.ec.lazyLoad || this.init() : console.warn('组件需绑定 ec 变量，例：<ec-canvas id="mychart-dom-bar" canvas-id="mychart-bar" ec="{{ ec }}"></ec-canvas>');
    },
    methods: {
        init: function(a) {
            var e = this, t = wx.version.version.split(".").map(function(t) {
                return parseInt(t, 10);
            });
            if (1 < t[0] || 1 === t[0] && 9 < t[1] || 1 === t[0] && 9 === t[1] && 91 <= t[2]) {
                ctx = wx.createCanvasContext(this.data.canvasId, this);
                var r = new _wxCanvas2.default(ctx, this.data.canvasId);
                echarts.setCanvasCreator(function() {
                    return r;
                }), wx.createSelectorQuery().in(this).select(".ec-canvas").boundingClientRect(function(t) {
                    "function" == typeof a ? e.chart = a(r, t.width, t.height) : e.data.ec && e.data.ec.onInit && (e.chart = e.data.ec.onInit(r, t.width, t.height));
                }).exec();
            } else console.error("微信基础库版本过低，需大于等于 1.9.91。参见：https://github.com/ecomfe/echarts-for-weixin#%E5%BE%AE%E4%BF%A1%E7%89%88%E6%9C%AC%E8%A6%81%E6%B1%82");
        },
        canvasToTempFilePath: function(t) {
            var a = this;
            t.canvasId || (t.canvasId = this.data.canvasId), ctx.draw(!0, function() {
                wx.canvasToTempFilePath(t, a);
            });
        },
        touchStart: function(t) {
            if (this.chart && 0 < t.touches.length) {
                var a = t.touches[0];
                this.chart._zr.handler.dispatch("mousedown", {
                    zrX: a.x,
                    zrY: a.y
                }), this.chart._zr.handler.dispatch("mousemove", {
                    zrX: a.x,
                    zrY: a.y
                });
            }
        },
        touchMove: function(t) {
            if (this.chart && 0 < t.touches.length) {
                var a = t.touches[0];
                this.chart._zr.handler.dispatch("mousemove", {
                    zrX: a.x,
                    zrY: a.y
                });
            }
        },
        touchEnd: function(t) {
            if (this.chart) {
                var a = t.changedTouches ? t.changedTouches[0] : {};
                this.chart._zr.handler.dispatch("mouseup", {
                    zrX: a.x,
                    zrY: a.y
                }), this.chart._zr.handler.dispatch("click", {
                    zrX: a.x,
                    zrY: a.y
                });
            }
        }
    }
});