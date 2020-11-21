var app = getApp();

Page({
    data: {
        navTile: "预约服务",
        curIndex: 0,
        orderpro: [],
        ordersuc: []
    },
    onLoad: function(t) {
        this.getUrl();
        var o = t.cid;
        wx.setStorageSync("cid", o), wx.setNavigationBarTitle({
            title: t.cname
        }), wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("fontcolor"),
            backgroundColor: wx.getStorageSync("color"),
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        });
    },
    onReady: function() {},
    onShow: function() {
        var o = this, t = wx.getStorageSync("cid");
        console.log(t), app.util.request({
            url: "entry/wxapp/Xzcate",
            cachetime: "0",
            data: {
                cid: t
            },
            success: function(t) {
                o.setData({
                    cateData: t.data
                });
            }
        });
    },
    getUrl: function() {
        var o = this;
        app.util.request({
            url: "entry/wxapp/url",
            cachetime: "0",
            success: function(t) {
                wx.setStorageSync("url", t.data), o.setData({
                    url: t.data
                });
            }
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    toOrder: function(t) {
        wx.navigateTo({
            url: "../order/order"
        });
    }
});