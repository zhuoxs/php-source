var app = getApp(), conf = require("../../utils/push-stat-conf.js");

Page({
    data: {
        isBackcg: !1
    },
    onLoad: function(a) {
        if (void 0 !== a && a.apId && a.pathTg) if (wx.navigateToMiniProgram) {
            var i = {}, t = decodeURIComponent(a.pathTg), o = "";
            if (-1 != t.indexOf("?")) {
                o = t.split("?")[1].split("&");
                for (var e = 0; e < o.length; e++) -1 != o[e].indexOf("=") && (i[o[e].split("=")[0]] = o[e].split("=")[1]);
            }
            wx.navigateToMiniProgram({
                appId: a.apId,
                path: t.split("?")[0],
                extraData: i,
                fail: function() {
                    wx.redirectTo({
                        url: conf.pageHomeBack,
                        fail: function(a) {
                            wx.switchTab({
                                url: conf.pageHomeBack
                            });
                        }
                    });
                }
            });
        } else wx.redirectTo({
            url: conf.pageHomeBack,
            fail: function(a) {
                wx.switchTab({
                    url: conf.pageHomeBack
                });
            }
        });
    },
    onShow: function() {
        this.data.isBackcg && wx.redirectTo({
            url: conf.pageHomeBack,
            fail: function(a) {
                wx.switchTab({
                    url: conf.pageHomeBack
                });
            }
        });
    },
    onHide: function() {
        this.setData({
            isBackcg: !0
        });
    }
});