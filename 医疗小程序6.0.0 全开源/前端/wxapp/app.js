App({
    onLaunch: function() {
        var t = wx.getStorageSync("logs") || [];
        t.unshift(Date.now()), wx.setStorageSync("logs", t);
    },
    bgcolor: function(t) {
        this.globalData.bg = t;
    },
    globalData: {
        userInfo: null,
        bg: ""
    },
    util: require("we7/resource/js/util.js"),
    siteInfo: require("siteinfo.js")
});