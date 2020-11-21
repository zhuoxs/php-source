var _extends = Object.assign || function(t) {
    for (var a = 1; a < arguments.length; a++) {
        var e = arguments[a];
        for (var n in e) Object.prototype.hasOwnProperty.call(e, n) && (t[n] = e[n]);
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

var app = getApp(), WxParse = require("../common/wxParse/wxParse.js");

Page(_extends({}, _reload.reload, {
    data: _extends({}, _reload.data, {
        ajax: !1
    }),
    onLoad: function(t) {
        this.setData({
            id: t.id
        });
    },
    onloadData: function(t) {
        var a = this;
        t.detail.login && this.checkUrl().then(function(t) {
            return (0, _api.NewsDetailsData)({
                id: a.data.id,
                uid: wx.getStorageSync("fcInfo").wxInfo.id
            });
        }).then(function(t) {
            a.setData({
                info: t,
                show: !0
            }), WxParse.wxParse("content", "html", t.content, a, 0);
        }).catch(function(t) {
            -1 === t.code ? a.tips(t.msg) : a.tips("false");
        });
    },
    onMyCardTab: function() {
        this.navTo("../mycard/mycard");
    },
    onLoginTab: function() {
        this.navTo("../login/login");
    },
    onHouseTab: function() {
        0 != this.data.info.hid && this.navTo("../houses/houses?hid=" + this.data.info.hid);
    },
    onCollectTab: function() {
        var a = this;
        if (!this.data.ajax) {
            this.setData({
                ajax: !0
            });
            var t = {
                uid: wx.getStorageSync("fcInfo").wxInfo.id
            };
            0 == this.data.info.collect ? t.nid = this.data.info.id : t.collectid = this.data.info.collect, 
            (0, _api.CollectData)(t).then(function(t) {
                0 == a.data.info.collect ? a.setData(_defineProperty({}, "info.collect", t.collect)) : a.setData(_defineProperty({}, "info.collect", 0)), 
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