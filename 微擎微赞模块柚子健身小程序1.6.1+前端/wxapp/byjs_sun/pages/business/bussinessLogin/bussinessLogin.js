var app = getApp();

Page({
    data: {
        user: "",
        pow: ""
    },
    onLoad: function(t) {
        var a = this;
        app.util.request({
            url: "entry/wxapp/url",
            cachetime: "0",
            success: function(t) {
                wx.setStorageSync("url", t.data), a.setData({
                    url: t.data
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
    user: function(t) {
        this.setData({
            user: t.detail.value
        });
    },
    pow: function(t) {
        this.setData({
            pow: t.detail.value
        });
    },
    goLogin: function() {
        return "" === this.data.user ? (wx.showToast({
            title: "用户名不能为空",
            icon: "error",
            duration: 2e3
        }), !1) : "" === this.data.pow ? (wx.showToast({
            title: "密码不能为空",
            icon: "error",
            duration: 2e3
        }), !1) : void app.util.request({
            url: "entry/wxapp/CoachLogin",
            data: {
                account: this.data.user,
                password: this.data.pow
            },
            cachetime: 0,
            success: function(t) {
                3 == t.data.num ? wx.showModal({
                    title: "提示！！",
                    content: "登录失败，密码或账号错误，请重新输入"
                }) : 1 == t.data.num ? (console.log(t), wx.navigateTo({
                    url: "../../../../byjs_sun/pages/business/coachone/coachone?id=" + t.data.res.id
                })) : 2 == t.data.num && wx.showModal({
                    title: "提示！！",
                    content: "帐号未通过审核，请联系平台"
                });
            }
        });
    }
});