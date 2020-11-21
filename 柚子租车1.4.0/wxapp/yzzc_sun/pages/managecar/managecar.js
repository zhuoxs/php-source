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
        imgLink: wx.getStorageSync("url"),
        navList: [ {
            name: "已上架"
        }, {
            name: "已下架"
        } ],
        chooseNav: 0,
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
        this.setData({
            sid: t.sid
        });
    },
    onloadData: function(t) {
        var a = this;
        t.detail.login && (this.setData({
            show: !0
        }), this.checkUrl().then(function(t) {
            return (0, _api.BranchCarlsitData)();
        }).then(function(t) {
            a.getListData();
        }).catch(function(t) {
            -1 === t.code ? a.tips(t.msg) : a.tips("false");
        }));
    },
    getListData: function() {
        var a = this;
        if (!this.data.list.over) {
            this.setData(_defineProperty({}, "list.load", !0));
            var e = {
                page: this.data.list.page,
                length: this.data.list.length,
                type: this.data.chooseNav - 0 + 1,
                sid: this.data.sid
            };
            (0, _api.BranchCarlsitData)(e).then(function(t) {
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
            chooseNav: a
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
    },
    onContralCarTab: function(t) {
        var a = this, e = t.currentTarget.dataset.idx, i = t.currentTarget.dataset.types, s = this.data.list.data[e].id, n = {
            type: i,
            id: s
        }, o = "";
        o = 1 == i ? "确定是上架该车辆(" + this.data.list.data[e].name + ")" : 2 == i ? "确定下架该车辆(" + this.data.list.data[e].name + ")" : "确定删除该车辆(" + this.data.list.data[e].name + ")", 
        wx.showModal({
            title: "提示",
            content: o,
            success: function(t) {
                t.confirm && (0, _api.DoCarData)(n).then(function(t) {
                    1 == i ? a.tips("已上架") : 2 == i ? a.tips("已下架") : a.tips("已删除"), a.setData({
                        list: {
                            load: !1,
                            over: !1,
                            page: 1,
                            length: 10,
                            none: !1,
                            data: []
                        }
                    }), a.getListData();
                }).catch(function(t) {
                    -1 == t.code ? a.tips(t.msg) : a.tips("false");
                });
            }
        });
    }
}));