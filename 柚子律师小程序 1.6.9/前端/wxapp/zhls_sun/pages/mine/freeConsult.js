var app = getApp();

Page({
    data: {},
    onLoad: function(n) {
        var o = this;
        wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("fontcolor"),
            backgroundColor: wx.getStorageSync("color"),
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        }), wx.getStorage({
            key: "openid",
            success: function(n) {
                app.util.request({
                    url: "entry/wxapp/Usermian",
                    cachetime: "0",
                    data: {
                        openid: n.data
                    },
                    success: function(n) {
                        console.log(n.data), o.setData({
                            mianData: n.data
                        });
                    }
                });
            }
        });
    },
    onShow: function() {
        this.getUserInfo();
    },
    getUserInfo: function() {
        var o = this;
        wx.login({
            success: function() {
                wx.getUserInfo({
                    success: function(n) {
                        o.setData({
                            userInfo: n.userInfo
                        });
                    }
                });
            }
        });
    },
    consultDetails: function(n) {
        wx.navigateTo({
            url: "../mineConsult/details?mid=" + n.currentTarget.dataset.id
        });
    },
    onReady: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {}
});