var _extends = Object.assign || function(a) {
    for (var e = 1; e < arguments.length; e++) {
        var t = arguments[e];
        for (var r in t) Object.prototype.hasOwnProperty.call(t, r) && (a[r] = t[r]);
    }
    return a;
}, _reload = require("../../resource/js/reload.js");

function _defineProperty(a, e, t) {
    return e in a ? Object.defineProperty(a, e, {
        value: t,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : a[e] = t, a;
}

var app = getApp();

Page(_extends({}, _reload.reload, {
    data: {
        repayType: [ {
            name: "等额本息",
            value: 0,
            checked: "true"
        }, {
            name: "等额本金",
            value: 1
        } ],
        calType: [ {
            name: "按贷款总额",
            value: 0,
            checked: "true"
        }, {
            name: "按单价",
            value: 1
        } ],
        param: {
            navChoose: 0,
            repayChoose: 0,
            calChoose: 0,
            yearA: 20,
            downA: 3,
            moneyA: "",
            priceA: "",
            areaA: "",
            rateA: 4.9,
            yearB: 20,
            downB: 3,
            moneyB: "",
            priceB: "",
            areaB: "",
            rateB: 3.25
        }
    },
    onLoad: function() {
        this.onloadData();
    },
    onShow: function() {
        var a, e = wx.getStorageSync("calculate");
        "" != e && this.setData((_defineProperty(a = {}, "param.rateA", (e.a.rate - 0) * (e.a.rates - 0)), 
        _defineProperty(a, "param.rateB", (e.b.rate - 0) * (e.b.rates - 0)), a));
    },
    onloadData: function() {
        var e = this;
        this.getUrl().then(function(a) {
            e.setData({
                show: !0
            });
        }).catch(function(a) {
            -1 === a.code ? e.tips(a.msg) : e.tips("false");
        });
    },
    onNavTab: function(a) {
        var e = a.currentTarget.dataset.idx - 0;
        this.setData(_defineProperty({}, "param.navChoose", e));
    },
    getRepayTypeTab: function(a) {
        var e = a.detail.value - 0;
        this.setData(_defineProperty({}, "param.repayChoose", e));
    },
    getCalTypeTab: function(a) {
        var e = a.detail.value - 0;
        this.setData(_defineProperty({}, "param.calChoose", e));
    },
    getYearA: function(a) {
        var e = a.detail.value;
        this.setData(_defineProperty({}, "param.yearA", e));
    },
    getDownA: function(a) {
        var e = a.detail.value;
        this.setData(_defineProperty({}, "param.downA", e));
    },
    getMoneyATab: function(a) {
        var e = a.detail.value;
        if (isNaN(e - 0)) this.setData(_defineProperty({}, "param.moneyA", this.data.param.moneyA)); else {
            var t = null;
            if (-1 == e.indexOf(".")) t = e; else {
                var r = e.split("."), i = r[1].slice(0, 2);
                t = r[0] + "." + i;
            }
            this.setData(_defineProperty({}, "param.moneyA", t));
        }
    },
    getPriceATab: function(a) {
        var e = a.detail.value;
        if (isNaN(e - 0)) this.setData(_defineProperty({}, "param.priceA", this.data.param.priceA)); else {
            var t = null;
            if (-1 == e.indexOf(".")) t = e; else {
                var r = e.split("."), i = r[1].slice(0, 2);
                t = r[0] + "." + i;
            }
            this.setData(_defineProperty({}, "param.priceA", t));
        }
    },
    getAreaATab: function(a) {
        var e = a.detail.value;
        if (isNaN(e - 0)) this.setData(_defineProperty({}, "param.areaA", this.data.param.areaA)); else {
            var t = null;
            if (-1 == e.indexOf(".")) t = e; else {
                var r = e.split("."), i = r[1].slice(0, 2);
                t = r[0] + "." + i;
            }
            this.setData(_defineProperty({}, "param.areaA", t));
        }
    },
    getRateA: function(a) {
        var e = a.detail.value;
        this.setData(_defineProperty({}, "param.rateA", e));
    },
    getYearB: function(a) {
        var e = a.detail.value;
        this.setData(_defineProperty({}, "param.yearB", e));
    },
    getDownB: function(a) {
        var e = a.detail.value;
        this.setData(_defineProperty({}, "param.downB", e));
    },
    getMoneyBTab: function(a) {
        var e = a.detail.value;
        if (isNaN(e - 0)) this.setData(_defineProperty({}, "param.moneyB", this.data.param.moneyB)); else {
            var t = null;
            if (-1 == e.indexOf(".")) t = e; else {
                var r = e.split("."), i = r[1].slice(0, 2);
                t = r[0] + "." + i;
            }
            this.setData(_defineProperty({}, "param.moneyB", t));
        }
    },
    getPriceBTab: function(a) {
        var e = a.detail.value;
        if (isNaN(e - 0)) this.setData(_defineProperty({}, "param.priceB", this.data.param.priceB)); else {
            var t = null;
            if (-1 == e.indexOf(".")) t = e; else {
                var r = e.split("."), i = r[1].slice(0, 2);
                t = r[0] + "." + i;
            }
            this.setData(_defineProperty({}, "param.priceB", t));
        }
    },
    getAreaBTab: function(a) {
        var e = a.detail.value;
        if (isNaN(e - 0)) this.setData(_defineProperty({}, "param.areaB", this.data.param.areaB)); else {
            var t = null;
            if (-1 == e.indexOf(".")) t = e; else {
                var r = e.split("."), i = r[1].slice(0, 2);
                t = r[0] + "." + i;
            }
            this.setData(_defineProperty({}, "param.areaB", t));
        }
    },
    getRateB: function(a) {
        var e = a.detail.value;
        this.setData(_defineProperty({}, "param.rateB", e));
    },
    onRateTab: function(a) {
        var e = a.currentTarget.dataset.idx - 0;
        this.navTo("../rate/rate?i=" + e);
    },
    onSendTab: function() {
        if (0 == this.data.param.navChoose && 0 == this.data.param.calChoose && (this.data.param.moneyA < 0 || "" == this.data.param.moneyA)) this.tips("请输入正确的贷款总额！"); else {
            if (0 == this.data.param.navChoose && 1 == this.data.param.calChoose) {
                if (this.data.param.priceA < 0 || "" == this.data.param.priceA) return void this.tips("请输入正确的单价！");
                if (this.data.param.areaA < 0 || "" == this.data.param.areaA) return void this.tips("请输入正确的面积！");
            }
            if (1 == this.data.param.navChoose && 0 == this.data.param.calChoose && (this.data.param.moneyB < 0 || "" == this.data.param.moneyB)) this.tips("请输入正确的贷款总额！"); else {
                if (1 == this.data.param.navChoose && 1 == this.data.param.calChoose) {
                    if (this.data.param.priceB < 0 || "" == this.data.param.priceB) return void this.tips("请输入正确的单价！");
                    if (this.data.param.areaB < 0 || "" == this.data.param.areaB) return void this.tips("请输入正确的面积！");
                }
                if (2 == this.data.param.navChoose && (this.data.param.moneyA < 0 || "" == this.data.param.moneyA)) this.tips("请输入正确的商业贷款总额！"); else if (2 == this.data.param.navChoose && (this.data.param.moneyB < 0 || "" == this.data.param.moneyB)) this.tips("请输入正确的公积金贷款总额！"); else {
                    var a = JSON.stringify(this.data.param);
                    this.navTo("../calculatorlast/calculatorlast?param=" + a);
                }
            }
        }
    }
}));