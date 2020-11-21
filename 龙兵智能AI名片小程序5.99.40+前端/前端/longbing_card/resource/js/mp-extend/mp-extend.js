function _toConsumableArray(r) {
    if (Array.isArray(r)) {
        for (var e = 0, t = Array(r.length); e < r.length; e++) t[e] = r[e];
        return t;
    }
    return Array.from(r);
}

Object.defineProperty(exports, "__esModule", {
    value: !0
});

var life = {
    App: [ "preproccess", "onLaunch", "onShow", "onHide", "onError" ],
    Page: [ "preproccess", "onLoad", "onReady", "onShow", "onHide", "onUnload", "onReachBottom" ],
    Component: [ "preproccess", "created", "attached", "ready", "moved", "detached", "error" ]
}, lifeMixin = {};

for (var key in life) {
    lifeMixin[key] = lifeMixin[key] || {};
    var _iteratorNormalCompletion = !0, _didIteratorError = !1, _iteratorError = void 0;
    try {
        for (var _step, _iterator = life[key][Symbol.iterator](); !(_iteratorNormalCompletion = (_step = _iterator.next()).done); _iteratorNormalCompletion = !0) {
            var lifeTime = _step.value;
            lifeMixin[key][lifeTime] = [];
        }
    } catch (r) {
        _didIteratorError = !0, _iteratorError = r;
    } finally {
        try {
            !_iteratorNormalCompletion && _iterator.return && _iterator.return();
        } finally {
            if (_didIteratorError) throw _iteratorError;
        }
    }
}

var base = {
    App: {},
    Page: {},
    Component: {}
}, MpExtend = function e(r) {
    if (isArray(r)) r.forEach(function(r) {
        return e(r);
    }); else for (var t in r) if (life[t]) {
        var o = Object.assign({}, r[t]);
        for (var n in o) lifeMixin[t][n] && (lifeMixin[t][n].push(o[n]), delete o[n]);
        mixin(base[t], o);
    } else warning(t, "not found");
}, _App = decorate(App, function(r) {
    mixin(r, base.App);
    var e = !0, t = !1, o = void 0;
    try {
        for (var n, a = life.App[Symbol.iterator](); !(e = (n = a.next()).done); e = !0) {
            var i = n.value;
            r[i] = decorate.apply(void 0, [ r[i] ].concat(_toConsumableArray(lifeMixin.App[i])));
        }
    } catch (r) {
        t = !0, o = r;
    } finally {
        try {
            !e && a.return && a.return();
        } finally {
            if (t) throw o;
        }
    }
    r.preproccess && r.preproccess.call(r, r);
}), _Page = decorate(Page, function(r) {
    mixin(r, base.Page);
    var e = !0, t = !1, o = void 0;
    try {
        for (var n, a = life.Page[Symbol.iterator](); !(e = (n = a.next()).done); e = !0) {
            var i = n.value;
            r[i] = decorate.apply(void 0, [ r[i] ].concat(_toConsumableArray(lifeMixin.Page[i])));
        }
    } catch (r) {
        t = !0, o = r;
    } finally {
        try {
            !e && a.return && a.return();
        } finally {
            if (t) throw o;
        }
    }
    r.preproccess && r.preproccess.call(r, r);
}), _Component = decorate(Component, function(r) {
    mixin(r, base.Component);
    var e = !0, t = !1, o = void 0;
    try {
        for (var n, a = life.Component[Symbol.iterator](); !(e = (n = a.next()).done); e = !0) {
            var i = n.value;
            r[i] = decorate.apply(void 0, [ r[i] ].concat(_toConsumableArray(lifeMixin.Component[i])));
        }
    } catch (r) {
        t = !0, o = r;
    } finally {
        try {
            !e && a.return && a.return();
        } finally {
            if (t) throw o;
        }
    }
    r.preproccess && r.preproccess.call(r, r);
});

function decorate(i) {
    for (var r = arguments.length, l = Array(1 < r ? r - 1 : 0), e = 1; e < r; e++) l[e - 1] = arguments[e];
    return function() {
        var r = !0, e = !1, t = void 0;
        try {
            for (var o, n = l[Symbol.iterator](); !(r = (o = n.next()).done); r = !0) {
                var a = o.value;
                a && a.apply(this, arguments);
            }
        } catch (r) {
            e = !0, t = r;
        } finally {
            try {
                !r && n.return && n.return();
            } finally {
                if (e) throw t;
            }
        }
        return i && i.apply(this, arguments);
    };
}

function mixin(c) {
    for (var r = arguments.length, e = Array(1 < r ? r - 1 : 0), t = 1; t < r; t++) e[t - 1] = arguments[t];
    return e.forEach(function(r) {
        for (var e in r) isObject(c[e]) && isObject(r[e]) ? mixin(c[e], r[e]) : c[e] = c[e] || r[e];
        var t = !0, o = !1, n = void 0;
        try {
            for (var a, i = Object.getOwnPropertySymbols(r)[Symbol.iterator](); !(t = (a = i.next()).done); t = !0) {
                var l = a.value;
                c[l] = c[l] || r[l];
            }
        } catch (r) {
            o = !0, n = r;
        } finally {
            try {
                !t && i.return && i.return();
            } finally {
                if (o) throw n;
            }
        }
    }), c;
}

function isObject(r) {
    return "[object Object]" === Object.prototype.toString.call(r);
}

function isArray(r) {
    return "[object Array]" === Object.prototype.toString.call(r);
}

function warning() {
    for (var r, e = arguments.length, t = Array(e), o = 0; o < e; o++) t[o] = arguments[o];
    MpExtend.tips && (r = console).warn.apply(r, [ "mp-extend:" ].concat(t));
}

Object.assign(MpExtend, {
    mixin: mixin,
    decorate: decorate,
    Page: _Page,
    warning: warning,
    tips: !0
}), exports.default = MpExtend;