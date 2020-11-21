var formatTime = function(t) {
    var e = t.getFullYear(), r = t.getMonth() + 1, o = t.getDate(), m = t.getHours(), a = t.getMinutes(), n = t.getSeconds();
    return [ e, r, o ].map(formatNumber).join("/") + " " + [ m, a, n ].map(formatNumber).join(":");
}, formatNumber = function(t) {
    return (t = t.toString())[1] ? t : "0" + t;
};

module.exports = {
    formatTime: formatTime
};