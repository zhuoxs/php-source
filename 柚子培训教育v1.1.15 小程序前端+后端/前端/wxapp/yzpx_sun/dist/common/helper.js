function extractComponentId() {
    return ((0 < arguments.length && void 0 !== arguments[0] ? arguments[0] : {}).currentTarget || {}).dataset.componentId;
}

var LIFE_CYCLE = [ "onLoad", "onReady", "onShow", "onHide", "onUnload", "onPullDownRefresh", "onReachBottom", "onShareAppMessage", "onPageScroll" ], extendCreator = function() {
    var e = 0 < arguments.length && void 0 !== arguments[0] ? arguments[0] : {}, n = e.life, r = void 0 === n ? LIFE_CYCLE : n, t = e.exclude, o = void 0 === t ? [] : t, i = o.concat(LIFE_CYCLE.map(getFuncArrayName));
    if (!Array.isArray(r) || !Array.isArray(o)) throw new Error("Invalid Extend Config");
    var c = r.filter(function(e) {
        return 0 <= LIFE_CYCLE.indexOf(e);
    });
    return function(a) {
        for (var e = arguments.length, n = Array(1 < e ? e - 1 : 0), r = 1; r < e; r++) n[r - 1] = arguments[r];
        return n.forEach(function(t) {
            t && Object.keys(t).forEach(function(e) {
                var n = t[e];
                if (!(0 <= i.indexOf(e))) if (0 <= c.indexOf(e) && "function" == typeof n) {
                    var r, o = getFuncArrayName(e);
                    if (a[o] || (a[o] = [], a[e] && a[o].push(a[e]), a[e] = function() {
                        for (var n = this, e = arguments.length, r = Array(e), t = 0; t < e; t++) r[t] = arguments[t];
                        a[o].forEach(function(e) {
                            return e.apply(n, r);
                        });
                    }), t[o]) (r = a[o]).push.apply(r, t[o]); else a[o].push(n);
                } else a[e] = n;
            });
        }), a;
    };
}, getFuncArrayName = function(e) {
    return "__$" + e;
};

module.exports = {
    extractComponentId: extractComponentId,
    extend: Object.assign,
    extendCreator: extendCreator
};