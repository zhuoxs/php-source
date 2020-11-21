var t = function(t) {
    return (t = t.toString())[1] ? t : "0" + t;
};

module.exports = {
    formatTime: function(o) {
        var r = o.getFullYear(), e = o.getMonth() + 1, n = o.getDate(), a = o.getHours(), l = o.getMinutes(), u = o.getSeconds();
        return [ r, e, n ].map(t).join("/") + " " + [ a, l, u ].map(t).join(":");
    },
    computeHeight: function(t, o, r) {
        for (var e = [], n = [], a = o.length, l = 0; l < a; l++) e[l] = !1, n[l] = Math.floor(l / 2) * (320 / 750) * 500;
        for (var u = 0; u < o.length; u++) u < r ? e[u] = !0 : n[u] < t.data.scrollTop && 0 == e[u] && (e[u] = !0);
        console.log(e), t.setData({
            arr: e,
            tarrHight: n
        });
    },
    returnTop: function() {
        wx.pageScrollTo({
            scrollTop: 0,
            duration: 0
        });
    }
};