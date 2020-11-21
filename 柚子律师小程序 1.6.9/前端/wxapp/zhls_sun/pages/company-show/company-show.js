var app = getApp();

Page({
    data: {},
    onLoad: function(t) {
        var n = this;
        n.url(), app.util.request({
            url: "entry/wxapp/brief",
            cachetime: "0",
            success: function(t) {
                n.setData({
                    brief: t.data
                });
            }
        }), n.diyWinColor();
    },
    url: function(t) {
        var n = this;
        app.util.request({
            url: "entry/wxapp/Url2",
            cachetime: "0",
            success: function(t) {
                wx.setStorageSync("url2", t.data);
            }
        }), app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "0",
            success: function(t) {
                wx.setStorageSync("url", t.data), n.setData({
                    url: t.data
                });
            }
        });
    },
    callMe: function(t) {
        wx.makePhoneCall({
            phoneNumber: t.currentTarget.dataset.phone,
            success: function(t) {
                console.log("-----拨打电话成功-----");
            },
            fail: function(t) {
                console.log("-----拨打电话失败-----");
            }
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    diyWinColor: function(t) {
        wx.setNavigationBarColor({
            frontColor: "#ffffff",
            backgroundColor: "#618dfb"
        }), wx.setNavigationBarTitle({
            title: "关于我们"
        });
    }
});