var app = getApp();

Page({
    data: {},
    onLoad: function(o) {
        var n = this, a = wx.getStorageSync("build_id");
        wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("fontcolor"),
            backgroundColor: wx.getStorageSync("color"),
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        }), wx.getStorage({
            key: "openid",
            success: function(o) {
                app.util.request({
                    url: "entry/wxapp/Mycoupon",
                    cachetime: "0",
                    data: {
                        uid: o.data,
                        build_id: a
                    },
                    success: function(o) {
                        console.log(o.data.data), n.setData({
                            cards: o.data.data
                        });
                    }
                });
            }
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    goToCoupon: function() {
        wx.navigateTo({
            url: "../../index/hairs/hairs"
        });
    },
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {}
});