var app = getApp();

Page({
    data: {},
    onPullDownRefresh: function() {
        wx.stopPullDownRefresh();
    },
    onLoad: function(a) {
        var t = this;
        app.util.request({
            url: "entry/wxapp/base",
            cachetime: "30",
            data: {
                vs1: 1
            },
            success: function(a) {
                t.setData({
                    baseinfo: a.data.data
                }), wx.setNavigationBarColor({
                    frontColor: t.data.baseinfo.base_tcolor,
                    backgroundColor: t.data.baseinfo.base_color
                });
            },
            fail: function(a) {}
        });
    },
    goback: function() {
        var a = this, s = wx.getStorageSync("openid");
        wx.getUserInfo({
            success: function(a) {
                var t = a.userInfo, e = t.nickName, n = t.avatarUrl, o = t.gender, r = t.province, c = t.city, i = t.country;
                app.util.request({
                    url: "entry/wxapp/Useupdate",
                    data: {
                        openid: s,
                        nickname: e,
                        avatarUrl: n,
                        gender: o,
                        province: r,
                        city: c,
                        country: i
                    },
                    header: {
                        "content-type": "application/json"
                    },
                    success: function(a) {
                        wx.setStorageSync("golobeuid", a.data.data.id), wx.setStorageSync("golobeuser", a.data.data), 
                        wx.navigateBack({
                            delta: 1
                        });
                    }
                });
            },
            fail: function() {
                app.util.selfinfoget(a.chenggfh);
            }
        });
    }
});