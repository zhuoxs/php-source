Object.defineProperty(exports, "__esModule", {
    value: !0
}), exports.formatTime = function(e) {
    var o = e.getFullYear(), r = e.getMonth() + 1, n = e.getDate(), a = e.getHours(), u = e.getMinutes(), i = e.getSeconds();
    return [ o, r, n ].map(t).join("/") + " " + [ a, u, i ].map(t).join(":");
};

var t = function(t) {
    var e = t.toString();
    return e[1] ? e : "0" + e;
};

exports.countDown = function(t) {
    var e = new Date(t).getTime(), o = Date.now(), r = Math.floor((e - o) / 1e3), n = r % 60, a = Math.floor(r / 60) % 60, u = Math.floor(r / 60 / 60) % 24, i = Math.floor(r / 60 / 60 / 24);
    return {
        sec: n = n < 10 ? "0" + n : n,
        min: a = a < 10 ? "0" + a : a,
        hour: u = u < 10 ? "0" + u : u,
        day: i
    };
};