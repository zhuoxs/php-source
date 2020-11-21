var app = getApp();

App({
    globalData: {},
    userInfo: null,
    hasshowpopad: !1,
    onLaunch: function(t) {
        console.log(t.scene), wx.removeStorageSync("comeIn");
        var e = wx.getStorageSync("logs") || [];
        e.unshift(Date.now()), wx.setStorageSync("logs", e), wx.login({
            success: function(t) {}
        }), wx.request({
            url: this.siteInfo.siteroot + "?i=" + this.siteInfo.uniacid + "&t=undefined&v=1.0.0&from=wxapp&c=entry&a=wxapp&do=Url&m=chbl_sun",
            success: function(t) {
                console.log(t), wx.setStorageSync("url", t.data);
            }
        });
    },
    onShow: function(t) {
        this.shareTicket, t && t.scene && 1044 == t.scene && (this.shareTicket = t.shareTicket ? t.shareTicket : "");
    },
    siteInfo: require("siteinfo.js"),
    util: require("util.js"),
    get_current_county: function() {
        var c = !(0 < arguments.length && void 0 !== arguments[0]) || arguments[0], s = this;
        return new Promise(function(o, t) {
            var e = s.globalData.current_county;
            e && c ? o(e) : s.get_location().then(function(t) {
                var e = t.latitude, n = t.longitude;
                s.util.request({
                    url: "entry/wxapp/AddressInfo",
                    cachetime: "30",
                    fromcache: c,
                    data: {
                        latitude: e,
                        longitude: n
                    },
                    success: function(t) {
                        2 != t.data && (o(t.data), s.set_current_county(t.data));
                    }
                });
            });
        });
    },
    set_current_county: function(t) {
        this.globalData.current_county = t;
    },
    get_location: function() {
        !(0 < arguments.length && void 0 !== arguments[0]) || arguments[0];
        return new Promise(function(e, t) {
            wx.getLocation({
                type: "wgs84",
                success: function(t) {
                    e(t);
                }
            });
        });
    }
});