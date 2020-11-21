var formatTime = function(e) {
    var t = e.getFullYear(), r = e.getMonth() + 1, a = e.getDate(), n = e.getHours(), o = e.getMinutes(), i = e.getSeconds();
    return [ t, r, a ].map(formatNumber).join("/") + " " + [ n, o, i ].map(formatNumber).join(":");
}, formatNumber = function(e) {
    return (e = e.toString())[1] ? e : "0" + e;
};

function js_date_time(e) {
    var t = new Date(1e3 * parseInt(e)), r = t.getFullYear(), a = t.getMonth() + 1, n = t.getDate();
    t.getHours(), t.getMinutes(), t.getSeconds();
    if (10 <= a) var o = a; else o = "0" + a;
    if (10 <= n) var i = n; else i = "0" + n;
    var m = new Date();
    Date.parse(m.toDateString());
    return r + "-" + o + "-" + i;
}

module.exports = {
    formatTime: formatTime,
    js_date_time: js_date_time
};