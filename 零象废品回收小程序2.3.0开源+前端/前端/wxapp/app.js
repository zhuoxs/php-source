App({
    data: {},
    siteInfo: require("siteinfo.js"),
    util: require("we7/resource/js/util.js"),
    onLaunch: function() {},
    upLoad: function() {},
    uid: function(e) {
        var u = wx.getStorageSync("uid");
        if (u) return u;
        this.util.getUserInfo(function(e) {
            if (e.memberInfo) {
                var u = e.memberInfo.uid;
                return wx.setStorageSync("uid", u), u;
            }
            return "";
        });
    },
    uplaod: function(e) {
        var u = this;
        wx.chooseImage({
            count: 1,
            sizeType: [ "original", "compressed" ],
            success: function(t) {
                var n = t.tempFilePaths;
                wx.uploadFile({
                    url: u.util.url("entry/wxapp/Api", {
                        m: "ox_uxuanke",
                        r: "upload.save"
                    }),
                    filePath: n[0],
                    name: "file",
                    success: function(u) {
                        var t = JSON.parse(u.data);
                        "function" == typeof e && e(t.data);
                    }
                });
            }
        });
    },
    globalData: {
        userInfo: null
    }
});