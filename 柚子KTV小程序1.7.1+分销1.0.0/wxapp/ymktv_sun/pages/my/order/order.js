var app = getApp();

Page({
    data: {
        currentTab: 0
    },
    onLoad: function(t) {
        var r = this;
        app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "0",
            success: function(t) {
                wx.setStorageSync("url", t.data), r.setData({
                    url: t.data
                });
            }
        });
    },
    onShow: function() {
        var r = this;
        app.util.request({
            url: "entry/wxapp/BuildAllOrder",
            cachetime: "0",
            success: function(t) {
                console.log(t.data), r.setData({
                    orderno: t.data.arr1,
                    orderyes: t.data.arr2
                });
            }
        });
    },
    bindChange: function(t) {
        console.log(t);
        this.setData({
            currentTab: t.detail.current
        });
    },
    swichNav: function(t) {
        if (this.data.currentTab === t.target.dataset.index) return !1;
        this.setData({
            currentTab: t.target.dataset.index
        });
    },
    goMyhistory: function() {
        wx.redirectTo({
            url: "../order/order"
        });
    },
    goSet: function() {
        wx.redirectTo({
            url: "../set/set"
        });
    },
    goWork: function() {
        wx.redirectTo({
            url: "../work/work"
        });
    }
});