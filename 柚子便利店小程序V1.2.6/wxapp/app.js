App({
    onLaunch: function() {},
    onShow: function() {
        var e = this;
        wx.getSystemInfo({
            success: function(s) {
                -1 != s.model.search("iPhone X") && (e.globalData.isIpx = !0);
            }
        });
    },
    siteInfo: require("siteinfo.js"),
    util: require("/we7/js/util.js"),
    globalData: {
        userInfo: null,
        showMaskFlag: !0,
        isIpx: !1
    }
});