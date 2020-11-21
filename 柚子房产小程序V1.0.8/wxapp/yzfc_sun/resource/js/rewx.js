var app = getApp();

function request(t, e, n) {
    return n || (n = {}), n.m || (n.m = "yzfc_sun"), new Promise(function(e, a) {
        app.util.request({
            url: "entry/wxapp/" + t,
            data: n,
            success: function(t) {
                200 == t.statusCode ? 1 == t.data.code ? e(t.data.data) : a(t.data) : wx.showToast({
                    title: t.statusCode + "。。。",
                    icon: "none",
                    duration: 2e3
                });
            },
            fail: function(t) {
                wx.showToast({
                    title: t.errMsg,
                    icon: "none",
                    duration: 1e3
                });
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

function getFullDay(t) {
    var e = new Date(1e3 * t);
    return e.getFullYear() + "-" + (9 < e.getMonth() + 1 ? e.getMonth() + 1 : "0" + (e.getMonth() + 1)) + "-" + (9 < e.getDate() ? e.getDate() : "0" + e.getDate()) + " " + (9 < e.getHours() ? e.getHours() : "0" + e.getHours()) + ":" + (9 < e.getMinutes() ? e.getMinutes() : "0" + e.getMinutes());
}

function getFullDate(t) {
    var e = new Date(1e3 * t);
    return e.getFullYear() + "-" + (9 < e.getMonth() + 1 ? e.getMonth() + 1 : "0" + (e.getMonth() + 1)) + "-" + (9 < e.getDate() ? e.getDate() : "0" + e.getDate());
}

function getFullTime(t) {
    var e = new Date(1e3 * t);
    return (9 < e.getHours() ? e.getHours() : "0" + e.getHours()) + ":" + (9 < e.getMinutes() ? e.getMinutes() : "0" + e.getMinutes());
}

function GetDistance(t, e, a, n) {
    var o = t * Math.PI / 180, r = a * Math.PI / 180, u = o - r, i = e * Math.PI / 180 - n * Math.PI / 180, s = 2 * Math.asin(Math.sqrt(Math.pow(Math.sin(u / 2), 2) + Math.cos(o) * Math.cos(r) * Math.pow(Math.sin(i / 2), 2)));
    return s *= 6378.137, s = (s = Math.round(1e4 * s) / 1e4).toFixed(2);
}

function getTimeStr(t) {
    return t = (t = t.replace(/-/g, ":").replace(" ", ":")).split(":"), new Date(t[0], t[1] - 1, t[2], t[3], t[4]).getTime() / 1e3;
}

var countDown = function(t, e) {
    clearInterval(s);
    var a = Math.floor(new Date().getTime() / 1e3 - 0);
    e -= 0;
    var n = Math.floor(e - a), o = 0, r = 0, u = 0, i = 0, s = (new Date(), setInterval(function() {
        if (--n <= 0) return t.setData({
            countTime: {
                D: 0,
                H: 0,
                M: 0,
                S: 0,
                over: 1
            }
        }), clearInterval(s), !1;
        o = Math.floor(n / 86400), r = Math.floor(n / 60 / 60 % 24), u = Math.floor(n / 60 % 60), 
        i = Math.floor(n % 60), r = 9 < r ? r : "0" + r, u = 9 < u ? u : "0" + u, i = 9 < i ? i : "0" + i, 
        t.setData({
            countTime: {
                D: o,
                H: r,
                M: u,
                S: i,
                over: 0
            }
        });
    }, 1e3));
};

module.exports = {
    get: iget,
    post: ipost,
    getFullDay: getFullDay,
    getFullDate: getFullDate,
    getFullTime: getFullTime,
    GetDistance: GetDistance,
    countDown: countDown,
    getTimeStr: getTimeStr
};