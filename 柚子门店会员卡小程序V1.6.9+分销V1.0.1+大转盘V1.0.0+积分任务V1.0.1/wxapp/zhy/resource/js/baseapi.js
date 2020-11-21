var util = require("kxutil.js"), md5 = require("../../../we7/js/md5.js"), api = {
    promiseAist: {},
    getPromise: function(e, t) {
        var s = this, i = md5(t);
        if (s.promiseAist[i]) return s.promiseAist[i];
        var r = new Promise(e);
        return s.promiseAist[i] = r.then(function(e) {
            return delete s.promiseAist[i], Promise.resolve(e);
        }).catch(function(e) {
            return delete s.promiseAist[i], Promise.reject(e);
        }), s.promiseAist[i];
    },
    myRequest: function(e, t, s, o, a) {
        return s || (s = {}), s.m || (s.m = "cysc_sun"), this.getPromise(function(i, r) {
            util.request({
                url: "entry/wxapp/" + e,
                data: s,
                method: t,
                fromcache: a,
                cachetime: o,
                showLoading: !1,
                success: function(e) {
                    if (200 == e.statusCode) {
                        if (!e.data.code) {
                            var t = {
                                data: e.data.data
                            };
                            e.data.other && (t.other = e.data.other), e.data.msg && (t.msg = e.data.msg), i(t);
                        }
                        r(e.data);
                    } else {
                        var s = {
                            code: -1,
                            msg: "状态：" + e.statusCode
                        };
                        r(s);
                    }
                },
                fail: function(e) {
                    if (console.log("shibaile"), "request:fail " === e.errMsg) {
                        r({
                            code: -1,
                            msg: "网络环境差，请稍后重试！"
                        });
                    }
                    r(e.data);
                }
            });
        }, e);
    },
    get: function(e, t) {
        var s = 2 < arguments.length && void 0 !== arguments[2] ? arguments[2] : 0, i = !(3 < arguments.length && void 0 !== arguments[3]) || arguments[3];
        return this.myRequest(e, "GET", t, s, i);
    },
    post: function(e, t) {
        var s = 2 < arguments.length && void 0 !== arguments[2] ? arguments[2] : 0, i = !(3 < arguments.length && void 0 !== arguments[3]) || arguments[3];
        return this.myRequest(e, "POST", t, s, i);
    }
};

module.exports = api;