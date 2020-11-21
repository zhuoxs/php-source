var app = getApp();

Page({
    data: {
        pageWrapCount: [],
        answerArr: []
    },
    onLoad: function(a) {
        var n = this, t = a.zid;
        n.setData({
            zid: t
        }), app.util.request({
            url: "entry/wxapp/Selectallque",
            data: {
                zid: t
            },
            success: function(a) {
                console.log(a), app.globalData.answer = a.data.data, n.setData({
                    pageWrapCount: n.data.pageWrapCount.concat([ 1 ])
                });
            }
        });
    },
    answerDetailClick: function(a) {
        console.log(a);
        var n = a.detail.id, t = this.data.zid;
        wx.navigateTo({
            url: "/hyb_yl/answer_detail/answer_detail?user_openid=" + n + "&p_id=" + t
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {}
});