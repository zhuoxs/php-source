var app = getApp();

Page({
    data: {
        motto: "Hello World",
        userInfo: {},
        hasUserInfo: !1,
        canIUse: wx.canIUse("button.open-type.getUserInfo")
    },
    bindViewTap: function() {
        wx.navigateTo({
            url: "../logs/logs"
        });
    },
    onLoad: function() {
        var a = this;
        wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("fontcolor"),
            backgroundColor: wx.getStorageSync("color"),
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        }), app.globalData.userInfo ? this.setData({
            userInfo: app.globalData.userInfo,
            hasUserInfo: !0
        }) : this.data.canIUse ? app.userInfoReadyCallback = function(o) {
            a.setData({
                userInfo: o.userInfo,
                hasUserInfo: !0
            });
        } : wx.getUserInfo({
            success: function(o) {
                app.globalData.userInfo = o.userInfo, a.setData({
                    userInfo: o.userInfo,
                    hasUserInfo: !0
                });
            }
        });
    },
    getUserInfo: function(o) {
        console.log(o), app.globalData.userInfo = o.detail.userInfo, this.setData({
            userInfo: o.detail.userInfo,
            hasUserInfo: !0
        });
    }
});