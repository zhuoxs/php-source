var _extends = Object.assign || function(e) {
    for (var t = 1; t < arguments.length; t++) {
        var a = arguments[t];
        for (var r in a) Object.prototype.hasOwnProperty.call(a, r) && (e[r] = a[r]);
    }
    return e;
}, _reload = require("../../resource/js/reload.js"), _api = require("../../resource/js/api.js"), app = getApp();

Page(_extends({}, _reload.reload, {
    data: _extends({}, _reload.data),
    onLoad: function(e) {
        this.setData({
            hid: e.hid
        });
    },
    onloadData: function(e) {
        var t = this;
        e.detail.login && this.checkUrl().then(function(e) {
            return (0, _api.HouseDetailsData)({
                hid: t.data.hid
            });
        }).then(function(e) {
            t.setData({
                show: !0,
                info: e
            });
        }).catch(function(e) {
            -1 === e.code ? t.tips(e.msg) : t.tips("false");
        });
    }
}));