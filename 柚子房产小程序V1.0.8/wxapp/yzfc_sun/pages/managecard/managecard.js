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
        way: 0,
        wayA: 0,
        wayB: 0
    }),
    onLoad: function() {},
    onloadData: function(t) {
        var a = this;
        if (t.detail.login) {
            var e = wx.getStorageSync("manage");
            this.setData({
                account: e.account,
                token: e.token
            });
            var i = {
                account: e.account,
                token: e.token,
                type: this.data.way - 0 + 1,
                isuse: this.data.wayA,
                logistics: this.data.wayB - 0 + 1,
                page: this.data.list.page,
                length: this.data.list.length
            };
            this.checkUrl().then(function(t) {
                return (0, _api.SendPrizeData)(i);
            }).then(function(t) {
                a.dealList(t, i.page), a.setData({
                    show: !0
                });
            }).catch(function(t) {
                -1 === t.code ? a.tips(t.msg) : a.tips("false");
            });
        }
    },
    getListData: function() {
        var a = this, e = this;
        if (this.data.list.over) this.tips("已全部加载完。"); else {
            this.setData(_defineProperty({}, "list.load", !0));
            var i = {
                account: this.data.account,
                token: this.data.token,
                type: this.data.way - 0 + 1,
                isuse: this.data.wayA,
                logistics: this.data.wayB - 0 + 1,
                uid: wx.getStorageSync("fcInfo").wxInfo.id,
                page: this.data.list.page,
                length: this.data.list.length
            };
            (0, _api.SendPrizeData)(i).then(function(t) {
                a.dealList(t, i.page);
            }).catch(function(t) {
                -1 === t.code ? a.tips(t.msg) : -2 === t.code ? (wx.setStorageSync("manage", ""), 
                wx.showModal({
                    title: "提示",
                    content: "登陆过期，请重新登陆！",
                    showCancel: !1,
                    success: function(t) {
                        e.reTo("../login/login");
                    }
                })) : a.tips("false");
            });
        }
    },
    onReachBottom: function() {
        this.getListData();
    },
    onWayTab: function(t) {
        var a = t.currentTarget.dataset.idx;
        this.setData({
            way: a,
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
    onWayATab: function(t) {
        var a = t.currentTarget.dataset.idx;
        this.setData({
            wayA: a,
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
    onWayBTab: function(t) {
        var a = t.currentTarget.dataset.idx;
        this.setData({
            wayB: a,
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
    onInfoTab: function(t) {
        var a = t.currentTarget.dataset.idx, e = this.data.list.data[a].id, i = this.data.list.data[a].info.prizename, n = this.data.imgLink + this.data.list.data[a].info.img_cover;
        this.navTo("../card/card?pid=" + e + "&title=" + i + "&img=" + n + "&manage=1");
    },
    onSendTab: function(t) {
        var a = this, e = t.currentTarget.dataset.idx, i = {
            logistics: 2,
            id: this.data.list.data[e].id
        };
        (0, _api.UpdatePrizeData)(i).then(function(t) {
            a.tips("已发货！"), a.setData({
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
            -1 === t.code ? a.tips(t.msg) : -2 === t.code ? (wx.setStorageSync("manage", ""), 
            wx.showModal({
                title: "提示",
                content: "登陆过期，请重新登陆！",
                showCancel: !1,
                success: function(t) {
                    _this.reTo("../login/login");
                }
            })) : a.tips("false");
        });
    }
}));