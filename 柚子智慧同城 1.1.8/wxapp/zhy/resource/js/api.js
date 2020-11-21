var e = Object.assign || function(e) {
    for (var t = 1; t < arguments.length; t++) {
        var i = arguments[t];
        for (var r in i) Object.prototype.hasOwnProperty.call(i, r) && (e[r] = i[r]);
    }
    return e;
}, t = require("./kxutil.js"), i = require("../../../we7/js/md5.js"), r = {};

r.promiseAist = {}, r.getPromise = function(e, t) {
    var r = this, s = i(t);
    if (r.promiseAist[s]) return r.promiseAist[s];
    var n = new Promise(e);
    return r.promiseAist[s] = n.then(function(e) {
        return delete r.promiseAist[s], Promise.resolve(e);
    }).catch(function(e) {
        return delete r.promiseAist[s], Promise.reject(e);
    }), r.promiseAist[s];
}, r.myRequest = function(e, i, r, s, n) {
    var o = this;
    return r || (r = {}), r.m || (r.m = "yztc_sun"), o.getPromise(function(o, a) {
        t.request({
            url: "entry/wxapp/" + e,
            data: r,
            method: i,
            fromcache: n,
            cachetime: s,
            showLoading: !1,
            success: function(e) {
                if (200 == e.statusCode) {
                    if (!e.data.code) {
                        var t = {
                            data: e.data.data
                        };
                        e.data.other && (t.other = e.data.other), e.data.msg && (t.msg = e.data.msg), o(t);
                    }
                    a(e.data);
                } else {
                    var i = {
                        code: -1,
                        msg: "状态：" + e.statusCode
                    };
                    a(i);
                }
            },
            fail: function(e) {
                "request:fail " === e.errMsg && a({
                    code: -1,
                    msg: "网络环境差，请稍后重试！"
                }), a(e.data);
            }
        });
    }, e);
}, r.get = function(e, t) {
    var i = arguments.length > 2 && void 0 !== arguments[2] ? arguments[2] : 0, r = !(arguments.length > 3 && void 0 !== arguments[3]) || arguments[3];
    return this.myRequest(e, "GET", t, i, r);
}, r.post = function(e, t) {
    var i = arguments.length > 2 && void 0 !== arguments[2] ? arguments[2] : 0, r = !(arguments.length > 3 && void 0 !== arguments[3]) || arguments[3];
    return this.myRequest(e, "POST", t, i, r);
}, r.apiWxGetopenid = function(e) {
    return this.post("Api_wx|getopenid", e, 0, !1);
}, r.apiUserLogin = function(e) {
    return this.post("Api_user|login", e, 0, !1);
}, r.apiUserMyInfo = function(e) {
    return this.post("Api_user|myInfo", e, 0, !1);
}, r.apiIndexNavIcon = function(e) {
    return this.post("Api_index|navIcon", e, 0, !1);
}, r.apiIndexSystemSet = function(e) {
    return this.post("Api_index|systemSet", e, 0, !1);
}, r.apiCommonGetNowTime = function(e) {
    return this.post("Api_common|getNowTime", e, 0, !1);
}, r.isMoney = function(e) {
    var t = getApp(), i = (e.trim() - 0).toFixed(2);
    return isNaN(i) ? (t.tips("请输入正确的金额！"), "") : i <= 0 ? "" : i;
};

var s = e({}, r, require("../../api/l"), require("../../api/s"), require("../../api/plugl"), require("../../api/plugs"));

module.exports = s;