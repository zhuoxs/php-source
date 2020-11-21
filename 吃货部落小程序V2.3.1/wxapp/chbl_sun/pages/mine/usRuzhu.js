var app = getApp();

Page({
    data: {},
    onLoad: function(t) {
        wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("fontcolor"),
            backgroundColor: wx.getStorageSync("color"),
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        });
    },
    onShow: function() {
        this.getUserInfo();
    },
    getUserInfo: function() {
        var n = this;
        wx.login({
            success: function() {
                wx.getUserInfo({
                    success: function(t) {
                        console.log(t), n.setData({
                            userInfo: t.userInfo
                        });
                    }
                });
            }
        });
    },
    goActivityList: function(t) {
        wx.navigateTo({
            url: "../activity/jika"
        });
    },
    addActivity: function(t) {
        wx.getStorage({
            key: "openid",
            success: function(t) {
                app.util.request({
                    url: "entry/wxapp/storeActivedq",
                    cachetime: "0",
                    data: {
                        user_id: t.data
                    },
                    success: function(t) {
                        if (console.log(t), 1 == t.data.data) wx.navigateTo({
                            url: "../add-activity/index"
                        }); else {
                            var n = t.data.data;
                            app.util.request({
                                url: "entry/wxapp/delStoreActive",
                                cachetime: "0",
                                data: {
                                    id: n
                                },
                                success: function(t) {
                                    console.log(t), wx.showToast({
                                        title: "您的入驻已到期，请重新入驻",
                                        icon: "none",
                                        duration: 2e3
                                    });
                                }
                            });
                        }
                    }
                });
            }
        });
    },
    backFirst: function(t) {
        wx.switchTab({
            url: "../first/index"
        });
    },
    onReady: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {}
});