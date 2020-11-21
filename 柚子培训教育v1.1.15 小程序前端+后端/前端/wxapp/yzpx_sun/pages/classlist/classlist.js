var _extends = Object.assign || function(t) {
    for (var a = 1; a < arguments.length; a++) {
        var e = arguments[a];
        for (var s in e) Object.prototype.hasOwnProperty.call(e, s) && (t[s] = e[s]);
    }
    return t;
}, _reload = require("../../resource/js/reload.js"), _api = require("../../resource/js/api.js");

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
        nonePage: !1,
        list: {
            load: !1,
            over: !1,
            page: 1,
            length: 10,
            data: []
        },
        gps: !0
    },
    onLoad: function(t) {
        var a = wx.getStorageSync("shopinfo");
        this.setData({
            sid: a.sid
        });
    },
    onloadData: function(t) {
        var a = this, e = this;
        t.detail.login && (this.setData({
            login: t.detail.login
        }), this.checkUrl().then(function(t) {
            return wx.showShareMenu(), a.checkSchool();
        }).then(function(t) {
            return (0, _api.CourseClassifyData)({
                sid: a.data.sid
            });
        }).then(function(t) {
            t.length < 1 ? (a.setData({
                nonePage: !0
            }), wx.showModal({
                title: "提示",
                content: "还没有课程哦！",
                showCancel: !1,
                success: function(t) {
                    e.lunchTo("../home/home");
                }
            })) : (t[0].choose = !0, a.setData({
                nav: t,
                choose: 0
            }), a.getListData());
        }).catch(function(t) {
            -1 === t.code ? a.tips(t.msg) : a.tips("false");
        }));
    },
    getListData: function() {
        var a = this;
        if (!this.data.list.over) {
            this.setData(_defineProperty({}, "list.load", !0));
            var e = {
                cid: this.data.nav[this.data.choose].id,
                page: this.data.list.page,
                length: this.data.list.length,
                sid: this.data.sid
            };
            return (0, _api.CourseListData)(e).then(function(t) {
                a.dealList(t, e.page);
            });
        }
    },
    onReachBottom: function() {
        this.getListData();
    },
    onNavTab: function(t) {
        var a = t.currentTarget.dataset.idx, e = this.data.nav;
        for (var s in e) {
            e[s = s - 0].choose = s === a;
        }
        this.setData({
            nav: e,
            choose: a,
            list: {
                load: !1,
                over: !1,
                page: 1,
                length: 10,
                data: []
            }
        }), this.getListData();
    },
    onClassTab: function() {
        this.navTo("../class/class");
    },
    onShareAppMessage: function(t) {
        return {
            title: "精品课程",
            path: "/yzpx_sun/pages/classlist/classlist?sid=" + this.data.sid
        };
    }
}));