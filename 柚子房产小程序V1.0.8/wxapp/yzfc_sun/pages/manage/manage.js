var _extends = Object.assign || function(a) {
    for (var n = 1; n < arguments.length; n++) {
        var e = arguments[n];
        for (var o in e) Object.prototype.hasOwnProperty.call(e, o) && (a[o] = e[o]);
    }
    return a;
}, _reload = require("../../resource/js/reload.js"), _api = require("../../resource/js/api.js"), app = getApp();

Page(_extends({}, _reload.reload, {
    data: _extends({}, _reload.data, {
        manage: !1
    }),
    onLoad: function() {
        this.onloadData();
    },
    onloadData: function() {
        var n = this, e = this;
        this.checkUrl().then(function(a) {
            var n = wx.getStorageSync("manage"), e = {
                account: n.account,
                token: n.token
            };
            return (0, _api.AdminInfoData)(e);
        }).then(function(a) {
            n.setData({
                show: !0,
                info: a
            });
        }).catch(function(a) {
            -1 === a.code ? n.tips(a.msg) : -2 === a.code ? (wx.setStorageSync("manage", ""), 
            wx.showModal({
                title: "提示",
                content: "登陆过期，请重新登陆！",
                showCancel: !1,
                success: function(a) {
                    e.reTo("../login/login");
                }
            })) : n.tips("false");
        });
    },
    onLogOutTab: function() {
        wx.setStorageSync("manage", ""), this.reTo("../login/login");
    },
    onManageCardTab: function() {
        this.navTo("../managecard/managecard");
    },
    onCheckTab: function() {
        var n = this;
        wx.scanCode({
            success: function(a) {
                n.navTo("../checkorder/checkorder?id=" + a.result);
            }
        });
    }
}));