var _createClass = function() {
    function n(t, e) {
        for (var a = 0; a < e.length; a++) {
            var n = e[a];
            n.enumerable = n.enumerable || !1, n.configurable = !0, "value" in n && (n.writable = !0), 
            Object.defineProperty(t, n.key, n);
        }
    }
    return function(t, e, a) {
        return e && n(t.prototype, e), a && n(t, a), t;
    };
}(), _slicedToArray = function(t, e) {
    if (Array.isArray(t)) return t;
    if (Symbol.iterator in Object(t)) return function(t, e) {
        var a = [], n = !0, i = !1, s = void 0;
        try {
            for (var r, o = t[Symbol.iterator](); !(n = (r = o.next()).done) && (a.push(r.value), 
            !e || a.length !== e); n = !0) ;
        } catch (t) {
            i = !0, s = t;
        } finally {
            try {
                !n && o.return && o.return();
            } finally {
                if (i) throw s;
            }
        }
        return a;
    }(t, e);
    throw new TypeError("Invalid attempt to destructure non-iterable instance");
};

function _classCallCheck(t, e) {
    if (!(t instanceof e)) throw new TypeError("Cannot call a class as a function");
}

function partStartWithZero(t, e) {
    for (var a = ""; a.length < e; ) a += "0";
    return (a + t).slice(-e);
}

function genNumber(t, e, a) {
    for (var n = []; t <= e; ) n.push(partStartWithZero(t, a)), t++;
    return n;
}

function moment(a) {
    var t = 1 < arguments.length && void 0 !== arguments[1] ? arguments[1] : "YYYY:MM:DD";
    if (a || 0 === a || (a = new Date()), "Invalid Date" === (a = new Date(a)).toString()) throw new Error("Invalid Date");
    var e = function(t, e) {
        return e ? e(a["get" + t]()) : a["get" + t]();
    }, n = new Map();
    n.set(/(Y+)/i, function() {
        return e("FullYear", function(t) {
            return (t + "").substr(4 - RegExp.$1.length);
        });
    }), n.set(/(M+)/, function() {
        return e("Month", function(t) {
            return partStartWithZero(t + 1, RegExp.$1.length);
        });
    }), n.set(/(D+)/i, function() {
        return e("Date", function(t) {
            return partStartWithZero(t, RegExp.$1.length);
        });
    }), n.set(/(H+)/i, function() {
        return e("Hours", function(t) {
            return partStartWithZero(t, RegExp.$1.length);
        });
    }), n.set(/(m+)/, function() {
        return e("Minutes", function(t) {
            return partStartWithZero(t, RegExp.$1.length);
        });
    }), n.set(/(s+)/, function() {
        return e("Seconds", function(t) {
            return partStartWithZero(t, RegExp.$1.length);
        });
    });
    var i = !0, s = !1, r = void 0;
    try {
        for (var o, u = n[Symbol.iterator](); !(i = (o = u.next()).done); i = !0) {
            var h = _slicedToArray(o.value, 2), d = h[0], c = h[1];
            d.test(t) && (t = t.replace(RegExp.$1, c.call(null)));
        }
    } catch (t) {
        s = !0, r = t;
    } finally {
        try {
            !i && u.return && u.return();
        } finally {
            if (s) throw r;
        }
    }
    return t;
}

var LIMIT_YEAR_COUNT = 50, DatePicker = function() {
    function n(t) {
        var e = 1 < arguments.length && void 0 !== arguments[1] ? arguments[1] : new Date(), a = arguments[2];
        _classCallCheck(this, n), this.types = [ "year", "month", "day", "hour", "minute", "second" ], 
        this.months = genNumber(1, 12, 2), this.hours = genNumber(0, 23, 2), this.seconds = genNumber(0, 59, 2), 
        this.minutes = genNumber(0, 59, 2), this.init(e, a);
    }
    return _createClass(n, [ {
        key: "getYears",
        value: function(t) {
            var e = Math.floor(LIMIT_YEAR_COUNT / 2);
            return genNumber(t - e, t + (LIMIT_YEAR_COUNT - e), 4);
        }
    }, {
        key: "lastDay",
        value: function(t, e) {
            return 12 !== e ? new Date(new Date(t + "/" + (e + 1) + "/1").getTime() - 864e5).getDate() : 31;
        }
    }, {
        key: "init",
        value: function(t, e) {
            var a = new Date(t), n = a.getFullYear(), i = a.getMonth() + 1, s = this.getYears(n), r = genNumber(1, this.lastDay(n, i), 2);
            this._years = s, this._dataList = [ s, this.months, r, this.hours, this.minutes, this.seconds ], 
            this._indexs = [ 25, i - 1, a.getDate(), a.getHours(), a.getMinutes(), a.getSeconds() ], 
            e && e({
                dataList: this._dataList,
                indexs: this._indexs
            });
        }
    }, {
        key: "update",
        value: function(t, e, a) {
            switch (this.types[t]) {
              case "year":
                this._updateYear(t, e, a);
                break;

              case "month":
                this._updateMonth(t, e, a);
                break;

              default:
                this._indexs[t] = e, a && a({
                    dataList: this._dataList,
                    indexs: this._indexs,
                    updateColumn: t,
                    updateIndex: e
                });
            }
        }
    }, {
        key: "_updateYear",
        value: function(t, e, a) {
            var n = this._dataList[t][e];
            this._dataList[t] = this.getYears(+n), this._indexs[t] = Math.floor(LIMIT_YEAR_COUNT / 2), 
            a && a({
                dataList: this._dataList,
                indexs: this._indexs,
                updateColumn: t
            });
        }
    }, {
        key: "_updateMonth",
        value: function(t, e, a) {
            var n = this._dataList[t][e], i = this._dataList[0][this._indexs[0]], s = this.lastDay(+i, +n);
            this._indexs[t] = e, this._dataList[2] = genNumber(1, s, 2), this._indexs[2] = this._indexs[2] >= this._dataList[2].length ? this._dataList[2].length - 1 : this._indexs[2], 
            a && a({
                dataList: this._dataList,
                indexs: this._indexs,
                updateColumn: 2,
                updateIndex: this._indexs[2]
            }), a && a({
                dataList: this._dataList,
                indexs: this._indexs,
                updateColumn: 1,
                updateIndex: e
            });
        }
    } ]), n;
}(), _indexs = [];

Component({
    properties: {
        placeholder: {
            type: String,
            value: "请选择时间"
        },
        format: {
            type: String,
            value: "YYYY-MM-DD HH:mm:ss"
        },
        native: {
            type: Boolean
        },
        pickerView: {
            type: Boolean
        },
        date: {
            type: String,
            value: new Date()
        },
        notUse: {
            type: Array
        }
    },
    externalClasses: [ "placeholder-class" ],
    data: {
        transPos: [ 0, 0, 0, 0, 0, 0 ]
    },
    attached: function() {
        var e = this;
        this.use = {}, [ "years", "months", "days", "hours", "minutes", "seconds" ].forEach(function(t) {
            -1 === (e.data.notUse || []).indexOf(t) && (e.use[t] = !0);
        }), this.setData({
            use: this.use
        }), this.data.pickerView && !this.data.native && this.showPicker();
    },
    ready: function() {
        this.setData({
            dataList: [ [ "2018", "2019", "2020", "2021", "2022", "2023", "2024", "2025", "2026", "2027", "2028", "2029", "2030", "2031", "2032", "2033", "2034", "2035", "2036", "2037", "2038", "2039", "2040", "2041", "2042", "2043" ], genNumber(1, 12, 2), genNumber(0, 31, 2), genNumber(0, 23, 2), genNumber(0, 59, 2), genNumber(0, 59, 2) ]
        }), this.picker = new DatePicker(this.data.format, this.data.date, this.updatePicker.bind(this));
    },
    methods: {
        updatePicker: function(t) {
            var e = t.dataList, a = t.indexs, n = t.updateColumn, i = t.updateIndex, s = {};
            _indexs = a, n && (s["transPos[" + n + "]"] = -36 * _indexs[n], s["dataList[" + n + "]"] = e[n]), 
            void 0 !== i && (s["transPos[" + n + "]"] = -36 * _indexs[n], s["selected[" + n + "]"] = a[n]), 
            n || void 0 !== i || (s = {
                dataList: e,
                selected: a
            }, _indexs.forEach(function(t, e) {
                s["transPos[" + e + "]"] = 36 * -t;
            })), this.setData(s);
        },
        touchmove: function(t) {
            var e = t.changedTouches, a = t.target.dataset.col, n = e[0].clientY;
            if (a) {
                var i = {}, s = this.data.dataList[a].length;
                i["transPos[" + a + "]"] = this.startTransPos + (n - this.startY), 0 <= i["transPos[" + a + "]"] ? i["transPos[" + a + "]"] = 0 : 36 * -(s - 1) >= i["transPos[" + a + "]"] && (i["transPos[" + a + "]"] = 36 * -(s - 1)), 
                this.setData(i);
            }
        },
        touchStart: function(t) {
            var e = t.target, a = t.changedTouches, n = e.dataset.col, i = a[0];
            n && (this.startY = i.clientY, this.startTime = t.timeStamp, this.startTransPos = this.data.transPos[n]);
        },
        touchEnd: function(t) {
            var e = t.target.dataset.col;
            if (e) {
                var a = this.data.transPos[e], n = Math.round(a / 36);
                this.columnchange({
                    detail: {
                        column: +e,
                        value: -n
                    }
                });
            }
        },
        columnchange: function(t) {
            var e = t.detail, a = e.column, n = e.value;
            _indexs[a] = n, this.picker.update(a, n, this.updatePicker.bind(this)), this.data.pickerView && !this.data.native && this.change({
                detail: {
                    value: _indexs
                }
            });
        },
        getFormatStr: function() {
            var n = this, i = new Date();
            return [ "FullYear", "Month", "Date", "Hours", "Minutes", "Seconds" ].forEach(function(t, e) {
                var a = n.data.dataList[e][_indexs[e]];
                "Month" === t && (a = +n.data.dataList[e][_indexs[e]] - 1), i["set" + t](+a);
            }), moment(i, this.data.format);
        },
        showPicker: function() {
            this.setData({
                show: !0
            });
        },
        hidePicker: function(t) {
            var e = t.currentTarget.dataset.action;
            this.setData({
                show: !1
            }), "cancel" === e ? this.cancel({
                detail: {}
            }) : this.change({
                detail: {
                    value: _indexs
                }
            });
        },
        change: function(t) {
            var a = t.detail.value, e = this.data.dataList.map(function(t, e) {
                return +t[a[e]];
            });
            if (this.triggerEvent("change", {
                value: e
            }), this.data.pickerView && this.data.native) for (var n = 0; n < a.length; n++) if (_indexs[n] !== a[n]) {
                this.columnchange({
                    detail: {
                        column: n,
                        value: a[n]
                    }
                });
                break;
            }
            this.setData({
                text: this.getFormatStr()
            });
        },
        cancel: function(t) {
            this.triggerEvent("cancel", t.detail);
        }
    }
});