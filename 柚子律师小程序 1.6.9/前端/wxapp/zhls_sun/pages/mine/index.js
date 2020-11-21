var app = getApp();

Page({
    data: {
        current: 0
    },
    goTap: function(n) {
        console.log(n);
        var t = this;
        t.setData({
            current: n.currentTarget.dataset.index
        }), 1 == t.data.current && wx.redirectTo({
            url: "../article/index?currentIndex=1"
        }), 2 == t.data.current && wx.redirectTo({
            url: "/zhls_sun/pages/lvshiList/lvshiList?currentIndex=2"
        }), 0 == t.data.current && wx.redirectTo({
            url: "../shouye/index?currentIndex=0"
        });
    },
    onLoad: function(t) {
        var e = this;
        e.url(), wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("fontcolor"),
            backgroundColor: wx.getStorageSync("color"),
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        });
        var n = wx.getStorageSync("user_info");
        e.setData({
            userInfo: n
        }), app.util.request({
            url: "entry/wxapp/tab",
            cachetime: "10",
            success: function(n) {
                e.setData({
                    tab: n.data,
                    current: t.currentIndex
                });
            }
        });
    },
    goAboutUs: function(n) {
        wx.navigateTo({
            url: "../company-show/company-show"
        });
    },
    url: function(n) {
        var t = this;
        app.util.request({
            url: "entry/wxapp/Url2",
            cachetime: "0",
            success: function(n) {
                wx.setStorageSync("url2", n.data);
            }
        }), app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "0",
            success: function(n) {
                wx.setStorageSync("url", n.data), t.setData({
                    url: n.data
                });
            }
        });
    },
    onShow: function() {},
    goYuyue: function(n) {
        wx.navigateTo({
            url: "../mine/yuyue"
        });
    },
    goFreeConsult: function(n) {
        wx.navigateTo({
            url: "../mine/freeConsult"
        });
    },
    goPayConsult: function(n) {
        wx.navigateTo({
            url: "../mine/payConsult"
        });
    },
    goShareHong: function(n) {
        wx.navigateTo({
            url: "../hongbao/index"
        });
    },
    guanli: function(n) {
        wx.navigateTo({
            url: "../manager/login/login"
        });
    },
    onReady: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {}
});