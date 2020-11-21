var app = getApp();

Page({
    data: {
        isIpx: app.globalData.isIpx,
        name: "托尼",
        work: "首席发型师",
        workyear: "7",
        ordernum: "99",
        comment: "100%",
        serice: []
    },
    onLoad: function(t) {
        wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("fontcolor"),
            backgroundColor: wx.getStorageSync("color"),
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        });
        var a = t.id;
        wx.setStorageSync("id", a), this.urls();
    },
    urls: function() {
        var a = this;
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
                wx.setStorageSync("url", t.data), a.setData({
                    url: t.data
                });
            }
        });
    },
    onReady: function() {},
    onShow: function() {
        var o = this, t = wx.getStorageSync("id");
        app.util.request({
            url: "entry/wxapp/HairDetails",
            cachetime: "30",
            data: {
                id: t
            },
            success: function(t) {
                for (var a = [], e = 0; e < t.data.data.star; e++) a[e] = 1;
                console.log(t.data.data), o.setData({
                    hairer: t.data.data,
                    star: a
                });
            }
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    previewImg: function(t) {
        console.log(this.data);
        var a = t.currentTarget.dataset.index, e = this.data.hairer.gallery[a].imgs;
        console.log(e), wx.previewImage({
            current: e[0],
            urls: e,
            success: function(t) {},
            fail: function(t) {},
            complete: function(t) {}
        });
    },
    toOrder: function(t) {
        console.log(t), wx.navigateTo({
            url: "../order/order?id=" + t.currentTarget.dataset.id
        });
    }
});