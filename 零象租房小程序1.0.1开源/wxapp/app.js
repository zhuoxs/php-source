App({
    data: {},
    siteInfo: require("siteinfo.js"),
    util: require("we7/resource/js/util.js"),
    onLaunch: function() {},
    upLoad: function() {},
    uid: function(e) {
        var n = wx.getStorageSync("uid");
        if (n) return n;
        this.util.getUserInfo(function(e) {
            if (e.memberInfo) {
                var n = e.memberInfo.uid;
                return wx.setStorageSync("uid", n), n;
            }
            return "";
        });
    },
    globalData: {
        userInfo: null
    }
});