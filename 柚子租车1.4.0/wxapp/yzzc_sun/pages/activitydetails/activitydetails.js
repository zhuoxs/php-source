var _extends = Object.assign || function(e) {
    for (var a = 1; a < arguments.length; a++) {
        var n = arguments[a];
        for (var o in n) Object.prototype.hasOwnProperty.call(n, o) && (e[o] = n[o]);
    }
    return e;
}, _reload = require("../../common/js/reload.js"), _api = require("../../common/js/api.js"), app = getApp();

Page(_extends({}, _reload.reload, {
    data: {
        imgLink: "",
        nonePage: 0
    },
    goYuding: function(e) {
        wx.navigateTo({
            url: "../choosetime/choosetime?table=3"
        });
    },
    onLoad: function(e) {
        this.onloadData(e);
    },
    onloadData: function(e) {
        var a = this, n = {
            aid: e.aid
        };
        this.checkUrl().then(function(e) {
            return (0, _api.ActiveInfoData)(n);
        }).then(function(e) {
            a.setData({
                msg: e
            });
        }).catch(function(e) {
            -1 === e.code ? (a.setData({
                nonePage: 1
            }), wx.showModal({
                content: e.msg + "",
                showCancel: !1,
                confirmText: "朕知道了",
                success: function(e) {
                    wx.reLaunch({
                        url: "../home/home"
                    });
                }
            })) : a.tips("false");
        });
    }
}));