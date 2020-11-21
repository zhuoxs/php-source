var app = getApp();

Page({
    data: {},
    onLoad: function(o) {
        wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("fontcolor"),
            backgroundColor: wx.getStorageSync("color"),
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        });
    },
    formSubmit: function(o) {
        console.log(o);
        var n = o.detail.value.password, t = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/ActiveCode",
            cachetime: "0",
            data: {
                code: n,
                openid: t
            },
            success: function(o) {
                console.log(o), wx.showModal({
                    title: "提示",
                    content: "激活成功！",
                    showCancel: !1,
                    success: function(o) {
                        wx.navigateTo({
                            url: "../eater-card/index"
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
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {}
});