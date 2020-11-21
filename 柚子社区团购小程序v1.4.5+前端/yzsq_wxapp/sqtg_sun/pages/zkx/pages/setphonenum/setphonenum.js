var app = getApp();

Page({
    data: {},
    onLoad: function(a) {
        var t = wx.getStorageSync("open_id"), e = a.id;
        this.setData({
            open_id: t,
            whichUrl: e
        });
    },
    formSubmit: function(a) {
        var t = a.detail.value.mobile;
        this.data.whichUrl;
        /^1(3|4|5|7|8|9)\d{9}$/.test(t) ? app.ajax({
            url: "Cuser|login",
            data: {
                openid: this.data.open_id,
                tel: t
            },
            success: function(a) {
                a.code ? app.tips(a.msg) : (wx.setStorageSync("userInfo", a.data), wx.navigateBack({
                    delta: 1
                }));
            }
        }) : app.tips("请输入正确的手机号码");
    }
});