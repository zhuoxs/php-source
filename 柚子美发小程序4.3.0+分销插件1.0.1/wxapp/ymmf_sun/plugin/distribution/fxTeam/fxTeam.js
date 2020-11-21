var app = getApp();

Page({
    data: {
        curIndex: 0,
        nav: [ "一级", "二级" ],
        commissiontype: [ "", "%", "元" ],
        page: [ 1, 1 ],
        member: [],
        distribution_set: []
    },
    onLoad: function(t) {
        var a = app.getSiteUrl();
        this.setData({
            url: a
        });
        var e = wx.getStorageSync("System");
        wx.setNavigationBarColor({
            frontColor: e.fontcolor ? e.fontcolor : "#000000",
            backgroundColor: e.color ? e.color : "#ffffff",
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        });
    },
    onReady: function() {
        var e = this;
        app.util.request({
            url: "entry/wxapp/Plugin",
            data: {
                type: 1
            },
            showLoading: !1,
            success: function(t) {
                var a = t.data;
                2 != a && e.setData({
                    distribution_set: a
                });
            }
        });
        var t = wx.getStorageSync("users");
        app.util.request({
            url: "entry/wxapp/GetFirstLevel",
            data: {
                uid: t.id,
                level: 0,
                m: app.globalData.Plugin_distribution
            },
            success: function(t) {
                console.log(t.data), 2 != t.data ? e.setData({
                    member: t.data
                }) : e.setData({
                    member: []
                });
            }
        });
    },
    onShow: function() {},
    onPullDownRefresh: function() {},
    onShareAppMessage: function() {},
    bargainTap: function(t) {
        var a = parseInt(t.currentTarget.dataset.index), e = this, n = wx.getStorageSync("users");
        app.util.request({
            url: "entry/wxapp/GetFirstLevel",
            data: {
                uid: n.id,
                level: a,
                m: app.globalData.Plugin_distribution
            },
            success: function(t) {
                console.log(t.data), 2 != t.data ? e.setData({
                    member: t.data,
                    curIndex: a
                }) : e.setData({
                    member: [],
                    curIndex: a
                });
            }
        });
    }
});