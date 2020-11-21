var app = getApp();

Page({
    data: {},
    onLoad: function(n) {},
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    bindinput1: function(n) {
        this.setData({
            length: n.detail.value.length,
            account: n.detail.value
        });
    },
    bindinput2: function(n) {
        this.setData({
            length2: n.detail.value.length,
            pwd: n.detail.value
        });
    },
    goWork: function() {
        var t = this, n = t.data.account, o = t.data.pwd;
        console.log(n), console.log(o), null == n ? wx.showToast({
            title: "帐号不得为空！",
            icon: "none",
            duration: 1e3
        }) : null == o ? wx.showToast({
            title: "密码不得为空！",
            icon: "none",
            duration: 1e3
        }) : app.util.request({
            url: "entry/wxapp/adminLogin",
            data: {
                account: n,
                pwd: o
            },
            success: function(n) {
                wx.setStorageSync("url", n.data), t.setData({
                    url: n.data
                });
            }
        });
    }
});