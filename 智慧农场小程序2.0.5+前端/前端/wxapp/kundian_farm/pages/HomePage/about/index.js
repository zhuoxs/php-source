var a = require("../../../../wxParse/wxParse.js"), t = new getApp();

Page({
    data: {},
    onLoad: function(e) {
        var s = t.siteInfo.uniacid, r = this;
        t.util.request({
            url: "entry/wxapp/class",
            data: {
                op: "getAboutData",
                uniacid: s,
                action: "index",
                control: "home"
            },
            success: function(t) {
                "" != t.data.aboutData.farm_desc && a.wxParse("article", "html", t.data.aboutData.farm_desc, r, 5);
            }
        });
    }
});