var _extends = Object.assign || function(t) {
    for (var a = 1; a < arguments.length; a++) {
        var e = arguments[a];
        for (var i in e) Object.prototype.hasOwnProperty.call(e, i) && (t[i] = e[i]);
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
    data: _extends({}, _reload.data, {
        navChoose: 0,
        search: ""
    }),
    onLoad: function(t) {
        var a = wx.getStorageSync("config");
        this.setData({
            color: a.color
        }), this.onloadData();
    },
    onloadData: function() {
        var a = this, e = {
            page: this.data.list.page,
            length: this.data.list.length
        };
        this.checkUrl().then(function(t) {
            return (0, _api.QuestionClassifyData)();
        }).then(function(t) {
            return a.setData({
                nav: t,
                show: !0
            }), e.cid = a.data.nav[0].id, (0, _api.QuestionListData)(e);
        }).then(function(t) {
            a.dealList(t, e.page);
        }).catch(function(t) {
            -1 === t.code ? a.tips(t.msg) : a.tips("false");
        });
    },
    getListData: function(t) {
        var a = this;
        if (this.data.list.over) this.tips("已全部加载完。"); else {
            this.setData(_defineProperty({}, "list.load", !0));
            var e = {
                page: this.data.list.page,
                length: this.data.list.length,
                cid: this.data.nav[this.data.navChoose].id
            };
            1 == t && (e.keywork = this.data.search), (0, _api.QuestionListData)(e).then(function(t) {
                a.dealList(t, e.page);
            }).catch(function(t) {
                -1 == t.code ? a.tips(t.msg) : a.tips("false");
            });
        }
    },
    onReachBottom: function() {
        this.getListData();
    },
    onNavTab: function(t) {
        var a = t.currentTarget.dataset.idx;
        this.setData({
            navChoose: a,
            search: "",
            list: {
                load: !1,
                over: !1,
                page: 1,
                length: 10,
                none: !1,
                data: []
            }
        }), this.getListData();
    },
    onSearchTab: function(t) {
        var a = t.detail.value;
        this.setData({
            search: a
        }), this.setData({
            list: {
                load: !1,
                over: !1,
                page: 1,
                length: 10,
                none: !1,
                data: []
            }
        }), this.getListData(1);
    },
    onAskTab: function() {
        this.navTo("../ask/ask");
    }
}));