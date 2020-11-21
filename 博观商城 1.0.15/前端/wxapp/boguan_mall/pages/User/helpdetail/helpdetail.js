var t = require("../../../utils/base.js"), e = require("../../../../wxParse/wxParse.js"), a = require("../../../../api.js"), i = new t.Base(), r = getApp();

Page({
    data: {},
    onLoad: function(t) {
        r.pageOnLoad(), 1 == t.type ? this.getAbout() : this.getHelp(t.helpId);
    },
    getHelp: function(t) {
        var r = this, n = {
            url: a.default.help_detail,
            data: {
                helpId: t
            },
            method: "GET"
        };
        i.getData(n, function(t) {
            if (1 == t.errorCode) {
                var a = t.data.content;
                e.wxParse("content", "html", a, r), wx.setNavigationBarTitle({
                    title: t.data.title
                });
            }
        });
    },
    getAbout: function() {
        var t = this, r = {
            url: a.default.about_detail,
            method: "GET"
        };
        i.getData(r, function(a) {
            if (1 == a.errorCode) {
                var i = a.data.content;
                e.wxParse("content", "html", i, t), wx.setNavigationBarTitle({
                    title: a.data.title
                });
            }
        });
    }
});