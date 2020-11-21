var app = getApp();

Page({
    data: {
        i: 0,
        keshi: []
    },
    keshi: function(a) {
        var t = this, o = a.currentTarget.dataset.id;
        app.util.request({
            url: "entry/wxapp/Categoryfl2",
            data: {
                id: o
            },
            success: function(a) {
                console.log(a.data.data), t.setData({
                    categoryfl2: a.data.data
                });
            }
        }), this.setData({
            i: a.currentTarget.dataset.index
        });
    },
    doctor: function(a) {
        var t = a.currentTarget.dataset.id;
        wx.reLaunch({
            url: "/hyb_yl/zhuanjialiebiao/zhuanjialiebiao?id=" + t
        });
    },
    onLoad: function(a) {
        var t = wx.getStorageSync("color"), o = a.title;
        wx.setNavigationBarTitle({
            title: o
        }), wx.setNavigationBarColor({
            frontColor: "#ffffff",
            backgroundColor: t
        });
        var e = this;
        app.util.request({
            url: "entry/wxapp/Categoryf1",
            success: function(a) {
                console.log(a.data.data);
                var t = a.data.data[0].id;
                app.util.request({
                    url: "entry/wxapp/Categoryfl2",
                    data: {
                        id: t
                    },
                    success: function(a) {
                        console.log(a.data.data), e.setData({
                            categoryfl2: a.data.data
                        });
                    }
                }), e.setData({
                    category: a.data.data
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