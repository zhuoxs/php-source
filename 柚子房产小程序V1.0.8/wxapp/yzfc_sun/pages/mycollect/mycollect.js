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
        ajax: !1
    }),
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
                }), (0, _api.MyCollectData)(e);
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
            (0, _api.MyCollectData)(e).then(function(t) {
                a.dealList(t, e.page);
            }).catch(function(t) {
                -1 == t.code ? a.tips(t.msg) : a.tips("false");
            });
        }
    },
    onReachBottom: function() {
        this.getListData();
    },
    onNewsTab: function(t) {
        var a = t.currentTarget.dataset.idx;
        this.navTo("../news/news?id=" + this.data.list.data[a].nid);
    },
    onCollectTab: function(t) {
        var a = this, e = t.currentTarget.dataset.idx;
        if (!this.data.ajax) {
            this.setData({
                ajax: !0
            });
            var i = {
                uid: wx.getStorageSync("fcInfo").wxInfo.id
            };
            0 == this.data.list.data[e].id ? i.nid = this.data.list.data[e].nid : i.collectid = this.data.list.data[e].id, 
            (0, _api.CollectData)(i).then(function(t) {
                0 == a.data.list.data[e].id ? a.setData(_defineProperty({}, "list.data[" + e + "].id", t.collect)) : a.setData(_defineProperty({}, "list.data[" + e + "].id", 0)), 
                a.setData({
                    ajax: !1
                });
            }).catch(function(t) {
                a.setData({
                    ajax: !1
                }), -1 === t.code ? a.tips(t.msg) : a.tips("false");
            });
        }
    }
}));