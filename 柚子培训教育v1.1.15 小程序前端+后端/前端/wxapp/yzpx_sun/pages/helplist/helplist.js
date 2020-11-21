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
    onLoad: function(t) {
        this.setData({
            user: t.uid,
            cid: t.cid
        });
    },
    onloadData: function(t) {
        var a = this;
        t.detail.login && (this.setData({
            login: t.detail.login
        }), this.data.user == wx.getStorageSync("userInfo").wxInfo.id ? this.setData({
            my: !0
        }) : this.setData({
            my: !1
        }), this.checkUrl().then(function(t) {
            a.getListData();
        }).catch(function(t) {
            wx.showToast({
                title: t.msg,
                icon: "none",
                duration: 2e3
            });
        }));
    },
    getListData: function() {
        var a = this;
        if (!this.data.list.over) {
            this.setData(_defineProperty({}, "list.load", !0));
            var e = {
                uid: this.data.user,
                cid: this.data.cid,
                page: this.data.list.page,
                length: this.data.list.length
            };
            (0, _api.HelpBargainListData)(e).then(function(t) {
                a.dealList(t, e.page);
            });
        }
    },
    onReachBottom: function() {
        this.getListData();
    }
}));