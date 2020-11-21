var app = getApp();

Page({
    data: {},
    onLoad: function(o) {
        var n = this;
        app.util.request({
            url: "entry/wxapp/Url",
            success: function(o) {
                console.log("页面加载请求"), console.log(o), wx.setStorageSync("url", o.data), n.setData({
                    url: o.data
                });
            }
        }), app.util.request({
            url: "entry/wxapp/About_us",
            success: function(o) {
                console.log("关于我们"), console.log(o), n.setData({
                    aboutUs: o.data
                });
            }
        }), n.diyWinColor();
    },
    callMe: function(o) {
        wx.makePhoneCall({
            phoneNumber: o.currentTarget.dataset.tel,
            success: function(o) {
                console.log("-----拨打电话成功-----");
            },
            fail: function(o) {
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
    diyWinColor: function(o) {
        wx.setNavigationBarColor({
            frontColor: "#ffffff",
            backgroundColor: "#ffb62b"
        }), wx.setNavigationBarTitle({
            title: "关于我们"
        });
    }
});