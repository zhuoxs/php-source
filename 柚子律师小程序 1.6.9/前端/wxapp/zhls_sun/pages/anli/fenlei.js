var app = getApp();

Page({
    data: {},
    onLoad: function(t) {
        var a = this;
        wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("fontcolor"),
            backgroundColor: wx.getStorageSync("color"),
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        });
        var n = t.id;
        app.util.request({
            url: "entry/wxapp/anliIdData",
            cachetime: "0",
            data: {
                id: n
            },
            success: function(t) {
                a.setData({
                    anliIdData: t.data
                });
            }
        }), app.util.request({
            url: "entry/wxapp/anlipayData",
            cachetime: "0",
            data: {
                id: n
            },
            success: function(t) {
                console.log(t.data), a.setData({
                    payData: t.data
                });
            }
        }), wx.setNavigationBarTitle({
            title: t.title
        });
    },
    consultDetails: function(t) {
        t.currentTarget.dataset.pid && wx.navigateTo({
            url: "../consult/details?pid=" + t.currentTarget.dataset.pid
        }), t.currentTarget.dataset.mid && wx.navigateTo({
            url: "../consult/details?mid=" + t.currentTarget.dataset.mid
        }), t.currentTarget.dataset.fid && wx.navigateTo({
            url: "../consult/details?fid=" + t.currentTarget.dataset.fid
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