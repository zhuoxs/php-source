var app = getApp(), WxParse = require("../../../../we7/js/wxParse/wxParse.js");

Page({
    data: {
        aboutsdd: [],
        url: [],
        indicatorDots: !1,
        autoplay: !1,
        interval: 3e3,
        duration: 800,
        isIpx: app.globalData.isIpx
    },
    onLoad: function(a) {
        wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("fontcolor"),
            backgroundColor: wx.getStorageSync("color"),
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        });
    },
    onReady: function() {},
    onShow: function() {
        var t = this;
        app.util.request({
            url: "entry/wxapp/Aboutus",
            success: function(a) {
                t.setData({
                    aboutsdd: a.data
                }), t.getUrl(), WxParse.wxParse("article", "html", a.data.details, t, 5);
            }
        });
    },
    getUrl: function() {
        var t = this;
        app.util.request({
            url: "entry/wxapp/url",
            cachetime: "0",
            success: function(a) {
                wx.setStorageSync("url", a.data), t.setData({
                    url: a.data
                });
            }
        });
    },
    dialogYZ: function(a) {
        wx.makePhoneCall({
            phoneNumber: this.data.aboutsdd.tel
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    dialog: function(a) {
        wx.makePhoneCall({
            phoneNumber: this.data.phone
        });
    }
});