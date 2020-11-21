var formatTime = function(e) {
    var t = e.getFullYear(), r = e.getMonth() + 1, m = e.getDate(), o = e.getHours(), u = e.getMinutes(), a = e.getSeconds();
    return [ t, r, m ].map(formatNumber).join("/") + " " + [ o, u, a ].map(formatNumber).join(":");
};

function formatTimeTwo(e, t) {
    var r = [ "Y", "M", "D", "h", "m", "s" ], m = [], o = new Date(1e3 * e);
    for (var u in m.push(o.getFullYear()), m.push(formatNumber(o.getMonth() + 1)), m.push(formatNumber(o.getDate())), 
    m.push(formatNumber(o.getHours())), m.push(formatNumber(o.getMinutes())), m.push(formatNumber(o.getSeconds())), 
    m) t = t.replace(r[u], m[u]);
    return t;
}

var formatNumber = function(e) {
    return (e = e.toString())[1] ? e : "0" + e;
};

module.exports = {
    formatTime: formatTime,
    formatTimeTwo: formatTimeTwo
};