var app = getApp();

Page({
    selStatus: function(t) {
        console.log(t);
        this.setData({
            currentStatus: t.currentTarget.dataset.index
        }), this.getorder();
    },
    data: {
        currentStatus: 0
    },
    getorder: function() {
        var e = this, t = wx.getStorageSync("openid"), o = e.data.currentStatus;
        app.util.request({
            url: "entry/wxapp/GetOrdered",
            cachetime: "0",
            data: {
                openid: t,
                currentStatus: o
            },
            success: function(t) {
                console.log(t), e.setData({
                    allOrders: t.data.data
                });
            }
        });
    },
    onLoad: function(t) {
        var e = this, o = wx.getStorageSync("openid");
        console.log(o), wx.getStorage({
            key: "url",
            success: function(t) {
                e.setData({
                    url: t.data,
                    openid: o
                });
            }
        }), e.getorder(), e.diyWinColor();
    },
    goOrderAfter: function(t) {
        console.log(t);
        wx.navigateTo({
            url: "../orderAfter/orderAfter?orderID=" + t.currentTarget.dataset.id + "&store_id=" + t.currentTarget.dataset.store_id + "&boss=1&boss_id=" + this.data.openid
        });
    },
    onReady: function() {},
    onShow: function() {},
    diyWinColor: function(t) {
        var e = wx.getStorageSync("system");
        wx.setNavigationBarColor({
            frontColor: e.color,
            backgroundColor: e.fontcolor,
            animation: {
                duration: 400,
                timingFunc: "easeIn"
            }
        }), wx.setNavigationBarTitle({
            title: "订单中心"
        });
    }
});