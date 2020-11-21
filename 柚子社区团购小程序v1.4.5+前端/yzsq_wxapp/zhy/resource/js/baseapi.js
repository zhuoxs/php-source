var util = require("kxutil.js"), md5 = require("../../../we7/js/md5.js"), api = {
    promiseAist: {},
    getPromise: function(t, e) {
        var s = this, i = md5(e);
        if (s.promiseAist[i]) return s.promiseAist[i];
        var n = new Promise(t);
        return s.promiseAist[i] = n.then(function(t) {
            return delete s.promiseAist[i], Promise.resolve(t);
        }).catch(function(t) {
            return delete s.promiseAist[i], Promise.reject(t);
        }), s.promiseAist[i];
    },
    myRequest: function(t, e, s, o, r) {
        return s || (s = {}), s.m || (s.m = "sqtg_sun"), this.getPromise(function(i, n) {
            util.request({
                url: "entry/wxapp/" + t,
                data: s,
                method: e,
                fromcache: r,
                cachetime: o,
                showLoading: !1,
                success: function(t) {
                    if (200 == t.statusCode) {
                        if (!t.data.code) {
                            var e = {
                                data: t.data.data
                            };
                            t.data.other && (e.other = t.data.other), t.data.msg && (e.msg = t.data.msg), i(e);
                        }
                        n(t.data);
                    } else {
                        var s = {
                            code: -1,
                            msg: "状态：" + t.statusCode
                        };
                        n(s);
                    }
                },
                fail: function(t) {
                    if (console.log("shibaile"), "request:fail " === t.errMsg) {
                        n({
                            code: -1,
                            msg: "网络环境差，请稍后重试！"
                        });
                    }
                    n(t.data);
                }
            });
        }, t);
    },
    get: function(t, e) {
        var s = 2 < arguments.length && void 0 !== arguments[2] ? arguments[2] : 0, i = !(3 < arguments.length && void 0 !== arguments[3]) || arguments[3];
        return this.myRequest(t, "GET", e, s, i);
    },
    post: function(t, e) {
        var s = 2 < arguments.length && void 0 !== arguments[2] ? arguments[2] : 0, i = !(3 < arguments.length && void 0 !== arguments[3]) || arguments[3];
        return this.myRequest(t, "POST", e, s, i);
    },
    getSetting: function() {
        return this.post("Csystem|suspensionIcon");
    }
};

api.getSetting = function() {
    return this.post("Csystem|suspensionIcon");
}, api.getCshopGetShops = function(t) {
    return this.post("Cshop|getShops", t, 0, !1);
}, api.getIndexGetpluginkey = function(t) {
    return this.post("Index|getpluginkey");
}, api.getCcommentBaseCommentList = function(t) {
    return this.post("Ccomment|baseCommentList", t, 0, !1);
}, api.getCartCount = function(t) {
    return this.post("Ccart|getCarts", t, 0, !1).then(function(t) {
        var e = 0;
        return t.data.forEach(function(t) {
            e += t.num;
        }), Promise.resolve(e);
    });
}, module.exports = api;