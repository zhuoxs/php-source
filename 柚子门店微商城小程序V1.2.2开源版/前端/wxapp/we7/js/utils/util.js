var formatTime = function(t) {
    var e = t.getFullYear(), r = t.getMonth() + 1, a = t.getDate(), n = t.getHours(), o = t.getMinutes(), m = t.getSeconds();
    return [ e, r, a ].map(formatNumber).join("-") + " " + [ n, o, m ].map(formatNumber).join(":");
}, formatNumber = function(t) {
    return (t = t.toString())[1] ? t : "0" + t;
};

function js_date_time(t) {
    var e = new Date(1e3 * parseInt(t)), r = e.getFullYear(), a = e.getMonth() + 1, n = e.getDate(), o = e.getHours(), m = e.getMinutes(), u = (e.getSeconds(), 
    new Date());
    Date.parse(u.toDateString());
    return r + "-" + a + "-" + n + " " + o + ":" + m;
}

module.exports = {
    formatTime: formatTime,
    js_date_time: js_date_time
};