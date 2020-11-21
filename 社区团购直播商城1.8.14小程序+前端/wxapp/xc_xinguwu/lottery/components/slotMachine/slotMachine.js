Object.defineProperty(exports, "__esModule", {
    value: !0
});

var _createClass = function() {
    function e(t, a) {
        for (var s = 0; s < a.length; s++) {
            var e = a[s];
            e.enumerable = e.enumerable || !1, e.configurable = !0, "value" in e && (e.writable = !0), 
            Object.defineProperty(t, e.key, e);
        }
    }
    return function(t, a, s) {
        return a && e(t.prototype, a), s && e(t, s), t;
    };
}();

function _classCallCheck(t, a) {
    if (!(t instanceof a)) throw new TypeError("Cannot call a class as a function");
}

var Machine = function() {
    function s(t, a) {
        _classCallCheck(this, s), this.page = t, this.height = a.height, this.len = a.len, 
        this.transY1 = a.transY1, this.num1 = a.num1, this.transY2 = a.transY2, this.num2 = a.num2, 
        this.transY3 = a.transY3, this.num3 = a.num3, this.transY4 = a.transY4, this.num4 = a.num4, 
        this.speed = a.speed, this.isStart = !1, this.endCallBack = a.callback, this.page.start = this.start.bind(this);
    }
    return _createClass(s, [ {
        key: "start",
        value: function() {
            var a = this, s = 0, t = this.isStart, e = this.len, i = this.height, n = this.transY1, r = this.transY2, h = this.transY3, u = this.transY4, l = this.speed, c = this.num1, o = this.num2, f = this.num3, m = this.num4, Y = this.endCallBack;
            if (!t) {
                this.isStart = !0;
                var b = i * e, M = Math.floor(2 * Math.random() + 2), v = l / 2, p = 0 == c ? 10 * i : c * i, d = 0 == o ? 10 * i : o * i, g = 0 == f ? 10 * i : f * i, C = 0 == m ? 10 * i : m * i, k = 1, y = 1, T = 1, _ = 1;
                this.timer = setInterval(function() {
                    if (k <= M) n -= l, Math.abs(n) > b && (n += b, k++); else if (M < k && k < M + 2) n -= v, 
                    Math.abs(n) > b && (n += b, k++); else {
                        if (n == p) return;
                        var t = (p + n) / v;
                        n -= t = v < t ? v : t < 1 ? 1 : t, n = Math.abs(n) > p ? n = -p : n;
                    }
                    a.timer1 = setTimeout(function() {
                        if (y <= M) r -= l, Math.abs(r) > b && (r += b, y++); else if (M < y && y < M + 2) r -= v, 
                        Math.abs(r) > b && (r += b, y++); else {
                            if (r == d) return;
                            var t = (d + r) / v;
                            r -= t = v < t ? v : t < 1 ? 1 : t, r = Math.abs(r) > d ? r = -d : r;
                        }
                    }, 200), a.timer2 = setTimeout(function() {
                        if (T <= M) h -= l, Math.abs(h) > b && (h += b, T++); else if (M < T && T < M + 2) h -= v, 
                        Math.abs(h) > b && (h += b, T++); else {
                            if (h == g) return;
                            var t = (g + h) / v;
                            h -= t = v < t ? v : t < 1 ? 1 : t, h = Math.abs(h) > g ? h = -g : h;
                        }
                    }, 400), a.timer3 = setTimeout(function() {
                        if (_ <= M) u -= l, Math.abs(u) > b && (u += b, _++); else if (M < _ && _ < M + 2) u -= v, 
                        Math.abs(u) > b && (u += b, _++); else {
                            var t = (C + u) / v;
                            u -= t = m < 3 ? v < t ? v : t < .1 ? .1 : t : v < t ? v : t < .3 ? .3 : t, u = Math.abs(u) > C ? u = -C : u, 
                            Math.abs(u) >= C && (clearInterval(a.timer), clearTimeout(a.timer1), clearTimeout(a.timer2), 
                            clearTimeout(a.timer3), a.isStart = !1, 37 == ++s && Y && Y());
                        }
                    }, 600), a.page.setData({
                        machine: {
                            transY1: n,
                            transY2: r,
                            transY3: h,
                            transY4: u
                        }
                    });
                }, 1e3 / 60);
            }
        }
    }, {
        key: "reset",
        value: function() {
            this.transY1 = 0, this.transY2 = 0, this.transY3 = 0, this.transY4 = 0, this.page.setData({
                machine: {
                    transY1: 0,
                    transY2: 0,
                    transY3: 0,
                    transY4: 0
                }
            });
        }
    } ]), s;
}();

exports.default = Machine;