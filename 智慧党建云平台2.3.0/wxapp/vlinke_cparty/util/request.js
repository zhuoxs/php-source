function e(e, a, n) {
    return n || (n = {}), n.m || (n.m = "vlinke_cparty"), new Promise(function(a, r) {
        t.util.request({
            url: "entry/wxapp/" + e,
            data: n,
            success: function(e) {
                0 == e.data.errno && a(e.data.data), r(e.data.message);
            },
            fail: function(e) {
                r(e.data && e.data.message ? e.data.message : e.errMsg);
            },
            complete: function() {}
        });
    });
}

Object.defineProperty(exports, "__esModule", {
    value: !0
});

var t = getApp();

exports.default = {
    get: function(t, a) {
        return e(t, "GET", a);
    },
    post: function(t, a) {
        return e(t, "POST", a);
    }
};