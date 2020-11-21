var app = getApp();

function getViewWidth(a) {
    wx.createSelectorQuery().select("#progress-value").boundingClientRect(function(t) {
        console.log(t), a.setData({
            progressRight: 750 / app.systeminfo.screenWidth * t.width / 2
        });
    }).exec();
}

Page({
    data: {
        navIndex: 0
    },
    changeNavIdnex: function(t) {
        this.setData({
            navIndex: t.currentTarget.dataset.index
        });
    },
    onLoad: function(t) {
        var e = this;
        this.setData({
            avatarurl: app.globalData.userInfo.avatarurl
        }), app.util.request({
            url: "entry/wxapp/my",
            showLoading: !1,
            method: "POST",
            data: {
                op: "member"
            },
            success: function(t) {
                var a = t.data;
                a.data.list && (e.setData({
                    list: a.data.list,
                    vipIndex: a.data.vipIndex,
                    exp: a.data.exp
                }), getViewWidth(e)), a.data.pageset && e.setData({
                    pageset: a.data.pageset
                });
            }
        });
    },
    onReady: function() {
        app.look.goHome(this);
    },
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {}
});