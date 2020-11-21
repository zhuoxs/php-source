var app = getApp();

Page({
    data: {},
    onLoad: function(o) {
        wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("fontcolor"),
            backgroundColor: wx.getStorageSync("color"),
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        });
        var n = wx.getStorageSync("system");
        this.setData({
            tel: n.tel
        });
    },
    bindSave: function(o) {
        console.log(o.detail.value);
        this.data.region;
        var n = o.detail.value;
        if ("" != n.account) if ("" != n.password) {
            var e = wx.getStorageSync("openid"), t = n.account, a = n.password;
            app.util.request({
                url: "entry/wxapp/StoreLoginIn",
                cachetime: "30",
                data: {
                    openid: e,
                    user_name: t,
                    password: a
                },
                success: function(o) {
                    if (console.log(o), !o.data) return wx.showModal({
                        title: "提示",
                        content: "用户名或密码错误，请重新输入",
                        showCancel: !1
                    }), !1;
                    o.data && (console.log(o.data.user_id), wx.navigateTo({
                        url: "../manager/center/center?userid=" + o.data.user_id
                    }));
                }
            });
        } else wx.showModal({
            title: "提示",
            content: "请输入密码！",
            showCancel: !1
        }); else wx.showModal({
            title: "提示",
            content: "请输入账号！",
            showCancel: !1
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