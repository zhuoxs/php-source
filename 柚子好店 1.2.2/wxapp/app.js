App({
    siteInfo: require("siteinfo.js"),
    util: require("/we7/js/util.js"),
    onLaunch: function() {
        var n = wx.getStorageSync("logs") || [];
        n.unshift(Date.now()), wx.setStorageSync("logs", n), wx.removeStorage("comeIn"), 
        wx.request({
            url: this.siteInfo.siteroot + "?i=" + this.siteInfo.uniacid + "&t=undefined&v=1.0.0&from=wxapp&c=entry&a=wxapp&do=Url&m=yzhd_sun",
            success: function(n) {
                console.log(n), wx.setStorageSync("url", n.data);
            }
        }), wx.login({
            success: function(n) {}
        });
    },
    onShow: function(n) {},
    getUserInfo: function() {
        wx.login({
            success: function() {
                wx.getUserInfo({
                    success: function(n) {
                        console.log(n);
                    }
                });
            }
        });
    },
    globalData: {
        userInfo: null
    }
});