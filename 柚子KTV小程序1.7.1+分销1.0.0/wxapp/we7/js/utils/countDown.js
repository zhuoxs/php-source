var countDown = function o(r, e) {
    var t = Date.parse(new Date()), f = e - t, i = [];
    return i = date_format(f), f <= 0 && (i = ""), setTimeout(function() {
        f -= 100, o(r, e);
    }, 1e3), i;
};

function date_format(o) {
    var r = [], e = Math.floor(o / 1e3), t = fill_zero_prefix(Math.floor(e / 3600 / 24)), f = fill_zero_prefix(Math.floor((e - 60 * t * 60 * 24) / 3600)), i = fill_zero_prefix(Math.floor(e / 3600)), l = fill_zero_prefix(Math.floor((e - 3600 * i) / 60)), n = fill_zero_prefix(e - 3600 * i - 60 * l);
    return r.push(t), r.push(f), r.push(i), r.push(l), r.push(n), r;
}

function fill_zero_prefix(o) {
    return o < 10 ? "0" + o : o;
}

module.exports = {
    countDown: countDown
};