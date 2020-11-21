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
        login: !0,
        showPage: !1,
        nav: [ {
            name: "未咨询",
            choose: !0
        }, {
            name: "已咨询",
            choose: !1
        } ],
        choose: 0
    },
    onLoad: function(t) {
        this.setData({
            sid: t.sid
        });
    },
    onloadData: function() {
        var a = this;
        this.setData({
            list: {
                load: !1,
                over: !1,
                page: 1,
                length: 10,
                data: []
            }
        }), this.checkUrl().then(function(t) {
            return a.setData({
                showPage: !0
            }), (0, _api.OrderListData)({
                sid: a.data.sid,
                type: a.data.choose - 0 + 1,
                page: a.data.list.page,
                length: a.data.list.length
            });
        }).then(function(t) {
            a.dealList(t);
        }).catch(function(t) {
            wx.showToast({
                title: t.msg,
                icon: "none",
                duration: 2e3
            });
        });
    },
    getListData: function() {
        var a = this;
        if (!this.data.list.over) {
            this.setData(_defineProperty({}, "list.load", !0));
            var t = {
                page: this.data.list.page,
                length: this.data.list.length,
                sid: this.data.sid,
                type: this.data.choose - 0 + 1
            };
            return (0, _api.OrderListData)(t).then(function(t) {
                a.dealList(t);
            });
        }
    },
    onReachBottom: function() {
        this.getListData();
    },
    onChangeStatusTab: function(t) {
        var a = this, e = t.currentTarget.dataset.idx;
        if (this.setData({
            idx: e
        }), 2 != this.data.list.data[e].status) {
            var i = '是否已经咨询过学生"' + this.data.list.data[e].username + '"?';
            wx.showModal({
                title: "提示",
                content: i,
                success: function(t) {
                    t.confirm && a.changeStatusAjax();
                }
            });
        }
    },
    changeStatusAjax: function() {
        var a = this, t = {
            oid: this.data.list.data[this.data.idx].id
        };
        (0, _api.OrderStatusData)(t).then(function(t) {
            a.setData(_defineProperty({}, "list.data[" + a.data.idx + "].status", 2));
        }).catch(function(t) {
            -1 === t.code ? a.tips(t.msg) : a.tips("false");
        });
    },
    onNavTab: function(t) {
        var a = t.currentTarget.dataset.idx, e = this.data.nav;
        for (var i in e) {
            e[i = i - 0].choose = i === a;
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
    }
}));