var app = getApp();

Page({
    data: {
        navTile: "预约详情",
        status: 1,
        uname: "墨纸",
        uphone: "1300000",
        utime: "周二 02-12 10:30",
        remark: "这边很多文字的这边很多文字的这边很多文字的这边很多文字的这边很多文字的这边很多文字的这边很多文字的",
        shopaddr: "厦门市集美区"
    },
    onLoad: function(t) {
        var n = this;
        wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("fontcolor"),
            backgroundColor: wx.getStorageSync("color"),
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        }), wx.setNavigationBarTitle({
            title: n.data.navTile
        });
        var o = wx.getStorageSync("settings");
        n.setData({
            settings: o,
            url: wx.getStorageSync("url")
        });
        var a = wx.getStorageSync("openid"), e = t.order_id;
        app.util.request({
            url: "entry/wxapp/getSingleOrder",
            cachetime: "0",
            data: {
                id: e,
                uid: a
            },
            success: function(t) {
                n.setData({
                    order: t.data.data
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
    onShareAppMessage: function() {},
    toMap: function(t) {
        var n = parseFloat(t.currentTarget.dataset.latitude), o = parseFloat(t.currentTarget.dataset.longitude);
        wx.openLocation({
            latitude: n,
            longitude: o,
            scale: 28
        });
    },
    toCancel: function(t) {
        var n = this;
        n.setData({
            wx: wx.showModal({
                title: "提示",
                content: "确定取消本次预约吗",
                success: function(t) {
                    t.confirm && n.setData({
                        status: 0
                    });
                }
            })
        });
    },
    toBook: function(t) {
        wx.navigateTo({
            url: "../../index/book/book",
            success: function(t) {},
            fail: function(t) {},
            complete: function(t) {}
        });
    }
});