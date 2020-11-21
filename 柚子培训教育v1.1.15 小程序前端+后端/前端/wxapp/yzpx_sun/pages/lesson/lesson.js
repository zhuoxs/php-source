var _extends = Object.assign || function(e) {
    for (var t = 1; t < arguments.length; t++) {
        var a = arguments[t];
        for (var r in a) Object.prototype.hasOwnProperty.call(a, r) && (e[r] = a[r]);
    }
    return e;
}, _reload = require("../../resource/js/reload.js"), _api = require("../../resource/js/api.js"), app = getApp(), WxParse = require("../components/wxParse/wxParse.js");

Page(_extends({}, _reload.reload, {
    data: {},
    onLoad: function(e) {
        this.setData({
            lid: e.lid
        }), this.onloadData();
    },
    onloadData: function() {
        var t = this, a = {
            lid: this.data.lid
        };
        this.checkUrl().then(function(e) {
            return (0, _api.LessonInfoData)(a);
        }).then(function(e) {
            WxParse.wxParse("content", "html", e.content, t, 0), t.setData({
                info: e
            });
        }).catch(function(e) {
            -1 === e.code ? t.tips(e.msg) : t.tips("false");
        });
    }
}));