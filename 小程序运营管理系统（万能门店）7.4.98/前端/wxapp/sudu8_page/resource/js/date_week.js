function getDates(t) {
    for (var e = getCurrentMonthFirst(), a = [], r = 0; r < t; r++) {
        var n = dateLater(e, r);
        a.push(n);
    }
    return a;
}

function dateLater(t, e) {
    var a = {}, r = new Array("星期日", "星期一", "星期二", "星期三", "星期四", "星期五", "星期六"), n = new Date(t);
    n.setDate(n.getDate() + e);
    var g = n.getDay();
    return a.year = n.getFullYear(), a.month = n.getMonth() + 1 < 10 ? "0" + (n.getMonth() + 1) : n.getMonth() + 1, 
    a.day = n.getDate() < 10 ? "0" + n.getDate() : n.getDate(), a.week = r[g], a;
}

function getCurrentMonthFirst() {
    var t = new Date();
    return t.getFullYear() + "-" + (t.getMonth() + 1 < 10 ? "0" + (t.getMonth() + 1) : t.getMonth() + 1) + "-" + (t.getDate() < 10 ? "0" + t.getDate() : t.getDate());
}

function getLastDay(t, e) {
    var a = t, r = e++;
    12 < e && (r -= 12, a++);
    var n = new Date(a, r, 1);
    return new Date(n.getTime() - 864e5).getDate();
}

module.exports = {
    getDates: getDates,
    dateLater: dateLater,
    getLastDay: getLastDay
};