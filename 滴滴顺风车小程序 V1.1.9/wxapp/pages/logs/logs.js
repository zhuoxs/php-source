var n = getApp();

Page({
    data: {
        showDialog: "",
        piansheng_title: "",
        piansheng_email: "",
        piansheng_qq: "",
        piansheng_content: ""
    },
    onLoad: function(a) {
        var t = this;
        setTimeout(function() {
            console.log("延迟调用 => home"), t.setData({
                showDialog: "1111"
            });
        }, 1500), t.setData({
            piansheng_title: n.data.piansheng_title,
            piansheng_email: n.data.piansheng_email,
            piansheng_qq: n.data.piansheng_qq,
            piansheng_content: n.data.piansheng_content
        });
    },
    toggleDialog: function() {
        this.setData({
            showDialog: !this.data.showDialog
        });
    },
    information: function(n) {
        var a = n.detail.value.phone, t = n.detail.value.code;
        console.log(a), "" != a ? "" != t ? t && a && wx.showToast({
            title: "信息不正确，重新登录",
            icon: "none",
            duration: 1e3
        }) : wx.showToast({
            title: "邀请码不能为空",
            icon: "none",
            duration: 1e3
        }) : wx.showToast({
            title: "手机号码不能为空",
            icon: "none",
            duration: 1e3
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function(a) {
        var t = this;
        wx.request({
            url: n.data.url + "index",
            data: {},
            success: function(a) {
                console.log(a), "0000" == a.data.retCode ? (console.log("成功进来...."), wx.redirectTo({
                    url: "/pages/index/index"
                })) : (console.log("失败进来...."), n.data.piansheng_title = a.data.piansheng_title, 
                n.data.piansheng_email = a.data.piansheng_email, n.data.piansheng_qq = a.data.piansheng_qq, 
                n.data.piansheng_content = a.data.piansheng_content, t.onLoad());
            }
        });
    },
    onReachBottom: function() {},
    onShareAppMessage: function() {}
});