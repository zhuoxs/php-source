var app = getApp();

Page({
    data: {},
    onLoad: function(n) {
        app.util.request({
            url: "entry/wxapp/lottery",
            showLoading: !0,
            data: {
                op: "getLotteryType",
                id: n.id
            },
            success: function(o) {
                var t = o.data.data;
                console.log(t), 1 == t ? wx.redirectTo({
                    url: "../Sudoku/Sudoku?id=" + n.id
                }) : 2 == t ? wx.redirectTo({
                    url: "../corona/corona?id=" + n.id
                }) : 3 == t ? wx.redirectTo({
                    url: "../slot/slot?id=" + n.id
                }) : 4 == t ? wx.redirectTo({
                    url: "../scratch-off/scratch-off?id=" + n.id
                }) : 5 == t && wx.redirectTo({
                    url: "../puzzle/puzzle?id=" + n.id
                });
            }
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