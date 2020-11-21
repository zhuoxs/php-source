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
    data: {
        list: {
            load: !1,
            over: !1,
            page: 1,
            length: 10,
            data: []
        }
    },
    onLoad: function(t) {},
    onloadData: function(a) {
        var e = this;
        this.checkUrl().then(function(t) {
            if (a.detail.login) return e.setData({
                login: a.detail.login
            }), e.getListData(1);
        }).then(function(t) {
            e.dealList(t);
        }).catch(function(t) {
            -1 === t.code ? e.tips(t.msg) : e.tips("false");
        });
    },
    getListData: function(t) {
        var a = this;
        if (!this.data.list.over) {
            this.setData(_defineProperty({}, "list.load", !0));
            var e = {
                page: this.data.list.page,
                length: this.data.list.length
            };
            if (1 == t) return (0, _api.CardlistData)(e);
            (0, _api.CardlistData)(e).then(function(t) {
                a.dealList(t);
            });
        }
    },
    onReachBottom: function() {
        this.getListData();
    },
    onActivityTab: function(t) {
        var a = t.currentTarget.dataset.idx, e = this.data.list.data[a].id;
        this.navTo("../activity/activity?cid=" + e);
    }
}));