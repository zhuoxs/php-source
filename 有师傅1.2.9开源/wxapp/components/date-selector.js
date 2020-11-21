Component({
    properties: {
        beginTime: {
            type: Array,
            value: [ 1949, 10, 1, 0 ]
        },
        endTime: {
            type: Array,
            value: []
        },
        defSelectTime: {
            type: Array,
            value: [ 1990, 6, 16, 0 ]
        },
        selectTime: {
            type: null,
            value: [ 1990, 6, 16, 0 ],
            observer: function() {
                this.init();
            }
        },
        isUnclear: {
            type: Boolean,
            value: !0
        },
        color: {
            type: Array,
            value: [ "#eee", "#333" ]
        }
    },
    data: {
        dateIndex: [ 1, 1, 1, 1 ],
        date: [],
        recentTime: [ 1990, 6, 16, 0 ],
        placeholderShow: !0,
        placeholder: "公历年月日小时",
        bMillisecond: 0,
        eMillisecond: 0
    },
    methods: {
        bindDateChange: function(e) {
            for (var t = [ 0, 0, !0, e.detail.value ], a = t[0], i = t[1], n = t[2], r = t[3], c = 0; c < this.data.dateIndex.length; c++) if (this.data.dateIndex[c] != r[c]) {
                a = c, i = r[c], n = !1;
                break;
            }
            if (n) {
                var d = this.data.recentTime;
                this.setData({
                    recentTime: d,
                    placeholderShow: !1
                }), this.triggerEvent("datechange", d);
            } else this.update(a, i);
        },
        bindDateColumnChange: function(e) {
            this.update(e.detail.column, e.detail.value);
        },
        update: function(e, t) {
            var a = this.data.beginTime, i = this.data.endTime, n = this.data.recentTime, r = t - this.data.dateIndex[e];
            n[e] = n[e] + r;
            var c = this.changMillisecond(n);
            c < this.data.bMillisecond && (n = a.concat()), c > this.data.eMillisecond && (n = i.concat()), 
            this.data.isUnclear && 3 == e && 0 == t && (n[e] = -1);
            var d = this.makeDate(n);
            this.setData({
                date: d.date,
                dateIndex: d.dateIndex,
                recentTime: n,
                placeholderShow: !1
            }), this.triggerEvent("datechange", n);
        },
        buildArr: function(e, t, a, i) {
            for (var n = [], r = Math.max(e, t), c = Math.min(e, t); c <= r; c++) n.push(c + a);
            return i && n.unshift("不清楚"), n;
        },
        loop: function(e, t, a) {
            for (var i = e; i < t && !a(i); i++) ;
        },
        checkTimeArr: function(e, t, a) {
            var i = !0;
            return this.loop(0, a, function(a) {
                e[a] != t[a] && (i = !1);
            }), i;
        },
        checkRang: function(e, t, a) {
            return e <= a && t >= a ? a : a - e < a - t ? e : t;
        },
        makeDate: function(e) {
            var t = [], a = (new Date(), this), i = this.data.beginTime, e = e || this.data.recentTime, n = this.data.endTime, r = [];
            return this.loop(0, i.length, function(c) {
                var d = 0, h = 0;
                switch (c) {
                  case 0:
                    t.push(a.buildArr(i[c], n[c], "年")), r[c] = e[c] - i[c];
                    break;

                  case 1:
                    d = a.checkTimeArr(i, e, 1) ? i[c] : 1, h = a.checkTimeArr(n, e, 1) ? n[c] : 12, 
                    r[c] = a.checkTimeArr(i, e, 1) ? e[c] - i[c] : e[c] - 1, t.push(a.buildArr(d, h, "月"));
                    break;

                  case 2:
                    d = a.checkTimeArr(i, e, 2) ? i[c] : 1, h = a.checkTimeArr(n, e, 2) ? n[c] : new Date(e[0], e[1], 0).getDate(), 
                    r[c] = a.checkTimeArr(i, e, 2) ? e[c] - i[c] : e[c] - 1, t.push(a.buildArr(d, h, "日"));
                    break;

                  case 3:
                    d = a.checkTimeArr(i, e, 3) ? i[c] : 0, h = a.checkTimeArr(n, e, 3) ? n[c] : 23, 
                    r[c] = a.checkTimeArr(i, e, 3) ? e[c] - i[c] : e[c], a.data.isUnclear && (r[c] += 1, 
                    r[c] = r[c] <= -1 ? 0 : r[c]), t.push(a.buildArr(d, h, "时", a.data.isUnclear));
                    break;

                  case 4:
                    d = a.checkTimeArr(i, e, 4) ? i[c] : 0, h = a.checkTimeArr(n, e, 4) ? n[c] : 59, 
                    r[c] = a.checkTimeArr(i, e, 4) ? e[c] - i[c] : e[c], t.push(a.buildArr(d, h, "分"));
                    break;

                  case 5:
                    d = a.checkTimeArr(i, e, 5) ? i[c] : 0, h = a.checkTimeArr(n, e, 5) ? n[c] : 59, 
                    r[c] = a.checkTimeArr(i, e, 5) ? e[c] - i[c] : e[c], t.push(a.buildArr(d, h, "秒"));
                }
            }), {
                date: t,
                dateIndex: r,
                recentTime: e
            };
        },
        changMillisecond: function(e) {
            for (var t = e.concat(), a = 0; a < 6; a++) e[a] ? t[a] = e[a] : t[a] = 0;
            return new Date(t[0], t[1] - 1, t[2], t[3], t[4], t[5]).getTime();
        },
        init: function() {
            var e, t = this.data.endTime, a = this.data.placeholder, i = this.data.placeholderShow;
            if ("string" == typeof this.data.selectTime ? (e = this.data.defSelectTime.concat(), 
            a = this.data.selectTime) : (e = this.data.selectTime.concat(), i = !1), t.length <= 0) {
                var n = new Date();
                t = [ n.getFullYear(), n.getMonth() + 1, n.getDate(), n.getHours() ];
            }
            this.setData({
                recentTime: e,
                endTime: t,
                placeholder: a,
                placeholderShow: i
            });
            var r = this.makeDate(e);
            this.setData({
                date: r.date,
                dateIndex: r.dateIndex,
                recentTime: r.recentTime,
                bMillisecond: this.changMillisecond(this.data.beginTime),
                eMillisecond: this.changMillisecond(this.data.endTime)
            });
        }
    },
    onShow: function() {
        console.log("show");
    },
    created: function() {},
    attached: function() {
        this.init();
    },
    ready: function() {},
    moved: function() {},
    detached: function() {}
});