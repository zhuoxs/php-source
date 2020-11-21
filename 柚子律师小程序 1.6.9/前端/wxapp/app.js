App({
    onLaunch: function() {
        var e = this, n = wx.getStorageSync("logs") || [];
        n.unshift(Date.now()), wx.setStorageSync("logs", n), wx.login({
            success: function(n) {}
        }), wx.getSetting({
            success: function(n) {
                n.authSetting["scope.userInfo"] && wx.getUserInfo({
                    success: function(n) {
                        e.globalData.userInfo = n.userInfo, e.userInfoReadyCallback && e.userInfoReadyCallback(n);
                    }
                });
            }
        });
    },
    onShow: function() {
        this.getUserInfo();
    },
    getUserInfo: function() {
        wx.login({
            success: function() {
                wx.getUserInfo({
                    success: function(n) {
                        console.log(n), wx.setStorageSync("userInfo", n.userInfo);
                    }
                });
            }
        });
    },
    globalData: {
        userInfo: null,
        comeIn: !1
    },
    siteInfo: require("siteinfo.js"),
    util: require("/we7/js/util.js")
});