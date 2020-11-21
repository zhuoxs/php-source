var formatTime = function(e) {
    var t = e.getFullYear(), r = e.getMonth() + 1, n = e.getDate(), o = e.getHours(), a = e.getMinutes(), i = e.getSeconds();
    return [ t, r, n ].map(formatNumber).join("/") + " " + [ o, a, i ].map(formatNumber).join(":");
}, formatNumber = function(e) {
    return (e = e.toString())[1] ? e : "0" + e;
}, inArray = function(e, t) {
    for (var r = 0; r < e.length; r++) if (e[r] == element) return r;
    return -1;
};

function getLocalTime(e) {
    var t = (e = new Date(parseInt(e))).getFullYear(), r = e.getMonth() + 1, n = e.getDate(), o = e.getHours(), a = e.getMinutes();
    e.getSeconds();
    return t + "-" + r + "-" + n + " " + o + ":" + a;
}

module.exports = {
    formatTime: formatTime,
    inArray: inArray,
    getLocalTime: getLocalTime
};