var app = getApp();

Page({
    data: {},
    onLoad: function(n) {
        this.getUserInfo(), wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("fontcolor"),
            backgroundColor: wx.getStorageSync("color"),
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        });
        var o = this;
        wx.getStorage({
            key: "openid",
            success: function(n) {
                app.util.request({
                    url: "entry/wxapp/Userpay",
                    cachetime: "0",
                    data: {
                        openid: n.data
                    },
                    success: function(n) {
                        console.log(n.data), o.setData({
                            payData: n.data
                        });
                    }
                });
            }
        });
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
            url: "../mineConsult/details?fid=" + n.currentTarget.dataset.fid
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {}
});