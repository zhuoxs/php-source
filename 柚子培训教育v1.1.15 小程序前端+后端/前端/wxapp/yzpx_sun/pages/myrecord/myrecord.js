var _extends = Object.assign || function(t) {
    for (var a = 1; a < arguments.length; a++) {
        var e = arguments[a];
        for (var r in e) Object.prototype.hasOwnProperty.call(e, r) && (t[r] = e[r]);
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
        this.getListData();
    },
    getListData: function() {
        var a = this;
        if (!this.data.list.over) {
            this.setData(_defineProperty({}, "list.load", !0));
            var t = {
                uid: wx.getStorageSync("userInfo").wxInfo.id,
                page: this.data.list.page,
                length: this.data.list.length
            };
            (0, _api.OrderLogData)(t).then(function(t) {
                a.dealList(t);
            });
        }
    },
    onReachBottom: function() {
        this.getListData();
    },
    onClassTab: function(t) {
        var a = t.currentTarget.dataset.idx, e = this.data.list.data[a].cid;
        this.navTo("../class/class?cid=" + e);
    }
}));