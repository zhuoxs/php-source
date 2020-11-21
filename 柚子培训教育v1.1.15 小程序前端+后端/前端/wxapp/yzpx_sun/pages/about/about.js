var _extends = Object.assign || function(e) {
    for (var t = 1; t < arguments.length; t++) {
        var a = arguments[t];
        for (var r in a) Object.prototype.hasOwnProperty.call(a, r) && (e[r] = a[r]);
    }
    return e;
}, _reload = require("../../resource/js/reload.js"), _api = require("../../resource/js/api.js");

function _defineProperty(e, t, a) {
    return t in e ? Object.defineProperty(e, t, {
        value: a,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : e[t] = a, e;
}

var app = getApp();

Page(_extends({}, _reload.reload, {
    data: {
        markers: [ {
            iconPath: "../../resource/images/gps.png",
            id: 0,
            latitude: 23.099994,
            longitude: 113.32452,
            width: 20,
            height: 25
        } ]
    },
    onLoad: function(e) {
        var a = this, t = wx.getStorageSync("shopinfo");
        if (this.setData({
            sid: t.sid
        }), e.sid) var r = {
            sid: t.sid
        };
        this.checkUrl().then(function(e) {
            return (0, _api.WeData)(r);
        }).then(function(e) {
            var t;
            a.setData((_defineProperty(t = {
                info: e
            }, "markers[0].latitude", e.lat), _defineProperty(t, "markers[0].longitude", e.lng), 
            t));
        }).catch(function(e) {
            -1 === e.code ? a.tips(e.msg) : a.tips("false");
        });
    },
    onTelTab: function() {
        wx.makePhoneCall({
            phoneNumber: this.data.info.tel
        });
    },
    onGPSTab: function() {
        var e = this.data.info.lat - 0, t = this.data.info.lng - 0;
        wx.openLocation({
            latitude: e,
            longitude: t,
            scale: 28
        });
    }
}));