function e(e, t, n) {
    return t in e ? Object.defineProperty(e, t, {
        value: n,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : e[t] = n, e;
}

function t(e) {
    return (0, m.isDef)(e) && !isNaN(new Date(e).getTime());
}

function n(e, t, n) {
    return Math.min(Math.max(e, t), n);
}

function a(e) {
    return ("00" + e).slice(-2);
}

function u(e, t) {
    for (var n = -1, a = Array(e); ++n < e; ) a[n] = t(n);
    return a;
}

function i(e) {
    if (e) {
        for (;isNaN(parseInt(e, 10)); ) e = e.slice(1);
        return parseInt(e, 10);
    }
}

function r(e, t) {
    return 32 - new Date(e, t - 1, 32).getDate();
}

var o = require("../common/component"), m = require("../common/utils"), l = new Date().getFullYear();

(0, o.VantComponent)({
    props: {
        value: null,
        title: String,
        loading: Boolean,
        itemHeight: {
            type: Number,
            value: 44
        },
        visibleItemCount: {
            type: Number,
            value: 5
        },
        confirmButtonText: {
            type: String,
            value: "确认"
        },
        cancelButtonText: {
            type: String,
            value: "取消"
        },
        type: {
            type: String,
            value: "datetime"
        },
        showToolbar: {
            type: Boolean,
            value: !0
        },
        minDate: {
            type: Number,
            value: new Date(l - 10, 0, 1).getTime()
        },
        maxDate: {
            type: Number,
            value: new Date(l + 10, 11, 31).getTime()
        },
        minHour: {
            type: Number,
            value: 0
        },
        maxHour: {
            type: Number,
            value: 23
        },
        minMinute: {
            type: Number,
            value: 0
        },
        maxMinute: {
            type: Number,
            value: 59
        }
    },
    data: {
        innerValue: Date.now(),
        columns: []
    },
    watch: {
        value: function(e) {
            var t = this, n = this.data;
            (e = this.correctValue(e)) === n.innerValue || this.updateColumnValue(e).then(function() {
                t.$emit("input", e);
            });
        },
        type: "updateColumns",
        minHour: "updateColumns",
        maxHour: "updateColumns",
        minMinute: "updateColumns",
        maxMinute: "updateColumns"
    },
    methods: {
        getPicker: function() {
            if (null == this.picker) {
                var e = this.picker = this.selectComponent(".van-datetime-picker"), t = e.setColumnValues;
                e.setColumnValues = function() {
                    for (var n = arguments.length, a = new Array(n), u = 0; u < n; u++) a[u] = arguments[u];
                    return t.apply(e, [].concat(a, [ !1 ]));
                };
            }
            return this.picker;
        },
        updateColumns: function() {
            var e = this.getRanges().map(function(e, t) {
                var n = e.type, i = e.range;
                return {
                    values: u(i[1] - i[0] + 1, function(e) {
                        var t = i[0] + e;
                        return t = "year" === n ? "" + t : a(t);
                    })
                };
            });
            return this.set({
                columns: e
            });
        },
        getRanges: function() {
            var e = this.data;
            if ("time" === e.type) return [ {
                type: "hour",
                range: [ e.minHour, e.maxHour ]
            }, {
                type: "minute",
                range: [ e.minMinute, e.maxMinute ]
            } ];
            var t = this.getBoundary("max", e.innerValue), n = t.maxYear, a = t.maxDate, u = t.maxMonth, i = t.maxHour, r = t.maxMinute, o = this.getBoundary("min", e.innerValue), m = o.minYear, l = o.minDate, s = [ {
                type: "year",
                range: [ m, n ]
            }, {
                type: "month",
                range: [ o.minMonth, u ]
            }, {
                type: "day",
                range: [ l, a ]
            }, {
                type: "hour",
                range: [ o.minHour, i ]
            }, {
                type: "minute",
                range: [ o.minMinute, r ]
            } ];
            return "date" === e.type && s.splice(3, 2), "year-month" === e.type && s.splice(2, 3), 
            s;
        },
        correctValue: function(e) {
            var u = this.data, i = "time" !== u.type;
            if (i && !t(e) ? e = u.minDate : i || e || (e = a(u.minHour) + ":00"), !i) {
                var r = e.split(":"), o = r[0], m = r[1];
                return o = a(n(o, u.minHour, u.maxHour)), m = a(n(m, u.minMinute, u.maxMinute)), 
                o + ":" + m;
            }
            return e = Math.max(e, u.minDate), e = Math.min(e, u.maxDate);
        },
        getBoundary: function(t, n) {
            var a, u = new Date(n), i = new Date(this.data[t + "Date"]), o = i.getFullYear(), m = 1, l = 1, s = 0, p = 0;
            return "max" === t && (m = 12, l = r(u.getFullYear(), u.getMonth() + 1), s = 23, 
            p = 59), u.getFullYear() === o && (m = i.getMonth() + 1, u.getMonth() + 1 === m && (l = i.getDate(), 
            u.getDate() === l && (s = i.getHours(), u.getHours() === s && (p = i.getMinutes())))), 
            a = {}, e(a, t + "Year", o), e(a, t + "Month", m), e(a, t + "Date", l), e(a, t + "Hour", s), 
            e(a, t + "Minute", p), a;
        },
        onCancel: function() {
            this.$emit("cancel");
        },
        onConfirm: function() {
            this.$emit("confirm", this.data.innerValue);
        },
        onChange: function() {
            var e, t = this, n = this.data, a = this.getPicker();
            if ("time" === n.type) {
                var u = a.getIndexes();
                e = u[0] + n.minHour + ":" + (u[1] + n.minMinute);
            } else {
                var o = a.getValues(), m = i(o[0]), l = i(o[1]), s = r(m, l), p = i(o[2]);
                "year-month" === n.type && (p = 1), p = p > s ? s : p;
                var c = 0, h = 0;
                "datetime" === n.type && (c = i(o[3]), h = i(o[4])), e = new Date(m, l - 1, p, c, h);
            }
            e = this.correctValue(e), this.updateColumnValue(e).then(function() {
                t.$emit("input", e), t.$emit("change", a);
            });
        },
        updateColumnValue: function(e) {
            var t = this, n = [], u = this.data, i = this.getPicker();
            if ("time" === u.type) {
                var r = e.split(":");
                n = [ r[0], r[1] ];
            } else {
                var o = new Date(e);
                n = [ "" + o.getFullYear(), a(o.getMonth() + 1) ], "date" === u.type && n.push(a(o.getDate())), 
                "datetime" === u.type && n.push(a(o.getDate()), a(o.getHours()), a(o.getMinutes()));
            }
            return this.set({
                innerValue: e
            }).then(function() {
                return t.updateColumns();
            }).then(function() {
                return i.setValues(n);
            });
        }
    },
    created: function() {
        var e = this, t = this.correctValue(this.data.value);
        this.updateColumnValue(t).then(function() {
            e.$emit("input", t);
        });
    }
});