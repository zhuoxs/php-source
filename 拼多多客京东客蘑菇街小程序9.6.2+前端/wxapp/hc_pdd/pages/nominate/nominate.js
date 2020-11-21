var app = getApp();

Page({
    data: {
        motto: "Hello World",
        userInfo: {},
        hasUserInfo: !1,
        canIUse: wx.canIUse("button.open-type.getUserInfo"),
        circular: 0,
        currentTab: 0,
        navScrollLeft: 0
    },
    onLoad: function() {
        var a = this;
        wx.getSystemInfo({
            success: function(t) {
                a.setData({
                    windowHeight: t.windowHeight,
                    windowWidth: t.windowWidth
                });
            }
        });
    },
    switchNav: function(t) {
        var a = t.currentTarget.dataset.current, e = this.data.windowWidth / 5;
        if (this.setData({
            navScrollLeft: (a - 2) * e
        }), this.data.currentTab == a) return !1;
        this.setData({
            currentTab: a
        });
    },
    switchTab: function(t) {
        console.log(t);
        var a = t.detail.current, e = this.data.windowWidth / 5;
        this.setData({
            currentTab: a,
            navScrollLeft: (a - 2) * e
        });
    }
});