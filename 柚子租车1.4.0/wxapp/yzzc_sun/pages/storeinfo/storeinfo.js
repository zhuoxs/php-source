var _extends = Object.assign || function(t) {
    for (var a = 1; a < arguments.length; a++) {
        var s = arguments[a];
        for (var n in s) Object.prototype.hasOwnProperty.call(s, n) && (t[n] = s[n]);
    }
    return t;
}, _reload = require("../../common/js/reload.js"), _api = require("../../common/js/api.js"), app = getApp();

Page(_extends({}, _reload.reload, {
    data: {},
    onLoad: function(t) {
        this.setData({
            options: t
        });
    },
    onloadData: function(t) {
        var a = this;
        t.detail.login && (this.setData({
            show: !0
        }), this.checkUrl().then(function(t) {
            a.onloadDatas(a.data.options);
        }).catch(function(t) {
            -1 === t.code ? a.tips(t.msg) : a.tips("false");
        }));
    },
    onloadDatas: function(t) {
        var a = this, s = {
            id: t.sid
        };
        (0, _api.BranchData)(s).then(function(t) {
            a.setData({
                msg: t
            });
        }, function(t) {
            console.log("err" + t);
        });
    },
    goSelectCar: function() {
        var t = {
            city: this.data.msg.city_name,
            name: this.data.msg.area_name + this.data.msg.name,
            sid: this.data.msg.id
        };
        t = JSON.stringify(t), this.navTo("../choosetime/choosetime?table=6&param=" + t);
    },
    onGPSTab: function() {
        wx.openLocation({
            latitude: this.data.msg.lat - 0,
            longitude: this.data.msg.lng - 0,
            scale: 28
        });
    },
    onShareAppMessage: function() {
        return {
            title: this.data.msg.name,
            path: "/yzzc_sun/pages/storeinfo/storeinfo?sid=" + this.data.msg.id
        };
    }
}));