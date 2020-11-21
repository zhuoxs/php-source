var _extends = Object.assign || function(t) {
    for (var a = 1; a < arguments.length; a++) {
        var e = arguments[a];
        for (var i in e) Object.prototype.hasOwnProperty.call(e, i) && (t[i] = e[i]);
    }
    return t;
}, _reload = require("../../common/js/reload.js"), _api = require("../../common/js/api.js");

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
        show: !1,
        statusType: [ "积分明细", "兑换记录" ],
        list: {
            load: !1,
            over: !1,
            page: 1,
            length: 10,
            none: !1,
            data: []
        }
    },
    onLoad: function(t) {
        this.setLoadData(t);
    },
    onloadData: function(t) {
        var a = this;
        t.detail.login && (this.setData({
            show: !0
        }), this.checkUrl().then(function(t) {
            a.getListData();
        }).catch(function(t) {
            -1 === t.code ? a.tips(t.msg) : a.tips("false");
        }));
    },
    setLoadData: function(t) {
        var a = t.title, e = t.curIndex;
        wx.setNavigationBarTitle({
            title: a
        }), this.setData({
            currentStatus: e
        });
    },
    getListData: function() {
        var a = this;
        if (!this.data.list.over) {
            this.setData(_defineProperty({}, "list.load", !0));
            var e = {
                type: this.data.currentStatus - 0 + 1,
                page: this.data.list.page,
                length: this.data.list.length,
                uid: wx.getStorageSync("userInfo").wxInfo.id
            };
            (0, _api.IntegralDetailsData)(e).then(function(t) {
                a.dealList(t, e.page);
            }).catch(function(t) {
                -1 == t.code ? a.tips(t.msg) : a.tips("false");
            });
        }
    },
    onReachBottom: function() {
        this.getListData();
    },
    statusTap: function(t) {
        0 == t.currentTarget.dataset.index ? wx.setNavigationBarTitle({
            title: "积分明细"
        }) : wx.setNavigationBarTitle({
            title: "兑换记录"
        }), this.setData({
            currentStatus: t.currentTarget.dataset.index
        }), this.setData({
            list: {
                load: !1,
                over: !1,
                page: 1,
                length: 10,
                none: !1,
                data: []
            }
        }), this.getListData();
    }
}));