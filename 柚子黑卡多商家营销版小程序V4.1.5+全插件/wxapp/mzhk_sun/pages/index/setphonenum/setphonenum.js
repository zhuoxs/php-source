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
    onShareAppMessage: function() {},
    formSubmit: function(n) {
        var e = wx.getStorageSync("users"), o = n.detail.value.mobile;
        /^1(3|4|5|7|8|9)\d{9}$/.test(o) ? app.util.request({
            url: "entry/wxapp/UpdateUser",
            cachetime: "0",
            data: {
                id: e.id,
                tel: o
            },
            success: function(n) {
                console.log(n), n && wx.setStorageSync("users", n.data), wx.reLaunch({
                    url: "/mzhk_sun/pages/index/index"
                });
            }
        }) : wx.showToast({
            title: "请输入正确的手机号码",
            icon: "none",
            duration: 1500
        });
    }
});