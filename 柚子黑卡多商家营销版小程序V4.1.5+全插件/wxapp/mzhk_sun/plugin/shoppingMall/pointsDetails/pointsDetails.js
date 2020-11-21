/*   time:2019-08-09 13:18:39*/
var app = getApp();
Page({
    data: {
        page: 1,
        pagesize: 9,
        is_modal_Hidden: !0,
        list: []
    },
    onLoad: function(t) {
        app.wxauthSetting(), this.getIntegration()
    },
    onShow: function() {
        app.func.islogin(app, this)
    },
    onReachBottom: function() {
        this.data.hasMore ? this.getIntegration() : wx.showToast({
            title: "没有更多活动了~",
            icon: "none"
        })
    },
    getIntegration: function() {
        var n = this,
            t = wx.getStorageSync("users").openid,
            o = n.data.page,
            i = n.data.list;
        app.util.request({
            url: "entry/wxapp/getMyTaskRecord",
            data: {
                m: app.globalData.Plugin_scoretask,
                openid: t,
                page: o,
                pagesize: n.data.pagesize
            },
            showLoading: !1,
            success: function(t) {
                console.log(t);
                var a = t.data.length == n.data.pagesize;
                if (1 == o) i = t.data;
                else for (var e in t.data) i.push(t.data[e]);
                o += 1, n.setData({
                    pointsDetails: i,
                    hasMore: a,
                    page: o
                })
            }
        })
    },
    lower: function() {
        this.data.hasMore ? this.getIntegration() : wx.showToast({
            title: "没有更多活动了~",
            icon: "none"
        })
    },
    onPullDownRefresh: function() {
        wx.stopPullDownRefresh()
    },
    updateUserInfo: function(t) {
        app.wxauthSetting()
    }
});