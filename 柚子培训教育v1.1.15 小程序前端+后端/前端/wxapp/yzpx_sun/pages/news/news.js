var _extends = Object.assign || function(t) {
    for (var e = 1; e < arguments.length; e++) {
        var n = arguments[e];
        for (var a in n) Object.prototype.hasOwnProperty.call(n, a) && (t[a] = n[a]);
    }
    return t;
}, _reload = require("../../resource/js/reload.js"), _api = require("../../resource/js/api.js"), app = getApp(), WxParse = require("../components/wxParse/wxParse.js");

Page(_extends({}, _reload.reload, {
    onLoad: function(t) {
        this.setData({
            nid: t.nid
        });
    },
    onloadData: function(t) {
        var e = this;
        t.detail.login && (this.setData({
            login: t.detail.login
        }), this.checkUrl().then(function(t) {
            (0, _api.NewsDetailsData)({
                nid: e.data.nid
            }).then(function(t) {
                WxParse.wxParse("content", "html", t.content, e, 0), e.setData({
                    info: t
                });
            });
        }).catch(function(t) {
            wx.showToast({
                title: t.msg,
                icon: "none",
                duration: 2e3
            });
        }));
    },
    onShareAppMessage: function(t) {
        return {
            title: this.data.info.title,
            path: "/yzpx_sun/pages/news/news?nid=" + this.data.nid
        };
    }
}));