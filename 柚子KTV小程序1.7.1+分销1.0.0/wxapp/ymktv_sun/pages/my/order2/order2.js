var app = getApp();

Page({
    data: {
        currentTab: 0
    },
    onLoad: function(a) {
        var e = this, t = a.bid;
        wx.setStorageSync("bid", t), console.log(t), app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "0",
            success: function(t) {
                wx.setStorageSync("url", t.data), e.setData({
                    url: t.data,
                    b_name: a.b_name
                });
            }
        });
    },
    onShow: function() {
        var a = this, t = wx.getStorageSync("bid");
        app.util.request({
            url: "entry/wxapp/BuildOrder",
            cachetime: "0",
            data: {
                bid: t
            },
            success: function(t) {
                console.log(t.data), a.setData({
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
            url: "../order2/order2"
        });
    },
    goSet: function() {
        wx.redirectTo({
            url: "../set2/set2?b_name=" + this.data.b_name
        });
    },
    goWork: function() {
        var t = wx.getStorageSync("bid");
        wx.redirectTo({
            url: "../work2/work2?bid=" + t + "&b_name=" + this.data.b_name
        });
    }
});