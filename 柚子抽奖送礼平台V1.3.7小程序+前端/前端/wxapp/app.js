var App = require("zhy/sdk/qitui/oddpush.js").oddPush(App, "App").App;

App({
    globalData: {
        userInfo: null,
        adBtn: !1
    },
    siteInfo: require("siteinfo.js"),
    util: require("/we7/js/util.js"),
    func: require("func.js"),
    onLaunch: function() {
        wx.request({
            url: this.siteInfo.siteroot + "?i=" + this.siteInfo.uniacid + "&t=undefined&v=1.0.0&from=wxapp&c=entry&a=wxapp&do=GetqtappData&m=yzcj_sun",
            header: {
                "content-type": "application/json"
            },
            success: function(t) {
                console.log(t.data);
                var e = t.data;
                wx.setStorageSync("qitui", e);
            }
        });
    }
});