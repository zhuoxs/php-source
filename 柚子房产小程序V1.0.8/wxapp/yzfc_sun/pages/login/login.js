var _extends = Object.assign || function(t) {
    for (var a = 1; a < arguments.length; a++) {
        var e = arguments[a];
        for (var n in e) Object.prototype.hasOwnProperty.call(e, n) && (t[n] = e[n]);
    }
    return t;
}, _reload = require("../../resource/js/reload.js"), _api = require("../../resource/js/api.js"), app = getApp();

Page(_extends({}, _reload.reload, {
    data: _extends({}, _reload.data, {
        account: "",
        psw: ""
    }),
    onLoad: function() {
        this.onloadData();
    },
    onloadData: function(t) {
        var a = this;
        this.checkUrl().then(function(t) {
            a.setData({
                show: !0
            });
        }).catch(function(t) {
            -1 === t.code ? a.tips(t.msg) : a.tips("false");
        });
    },
    getAccount: function(t) {
        this.setData({
            account: t.detail.value
        });
    },
    getPsw: function(t) {
        this.setData({
            psw: t.detail.value
        });
    },
    onLoginTab: function() {
        var a = this, t = {
            account: this.data.account,
            psw: this.data.psw
        };
        (0, _api.AdminLoginData)(t).then(function(t) {
            wx.setStorageSync("manage", t), a.reTo("../manage/manage");
        }).catch(function(t) {
            -1 === t.code ? a.tips(t.msg) : a.tips("false");
        });
    }
}));