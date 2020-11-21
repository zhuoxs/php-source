var app = getApp();

Page({
    data: {
        page: 1,
        pagesize: 9,
        list: []
    },
    onLoad: function(t) {
        this.getIntegration();
    },
    onReachBottom: function() {
        this.data.hasMore ? this.getIntegration() : wx.showToast({
            title: "没有更多活动了~",
            icon: "none"
        });
    },
    getIntegration: function() {
        var o = this, t = wx.getStorageSync("user").openid, n = o.data.page, s = o.data.list;
        app.util.request({
            url: "entry/wxapp/getMyTaskRecord",
            data: {
                m: app.globalData.Plugin_scoretask,
                openid: t,
                page: n,
                pagesize: o.data.pagesize
            },
            showLoading: !1,
            success: function(t) {
                console.log(t);
                var a = t.data.length == o.data.pagesize;
                if (1 == n) s = t.data; else for (var e in t.data) s.push(t.data[e]);
                n += 1, o.setData({
                    pointsDetails: s,
                    hasMore: a,
                    page: n
                });
            }
        });
    },
    lower: function() {
        this.data.hasMore ? this.getIntegration() : wx.showToast({
            title: "没有更多活动了~",
            icon: "none"
        });
    },
    onPullDownRefresh: function() {
        wx.stopPullDownRefresh();
    }
});