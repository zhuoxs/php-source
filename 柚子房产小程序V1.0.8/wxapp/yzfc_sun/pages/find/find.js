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
        navChoose: 0
    }),
    onLoad: function() {
        var t = wx.getStorageSync("config");
        this.setData({
            color: t.color
        });
    },
    onloadData: function(t) {
        var a = this;
        if (t.detail.login) {
            var e = {
                page: this.data.list.page,
                length: this.data.list.length
            };
            this.checkUrl().then(function(t) {
                return (0, _api.FindClassifyData)();
            }).then(function(t) {
                return a.setData({
                    nav: t
                }), e.cid = a.data.nav[a.data.navChoose].id, (0, _api.FindListData)(e);
            }).then(function(t) {
                a.dealList(t, e.page), a.setData({
                    show: !0
                });
            }).catch(function(t) {
                -1 === t.code ? a.tips(t.msg) : a.tips("false");
            });
        }
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
    getListData: function(t) {
        var a = this;
        if (this.data.list.over) this.tips("已全部加载完。"); else {
            this.setData(_defineProperty({}, "list.load", !0));
            var e = {
                page: this.data.list.page,
                length: this.data.list.length,
                cid: this.data.nav[this.data.navChoose].id
            };
            (0, _api.FindListData)(e).then(function(t) {
                a.dealList(t, e.page);
            }).catch(function(t) {
                -1 == t.code ? a.tips(t.msg) : a.tips("false");
            });
        }
    },
    onReachBottom: function() {
        this.getListData();
    },
    onAddFindTab: function() {
        this.navTo("../addfind/addfind");
    },
    onFindInfoTab: function(t) {
        var a = t.currentTarget.dataset.idx;
        this.navTo("../findinfo/findinfo?fid=" + this.data.list.data[a].id);
    },
    onShareAppMessage: function() {
        return {
            title: "发现",
            path: "/yzxc_sun/pages/find/find"
        };
    }
}));