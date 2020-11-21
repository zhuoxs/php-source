var app = getApp();

Page({
    data: {},
    onLoad: function(n) {
        var a = this;
        console.log(n), app.util.request({
            url: "entry/wxapp/LoginLawyer",
            cachetime: "0",
            data: {
                id: n.id
            },
            success: function(n) {
                console.log(n.data), a.setData({
                    lawyer: n.data
                });
            }
        });
    },
    answerTap: function(n) {
        console.log(n);
        var a = n.currentTarget.dataset.fid;
        wx.navigateTo({
            url: "../details/details?fid=" + a
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