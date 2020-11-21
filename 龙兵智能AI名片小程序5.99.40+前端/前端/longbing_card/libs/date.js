function Dater(e, t, a) {
    var r, n = new Date(), o = (e = e || n.getFullYear(), t = t || n.getMonth() + 1, 
    a = a || n.getDate(), function(e, t, a) {
        return (a = new Date(e, t, a)).setDate(1), a.getDay();
    }), s = [ 31, (r = e, r % 4 == 0 && r % 100 != 0 || r % 400 == 0 ? 29 : 28), 31, 30, 31, 30, 31, 31, 30, 31, 30, 31 ], h = [], D = [], y = [], g = s[t - 1 - 1];
    if (0 === o(e, t - 1, a)) for (var l = 6; 0 <= l; l--) h[6 - l] = g - l; else for (l = o(e, t - 1, a); 0 < l; l--) h[o(e, t - 1, a) - l] = g - l + 1;
    for (l = 0; l < s[t - 1]; l++) D[l] = l + 1;
    var u = 42 - (h.length + s[t - 1]);
    for (l = 0; l < u; l++) y[l] = l + 1;
    if (isNaN(h[0])) for (var c = 0; c < h.length; c++) h[c] = 31 - h.length + c + 1;
    this.monthDays = {
        preMonthDays: h,
        thisMonthDays: D,
        nextMonthDays: y,
        day: a,
        month: t,
        year: e
    };
    var f = [];
    for (l = 0; l < 7; l++) {
        var i = new Date();
        i.setFullYear(e), i.setMonth(t - 1), i.setDate(a - 1);
        var d = i.getDay(), M = i.getDate() + 1 - d + l;
        i.setDate(M - 1), f.push({
            year: i.getFullYear(),
            month: i.getMonth() + 1,
            day: i.getDate() + 1
        });
    }
    this.weekDays = {
        data: f,
        day: a,
        month: t,
        year: e
    };
}

Object.defineProperty(exports, "__esModule", {
    value: !0
}), (exports.default = Dater).change = function(e, t, a) {
    var r = new Date();
    switch (r.setFullYear(e.year, e.month - 1, e.day), t) {
      case "y":
        r.setFullYear(r.getFullYear() + a);
        break;

      case "m":
        r.setMonth(r.getMonth() + a);
        break;

      case "w":
        r.setDate(r.getDate() + 7 * a);
        break;

      case "d":
        r.setDate(r.getDate() + a);
    }
    return {
        year: r.getFullYear(),
        month: r.getMonth() + 1,
        day: r.getDate()
    };
}, Dater.getTodayAnchor = function() {
    var e = new Date();
    return {
        year: e.getFullYear(),
        month: e.getMonth() + 1,
        day: e.getDate()
    };
}, Dater.AnchorToDayString = function(e) {
    return e.year + "/" + (e.month < 10 ? "0" : "") + e.month + "/" + (e.day < 10 ? "0" : "") + e.day;
};