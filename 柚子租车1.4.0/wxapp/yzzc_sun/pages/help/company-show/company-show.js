var _extends = Object.assign || function(e) {
    for (var t = 1; t < arguments.length; t++) {
        var a = arguments[t];
        for (var r in a) Object.prototype.hasOwnProperty.call(a, r) && (e[r] = a[r]);
    }
    return e;
}, _reload = require("../../../common/js/reload.js"), _api = require("../../../common/js/api.js");

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
        imgLink: wx.getStorageSync("url"),
        markers: [ {
            id: 0,
            latitude: 23.099994,
            longitude: 113.32452,
            width: 50,
            height: 50
        } ]
    },
    onLoad: function(e) {
        this.onloadData();
    },
    onloadData: function() {
        var a = this;
        this.checkUrl().then(function(e) {
            return (0, _api.WeData)();
        }).then(function(e) {
            var t;
            a.setData((_defineProperty(t = {
                msg: e
            }, "markers[0].latitude", e.lat), _defineProperty(t, "markers[0].longitude", e.lng), 
            t));
        }).catch(function(e) {
            -1 === e.code ? a.tips(e.msg) : a.tips("false");
        });
    },
    callMe: function(e) {
        wx.makePhoneCall({
            phoneNumber: this.data.msg.tel
        });
    }
}));