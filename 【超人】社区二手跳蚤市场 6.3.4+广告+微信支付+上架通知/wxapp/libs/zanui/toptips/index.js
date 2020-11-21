var _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function(t) {
    return typeof t;
} : function(t) {
    return t && "function" == typeof Symbol && t.constructor === Symbol && t !== Symbol.prototype ? "symbol" : typeof t;
}, _extends = Object.assign || function(t) {
    for (var e = 1; e < arguments.length; e++) {
        var o = arguments[e];
        for (var r in o) Object.prototype.hasOwnProperty.call(o, r) && (t[r] = o[r]);
    }
    return t;
}, FONT_COLOR = "#fff", BG_COLOR = "#e64340";

function Toptips() {
    var t = 0 < arguments.length && void 0 !== arguments[0] ? arguments[0] : {}, e = getCurrentPages(), o = e[e.length - 1];
    t = Object.assign({
        selector: "#zan-toptips",
        duration: 3e3
    }, parseParam(t));
    var r = o.selectComponent(t.selector);
    delete t.selector, r.setData(_extends({}, t)), r && r.show();
}

function parseParam(t) {
    return "object" === (void 0 === t ? "undefined" : _typeof(t)) ? t : {
        content: t
    };
}

Component({
    properties: {
        content: String,
        color: {
            type: String,
            value: FONT_COLOR
        },
        backgroundColor: {
            type: String,
            value: BG_COLOR
        },
        isShow: {
            type: Boolean,
            value: !1
        },
        duration: {
            type: Number,
            value: 3e3
        }
    },
    methods: {
        show: function() {
            var t = this, e = this.data.duration;
            this._timer && clearTimeout(this._timer), this.setData({
                isShow: !0
            }), 0 < e && e !== 1 / 0 && (this._timer = setTimeout(function() {
                t.hide();
            }, e));
        },
        hide: function() {
            this._timer = clearTimeout(this._timer), this.setData({
                isShow: !1
            });
        }
    }
}), module.exports = Toptips;