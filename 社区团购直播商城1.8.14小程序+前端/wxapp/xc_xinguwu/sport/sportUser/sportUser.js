var app = getApp();

function isToday(t) {
    var a = new app.util.date();
    return a.dateToStr("yyyy-MM-DD", a.longToDate(1e3 * t)) == a.dateToStr("yyyy-MM-DD");
}

Page({
    data: {},
    onLoad: function(t) {
        var a = wx.getStorageSync("weRunData");
        a && isToday(a.timestamp) ? this.setData({
            step: a.step
        }) : this.setData({
            step: 0
        });
    },
    onReady: function() {
        app.look.sport_footer(this);
        var t = {};
        t.sport_icon = app.module_url + "resource/wxapp/sport/sport-icon.png", this.setData({
            images: t,
            avatarutl: app.globalData.userInfo.avatarurl,
            nickname: app.globalData.userInfo.nickname,
            userid: app.globalData.userInfo.id,
            totalstep: app.globalData.userInfo.totalstep
        });
    },
    onShow: function() {
        var a = this;
        app.util.request({
            url: "entry/wxapp/sport",
            showLoading: !1,
            method: "POST",
            data: {
                op: "getUserCoin"
            },
            success: function(t) {
                a.setData({
                    coin: t.data.data
                });
            }
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {
        var t = "", a = "";
        null != app.sportSet && (app.look.istrue(app.sportSet.share_title) && (t = app.sportSet.share_title), 
        app.look.istrue(app.sportSet.share_img) && (a = app.sportSet.share_img));
        var o = "/xc_xinguwu/sport/sport/sport?userid=" + app.globalData.userInfo.id + "&type=sport";
        return {
            title: t,
            path: "/xc_xinguwu/pages/base/base?share=" + (o = encodeURIComponent(o)),
            imageUrl: a,
            success: function(t) {
                that.hideshare(), wx.showToast({
                    title: "转发成功"
                });
            },
            fail: function(t) {}
        };
    }
});