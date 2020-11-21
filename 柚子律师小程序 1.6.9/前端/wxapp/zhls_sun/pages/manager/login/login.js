var app = getApp();

Page({
    data: {},
    onLoad: function(n) {},
    bindSave: function(n) {
        this.data.region;
        var o = n.detail.value;
        "" != o.account ? "" != o.password ? app.util.request({
            url: "entry/wxapp/LoginShop",
            cachetime: "0",
            data: {
                account: o.account,
                password: o.password
            },
            success: function(n) {
                console.log(n.data);
                var o = n.data.id;
                2 != n.data.erron ? 3 != n.data.erron ? 1 == n.data.erron && wx.showModal({
                    title: "提示",
                    content: "登录成功",
                    showCancel: !1,
                    success: function(n) {
                        wx.navigateTo({
                            url: "../center/center?id=" + o
                        });
                    }
                }) : wx.showModal({
                    title: "提示",
                    content: "密码错误！",
                    showCancel: !1
                }) : wx.showModal({
                    title: "提示",
                    content: "账号错误！",
                    showCancel: !1
                });
            }
        }) : wx.showModal({
            title: "提示",
            content: "请输入密码！",
            showCancel: !1
        }) : wx.showModal({
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