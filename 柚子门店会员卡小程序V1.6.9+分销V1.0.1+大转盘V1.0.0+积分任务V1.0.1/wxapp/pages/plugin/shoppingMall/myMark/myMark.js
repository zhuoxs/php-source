var app = getApp();

Page({
    data: {
        page: 1,
        pagesize: 10,
        list: []
    },
    onLoad: function(a) {
        var t = this;
        app.get_openid().then(function(a) {
            console.log(a), t.setData({
                openid: a
            }), t.getMake();
        });
    },
    jumpArticle: function(a) {
        var t = a.currentTarget.dataset.url;
        wx.navigateTo({
            url: "../publicNumber/publicNumber?url=" + t
        });
    },
    onReachBottom: function() {
        this.data.hasMore ? this.getMake() : wx.showToast({
            title: "没有更多活动了~",
            icon: "none"
        });
    },
    onPullDownRefresh: function() {
        wx.stopPullDownRefresh();
    },
    getMake: function() {
        var o = this, n = o.data.page, s = o.data.list, a = (wx.getStorageSync("user"), 
        o.data.openid);
        console.log(a), app.util.request({
            url: "entry/wxapp/getMyReadRecord",
            data: {
                m: app.globalData.Plugin_scoretask,
                openid: a,
                page: o.data.page,
                pagesize: o.data.pagesize
            },
            showLoading: !1,
            success: function(a) {
                console.log(a.data);
                var t = a.data.data.length == o.data.pagesize;
                if (1 == n) s = a.data.data; else for (var e in a.data.data) s.push(a.data.data[e]);
                console.log("页数"), n += 1, console.log(n), o.setData({
                    imgroot: a.data.other.img_root,
                    markList: s,
                    page: n,
                    hasMore: t
                });
            }
        });
    },
    lower: function(a) {
        this.data.hasMore ? this.getMake() : wx.showToast({
            title: "没有更多活动了~",
            icon: "none"
        });
    }
});