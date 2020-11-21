var app = getApp();

function request(t, e, a) {
    return a || (a = {}), a.m || (a.m = "yzzc_sun"), new Promise(function(e, n) {
        app.util.request({
            url: "entry/wxapp/" + t,
            data: a,
            success: function(t) {
                200 == t.statusCode ? 1 == t.data.code ? e(t.data.data) : n(t.data) : wx.showToast({
                    title: t.statusCode + ",技术人员正在赶来！",
                    icon: "none",
                    duration: 2e3
                });
            },
            fail: function(t) {
                "request:fail " === t.errMsg && wx.showToast({
                    title: "请求数据失败！请联系程序员",
                    icon: "none",
                    duration: 1e3
                }), n(t.data);
            }
        });
    });
}

function iget(t, e) {
    return request(t, "GET", e);
}

function ipost(t, e) {
    return request(t, "POST", e);
}

function alert(n) {
    var a = 1 < arguments.length && void 0 !== arguments[1] ? arguments[1] : "提示";
    return new Promise(function(t, e) {
        wx.showModal({
            title: a,
            content: n,
            cancel: !1,
            success: function() {
                t();
            },
            fail: function() {
                e();
            }
        });
    });
}

function toast(n) {
    return new Promise(function(t, e) {
        wx.showToast({
            title: n,
            success: function() {
                t();
            },
            fail: function(t) {
                e(t);
            }
        });
    });
}

function getFullDay(t) {
    var e = new Date(1e3 * t);
    return e.getFullYear() + "-" + (9 < e.getMonth() + 1 ? e.getMonth() + 1 : "0" + (e.getMonth() + 1)) + "-" + (9 < e.getDate() ? e.getDate() : "0" + e.getDate()) + " " + (9 < e.getHours() ? e.getHours() : "0" + e.getHours()) + ":" + (9 < e.getMinutes() ? e.getMinutes() : "0" + e.getMinutes());
}

function GetDistance(t, e, n, a) {
    var o = t * Math.PI / 180, s = n * Math.PI / 180, u = o - s, i = e * Math.PI / 180 - a * Math.PI / 180, r = 2 * Math.asin(Math.sqrt(Math.pow(Math.sin(u / 2), 2) + Math.cos(o) * Math.cos(s) * Math.pow(Math.sin(i / 2), 2)));
    return r *= 6378.137, r = (r = Math.round(1e4 * r) / 1e4).toFixed(2);
}

module.exports = {
    get: iget,
    post: ipost,
    alert: alert,
    toast: toast,
    getFullDay: getFullDay,
    GetDistance: GetDistance
};