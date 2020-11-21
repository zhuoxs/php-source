var _extends = Object.assign || function(t) {
    for (var e = 1; e < arguments.length; e++) {
        var a = arguments[e];
        for (var i in a) Object.prototype.hasOwnProperty.call(a, i) && (t[i] = a[i]);
    }
    return t;
}, _reload = require("../../resource/js/reload.js"), _api = require("../../resource/js/api.js");

function _defineProperty(t, e, a) {
    return e in t ? Object.defineProperty(t, e, {
        value: a,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : t[e] = a, t;
}

var app = getApp();

function getDates(t) {
    var e = new Date(t);
    return e.getFullYear() + "/" + (9 < e.getMonth() + 1 ? e.getMonth() + 1 : "0" + (e.getMonth() + 1)) + "/" + (9 < e.getDate() ? e.getDate() : "0" + e.getDate()) + " 00:00:00";
}

Page(_extends({}, _reload.reload, {
    data: {
        nowMonth: "",
        weekList: [ {}, {}, {}, {}, {}, {}, {} ],
        nav: [ {
            name: "我的课程",
            choose: !0
        }, {
            name: "今日课程",
            choose: !1
        } ],
        choose: 0,
        chooseTime: 0,
        list: {
            load: !1,
            over: !1,
            page: 1,
            length: 10,
            data: []
        }
    },
    onLoad: function(t) {
        wx.setStorageSync("isshare", !1), this.getDay();
    },
    onloadData: function(t) {
        var e = this;
        t.detail.login && (this.setData({
            login: t.detail.login
        }), this.checkUrl().then(function(t) {
            wx.showShareMenu(), e.getListData();
        }).catch(function(t) {
            wx.showToast({
                title: t.msg,
                icon: "none",
                duration: 2e3
            });
        }));
    },
    getDay: function() {
        for (var t = new Date(), e = t.getTime(), a = t.getFullYear(), i = t.getMonth() + 1, s = [ {}, {}, {}, {}, {}, {}, {} ], o = 0; o < 7; o++) {
            e = 0 === o ? e : e + 864e5, s[o].day = new Date(e).getDate(), s[o].week = "日一二三四五六".charAt(new Date(e).getDay()), 
            s[o].now = 0 === o;
            var n = Date.parse(getDates(e)) / 1e3;
            s[o].stime = n, s[o].etime = n + 86399;
        }
        var r = a + "年" + i + "月";
        this.setData({
            nowMonth: r,
            weekList: s
        });
    },
    onChangeDayTab: function(t) {
        var e = t.currentTarget.dataset.idx, a = this.data.weekList;
        for (var i in a) {
            a[i = i - 0].now = i === e;
        }
        this.setData({
            weekList: a,
            chooseTime: e,
            list: {
                load: !1,
                over: !1,
                page: 1,
                length: 10,
                data: []
            }
        }), this.getListData();
    },
    onNavTab: function(t) {
        var e = t.currentTarget.dataset.idx - 0, a = this.data.nav;
        for (var i in a) {
            a[i = i - 0].choose = i === e;
        }
        this.setData({
            nav: a,
            choose: e,
            list: {
                load: !1,
                over: !1,
                page: 1,
                length: 10,
                data: []
            }
        }), this.getListData();
    },
    onClassListTab: function() {
        var t = wx.getStorageSync("shopinfo").id;
        this.navTo("../classlist/classlist?sid=" + t);
    },
    getListData: function() {
        var e = this;
        if (!this.data.list.over) {
            this.setData(_defineProperty({}, "list.load", !0));
            var a = {
                uid: wx.getStorageSync("userInfo").wxInfo.id,
                page: this.data.list.page,
                length: this.data.list.length,
                start_time: this.data.weekList[this.data.chooseTime].stime,
                end_time: this.data.weekList[this.data.chooseTime].etime
            };
            0 === this.data.choose ? (0, _api.MylessonData)(a).then(function(t) {
                !1 === t ? e.setData({
                    list: {
                        load: !1,
                        over: !1,
                        page: 1,
                        length: 10,
                        data: []
                    }
                }) : e.dealList(t, a.page);
            }) : (0, _api.TodayLessonData)(a).then(function(t) {
                e.dealList(t, a.page);
            });
        }
    },
    onReachBottom: function() {
        this.getListData();
    }
}));