var _App;

function _defineProperty(e, n, t) {
    return n in e ? Object.defineProperty(e, n, {
        value: t,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : e[n] = t, e;
}

App((_defineProperty(_App = {
    siteInfo: require("siteinfo.js"),
    util: require("/we7/js/util.js"),
    onLaunch: function() {
        var n = this, e = wx.getStorageSync("logs") || [];
        e.unshift(Date.now()), wx.setStorageSync("logs", e), wx.clearStorage("comeIn"), 
        wx.login({
            success: function(e) {}
        }), wx.getSetting({
            success: function(e) {
                e.authSetting["scope.userInfo"] && wx.getUserInfo({
                    success: function(e) {
                        n.globalData.userInfo = e.userInfo, n.userInfoReadyCallback && n.userInfoReadyCallback(e);
                    }
                });
            }
        });
    },
    globalData: {
        userInfo: null
    }
}, "siteInfo", require("siteinfo.js")), _defineProperty(_App, "util", require("/we7/js/util.js")), 
_App));