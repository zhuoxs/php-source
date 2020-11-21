var _extends = Object.assign || function(t) {
    for (var e = 1; e < arguments.length; e++) {
        var n = arguments[e];
        for (var a in n) Object.prototype.hasOwnProperty.call(n, a) && (t[a] = n[a]);
    }
    return t;
}, _reload = require("../../resource/js/reload.js"), _api = require("../../resource/js/api.js"), app = getApp();

Page(_extends({}, _reload.reload, {
    data: {
        remove: !1
    },
    onLoad: function(t) {
        this.setData({
            id: t.id
        }), this.onloadData();
    },
    onloadData: function() {
        var e = this, t = wx.getStorageSync("manage"), n = {
            ordernum: this.data.id,
            account: t.account,
            token: t.token
        };
        this.checkUrl().then(function(t) {
            return (0, _api.CheckInfoData)(n);
        }).then(function(t) {
            e.setData({
                info: t
            });
        }).catch(function(t) {
            -1 === t.code ? e.tips(t.msg) : -2 === t.code ? (wx.setStorageSync("manage", ""), 
            wx.showModal({
                title: "提示",
                content: "登陆过期，请重新登陆！",
                showCancel: !1,
                success: function(t) {
                    _this.reTo("../login/login");
                }
            })) : e.tips("false");
        });
    },
    onCheckTab: function() {
        var e = this, t = wx.getStorageSync("manage"), n = {
            ordernum: this.data.id,
            account: t.account,
            token: t.token
        };
        (0, _api.CheckPrizeData)(n).then(function(t) {
            wx.showModal({
                title: "提示",
                content: "核销成功！",
                showCancel: !1,
                success: function(t) {
                    wx.navigateBack({
                        delta: 1
                    });
                }
            });
        }).catch(function(t) {
            -1 === t.code ? e.tips(t.msg) : -2 === t.code ? (wx.setStorageSync("manage", ""), 
            wx.showModal({
                title: "提示",
                content: "登陆过期，请重新登陆！",
                showCancel: !1,
                success: function(t) {
                    _this.reTo("../login/login");
                }
            })) : e.tips("false");
        });
    }
}));