var app = getApp();

Page({
    data: {
        fl_id: "",
        currentTab: 0
    },
    taocan1: function(a) {
        var t = this;
        console.log(a.currentTarget.dataset.id);
        var e = a.currentTarget.dataset.id;
        t.setData({
            fl_id: e,
            currentTab: 0
        }), app.util.request({
            url: "entry/wxapp/Kcfl",
            data: {
                fl_id: e
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
        var e = a.currentTarget.dataset.id;
        t.setData({
            fl_id: e,
            currentTab: a.currentTarget.dataset.index + 1
        }), app.util.request({
            url: "entry/wxapp/Kcfl",
            data: {
                fl_id: e
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
        this.getBase();
        var t = this;
        wx.getStorageSync("openid");
        t.setData({
            currentTab: a.index
        }), app.util.request({
            url: "entry/wxapp/Schoolflarray",
            data: {},
            cachetime: "0",
            success: function(a) {
                console.log(a), t.setData({
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
        var t = this, e = t.data.fl_id;
        console.log(e), app.util.request({
            url: "entry/wxapp/Kcfl",
            data: {},
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
    }
});