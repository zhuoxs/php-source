var app = getApp();

Page({
    data: {
        address: []
    },
    onLoad: function(n) {},
    onShow: function() {
        var o = this, n = wx.getStorageSync("gid");
        app.util.request({
            url: "entry/wxapp/GetAddress",
            data: {
                gid: n
            },
            success: function(n) {
                console.log(n), o.setData({
                    resNo: n.data.resNo,
                    resYes: n.data.resYes
                });
            }
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {}
});