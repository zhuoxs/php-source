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
        nav: [ "全部", "一居", "两居", "三居", "四居", "五居", "五居以上" ],
        navChoose: 0
    }),
    onLoad: function(t) {
        this.setData({
            hid: t.hid
        }), this.onloadData();
    },
    onloadData: function() {
        var a = this, e = {
            page: this.data.list.page,
            length: this.data.list.length,
            hid: this.data.hid,
            type: this.data.navChoose
        };
        this.checkUrl().then(function(t) {
            return (0, _api.HouseTypeListData)(e);
        }).then(function(t) {
            a.setData({
                show: !0
            }), a.dealList(t, e.page);
        }).catch(function(t) {
            -1 === t.code ? a.tips(t.msg) : a.tips("false");
        });
    },
    getListData: function() {
        var a = this;
        if (this.data.list.over) this.tips("已全部加载完。"); else {
            this.setData(_defineProperty({}, "list.load", !0));
            var e = {
                page: this.data.list.page,
                length: this.data.list.length,
                hid: this.data.hid,
                type: this.data.navChoose
            };
            (0, _api.HouseTypeListData)(e).then(function(t) {
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
    onHouseTab: function(t) {
        var a = t.currentTarget.dataset.idx;
        this.navTo("../house/house?id=" + this.data.list.data[a].id);
    }
}));