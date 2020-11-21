function _toConsumableArray(r) {
    if (Array.isArray(r)) {
        for (var n = 0, e = Array(r.length); n < r.length; n++) e[n] = r[n];
        return e;
    }
    return Array.from(r);
}

function extractComponentId() {
    return ((0 < arguments.length && void 0 !== arguments[0] ? arguments[0] : {}).currentTarget || {}).dataset.componentId;
}

var LIFE_CYCLE = [ "onLoad", "onReady", "onShow", "onHide", "onUnload", "onPullDownRefresh", "onReachBottom", "onShareAppMessage", "onPageScroll" ], extendCreator = function() {
    var r = 0 < arguments.length && void 0 !== arguments[0] ? arguments[0] : {}, n = r.life, e = void 0 === n ? LIFE_CYCLE : n, t = r.exclude, o = void 0 === t ? [] : t, i = o.concat(LIFE_CYCLE.map(getFuncArrayName));
    if (!Array.isArray(e) || !Array.isArray(o)) throw new Error("Invalid Extend Config");
    var u = e.filter(function(r) {
        return 0 <= LIFE_CYCLE.indexOf(r);
    });
    return function(a) {
        for (var r = arguments.length, n = Array(1 < r ? r - 1 : 0), e = 1; e < r; e++) n[e - 1] = arguments[e];
        return n.forEach(function(t) {
            t && Object.keys(t).forEach(function(r) {
                var n = t[r];
                if (!(0 <= i.indexOf(r))) if (0 <= u.indexOf(r) && "function" == typeof n) {
                    var e, o = getFuncArrayName(r);
                    if (a[o] || (a[o] = [], a[r] && a[o].push(a[r]), a[r] = function() {
                        for (var n = this, r = arguments.length, e = Array(r), t = 0; t < r; t++) e[t] = arguments[t];
                        a[o].forEach(function(r) {
                            return r.apply(n, e);
                        });
                    }), t[o]) (e = a[o]).push.apply(e, _toConsumableArray(t[o])); else a[o].push(n);
                } else a[r] = n;
            });
        }), a;
    };
}, getFuncArrayName = function(r) {
    return "__$" + r;
};

module.exports = {
    extractComponentId: extractComponentId,
    extend: Object.assign,
    extendCreator: extendCreator
};