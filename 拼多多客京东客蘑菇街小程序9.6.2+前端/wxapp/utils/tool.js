function throttle(l, e) {
    null != e && null != e || (e = 1500);
    var n = null;
    return function() {
        var t = +new Date();
        (e < t - n || !n) && (l(), n = t);
    };
}

module.exports = {
    throttle: throttle
};