var _extends = Object.assign || function(e) {
    for (var a = 1; a < arguments.length; a++) {
        var t = arguments[a];
        for (var o in t) Object.prototype.hasOwnProperty.call(t, o) && (e[o] = t[o]);
    }
    return e;
}, _reload = require("../../resource/js/reload.js");

function _defineProperty(e, a, t) {
    return a in e ? Object.defineProperty(e, a, {
        value: t,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : e[a] = t, e;
}

var app = getApp();

Page(_extends({}, _reload.reload, {
    data: {},
    onLoad: function(e) {
        var a = JSON.parse(e.param);
        this.setData({
            param: a
        }), this.onLoadData();
    },
    onLoadData: function() {
        0 == this.data.param.navChoose ? this.calA() : 1 == this.data.param.navChoose ? this.calB() : 2 == this.data.param.navChoose && this.calA();
    },
    calA: function() {
        var e = this.data.param, a = {};
        a.year = e.yearA - 0, a.month = 12 * a.year, 0 == e.calChoose ? a.allMoney = 1e4 * (e.moneyA - 0) : a.allMoney = (e.priceA - 0) * (e.areaA - 0) * (10 - e.downA) / 10;
        var t = (e.rateA - 0) / 1200, o = Math.pow(1 + t, a.month);
        a.repayA = a.allMoney * t * o / (o - 1), a.interestA = a.month * a.repayA - a.allMoney, 
        a.allA = a.interestA + a.allMoney, a.repayB = a.allMoney / a.month + (a.allMoney - 0) * t, 
        a.interestB = (a.allMoney / a.month + a.allMoney * t + a.allMoney / a.month * (1 + t)) / 2 * a.month - a.allMoney, 
        a.allB = a.interestB + a.allMoney, a.dec = a.allMoney / a.month * t, a.allMoney = a.allMoney / 1e4, 
        a.repayA = (a.repayA - 0).toFixed(2), a.interestA = ((a.interestA - 0) / 1e4).toFixed(2), 
        a.allA = ((a.allA - 0) / 1e4).toFixed(2), a.repayB = (a.repayB - 0).toFixed(2), 
        a.interestB = ((a.interestB - 0) / 1e4).toFixed(2), a.allB = ((a.allB - 0) / 1e4).toFixed(2), 
        a.dec = (a.dec - 0).toFixed(2), 2 == this.data.param.navChoose ? this.setData({
            show1: a
        }) : this.setData({
            show: a
        }), 2 == this.data.param.navChoose && this.calB();
    },
    calB: function() {
        var e = this.data.param, a = {};
        a.year = e.yearB - 0, a.month = 12 * a.year, 0 == e.calChoose ? a.allMoney = 1e4 * (e.moneyB - 0) : a.allMoney = (e.priceB - 0) * (e.areaB - 0) * (10 - e.downB) / 10;
        var t = (e.rateB - 0) / 1200, o = Math.pow(1 + t, a.month);
        if (a.repayA = a.allMoney * t * o / (o - 1), a.interestA = a.month * a.repayA - a.allMoney, 
        a.allA = a.interestA + a.allMoney, a.repayB = a.allMoney / a.month + (a.allMoney - 0) * t, 
        a.interestB = (a.allMoney / a.month + a.allMoney * t + a.allMoney / a.month * (1 + t)) / 2 * a.month - a.allMoney, 
        a.allB = a.interestB + a.allMoney, a.dec = a.allMoney / a.month * t, a.allMoney = a.allMoney / 1e4, 
        a.repayA = (a.repayA - 0).toFixed(2), a.interestA = ((a.interestA - 0) / 1e4).toFixed(2), 
        a.allA = ((a.allA - 0) / 1e4).toFixed(2), a.repayB = (a.repayB - 0).toFixed(2), 
        a.interestB = ((a.interestB - 0) / 1e4).toFixed(2), a.allB = ((a.allB - 0) / 1e4).toFixed(2), 
        a.dec = (a.dec - 0).toFixed(2), 2 == this.data.param.navChoose) {
            var l = {
                repayA: e.moneyA - 0 + (e.moneyB - 0),
                repayB: e.moneyA - 0 + (e.moneyB - 0),
                interestA: (this.data.show1.interestA - 0 + (a.interestA - 0)).toFixed(2),
                interestB: (this.data.show1.interestB - 0 + (a.interestB - 0)).toFixed(2),
                allA: (this.data.show1.allA - 0 + (a.allA - 0)).toFixed(2),
                allB: (this.data.show1.allB - 0 + (a.allB - 0)).toFixed(2)
            };
            this.setData({
                show2: a,
                show: l
            });
        } else this.setData({
            show: a
        });
    },
    onNavTab: function(e) {
        var a = e.currentTarget.dataset.idx - 0;
        this.setData(_defineProperty({}, "param.repayChoose", a));
    }
}));