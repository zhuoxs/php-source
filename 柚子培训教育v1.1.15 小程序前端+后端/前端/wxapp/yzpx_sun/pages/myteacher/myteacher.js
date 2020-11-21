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
    data: {},
    onLoad: function(t) {},
    onShow: function() {
        this.setData({
            list: {
                load: !1,
                over: !1,
                page: 1,
                length: 10,
                data: []
            }
        }), this.onloadData();
    },
    onloadData: function() {
        var a = this;
        this.checkUrl().then(function(t) {
            a.getListData();
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
                uid: wx.getStorageSync("userInfo").wxInfo.id,
                page: this.data.list.page,
                length: this.data.list.length
            };
            (0, _api.MyteacherData)(t).then(function(t) {
                a.dealList(t);
            });
        }
    },
    onReachBottom: function() {
        this.getListData();
    },
    onTeacherTab: function(t) {
        var a = t.currentTarget.dataset.idx, e = this.data.list.data[a].info.id;
        this.navTo("../teacher/teacher?tid=" + e);
    },
    onCollectTab: function(t) {
        var e = this, a = wx.getStorageSync("userInfo"), i = t.currentTarget.dataset.type, n = t.currentTarget.dataset.idx, o = {
            type: i,
            typeid: this.data.list.data[n].typeid,
            uid: a.wxInfo.id,
            act: this.data.list.data[n].like ? 2 : 1,
            actid: this.data.list.data[n].id
        };
        (0, _api.CollectData)(o).then(function(t) {
            var a;
            e.setData((_defineProperty(a = {}, "list.data[" + n + "].like", !e.data.list.data[n].like), 
            _defineProperty(a, "list.data[" + n + "].id", 1 === o.act ? t.actid : 0), a));
        }).catch(function(t) {
            wx.showToast({
                title: t.msg,
                icon: "none",
                duration: 2e3
            });
        });
    }
}));