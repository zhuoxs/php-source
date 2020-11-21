var _extends = Object.assign || function(a) {
    for (var e = 1; e < arguments.length; e++) {
        var t = arguments[e];
        for (var r in t) Object.prototype.hasOwnProperty.call(t, r) && (a[r] = t[r]);
    }
    return a;
}, _reload = require("../../../common/js/reload.js"), _api = require("../../../common/js/api.js"), app = getApp(), wxParse = require("../../wxParse/wxParse.js");

Page(_extends({}, _reload.reload, {
    data: {},
    onLoad: function(a) {
        this.onloadData();
    },
    onloadData: function() {
        var e = this;
        this.checkUrl().then(function(a) {
            return (0, _api.HelpsData)();
        }).then(function(a) {
            e.setData({
                msg: a
            }), wxParse.wxParse("detail", "html", a.content, e, 20);
        }).catch(function(a) {
            -1 === a.code ? e.tips(a.msg) : e.tips("false");
        });
    }
}));