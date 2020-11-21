var countDown = function o(t, r) {
    var e = Date.parse(new Date()), n = r - e, u = [];
    return u = date_format(n), n <= 0 && (u = ""), setTimeout(function() {
        n -= 100, o(t, r);
    }, 1e3), u;
};

function date_format(o) {
    var t = [], r = Math.floor(o / 1e3), e = Math.floor(r / 3600 / 24), n = Math.floor((r - 60 * e * 60 * 24) / 3600), u = Math.floor(r / 3600), f = fill_zero_prefix(Math.floor((r - 3600 * u) / 60)), a = fill_zero_prefix(r - 3600 * u - 60 * f);
    return t.push(e), t.push(n), t.push(u), t.push(f), t.push(a), t;
}

function fill_zero_prefix(o) {
    return o < 10 ? "0" + o : o;
}

module.exports = {
    countDown: countDown
};