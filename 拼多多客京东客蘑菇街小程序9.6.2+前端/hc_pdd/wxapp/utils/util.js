var formatTime = function(t) {
    var e = t.getFullYear(), r = t.getMonth() + 1, o = t.getDate(), n = t.getHours(), u = t.getMinutes(), a = t.getSeconds();
    return [ e, r, o ].map(formatNumber).join("/") + " " + [ n, u, a ].map(formatNumber).join(":");
}, formatNumber = function(t) {
    return (t = t.toString())[1] ? t : "0" + t;
};

function throttle(e, r) {
    null != r && null != r || (r = 1500);
    var o = null;
    return function() {
        var t = +new Date();
        (r < t - o || !o) && (e.apply(this, arguments), o = t);
    };
}

module.exports = {
    formatTime: formatTime
}, module.exports = {
    throttle: throttle
};