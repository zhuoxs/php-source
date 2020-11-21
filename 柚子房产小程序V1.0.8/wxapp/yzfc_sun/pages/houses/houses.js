var _extends = Object.assign || function(a) {
    for (var t = 1; t < arguments.length; t++) {
        var o = arguments[t];
        for (var i in o) Object.prototype.hasOwnProperty.call(o, i) && (a[i] = o[i]);
    }
    return a;
}, _reload = require("../../resource/js/reload.js"), _api = require("../../resource/js/api.js"), app = getApp();

Page(_extends({}, _reload.reload, {
    data: _extends({}, _reload.data),
    onLoad: function(a) {
        this.setData({
            hid: a.hid
        });
    },
    onloadData: function(a) {
        var t = this;
        a.detail.login && this.checkUrl().then(function(a) {
            return (0, _api.HouseDetailsData)({
                hid: t.data.hid
            });
        }).then(function(a) {
            t.setData({
                show: !0,
                info: a
            });
        }).catch(function(a) {
            -1 === a.code ? t.tips(a.msg) : t.tips("false");
        });
    },
    onCalculatorTab: function() {
        this.navTo("../calculator/calculator?hid=" + this.data.hid);
    },
    onHouseListTab: function() {
        this.navTo("../houselist/houselist?hid=" + this.data.hid);
    },
    onBookingTab: function() {
        this.navTo("../booking/booking?hid=" + this.data.hid);
    },
    onHousesMoreTab: function() {
        this.navTo("../housesmore/housesmore?hid=" + this.data.hid);
    },
    onTelTab: function() {
        wx.makePhoneCall({
            phoneNumber: this.data.info.tel
        });
    },
    onHouseTab: function(a) {
        var t = a.currentTarget.dataset.idx;
        this.navTo("../house/house?id=" + this.data.info.rec[t].id);
    }
}));