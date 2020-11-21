var app = getApp();

Page({
    data: {
        taocan: [],
        currentTab: 0,
        huanzhe: [ {
            name: "患者案例",
            list: []
        } ]
    },
    taocan: function(a) {
        this.setData({
            currentTab: a.currentTarget.dataset.index + 1
        });
        var t = this, n = a.currentTarget.dataset.id;
        app.util.request({
            url: "entry/wxapp/Hzfl",
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
    },
    taocan1: function(a) {
        var t = this;
        console.log(a);
        var n = a.currentTarget.dataset.id;
        t.setData({
            currentTab: 0
        }), app.util.request({
            url: "entry/wxapp/Hzfl",
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
    onLoad: function(a) {
        var t = wx.getStorageSync("color");
        wx.setNavigationBarColor({
            frontColor: "#ffffff",
            backgroundColor: t
        });
        var n = this;
        wx.getStorageSync("openid");
        n.setData({
            currentTab: a.index
        });
        var o = a.biaoti1;
        wx.setNavigationBarTitle({
            title: o
        }), app.util.request({
            url: "entry/wxapp/Schoolfl",
            data: {},
            success: function(a) {
                console.log(a), n.setData({
                    taocan: a.data.data
                });
            },
            fail: function(a) {
                console.log(a);
            }
        }), app.util.request({
            url: "entry/wxapp/Selecthzfl",
            data: {},
            success: function(a) {
                console.log(a.data.data), n.setData({
                    dataarrays: a.data.data
                });
            },
            fail: function(a) {
                console.log(a);
            }
        });
    },
    onReady: function() {
        this.getBase();
    },
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    getBase: function(a) {
        var t = this, n = t.data.fl_id;
        console.log(n), app.util.request({
            url: "entry/wxapp/Hzfl",
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
    }
});