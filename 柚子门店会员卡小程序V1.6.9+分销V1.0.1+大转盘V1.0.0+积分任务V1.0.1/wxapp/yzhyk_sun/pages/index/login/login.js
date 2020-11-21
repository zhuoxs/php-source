Page({
    data: {
        navTile: "登录",
        tip1: "柚子生活",
        tip2: "健康每一天",
        isWx: !0,
        phoneNum: ""
    },
    onLoad: function(n) {
        wx.setNavigationBarTitle({
            title: this.data.navTile
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    toOther: function(n) {
        this.setData({
            isWx: !this.data.isWx
        });
    },
    receCode: function(n) {},
    delPhone: function(n) {
        this.setData({
            phoneNum: ""
        });
    },
    formSubmit: function(n) {
        var t = n.detail.value.phone, o = n.detail.value.code, e = "", i = !0;
        console.log(t, o), /^1(3|4|5|7|8)\d{9}$/.test(uphone) ? "" == o ? e = "请输入手机验证码" : i = !1 : e = "请输入手机号", 
        1 == i && wx.showModal({
            title: "提示",
            content: e,
            showCancel: !1
        });
    },
    wxLogin: function(n) {}
});