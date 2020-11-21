var func = {
    decodeScene: function(e) {
        if (e.scene) for (var n = e, o = decodeURIComponent(e.scene).split("&"), r = 0; r < o.length; r++) {
            var t = o[r].split("=");
            n[t[0]] = t[1];
        } else n = e;
        return n;
    },
    gotoUrl: function(e, n, o, r, t) {
        1 == r ? (wx, wx.redirectTo({
            url: "/" + o
        })) : wx.navigateTo({
            url: "/" + o
        });
    }
};

module.exports = func;