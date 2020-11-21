function _defineProperty(t, e, i) {
    return e in t ? Object.defineProperty(t, e, {
        value: i,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : t[e] = i, t;
}

Object.defineProperty(exports, "__esModule", {
    value: !0
});

var _StyleHelper = require("../../libs/StyleHelper.js"), _StyleHelper2 = _interopRequireDefault(_StyleHelper), _WxHelper = require("../../libs/WxHelper.js"), _WxHelper2 = _interopRequireDefault(_WxHelper), _MultiHelper = require("../../libs/MultiHelper.js"), _MultiHelper2 = _interopRequireDefault(_MultiHelper);

function _interopRequireDefault(t) {
    return t && t.__esModule ? t : {
        default: t
    };
}

var ChildPath = "../tab/tab";

Component({
    properties: {
        index: {
            type: Number | String,
            value: 0,
            observer: function(t) {
                this.handleIndexChange(t, !0);
            }
        },
        probe: {
            type: Number | String,
            value: 0
        },
        width: {
            type: Number | String,
            value: wx.getSystemInfoSync().windowWidth
        },
        autoWidth: {
            type: Boolean,
            value: !0
        },
        inkBar: {
            type: Boolean
        },
        inkBarStyle: {
            type: String | Object
        },
        inkBarWrapperStyle: {
            type: String | Object
        },
        tabStyle: {
            type: Object | String
        },
        activeTabStyle: {
            type: Object | String
        }
    },
    data: {
        scrollTop: 0,
        scrollLeft: 0,
        children: [],
        rect: {},
        outerChange: !1,
        walkDistance: 0,
        walkCount: 0,
        selfStyle: "",
        selfProbe: 0,
        selfIndex: 0,
        selfInkBarStyle: "",
        inkBarWrapperStyle: ""
    },
    relations: _defineProperty({}, ChildPath, {
        type: "child"
    }),
    ready: function() {
        this.setData({
            selfIndex: Number(this.data.index),
            selfProbe: Number(this.data.probe),
            height: Number(this.data.height)
        }), this._init();
    },
    methods: {
        _init: function() {
            this._initRect(), this._initChildren(), this._initChildActive(), this._initSelfStyle(), 
            this.data.inkBar && this._initSelfInkBarStyle();
        },
        _initChildren: function() {
            var t = this.getRelationNodes(ChildPath);
            this.setData({
                children: t
            });
        },
        _initChildActive: function() {
            this.data.children[this.data.selfIndex].setData({
                active: !0
            });
        },
        _initRect: function() {
            var e = this;
            _WxHelper2.default.getComponentRect(this, ".ui-tabs").then(function(t) {
                e.setData({
                    rect: t
                });
            });
        },
        _initSelfStyle: function() {
            this.setData({
                selfStyle: _StyleHelper2.default.getPlainStyle({
                    width: this.data.width
                })
            });
        },
        _initSelfInkBarStyle: function() {
            this.setData({
                selfInkBarStyle: _StyleHelper2.default.getPlainStyle(this.data.inkBarStyle)
            });
        },
        handleIndexChange: function(t, e) {
            _MultiHelper2.default.updateChildActive(this, t);
            var i = Number(this.properties.probe);
            (0 === i || 1 === i && !e) && this.triggerEvent("change", {
                index: t
            }), this.setData({
                selfIndex: t
            }), this._setTabStyle();
            var a = this, l = setInterval(function() {
                1 < a.getRelationNodes(ChildPath).length && (clearInterval(l), a._autoCenterTab());
            }, 100);
            this.data.inkBar && this._setInkBarWrapperStyle();
        },
        _setTabStyle: function() {
            var t = this.data, e = t.children, a = t.selfIndex, i = t.tabStyle, l = t.activeTabStyle, n = t.autoWidth, r = _StyleHelper2.default.getPlainStyle(i), s = _StyleHelper2.default.getMergedPlainStyles([ i, l ]);
            e.forEach(function(t, e) {
                var i = e === a ? s : r;
                n && (i += ";width: " + t.data.width + "px"), t.setData({
                    selfStyle: i
                });
            });
        },
        _autoCenterTab: function() {
            var a = this, l = this.data.children[this.data.selfIndex];
            _WxHelper2.default.getScrollViewRect(this, ".ui-tabs").then(function(i) {
                _WxHelper2.default.getComponentRect(l, ".ui-tab").then(function(t) {
                    var e = t.left - (a.data.rect.width - l.data.width) / 2;
                    a.setData({
                        scrollLeft: e + i.scrollLeft
                    });
                });
            });
        },
        _setInkBarWrapperStyle: function() {
            for (var t = this.data, e = t.children, i = t.rect, a = 0, l = 0, n = 0; n < e.length; n++) {
                if (e[n].data.active) {
                    l = e[n].data.width;
                    break;
                }
                a += e[n].data.width;
            }
            this.setData({
                inkBarWrapperStyle: _StyleHelper2.default.getPlainStyle({
                    top: i.height - 2,
                    left: a,
                    width: l
                })
            });
        },
        _increaseWalkDistance: function(t) {
            var e = this;
            if (this.data.walkDistance += t.width, this.data.walkCount++, this.data.walkCount === this.data.children.length) {
                var i, a = this.data, l = a.walkDistance, n = a.walkCount, r = a.rect, s = a.tabStyle, h = a.activeTabStyle, d = a.children, u = a.selfIndex, o = {}, f = null;
                l < r.width && this.data.autoWidth && (o = {
                    width: f = r.width / n
                });
                var c = _StyleHelper2.default.getMergedPlainStyles([ s, o ]), p = _StyleHelper2.default.getMergedPlainStyles([ s, h, o ]);
                i = function() {
                    d.forEach(function(t, e) {
                        t.setData({
                            selfStyle: e === u ? p : c
                        }), f && t.setData({
                            width: f
                        });
                    });
                }, setTimeout(function() {
                    i(), e.data.inkBar && e._setInkBarWrapperStyle();
                });
            }
        }
    }
});