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
    data: _extends({}, _reload.data),
    onLoad: function() {},
    onloadData: function(t) {
        var a = this;
        if (t.detail.login) {
            var e = {
                page: this.data.list.page,
                length: this.data.list.length,
                uid: wx.getStorageSync("fcInfo").wxInfo.id
            };
            this.checkUrl().then(function(t) {
                return a.setData({
                    show: !0
                }), (0, _api.MyOrderData)(e);
            }).then(function(t) {
                a.dealList(t, e.page);
            }).catch(function(t) {
                -1 === t.code ? a.tips(t.msg) : a.tips("false");
            });
        }
    },
    getListData: function(t) {
        var a = this;
        if (this.data.list.over) this.tips("已全部加载完。"); else {
            this.setData(_defineProperty({}, "list.load", !0));
            var e = {
                page: this.data.list.page,
                length: this.data.list.length,
                uid: wx.getStorageSync("fcInfo").wxInfo.id
            };
            (0, _api.MyOrderData)(e).then(function(t) {
                a.dealList(t, e.page);
            }).catch(function(t) {
                -1 == t.code ? a.tips(t.msg) : a.tips("false");
            });
        }
    },
    onReachBottom: function() {
        this.getListData();
    },
    onDelTab: function(t) {
        var e = this, a = t.currentTarget.dataset.idx, i = this.data.list.data[a].id;
        wx.showModal({
            title: "提示",
            content: "是否删除" + this.data.list.data[a].houseinfo.name + "的预约看房？",
            success: function(t) {
                var a = this;
                t.confirm && (0, _api.DelOrderData)({
                    oid: i
                }).then(function(t) {
                    e.tips("删除成功！"), e.setData({
                        list: {
                            load: !1,
                            over: !1,
                            page: 1,
                            length: 10,
                            none: !1,
                            data: []
                        }
                    }), e.getListData();
                }).catch(function(t) {
                    -1 == t.code ? a.tips(t.msg) : a.tips("false");
                });
            }
        });
    }
}));