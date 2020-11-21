var _extends = Object.assign || function(t) {
    for (var a = 1; a < arguments.length; a++) {
        var e = arguments[a];
        for (var i in e) Object.prototype.hasOwnProperty.call(e, i) && (t[i] = e[i]);
    }
    return t;
}, _reload = require("../../resource/js/reload.js");

function _defineProperty(t, a, e) {
    return a in t ? Object.defineProperty(t, a, {
        value: e,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : t[a] = e, t;
}

var app = getApp();

Page(_extends({}, _reload.reload, {
    data: {
        rateA: [ {
            title: "最新商业贷款基准利率（4.9%）",
            val: 4.9
        }, {
            title: "最新商业贷款利率上浮20%（5.88%）",
            val: 5.88
        }, {
            title: "最新商业贷款利率上浮15%（5.64%）",
            val: 5.64
        }, {
            title: "最新商业贷款利率上浮10%（5.39%）",
            val: 5.39
        }, {
            title: "最新商业贷款利率上浮5%（5.15%）",
            val: 5.15
        }, {
            title: "最新商业贷款利率下浮5%（4.66%）",
            val: 4.66
        }, {
            title: "最新商业贷款利率下浮10%（4.41%）",
            val: 4.41
        }, {
            title: "最新商业贷款利率下浮15%（4.17%）",
            val: 4.17
        }, {
            title: "最新商业贷款利率下浮20%（3.92%）",
            val: 3.92
        }, {
            title: "最新商业贷款利率下浮30%（3.43%）",
            val: 3.43
        } ],
        rateB: [ {
            title: "最新公积金基准利率（3.25%）",
            val: 3.25
        }, {
            title: "最新公积金利率上浮20%（3.9%）",
            val: 3.9
        }, {
            title: "最新公积金利率上浮10%（3.58%）",
            val: 3.58
        } ],
        c: {
            a: {
                rate: 4.9,
                rates: 1
            },
            b: {
                rate: 3.25,
                rates: 1
            }
        }
    },
    onLoad: function(t) {
        this.setData({
            i: t.i
        });
        var a = wx.getStorageSync("calculate");
        if ("" != a) if (this.setData({
            c: a
        }), 0 == t.i) for (var e in this.data.rateA) this.data.rateA[e].val == a.a.rate && 1 == a.a.rates && this.setData({
            choose: e
        }); else for (var i in this.data.rateB) this.data.rateB[i].val == a.b.rate && 1 == a.b.rates && this.setData({
            choose: i
        });
    },
    onGetRateTab: function(t) {
        var a, e, i = t.currentTarget.dataset.idx;
        this.data.c;
        0 == this.data.i ? this.setData((_defineProperty(a = {}, "c.a.rate", this.data.rateA[i].val), 
        _defineProperty(a, "c.a.rates", 1), a)) : this.setData((_defineProperty(e = {}, "c.b.rate", this.data.rateB[i].val), 
        _defineProperty(e, "c.b.rates", 1), e));
        wx.setStorageSync("calculate", this.data.c), wx.navigateBack({
            delta: 1
        });
    },
    getRateTab: function(t) {
        var a = t.detail.value, e = a - 0;
        if (0 == this.data.i) if (isNaN(e)) this.setData(_defineProperty({}, "c.a.rate", this.data.c.a.rate)); else {
            var i = null;
            if (-1 == a.indexOf(".")) i = a; else {
                var r = a.split("."), s = r[1].slice(0, 2);
                i = r[0] + "." + s;
            }
            this.setData(_defineProperty({}, "c.a.rate", i));
        } else if (isNaN(e)) this.setData(_defineProperty({}, "c.b.rate", this.data.c.a.rate)); else {
            var l = null;
            if (-1 == a.indexOf(".")) l = a; else {
                var c = a.split("."), n = c[1].slice(0, 2);
                l = c[0] + "." + n;
            }
            this.setData(_defineProperty({}, "c.b.rate", l));
        }
    },
    getRatesTab: function(t) {
        var a = t.detail.value, e = a - 0;
        if (0 == this.data.i) if (isNaN(e)) this.setData(_defineProperty({}, "c.a.rates", this.data.c.a.rates)); else {
            var i = null;
            if (-1 == a.indexOf(".")) i = a; else {
                var r = a.split("."), s = r[1].slice(0, 2);
                i = r[0] + "." + s;
            }
            this.setData(_defineProperty({}, "c.a.rates", i));
        } else if (isNaN(e)) this.setData(_defineProperty({}, "c.b.rates", this.data.c.b.rates)); else {
            var l = null;
            if (-1 == a.indexOf(".")) l = a; else {
                var c = a.split("."), n = c[1].slice(0, 2);
                l = c[0] + "." + n;
            }
            this.setData(_defineProperty({}, "c.b.rates", l));
        }
    },
    onCheckTab: function() {
        this.data.c.a.rate <= 0 || this.data.c.b.rate <= 0 ? this.tips("请输入正确的利率") : this.data.c.a.rates <= 0 || this.data.c.b.rates <= 0 ? this.tips("请输入正确的倍数") : (wx.setStorageSync("calculate", this.data.c), 
        wx.navigateBack({
            delta: 1
        }));
    }
}));