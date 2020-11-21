var _extends = Object.assign || function(a) {
    for (var t = 1; t < arguments.length; t++) {
        var e = arguments[t];
        for (var i in e) Object.prototype.hasOwnProperty.call(e, i) && (a[i] = e[i]);
    }
    return a;
}, _reload = require("../../resource/js/reload.js"), _api = require("../../resource/js/api.js"), app = getApp();

Page(_extends({}, _reload.reload, {
    data: {
        bargain: !1
    },
    onLoad: function(a) {
        1 == a.bargain && this.setData({
            bargain: !0
        }), this.setData({
            id: a.id
        }), this.onloadData();
    },
    onloadData: function() {
        var t = this;
        if (this.data.bargain) {
            var a = {
                bid: this.data.id
            };
            (0, _api.BargainOrderData)(a).then(function(a) {
                t.setData({
                    info: a
                });
            });
        } else {
            var e = {
                id: this.data.id
            };
            (0, _api.SignInfoData)(e).then(function(a) {
                t.setData({
                    info: a
                });
            });
        }
    },
    onTelTab: function() {
        wx.makePhoneCall({
            phoneNumber: this.data.info.shopinfo.tel
        });
    }
}));