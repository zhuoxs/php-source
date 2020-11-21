var _extends = Object.assign || function(t) {
    for (var a = 1; a < arguments.length; a++) {
        var e = arguments[a];
        for (var o in e) Object.prototype.hasOwnProperty.call(e, o) && (t[o] = e[o]);
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
        login: !0,
        list: {
            load: !1,
            over: !1,
            page: 1,
            length: 10,
            data: []
        },
        schoolFlag: !1,
        choose: "",
        ajax: !0,
        nav: [ {
            name: "未使用",
            choose: !0
        }, {
            name: "已使用",
            choose: !1
        } ],
        tchoose: 0
    },
    onLoad: function(t) {},
    onloadData: function(t) {
        var a = this;
        t.detail.login && this.checkUrl().then(function(t) {
            a.getListData();
        }).catch(function(t) {
            -1 === t.code ? a.tips(t.msg) : a.tips("false");
        });
    },
    getListData: function() {
        var a = this;
        if (!this.data.list.over) {
            this.setData(_defineProperty({}, "list.load", !0));
            var e = {
                uid: wx.getStorageSync("userInfo").wxInfo.id,
                page: this.data.list.page,
                length: this.data.list.length,
                type: this.data.tchoose - 0 + 1
            };
            (0, _api.MyCouponData)(e).then(function(t) {
                a.dealList(t, e.page);
            });
        }
    },
    onReachBottom: function() {
        this.getListData();
    },
    closeSchool: function(t) {
        var a = t.currentTarget.dataset.idx;
        console.log(a), null != a && (this.setData({
            choose: a
        }), 0 != this.data.list.data[a].info.use) || this.setData({
            schoolFlag: !this.data.schoolFlag
        });
    },
    onNavTab: function(t) {
        var a = t.currentTarget.dataset.idx, e = this.data.nav;
        for (var o in e) {
            e[o = o - 0].choose = o === a;
        }
        this.setData({
            nav: e,
            tchoose: a,
            list: {
                load: !1,
                over: !1,
                page: 1,
                length: 10,
                data: []
            }
        }), this.getListData();
    }
}));