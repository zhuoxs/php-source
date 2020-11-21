var _extends = Object.assign || function(a) {
    for (var t = 1; t < arguments.length; t++) {
        var e = arguments[t];
        for (var n in e) Object.prototype.hasOwnProperty.call(e, n) && (a[n] = e[n]);
    }
    return a;
}, _reload = require("../../resource/js/reload.js"), _api = require("../../resource/js/api.js"), app = getApp(), WxParse = require("../common/wxParse/wxParse.js");

Page(_extends({}, _reload.reload, {
    data: _extends({}, _reload.data),
    onLoad: function(a) {
        this.onloadData();
    },
    onloadData: function() {
        var t = this;
        this.checkUrl().then(function(a) {
            return (0, _api.CompanyData)();
        }).then(function(a) {
            t.setData({
                show: !0,
                info: a[0]
            }), WxParse.wxParse("content", "html", a[0].content, t, 0);
        }).catch(function(a) {
            -1 === a.code ? t.tips(a.msg) : t.tips("false");
        });
    },
    onTelTab: function() {
        wx.makePhoneCall({
            phoneNumber: this.data.info.tel
        });
    },
    onMapTab: function() {
        this.GPSMap(this.data.info.lat, this.data.info.lng);
    },
    onShopListTab: function() {
        this.navTo("../shoplist/shoplist");
    }
}));