var app = getApp();

Page({
    data: {
        current: 0,
        currentType: 0,
        tabClass: [ "", "", "", "" ]
    },
    goTap: function(t) {
        console.log(t);
        var e = this;
        e.setData({
            current: t.currentTarget.dataset.index
        }), 0 == e.data.current && wx.redirectTo({
            url: "../shouye/index?currentIndex=0"
        }), 2 == e.data.current && wx.redirectTo({
            url: "/zhls_sun/pages/lvshiList/lvshiList?currentIndex=2"
        }), 3 == e.data.current && wx.redirectTo({
            url: "../mine/index?currentIndex=3"
        });
    },
    onLoad: function(e) {
        var n = this;
        n.url(), wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("fontcolor"),
            backgroundColor: wx.getStorageSync("color"),
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        }), app.util.request({
            url: "entry/wxapp/tab",
            cachetime: "10",
            success: function(t) {
                n.setData({
                    tab: t.data,
                    current: e.currentIndex
                });
            }
        }), app.util.request({
            url: "entry/wxapp/Category",
            cachetime: "0",
            success: function(t) {
                var e = 750 / t.data.length;
                if (250 <= e) var a = e; else a = 250;
                n.setData({
                    statusType: t.data,
                    Wid: a
                });
            }
        }), app.util.request({
            url: "entry/wxapp/MoData",
            cachetime: "0",
            success: function(t) {
                n.setData({
                    anliList: t.data
                });
            }
        });
    },
    url: function(t) {
        var e = this;
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
                wx.setStorageSync("url", t.data), e.setData({
                    url: t.data
                });
            }
        });
    },
    statusTap: function(t) {
        var e = this, a = t.currentTarget.dataset.index, n = t.currentTarget.dataset.id;
        e.data.currentType = a, app.util.request({
            url: "entry/wxapp/CateData",
            cachetime: "0",
            data: {
                cid: n
            },
            success: function(t) {
                e.setData({
                    anliList: t.data,
                    currentType: a
                });
            }
        }), e.onShow();
    },
    goDetails: function(t) {
        console.log(t), wx.navigateTo({
            url: "../article/details?id=" + t.currentTarget.dataset.id
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