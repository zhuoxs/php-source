var t = [ "周天", "周一", "周二", "周三", "周四", "周五", "周六" ], e = [ "10:00", "10:30", "11:00", "11:30", "12:00", "13:00", "13:30", "14:00", "14:30", "15:00", "15:30", "16:00", "16:30", "17:00", "17:30", "18:00", "18:30", "19:00", "19:30", "22:00", "20:30", "21:00", "21:30", "22:00" ], a = new Date();

a.setDate(a.getDate());

for (var g, r = [], D = [], o = 0; o < 7; o++) {
    var n = "", s = "";
    n = a.getMonth() + 1 < 10 ? "0" + (a.getMonth() + 1) : a.getMonth() + 1, s = a.getDate() < 10 ? "0" + a.getDate() : a.getDate(), 
    g = t[a.getDay()] + " " + n + "-" + s, r.push(g), a.setDate(a.getDate() + 1);
}

D[0] = r, D[1] = e;

module.exports = {
    formatTime: function(t) {
        return D;
    }
};