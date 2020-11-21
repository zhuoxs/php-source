var app = getApp();

Page({
    data: {
        currentTab: 0
    },
    taocan: function(a) {
        var t = this, n = a.currentTarget.dataset.id;
        app.util.request({
            url: "entry/wxapp/Zixunall",
            data: {
                zx_id: n
            },
            success: function(a) {
                console.log(a), t.setData({
                    zixun: a.data.data
                });
            },
            fail: function(a) {
                console.log(a);
            }
        }), this.setData({
            currentTab: a.currentTarget.dataset.index + 1
        });
    },
    taocan1: function(a) {
        console.log(a);
        var t = this, n = a.currentTarget.dataset.id;
        app.util.request({
            url: "entry/wxapp/Zixunall",
            data: {
                zx_id: n
            },
            success: function(a) {
                console.log(a), t.setData({
                    zixun: a.data.data
                });
            },
            fail: function(a) {
                console.log(a);
            }
        }), this.setData({
            currentTab: 0
        });
    },
    onLoad: function(a) {
        var t = a.biaoti2;
        wx.setNavigationBarTitle({
            title: t
        });
        var n = wx.getStorageSync("color");
        wx.setNavigationBarColor({
            frontColor: "#ffffff",
            backgroundColor: n
        });
        var o = this, e = a.id;
        console.log(e), o.setData({
            currentTab: e
        }), null != e ? app.util.request({
            url: "entry/wxapp/Zixunyi",
            data: {
                zx_id: e
            },
            success: function(a) {
                console.log(a), o.setData({
                    zixun: a.data.data
                });
            },
            fail: function(a) {
                console.log(a);
            }
        }) : app.util.request({
            url: "entry/wxapp/Zixunallarray",
            data: {},
            success: function(a) {
                console.log(a), o.setData({
                    zixun: a.data.data
                });
            },
            fail: function(a) {
                console.log(a);
            }
        }), app.util.request({
            url: "entry/wxapp/Fenliarray",
            data: {},
            success: function(a) {
                o.setData({
                    taocan: a.data.data
                });
            },
            fail: function(a) {
                console.log(a);
            }
        });
    },
    onReady: function() {
        this.getScurl();
    },
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    getScurl: function() {
        var t = this;
        app.util.request({
            url: "entry/wxapp/Scurl",
            success: function(a) {
                t.setData({
                    dataurl: a.data.data
                });
            },
            fail: function(a) {
                console.log(a);
            }
        });
    }
});