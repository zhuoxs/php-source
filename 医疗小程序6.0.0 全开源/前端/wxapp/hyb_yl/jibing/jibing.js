var app = getApp();

Page({
    data: {
        fl_id: "",
        currentTab: 0
    },
    taocan1: function(a) {
        var t = this, n = a.currentTarget.dataset.id;
        t.setData({
            fl_id: n,
            currentTab: 0
        }), app.util.request({
            url: "entry/wxapp/Kcfl",
            data: {
                fl_id: n
            },
            success: function(a) {
                console.log(a), t.setData({
                    dataarray: a.data.data
                });
            },
            fail: function(a) {
                console.log(a);
            }
        });
    },
    taocan: function(a) {
        var t = this;
        console.log(a.currentTarget.dataset.id);
        var n = a.currentTarget.dataset.id;
        t.setData({
            fl_id: n,
            currentTab: a.currentTarget.dataset.index + 1
        }), app.util.request({
            url: "entry/wxapp/Kcfl",
            data: {
                fl_id: n
            },
            cachetime: "0",
            success: function(a) {
                console.log(a), t.setData({
                    dataarray: a.data.data
                });
            },
            fail: function(a) {
                console.log(a);
            }
        });
    },
    onLoad: function(a) {
        var t = wx.getStorageSync("color"), n = a.biaoti3;
        wx.setNavigationBarTitle({
            title: n
        }), wx.setNavigationBarColor({
            frontColor: "#ffffff",
            backgroundColor: t
        }), this.getBase();
        var o = this;
        wx.getStorageSync("openid");
        o.setData({
            currentTab: a.index
        }), app.util.request({
            url: "entry/wxapp/Schoolflarray",
            data: {},
            cachetime: "0",
            success: function(a) {
                console.log(a), o.setData({
                    taocan: a.data.data
                });
            },
            fail: function(a) {
                console.log(a);
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
    getBase: function(a) {
        var t = this, n = t.data.fl_id;
        console.log(n), app.util.request({
            url: "entry/wxapp/Kcfl",
            data: {
                fl_id: n
            },
            success: function(a) {
                t.setData({
                    dataarray: a.data.data
                });
            },
            fail: function(a) {
                console.log(a);
            }
        });
    }
});