var _extends = Object.assign || function(t) {
    for (var a = 1; a < arguments.length; a++) {
        var e = arguments[a];
        for (var n in e) Object.prototype.hasOwnProperty.call(e, n) && (t[n] = e[n]);
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

Page(_extends({}, _reload.reload, _defineProperty({
    data: {
        list: {
            load: !1,
            over: !1,
            page: 1,
            length: 10,
            none: !1,
            data: []
        },
        currentStatus: 0,
        statusType: [ "短租订单", "长租订单" ],
        typeType: [ "已完成", "待支付", "已支付", "已取车", "已取消" ],
        currentType: 0,
        first: 0
    },
    onLoad: function(t) {
        this.setData({
            sid: t.sid
        });
    },
    onloadData: function(t) {
        var a = this;
        t.detail.login && (this.setData({
            login: !0
        }), this.data.first = 1, this.checkUrl().then(function(t) {
            a.getListData();
        }).catch(function(t) {
            -1 === t.code ? a.tips(t.msg) : a.tips("false");
        }));
    },
    onShow: function() {
        1 == this.data.first && this.onloadData({
            detail: {
                login: 1
            }
        });
    },
    getListData: function() {
        var a = this;
        if (!this.data.list.over) {
            this.setData(_defineProperty({}, "list.load", !0));
            var e = {
                type: this.data.currentStatus - 0 + 1,
                status: this.data.currentType,
                sid: this.data.sid,
                page: this.data.list.page,
                length: this.data.list.length
            };
            (0, _api.BranchOrderData)(e).then(function(t) {
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
        this.setData({
            currentStatus: t.currentTarget.dataset.index,
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
    typeTap: function(t) {
        this.setData({
            currentType: t.currentTarget.dataset.index,
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
    onReturnTab: function(t) {}
}, "onReturnTab", function(t) {
    var a = this, e = t.currentTarget.dataset.oid, n = (t.currentTarget.dataset.sid, 
    {
        id: e
    });
    wx.showModal({
        title: "提示",
        content: "确定该车辆客户已经还车？",
        success: function(t) {
            t.confirm && (0, _api.ReturnCarData)(n).then(function(t) {
                a.tips("订单已完成！"), a.setData({
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
})));