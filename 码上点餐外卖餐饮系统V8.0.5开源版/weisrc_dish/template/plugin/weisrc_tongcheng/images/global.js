$.fn.scrollTo = function(l) {
    var t = {
        direct: "top",
        to: 0,
        durTime: 500,
        delay: 30,
        callback: null
    },
    o = $.extend(t, l),
    r = this,
    c = "top" == o.direct ? r.scrollTop() : r.scrollLeft(),
    e = o.to - c,
    a = 0,
    n = Math.round(o.durTime / o.delay),
    d = function(l) {
        a++;
        var t = Math.round(e / n);
        return a >= n ? ("top" == o.direct ? r.scrollTop(l) : r.scrollLeft(l), clearInterval(i), void(o.callback && o.callback())) : void("top" == o.direct ? r.scrollTop(c + a * t) : r.scrollLeft(c + a * t))
    },
    i = setInterval(function() {
        d(o.to)
    },
    o.delay);
    return r
};